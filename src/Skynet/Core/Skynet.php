<?php

/**
 * Skynet/Core/Skynet.php
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
use Skynet\Error\SkynetException;
use Skynet\State\SkynetStatesTrait;
use Skynet\EventListener\SkynetEventListenersFactory;
use Skynet\EventLogger\SkynetEventLoggersFactory;
use Skynet\Secure\SkynetAuth;
use Skynet\Secure\SkynetVerifier;
use Skynet\Core\SkynetChain;
use Skynet\Data\SkynetRequest;
use Skynet\Data\SkynetResponse;
use Skynet\Database\SkynetDatabase;
use Skynet\Database\SkynetGenerator;
use Skynet\Database\SkynetOptions;
use Skynet\Filesystem\SkynetCloner;
use Skynet\Updater\SkynetUpdater;
use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Cluster\SkynetCluster;
use Skynet\Connection\SkynetConnectionsFactory;
use Skynet\Console\SkynetCli;
use Skynet\Console\SkynetConsole;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;
use Skynet\Renderer\SkynetRenderersFactory;

 /**
  * Skynet Main Launcher Class
  *
  * Main launcher for Skynet.
  * This is the main core of Skynet and it controls requests and receives responses.
  * By creating instance of Skynet class, e.g. $skynet = new Skynet(); you will start Skynet.
  * With __toString() (e.g. echo $skynet; ) skynet will show debug data with informations about connections, states, errors, requests, responses, configuration and more.
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class Skynet
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var string Cluster URL in actual connection */
  private $clasterUrl;

  /** @var bool Status od connection with cluster */
  private $isConnected = false;

  /** @var bool Status of database connection */
  private $isDbConnected = false;

  /** @var bool Status of response */
  private $isResponse = false;

  /** @var SkynetResponse Assigned response */
  private $response;

  /** @var string Raw response from connect() */
  private $responseData;

  /** @var string Raw header response from getHeader() */
  private $responseHeaderData;

  /** @var mixed[] Sended params in header request */
  private $sendedHeaderDataParams;

  /** @var SkynetRequest Assigned request */
  private $request;
  
  /** @var PDO Connection */
  private $db;

  /** @var integer Actual connection number */
  private $connectId = 0;

  /** @var integer Connections finished with success */
  private $successConnections = 0;

  /** @var integer Actual connection in broadcast mode */
  private $broadcastNum = 0;

  /** @var string[] URLs of connection addresses*/
  private $connectAddresses = [];

  /** @var SkynetChain SkynetChain instance */
  private $skynetChain;
  
  /** @var SkynetCloner Clusters cloner */
  private $cloner;

  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetGenerator TXT Reports Generator instance */
  private $generator;

  /** @var SkynetUpdater Updater instance */
  private $updater;
  
  /** @var SkynetAuth Authentication */
  private $auth;

  /** @var string[] Array of received remote data */
  private $remoteData = [];

  /** @var bool Status of broadcast */
  private $isBroadcast = false;

  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;
  
  /** @var SkynetOptions Options getter/setter */
  private $options;

  /** @var SkynetEventListenersInterface[] Array of Event Listeners */
  private $eventListeners = [];

  /** @var SkynetEventListenersInterface[] Array of Event Loggers */
  private $eventLoggers = [];

  /** @var string[] Array of debug of connections */
  private $debug = [];

  /** @var SkynetConnectionInterface Connector instance */
  private $connection;

  /** @var bool Controller for break connections if specified receiver set */
  private $breakConnections = false;
  
  /** @var string[] Array with connections debug */
  private $connectionsData = [];
  
  /** @var SkynetCli CLI Console */
  private $cli;
  
  /** @var SkynetConsole HTML Console */
  private $console;
  
  /** @var string[] Array of cli outputs */
  private $cliOutput = [];
  
  /** @var string[] Array of console outputs */
  private $consoleOutput = [];
  
  private $clusters = [];
  
  private $connMode = 2;  


 /**
  * Constructor
  *
  * @param bool $start Autostarts Skynet
  *
  * @return Skynet $this Instance of $this
  */
  public function __construct($start = false)
  {
    $this->auth = new SkynetAuth();
    $this->request = new SkynetRequest();
    $this->response = new SkynetResponse();
    $this->db = SkynetDatabase::getInstance()->getDB();
    $this->skynetChain = new SkynetChain();
    $this->verifier = new SkynetVerifier();
    $this->generator = new SkynetGenerator();
    $this->cloner = new SkynetCloner();
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();
    $this->connection = SkynetConnectionsFactory::getInstance()->getConnector(\SkynetUser\SkynetConfig::get('core_connection_type'));
    $this->cli = new SkynetCli();
    $this->console = new SkynetConsole();
    $this->options = new SkynetOptions();
    
    $this->verifier->assignRequest($this->request);
    
    $this->clusters = $this->clustersRegistry->getAll();
    $this->modeController();

    /* Self-updater of Skynet */
    if(\SkynetUser\SkynetConfig::get('core_updater'))
    {
      $this->updater = new SkynetUpdater(__FILE__);
    }
    $this->newChain();
    if($start === true)
    {
      $this->boot();
    }
    return $this;    
  }

 /**
  * Launches Skynet
  *
  * @return string Output debug data
  */
  public function boot()
  {
    $startBroadcast = false;
    
    /* Check for console and CLI args */
    if($this->cli->isCli())
    {      
      $startBroadcast = $this->cliController();        
    } else {      
      $startBroadcast = $this->consoleController();  
    }

    /* Start broadcasting clusters */
    if($startBroadcast === true) 
    {
      if($this->connMode == 2)
      {
        $this->broadcast();
      }
    }
    echo $this->renderOutput();   
  }
  
 /**
  * Connects to all clusters from cluster's list saved in database ["skynet_clusters" table]
  *
  * Method connects to all clusters, checks headers, sends requests, gets responses and puts all of verified cluster's URLs into database.
  * Use this method to broadcast requests to all your skynet instances (clusters).
  * You can limit connections at once via $config['connection_broadcast_limit'] in {src/Skynet/SkynetConfig.php}.
  *
  * @return Skynet $this Instance of this
  */
  public function broadcast()
  {
    /* Disable broadcast when cluster is sleeped */
    if($this->options->getOptionsValue('sleep') == 1 || $this->verifier->isPing())
    {
      return false;
    }
    
    /* Disable broadcast when viewing database */
    if($this->verifier->isDatabaseView())
    {
      return false;
    }
    /* Disable broadcast when Peer connection */
    if(isset($_REQUEST['@peer'])) 
    {
      return false;
    }
    
    $this->isBroadcast = true;

    /* Check Chain value */
    if(!$this->skynetChain->isChain())
    {
      $this->skynetChain->createChain();
      $this->addError(SkynetTypes::CHAIN, 'NO CHAINDATA IN DATABASE');     
    }

    /* Load actual chain value from db */
    $this->skynetChain->loadChain();

    /* Get clusters saved in db */   
    if(is_array($this->clusters) && count($this->clusters) > 0)
    {
      foreach($this->clusters as $cluster)
      {
        /* First, request for header with correct ID and get remote chain value */
        $this->responseHeaderData = null;
        $stateId = $this->connectId;        
        if($this->connectId == 0) 
        {
          $stateId = 1;
        }
        $cluster->setStateId($stateId);
        
        /* Get remote header */
        $header = $cluster->fromConnect();
        $this->responseHeaderData = $header['data'];
        $this->sendedHeaderDataParams = $header['params'];

        /* Prepare address */
        $address = \SkynetUser\SkynetConfig::get('core_connection_protocol').$cluster->getUrl();

        /* If Key ID is verified and remote shows chain and we are not under other connection */
        if(!$this->verifier->isPing() 
          && $cluster->getHeader()->getChain() !== null 
          && $this->verifier->isAddressCorrect($address))
        {
          $this->clusterUrl = $address;
          
          /* If remote cluster have different chain value, then connect */
          $remoteChainValue = $cluster->getHeader()->getChain();
          $myChainValue = $this->skynetChain->getChain();
          if($myChainValue != $remoteChainValue)
          {
            $this->connect($address, $this->skynetChain->getChain());
          }

          /* Save remote cluster address in database if not exists yet */
          $this->clustersRegistry->setStateId($this->connectId);          
          if($this->isConnected)
          {
            $this->clustersRegistry->add($cluster);
          }
        } else {
          $this->addState(SkynetTypes::HEADER,'[[[[ERROR]]]: PROBLEM WITH RECEIVING HEADER: '.$address.'. IGNORING THIS CLUSTER...');
        }
        
        if($this->breakConnections) 
        {
          break;
        }
        $this->broadcastNum++;
      }
    }
    return $this;
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
    $this->isConnected = false; 
    $ping = 0;
    
    if($this->verifier->isDatabaseView())
    {
      return false;
    }
    
    $this->isResponse = false;
    $this->connectId++;
    $this->setStateId($this->connectId);
    $this->connection->setStateId($this->connectId);
    $this->responseData = null;

    /* Prepare cluster object and address */
    if($remote_cluster !== null && !empty($remote_cluster) && is_string($remote_cluster))
    {
      if($remote_cluster instanceof SkynetCluster)
      {
        $cluster = $remote_cluster;
        $this->clusterUrl = $cluster->getUrl();

      } else {
        $cluster = new SkynetCluster();
        $cluster->setUrl($remote_cluster);
        $this->clusterUrl = $remote_cluster;
      }
    }
   
    if(empty($this->clusterUrl) || $this->clusterUrl === null)
    {
      return false;
    }

    /* If next connection in broadcast mode */
    if($this->connectId > 1)
    {
      $this->request = new SkynetRequest();
      $this->response = new SkynetResponse();
      $this->request->setStateId($this->connectId);      
      $this->response->setStateId($this->connectId);
      $this->connection->setStateId($this->connectId);
    }

    try
    {
      /* Prepare request */
      $this->connection->setCluster($cluster);
      $this->request->addMetaData($chain);

      /* Try to connect and get response, launch pre-request listeners */
      $this->launchEventListeners('onRequest');

      /* If specified receiver via [@to] */
      $requests = $this->request->getRequestsData();
      if(isset($requests['@to']) && !isset($_REQUEST['@peer']))
      {
        $cluster = new SkynetCluster();
        $cluster->setUrl($requests['@to']);
        $this->clusterUrl = $requests['@to'];
        $this->connection->setCluster($cluster);
        $this->breakConnections = true;
      }
      
      /* Try to connect and get response */
      $this->launchEventListeners('onRequestLoggers');
      $this->connection->assignRequest($this->request);
      
      $adapter = $this->connection->connect();
      $this->responseData = $adapter['data'];

      if($this->responseData === null || $this->responseData === false)
      {
        throw new SkynetException(SkynetTypes::CONN_ERR);
      }
      
      if($adapter['result'] === true)
      {
        $this->isConnected = true;        
      }        
      
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

      /* Get header of remote cluster */
      $cluster->getHeader()->setStateId($this->connectId);
      $cluster->getHeader()->setConnId($this->connectId);
      $cluster->fromResponse($this->response);

      /* If single connection via $skynet->connect(CLUSTER_ADDRESS); */
      if(!$this->isBroadcast)
      {
        $clusterAddress = str_replace(array(\SkynetUser\SkynetConfig::get('core_connection_protocol'), 'http://', 'https://'), '', $this->clusterUrl);
        $cluster->getHeader()->setUrl($clusterAddress);        
      }
      
      /* Add cluster to database if not exists */
      if($this->isConnected)
      {
        $this->clustersRegistry->add($cluster);
        $cluster->getHeader()->setResult(1);
      }

      /* Launch response listeners */
      if($cluster->getHeader()->getId() !== null 
        && $this->verifier->isRequestKeyVerified($cluster->getHeader()->getId()))
      {
        $this->launchEventListeners('onResponse');
        $this->launchEventListeners('onResponseLoggers');
      }

      $this->successConnections++;

    /* If connection errors */
    } catch(SkynetException $e)
    {
      $cluster->getHeader()->setResult(-1);
      $this->addState(SkynetTypes::CONN_ERR, SkynetTypes::CONN_ERR.' : '. $this->connection->getUrl().$this->connection->getParams());
      $this->addError('Connection error: '.$e->getMessage(), $e);
    }
    
    /* refresh clusters data */   
    $thisCluster = key($this->clusters);
    $this->clusters[$thisCluster] = $cluster;

    /* Generates debug data for every connection */    
    $this->connectionsData[] = [
    'id' => $this->connectId,    
    'CLUSTER URL' => $this->clusterUrl, 
    'Ping' => $cluster->getHeader()->getPing().'ms',    
    'FIELDS' => [
      'request_raw' => $this->request->getFields(),
      'response_decrypted' => $this->response->getFields(),
      'request_encypted' => $this->request->getEncryptedFields(),
      'response_raw' => $this->response->getRawFields()
      ],
    'SENDED PARAMS' => $adapter['params'],
    'SENDED HEADER PARAMS (broadcast)' => $this->sendedHeaderDataParams,
    'RECEIVED RAW DATA' => $this->responseData,
    'RECEIVED RAW HEADER (broadcast)' => $this->responseHeaderData      
    ];
    
    return $this;
  }

 /**
  * Returns true if is response
  *
  * @return bool True if response received
  */
  public function isResponse()
  {
    return $this->isResponse;
  }

 /**
  * Generates new chain value
  *
  * Chain is used for updates data in instances. Every new action whitch broadcast to all your clusters should increments chain value.
  * Method calls exit() and terminates Skynet if requested key ID is incorrect.
  *
  * @return bool true|false
  */
  public function newChain()
  {
    return $this->skynetChain->newChain();
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
  * Returns request object
  *
  * @return SkynetRequest Object with request data and request manipulation methods
  */
  public function getRequest()
  {
    return $this->request;
  }

 /**
  * Assigns $request object to Skynet
  *
  * @param SkynetRequest $request
  */
  public function setRequest(SkynetRequest $request)
  {
    $this->request = $request;
  }

 /**
  * Assigns $response object to Skynet
  *
  * @param SkynetResponse $response
  */
  public function setResponse(SkynetResponse $response)
  {
    $this->response = $response;
  }

 /**
  * Sets URL address of cluster to connect with via connect() method.
  *
  * @param string $url Address of actually connected Cluster, e.g. http://localhost/skynet.php
  */
  public function setClusterUrl($url)
  {
    $this->clusterUrl = $url;
  }

 /**
  * Returns rendered output
  *
  * @return string Output
  */
  public function renderOutput()
  {
    if($this->cli->isCli())
    {
        $renderer = SkynetRenderersFactory::getInstance()->getRenderer('cli');
    } else {
        
        if(!$this->auth->isAuthorized())
        {
          if($this->verifier->isPing())
          {
            return false;
          } else {
            $this->auth->checkAuth();
            return false;
          }
        }        
        
        $renderer = SkynetRenderersFactory::getInstance()->getRenderer('html');
    }   
    
    $this->loadErrorsRegistry();
    $this->loadStatesRegistry();
    if($this->verifier->isPing()) 
    {
      return '';
    }
    $chainData = $this->skynetChain->loadChain();   

    /* set connection mode to output */
    if($this->isBroadcast)
    {
      $renderer->setConnectionMode(2);
    } elseif($this->isConnected)
    {
      $renderer->setConnectionMode(1);
    } else {
      $renderer->setConnectionMode(0);
    }
    
    $renderer->setClustersData($this->clusters);
    $renderer->setConnectionsCounter($this->successConnections);
    $renderer->addField('My address', SkynetHelper::getMyUrl());
    $renderer->addField('Broadcasting Clusters', $this->broadcastNum);
    $renderer->addField('Clusters in DB', $this->clustersRegistry->countClusters()); 
    $renderer->addField('Connection attempts', $this->connectId);
    $renderer->addField('Succesful connections', $this->successConnections);
    $renderer->addField('Chain', $chainData['chain'] . ' (updated: '.date('H:i:s d.m.Y', $chainData['updated_at']).')');
    $renderer->addField('Skynet Key ID', \SkynetUser\SkynetConfig::KEY_ID);
    $renderer->addField('Time now', date('H:i:s d.m.Y').' ['.time().']');  
    $renderer->addField('Sleeped', ($this->options->getOptionsValue('sleep') == 1) ? 'YES' : 'NO');
    
    foreach($this->connectionsData as $connectionData)
    {
      $renderer->addConnectionData($connectionData);
    }
    foreach($this->statesRegistry->getStates() as $state)
    {
      $renderer->addStateField($state->getCode(), $state->getMsg());
    }
    foreach($this->errorsRegistry->getErrors() as $error)
    {
      $renderer->addErrorField($error->getCode(), $error->getMsg(), $error->getException());
    }
    foreach(\SkynetUser\SkynetConfig::getAll() as $k => $v)
    {
      $renderer->addConfigField($k, $v);
    }
    
    $renderer->setConsoleOutput($this->consoleOutput);
    $renderer->setCliOutput($this->cliOutput);
    
    return $renderer->render();
  }  
  
 /**
  * __toString
  *
  * @return string Debug data
  */
  public function __toString()
  {   
    return $this->renderOutput();
  }
 
 /**
  * set Mode
  *
  * @return string Debug data
  */
  private function modeController()
  {   
    if(isset($_REQUEST['_skynetSetConnMode']))
    {
      if(!isset($_SESSION))
      {
        session_start();
      }
      $_SESSION['_skynetConnMode'] = $_REQUEST['_skynetSetConnMode'];      
    }
    
    if(isset($_SESSION['_skynetConnMode']))
    {
      $this->connMode = $_SESSION['_skynetConnMode'];
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
      /* Launch when response received */
      case 'onResponse':
        foreach($this->eventListeners as $listener)
        {
          $listener->setConnId($this->connectId);
          $listener->setSender(true);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          $listener->onResponse('afterReceive');
          $requests = $this->request->getRequestsData();
          if(isset($requests['@echo'])) 
          {
            $listener->onEcho('afterReceive');
          }
          if(isset($requests['@broadcast'])) 
          {
            $listener->onBroadcast('afterReceive');
          }
        }
      break;

      /* Launch before sending request */
      case 'onRequest':
        foreach($this->eventListeners as $listener)
        {
          $listener->setConnId($this->connectId);
          $listener->setSender(true);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          $listener->setReceiverClusterUrl($this->clusterUrl);
          $listener->onRequest('beforeSend');
          $requests = $this->request->getRequestsData();
        }

        if($this->request->isField('@broadcast') 
          && !$this->request->isField('@broadcaster'))
        {
          $this->request->set('@broadcaster', SkynetHelper::getMyUrl());
        }

      break;

      /* Launch after response listeners */
      case 'onResponseLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->setConnId($this->connectId);
          $listener->setSender(true);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          $listener->onResponse('afterReceive');
          $requests = $this->request->getRequestsData();
          if(isset($requests['@echo'])) 
          {
            $listener->onEcho('afterReceive');
          }
          if(isset($requests['@broadcast'])) 
          {
            $listener->onBroadcast('afterReceive');
          }
        }
      break;

      /* Launch after request listeners */
      case 'onRequestLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->setConnId($this->connectId);
          $listener->setSender(true);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          $listener->setReceiverClusterUrl($this->clusterUrl);
          $listener->onRequest('beforeSend');
          $requests = $this->request->getRequestsData();
        }
      break;
      
      /* Launch when CLI */
      case 'onCli':
        foreach($this->eventListeners as $listener)
        {
          $listener->assignCli($this->cli);
          $this->cliOutput[] = $listener->onCli();
        }
      break;
      
      /* Launch when Console */
      case 'onConsole':
        foreach($this->eventListeners as $listener)
        {
          $listener->assignConsole($this->console);
          $this->consoleOutput[] = $listener->onConsole();
        }
      break;
    }
  } 
  
 /**
  * Listener for Cli Commands
  *
  * @return bool If true then start broadcast
  */ 
  private function cliController()
  {
    $startBroadcast = false;
    
    /* if CLI mode */
    if($this->cli->isCommand('b') || $this->cli->isCommand('broadcast'))
    {
      /* Launch broadcast */
      $startBroadcast = true;
      
    } else {
      
      /* If single connection */
      $address = null;
      if($this->cli->isCommand('connect'))
      {
        $address = $this->cli->getParam('connect');          
      } elseif($this->cli->isCommand('c'))
      {
        $address = $this->cli->getParam('c');          
      }
      
      if(!empty($address) && $address !== null)
      {
        if($this->verifier->isAddressCorrect($address))
        {
          $this->connect($address); 
        } 
      }        
    }
    
    /* Launch CLI commands listeners */
     $this->launchEventListeners('onCli');    
    
    return $startBroadcast;
  }
 
 /**
  * Listener for Console Commands
  *
  * @return bool If true then start broadcast
  */  
  private function consoleController()
  {
    $startBroadcast = true;
    
    /* @connect command */
    if($this->auth->isAuthorized() && $this->console->isInput())
    {
      $this->console->parseConsoleInput($_REQUEST['_skynetCmdConsoleInput']);
      if($this->console->isConsoleCommand('connect'))
      {
        $startBroadcast = false;
        $connectData = $this->console->getConsoleCommand('connect');
        $connectParams = $connectData->getParams();
       
        if(count($connectParams) > 0)
        {
          foreach($connectParams as $param)
          {            
            if($this->verifier->isAddressCorrect($param))
            {
              $this->connect($param); 
            }              
          }
        }
        return false;
      }
      
      /* @add command */
      if($this->console->isConsoleCommand('add'))
      {
        $params = $this->console->getConsoleCommand('add')->getParams();
        if(count($params) > 0)
        {
          foreach($params as $param)
          {
            $cluster = new SkynetCluster();
            $cluster->setUrl($param);
            $cluster->getHeader()->setUrl($param);
            $this->clustersRegistry->add($cluster);             
          }
        }
      }
      
      /* Other listeners Commands */
      if($this->console->isAnyConsoleCommand())
      {
        $consoleCommands = $this->console->getConsoleCommands();
        foreach($consoleCommands as $command)
        {         
          $params = $command->getParams();        
          if(count($params) > 0)
          {
            foreach($params as $param)
            {
              if(is_string($param) && $param == 'me')
              {
                $this->console->clear();
                
                /* Launch Console commands listeners */
                $this->launchEventListeners('onConsole');
                
              } elseif(is_string($param) && $param != 'all')
              {
                $startBroadcast = false;
                if($this->verifier->isAddressCorrect($param))
                {
                  $this->connect($param); 
                }  
              }
            }  
          }  
        }        
      } 
    } 
    
    return $startBroadcast;
  }
}