<?php

/**
 * Skynet/Core/SkynetResponder.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Core;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\EventListener\SkynetEventListenersFactory;
use Skynet\EventLogger\SkynetEventLoggersFactory;
use Skynet\Secure\SkynetAuth;
use Skynet\Secure\SkynetVerifier;
use Skynet\Core\SkynetChain;
use Skynet\Data\SkynetRequest;
use Skynet\Data\SkynetResponse;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;
use Skynet\Database\SkynetOptions;
use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Cluster\SkynetCluster;
use Skynet\SkynetVersion;
use Skynet\EventListener\SkynetEventListenersLauncher;
use Skynet\Debug\SkynetDebug;

 /**
  * Skynet ResponderService Main Launcher
  *
  * Main launcher for Skynet Cluster.
  * This is the main core of Skynet Responder and it responds for data sending from Skynet Core.
  * By creating instance of SkynetResponder class, e.g. $skynetCluster = new SkynetResponder(); you will start responder. From that, Skynet Cluster will be listening for incoming connections.
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetResponder
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var SkynetResponse Assigned response */
  private $response;

  /** @var SkynetRequest Assigned request  */
  private $request;

  /** @var string Actual requestURI */
  private $requestURI;

  /** @var string Status of data */
  private $raw;

  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;

  /** @var SkynetEventListenerInterface Array of Event Listeners*/
  private $eventListeners = [];

  /** @var SkynetEventListenerInterface Array of Event Loggers */
  private $eventLoggers = [];

  /** @var bool Status of cluster conenction*/
  private $isConnected = false;

  /** @var bool Status of database connection*/
  private $isDbConnected = false;

  /** @var bool Status of response */
  private $isResponse = false;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetOptions Options getter/setter */
  private $options;
  
  /** @var SkynetEventListenersLauncher Listeners Launcher */
  private $eventListenersLauncher;  

 /**
  * Constructor
  *
  * @param bool $start Autostarts Skynet
  *
  * @return SkynetCluster $this Instance of $this
  */
  public function __construct($start = false)
  {
    if(isset($_SERVER['REQUEST_URI']))
    {
      $this->requestURI = $_SERVER['REQUEST_URI'];
    }
    $this->assignRequest();
    $this->assignResponse();
    $this->verifier = new SkynetVerifier();    
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();
    $this->options = new SkynetOptions();   

    $this->eventListenersLauncher = new SkynetEventListenersLauncher();
    $this->eventListenersLauncher->setSender(false);
    $this->eventListenersLauncher->assignConnectId(1);
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);    
    
    if($start)
    {
      $response = $this->launch();
      if(!empty($response))
      {
        header('Content-type:application/json;charset=utf-8');
        echo $response;
      }
    }
    return $this;
  }

 /**
  * Sets raw
  *
  * @param string $mode
  */
  public function setRaw($mode)
  {
    $this->raw = $mode;
  }

 /**
  * Assigns $response object to Skynet Cluster, default: NULL
  *
  * @param SkynetResponse|null $response
  */
  private function assignResponse(SkynetResponse $response = null)
  {
    ($response !== null) ? $this->response = $response : $this->response = new SkynetResponse();
    if($this->response !== null)
    {
      $this->addState(SkynetTypes::STATUS_OK, SkynetTypes::A_RESPONSE_OK);
    }
  }

 /**
  * Assigns $request object to Skynet Cluster, default: NULL
  *
  * @param SkynetRequest|null $request
  */
  private function assignRequest(SkynetRequest $request = null)
  {
    ($request !== null) ? $this->request = $request : $this->request = new SkynetRequest();
    if($this->request !== null)
    {
      $this->addState(SkynetTypes::STATUS_OK, SkynetTypes::A_REQUEST_OK);
      $this->request->loadRequest();
      $this->request->prepareRequests();
    }
  }

 /**
  * Returns request object
  *
  * @return SkynetRequest Object with request data and request manipulation methods
  */
  public function getRequest()
  {
    return $this->request;
  }

 /**
  * Returns response object
  *
  * @return SkynetResponse Object with response data and response generation/manipulation methods
  */
  public function getResponse()
  {
    return $this->response;
  }

 /**
  * Launchs Skynet Cluster Listener
  *
  * This is the main controller of cluster. It it listening for incoming connections and works on them.
  * Cluster generates responses for incoming requests by returning JSON encoded response.
  *
  * @return string JSON encoded response
  */
  public function launch()
  {    
    if($this->verifier->isUpdateRequest() || !$this->verifier->hasIpAccess() || !$this->verifier->isRequestKeyVerified() || !$this->verifier->verifyChecksum())
    {
      return false;
    }
   
    $this->request->loadRequest();
    $this->request->prepareRequests();

    $this->prepareListeners();
    $this->eventListenersLauncher->launch('onRequest');
    $this->eventListenersLauncher->launch('onRequestLoggers');
    
    if($this->isSleeped())
    {
      return false;
    }

    $cluster = new SkynetCluster();
    $cluster->fromRequest($this->request);
    $this->clustersRegistry->add($cluster);

    $this->response->assignRequest($this->request);
    $this->prepareListeners();
    $this->eventListenersLauncher->launch('onResponse');    
   
    if(!$this->isEcho() || ($this->isEcho() && $this->isBroadcast()))
    {
      $response = $this->response->generateResponse();
      $this->prepareListeners();
      $this->eventListenersLauncher->launch('onResponseLoggers');
      return $response;
    }
  }

 /**
  * Assigns data to listeners
  */ 
  private function prepareListeners()
  {
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);
    $this->eventListenersLauncher->assignConnectId(1);
  }  
  
 /**
  * Returns true if is sleeped
  *
  * @return bool True if sleep
  */
  private function isSleeped()
  {
    if($this->options->getOptionsValue('sleep') == 1)
    {
      return true;
    }
  }
  
 /**
  * Returns true if is echo equest
  *
  * @return bool True if echo
  */
  private function isEcho()
  {
    if(isset($_REQUEST['@echo']))
    {
      return true;
    }
  }
  
 /**
  * Returns true if is broadcast equest
  *
  * @return bool True if broadcast
  */
  private function isBroadcast()
  {
    if(isset($_REQUEST['@broadcast']))
    {
      return true;
    }
  }
  
 /**
  * __toString
  *
  * @return string Version data
  */
  public function __toString()
  {
    return 'SKYNET CLUSTER v.'.SkynetVersion::VERSION;
  }
}