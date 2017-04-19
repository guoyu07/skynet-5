<?php

/**
 * Skynet/Core/SkynetResponder.php
 *
 * @package Skynet
 * @version 1.0.0
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

 /**
  * Skynet ResponderService Main Launcher
  *
  * Main launcher for Skynet Cluster.
  * This is the main core of Skynet Cluster and it responds for data sending from Skynet Core.
  * By creating instance of SkynetCluster class, e.g. $skynetCluster = new SkynetCluster(); you will start SkynetCluster. From that, Skynet Cluster will be listening for incoming connections.
  * With __toString() (e.g. echo $skynetCluster; ) skynet will show debug data with informations about connections, states, errors, requests, responses, configuration and more.
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
  

 /**
  * Constructor
  *
  * @param bool $start Autostarts Skynet
  *
  * @return SkynetCluster $this Instance of $this
  */
  public function __construct($start = false)
  {
    $this->assignRequest();
    $this->assignResponse();
    $this->verifier = new SkynetVerifier();
    if(isset($_SERVER['REQUEST_URI']))
    {
      $this->requestURI = $_SERVER['REQUEST_URI'];
    }
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();
    $this->options = new SkynetOptions();    
    
    if($start)
    {
      echo $this->launch();
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
  * Launch Event Listeners
  *
  * Method execute all registered in Factory event listeners. Every listener have access to request and response and can manipulate them.
  * You can create and register your own listeners by added them to registry in {SkynetEventListenersFactory}.
  * Every event listener must implements {SkynetEventListenerInterface} interface and extends {SkynetEventListenerAbstract} class.
  * OnEventName() method gets context param {beforeSend|afterReceive} (you can depends actions from that).
  * Inside event listener you have access to $request and $response objects. See API documentation for more info.
  *
  * @param string $event Event name
  */
  private function launchEventListeners($event)
  {
    switch($event)
    {
      /* Launch before sending response */
      case 'onResponse':
        foreach($this->eventListeners as $listener)
        {
          $listener->setConnId(1);
          $listener->setSender(false);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) 
            && isset($requests['_skynet_sender_url']) 
            && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            $listener->onResponse('beforeSend');
            if(isset($requests['@echo'])) 
            {
              $listener->onEcho('beforeSend');
            }
            if(isset($requests['@broadcast'])) 
            {
              $listener->onBroadcast('beforeSend');
            }
          }
        }
      break;

      /* Launch after receives request */
      case 'onRequest':
        foreach($this->eventListeners as $listener)
        {
          $listener->setConnId(1);
          $listener->setSender(false);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) 
            && isset($requests['_skynet_sender_url']) 
            && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            $listener->onRequest('afterReceive');
          }
        }
      break;

      /* Launch after response listeners */
      case 'onResponseLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->setConnId(1);
          $listener->setSender(false);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) 
            && isset($requests['_skynet_sender_url']) 
            && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            $listener->onResponse('beforeSend');
            if(isset($requests['@echo'])) 
            {
              $listener->onEcho('beforeSend');
            }
            if(isset($requests['@broadcast'])) 
            {
              $listener->onBroadcast('beforeSend');
            }
          }
        }
      break;

      /* Launch after request listeners */
      case 'onRequestLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->setConnId(1);
          $listener->setSender(false);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) 
            && isset($requests['_skynet_sender_url']) 
            && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            $listener->onRequest('afterReceive');
          }
        }
      break;
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
  * Launch Skynet Cluster Listener
  *
  * This is the main controller of cluster. It it listening for incoming connections and works on them.
  * Cluster generates responses for incoming requests by returning JSON encoded response.
  *
  * @return string JSON encoded response
  */
  public function launch()
  {
    if(!$this->verifier->isRequestKeyVerified() || !$this->verifier->verifyChecksum())
    {
      return false;
    }
    
    $this->request->loadRequest();
    $this->request->prepareRequests();

    $this->launchEventListeners('onRequest');
    $this->launchEventListeners('onRequestLoggers');
    
    if($this->options->getOptionsValue('sleep') == 1)
    {
      return false;
    }

    $cluster = new SkynetCluster();
    $cluster->fromRequest($this->request);
    $this->clustersRegistry->add($cluster);

    $this->response->assignRequest($this->request);
    $this->launchEventListeners('onResponse');
    if(!isset($_REQUEST['@echo']) || (isset($_REQUEST['@echo']) && isset($_REQUEST['@broadcast'])))
    {
      $response = $this->response->generateResponse();
      $this->launchEventListeners('onResponseLoggers');      
      return $response;
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