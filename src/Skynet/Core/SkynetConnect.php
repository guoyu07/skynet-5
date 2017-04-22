<?php

/**
 * Skynet/Core/SkynetConnect.php
 *
 * @package Skynet
 * @version 1.1.1
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.1
 */

namespace Skynet\Core;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\Error\SkynetException;
use Skynet\State\SkynetStatesTrait;
use Skynet\EventListener\SkynetEventListenersLauncher;
use Skynet\Common\SkynetHelper;
use Skynet\Connection\SkynetConnectionsFactory;
use Skynet\Secure\SkynetVerifier;
use Skynet\Core\SkynetChain;
use Skynet\Data\SkynetRequest;
use Skynet\Data\SkynetResponse;
use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Cluster\SkynetCluster;
use Skynet\Common\SkynetTypes;


 /**
  * Skynet Event Listeners Launcher
  *
  */
class SkynetConnect
{     
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var SkynetRequest Assigned request */
  private $request;
  
  /** @var SkynetResponse Assigned response */
  private $response; 
  
  /** @var integer Actual connection number */
  private $connectId = 0; 
  
  /** @var string Cluster URL in actual connection */
  private $clusterUrl;
  
  /** @var SkynetCli CLI Console */
  private $cli;
  
  /** @var SkynetConsole HTML Console */
  private $console;
  
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;
  
  /** @var SkynetEventListenersLauncher Listeners Launcher */
  private $eventListenersLauncher;
  
  /** @var SkynetConnectionInterface Connector instance */
  private $connection;
  
  /** @var SkynetChain SkynetChain instance */
  private $skynetChain;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetCluster Actual cluster */
  private $cluster = null;  
  
  /** @var SkynetCluster[] Array of clusters */
  private $clusters = [];
  
  /** @var bool Status od connection with cluster */
  private $isConnected = false;
  
  /** @var bool Status of response */
  private $isResponse = false;
  
  /** @var bool Status of broadcast */
  private $isBroadcast = false;

  /** @var string Raw response from connect() */
  private $responseData;
  
  /** @var string Raw header response from getHeader() */
  private $responseHeaderData;
  
  /** @var mixed[] Sended params in header request */
  private $sendedHeaderDataParams;
  
  /** @var bool Controller for break connections if specified receiver set */
  private $breakConnections = false;
  
