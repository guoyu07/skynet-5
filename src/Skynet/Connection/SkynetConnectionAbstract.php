<?php

/**
 * Skynet/Connection/SkynetConnectionAbstract.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Connection;

use Skynet\EventListener\SkynetEventListenersFactory;
use Skynet\Secure\SkynetVerifier;
use Skynet\Encryptor\SkynetEncryptorsFactory;
use Skynet\Common\SkynetHelper;
use Skynet\Cluster\SkynetCluster;
use Skynet\SkynetVersion;
use Skynet\Data\SkynetRequest;
use Skynet\Data\SkynetResponse;

 /**
  * Skynet Connection Base
  *
  * Sets base method for extending connectors classes
  */
abstract class SkynetConnectionAbstract
{
  /** @var SkynetEventListenerInterface Array of Event Listeners */
  protected $eventListeners = [];

  /** @var string Actually used URL */
  protected $url;

  /** @var integer State Number/ID, actual No of connection */
  protected $state;

  /** @var string Received raw data */
  protected $data;

  /** @var string Parsed conenction params */
  protected $params;

  /** @var SkynetRequest Assigned request */
  protected $request;

  /** @var string[] Array od indexed requests */
  protected $requests = [];

  /** @var SkynetEncryptorInterface Encryptor instance */
  protected $encryptor;

  /** @var SkynetVerifier instance */
  protected $verifier;

  /** @var SkynetCluster Actual cluster */
  protected $cluster;
  
  /** @var string Checksum */
  protected $checksum;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $this->verifier = new SkynetVerifier();
  }

 /**
  * Launcher Event Listeners
  */
  protected function launchConnectListeners()
  {
    foreach($this->eventListeners as $listener)
    {
      $listener->onConnect($this);
    }
  }

 /**
  * Assigns $request object
  *
  * @param SkynetRequest $request
  */
  public function assignRequest(SkynetRequest $request)
  {
    $this->request = $request;   
    $this->setRequests($request->prepareRequests(false));
    $this->requests['_skynet_checksum'] = $this->verifier->generateChecksum($this->requests);
  }

 /**
  * Sets requests array
  *
  * @param string[] $requests Array of requests
  */
  public function setRequests($requests)
  {
    $this->requests = $requests;
  }

 /**
  * Sets cluster object
  *
  * @param SkynetCluster $cluster
  */
  public function setCluster(SkynetCluster $cluster)
  {
    $this->cluster = $cluster;
  }

 /**
  * Sets raw receiver data
  *
  * @param string $data
  */
  public function setData($data)
  {
    $this->data = $data;
  }

 /**
  * Sets URL to connection
  *
  * @param string $url
  */
  public function setUrl($url)
  {
    $this->url = $url;
  }

 /**
  * Returns cluster object
  *
  * @return SkynetCluster Cluster
  */
  public function getCluster()
  {
    return $this->cluster;
  }

 /**
  * Returns raw received data
  *
  * @return string Raw data
  */
  public function getData()
  {
    return $this->data;
  }

 /**
  * Returns cluster URL
  *
  * @return string Cluster URL
  */
  public function getUrl()
  {
    return $this->url;
  }

 /**
  * Returns connection params
  *
  * @return string Connection params
  */
  public function getParams()
  {
    return $this->params;
  }
}