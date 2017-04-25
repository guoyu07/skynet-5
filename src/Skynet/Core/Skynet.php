<?php

/**
 * Skynet/Core/Skynet.php
 *
 * @package Skynet
 * @version 1.1.2
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
use Skynet\EventListener\SkynetEventListenersLauncher;
use Skynet\Secure\SkynetAuth;
use Skynet\Secure\SkynetVerifier;
use Skynet\Core\SkynetChain;
use Skynet\Core\SkynetConnect;
use Skynet\Core\SkynetOutput;
use Skynet\Data\SkynetRequest;
use Skynet\Data\SkynetResponse;
use Skynet\Database\SkynetDatabase;
use Skynet\Database\SkynetGenerator;
use Skynet\Database\SkynetOptions;
use Skynet\Filesystem\SkynetCloner;
use Skynet\Filesystem\SkynetDetector;
use Skynet\Updater\SkynetUpdater;
use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Cluster\SkynetCluster;
use Skynet\Console\SkynetCli;
use Skynet\Console\SkynetConsole;
use Skynet\Console\SkynetConsoleInput;
use Skynet\Console\SkynetCliInput;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;
use Skynet\Debug\SkynetDebug;

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
  private $clusterUrl;

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

  /** @var SkynetEventListenersLauncher Listeners Launcher */
  private $eventListenersLauncher;

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

  /** @var SkynetCluster Actual cluster */
  private $cluster = null;

  /** @var SkynetCluster[] Array of clusters */
  private $clusters = [];

  /** @var int connection mode */
  private $connMode = 2;

  /** @var SkynetDetector Clusters detector */
  private $clustersDetector;

  /** @var string[] Array of monits */
  private $monits = [];

  /** @var SkynetConnect Connect object */
  private $skynetConnect;
  
  /** @var bool If true checks header before connect */
  private $checkHeader = false;
  
  /** @var SkynetDebug Debugger */
  private $debugger;

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
    $this->cli = new SkynetCli();
    $this->console = new SkynetConsole();
    $this->options = new SkynetOptions();
    $this->detector = new SkynetDetector();
    $this->skynetConnect = new SkynetConnect();
    $this->debugger = new SkynetDebug();

    $this->eventListenersLauncher = new SkynetEventListenersLauncher();
    $this->eventListenersLauncher->setSender(true);
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);
    $this->eventListenersLauncher->assignCli($this->cli);
    $this->eventListenersLauncher->assignConsole($this->console);

    $this->verifier->assignRequest($this->request);
    $this->modeController();

    /* Self-updater of Skynet */
    if(\SkynetUser\SkynetConfig::get('core_updater'))
    {
      $this->updater = new SkynetUpdater(__FILE__);
    }

    $this->clusters = $this->clustersRegistry->getAll();

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

    /* clusters detector */
    if(!$this->verifier->isPing())
    {
      $detectClusters = $this->detector->check();
      if($detectClusters !== null)
      {
        $this->monits[] = $detectClusters;
      }
    }
  }

 /**
  * Connects to all clusters from cluster's list saved in database ["skynet_clusters" table]
  *
  * Method connects to all clusters, checks headers, sends requests, gets responses and puts all of verified cluster's URLs into database.
  * Use this method to broadcast requests to all your skynet instances (clusters).
  *
  * @return Skynet $this Instance of this
  */
  public function broadcast()
  {    
    if($this->isSleeped() || $this->verifier->isPing() || $this->verifier->isDatabaseView() || isset($_REQUEST['@peer']) || !$this->auth->isAuthorized())
    {
      return false;
    }

    $this->isBroadcast = true;
    $this->loadChain();
   
    /* Get clusters saved in db */
    if($this->areClusters())
    {
      $clustersNum = 0;
      $tmpRequest = new SkynetRequest();
      
     
      $to = $tmpRequest->get('@to');      
    
      $this->debugger->dump($to);
      if($to !== null)
      {
         //$this->doConnect = false;
         $to = $tmpRequest->get('@to');
         $this->debugger->dump($to);
      }
      
      foreach($this->clusters as $cluster)
      {
        $clustersNum++;
        $this->cluster = $cluster;
        $this->assignConnId();
        if($this->checkHeader)
        {
          $this->getRemoteHeader();
        }

        /* Prepare address */
        $address = \SkynetUser\SkynetConfig::get('core_connection_protocol').$this->cluster->getUrl();
        $this->clusterUrl = $address;

        /* If Key ID is verified and remote shows chain and we are not under other connection */
        if(!$this->verifier->isPing() && ($this->cluster->getHeader()->getChain() !== null || !$this->checkHeader) && $this->verifier->isAddressCorrect($address))
        {
          if(!$this->checkHeader || $this->isDifferentChain())
          {
            $this->connect($address, $this->skynetChain->getChain());
          }
          $this->storeCluster();

        } else {
          $this->clusters[$clustersNum - 1]->getHeader()->setResult(-1);
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
    $this->connectId++;
    $this->setStateId($this->connectId);

    $connect = new SkynetConnect();
    $connect->assignRequest($this->request);
    $connect->assignResponse($this->response);
    $connect->assignConnectId($this->connectId);
    $connect->setIsBroadcast($this->isBroadcast);

    if($this->verifier->isDatabaseView())
    {
      return false;
    }

    try
    {
      $connResult = $connect->connect($remote_cluster, $chain);
      if($connResult)
      {
        $this->successConnections++;
        $this->clusters[$this->connectId - 1] = $connect->getCluster();
        $this->isConnected = true;
      } elseif($connResult === null) 
      {
        $this->clusters[$this->connectId - 1]->getHeader()->setResult(0);
      } elseif(!$connResult) 
      {
        $this->clusters[$this->connectId - 1]->getHeader()->setResult(-1);
      }      

    } catch(SkynetException $e)
    {
      $this->clusters[$this->connectId - 1]->getHeader()->setResult(-1);
      $this->addState(SkynetTypes::CONN_ERR, SkynetTypes::CONN_ERR.' : '. $connect->getConnection()->getUrl().$connect->getConnection()->getParams());
      $this->addError('Connection error: '.$e->getMessage(), $e);
    }

    $this->breakConnections = $connect->getBreakConnections();

    $data = $connect->getConnectionData();
    $data['SENDED HEADER PARAMS (broadcast)'] = $this->sendedHeaderDataParams;
    $data['RECEIVED RAW HEADER (broadcast)'] = $this->responseHeaderData;
    $this->connectionsData[] = $data;

    return $this;
  }

 /**
  * Returns rendered output
  *
  * @return string Output
  */
  public function renderOutput()
  {
    $output = new SkynetOutput();
    if(isset($_REQUEST['_skynetAjax']))
    {
      $output->setInAjax(true);
    }
    $output->setConnectId($this->connectId);
    $output->setMonits($this->monits);
    $output->setClusters($this->clusters);
    $output->setIsBroadcast($this->isBroadcast);
    $output->setIsConnected($this->isConnected);
    $output->setConnectionData($this->connectionsData);
    $output->setBroadcastNum($this->broadcastNum);
    $output->setSuccessConnections($this->successConnections);
    $output->setConsoleOutput($this->consoleOutput);
    $output->setCliOutput($this->cliOutput);
    return (string)$output;
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
  * Listener for Cli Commands
  *
  * @return bool If true then start broadcast
  */
  private function cliController()
  {
    $cliInput = new SkynetCliInput();
    $cliInput->assignRequest($this->request);
    $cliInput->assignResponse($this->response);
    $cliInput->assignConsole($this->console);
    $cliInput->assignCli($this->cli);

    $startBroadcast =  $cliInput->launch();
    $addresses = $cliInput->getAddresses();
    $this->cliOutput = $cliInput->getCliOutput();

    if(count($addresses) > 0)
    {
      foreach($addresses as $address)
      {
        $this->connect($address);
      }
    }
    return $startBroadcast;
  }

 /**
  * Listener for Console Commands
  *
  * @return bool If true then start broadcast
  */
  private function consoleController()
  {
    $consoleInput = new SkynetConsoleInput();
    $consoleInput->assignRequest($this->request);
    $consoleInput->assignResponse($this->response);
    $consoleInput->assignConsole($this->console);
    $consoleInput->assignCli($this->cli);

    $startBroadcast =  $consoleInput->launch();
    $addresses = $consoleInput->getAddresses();
    $this->consoleOutput = $consoleInput->getConsoleOutput();    

    if(count($addresses) > 0)
    {
      foreach($addresses as $address)
      {
        $this->connect($address);
      }
    }
    if(!$startBroadcast)
    {
      $this->connMode = 1;
    }
    return $startBroadcast;
  }

 /**
  * Checks if remote cluster has different chain
  *
  * @return bool True if different
  */
  private function isDifferentChain()
  {
    $remoteChainValue = $this->cluster->getHeader()->getChain();
    $myChainValue = $this->skynetChain->getChain();
    if($myChainValue != $remoteChainValue)
    {
      return true;
    }
  }

 /**
  * Assigns connection ID to cluster
  */
  private function assignConnId()
  {
  /* First, request for header with correct ID and get remote chain value */
    $stateId = $this->connectId;
    if($this->connectId == 0)
    {
      $stateId = 1;
    }
    $this->cluster->setStateId($stateId);
  }

 /**
  * Saves cluster in DB
  */
  private function storeCluster()
  {
    /* Save remote cluster address in database if not exists yet */
    $this->clustersRegistry->setStateId($this->connectId);
    if($this->isConnected)
    {
      $this->clustersRegistry->add($this->cluster);
    }
  }

 /**
  * Checks for clusters in DB
  *
  * @return bool True if are clusters
  */
  private function areClusters()
  {
    if(is_array($this->clusters) && count($this->clusters) > 0)
    {
      return true;
    }
  }

 /**
  * Gets remote header
  */
  private function getRemoteHeader()
  {
    $this->responseHeaderData = null;
    $header = $this->cluster->fromConnect();
    $this->responseHeaderData = $header['data'];
    $this->sendedHeaderDataParams = $header['params'];
  }

 /**
  * Loads chain from DB
  */
  private function loadChain()
  {
    /* Check Chain value */
    if(!$this->skynetChain->isChain())
    {
      $this->skynetChain->createChain();
      $this->addError(SkynetTypes::CHAIN, 'NO CHAINDATA IN DATABASE');
    }

    /* Load actual chain value from db */
    $this->skynetChain->loadChain();
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
  * __toString
  *
  * @return string Debug data
  */
  public function __toString()
  {
    return $this->renderOutput();
  }
}