  /** @var string[] Array with connections debug */ 
  private $connectionData = [];
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->eventListenersLauncher = new SkynetEventListenersLauncher();
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);
    $this->eventListenersLauncher->assignCli($this->cli);
    $this->eventListenersLauncher->assignConsole($this->console);
    $this->connection = SkynetConnectionsFactory::getInstance()->getConnector(\SkynetUser\SkynetConfig::get('core_connection_type'));
    $this->verifier = new SkynetVerifier();
    $this->clustersRegistry = new SkynetClustersRegistry();
  }  

 /**
  * Connects to single skynet cluster via URL
  *
  * Method connects to cluster, sends request, gets response and puts cluster URL into database (if not exists yet).
  * 
  * @param string|SkynetCluster $remote_cluster URL to remote skynet cluster, e.g. http://server.com/skynet.php, default: NULL
  * @param integer $chain Forces new connection chain value, default: NULL
  *
  * @return Skynet $this Instance of this
  */
  public function connect($remote_cluster = null, $chain = null)
  {
    $result = false;
    
    $this->init();   
    $this->cluster = $this->prepareCluster($remote_cluster);   
   
    if(empty($this->clusterUrl) || $this->clusterUrl === null)
    {
      return false;
    }
      
    /* If next connection in broadcast mode */
    if($this->connectId > 1)
    {
      $this->newData(); 
    }
    
    $this->prepareListeners();    
   
    $this->prepareRequest($chain);
    $this->responseData = $this->sendRequest();

    if($this->responseData === null || $this->responseData === false)
    {
       $this->cluster->getHeader()->setResult(-1);
       throw new SkynetException(SkynetTypes::CONN_ERR);
       
    } else {
      
      $this->prepareResponse();
      $this->updateClusterHeader();      
      $this->storeCluster();
      $this->launchResponseListeners();
      $result = true;
    }
    
    $this->saveConnectionData();    
    return $result;
  }
 
 /**
  * Returns connection data
  *
  * @return string[] Connection output
  */  
  public function getConnection()
  {
    return $this->connection;
  }

 /**
  * Launches listeners 
  */ 
  private function launchResponseListeners()
  {
   /* Launch response listeners */
    if($this->cluster->getHeader()->getId() !== null 
      && $this->verifier->isRequestKeyVerified($this->cluster->getHeader()->getId()))
    {
      $this->eventListenersLauncher->launch('onResponse');
      $this->eventListenersLauncher->launch('onResponseLoggers');
    }
  }

 /**
  * Stores cluster in DB
  */ 
  private function storeCluster()
  {
    /* Add cluster to database if not exists */
    if($this->isConnected)
    {
      $this->clustersRegistry->add($this->cluster);
      $this->cluster->getHeader()->setResult(1);
    }
  }

 /**
  * Updates cluster header with connID
  */ 
  private function updateClusterHeader()
  {
    /* Get header of remote cluster */
    $this->cluster->getHeader()->setStateId($this->connectId);
    $this->cluster->getHeader()->setConnId($this->connectId);
    $this->cluster->fromResponse($this->response);

    /* If single connection via $skynet->connect(CLUSTER_ADDRESS); */
    if(!$this->isBroadcast)
    {
      $clusterAddress = str_replace(array(\SkynetUser\SkynetConfig::get('core_connection_protocol'), 'http://', 'https://'), '', $this->clusterUrl);
      $this->cluster->getHeader()->setUrl($clusterAddress);        
    }
  }

 /**
  * Parses response
  */ 
  private function prepareResponse()
  {
    /* Parse response */
    $this->response->setRawReceivedData($this->responseData);
    if(!empty($this->responseData) && $this->responseData !== false) 
    {
      $this->isResponse = true;           
      $this->addState(SkynetTypes::CONN_OK, 'RESPONSE DATA TRANSFER OK: '. $this->clusterUrl);
    } else {
      $this->addState(SkynetTypes::CONN_OK, '[[ERROR]] RECEIVING RESPONSE: '. $this->clusterUrl);
    }
    $this->response->parseResponse();
    $responses = $this->response->getResponseData();  
  }

 /**
  * Connects and sends request
  *
  * @return string Raw response data
  */ 
  private function sendRequest()
  {
    $this->connection->assignRequest($this->request);      
    $this->adapter = $this->connection->connect();
    $this->responseData = $this->adapter['data'];
    if($this->adapter['result'] === true)
    {
      $this->isConnected = true;        
    } 
    return $this->responseData;
  }

 /**
  * Prepares request
  *
  * @param int $chain New chain value
  */ 
  private function prepareRequest($chain = null)
  {
   /* Prepare request */
    $this->connection->setCluster($this->cluster);
    $this->request->addMetaData($chain);

    /* Try to connect and get response, launch pre-request listeners */
    $this->eventListenersLauncher->launch('onRequest');

    /* If specified receiver via [@to] */
    $requests = $this->request->getRequestsData();      
    
    if(isset($requests['@to']) && !isset($_REQUEST['@peer']))
    {
      $this->cluster = new SkynetCluster();
      $this->cluster->setUrl($requests['@to']);
      $this->clusterUrl = $requests['@to'];
      $this->connection->setCluster($this->cluster);
      $this->breakConnections = true;
    } 
    $this->eventListenersLauncher->launch('onRequestLoggers');
  }

 /**
  * Assigns data to listeners
  */ 
  private function prepareListeners()
  {
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);
    $this->eventListenersLauncher->assignConnectId($this->connectId);
    $this->eventListenersLauncher->assignClusterUrl($this->clusterUrl);   
  }

 /**
  * Prepares cluster object
  *
  * @param SkynetCluster|string $remote_cluster Cluster or address
  *
  * @return SkynetCluster
  */ 
  private function prepareCluster($remote_cluster = null)
  {
    /* Prepare cluster object and address */
    if($remote_cluster !== null && !empty($remote_cluster))
    {
      if($remote_cluster instanceof SkynetCluster)
      {
        $this->cluster = $remote_cluster;
        $this->clusterUrl = $this->cluster->getUrl();

      } elseif(is_string($remote_cluster)) 
      {
        $this->cluster = new SkynetCluster();
        $this->cluster->setUrl($remote_cluster);
        $this->clusterUrl = $remote_cluster;
      }
    }
    return $this->cluster;
  }

 /**
  * Inits connection
  */ 
  private function init()
  {
    $this->isConnected = false;     
    $this->isResponse = false;   
    $this->setStateId($this->connectId);
    $this->connection->setStateId($this->connectId);
    $this->responseData = null;   
  }

 /**
  * Creates new cluster
  */ 
  private function newData()
  {
    $this->request = new SkynetRequest();
    $this->response = new SkynetResponse();
    $this->request->setStateId($this->connectId);      
    $this->response->setStateId($this->connectId);
    $this->connection->setStateId($this->connectId);  
  }
  
 /**
  * Logs connection data
  */ 
  private function saveConnectionData()
  {
   $this->connectionData = [
    'id' => $this->connectId,    
    'CLUSTER URL' => $this->clusterUrl, 
    'Ping' => $this->cluster->getHeader()->getPing().'ms',    
    'FIELDS' => [
      'request_raw' => $this->request->getFields(),
      'response_decrypted' => $this->response->getFields(),
      'request_encypted' => $this->request->getEncryptedFields(),
      'response_raw' => $this->response->getRawFields()
      ],
    'SENDED PARAMS' => $this->adapter['params'],    
    'RECEIVED RAW DATA' => $this->responseData    
    ];
  }

 /**
  * Returns cluster
  *
  * @return SkynetCluster Remote cluster
  */  
  public function getCluster()
  {
    return $this->cluster;
  }

 /**
  * Returns connection data
  *
  * @return string[] Connection debug data
  */  
  public function getConnectionData()
  {
   return $this->connectionData;
  }

 /**
  * Returns signal to break broadcast
  *
  * @return bool True if stop broadcast
  */  
  public function getBreakConnections()
  {
   return $this->breakConnections;
  }

 /**
  * Sets if broadcast mode
  *
  * @param bool $isBroadcast
  */   
  public function setIsBroadcast($isBroadcast)
  {
    $this->isBroadcast = $isBroadcast;
  }

 /**
  * Assigns Request
  *
  * @param SkynetRequest $request
  */   
  public function assignRequest($request)
  {
    $this->request = $request;
  }

 /**
  * Assigns Response
  *
  * @param SkynetResponse $response
  */   
  public function assignResponse($response)
  {
    $this->response = $response;
  }

 /**
  * Assigns clusters list
  *
  * @param SkynetCluster[] $clusters
  */   
  public function assignClusters($clusters)
  {
    $this->clusters = $clusters;
  }

 /**
  * Assigns connect ID
  *
  * @param int $connectId
  */     
  public function assignConnectId($connectId)
  {
    $this->connectId = $connectId;
  }

 /**
  * Assigns cluster URL
  *
  * @param string $clusterUrl
  */     
  public function assignClusterUrl($clusterUrl)
  {
    $this->clusterUrl = $clusterUrl;
  }

 /**
  * Assigns CLI
  *
  * @param SkynetCli $cli
  */     
  public function assignCli($cil)
  {
    $this->cil = $cil;
  }
  
 /**
  * Assigns Console
  *
  * @param SkynetConsole $console
  */ 
  public function assignConsole($console)
  {
    $this->console = $console;
  }
}