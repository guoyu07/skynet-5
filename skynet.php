<?php 

/* Skynet Standalone | version compiled: 2017.04.28 19:50:03 (1493409003) */

namespace Skynet;


/**
 * Skynet/SkynetConfig.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Config
  *
  * Global configuration of Skynet
  */
class SkynetConfig
{
  
  /** @var string SKYNET KEY ID, default: 1234567890 */
  const KEY_ID = '1234567890';
  
  /** @var string SKYNET PASSWORD, default: empty */
  const PASSWORD = '';
  
  
  /** @var string[] Array of configuration options */
  private static $config = [

/*
  ==================================
  Core configuration - base options:
  ==================================
*/
    /* core_secure -> bool:[true|false]
    If TRUE, Skynet will verify KEY ID in every response, if FALSE - you will able to connect without key (USE THIS ONLY FOR TESTS!!!) */
    'core_secure' => true,

    /* core_raw -> bool:[true|false]
    If TRUE all sending and receiving data will be encrypted, if FALSE - all data will be send in plain text */
    'core_raw' => false,

    /* core_updater -> bool:[true|false]
    If TRUE Skynet will enable self-remote-update engine, if FALSE - self-remote-engine will be disabled */
    'core_updater' => true,
    
    /* core_cloner -> bool:[true|false]
    If TRUE - cloner will be enabled and listening for clone command */
    'core_cloner' => true,
    
    /* core_check_new_versions -> bool:[true|false]
    If TRUE - information about new version is given from GitHub */
    'core_check_new_versions' => true,
    
    /* core_urls_chain -> bool:[true|false]
    If TRUE - Skynet will include urls chain to requests/responses and will be updates new clusters from it  */
    'core_urls_chain' => true,
    
    /* core_mode -> integer:0|1|2
    Default Skynet Mode. 0 = Idle, 1 = Single, 2 = Broadcast */
    'core_mode' => 2,

    /* core_encryptor -> string:[openSSL|mcrypt|base64|...]
    Name of registered class used for encrypting data */
    'core_encryptor' => 'openSSL',
    
    /* core_encryptor_algorithm -> string]
    Algorithm for OpenSSL encryption */
    'core_encryptor_algorithm' => 'aes-256-ctr',
    
    /* core_renderer_theme -> string:[dark|light|raw|...]
    Theme CSS configuration for HTML Renderer */
    'core_renderer_theme' => 'dark',
    
    /* core_date_format -> string
    Date format for date() function */
    'core_date_format' => 'H:i:s d.m.Y',
    
    /* core_admin_ip_whitelist -> string[]
    IP Whitelist for accepting access to Control Panel */
    'core_admin_ip_whitelist' => [],
    
    /*core_open_sender -> bool:[true|false]
    If TRUE Skynet will always sends requests when open (without login to Control Panel) */
    'core_open_sender' => true,
    
/*
  ==================================
  Translate configuration 
  ==================================
*/   
    
    /* translator_config -> bool:[true|false]
    If TRUE - config fields are translated*/
    'translator_config' => true,
    
    /* translator_params -> bool:[true|false]
    If TRUE - param fields are translated*/
    'translator_params' => true,

/*
  ==================================
  Core configuration - connections with clusters:
  ==================================
*/
    /* core_connection_mode -> string:[host|ip]
    Specified connection addresses by host or IP */
    'core_connection_mode' => 'host', // WARNING: at now only host method is supported

    /* core_connection_type -> string:[curl|file_get_contents|...]
    Name of registered class used for connection with clusters */
    'core_connection_type' => 'curl',

    /* core_connection_protocol -> string:[http|https]
    Connections protocol */
    'core_connection_protocol' => 'http://',

    /* core_connection_ssl_verify -> bool:[true|false]
    Only for cURL, set to FALSE to disable verification of SSL certificates */
    'core_connection_ssl_verify' => false,
    
    /* core_connection_curl_cli_echo -> bool:[true|false]
    If true CURL will display connection output in CLI mode (VERBOSE OPTION) */
    'core_connection_curl_output' => true,
    
    /* core_connection_ip_whitelist -> string[]
    IP Whitelist for accepting requests from, if empty then all IP's has access to response */
    'core_connection_ip_whitelist' => [],

/*
  ==================================
  Emailer configuration:
  ==================================
*/
    /* core_email_send -> bool:[true|false]
    TRUE for enable auto-emailer engine for responses, FALSE to disable */
    'emailer_responses' => true,
    
    /* core_email_send -> bool:[true|false]
    TRUE for enable auto-emailer engine for requests, FALSE to disable */
    'emailer_requests' => true,

    /* core_email_address -> [email]
    Specify email address for receiving emails from Skynet */
    'emailer_email_address' => 'your@email.com',

/*
  ==================================
  Response:
  ==================================
*/
    /* response_include_request -> bool:[true|false]
    If TRUE, response will be attaching requests data with @ prefix, if FALSE requests data will not be included into response */
    'response_include_request' => true,

/*
  ==================================
  Logs:
  ==================================
*/
     /* logs_errors_with_full_trace -> bool:[true|false]
    Set TRUE to log errors with full error code, file, line and trace data, set FALSE to log only error messages */
    'logs_errors_with_full_trace' => true,
    
    /* logs_txt_include_secure_data -> bool:[true|false]
    Set TRUE to log Skynet Key ID and Hash (use this only for debug, not in production */
    'logs_txt_include_secure_data' => true,
    
    /* logs_txt_include_clusters_data -> bool:[true|false]
    Set TRUE to log clusters URLs and clusters chain (use this only for debug, not in production */
    'logs_txt_include_clusters_data' => true,
    
    /* logs_dir -> string:[path/]
    Specify path to dir where Skynet will save logs, or leave empty to save logs in Skynet directory */
    'logs_dir' => 'logs/',

    /* logs_txt_* -> bool:[true|false]
    Enable or disable txt logs for specified Event */
    'logs_txt_access_errors' => true,
    'logs_txt_errors' => true,
    'logs_txt_requests' => true,
    'logs_txt_responses' => true,
    'logs_txt_echo' => true,
    'logs_txt_broadcast' => true,
    'logs_txt_selfupdate' => true,

    /* logs_txt_include_internal_data -> bool:[true|false]
    If TRUE, Skynet will include internal params in txt logs */
    'logs_txt_include_internal_data' => true,

    /* logs_db_* -> bool:[true|false]
    Enable or disable database logs for specified Event */
    'logs_db_access_errors' => true,
    'logs_db_errors' => true,
    'logs_db_requests' => true,
    'logs_db_responses' => true,
    'logs_db_echo' => true,
    'logs_db_broadcast' => true,
    'logs_db_selfupdate' => true,

    /* logs_db_include_internal_data -> bool:[true|false]
    If TRUE, Skynet will include internal params in database logs */
    'logs_db_include_internal_data' => false,

/*
  ==================================
  Database configuration:
  ==================================
*/
    /* db -> bool:[true|false]
    Enable or disable database support. If disabled some of functions of Skynet will not work  */
    'db' => true,

    /* db_type -> string:[dsn]
    Specify adapter for PDO (sqlite is recommended)  */
    'db_type' => 'sqlite',

    /* DB connection config  */
    'db_host' => '127.0.0.1',
    'db_user' => 'root',
    'db_password' => '',
    'db_dbname' => 'skynet',
    'db_encoding' => 'utf-8',
    'db_port' => 3306,

    /* db_file -> string:[filename]
    SQLite database filename, leave empty to let Skynet specify names itself (recommended)  */
    'db_file' => '',
    /* db_file -> string:[path/]
    SQLite database path, if empty db will be created in Skynet directory  */
    'db_file_dir' => '',
    
/*
  ==================================
  Debug options
  ==================================
*/
    /* console_debug -> bool:[true|false]
     If TRUE, console command debugger will be displayed when parsing input */
    'console_debug' => true,
    
     /* debug_exceptions -> bool:[true|false]
     If TRUE, debugger will show more info like line, file and trace on errors */
    'debug_exceptions' => false,
    
    /* debug_internal -> bool:[true|false]
     If TRUE, internal params will be show in debug data */
    'debug_internal' => true,  
    
    /* debug_echo-> bool:[true|false]
     If TRUE, internal @echo params will be show in debug data */
    'debug_echo' => true,
    
     /* debug_key-> bool:[true|false]
     If TRUE, KEY ID will be in debug data */
    'debug_key' => true

/*
 -------- end of config.
*/
  ];

 /**
  * Gets config value
  *
  * @param string $key Config Key
  *
  * @return mixed Config value
  */
  public static function get($key)
  {
    if(array_key_exists($key, self::$config)) 
    {
      return self::$config[$key];
    }
  }

 /**
  * Gets all config values as array
  *
  * @return mixed[]
  */
  public static function getAll()
  {
   return self::$config;
  }

 /**
  * Sets config value
  *
  * @param string $key Config Key
  * @param mixed $value Config Value
  */
  public static function set($key, $value)
  {
    self::$config[$key] = $value;
  }
}

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

/**
 * Skynet/EventListener/SkynetEventListenerAbstract.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener Abstract
  *
  * Base class for all Event Listeners
  * Every Event Listener must extends this class and implements [SkynetEventListenerInterface]
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
abstract class SkynetEventListenerAbstract
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var SkynetResponse Assigned response*/
  protected $response;

  /** @var SkynetRequest Assigned request */
  protected $request;

  /** @var string[] Array of indexed responses */
  protected $responseData;

  /** @var string[] Array of indexed requests */
  protected $requestsData;

  /** @var bool Status of database connection */
  protected $db_connected = false;

  /** @var bool Status of table schema in database, true if all tables exists */
  protected $db_created = false;

  /** @var string Url of receiver */
  protected $receiverClusterUrl;
  
  /** @var string Url of sender */
  protected $senderClusterUrl;

  /** @var PDO PDO connection instance */
  protected $db;

  /** @var bool Is sender or receiver */
  protected $sender = true;

  /** @var string Context of call - sender or cluster */
  protected $mode;

  /** @var string My cluster URL */
  protected $myAddress;

  /** @var string URL of sender */
  protected $senderAddress;

  /** @var integer Connection Number/ID */
  protected $connId;

  /** @var SkynetVerifier SkynetVerifier instance */
  protected $verifier;
  
  /** @var SkynetParams Params Operations */
  protected $paramsParser;
  
  /** @var SkynetAuth Authentication */
  protected $auth;
  
  /** @var SkynetOptions Options registry */
  protected $options;
  
  /** @var SkynetRegistry Registry */
  protected $registry;
  
  /** @var SkynetCli CLI Console */
  protected $cli;
  
  /** @var SkynetConsole HTML Console */
  protected $console;
  
  /** @var SkynetDebug Debugger */
  protected $debug;
  
  /** @var string[] Monits */
  protected $monits = [];
  
  /** @var string Event */
  protected $eventName;
  
  /** @var string Context */
  protected $context;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->loadErrorsRegistry();
    $this->loadStatesRegistry();
    $this->auth = new SkynetAuth();
    $dbInstance = SkynetDatabase::getInstance();
    $this->db_connected = $dbInstance->isDbConnected();
    $this->db_created = $dbInstance->isDbCreated();
    $this->db = $dbInstance->getDB();
    $this->myAddress = SkynetHelper::getMyUrl();
    $this->verifier = new SkynetVerifier();
    $this->paramsParser = new SkynetParams();
    $this->options = new SkynetOptions();
    $this->registry = new SkynetRegistry();
    $this->debug = new SkynetDebug();
  }

 /**
  * Adds monit
  *
  * @param string $mode
  */
  public function addMonit($monit)
  {
    $tmpMonit = $monit;
    if(is_array($monit))
    {
      $tmpMonit = implode('<br>', $monit);
    }
    $this->monits[] = $tmpMonit;
  }
  
 /**
  * Sets event name
  *
  * @param string $event
  */
  public function setEventName($event)
  {
      $this->eventName = $event;
  }
 
 /**
  * Sets context
  *
  * @param string $context
  */
  public function setContext($context)
  {
      $this->context = $context;
  }
  
 /**
  * Sets context - sender or cluster
  *
  * @param string $mode
  */
  public function setMode($mode)
  {
      $this->mode = $mode;
  }

 /**
  * Sets actual connection number/id
  *
  * @param integer $id
  */
  public function setConnId($id)
  {
    $this->connId = $id;
    $this->stateId = $id;
  }

 /**
  * Assigns response data array
  *
  * @param string[] $data
  */
  public function setResponseData($data)
  {
    $this->responseData = $data;
  }

 /**
  * Assigns request data array
  *
  * @param string[] $data
  */
  public function setRequestData($data)
  {
    $this->requestsData = $data;
  }

 /**
  * Assigns $response object to Skynet
  *
  * @param SkynetResponse $response
  */
  public function assignResponse(SkynetResponse $response)
  {
    $this->response = $response;
    $this->responseData = $this->response->getResponseData();
  }

 /**
  * Assigns $request object to Skynet
  *
  * @param SkynetRequest $request
  */
  public function assignRequest(SkynetRequest $request)
  {
     $this->request = $request;
     $this->requestsData = $this->request->getRequestsData();
  }

 /**
  * Sets URL address of cluster witch Skynet sending to
  *
  * @param string $url
  */
  public function setReceiverClusterUrl($url)
  {
    $this->receiverClusterUrl = SkynetHelper::cleanUrl($url);
  }

 /**
  * Sets URL address of sender cluster 
  *
  * @param string $url
  */
  public function setSenderClusterUrl($url)
  {
    $this->senderClusterUrl = SkynetHelper::cleanUrl($url);
  }
  
 /**
  * Sets if I'm sender
  *
  * @param bool $isSender
  */
  public function setSender($isSender)
  {
    $this->sender = $isSender;
  }
 
 /**
  * Returns packed params (alias)
  *
  * @param mixed[] $params Params array
  */ 
  protected function packParams($params)
  {   
    return $this->paramsParser->packParams($params);
  }
 
 /**
  * Returns unpacked params (alias)
  *
  * @param mixed $params Packed params string
  */   
  protected function unpackParams($params)
  {
    return $this->paramsParser->unpackParams($params);
  }
  
 /**
  * Checks for params is packed (alias)
  *
  * @param bool True if packed
  */   
  protected function isPacked($params)
  {
    return $this->paramsParser->isPacked($params);
  }

 /**
  * Gets Registry value
  *
  * @param string $key Key
  *
  * @return mixed Value
  */    
  protected function reg_get($key)
  {
    return $this->registry->getRegistryValue($key);
  } 

 /**
  * Updates Registry value
  *
  * @param string $key Key
  * @param string $value value
  *
  * @return bool
  */  
  protected function reg_set($key, $value)
  {
    return $this->registry->setRegistryValue($key, $value);
  }
  
 /**
  * Gets Option value
  *
  * @param string $key Key
  *
  * @return mixed Value
  */    
  protected function opt_get($key)
  {
    return $this->options->getOptionsValue($key);
  } 

 /**
  * Updates Option  value
  *
  * @param string $key Key
  * @param string $value value
  *
  * @return bool
  */  
  protected function opt_set($key, $value)
  {
    return $this->options->setOptionsValue($key, $value);
  }
  
 /**
  * Assigns CLI
  *
  * @param SkynetCli $cli
  */
  public function assignCli(SkynetCli $cli)
  {
     $this->cli = $cli;
  }
  
 /**
  * Assigns Console
  *
  * @param SkynetConsole $console
  */
  public function assignConsole(SkynetConsole $console)
  {
     $this->console = $console;
  }
 
 /**
  * Resets monits
  */
  public function resetMonits()
  {
    $this->monits = [];
  }
  
 /**
  * Adds log
  *
  * @param string $content Log message
  *
  * @return bool True if success
  */
  public function addLog($content = '')
  {
    $loggerDb = new SkynetEventListenerLoggerDatabase();
    $loggerDb->setSenderClusterUrl($this->senderClusterUrl);
    $loggerDb->setReceiverClusterUrl($this->receiverClusterUrl);
    
    $loggerTxt = new SkynetEventListenerLoggerFiles();
    $loggerTxt->setSenderClusterUrl($this->senderClusterUrl);
    $loggerTxt->setReceiverClusterUrl($this->receiverClusterUrl);
    
    $argsStr = '';
    $file = '';
    $line = '';   
    $method = '';
    $args = [];
    
    $success = false;
    
    $listener = pathinfo(@debug_backtrace()[0]['file'], PATHINFO_FILENAME); 
    $line = @debug_backtrace()[0]['line'];    
    $method = @debug_backtrace()[1]['function']; 
    $args = @debug_backtrace()[1]['args'];     
   
    $argsAry = [];
    if(is_array($args) && count($args) > 0)
    {
      foreach($args as $arg)
      {
        if(is_array($arg))
        {
          $argsAry[] = implode(':', $arg);
        } elseif(is_object($arg))
        {
          $argsAry[] = get_class($arg);
        } else {
          $argsAry[] = $arg;
        }
      }      
      $argsStr = implode(',', $argsAry);
    }
    
    $eventStr = $this->eventName.'('.$this->context.')';
    $methodStr = $method.'('.$argsStr.')';   
    
    if($loggerDb->saveUserLogToDb($content, $listener, $line, $eventStr, $methodStr))
    {
      $success = true;
    }
    
    if($loggerTxt->saveUserLogToFile($content, $listener, $line, $eventStr, $methodStr))
    {
      $success = true;
    }
    
    return $success;
  }
  
  /**
  * Returns monits
  *
  * @return string[] Monits
  */
  public function getMonits()
  {
    return $this->monits;
  }
}

/**
 * Skynet/Renderer/SkynetRendererAbstract.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer Base
  *
  * Assigns data to renderers
  */
abstract class SkynetRendererAbstract
{   
  /** @var SkynetField[] Custom data fields */
  protected $fields = [];
  
  /** @var SkynetField[] States data fields */
  protected $statesFields = [];
  
  /** @var SkynetField[] Debug data fields */
  protected $debugFields = [];
  
  /** @var SkynetError[] Errors data fields */  
  protected $errorsFields = [];
  
  /** @var SkynetField[] Config data fields */
  protected $configFields = [];
  
  /** @var mixed[] Conenctions data fields */
  protected $connectionsData = [];  
    
  /** @var int Num of success connects */
  protected $connectionsCounter;
  
  /** @var string Current view mode (connections|database|...) */
  protected $mode;  
  
  /** @var SkynetCli Cli commands parser */ 
  protected $cli;
  
  /** @var string[] Output from listeners */
  protected $cliOutput = [];
  
  /** @var string[] Output from listeners */
  protected $consoleOutput = [];
  
  /** @var string[] Clusters debug data */
  protected $clustersData = [];
  
  /** @var int Connection Mode | 0 - idle, 1 - single, 2 - broadcast */
  protected $connectionMode = 0;
 
  /** @var string[] Monits */ 
  protected $monits = [];
  
  /** @var bool If true then ajax output */ 
  protected $inAjax = false;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->mode = 'connections';
    $this->cli = new SkynetCli();
    
        /* Switch View */
    if(!$this->cli->isCli())
    {
      if(isset($_REQUEST['_skynetView']) && !empty($_REQUEST['_skynetView']))
      {
        switch($_REQUEST['_skynetView'])
        {
          case 'connections':
            $this->mode = 'connections';
          break;
          
          case 'database':       
            $this->mode = 'database';
          break;          
        } 
      }
    } else {
      if($this->cli->isCommand('db'))
      {
        $this->mode = 'database';
      }
    }
  }   

 /**
  * Assigns data fields array to renderer
  *
  * @param mixed $key
  * @param mixed $value
  */
  public function addField($key, $value)
  {
    $this->fields[$key] = new SkynetField($key, $value);
  }
 
 /**
  * Assigns data fields array to renderer
  *
  * @param mixed[] $fields
  */
  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  
 /**
  * Sets num of connections
  *
  * @param int $num
  */    
  public function setConnectionsCounter($num)
  {
    $this->connectionsCounter = $num;
  }
  
 /**
  * Assigns conenctions debug data array to renderer
  *
  * @param mixed[] $data
  */
  public function addConnectionData($data)
  {
    $this->connectionsData[] = $data;
  }  
  
  
 /**
  * Assigns conenctions 
  *
  * @param mixed[] $data
  */
  public function setConnectionsData($data)
  {
    $this->connectionsData = $data;
  }  
  
 /**
  * Assignsclusters debug data array to renderer
  *
  * @param SkynetCluster[] $clusters
  */
  public function setClustersData($clusters)
  {
    $this->clustersData = $clusters;
  }

 /**
  * Assigns State data field to renderer
  *
  * @param mixed $key
  * @param mixed $value
  */  
  public function addStateField($key, $value)
  {
    $this->statesFields[] = new SkynetField($key, $value);
  }

  /**
  * Sets state fields
  *
  * @param mixed[] 
  */  
  public function setStatesFields($fields)
  {
    $this->statesFields = $fields;
  }
 
 /**
  * Assigns Debug data field to renderer
  *
  * @param mixed $key
  * @param mixed $value
  */  
  public function addDebugField($key, $value)
  {
    $this->debugFields[] = new SkynetField($key, $value);
  }

  /**
  * Sets debug fields
  *
  * @param mixed[] 
  */  
  public function setDebugFields($fields)
  {
    $this->debugFields = $fields;
  }
  
 /**
  * Assigns Error debug data field to renderer
  *
  * @param mixed $key
  * @param mixed $value
  * @param Exception $exception 
  */  
  public function addErrorField($key, $value, $exception = null)
  {
    $this->errorsFields[] = new SkynetField($key, array($value, $exception));
  }
  
 /**
  * Sets error fields
  *
  * @param mixed[] 
  */  
  public function setErrorsFields($fields)
  {
    $this->errorsFields = $fields;
  }

 /**
  * Assigns config data array to renderer
  *
  * @param mixed $key
  * @param mixed $value
  */  
  public function addConfigField($key, $value)
  {
    $this->configFields[] = new SkynetField($key, $value);
  }
 
 /**
  * Sets config fields
  *
  * @param mixed[] 
  */  
  public function setConfigFields($fields)
  {
    $this->configFields = $fields;
  }
 
 /**
  * Sets in ajax
  *
  * @param bool $ajax
  */  
  public function setInAjax($ajax)
  {
    $this->inAjax = $ajax;
  }
  
 /**
  * Adds monit
  *
  * @param string $msg
  */  
  public function addMonit($msg)
  {
    $this->monits[] = $msg;
  }
  
 /**
  * Adds monit
  *
  * @param string $msg
  */  
  public function setMonits($monits)
  {
    $this->monits = $monits;
  }
  
 /**
  * Sets view mode
  *
  * @param string $mode
  */
  public function setMode($mode)
  {
    $this->mode = $mode;
  }
  
 /**
  * Returns current view mode
  *
  * @return string
  */
  public function getMode()
  {
    return $this->mode;
  }
 
 /**
  * Sets connection mode
  *
  * @param int $mode
  */
  public function setConnectionMode($mode)
  {
    $this->connectionMode = $mode;
  }
  
 /**
  * Returns connection view mode
  *
  * @return int
  */
  public function getConnectionMode()
  {
    return $this->connectionMode;
  }
  
 /**
  * Sets cli listeners output data
  *
  * @param string $output
  */
  public function setCliOutput($output)
  {
    $this->cliOutput = $output;
  }
  
 /**
  * Sets console listeners output data
  *
  * @param string $output
  */
  public function setConsoleOutput($output)
  {
    $this->consoleOutput = $output;
  }
}

/**
 * Skynet/Connection/SkynetConnectionInterface.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Connection Interface
  *
  * Interface for connection adapters.
  * Every connection adapter must implements this interface and extends [SkynetConnectionAbstract] class.
  */
interface SkynetConnectionInterface
{
 /**
  * Must prepare params to send
  */
  public function prepareParams();

 /**
  * Must receive and returns raw response data from remote address
  *
  * @param string $url URL to connect
  */
  public function connect($url);
}

/**
 * Skynet/Encryptor/SkynetEncryptorInterface.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Encryptor Interface
  *
  * Interface for custom encryption classes. You can use your own algorithms for encrypting data sending and receiving by Skynet.
  * Every encryption class must implements this interface.
  */
interface SkynetEncryptorInterface
{
 /**
  * Encrypts data
  *
  * @param string $str Data to encrypt
  *
  * @return string Encrypted data
  */
  public static function encrypt($str);

 /**
  * Decrypts data
  *
  * @param string $str Data to decrypt
  *
  * @return string Decrypted data
  */
  public static function decrypt($str);
}

/**
 * Skynet/EventListener/SkynetEventListenerInterface.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener Interface
  *
  * Interface for all Event Listeners in Skynet
  */
interface SkynetEventListenerInterface
{
 /**
  * Constructor
  *
  * Every constructor in Event Listeners must call parent constructor from [SkynetEventListenerAbstract]
  */
  public function __construct();

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn);

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context);

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context);

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context);

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context);  
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli();

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole();  
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands();
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerDatabase();
}

/**
 * Skynet/Renderer/SkynetRendererInterface.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer Interface
  *
  * Interface for custom renderer classes. 
  */
interface SkynetRendererInterface
{
 /**
  * Returns rendered data
  *
  * @return string output
  */
  public function render();
}

/**
 * Skynet/Error/SkynetErrorsTrait.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Errors Trait
  *
  * Trait for creating error messages
  */
trait SkynetErrorsTrait
{
  /** @var SkynetError[] Array of errors */
  protected $errors = [];

  /** @var SkynetErrorsRegistry Errors global registry */
  protected $errorsRegistry;

 /**
  * Loads errors registry
  *
  * @return SkynetErrorsRegistry
  */
  protected function loadErrorsRegistry()
  {
    if($this->errorsRegistry === null) 
    {
      $this->errorsRegistry = SkynetErrorsRegistry::getInstance();
    }
  }

 /**
  * Adds error to registry
  *
  * @param mixed $code
  * @param string $msg
  * @param \Exception|null $e
  */
  protected function addError($code, $msg, \Exception $e = null)
  {
    $error = new SkynetError($code, $msg, $e);
    
    $data = $code.': '.$msg;
    if($e !== null && SkynetConfig::get('logs_errors_with_full_trace'))
    {
      $data = $msg.' { File:'.$e->getFile().' | Line:'.$e->getLine().' | Trace:'.$e->getTraceAsString().' }';
    }        
    $this->loadErrorsRegistry();
    $this->errorsRegistry->addError($error);
    if(SkynetConfig::get('logs_txt_errors'))
    {
      $this->saveErrorInLogFile($data);
    }
    if(SkynetConfig::get('logs_db_errors'))
    {
      $this->saveErrorInDb($data);   
    }      
  }

 /**
  * Returns stored errors as array
  *
  * @return string[]
  */
  protected function getErrors()
  {
     $this->loadErrorsRegistry();
     $this->errorsRegistry->getErrors();
  }

 /**
  * Checks for errors exists in registry
  *
  * @return bool True if are errors
  */
  protected function areErrors()
  {
     $this->loadErrorsRegistry();
     if(count($this->errorsRegistry->getErrors()) > 0) 
     {
       return true;
     }
  }

 /**
  * Dump errors array
  *
  * @return string
  */
  protected function dumpErrors()
  {
    $str = '';
    if(count($this->errorsRegistry->getErrors()) > 0) 
    {
      $str = 'ERRORS:<br/>'.implode('<br/>', $this->errorsRegistry->getErrors());
    }
    return $str;
  }
 
 /**
  * Save error in file
  *
  * @param string $msg Error message 
  *
  * @return bool
  */ 
  private function saveErrorInLogFile($msg)
  {
    $fileName = 'errors';
    $logFile = new SkynetLogFile('ERRORS');
    $logFile->setFileName($fileName);
    $logFile->setTimePrefix(false);
    $logFile->setHeader("#ERRORS:");    
    $time_prefix = '@'.date('H:i:s d.m.Y').' ['.time().']: ';
    $logFile->addLine($time_prefix.$msg);    
    return $logFile->save('after');
  }
 
 /**
  * Save error in database
  *
  * @param string $msg Error message 
  *
  * @return bool
  */  
  private function saveErrorInDb($msg)
  {
    $db = SkynetDatabase::getInstance()->getDB();
    
    try
    {
      $stmt = $db->prepare(
        'INSERT INTO skynet_errors (skynet_id, created_at, content, remote_ip)
        VALUES(:skynet_id, :created_at, :content, :remote_ip)'
        );
      $time = time();
      $remote_ip = '';
      if(isset($_SERVER['REMOTE_ADDR']))
      {
        $remote_ip = $_SERVER['REMOTE_ADDR'];
      }
      $skynet_id = SkynetConfig::KEY_ID;
      $stmt->bindParam(':skynet_id', $skynet_id, \PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $time, \PDO::PARAM_INT);
      $stmt->bindParam(':content', $msg, \PDO::PARAM_STR);
      $stmt->bindParam(':remote_ip', $remote_ip, \PDO::PARAM_STR);
      if($stmt->execute())
      {
        return true;
      }    
    } catch(\PDOException $e)  { /* End of The World. Error when saving info about error... :/ */ }
  }
}

/**
 * Skynet/State/SkynetStatesTrait.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet State Trait
  *
  * Trait for handle states
  */
trait SkynetStatesTrait
{
  /** @var SkynetState[] States collection */
  private $states = [];

  /** @var SkynetStatesRegistry Global states registry */
  protected $statesRegistry;

  /** @var integer Current connection ID */
  private $stateId;

 /**
  * Loads states registry
  */
  protected function loadStatesRegistry()
  {
    if($this->statesRegistry == null) $this->statesRegistry = SkynetStatesRegistry::getInstance();
  }

 /**
  * Sets global statesID
  *
  * @param integer $id
  */
  public function setStateId($id)
  {
    $this->stateId = $id;
  }

 /**
  * Adds state to registry
  *
  * @param mixed $code
  * @param string $message
  */
  protected function addState($code, $message)
  {
     $this->loadStatesRegistry();
     $state = new SkynetState($code, $message);
     $state->setStateId($this->stateId);
     $this->statesRegistry->addState($state);
  }

 /**
  * Returns stored states
  *
  * @return SkynetState[]
  */
  protected function getStates()
  {
    $this->loadStatesRegistry();
    return $this->statesRegistry->getStates();
  }

 /**
  * Returns state as string
  *
  * @return string
  */
  protected function dumpState()
  {
    $str = '';
    foreach($this->states as $state)
    {
      $str.= $state->getCode().': '.$state->getMsg().'<br/>';
    }
    return $str;
  }
}

/**
 * Skynet/SkynetEventListenerMyListener.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Your custom event listener - see documentation for API Reference
  *
  * Custom listener
  */
class SkynetEventListenerMyListener extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
    
    /*
    Most important API for your disponce, see more in documentation:
    
      $this->request -- Request object
      $this->response -- Response object
      
      $this->request->get(<key>)  -- gets request value
      $this->request->set(<key>, <value>)  -- sets request value
      
      $this->response->get(<key>)  -- gets response value
      $this->response->set(<key>, <value>)  -- sets response value
      
    */
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  
  {   
    /* code executed after connection to cluster */  
  }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
        /* code executed in sender before creating request */  
    }
    
    if($context == 'afterReceive')
    {
        /* code executed in responder after received request */  
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
        /* code executed in sender after received response */  
    }

    if($context == 'beforeSend')
    {      
        /* code executed in responder before create response for request */  
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      /* code executed in responder when creating response for requested @broadcast */  
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      /* code executed in responder when creating response for requested @echo */  
    }    
  }  
   
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }     
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = []; 
    
    return array('cli' => $cli, 'console' => $console);    
  }  
      
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
}

/**
 * Skynet/Cluster/SkynetCluster.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Cluster Data
  *
  * Stores informations about cluster
  */
class SkynetCluster
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var integer ID in database */
  private $id;

  /** @var string SkynetID of cluster */
  private $skynet_id;

  /** @var string Cluster URL */
  private $url;

  /** @var integer Last connection with cluster */
  private $last_connect;

  /** @var integer Actual chain value */
  private $chain;

  /** @var string Cluster IP */
  private $ip;

  /** @var string Cluter version */
  private $version;

  /** @var string Cluster registrator (another cluster witch sends data) */
  private $registrator;

  /** @var SkynetClusterHeader Cluster header */
  private $header;
  
  public $test;  

 /**
  * Constructor
  */
  public function __construct()
  {
    if(isset($_SERVER['SERVER_ADDR']))
    {
      $this->ip = $_SERVER['SERVER_ADDR'];
    }
    $this->last_connect = time();
    $this->header = new SkynetClusterHeader();
  }

 /**
  * Sets header connection ID if exists
  */  
  private function setHeaderStateId()
  {
    if($this->stateId !== null) 
    {
      $this->header->setStateId($this->stateId);
    }     
  }
  
 /**
  * Connects to remote cluster and get it's header
  *
  * @return string Raw remote data
  */
  public function fromConnect()
  {
    if($this->url !== null)
    {  
      $this->setHeaderStateId();        
      return $this->header->fromConnect($this->url);
    }
  }

 /**
  * Gets remote cluster header saved in responce object
  *
  * @param SkynetResponse $response Response instance
  */
  public function fromResponse(SkynetResponse $response)
  {
    if($response !== null)
    { 
       $this->setHeaderStateId();        
       $this->header->fromResponse($response);       
    }
  }

 /**
  * Gets remote cluster header saved in request object
  *
  * @param SkynetRequest $request Request instance
  */
  public function fromRequest(SkynetRequest $request)
  {
    if($request !== null)
    {
       $this->setHeaderStateId();      
       $this->header->fromRequest($request);
    }
  }

 /**
  * Sets skynet ID
  *
  * @param integer $id SkynetID
  */
  public function setId($id)
  {
    $this->id = $id;
  }

 /**
  * Sets skynet ID
  *
  * @param integer $id SkynetID
  */
  public function setSkynetId($id)
  {
    $this->id = $id;
  }

 /**
  * Sets cluster URL
  *
  * @param integer $url Cluster URL
  */
  public function setUrl($url)
  {
    $this->url = $url;
    $this->header->setUrl($url);
  }
  
 /**
  * Sets time of last connection
  *
  * @param integer $last_connect Unix time format
  */
  public function setLastConnect($last_connect)
  {
    $this->last_connect = $last_connect;
  }

 /**
  * Sets Chain value
  *
  * @param integer $chain Chain value
  */
  public function setChain($chain)
  {
    $this->chain = $chain;
  }

 /**
  * Sets ip address
  *
  * @param string $ip IP Address
  */
  public function setIp($ip)
  {
    $this->ip = $ip;
  }
  
 /**
  * Sets skynet's version
  *
  * @param string $version Version
  */
  public function setVersion($version)
  {
    $this->version = $version;
  }

   /**
  * Sets registrator (other cluster witch was send info about this cluster
  *
  * @param string $registrator Cluster's URL
  */
  public function setRegistrator($registrator)
  {
    $this->registrator = $registrator;
  }

 /**
  * Sets cluster header
  *
  * @param SkynetClusterHeader $header Cluster Header
  */
  public function setHeader(SkynetClusterHeader $header)
  {
    $this->header = $header;
  }

 /**
  * Returns ID in database
  *
  * @return integer
  */
  public function getId()
  {
    return $this->id;
  }

 /**
  * Returns skynet ID/key
  *
  * @return string
  */
  public function getSkynetId()
  {
    return $this->id;
  }

 /**
  * Returns cluster's URL
  *
  * @return string
  */
  public function getUrl()
  {
    return $this->url;
  }

 /**
  * Returns time of latest update in database
  *
  * @return integer Unix time format
  */
  public function getLastConnect()
  {
    return $this->last_connect;
  }

 /**
  * Returns actual chain value
  *
  * @return integer
  */
  public function getChain()
  {
    return $this->chain;
  }

 /**
  * Returns cluster's IP
  *
  * @return string
  */
  public function getIp()
  {
    return $this->ip;
  }

 /**
  * Returns skynet's version
  *
  * @return string
  */
  public function getVersion()
  {
    return $this->version;
  }

 /**
  * Returns registrator cluster URL
  *
  * @return string
  */
  public function getRegistrator()
  {
    return $this->registrator;
  }

 /**
  * Returns cluster header
  *
  * @return SkynetClusterHeader
  */
  public function getHeader()
  {    
    return $this->header;
  }
  
 /**
  * Returns cluster header (alias)
  *
  * @return SkynetClusterHeader
  */
  public function header()
  {
    return $this->header;
  }
}

/**
 * Skynet/Cluster/SkynetClusterHeader.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Cluster Header Data
  *
  * Stores cluster header
  */
class SkynetClusterHeader
{
  use SkynetStatesTrait, SkynetErrorsTrait;

  /** @var integer Actual value of chain */
  private $chain;

  /** @var string Cluster skynetID*/
  private $id;

  /** @var string Cluster URL */
  private $url;

  /** @var string Cluster IP address */
  private $ip;

  /** @var string Skynet version */
  private $version;

  /** @var integer Skynet param */
  private $skynet;

  /** @var string Chain with clusters from database */
  private $clusters;

  /** @var integer Time of last update in database */
  private $updated_at;

  /** @var SkynetEncryptorInterface Encryptor instance */
  private $encryptor;

  /** @var SkynetVerifier Verifier instance */
  private $verifier;

  /** @var string[] Exploded list of clusters URLs from chain */
  private $clustersList = [];

  /** @var SkynetConnectionInterface Connector instance */
  private $connection;
  
  private $ping = 0;  
    
  private $result = 0;
  
  private $connId = 0;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->connection = SkynetConnectionsFactory::getInstance()->getConnector(SkynetConfig::get('core_connection_type'));
    $this->encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $this->verifier = new SkynetVerifier();
  }

 /**
  * Encrypts data with encryptor
  *
  * @param string $str String to be encrypted
  *
  * @return string Encrypted data
  */
  private function encrypt($str)
  {
    if(!SkynetConfig::get('core_raw'))
    {
      return $this->encryptor->encrypt($str);
    } else {
      return $str;
    }
  }

 /**
  * Decrypts data with encryptor
  *
  * @param string $str String to be decrypted
  *
  * @return string Decrypted data
  */
  private function decrypt($str)
  {
    if(!SkynetConfig::get('core_raw'))
    {
      return $this->encryptor->decrypt($str);
    } else {
      return $str;
    }
  }

 /**
  * Generates and fills header data
  */
  public function generate()
  {
    $skynetChain = new SkynetChain();
    $chainData = $skynetChain->loadChain();

    $this->skynet = 1;
    $this->chain = $chainData['chain'];
    $this->updated_at = $chainData['updated_at'];
    $this->id = $this->verifier->getKeyHashed();
    $this->url = SkynetHelper::getMyUrl();
    if(isset($_SERVER['SERVER_ADDR']))
    {
      $this->ip = $_SERVER['SERVER_ADDR'];
    }
    $this->version = SkynetVersion::VERSION;
    $this->clusters = '';
  }

 /**
  * Fills header data from remote address
  *
  * Method connects to remote cluster and gets cluster header from connection
  *
  * @param string $address Remote Cluster URL
  *
  * @return string[] Array with raw received data and params
  */
  public function fromConnect($address = null)
  {
    if($address === null)
    {
       $this->addState(SkynetTypes::HEADER, 'CLUSTER ADDRESS IS NOT SET');
       return false;
    }
    
    $address = SkynetConfig::get('core_connection_protocol').$address;
    if($this->stateId !== null) 
    {
      $this->connection->setStateId($this->stateId);
    }

    $ary = [];
    $key = $this->verifier->getKeyHashed();

    $ary['_skynet_hash'] = $this->verifier->generateHash();
    $ary['_skynet_chain_request'] = '1';
    $ary['_skynet_id'] = $key;

    if(!SkynetConfig::get('core_raw'))
    {
      $ary['_skynet_hash'] = $this->encryptor->encrypt($ary['_skynet_hash']);
      $ary['_skynet_chain_request'] = $this->encryptor->encrypt($ary['_skynet_chain_request']);
      $ary['_skynet_id'] = $this->encryptor->encrypt($key);
    }

    $this->connection->setRequests($ary);
    
    try
    {
      /* Try to connect to get header data */
      $adapter = $this->connection->connect($address);
      $data = $adapter['data'];
    
      if($data === null || empty($data))
      {
        throw new SkynetException('CLUSTER HEADER IS NULL: '.$address);
      }
      
      /* Decode received header */
      $remoteHeader = json_decode($data);
      
    } catch(SkynetException $e)
    {
      $this->addState(SkynetTypes::HEADER, 'CLUSTER HEADER IS NULL');
      $this->addError(SkynetTypes::HEADER, $e->getMessage(), $e);
    }

    /* Assign received header data */
    if(isset($remoteHeader->_skynet_chain)) 
    {
      $this->chain = (int)$this->decrypt($remoteHeader->_skynet_chain);
    }
    
    if(isset($remoteHeader->_skynet_chain_updated_at)) 
    {
      $this->updated_at = $this->decrypt($remoteHeader->_skynet_chain_updated_at);
    }
    
    if(isset($remoteHeader->_skynet_id)) 
    {
      $this->id = $this->decrypt($remoteHeader->_skynet_id);
    }
    
    if(isset($remoteHeader->_skynet_cluster_url)) 
    {
      $this->url = $this->decrypt($remoteHeader->_skynet_cluster_url);
    }
    
    if(isset($remoteHeader->_skynet_cluster_ip)) 
    {
      $this->ip = $this->decrypt($remoteHeader->_skynet_cluster_ip);
    }
    
    if(isset($remoteHeader->_skynet_version)) 
    {
      $this->version = $this->decrypt($remoteHeader->_skynet_version);
    }
    
    if(isset($remoteHeader->_skynet_clusters)) 
    {
      $this->clusters = $this->decrypt($remoteHeader->_skynet_clusters);
    }
    
    if(isset($remoteHeader->_skynet_ping)) 
    {
      $this->ping = round(microtime(true) * 1000) - $this->decrypt($remoteHeader->_skynet_ping);
    }

    /* For debug, return received data */
    return $adapter;
  }

 /**
  * Fills header data from response object
  *
  * @param SkynetResponse $response
  */
  public function fromResponse(SkynetResponse $response)
  {
    $data = $response->getResponseData();
    
    if(isset($data['_skynet_chain'])) 
    {
      $this->chain = (int)$data['_skynet_chain'];
    }
    
    if(isset($data['_skynet_chain_updated_at'])) 
    {
      $this->updated_at = $data['_skynet_chain_updated_at'];
    }
    
    if(isset($data['_skynet_id'])) 
    {
      $this->id = $data['_skynet_id'];
    }
    
    if(isset($data['_skynet_cluster_url'])) 
    {
      $this->url = $data['_skynet_cluster_url'];
    }
    
    if(isset($data['_skynet_cluster_ip'])) 
    {
      $this->ip = $data['_skynet_cluster_ip'];
    }
    
    if(isset($data['_skynet_version'])) 
    {
      $this->version = $data['_skynet_version'];
    }
    
    if(isset($data['_skynet_clusters'])) 
    {      
      $this->clusters = $data['_skynet_clusters'];   
    }
    
    if(isset($data['_skynet_ping'])) 
    {      
      $this->ping = round(microtime(true) * 1000) - $data['_skynet_ping'];   
    }
  }

 /**
  * Generates header data from response object
  *
  * @param SkynetRequest $request
  */
  public function fromRequest(SkynetRequest $request)
  {
    $data = $request->getRequestsData();
    
    if(isset($data['_skynet_chain'])) 
    {
      $this->chain = (int)$data['_skynet_chain'];
    }
    
    if(isset($data['_skynet_chain_updated_at'])) 
    {
      $this->updated_at = $data['_skynet_chain_updated_at'];
    }    
    
    if(isset($data['_skynet_id'])) 
    {
      $this->id = $data['_skynet_id'];
    }
    
    if(isset($data['_skynet_cluster_url'])) 
    {
      $this->url = $data['_skynet_cluster_url'];      
    }
    
    if(isset($data['_skynet_cluster_ip'])) 
    {
      $this->ip = $data['_skynet_cluster_ip'];
    }
    
    if(isset($data['_skynet_version'])) 
    {
      $this->version = $data['_skynet_version'];
    }
    
    if(isset($data['_skynet_clusters'])) 
    {
      $this->clusters = $data['_skynet_clusters'];
    }
    
    if(isset($data['_skynet_ping'])) 
    {      
      $this->ping = round(microtime(true) * 1000) - $data['_skynet_ping'];   
    }
  }

 /**
  * Returns chain value
  *
  * @return integer
  */
  public function getChain()
  {
    return $this->chain;
  }

 /**
  * Returns SkynetID/key
  *
  * @return string
  */
  public function getId()
  {
    return $this->id;
  }
  
 /**
  * Returns Result
  *
  * @return int
  */
  public function getResult()
  {
    return $this->result;
  }

 /**
  * Returns cluster URL
  *
  * @return string
  */
  public function getUrl()
  {
    return $this->url;
  }

 /**
  * Returns cluster IP
  *
  * @return string
  */
  public function getIp()
  {
    return $this->ip;
  }

 /**
  * Returns cluster Skynet version
  *
  * @return string
  */
  public function getVersion()
  {
    return $this->version;
  }

 /**
  * Returns clusters chain
  *
  * @return string Base64 encoded addresses, separated by ";"
  */
  public function getClusters()
  {
    return $this->clusters;
  }

 /**
  * Returns time of last update in database
  *
  * @return integer Unix time format
  */
  public function getUpdatedAt()
  {
    return $this->updated_at;
  }

 /**
  * Returns conn Id
  *
  * @return string[]
  */
  public function getConnId()
  {
    return $this->connId;
  }
  
 /**
  * Returns clusters urls array
  *
  * @return string[]
  */
  public function getClustersList()
  {
    return $this->clusterList;
  }

 /**
  * Gets ping
  */
  public function getPing()
  { 
    return $this->ping;
  }
  
 /**
  * Sets chain value
  *
  * @param integer $chain
  */
  public function setChain($chain)
  {
    $this->chain = $chain;
  }

 /**
  * Sets result
  *
  * @param int $result
  */
  public function setResult($result)
  {
    $this->result = $result;
  }
  
 /**
  * Sets connect id
  *
  * @param int $result
  */
  public function setConnId($connId)
  {
    $this->connId = $connId;
  }
  
 /**
  * Sets skynetID/key
  *
  * @param string $id
  */
  public function setId($id)
  {
    $this->id = $id;
  }

 /**
  * Sets cluster URL
  *
  * @param string $url
  */
  public function setUrl($url)
  {
    $this->url = $url;
  }
  
 /**
  * Sets cluster IP
  *
  * @param string $ip
  */
  public function setIp($ip)
  {
    $this->ip = $ip;
  }
  
 /**
  * Sets cluster's Skynet version
  *
  * @param string $version
  */
  public function setVersion($version)
  {
    $this->version = $version;
  }

 /**
  * Sets clusters URLs chain
  *
  * @param string[] $clusters Base64 encoded chain, clusters separated by ";"
  */
  public function setClusters($clusters)
  {
    $this->clusters = $clusters;
  }

 /**
  * Sets updat time
  *
  * @param integer $updated_at Unix time format
  */
  public function setUpdatedAt($updated_at)
  {
    $this->updated_at = $updated_at;
  }

 /**
  * Sets clusters list array
  *
  * @param string[] $clustersList
  */
  public function setClustersList($clustersList)
  {
    $this->clustersList = $clustersList;
  }
}

/**
 * Skynet/Cluster/SkynetClustersRegistry.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Clusters Database Operations
  *
  * Manipulate clusters saved in database
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetClustersRegistry
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var bool Status od database connection */
  protected $db_connected = false;

  /** @var bool Status of tables schema */
  protected $db_created = false;

  /** @var string URL od receiver */
  protected $receiverClusterUrl;

  /** @var string[] Array of received remote data from cluster */
  protected $remoteData = [];

  /** @var PDO PDO connection instance */
  protected $db;

  /** @var SkynetClusterHeader SkynetClusterHeader instance */
  private $clusterHeader;

  /** @var SkynetCluster Actual cluster entity */
  private $cluster;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var string[] Monits */
  private $monits = [];
  
  /** @var string Registrator */
  private $registrator;

 /**
  * Constructor
  */
  public function __construct()
  {
    $dbInstance = SkynetDatabase::getInstance();
    $this->db_connected = $dbInstance->isDbConnected();
    $this->db_created = $dbInstance->isDbCreated();
    $this->db = $dbInstance->getDB();
    $this->verifier = new SkynetVerifier();
    
    $this->registrator = SkynetHelper::getMyUrl();
  }

 /**
  * Sets cluster header
  *
  * @param SkynetClusterHeader $header
  */
  public function setClusterHeader(SkynetClusterHeader $header)
  {
    $this->clusterHeader = $header;
  }

 /**
  * Sets cluster entity
  *
  * @param SkynetCluster $cluster
  */
  public function setCluster(SkynetCluster $cluster)
  {
    $this->cluster = $cluster;
  }

 /**
  * Returns cluster header
  *
  * @return SkynetClusterHeader
  */
  public function getClusterHeader()
  {
    return $this->cluster->getHeader();
  }

 /**
  * Returns cluster entity
  *
  * @return SkynetCluster
  */
  public function getCluster()
  {
    return $this->cluster;
  }

 /**
  * Sets array with remote data
  *
  * @param string[] $data
  */
  public function setRemoteData($data)
  {
    $this->remoteData = $data;
  }

 /**
  * Adds cluster into database
  *
  * @param SkynetCluster $cluster
  *
  * @return bool
  */  
  public function add(SkynetCluster $cluster = null)
  {    
    $this->registrator = SkynetHelper::getMyUrl();
    
    if($cluster === null)
    {
        return false;
    }
    
    /* Update via remote list from urls chain */
    if(SkynetConfig::get('core_urls_chain') && $cluster->getHeader() !== null  && !empty($cluster->getHeader()->getClusters()))
    {
      $this->updateFromHeader($cluster);
    }  
    
    if($this->isCluster($cluster))
    {
      $this->update($cluster);
      
    } else {
      
      if(!$this->isClusterBlocked($cluster))
      {        
        if($this->insert($cluster))
        {          
          return true;
        }
      }
    }    
  }  

 /**
  * Adds cluster into database
  *
  * @param SkynetCluster $cluster
  *
  * @return bool
  */  
  public function addBlocked(SkynetCluster $cluster = null)
  {
    /* Update from remote list from header */
    if($cluster === null)
    {
      return false;
    }   
    if(!$this->isClusterBlocked($cluster))
    {     
      if($this->insertBlocked($cluster))
      {        
        return true;
      }
    }
  }    
  
 /**
  * Returns number of clusters in database
  * 
  * @return int
  */  
  public function countClusters()
  {
    $counter = 0;
    try
    {
      $stmt = $this->db->query(
        'SELECT count(*) as c FROM skynet_clusters');     
      $stmt->execute();
      $row = $stmt->fetch();
      $counter = $row['c'];
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting records from database table: clusters failed', $e);
      return false;
    }    
    return $counter;   
  }

 /**
  * Returns number of blocked clusters in database
  * 
  * @return int
  */  
  public function countBlockedClusters()
  {
    $counter = 0;
    try
    {
      $stmt = $this->db->query(
        'SELECT count(*) as c FROM skynet_clusters_blocked');     
      $stmt->execute();
      $row = $stmt->fetch();
      $counter = $row['c'];
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting records from database table: clusters_blocked failed', $e);
      return false;
    }    
    return $counter;   
  }
  
 /**
  * Parse clusters from database into clusters chain
  *
  * @return string Chain with Base64 encoded urls
  */
  public function parseMyClusters()
  {
    $clusters = $this->getAll();
    $ary = [];
    $ret = '';
    if(count($clusters) > 0)
    {
      foreach($clusters as $cluster)
      {
        $ary[] = base64_encode($cluster->getUrl());
      }
      $ret = implode(';', $ary);
    }
    return $ret;
  }

 /**
  * Gets and returns clusters stored in database
  *
  * @return SkynetCluster[] Array of clusters
  */
  public function getAll()
  {
    $clusters = [];
    try
    {
      $stmt = $this->db->query(
      'SELECT * FROM skynet_clusters');

      while($row = $stmt->fetch())
      {
        $cluster = new SkynetCluster();
        $cluster->setId($row['id']);
        $cluster->setSkynetId($row['skynet_id']);
        $cluster->setUrl($row['url']);
        $cluster->setIp($row['ip']);
        $cluster->setVersion($row['version']);
        $cluster->setLastConnect($row['last_connect']);
        $cluster->setRegistrator($row['registrator']);
        $clusters[] = $cluster;
      }
      $stmt->closeCursor();
      return $clusters;
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
 /**
  * Checks for address exists
  *
  * @param string $url
  *
  * @return bool
  */ 
  public function addressExists($url)
  {
    $cluster = new SkynetCluster();
    $cluster->getHeader()->setUrl($url);
    if($this->isCluster($cluster))
    {
      return true;
    }    
  }

 /**
  * Checks for cluster exists in database
  *
  * @param SkynetCluster $cluster Cluster entity to check
  *
  * @return bool
  */
  public function isCluster(SkynetCluster $cluster = null)
  {   
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }    
    
    $url = SkynetHelper::cleanUrl($url);  
    
    try
    {
      $stmt = $this->db->prepare(
      'SELECT count(*) as c FROM skynet_clusters WHERE url = :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();

      $stmt->closeCursor();
      if($result['c'] > 0)
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Checks for cluster exists in database
  *
  * @param SkynetCluster $cluster Cluster entity to check
  *
  * @return bool
  */
  public function isClusterBlocked(SkynetCluster $cluster = null)
  {   
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }    
    
    $url = SkynetHelper::cleanUrl($url);
    
    try
    {
      $stmt = $this->db->prepare(
      'SELECT count(*) as c FROM skynet_clusters_blocked WHERE url = :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();

      $stmt->closeCursor();
      if($result['c'] > 0)
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
 /**
  * Updates cluster in database
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function update(SkynetCluster $cluster = null)
  {
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }

    $url = SkynetHelper::cleanUrl($url);
    
    /* dont do anything when only file name in url */
    if($url == SkynetHelper::getMyself() || strpos($url, '/') === false)
    {
      return false;
    }
    
    $last_connect = time();
    $id = '';
    $ip = '';
    $version = '';
    
    if($cluster->getHeader() !== null)
    {
      $id = $cluster->getHeader()->getId();
      $ip = $cluster->getHeader()->getIp();
      $version = $cluster->getHeader()->getVersion();
    }

    if($this->verifier->isMyKey($id))
    {
      $id = SkynetConfig::KEY_ID;
    }
      
    try
    {
      if(!empty($id))
      {
        $stmt = $this->db->prepare('UPDATE skynet_clusters SET skynet_id = :skynet_id, ip = :ip, version = :version, last_connect = :last_connect WHERE url = :url');
        $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':ip', $ip, \PDO::PARAM_STR);
        $stmt->bindParam(':version', $version, \PDO::PARAM_STR);
      } else {
        $stmt = $this->db->prepare('UPDATE skynet_clusters SET last_connect = :last_connect WHERE url = :url');
      }
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->bindParam(':last_connect', $last_connect, \PDO::PARAM_INT);

      if($stmt->execute())
      {
        //$this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] UPDATED IN DB');
        return true;
      } else {
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] NOT UPDATED IN DB');
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

  /**
  * Removes cluster from database
  *
  * @param string $url Not remove
  *
  * @return bool True if success
  */
  public function removeAll($url = null)
  {
    try
    {
      $url = SkynetHelper::cleanUrl($url);
      
      $this->removeAllBlocked($url);
      
      $stmt = $this->db->prepare(
      'DELETE FROM skynet_clusters WHERE url != :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }  
  
 /**
  * Removes cluster from blocked database
  *
  * @param string $url Not remove
  *
  * @return bool True if success
  */
  public function removeAllBlocked($url = null)
  {
    try
    {
      $url = SkynetHelper::cleanUrl($url);
      
      $stmt = $this->db->prepare(
      'DELETE FROM skynet_clusters_blocked WHERE url != :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  } 
  
 /**
  * Removes cluster from database
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function remove(SkynetCluster $cluster = null)
  {
    //$url = $this->cluster->getHeader()->getUrl();
    if($cluster !== null) 
    {
      $url = $cluster->getUrl();
      $url = SkynetHelper::cleanUrl($url);
    }   

    try
    {
      $stmt = $this->db->prepare(
      'DELETE FROM skynet_clusters WHERE url = :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        $this->monits[] = 'Clusters Registry: cluster removed from list: '.$url;
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
 /**
  * Removes cluster from blocked in database
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function removeBlocked(SkynetCluster $cluster = null)
  {    
    if($cluster !== null) 
    {
      $url = $cluster->getUrl();
      $url = SkynetHelper::cleanUrl($url);     
    }   

    try
    {
      $stmt = $this->db->prepare(
      'DELETE FROM skynet_clusters_blocked WHERE url = :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        $this->monits[] = 'Clusters Registry: cluster removed from blocked list: '.$url;
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Inserts cluster into database
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function insert(SkynetCluster $cluster = null)
  {
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }
    
    $url = SkynetHelper::cleanUrl($url);
    
    if(!$this->verifier->isAddressCorrect(SkynetConfig::get('core_connection_protocol').$url))
    {
      return false;
    }
    
    /* dont do anything when only file name in url */
    if($url == SkynetHelper::getMyUrl() || $url == SkynetHelper::getMyself() || strpos($url, '/') === false)
    {
      return false;
    }  
    
    try
    {      
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_clusters (skynet_id, url, ip, version, last_connect, registrator)
      VALUES(:skynet_id, :url,  :ip, :version, :last_connect, :registrator)'
      );

      $last_connect = time();
      
      $id = '';
      $ip = '';
      $version = '';     
      
      if($cluster->getHeader() !== null)
      {
        $id = $cluster->getHeader()->getId();
        $ip = $cluster->getHeader()->getIp();
        $version = $cluster->getHeader()->getVersion();
        $this->registrator = $cluster->getHeader()->getUrl();
      } 
      
      if($this->verifier->isMyKey($id))
      {
        $id = SkynetConfig::KEY_ID;
      }

      $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->bindParam(':ip', $ip, \PDO::PARAM_STR);
      $stmt->bindParam(':version', $version, \PDO::PARAM_STR);
      $stmt->bindParam(':last_connect', $last_connect, \PDO::PARAM_INT);
      $stmt->bindParam(':registrator', $this->registrator, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->monits[] = 'Clusters Registry: cluster added to list: '.SkynetHelper::cleanUrl($cluster->getUrl());
        if($this->isClusterBlocked($cluster))
        {     
          $this->removeBlocked($cluster);
        }
        
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] ADDED TO DB');
        return true;
      } else {
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] NOT ADDED TO DB');
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }  
 
 /**
  * Inserts cluster into blocked list
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function insertBlocked(SkynetCluster $cluster = null)
  {
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }
    
    $url = SkynetHelper::cleanUrl($url);
    
    /* dont do anything when only file name in url */
    if($url == SkynetHelper::getMyUrl() || $url == SkynetHelper::getMyself() || strpos($url, '/') === false)
    {
      return false;
    }  
    
    if(!$this->verifier->isAddressCorrect(SkynetConfig::get('core_connection_protocol').$url))
    {
      return false;
    }
    
    try
    {      
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_clusters_blocked (skynet_id, url, ip, version, last_connect, registrator)
      VALUES(:skynet_id, :url,  :ip, :version, :last_connect, :registrator)'
      );

      $last_connect = time();
      
      $id = '';
      $ip = '';
      $version = '';
           
      if($cluster->getHeader() !== null)
      {
        $id = $cluster->getHeader()->getId();
        $ip = $cluster->getHeader()->getIp();
        $version = $cluster->getHeader()->getVersion();
        $this->registrator = $cluster->getHeader()->getUrl();
      } 
      
      if($this->verifier->isMyKey($id))
      {
        $id = SkynetConfig::KEY_ID;
      }

      $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->bindParam(':ip', $ip, \PDO::PARAM_STR);
      $stmt->bindParam(':version', $version, \PDO::PARAM_STR);
      $stmt->bindParam(':last_connect', $last_connect, \PDO::PARAM_INT);
      $stmt->bindParam(':registrator', $this->registrator, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->monits[] = 'Clusters Registry: cluster added to blocked list: '.SkynetHelper::cleanUrl($cluster->getUrl());
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] ADDED TO DB');
        return true;
      } else {
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] NOT ADDED TO DB');
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  } 
  
 /**
  * Updates clusters in database broadcasted by Skynet
  *
  * @param SkynetCluster $cluster Cluster object
  *
  * @return bool True if success
  */
  private function updateFromHeader(SkynetCluster $cluster)
  {
    $clusters_encoded = $cluster->getHeader()->getClusters();
    $this->registrator = SkynetHelper::cleanUrl($cluster->getHeader()->getUrl());

    $clustersUrls = explode(';', $clusters_encoded);
    $newClusters = [];

    foreach($clustersUrls as $clusterUrlRaw)
    {
      $clusterUrlDecoded = base64_decode($clusterUrlRaw);
      if(strcmp($clusterUrlDecoded, SkynetHelper::getMyUrl()) != 0)
      {
        $url = SkynetHelper::cleanUrl($clusterUrlDecoded);
        $newCluster = new SkynetCluster();
        $newCluster->setUrl($url);
        $newClusters[] = $newCluster;
      }
    }

    /* Insert or update */
    foreach($newClusters as $cluster)
    {
      if(!$this->isClusterBlocked($cluster))
      {
        if($this->isCluster($cluster))
        {
          $this->update($cluster);
        } else {
          $this->insert($cluster);
        }
      }
    }
  }
  
 /**
  * Returns monits
  *
  * @return string[] Monits
  */
  public function getMonits()
  {
    return $this->monits;
  }
}

/**
 * Skynet/Cluster/SkynetClustersUrlsChain.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Cluster Urls Chain
  *
  * Stores clusters URLs in encoded chain
  */
class SkynetClustersUrlsChain
{
  /** @var string Raw urls chain */
  private $rawUrlsChain;

  /** @var string Decrypted urls chain */
  private $decryptedUrlsChain;

  /** @var string[] Array of clusters in chain */
  private $clusters = [];

  /** @var SkynetRequest Assigned request */
  private $request;

  /** @var string My cluster URL */
  private $myUrl;

  /** @var string Sender URL */
  private $senderUrl;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->myUrl = SkynetHelper::getMyUrl();
    $this->verifier = new SkynetVerifier();
    $this->clustersRegistry = new SkynetClustersRegistry();
  }

 /**
  * Assigns $request object
  *
  * @param SkynetRequest $request
  */
  public function assignRequest(SkynetRequest $request)
  {
    $this->request = $request;
  }

 /**
  * Parses clusters from dataabse into urls chain
  *
  * Creates urls chain from saved clusters. This chain will be sended with request to update clusters on another clusters
  *
  * @return string Parsed chain
  */
  public function parseMyClusters()
  {
    $clusters = $this->clustersRegistry->getAll();
    $ary = [];
    $ret = '';
    $ary[] = base64_encode(SkynetHelper::getMyUrl());
    if(count($clusters) > 0)
    {
      foreach($clusters as $cluster)
      {
        if(!$this->clustersRegistry->isClusterBlocked($cluster))
        {
          if(!empty($cluster->getUrl())) 
          {
            $ary[] = base64_encode($cluster->getUrl());
          }
        }
      }
      $ret = implode(';', $ary);
    }   
    return $ret;
  }
  
 /**
  * Loads clusters urls saved in request into $this->clusters[] array
  */
  public function loadFromRequest()
  {
    if($this->request === null) 
    {
      return false;
    }
    if($this->request->get('_skynet_clusters_chain') !== null)
    {
      $this->senderUrl = $this->request->getSenderClusterUrl();
      $this->rawUrlsChain = $this->request->get('_skynet_clusters_chain');
      $this->decryptedUrlsChain = $this->decryptRawChain($this->rawUrlsChain);
      $this->explodeChain();
    }
  }

 /**
  * Checks if cluster url exists in $this->clusters[] array
  *
  * @param string $url Cluster URL to check
  *
  * @return bool True if exists
  */
  public function isClusterInChain($url)
  {
    if(in_array($url, $this->clusters))
    {
      return true;
    }
  }

 /**
  * Checks if my cluster url exists in $this->clusters[] array
  *
  * @return bool True if exists
  */
  public function isMyClusterInChain()
  {
    if(in_array($this->myUrl, $this->clusters))
    {
      return true;
    }
  }

 /**
  * Checks if request sender's cluster url exists in $this->clusters[] array
  *
  * @return bool True if exists
  */
  public function isSenderClusterInChain()
  {
    if(in_array($this->senderUrl, $this->clusters))
    {
      return true;
    }
  }

 /**
  * Adds cluster URL into $this->clusters[] array
  *
  * @param string $url Cluster URL to add
  */
  public function addClusterToChain($url)
  {
    if($url !== null && !empty($url)) 
    {
      $this->clusters[] = $url;
    }
  }

 /**
  * Adds my cluster URL into $this->clusters[] array
  *
  * @return bool
  */
  public function addMyClusterToChain()
  {
    return $this->addClusterToChain($this->myUrl);
  }

 /**
  * Adds request sender's cluster URL into $this->clusters[] array
  *
  * @return bool
  */
  public function addSenderClusterToChain()
  {
    return $this->addClusterToChain($this->senderUrl);
  }

 /**
  * Returns base64 encrypted chain generated from $this->clusters[] array
  *
  * @return string Base64 encode clusters urls chain
  */
  public function getClustersUrlsChain()
  {
    return $this->encryptRawChain(implode(';', $this->clusters));
  }

 /**
  * Returns NOT encrypted raw chain generated from $this->clusters[] array
  *
  * @return string Base64 encode clusters urls chain
  */
  public function getClustersUrlsPlainChain()
  {
    return implode(';', $this->clusters);
  }

 /**
  * Encode raw chain by base64
  *
  * @param string $chain
  *
  * @return string Base64 encoded urls chain
  */
  private function encryptRawChain($chain)
  {
    return base64_encode($chain);
  }

 /**
  * Decode raw chain by base64
  *
  * @param string $chain
  *
  * @return string Base64 decoded urls chain
  */
  private function decryptRawChain($chain)
  {
    return base64_decode($chain);
  }

 /**
  * Explode decoded urls chain and returns aray of clusters
  *
  * @return string[] Array of clusters
  */
  private function explodeChain()
  {
    $this->clusters = explode(';', $this->decryptedUrlsChain);
    return $this->clusters;
  }
}

/**
 * Skynet/Common/SkynetHelper.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Helper
  *
  * Common used methods
  */
class SkynetHelper
{
 /**
  * Returns cluster address by host or ip
  *
  * @return string
  */
  public static function getServerAddress()
  {
    if(SkynetConfig::get('core_connection_mode') == 'host')
    {
      return self::getServerHost();
    } elseif(SkynetConfig::get('core_connection_mode') == 'ip')
    {
      return self::getServerIp();
    }
  }

 /**
  * Returns cluster host
  *
  * @return string
  */
  public static function getServerHost()
  {
    if(isset($_SERVER['HTTP_HOST'])) 
    {
      return $_SERVER['HTTP_HOST'];
    }
  }
 
 /**
  * Returns basename
  *
  * @return string
  */ 
  public static function getMyBasename()
  {
    return basename($_SERVER['PHP_SELF']);
  }

 /**
  * Returns cluster IP address
  *
  * @return string
  */
  public static function getServerIp()
  {
    if(isset($_SERVER['SERVER_ADDR']))
    {
      return $_SERVER['SERVER_ADDR'];
    }
  }

 /**
  * Returns remote client IP address
  *
  * @return string
  */
  public static function getRemoteIp()
  {
    if(!isset($_SERVER['REMOTE_ADDR']))
    {
      return '-';
    }
    
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];     

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
      $ip = $client;
    } elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
      $ip = $forward;
    } else
    {
      $ip = $remote;
    }
    return $ip;
  }
  
 /**
  * Returns cluster filename
  *
  * @return string
  */
  public static function getMyself()
  {
   return $_SERVER['PHP_SELF'];
  }

 /**
  * Returns cluster adress to
  *
  * @return string
  */
  public static function getMyServer()
  {
   return self::getServerAddress().pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME);
  }
  
 /**
  * Returns cluster full address
  *
  * @return string
  */
  public static function getMyUrl()
  {
    return self::getServerAddress().self::getMyself();
  }

 /**
  * Validates URL
  *
  * @param string $url
  *
  * @return bool
  */  
  public function isUrl($url)
  {
    if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url))
    {
      return true;
    }
  }
  
 /**
  * Sanitazes URL
  *
  * @param string $url
  *
  * @return string
  */  
  public static function cleanUrl($url)
  {
    return str_replace(array(SkynetConfig::get('core_connection_protocol'), 'http://', 'https://'), '', $url);
  }
 
 /**
  * Translates Config value
  *
  * @param string $key
  *
  * @return string
  */  
  public static function translateCfgKey($key)
  {
    $titles = [];
    
    $titles['core_secure'] = 'Secure connections by Key';
    $titles['core_raw'] = 'Disable data encryption';
    $titles['core_updater'] = 'Updater engine enabled';
    $titles['core_cloner'] = 'Cloner engine enabled';
    $titles['core_check_new_versions'] = 'Check GitHub for new version';
    $titles['core_urls_chain'] = 'URLs Chain Engine enabled';
    $titles['core_mode'] = 'Default mode (0=Idle, 1=Single, 2=Broadcast)';
    $titles['core_encryptor'] = 'Data encryptor';
    $titles['core_encryptor_algorithm'] = 'Data encryptor algorithm';
    $titles['core_renderer_theme'] = 'Renderer theme';
    $titles['core_date_format'] = 'Date format';
    $titles['core_admin_ip_whitelist'] = 'IP\'s whitelist for access to Control Panel';
    $titles['core_open_sender'] = 'Always send requests (even without login to Control Panel)';
    
    $titles['translator_config'] = 'Translate config keys to titles';
    $titles['translator_params'] = 'Translate internal params to titles';
    
    $titles['core_connection_mode'] = 'Connection by host or IP';
    $titles['core_connection_type'] = 'Connection provider';
    $titles['core_connection_protocol'] = 'Connection protocol';
    $titles['core_connection_ssl_verify'] = 'Verify SSL if https connection';
    $titles['core_connection_curl_output'] = 'Output full CURL data in CLI';
    
    $titles['core_connection_ip_whitelist'] = 'IP Whitelist (accepts requests only from list)';
    
    $titles['emailer_responses'] = 'Log responses via email';
    $titles['emailer_requests'] = 'Log requests via email';
    $titles['emailer_email_address'] = 'Emails receiver address';
    
    $titles['response_include_request'] = 'Include @request in response';
    
    $titles['logs_errors_with_full_trace'] = 'Log errors with full trace';
    $titles['logs_txt_include_secure_data'] = 'Include Key ID and Hash in txt logs';
    $titles['logs_txt_include_clusters_data'] = 'Include clusters URLs in txt logs';
    
    $titles['logs_dir'] = 'Directory for logs';
    
    $titles['logs_txt_access_errors'] = 'Log access errors in .txt files';
    $titles['logs_txt_errors'] = 'Log core errors in .txt files';
    $titles['logs_txt_requests'] = 'Log requests in .txt files';
    $titles['logs_txt_responses'] = 'Log responses in .txt files';
    $titles['logs_txt_echo'] = 'Log @echo in .txt files';
    $titles['logs_txt_broadcast'] = 'Log @broadcast in .txt files';
    $titles['logs_txt_selfupdate'] = 'Log @self_update in .txt files';
    
    $titles['logs_txt_include_internal_data'] = 'Include internal (_skynet_*)  params in .txt logs';
    
    $titles['logs_db_access_errors'] = 'Log access errors in database';
    $titles['logs_db_errors'] = 'Log core errors in database';
    $titles['logs_db_requests'] = 'Log requests in database';
    $titles['logs_db_responses'] = 'Log responses in database';
    $titles['logs_db_echo'] = 'Log @echo in database';
    $titles['logs_db_broadcast'] = 'Log @broadcast in database';
    $titles['logs_db_selfupdate'] = 'Log @self_update in database';
    
    $titles['logs_db_include_internal_data'] = 'Include internal (_skynet_*)  params in database';
    
    $titles['db'] = 'Database support enabled';
    $titles['db_type'] = 'Database type (PDO)';
    $titles['db_host'] = 'Database host';
    $titles['db_user'] = 'Database username';
    $titles['db_password'] = 'Database password';
    $titles['db_dbname'] = 'Database name';
    $titles['db_encoding'] = 'Database encoding';
    $titles['db_port'] = 'Database port';
    
    $titles['db_file'] = 'Database file (for SQLite)';
    $titles['db_file_dir'] = 'Database files directory (for SQLite)';
    
    $titles['console_debug'] = 'Enable console commands debugger';
    $titles['debug_exceptions'] = 'Debug errors with full exceptions';
    $titles['debug_internal'] = 'Debug internal skynet params';
    $titles['debug_echo'] = 'Debug internal @echo skynet params';
    $titles['debug_key'] = 'Show KEY ID in Control Panel';
    
    if(array_key_exists($key, $titles))
    {
      return $titles[$key];
    } else {
      return $key;
    }
  }  
}

/**
 * Skynet/Common/SkynetTypes.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Types
  *
  * Defines types constants
  */
class SkynetTypes
{
  /** @var string Global Error */
  const STATUS_OK = 'OK';

  /** @var string Global OK */
  const STATUS_ERR = 'ERROR';

  /** @var string Connection Ok */
  const CONN_OK = 'CONNECTION OK';

  /** @var string Connection Error */
  const CONN_ERR = 'CONNECTION ERROR';

  /** @var string Database Connection OK */
  const DBCONN_OK = 'DB CONNECTION OK';

  /** @var string Database Connection Error */
  const DBCONN_ERR = 'DB CONNECTION ERROR';

  /** @var string Status of CURL */
  const CURL = 'CURL STATUS';
  
  /** @var string Error */
  const CURL_ERR = 'CURL ERROR';
  
  /** @var string Self-cloner */
  const CLONER = 'SKYNET CLONER';
  
  /** @var string Status of file_get_constents() */
  const FILE_GET_CONTENTS = 'FILE_GET_CONTENTS';
  
  /** @var string PDO Exception */
  const PDO = 'PDO EXCEPTION';
  
  /** @var string Database status */
  const DB = 'DB';
  
  /** @var string CHAIN */
  const CHAIN = 'CHAIN';
  
  /** @var string Status of SkynetVerifier */
  const VERIFY = 'VERIFIER';
  
  /** @var string Status of SkynetVerifier */
  const HEADER = 'CLUSTER HEADER';
  
   /** @var string Status of SkynetResponse */
  const RESPONSE = 'RESPONSE';
  
  /** @var string Status of SkynetRequeste */
  const REQUEST = 'REQUEST';
  
  /** @var string Status of cluster */
  const CLUSTER = 'CLUSTER';
  
  /** @var string Status of cluster */
  const CLUSTERS_DB = 'CLUSTERS DB';
  
  /** @var string Status of file logger */
  const LOGFILE = 'FILE LOGGER';
  
  /** @var string Status of Emailer */
  const EMAIL = 'EMAIL SENDER';
  
  /** @var string Status of REGISTRY */
  const REGISTRY = 'REGISTRY';
  
  /** @var string Status of OPTIONS */
  const OPTIONS = 'OPTIONS';
  
  /** @var string Skynet Exception */
  const EXCEPTION = 'SKYNET EXCEPTION';
  
  /** @var string Status of SELF-UPDATER */
  const UPDATER = 'SELF-UPDATER';
  
  /** @var string Status of TXTLOG */
  const TXT_LOG = 'TXT LOGGER';
  
  /** @var string Status of TXTLOG */
  const DB_LOG = 'DB LOGGER';  

  /** @var string Assignment - response */
  const A_RESPONSE_OK = 'RESPONSE ASSIGNED';

  /** @var string Assignment - request */
  const A_REQUEST_OK = 'REQUEST ASSIGNED';
}

/**
 * Skynet/Connection/SkynetConnectionCurl.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Connection [cURL]
  *
  * Adapter for cURL connections
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetConnectionCurl extends SkynetConnectionAbstract implements SkynetConnectionInterface
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var string[] Parameters array to send as POST via cURL */
  private $postParams = [];

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
  }

 /**
  * Connects to remote address and gets response data
  *
  * @param string|null $remote_address URL to connect
  *
  * @return string Raw received data
  */
  public function connect($remote_address = null)
  {       
    $this->data = null;
    
    $address = '';
    
    if($this->cluster !== null) 
    {
      $address = $this->cluster->getUrl();
    }
    
    if($remote_address !== null) 
    {
      $address = $remote_address;
    }
    
    if(empty($address))
    {
      $this->addState(SkynetTypes::CURL_ERR,'[[[[ERROR]]]: ADDRESS IS NULL');
      return false;
    }
    
    $this->url = $address;

    $this->prepareParams();
    $data = $this->init($this->url);    
    $this->data = $data['data'];
    $result = $data['result'];

    try
    {
      if($this->data === null)
      {
        throw new SkynetException('Connection error: [CURL] RESPONSE DATA IS NULL');        
      }   
      if(empty($this->data))
      {
        $this->addState(SkynetTypes::CURL_ERR,'[[[[ERROR]]]: NO RESPONSE: '.$this->url);           
      } else {
        $this->launchConnectListeners($this);        
      }
      
      $adapter = [];
      $adapter['result'] = $result;
      $adapter['data'] = $this->data;
      $adapter['params'] = $this->requests;
      return $adapter;
     
    } catch(SkynetException $e)
    {
      $this->addError(SkynetTypes::CURL, $e->getMessage(), $e);    
    }
  }

 /**
  * Opens cURL connection and gets response data
  *
  * @param string $address URL to connect
  *
  * @return string Received raw data
  */
  private function init($address)
  {
    $result = null;
    try
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $address);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_USERAGENT, 'Skynet '.SkynetVersion::VERSION);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_ENCODING ,"");
      curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
      curl_setopt($ch, CURLOPT_VERBOSE, SkynetConfig::get('core_connection_curl_output'));     
      if(!SkynetConfig::get('core_connection_ssl_verify'))
      {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      }
      $headers = array(
                   "Cache-Control: no-cache",
                  );
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      if(count($this->postParams) > 0) 
      {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postParams);
      }

      $responseData = curl_exec($ch);
      $charset = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

      /* If errors */
      if(curl_errno($ch))
      {
        $errno = curl_errno($ch);
        $msg = curl_error($ch);
        $this->addError(SkynetTypes::CURL, 'Connection error: [CURL] Code: '.$msg.' | Error: '.$msg);
        $this->addState(SkynetTypes::CURL, 'CONNECTION ERROR: '.$address);
        $result = false;
      } 
      if($responseData !== null && !empty($responseData))
      {      
        $this->addState(SkynetTypes::CURL,'[OK] RESPONSE DATA RECEIVED: '.$this->url.' (CHARSET: '.$charset.')');
        $preResponse = json_decode($responseData);
        if($preResponse !== null && isset($preResponse->_skynet))
        {        
          $result = true;
        }
      }

      curl_close($ch);
      
      $data = [];
      $data['result'] = $result;
      $data['data'] = $responseData;
      
      return $data;
      
    } catch(SkynetException $e)
    {
      $this->addError(SkynetTypes::CURL, 'CURL: '.$e->getMessage(), $e);
    }
  }

 /**
  * Create params for send via cURL
  * @param string[] $ary Array of params
  */
  private function createPostParams($ary)
  {
     $this->postParams = [];
     $this->postParams = $ary;
  }

 /**
  * Parse params into string (for debug)
  */
  public function prepareParams()
  {
    $fields = [];
    $this->postParams = [];

    if(is_array($this->requests) && count($this->requests) > 0)
    {
      foreach($this->requests as $fieldKey => $fieldValue)
      {
        $this->postParams[$fieldKey] = $fieldValue;
        $fields[] = $fieldKey.'='.$fieldValue;
      }
      if(count($fields) > 0)  
      {
        $this->params = '?'.implode('&', $fields);
      }
    }
  }
}

/**
 * Skynet/Connection/SkynetConnectionFileGetContents.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Connection [file_get_contents()]
  *
  * Adapter for simple connection via file_get_contents() function.
  * May be useful if there is no cURL extension on server.
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetConnectionFileGetContents extends SkynetConnectionAbstract implements SkynetConnectionInterface
{
  use SkynetErrorsTrait, SkynetStatesTrait;

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
  }

 /**
  * Opens connection and gets response data
  *
  * @param string $address URL to connect
  *
  * @return string Received raw data
  */
  private function init($address)
  {
    $data = null; 
    $result = null;
    try 
    {
      if(!SkynetConfig::get('core_connection_ssl_verify'))
      {
         $options = array(
          "ssl" => array(
              "verify_peer" => false,
              "verify_peer_name" => false,
          ));
        $data = @file_get_contents($address, false, stream_context_create($options));       
      } else {
        $data = @file_get_contents($address);
      }   
      
      if($data === null || $data === false)
      {
        $result = false;
        throw new SkynetException('DATA IS NULL');
      }    
      
      $preResponse = json_decode($data);
      if($preResponse !== null && isset($preResponse->_skynet))
      {        
        $result = true;
      }     
      
    } catch(SkynetException $e)
    {
      $this->addError(SkynetTypes::FILE_GET_CONTENTS, 'Connection error: NO DATA RECEIVED', $e);            
    }   
    
    $ret['data'] = $data;
    $ret['result'] = $result;
    return $ret;
  }

 /**
  * Connects to remote address and gets response data
  *
  * @param string|null $remote_address URL to connect
  *
  * @return string Raw received data
  */
  public function connect($remote_address = null)
  {
    $this->data = null;
    if($this->cluster !== null) 
    {
      $address = $this->cluster->getUrl();
    }
    if($remote_address !== null) 
    {
      $address = $remote_address;
    }

    if(empty($address) || $address === null)
    {
      $this->addError(SkynetTypes::FILE_GET_CONTENTS, 'Connection error: NO ADDRESS TAKEN');
      return false;
    }

    $this->prepareParams();
    $data = $this->init($address.$this->params);
    $this->data = $data['data'];
    if($this->data === null) 
    {
      $this->addError(SkynetTypes::FILE_GET_CONTENTS, 'Connection error: RESPONSE DATA IS NULL');
    }
    $this->launchConnectListeners($this);
    
    $adapter = [];
    $adapter['data'] = $this->data;
    $adapter['params'] = $this->requests;
    $adapter['result'] = $data['result'];
      
    return $adapter;
  }

 /**
  * Parse params into string (for debug)
  */
  public function prepareParams()
  {
    $fields = [];

    if(is_array($this->requests) && count($this->requests) > 0)
    {
      foreach($this->requests as $fieldKey => $fieldValue)
      {
        $fields[] = $fieldKey.'='.$fieldValue;
      }
      if(count($fields) > 0) 
      {
        $this->params = '?'.implode('&', $fields);
      }
    }
  }
}

/**
 * Skynet/Connection/SkynetConnectionsFactory.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Connections Factory
  *
  * Factory for connection adapters
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetConnectionsFactory
{
  /** @var SkynetConnectionInterface[] Array of connectors */
  private $connectorsRegistry = [];

  /** @var SkynetConnectionsFactory Instance of this */
  private static $instance = null;

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}

 /**
  * Registers all connection adapters into registry
  */
  private function registerConnectors()
  {
    $this->register('file_get_contents', new SkynetConnectionFileGetContents());
    $this->register('curl', new SkynetConnectionCurl());
  }

 /**
  * Returns choosen adapter
  *
  * @param string $name Name(key) od registered adapter
  *
  * @return SkynetConnectionInterface Connection adapter
  */
  public function getConnector($name = null)
  {
    if($name === null)
    {
      $name = SkynetConfig::get('core_connection_type');
    }
    if(array_key_exists($name, $this->connectorsRegistry))
    {
      return $this->connectorsRegistry[$name];
    }
  }

 /**
  * Registers adapter into registry
  *
  * @param string $id Name(key) od registered adapter
  * @param SkynetConnectionInterface $class New Connection adapter instance
  */
  private function register($id, SkynetConnectionInterface $class)
  {
    $this->connectorsRegistry[$id] = $class;
  }

 /**
  * Returns connection adapters array
  *
  * @param string $id Name(key) od registered adapter
  * @param SkynetConnectionInterface $class New Connection adapter instance
  *
  * @return SkynetConnectionInterface[] Connection adapters array
  */
  public function getConnectors()
  {
    return $this->connectorsRegistry;
  }

 /**
  * Checks for connection adapters already registered
  *
  * @return bool True if registered
  */
  public function areRegistered()
  {
    if($this->connectorsRegistry !== null && count($this->connectorsRegistry) > 0) return true;
  }

 /**
  * Returns instance of factory
  *
  * @return SkynetConnectionsFactory Instance of factory
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
      if(!self::$instance->areRegistered()) self::$instance->registerConnectors();
    }
    return self::$instance;
  }
}

/**
 * Skynet/Console/SkynetCli.php
 *
 * Operates on commands when running in CLI
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet CLI Parser
  *
  * Operates from CLI
  */
class SkynetCli
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var string[] Commands passed in CLI */
  private $commands = [];  

  /** @var string[] Commands params passed in CLI */
  private $params = [];
  
  /** @var string[] Commands with their params */
  private $commandsData = [];
  
  /** @var string[] $_SERVER['argc'] Arguments count*/
  private $argc;
  
  /** @var string[] $_SERVER['argv'] Arguments values */
  private $argv = [];
  
  /** @var int Num of passed args without argv[0] - (script name) */
  private $numArgs;
  
   /** @var bool True if passed args */
  private $areArgs = false;
  
  /** @var string Actual CLI argument */
  private $actualCmd;

 /**
  * Constructor
  */
  public function __construct()
  {
    if($this->isCli())
    {
      $this->argc = $_SERVER['argc'];
      $this->argv = $_SERVER['argv'];
      $this->numArgs = $this->argc - 1;
      
      if($this->haveArgs())
      {
        $this->areArgs = true;
        $this->getArgs();
      }
    }
  }

 /**
  * Checks environment for CLI
  *
  * @return bool True if in CLI
  */ 
  public function isCli()
  {
    if(defined('STDIN'))
    {
       return true;
    }

    if(php_sapi_name() === 'cli')
    {
       return true;
    }

    if(array_key_exists('SHELL', $_ENV)) 
    {
       return true;
    }

    if(empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) 
    {
       return true;
    } 

    if(!array_key_exists('REQUEST_METHOD', $_SERVER))
    {
       return true;
    }

    return false;
  }

 /**
  * Checks for CLI args exists
  *
  * @return bool True if are args
  */   
  public function haveArgs()
  {
    if($this->numArgs > 0)
    {
      return true;
    }
  }

 /**
  * Gets and parses arguments
  *
  * @return string[] Array with args and their params
  */ 
  public function getArgs()
  { 
    $cmds = [];
    $params = [];       
   
    foreach($this->argv as $k => $arg)
    {
      if($k > 0)
      {
        /* if command */
        if(strpos($arg, '-') === 0)
        {
          $cmd = substr($arg, 1, strlen($arg));
          $this->commands[] = $cmd;
          $this->actualCmd = $cmd;
          $this->commandsData[$cmd] = [];
          
        } else {
          /* if command param */
          if($this->actualCmd !== null)
          {
            $key = $this->actualCmd;
            if(is_array($this->commandsData[$key]))
            {
              $this->commandsData[$key][] = $arg;
            }             
          }       
          $this->params[] = $arg;
        }    
      }
    }  
    
    return $this->commandsData;
  }
 
 /**
  * Checks for command exists in args
  *
  * @param string $cmd Command name
  *
  * @return bool True if exists
  */  
 public function isCommand($cmd)
 {
   if(array_key_exists($cmd, $this->commandsData))
   {
      return true;
   }   
 }

 /**
  * Returns params array for arg
  *
  * @param string $cmd Command name
  *
  * @return string[] Params
  */  
 public function getParams($cmd)
 {
   if(array_key_exists($cmd, $this->commandsData))
   {
      return $this->commandsData[$cmd];
   } 
 }
 
 /**
  * Returns first param 
  *
  * @param string $cmd Command name
  *
  * @return string Param
  */  
 public function getParam($cmd)
 {
   if(array_key_exists($cmd, $this->commandsData))
   {
      return $this->commandsData[$cmd][0];
   } 
 }

 /**
  * Checks for command params
  *
  * @param string[] $params Check if have params
  *
  * @return bool True if are params
  */ 
  public function areParams($params)
  {
    if(is_array($params) && count($params) > 0)
    {
      return true;
    }
  }

 /**
  * Returns array with commands passed to CLI
  *
  * @return string[] Array with commands
  */   
  public function getCommands()
  {
    return $this->commands;
  }

 /**
  * Returns array with commands and params, [command] => params
  *
  * @return string[] Array with commands and params
  */    
  public function getCommandsData()
  {
    return $this->commandsData;
  }  
}

/**
 * Skynet/Console/SkynetCliInput.php
 *
 * @package Skynet
 * @version 1.1.2
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.2
 */

 /**
  * Skynet Console Input
  *
  * Parses user commands from webconsole
  */
class SkynetCliInput
{ 
  /** @var SkynetRequest Assigned request */
  private $request;
  
  /** @var SkynetResponse Assigned response */
  private $response; 
  
  /** @var bool Broadcast controller */
  private $startBroadcast;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetAuth Authentication */
  private $auth;
  
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;
  
  /** @var SkynetEventListenersLauncher Listeners Launcher */
  private $eventListenersLauncher;
  
  /** @var SkynetCli CLI Console */
  private $cli;
  
  /** @var SkynetConsole HTML Console */
  private $console;
  
  /** @var string[] Output from console */
  private $cliOutput = [];
  
  /** @var string[] Addresses to connect */
  private $addresses = [];

 /**
  * Constructor
  */
  public function __construct()
  {    
    $this->verifier = new SkynetVerifier();
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->auth = new SkynetAuth();
    $this->cli = new SkynetCli();
    $this->console = new SkynetConsole();
    $this->request = new SkynetRequest();
    $this->response = new SkynetResponse();
    
    $this->eventListenersLauncher = new SkynetEventListenersLauncher();
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);
    $this->eventListenersLauncher->assignCli($this->cli);
    $this->eventListenersLauncher->assignConsole($this->console);
  }

 /**
  * Launchs console controller
  *
  * @return bool Start Broadcast or not
  */
  public function launch()
  {
    $this->startBroadcast = false;
    $this->prepareListeners();
    
    /* if CLI mode */
    if($this->cli->isCommand('b') || $this->cli->isCommand('broadcast'))
    {
      /* Launch broadcast */
      $this->startBroadcast = true;
      
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
          $this->addresses[] = $address; 
        } 
      }        
    }
    
     /* Launch CLI commands listeners */
     $this->prepareListeners();
     $this->eventListenersLauncher->launch('onCli');    
     $this->cliOutput = $this->eventListenersLauncher->getCliOutput();
    
    return $this->startBroadcast;
  }
 
 /**
  * Returns addresses to connect
  *
  * @return string[] addresses list
  */  
  public function getAddresses()
  {
   return $this->addresses;   
  }

 /**
  * Returns signal to start broadcast
  *
  * @return bool True if start broadcast
  */  
  public function getStartBroadcast()
  {
    return $this->startBroadcast;
  } 

 /**
  * Returns CLI object
  *
  * @return SkynetCli CLI
  */  
  public function getCli()
  {
    return $this->cli;
  } 

 /**
  * Returns output from listeners
  *
  * @return string[] Output from console
  */  
  public function getCliOutput()
  {
    return $this->cliOutput;
  }
  
 /**
  * Assigns data to listeners
  */ 
  private function prepareListeners()
  {
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);
    //$this->eventListenersLauncher->assignConnectId($this->connectId);
    //$this->eventListenersLauncher->assignClusterUrl($this->clusterUrl);
    $this->eventListenersLauncher->assignCli($this->cli);    
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

/**
 * Skynet/Console/SkynetCommand.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Command
  */
class SkynetCommand
{    
  /** @var string Command name */
  private $code;
  
 /** @var mixed[] Command params */
  private $params = [];
  
  /** @var string Command helper params */
  private $helperDescription;
  

 /**
  * Constructor
  *
  * @param string $code Command code
  * @param string[] $params Command params
  * @param string $desc Command description
  */
  public function __construct($code = null, $params = null, $desc = null)
  {
    if($code !== null) $this->code = $code;
    if($params !== null) $this->params = $params;
    if($desc !== null) $this->helperDescription = $desc;
  }

 /**
  * Sets command code
  *
  * @param string $code Command code
  */
  public function setCode($code)
  {
    $this->code = $code;
  }
  
 /**
  * Sets command params
  *
  * @param string[] $params Command params
  */
  public function setParams($params)
  {
    $this->params = $params;
  }
  
 /**
  * Sets command helper description
  *
  * @param string $desc Command description
  */
  public function setHelperDescription($desc)
  {
    $this->helperDescription = $desc;
  }   
  
 /**
  * Returns command code
  *
  * @return string Command code
  */
  public function getCode()
  {
    return $this->code;
  }
  
 /**
  * Returns command params
  *
  * @return string[] Command params
  */
  public function getParams()
  {
    return $this->params;
  }
  
 /**
  * Returns command helper description
  *
  * @return string Command description
  */
  public function getHelperDescription()
  {
    return $this->helperDescription;
  }   
}

/**
 * Skynet/Console/SkynetConsole.php
 *
 * @package Skynet
 * @version 1.1.4
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Console 
  */
class SkynetConsole
{    
  /** @var SkynetCommand[] Array of helper commands */
  private $commands = [];
  
  /** @var SkynetCommand[] Array of console commands */
  private $consoleCommands = [];
  
   /** @var mixed[] Array of console requests */
  private $consoleRequests = [];
  
  /** @var SkynetCommand[] Array of helper custom commands */
  private $customCommands = [];
  
  /** @var string[] Parser Errors */
  private $parserErrors = [];
  
  /** @var string[] Parser States */
  private $parserStates = [];
  
  /** @var int actual parsed query */
  private $actualQueryNumber;
  
  /** @var SkynetEventListenersInterface[] Array of Event Listeners */
  private $eventListeners = [];

  /** @var SkynetEventListenersInterface[] Array of Event Loggers */
  private $eventLoggers = [];
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetDebug Debugger */
  private $debugger;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();    
    $this->registerListenersCommands();
    $this->verifier = new SkynetVerifier();
    $this->debug = new SkynetDebug();
  }

 /**
  * Registers listeners commands
  */  
  private function registerListenersCommands()
  {
    foreach($this->eventListeners as $listener)
    {
      if(method_exists($listener, 'registerCommands'))
      {
        $tmpCommands = $listener->registerCommands();      
      }
      
      if(is_array($tmpCommands) && isset($tmpCommands['console']) && is_array($tmpCommands['console']))
      {
        foreach($tmpCommands['console'] as $command)
        {
          $cmdName = '';
          $cmdDesc = '';
          $cmdDefaults = '';
          
          if(isset($command[0]))
          {
            $cmdName = $command[0];
          }
          
          if(isset($command[1]))
          {
            $cmdDesc = $command[1];
          }
          
          if(isset($command[2]))
          {
            $cmdDefaults = $command[2];
          }
          
          $this->addCommand($cmdName, $cmdDesc, $cmdDefaults);                  
        }
      }
    }   
  }

 /**
  * Returns true if is console input
  *
  * @return bool True if is input
  */
  public function isInput()
  {
    if(isset($_REQUEST['_skynetCmdCommandSend']) && isset($_REQUEST['_skynetCmdConsoleInput'])) 
    {
      return true;
    }    
  }
  
 /**
  * Adds command to registry
  *
  * @param string $code Command code
  * @param string[]|null $params Command params
  * @param string|null $desc Command description
  */
  public function addCommand($code, $params = null, $desc = null)
  {    
    if($params !== null)
    {
      if(is_array($params))
      {
        $paramsAry = $params;
      } else {
        $paramsAry = [];
        $paramsAry[0] = $params;
      }      
    }
    $this->commands[$code] = new SkynetCommand($code, $paramsAry, $desc);    
  }
  
 /**
  * Adds custom command to registry
  *
  * @param string $code Command code
  * @param string[]|null $params Command params
  * @param string|null $desc Command description
  */
  public function addCustomCommand($code, $params = null, $desc = null)
  {    
    if($params !== null)
    {
      if(is_array($params))
      {
        $paramsAry = $params;
      } else {
        $paramsAry = [];
        $paramsAry[0] = $params;
      }      
    }
    $this->customCommands[$code] = new SkynetCommand($code, $paramsAry, $desc);    
  }

 /**
  * Returns commands registry
  *
  * @return SkynetCommand[] Commands
  */  
  public function getCommands()
  {
    return $this->commands;
  }
  
 /**
  * Returns custom commands registry
  *
  * @return SkynetCommand[] Commands
  */  
  public function getCustomCommands()
  {
    return $this->customCommands;
  }
  
 /**
  * Returns console parsed commands
  *
  * @return SkynetCommand[] Commands
  */  
  public function getConsoleCommands()
  {
    return $this->consoleCommands;
  }
  
 /**
  * Returns console parsed requests
  *
  * @return mixed[] Requests
  */  
  public function getConsoleRequests()
  {
    return $this->consoleRequests;
  }
  
 /**
  * Returns command by code
  *
  * @param string $code Command code
  *
  * @return SkynetCommand Command
  */  
  public function getCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->commands))
    {
      return $this->commands[$code];
    }
  }
  
 /**
  * Returns custom command by code
  *
  * @param string $code Command code
  *
  * @return SkynetCommand Command
  */  
  public function getCustomCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->commands))
    {
      return $this->customCommands[$code];
    }
  }  
  
 /**
  * Returns console command by code
  *
  * @param string $code Command code
  *
  * @return SkynetCommand Command
  */  
  public function getConsoleCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->consoleCommands))
    {
      return $this->consoleCommands[$code];
    }
  }
  
 /**
  * Checks for command exists
  *
  * @param string $code Command code
  *
  * @return bool True if exists
  */  
  public function isCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->commands))
    {
      return true;
    }
  }
  
 /**
  * Checks for custom command exists
  *
  * @param string $code Command code
  *
  * @return bool True if exists
  */  
  public function isCustomCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->customCommands))
    {
      return true;
    }
  }
  
 /**
  * Checks for console command exists
  *
  * @param string $code Command code
  *
  * @return bool True if exists
  */  
  public function isConsoleCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->consoleCommands))
    {
      return true;
    }
  }
  
 /**
  * Checks for ny console command exists
  *
  * @return bool True if are commands
  */  
  public function isAnyConsoleCommand()
  {
    if(count($this->consoleCommands) > 0)
    {
      return true;
    }
  }
  
 /**
  * Returns parser errors
  *
  * @return string[] Erros
  */    
  public function getParserErrors()
  {
    return $this->parserErrors;    
  }
  
 /**
  * Adds parse error
  *
  * @param string $msg error
  */    
  public function addParserError($msg)
  {
    if($this->actualQueryNumber !== null)
    {
      $msg = 'Cmd['.$this->actualQueryNumber.']: '.$msg;
    }
    $this->parserErrors[] = $msg;    
  }

 /**
  * Returns parser states
  *
  * @return string[] Erros
  */    
  public function getParserStates()
  {
    return $this->parserStates;    
  }
  
 /**
  * Adds parser state
  *
  * @param string $msg state
  */    
  public function addParserState($msg)
  {
    if($this->actualQueryNumber !== null)
    {
      $msg = 'Query['.$this->actualQueryNumber.']: '.$msg;
    }
    $this->parserStates[] = $msg;    
  }
 
 /**
  * Returns type of query, false if incorrect query
  *
  * @param string $query Query to check
  *
  * @return string Query type
  */  
  private function getQueryType($query)
  {
    if(empty($query))
    {
      return false;
    }
    
    /* command */
    if(strpos($query, '@') === 0)
    {     
      return 'cmd';
    }
    
    if($this->isParamKeyVal($query))
    {
      return 'param';
    }
    
    /* incorrect */
    return false;
  }

 /**
  * Checks if param is pair key=val
  *
  * @param string $input
  *
  * @return bool True if is param key-value
  */ 
  private function isParamKeyVal($input)
  {
    if(!empty($input) && preg_match('/^[^http]+[a-zA-Z0-9_-]+: *"{0,1}.+"{0,1}$/', $input))
    {
      return true;
    }
  }
  
 /**
  * Removes multiple spaces
  *
  * @param string $str Original string
  *
  * @return string String with single spaces
  */    
  private function parseMultipleSpacesIntoSingle($str)
  {
    return preg_replace("/ {2,}/", " ", $str);    
  }
 
 /**
  * Checks if there are addresses in input
  *
  * @param string $input
  *
  * @return bool
  */ 
  private function areAddresses($input)
  {
   $urls = false;
   $e = explode(',', $input);
   $c = count($e);
   if($c > 0)
   {
     foreach($e as $param)
     {
       if($this->verifier->isAddressCorrect(trim($param)))
       {
         $urls = true;
       }
     }     
   }
   return $urls;   
  } 
 
 /**
  * Removes last ; char
  *
  * @param string $input
  *
  * @return string
  */  
  private function removeLastSemicolon($input)
  {
    return rtrim($input, ';');   
  }
 
 /**
  * Parses and returns params from params string
  *
  * @param string $paramsStr String with params
  *
  * @return mixed[] Array with params
  */   
  private function parseCmdParams($paramsStr)
  {
    $params = [];
    $semi = false;
    
    $paramsStr = $this->removeLastSemicolon($paramsStr);
    //var_dump($paramsStr);
   
    if(empty($paramsStr))
    {
      return false;
    }
    
    
   
    /* if param is quoted */
    if($this->isQuoted($paramsStr))
    {
      $data = $this->unQuote($paramsStr);      
      return array(0 => $data);
    }    
    
    /* if not quoted explode for params */
    $e = explode(',', $paramsStr);
    $numOfParams = count($e); 
    
    if(!$this->areAddresses($paramsStr))
    {
      $pattern = '/[a-zA-Z0-9_-]+: *"{0,1}([^"]+)"{0,1}[^,]?/';
      if(preg_match_all($pattern, $paramsStr, $matches, PREG_PATTERN_ORDER) != 0)
      {
        $e = $matches[0];
      } 
    }   
    
    foreach($e as $param)
    {
      $params[] = trim($param);      
    }
    
    return $params;    
  }

 /**
  * Returns param type
  *
  * @param string $paramStr param raw string
  *
  * @return string Type of param
  */    
  private function getParamType($paramStr)
  {
    $type = '';
    
    if(empty($paramStr))
    {
      return false;
    }
    
    $pattern = '/[a-zA-Z0-9_-]+: *"{0,1}([^"]+)"{0,1}[^,]?/';
    if(!preg_match($pattern, $paramStr))
    {
      $type = 'value';
      
    } else {
      
      $pattern = '/^[^http]+[a-zA-Z0-9_-]+: *"{0,1}([^"]+)"{0,1}[^,]?/';
      if(preg_match($pattern, $paramStr))
      {
        $type = 'keyvalue';
      } else {
        $type = 'value';
      }
    }   
   
    return $type;
  }

 /**
  * Returns array [key] => value from parsed param
  *
  * @param string $paramStr param raw string
  *
  * @return string[] Param array
  */    
  private function getParamKeyVal($paramStr)
  {
    if(empty($paramStr))
    {
      return false;
    }    
    if(substr($paramStr, -1) == ';')
    {
      $paramStr = rtrim($paramStr, ';');
    }
    $e = explode(':', $paramStr);
    
    $parts = count($e);
    if($parts < 2)
    {
      $this->addParserError('PARAM INCORRECT: '.$paramStr);
      return false;
      
    } else {
      
      $key = trim($e[0], '" ');
      if($parts == 2)
      {
        $value = trim($e[1], '" ');
      } else {
        $valueParts = [];
        $value = '';
        for($i = 1; $i < $parts; $i++)
        {
          $valueParts[] = trim($e[$i], '" ');
        }
        $value.= implode(':', $valueParts);
      }   
     
      $cleanValue = $this->unQuoteValue($value);
      $ary = [$key => $cleanValue];
     
      $this->addParserState('KEY_VALUE: '.$key.' => '.$cleanValue);
      return $ary;
    } 
  }

 /**
  * Parses command query, returns array with command name and params
  *
  * @param string $query Command single query
  *
  * @return mixed[] Array with command data
  */    
  private function getCommandFromQuery($query)
  {
    $haveParams = false;
    $paramsFromPos = null;
    $paramsStr = '';    
      
    $str = ltrim($query, '@');
    
    /* get command name */
    $cmdName = strstr($str, ' ', true);
    
    /* no space after command == no params */
    
    if($cmdName === false)
    {
      /* no params */
      $cmdName = $str;
      $haveParams = false;
    } else {        
      $paramsFromPos = strpos($str, ' ');        
      $paramsStr = trim(substr($str, $paramsFromPos, strlen($str)));
      $haveParams = true;
    }    
    
    /* gets params as array */
    $paramsAry = $this->parseCmdParams($paramsStr);    
    
    $data = [];
    $data['command'] = rtrim($cmdName, ';');
    $data['params'] = $paramsAry;  
    
    return $data;          
  } 
  
 /**
  * Returns command from query
  *
  * @param string $query raw query
  *
  * @return SkynetCommand Parsed command with params
  */    
  private function createCommand($query)
  {
     /* parse command data */
    $data = $this->getCommandFromQuery($query);    
       
    $numOfParams = count($data['params']);
    $this->addParserState('COMMAND: '.$data['command']);
    $this->addParserState('NUM OF PARAMS: '.$numOfParams);       
    
    /* new command */
    $command = new SkynetCommand($data['command']);
    
    /* if params */
    if(is_array($data['params']) && $numOfParams > 0)
    {
      /* loop on params */
      $tmpParams = [];
      foreach($data['params'] as $param)
      {                    
        $paramType = $this->getParamType($param);       
        $this->addParserState('PARAM: '.$param);
        $this->addParserState('PARAM_TYPE: '.$paramType);
        
        /* switch param type */
        switch($paramType)
        {
          case 'value':
          /* if single param add as string to command params array */
            $tmpParams[] = $param;
          break;
          
          case 'keyvalue':
            
          /* if key:value assignment add as array [key] => [value] */
            $tmpParams[] = $this->getParamKeyVal($param);            
          break;
        }
      }
      /* set parsed param to command */      
      $command->setParams($tmpParams);           
    }  
    
    return $command;     
  }
  
 /**
  * Returns key value pair array from param/query
  *
  * @param string $query raw query/param
  *
  * @return mixed[] Array [key] => value
  */   
  private function createParamRequest($query)
  {
    return $this->getParamKeyVal($query);   
  }
  
 /**
  * Explodes queries
  *
  * @param string $input
  *
  * @return string[] Queries
  */   
  private function explodeQuery($input)
  {
    if($this->isEndQuoted($input))
    {
      return array(0 => $input);
    } else {
      return explode(";\n", $input);  
    }      
  }

 /**
  * Checks if input is quoted
  *
  * @param string $input
  *
  * @return bool True if quoted
  */    
  private function isQuoted($input)
  {  
     if(preg_match('/^"{1}[^"]+"{1}$/', $input))
     {
       return true;
     }     
  }
 
 /**
  * Checks if input is endquoted
  *
  * @param string $input
  *
  * @return bool True if quoted
  */  
  private function isEndQuoted($input)
  {
    if(substr($input, -1) === '"' || substr($input, -1) === '\'' || substr($input, -1) === '";' || substr($input, -1) === '\';')
    {
      return true;
    }
  }

 /**
  * Unquotes input
  *
  * @param string $input
  *
  * @return string Cleaned string
  */   
  private function unQuote($input)
  {
    $len = strlen($input);
    if(substr($input, -1) === ';')
    {
      $input = rtrim($input, ';');
    }
    if(strpos($input, '"') === 0)
    {
      $input = trim($input, '"');
    }
    if(strpos($input, '\'') === 0)
    {
     $input = trim($input, '\'');
    } 
    return $input;
  }

 /**
  * Unquotes value
  *
  * @param string $input
  *
  * @return string Cleaned string
  */     
  private function unQuoteValue($input)
  {
    $len = strlen($input);    
    if(strpos($input, '"') === 0)
    {
      $input = trim($input, '"');
    }
    if(substr($input, -1) == '"')
    {
      $input = rtrim($input, '"');
    }
    if(strpos($input, '\'') === 0)
    {
     $input = trim($input, '\'');
    } 
    return $input;
  }
  
 /**
  * Parses input
  *
  * @param string $input Console input
  */    
  public function parseConsoleInput($input)
  {
    $querys = [];
    
    /* get input */
    $input = str_replace("\r\n", "\n", trim($input));  
    $input = $this->parseMultipleSpacesIntoSingle($input);
    
    if(substr($input, -1) != ';')
    {
      $input.= ';';
    }
    /* explode by ";" separator */
    $querys = $this->explodeQuery($input);
    
    $numOfQueries = count($querys);
    
    /* if queries */
    if($numOfQueries > 0)
    {
      $this->addParserState('Num of Queries: '.$numOfQueries);
      $i = 1;
      foreach($querys as $query)
      {
        $this->actualQueryNumber = $i;  
        
        $cleanQuery = trim($query);
        $queryType = $this->getQueryType($cleanQuery);
        
        /* switch query type */
        if($queryType !== false)
        {          
          $this->addParserState('Type: '.$queryType);   
            
          switch($queryType)
          {
              case 'cmd': 
                $command = $this->createCommand($cleanQuery);                 
                $this->consoleCommands[$command->getCode()] = $command;                
              break;              
              
              case 'param':
                $this->consoleRequests[] = $this->createParamRequest($cleanQuery);              
              break;            
          }          
        } else {
          $this->addParserState('Type: NOT RECOGNIZED. Ignoring...');
          $this->addParserError('TYPE NOT RECOGNIZED');          
        }        
        /* query counter */
        $i++;
      }
      //$this->debugger->dump($this->consoleCommands); 
      return true;
      
    } else {
      $this->addParserError('No queriws');
      return false;
    }
  }
  
 /**
  * Resets REQUEST
  */   
  public function clear()
  {
    $_REQUEST['_skynetCmdCommandSend'] = null;
    unset($_REQUEST['_skynetCmdCommandSend']);
  }
}

/**
 * Skynet/Console/SkynetConsoleInput.php
 *
 * @package Skynet
 * @version 1.1.2
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.2
 */

 /**
  * Skynet Console Input
  *
  * Parses user commands from webconsole
  */
class SkynetConsoleInput
{ 
  /** @var SkynetRequest Assigned request */
  private $request;
  
  /** @var SkynetResponse Assigned response */
  private $response; 
  
  /** @var bool Broadcast controller */
  private $startBroadcast;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetAuth Authentication */
  private $auth;
  
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;
  
  /** @var SkynetEventListenersLauncher Listeners Launcher */
  private $eventListenersLauncher;
  
  /** @var SkynetCli CLI Console */
  private $cli;
  
  /** @var SkynetConsole HTML Console */
  private $console;
  
  /** @var string[] Output from console */
  private $consoleOutput = [];
  
  /** @var string[] Addresses to connect */
  private $addresses = [];

 /**
  * Constructor
  */
  public function __construct()
  {    
    $this->verifier = new SkynetVerifier();
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->auth = new SkynetAuth();
    $this->cli = new SkynetCli();
    $this->console = new SkynetConsole();
    $this->request = new SkynetRequest();
    $this->response = new SkynetResponse();
    
    $this->eventListenersLauncher = new SkynetEventListenersLauncher();
    
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);
    $this->eventListenersLauncher->assignCli($this->cli);
    $this->eventListenersLauncher->assignConsole($this->console);
  }

 /**
  * Launchs CLI controller
  *
  * @return bool Start Broadcast or not
  */
  public function launch()
  {
    $this->startBroadcast = true;
    $this->prepareListeners();
    
    /* @connect command */
    if($this->auth->isAuthorized() && $this->console->isInput())
    {
      $this->console->parseConsoleInput($_REQUEST['_skynetCmdConsoleInput']);
      if($this->console->isConsoleCommand('connect'))
      {
        $this->startBroadcast = false;
        $connectData = $this->console->getConsoleCommand('connect');
        $connectParams = $connectData->getParams();
       
        if(count($connectParams) > 0)
        {
          foreach($connectParams as $param)
          {            
            if($this->verifier->isAddressCorrect($param))
            {              
              $this->addresses[] = $param;
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
      $toAll = false;
      $areAddresses = false;
      if($this->console->isAnyConsoleCommand())
      {
        $consoleCommands = $this->console->getConsoleCommands();
        foreach($consoleCommands as $command)
        {         
          if(!$this->console->isConsoleCommand('to') && $command != 'to')
          {
            $params = $command->getParams();        
            if(count($params) > 0)
            {    
              foreach($params as $param)
              {
                if(is_string($param) && $param == 'me')
                {
                  //$this->console->clear();
                  $areAddresses = true;
                  /* Launch Console commands listeners */
                  $this->prepareListeners();
                  $this->eventListenersLauncher->launch('onConsole');
                  $this->consoleOutput[] = $this->eventListenersLauncher->getConsoleOutput();                  
                  
                } elseif(is_string($param) && $param != 'all')
                {                
                  if($this->verifier->isAddressCorrect($param))
                  {                 
                    $this->startBroadcast = false;
                    $this->addresses[] = $param;
                    $areAddresses = true;
                  }  
                } elseif(is_string($param) && $param == 'all')
                {
                  $toAll = true;
                } else {
                  $toAll = true;
                }
              }           
            } 
          }
        }        
      } 
      if($toAll)
      {
        $this->startBroadcast = true;
      }
      if($areAddresses)
      {
        $this->startBroadcast = false;
      }
    } 
    
    return $this->startBroadcast;
  }
 
 /**
  * Returns addresses to connect
  *
  * @return string[] addresses list
  */  
  public function getAddresses()
  {
   return $this->addresses;   
  }

 /**
  * Returns signal to start broadcast
  *
  * @return bool True if start broadcast
  */  
  public function getStartBroadcast()
  {
    return $this->startBroadcast;
  } 

 /**
  * Returns console object
  *
  * @return SkynetConsole Console
  */  
  public function getConsole()
  {
    return $this->console;
  } 

 /**
  * Returns output from listeners
  *
  * @return string[] Output from console
  */  
  public function getConsoleOutput()
  {
    return $this->consoleOutput;
  }
  
 /**
  * Assigns data to listeners
  */ 
  private function prepareListeners()
  {
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);
    $this->eventListenersLauncher->assignConsole($this->console);
    //$this->eventListenersLauncher->assignConnectId($this->connectId);
    //$this->eventListenersLauncher->assignClusterUrl($this->clusterUrl);   
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

/**
 * Skynet/Core/Skynet.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

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
  private $connMode;

  /** @var SkynetDetector Clusters detector */
  private $clustersDetector;

  /** @var string[] Array of monits */
  private $monits = [];

  /** @var SkynetConnect Connect object */
  private $skynetConnect;
  
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
    
    $this->connMode = SkynetConfig::get('core_mode');

    $this->verifier->assignRequest($this->request);
    $this->modeController();

    /* Self-updater of Skynet */
    if(SkynetConfig::get('core_updater'))
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

    if($this->auth->isAuthorized() || $this->verifier->isOpenSender())
    {
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
    if($this->isSleeped() || $this->verifier->isPing() || $this->verifier->isDatabaseView() || isset($_REQUEST['@peer']) || (!$this->verifier->isOpenSender() && (!$this->auth->isAuthorized() || !$this->verifier->hasAdminIpAddress())))
    {
      return false;
    }

    $this->isBroadcast = true;
    $this->loadChain();
   
    /* Get clusters saved in db */
    if($this->areClusters())
    {
      $clustersNum = 0;      
      foreach($this->clusters as $cluster)
      {
        $clustersNum++;
        $this->cluster = $cluster;
        $this->assignConnId();        

        /* Prepare address */
        $address = SkynetConfig::get('core_connection_protocol').$this->cluster->getUrl();
        $this->clusterUrl = $address;

        /* If Key ID is verified and remote shows chain and we are not under other connection */
        if(!$this->verifier->isPing() && $this->verifier->isAddressCorrect($address))
        {         
          $this->connect($address, $this->skynetChain->getChain());         
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
        if($connect->getAddition())
        {
          $this->clusters[] = $connect->getCluster();
        } else {
          $this->clusters[$this->connectId - 1] = $connect->getCluster();
        }
        $this->isConnected = true;
      } elseif($connResult === null) 
      {
        if($connect->getAddition())
        {
          $this->clusters[] = $connect->getCluster();
        } else {
          $this->clusters[$this->connectId - 1]->getHeader()->setResult(0);
        }
      } elseif(!$connResult) 
      {
        if($connect->getAddition())
        {
          $this->clusters[] = $connect->getCluster();
        } else {
          $this->clusters[$this->connectId - 1]->getHeader()->setResult(-1);
        }
      }  

    } catch(SkynetException $e)
    {
      if($connect->getAddition())
      {
        $this->clusters[] = $connect->getCluster();
      } else {
        $this->clusters[$this->connectId - 1]->getHeader()->setResult(-1);
      }
      
      $this->addState(SkynetTypes::CONN_ERR, SkynetTypes::CONN_ERR.' : '. $connect->getConnection()->getUrl().$connect->getConnection()->getParams());
      $this->addError('Connection error: '.$e->getMessage(), $e);
    }
    $monits = $connect->getMonits();
    if(count($monits) > 0)
    {
      $this->monits = array_merge($this->monits, $monits);
    }
    $this->breakConnections = $connect->getBreakConnections();

    $data = $connect->getConnectionData();
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
    if($this->verifier->isPing() || !$this->verifier->hasAdminIpAddress())
    {
      return '';
    }
    
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
    if(!isset($_SESSION))
    {
      session_start();
    }
    if(!isset($_SESSION['_skynetOptions']))
    {
      $_SESSION['_skynetOptions'] = [];
      $_SESSION['_skynetOptions']['viewInternal'] = SkynetConfig::get('debug_internal');
      $_SESSION['_skynetOptions']['viewEcho'] = SkynetConfig::get('debug_echo');
      $_SESSION['_skynetOptions']['theme'] = SkynetConfig::get('core_renderer_theme');
    }
    
    if(isset($_REQUEST['_skynetSetConnMode']))
    {      
      $_SESSION['_skynetConnMode'] = (int)$_REQUEST['_skynetSetConnMode'];
    }

    if(isset($_SESSION['_skynetConnMode']))
    {
      $this->connMode = $_SESSION['_skynetConnMode'];
    }
    
    if(isset($_REQUEST['_skynetOptionViewInternalParams']))
    {      
      $_SESSION['_skynetOptions']['viewInternal'] = ($_REQUEST['_skynetOptionViewInternalParams'] == 1) ? true : false;
    }
    
    if(isset($_REQUEST['_skynetOptionViewEchoParams']))
    {      
      $_SESSION['_skynetOptions']['viewEcho'] = ($_REQUEST['_skynetOptionViewEchoParams'] == 1) ? true : false;
    }
    
    if(isset($_REQUEST['_skynetTheme']))
    {      
      $_SESSION['_skynetOptions']['theme'] = $_REQUEST['_skynetTheme'];
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
    if($this->verifier->isPing() || !$this->verifier->hasAdminIpAddress())
    {
      return '';
    }
    return $this->renderOutput();
  }
}

/**
 * Skynet/Core/SkynetChain.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Chain Value
  *
  * Stores identifier of current clusters state
  */
class SkynetChain
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var SkynetDatabase PDO connection instance */
  protected $db;

  /** @var bool Status of database connection */
  protected $dbConnected = false;

  /** @var bool Status of tables schema */
  protected $dbCreated = false;

  /** @var SkynetEncryptorInterface Encryptor instance */
  private $encryptor;

  /** @var SkynetVerifier Verifier instance */
  private $verifier;

  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;

  /** @var integer Actua chain value */
  private $chain;

  /** @var integer Time of last chain update */
  private $updated_at;

 /**
  * Constructor
  */
  public function __construct()
  {
    $dbInstance = SkynetDatabase::getInstance();
    $this->db_connected = $dbInstance->isDbConnected();
    $this->db_created = $dbInstance->isDbCreated();
    $this->db = $dbInstance->getDB();
    $this->encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $this->verifier = new SkynetVerifier();
    $this->clustersRegistry = new SkynetClustersRegistry();

    $this->updateMyChain();
    $this->showMyChain();
  }

 /**
  * Checks for reqest for show my chain
  *
  * @return bool True if is request for chain
  */
  public function isRequestForChain()
  {
    if(isset($_REQUEST['_skynet_chain_request'])) 
    {
      return true;
    }
  }

 /**
  * Encrypts data with encryptor
  *
  * @param string $str String to be encrypted
  * @return string Encrypted data
  */
  private function encrypt($str)
  {
    if(!SkynetConfig::get('core_raw'))
    {
      return $this->encryptor->encrypt($str);
    } else {
      return $str;
    }
  }

 /**
  * Decrypts data with encryptor
  *
  * @param string $str String to be decrypted
  * @return string Decrypted data
  */
  private function decrypt($str)
  {
    if(!SkynetConfig::get('core_raw'))
    {
      return $this->encryptor->decrypt($str);
    } else {
      return $str;
    }
  }
  
 /**
  * Generates hash
  */
  private function addHash()
  {
    $hash = sha1(SkynetHelper::getMyUrl().SkynetConfig::KEY_ID);
    return $hash;
  }

 /**
  * Shows cluster chain value and header as encoded JSON
  */
  public function showMyChain()
  {
    $ary = [];

    if($this->isRequestForChain())
    {
      if(!$this->verifier->isRequestKeyVerified())
      {
        exit;
      }

      if($this->isChain())
      {
        $this->loadChain();
        $ary['_skynet_chain'] = $this->encrypt($this->chain);
        $ary['_skynet_chain_updated_at'] = $this->encrypt($this->updated_at);
      } else {
        $ary['_skynet_chain'] = $this->encrypt('0');
        $ary['_skynet_chain_updated_at'] = $this->encrypt('0');
      }

      $ary['_skynet_hash'] = $this->encrypt($this->verifier->generateHash());

      /* Add header data */
      $ary['_skynet_id'] = $this->encrypt(SkynetConfig::KEY_ID);
      $ary['_skynet_cluster_url'] = $this->encrypt(SkynetHelper::getMyUrl());
      $ary['_skynet_cluster_ip'] = $this->encrypt($_SERVER['REMOTE_ADDR']);
      $ary['_skynet_version'] = $this->encrypt(SkynetVersion::VERSION);
      $ary['_skynet_clusters_chain'] = $this->encrypt($this->clustersRegistry->parseMyClusters());

      echo json_encode($ary);

      /* Stop execution when chain is rendered */
      exit;
    }
  }

 /**
  * Increments chain value and saves it in database
  *
  * @return bool True if success
  */
  public function newChain()
  {
    if(isset($_REQUEST['_skynet_cluster_url'])) 
    {
      return false;
    }
    $this->loadChain();
    $nextChain = $this->chain + 1;
    if($this->updateChain($nextChain)) 
    {
      return true;
    }
  }

 /**
  * Checks for chain update request and updates chain in database if request for update exists
  *
  * @return bool True if success
  */
  public function updateMyChain()
  {
    if(isset($_REQUEST['_skynet_chain_new']))
    {
      if(!$this->verifier->isRequestKeyVerified())
      {
        exit;
      }
      $newChain = intval($this->decrypt($_REQUEST['_skynet_chain_new']));
      $this->loadChain();

      if($newChain > $this->chain)
      {
        $this->updateChain($newChain);
        return true;
      }
    }
  }

 /**
  * Checks for chain data in database
  *
  * @return bool True if success
  */
  public function isChain()
  {
    try
    {
      $stmt = $this->db->prepare(
      'SELECT chain FROM skynet_chain WHERE id = 1');
      $stmt->execute();
      $result = $stmt->fetchColumn();
      $stmt->closeCursor();
      if($result > 0) 
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CHAIN, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

  
 /**
  * Creates chain in DB
  *
  * @return bool
  */
  public function createChain()
  {
    try
    {
      $stmt = $this->db->query(
      'INSERT INTO skynet_chain (id, chain, updated_at) VALUES(1, 0, 0)');
      $stmt->execute();
      return true;
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CHAIN, 'INSERT CHAIN ERROR : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
  
 /**
  * Loads and returns actual chain data from database
  *
  * @return string[] Row with chain data
  */
  public function loadChain()
  {
    try
    {
      $stmt = $this->db->prepare(
      'SELECT chain, updated_at FROM skynet_chain WHERE id = 1');
      $stmt->execute();
      $row = $stmt->fetch();
      $stmt->closeCursor();
      $this->chain = $row['chain'];
      $this->updated_at = $row['updated_at'];
      return $row;
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CHAIN, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Updates chain in database
  *
  * @param integer $chain New chain value
  * @return bool True if success
  */
  public function updateChain($chain = null)
  {
    try
    {      
      if($chain === null) 
      {
        $chain = $this->chain;
      }
      $time = time();
      $stmt = $this->db->prepare(
      'UPDATE skynet_chain SET chain = :chain, updated_at = :time WHERE id = 1');
      $stmt->bindParam(':chain', $chain, \PDO::PARAM_INT);
      $stmt->bindParam(':time', $time, \PDO::PARAM_INT);
      if($stmt->execute()) 
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CHAIN, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Returns chain value
  *
  * @return integer Chain value
  */
  public function getChain()
  {
    return $this->chain;
  }

 /**
  * Sets chain value
  *
  * @param integer
  */
  public function setChain($chain)
  {
    $this->chain = (int)$chain;
  }

 /**
  * Returns time when chain was updated
  *
  * @return integer Time in unix format
  */
   public function getUpdatedAt()
  {
    return $this->updated_at;
  }

 /**
  * Sets update time
  *
  * @param integer Time in unix format
  */
  public function setUpdatedAt($time)
  {
    $this->updated_at = $time;
  }
}

/**
 * Skynet/Core/SkynetConnect.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.1
 */

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

  /** @var SkynetDebug Debugger */
  private $debugger;

  /** @var bool Execute connection or not */
  private $doConnect;

  /** @var string Monits */
  private $monits = [];

  /** @var bool True if adding new to DB */
  private $addition = false;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->eventListenersLauncher = new SkynetEventListenersLauncher();
    $this->eventListenersLauncher->setSender(true);
    $this->eventListenersLauncher->assignRequest($this->request);
    $this->eventListenersLauncher->assignResponse($this->response);
    $this->eventListenersLauncher->assignCli($this->cli);
    $this->eventListenersLauncher->assignConsole($this->console);
    $this->connection = SkynetConnectionsFactory::getInstance()->getConnector(SkynetConfig::get('core_connection_type'));
    $this->verifier = new SkynetVerifier();
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->debugger = new SkynetDebug();
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
    $this->doConnect = true;

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

    $this->eventListenersLauncher->assignSenderClusterUrl(SkynetHelper::getMyUrl());
    $this->eventListenersLauncher->assignReceiverClusterUrl($this->cluster->getUrl());
    $this->prepareListeners();

    $this->prepareRequest($chain);

    if(!$this->doConnect)
    {
      return null;
    }

    $this->responseData = $this->sendRequest();

    if($this->responseData === null || $this->responseData === false)
    {
       $this->cluster->getHeader()->setResult(-1);
       throw new SkynetException(SkynetTypes::CONN_ERR);

    } else {

      $this->prepareResponse();
      $this->updateClusterHeader();
      $this->storeCluster();
      
      $this->eventListenersLauncher->assignSenderClusterUrl($this->cluster->getUrl());
      $this->eventListenersLauncher->assignReceiverClusterUrl(SkynetHelper::getMyUrl());
      $this->launchResponseListeners();
      $result = true;
    }

    $clustersMonits = $this->clustersRegistry->getMonits();
    if(count($clustersMonits) > 0)
    {
      $this->monits = array_merge($this->monits, $clustersMonits);
    }

    $listenersMonits = $this->eventListenersLauncher->getMonits();
    if(count($listenersMonits) > 0)
    {
      $this->monits[] = '<strong>Connection ('.$this->connectId.') '.$this->clusterUrl.':</strong>';
      $this->monits = array_merge($this->monits, $listenersMonits);
      $this->monits[] = '';
    }

    $this->saveConnectionData();
    return $this->isConnected;
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
    $id = $this->cluster->getHeader()->getId();

    /* Launch response listeners */
    if($this->cluster->getHeader()->getId() !== null && $this->verifier->isRequestKeyVerified($this->cluster->getHeader()->getId(), true, $this->response))
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
      if($this->clustersRegistry->isClusterBlocked($this->cluster))
      {
        $this->clustersRegistry->removeBlocked($this->cluster);
      }

      if($this->clustersRegistry->add($this->cluster))
      {
        $this->addition = true;
      }
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
      $clusterAddress = SkynetHelper::cleanUrl($this->clusterUrl);
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
    $this->isConnected = false;
    $this->connection->assignRequest($this->request);
    $this->adapter = $this->connection->connect();
    $this->responseData = $this->adapter['data'];
    if($this->adapter['result'] === true)
    {
      $this->isConnected = true;
    } else {
      $this->clustersRegistry->addBlocked($this->cluster);
      $this->cluster->getHeader()->setResult(-1);
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

    $requests = $this->request->getRequestsData();

     /* If specified receiver via [@to] */
    if(isset($requests['@to']))
    {
       $to = $this->request->get('@to');
       if(is_string($to))
       {
         if($this->verifier->isAddressCorrect($to))
         {
           if($this->clusterUrl != $to)
           {
             $this->doConnect = false;
           }
         }
       } elseif(is_array($to))
       {
          if(!in_array($this->clusterUrl, $to))
          {
            $this->doConnect = false;
          }
       }

       $to = $this->request->get('@to');
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
    'SENDED RAW DATA' => $this->adapter['params'],
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
  * Returns monits
  *
  * @return string[] Monits
  */
  public function getMonits()
  {
   return $this->monits;
  }

 /**
  * Returns if added to DB
  *
  * @return string[] Monits
  */
  public function getAddition()
  {
   return $this->addition;
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

/**
 * Skynet/Core/SkynetOutput.php
 *
 * @package Skynet
 * @version 1.1.1
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.1
 */

 /**
  * Skynet Event Listeners Launcher
  *
  */
class SkynetOutput
{     
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var SkynetRequest Assigned request */
  private $request;
  
  /** @var SkynetResponse Assigned response */
  private $response; 
  
  /** @var integer Actual connection number */
  private $connectId = 0; 
  
  /** @var SkynetCli CLI Console */
  private $cli;
  
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;
  
  /** @var SkynetEventListenersLauncher Listeners Launcher */
  private $eventListenersLauncher;
  
  /** @var SkynetChain SkynetChain instance */
  private $skynetChain;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetCluster Actual cluster */
  private $cluster = null; 
  
  /** @var SkynetAuth Authentication */
  private $auth;
  
  /** @var SkynetCluster[] Array of clusters */
  private $clusters = [];
  
  /** @var bool Status od connection with cluster */
  private $isConnected = false;
  
  /** @var bool Status of broadcast */
  private $isBroadcast = false;  
  
  /** @var SkynetOptions Options getter/setter */
  private $options;
  
  /** @var integer Connections finished with success */
  private $successConnections;
  
  /** @var integer Actual connection in broadcast mode */
  private $broadcastNum;
  
  /** @var bool Controller for break connections if specified receiver set */
  private $breakConnections = false;
  
  /** @var string[] Array with connections debug */
  private $connectionData = [];
 
  /** @var string[] Array of monits */  
  private $monits = [];
  
  /** @var string[] Array of console outputs */
  private $consoleOutput;
  
  /** @var string[] Array of cli outputs */
  private $cliOutput;
  
  /** @var bool If true then ajax output */ 
  private $inAjax = false;

 /**
  * Constructor
  */
  public function __construct()
  { 
    $this->verifier = new SkynetVerifier();
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->skynetChain = new SkynetChain();
    $this->options = new SkynetOptions();
    $this->cli = new SkynetCli();
    $this->auth = new SkynetAuth();
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
            return '';
          } else {
            $this->auth->checkAuth();
            return '';
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
    
    /* assign monits */
    if(count($this->monits) > 0)
    {
      foreach($this->monits as $monit)
      {
        $renderer->addMonit($monit);
      }    
    }

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
    
    $key = SkynetConfig::KEY_ID;
    if(!SkynetConfig::get('debug_key'))
    {
      $key = '****';
    }
    
    $encryptorAlgorithm = '';
    if(SkynetConfig::get('core_encryptor') == 'openSSL')
    {
      $encryptorAlgorithm = ' ('.SkynetConfig::get('core_encryptor_algorithm').')';
    }
    
    $renderer->setInAjax($this->inAjax);
    $renderer->setClustersData($this->clusters);
    $renderer->setConnectionsCounter($this->successConnections);
    $renderer->addField('My address', SkynetHelper::getMyUrl());
    $renderer->addField('Cluster IP', SkynetHelper::getServerIp());
    $renderer->addField('Your IP', SkynetHelper::getRemoteIp());
    $renderer->addField('Encryption', SkynetConfig::get('core_encryptor').$encryptorAlgorithm);
    $renderer->addField('Connections', SkynetConfig::get('core_connection_type').' | By '.SkynetConfig::get('core_connection_mode').' | '.SkynetConfig::get('core_connection_protocol'));    
    $renderer->addField('Broadcasting Clusters', $this->broadcastNum);
    $renderer->addField('Clusters in DB', $this->clustersRegistry->countClusters().' / '.$this->clustersRegistry->countBlockedClusters()); 
    $renderer->addField('Connection attempts', $this->connectId);
    $renderer->addField('Succesful connections', $this->successConnections);
    $renderer->addField('Chain', $chainData['chain'] . ' (updated: '.date('H:i:s d.m.Y', $chainData['updated_at']).')');
    $renderer->addField('Skynet Key ID', $key);
    $renderer->addField('Time now', date('H:i:s d.m.Y').' ['.time().']');  
    $renderer->addField('Sleeped', ($this->options->getOptionsValue('sleep') == 1) ? true : false);
    
    foreach($this->connectionData as $connectionData)
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
    foreach(SkynetConfig::getAll() as $k => $v)
    {
      $renderer->addConfigField($k, $v);
    }
    
    $renderer->setConsoleOutput($this->consoleOutput);
    $renderer->setCliOutput($this->cliOutput);
    
    return $renderer->render();
  } 

 /**
  * Sets monits
  *
  * @param string[] $monits
  */  
  public function setMonits($monits)
  {
    $this->monits = $monits;
  }

 /**
  * Sets connID
  *
  * @param int $connectId
  */    
  public function setConnectId($connectId)
  {
    $this->connectId = $connectId;
  }
 
 /**
  * Sets in ajax
  *
  * @param bool $ajax
  */  
  public function setInAjax($ajax)
  {
    $this->inAjax = $ajax;
  }
  
 /**
  * Sets clusters
  *
  * @param SkynetCluster[] $clusters
  */   
  public function setClusters($clusters)
  {
    $this->clusters = $clusters;
  }
 
 /**
  * Sets is broadcast
  *
  * @param bool $isBroadcast
  */   
  public function setIsBroadcast($isBroadcast)
  {
    $this->isBroadcast = $isBroadcast;
  }

 /**
  * Sets if is connected
  *
  * @param bool $isConnected
  */    
  public function setIsConnected($isConnected)
  {
    $this->isConnected = $isConnected;
  }
 
 /**
  * Sets connection data debug
  *
  * @param string[] $connectionData
  */   
  public function setConnectionData($connectionData)
  {
    $this->connectionData = $connectionData;
  }
 
 /**
  * Sets number of broadcasted
  *
  * @param int $broadcastNum
  */   
  public function setBroadcastNum($broadcastNum)
  {
    $this->broadcastNum = $broadcastNum;
  }
 
 /**
  * Sets successful connections
  *
  * @param int $successConnections
  */   
  public function setSuccessConnections($successConnections)
  {
    $this->successConnections = $successConnections;
  }

 /**
  * Sets console output
  *
  * @param string $consoleOutput
  */     
  public function setConsoleOutput($consoleOutput)
  {
    $this->consoleOutput = $consoleOutput;
  }
 
 /**
  * Sets cli output
  *
  * @param string $cliOutput
  */   
  public function setCliOutput($cliOutput)
  {
    $this->cliOutput = $cliOutput;
  }
  
 /**
  * __toString
  *
  * @return string Debug data
  */
  public function __toString()
  {   
    return (string)$this->renderOutput();
  }  
}

/**
 * Skynet/Core/SkynetPeer.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Peer
  *
  * Allows to sending Skynet requests inside another Skynet
  */
class SkynetPeer
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var SkynetRequest Request to send */
  private $request;
  
  /** @var SkynetConnectionInterface Connector instance */
  private $connection;
  
  /** @var string Received raw data */
  private $receivedData;

 /**
  * Constructor
  */
  public function __construct()
  {    
    $this->connection = SkynetConnectionsFactory::getInstance()->getConnector(SkynetConfig::get('core_connection_type'));
    $this->request = new SkynetRequest();
    $this->request->addMetaData();
  }

 /**
  * Connects to another Skynet
  *
  * @param string $address Cluster address
  *
  * @return string Received data
  */
  public function connect($address)  
  {     
    $this->request->set('@peer', 1);
    $this->connection->assignRequest($this->request);   
    $this->receivedData = $this->connection->connect($address);
    return $this->receivedData['data'];
  }
  
 /**
  * Assigns request to send
  *
  * @param SkynetRequest $request
  */
  public function assignRequest(SkynetRequest $request)
  {
    $this->request = clone $request;
  } 
  
 /**
  * Returns request
  *
  * @return SkynetRequest Request instance
  */
  public function getRequest()
  {
    return $this->request;
  }
}

/**
 * Skynet/Core/SkynetResponder.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

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

    $this->eventListenersLauncher->assignSenderClusterUrl($this->request->get('_skynet_sender_url'));
    $this->eventListenersLauncher->assignReceiverClusterUrl(SkynetHelper::getMyUrl());
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
    
    $this->eventListenersLauncher->assignSenderClusterUrl(SkynetHelper::getMyUrl());
    $this->eventListenersLauncher->assignReceiverClusterUrl($this->request->get('_skynet_sender_url'));
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

/**
 * Skynet/Data/SkynetField.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Field
  *
  * Internal datastructure of data with pairs key = value storing in response and request objects
  */
class SkynetField
{
  /** @var string Field name/key */
  private $name;

  /** @var string Field value */
  private $value;

  /** @var SkynetEncryptorInterface[] SkynetEncryptors registry */
  private $encryptorsRegistry = [];

  /** @var SkynetEncryptorInterface SkynetEncryptor instance */
  private $encryptor;

  /** @var bool|null Encryption status of value in field, null - none, false - decrypted, true - encrypted */
  private $isEncrypted = null;

 /**
  * Skynet Exception
  *
  * Operates on exceptions
  *
  * @param string|null $name Field name
  * @param mixed|null $value Field value
  * @param bool $encrypted Status of encryption
  */
  public function __construct($name = null, $value = null, $encrypted = null)
  {
    $this->encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $this->isEncrypted = $encrypted;

    $this->setName($name);
    $this->setValue($value);
  }

 /**
  * Encrypts data with encryptor
  *
  * @param string $str String to be encrypted
  * @return string Encrypted data
  */
  private function encrypt($str)
  {
    return $this->encryptor->encrypt($str);
  }

 /**
  * Decrypts data with encryptor
  *
  * @param string $str String to be decrypted
  * @return string Decrypted data
  */
  private function decrypt($str)
  {
    return $this->encryptor->decrypt($str);
  }

 /**
  * Returns field name/key
  *
  * @return string
  */
  public function getName()
  {
    return $this->name;
  }

 /**
  * Returns field value
  *
  * Depends on status (encrypted/decrypted) it returns value in states ways, encrypting or decrypting value "on fly"
  *
  * @return string
  */
  public function getValue()
  {
    if(SkynetConfig::get('core_raw') || $this->isEncrypted === null)
    {
      return $this->value;
    } elseif($this->isEncrypted === false)
    {
      return $this->encrypt($this->value);
    } else {
      return $this->decrypt($this->value);
    }
  }

 /**
  * Sets field name/key
  *
  * @param string $name
  */
  public function setName($name)
  {
    $this->name = $name;
  }

 /**
  * Sets field value
  *
  * Depends on status (encrypted/decrypted) it sets value in different states, encrypting or decrypting value "on fly"
  *
  * @param string $value
  */
  public function setValue($value)
  {
    if(SkynetConfig::get('core_raw') || $this->isEncrypted === null)
    {
      $this->value = $value;
    } elseif($this->isEncrypted === true)
    {
      $this->value = $this->decrypt($value);
    } else  {
      $this->value = $this->encrypt($value);
    }
  }

 /**
  * Sets encryption status
  *
  * Sets information about status of value: FALSE (decrypted), NULL (raw), TRUE (encrypted)
  *
  * @param bool|null $status
  */
  public function setIsEncrypted($status)
  {
    $this->isEncrypted = $status;
  }

 /**
  * Returns encryption status
  *
  * @return bool|null
  */
  public function getIsEncrypted()
  {
    return $this->isEncrypted;
  }

 /**
  * Generates string value of field
  *
  * @return string
  */
  public function __toString()
  {
    return '<b>'.$this->name.'</b>: '.$this->value;
  }
}

/**
 * Skynet/Data/SkynetParams.php
 *
 * @package Skynet
 * @version 1.1.4
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Command
  */
class SkynetParams
{  
 
  /** @var SkynetDebug Debugger */
  private $debugger;
  
  /**
  * Constructor
  */
  public function __construct()
  {
    $this->debugger = new SkynetDebug();
  }

 /**
  * Returns packed params
  *
  * @param mixed[] $params Params array
  *
  * @return string[]
  */  
  public function packParams($params)
  {       
    if($params === null || empty($params))
    {
      return false;
    } 
   
    if(!is_array($params))
    {
      return $params;
      
    } else {
      
      if(count($params) == 1)
      {        
        $key = key($params);
        
        if(!is_array($params[$key]) && is_numeric($key))
        {         
          return $params[$key];
        }
      }
    }
    
    $prefix = '';
    $paramsValues = [];
    $c = count($params);
    if($c > 0)
    {
      foreach($params as $p => $param)
      {
        if(is_array($param))
        {
          foreach($param as $k => $v)
          {
            /* pack into key:value string */
            $safeKey = $this->sanitizeVal($k);
            $safeValue = $this->sanitizeVal($v);
            $paramsValues[$safeKey] = $safeValue;
          }
          
        } else {
          
          if(is_numeric($p))
          {
            $paramsValues[$p] = str_replace(';', '', $param);
          } else {
            $safeKey = $this->sanitizeVal($p);
            $safeValue = $this->sanitizeVal($param);
            $paramsValues[$p] = $safeValue;            
          }
        }           
      }                
    }
    
    if($c > 0) 
    {
      $prefix = '$#';
    }
    return $prefix.serialize($paramsValues); 
  }

 /**
  * Returns unpacked params
  *
  * @param mixed $params Packed params string
  *
  * @return string[]
  */  
  public function unpackParams($params)
  {
    $params = preg_replace('/^\$#/', '', $params);
    
    $e = unserialize($params);
    
    if(count($e) < 1) 
    {
      return $params;
    }
    $fields = [];
    
    foreach($e as $element)
    {
      if(strpos($element, ':') !== false)
      {
        if(strpos($element, '://') === false)
        {
          /* key => val */
          $parts = explode(':', $element);
          $key = $parts[0];
          $val = $this->unsanitizeVal($parts[1]);
          $fields[] = [$key => $val];
        } else {
          $val = $this->unsanitizeVal($element);
          $fields[] = $val;
        }
        
      } else {
        /* var */
        $val = $element;
        $fields[] = $val;
      }
    }
    
    //var_dump($fields);    
    return $e;
  }

 /**
  * Sanitizes val
  *
  * @param string $input
  *
  * @return string
  */    
  private function sanitizeVal($input)
  {
    return str_replace(array('$#'), array('$$1$$'), $input);
  }
  
 /**
  * Unsanitizes val
  *
  * @param string $input
  *
  * @return string
  */    
  private function unsanitizeVal($input)
  {
    return str_replace(array('$$1$$'), array('$#'), $input);
  }
  
 /**
  * Checks for params is packed
  *
  * @param bool True if packed
  */  
  public function isPacked($params)
  {
    if(strpos($params, '$#') === 0) 
    {
      return true;
    }
  }
  
  public function isInternal($param)
  {
    if(strpos($param, '_') == 0)
    {
      return true;
    } elseif(strpos($param, '@_') == 0)
    {
      return true;
    }
  }
  
  public function translateInternalParam($param)
  {
    $keys = [];
    
    $keys['skynet'] = 'In Skynet';
    $keys['skynet_chain_new'] = 'New Chain value';
    $keys['skynet_clusters_chain'] = 'Clusters Chain';
    $keys['skynet_id'] = 'Skynet Key ID';
    $keys['skynet_ping'] = 'Ping (microtime)';
    $keys['skynet_hash'] = 'Hash';
    $keys['skynet_chain'] = 'Actual Chain value';
    $keys['skynet_chain_updated_at'] = 'Last update of Chain value';
    $keys['skynet_version'] = 'Skynet Version';
    $keys['skynet_cluster_url'] = 'Cluster address';
    $keys['skynet_cluster_ip'] = 'Cluster IP';
    $keys['skynet_cluster_time'] = 'Time of sent';
    $keys['skynet_clusters'] = 'Clusters chain';
    $keys['skynet_sender_time'] = 'Request sender time';
    $keys['skynet_sender_url'] = 'Request sender address';
    $keys['skynet_checksum'] = 'MD5 checksum';
    
    $prefix = '';
    
    $internal = '_'.$param;
    $internalEcho = '@_'.$param;
    
    if(strpos($param, '_') == 0)
    {
      $check = preg_replace('/^_/', '', $param);
    } elseif(strpos($param, '@_') == 0)
    {
      $check = preg_replace('/^@_/', '', $param);
      $prefix = '@>>';
    }
    
    if(array_key_exists($check, $keys))
    {
      return $prefix.$keys[$check];
    } else {
      return $param;
    }
  }
}

/**
 * Skynet/Data/SkynetRequest.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Request
  *
  * Stores and generates Requests
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetRequest
{
  use SkynetStatesTrait;

  /** @var SkynetField[] Array of request fields */
  private $fields = [];

  /** @var string[] Indexed array with requests data */
  private $requests = [];

  /** @var SkynetClustersRegistry SkynetClustersRegistry instance */
  private $clustersRegistry;
  
  /** @var clustersUrlsChain clustersUrlsChain instance */
  private $clustersUrlsChain;

  /** @var SkynetChain SkynetChain instance */
  private $skynetChain;

  /** @var SkynetEncryptorInterface SkynetEncryptor instance */
  private $encryptor;

  /** @var SkynetVerifier SkynetVerifier instance */
  private $verifier;
  
  /** @var SkynetParams Params Operations */
  protected $paramsParser;

 /**
  * Constructor
  *
  * @return SkynetRequest $this Instance of $this
  */
  public function __construct()
  {
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->clustersUrlsChain = new SkynetClustersUrlsChain();
    $this->skynetChain = new SkynetChain();
    $this->encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $this->verifier = new SkynetVerifier();
    $this->paramsParser = new SkynetParams();
    return $this;
  }  
  
 /**
  * Returns value of request field
  *
  * @param string $key Field key
  * @return string Value of requested field
  */
  public function get($key = null)
  {
    if($key !== null)
    {
      $this->reloadRequest();

      if(array_key_exists($key, $this->requests))
      {
        $field = $this->requests[$key];
        if($this->paramsParser->isPacked($field))
        {
           return $this->paramsParser->unpackParams($field);
        } else {
           return $field;
        }
       
      } else {
        return null;
      }
    }
  }
  
 /**
  * Quick alias for add new request field
  *
  * @param string $name Field name/key
  * @param string $value Field value
  *
  * @return SkynetRequest Instance of $this
  */
  public function add($name, $value)
  {
    return $this->set($name, $value);
  }
  
 /**
  * Quick alias to create new request field
  *
  * @param string $key Key of new request field
  * @param string $value Value of new request field
  *
  * @return SkynetRequest Instance of $this
  */
  public function set($key, $value)
  {
    if(is_array($value))
    {
       $this->addField($key, new SkynetField($key, $this->paramsParser->packParams($value)));
    } else {
       $this->addField($key, new SkynetField($key, $value));
    }
     
    return $this;
  }
  
 /**
  * Generates associative array with requests data indexed by keys of request fields
  *
  * @param bool $encrypted Sets mode for encryption: NULL - do nothing, FALSE - encrypt field, TRUE - decrypt field
  *
  * @return string[] Indexed requests
  */
  public function prepareRequests($encrypted = null)
  {
    $this->requests = [];
    $newFields = [];

    foreach($this->fields as $field)
    {
      $nowEncrypted = $field->getIsEncrypted();
      $field->setIsEncrypted($encrypted);
      $fieldKey = $field->getName();
      $fieldValue = $field->getValue();
      $this->requests[$fieldKey] = $fieldValue;
      $field->setIsEncrypted($nowEncrypted);
    }
    return $this->requests;
  }

 /**
  * Returns requests as array
  *
  * @return string[] Indexed requests
  */
  public function getRequests()
  {
    return $this->requests;
  }

 /**
  * Returns array with request fields objects
  *
  * @return SkynetField[] All request objects
  */
  public function getFields()
  {
    return $this->fields;
  }

 /**
  * Returns array with request fields objects and encrypt them
  *
  * @return SkynetField[] All request objects (encrypted)
  */
  public function getEncryptedFields()
  {
    if(SkynetConfig::get('core_raw'))  
    {
      return $this->fields;
    }

    $fields = [];
    foreach($this->fields as $field)
    {
      $key = $field->getName();
      $value = $field->getValue();     
      $fields[$key] = new SkynetField($key, $value);
      $fields[$key]->setIsEncrypted(false);
    }
    return $fields;
  }

 /**
  * Force reload and prepare requests
  */
  private function reloadRequest()
  {
    if(count($this->fields) == 0) 
    {
      $this->loadRequest();
    }
    $this->prepareRequests();
  }

 /**
  * Returns request fields as indexed array
  *
  * @return string[] All requests as indexed array
  */
  public function getRequestsData()
  {
    $fields = [];
    foreach($this->fields as $field)
    {
      $field->setIsEncrypted(null);
      $key = $field->getName();
      $value = $field->getValue();
      $fields[$key] = $value;
    }
    return $fields;
  }

 /**
  * Returns url of remote Skynet instance which was send request
  *
  * @return string Address of cluster
  */
  public function getSenderClusterUrl()
  {
    $url = $this->get('_skynet_cluster_url');

    /* If I'm sender */
    if(isset($_REQUEST['_skynet_cluster_url']))
    {
      if(SkynetConfig::get('core_raw'))
      {
        $url = $_REQUEST['_skynet_cluster_url'];
      } else {
        $url = $this->encryptor->decrypt($_REQUEST['_skynet_cluster_url']);
      }
    }

    /* If I'm receiver */
    if(isset($_REQUEST['_skynet_sender_url']))
    {
      if(SkynetConfig::get('core_raw'))
      {
        $url = $_REQUEST['_skynet_sender_url'];
      } else {
        $url = $this->encryptor->decrypt($_REQUEST['_skynet_sender_url']);
      }
    }
    return $url;
  }

 /**
  * Returns true if field exists in request
  *
  * @param string $key Name/key of request field
  *
  * @return bool If field exists return true
  */
  public function isField($key)
  {
    if(is_array($this->fields) && count($this->fields) > 0 && array_key_exists($key, $this->fields))
    {     
      return true;     
    }
  }

 /**
  * Adds internal skynet control data to request
  *
  * @param integer $chain New value of chain
  */
  public function addMetaData($chain = null)
  {
    if($chain !== null)
    {
      $this->set('_skynet_chain_new', $chain);
    }
    /* Prepare my header */
    $clusterHeader = new SkynetClusterHeader();
    $clusterHeader->generate();
    
    $milliseconds = round(microtime(true) * 1000);

    /* Create fields */
    $this->set('_skynet', 1);
    $this->set('_skynet_id', $clusterHeader->getId());
    $this->set('_skynet_ping', $milliseconds);
    $this->set('_skynet_hash', $this->verifier->generateHash());
    $this->set('_skynet_chain', $clusterHeader->getChain());
    $this->set('_skynet_chain_updated_at', $clusterHeader->getUpdatedAt());
    $this->set('_skynet_version', $clusterHeader->getVersion());
    $this->set('_skynet_cluster_url', $clusterHeader->getUrl());
    $this->set('_skynet_cluster_ip', $clusterHeader->getIp());
    $this->set('_skynet_cluster_time', time());   
    $this->set('_skynet_sender_time', time());
    $this->set('_skynet_sender_url', SkynetHelper::getMyUrl());
    
    if(SkynetConfig::get('core_urls_chain'))
    {
      $this->set('_skynet_clusters_chain', $this->clustersUrlsChain->parseMyClusters());
    }
  }

 /**
  * Loads requests data from GET and POST and put them as fields
  *
  * @return SkynetRequest Instance of $this
  */
  public function loadRequest()
  {
    if(is_array($_REQUEST) && count($_REQUEST) > 0)
    {
      foreach($_REQUEST as $key => $value)
      {
        $this->addField($key, new SkynetField($key, $value, true));
      }
    }
    return $this;
  }

 /**
  * Adds new field to request
  *
  * @param string $key Key
  * @param SkynetField $field New request field
  *
  * @return SkynetRequest Instance of $this
  */
  public function addField($key, SkynetField $field)
  {
    $this->fields[$key] = $field;
    return $this;
  }
}

/**
 * Skynet/Data/SkynetResponse.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Response
  *
  * Stores and generates Responses
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetResponse
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var SkynetField[] Array of response fields*/
  private $fields = [];

  /** @var SkynetField[] Array of raw response fields */
  private $rawFields = [];

  /** @var string[] Parsed connection params */
  private $params = [];

  /** @var SkynetRequest Assigned Request */
  private $request;

  /** @var string Raw data from connection */
  private $rawReceivedData;

  /** @var SkynetVerifier SkynetVerifier instance*/
  private $verifier;

  /** @var bool Is cluster received in response */
  private $receivedClusters;

  /** @var SkynetClustersRegistry SkynetClustersRegistry instance */
  private $clustersRegistry;

  /** @var SkynetClusterHeader SkynetClusterHeader instance */
  private $clusterHeader;
  
  /** @var clustersUrlsChain clustersUrlsChain instance */
  private $clustersUrlsChain;

  /** @var SkynetEncryptorInterface SkynetEncryptorInterface instance */
  private $encryptor;
  
  /** @var SkynetParams Params Operations */
  protected $paramsParser;
  
  /** @var SkynetChain SkynetChain instance */
  private $skynetChain;

 /**
  * Constructor
  *
  * @return SkynetResponse $this Instance of $this
  */
  public function __construct()
  {
    $this->verifier = new SkynetVerifier();
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->clusterHeader = new SkynetClusterHeader();
    $this->clustersUrlsChain = new SkynetClustersUrlsChain();
    $this->encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $this->paramsParser = new SkynetParams();
    $this->skynetChain = new SkynetChain();
    return $this;
  }
  
 /**
  * Quick alias for add new response field
  *
  * @param string $key Field name/key
  * @param string $value Field value
  *
  * @return SkynetResponse Instance of $this
  */
  public function add($key, $value)
  {
    return $this->set($key, $value);
  }

 /**
  * Quick alias for add new response field
  *
  * @param string $key Field name/key
  * @param string $value Field value
  *
  * @return SkynetResponse Instance of $this
  */
  public function set($key, $value)
  {
    if(is_array($value))
    {
       $this->addField($key, new SkynetField($key, $this->paramsParser->packParams($value)));
    } else {
       $this->addField($key, new SkynetField($key, $value));
    }
    return $this;
  }
  
 /**
  * Returns value of response field
  *
  * @param string $key Field key
  * @return string Value of requested field
  */
  public function get($key = null)
  {
    if($key !== null)
    {
      if(array_key_exists($key, $this->fields))
      {
        $field = $this->fields[$key];
        $value = $field->getValue();
        
        if($this->paramsParser->isPacked($value))
        {
           return $this->paramsParser->unpackParams($value);
        } else {
           return $value;
        }
       
      } else {
        return null;
      }
    }
  }

 /**
  * Sets raw received JSON data from connection
  *
  * @param string $data Raw received JSON data
  */
  public function setRawReceivedData($data)
  {
     $this->rawReceivedData = $data;
  }

 /**
  * Adds new response field
  *
  * @param string $key Key
  * @param SkynetField $field New response field
  */
  public function addField($key, SkynetField $field)
  {
    $this->fields[$key] = $field;
  }

 /**
  * Adds new RAW response field
  *
  * @param string $key Param key name
  * @param SkynetField $field New RAW response field
  */
  public function addRawField($key, SkynetField $field)
  {
    $this->rawFields[$key] = $field;
  }

 /**
  * Parses response from received JSON data *
  */
  public function parseResponse()
  {
    $json = json_decode($this->rawReceivedData);
    if($json !== null)
    {
      foreach($json as $k => $v)
      {
        $this->addField($k, new SkynetField($k, $v, true));
        $this->addRawField($k, new SkynetField($k, $v, null));
      }
      $this->isResponse = true;
    }
  }

 /**
  * Returns array with response fields
  *
  * @return SkynetField[] Array of response fields
  */
  public function getFields()
  {
    return $this->fields;
  }

 /**
  * Gets response fields as associative array indexed by keys
  *
  * @return string[] Indexed associative array with response fields
  */
  public function getResponseData()
  {
    $fields = [];
    foreach($this->fields as $field)
    {
      $name = $field->getName();
      $field->setIsEncrypted(null);
      $fields[$name] = $field->getValue();
      if($this->receivedClusters === null && $name == '_skynet_clusters')
      {
        $remoteData = [];
        $remoteData['_skynet_cluster_url'] = '';
        $remoteData['_skynet_clusters'] = $field->getValue();
        $this->receivedClusters = true;
      }
    }
    return $fields;
  }

 /**
  * Gets RAW response fields (without any encrypt/decrypt manipulations)
  *
  * @return SkynetField[] Raw response fields
  */
  public function getRawFields()
  {
    if(SkynetConfig::get('core_raw')) 
    {
      return $this->fields;
    }

    $fields = [];
    foreach($this->rawFields as $k => $v)
    {
      $fields[$k] = $v;
    }
    return $fields;
  }

 /**
  * Gets params used for connection
  *
  * @return string[] Array of connection params
  */
  public function getParams()
  {
    return $this->params;
  }

 /**
  * Adds request fields to response and prefix them with @
  */
  private function addMetaRequest()
  {
    $requests = $this->request->getRequests();
    foreach($requests as $k => $v)
    {
      if(strpos($k, '@') !== 0) 
      {
        $key = '@'.$k;
        $this->fields[$key] = new SkynetField($key, $v);
      }
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
  }

 /**
  * Adds internal skynet control data to request
  */
  private function addMetaData()
  {
    $clusterHeader = new SkynetClusterHeader();
    $clusterHeader->generate();
    
    $milliseconds = round(microtime(true) * 1000);
    
    $this->set('_skynet', 1);
    $this->set('_skynet_id', $clusterHeader->getId());
    $this->set('_skynet_ping', $milliseconds);
    $this->set('_skynet_hash', $this->verifier->generateHash());
    $this->set('_skynet_chain', $clusterHeader->getChain());
    $this->set('_skynet_chain_updated_at', $clusterHeader->getUpdatedAt());
    $this->set('_skynet_version', $clusterHeader->getVersion());
    $this->set('_skynet_cluster_url', $clusterHeader->getUrl());
    $this->set('_skynet_cluster_ip', $clusterHeader->getIp());
    $this->set('_skynet_cluster_time', time());
    
    if(SkynetConfig::get('core_urls_chain'))
    {
      $this->set('_skynet_clusters_chain', $this->clustersUrlsChain->parseMyClusters());
    }
  }

 /**
  * Generate JSON response from fields
  *
  * @param bool $force Forces JSON generation even if ID Key is incorrect
  *
  * @return string JSON encoded response
  */
  public function generateResponse($force = false)
  {
    /* If not authorized */
    if(!$this->verifier->isRequestKeyVerified() && !$force)
    {
      return false;
    }

    $this->addMetaData();
    if(SkynetConfig::get('response_include_request')) 
    {
      $this->addMetaRequest();
    }

    $ary = [];
    foreach($this->fields as $field)
    {
      $field->setIsEncrypted(false);
      $key = $field->getName();
      $value = $field->getValue();
      $ary[$key] = $value;
    }
    $ary['_skynet_checksum'] = $this->verifier->generateChecksum($ary);
    return json_encode($ary);
  }
}

/**
 * Skynet/Database/SkynetDatabase.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Database Connection
  *
  * Base class for database connection
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetDatabase
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var bool Status of database connection */
  protected $dbConnected = false;

  /** @var bool Status of tables schema */
  protected $dbCreated = false;

  /** @var SkynetDatabase Instance of this */
  private static $instance = null;
  
  /** @var string[] Array with table names */
  private $dbTables;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var PDO Connection */
  private $db;
  
  /** @var SkynetDatabaseOperations DB Methods */
  public $ops;

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}

 /**
  * Connects to database
  *
  * @return PDO
  */
  public function connect()
  {
    if($this->db !== null) 
    {
      return $this->db;
    }
    
    if(SkynetConfig::get('db_type') == 'sqlite')
    {
      if(empty(SkynetConfig::get('db_file')))
      {
        SkynetConfig::set('db_file', '.'.str_replace('.', '_', pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)).'.db');
      }

      if(!empty(SkynetConfig::get('db_file_dir')))
      {
        $db_path = SkynetConfig::get('db_file_dir');
        if(substr($db_path, -1) != '/') 
        {
          $db_path.= '/';
        }
        
        if(!is_dir($db_path)) 
        {
          try
          {
            if(mkdir($db_path))
            {
              SkynetConfig::set('db_file', $db_path.SkynetConfig::get('db_file'));
            } else {
              throw new SkynetException('ERROR CREATING DIR: '.$db_path);
            }
          } catch(SkynetException $e)
          {
            $this->addError(SkynetTypes::DB, 'DATABASE FILE DIR: '.$e->getMessage(), $e);
          }         
        }
      }
    }

    try
    {
       /* Try to connect... */
       if(SkynetConfig::get('db_type') != 'sqlite')
       {
         $dsn = SkynetConfig::get('db_type') .
         ':host=' . SkynetConfig::get('db_host') .
         ';port=' .SkynetConfig::get('db_port') .
         ';encoding=' . SkynetConfig::get('db_encoding') .
         ';dbname=' . SkynetConfig::get('db_dbname');
       } else {
         $dsn = SkynetConfig::get('db_type') .':'. SkynetConfig::get('db_file');
       }

       $options = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION);
       $this->db = new \PDO($dsn, SkynetConfig::get('db_user'),  SkynetConfig::get('db_password'), $options);
       $this->dbConnected = true;
       $this->addState(SkynetTypes::DB, SkynetTypes::DBCONN_OK.' : '. SkynetConfig::get('db_type'));

       
       $this->ops = new SkynetDatabaseOperations();
       $this->ops->setDb($this->db);
       
       /* Check for database schema */
       $this->ops->checkSchemas();
       $this->dbCreated = $this->ops->getDbCreated();

       return $this->db;

    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Returns Connection
  *
  * @return PDO PDO Connection object
  */
  public function getDB()
  {
    return $this->db;
  }

 /**
  * Returns instance of this
  *
  * @return SkynetDatabase
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
      self::$instance->connect();
    }
    return self::$instance;
  }

 /**
  * Checks for connection
  *
  * @return bool True if connected to database
  */
  public function isDbConnected()
  {
    return $this->dbConnected;
  }

 /**
  * Checks for database schema is created
  *
  * @return bool True if schema exists in database
  */
  public function isDbCreated()
  {
    return $this->dbCreated;
  }

 /**
  * Disconnects with database
  */
  public function disconnect()
  {
    $this->db = null;
  }
}

/**
 * Skynet/Database/SkynetDatabaseOperations.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.3
 */

 /**
  * Skynet Database Operations
  *
  * Base class for database ops
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetDatabaseOperations
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var string[] Array with table names */
  private $dbTables;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var bool Status of tables schema */
  protected $dbCreated = false;
  
  /** @var PDO Connection */
  private $db;

 /**
  * Constructor
  */
  public function __construct() 
  {   
  }

 /**
  * Returns table records count
  *
  * @param string $table Table name
  * 
  * @return int
  */  
  public function countTableRows($table)
  {
    $counter = 0;
    try
    {
      $stmt = $this->db->query('SELECT count(*) as c FROM '.$table.' LIMIT 200');     
      $stmt->execute();
      $row = $stmt->fetch();
      $counter = $row['c'];
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting records from database table: '.$table.' failed', $e);
      return false;
    }    
    return $counter;   
  }

 /**
  * Deletes record from table
  *
  * @param string $table Table name
  * @param int $id Record ID
  * 
  * @return bool
  */  
  public function deleteRecordId($table, $id)
  {    
    try
    {
      $stmt = $this->db->prepare('DELETE FROM '.$table.' WHERE id = :id');   
      $stmt->bindParam(':id', $id);        
      if($stmt->execute())
      {
        return true;
      }
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Error deleting [ID: '.$id.' ] from table: '.$table, $e);      
    }       
  }
  
 /**
  * Deletes all records from table
  *
  * @param string $table Table name
  * 
  * @return bool
  */  
  public function deleteAllRecords($table)
  {    
    try
    {
      $stmt = $this->db->query('DELETE FROM '.$table); 
      if($stmt->execute())
      {
        return true;      
      }
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Error deleting all records from table: '.$table, $e);      
    }       
  }
  
 /**
  * Returns rows from table
  *
  * @param string $table Table name
  * @param int $startFrom Limit offset
  * @param int $limitTo Limit
  * @param string $sortBy Sort by column
  * @param string $sortOrder Sort order ASC|DESC
  * 
  * @return mixed[] Record's rows
  */  
  public function getTableRows($table, $startFrom = null, $limitTo = null, $sortBy = null, $sortOrder = null)
  {
    $rows = [];
    $limit = '';
    $sort = ''; 
    $order = '';     
    if($limitTo !== null) 
    {
      $limit = ' LIMIT '.intval($startFrom).', '.intval($limitTo);
    }
    
    if($sortBy !== null) 
    {
      $sort = ' ORDER BY '.$sortBy;
    }
    
    if($sortOrder !== null) 
    {
      $order = ' '.$sortOrder;
    }
    
    try
    {
      $query = 'SELECT * FROM '.$table.$sort.$order.$limit;      
      $stmt = $this->db->query($query);     
      $stmt->execute();
           
      while($row = $stmt->fetch())
      {
        $rows[] = $row;
      }
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting records from database table: '.$table.' failed', $e);
      return false;
    }    
    return $rows;   
  } 

 /**
  * Updates row
  *
  * @param string $table Table name
  * @param int $id Record ID
  * @param mixed[] $data Data
  * 
  * @return bool True if success
  */   
  public function updateRow($table, $id, $data)
  {      
    $params = [];
    foreach($data as $k => $v)
    {
      $params[] = $k.'=:'.$k;      
    }
    $paramsSet = implode(',', $params);    
    $query =  'UPDATE '.$table.' SET '.$paramsSet.' WHERE id=:id';    
    
    try
    {
      $stmt = $this->db->prepare($query); 
      $stmt->bindValue(':id', $id);
      foreach($data as $k => $v)
      {
        $stmt->bindValue(':'.$k, $v);
      }
      
      if($stmt->execute())
      {
        return true;
      }
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Update record in table: '.$table.' failed', $e);
      return false;
    } 
  }  
 
 /**
  * Create record row
  *
  * @param string $table Table name
  * @param mixed[] $data Data
  * 
  * @return bool True if success
  */   
  public function newRow($table, $data)
  {      
    $params = [];
    $insert = [];
    foreach($data as $k => $v)
    {
      $params[] = ':'.$k;  
      $insert[] = $k;
    }
    $paramsSet = implode(',', $params);  
    $fieldsStr = implode(',', $insert);  
    $query =  'INSERT INTO '.$table.'('.$fieldsStr.') VALUES('.$paramsSet.')';    
    
    var_dump($query);
    
    try
    {
      $stmt = $this->db->prepare($query);       
      foreach($data as $k => $v)
      {
        $stmt->bindValue(':'.$k, $v);
      }
      
      if($stmt->execute())
      {
        return true;
      }
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'New record in table: '.$table.' failed', $e);
      return false;
    } 
  } 
  
 /**
  * Returns row from table
  *
  * @param string $table Table name
  * @param int $id Record ID
  * 
  * @return mixed[] Record's row
  */  
  public function getTableRow($table, $id)
  {   
    try
    {
      $query = 'SELECT * FROM '.$table.' WHERE id = :id';      
      $stmt = $this->db->prepare($query);   
      $stmt->bindParam(':id', $id);
      $stmt->execute();           
      $row = $stmt->fetch();
      $stmt->closeCursor();
      return $row;
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting record from database table: '.$table.' failed (id: '.$id.')', $e);
      return false;
    }  
  }
  
 /**
  * Checks database tables and creates schema if not exists
  *
  * @return bool
  */
  public function checkSchemas()
  {
    $error = false;
    $createQueries = [];
    $dbSchema = new SkynetDatabaseSchema();
    $createQueries = $dbSchema->getCreateQueries();

    foreach($createQueries as $table => $query)
    {
      if(!$this->isTable($table))
      {
        $error = true;
        if($this->createTable($query))
        {
          $error = false;
          $this->addState(SkynetTypes::DB, 'DATABASE TABLE ['.$table.'] CREATED');
        }
      }
    }

    if(!$error)
    {
      $this->dbCreated = true;
      $this->addState(SkynetTypes::DB, 'DATABASE SCHEMA IS CORRECT');
    }
  }

  public function getDbCreated()
  {
    return $this->dbCreated;
  }
  
 /**
  * Creates table in database
  *
  * @param string|string[] $queries Queries for schema creation
  *
  * @return bool
  */
  public function createTable($queries)
  {
    $i = 0;
    try
    {
      if(is_array($queries))
      {
        foreach($queries as $query)
        {
          $this->db->query($query);
          $i++;
        }
      } else {
         $this->db->query($queries);
         $i++;
      }
      return true;

    } catch (\PDOException $e)
    {
      $this->addState(SkynetTypes::DB, 'DATABASE SCHEMA NOT CREATED...');
      $this->addError(SkynetTypes::PDO, 'DATABASE SCHEMA BUILDING ERROR: Exception: '.$e->getMessage(), $e);
    }
  }

 /**
  * Checks for table exists
  *
  * @param string $table Table name
  *
  * @return bool
  */
  public function isTable($table)
  {
    try
    {
        $result = $this->db->query("SELECT 1 FROM ".$table." LIMIT 1");

    } catch (\PDOException $e)
    {
        $this->addState(SkynetTypes::DB, 'DATABASE TABLE: ['.$table.'] NOT EXISTS...TRYING TO CREATE...');
        return false;
    }
    return $result !== false;
  }

 /**
  * Sets DB
  *
  * @param PDO PDO Connection object
  */
  public function setDB($db)
  {
   $this->db = $db;
  } 
}

/**
 * Skynet/Database/SkynetDatabaseSchema.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.3
 */

 /**
  * Skynet Database Schema
  *
  * Database tables schema
  */
class SkynetDatabaseSchema
{  
  /** @var string[] Array with table names */
  private $dbTables = [];
  
  /** @var string[] Array with tables fields */
  private $tablesFields = [];  
    
  /** @var string[] Array with CREATE queries */
  private $createQueries = [];
  
  /** @var SkynetEventListenersInterface[] Array of Event Listeners */
  private $eventListeners = [];

  /** @var SkynetEventListenersInterface[] Array of Event Loggers */
  private $eventLoggers = [];

 /**
  * Constructor (private)
  */
  public function __construct() 
  {
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();
    $this->registerListenersTables();
  }
  
 /**
  * Registers tables from listeners
  */
  public function registerListenersTables()
  {
    $listenersData = [];
    
    foreach($this->eventListeners as $listener)
    {
      if(method_exists($listener, 'registerDatabase'))
      {
        $data = $listener->registerDatabase();  
        if(is_array($data) && isset($data['queries']) && isset($data['tables']) && isset($data['fields']))
        {
          $listenersData[] = $data;
        }
      }
    }
    foreach($this->eventLoggers as $listener)
    {
      if(method_exists($listener, 'registerDatabase'))
      {
        $data = $listener->registerDatabase(); 
        if(is_array($data) && isset($data['queries']) && isset($data['tables']) && isset($data['fields']))
        {
          $listenersData[] = $data;
        }
      }
    } 
    
    foreach($listenersData as $listenerData)
    {
      $this->createQueries = array_merge($this->createQueries, $listenerData['queries']);
      $this->dbTables = array_merge($this->dbTables, $listenerData['tables']);
      $this->tablesFields = array_merge($this->tablesFields, $listenerData['fields']);      
    }    
  }

 /**
  * Returns tables num
  *
  * @return int Num of tables
  */  
  public function countTables()
  {   
    return count($this->dbTables);
  }
  
 /**
  * Returns create queries
  *
  * @return string[] SQL Queries
  */   
  public function getCreateQueries()
  {   
    return $this->createQueries;
  }
  
 /**
  * Returns tables names
  *
  * @return string[]
  */   
  public function getDbTables()
  {
    return $this->dbTables;   
  }

 /**
  * Returns tables fields
  *
  * @return string[]
  */  
  public function getTablesFields()
  {   
    return $this->tablesFields;
  }
}

/**
 * Skynet/Database/SkynetGenerator.php
 *
 * Checking and veryfing access to skynet
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Generator
  *
  * TXT Generator
  */
class SkynetGenerator
{
  /** @var string Current table in Database view */
  protected $selectedTable;
  
  /** @var string[] Array with table names */
  protected $dbTables;
  
  /** @var SkynetDatabase DB Instance */
  protected $database;
  
  /** @var SkynetDatabaseSchema DB Schema */
  protected $databaseSchema;
  
  /** @var PDO Connection instance */
  protected $db;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier; 

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->database = SkynetDatabase::getInstance();   
    $this->databaseSchema = new SkynetDatabaseSchema;        
    $this->dbTables = $this->databaseSchema->getDbTables();   
    $this->tablesFields = $this->databaseSchema->getTablesFields();      
    $this->db = $this->database->connect();
    $this->verifier = new SkynetVerifier();
    
    if(isset($_REQUEST['_skynetGenerateTxtFromId']) && isset($_REQUEST['_skynetDatabase']))
    {
      $this->generateFromTable($_REQUEST['_skynetDatabase'], $_REQUEST['_skynetGenerateTxtFromId']);   
    }
  }

 /**
  * Generates TXT from record
  *
  * @param string $table Table
  * @param int $id Record ID
  */  
  private function generateFromTable($table, $id)
  {
    $row = $this->database->ops->getTableRow($table, $id);
    
    $fileName = date('Y-m-d_H-i-s').'_'.$table.'_'.$id.'.txt';
    $logFile = new SkynetLogFile('RECORD #ID '.$id);
    $logFile->setFileName($fileName);
    $logFile->setHeader('RECORD #ID '.$id.' FROM '.$table);

    foreach($this->tablesFields[$table] as $k => $v)
    {     
      $data = $row[$k];
      $logFile->addLine($this->parseLine($k, $data));
    }  
    
    $file = $logFile->save(null, false);
    
    if(!empty($file))
    {
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename='.$fileName);
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      echo $file;
      exit;
    }    
  }
  
   /**
  * Parse single line
  *
  * @param string $k Field name/key
  * @param string $v Field value
  * @param bool $force Force include if internal param
  *
  * @return string Parsed line
  */
  private function parseLine($k, $v, $force = false)
  {     
    $row = '';
    if(SkynetConfig::get('logs_txt_include_internal_data') || $force)
    {
       $row = "  ".$k.": ".$this->decodeIfNeeded($k, $v);
    } else {
       if(!$this->verifier->isInternalParameter($k)) 
       {
         $row = "  ".$k.": ".$this->decodeIfNeeded($k, $v);
       }
    }       
    return $row;
  }
  
  /**
  * Decodes value if encrypted
  *
  * @param string $key Field name/key
  * @param string $val Value
  *
  * @return string Decoded value
  */
  private function decodeIfNeeded($key, $val)
  {
    if(is_numeric($key)) 
    {
      return $val;
    }
    if($key == '_skynet_clusters' || $key == '@_skynet_clusters')
    {
      $ret = [];
      $clusters = explode(';', $val);
      foreach($clusters as $cluster)
      {
        $ret[] = base64_decode($cluster);
      }
      return implode('; ', $ret);
    }

    $toDecode = ['_skynet_clusters_chain', '@_skynet_clusters_chain'];
    if(in_array($key, $toDecode))
    {      
      return base64_decode($val);
    } else {     
      return $val;
    }
  }
}

/**
 * Skynet/Database/SkynetOptions.php
 *
 * Checking and veryfing access to skynet
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Core Options Registry
  */
class SkynetOptions
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var string Current table in Database view */
  protected $selectedTable;
  
  /** @var string[] Array with table names */
  protected $dbTables;
  
  /** @var SkynetDatabase DB Instance */
  protected $database;
  
  /** @var PDO Connection instance */
  protected $db;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
 

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->database = SkynetDatabase::getInstance();   
    $this->db = $this->database->connect();
    $this->verifier = new SkynetVerifier();   
  }

 /**
  * Check for key exists
  *
  * @param string $key Key
  *
  * @return bool
  */
  public function isOptionsKey($key)
  {
    try
    {
      $stmt = $this->db->prepare(
      'SELECT count(*) as c FROM skynet_options WHERE key = :key');
      $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();
      $stmt->closeCursor();
      if($result['c'] > 0)
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::OPTIONS, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Inserts new record
  *
  * @param string $key Key
  * @param string $value value
  *
  * @return bool
  */    
  public function insertOptionsKey($key, $value)
  {
    try
    {
        $id = SkynetConfig::KEY_ID;
        $time = time();        
        $stmt = $this->db->prepare('INSERT INTO skynet_options (skynet_id, created_at, key, content) VALUES(:skynet_id, :time, :key, :content)');
        $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':time', $time, \PDO::PARAM_INT);
        $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
        $stmt->bindParam(':content', $value, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->addState(SkynetTypes::OPTIONS, 'INSERTED NEW KEY: '.$key);
        return true;
      } else {
        $this->addState(SkynetTypes::OPTIONS, 'INSERT NEW KEY FAILED: '.$key);
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::OPTIONS, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Updates record
  *
  * @param string $key Key
  * @param string $value value
  *
  * @return bool
  */     
  public function setOptionsValue($key, $value)
  {
    if(!$this->isOptionsKey($key))
    {
      $this->insertOptionsKey($key, '');       
    }
    
    try
    {
        $id = SkynetConfig::KEY_ID;
        $time = time();        
        $stmt = $this->db->prepare('UPDATE skynet_options SET created_at = :time, content = :content WHERE key = :key');        
        $stmt->bindParam(':time', $time, \PDO::PARAM_INT);        
        $stmt->bindParam(':content', $value, \PDO::PARAM_STR);
        $stmt->bindParam(':key', $key, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->addState(SkynetTypes::OPTIONS, 'UPDATED KEY: '.$key);
        return true;
      } else {
        $this->addState(SkynetTypes::OPTIONS, 'UPDATE KEY FAILED: '.$key);
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::OPTIONS, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
 /**
  * Gets record value
  *
  * @param string $key Key
  *
  * @return mixed Value
  */    
  public function getOptionsValue($key)
  {
    if(!$this->isOptionsKey($key))
    {
      $this->insertOptionsKey($key, '');      
    }
    
    $content = '';
    try
    {
      $stmt = $this->db->prepare(
        'SELECT content FROM skynet_options WHERE key = :key'); 
      $stmt->bindParam(':key', $key);
      $stmt->execute();
      $row = $stmt->fetch();
      $content = $row['content'];
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Options: getting record for key ['.$key.'] failed', $e);
      return '';
    }    
    return $content;   
  }
}

/**
 * Skynet/Database/SkynetRegistry.php
 *
 * Checking and veryfing access to skynet
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Registry
  */
class SkynetRegistry
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var string Current table in Database view */
  protected $selectedTable;
  
  /** @var string[] Array with table names */
  protected $dbTables;
  
  /** @var SkynetDatabase DB Instance */
  protected $database;
  
  /** @var PDO Connection instance */
  protected $db;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
 

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->database = SkynetDatabase::getInstance();
    $this->db = $this->database->connect();
    $this->verifier = new SkynetVerifier();   
  }

 /**
  * Check for key exists
  *
  * @param string $key Key
  *
  * @return bool
  */
  public function isRegistryKey($key)
  {
    try
    {
      $stmt = $this->db->prepare(
      'SELECT count(*) as c FROM skynet_registry WHERE key = :key');
      $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();
      $stmt->closeCursor();
      if($result['c'] > 0)
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::REGISTRY, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Inserts new record
  *
  * @param string $key Key
  * @param string $value value
  *
  * @return bool
  */  
  public function insertRegistryKey($key, $value)
  {
    try
    {
        $id = SkynetConfig::KEY_ID;
        $time = time();        
        $stmt = $this->db->prepare('INSERT INTO skynet_registry (skynet_id, created_at, key, content) VALUES(:skynet_id, :time, :key, :content)');
        $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':time', $time, \PDO::PARAM_INT);
        $stmt->bindParam(':key', $key, \PDO::PARAM_STR);
        $stmt->bindParam(':content', $value, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->addState(SkynetTypes::REGISTRY, 'INSERTED NEW KEY:'.$key);
        return true;
      } else {
        $this->addState(SkynetTypes::REGISTRY, 'INSERT NEW KEY FAILED:'.$key);
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::REGISTRY, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Updates record
  *
  * @param string $key Key
  * @param string $value value
  *
  * @return bool
  */    
  public function setRegistryValue($key, $value)
  {
    if(!$this->isRegistryKey($key))
    {
      $this->insertRegistryKey($key, $value);
    }
    
    try
    {
        $id = SkynetConfig::KEY_ID;
        $time = time();        
        $stmt = $this->db->prepare('UPDATE skynet_registry SET created_at = :time, content = :content WHERE key = :key');              
        $stmt->bindParam(':time', $time, \PDO::PARAM_INT);        
        $stmt->bindParam(':content', $value, \PDO::PARAM_STR);
        $stmt->bindParam(':key', $key, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->addState(SkynetTypes::REGISTRY, 'UPDATED KEY:'.$key);
        return true;
      } else {
        $this->addState(SkynetTypes::REGISTRY, 'UPDATE KEY FAILED:'.$key);
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::REGISTRY, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
 /**
  * Gets record value
  *
  * @param string $key Key
  *
  * @return mixed Value
  */    
  public function getRegistryValue($key)
  {
    if(!$this->isRegistryKey($key))
    {
      $this->insertRegistryKey($key, ''); 
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
    
    $content = '';
    try
    {
      $stmt = $this->db->prepare(
        'SELECT content FROM skynet_registry WHERE key = :key'); 
      $stmt->bindParam(':key', $key);
      $stmt->execute();
      $row = $stmt->fetch();
      $content = $row['content'];
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Registry: getting record for key ['.$key.'] failed', $e);
      return '';
    }    
    return $content;   
  }
}

/**
 * Skynet/Core/SkynetDebug.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.3
 */

 /**
  * Skynet Debugger
  *
  */
class SkynetDebug
{     
  use SkynetErrorsTrait, SkynetStatesTrait; 

 /**
  * Constructor
  */
  public function __construct()
  {
        
  }  
 
 /**
  * Returns debug data
  *
  * @return string[] Debug
  */ 
  public function getData()
  {
    $this->newSession();    
    $output = [];
    
    $c = count($_SESSION['_skynetDebugger']);
    if($c > 0)
    {
      foreach($_SESSION['_skynetDebugger'] as $k => $v)
      {
        $output[$k] = ['title' => $v['title'], 'data' => $this->decorate($v['data'])];
      }    
    }
    
    return $output;    
  }

 /**
  * Adds div to output
  *
  * @param string $input
  *
  * @return string Output
  */   
  private function decorate($input)
  {
    return '<div class="debuggerField">'.$input.'</div>';    
  }

 /**
  * Resets debug fields
  */    
  public function resetDebug()
  {
    $_SESSION['_skynetDebugger'] = [];
  }

 /**
  * Dumps var
  *
  * @param mixed $var
  * @param string|null $name
  */    
  public function dump($var = null, $name = null)
  {
    if($name === null)
    {
      $file = debug_backtrace()[0]['file']; 
      $line = debug_backtrace()[0]['line'];    
      $name = '<b>'.basename($file).'</b><br>Line: '.$line;
    }
    
    $this->newSession();    
    ob_start(); 
    var_dump($var);
    $output = ob_get_clean();
    $this->addDebugField($output, $name);
  }
  
 /**
  * Adds debug text
  *
  * @param string $var
  */   
  public function txt($var = null)
  {    
    $file = debug_backtrace()[0]['file']; 
    $line = debug_backtrace()[0]['line'];    
    $name = '<b>'.basename($file).'</b><br>Line: '.$line;
     
    if(is_array($var))
    {
      $dbg = implode('<br>', $var);
    } elseif(is_string($var)) 
    {
      $dbg = $var;
    } else {
      $this->dump($var, $name);
      return false;
    }
    $this->addDebugField($dbg, $name);
  }

 /**
  * Counts debug fields
  *
  * @return int 
  */   
  public function countDebug()
  {
    $this->newSession(); 
    return count($_SESSION['_skynetDebugger']);    
  }

 /**
  * Adds debug to session
  *
  * @param mixed $debug
  * @param string|null $name
  */   
  private function addDebugField($debug, $name = null)
  {
    $data = ['title' => $name, 'data' => $debug];
    $_SESSION['_skynetDebugger'][] = $data;
    
    /*
    if($name === null)
    {
      $_SESSION['_skynetDebugger'][] = $debug;
    } else {
      $_SESSION['_skynetDebugger'][$name] = $debug;
    }   
    */
  }

 /**
  * Stats session if not exists
  */    
  private function newSession()
  {
    if(!isset($_SESSION))
    {
      session_start();
    } 
    if(!isset($_SESSION['_skynetDebugger']))
    {
      $_SESSION['_skynetDebugger'] = [];
    }
  }
}

/**
 * Skynet/Encryptor/SkynetEncryptorBase64.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Encryptor - base64
  *
  * Simple encryptor uses base64 to encrypt and decrypt sending data
  */
class SkynetEncryptorBase64 implements SkynetEncryptorInterface
{
 /**
  * Encrypts data
  *
  * @param string $str Data to encrypt
  *
  * @return string Encrypted data
  */
  public static function encrypt($str)
  {
    return base64_encode($str);
  }

 /**
  * Decrypts data
  *
  * @param string $str Data to decrypt
  *
  * @return string Decrypted data
  */
  public static function decrypt($str)
  {
    return base64_decode($str);
  }
}

/**
 * Skynet/Encryptor/SkynetEncryptorMcrypt.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.5
 */

 /**
  * Skynet Encryptor - Mcrypt
  *
  * Simple encryptor uses Mcrypt to encrypt and decrypt sending data
  */
class SkynetEncryptorMcrypt implements SkynetEncryptorInterface
{
 /**
  * Encrypts data
  *
  * @param string $str Data to encrypt
  *
  * @return string Encrypted data
  */
  public static function encrypt($decrypted)
  {    
    $key = md5(SkynetConfig::KEY_ID); 
    
    $mcrypt = mcrypt_module_open('rijndael-256', '', 'cbc', '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($mcrypt), MCRYPT_DEV_RANDOM); 
    $iv_base64 = base64_encode($iv);
    
    mcrypt_generic_init($mcrypt, $key, $iv);
    $encryptedData = mcrypt_generic($mcrypt, $decrypted);
    mcrypt_generic_deinit($mcrypt);
    mcrypt_module_close($mcrypt);        
    
    return base64_encode($iv_base64.base64_encode($encryptedData));
  }

 /**
  * Decrypts data
  *
  * @param string $str Data to decrypt
  *
  * @return string Decrypted data
  */
  public static function decrypt($encrypted)
  {
     $key = md5(SkynetConfig::KEY_ID);
     
     $encrypted = base64_decode($encrypted);
     if(strlen($encrypted) < 44 || empty($encrypted) || $encrypted === null)
     {
       return $encrypted;
     }     
     
     $str = base64_decode(substr($encrypted, 44));
     $iv = base64_decode(substr($encrypted, 0, 43).'==');
     
     if(strlen($iv) < 32)
     {
       return $encrypted;
     }
     
     $mcrypt = mcrypt_module_open('rijndael-256', '', 'cbc', '');
     mcrypt_generic_init($mcrypt, $key, $iv);
     $decryptedData = rtrim(mdecrypt_generic($mcrypt, $str), "\0\4");   
     mcrypt_generic_deinit($mcrypt);
     mcrypt_module_close($mcrypt);
     
     return $decryptedData;
  }
}

/**
 * Skynet/Encryptor/SkynetEncryptorOpenSSL.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.5
 */

 /**
  * Skynet Encryptor - OpenSSL
  *
  * Simple encryptor uses OpenSSL to encrypt and decrypt sending data
  */
class SkynetEncryptorOpenSSL implements SkynetEncryptorInterface
{
 /**
  * Encrypts data
  *
  * @param string $str Data to encrypt
  *
  * @return string Encrypted data
  */
  public static function encrypt($decrypted)
  {    
    $key = md5(SkynetConfig::KEY_ID); 
    $iv = openssl_random_pseudo_bytes(16);
    $iv_base64 = base64_encode($iv);    
    $encryptedData = @openssl_encrypt($decrypted, SkynetConfig::get('core_encryptor_algorithm'), $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);   
    return base64_encode($iv_base64.'$:::$'.base64_encode($encryptedData));
  }

 /**
  * Decrypts data
  *
  * @param string $str Data to decrypt
  *
  * @return string Decrypted data
  */
  public static function decrypt($encrypted)
  {
     $key = md5(SkynetConfig::KEY_ID);     
     $encrypted = base64_decode($encrypted);     
     $parts = explode('$:::$', $encrypted);
     if(count($parts) == 2)
     {
       $iv = base64_decode($parts[0]);
       $data = base64_decode($parts[1]);
       $decryptedData = @openssl_encrypt($data, SkynetConfig::get('core_encryptor_algorithm'), $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv); 
       return $decryptedData;        
     } else {       
       return $encrypted;
     }
  }
}

/**
 * Skynet/Encryptor/SkynetEncryptorsFactory.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Encryptors Factory
  *
  * Factory for encryptors. You can register here your own enryption classes
  */
class SkynetEncryptorsFactory
{
  /** @var SkynetEncryptorInterface[] Array of encryptors */
  private $encryptorsRegistry = [];

  /** @var SkynetEncryptorInterface Choosen encryptor instance */
  private $encryptor;

  /** @var SkynetEncryptorsFactory Instance of this */
  private static $instance = null;

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}

 /**
  * Registers encryptor classes in registry
  */
  private function registerEncryptors()
  {
    $this->register('openSSL', new SkynetEncryptorOpenSSL());
    $this->register('mcrypt', new SkynetEncryptorMcrypt());
    $this->register('base64', new SkynetEncryptorBase64());
  }

 /**
  * Returns choosen encryptor from registry
  *
  * @param string $name
  *
  * @return SkynetEncryptorInterface Encryptor
  */
  public function getEncryptor($name = null)
  {
    if($name === null)
    {
      $name = SkynetConfig::get('core_encryptor');
    }
    if(is_array($this->encryptorsRegistry) && array_key_exists($name, $this->encryptorsRegistry))
    {
      return $this->encryptorsRegistry[$name];
    }
  }

 /**
  * Registers encyptor in registry
  *
  * @param string $id name/key of encryptor
  * @param SkynetEncryptorInterface $class New instance of encryptor class
  */
  private function register($id, SkynetEncryptorInterface $class)
  {
    $this->encryptorsRegistry[$id] = $class;
  }

 /**
  * Returns instance
  *
  * @return SkynetEncryptorsFactory
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
      self::$instance->registerEncryptors();
    }
    return self::$instance;
  }
}

/**
 * Skynet/Error/SkynetError.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Error
  *
  * Stores internal errors
  */
class SkynetError
{
  /** @var integer Code */
  private $code;

  /** @var string Message */
  private $msg;

  /** @var integer Error/connect ID */
  private $errorId;
  
  /** @var \Exception Exception object */
  private $exception;

 /**
  * Constructor
  *
  * @param integer $code Error Code
  * @param string $msg Error Message
  * @param \Exception $exception Exception object
  */
  public function __construct($code, $msg, $exception = null)
  {
    $this->code = $code;
    $this->msg = $msg;
    $this->exception = $exception;
  }

 /**
  * Sets global errorsID
  *
  * @param integer $id
  */
  public function setErrorId($id)
  {
    $this->errorId = $id;
  }

 /**
  * Sets error code
  *
  * @param integer $code
  */
  public function setCode($code)
  {
    $this->code = $code;
  }

 /**
  * Sets error message
  *
  * @param string $msg
  */
  public function setMsg()
  {
    $this->msg = $msg;
  }

 /**
  * Returns error code
  *
  * @return integer
  */
  public function getCode()
  {
    return $this->code;
  }

 /**
  * Returns errorID
  *
  * @return integer
  */
  public function getErrorId()
  {
    return $this->errorId;
  }

 /**
  * Returns error message
  *
  * @return string
  */
  public function getMsg()
  {
    return $this->msg;
  }
  
 /**
  * Returns error Eception
  *
  * @return Exception
  */
  public function getException()
  {
    return $this->exception;
  }

 /**
  * Returns error as string
  *
  * @return string
  */
  public function __toString()
  {
    $id = '';
    if($this->errorId !== null) $id = '[@'.$this->errorId.'] ';
    return '<b>'.$id.$this->code.'</b>: '.$this->msg;
  }
}

/**
 * Skynet/Error/SkynetErrorsRegistry.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Errors Registry
  *
  * Registry stores all errors generates by Skynet
  */
class SkynetErrorsRegistry
{
  /** @var string[] Aray with errors */
  protected $errors = [];

  /** @var SkynetErrorsRegistry Instance of this */
  private static $instance = null;

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}

 /**
  * Returns instance of this
  *
  * @return SkynetErrorsRegistry
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
    }
    return self::$instance;
  }

 /**
  * Adds error message to registry
  *
  * @param SkynetError
  */
  public function addError(SkynetError $error)
  {
    $this->errors[] = $error;
  }

 /**
  * Returns stored errors as array
  *
  * @return string[]
  */
  public function getErrors()
  {
    return $this->errors;
  }

 /**
  * Checks for errors exists in registry
  *
  * @return bool True if are errors
  */
  public function areErrors()
  {
    if(count($this->errors) > 0) return true;
  }

 /**
  * Dump errors array
  *
  * @return string
  */
  public function dumpErrors()
  {
    $str = '';
    if(count($this->errors) > 0) $str = 'ERRORS:<br/>'.implode('<br/>', $this->errors);
    return $str;
  }
}

/**
 * Skynet/Error/SkynetException
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Exception
  *
  * Operates on exceptions
  */
class SkynetException extends \Exception
{
  use SkynetErrorsTrait;
 /**
  * Constructor
  *
  * @param mixed $message
  * @param integer $code
  * @param Exception|null $previous
  */
  public function __construct($message, $code = 0, \Exception $previous = null)
  {
    parent::__construct($message, $code, $previous);
    //$this->addError(SkynetTypes::EXCEPTION, 'SkynetException: '.$message, $this);
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerCli.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - CLI
  *
  * Gets requests from CLI
  */
class SkynetEventListenerCli extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{ 
  /** @var bool Status of input */
  private $inputReceived = false;

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
    $this->console = new SkynetConsole();
    $this->cli = new SkynetCli();
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
      if(($this->auth->isAuthorized() && $this->console->isInput()) || $this->cli->isCli())
      {       
        if(!$this->inputReceived)
        {
          if(!$this->cli->isCli())
          {
            /* HTML console */
            $this->console->parseConsoleInput($_REQUEST['_skynetCmdConsoleInput']);
            $this->inputReceived = true;
          } else {
            
            /* CLI */
            if($this->cli->isCommand('send'))
            {
              $cliParams = $this->cli->getParam('send');
              if(!empty($cliParams))
              {
                $cliParams = str_replace(array("'", "; "), array("\"", ";\n"), $cliParams);
                $this->console->parseConsoleInput($cliParams);               
                $this->inputReceived = true;
              }
            } else {
              return false;
            }
          }
        }
        /* get data from console */
        $commands = $this->console->getConsoleCommands();
        $requests = $this->console->getConsoleRequests();  
        
        /* add param requests */
        if(count($requests) > 0)
        {          
           /* assign data to request */
           foreach($requests as $request)
           {
              foreach($request as $k => $v)
              {
                $this->request->set($k, $v);
              }         
           }            
        } 

        /* add command requests */
        if(count($commands) > 0)
        {          
           /* assign data to request */
           foreach($commands as $command)
           {
              $cmdName = '@'.$command->getCode();
              $params = $command->getParams(); 
              
              $this->request->set($cmdName, $this->packParams($params)); 
           }            
        }        
      }
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
       echo $this->response->get('@cipka');
    }

    if($context == 'beforeSend')
    {      
      
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }   
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
    /* if compile */
    if($this->cli->isCommand('compile'))
    {       
      $compiler = new SkynetCompiler;
      return $compiler->compile('cli');
    }
    
    /* if keygen */
    if($this->cli->isCommand('keygen'))
    { 
      $keyGen = new SkynetKeyGen;    
      return $keyGen->show('cli');
    }
    
    /* if pwdgen */
    if($this->cli->isCommand('pwdgen'))
    { 
      $pwdGen = new SkynetPwdGen;    
      return $pwdGen->show('cli');
    }
    
    /* if check */
    if($this->cli->isCommand('check'))
    {       
      return 'Newest version available on GitHub: '.$this->checkNewestVersion().' | Your version: '.SkynetVersion::VERSION;
    }
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {        
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];    
    
    $cli[] = ['-debug', '', 'Displays connections full debug'];
    $cli[] = ['-dbg', '', 'Displays connections full debug (alias)'];
    $cli[] = ['-cfg', '', 'Displays configuration'];
    $cli[] = ['-status', '', 'Displays status'];
    $cli[] = ['-out', ['"field"', '"field1, field2..."'], 'Displays only specified fields returned from response'];
    $cli[] = ['-connect', 'address', 'Connects to single specified address'];
    $cli[] = ['-c', 'address', 'Connects to single specified address (alias)'];
    $cli[] = ['-broadcast', '', 'Broadcasts all addresses (starts Skynet)'];
    $cli[] = ['-b', '', 'Broadcasts all addresses (starts Skynet) (alias)'];
    $cli[] = ['-send', '"request params"', 'Sends request from command line, see documentation for syntax'];
    $cli[] = ['-db', 'table name', '[optional: page sortByColumn ASC', 'DESC Displays logs records from specified table in database'];
    $cli[] = ['-db', 'table name -del record ID', 'Erases record from database table'];     
    $cli[] = ['-db', 'table name -truncate', 'Erases ALL RECORDS from database table'];  
    $cli[] = ['-help', '', 'Displays this help'];
    $cli[] = ['-h', '', 'Displays this help (alias)'];
    $cli[] = ['-pwdgen', 'your password', 'Generates new password hash from plain password'];
    $cli[] = ['-keygen', '', 'Generates new SKYNET ID KEY'];
    $cli[] = ['-compile', '', 'Compiles Skynet sources to standalone file'];
    $cli[] = ['-check', '', 'Checks for new version on GitHub'];
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
  
 /**
  * Checks for new version on GitHub
  *
  * @return string Version
  */ 
  private function checkNewestVersion()
  {   
    $url = 'https://raw.githubusercontent.com/szczyglinski/skynet/master/VERSION';
    $version = @file_get_contents($url);
    if($version !== null)
    {
      return ' ('.$version.')';
    }   
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerCloner.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Cloner
  *
  * Clones Skynet to other locations
  */
class SkynetEventListenerCloner extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{ 
  /** @var SkynetCloner Clusters cloner */
  private $cloner;
  
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
    $this->cloner = new SkynetCloner();    
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
      /* Add returned new clones addresses into database */
      if($this->response->get('@<<clonesAddr') !== null)
      {
        $cloned = $this->response->get('@<<clonesAddr');        
        if(is_array($cloned))
        {
          $this->cloner->registerNewClones($cloned);
        } elseif(!empty($cloned)) 
        {
          $this->cloner->registerNewClones(array($cloned));
        }
       
        $monit = '[SUCCESS] New clones addresses: <br>';
        if(is_array($cloned))
        {
          $monit.= implode('<br>', $cloned);
        } else {
          $monit.= $cloned;
        }
        
        if($this->response->get('@<<clones') !== null)
        {
          $monit.= '<br>Clones connections: '.$this->response->get('@<<clones');
        }        
        $this->addMonit($monit);
      }      
    }

    if($context == 'beforeSend')
    { 
      if($this->request->get('@clone') !== null)
      {        
        $i = 0;
        
        /* Generate clones */
        $clones = $this->cloner->startCloning();            
        
        if($clones !== false && $clones !== null)
        {           
          /* Connect to every new clone, they will register this cluster, and others and resend clone command to next creates clones. */
          $skynetPeer = new SkynetPeer();
          $skynetPeer->getRequest()->set('@clone', 'all');
          $skynetPeer->getRequest()->set('@echo', 1);
          $data = '';                   
          foreach($clones as $address)
          {
            $data.= $skynetPeer->connect($address);
            $i++;
          }
          
          /* Return data about new clones.
             Connect to @clone command sender with @echo - so, @clone sender will resend info about this clones to another clusters via Peer */
          if($this->request->get('_skynet_sender_url') !== null)
          {
            $this->response->set('isSender', $this->request->get('_skynet_sender_url')); 
            
            $newRequest = new SkynetRequest();
            $newRequest->addMetaData(); 
            $newRequest->set('@echo', 1);
            $skynetPeer->assignRequest($newRequest);            
            $address = SkynetConfig::get('core_connection_protocol').$this->request->get('_skynet_sender_url');
            $skynetPeer->connect($address);            
          }
          
          $this->response->set('@<<clonesAddr', $clones);        
        }
        $this->response->set('@<<clones', $i);    
      }        
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }  
   
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {     
    if($this->console->isConsoleCommand('clone') && SkynetConfig::get('core_cloner'))
    {  
      $clones = $this->cloner->startCloning();
      if($clones !== false && $clones !== null)
      {                  
        $skynetPeer = new SkynetPeer();
        foreach($clones as $address)
        {
          $skynetPeer->connect($address);
        }        
      }                 
    }   
  } 

 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];    
    
    $console[] = ['@clone', ['me', 'cluster address', 'cluster address1, address2 ...'], 'no args=TO ALL'];   
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerClusters.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Cloner
  *
  * Clones Skynet to other locations
  */
class SkynetEventListenerClusters extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;
  
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
    $this->clustersRegistry = new SkynetClustersRegistry();
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
    
    if($context == 'afterReceive')
    {
      if($this->request->get('_skynet_clusters') !== null)
      {
        $clustersAry = explode(';', $this->request->get('_skynet_clusters'));
        if(count($clustersAry) > 0)
        {
          foreach($clustersAry as $clusterAddress)
          {
            $decodedAddr = base64_decode($clusterAddress);            
            $cluster = new SkynetCluster();
            $cluster->setUrl($decodedAddr);
            $cluster->fromRequest($this->request);
            $cluster->getHeader()->setUrl($decodedAddr);
            $this->clustersRegistry->add($cluster);            
          }         
        }
      }
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
      if($this->response->get('_skynet_clusters') !== null && $this->request->get('@<<reset') === null)
      {
        $clustersAry = explode(';', $this->response->get('_skynet_clusters'));
        
        if(count($clustersAry) > 0)
        {
          foreach($clustersAry as $clusterAddress)
          {
            $decodedAddr = base64_decode($clusterAddress);      
            $cluster = new SkynetCluster();
            $cluster->setUrl($decodedAddr);
            $cluster->fromResponse($this->response);
            $cluster->getHeader()->setUrl($decodedAddr);
            $this->clustersRegistry->add($cluster);            
          }         
        }
      }
    }

    if($context == 'beforeSend')
    { 
      if($this->request->get('@reset') !== null && $this->request->get('_skynet_sender_url') !== null)
      {
        $u = SkynetHelper::getMyUrl();       
        if($this->clustersRegistry->removeAll($this->request->get('_skynet_sender_url')))
        {
          $this->response->set('@<<reset', 'DELETED');
        } else {          
          $this->response->set('@<<reset', 'NOT DELETED');
        }
      }
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }     
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];
    $console[] = ['@add', ['cluster address', 'cluster address1, address2 ...'], ''];   
    $console[] = ['@connect', ['cluster address', 'cluster address1, address2 ...'], ''];  
    $console[] = ['@to', 'cluster address', ''];
    $console[] = ['@reset', ['cluster address', 'cluster address1, address2 ...'], ''];    
    
    return array('cli' => $cli, 'console' => $console);    
  }
  
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    
    $queries['skynet_clusters'] = 'CREATE TABLE skynet_clusters (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), url TEXT, ip VARCHAR (15), version VARCHAR (6), last_connect INTEGER, registrator TEXT)';
    $queries['skynet_clusters_blocked'] = 'CREATE TABLE skynet_clusters_blocked (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), url TEXT, ip VARCHAR (15), version VARCHAR (6), last_connect INTEGER, registrator TEXT)';    
    $queries['skynet_chain'] = ['CREATE TABLE skynet_chain (id INTEGER PRIMARY KEY AUTOINCREMENT, chain BIGINT, updated_at INTEGER)', 'INSERT INTO skynet_chain (id, chain, updated_at) VALUES(1, 0, 0)'];
    
    $tables['skynet_clusters'] = 'Clusters';
    $tables['skynet_clusters_blocked'] = 'Clusters (corrupted/blocked)';   
    $tables['skynet_chain'] = 'Chain';   
    
    $fields['skynet_clusters'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'url' => 'URL Address',
    'ip' => 'IP Address',
    'version' => 'Skynet version',
    'last_connect' => 'Last connection',
    'registrator' => 'Added by'
    ];
    
    $fields['skynet_clusters_blocked'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'url' => 'URL Address',
    'ip' => 'IP Address',
    'version' => 'Skynet version',
    'last_connect' => 'Last connection',
    'registrator' => 'Added by'
    ];    
    
    $fields['skynet_chain'] = [
    'id' => '#ID',
    'chain' => 'Current Chain Value',
    'updated_at' => 'Last update'
    ];   
    
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerEcho.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Echo
  *
  * Creates and operates on Echo and Broadcast Requests
  */
class SkynetEventListenerEcho extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')  { }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive') { }

    if($context == 'beforeSend')  { }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      /* Ping to all my clusters */
      $this->pingAll($context);
      foreach($this->requestsData as $k => $v)
      {
        /* If not internal skynet param */
        if(strpos($k, '_skynet') !== 0 && strpos($k, '_skynet') !== 1 && strpos($k, '<<') !== 0 && strpos($k, '<<') !== 1)
        {
          /* Then resend Request */
          $this->response->set($k, $v);
        }
      }
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      if($this->request->get('@broadcast') == 1) 
      {
        return false;
      }
      $this->pingAll($context);
    }   
  }  
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];    
    
    $console[] = ['@echo', ['cluster address', 'cluster address1, address2 ...'], 'TO ALL'];  
    $console[] = ['@broadcast', ['cluster address', 'cluster address1, address2 ...'], 'TO ALL'];     
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }

 /**
  * Sends echo and broadcast messages
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  private function pingAll($context)
  {
    
    /* Must been launch "beforeSend" IN RESPONDER (before sending Response). 
    Echo is sending from Peer to next clusters with request to another echo - clusters sends next echo via own Peers when responding on request from here. 
    No response is generated here, cluster don't show response data on echo.  */
    if($context != 'beforeSend' || $this->opt_get('sleep') == 1) 
    {
      return false;
    }

    /* prepare/check already visited clusters chain */
    $urlsChain = new SkynetClustersUrlsChain();
    $urlsChain->assignRequest($this->request);

    $urlsChain->loadFromRequest();
    if($urlsChain->isMyClusterInChain()) 
    {
      return false;
    }

    $urlsChain->addMyClusterToChain();
    if(!$urlsChain->isSenderClusterInChain()) 
    {
      $urlsChain->addSenderClusterToChain();
    }
    $newPingedChainRaw = $urlsChain->getClustersUrlsChain();

    /* get clusters */
    $connectAddresses = [];
    $rawAddresses = [];
    $clustersRegistry = new SkynetClustersRegistry();
    $clusters = $clustersRegistry->getAll();
    if(count($clusters) > 0)
    {
      foreach($clusters as $cluster)
      {
        if($cluster->getUrl() != $this->request->getSenderClusterUrl() && !$urlsChain->isClusterInChain($cluster->getUrl()))
        {
          $rawAddresses[] = $cluster->getUrl();
          $connectAddresses[] = SkynetConfig::get('core_connection_protocol').$cluster->getUrl();
        }
      }

       if(is_array($connectAddresses) && count($connectAddresses) > 0)
       {
         $skynetPeer = new SkynetPeer();
         $skynetPeer->getRequest()->set('_skynet_clusters_chain', $newPingedChainRaw);         

          /* If in echo mode */
          if($this->request->get('@echo') == 1) 
          {
            $skynetPeer->getRequest()->set('@echo', 1);
          }

          /* If in broadcast mode */
          if($this->request->get('@broadcast') == 1)
          {
            $broadcastedRequests = [];
            foreach($this->requestsData as $k => $v)
            {
              /* If not internal skynet param */
              if(!$this->verifier->isInternalParameter($k))
              {
                $skynetPeer->getRequest()->set($k, $v);
                $this->response->set($k, $v);
                $broadcastedRequests[$k] = $v;
              }
            }
            $skynetPeer->getRequest()->set('@broadcast', 1);
          }

          /* Connect to clusters */
          $data = '';
          foreach($connectAddresses as $address)
          {
             $data.= $skynetPeer->connect($address);
          }
          
          /* No reponse is send */
          $this->response->set('FromEcho', $data);   

          
          /* Save logs */
          if($this->request->get('@echo') == 1)
          {
            if(SkynetConfig::get('logs_db_echo'))
            {
              $logger = new SkynetEventListenerLoggerDatabase();
              $logger->assignRequest($this->request);
              $logger->setRequestData($this->requestsData);
              if($logger->saveEchoToDb($rawAddresses, $urlsChain))
              {
                $this->addState(SkynetTypes::STATUS_OK, 'ECHO SAVED TO DB');
              }
            }

            if(SkynetConfig::get('logs_txt_echo'))
            {
              $logger = new SkynetEventListenerLoggerFiles();
              $logger->assignRequest($this->request);
              $logger->setRequestData($this->requestsData);
              if($logger->saveEchoToFile($rawAddresses, $urlsChain))
              {
                $this->addState(SkynetTypes::STATUS_OK, 'ECHO SAVED TO TXT');
              }
            }
          }

          if($this->request->get('@broadcast') == 1)
          {
            if(SkynetConfig::get('logs_db_broadcast'))
            {
              $logger = new SkynetEventListenerLoggerDatabase();
              $logger->assignRequest($this->request);
              $logger->setRequestData($this->requestsData);
              if($logger->saveBroadcastToDb($rawAddresses, $urlsChain))
              {
                $this->addState(SkynetTypes::STATUS_OK, 'BROADCAST SAVED TO DB');
              }
            }

            if(SkynetConfig::get('logs_txt_broadcast'))
            {
              $logger = new SkynetEventListenerLoggerFiles();
              $logger->assignRequest($this->request);
              $logger->setRequestData($this->requestsData);
              if($logger->saveBroadcastToFile($rawAddresses, $urlsChain, $broadcastedRequests))
              {
                $this->addState(SkynetTypes::STATUS_OK, 'BROADCAST SAVED TO TXT');
              }
            }
          }
       }
    }
    
    if($this->request->get('@echo') == 1) 
    {
      $this->response->set('@echo', '1');
    }
    if($this->request->get('@broadcast') == 1) 
    {
      $this->response->set('@broadcast', '1');
    }
    $this->response->set('_skynet_clusters_chain', $newPingedChainRaw);
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerExec.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Exec
  *
  * Skynet Exec & System
  */
class SkynetEventListenerExec extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{  
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();   
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
    
    if($context == 'afterReceive')
    {
      /* exec() */
      if($this->request->get('@exec') !== null)
      {
        if(!isset($this->request->get('@exec')['cmd']))
        {
          $this->response->set('@<<exec', 'COMMAND IS NULL');
          return false;
        }
        $cmd = $this->request->get('@exec')['cmd'];
        $return = null;
        $output = [];                
        $result = @exec($cmd, $output, $return);
        $this->response->set('@<<execResult', $result);
        $this->response->set('@<<execReturn', $return); 
        $this->response->set('@<<execOutput', $output); 
        $this->response->set('@<<exec', $this->request->get('@exec')['cmd']);
      } 

      /* system() */
      if($this->request->get('@system') !== null)
      {
        if(!isset($this->request->get('@system')['cmd']))
        {
          $this->response->set('@<<system', 'COMMAND IS NULL');
          return false;
        }
        $cmd = $this->request->get('@system')['cmd']; 
        $return = null;        
        $result = @system($cmd, $return);
        $this->response->set('@<<systemResult', $result);
        $this->response->set('@<<systemReturn', $return);        
        $this->response->set('@<<system', $this->request->get('@system')['cmd']);
      } 
      
      /* proc_open() */
      if($this->request->get('@proc') !== null)
      {
        if(!isset($this->request->get('@proc')['proc']))
        {
          $this->response->set('@<<proc', 'COMMAND IS NULL');
          return false;
        }
        
        $proc = $this->request->get('@proc')['proc']; 
        $return = null;   
        
        $descriptorspec = array(
            0 => array('pipe', 'r'), 
            1 => array('pipe', 'w'), 
            2 => array('pipe', 'w') 
        );

        $process = proc_open($proc, $descriptorspec, $pipes);

        if(is_resource($process)) 
        {   
          $result = stream_get_contents($pipes[1]);
          fclose($pipes[0]);
          fclose($pipes[1]);   
          fclose($pipes[2]);
          $return = proc_close($process);
        }
        
        $this->response->set('@<<procResult', $result);
        $this->response->set('@<<procReturn', $return);        
        $this->response->set('@<<proc', $this->request->get('@proc')['proc']);
      }  

      /* eval() */
      if($this->request->get('@eval') !== null)
      {
        if(!isset($this->request->get('@eval')['php']))
        {
          $this->response->set('@<<eval', 'PHP CODE IS NULL');
          return false;
        }
        $php = $this->request->get('@eval')['php'];  
        
        $result = @eval($php);
        $this->response->set('@<<evalReturn', $result); 
        $this->response->set('@<<eval', $this->request->get('@eval')['php']);
      } 
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
      /* exec */
      if($this->response->get('@<<exec') !== null)
      {        
        $this->addMonit('[EXEC CMD] exec($cmd, , ): '.$this->response->get('@<<exec'));
      }
      if($this->response->get('@<<execReturn') !== null)
      {        
        $this->addMonit('[EXEC RETURN] exec( , , $return): '.$this->response->get('@<<execReturn'));
      }
      if($this->response->get('@<<execResult') !== null)
      {        
        $this->addMonit('[EXEC RESULT] $result = exec(): '.$this->response->get('@<<execResult'));
      }
      if($this->response->get('@<<execOutput') !== null)
      {        
        $output = $this->response->get('@<<execOutput');
        if(is_array($output))
        {
          $output = '<br>'.implode('<br>', $output);
        }
        $this->addMonit('[EXEC OUTPUT] exec( , $output[], ): '.$output);
      }
      
      
      /* system */
      if($this->response->get('@<<system') !== null)
      {        
        $this->addMonit('[SYSTEM CMD] system($cmd, ): '.$this->response->get('@<<system'));
      }
      if($this->response->get('@<<systemReturn') !== null)
      {        
        $this->addMonit('[SYSTEM RETURN] system( , $return): '.$this->response->get('@<<systemReturn'));
      }
      if($this->response->get('@<<systemResult') !== null)
      {        
        $this->addMonit('[SYSTEM RESULT] $result = system(): '.$this->response->get('@<<systemResult'));
      }
      
      /* proc */
      if($this->response->get('@<<proc') !== null)
      {        
        $this->addMonit('[PROCESS] proc_open($proc, , ): '.$this->response->get('@<<proc'));
      }
      if($this->response->get('@<<procReturn') !== null)
      {        
        $this->addMonit('[PROCESS RETURN] $return = proc_close($proc): '.$this->response->get('@<<procReturn'));
      }
      if($this->response->get('@<<procResult') !== null)
      {        
        $output = $this->response->get('@<<procResult');
        if(is_array($output))
        {
          $output = '<br>'.implode('<br>', $output);
        }
        $this->addMonit('[PROCESS RESULT] $result = stream_get_contents():<br>'.$output);
      }
      
      /* eval */
      if($this->response->get('@<<eval') !== null)
      {        
        $this->addMonit('[EVAL]: '.$this->response->get('@<<eval'));
      }
      if($this->response->get('@<<evalReturn') !== null)
      {        
        $output = $this->response->get('@<<evalReturn');
        if(is_array($output))
        {
          $output = '<br>'.implode('<br>', $output);
        }
        $this->addMonit('[EVAL RETURN]:<br>'.$output);
      }
    }

    if($context == 'beforeSend')
    {      
      
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }     
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];
    $console[] = ['@exec', 'cmd:"commands_to_execute"', ''];     
    $console[] = ['@system', 'cmd:"commands_to_execute"', '']; 
    $console[] = ['@proc', 'proc:"proccess_to_open"', ''];
    $console[] = ['@eval', 'php:"code_to_execute"', 'no args=TO ALL'];    
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerFiles.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Files
  *
  * Skynet Files Read/Write/Send
  */
class SkynetEventListenerFiles extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{  
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();   
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
      $this->addLog('xxxx');
    }
    
    if($context == 'afterReceive')
    {
      /* File read */
      if($this->request->get('@fget') !== null)
      {
        if(!is_array($this->request->get('@fget')))
        {
          $result = 'NO PATH IN PARAM';
          $this->response->set('@<<fgetStatus', $result);  
          return false;
        }      
        
        $params = $this->request->get('@fget');
        if(isset($params['path']) && !empty($params['path']))
        {
          $file = $params['path'];
        } else {
           $result = 'NO PATH IN PARAM';
           $this->response->set('@<<fgetStatus', $result);  
           return false;
        }        
       
        $result = 'TRYING';
        
        if(file_exists($file))
        {
          $result = 'FILE EXISTS: '.$file;
          $data = @file_get_contents($file);
          if($data !== null)
          {
             $result = 'FILE READED: '.$file;             
             $this->response->set('@<<fgetData', $data);
             $this->response->set('@<<fgetFile', $file);               
          } else {
             $result = 'NULL DATA OR READ ERROR';
          }          
        } else {
          $result = 'FILE NOT EXISTS: '.$file;
        }
        $this->response->set('@<<fgetStatus', $result);  
      }
        
      /* File save */
      if($this->request->get('@fput') !== null)
      {
        if(!is_array($this->request->get('@fput')))
        {
          $result = 'NO PATH IN PARAM';
          $this->response->set('@<<fputStatus', $result);  
          return false;
        }      
        
        $params = $this->request->get('@fput');
        if(isset($params['path']) && !empty($params['path']))
        {
           $file = $params['path'];
        } else {
           $result = 'NO PATH IN PARAM';
           $this->response->set('@<<fputStatus', $result);  
           return false;
        }  
        
        $result = 'TRYING';
        $data = null;
        if(isset($params['data']))
        {
          $data = $params['data'];
        }
        
        if(@file_put_contents($file, $data))
        {
          $result = 'FILE SAVED: '.$file;                
        } else {
          $result = 'FILE NOT SAVED: '.$file;
        }
        $this->response->set('@<<fputStatus', $result);  
      }
      
      /* File delete */
      if($this->request->get('@fdel') !== null)
      {
        if(!is_array($this->request->get('@fdel')))
        {
          $result = 'NO PATH IN PARAM';
          $this->response->set('@<<fdelStatus', $result);  
          return false;
        }      
        
        $params = $this->request->get('@fdel');
        if(isset($params['path']) && !empty($params['path']))
        {
          $file = $params['path'];
        } else {
           $result = 'NO PATH IN PARAM';
           $this->response->set('@<<fdelStatus', $result);  
           return false;
        }        
       
        $result = 'TRYING';
        if(file_exists($file))
        {
          if(@unlink($file))
          {
            $result = 'FILE DELETED: '.$file;           
          } else {
            $result = 'FILE NOT DELETED: '.$file;
          }
        } else {
          $result = 'FILE NOT EXISTS: '.$file;
        }
        $this->response->set('@<<fdelStatus', $result);  
      }
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
      if($this->response->get('@<<fgetStatus') !== null)
      {       
        $this->addMonit('[STATUS] File get status: '.$this->response->get('@<<fgetStatus'));
      }
      
      if($this->response->get('@<<fputStatus') !== null)
      {       
        $this->addMonit('[STATUS] File put status: '.$this->response->get('@<<fputStatus'));
      }
      
      if($this->response->get('@<<fdelStatus') !== null)
      {       
        $this->addMonit('[STATUS] File delete status: '.$this->response->get('@<<fdelStatus'));
      }      
      
      if($this->response->get('@<<fgetFile') !== null)
      {          
        $this->addMonit('[SUCCESS] Remote file received: '.$this->response->get('@<<fgetFile'));
        
        $dir = '_download';
        if(!is_dir($dir))
        {
          if(!@mkdir($dir))
          {
            $this->addError('FGET', 'MKDIR ERROR: '.$dir); 
            $this->addMonit('[ERROR CREATING DIR] Directory not created: '.$dir);            
            return false;
          } 
        }
        
        $fileName = time().'_'.str_replace(array("\\", "/"), "-", $this->response->get('@<<fgetFile'));
        $file = $dir.'/'.$fileName;
        if(!@file_put_contents($file, $this->response->get('@<<fgetData')))
        {
          $this->addError('FGET', 'FILE SAVE ERROR: '.$file); 
          $this->addMonit('[ERROR SAVING FILE] Remote file received but not saved: '.$file);
        } else {
          $this->addState('FGET', 'FILE SAVED: '.$file);
          $this->addMonit('[SUCCESS] Remote file saved: '.$file);          
        }
      }
    }

    if($context == 'beforeSend')
    {      
      
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }     
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];  
    $console[] = ['@fget', 'path:"/path/to"', ''];
    $console[] = ['@fput', 'path:"/path/to",data:"data_to_save"', '']; 
    $console[] = ['@fdel', 'path:"/path/to"', ''];    
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerOptions.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Registry
  *
  * Skynet Registry 
  */
class SkynetEventListenerOptions extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{  
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();   
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
    
    if($context == 'afterReceive')
    {
      if($this->request->get('@opt_set') !== null)
      {
        $returnSuccess = [];
        $returnError = [];
        $params = $this->request->get('@opt_set');         
       
        if(is_array($params))
        {          
          foreach($params as $key => $value)
          {
            if($this->opt_set($key, $value))
            {
              $returnSuccess[] = $key;   
            } else {
              $returnError[] = $key; 
              $this->addError(SkynetTypes::OPTIONS, 'UPDATE ERROR: '.$key);                  
            }                   
          }
          
          if(count($returnSuccess) > 0)
          {
            $this->response->set('@<<opt_setSuccess', $returnSuccess);
          }
          
          if(count($returnError) > 0)
          {
            $this->response->set('@<<opt_setErrors', $returnError);
          }          
        }        
      }
           
      
      if($this->request->get('@opt_get') !== null)
      {
        $return = [];
        $params = $this->request->get('@opt_get');        
        
        if(is_array($params))
        {
          foreach($params as $param)
          {
            $return[$param] = $this->opt_get($param);            
          }
          
        } else {
          $return[$params] = $this->opt_get($params);            
        }
        
        if(count($return) > 0)
        {
          foreach($return as $k => $v)
          {
            $this->response->set($k, $v);
          }
        }
      }
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
      if($this->response->get('@<<opt_setSuccess') !== null)
      {
         $fields = $this->response->get('@<<opt_setSuccess');
         if(is_array($fields))
         {
           $fields = implode(', ', $fields);
         }
         
         $this->addMonit('[SUCCESS] Options values set: '.$fields);
      }
      if($this->response->get('@<<opt_setErrors') !== null)
      {
        $fields = $this->response->get('@<<opt_setErrors');
        if(is_array($fields))
        {
          $fields = implode(',', $fields);
        }
        $this->addMonit('[ERROR] Options values not set: '.$fields);
      }
    }

    if($context == 'beforeSend')
    {      
      
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }     
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  } 
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];    
    
    $console[] = ['@opt_set', ['key: "value"', 'key1: "value1", key2: "value2"...'], 'no @to=TO ALL'];   
    $console[] = ['@opt_get', ['key', 'key1, key2, key3...'], 'no @to=TO ALL'];   
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    
    $queries['skynet_options'] = 'CREATE TABLE skynet_options (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, key VARCHAR (15), content TEXT)';
    $tables['skynet_options'] = 'Options';
    $fields['skynet_options'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Last update',
    'key' => 'Key',
    'content' => 'Value'
    ];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerRegistry.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Registry
  *
  * Skynet Registry 
  */
class SkynetEventListenerRegistry extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{  
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
     
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
      if($this->response->get('@<<reg_setSuccess') !== null)
      {
         $fields = $this->response->get('@<<reg_setSuccess');
         if(is_array($fields))
         {
           $fields = implode(', ', $fields);
         }
         
         $this->addMonit('[SUCCESS] Registry values set: '.$fields);
      }
      if($this->response->get('@<<reg_setErrors') !== null)
      {
        $fields = $this->response->get('@<<reg_setErrors');
        if(is_array($fields))
        {
          $fields = implode(',', $fields);
        }
        $this->addMonit('[ERROR] Registry values not set: '.$fields);
      }
    }

    if($context == 'beforeSend')
    {      
      if($this->request->get('@reg_set') !== null)
      {
        $returnSuccess = [];
        $returnError = [];
        $params = $this->request->get('@reg_set');   
       
        if(is_array($params))
        {          
          foreach($params as $key => $value)
          {
            if($this->reg_set($key, $value))
            {
              $returnSuccess[] = $key;   
            } else {
              $returnError[] = $key; 
              $this->addError(SkynetTypes::REGISTRY, 'UPDATE ERROR: '.$key);                  
            }                 
          }
          
          if(count($returnSuccess) > 0)
          {
            $this->response->set('@<<reg_setSuccess', $returnSuccess);
          }
          
          if(count($returnError) > 0)
          {
            $this->response->set('@<<reg_setErrors', $returnError);
          }          
        }        
      }
           
      
      if($this->request->get('@reg_get') !== null)
      {
        $return = [];
       
        $params = $this->request->get('@reg_get');           
        if(is_array($params))
        {
          foreach($params as $param)
          {
            $return[$param] = $this->reg_get($param);            
          }
          
        } else {
          $return[$params] = $this->reg_get($params);            
        }
        
        if(count($return) > 0)
        {
          foreach($return as $k => $v)
          {
            $this->response->set($k, $v);
          }
        }        
      }      
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }   
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];    
   
    $console[] = ['@reg_set', ['key: "value"', 'key1: "value1", key2: "value2"...'], 'no @to=TO ALL'];   
    $console[] = ['@reg_get', ['key', 'key1, key2, key3...'], 'no @to=TO ALL'];  
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    
    $queries['skynet_registry'] = 'CREATE TABLE skynet_registry (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, key VARCHAR (15), content TEXT)';
    $tables['skynet_registry'] = 'Registry';
    $fields['skynet_registry'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Last update',
    'key' => 'Key',
    'content' => 'Value'
    ];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
}

/**
 * Skynet/EventListener/SkynetEventListenersFactory.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listeners Factory
  *
  * Factory for Event Listeners
  */
class SkynetEventListenersFactory
{
  /** @var SkynetEventListenerInterface[] Array of Event Listeners */
  private $eventListeners = [];

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}

 /**
  * Registers Event Listeners classes in registry
  */
  private function registerEventListeners()
  {
    $this->register('exec', new SkynetEventListenerExec());
    $this->register('clusters', new SkynetEventListenerClusters());
    $this->register('cloner', new SkynetEventListenerCloner());
    $this->register('cli', new SkynetEventListenerCli());  
    $this->register('files', new SkynetEventListenerFiles());    
    $this->register('options', new SkynetEventListenerOptions());
    $this->register('registry', new SkynetEventListenerRegistry());
    $this->register('my', new SkynetEventListenerMyListener());    
    $this->register('echo', new SkynetEventListenerEcho());
    $this->register('sleeper', new SkynetEventListenerSleeper());
    $this->register('updater', new SkynetEventListenerUpdater());
  }

 /**
  * Returns choosen Event Listener from registry
  *
  * @param string $name
  *
  * @return SkynetEventListenerInterface EventListener
  */
  public function getEventListener($name)
  {
    if(array_key_exists($name, $this->eventListeners))
    {
      return $this->eventListeners[$name];
    }
  }

 /**
  * Returns all Event Listeners from registry as array
  *
  * @return SkynetEventListenerInterface[] Array of Event Listeners
  */
  public function getEventListeners()
  {
    return $this->eventListeners;
  }

 /**
  * Checks for Event Listeners in registry
  *
  * @return bool True if events exists
  */
  public function areRegistered()
  {
    if($this->eventListeners !== null && count($this->eventListeners) > 0) return true;
  }

 /**
  * Registers Event Listener in registry
  *
  * @param string $id name/key of listener
  * @param SkynetEventListenerInterface $class New instance of listener class
  */
  private function register($id, SkynetEventListenerInterface $class)
  {
    $this->eventListeners[$id] = $class;
  }

 /**
  * Returns instance
  *
  * @return SkynetEventListenersFactory
  */
  public static function getInstance()
  {
    static $instance = null;
    if($instance === null)
    {
      $instance = new static();
      if(!$instance->areRegistered()) 
      {
        $instance->registerEventListeners();
      }
    }
    return $instance;
  }
}

/**
 * Skynet/EventListener/SkynetEventListenersLauncher.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.1
 */

 /**
  * Skynet Event Listeners Launcher
  *
  */
class SkynetEventListenersLauncher
{     
  /** @var SkynetRequest Request object */
  private $request;
  
  /** @var SkynetResponse Response object */
  private $response; 
  
  /** @var int Connection Number */
  private $connectId = 1; 
  
  /** @var string Cluster UR */
  private $clusterUrl;
  
  /** @var string Sender cluster UR */
  private $senderClusterUrl;
  
  /** @var string Receiver cluster UR */
  private $receiverClusterUrl;
  
  /** @var SkynetCli CLI object */
  private $cli;
  
  /** @var SkynetConsole Console object */
  private $console;
  
  /** @var SkynetEventListenerInterface[] Lisetners */
  private $eventListeners;
  
  /** @var SkynetEventListenerInterface[] Loggers */
  private $eventLoggers;
  
  /** @var string[] Output from CLI */
  private $cliOutput = [];
  
  /** @var string[] Output from Console */
  private $consoleOutput = [];
  
  /** @var bool If sender */
  private $sender = true;
  
  /** @var string[] Tables data */
  private $dbTables = [];
  
  /** @var string[] Monits */
  private $monits = [];

 /**
  * Constructor
  */
  public function __construct()
  {
   $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
   $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();
  }  
  
 /**
  * Assigns request
  *
  * @param SkynetRequest $request
  */  
  public function assignRequest($request)
  {
    $this->request = $request;
  }

 /**
  * Assigns response
  *
  * @param SkynetResponse $response
  */    
  public function assignResponse($response)
  {
    $this->response = $response;
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
  * Assigns clusterURL
  *
  * @param string $clusterUrl
  */   
  public function assignClusterUrl($clusterUrl)
  {
    $this->clusterUrl = $clusterUrl;
  }
 
 /**
  * Assigns sender clusterURL
  *
  * @param string $clusterUrl
  */   
  public function assignSenderClusterUrl($clusterUrl)
  {
    $this->senderClusterUrl = $clusterUrl;
  }
 
 /**
  * Assigns receiver clusterURL
  *
  * @param string $clusterUrl
  */   
  public function assignReceiverClusterUrl($clusterUrl)
  {
    $this->receiverClusterUrl = $clusterUrl;
  }
  
 /**
  * Assigns CLI
  *
  * @param SkynetCli CLI
  */   
  public function assignCli($cli)
  {
    $this->cli = $cli;
  }
  
  public function assignConsole($console)
  {
    $this->console = $console;
  }
 
 /**
  * Assigns Cli output data
  *
  * @param string[] Output from CLI
  */  
  public function getCliOutput()
  {
    return $this->cliOutput;
  }
 
 /**
  * Assigns Console output data
  *
  * @param string[] Output from Console
  */   
  public function getConsoleOutput()
  {
    return $this->consoleOutput;
  }

 /**
  * Sets if sender
  *
  * @param bool True if sender
  */    
  public function setSender($sender)
  {
    $this->sender = $sender;
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
  public function launch($event)
  {
    switch($this->sender)
    {
      case true:
        $this->launchSenderListeners($event);
      break;
      
      case false:
        $this->launchResponderListeners($event);
      break;      
    }
  } 
 
 
  private function get_class_name($classname)
  {
    if($pos = strrpos($classname, '\\')) 
    {
      return substr($classname, $pos + 1);
    }
    return $pos;
  }
 
 /**
  * Assigns monits from listeners
  *
  * @param string[] Monits from listener
  */     
  private function assignMonits($listener, $eventName, $context = null)
  {
    $monits = $listener->getMonits();
    if(is_array($monits) && count($monits) > 0)
    {
      $this->monits[] = '['.$this->get_class_name(get_class($listener)).'] : '.$eventName.'('.$context.')<br>'.implode('<br>', $monits).'<br>';    
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
  private function launchSenderListeners($event)
  {
    switch($event)
    {
      /* Launch when response received */
      case 'onResponse':
        foreach($this->eventListeners as $listener)
        {
          $listener->resetMonits();
          $listener->setConnId($this->connectId);
          $listener->setEventName('onResponse');
          $listener->setContext('afterReceive');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->setSender($this->sender);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          if(method_exists($listener, 'onResponse'))
          {
            $listener->onResponse('afterReceive');
          }
          $requests = $this->request->getRequestsData();
          if(isset($requests['@echo'])) 
          {
            if(method_exists($listener, 'onEcho'))
            {
              $listener->onEcho('afterReceive');
            }
          }
          if(isset($requests['@broadcast'])) 
          {
            if(method_exists($listener, 'onBroadcast'))
            {
              $listener->onBroadcast('afterReceive');
            }
          }
          $this->assignMonits($listener, $event, 'afterReceive'); 
        }
      break;

      /* Launch before sending request */
      case 'onRequest':
        foreach($this->eventListeners as $listener)
        {
          $listener->resetMonits();
          $listener->setConnId($this->connectId);
          $listener->setEventName('onRequest');
          $listener->setContext('beforeSend');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->setSender($this->sender);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          $listener->setReceiverClusterUrl($this->clusterUrl);
          if(method_exists($listener, 'onRequest'))
          {
            $listener->onRequest('beforeSend');
          }
          $requests = $this->request->getRequestsData();
          $this->assignMonits($listener, $event, 'beforeSend');
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
          $listener->resetMonits();
          $listener->setConnId($this->connectId);
          $listener->setEventName('onResponseLoggers');
          $listener->setContext('afterReceive');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->setSender($this->sender);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          if(method_exists($listener, 'onResponse'))
          {
            $listener->onResponse('afterReceive');
          }
          $requests = $this->request->getRequestsData();
          if(isset($requests['@echo'])) 
          {
            if(method_exists($listener, 'onEcho'))
            {
              $listener->onEcho('afterReceive');
            }
          }
          if(isset($requests['@broadcast'])) 
          {
            if(method_exists($listener, 'onBroadcast'))
            {
              $listener->onBroadcast('afterReceive');
            }
          }
          $this->assignMonits($listener, $event, 'afterReceive');
        }
      break;

      /* Launch after request listeners */
      case 'onRequestLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->resetMonits();
          $listener->setConnId($this->connectId);
          $listener->setEventName('onRequestLoggers');
          $listener->setContext('beforeSend');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->setSender($this->sender);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          $listener->setReceiverClusterUrl($this->clusterUrl);
          if(method_exists($listener, 'onRequest'))
          {
            $listener->onRequest('beforeSend');
          }
          $requests = $this->request->getRequestsData();
          $this->assignMonits($listener, $event, 'beforeSend');
        }
      break;
      
      /* Launch when CLI */
      case 'onCli':
        foreach($this->eventListeners as $listener)
        {
          $listener->resetMonits();
          $listener->setEventName('onCli');
          $listener->setContext('onCli');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->assignCli($this->cli);
          if(method_exists($listener, 'onCli'))
          {
            $output = $listener->onCli();
          }
          if($output !== null)
          {
            $this->cliOutput[] = $output;
          }
          $this->assignMonits($listener, $event, 'onCli');
        }
      break;
      
      /* Launch when Console */
      case 'onConsole':
        foreach($this->eventListeners as $listener)
        {
          $listener->resetMonits();
          $listener->setEventName('onConsole');
          $listener->setContext('onConsole');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->assignConsole($this->console);
          if(method_exists($listener, 'onConsole'))
          {
            $output = $listener->onConsole();
          }
          if($output !== null)
          {
            $this->consoleOutput[] = $output;
          }
          $this->assignMonits($listener, $event, 'onConsole');
        }
      break;
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
  private function launchResponderListeners($event)
  {
    switch($event)
    {
      /* Launch before sending response */
      case 'onResponse':
        foreach($this->eventListeners as $listener)
        {
          $listener->resetMonits();
          $listener->setConnId($this->connectId);
          $listener->setEventName('onResponse');
          $listener->setContext('beforeSend');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->setSender($this->sender);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) && isset($requests['_skynet_sender_url']) && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            if(method_exists($listener, 'onResponse'))
            {
              $listener->onResponse('beforeSend');
            }
            if(isset($requests['@echo'])) 
            {
              if(method_exists($listener, 'onEcho'))
              {
                $listener->onEcho('beforeSend');
              }
            }
            if(isset($requests['@broadcast'])) 
            {
              if(method_exists($listener, 'onBroadcast'))
              {
                $listener->onBroadcast('beforeSend');
              }
            }
          }
          $this->assignMonits($listener, $event, 'beforeSend');
        }
      break;

      /* Launch after receives request */
      case 'onRequest':
        foreach($this->eventListeners as $listener)
        {
          $listener->resetMonits();
          $listener->setConnId($this->connectId);
          $listener->setEventName('onRequest');
          $listener->setContext('afterReceive');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->setSender($this->sender);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) && isset($requests['_skynet_sender_url']) && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            if(method_exists($listener, 'onRequest'))
            {
              $listener->onRequest('afterReceive');
            }
          }
          $this->assignMonits($listener, $event, 'afterReceive');
        }
      break;

      /* Launch after response listeners */
      case 'onResponseLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->resetMonits();
          $listener->setConnId($this->connectId);
          $listener->setEventName('onResponseLoggers');
          $listener->setContext('beforeSend');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->setSender($this->sender);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) && isset($requests['_skynet_sender_url']) && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            if(method_exists($listener, 'onResponse'))
            {
              $listener->onResponse('beforeSend');
            }
            if(isset($requests['@echo'])) 
            {
              if(method_exists($listener, 'onEcho'))
              {
                $listener->onEcho('beforeSend');
              }
            }
            if(isset($requests['@broadcast'])) 
            {
              if(method_exists($listener, 'onBroadcast'))
              {
                $listener->onBroadcast('beforeSend');
              }
            }
          }
          $this->assignMonits($listener, $event, 'beforeSend');
        }
      break;

      /* Launch after request listeners */
      case 'onRequestLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->resetMonits();
          $listener->setConnId($this->connectId);
          $listener->setEventName('onRequestLoggers');
          $listener->setContext('afterReceive');
          
          $listener->setReceiverClusterUrl($this->receiverClusterUrl);
          $listener->setSenderClusterUrl($this->senderClusterUrl);
          
          $listener->setSender($this->sender);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) && isset($requests['_skynet_sender_url']) && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            if(method_exists($listener, 'onRequest'))
            {
              $listener->onRequest('afterReceive');
            }
          }
          $this->assignMonits($listener, $event, 'afterReceive');
        }
      break;
    }
  }
  
 /**
  * Returns monits
  *
  * @return string[] Monits
  */
  public function getMonits()
  {
    return $this->monits;
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerSleeper.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Sleeper
  *
  * Skynet Sleep and WakeUp 
  */
class SkynetEventListenerSleeper extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{     
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();   
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
    if($context == 'afterReceive')
    {
      if($this->request->get('@sleep') !== null)
      {
        $key = 'sleep';
        $value = 1;
        $returnSuccess = [];
        $returnError = [];
        if($this->opt_set($key, $value))
        {
          $returnSuccess[] = $key;   
        } else {
          $returnError[] = $key; 
          $this->addError(SkynetTypes::OPTIONS, 'UPDATE ERROR: '.$key);                  
        }
          
        if(count($returnSuccess) > 0)
        {
          $this->response->set('@<<opt_setSuccess', $returnSuccess);
        }
        
        if(count($returnError) > 0)
        {
          $this->response->set('@<<opt_setErrors', $returnError);
        }      
      }
           
      
      if($this->request->get('@wakeup') !== null)
      {
        $key = 'sleep';
        $value = 0;
        $returnSuccess = [];
        $returnError = [];
        if($this->opt_set($key, $value))
        {
          $returnSuccess[] = $key;   
        } else {
          $returnError[] = $key; 
          $this->addError(SkynetTypes::OPTIONS, 'UPDATE ERROR: '.$key);                  
        }
          
        if(count($returnSuccess) > 0)
        {
          $this->response->set('@<<opt_setSuccess', $returnSuccess);
        }
        
        if(count($returnError) > 0)
        {
          $this->response->set('@<<opt_setErrors', $returnError);
        }   
      }
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
      if($this->response->get('@<<opt_setSuccess') === 'sleep')
      {
         $this->addMonit('[SUCCESS] Sleep/wakeup');
      }
      if($this->response->get('@<<opt_setErrors') === 'sleep')
      {       
        $this->addMonit('[ERROR] Sleep/wakeup');
      }
    }

    if($context == 'beforeSend')
    {      
      
    }
  }
  
 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }  
  
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
    /* if sleep */
    if($this->cli->isCommand('sleep'))
    {       
      $this->opt_set('sleep', 1);    
      return '@SLEEPER: cluster sleeped';
    }
    
    /* if wakeup */
    if($this->cli->isCommand('wakeup'))
    {       
      $this->opt_set('sleep', 0);   
      return '@SLEEPER: cluster woked up';      
    }    
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    if($this->console->isConsoleCommand('sleep'))
    {
       $this->opt_set('sleep', 1);
       return '@SLEEPER: cluster sleeped';       
    }
    
    if($this->console->isConsoleCommand('wakeup'))
    {       
       $this->opt_set('sleep', 0);
       return '@SLEEPER: cluster woked up';      
    }
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];
    
    $cli[] = ['-sleep', '', 'Sleeps this cluster'];
    $cli[] = ['-wakeup', '', 'Wakeup this cluster'];
    
    $console[] = ['@sleep', ['me', 'cluster address', 'cluster address1, address2 ...'], 'no args=TO ALL'];  
    $console[] = ['@wakeup', ['me', 'cluster address', 'cluster address1, address2 ...'], 'no args=TO ALL'];   
    
    return array('cli' => $cli, 'console' => $console);    
  }
  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
}

/**
 * Skynet/EventListener/SkynetEventListenerEcho.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener - Echo
  *
  * Creates and operates on Echo and Broadcast Requests
  */
class SkynetEventListenerUpdater extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{  
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
      if($this->response->get('@<<self_updateSuccess') !== null)
      {        
        $this->addMonit('[SUCCESS] Update succesfull: '.$this->response->get('@<<self_updateSuccess'));
      }
      if($this->response->get('@<<self_updateError') !== null)
      {
        $this->addMonit('[ERROR] Update error: '.$this->response->get('@<<self_updateError'));
      }
    }

    if($context == 'beforeSend')
    {      
      if($this->request->get('@self_update') !== null)
      {         
        if(isset($this->request->get('@self_update')['source']))
        {
          $address = $this->request->get('@self_update')['source'];
        } else {
          $this->response->set('@<<self_updateError', 'NO SOURCE: '.SkynetHelper::getMyUrl());           
          return false;
        }        
        
        if($address == SkynetHelper::getMyUrl()) 
        {
          return false;
        }
        
        try
        {
          $success = false;
          $logs = [];
          $data = null;
          $logs[] = 'SELF-UPDATE: REQUEST RECEIVED';          
          $remote = $this->getRemoteCode($address);
          $logs[] = 'SELF-UPDATE: REMOTE SOURCE: '.$address;
          
          if(isset($remote['data']))
          {
            $data = $remote['data']; 
          } else {
            throw new SkynetException('SELF-UPDATE ERROR: NULL');
          }  
          
          /* If is data received */
          if($data !== null && !empty($data))
          {
            $logs[] = 'SELF-UPDATE: REMOTE DATA RECEIVED';
            $encodedData = json_decode($data);          
          } else {
            $logs[] = 'SELF-UPDATE ERROR: NO DATA RECEIVED';         
            throw new SkynetException('SELF-UPDATE ERROR: NO DATA RECEIVED');
          }           
            
          /* If is version info */
          if(isset($encodedData->version))
          {
            $logs[] = 'SELF-UPDATE: REMOTE VERSION IS: '.$encodedData->version;
            $logs[] = 'SELF-UPDATE: MY VERSION IS: '.SkynetVersion::VERSION;
            $new_version = $encodedData->version;
            $new_code = $encodedData->code;
          } else {            
            $logs[] = 'SELF-UPDATE ERROR: NO VERSION DATA';         
            throw new SkynetException('SELF-UPDATE ERROR: NO VERSION DATA');           
          }
           
          /* If is new source code */
          if(!empty($new_code))
          {
            $sended_checksum = $encodedData->checksum;
            $gen_checksum = md5($new_code);          
            $logs[] = 'SELF-UPDATE: RECEIVED CODE CHECKSUM [sended]: '.$sended_checksum;
            $logs[] = 'SELF-UPDATE: RECEIVED CODE CHECKSUM [checked]: '.$gen_checksum;          
          } else {
            $logs[] = 'SELF-UPDATE ERROR: RECEIVED CODE EMPTY';          
            throw new SkynetException('SELF-UPDATE ERROR: RECEIVED CODE EMPTY');  
          }
          
          /* Try to update */
          if($this->updateSourceCode($new_code))
          {
            $success = true;
            $logs[] = 'SELF-UPDATE: UPDATED TO VERSION: '.$encodedData->version;   
          } else {
            $logs[] = 'SELF-UPDATE ERROR: UPDATE FAILED';
            $success = false;
            throw new SkynetException('SELF-UPDATE ERROR: UPDATE FAILED'); 
          }
          
        } catch(SkynetException $e)
        {
          $success = false;
          $this->addError(SkynetTypes::UPDATER, 'SELF UPDATE FAILED: '.$e->getMessage(), $e);
        }
        
        /* Save log to file */
        if($this->areErrors() && is_array($this->getErrors()))
        {
          $logs = array_merge($logs, $this->getErrors());
        }
        
        if(SkynetConfig::get('logs_txt_selfupdate'))
        {
          $logger = new SkynetEventListenerLoggerFiles();
          $logger->assignRequest($this->request);
          $logger->setRequestData($this->requestsData);   
          if($logger->saveSelfUpdateToFile($logs))
          {
            $this->addState(SkynetTypes::STATUS_OK, 'SELF-UPDATE STATUS SAVED TO TXT');
          }
        } 
         
        if(SkynetConfig::get('logs_db_selfupdate'))
        {
          $data = [];
          $data['source'] = $address;
          $data['version'] = '';          
          if(isset($encodedData->version)) 
          {
            $data['version'] = $encodedData->version;
          }
          
          $logger = new SkynetEventListenerLoggerDatabase();
          $logger->assignRequest($this->request);
          $logger->setRequestData($this->requestsData);
          if($logger->saveSelfUpdateToDb($data, $logs))
          {
            $this->addState(SkynetTypes::STATUS_OK, 'SELFUPDATE SAVED TO DB');
          }
        }        
        
        if(!$success) 
        {
          $this->response->set('@<<self_updateError', SkynetHelper::getMyUrl());
        } else {
          $this->response->set('@<<self_updateSuccess', SkynetHelper::getMyUrl());         
        }
      }
    }
  }
  
 /**
  * Update Skynet with new source code
  *
  * @param string $code New PHP code
  *
  * @return bool
  */ 
  private function updateSourceCode($code)
  {
    if(empty($code))
    {
      return false;
    }
    $myFile = SkynetHelper::getMyBasename();
    $tmpFile = '__'.$myFile;
    $bckMyFile = '___'.$myFile;    
    
    try
    {
      if(!file_put_contents($tmpFile, $code))
      {
         throw new SkynetException('File put error');
      }     
      
      if(!rename($myFile, $bckMyFile))
      {
        throw new SkynetException('Rename my file to backup failed');
      }
      
      if(!rename($tmpFile, $myFile))
      {
         @rename($bckMyFile, $myFile);            
         throw new SkynetException('Rename new file to my file failed');
      }
      @unlink($bckMyFile);
      return true;
     
    } catch(SkynetException $e)
    {
      $this->addError(SkynetTypes::UPDATER, 'Skynet update error: '.$e->getMessage(), $e);      
    }
  }

 /**
  * Gets remote source code
  *
  * @param string $address Adress to cluster with code
  *
  * @return string Source code
  */   
  private function getRemoteCode($address)
  {   
    $connection = SkynetConnectionsFactory::getInstance()->getConnector(SkynetConfig::get('core_connection_type'));
    $encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $verifier = new SkynetVerifier();    

    $ary = [];
    $ary['@code'] = 1;
    $ary['_skynet_hash'] = $verifier->generateHash();    
    $ary['_skynet_id'] = $verifier->getKeyHashed();
    $ary['_skynet_sender_url'] = SkynetHelper::getMyUrl();
    $ary['_skynet_cluster_url'] = SkynetHelper::getMyUrl();

    if(!SkynetConfig::get('core_raw'))
    {
      $ary['@code'] = $encryptor->encrypt($ary['@code']);
      $ary['_skynet_hash'] = $encryptor->encrypt($ary['_skynet_hash']);     
      $ary['_skynet_id'] = $encryptor->encrypt($ary['_skynet_id']);
      $ary['_skynet_sender_url'] = $encryptor->encrypt(SkynetHelper::getMyUrl());
      $ary['_skynet_cluster_url'] = $encryptor->encrypt(SkynetHelper::getMyUrl());
    }
   // $ary['_skynet_cluster_url']
    $connection->setRequests($ary);        
    return $connection->connect($address);
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }   
   
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  } 
  
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];    
    $console[] = ['@self_update', 'source:"source_cluster_address"', 'TO ALL'];       
    return array('cli' => $cli, 'console' => $console);    
  }
  
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
}

/**
 * Skynet/EventLogger/SkynetEventListenerEmailer.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Emailer
  *
  * Sends email with response and request
  */
class SkynetEventListenerEmailer extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  
  {   
    /* code executed before connection to cluster */  
  }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
        /* code executed in sender before creating request */  
    }
    
    if($context == 'afterReceive')
    {
      /* code executed in responder after received request */  
      
      if($this->request->get('@emailer') !== null)
      {
        $this->opt_set('emailer', $this->request->get('@emailer'));
      }      
      
      if(SkynetConfig::get('emailer_requests'))
      {
        if($this->opt_get('emailer') == 1)
        {
          $address = SkynetConfig::get('emailer_email_address');
          $data = $this->createLog('request', $context, true);
          if($this->sendMail($address, '[SKYNET] onRequest:', $data))
          {
            $this->response->set('@<<emailSent', $address);
          } else {
            $this->response->set('@<<emailSentError', $address);
          }          
        }         
      }
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
        /* code executed in sender after received response */  
    }

    if($context == 'beforeSend')
    {      
      /* code executed in responder before create response for request */
      
      if($this->request->get('@emailer') !== null)
      {
        $this->opt_set('emailer', $this->request->get('@emailer'));
      }  
      
      if(SkynetConfig::get('emailer_responses'))
      {
        if($this->opt_get('emailer') == 1)
        {
          $address = SkynetConfig::get('emailer_email_address');
          $data = $this->createLog('response', $context, true);
          
          if($this->sendMail($address, '[SKYNET] onResponse:', $data))
          {
            $this->response->set('@<<emailSent', $address);
          } else {
            $this->response->set('@<<emailSentError', $address);
          }           
        } 
      }
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      /* code executed in responder when creating response for requested @broadcast */  
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      /* code executed in responder when creating response for requested @echo */  
    }    
  }    
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];    
    
    $console[] = ['@emailer', ['1', '0'], 'TO ALL'];   
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
  
 /**
  * Sends email
  *
  * @param string $to Email address
  * @param string $subject Email subject
  * @param string $message Email message body
  *
  * @return bool True if success
  */    
  private function sendMail($to, $subject, $message)
  {    
    try
    {
      if(@mail($to, $subject, $message))
      {
        $this->addState(SkynetTypes::EMAIL, 'Email sended: ['.$to.'] '.$subject);
        return true;
      } else {
        throw new SkynetException('Email not sent: ['.$to.'] '.$subject);
      }
    } catch(SkynetException $e)
    {
      $this->addError(SkynetTypes::EMAIL, $e->getMessage(), $e);
    }    
  }

 /**
  * Create log data for email
  *
  * @param string $event Event name/key
  * @param string $context Context - beforeSend | afterReceive
  * @param bool $toFile If True file log will be created
  *
  * @return string Parsed data
  */  
  private function createLog($event, $context, $toFile = false)
  {    
    switch($event)
    {
      case 'request': 
      
        $receiver = '';
        $direction = '';
        $suffix = '';

        if($context == 'afterReceive')
        {
          if(isset($this->requestsData['_skynet_sender_url']))
          {
            $receiver = $this->requestsData['_skynet_sender_url'];
          }
          $direction = 'from';
          $suffix = 'in';
          
        } elseif($context == 'beforeSend')
        {
          if(isset($this->receiverClusterUrl))
          {
            $receiver = $this->receiverClusterUrl;
          }
          $direction = 'to';
          $suffix = 'out';
        }

        $fileName = 'email_'.$suffix;
        $logFile = new SkynetLogFile('REQUEST');
        $logFile->setFileName($fileName);
        $logFile->setCounter($this->connId);
        $logFile->setHeader("Request ".$direction.": ".$receiver);
        foreach($this->requestsData as $k => $v)
        {
          $logFile->addLine($this->parseLine($k, $v));
        }
        return $logFile->save(null, $toFile);
      break;
      
      case 'response':
      
        $remote = '';
        $direction = '';
        $suffix = '';
        if($context == 'afterReceive')
        {
          if(isset($this->responseData['_skynet_cluster_url']))
          {
            $remote = $this->responseData['_skynet_cluster_url'];
          }
          $direction = 'from';
          $suffix = 'in';
        } elseif($context == 'beforeSend')
        {
          if(isset($this->requestsData['_skynet_sender_url']))
          {
            $remote = $this->requestsData['_skynet_sender_url'];
          }
          $direction = 'to';
          $suffix = 'out';
        }

        $fileName = 'email_'.$suffix;
        $logFile = new SkynetLogFile('RESPONSE');
        $logFile->setFileName($fileName);
        $logFile->setCounter($this->connId);
        $logFile->setHeader("Response ".$direction.": ".$remote);

        foreach($this->responseData as $k => $v)
        {
          $logFile->addLine($this->parseLine($k, $v));
        }
        /* If from response sender */
        if($direction == 'to')
        {
          $logFile->addSeparator();
          $logFile->addLine("RESPONSE FOR THIS REQUEST FROM [".$remote."]");
          foreach($this->requestsData as $k => $v)
          {
            $logFile->addLine($this->parseLine($k, $v));
          }
        }
        return $logFile->save(null, $toFile);
      
      break;
    }
  }  
  
 /**
  * Parse single line
  *
  * @param string $k Field name/key
  * @param string $v Field value
  * @param bool $force Force include if internal param
  *
  * @return string Parsed line
  */
  private function parseLine($k, $v, $force = false)
  {     
    $row = '';
    if(SkynetConfig::get('logs_txt_include_internal_data') || $force)
    {
       $row = "  ".$k.": ".$this->decodeIfNeeded($k, $v);
    } else {
       if(!$this->verifier->isInternalParameter($k)) 
       {
         $row = "  ".$k.": ".$this->decodeIfNeeded($k, $v);
       }
    }       
    return $row;
  }
  
 /**
  * Decodes value if encrypted
  *
  * @param string $key Field name/key
  * @param string $val Value
  *
  * @return string Decoded value
  */
  private function decodeIfNeeded($key, $val)
  {
    if(is_numeric($key)) return $val;
    if($key == '_skynet_clusters' || $key == '@_skynet_clusters')
    {
      $ret = [];
      $clusters = explode(';', $val);
      foreach($clusters as $cluster)
      {
        $ret[] = base64_decode($cluster);
      }
      return implode('; ', $ret);
    }

    $toDecode = ['_skynet_clusters_chain', '@_skynet_clusters_chain'];
    if(in_array($key, $toDecode))
    {      
      return base64_decode($val);
    } else {     
      return $val;
    }
  }
}

/**
 * Skynet/EventLogger/SkynetEventListenerLoggerDatabase.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener Logger - Database
  *
  * Saves events logs in database
  */
class SkynetEventListenerLoggerDatabase extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{
  /** @var SkynetChain SkynetChain instance */
  private $skynetChain;

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
    $this->skynetChain = new SkynetChain();
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $context Connection adapter instance
  */
  public function onConnect($context = null)
  {

  }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if(SkynetConfig::get('db') && SkynetConfig::get('logs_db_requests')) 
    {
      $this->saveRequestToDb($context);
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if(SkynetConfig::get('db') && SkynetConfig::get('logs_db_responses')) 
    {
      $this->saveResponseToDb($context);
    }
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {

  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {

  }  
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];
    
    return array('cli' => $cli, 'console' => $console);    
  }
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];    
    
    $queries['skynet_logs_user'] = 'CREATE TABLE skynet_logs_user (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, sender_url TEXT, receiver_url TEXT, listener VARCHAR (100), event VARCHAR (150), method TEXT, line INTEGER)';
    $queries['skynet_logs_responses'] = 'CREATE TABLE skynet_logs_responses (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, sender_url TEXT, receiver_url TEXT)';
    $queries['skynet_logs_requests'] = 'CREATE TABLE skynet_logs_requests (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, sender_url TEXT, receiver_url TEXT)';    
    $queries['skynet_logs_echo'] = 'CREATE TABLE skynet_logs_echo (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, ping_from TEXT, ping_to TEXT, urls_chain TEXT)';
    $queries['skynet_logs_broadcast'] = 'CREATE TABLE skynet_logs_broadcast (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, ping_from TEXT, ping_to TEXT, urls_chain TEXT)';
    $queries['skynet_errors'] = 'CREATE TABLE skynet_errors (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, remote_ip VARCHAR (15))';
    $queries['skynet_access_errors'] = 'CREATE TABLE skynet_access_errors (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, remote_cluster TEXT, request_uri TEXT, remote_host TEXT, remote_ip VARCHAR (15))';   
    $queries['skynet_logs_selfupdate'] = 'CREATE TABLE skynet_logs_selfupdate (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, sender_url TEXT, source  TEXT, status TEXT, from_version VARCHAR (15), to_version VARCHAR (15))';    
   
    $tables['skynet_logs_user'] = 'Logs: user logs';
    $tables['skynet_logs_responses'] = 'Logs: Responses';
    $tables['skynet_logs_requests'] = 'Logs: Requests';
    $tables['skynet_logs_echo'] = 'Logs: Echo';
    $tables['skynet_logs_broadcast'] = 'Logs: Broadcasts';
    $tables['skynet_errors'] = 'Logs: Errors';
    $tables['skynet_access_errors'] = 'Logs: Access Errors';
    $tables['skynet_logs_selfupdate'] = 'Logs: Self-updates';  
    
    $fields['skynet_logs_user'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'content' => 'Log message',
    'sender_url' => 'Sender',
    'receiver_url' => 'Receiver',
    'listener' => 'Event Listener',
    'event' => 'Event Name',
    'method' => 'Method',
    'line' => 'Line'
    ];
    
    $fields['skynet_logs_responses'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'content' => 'Full Response',
    'sender_url' => 'Response Sender',
    'receiver_url' => 'Response Receiver'
    ];
    
    $fields['skynet_logs_requests'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'content' => 'Full Request',
    'sender_url' => 'Request Sender',
    'receiver_url' => 'Request Receiver'
    ];
    
    $fields['skynet_logs_echo'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'request' => 'Echo Full Request',    
    'ping_from' => '@Echo received from',
    'ping_to' => '@Echo resended to',
    'urls_chain' => 'URLs Chain'
    ];
    
    $fields['skynet_logs_broadcast'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'request' => 'Echo Full Request',    
    'ping_from' => '@Broadcast received from',
    'ping_to' => '@Broadcast resended to',
    'urls_chain' => 'URLs Chain'
    ];
    
    $fields['skynet_errors'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Created At',
    'content' => 'Error log',    
    'remote_ip' => 'IP Address'
    ];
    
    $fields['skynet_access_errors'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Created At',
    'request' => 'Full Request',
    'remote_cluster' => 'Remote Cluster Address',
    'request_uri' => 'Request URI',
    'remote_host' => 'Remote Host',
    'remote_ip' => 'Remote IP Address'
    ];
    
    $fields['skynet_logs_selfupdate'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Created At',
    'request' => 'Full Request',
    'sender_url' => 'Update command Sender',
    'source' => 'Update remote Source Code',
    'status' => 'Update Status',
    'from_version' => 'From version (before)',
    'to_version' => 'To version (after)'
    ];
    
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
  
 /**
  * Saves response data in database
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  private function saveResponseToDb($context)
  {
    if($this->skynetChain->isRequestForChain())
    {
      return false;
    }

    $responseData = '';
    foreach($this->responseData as $k => $v)
    {
      if(SkynetConfig::get('logs_db_include_internal_data'))
      {
         $responseData.= $k.": ".$v."; ";
      } else {
         if(!$this->verifier->isInternalParameter($k)) 
         {
           $responseData.= $k.": ".$v."; ";
         }
      }
    }

    try
    {
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_logs_responses (skynet_id, created_at, content, sender_url, receiver_url)
      VALUES(:skynet_id, :created_at, :content, :sender_url,  :receiver_url)'
      );

      $receiver = '';
      $sender = '';
      $skynet_id = '';
      $logInfo = '';

      if($context == 'beforeSend')
      {         
         $skynet_id = SkynetConfig::KEY_ID;
         $logInfo = 'to &gt;&gt; '.$receiver;         
      } else {        
         $skynet_id = $this->responseData['_skynet_id'];
         if($this->verifier->isMyKey($skynet_id))
         {
           $skynet_id = SkynetConfig::KEY_ID;
         }
         $logInfo = 'from &lt;&lt; '.$sender;
      }
      
      $sender = $this->senderClusterUrl;
      $receiver = $this->receiverClusterUrl;
      
      $sender = SkynetHelper::cleanUrl($sender);
      $receiver = SkynetHelper::cleanUrl($receiver);

      $time = time();
      $stmt->bindParam(':skynet_id', $skynet_id, \PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $time, \PDO::PARAM_INT);
      $stmt->bindParam(':content', $responseData, \PDO::PARAM_STR);
      $stmt->bindParam(':sender_url', $sender, \PDO::PARAM_STR);
      $stmt->bindParam(':receiver_url', $receiver, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->addState(SkynetTypes::DB_LOG, 'RESPONSE ['.$logInfo.'] SAVED TO DB');
        return true;
      } else {
        $this->addState(SkynetTypes::DB_LOG, 'RESPONSE ['.$logInfo.'] NOT SAVED TO DB');
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::DB_LOG, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Saves request data in database
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  private function saveRequestToDb($context)
  {
    if($this->skynetChain->isRequestForChain())
    {
      return false;
    }

    $requestData = '';
    foreach($this->requestsData as $k => $v)
    {
      if(SkynetConfig::get('logs_db_include_internal_data'))
      {
         $requestData.= $k.": ".$v."; ";
      } else {
         if(!$this->verifier->isInternalParameter($k)) 
         {
           $requestData.= $k.": ".$v."; ";
         }
      }
    }

    try
    {
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_logs_requests (skynet_id, created_at, content, receiver_url, sender_url)
      VALUES(:skynet_id, :created_at, :content, :receiver_url,  :sender_url)'
      );

      $receiver = '';
      $sender = '';
      $skynet_id = '';

      if($context == 'afterReceive')
      {         
         if(isset($this->requestsData['_skynet_id'])) 
         {
           $skynet_id = $this->requestsData['_skynet_id'];
           if($this->verifier->isMyKey($skynet_id))
           {
             $skynet_id = SkynetConfig::KEY_ID;
           }
         }
         
      } else {        
         $skynet_id = SkynetConfig::KEY_ID;
      }
      
      $sender = $this->senderClusterUrl;
      $receiver = $this->receiverClusterUrl;
      
      $sender = SkynetHelper::cleanUrl($sender);
      $receiver = SkynetHelper::cleanUrl($receiver);

      $time = time();
      $senderUrl = SkynetHelper::getMyUrl();
      $stmt->bindParam(':skynet_id', $skynet_id, \PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $time, \PDO::PARAM_INT);
      $stmt->bindParam(':content', $requestData, \PDO::PARAM_STR);
      $stmt->bindParam(':sender_url', $sender, \PDO::PARAM_STR);
      $stmt->bindParam(':receiver_url', $receiver, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->addState(SkynetTypes::DB_LOG, 'REQUEST [to &gt;&gt; '.$receiver.' ] SAVED TO DB');
        return true;
      } else {
        $this->addState(SkynetTypes::DB_LOG, 'REQUEST [to &gt;&gt; '.$receiver.' ] NOT SAVED TO DB');
      }    
      
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::DB_LOG, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Saves echo data in database
  *
  * @param string[] $addresses Array of broadcasted urls
  * @param SkynetClustersUrlsChain $urlsChain URLS chain
  */
  public function saveEchoToDb($addresses, SkynetClustersUrlsChain $urlsChain)
  {
    $receivers_urls = implode(';', $addresses);
    $urlsChainPlain = $urlsChain->getClustersUrlsPlainChain();
    $requestData = '';
    foreach($this->requestsData as $k => $v)
    {
      if(SkynetConfig::get('logs_db_include_internal_data'))
      {
         $requestData.= $k.": ".$v."; ";
      } else {
         if(!$this->verifier->isInternalParameter($k)) 
         {
           $requestData.= $k.": ".$v."; ";
         }
      }
    }

    try
    {
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_logs_echo (skynet_id, created_at, request, ping_from, ping_to, urls_chain)
      VALUES(:skynet_id, :created_at, :request, :ping_from,  :ping_to, :urls_chain)'
      );
      
      $sender = $this->senderClusterUrl;
      $sender = SkynetHelper::cleanUrl($sender);
      
      $time = time();
      $id = SkynetConfig::KEY_ID;
      $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $time, \PDO::PARAM_INT);
      $stmt->bindParam(':request', $requestData, \PDO::PARAM_STR);
      $stmt->bindParam(':ping_from', $sender, \PDO::PARAM_STR);
      $stmt->bindParam(':ping_to', $receivers_urls, \PDO::PARAM_STR);
      $stmt->bindParam(':urls_chain', $urlsChainPlain, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        $this->addState(SkynetTypes::DB_LOG, 'ECHO FROM [from &gt;&gt; '.$senderUrl.' ] SAVED TO DB');
        return true;
      }
      
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::DB_LOG, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Saves broadcast data in database
  *
  * @param string[] $addresses Array of broadcasted urls
  * @param SkynetClustersUrlsChain $urlsChain URLS chain
  */
  public function saveBroadcastToDb($addresses, SkynetClustersUrlsChain $urlsChain)
  {
    $receivers_urls = implode(';', $addresses);
    $urlsChainPlain = $urlsChain->getClustersUrlsPlainChain();
    $requestData = '';
    foreach($this->requestsData as $k => $v)
    {
      if(SkynetConfig::get('logs_db_include_internal_data'))
      {
         $requestData.= $k.": ".$v."; ";
      } else {
         if(!$this->verifier->isInternalParameter($k)) 
         {
           $requestData.= $k.": ".$v."; ";
         }
      }
    }
    
    $sender = $this->senderClusterUrl;
    $sender = SkynetHelper::cleanUrl($sender);
    
    try
    {
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_logs_broadcast (skynet_id, created_at, request, ping_from, ping_to, urls_chain)
      VALUES(:skynet_id, :created_at, :request, :ping_from,  :ping_to, :urls_chain)'
      );
      $senderUrl = $this->request->getSenderClusterUrl();
      $time = time();
      $id = SkynetConfig::KEY_ID;
      $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $time, \PDO::PARAM_INT);
      $stmt->bindParam(':request', $requestData, \PDO::PARAM_STR);
      $stmt->bindParam(':ping_from', $sender, \PDO::PARAM_STR);
      $stmt->bindParam(':ping_to', $receivers_urls, \PDO::PARAM_STR);
      $stmt->bindParam(':urls_chain', $urlsChainPlain, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        $this->addState(SkynetTypes::DB_LOG, 'BROADCAST FROM [from &gt;&gt; '.$senderUrl.' ] SAVED TO DB');
        return true;    
      }
        
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::DB_LOG, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }  
  
 /**
  * Saves broadcast data in database
  *
  * @param string[] $data Update data
  * @param string[] $logs Array with logs
  */
  public function saveSelfUpdateToDb($data, $logs)
  {   
    $requestData = '';
    foreach($this->requestsData as $k => $v)
    {
      if(SkynetConfig::get('logs_db_include_internal_data'))
      {
         $requestData.= $k.": ".$v."; ";
      } else {
         if(!$this->verifier->isInternalParameter($k)) 
         {
           $requestData.= $k.": ".$v."; ";
         }
      }
    }
    
    $sender = $this->senderClusterUrl;
    $sender = SkynetHelper::cleanUrl($sender);

    try
    {
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_logs_selfupdate (skynet_id, created_at, request, sender_url, source, status, from_version, to_version)
      VALUES(:skynet_id, :created_at, :request, :sender_url, :source, :status, :from_version, :to_version)'
      );
      $senderUrl = $this->request->getSenderClusterUrl();
      $time = time();
      $id = SkynetConfig::KEY_ID;
      $source = $data['source'];
      $status = implode('; ', $logs);
      $from_version = SkynetVersion::VERSION;
      $to_version = $data['version'];
      $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $time, \PDO::PARAM_INT);
      $stmt->bindParam(':request', $requestData, \PDO::PARAM_STR);
      $stmt->bindParam(':sender_url', $sender, \PDO::PARAM_STR);
      $stmt->bindParam(':source', $source, \PDO::PARAM_STR);
      $stmt->bindParam(':status', $status, \PDO::PARAM_STR);
      $stmt->bindParam(':from_version', $from_version, \PDO::PARAM_STR);
      $stmt->bindParam(':to_version', $to_version, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        $this->addState(SkynetTypes::DB_LOG, 'SELF-UPDATE FROM [from &gt;&gt; '.$senderUrl.' ] SAVED TO DB');
        return true;
      }
      
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::DB_LOG, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
 /**
  * Saves User Log
  *
  * @param string $content Log message
  * @param string $listener Event listener/file
  * @param string $line Line
  * @param string $event Event name
  * @param string $method Method name
  */
  public function saveUserLogToDb($content, $listener = '', $line = 0, $event = '', $method = '')
  {
    try
    {
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_logs_user (skynet_id, created_at, content, sender_url, receiver_url, listener, event, method, line)
      VALUES(:skynet_id, :created_at, :content, :sender_url, :receiver_url, :listener, :event, :method, :line)'
      );
      
      $sender = $this->senderClusterUrl;
      $receiver = $this->receiverClusterUrl;
      
      $sender = SkynetHelper::cleanUrl($sender);
      $receiver = SkynetHelper::cleanUrl($receiver);
      
      $time = time();
      $id = SkynetConfig::KEY_ID;
      $line = intval($line);
      
      $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $time, \PDO::PARAM_INT);
      $stmt->bindParam(':content', $content, \PDO::PARAM_STR);
      $stmt->bindParam(':sender_url', $sender, \PDO::PARAM_STR);
      $stmt->bindParam(':receiver_url', $receiver, \PDO::PARAM_STR);
      $stmt->bindParam(':listener', $listener, \PDO::PARAM_STR);
      $stmt->bindParam(':event', $event, \PDO::PARAM_STR);
      $stmt->bindParam(':method', $method, \PDO::PARAM_STR);
      $stmt->bindParam(':line', $line, \PDO::PARAM_STR);
      
      if($stmt->execute()) 
      {
        $this->addState(SkynetTypes::DB_LOG, 'USERLOG [created by &gt;&gt; '.$listener.' ] SAVED TO DB');
        return true;
      }
      
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::DB_LOG, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
}

/**
 * Skynet/EventLogger/SkynetEventListenerLoggerFiles.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Listener Logger - Files
  *
  * Saves events logs in txt files
  */
class SkynetEventListenerLoggerFiles extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{  
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)
  {

  }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if(!SkynetConfig::get('logs_txt_requests'))
    {
      return false;
    }
    $this->saveRequestToFile($context);
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if(!SkynetConfig::get('logs_txt_responses'))
    {
      return false;
    }
    $this->saveResponseToFile($context);
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {

  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {

  }
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];    
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */    
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }

 /**
  * Decodes value if encrypted
  *
  * @param string $key Field name/key
  * @param string $val Value
  *
  * @return string Decoded value
  */
  private function decodeIfNeeded($key, $val)
  {
    if(is_numeric($key)) 
    {
      return $val;
    }
    
    if($key == '_skynet_clusters_chain' || $key == '@_skynet_clusters_chain')
    {
      $ret = [];
      $clusters = explode(';', $val);
      foreach($clusters as $cluster)
      {
        $ret[] = base64_decode($cluster);
      }
      return implode('; ', $ret);
    }

    $toDecode = [];
    if(in_array($key, $toDecode))
    {      
      return base64_decode($val);
    } else {     
      return $val;
    }
  }

 /**
  * Saves response to file
  *
  * @param string $context Context - beforeSend | afterReceive
  *
  * @return bool True if success
  */
  private function saveResponseToFile($context)
  {
    $remote = '';
    $direction = '';
    $suffix = '';
    if($context == 'afterReceive')
    {
      if(isset($this->responseData['_skynet_cluster_url']))
      {
        $remote = $this->responseData['_skynet_cluster_url'];
      }
      $direction = 'from';
      $suffix = 'in';
    } elseif($context == 'beforeSend')
    {
      if(isset($this->requestsData['_skynet_sender_url']))
      {
        $remote = $this->requestsData['_skynet_sender_url'];
      }
      $direction = 'to';
      $suffix = 'out';
    }

    $fileName = 'response_'.$suffix;
    $logFile = new SkynetLogFile('RESPONSE');
    $logFile->setFileName($fileName);
    $logFile->setCounter($this->connId);
    if(SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->setHeader("Response ".$direction.": ".$remote);
    }

    foreach($this->responseData as $k => $v)
    {
      if($this->canSave($k))
      {
        $logFile->addLine($this->parseLine($k, $v));
      }
    }
    /* If from response sender */
    if($direction == 'to')
    {
      $logFile->addSeparator();
      if(SkynetConfig::get('logs_txt_include_clusters_data'))
      {
        $logFile->addLine("RESPONSE FOR THIS REQUEST FROM [".$remote."]");
      }
      foreach($this->requestsData as $k => $v)
      {
        if($this->canSave($k))
        {
          $logFile->addLine($this->parseLine($k, $v));
        }
      }
    }
    return $logFile->save();
  }

 /**
  * Saves request to file
  *
  * @param string $context Context - beforeSend | afterReceive
  *
  * @return bool True if success
  */
  private function saveRequestToFile($context)
  {
    $receiver = '';
    $direction = '';
    $suffix = '';

    if($context == 'afterReceive')
    {
      if(isset($this->requestsData['_skynet_sender_url']))
      {
        $receiver = $this->requestsData['_skynet_sender_url'];
      }
      $direction = 'from';
      $suffix = 'in';
    } elseif($context == 'beforeSend')
    {
      if(isset($this->receiverClusterUrl))
      {
        $receiver = $this->receiverClusterUrl;
      }
      $direction = 'to';
      $suffix = 'out';
    }

    $fileName = 'request_'.$suffix;
    $logFile = new SkynetLogFile('REQUEST');
    $logFile->setFileName($fileName);
    $logFile->setCounter($this->connId);
    if(SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->setHeader("Request ".$direction.": ".$receiver);
    }
    foreach($this->requestsData as $k => $v)
    {
      if($this->canSave($k))
      {
        $logFile->addLine($this->parseLine($k, $v));
      }
    }
    return $logFile->save();
  }

 /**
  * Saves echo to file
  *
  * @param string[] $addresses Array of echoes urls
  * @param SkynetClustersUrlsChain $urlsChain URLS chain
  *
  * @return bool True if success
  */
  public function saveEchoToFile($addresses, SkynetClustersUrlsChain $urlsChain)
  {
    $receiver = '';
    if(isset($this->receiverClusterUrl)) 
    {
      $receiver = $this->receiverClusterUrl;
    }

    $receivers_urls = implode(';', $addresses);
    $urlsChainPlain = $urlsChain->getClustersUrlsPlainChain();
    $senderUrl = $this->request->getSenderClusterUrl();

    $fileName = 'echo';
    $logFile = new SkynetLogFile('ECHO');
    $logFile->setFileName($fileName);
    if(SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->setHeader("@Echo From (sended to me from): ".$senderUrl);
      $logFile->setHeader("@Echo To (resended to): ".$receivers_urls);
      $logFile->addLine("URLS CHAIN: ".$urlsChainPlain);
      $logFile->addSeparator();
      $logFile->addLine("#REQUEST FROM [".$senderUrl."]:");
    }

    foreach($this->requestsData as $k => $v)
    {
      if($this->canSave($k))
      {
        $logFile->addLine($this->parseLine($k, $v));
      }
    }
    return $logFile->save();
  }

 /**
  * Saves broadcast to file
  *
  * @param string[] $addresses Array of broadcasted urls
  * @param SkynetClustersUrlsChain $urlsChain URLS chain
  * @param string[] $broadcastedRequests Array of broadcastd requests
  *
  * @return bool True if success
  */
  public function saveBroadcastToFile($addresses, SkynetClustersUrlsChain $urlsChain, $broadcastedRequests)
  {
    $receiver = '';
    if(isset($this->receiverClusterUrl)) 
    {
      $receiver = $this->receiverClusterUrl;
    }

    $receivers_urls = implode(';', $addresses);
    $urlsChainPlain = $urlsChain->getClustersUrlsPlainChain();
    $senderUrl = $this->request->getSenderClusterUrl();

    $fileName = 'broadcast';
    $logFile = new SkynetLogFile('BROADCAST');
    $logFile->setFileName($fileName);
    if(SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->setHeader("@Broadcast From (sended to me from): ".$senderUrl);
      $logFile->setHeader("@Broadcast To (resended to): ".$receivers_urls);
      $logFile->addLine("URLS CHAIN: ".$urlsChainPlain);
    }
    $logFile->addSeparator();
    if(SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->addLine("#REQUEST FROM [".$senderUrl."]:");
    }

    foreach($this->requestsData as $k => $v)
    {
      if($this->canSave($k))
      {
        $logFile->addLine($this->parseLine($k, $v));
      }
    }

    if(is_array($broadcastedRequests) && count($broadcastedRequests) > 0)
    {
      $logFile->addSeparator();
      if(SkynetConfig::get('logs_txt_include_clusters_data'))
      {
        $logFile->addLine("@BROADCASTED REQUEST TO [".$receivers_urls."]:");
      }
      
      foreach($broadcastedRequests as $k => $v)
      {
        if($this->canSave($k))
        {
          $logFile->addLine($this->parseLine($k, $v, true));
        }
      }
    }
    return $logFile->save();
  }  
  
 /**
  * Saves self-update log to file
  *
  * @param string[] $logs Array of update logs
  *
  * @return bool True if success
  */
  public function saveSelfUpdateToFile($logs)
  {  
    $senderUrl = $this->request->getSenderClusterUrl();
    
    $fileName = 'self-update';
    $logFile = new SkynetLogFile('SELF-UPDATE');
    $logFile->setFileName($fileName);
    if(SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->setHeader("@Self-update request From (sended to me from): ".$senderUrl);
    }
    $logFile->addLine("UPDATE LOG:");
    foreach($logs as $k => $v)
    {     
      $logFile->addLine($this->parseLine($k, $v));     
    }    
    
    $logFile->addSeparator();
    if(SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->addLine("#REQUEST FROM [".$senderUrl."]:");
    }

    foreach($this->requestsData as $k => $v)
    {
      if($this->canSave($k))
      {
        $logFile->addLine($this->parseLine($k, $v));
      }
    }
    return $logFile->save();
  }
  
 /**
  * Saves User Log
  *
  * @param string $content Log message
  * @param string $listener Event listener/file
  * @param string $line Line
  * @param string $event Event name
  * @param string $method Method name
  */
  public function saveUserLogToFile($content, $listener = '', $line = 0, $event = '', $method = '')
  {   
    $logs = [];
    if(SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logs['Sender URL'] = $this->senderClusterUrl;
      $logs['Receiver URL'] = $this->receiverClusterUrl;
    }
    $logs['Listener'] = $listener;
    $logs['Event'] = $event;
    $logs['Method'] = $method;
    $logs['Line'] = $line;   
    $logs['Message'] = $content;    
    
    $fileName = 'log';
    $logFile = new SkynetLogFile('USERLOG');
    $logFile->setFileName($fileName);
    $logFile->setHeader("@User log from Event Listener: ".$listener);
    $logFile->addLine("LOG:");
    foreach($logs as $k => $v)
    {     
      $logFile->addLine($this->parseLine($k, $v));     
    }    
    
    $logFile->addSeparator();
    if(SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->addLine("#SENDER [".$this->senderClusterUrl."]");
      $logFile->addLine("#RECEIVER [".$this->receiverClusterUrl."]");
    }

    return $logFile->save();
  }

 /**
  * Parses single line
  *
  * @param string $k Field name/key
  * @param string $v Field value
  * @param bool $force Force include if internal param
  *
  * @return string Parsed line
  */
  private function parseLine($k, $v, $force = false)
  {     
    $row = '';    
    if(SkynetConfig::get('logs_txt_include_internal_data') || $force)
    {
       $row = "  ".$k.": ".$this->decodeIfNeeded($k, $v);
    } else {
       if(!$this->verifier->isInternalParameter($k)) 
       {
         $row = "  ".$k.": ".$this->decodeIfNeeded($k, $v);
       }
    }       
    return $row;
  }

 /**
  * Checks for secure data
  *
  * @param string $key Field key
  *
  * @return bool True if can save
  */  
  private function canSave($key)
  {
    if($key == '_skynet_id' || $key == '_skynet_hash' || $key == '@_skynet_id' || $key == '@_skynet_hash')
    {
      if(!SkynetConfig::get('logs_txt_include_secure_data'))
      {
        return false;
      }
    }
    
    if($key == '_skynet_cluster_url' || $key == '_skynet_sender_url' || $key == '@_skynet_cluster_url' || $key == '@_skynet_sender_url' || $key == '_skynet_clusters_chain' || $key == '@_skynet_clusters_chain')
    {
      if(!SkynetConfig::get('logs_txt_include_clusters_data'))
      {
        return false;
      }
    }
    
    return true;
  }
}

/**
 * Skynet/EventLogger/SkynetEventLoggersFactory.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Event Loggers Factory
  *
  * Factory for Event Loggers
  */
class SkynetEventLoggersFactory
{
  /** @var SkynetEventListenerInterface[] Array of Event Listeners */
  private $eventListeners = [];

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */ private function __clone() {}

 /**
  * Registers Event Loggers classes in registry
  */
  private function registerEventListeners()
  {
    $this->register('emailer', new SkynetEventListenerEmailer());
    $this->register('databaseLogger', new SkynetEventListenerLoggerDatabase());
    $this->register('fileLogger', new SkynetEventListenerLoggerFiles());
  }

 /**
  * Returns choosen Event Logger from registry
  *
  * @param string $name
  *
  * @return SkynetEventListenerInterface EventLogger
  */
  public function getEventListener($name)
  {
    if(array_key_exists($name, $this->eventListeners))
    {
      return $this->eventListeners[$name];
    }
  }

 /**
  * Returns all Event Loggers from registry as array
  *
  * @return SkynetEventListenerInterface[] Array of Event Loggers
  */
  public function getEventListeners()
  {
    return $this->eventListeners;
  }

 /**
  * Checks for Event Loggers in registry
  *
  * @return bool True if events exists
  */
  public function areRegistered()
  {
    if($this->eventListeners !== null && count($this->eventListeners) > 0) return true;
  }

 /**
  * Registers Event Logger in registry
  *
  * @param string $id name/key of logger
  * @param SkynetEventListenerInterface $class New instance of logger class
  */
  private function register($id, SkynetEventListenerInterface $class)
  {
    $this->eventListeners[$id] = $class;
  }

 /**
  * Returns instance
  *
  * @return SkynetEventLoggersFactory
  */
  public static function getInstance()
  {
    static $instance = null;
    if($instance === null)
    {
      $instance = new static();
      if(!$instance->areRegistered()) $instance->registerEventListeners();
    }
    return $instance;
  }
}

/**
 * Skynet/Filesystem/SkynetCloner.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Cloner
  *
  * Creates another Skynet clusters on-fly
  */
class SkynetCloner
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->clustersRegistry = new SkynetClustersRegistry();    
  }

 /**
  * Starts clone process
  *
  * @return string[] Array of clones addresses or false
  */
  public function startCloning()
  {   
    $dirsList = $this->inspectDirs();
    $success = [];
    
    if($dirsList !== false)
    {
      foreach($dirsList as $dir)
      {
        $newClone = $this->cloneTo($dir);
        if($newClone !== false)
        {
          $success[] = $newClone;
        }        
      }      
    
      if(count($success) > 0)
      {
        return $this->registerNewClones($success);        
      } 
      return false;
    }
  }

 /**
  * Registers new clones in DB
  *
  * @param string[] $clusters Array with addresses of new clones
  *
  * @return string[] Array of clones addresses or false
  */  
  public function registerNewClones($clusters)
  {
    $success = [];
    
    foreach($clusters as $address)
    {
      $cluster = new SkynetCluster();
      $cluster->setUrl($address);
      $cluster->getHeader()->setUrl($address);
      if($this->clustersRegistry->add($cluster))
      {
        $success[] = $address;
      }
    }    
    
    if(count($success) > 0)
    {
      return $success;
    } 
    return false;
  }  

 /**
  * Gets list of dirs
  *
  * @param string $from Start directory
  *
  * @return string[] Array of dirs paths or false
  */  
  public function inspectDirs($from = null)
  {
    if($from !== null && !empty($from))
    {
      if(substr($from, -1) != '/')
      {
        $from.= '/';
      }
      if(!is_dir($from))
      {
        $this->addError(SkynetTypes::CLONER, 'DIR: '.$from.' NOT EXISTS');  
        return false;
      }
    }
    
    $dir = @glob($from.'*');
    $dirs = [];
    
    $toExcludeDirs = [];
    $excludeDirs = [];
    
    $toExcludeDirs[] = SkynetConfig::get('logs_dir');
    
    foreach($toExcludeDirs as $excludeDir)
    {
      if(!empty($exludeDir) && substr($excludeDir, -1) == '/')
      {
        $excludeDir = rtrim($excludeDir, '/');
        $excludeDirs[] = $excludeDir;
      }      
    }
    
    foreach($dir as $path)
    {
      if(is_dir($path))
      {
        $base = basename($path);
        if(!in_array($base, $excludeDirs))
        {
          $dirs[] = $path;
        }
      }
    }
    
    if(count($dirs) > 0)
    {
      return $dirs;
    } 
    return false;
  }

 /**
  * Clones Skynet to another file
  *
  * @param string $dir Destination dir
  *
  * @return string[] Array of cloned addresses or false
  */
  public function cloneTo($dir)
  {
    if(substr($dir, -1) != '/')
    {
      $dir.= '/';
    }
    
    $myFile = basename($_SERVER['PHP_SELF']);   
    $hash = substr(md5($_SERVER['PHP_SELF']), -5, 5);    
    $newFile = $dir.$hash.'_'.$myFile;  
    
    if(file_exists($newFile))
    {
      return false;
    }
    
    try
    {      
      if(@copy($myFile, $newFile))
      {
        $this->addState(SkynetTypes::CLONER,'CLONED TO: '.$newFile);  
        $address = $_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']).$newFile;       
        return $address;
        
      } else {        
        throw new SkynetException('CLONED TO: '.$newFile.' FAILED');    
      }
    } catch(SkynetException $e)
    {
      $this->addError(SkynetTypes::CLONER, $e->getMessage(), $e);  
      return false;
    }
  }
}

/**
 * Skynet/Filesystem/SkynetDetector.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

 /**
  * Skynet Detector
  *
  * Checks for other clusters in this directory
  */
class SkynetDetector
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->clustersRegistry = new SkynetClustersRegistry();    
  }

 /**
  * Detect clusters in folder
  *
  * @return string[] Array of possible clusters
  */
  private function checkDir($dir = '')
  {   
    $clusters = [];
    
    if(!empty($dir))
    {
      if(substr($dir, -1) != '/')
      {
        $dir.= '/';
      }
    }    
    
    $d = glob($dir.'*skynet*.php');
    foreach($d as $file)
    {
      $name = str_replace($d, '', $file);      
      $address = SkynetHelper::getMyServer().'/'.$file;
      
      if(!$this->clustersRegistry->addressExists($address) && $address != SkynetHelper::getMyUrl())
      {
        $clusters[] = $address; 
      }   
    }     
    return $clusters;
  }   
  
 /**
  * Check for clusters in dir
  *
  * @return string monit
  */  
  public function check()
  {
    $clusters = $this->checkDir();
    if(count($clusters) > 0)
    {
      $monit = 'Clusters detector: Possible Skynet clusters detected in this directory: <br>';
      
      foreach($clusters as $cluster)
      {
        $monit.= ' - <a href="javascript:skynetControlPanel.insertConnect(\''.SkynetConfig::get('core_connection_protocol').$cluster.'\');"><b>'.$cluster.'</b></a><br>';       
      }
      
      $monit.= 'If you want to try to connect with this address click on address above and send <b>@connect</b> request.';   
      return $monit;
      
    } else {
      
      return null;
    }
  }  
}

/**
 * Skynet/Filesystem/SkynetLogFile.php
 *
 * Checking and veryfing access to skynet
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Log File
  *
  * Creates and manipulates log files
  */
class SkynetLogFile
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var string[] Array of rows/lines in log */
  private $lines = [];

  /** @var string[] Array of header lines */
  private $headers = [];

  /** @var string[] Array of user-header lines */
  private $dataHeaders = [];

  /** @var string Parsed lines  */
  private $data;

  /** @var string Log filename */
  private $fileName;

  /** @var string Name of log */
  private $name;

  /** @var string Extension of log file */
  private $ext;

  /** @var integer File number, numering for multiple files from one generator */
  private $counter;

  /** @var string suffix with name of generator */
  private $selfSuffix;
  
  /** @var bool Add time prefix */
  private $timePrefix = true;

 /**
  * Constructor
  *
  * @param string $name Name of log
  */
  public function __construct($name = null)
  {
    $this->name = $name;
    $this->ext = '.txt';
    
    $logsDir = SkynetConfig::get('logs_dir');
    if(!empty($logsDir) && substr($logsDir, -1) != '/')
    {
      $logsDir.= '/';
      SkynetConfig::set('logs_dir', $logsDir);
    }
    
    if(!empty($logsDir) && !is_dir($logsDir)) 
    {
      try
      {
        if(!mkdir($logsDir))
        {
          throw new SkynetException('ERROR CREATING DIRECTORY: '.$logsDir);
        }          
      } catch(SkynetException $e)
      {
        $this->addError(SkynetTypes::LOGFILE, 'LOGS DIR: '.$e->getMessage(), $e);
      }
    }
  }

 /**
  * Adds new line
  *
  * @param string $line
  */
  public function addLine($line = '')
  {
    $this->lines[] = $line;    
  }

 /**
  * Sets filename
  *
  * @param string $fileName
  */
  public function setFileName($fileName)
  {
    $this->fileName = $fileName;
  }

 /**
  * Sets suffix
  *
  * @param string $suffix
  */
  public function setSuffix($suffix)
  {
    $this->selfSuffix = $suffix;
  }
  
 /**
  * Sets auto adding time_prefix
  *
  * @param bool $mode
  */  
  public function setTimePrefix($mode)
  {
    $this->timePrefix = $mode;
  }

 /**
  * Sets file counter
  *
  * @param int $counter
  */
  public function setCounter($counter)
  {
    $this->counter = $counter;
  }

 /**
  * Sets log name
  *
  * @param string $name
  */
  public function setName($name)
  {
    $this->name = $name;
  }

 /**
  * Adds header line
  *
  * @param string $data
  */
  public function setHeader($data)
  {
    $this->dataHeaders[] = $data;
  }

 /**
  * Prepares header
  */
  private function addHeader()
  {
    $this->headers[] = implode($this->nl(), $this->dataHeaders);
    $this->headers[] = $this->nl();
    $this->headers[] = $this->lineSeparator();
    $this->headers[] = $this->nl();
  }

 /**
  * Prepares metadata
  */
  private function addMeta()
  {
    $this->headers[] = "Skynet Log file (generated: ".date('H:i:s d.m.Y')." [".time()."])";
    $this->headers[] = $this->nl();
    $this->headers[] = "File generated by: ".SkynetHelper::getMyUrl();
    $this->headers[] = $this->nl();
  }

 /**
  * Returns line separator string
  *
  * @return string
  */
  private function lineSeparator()
  {
    return "------------";
  }

 /**
  * Adds line separator
  */
  public function addSeparator()
  {
    $this->lines[] = $this->lineSeparator();
  }

 /**
  * Returns new line string
  *
  * @return string
  */
  public function nl()
  {
    return "\r\n";
  }

 /**
  * Adds begin tag
  */
  private function addBegin()
  {
     $this->headers[] = " {".$this->nl();
  }

 /**
  * Adds ending tag
  */
  private function addEnd()
  {
    $this->lines[] = "}";
  }

 /**
  * Adds prefix (log name)
  */
  private function addPrefix()
  {
    $this->headers[] = '#'.$this->name;
  }

 /**
  * Prepares headers
  */
  private function generateHeaders()
  {
    $this->addPrefix();
    $this->addBegin();
    $this->addMeta();
    $this->addHeader();
    $this->data = implode('', $this->headers);
  }

 /**
  * Prepares lines data
  *
  * @param string|null $mode If null then adds the end prefix
  */
  private function generateData($mode = null)
  {
    if($mode === null) 
    {
      $this->addEnd();
    }
    $this->data.= implode($this->nl(), $this->lines);
  }

 /**
  * Saves log to file
  *
  * @param string|null $mode NULL if new/or overwrite file if exists, "after" - to append new data after old data, or "before" to add data at the beginning of old data
  * @param bool $toFile Save to file
  */
  public function save($mode = null, $toFile = true)
  {   
    $logsDir = SkynetConfig::get('logs_dir');    
    
    if($this->selfSuffix === null) 
    {
      $this->selfSuffix = str_replace("/", "-", SkynetHelper::getMyUrl());
    }
    $suffix = '_'.$this->selfSuffix;

    $counter = '';
    if($this->counter !== null) 
    {
      $counter = '_'.$this->counter;
    }
    
    $time = '';
    if($this->timePrefix) 
    {
      $time = time().'_';    
    }
    $file = $logsDir.$time.$this->fileName.$suffix.$counter.$this->ext;
    
    /* Save mode */
    if($mode !== null)
    {
      $oldData = '';
      if(file_exists($file))
      {
        $oldData = @file_get_contents($file);
      }
      
      if(!empty($oldData))
      {
        switch($mode)
        {
          case 'before':
            $this->generateData($mode);
            $this->data = $this->data.$this->nl().$oldData;
          break;
          
          case 'after':
            $this->generateData($mode);
            $this->data = $oldData.$this->nl().$this->data;
          break;        
        } 
      } else {
        $this->generateHeaders();
        $this->generateData($mode);
      }
     
    } else {
        $this->generateHeaders();
        $this->generateData($mode);
    }
    
    if($toFile)
    {
      try
      {
        if(file_put_contents($file, $this->data))
        {
          $this->addState(SkynetTypes::LOGFILE, $this->name.' LOG ['.$file.'] SAVED');
          return true;
        } else {      
          $this->addState(SkynetTypes::LOGFILE, $this->name.' LOG ['.$file.'] NOT SAVED');
          throw new SkynetException('ERROR SAVING LOG FILE: '.$file);
        }
      } catch(SkynetException $e)
      {
        $this->addError(SkynetTypes::LOGFILE, 'LOG FILE: '.$e->getMessage(), $e);
      }
    }
    return $this->data;
  }
}

/**
 * Skynet/Renderer/Cli/SkynetRendererCli.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet CLI Output Renderer 
  */
class SkynetRendererCli extends SkynetRendererAbstract implements SkynetRendererInterface
{
  use SkynetErrorsTrait, SkynetStatesTrait;   
  

  /** @var string[] HTML elements of output */
  private $output = [];   
  
  /** @var SkynetRendererHtmlDebugRenderer Debug Renderer */
  private $debugRenderer;
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetRendererHtmlDatabaseRenderer Database Renderer */
  private $databaseRenderer;
  
  /** @var SkynetRendererHtmlConnectionsRenderer Connections Renderer */
  private $connectionsRenderer; 
  
  /** @var SkynetEventListenersInterface[] Array of Event Listeners */
  private $eventListeners = [];

  /** @var SkynetEventListenersInterface[] Array of Event Loggers */
  private $eventLoggers = [];

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct(); 
    
    $this->elements = new SkynetRendererCliElements();    
    $this->debugRenderer = new SkynetRendererCliDebugRenderer();
    $this->databaseRenderer = new  SkynetRendererCliDatabaseRenderer();
    $this->connectionsRenderer = new  SkynetRendererCliConnectionsRenderer();  
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();    
  }
  
 /**
  * Renders and returns debug section
  *
  * @return string Output string
  */     
  private function renderDebugSection()
  {
    $output = [];   
     
    /* Center Main : Left Column */
    $output[] = $this->elements->addSectionId('columnDebug');   

    /* Center Main : Left Column: summary */
    $output[] = $this->elements->addSubtitle('Summary');
    $output[] = $this->debugRenderer->parseFields($this->fields);

    /* Center Main : Left Column: errors */
    $output[] = $this->elements->addSeparator();    
   
    if(count($this->errorsFields) > 0)
    {
      $output[] = $this->elements->addSubtitle('Errors');
      $output[] = $this->debugRenderer->parseErrorsFields($this->errorsFields);
    }

    if($this->cli->haveArgs() && $this->cli->isCommand('status'))
    {
      /* Center Main : Left Column: states */
      $output[] = $this->elements->addSeparator();
      $output[] = $this->elements->addSubtitle('States');
      $output[] = $this->debugRenderer->parseStatesFields($this->statesFields);
    }

    if($this->cli->haveArgs() && $this->cli->isCommand('cfg'))
    {
      /* Center Main : Left Column: Config */
      $output[] = $this->elements->addSeparator();
      $output[] = $this->elements->addSubtitle('Config');
      $output[] = $this->debugRenderer->parseConfigFields($this->configFields);
    }
    
    return implode('', $output);
  }
  
 /**
  * Renders and returns connections view
  *
  * @return string Output string
  */    
  private function renderConnectionsSection()
  {
    $output = [];   
    /* Center Main : Right Column: */
    $output[] = $this->elements->addSectionId('columnConnections');         
    $output[] = $this->connectionsRenderer->renderConnections($this->connectionsData);
    $output[] = $this->elements->addSectionEnd();  
    return implode('', $output);      
  } 

 /**
  * Renders and returns header
  *
  * @return string Output string
  */ 
  private function renderHeaderSection()
  {
    $output = [];
    
    //$header = $this->elements->getNl().$this->elements->addH1('//\\\\ SKYNET v.'.SkynetVersion::VERSION);
    $header = $this->elements->getNl().'(c) 2017 Marcin Szczyglinski | Check for newest versions here: '.$this->elements->addUrl(SkynetVersion::WEBSITE);
    $header.= $this->elements->getNl();
    $output[] = $header;      
    return implode('', $output);
  }
  
 /**
  * Generates new password hash
  *
  * @return string Output string
  */
  public function renderPwdGen()
  {
    $params = $this->cli->getParams('pwdgen');
    if($params !== null && isset($params[0]) && !empty($params[0]))       
    {
      return $this->elements->getNl().'Password hash for "'.$params[0].'": '.password_hash($params[0], PASSWORD_BCRYPT).$this->elements->getNl().'(you can put this password hash into your SkynetConfig.php)';
    } else {
      return $this->elements->getNl().'Password string missing. Use: -pwdgen <your password> to generate hash';
    }    
  } 

 /**
  * Generates new Skynet ID Key
  *
  * @return string Output string
  */
  public function renderKeyGen()
  {
    $rand = rand(0,99999);   
    $key = sha1(time().md5($rand));
    return $this->elements->getNl().'New randomly generated SKYNET ID KEY: '.$key.$this->elements->getNl().'(you can put this ID Key into your SkynetConfig.php)';
  } 
  
 /**
  * Prepare listeners commands
  */  
  private function prepareListenersCommands()
  {
    $commands = [];    
    foreach($this->eventListeners as $listener)
    {
      $tmpCommands = $listener->registerCommands();      
      
      if(is_array($tmpCommands) && isset($tmpCommands['cli']) && is_array($tmpCommands['cli']))
      {
        foreach($tmpCommands['cli'] as $command)
        {
          $cmdName = '';
          $cmdDesc = '';
          $cmdParams = '';
          
          if(isset($command[0]))
          {
            $cmdName = $command[0];
          }
          
          if(isset($command[1]))
          {
            if(is_array($command[1]))
            {
              $params = [];
              foreach($command[1] as $param)
              {
                if(!empty($param))
                {
                  $params[] = '<'.$param.'>';
                }
              }              
              $cmdParams = ' '.implode(' or ', $params).' ';
            } else {
              
              if(!empty($command[1]))
              {
                $cmdParams = ' <'.$command[1].'> ';
              } else {
                $cmdParams = '';
              }
            }
          }
          
          if(isset($command[2]))
          {
            $cmdDesc = $command[2];
          }
          
          $commands[] = ' '.$cmdName.$cmdParams.' | '.$cmdDesc;                
        }
      }
    }   
    return $commands;
  }
  
 /**
  * Renders and returns commands helper
  *
  * @return string Output string
  */
  private function renderCommandsHelp()
  {
    $databaseSchema = new SkynetDatabaseSchema();
    $tables = ' [?] Database tables: '.implode(', ', array_flip($databaseSchema->getDbTables()));
    $listenersCommands = $this->prepareListenersCommands();
   
    $str = $this->elements->getSeparator()." [?] HELP: Commands list [you can put multiple params at once, separating by space]:".$this->elements->getSeparator().$this->elements->getNl();      
    $str.= implode($this->elements->getNl(), $listenersCommands);    
    $str.= $this->elements->getNl().$this->elements->getNl().$tables.$this->elements->getNl();
    
    return $str;
  }  
  
 /**
  * Renders ad commands
  *
  * @return string Output string
  */ 
  private function renderEndCommands()
  {
    $output = [];
    
    if($this->cli->haveArgs() && ($this->cli->isCommand('h') || $this->cli->isCommand('help')))
    {
      $output[] = $this->renderCommandsHelp();
    } else {
      $output[] = $this->elements->getSeparator().' [?] HELP: "php '.$_SERVER['argv'][0].' -h" OR "php '.$_SERVER['argv'][0].' -help" displays Skynet CLI commands list.';
    }
    
    return implode('', $output);   
  }
  
 /**
  * Renders and returns HTML output
  *
  * @return string Output string
  */
  public function render()
  {     
    $listenersOutput = implode($this->elements->getNl(), $this->cliOutput);    
    
    if(!$this->cli->haveArgs() || ($this->cli->haveArgs() && !$this->cli->isCommand('out')))
    {
      $this->output[] = $this->elements->addHeader();  

      /* Render header */
      $this->output[] = $this->renderHeaderSection();    
          
      switch($this->mode)
      {
        case 'connections':
           /* --- Center Main --- */      
           $this->output[] = $this->renderDebugSection();
           $this->output[] = $this->renderEndCommands();
           
           if($this->cli->haveArgs() && ($this->cli->isCommand('dbg') || $this->cli->isCommand('debug')))
           {
              $this->output[] = $this->renderConnectionsSection();
           } else {
             $this->output[] = $this->elements->getSeparator().$this->elements->getNl().'[RESULT] Executed connections to clusters: '.count($this->connectionsData);
           }
           $this->output[] = $this->elements->addSectionEnd();        
   
        break; 

        case 'database':
           /* --- Center Main --- */
           $this->output[] = $this->renderEndCommands();
           $this->output[] = $this->elements->addSectionId('dbRecords'); 
           $this->output[] = $this->databaseRenderer->renderDatabaseView();
           $this->output[] = $this->elements->addSectionEnd();
        break;
      }   
      /* Center Main : END */   
      
      $this->output[] = $listenersOutput;    

      $params = $this->cli->getParams('send');
      
      $this->output[] = $this->elements->addFooter();
      
    } else {
        $params = $this->cli->getParams('out');        
        if($params !== null && isset($params[0]))
        {
          $e = explode(',', $params[0]);
          $outputParams = [];
          if($e > 0)
          {
            foreach($e as $paramKey)
            {
              $outputParams[] = trim($paramKey);
            }            
          }          
          
          $this->output[] = $this->connectionsRenderer->renderConnections($this->connectionsData, $outputParams);         
        } else {
          $this->output[] = $this->connectionsRenderer->renderConnections($this->connectionsData, true);
        }
    }  
    
    return implode('', $this->output);
  } 
}

/**
 * Skynet/Renderer/Cli/SkynetRendererCliConnectionsRenderer.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer HTML Connections Renderer
  */
class SkynetRendererCliConnectionsRenderer
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererCliElements();
    $this->params = new SkynetParams;
    $this->verifier = new SkynetVerifier();
  }   
  
 /**
  * Assigns Elements Generator
  *
  * @param SkynetRendererHtmlElements $elements
  */
  public function assignElements($elements)
  {
    $this->elements = $elements;   
  } 

 /**
  * Parses fields with time
  * 
  * @param string $key
  * @param string $value
  *
  * @return string Parsed time
  */  
  private function parseParamTime($key, $value)
  {
    if(!SkynetConfig::get('translator_params'))
    {
      return $value;
    }
    
    $timeParams = ['_skynet_sender_time', '_skynet_cluster_time', '_skynet_chain_updated_at', '@_skynet_sender_time', '@_skynet_cluster_time', '@_skynet_chain_updated_at'];
    if(in_array($key, $timeParams) && !empty($value) && is_numeric($value))
    {
      return date(SkynetConfig::get('core_date_format'), $value);      
    } else {
      return $value;
    }
  }
      
 /**
  * Parses array 
  * 
  * @param string[] $fields Array with fields
  * @param string[] $onlyFields Only selected fields
  *
  * @return string HTML code
  */    
  public function parseParamsArray($fields, $onlyFields = null)
  {
    $rows = []; 
    $debugInternal = SkynetConfig::get('debug_internal');
    $debugEcho = SkynetConfig::get('debug_echo');
    
    foreach($fields as $key => $field)
    {
      if($onlyFields === null)
      {
        $render = true;      
        if(SkynetConfig::get('translator_params'))
        {
          $paramName = $this->params->translateInternalParam(htmlspecialchars($field->getName(), ENT_QUOTES, "UTF-8"));
        } else {
          $paramName = $field->getName();
        }
        
        if($this->verifier->isInternalParameter($field->getName()))
        {
          $render = false;
          if($debugInternal)
          {
            $render = true;
          }
        }
        
        if($this->verifier->isInternalEchoParameter($field->getName()))
        {
          if($debugInternal)
          {
            $render = false;
            if($debugEcho)
            {
              $render = true;
            }
          }
        }
        
        if($render)
        {
          $value = $this->parseParamTime($field->getName(), $field->getValue());        
        
          if($this->params->isPacked($value))
          {
            $unpacked = $this->params->unpackParams($value);
            if(is_array($unpacked))
            {
              $extracted = [];
              foreach($unpacked as $k => $v)
              {
                $extracted[] = '-'.$k.': '.$v;            
              }
              $parsedValue = implode($this->elements->getNl(), $extracted);
            } else {
              $parsedValue = $unpacked;
            }
            
          } else {
            
            $parsedValue = $value;
          }    
          
          $rows[] = $paramName.': '.$parsedValue;    
        }
      
      } else {
        
        if(is_array($onlyFields))
        {
          if(in_array($key, $onlyFields))
          {
            $rows[] = strip_tags($field->getValue());   
          }
        } else {
          
          $rows[] = strip_tags($field->getValue());  
        }
      }      
    }
    return implode(';'.$this->elements->getNl(), $rows);        
  }
  
 /**
  * Parses connection array data fields
  *
  * @param string[] $fields Array of fields arrays
  * @param string $clusterUrl
  * @param string[] $onlyFields Only selected fields
  *
  * @return string HTML code
  */   
  public function parseConnectionFields($fields, $clusterUrl, $onlyFields = null)
  {
    $names = [
      'request_raw' => 'Request Fields {sended} (plain) '.$this->elements->getGt().$this->elements->getGt().' to: '.$this->elements->addSpan($clusterUrl, 't'),
      'request_encypted' => 'Request Fields {sended} (encrypted) '.$this->elements->getGt().$this->elements->getGt().' to: '.$this->elements->addSpan($clusterUrl, 't'),
      'response_raw' => 'Response Fields {received} (raw) '.$this->elements->getLt().$this->elements->getLt().' from: '.$this->elements->addSpan($clusterUrl, 't'),
      'response_decrypted' => 'Response Fields {received} (decrypted) '.$this->elements->getLt().$this->elements->getLt().' from: '.$this->elements->addSpan($clusterUrl, 't')
      ];      
    
    $rows = [];   
    foreach($fields as $key => $value)
    {
      if($onlyFields === null)
      {
        $rows[] = 
        $this->elements->addH3('[### '.$names[$key].' ###]').
        $this->parseParamsArray($value);
      } else {
        if($key == 'response_decrypted')
        {
          $rows[] = $clusterUrl." {\n".$this->parseParamsArray($value, $onlyFields)."\n}";
        }
      }      
    }
    if($onlyFields === null)
    {
      return implode($this->elements->getNl().$this->elements->getSeparator().$this->elements->getNl(), $rows);   
    } else {
      return implode($this->elements->getNl(), $rows); 
    }    
  }
 
 /**
  * Parses connection params array
  *
  * @param string[] $connData Array of connection data params
  * @param string[] $onlyFields Only selected fields
  *
  * @return string HTML code
  */ 
  public function parseConnection($connData, $onlyFields = null)
  {
    $rows = [];
    
    if($onlyFields === null)
    {
      $rows[] =     
      $this->elements->addH2('@'.$connData['id'].' Connection {').
      $this->elements->addH3('@ClusterAddress: '.$this->elements->addUrl($connData['CLUSTER URL']));
    }
      
    $paramsFields = ['SENDED RAW DATA'];  
    $rawDataFields = ['RECEIVED RAW DATA'];
      
    foreach($connData as $key => $value)
    {
      $parsedValue = $value;
      
      if($key == 'FIELDS')
      {
        $rows[] = $this->parseConnectionFields($value, $connData['CLUSTER URL'], $onlyFields);
                
      } else {
        
        $parsedValue = $value;
        
        if($key == 'CLUSTER URL')
        {
          $parsedValue = $this->elements->addUrl($value);
        }
        
        if(in_array($key, $paramsFields))
        {
          $parsedValue = $this->parseDebugParams($value);
          
        } elseif(in_array($key, $rawDataFields))
        {
          $parsedValue = $this->parseResponseRawData($value);
        }        
        
        if($onlyFields === null)
        {
           $rows[] = $this->elements->addBold('#'.strtoupper($key).' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked').' '.$parsedValue;   
        }
      }        
    }
    
    if($onlyFields === null)
    {
       $rows[] = $this->elements->addH2('}');
    }
    return implode($this->elements->getNl().$this->elements->getNl(), $rows);    
  }

 /**
  * Parses connections data array
  *
  * @param mixed[] $connectionsDataArray Connections data array
  * @param string[] $onlyFields Only selected fields
  *
  * @return string HTML code
  */  
  public function renderConnections($connectionsDataArray, $onlyFields = null)
  {
    $parsed = [];
    foreach($connectionsDataArray as $connData)
    {
      $parsed[] = $this->parseConnection($connData, $onlyFields);
    }        
    return implode($this->elements->getSeparator(), $parsed);
  }
  
 /**
  * Parses raw JSON response, bolds keys
  *
  * @param string $data Raw JSON response
  *
  * @return string Parsed JSON response
  */
  public function parseResponseRawData($data)
  {
    return $data;
  }

 /**
  * Parses params array
  *
  * @param mixed[] $params Array of params
  *
  * @return string Parsed string
  */
  public function parseDebugParams($params)
  {
    if(!is_array($params) || count($params) == 0) 
    {
      return null;
    }
    $fields = [];
    foreach($params as $k => $v)
    {
      $fields[] = $k.': '.$v;
    }
    return implode('; ', $fields);
  }
}

/**
 * Skynet/Renderer/Cli/SkynetRendererCliDatabaseRenderer.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer HTML Database Renderer
  *
  */
class SkynetRendererCliDatabaseRenderer
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var string Current table in Database view */
  protected $selectedTable;
  
  /** @var string[] Array with table names */
  protected $dbTables;
  
  /** @var SkynetDatabase DB Instance */
  protected $database;
  
  /** @var SkynetDatabaseSchema DB Schema */
  protected $databaseSchema;
  
  /** @var PDO Connection instance */
  protected $db;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var string Sort by */
  protected $tableSortBy;
  
  /** @var string Sort order */
  protected $tableSortOrder;
  
  /** @var int Current pagination */
  protected $tablePage;
  
  /** @var int Limit records per page */
  protected $tablePerPageLimit;
  
  /** @var SkynetCli Cli commands parser */ 
  protected $cli;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererCliElements();
    $this->database = SkynetDatabase::getInstance(); 
    $this->databaseSchema = new SkynetDatabaseSchema;        
    $this->dbTables = $this->databaseSchema->getDbTables();   
    $this->tablesFields = $this->databaseSchema->getTablesFields();
    $this->tablePerPageLimit = 10;
    $this->cli = new SkynetCli();
    
    $this->db = $this->database->connect();
    
    
    if($this->cli->isCli())
    {
      if($this->cli->isCommand('db'))
      {
        $params = $this->cli->getParams('db');
        if($params !== null)
        {
          if(isset($params[0]) && !empty($params[0]))
          {
            if(array_key_exists($params[0], $this->dbTables))
            {
              $this->selectedTable = $params[0];
            } 
          }
          
          if(isset($params[1]) && !empty($params[1]) && is_numeric($params[1]))
          {
             $this->tablePage = (int)$params[1];
          }
          
          if(isset($params[2]) && !empty($params[2]))
          {
             $this->tableSortBy = $params[2];
          }
          
          if(isset($params[3]) && !empty($params[3]))
          {
             $this->tableSortOrder = strtoupper($params[3]);
          }         
        } 

        if($this->cli->isCommand('del'))
        {
          $delParam = $this->cli->getParam('del');
          if($delParam !== null && is_numeric($delParam))
          {
            $this->database->ops->deleteRecordId($this->selectedTable, intval($delParam));            
          }        
        }
        
        if($this->cli->isCommand('truncate'))
        {
           $this->database->ops->deleteAllRecords($this->selectedTable);                 
        }
      }      
    }
    
    /* Set defaults */   
    if($this->selectedTable === null)
    {
      $this->selectedTable = 'skynet_clusters';
    }
   
    if($this->tableSortBy === null)
    {
      $this->tableSortBy = 'id';
    }
    
    if($this->tableSortOrder === null)
    {
      $this->tableSortOrder = 'DESC';
    }
    
    if($this->tablePage === null)
    {
      $this->tablePage = 1;
    }
  }   
  
 /**
  * Assigns Elements Generator
  *
  * @param SkynetRendererHtmlElements $elements
  */
  public function assignElements($elements)
  {
    $this->elements = $elements;   
  }  
  
    
 /**
  * Renders and returns records
  *
  * @return string HTML code
  */  
  public function renderDatabaseView()
  {
    $recordRows = [];    
    $start = 0;
    if($this->tablePage > 1)
    {
      $min = (int)$this->tablePage - 1;
      $start = $min * $this->tablePerPageLimit;
    }
    
    $rows = $this->database->ops->getTableRows($this->selectedTable, $start, $this->tablePerPageLimit, $this->tableSortBy, $this->tableSortOrder);
    if($rows !== false && count($rows) > 0)
    {
      $numRecords = $this->database->ops->countTableRows($this->selectedTable);
      $numPages = (int)ceil($numRecords / $this->tablePerPageLimit);
    
      $fields = $this->tablesFields[$this->selectedTable];   
      $header = $this->renderTableHeader($fields);
      $recordRows[] = ' '.$header.$this->elements->getNl().'+++++++++++++++++++++++++++'.$this->elements->getNl();
      $i = 0;
      foreach($rows as $row)
      {
        $recordRows[] = $this->renderTableRow($fields, $row); 
        $i++;
      }       
      $recordRows[] = '+++++++++++++++++++++++++++'.$this->elements->getNl().' '.$header;
      return 'Displaying ['.$i.'] records: [Page '.$this->tablePage.' / '.$numPages.'] [All records: '.$numRecords.'] from table: ['.$this->selectedTable.']'.$this->elements->getSeparator().implode('', $recordRows);
      
    } else {
      return 'No records.';
    }    
  } 

 /**
  * Renders and returns table header
  *
  * @param string[] $fields Array with table fields
  *
  * @return string HTML code
  */  
  private function renderTableHeader($fields)
  {
    $td = [];
    foreach($fields as $k => $v)
    {     
      $td[] = '['.$v.']';         
    }     
    return implode(' ', $td);    
  }

 /**
  * Renders and returns single record
  *  
  * @param string[] $fields Array with table fields
  * @param mixed[] $rowData Record from database
  *
  * @return string HTML code
  */   
  private function renderTableRow($fields, $rowData)
  {    
    $td = [];
    if(!is_array($fields)) 
    {
      return false;
    }
    
    $typesTime = ['created_at', 'updated_at', 'last_connect'];
    $typesSkynetId = ['skynet_id'];
    $typesUrl = ['sender_url', 'receiver_url', 'ping_from', 'url', 'remote_cluster'];
    $typesData = [];
    
    foreach($fields as $k => $v)
    {
      if(array_key_exists($k, $rowData))
      {
        $data = $rowData[$k];
        
        if(in_array($k, $typesTime))
        {
          $data = date(SkynetConfig::get('core_date_format'), $data);
        }
        
        if(in_array($k, $typesUrl) && !empty($data))
        {
          $data = $this->elements->addUrl(SkynetConfig::get('core_connection_protocol').$data, $data);
        }        
        
        if(empty($data)) 
        {
          $data = '-';
        }
        
        $td[] = $data;
      }     
    }  
    
    return implode(' | ', $td).$this->elements->getSeparator();    
  }
}

/**
 * Skynet/Renderer/Cli/SkynetRendererCliDebugRenderer.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer Debug Renderer
  *
  */
class SkynetRendererCliDebugRenderer
{     
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererCliElements();   
  }  
  
 /**
  * Assigns Elements Generator
  *
  * @param SkynetRendererHtmlElements $elements
  */
  public function assignElements($elements)
  {
    $this->elements = $elements;   
  } 
  
 /**
  * Parses assigned custom fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function parseFields($fields)
  {
    $rows = [];
    foreach($fields as $field)
    {
      $val = $field->getValue();       
      if($field->getName() == 'Sleeped')
      {
        if($val == 1)
        {
          $val = 'YES';
        } else {
          $val = 'NO';
        }
      }      
      $rows[] = $this->elements->addBold($field->getName().':').' '.$val;      
    }    
    return implode($this->elements->getNl(), $rows);
  }
  
 /**
  * Parses assigned states data
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function parseStatesFields($fields)
  {
    $rows = [];
    foreach($fields as $field)
    {
      $val = $field->getValue();       
      $rows[] = $this->elements->addBold($field->getName().':').' '.$val;      
    }    
    return implode($this->elements->getNl(), $rows);
  } 

 /**
  * Parses assigned errors data
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */   
  public function parseErrorsFields($fields)
  {
    $rows = [];
    foreach($fields as $field)
    {
      $errorData = $field->getValue();
      $errorMsg = $errorData[0];
      $errorException = $errorData[1];
      
      $ex = '';
      if($errorException !== null && SkynetConfig::get('debug_exceptions'))
      {
        $ex = $this->elements->addSpan($this->elements->getNl().
        $this->elements->addBold('Exception: ').$errorException->getMessage().$this->elements->getNl().
        $this->elements->addBold('File: ').$errorException->getFile().$this->elements->getNl().
        $this->elements->addBold('Line: ').$errorException->getLine().$this->elements->getNl().
        $this->elements->addBold('Trace: ').str_replace('#', $this->elements->getNl().'#', $errorException->getTraceAsString()), 'exception');
      }
      $rows[] = $this->elements->addBold($field->getName().':', 'error').' '.$this->elements->addSpan($errorData[0], 'error').$ex ;      
    }
    if(count($rows) == 0) 
    {
      return '-- no errors --';
    }
    return implode($this->elements->getNl(), $rows);
  }
  
 /**
  * Parses config value
  * 
  * @param mixed $value
  *
  * @return string HTML code
  */    
  public function parseConfigValue($value)
  {
    $parsed = $value;   
    if(is_bool($value))
    {
      if($value == true)
      {
        $parsed = $this->elements->addSpan('YES', 'yes');
      } else {
        $parsed = $this->elements->addSpan('NO', 'no');
      }
    }    
    return $parsed;        
  }
  
 /**
  * Parses assigned config data
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */     
  public function parseConfigFields($fields)
  {
    $rows = [];
    foreach($fields as $field)
    {
      $key = $field->getName();
      if(SkynetConfig::get('translator_config'))
      {
        $keyTitle = SkynetHelper::translateCfgKey($key);
      } else {
        $keyTitle = $key;
      }      
      $rows[] = $this->elements->addBold('['.$keyTitle.'] ').$this->parseConfigValue($field->getValue());
    }
    
    return implode($this->elements->getNl(), $rows);
  } 
}

/**
 * Skynet/Renderer/Cli/SkynetRendererCliElements.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer HTML Elements generator
  *
  */
class SkynetRendererCliElements
{   
  /** @var string New Line Char */
  private $nl;
  
  /** @var string > Char */
  private $gt;
  
  /** @var string < Char */
  private $lt;
  
  /** @var string Separator tag */
  private $separator;
  
  /** @var string CSS Stylesheet */
  private $css;
  
  
 /**
  * Constructor
  */
  public function __construct()
  {
    $this->nl = "\n";
    $this->gt = ">";
    $this->lt = "<";
    $this->separator = $this->nl."------------------------".$this->nl; 
  }   
  
 /**
  * Sets CSS styles
  *
  * @param string $styles CSS styles data
  */ 
  public function setCss($styles)
  {
    $this->css = $styles;    
  }
  
 /**
  * Adds subtitle
  * 
  * @param string $title Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */  
  public function addSubtitle($title, $class = null)
  {  
    return $this->addH3('[### '.$title.' ###]', $class);
  }
  
 /**
  * Returns line separator tag
  *
  * @return string HTML code
  */  
  public function addSeparator()
  {
    return $this->separator;
  } 
  
  /**
  * Adds bold
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */    
  public function addBold($html, $class = null)
  {
    return strip_tags($html);
  }
 
 /**
  * Adds span
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addSpan($html, $class = null)
  {   
    return strip_tags($html);
  } 
 
 /**
  * Adds Heading1
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addH1($html, $class = null)
  {   
    return strip_tags($html).$this->nl.$this->nl;
  }
  
 /**
  * Adds Heading2
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addH2($html, $class = null)
  {
    return strip_tags($html).$this->nl.$this->nl;
  }
  
 /**
  * Adds Heading3
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addH3($html, $class = null)
  {
    return strip_tags($html).$this->nl.$this->nl;
  }
  
 /**
  * Adds URL
  * 
  * @param string $link URL
  * @param string $name Name of link
  * @param bool $target True if _blank
  *
  * @return string HTML code
  */   
  public function addUrl($link, $name = null, $target = true)
  {
    return $link;    
  }

 /**
  * Adds any HTML
  * 
  * @param string $html HTML code
  *
  * @return string HTML code
  */    
  public function addHtml($html)
  {
    return $html;
  }

 
 /**
  * Adds section container
  * 
  * @param string $id Identifier
  *
  * @return string HTML code
  */    
  public function addSectionId($id)
  {
    return $this->separator;
  }
  
 /**
  * Adds section container
  * 
  * @param string $class Class name
  *
  * @return string HTML code
  */
  public function addSectionClass($class)
  {
    return $this->nl.$this->separator.$this->nl;
  }
  
 /**
  * Adds section closing tag
  * 
  * @param string $id Identifier
  *
  * @return string HTML code
  */
  public function addSectionEnd()
  {
    return $this->nl.$this->nl;
  }
  
 /**
  * Adds clearing floats
  * 
  * @param string $title Text to decorate
  *
  * @return string HTML code
  */   
  public function addClr()
  {
    return $this->nl;
  }
 
 /**
  * Adds HTML head tags
  *
  * @return string HTML code
  */ 
  public function addHeader()
  {   
    $line = '++++++++++++++++++++++++++++++++++++++++++++++++';
    return $this->nl.$line.$this->nl." SKYNET ".SkynetVersion::VERSION." (CLI MODE)".$this->nl.$line;
  } 
      
 /**
  * Adds HTML body ending tags
  *
  * @return string HTML code
  */
  public function addFooter()
  {
    $html = $this->nl;
    return $html;
  }
  
 /**
  * Returns new line
  *
  * @return string HTML 
  */
  public function getNl()
  {
    return $this->nl;
  }
  
 /**
  * Returns > arrow
  *
  * @return string HTML 
  */
  public function getGt()
  {
    return $this->gt;
  }
  
 /**
  * Returns < arrow
  *
  * @return string HTML 
  */
  public function getLt()
  {
    return $this->lt;
  }
  
 /**
  * Returns separator
  *
  * @return string HTML 
  */
  public function getSeparator()
  {
    return $this->separator;
  }
}

/**
 * Skynet/Renderer/Html/SkynetRendererHtml.php
 *
 * @package Skynet
 * @version 1.1.2
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Html Output Renderer 
  */
class SkynetRendererHtml extends SkynetRendererAbstract implements SkynetRendererInterface
{
  use SkynetErrorsTrait, SkynetStatesTrait;   
  

  /** @var string[] HTML elements of output */
  private $output = [];     
 
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetRendererHtmlDatabaseRenderer Database Renderer */
  private $databaseRenderer;
  
  /** @var SkynetRendererHtmlConnectionsRenderer Connections Renderer */
  private $connectionsRenderer;   
  
  /** @var SkynetRendererHtmlHeaderRenderer Header Renderer */
  private $headerRenderer;
  
  /** @var SkynetRendererHtmlStatusRenderer Status Renderer */
  private $statusRenderer;
  
  /** @var SkynetDebug Debugger */
  private $debugger;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();       
     
    $this->elements = new SkynetRendererHtmlElements();       
    $this->databaseRenderer = new  SkynetRendererHtmlDatabaseRenderer();
    $this->connectionsRenderer = new  SkynetRendererHtmlConnectionsRenderer();   
    $this->headerRenderer = new  SkynetRendererHtmlHeaderRenderer();    
    $this->statusRenderer = new  SkynetRendererHtmlStatusRenderer(); 
    $this->debugger = new SkynetDebug();
  }

  
  public function renderAjaxOutput()
  {
    $output = [];   
    $output['connectionMode'] = $this->connectionMode;  
    $output['addresses'] = $this->statusRenderer->renderClusters(true);  
    $connData = $this->connectionsRenderer->render(true);
    if(empty($connData))
    {
      $connData = 'Connections data is empty.';
    }
    $output['connectionData'] = $connData;  
    $output['gotoConnection'] = $this->connectionsRenderer->renderGoToConnection($this->connectionsData);
    
    $output['tabStates'] = $this->statusRenderer->renderStates(true);
    $output['tabErrors'] = $this->statusRenderer->renderErrors(true);
    $output['tabConfig'] = $this->statusRenderer->renderConfig(true);
    $output['tabDebug'] = $this->statusRenderer->renderDebug(true);
    $output['tabListeners'] = $this->statusRenderer->renderListeners(true);
    $output['tabConsole'] = $this->statusRenderer->renderConsoleDebug(true);
    
    $output['numStates'] = count($this->statesFields);
    $output['numErrors'] = count($this->errorsFields);
    $output['numConfig'] = count($this->configFields);
    $output['numDebug'] = $this->debugger->countDebug();
    $output['numConsole'] = count($this->consoleOutput);
    $output['numListeners'] = $this->statusRenderer->countListeners();
    
    $output['numConnections'] = $this->connectionsCounter;
    
    $output['sumBroadcasted'] = $this->fields['Broadcasting Clusters']->getValue();
    $output['sumClusters'] = $this->fields['Clusters in DB']->getValue();
    $output['sumAttempts'] = $this->fields['Connection attempts']->getValue();
    $output['sumSuccess'] = $this->fields['Succesful connections']->getValue();
    
    $output['sumClusterIP'] = $this->fields['Cluster IP']->getValue();
    $output['sumYourIP'] = $this->fields['Your IP']->getValue();
    $output['sumEncryption'] = $this->fields['Encryption']->getValue();
    $output['sumConnections'] = $this->fields['Connections']->getValue();
    
    $output['sumChain'] = $this->fields['Chain']->getValue();
    $output['sumSleeped'] = $this->fields['Sleeped']->getValue();
    $this->debugger->resetDebug();
    
    return json_encode($output);
  }
  
 /**
  * Renders and returns HTML output
  *
  * @return string HTML code
  */
  public function render()
  {  
    $connected = 0;
    if($this->fields['Succesful connections']->getValue() > 0)
    {
      $connected = 1;
    }
    
    $this->headerRenderer->setConnectionsCounter($this->connectionsCounter);
    $this->headerRenderer->setFields($this->fields);
    $this->headerRenderer->addConnectionData($this->connectionsData);
    $this->headerRenderer->setMode($this->mode);

    $this->statusRenderer->setConnectionMode($this->connectionMode);
    $this->statusRenderer->setClustersData($this->clustersData);
    $this->statusRenderer->setErrorsFields($this->errorsFields);
    $this->statusRenderer->setConfigFields($this->configFields);
    $this->statusRenderer->setStatesFields($this->statesFields);
    $this->statusRenderer->setConsoleOutput($this->consoleOutput);
    $this->statusRenderer->setMonits($this->monits);
    
    $this->connectionsRenderer->setConnectionsData($this->connectionsData);
    
    if($this->inAjax)
    {
      return $this->renderAjaxOutput();
    }
    
    $this->output[] = $this->elements->addHeader();
    
    /* Start wrapper div */
    $this->output[] = $this->elements->addSectionId('wrapper');    

      /* Render header */    
      $this->output[] = $this->headerRenderer->render();    
     
      switch($this->mode)
      {
        case 'connections':
           /* --- Center Main --- */
           $this->output[] = $this->elements->addSectionClass('main');   
           $this->output[] = $this->statusRenderer->render();
           $this->output[] = $this->connectionsRenderer->render();        
           $this->output[] = $this->elements->addClr();  
           $this->output[] = $this->elements->addSectionEnd();         
    
        break; 

        case 'database':
            
           $records = $this->databaseRenderer->renderDatabaseView();
           $sorter = $this->databaseRenderer->renderDatabaseSwitch();
           
           /* --- Center Main --- */
           $this->output[] = $this->elements->addSectionId('dbSwitch'); 
           $this->output[] = $sorter;
           $this->output[] = $this->elements->addSectionEnd();
           
           $this->output[] = $this->elements->addSectionId('dbRecords'); 
           $this->output[] = $records;
           $this->output[] = $this->elements->addSectionEnd();
        break;
      }   
      /* Center Main : END */   

      /* !End of wrapper */
    $this->output[] = $this->elements->addSectionEnd();
    $this->output[] = $this->elements->addFooter($connected);
    
    $this->debugger->resetDebug();
    return implode('', $this->output);
  } 
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlClustersRenderer.php
 *
 * @package Skynet
 * @version 1.1.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

 /**
  * Skynet Renderer Clusters list Renderer
  *
  */
class SkynetRendererHtmlClustersRenderer extends SkynetRendererAbstract
{     
  /** @var string[] HTML elements of output */
  private $output = [];    
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();  
  }  
  
 /**
  * Renders clusters
  *
  * @return string HTML code
  */ 
  public function render()
  {
    $c = count($this->clustersData);
    $output = [];
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Your Skynet clusters ('.$c.')'));
    if($c > 0)
    {
      $output[] = $this->elements->addHeaderRow4('Status', 'Cluster address', 'Ping', 'Connect');
      foreach($this->clustersData as $cluster)
      {
         $class = '';
         $result = $cluster->getHeader()->getResult();
                 
         switch($result)
         {
           case -1:
            $class = 'statusError';
           break;
           
           case 0:
            $class = 'statusIdle';
           break;
           
           case 1:
            $class = 'statusConnected';
           break;          
         }
         
         $id = $cluster->getHeader()->getConnId();         
             
         $status = '<span class="statusId'.$id.' statusIcon '.$class.'">( )</span>';
         $url = $this->elements->addUrl(SkynetConfig::get('core_connection_protocol').$cluster->getHeader()->getUrl(), $cluster->getHeader()->getUrl());
         $output[] = $this->elements->addClusterRow($status, $url, $cluster->getHeader()->getPing().'ms', '<a href="javascript:skynetControlPanel.insertConnect(\''.SkynetConfig::get('core_connection_protocol').$cluster->getHeader()->getUrl().'\');" class="btn">CONNECT</a>');
      }      
    } else {
      
      $info = 'No clusters in database.';
      $info.= $this->elements->getNl();
      $info.= 'Add new cluster with:';
      $info.= $this->elements->getNl();
      $info.= $this->elements->addBold('@add "cluster address"').' or '.$this->elements->addBold('@connect "cluster address"').' command';
      $output[] = $this->elements->addRow($info);
    }
   
    return implode($output);    
  } 
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlConnectionsRenderer.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer HTML Connections Renderer
  */
class SkynetRendererHtmlConnectionsRenderer extends SkynetRendererAbstract
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetParams[] Params */
  private $params;
  
  /** @var SkynetVerifier SkynetVerifier instance */
  private $verifier;  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();
    $this->params = new SkynetParams;
    $this->verifier = new SkynetVerifier();
  }   
  
 /**
  * Assigns Elements Generator
  *
  * @param SkynetRendererHtmlElements $elements
  */
  public function assignElements($elements)
  {
    $this->elements = $elements;   
  } 

  
  private function renderOptions()
  {
    $options = [];
    $paramsOptions = [];
    $paramsEchoOptions = [];
    
    if(!isset($_SESSION))
    {
      session_start();
    }
    $debugInternal = SkynetConfig::get('debug_internal');
    $debugEcho = SkynetConfig::get('debug_echo');
    
    if(isset($_SESSION['_skynetOptions']['viewInternal']))
    {
      $debugInternal = $_SESSION['_skynetOptions']['viewInternal'];
    }
    
    if(isset($_SESSION['_skynetOptions']['viewEcho']))
    {
      $debugEcho = $_SESSION['_skynetOptions']['viewEcho'];
    }    
    
    if($debugInternal)
    {
      $paramsOptions[] = '<option value="1" selected>YES</option>';
      $paramsOptions[] = '<option value="0">NO</option>';
    } else {
      $paramsOptions[] = '<option value="1">YES</option>';
      $paramsOptions[] = '<option value="0" selected>NO</option>';
    }
    
    if($debugEcho)
    {
      $paramsEchoOptions[] = '<option value="1" selected>YES</option>';
      $paramsEchoOptions[] = '<option value="0">NO</option>';
    } else {
      $paramsEchoOptions[] = '<option value="1">YES</option>';
      $paramsEchoOptions[] = '<option value="0" selected>NO</option>';
    }
    
    $options[] = '<form method="GET" action="" class="formConnectionDataOptions">';
    $options[] = 'Auto-reconnect interval: <input value="0" type="text" id="connIntervalValue" name="connectionInterval"> seconds <input type="button" onclick="skynetControlPanel.setConnectInterval(\''.basename($_SERVER['PHP_SELF']).'\')" value="OK"> (<span id="connIntervalStatus">disabled</span>)<br>';    
    
    $options[] = 'Display internal params: <select id="_skynetViewInternalParamsOption" onchange="skynetControlPanel.switchViewInternalParams(\''.basename($_SERVER['PHP_SELF']).'\');" name="_skynetViewInternalParamsOption">'.implode('', $paramsOptions).'</select> ';
    $options[] = 'Display @echo: <select id="_skynetViewEchoParamsOption" onchange="skynetControlPanel.switchViewEchoParams(\''.basename($_SERVER['PHP_SELF']).'\');" name="_skynetViewEchoParamsOption">'.implode('', $paramsEchoOptions).'</select>';
    
    $options[] = '</form>';  
    
    return implode('', $options);
  }
  
  
  
 /**
  * Renders go to connection form
  *
  * @param mixed[] $connectionsDataArray ConnectionsData
  *
  * @return string HTML code
  */   
  public function renderGoToConnection($connectionsDataArray)
  {   
    $options = [];
    $options[] = '<option value="0"> --- choose from list --- </option>';
    $conns = count($connectionsDataArray);
    if($conns == 0) 
    {
      return '';
    }
    
    for($i = 1; $i <= $conns; $i++)
    {
      $url = '';
      $j = $i - 1;
      if(isset($connectionsDataArray[$j]['CLUSTER URL'])) 
      {
        $url = $connectionsDataArray[$j]['CLUSTER URL'];
      }
      $url = str_replace(array('http://', 'https://'), '', $url);
      if(strlen($url) > 20)
      {
        $url = substr($url, 0, 20).'...'.basename($url);
      }      
      
      $options[] = '<option value="'.$i.'">#'.$i.' ('.$url.')</option>';     
    }   
      
    return '<form method="GET" action="" class="formConnections">
    Go to connection: <select id="connectList" onchange="skynetControlPanel.gotoConnection();" name="_go">'.implode('', $options).'</select></form>';      
  }  
 
 /**
  * Parses fields with time
  * 
  * @param string $key
  * @param string $value
  *
  * @return string Parsed time
  */  
  private function parseParamTime($key, $value)
  {
    if(!SkynetConfig::get('translator_params'))
    {
      return $value;
    }
    
    $timeParams = ['_skynet_sender_time', '_skynet_cluster_time', '_skynet_chain_updated_at', '@_skynet_sender_time', '@_skynet_cluster_time', '@_skynet_chain_updated_at'];
    if(in_array($key, $timeParams) && !empty($value) && is_numeric($value))
    {
      return date(SkynetConfig::get('core_date_format'), $value);      
    } else {
      return $value;
    }
  }
 
 /**
  * Parses array 
  * 
  * @param mixed $fields Array with fields
  *
  * @return string HTML code
  */    
  public function parseParamsArray($fields)
  {
    $rows = [];  
    if(!isset($_SESSION))
    {
      session_start();
    }
    $debugInternal = SkynetConfig::get('debug_internal');
    $debugEcho = SkynetConfig::get('debug_echo');
    
    if(isset($_SESSION['_skynetOptions']['viewInternal']))
    {
      $debugInternal = $_SESSION['_skynetOptions']['viewInternal'];
    }
    
    if(isset($_SESSION['_skynetOptions']['viewEcho']))
    {
      $debugEcho = $_SESSION['_skynetOptions']['viewEcho'];
    }
    
    foreach($fields as $key => $field)
    {
      $render = true;
      
      if(SkynetConfig::get('translator_params'))
      {
        $paramName = $this->params->translateInternalParam(htmlspecialchars($field->getName(), ENT_QUOTES, "UTF-8"));
      } else {
        $paramName = $field->getName();
      }
      
      if($this->verifier->isInternalParameter($field->getName()))
      {
        $render = false;
        if($debugInternal)
        {
          $render = true;
        }
      }
      
      if($this->verifier->isInternalEchoParameter($field->getName()))
      {
        if($debugInternal)
        {
          $render = false;
          if($debugEcho)
          {
            $render = true;
          }
        }
      }
      
      if($render)
      {
        $value = $this->parseParamTime($field->getName(), $field->getValue());        
        
        if($this->params->isPacked($value))
        {
          $unpacked = $this->params->unpackParams($value);
          if(is_array($unpacked))
          {
            //var_dump($unpacked);
            
            $extracted = [];
            foreach($unpacked as $k => $v)
            {
              $extracted[] = '<b>'.$k.':</b> '.str_replace(array("<", ">"), array("&lt;", "&gt;"), $v);            
            }
            $parsedValue = implode('<br>', $extracted);
          } else {
            $parsedValue = str_replace(array("<", ">"), array("&lt;", "&gt;"), $unpacked);
          }
          
        } else {
          
          $parsedValue = str_replace(array("<", ">"), array("&lt;", "&gt;"), $value);
        }       
        $rows[] = $this->elements->addValRow('<b>'.$paramName.'</b>', $parsedValue);    
      }      
    }
    
    if(count($rows) > 0)
    {      
      return implode('', $rows);       
    } else {
      return $this->elements->addRow(' -- no data -- ');
    }  
  }
  
 /**
  * Parses connection array data fields
  *
  * @param string[] $fields Array of fields arrays
  * @param string $clusterUrl
  *
  * @return string HTML code
  */   
  public function parseConnectionFields($fields, $clusterUrl, $id)
  {
    $names = [
      'request_raw' => ['Request Fields {sended} (plain) '.$this->elements->getGt().$this->elements->getGt().' to: '.$this->elements->addSpan($clusterUrl, 't'), ''],
      'request_encypted' => ['Request Fields {sended} (encrypted) '.$this->elements->getGt().$this->elements->getGt().' to: '.$this->elements->addSpan($clusterUrl, 't'), ''],
      'response_raw' => ['Response Fields {received} (raw) '.$this->elements->getLt().$this->elements->getLt().' from: '.$this->elements->addSpan($clusterUrl, 't'), ''],
      'response_decrypted' => ['Response Fields {received} (decrypted) '.$this->elements->getLt().$this->elements->getLt().' from: '.$this->elements->addSpan($clusterUrl, 't'), '']
      ];      
    
    $rows = [];   
    
    $rows[] = $this->elements->addSectionClass('tabConnPlain'.$id);
    $rows[] = $this->elements->beginTable();
    $rows[] = $this->elements->addHeaderRow($this->elements->addH3('[ '.$names['request_raw'][0].' ]'));
    $rows[] = $this->parseParamsArray($fields['request_raw']);      
    $rows[] = $this->elements->endTable();      
    
    $rows[] = $this->elements->beginTable();
    $rows[] = $this->elements->addHeaderRow($this->elements->addH3('[ '.$names['response_decrypted'][0].' ]'));
    $rows[] = $this->parseParamsArray($fields['response_decrypted']);      
    $rows[] = $this->elements->endTable();  
    $rows[] = $this->elements->addSectionEnd();
    
    $rows[] = $this->elements->addSectionClass('hide tabConnEncrypted'.$id);
    $rows[] = $this->elements->beginTable();
    $rows[] = $this->elements->addHeaderRow($this->elements->addH3('[ '.$names['request_encypted'][0].' ]'));
    $rows[] = $this->parseParamsArray($fields['request_encypted']);      
    $rows[] = $this->elements->endTable();      
    
    $rows[] = $this->elements->beginTable();
    $rows[] = $this->elements->addHeaderRow($this->elements->addH3('[ '.$names['response_raw'][0].' ]'));
    $rows[] = $this->parseParamsArray($fields['response_raw']);      
    $rows[] = $this->elements->endTable();  
    $rows[] = $this->elements->addSectionEnd();
    
    return implode('', $rows);    
  } 
 
 /**
  * Renders tabs
  *
  * @return string HTML code
  */  
  public function renderConnectionTabs($id = 0)
  {
    $output = [];
    $output[] = '<div class="tabsHeader">';
    $output[] = '<a class="tabConnPlainBtn'.$id.' active" href="javascript:skynetControlPanel.switchConnTab(\'tabConnPlain\', '.$id.');">Plain data</a> <a class="tabConnEncryptedBtn'.$id.' errors" href="javascript:skynetControlPanel.switchConnTab(\'tabConnEncrypted\', '.$id.');">Encrypted data</a> <a class="tabConnRawBtn'.$id.'" href="javascript:skynetControlPanel.switchConnTab(\'tabConnRaw\', '.$id.');">Raw data</a>';
    $output[] = '</div>';    
    return implode($output);
  }
  
 /**
  * Parses connection params array
  *
  * @param string[] $connData Array of connection data params
  *
  * @return string HTML code
  */ 
  public function parseConnection($connData)
  {
    if(!isset($connData['id']))
    {
      return 'Connection data is NULL';
    }
    $rows = [];
    $rows[] = 
      $this->elements->addHtml('<a name="_connection'.$connData['id'].'"></a>').
      $this->elements->addH2('@'.$connData['id'].' Connection {').
      $this->elements->addH3('@ClusterAddress: '.$this->elements->addUrl($connData['CLUSTER URL']));    
    
    $rows[] = $this->renderConnectionTabs($connData['id']);
      
    $paramsFields = ['SENDED RAW DATA'];  
    $rawDataFields = ['RECEIVED RAW DATA'];
    
    $rows[] = $this->elements->beginTable();
    $parsedValue = $this->elements->addUrl($connData['CLUSTER URL']);
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('CLUSTER URL').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $parsedValue);    
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('Connection number').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $connData['id']);    
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('Ping').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $connData['Ping']);   
    $rows[] = $this->elements->endTable();      
    
    $rows[] = $this->parseConnectionFields($connData['FIELDS'], $connData['CLUSTER URL'], $connData['id']);    
    
    $rows[] = $this->elements->addSectionClass('hide tabConnRaw'.$connData['id']);
    $rows[] = $this->elements->beginTable();
    $parsedValue = $this->parseDebugParams($connData['SENDED RAW DATA']);
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('SENDED RAW DATA').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $parsedValue);  
    
    $parsedValue = $this->parseResponseRawData($connData['RECEIVED RAW DATA']);
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('RECEIVED RAW DATA').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $parsedValue);    
   
    $rows[] = $this->elements->endTable();  
    $rows[] = $this->elements->addSectionEnd();   
    
    
    $rows[] = $this->elements->addH2('}');
    return implode('', $rows);    
  }

 /**
  * Parses connections data array
  *
  * @param mixed[] $connectionsDataArray Connections data array
  *
  * @return string HTML code
  */  
  public function renderConnections($connectionsDataArray)
  {
    $parsed = [];
    foreach($connectionsDataArray as $connData)
    {
      $parsed[] = $this->parseConnection($connData);
    }        
    return implode($this->elements->getSeparator(), $parsed);
  }
  
 /**
  * Parses raw JSON response, bolds keys
  *
  * @param string $data Raw JSON response
  *
  * @return string Parsed JSON response
  */
  public function parseResponseRawData($data)
  {
    if(!empty($data))
    {
      return str_replace(array('{"', '":', '","'), array('{<b>"', '":</b>', '", <b>"'), $data);
    } else {
      return ' -- no data -- ';
    }
  }

 /**
  * Parses params array
  *
  * @param mixed[] $params Array of params
  *
  * @return string Parsed string
  */
  public function parseDebugParams($params)
  {
    if(!is_array($params) || count($params) == 0) 
    {
      return null;
    }
    $fields = [];
    foreach($params as $k => $v)
    {
      $fields[] = '<b>'.$k.'=</b>'.$v;
    }
    return implode(';'.$this->elements->getNl(), $fields);
  }
  
 /**
  * Renders and returns connections view
  *
  * @return string HTML code
  */    
  public function render($ajax = false)
  {
    if($ajax)
    {
      return $this->renderConnections($this->connectionsData);
    }
    
    $output = [];   
    /* Center Main : Right Column: */
    $output[] = $this->elements->addSectionClass('columnConnections'); 
    
    $output[] = $this->elements->addSectionClass('innerConnectionsOptions'); 
    $output[] = $this->elements->addSectionClass('reconnectArea'); 
    $output[] = $this->renderOptions();
    $output[] = $this->elements->addSectionEnd();
    $output[] = $this->elements->addSectionEnd();
    
    $output[] = $this->elements->addSectionClass('innerConnectionsData'); 
    $output[] = $this->renderConnections($this->connectionsData);
    $output[] = $this->elements->addSectionEnd();  
    
    $output[] = $this->elements->addSectionEnd();  
    return implode('', $output);      
  } 
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlConsoleRenderer.php
 *
 * @package Skynet
 * @version 1.1.2
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer HTML Console Renderer
  */
class SkynetRendererHtmlConsoleRenderer
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetConsole Console */
  private $console;
  
  /** @var string[] output from listeners */
  private $listenersOutput = [];
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();
    $this->console = new SkynetConsole();
  }   
  
 /**
  * Assigns Elements Generator
  *
  * @param SkynetRendererHtmlElements $elements
  */
  public function assignElements($elements)
  {
    $this->elements = $elements;   
  }   

 /**
  * Assigns output from listeners
  *
  * @param string[] $output
  */
  public function setListenersOutput($output)
  {
    $this->listenersOutput = $output;   
  }        

 /**
  * Parses params into select input
  *
  * @param mixed[] $params Array of params
  *
  * @return string Parsed params
  */      
  private function parseCommandParams($params)
  {
    $paramsParsed = [];
    if(is_array($params) && count($params) > 0)
    {
      foreach($params as $param)
      {
        $paramsParsed[] = $this->elements->getLt().$param.$this->elements->getGt();        
      }
      return implode(' or ', $paramsParsed);
    }
  }  
    
 /**
  * Renders console helpers
  *
  * @return string HTML code
  */   
  private function renderConsoleHelpers()
  {    
    $options = [];
    $options[] = '<option value="0"> -- commands -- </option>';  
    
    $commands = $this->console->getCommands();          
    
    if(count($commands) > 0)
    {
      foreach($commands as $code => $command)
      {
        $descStr = '';
        if(!empty($command->getHelperDescription()))
        {
          $descStr = ' | '.$command->getHelperDescription();
        }
         $params = $this->parseCommandParams($command->getParams()).$descStr;         
         $options[] = '<option value="'.$code.'">'.$code.' '.$params.'</option>';        
      }      
    }    
      
    return "<select id='cmdsList' onchange='skynetControlPanel.insertCommand();' name='_cmd1'>".implode('', $options)."</select>";      
  }  
 
 /**
  * Parses input and shows debug
  *
  * @param string $input Console raw Input string
  *
  * @return string HTML code
  */   
  private function parseConsoleInputDebug($input)
  {
    $this->console->parseConsoleInput($input);
    $errors = $this->console->getParserErrors();
    $states = $this->console->getParserStates();
    $outputs = [];
    $output = '';
     
    $parsedErrors = '';
    $parsedStates = '';
    $i = 1;
    if(is_array($errors) && count($errors) > 0)
    {
      $parsedErrors.= $this->elements->addHeaderRow($this->elements->addSubtitle('Parser errors'));
      foreach($errors as $error)
      {
        $parsedErrors.= $this->elements->addValRow('InputParserError #'.$i, $this->elements->addSpan($error, 'error'));   
        $i++;
      }      
    }
    
    if(SkynetConfig::get('console_debug'))
    {
      $i = 1;     
      
      if(is_array($states) && count($states) > 0)
      {
        $parsedErrors.= $this->elements->addHeaderRow($this->elements->addSubtitle('Parser states'));
        foreach($states as $state)
        {
          $parsedStates.= $this->elements->addValRow('InputParserState #'.$i, $this->elements->addSpan($state, 'yes')); 
          $i++;
        }      
      }
    }
   
    /* Add output from listeners */
    foreach($this->listenersOutput as $listenerOutput)
    {
      if(is_string($listenerOutput) && !empty($listenerOutput))
      {
        $outputs[] = $listenerOutput;
      } elseif(is_array($listenerOutput) && count($listenerOutput) > 0)
      {
        foreach($listenerOutput as $addressListenerOutput)
        {
          $outputs[] = $addressListenerOutput;
        }
      }
    }
    
    $input = str_replace("\r\n", "\n", $input);
    $input = htmlentities($input);
    $input = str_replace("\n", $this->elements->getNl(), $input);
    
    $input = $this->elements->addHeaderRow($this->elements->addSubtitle('Input query')).$this->elements->addRow($input);
    
    if(count($outputs) > 0)
    {
      $output = implode("\n", $outputs);
      $output = str_replace("\r\n", "\n", $output);
      $output = htmlentities($output);
      $output = $this->elements->addSectionClass('monits').str_replace("\n", $this->elements->getNl(), $output).$this->elements->addSectionEnd();
      $output = $this->elements->addHeaderRow($this->elements->addSubtitle('Output')).$this->elements->addRow($output);
    }
    
    return $output.$parsedErrors.$parsedStates.$input;
  }
  
 /**
  * Renders and returns console form
  *
  * @return string HTML code
  */   
  public function renderConsole()
  {
    $ajaxSupport = true;
    
    $onsubmit = '';
    $submit = '<input type="submit" title="Send request commands from console" value="Send request" class="sendBtn" />';
    if($ajaxSupport)
    {     
      $submit = '<input type="button" onclick="skynetControlPanel.load(1, true, \''.basename($_SERVER['PHP_SELF']).'\');" title="Send request commands from console" value="Send request" class="sendBtn" />';
    }
    
    return '<form method="post" action="#console'.md5(time()).'" name="_skynetCmdConsole">
    '.$submit.$this->renderConsoleHelpers().' See '.$this->elements->addUrl(SkynetVersion::WEBSITE, 'documentation').' for information about console usage 
    <textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" autofocus name="_skynetCmdConsoleInput" placeholder="&gt;&gt; Console" id="_skynetCmdConsoleInput"></textarea>
    <input type="hidden" name="_skynetCmdCommandSend" value="1" />
    </form>';
  }
  
 /**
  * Renders sended input
  *
  * @return string HTML code
  */    
  public function renderConsoleInput()
  {
    if(isset($_REQUEST['_skynetCmdConsoleInput'])) 
    {
      return $this->parseConsoleInputDebug($_REQUEST['_skynetCmdConsoleInput']); 
    } else {
      return $this->elements->addHeaderRow($this->elements->addSubtitle('Console')).$this->elements->addRow('-- no input --');
    }    
  }
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlDatabaseRenderer.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer HTML Database Renderer
  *
  */
class SkynetRendererHtmlDatabaseRenderer
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var string Current table in Database view */
  protected $selectedTable;
  
  /** @var string[] Array with table names */
  protected $dbTables;
  
  /** @var SkynetDatabase DB Instance */
  protected $database;
  
  /** @var SkynetDatabaseSchema DB Schema */
  protected $databaseSchema;
  
  /** @var PDO Connection instance */
  protected $db;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var string Sort by */
  protected $tableSortBy;
  
  /** @var string Sort order */
  protected $tableSortOrder;
  
  /** @var int EditID */
  protected $tableEditId = 0;
  
  /** @var int Current pagination */
  protected $tablePage;
  
  /** @var int Limit records per page */
  protected $tablePerPageLimit;
  
  /** @var SkynetClustersRegistry Clusters */
  protected $clustersRegistry;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();
    $this->database = SkynetDatabase::getInstance();  
    $this->databaseSchema = new SkynetDatabaseSchema;    
    $this->dbTables = $this->databaseSchema->getDbTables();   
    $this->tablesFields = $this->databaseSchema->getTablesFields();
    $this->tablePerPageLimit = 20;
    $this->clustersRegistry = new SkynetClustersRegistry();
    
    $this->db = $this->database->connect();
    
    /* Switch database table */
    if(isset($_REQUEST['_skynetDatabase']) && !empty($_REQUEST['_skynetDatabase']))
    {
      if(array_key_exists($_REQUEST['_skynetDatabase'], $this->dbTables))
      {
        $this->selectedTable = $_REQUEST['_skynetDatabase'];
      }
    }
    
    if($this->selectedTable === null)
    {
      $this->selectedTable = 'skynet_clusters';
    }
    
    /* Set default */
    if(isset($_REQUEST['_skynetPage']) && !empty($_REQUEST['_skynetPage']))
    {
      $this->tablePage = (int)$_REQUEST['_skynetPage'];
    }
    
    if(isset($_REQUEST['_skynetSortBy']) && !empty($_REQUEST['_skynetSortBy']))
    {
      $this->tableSortBy = $_REQUEST['_skynetSortBy'];
    }
    
    if(isset($_REQUEST['_skynetSortOrder']) && !empty($_REQUEST['_skynetSortOrder']))
    {
      $this->tableSortOrder = $_REQUEST['_skynetSortOrder'];
    }
    
    if(isset($_REQUEST['_skynetEditId']) && !empty($_REQUEST['_skynetEditId']) && is_numeric($_REQUEST['_skynetEditId']))
    {
      $this->tableEditId = intval($_REQUEST['_skynetEditId']);
    }    
    
    /* Set defaults */   
    if($this->tableSortBy === null)
    {
      $this->tableSortBy = 'id';
    }
    if($this->tableSortOrder === null)
    {
      $this->tableSortOrder = 'DESC';
    }
    if($this->tablePage === null)
    {
      $this->tablePage = 1;
    }
  }   
  
 /**
  * Assigns Elements Generator
  *
  * @param SkynetRendererHtmlElements $elements
  */
  public function assignElements($elements)
  {
    $this->elements = $elements;   
  }  
  
 /**
  * Delete controller
  *
  * @return string HTML code
  */   
  private function deleteRecord()
  {
    $output = [];
    
    if($this->selectedTable != 'skynet_chain')
    {
      if(isset($_REQUEST['_skynetDeleteRecordId']) && !empty($_REQUEST['_skynetDeleteRecordId']) && is_numeric($_REQUEST['_skynetDeleteRecordId']))
      {
        /* If cluster delete then add cluster to blocked list */
        if($this->selectedTable == 'skynet_clusters')
        {
          $row = $this->database->ops->getTableRow($this->selectedTable, intval($_REQUEST['_skynetDeleteRecordId']));
          $cluster = new SkynetCluster;
          $cluster->setUrl($row['url']);
          $this->clustersRegistry->addBlocked($cluster);          
        }
    
        if($this->database->ops->deleteRecordId($this->selectedTable, intval($_REQUEST['_skynetDeleteRecordId'])))
        {
          $output[] = $this->elements->addMonitOk('Record deleted.');
        } else {
          $output[] = $this->elements->addMonitError('Record delete error.');
        }
      }    

      if(isset($_REQUEST['_skynetDeleteAllRecords']) && $_REQUEST['_skynetDeleteAllRecords'] == 1)
      {
        if($this->database->ops->deleteAllRecords($this->selectedTable))
        {
          $output[] = $this->elements->addMonitOk('All records deleted.');
        } else {
          $output[] = $this->elements->addMonitError('All records delete error.');
        }
      }   
    } 
    
    
    
    
    return implode('', $output);
  }

 /**
  * Inserts record
  *
  * @return string HTML result
  */    
  private function newRecord()
  {
    $output = [];
    
    $data = [];
    $fields = $this->tablesFields[$this->selectedTable];
    
    foreach($fields as $k => $v)
    {
      if($k != 'id')
      {
        $data[$k] = '';
        if(isset($_POST['record_'.$k]))
        {
          $data[$k] = $_POST['record_'.$k];
        }        
      }      
    }     
   
    if($this->database->ops->newRow($this->selectedTable, $data))
    {     
      $output[] = $this->elements->addMonitOk('Record inserted');
    } else {
      $output[] = $this->elements->addMonitError('Record insert error.');
    } 
    return implode('', $output);
  }
  
 /**
  * Updates record
  *
  * @return string HTML result
  */    
  private function updateRecord()
  {
    $output = [];
    
    $data = [];
    $fields = $this->tablesFields[$this->selectedTable];
    
    foreach($fields as $k => $v)
    {
      if($k != 'id')
      {
        $data[$k] = '';
        if(isset($_POST['record_'.$k]))
        {
          $data[$k] = $_POST['record_'.$k];
        }        
      }      
    }     
   
    if($this->database->ops->updateRow($this->selectedTable, $this->tableEditId, $data))
    {     
      $output[] = $this->elements->addMonitOk('Record updated');
    } else {
      $output[] = $this->elements->addMonitError('Record update error.');
    } 
    return implode('', $output);
  }  
    
 /**
  * Renders and returns records
  *
  * @return string HTML code
  */  
  public function renderDatabaseView()
  {
    $output = [];
    
    $recordRows = [];    
    $start = 0;
    if($this->tablePage > 1)
    {
      $min = (int)$this->tablePage - 1;
      $start = $min * $this->tablePerPageLimit;
    }
    
    $output[] = $this->deleteRecord();
    $rows = $this->database->ops->getTableRows($this->selectedTable, $start, $this->tablePerPageLimit, $this->tableSortBy, $this->tableSortOrder);
    
    if(isset($_REQUEST['_skynetSaveRecord']))
    {
      $output[] = $this->updateRecord();
    }   

    if(isset($_REQUEST['_skynetInsertRecord']))
    {
      $output[] = $this->newRecord();
    }     
    
    if(!empty($this->tableEditId))
    {
      $output[] = $this->renderEditForm();
    } elseif(isset($_REQUEST['_skynetNewRecord']))
    {
      $output[] = $this->renderEditForm(true);
    }
    
    if($rows !== false && count($rows) > 0)
    {
      $fields = $this->tablesFields[$this->selectedTable];   
      $header = $this->renderTableHeader($fields);
      $recordRows[] = $header;
      $i = 0;
      foreach($rows as $row)
      {
        $recordRows[] = $this->renderTableRow($fields, $row); 
        $i++;
      }        
      $recordRows[] = $header;
      
      $allRecords = $this->database->ops->countTableRows($this->selectedTable);
      
      $output[] = $this->elements->beginTable('dbTable');  
      $dbTitle =  $this->elements->addSectionClass('dbTitle').$this->elements->addSubtitle($this->dbTables[$this->selectedTable]).$this->elements->getNl().$this->selectedTable.' ('.$i.'/'.$allRecords.')'.$this->elements->addSectionEnd();
      $output[] = $this->elements->addHeaderRow($dbTitle.$this->getNewButton(), count($fields) + 1);      
      $output[] = implode('', $recordRows);
      $output[] = $this->elements->endTable();
      
      return implode('', $output);
      
    } else {
      
      $fields = $this->tablesFields[$this->selectedTable];   
      $header = $this->renderTableHeader($fields);      
     
      $output[] = $this->elements->beginTable('dbTable'); 
      $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle($this->selectedTable).$this->getNewButton(), count($fields) + 1);
      $output[] = $header;           
      $output[] = $this->elements->addRow('No records', count($fields) + 1);
      $output[] = $this->elements->endTable();
      
      return implode('', $output);
    }    
  }
  
 /**
  * Renders and returns table form switcher
  *
  * @return string HTML code
  */   
  public function renderDatabaseSwitch()
  {
    $options = [];
    foreach($this->dbTables as $k => $v)
    {
      $numRecords = 0;
      $numRecords = $this->database->ops->countTableRows($k);
      
      if($k == $this->selectedTable)
      {
        $options[] = $this->elements->addOption($k, $v.' ('.$numRecords.')', true);
      } else {
        $options[] = $this->elements->addOption($k, $v.' ('.$numRecords.')');
      }
    }   
      
    return '<form method="GET" action="">
    Select database table: <select name="_skynetDatabase">'.implode('', $options).'</select>
    <input type="submit" value="Show stored data"/>
    <input type="hidden" name="_skynetView" value="database" />
    </form>'.$this->renderTableSorter();      
  }

 /**
  * Renders new record btn
  *
  * @return string HTML code
  */ 
  private function getNewButton()
  {
    $newHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetNewRecord=1&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;    
    return $this->elements->getNl().$this->elements->addUrl($newHref, $this->elements->addBold('[+] New record'), false, 'btnNormal').$this->elements->getNl().$this->elements->getNl();
  }  
  
 /**
  * Renders edit form
  *
  * @return string HTML code
  */   
  public function renderEditForm($new = false)
  {  
    $output = [];
    $deleteHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetDeleteRecordId='.$this->tableEditId.'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $deleteLink = 'javascript:if(confirm(\'Delete record from database?\')) window.location.assign(\''.$deleteHref.'\');';
    $saveBtn = '<input type="submit" value="Save record"/>';    
    $deleteBtn = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete'), false, 'btnDelete');
    $actionsEdit = $saveBtn.' '.$deleteBtn;
    $actionsNew = '<input type="submit" value="Add record"/>';
    
    $formAction = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $output[] = '<form method="POST" action="'.$formAction.'">';
    $output[] = $this->elements->beginTable('dbTable'); 
    
    if($new)
    {
       $title = $this->elements->addSubtitle($this->selectedTable.' | CREATING NEW RECORD');
    } else {
       $title = $this->elements->addSubtitle($this->selectedTable.' | EDITING RECORD ID: '.$this->tableEditId);
    }
   
    $output[] = $this->elements->addHeaderRow($title, 2);
    
    if($new)
    {
      $output[] = $this->elements->addFormActionsRow($actionsNew);  
    } else{
      $output[] = $this->elements->addFormActionsRow($actionsEdit);  
    }      
    
    $fields = $this->tablesFields[$this->selectedTable]; 
    
    foreach($fields as $k => $v)
    {
      if($new)
      {
        if($k != 'id')
        {
          $output[] = $this->elements->addFormRow($this->elements->addSubtitle($v).'<br>('.$k.')', '<textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" name="record_'.$k.'"></textarea>'); 
        } 
        
      } else {
        $row = $this->database->ops->getTableRow($this->selectedTable, $this->tableEditId);
        if($k == 'id')
        {
          $output[] = $this->elements->addFormRow($this->elements->addSubtitle($v).'<br>('.$k.')', '<textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" name="record_'.$k.'" readonly>'.htmlentities($row[$k]).'</textarea>'); 
        } else {
          $output[] = $this->elements->addFormRow($this->elements->addSubtitle($v).'<br>('.$k.')', '<textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" name="record_'.$k.'">'.htmlentities($row[$k]).'</textarea>');    
        }
      }
    }    
    
    if($new)
    {
      $output[] = $this->elements->addFormActionsRow($actionsNew);
      $output[] = $this->elements->addFormActionsRow('<input type="hidden" name="_skynetInsertRecord" value="1">');      
    } else {
      $output[] = $this->elements->addFormActionsRow($actionsEdit);  
      $output[] = $this->elements->addFormActionsRow('<input type="hidden" name="_skynetSaveRecord" value="1">');      
    }
    
    $output[] = $this->elements->endTable();
    $output[] = '</form>';
    
    return implode('', $output); 
  }
  
 /**
  * Renders and returns table form switcher
  *
  * @return string HTML code
  */   
  private function renderTableSorter()
  {
    $optionsSortBy = [];
    $optionsOrderBy = [];
    $optionsPages = [];    
   
    $numRecords = $this->database->ops->countTableRows($this->selectedTable);
    $numPages = (int)ceil($numRecords / $this->tablePerPageLimit);    
    $order = ['ASC' => 'Ascending', 'DESC' => 'Descending'];    
    
    foreach($this->tablesFields[$this->selectedTable] as $k => $v)
    {     
      if($k == $this->tableSortBy)
      {
        $optionsSortBy[] = $this->elements->addOption($k, $v, true);
      } else {
        $optionsSortBy[] = $this->elements->addOption($k, $v);
      }
    }   
    
    foreach($order as $k => $v)
    {     
      if($k == $this->tableSortOrder)
      {
        $optionsOrderBy[] = $this->elements->addOption($k, $v, true);
      } else {
        $optionsOrderBy[] = $this->elements->addOption($k, $v);
      }
    }   
    for($i = 1; $i <= $numPages; $i++)
    {    
      if($i == $this->tablePage)
      {
        $optionsPages[] = $this->elements->addOption($i, $i.' / '.$numPages, true);
      } else {
        $optionsPages[] = $this->elements->addOption($i, $i.' / '.$numPages);
      }
    }      
    
    $deleteHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetDeleteAllRecords=1&_skynetPage=1&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $allDeleteLink = '';
    
    if($this->database->ops->countTableRows($this->selectedTable) > 0 && $this->selectedTable != 'skynet_chain')
    {
      $deleteLink = 'javascript:if(confirm(\'Delete ALL RECORDS from this table?\')) window.location.assign(\''.$deleteHref.'\');';
      $allDeleteLink = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete ALL RECORDS'), false, 'btnDelete');
    }   
    
    $output = [];
    $output[] = '<form method="GET" action="">';
    if($this->database->ops->countTableRows($this->selectedTable) > 0)
    {
      $output[] = 'Page:<select name="_skynetPage">'.implode('', $optionsPages).'</select> ';
    }
    $output[] = 'Sort By: <select name="_skynetSortBy">'.implode('', $optionsSortBy).'</select>  ';
    $output[] = '<select name="_skynetSortOrder">'.implode('', $optionsOrderBy).'</select> ';
    $output[] = '<input type="submit" value="Execute"/> '.$allDeleteLink;
    $output[] = '<input type="hidden" name="_skynetView" value="database"/>';
    $output[] = '<input type="hidden" name="_skynetDatabase" value="'.$this->selectedTable.'"/>';
    $output[] = '</form>';

    return implode('', $output);
  }

 /**
  * Renders and returns table header
  *
  * @param string[] $fields Array with table fields
  *
  * @return string HTML code
  */  
  private function renderTableHeader($fields)
  {
    $td = [];
    foreach($fields as $k => $v)
    {     
      $td[] = '<th>'.$v.'</th>';         
    }
    $td[] = '<th>Save as TXT / Edit / Delete</th>';         
    return '<tr>'.implode('', $td).'</tr>';    
  }

 /**
  * Decorates data
  *  
  * @param string $rowName
  * @param string $rowValue
  *
  * @return string Decorated value
  */  
  private function decorateData($rowName, $rowValue)
  {
    $typesTime = ['created_at', 'updated_at', 'last_connect'];
    $typesSkynetId = ['skynet_id'];
    $typesUrl = ['sender_url', 'receiver_url', 'ping_from', 'url', 'remote_cluster'];
    $typesData = [];
    
    if(in_array($rowName, $typesTime) && is_numeric($rowValue))
    {
      $rowValue = date(SkynetConfig::get('core_date_format'), $rowValue);
    }
    
    if(in_array($rowName, $typesUrl) && !empty($rowValue))
    {     
      $urlName = $rowValue;
      if(SkynetHelper::getMyUrl() == $rowValue)
      {
        $urlName = '<span class="marked"><b>[ME]</b> '.$rowValue.'</span>';
      }
      $rowValue = $this->elements->addUrl(SkynetConfig::get('core_connection_protocol').$rowValue, $urlName);
    }
    
    if(in_array($rowName, $typesSkynetId) && !empty($rowValue))
    {
      $rowValue = $this->elements->addSpan($rowValue, 'marked');
    }
    
    if(empty($rowValue)) 
    {
      $rowValue = '-';
    }
    
    return str_replace("; ", ";<br>", $rowValue);
  }
  
 /**
  * Renders and returns single record
  *  
  * @param string[] $fields Array with table fields
  * @param mixed[] $rowData Record from database
  *
  * @return string HTML code
  */   
  private function renderTableRow($fields, $rowData)
  {    
    $td = [];
    if(!is_array($fields)) 
    {
      return false;
    }
    
    foreach($fields as $k => $v)
    {
      if(array_key_exists($k, $rowData))
      {
        $data = htmlentities($rowData[$k]);       
        
        $data = $this->decorateData($k, $data);
        
        $td[] = '<td>'.$data.'</td>';
      }     
    }
    $deleteStr = '';
    $txtLink = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetGenerateTxtFromId='.$rowData['id'].'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $deleteHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetDeleteRecordId='.$rowData['id'].'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $editLink = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetEditId='.$rowData['id'].'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $deleteLink = 'javascript:if(confirm(\'Delete record from database?\')) window.location.assign(\''.$deleteHref.'\');';
    if($this->selectedTable != 'skynet_chain')
    {
      $deleteStr = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete'), false, 'btnDelete');
    }
    $editStr = $this->elements->addUrl($editLink, $this->elements->addBold('Edit'), false, 'btnNormal'); 
    $td[] = '<td class="tdActions">'.$this->elements->addUrl($txtLink, $this->elements->addBold('Generate TXT'), false, 'btnNormal').' '.$editStr.' '.$deleteStr.'</td>';
    
    return '<tr>'.implode('', $td).'</tr>';    
  }
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlDebugParser.php
 *
 * @package Skynet
 * @version 1.1.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

 /**
  * Skynet Renderer Debug Renderer
  *
  */
class SkynetRendererHtmlDebugParser
{     
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();   
  }  
  
 /**
  * Assigns Elements Generator
  *
  * @param SkynetRendererHtmlElements $elements
  */
  public function assignElements($elements)
  {
    $this->elements = $elements;   
  } 
  
 /**
  * Parses assigned custom fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function parseFields($fields)
  {
    $rows = [];
    foreach($fields as $field)
    {
      $rows[] = $this->elements->addValRow($this->elements->addBold($field->getName()), $field->getValue());
    }    
    return implode('', $rows);
  }
 
 /**
  * Parses assigned debug data
  *
  * @param string[] $fields
  *
  * @return string HTML code
  */    
  public function parseDebugFields($fields)
  {
    $rows = [];
    foreach($fields as $k => $v)
    {
      $rows[] = $this->elements->addRow($v['title'].'<br>'.$v['data']);
    }    
    if(count($rows) == 0) 
    {
      return $this->elements->addRow('-- no debug fields --');
    }  
    return implode('', $rows);
  }
  
 /**
  * Parses assigned states data
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function parseStatesFields($fields)
  {
    $rows = [];
    foreach($fields as $field)
    {
      $rows[] = $this->elements->addValRow($this->elements->addBold($field->getName()), $field->getValue());
    } 
    if(count($rows) == 0) 
    {
      return $this->elements->addRow('-- no states --');
    }  
    return implode('', $rows);
  } 

 /**
  * Parses assigned errors data
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */   
  public function parseErrorsFields($fields)
  {
    $rows = [];
    foreach($fields as $field)
    {
      $errorData = $field->getValue();
      $errorMsg = $errorData[0];
      $errorException = $errorData[1];
      
      $ex = '';
      if($errorException !== null && SkynetConfig::get('debug_exceptions'))
      {
        $ex = $this->elements->addSpan($this->elements->getNl().
        $this->elements->addBold('Exception: ').$errorException->getMessage().$this->elements->getNl().
        $this->elements->addBold('File: ').$errorException->getFile().$this->elements->getNl().
        $this->elements->addBold('Line: ').$errorException->getLine().$this->elements->getNl().
        $this->elements->addBold('Trace: ').str_replace('#', $this->elements->getNl().'#', $errorException->getTraceAsString()), 'exception');
      }
      $rows[] = $this->elements->addValRow($this->elements->addBold($field->getName()), $this->elements->addSpan($errorData[0], 'error').$ex);
    }  
    if(count($rows) == 0) 
    {
      return $this->elements->addRow('-- no errors --');
    }    
    return implode('', $rows);
  }
  
 /**
  * Parses config value
  * 
  * @param mixed $value
  *
  * @return string HTML code
  */    
  public function parseConfigValue($value)
  {
    $parsed = $value;   
    if(is_bool($value))
    {
      if($value == true)
      {
        $parsed = $this->elements->addSpan('YES', 'yes');
      } else {
        $parsed = $this->elements->addSpan('NO', 'no');
      }
    }    
    return $parsed;        
  }
  
 /**
  * Parses assigned config data
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */     
  public function parseConfigFields($fields)
  {
    $rows = [];
    foreach($fields as $field)
    {
      $key = $field->getName();
      $keyTitle = SkynetHelper::translateCfgKey($key);
      $val = $field->getValue();
      if(is_array($val))
      {
        $val = implode('<br>', $val);
      }
      
      $rows[] = $this->elements->addVal3Row($this->elements->addBold($keyTitle), $this->parseConfigValue($val), $key);  
    }
    
    return implode('', $rows);
  } 
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlElements.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer HTML Elements generator
  *
  */
class SkynetRendererHtmlElements
{   
  /** @var string New Line Char */
  private $nl;
  
  /** @var string > Char */
  private $gt;
  
  /** @var string < Char */
  private $lt;
  
  /** @var string Separator tag */
  private $separator;
  
  /** @var string CSS Stylesheet */
  private $css;
  
  /** @var Skynet SkynetRendererHtmlThemes Themes Container*/
  private $themes;
  
  private $js;
  
  
 /**
  * Constructor
  */
  public function __construct()
  {
    $this->themes = new SkynetRendererHtmlThemes();
    $this->js = new SkynetRendererHtmlJavascript();
    
    $theme = SkynetConfig::get('core_renderer_theme');
    if(isset($_SESSION['_skynetOptions']['theme']) && !empty($_SESSION['_skynetOptions']['theme']))
    {
      $theme = $_SESSION['_skynetOptions']['theme'];
    }   
    $this->css = $this->themes->getTheme($theme);
    $this->nl = '<br/>';
    $this->gt = '&gt;';
    $this->lt = '&lt;';
    $this->separator = '<hr/>'; 
  }   
  
 /**
  * Sets CSS styles
  *
  * @param string $styles CSS styles data
  */ 
  public function setCss($styles)
  {
    $this->css = $styles;    
  }  
    
 /**
  * Checks for new version on GitHub
  *
  * @return string Version
  */ 
  private function checkNewestVersion()
  {
    if(!SkynetConfig::get('core_check_new_versions'))
    {
      return null;
    }
    
    $url = 'https://raw.githubusercontent.com/szczyglinski/skynet/master/VERSION';
    $version = @file_get_contents($url);
    if($version !== null)
    {
      return ' ('.$version.')';
    }   
  }
  
 /**
  * Adds subtitle
  * 
  * @param string $title Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */  
  public function addSubtitle($title, $class = null)
  {  
    return $this->addH3('[ '.$title.' ]', $class);
  }
  
 /**
  * Returns line separator tag
  *
  * @return string HTML code
  */  
  public function addSeparator()
  {
    return $this->separator;
  } 
  
 /**
  * Adds bold
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */    
  public function addBold($html, $class = null)
  {
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<b'.$cls.'>'.$html.'</b>';
  }
 
 /**
  * Adds select option
  * 
  * @param string $value Option value
  * @param string $title Option name
  * @param bool $selected Selected
  *
  * @return string HTML code
  */    
  public function addOption($value, $title, $isSelected = false)
  {
    $selected = '';
    if($isSelected === true) 
    {
      $selected = ' selected';
    }
    return '<option value="'.$value.'"'.$selected.'>'.$title.'</option>';
  }
  
 /**
  * Adds span
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addSpan($html, $class = null)
  {
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<span'.$cls.'>'.$html.'</span>';
  } 
 
 /**
  * Adds Heading1
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addH1($html, $class = null)
  {
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<h1'.$cls.'>'.$html.'</h1>';
  }
  
 /**
  * Adds Heading2
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addH2($html, $class = null)
  {
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<h2'.$cls.'>'.$html.'</h2>';
  }
  
 /**
  * Adds Heading3
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addH3($html, $class = null)
  {
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<h3'.$cls.'>'.$html.'</h3>';
  }
  
 /**
  * Adds Table
  * 
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function beginTable($class = null)
  {
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<table'.$cls.'>';
  }
  
 /**
  * Ends Table
  *
  * @return string HTML code
  */   
  public function endTable()
  {   
    return '</table>';
  }
  
 /**
  * Adds URL
  * 
  * @param string $link URL
  * @param string $name Name of link
  * @param bool $target True if _blank
  * @param string $class CSS class
  *
  * @return string HTML code
  */   
  public function addUrl($link, $name = null, $target = true, $class = null)
  {
    if($name === null) 
    {
      $name = $link;
    }
    $blank = '';
    if($target) 
    {
      $blank = ' target="_blank"';
    }
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<a'.$cls.' href="'.$link.'"'.$blank.' title="'.strip_tags($name).'">'.$name.'</a>';    
  }

 /**
  * Adds any HTML
  * 
  * @param string $html HTML code
  *
  * @return string HTML code
  */    
  public function addHtml($html)
  {
    return $html;
  }

 /**
  * Adds Tab btn
  * 
  * @param string $title Title
  * @param string $url URL
  * @param string $class Class
  *
  * @return string HTML code
  */    
  public function addTabBtn($title, $url, $class)
  {
    return '<a class="'.$class.'" href="'.$url.'">'.$title.'</a> ';
  }
 
 /**
  * Adds section container
  * 
  * @param string $id Identifier
  *
  * @return string HTML code
  */    
  public function addSectionId($id)
  {
    return '<div id="'.$id.'">';
  }
  
 /**
  * Adds section container
  * 
  * @param string $class Class name
  *
  * @return string HTML code
  */
  public function addSectionClass($class)
  {
    return '<div class="'.$class.'">';
  }

  
 /**
  * Adds section closing tag
  *
  * @return string HTML code
  */
  public function addSectionEnd()
  {
    return '</div>';
  }
  
 /**
  * Adds clearing floats
  * 
  *
  * @return string HTML code
  */   
  public function addClr()
  {
    return '<div class="clr"></div>';
  }
 
 /**
  * Adds table key => value row
  * 
  * @param string $status TD 1
  * @param string $url TD 2
  * @param string $ping TD 3
  *
  * @return string HTML code
  */   
  public function addClusterRow($status, $url, $ping, $conn)
  {
    return '<tr><td class="tdClusterStatus">'.$status.'</td><td class="tdClusterUrl">'.$url.'</td><td class="tdClusterPing">'.$ping.'</td><td class="tdClusterConn">'.$conn.'</td></tr>';
  }
 
 /**
  * Adds table key => value row
  * 
  * @param string $key TD 1
  * @param string $val TD 2
  *
  * @return string HTML code
  */   
  public function addValRow($key, $val)
  {
    return '<tr><td class="tdKey">'.$key.'</td><td class="tdVal">'.$val.'</td></tr>';
  }
 
 /**
  * Adds table key => value row
  * 
  * @param string $key TD 1
  * @param string $val TD 2
  * @param string $val2 TD 3
  *
  * @return string HTML code
  */   
  public function addVal3Row($key, $val, $val2)
  {
    return '<tr><td class="tdKey">'.$key.'</td><td class="tdVal">'.$val.'</td><td class="tdVal">'.$val2.'</td></tr>';
  }
  
 /**
  * Adds table key => value row
  * 
  * @param string $key TD 1
  * @param string $val TD 2
  *
  * @return string HTML code
  */   
  public function addFormRow($key, $val)
  {
    return '<tr><td class="tdFormKey">'.$key.'</td><td class="tdFormVal">'.$val.'</td></tr>';
  }
 
 /**
  * Adds monit
  * 
  * @param string $msg
  *
  * @return string HTML code
  */  
 public function addMonitOk($msg)
 {
    $output = [];
    $output[] = $this->addSectionClass('monitOK');
    $output[] = $this->addBold('Result: [OK] ');
    $output[] = $msg;    
    $output[] = $this->addSectionEnd(); 
    return implode('', $output);
 }
 
 /**
  * Adds monit
  * 
  * @param string $msg
  *
  * @return string HTML code
  */  
 public function addMonitError($msg)
 {
    $output = [];
    $output[] = $this->addSectionClass('monitError');
    $output[] = $this->addBold('Result: [ERROR] ');
    $output[] = $msg;    
    $output[] = $this->addSectionEnd(); 
    return implode('', $output);
 }
 
 /**
  * Adds table key => value row
  * 
  * @param string $key TD 1
  * @param string $val TD 1
  *
  * @return string HTML code
  */   
  public function addFormActionsRow($val)
  {
    return '<tr><td class="tdFormActions" colspan="2">'.$val.'</td></tr>';
  }

 /**
  * Adds table header row
  * 
  * @param string $col1 TD 1
  * @param string $col2 TD 2
  *
  * @return string HTML code
  */   
  public function addHeaderRow2($col1, $col2)
  {
    return '<tr><th class="tdHeader">'.$col1.'</th><th class="tdHeader">'.$col2.'</th></tr>';
  }
  
 /**
  * Adds table header row
  * 
  * @param string $col1 TD 1
  * @param string $col2 TD 2
  * @param string $col3 TD 3
  *
  * @return string HTML code
  */   
  public function addHeaderRow3($col1, $col2, $col3)
  {
    return '<tr><th class="tdHeader">'.$col1.'</th><th class="tdHeader">'.$col2.'</th><th class="tdHeader">'.$col3.'</th></tr>';
  } 
  
 /**
  * Adds table header row
  * 
  * @param string $col1 TD 1
  * @param string $col2 TD 2
  * @param string $col3 TD 3
  * @param string $col4 TD 4
  *
  * @return string HTML code
  */   
  public function addHeaderRow4($col1, $col2, $col3, $col4)
  {
    return '<tr><th class="tdHeader">'.$col1.'</th><th class="tdHeader">'.$col2.'</th><th class="tdHeader">'.$col3.'</th><th class="tdHeader">'.$col4.'</th></tr>';
  } 
  
 /**
  * Adds table header row
  * 
  * @param string $val TD 1
  *
  * @return string HTML code
  */   
  public function addHeaderRow($val, $colspan = 2)
  {
    return '<tr><th class="tdHeader" colspan="'.$colspan.'">'.$val.'</th></tr>';
  } 
 
 /**
  * Adds table row
  * 
  * @param string $val TD 1
  *
  * @return string HTML code
  */   
  public function addRow($val, $colspan = 2)
  {
    return '<tr><td colspan="'.$colspan.'">'.$val.'</td></tr>';
  } 
  
 /**
  * Adds HTML head tags
  *
  * @return string HTML code
  */ 
  public function addHeader()
  {
    $html = '<html><head>';
    $html.= '<title>'.pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME).' ('.SkynetVersion::VERSION.')</title>';
    $html.= '<style>'.$this->css.'</style>';
    $html.= '<meta charset="utf-8">';
    $html.= '<link rel="shortcut icon"type="image/x-icon" href="data:image/x-icon;,">';
    $html.= '</head><body>';
    return $html;
  } 
      
 /**
  * Adds HTML body ending tags
  *
  * @return string HTML code
  */
  public function addFooter($successed = 0)
  {
    //$html = '<script src="skynet.js"></script>';
    $html = '<script>'.$this->js->getJavascript().'</script>';
    $html.= '<script>skynetControlPanel.setFavIcon('.$successed.');</script>';
    $html.= '</body></html>';
    return $html;
  }
  
 /**
  * Returns header
  *
  * @return string HTML code
  */  
  public function addSkynetHeader()
  {
    $header = $this->addH1('<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAaCAYAAAD1wA/qAAAALHRFWHRDcmVhdGlvbiBUaW1lAMWaciAxOSBrd2kgMjAxNyAwMjo1Njo0NSArMDEwMBachLcAAAAHdElNRQfhBBMAORXFuVVnAAAACXBIWXMAAAsSAAALEgHS3X78AAAABGdBTUEAALGPC/xhBQAAAx9JREFUeNrtl19IU1Ecx+/+Ovtjioj5oEEPPS0J6inaW4EPBjXooVgPJfbQg+0hmBAoY7FUamwPU/eyDWszaq5oC5kVW8m0Qool+rIYDPawQpq49sf97XfmOTW16Zlt3oK+8OVc7j1/fp97zu/ccxnmv7aWUCgslCqViq/X6xvQtUgkYjus8sTj8QqlRCJhgsHg3Wg06pHL5XXFz/56kUA7OjqYUCikzWPFYrHp3t7e+n8Chs/nF0qpVMqEw2FDfoOSyeR7pVLZhOpwuVy2w90aQiaTMUtLS2P5EkqlUr7BwcFDqC6Hw2E77N9DdHd3cyORiDW/jTKZzH2dTsd22OtF1ntPT49wZWXFvh0E6C24OZfLMQaDge3w10MoFIpaSOZJCohZcAOYAXPBd8xm8zFWIUiy9vf31yUSCTcFhBdcjyGQzfh+aHx8XMwKBEnSgYGBRkjeWQqIafABDMABP9jwPGy324+zAqPVag9C0n6ggHgN3l+0nB6WqPcNYE7u6kyMjIy0ZbPZBQoItOT2YQge+PFWlWEDWB4dHZVUFYIk9tDQ0GEY8zMFxCvwXgwhAD+haIP03WQynakKBEnsvr6+I5DYAYpgXoD3YIga8DNKCKKk1Wo9W1EIspzUavXR1dXVEEUQLnAthhCBn5cJQZSamJg4X1EYjUZzIp1Of6UYfBIHz+AZce0QgijrdDovVgRieHj4FCR2hGJQ9OZrMATKjZd/CPFTU1NTVzeukLJkNBpPQz9RirEcYCGGQFutu1IQRB6P59qOYCwWSye0T1CM8TS/tishCPTRe1NpCKKZmZkbZcHYbLYL0C5N0be9CAKdobzVgiCam5tTkDg3/dMU0zkcjktQP0fRpw3MxxCN4HfVhiDy+Xy3NsEUU7lcriuUfT3Kr32pEUQTelG7BUG0uLh4u7W1tRC3QCD4NStut/s6ZR/orMTFEM3gj7sNQeT3+++1t7evAbS0tDBer/cmZVt0auVgiDbwJ7YgiAKBgK6rq0vImZ+fPycWi1XAhP5XMyXyHx20voA7wTF8Tw2+DF4uf2OvmFBeCOLx+NgP1c7Cc+35//8AAAAASUVORK5CYII=
"/> SKYNET v.'.SkynetVersion::VERSION, 'logo');
    $header.= '(c) 2017 Marcin Szczyglinski<br>Updates: '.$this->addUrl(SkynetVersion::WEBSITE).$this->checkNewestVersion().'<br>Website: '.$this->addUrl(SkynetVersion::BLOG);
    $header.= $this->getNl();      
    return $header;
  }
    
 /**
  * Returns new line
  *
  * @return string HTML 
  */
  public function getNl()
  {
    return $this->nl;
  }
  
 /**
  * Returns > arrow
  *
  * @return string HTML 
  */
  public function getGt()
  {
    return $this->gt;
  }
  
 /**
  * Returns < arrow
  *
  * @return string HTML 
  */
  public function getLt()
  {
    return $this->lt;
  }
  
 /**
  * Returns separator
  *
  * @return string HTML 
  */
  public function getSeparator()
  {
    return $this->separator;
  }
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlHeaderRenderer.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

 /**
  * Skynet Renderer Mode Renderer
  *
  */
class SkynetRendererHtmlHeaderRenderer extends SkynetRendererAbstract
{     
  /** @var string[] HTML elements of output */
  private $output = [];    
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  
  
  /** @var SkynetRendererHtmlConsoleRenderer Console Renderer */
  private $summaryRenderer;
  
  /** @var SkynetRendererHtmlConnectionsRenderer Connections Renderer */
  private $connectionsRenderer;
  
  /** @var SkynetDatabaseSchema DB Schema */
  protected $databaseSchema;
  
  /** @var SkynetAuth Authorization */
  private $auth;
  
  /** @var SkynetThemes Themes */
  private $themes;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();  
    $this->summaryRenderer = new  SkynetRendererHtmlSummaryRenderer();
    $this->connectionsRenderer = new  SkynetRendererHtmlConnectionsRenderer();
    $this->databaseSchema = new SkynetDatabaseSchema;    
    $this->auth = new SkynetAuth();
    $this->themes = new SkynetRendererHtmlThemes();  
  }  
 
 /**
  * Renders theme switcher
  *
  * @return string HTML code
  */   
  private function renderThemeSwitcher()
  {    
    $themes = $this->themes->getAvailableThemes();
    $options = [];
    
    foreach($themes as $k => $v)
    {
      if(isset($_SESSION['_skynetOptions']['theme']) && $_SESSION['_skynetOptions']['theme'] == $k)
      {
        $options[] = '<option value="'.$k.'" selected>'.$v.'</option>';
      } else {
        $options[] = '<option value="'.$k.'">'.$v.'</option>';
      }
    }    
    return '<select onchange="skynetControlPanel.changeTheme(this)" name="_skynetTheme">'.implode('', $options).'</select> ';
  }  
 
 /**
  * Renders and returns Switch View links
  *
  * @return string HTML code
  */   
  private function renderViewSwitcher()
  {    
    $modes = [];
    $modes['connections'] = 'CONNECTIONS (<span class="numConnections">'.$this->connectionsCounter.'</span>)';
    $modes['database'] = 'DATABASE ('.$this->databaseSchema->countTables().')';   
    
    $links = [];
    foreach($modes as $k => $v)
    {
      $name = $v;
      if($this->mode == $k) 
      {
        $name = $this->elements->addBold($v, 'viewActive');
      }
      $links[] = ' <a class="aSwitch" href="?_skynetView='.$k.'" title="Switch to view: '.strip_tags($v).'">'.$name.'</a> ';     
    }    
    return implode(' ', $links);
  } 
  
 /**
  * Renders and returns header
  *
  * @return string HTML code
  */ 
  public function render()
  {
    $output = [];  
    $header = $this->elements->addSkynetHeader();   
    
    /* --- Header --- */
    $output[] = $this->elements->addSectionId('header');
    
    
    $output[] = $this->elements->addSectionClass('hdrLogo');
    $output[] = $header;       
    $output[] = $this->elements->addSectionEnd();
    
    
    $output[] = $this->elements->addSectionClass('hdrColumn1');
    $output[] = $this->summaryRenderer->renderService($this->fields);
    $output[] = $this->elements->addSectionEnd();
    
    $output[] = $this->elements->addSectionClass('hdrColumn2');
    $output[] = $this->summaryRenderer->renderServer($this->fields);
    $output[] = $this->elements->addSectionEnd();
    
    $output[] = $this->elements->addSectionClass('hdrColumn3');
    $output[] = $this->summaryRenderer->renderSummary($this->fields);
    $output[] = $this->elements->addSectionEnd();
    
    
    $output[] = $this->elements->addSectionClass('hdrSwitch');
    
    $output[] = '<form method="get" action="" class="formViews" id="_skynetThemeForm">';
    $output[] = '<input type="hidden" name="_skynetView" value="'.$this->mode.'">';
    $output[] = 'View: '.$this->renderViewSwitcher();
    $output[] = ' Theme: '.$this->renderThemeSwitcher();
    $output[] = $this->renderLogoutLink();
    $output[] = '</form>';
    
    if($this->mode == 'connections')
    {
      $output[] = '<div class="innerGotoConnection">'.$this->connectionsRenderer->renderGoToConnection($this->connectionsData[0]).'</div>';
    }
    $output[] = $this->elements->addSectionEnd();

    /* Clear floats */  
    $output[] = $this->elements->addClr();
    /* !End of Header */
    $output[] = $this->elements->addSectionEnd();  

    return implode('', $output);
  }
  
 /**
  * Renders and returns logout link
  *
  * @return string HTML code
  */    
  public function renderLogoutLink()
  {
    if($this->auth->isPasswordGenerated())
    {
      return $this->elements->addUrl('?_skynetLogout=1', $this->elements->addBold('LOGOUT'), false, 'aLogout'); 
    }      
  } 
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlJavascript.php
 *
 * @package Skynet
 * @version 1.1.4
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

 /**
  * Skynet Renderer Javascript
  *
  */
class SkynetRendererHtmlJavascript
{     
 

 /**
  * Constructor
  */
  public function __construct()
  {
    
  }    
 
 /**
  * Returns jS
  *
  * @return string JS code
  */  
  public function getJavascript()
  {
    $js = "
  var skynetControlPanel = 
{  
  status: null,
  connectMode: 2,
  connectInterval: 0, 
  connectIntervalNow: 0,
  connectTimer: null,
  connectTimerNow: null,
  cluster: null,
  optionViewIntenalParams: null,
  optionViewEchoParams: null,
  
  switchTab: function(e) 
  {    
    var tabStates = document.getElementsByClassName('tabStates');
    var tabErrors = document.getElementsByClassName('tabErrors');
    var tabConfig = document.getElementsByClassName('tabConfig');
    var tabConsole = document.getElementsByClassName('tabConsole');
    var tabDebug = document.getElementsByClassName('tabDebug');
    var tabListeners = document.getElementsByClassName('tabListeners');
    
    tabStates[0].style.display = 'none';
    tabErrors[0].style.display = 'none';
    tabConfig[0].style.display = 'none';
    tabConsole[0].style.display = 'none';
    tabDebug[0].style.display = 'none';
    tabListeners[0].style.display = 'none';
    
    document.getElementsByClassName('tabStatesBtn')[0].className = document.getElementsByClassName('tabStatesBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabErrorsBtn')[0].className = document.getElementsByClassName('tabErrorsBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConfigBtn')[0].className = document.getElementsByClassName('tabConfigBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConsoleBtn')[0].className = document.getElementsByClassName('tabConsoleBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabDebugBtn')[0].className = document.getElementsByClassName('tabDebugBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabListenersBtn')[0].className = document.getElementsByClassName('tabListenersBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    
    var btnToActive = e + 'Btn';
    document.getElementsByClassName(btnToActive)[0].className += ' active';
    document.getElementsByClassName(e)[0].style.display = 'block';
  },
  
  switchConnTab: function(e, id) 
  {    
    var tabConnPlain = document.getElementsByClassName('tabConnPlain'+id);
    var tabConnEncrypted = document.getElementsByClassName('tabConnEncrypted'+id);
    var tabConnRaw = document.getElementsByClassName('tabConnRaw'+id);
    
    tabConnPlain[0].style.display = 'none';
    tabConnEncrypted[0].style.display = 'none';
    tabConnRaw[0].style.display = 'none';
    
    document.getElementsByClassName('tabConnPlainBtn'+id)[0].className = document.getElementsByClassName('tabConnPlainBtn'+id)[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConnEncryptedBtn'+id)[0].className = document.getElementsByClassName('tabConnEncryptedBtn'+id)[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConnRawBtn'+id)[0].className = document.getElementsByClassName('tabConnRawBtn'+id)[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    
    var btnToActive = e + 'Btn' + id;
    document.getElementsByClassName(btnToActive)[0].className += ' active';
    document.getElementsByClassName(e + id)[0].style.display = 'block';
  },
  
  insertCommand: function() 
  {    
    var cmdsList = document.getElementById('cmdsList');
    
    if(cmdsList.options[cmdsList.selectedIndex].value != '0') 
    { 
        if(document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value == '' || document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value == null) 
        {
          document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value = cmdsList.options[cmdsList.selectedIndex].value + ' ';
          document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].focus();
        } else {
          document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value = document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value + '\\r\\n' + cmdsList.options[cmdsList.selectedIndex].value + ' ';
          document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].focus();
        }        
    }
  },
  
  insertConnect: function(url) 
  {  
    var cmd = '@connect ' + url;
    
    if(document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value == '' || document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value == null) 
    {
      document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value = cmd + ' ';
      document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].focus();
    } else {
      document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value = document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value + '\\r\\n' + cmd + ' ';
      document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].focus();
    }    
  },
    
  gotoConnection: function() 
  {
    var connectList = document.getElementById('connectList');
    if(connectList.options[connectList.selectedIndex].value > 0) 
    {       
      window.location.assign(window.location.href.replace(location.hash, '') + '#_connection' + connectList.options[connectList.selectedIndex].value); 
    }
  },
  
  switchStatus: function(status)
  {
    this.status = status;
    var statusIdle = document.getElementsByClassName('statusIdle');
    var statusSingle  = document.getElementsByClassName('statusSingle');
    var statusBroadcast  = document.getElementsByClassName('statusBroadcast');
    
    document.getElementsByClassName('statusIdle')[0].className = document.getElementsByClassName('statusIdle')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('statusSingle')[0].className = document.getElementsByClassName('statusSingle')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('statusBroadcast')[0].className = document.getElementsByClassName('statusBroadcast')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    
    var toActive = 'status' + status;
    document.getElementsByClassName(toActive)[0].className += ' active';
  },
  
  switchMode: function(connId)
  {
    this.connectMode = connId;
    switch(connId)
    {
      case 0:
        this.switchStatus('Idle');
      break;
      
      case 1:
        this.switchStatus('Single');
      break;
      
      case 2:
        this.switchStatus('Broadcast');
      break;      
    }      
  },
  
  parseParam: function(param, paramClass = null)
  {
    if(param == true || param == false)
    {
     if(paramClass != null)
      {
        paramClass.className = paramClass.className.replace(/(?:^|\s)yes(?!\S)/g, '');
        paramClass.className = paramClass.className.replace(/(?:^|\s)no(?!\S)/g, '');          
      }   
        
      if(param == true)
      {
        paramClass.className += ' yes';
        return 'YES';
      } else {
        paramClass.className += ' no';
        return 'NO';
      }
      
    } else {
      
      return param;
    }    
  },

  load: function(connMode, cmd = false, skynetCluster)
  {   
    this.cluster = skynetCluster;
    var successed = 0;
    
    if(cmd == false)
    {
      this.connectMode = connMode;
      switch(connMode)
      {
        case 0:
          this.switchStatus('Idle');
        break;
        
        case 1:
          this.switchStatus('Single');
        break;
        
        case 2:
          this.switchStatus('Broadcast');
        break;      
      }  
    }    
    
    var divConnectionData = document.getElementsByClassName('innerConnectionsData')[0];
    var divAddresses = document.getElementsByClassName('innerAddresses')[0];
    var divGoto = document.getElementsByClassName('innerGotoConnection')[0];    
    var divTabStates = document.getElementsByClassName('tabStates')[0];
    var divTabErrors = document.getElementsByClassName('tabErrors')[0];
    var divTabConfig = document.getElementsByClassName('tabConfig')[0];
    var divTabConsole = document.getElementsByClassName('tabConsole')[0];  
    var divTabDebug = document.getElementsByClassName('tabDebug')[0]; 
    var divTabListeners = document.getElementsByClassName('tabListeners')[0];        
    var divNumStates = document.getElementsByClassName('numStates')[0];
    var divNumErrors = document.getElementsByClassName('numErrors')[0];
    var divNumConfig = document.getElementsByClassName('numConfig')[0];
    var divNumConsole = document.getElementsByClassName('numConsole')[0]; 
    var divNumDebug = document.getElementsByClassName('numDebug')[0];
    var divNumListeners = document.getElementsByClassName('numListeners')[0];
    var divNumConnections = document.getElementsByClassName('numConnections')[0];    
    var divSumBroadcasted = document.getElementsByClassName('sumBroadcasted')[0];
    var divSumClusters = document.getElementsByClassName('sumClusters')[0];
    var divSumAttempts = document.getElementsByClassName('sumAttempts')[0];
    var divSumSuccess = document.getElementsByClassName('sumSuccess')[0];    
    var divSumChain = document.getElementsByClassName('sumChain')[0];
    var divSumSleeped = document.getElementsByClassName('sumSleeped')[0];    
    var divSumClusterIP = document.getElementsByClassName('sumClusterIP')[0];
    var divSumYourIP = document.getElementsByClassName('sumYourIP')[0];
    var divSumEncryption = document.getElementsByClassName('sumEncryption')[0];
    var divSumConnections = document.getElementsByClassName('sumConnections')[0];
    
    divConnectionData.innerHTML = 'Connecting...Please wait...';   
    
    var xhttp;
    if(window.XMLHttpRequest) 
    {
      xhttp = new XMLHttpRequest();
      } else {        
      xhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xhttp.onreadystatechange = function() 
    {
      //console.debug(this);
      if(this.readyState == 4 && this.status == 200) 
      {  
       try
       {
         var response = JSON.parse(this.responseText);       
         successed = parseInt(response.sumSuccess);
         
         divConnectionData.innerHTML = response.connectionData;
         divAddresses.innerHTML = response.addresses;       
         divGoto.innerHTML = response.gotoConnection;       
         divTabStates.innerHTML = response.tabStates;
         divTabErrors.innerHTML = response.tabErrors;
         divTabConfig.innerHTML = response.tabConfig;
         divTabConsole.innerHTML = response.tabConsole; 
         divTabDebug.innerHTML = response.tabDebug;   
         divTabListeners.innerHTML = response.tabListeners;          
         divNumStates.innerHTML = response.numStates;
         divNumErrors.innerHTML = response.numErrors;
         divNumConfig.innerHTML = response.numConfig;
         divNumConsole.innerHTML = response.numConsole;   
         divNumDebug.innerHTML = response.numDebug;  
         divNumListeners.innerHTML = response.numListeners;          
         divNumConnections.innerHTML = response.numConnections;       
         divSumBroadcasted.innerHTML = response.sumBroadcasted;
         divSumClusters.innerHTML = response.sumClusters;
         divSumAttempts.innerHTML = response.sumAttempts;
         divSumSuccess.innerHTML = response.sumSuccess;       
         divSumChain.innerHTML = response.sumChain;         
         divSumClusterIP.innerHTML = response.sumClusterIP;
         divSumYourIP.innerHTML = response.sumYourIP;
         divSumEncryption.innerHTML = response.sumEncryption;
         divSumConnections.innerHTML = response.sumConnections;
         divSumSleeped.innerHTML = skynetControlPanel.parseParam(response.sumSleeped, divSumSleeped);           
         if(successed > 0)
         {
           skynetControlPanel.setFavIcon(1);
         } else {
           skynetControlPanel.setFavIcon(0);
         }       
         skynetControlPanel.switchMode(parseInt(response.connectionMode));
       } catch(e)
       {
         divConnectionData.innerHTML = this.responseText;
       }       
      }
    }
    
    var params = '_skynetAjax=1';
    if(cmd == true)
    {
      params+= '&_skynetCmdCommandSend=1&_skynetCmdConsoleInput='+encodeURIComponent(document.getElementById('_skynetCmdConsoleInput').value);
    } else {
      params+= '&_skynetSetConnMode=' + connMode;
    }
    
    if(this.optionViewIntenalParams != null)
    {
      if(this.optionViewIntenalParams == 1)
      {
        params+= '&_skynetOptionViewInternalParams=1';
      } else {
        if(this.optionViewIntenalParams == 0)
        {
          params+= '&_skynetOptionViewInternalParams=0';
        }
      }
    }
    
    if(this.optionViewEchoParams != null)
    {
      if(this.optionViewEchoParams == 1)
      {
        params+= '&_skynetOptionViewEchoParams=1';
      } else {
        if(this.optionViewEchoParams == 0)
        {
          params+= '&_skynetOptionViewEchoParams=0';
        }
      }
    }
    
    xhttp.open('POST', skynetCluster, true);   
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=utf-8');
    xhttp.send(params);
    return false;    
  },
  
  changeTheme: function(form)
  {
    document.getElementById('_skynetThemeForm').submit();
  },
  
  connectionHelper: function()
  {
    var divIntervalStatus = document.getElementById('connIntervalStatus');
    var now = parseInt(this.connectIntervalNow) - 1;
    this.connectIntervalNow = now;
    divIntervalStatus.innerHTML = now+'s';    
  },
  
  connectionClock: function() 
  {
    this.connectIntervalNow = this.connectInterval + 1;
    this.load(this.connectMode, false, this.cluster);
  },
  
  switchViewInternalParams: function(cluster)
  {
    this.cluster = cluster;
    var optionsList = document.getElementById('_skynetViewInternalParamsOption');
    if(optionsList.options[optionsList.selectedIndex].value == 1) 
    {   
      this.optionViewIntenalParams = 1;
    } else {
      this.optionViewIntenalParams = 0;
    }
    this.load(this.connectMode, false, this.cluster);    
  },
  
  switchViewEchoParams: function(cluster)
  {
    this.cluster = cluster;
    var optionsList = document.getElementById('_skynetViewEchoParamsOption');
    if(optionsList.options[optionsList.selectedIndex].value == 1) 
    { 
      this.optionViewEchoParams = 1;
    } else {
      this.optionViewEchoParams = 0;
    }
    this.load(this.connectMode, false, this.cluster);    
  },
  
  setConnectInterval: function(cluster)
  {
    this.cluster = cluster;
    var divIntervalInput = document.getElementById('connIntervalValue');
    var divIntervalStatus = document.getElementById('connIntervalStatus');
    var interval = parseInt(divIntervalInput.value);
    if(isNaN(interval))
    {
      interval = 0;
    }
    this.connectInterval = interval;
    
    if(interval == 0)
    {
      divIntervalStatus.innerHTML = 'disabled';
      clearInterval(this.connectTimer);
      clearInterval(this.connectTimerNow);
    } else {
      clearInterval(this.connectTimer);
      clearInterval(this.connectTimerNow);
      
      divIntervalStatus.innerHTML = interval +'s';
      var s = interval * 1000;
      this.connectIntervalNow = s;
      
      skynetControlPanel.connectInterval = interval;
      skynetControlPanel.connectIntervalNow = interval;
      this.connectTimer = setInterval(function()
      { 
        skynetControlPanel.connectionClock(); 
      }, s);      
      
      this.connectTimerNow = setInterval(function()
      { 
        skynetControlPanel.connectionHelper(); 
      }, 1000);
    }
  },
  
  setFavIcon: function(mode = 0) 
  {
    var iconIdle = 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAKnRFWHRDcmVhdGlvbiBUaW1lAE4gMjMga3dpIDIwMTcgMDM6NTY6NTUgKzAxMDAVMKR0AAAAB3RJTUUH4QQXATklbcCYqwAAAAlwSFlzAAALEgAACxIB0t1+/AAAAARnQU1BAACxjwv8YQUAAACeSURBVHja7dIxCkIhHMdxb9PsEB1CaAzXukeNuVqbBNkJOk5zk7OLmCD++/WKEIqXvamhz6TCVwVl7K/XDo4wKF4D3WWt9f6reAWPmJxzJKWcW2sPTfES6phzTqWUbr6B5pO994QlyjlTbQvNcUqJ3nm5SR2HELo4xkh9npsopWaYn26LFxBCTDGU9NnZGLNgY6hvM4LW15rAoD/yW64SvPFhV3oXpAAAAABJRU5ErkJggg==';
    var iconSuccess = 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAKnRFWHRDcmVhdGlvbiBUaW1lAE4gMjMga3dpIDIwMTcgMDM6NTY6NTUgKzAxMDAVMKR0AAAAB3RJTUUH4QQXAg0XHHuEhQAAAAlwSFlzAAALEgAACxIB0t1+/AAAAARnQU1BAACxjwv8YQUAAABJSURBVHjaY2AY3iDxn9R/EManhhGfZmT+fKZnjEQbgMtWbIYwEqsZlyGMpGjGZggjqZrRDWEkRzOyIYzkaoYBJko0Dw4DBh4AAJKoH3bZk1EYAAAAAElFTkSuQmCC';
    var docHead = document.getElementsByTagName('head')[0];       
    var newLink = document.createElement('link');
    newLink.rel = 'shortcut icon';
    newLink.id = 'fav';
    oldLink = document.getElementById('fav');
    
    var ico = '';
    if(mode == 0)
    {
      ico = 'data:image/png;base64,'+iconIdle;
    } else {
      ico = 'data:image/png;base64,'+iconSuccess;
    }
    newLink.href = ico;
    if (oldLink) 
    {
      docHead.removeChild(oldLink);
    }
    docHead.appendChild(newLink);    
  }
}
";

  return $js;    
  }
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlListenersRenderer.php
 *
 * @package Skynet
 * @version 1.1.4
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.4
 */

 /**
  * Skynet Renderer Mode Renderer
  *
  */
class SkynetRendererHtmlListenersRenderer
{
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  
  
  /** @var SkynetEventListenerInterface[] Listeners */
  private $eventListeners;
  
  /** @var SkynetEventListenerInterface[] Loggers */
  private $eventLoggers;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();  
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();
  }  
  
 /**
  * Renders and returns listeners
  *
  * @return string HTML code
  */  
  public function render($ajax = false)
  {    
    $output = [];
    $output[] = $this->elements->beginTable('tblStates');
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Event Listeners ('.$this->countListeners().')'));   
    $output[] = $this->elements->addHeaderRow2('ID', 'Event Listener');
    $output[] = $this->renderListenersList();
    
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Event Loggers ('.$this->countLoggers().')'));   
    $output[] = $this->elements->addHeaderRow2('ID', 'Event Loggers');
    $output[] = $this->renderLoggersList();
    
    $output[] = $this->elements->endTable();
    
    return implode('', $output);
  }

 /**
  * Counts listeners
  *
  * @return int Counter
  */   
  public function countListeners()
  {
    return count($this->eventListeners);
  }
 
 /**
  * Counts loggers
  *
  * @return int Counter
  */    
  public function countLoggers()
  {
    return count($this->eventLoggers);
  }

 /**
  * Checks for event methods
  *
  * @param \ReflectionClass $reflection
  *
  * @return int[] Event Methods count
  */    
  private function checkEvents($reflection)
  {
    $numEvents = 0;
    $methods = $reflection->getMethods();      
    $events = ['onRequest', 'onResponse', 'onEcho', 'onBroadcast', 'onConnect', 'onConsole', 'onCli'];
    foreach($methods as $m)
    {
      $methodName = $m->getName();
      if(in_array($methodName, $events))
      {
        $numEvents++;
      }      
    }
    return $numEvents;
  }  
  
 /**
  * Gets commands count
  *
  * @param \ReflectionClass $reflection
  * @param SkynetEventLoggersFactory $listener
  *
  * @return int[] Commands count
  */   
  private function checkCommands($reflection, $listener)
  {
    $cmds = [];
    $cmds['console'] = 0;
    $cmds['cli'] = 0;
    
    $isMethod = $reflection->hasMethod('registerCommands');
    if($isMethod)
    {
      $method = $reflection->getMethod('registerCommands');
      $closure = $reflection->getMethod('registerCommands')->getClosure($listener);
      $ret = call_user_func($closure);
      if(isset($ret['cli']))
      {
        $cmds['cli'] = count($ret['cli']);
      }
      if(isset($ret['console']))
      {
        $cmds['console'] = count($ret['console']);
      }
      return $cmds;
    }
  }
  
 /**
  * Gets tables count
  *
  * @param \ReflectionClass $reflection
  * @param SkynetEventLoggersFactory $listener
  *
  * @return int[] Tables count
  */   
  private function checkTables($reflection, $listener)
  {
    $cmds = [];
    $cmds['tables'] = 0;    
    
    $isMethod = $reflection->hasMethod('registerDatabase');
    if($isMethod)
    {
      $method = $reflection->getMethod('registerDatabase');
      $closure = $reflection->getMethod('registerDatabase')->getClosure($listener);
      $ret = call_user_func($closure);
      if(isset($ret['tables']))
      {
        $cmds['tables'] = count($ret['tables']);
      }      
      return $cmds;
    }
  }
 
 /**
  * Renders listeners list
  *
  * @return string HTML
  */  
  private function renderListenersList()
  {
    $output = [];    
    foreach($this->eventListeners as $k => $v)
    {
      $reflection = new \ReflectionClass(get_class($v));
      $methods = $reflection->getMethods();      
      $cmds = $this->checkCommands($reflection, $v);
      $tables = $this->checkTables($reflection, $v);
      
      $listenerId = $k;
      $listenerClass = $reflection->getShortName();
      $listenerNamespace = $reflection->getNamespaceName();      
      $cls = null;      
      if($listenerNamespace == 'SkynetUser')
      {
        $cls = 'debugListenerMy';        
      } else {
        $cls = 'debugListenerCore';        
      }      
      
      $listenerData = $this->elements->addSectionClass($cls);
      $listenerData.= $this->elements->addBold($listenerClass, $cls);
      $listenerData.= '<br>Events: '.$this->checkEvents($reflection).' | Console: '.$cmds['console'].' | CLI: '.$cmds['cli'].' | DB Tables: '.$tables['tables'];
      $listenerData.= $this->elements->addSectionEnd();
      
      $output[] =  $this->elements->addValRow($this->elements->addBold($listenerId, $cls), $listenerData);
    }
    return implode('', $output);    
  }
  
 /**
  * Renders loggers list
  *
  * @return string HTML
  */   
  private function renderLoggersList()
  {
    $output = [];    
    foreach($this->eventLoggers as $k => $v)
    {
      $reflection = new \ReflectionClass(get_class($v));
      $methods = $reflection->getMethods();      
      $cmds = $this->checkCommands($reflection, $v);
      $tables = $this->checkTables($reflection, $v);
      
      $listenerId = $k;
      $listenerClass = $reflection->getShortName();
      $listenerNamespace = $reflection->getNamespaceName();      
      $cls = null;      
      if($listenerNamespace == 'SkynetUser')
      {
        $cls = 'debugListenerMy';        
      } else {
        $cls = 'debugListenerCore';        
      }      
      
      $listenerData = $this->elements->addSectionClass($cls);
      $listenerData.= $this->elements->addBold($listenerClass, $cls);
      $listenerData.= '<br>Events: '.$this->checkEvents($reflection).' | Console: '.$cmds['console'].' | CLI: '.$cmds['cli'].' | DB Tables: '.$tables['tables'];
      $listenerData.= $this->elements->addSectionEnd();
      
      $output[] =  $this->elements->addValRow($this->elements->addBold($listenerId, $cls), $listenerData);
    }
    return implode('', $output);    
  }
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlModeRenderer.php
 *
 * @package Skynet
 * @version 1.1.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

 /**
  * Skynet Renderer Mode Renderer
  *
  */
class SkynetRendererHtmlModeRenderer extends SkynetRendererAbstract
{     
  /** @var string[] HTML elements of output */
  private $output = [];    
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();  
  }  
  
 /**
  * Renders and returns mode
  *
  * @return string HTML code
  */  
  public function render()
  {
    $ajaxSupport = true;
    
    $output = [];
    $status = $this->connectionMode;
    
    $classes = [];
    $classes['idle'] = '';
    $classes['single'] = '';
    $classes['broadcast'] = '';
    
    switch($status)
    {
      case 0:
       $classes['idle'] = ' active';
      break;
      
      case 1:
       $classes['single'] = ' active';
      break;
      
      case 2:
       $classes['broadcast'] = ' active';
      break;
    }   
    
    $output[] = '<b>SKYNET MODE:</b> ';
    
    if($ajaxSupport)
    {
      $output[] = '<a href="javascript:skynetControlPanel.load(0, false, \''.basename($_SERVER['PHP_SELF']).'\');"><span class="statusIdle'.$classes['idle'].'">Idle</span></a> ';
      $output[] = '<a href="javascript:skynetControlPanel.load(1, false, \''.basename($_SERVER['PHP_SELF']).'\');"><span class="statusSingle'.$classes['single'].'">Single</span></a> ';
      $output[] = '<a href="javascript:skynetControlPanel.load(2, false, \''.basename($_SERVER['PHP_SELF']).'\');"><span class="statusBroadcast'.$classes['broadcast'].'">Broadcast</span></a>'; 
      
    } else {
      $output[] = '<a href="?_skynetSetConnMode=0"><span class="statusIdle'.$classes['idle'].'">Idle</span></a> ';
      $output[] = '<a href="?_skynetSetConnMode=1"><span class="statusSingle'.$classes['single'].'">Single</span></a> ';
      $output[] = '<a href="?_skynetSetConnMode=2"><span class="statusBroadcast'.$classes['broadcast'].'">Broadcast</span></a>';  
    }
    
    return '<div class="modeButtons">'.implode($output).'</div>';
  }
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlStatusRenderer.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

 /**
  * Skynet Renderer Status Renderer
  *
  */
class SkynetRendererHtmlStatusRenderer extends SkynetRendererAbstract
{     
  /** @var string[] HTML elements of output */
  private $output = [];    
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  
  
  /** @var SkynetRendererHtmlConsoleRenderer Console Renderer */
  private $summaryRenderer;
  
  /** @var SkynetRendererHtmlConnectionsRenderer Connections Renderer */
  private $connectionsRenderer;
  
  /** @var SkynetRendererHtmlModeRenderer Mode Renderer */
  private $modeRenderer;
  
  /** @var SkynetRendererHtmlClustersRenderer Clusters Renderer */
  private $clustersRenderer;
  
  /** @var SkynetRendererHtmlConsoleRenderer Console Renderer */
  private $consoleRenderer;
  
  /** @var SkynetRendererHtmlListenersenderer Event Listeners Renderer */
  private $listenersRenderer;
  
  /** @var SkynetRendererHtmlDebugParser Debug Parser */
  private $debugParser;
  
  /** @var SkynetDebug Debugger */
  private $debugger;
  
  /** @var SkynetAuth Authorization */
  private $auth;
  
  /** @var SkynetVerifier Verificationn */
  private $verifier;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();  
    $this->summaryRenderer = new  SkynetRendererHtmlSummaryRenderer();
    $this->connectionsRenderer = new  SkynetRendererHtmlConnectionsRenderer();
    $this->modeRenderer = new  SkynetRendererHtmlModeRenderer();
    $this->clustersRenderer = new  SkynetRendererHtmlClustersRenderer();
    $this->debugParser = new SkynetRendererHtmlDebugParser();
    $this->consoleRenderer = new  SkynetRendererHtmlConsoleRenderer(); 
    $this->listenersRenderer = new  SkynetRendererHtmlListenersRenderer();      
    $this->debugger = new SkynetDebug();
    $this->auth = new SkynetAuth();
    $this->verifier = new SkynetVerifier();
  }  
   
 /**
  * Renders monits
  *
  * @return string HTML code
  */   
  private function renderMonits()
  {
    $output = [];
    
    $c = count($this->monits);
    if($c > 0)
    {
      $output[] = $this->elements->addSectionClass('monits');
      $output[] = $this->elements->addBold('Information(s):').$this->elements->getNl();
      foreach($this->monits as $monit)
      {
        $output[] = $monit.$this->elements->getNl();       
      } 
      $output[] = $this->elements->addSectionEnd(); 
    }    
    return implode($output);
  }
  
 /**
  * Renders tabs
  *
  * @return string HTML code
  */  
  private function renderTabs()
  {     
    $output = [];
    $output[] = $this->elements->addSectionClass('tabsHeader');
    $output[] = $this->elements->addTabBtn('States (<span class="numStates">'.count($this->statesFields).'</span>)', 'javascript:skynetControlPanel.switchTab(\'tabStates\');', 'tabStatesBtn active');
    $output[] = $this->elements->addTabBtn('Errors (<span class="numErrors">'.count($this->errorsFields).'</span>)', 'javascript:skynetControlPanel.switchTab(\'tabErrors\');', 'tabErrorsBtn errors');
    $output[] = $this->elements->addTabBtn('Config (<span class="numConfig">'.count($this->configFields).'</span>)', 'javascript:skynetControlPanel.switchTab(\'tabConfig\');', 'tabConfigBtn');
    $output[] = $this->elements->addTabBtn('Console (<span class="numConsole">'.count($this->consoleOutput).'</span>)', 'javascript:skynetControlPanel.switchTab(\'tabConsole\');', 'tabConsoleBtn');
    $output[] = $this->elements->addTabBtn('Debug (<span class="numDebug">'.$this->debugger->countDebug().'</span>)', 'javascript:skynetControlPanel.switchTab(\'tabDebug\');', 'tabDebugBtn');
    $output[] = $this->elements->addTabBtn('Listeners (<span class="numListeners">'.$this->countListeners().'</span>)', 'javascript:skynetControlPanel.switchTab(\'tabListeners\');', 'tabListenersBtn');
    $output[] = $this->elements->addSectionEnd();     
    return implode($output);
  }

 /**
  * Counts and Renders listeners
  *
  * @return string HTML code
  */ 
   public function countListeners()
   {
     return $this->listenersRenderer->countListeners().'/'.$this->listenersRenderer->countLoggers();     
   }
 
 /**
  * Renders errors
  *
  * @return string HTML code
  */    
  public function renderErrors($ajax = false)
  {
    /* Center Main : Left Column: errors */   
    $errors_class = null;
    if(count($this->errorsFields) > 0) 
    {
       $errors_class = 'error';
    }  
    
    $output = [];
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionClass('tabErrors');
    }
    $output[] = $this->elements->beginTable('tblErrors');
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Errors ('.count($this->errorsFields).')', $errors_class));
    $output[] = $this->debugParser->parseErrorsFields($this->errorsFields);
    $output[] = $this->elements->endTable();
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionEnd(); 
    }
    
    return implode($output);   
  }  
  
 /**
  * Renders states
  *
  * @return string HTML code
  */    
  public function renderStates($ajax = false)
  {
    $output = [];   
    
    /* Center Main : Left Column: states */
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionClass('tabStates');
    }
    $output[] = $this->elements->beginTable('tblStates');
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('States ('.count($this->statesFields).')'));
    $output[] = $this->renderMonits();
    $output[] = $this->elements->addHeaderRow2('Sender', 'State');
    $output[] = $this->debugParser->parseStatesFields($this->statesFields);
    $output[] = $this->elements->endTable();
    if(!$ajax)
    {      
      $output[] = $this->elements->addSectionEnd();  
    }
    
    return implode($output);   
  }
  
 /**
  * Renders listeners debug
  *
  * @return string HTML code
  */    
  public function renderListeners($ajax = false)
  {
    $output = [];   
    
    /* Center Main : Left Column: states */
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionClass('tabListeners');
    }
    
    $output[] = $this->listenersRenderer->render();
    
    if(!$ajax)
    {      
      $output[] = $this->elements->addSectionEnd();  
    }
    
    return implode($output);   
  }
  
 /**
  * Renders debug
  *
  * @return string HTML code
  */    
  public function renderDebug($ajax = false)
  {
    $output = [];   
    
    /* Center Main : Left Column: states */
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionClass('tabDebug');
    }
    
    $output[] = $this->elements->beginTable('tblStates');
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Debugger ('.$this->debugger->countDebug().')'));    
    $output[] = $this->elements->addHeaderRow2('File/line', 'Debug');    
    $output[] = $this->debugParser->parseDebugFields($this->debugger->getData());
    $output[] = $this->elements->endTable();
    if(!$ajax)
    {      
      $output[] = $this->elements->addSectionEnd();  
    }
    
    return implode($output);   
  }
 
 /**
  * Renders config
  *
  * @return string HTML code
  */    
  public function renderConfig($ajax = false)
  {
    $output = [];
    
    /* Center Main : Left Column: Config */
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionClass('tabConfig');
    }
    $output[] = $this->elements->beginTable('tblConfig');
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Config ('.count($this->configFields).')'), 3);
    $output[] = $this->elements->addHeaderRow3('Option', 'Value', 'Key');    
    $output[] = $this->debugParser->parseConfigFields($this->configFields);
    $output[] = $this->elements->endTable();
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionEnd(); 
    }
    
    return implode($output);   
  }   
  
 /**
  * Renders errors
  *
  * @return string HTML code
  */    
  public function renderConsoleDebug($ajax = false)
  {
    $output = [];
    $this->consoleRenderer->setListenersOutput($this->consoleOutput);
    
     /* If console input */
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionClass('tabConsole');
    }
    
    $output[] = $this->elements->addSectionId('consoleDebug');  
    $output[] = $this->elements->beginTable('tblConfig');   
    $output[] = $this->consoleRenderer->renderConsoleInput();
    $output[] = $this->elements->endTable();
    $output[] = $this->elements->addSectionEnd(); 
   
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionEnd();   
    }     
    
    return implode($output);   
  }

 /**
  * Renders warns
  *
  * @return string HTML code
  */    
  public function renderWarnings($ajax = false)
  {
    $output = [];
    
    /* Empty password warning */
    if(!$this->auth->isPasswordGenerated())
    {
      $output[] = $this->elements->addBold('SECURITY WARNING: ', 'error').$this->elements->addSpan('Access password is not set yet. Use [pwdgen.php] to generate your password and place generated password into [/src/SkynetUser/SkynetConfig.php]', 'error').$this->elements->getNl().$this->elements->getNl();
    }
    
    /* Default ID warning */
    if(!$this->verifier->isKeyGenerated())
    {
      $output[] = $this->elements->addBold('SECURITY WARNING: ', 'error').$this->elements->addSpan('Skynet ID KEY is empty or set to default value. Use [keygen.php] to generate new random ID KEY and place generated key into [/src/SkynetUser/SkynetConfig.php]', 'error');
    }
    
    return implode($output);   
  }
  
 /**
  * Renders mode
  *
  * @return string HTML code
  */    
  private function renderMode()
  {   
    $output = [];
    
    $output[] = $this->elements->addSectionClass('innerMode panel');
    $output[] = $this->elements->addSectionClass('hdrConnection');
    $output[] = $this->modeRenderer->render();
    $output[] = $this->elements->addSectionEnd();
    $output[] = $this->elements->addSectionEnd(); 
    
    return implode($output);   
  }
  
 /**
  * Renders warns
  *
  * @return string HTML code
  */    
  public function renderClusters($ajax = false)
  {
    $this->clustersRenderer->setClustersData($this->clustersData);
    $output = [];
    
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionClass('innerAddresses panel');  
    }      
    $output[] = $this->elements->beginTable('tblClusters');
    $output[] = $this->clustersRenderer->render();    
    $output[] = $this->elements->endTable();   
    if(!$ajax)
    {
      $output[] = $this->elements->addSectionEnd(); 
    }      
    
    return implode($output);   
  }

 /**
  * Renders warns
  *
  * @return string HTML code
  */    
  private function renderConsole()
  {
    $output = [];
    
    $output[] = $this->elements->addSectionClass('sectionConsole');   
    $output[] = $this->consoleRenderer->renderConsole();
    $output[] = $this->elements->addSectionEnd();  
    
    return implode($output);   
  }   
  
 /**
  * Renders and returns debug section
  *
  * @return string HTML code
  */     
  public function render()
  {
    $this->modeRenderer->setConnectionMode($this->connectionMode);
    $this->clustersRenderer->setClustersData($this->clustersData);
     
    $output = [];     
     
    /* Center Main : Left Column */
    $output[] = $this->elements->addSectionClass('columnDebug');      
    
      $output[] = $this->elements->addSectionClass('sectionStatus');       
      
        $output[] = $this->elements->addSectionClass('sectionAddresses');  
        $output[] = $this->renderMode();    
        $output[] = $this->renderClusters();    
        $output[] = $this->elements->addSectionEnd(); 
        
        
        $output[] = $this->elements->addSectionClass('sectionStates');   
        
          $output[] = $this->elements->addSectionClass('innerStates panel');    
          $output[] = $this->renderWarnings();      
          $output[] = $this->renderTabs();    
          $output[] = $this->renderErrors();
          $output[] = $this->renderConsoleDebug();
          $output[] = $this->renderStates();
          $output[] = $this->renderConfig(); 
          $output[] = $this->renderDebug();  
          $output[] = $this->renderListeners();          
          $output[] = $this->elements->addSectionEnd();     
          
        /* end sectionStates */
        $output[] = $this->elements->addSectionEnd(); 
        
        $output[] = $this->elements->addClr();     
       
      /* end sectionStatus */
      $output[] = $this->elements->addSectionEnd();     
      
      $output[] = $this->renderConsole();   

    /* Center Main : Left Column: END */  
    $output[] = $this->elements->addSectionEnd(); 
    
    return implode('', $output);
  } 
}

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlSummaryRenderer.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer Summary Renderer
  *
  */
class SkynetRendererHtmlSummaryRenderer
{     
  /** @var string[] HTML elements of output */
  private $output = [];   
  
  /** @var SkynetRendererHtmlDebugParser Debug Renderer */
  private $debugParser;
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();    
    $this->debugParser = new SkynetRendererHtmlDebugParser();
  }  

 /**
  * Parses fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */   
  public function renderService($fields)
  {
    $aryService = ['My address', 'Chain', 'Skynet Key ID', 'Sleeped'];
    $aryServiceClasses = ['My address', 'sumChain', 'Skynet Key ID', 'sumSleeped'];
        
    $this->output = [];
    $this->output[] = $this->elements->beginTable('tblService');
    $this->output[] = $this->parseFields($fields, $aryService, $aryServiceClasses);
    $this->output[] = $this->elements->endTable();
    return implode($this->output);   
  }

  
 /**
  * Parses fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function renderServer($fields)
  {
    $arySummary = ['Cluster IP', 'Your IP', 'Encryption', 'Connections'];
    $arySummaryClasses = ['sumClusterIP', 'sumYourIP', 'sumEncryption', 'sumConnections'];
    
    $this->output = [];
    $this->output[] = $this->elements->beginTable('tblService');
    $this->output[] = $this->parseFields($fields, $arySummary, $arySummaryClasses);
    $this->output[] = $this->elements->endTable();
    return implode($this->output);   
  }
  
 /**
  * Parses fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function renderSummary($fields)
  {
    $arySummary = ['Broadcasting Clusters', 'Clusters in DB', 'Connection attempts', 'Succesful connections'];
    $arySummaryClasses = ['sumBroadcasted', 'sumClusters', 'sumAttempts', 'sumSuccess'];
    
    $this->output = [];
    $this->output[] = $this->elements->beginTable('tblSummary');
    $this->output[] = $this->parseFields($fields, $arySummary, $arySummaryClasses);
    $this->output[] = $this->elements->endTable();
    return implode($this->output);   
  }
  
 /**
  * Parses assigned custom fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function parseFields($fields, $ary, $aryClasses)
  {
    $rows = [];  
    $i = 0;
    foreach($ary as $field)
    {
      if(array_key_exists($field, $fields))
      {
        $value = $fields[$field]->getValue(); 
        if($value === true)
        {
          $value = '<span class="yes">YES</span>';
        } elseif($value === false)
        {
          $value = '<span class="no">NO</span>';
        }
        
        $rows[] = $this->elements->addValRow($this->elements->addBold($fields[$field]->getName()), '<span class="'.$aryClasses[$i].'">'.$value.'</span>');
      }
      $i++;
    }    
    return implode('', $rows);
  }
}

/**
 * Skynet/Renderer/Html/SkynetRendererHtmlThemes.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderer HTML Themes
  */
class SkynetRendererHtmlThemes
{    
  /** @var string[] Array of themes CSS's */
  private $css = [];
  
  /** @var string[] Theme names */
  private $availableThemes = [];
  

 /**
  * Constructor
  */
  public function __construct()
  { 
    $this->availableThemes['dark'] = 'Dark';    
    
    $this->css['light'] = '    
    html, body { font-family: Verdana, Arial; font-size: 0.8rem; line-height: 1.4; } 
    textarea { padding:5px; width:100%; height:300px; } 
    ';
    
    $this->css['dark'] = '    
    html, body { background: #000; color: #bdd3bf; font-family: Verdana, Arial; font-size: 0.7rem; height: 98%; line-height: 1.4; min-width:1040px; }    
    b { color:#87b989; } 
    h2 { color: #5ba15f; } 
    h3 { color:#4f8553; margin:0; } 
    a { color: #eef6ef; text-decoration: none; } 
    a:hover { color: #fff; text-decoration: underline; } 
    hr { height: 1px;  color: #222e22;  background-color: #222e22;  border: none; }
    textarea { padding:5px; width:100%; height:90%; background: #000; color: green; }
    select, input {  font-family: Verdana, Arial; font-size: 0.8rem; background: #000; color: #9ed4a2; }
    select:hover, input:hover {  color: #fff; }
    
    table { font-size:1.0em; width:100%; max-width:100%; table-layout: fixed; }
    td { border-bottom: 1px solid #313c33; padding:2px; word-wrap: break-word; }
    th { color: #707070; font-weight: bold; text-align:left; }
    tr:hover { background:#0c0c0c; color: #fff; } 
    tr:hover a {  } 
    tr:hover th { background:#000; }
    
    #wrapper { width: 100%; height: 100%; word-wrap: break-word; }
    #header { height: 10%; min-height:70px; }
    #headerLogo { float:left; width:40%; max-height:100%; }
    #headerSwitcher { float:right; width:58%; max-height:100%; text-align:right; padding:5px; padding-right:20px; }   
    #authMain { text-align: center; }    
    #dbSwitch { height: 10%; max-height:56px; min-height:56px; width:100%; overflow:auto; }
    #dbRecords { height: 80%; max-height:80%; overflow:auto; }    
    #console { width: 100%; height: 15%; }    
    #loginSection { text-align:center; margin: auto; font-size:1.2rem; }
    #loginSection input[type="password"] { width:400px; }
    
    .formConnectionDataOptions { padding:0; margin:0; line-height:1.2; }
    .formViews { padding:0; margin:0; }
    
    .debugListenerMy { color: #3ffb6e; }    
    .debuggerField { padding:5px; background:#fff; color: #000; font-size:1.2rem; }
    
    .main { height: 90%; }
    .dbTable { table-layout: auto; }
    .columnDebug { float:left; width:58%; height:100%; max-height:100%; overflow:auto; }
    .columnConnections { float:right; width:40%; height:100%; max-height:100%; overflow:auto; padding-left:5px; padding-right:5px; }    
    
    .monits { padding:8px; font-size:1.1em; border: 1px solid #d7ffff; background:#03312f; }    
    .monitOK { padding:8px; font-size:1.1em; border: 1px solid #d7ffff; color: #32c434; background:#113112; text-align:center; }
    .monitError { padding:8px; font-size:1.1em; border: 1px solid #fdf6f7; color:#df888a; background:#4c1819; text-align:center; }
    
    .reconnectArea { font-size:0.8rem; }
    .reconnectArea input { width: 30px; }
    .hide { display:none; }
    .panel { }
    
    .sectionAddresses { width:50%; float:left; height:100%; max-height:100%; }
    .sectionStates { width:50%; float:right; height:100%; max-height:100%; }
    
    .innerAddresses { width:99%; height:90%; max-height:90%; overflow-y:auto; }
    .innerMode { width:100%; height:10%; max-height:24px; overflow-y:auto; }
    .innerStates { width:98%; height:100%; max-height:100%; overflow-y:auto; } 
    .innerConnectionsOptions { width:100%; height:5%; max-height:5%; min-height:38px; overflow-y:auto; }
    .innerConnectionsData { width:100%; height:95%; max-height:95%; overflow-y:auto; }
    
    .hdrLogo { width:15%; height:100%; max-height:100%; max-width:284px; min-width:284px; float:left; overflow-y:auto; }
    .hdrColumn1 { width:25%; height:100%; max-height:100%; float:left; overflow-y:auto; }
    .hdrColumn2 { width:15%; height:100%;  max-height:100%; float:left; overflow-y:auto; }
    .hdrColumn3 { width:15%; height:100%; max-height:100%; float:left; overflow-y:auto; }    
    .hdrSwitch { width:25%; height:100%; max-height:100%; float:right; overflow-y:auto; text-align:right; }
    .hdrConnection { margin-top:5px; font-size: 1.0rem; }
    .hdrConnection .active { background-color: #3ffb6e; color: #000; }
    
    .tabsHeader { border-bottom:1px solid #2e2e2e;  padding-top: 20px; padding-bottom:8px; }
    .tabsHeader a { font-size:1.1em; background: #2e2e2e; padding: 5px; margin-top:8px; margin-bottom:8px; }
    .tabsHeader a.active { background:#fff; color: #000; }
    
    .tabStates { display:block; }
    .tabConsole { display:none; }
    .tabConfig { display:none; }
    .tabErrors { display:none; }
    .tabConsole { display:none; }
    .tabDebug { display:none; }
    .tabListeners { display:none; }
    
    .tdClusterStatus { width:10%; }
    .tdClusterUrl { width:60%; }
    .tdClusterPing { width:10%; }
    .tdClusterConn { width:20%; }
    .tblSummary, .tblService, .tblStates, .tblConfig, .tblClusters { table-layout:auto; }
    .tblSummary .tdKey { width:80%; } .tblSummary .tdValue { width:20%; text-align:right }
    .tblService .tdKey { width:40%; } .tblService .tdValue { width:60%; text-align:right }
    .tblStates .tdKey { width:15%; } .tblStates .tdValue { width:85%; }
    
    .statusIcon { padding: 1px; }
    .statusConnected { background: #3ffb6e; }    
    .statusError { background: red; }
    .statusIdle, .statusSingle, .statusBroadcast { padding:3px; }
    .modeButtons a { background:#09270b; border: 1px solid silver; }
    .modeButtons a:hover { text-decoration:none; border: 1px solid #fff; }
    
    .dbTitle { text-align:center; }
    
    a.btn { background:#1c281d; border:1px solid #48734f; padding-left:5px; padding-right:5px; color:#fff; }
    a.btn:hover { background:#3ffb6e; color:#000; }
    
    .tdFormKey { width:20%; vertical-align:middle; text-align:center; }
    .tdFormVal { width:80%; vertical-align:top; }
    .tdFormVal textarea { width:100%; height:150px; }
    .tdFormActions { vertical-align:middle; text-align:center; }
    
    .sectionStatus { height:75%; max-height:75%; overflow-y:auto; }
    .sectionConsole { height:20%; max-height:20%; }
    .tdKey { width:30%; }
    .tdVal { width:70%; }
    .tdActions { width:150px; }
    .tdHeader { border:0px; padding-top:10px; }
    .marked { color: #5ba15f; } 
    .exception { color: #ae3516; }
    .exception b { color: red; }
    .error { color: red; }
    .yes { color: green; font-weight:bold; }
    .no { color: #ae3516; }
    .viewActive { color: #40ff40; }    
    .genLink:hover { color: #fff; }
    .formConnections { padding-top:30px }
    .sendBtn { background: #50ea59; color: #000;}
    .sendBtn:hover { background: #89f190; color: #000;}
    .aSwitch, .btnNormal { border:1px solid #2a2a2a; padding:3px; background:#1e1e1e; }
    .btnNormal b { color:#a4ce9c; }
    .btnNormal:hover b { color: #fff; }
    .aSwitch:hover, .btnNormal:hover { border:1px solid #b5b5b5; background: #2a2a2a; padding:3px; text-decoration:none; color: #fff}
    .btnDelete, .aLogout { background:#fde1ea; border:1px solid red; padding:3px; color:black; }
    .btnDelete:hover, .aLogout:hover { background:red; border:1px solid red; padding:3px; color:black; text-decoration:none; }
    .btnDelete b, .aLogout b { color: #831c15; }
    .btnDelete:hover b, .aLogout:hover b { color: #fff; text-decoration:none;}
    .clr { clear: both; }
    .loginForm { padding-top:100px; }
    .logo { font: normal normal 1.2rem \'Trebuchet MS\',Trebuchet,sans-serif; color:#fff; margin-top:0; margin-bottom:0; }  
    ';
  }    

 /**
  * Returns theme CSS
  *
  * @param string $name Theme name
  *
  * @return string CSS 
  */
  public function getTheme($name)
  {
    return $this->css[$name];
  }
  
 /**
  * Returns available themes names
  *
  * @return string[] Themes names
  */
  public function getAvailableThemes()
  {
    return $this->availableThemes;
  }
}

/**
 * Skynet/Renderer/SkynetRenderersFactory.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Renderers Factory
  *
  * Factory for renderers.
  */
class SkynetRenderersFactory
{
  /** @var SkynetRendererInterface[] Array of renderers */
  private $renderersRegistry = [];

  /** @var SkynetRendererInterface Choosen renderer instance */
  private $renderer;

  /** @var SkynetRenderersFactory Instance of this */
  private static $instance = null;

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}

 /**
  * Registers renderer classes in registry
  */
  private function registerRenderers()
  {
    $this->register('html', new SkynetRendererHtml());
    $this->register('cli', new SkynetRendererCli());
  }

 /**
  * Returns choosen renderer from registry
  *
  * @param string $name
  *
  * @return SkynetRendererInterface Renderer
  */
  public function getRenderer($name = null)
  {
    if($name === null)
    {
      $name = SkynetConfig::get('core_renderer');
    }
    if(is_array($this->renderersRegistry) && array_key_exists($name, $this->renderersRegistry))
    {
      return $this->renderersRegistry[$name];
    }
  }

 /**
  * Registers renderer in registry
  *
  * @param string $id name/key of renderer
  * @param SkynetRendererInterface $class New instance of renderer class
  */
  private function register($id, SkynetRendererInterface $class)
  {
    $this->renderersRegistry[$id] = $class;
  }

 /**
  * Returns instance
  *
  * @return SkynetRenderersFactory
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
      self::$instance->registerRenderers();
    }
    return self::$instance;
  }
}

/**
 * Skynet/Secure/SkynetAuth.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Authentication
  */
class SkynetAuth
{   
  /** @var Skynet SkynetRendererHtmlThemes Themes Container*/
  private $themes;
  
  /** @var string CSS Stylesheet */
  private $css;
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetCli CLI Console */
  private $cli;
  
 /**
  * Constructor
  */
  public function __construct()
  {
    if(!isset($_SESSION))
    {
      session_start();
    }
    $this->themes = new SkynetRendererHtmlThemes();
    $this->css = $this->themes->getTheme(SkynetConfig::get('core_renderer_theme'));
    $this->elements = new SkynetRendererHtmlElements();    
    $this->verifier = new SkynetVerifier();  
    $this->cli = new SkynetCli();    
    
    if(!$this->verifier->isPing() && isset($_REQUEST['_skynetLogout']))
    {
      $this->doLogout();
    }
  }
  
 /**
  * Returns login form
  *
  * @param string $error Error msg to show
  *
  * @return HTML code
  */ 
  private function showLoginForm($error = null)
  {    
    $form = '<form method="post" class="loginForm">Enter password: <input autofocus type="password" name="_skynetPassword" required/><input type="submit" value="Login to Skynet" />
    <input type="hidden" name="_skynetDoLogin" value="1" /></form>';    
    
    $output = [];
    $output[] = $this->elements->addHeader();
    $output[] = $this->elements->addSectionId('authMain');
    $output[] = $this->elements->addSkynetHeader();     
    $output[] = $this->elements->addSectionId('loginSection');
    
    if($error !== null)
    {
      $output[] = $this->elements->getNl().$this->elements->addBold($error, 'error').$this->elements->getNl();
    }
    
    $output[] = $form;
    $output[] = $this->elements->addSectionEnd();
    $output[] = $this->elements->addSectionEnd();
    $output[] = $this->elements->addFooter();
    echo implode($output);
    //exit;
  }

 /**
  * Checks if user login is correct
  *
  * @param string $pwd Skynet saved password
  * @param string $userPwd User requested password
  *
  * @return bool True if passwords match
  */ 
  private function checkLogin($pwd, $userPwd)
  {
    if(password_verify($userPwd, $pwd))
    {
      return true;
    } 
  }

 /**
  * Authorizes user
  *
  * @param string $pwd Correct password
  */   
  private function doLogin($pwd)
  {
    $token = sha1(substr($pwd, -10, 10));
    
    $_SESSION['_skynetLogged'] = 1;
    $_SESSION['_skynetToken'] = $token;    
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;    
  }

 /**
  * Logouts and destroys session
  */  
  private function doLogout()
  {
    $_SESSION['_skynetLogged'] = null;
    $_SESSION['_skynetToken'] = null;  
    session_destroy();
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;    
  }
  
 /**
  * Checks if password is set
  * 
  * @return bool True if set
  */   
  public function isPasswordGenerated()
  {
     if(!empty(SkynetConfig::PASSWORD))
     {
       return true;
     }    
  }
  
 /**
  * Checks if user is authorizes
  * 
  * @return bool True if authorized
  */ 
  public function isAuthorized()
  {     
    if(!$this->isPasswordGenerated() || $this->cli->isCli())
    {
      return true;
    }
    $neededToken = sha1(substr(SkynetConfig::PASSWORD, -10, 10));
    if(isset($_SESSION['_skynetLogged']) && $_SESSION['_skynetLogged'] == 1 && isset($_SESSION['_skynetToken']) && strcmp($_SESSION['_skynetToken'], $neededToken) === 0)
    {
      return true; 
    }    
  }
  
 /**
  * Checks if user authorized and displays login form if not
  *
  * @return bool True if authorized
  */
  public function checkAuth()
  {
    $pwd = SkynetConfig::PASSWORD;
    $userPwd = null;
    $error = null;
    
    if(empty($pwd))
    {
      return true;
      
    } else {
      
      if($this->isAuthorized())
      {
        return true;
      }
      
      if(isset($_POST['_skynetDoLogin']) && isset($_POST['_skynetPassword']) && !empty($_POST['_skynetPassword']))
      {
        $userPwd = $_POST['_skynetPassword'];
        if($this->checkLogin($pwd, $userPwd))
        {
          if($this->doLogin($pwd))
          {
            return true;
          } else {
            $error = 'Error occured';
          }
          
        } else {
          $this->verifier->saveAccessLogs(array('ACCESS TO SKYNET PANEL' => 'INCORRECT PASSWORD'));
          $error = 'Password incorrect';
        }        
      }     
      $this->showLoginForm($error);      
    }
  }  
}

/**
 * Skynet/Secure/SkynetVerifier.php
 *
 * Checking and veryfing access to skynet
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Verifier
  *
  * Verification and validation
  */
class SkynetVerifier
{
  /** @var string Remote cluster key */
  private $requestKey;
  
  /** @var string Remote cluster hash */
  private $requestHash;
  
  /** @var string Remote request sender */
  private $requestSenderUrl;

  /** @var string This cluster key */
  private $packageKey;

  /** @var SkynetEncryptorInterface Data encryptor */
  private $encryptor;
  
  /** @var SkynetRequest Request instance */
  private $request;
  
  /** @var string Checksum */
  private $checksum;
  
  /** @var SkynetDebug Debugger */
  private $debug;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $this->packageKey = SkynetConfig::KEY_ID;    
    $this->debug = new SkynetDebug();
  }
  
 /**
  * Returns hashed key
  *
  * @param SkynetRequest $request Request object
  */
  public function assignRequest(SkynetRequest $request)
  {
    $this->request = $request;
  }  
  
 /**
  * Returns hashed key
  *
  * @return string Hashed Skynet Key ID
  */
  public function getKeyHashed()
  {
    return password_hash(SkynetConfig::KEY_ID, PASSWORD_BCRYPT);    
  }
  
 /**
  * Checks for skynetID key exists in request
  *
  * @return bool True if exists
  */
  private function isRequestKey()
  {
    if(isset($_REQUEST['_skynet_id']) && !empty($_REQUEST['_skynet_id'])) 
    {
      return true;
    }
  }
 
 /**
  * Checks for request sender URL
  *
  * @return bool True if exists
  */
  private function isRequestSenderUrl()
  {
    if(isset($_REQUEST['_skynet_sender_url']) && !empty($_REQUEST['_skynet_sender_url'])) 
    {
      if(SkynetConfig::get('core_raw'))
      {
        $this->requestSenderUrl = $_REQUEST['_skynet_sender_url'];
      } else {
        $this->requestSenderUrl = $this->encryptor->decrypt($_REQUEST['_skynet_sender_url']);
      }
      
      return true;
    }
  }
  
 /**
  * Checks for hsh
  *
  * @return bool True if exists
  */
  private function isRequestHash()
  {
    if(isset($_REQUEST['_skynet_hash']) && !empty($_REQUEST['_skynet_hash'])) 
    {   
      if(SkynetConfig::get('core_raw'))
      {
        $this->requestHash = $_REQUEST['_skynet_hash'];
      } else {
        $this->requestHash = $this->encryptor->decrypt($_REQUEST['_skynet_hash']);
      } 
      
      return true;
    }
  }
  
/**
  * Checks for checksum exists in request
  *
  * @return bool True if exists
  */
  private function isChecksum()
  {
    if(isset($_REQUEST['_skynet_checksum']) && !empty($_REQUEST['_skynet_checksum'])) 
    {
      return true;
    }    
  }

 /**
  * Sets checksum from request
  *
  * @return bool True if exists
  */  
  private function getChecksum()
  {
    if(SkynetConfig::get('core_raw'))
    {
      $this->checksum = $_REQUEST['_skynet_checksum'];
    } else {
      $this->checksum = $this->encryptor->decrypt($_REQUEST['_skynet_checksum']);
    }   
  }
  
 /**
  * Generates MD5 checksum from request fields
  *
  * @param string[] $requests Array with requests
  *
  * @return string Generated MD5 checksum
  */  
  public function generateChecksum($requests)
  {
    $data = '';
    if(is_array($requests))
    {
      foreach($requests as $k => $v)
      {
        if($k != '_skynet_checksum')
        {
          $data.= $v;
        }
      }      
    }
    
    $sum = md5($data); 
    if(SkynetConfig::get('core_raw'))
    {
      return $sum;
    } else {
      return $this->encryptor->encrypt($sum);    
    }
  }
 
 /**
  * Checks IP from whitelist
  *
  * @return bool True if have access
  */ 
  public function hasIpAccess()
  {
    $ips = SkynetConfig::get('core_connection_ip_whitelist');
    $myIp = SkynetHelper::getRemoteIp();
    
    if(is_array($ips) && count($ips) > 0)
    {
      if(!in_array($myIp, $ips))
      {
        return false;
      }
    }
    return true;
  } 
 
 /**
  * Checks data integrity
  *
  * @param string $mode Request or response
  *
  * @return bool True if checksums OK.
  */ 
  public function verifyChecksum($mode = 'request')
  {
    $data = '';
    if($this->isChecksum())
    {
      $this->getChecksum();
    }       
    
    if($this->checksum !== null && !empty($this->checksum))
    {
      if(isset($_REQUEST) && count($_REQUEST) > 1)
      {      
        foreach($_REQUEST as $k => $v)
        {
          if($k != '_skynet_checksum')
          {
            if(SkynetConfig::get('core_raw'))
            {
              $data.= $v;
            } else {
              $data.= $v;
            }  
          }         
        } 
        $sum = md5($data);        
        if(strcmp($sum, $this->checksum) === 0)
        {
          return true;
        }
      }     
    } 
  }

 /**
  * Checks for keys pass
  * 
  * @param string $remoteKey Remote hashed key
  *
  * @return bool True if valid
  */  
  public function isMyKey($remoteKey)
  {
    if(password_verify($this->packageKey, $remoteKey))
    {
      return true;
    }    
  }
  
 /**
  * Validates skynetID key from request
  *
  * If requested key not match with my key then return false
  *
  * @param string $key Requested key
  *
  * @return bool True if valid
  */
  public function isRequestKeyVerified($key = null, $sender = false, SkynetResponse $response = null)
  {
    $success = false;    
    
    if($this->isRequestKey() || $key !== null)
    {
      if($key !== null)
      {
        $this->requestKey = $key;

      } elseif(SkynetConfig::get('core_raw'))
      {
        $this->requestKey = $_REQUEST['_skynet_id'];

      } else {
        $this->requestKey = $this->encryptor->decrypt($_REQUEST['_skynet_id']);
      }
      
      /* Verify when responder gets request */
      if($this->isMyKey($this->requestKey))
      {        
        if(!$sender && $this->isRequestHash() && $this->isRequestSenderUrl())
        {
          $strToVerify = $this->requestSenderUrl.$this->packageKey;
          if(password_verify($strToVerify, $this->requestHash))
          {
            if(strcmp(SkynetHelper::getMyUrl(), $this->requestSenderUrl) !== 0)
            {
              $success = true;
            }
          }
          
        /* Verify when sender receives response */
        } elseif($sender) 
        {
          if($response !== null)
          {
            $responseData = $response->getResponseData();
            if(isset($responseData['_skynet_cluster_url']) && isset($responseData['_skynet_hash']) && !empty($responseData['_skynet_cluster_url']) && !empty($responseData['_skynet_hash']))
            {
              $strToVerify = $responseData['_skynet_cluster_url'].$this->packageKey;
              if(password_verify($strToVerify, $responseData['_skynet_hash']))
              {
                if(strcmp(SkynetHelper::getMyUrl(), $responseData['_skynet_cluster_url']) !== 0)
                {                  
                  $success = true;
                }
              }
            }
          }
        }
      }     
      
      if($success === true)
      {       
        return true;        
      } else {         
        if($this->isPing())
        {
          $this->saveAccessLogs();
        }
      }         
    }    
  }

 /**
  * Generates hash
  *
  * @return string Hash
  */
  public function generateHash()
  {
    $url = SkynetHelper::getMyUrl();    
    $str = $url.SkynetConfig::KEY_ID;    
    $hashed = password_hash($str, PASSWORD_BCRYPT);
    return $hashed;
  }

 /**
  * Checks for cluster URL address is correct
  *
  * @param string $address URL to checkdate
  *
  * @return bool True if exists
  */
  public function isAddressCorrect($address)
  {
    if(!empty($address) && preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $address) && $address != 'http://'.SkynetHelper::getMyUrl() && $address != 'https://'.SkynetHelper::getMyUrl())
    {
      return true;
    }
  }

 /**
  * Checks if open sender (always send requests)
  *
  * @return bool True if open sender
  */
  public function isOpenSender()
  {
    if(SkynetConfig::get('core_open_sender'))
    {
      return true;
    }
  }
  
 /**
  * Checks if user IP is on white list
  *
  * @return bool True if have access
  */
  public function hasAdminIpAddress()
  {
    $ips = SkynetConfig::get('core_admin_ip_whitelist');
    $myIp = SkynetHelper::getRemoteIp();
    
    if(is_array($ips) && count($ips) > 0)
    {
      if(!in_array($myIp, $ips))
      {
        return false;
      }
    }
    return true;
  }
  
 /**
  * Checks if Skynet is not under another Skynet connection
  *
  * @return bool True if is another connection
  */
  public function isPing()
  {
    if(isset($_REQUEST['_skynet_cluster_url']) && isset($_REQUEST['_skynet']))
    {
      return true;
    }
  }
 
 /**
  * Checks if Skynet connects from client
  *
  * @return bool True if is client connection
  */
  public function isClient()
  {
    if(isset($_REQUEST['_skynet_cluster_url']) && isset($_REQUEST['_skynet']) && isset($_REQUEST['_skynet_client']))
    {
      return true;
    }
  }
  
 /**
  * Checks if Skynet requests for code
  *
  * @return bool True if request for code
  */
  public function isUpdateRequest()
  {
    if(isset($_REQUEST['@code']))
    {
      return true;
    }
  }
  
 /**
  * Checks if Skynet has opened database view
  *
  * @return bool True if is another connection
  */
  public function isDatabaseView()
  {
    if(isset($_REQUEST['_skynetView']) && $_REQUEST['_skynetView'] == 'database')
    {
      return true;
    }
  }
  
 /**
  * Checks env for CLI
  *
  * @return bool True if in console
  */ 
  public function isCli()
  {
    if(defined('STDIN'))
    {
       return true;
    }

    if(php_sapi_name() === 'cli')
    {
       return true;
    }

    if(array_key_exists('SHELL', $_ENV)) 
    {
       return true;
    }

    if(empty($_SERVER['REMOTE_ADDR']) and !isset($_SERVER['HTTP_USER_AGENT']) and count($_SERVER['argv']) > 0) 
    {
       return true;
    } 

    if(!array_key_exists('REQUEST_METHOD', $_SERVER))
    {
       return true;
    }

    return false;
  }

 /**
  * Checks for parameter is internal Skynet core param
  *
  * @param string $key Key to check
  *
  * @return bool True if internal param
  */
  public function isInternalParameter($key)
  {
     if(strpos($key, '_skynet') === 0 || strpos($key, '_skynet') === 1)
     {
       return true;
     }
  }

 /**
  * Checks for parameter is internal echo Skynet core param
  *
  * @param string $key Key to check
  *
  * @return bool True if internal echo param
  */
  public function isInternalEchoParameter($key)
  {
     if(strpos($key, '@_skynet') === 0)
     {
       return true;
     }
  }
  
 /**
  * Checks if KEY is set
  * 
  * @return bool True if set
  */   
  public function isKeyGenerated()
  {
     if(!empty(SkynetConfig::KEY_ID) && SkynetConfig::KEY_ID != '1234567890')
     {
       return true;
     }    
  }
  
 /**
  * Saves access logs
  *
  * @param string[] $request Array with requests
  */ 
  public function saveAccessLogs($request = null)
  {
    if($request === null && isset($_REQUEST))
    {
      $request = $_REQUEST;
    }
    if(SkynetConfig::get('logs_txt_access_errors'))
    {
      $this->saveAccessErrorInLogFile($request);
    }
    if(SkynetConfig::get('logs_db_access_errors'))
    {
      $this->saveAccessErrorInDb($request);   
    }   
  }
  
 /**
  * Save access error in file
  *
  * @param string[] $requestAry Array with requests
  *
  * @return bool
  */ 
  private function saveAccessErrorInLogFile($requestAry = null)
  {
    $fileName = 'access';
    $logFile = new SkynetLogFile('UNAUTHORIZED ACCESS');
    $logFile->setFileName($fileName);
    $logFile->setTimePrefix(false);
    $logFile->setHeader("#UNAUTHORIZED ACCESS ERRORS:");    
    $time_prefix = '@'.date('H:i:s d.m.Y').' ['.time().']: ';
    $data = implode('; ', $requestAry);    
    
    if($requestAry === null && $this->request !== null)
    {
      $requestAry = $this->request->getRequestsData();
    }
    
    $remote_host = '';
    $remote_cluster = '';
    $request_uri = '';
    $remote_ip = '';
    if(isset($_SERVER['REMOTE_ADDR']))
    {
       $request_uri = $_SERVER['REQUEST_URI'];
    }
    if(isset($_SERVER['REMOTE_ADDR']))
    {
       $remote_ip = $_SERVER['REMOTE_ADDR'];
    }    
    if(isset($_SERVER['REMOTE_HOST']))
    {
      $remote_host = $_SERVER['REMOTE_HOST'];
    }
    if(isset($requestAry['_skynet_cluster_url'])) $remote_cluster = $requestAry['_skynet_cluster_url'];
    
    $logFile->addLine($time_prefix.' {');  
    $logFile->addLine('@REMOTE_CLUSTER_URL: '.$remote_cluster); 
    $logFile->addLine('@REQUEST URI: '.$request_uri);    
    $logFile->addLine('@REMOTE_CLUSTER_HOST: '.$remote_host);
    $logFile->addLine('@REMOTE_CLUSTER_UP: '.$remote_ip);
    $logFile->addLine('#RAW REQUEST:');
    foreach($requestAry as $k => $v)
    {
      $logFile->addLine(' '.$k.': '.$v);  
    }
    $logFile->addLine('}');     
    $logFile->addLine();
    return $logFile->save('after');
  }
 
 /**
  * Save access error in database
  *
  * @param string[] $requestAry Array with requests
  *
  * @return bool
  */  
  private function saveAccessErrorInDb($requestAry = null)
  {
    $db = SkynetDatabase::getInstance()->getDB();
    if($requestAry === null && $this->request !== null)
    {
      $requestAry = $this->request->getRequestsData();
    }
    
    $rawRequest = '';
    foreach($requestAry as $k => $v)
    {
      $rawRequest = $k.'='.$v.';';
    }
    
    try
    {
      $stmt = $db->prepare(
        'INSERT INTO skynet_access_errors (skynet_id, created_at, request, remote_cluster, request_uri, remote_host, remote_ip)
        VALUES(:skynet_id, :created_at, :request, :remote_cluster, :request_uri, :remote_host, :remote_ip)'
        );
      $time = time();
      $remote_host = '';
      $remote_cluster = '';
      $request_uri = '';
      $remote_ip = '';
      if(isset($_SERVER['REMOTE_ADDR']))
      {
         $request_uri = $_SERVER['REQUEST_URI'];
      }
      if(isset($_SERVER['REMOTE_ADDR']))
      {
         $remote_ip = $_SERVER['REMOTE_ADDR'];
      }    
      if(isset($_SERVER['REMOTE_HOST']))
      {
        $remote_host = $_SERVER['REMOTE_HOST'];
      }
      if(isset($requestAry['_skynet_cluster_url'])) $remote_cluster = $requestAry['_skynet_cluster_url'];
      $skynet_id = SkynetConfig::KEY_ID;    
      
      $stmt->bindParam(':skynet_id', $skynet_id, \PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $time, \PDO::PARAM_INT);
      $stmt->bindParam(':request', $rawRequest, \PDO::PARAM_STR);
      $stmt->bindParam(':remote_cluster', $remote_cluster, \PDO::PARAM_STR);
      $stmt->bindParam(':request_uri', $request_uri, \PDO::PARAM_STR);
      $stmt->bindParam(':remote_host', $remote_host, \PDO::PARAM_STR);
      $stmt->bindParam(':remote_ip', $remote_ip, \PDO::PARAM_STR);
      if($stmt->execute())
      {
        return true;
      }    
    } catch(\PDOException $e)  
    {  
      $this->addError(SkynetTypes::PDO, 'DB SAVE ACCESS ERROR: '.$e->getMessage(), $e);
    }
  }
}

/**
 * Skynet/SkynetLauncher.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Main Launcher 
  */
class SkynetLauncher
{  
  /** @var Skynet Skynet Sender and controller */
  public $skynet;
  
  /** @var SkynetResponder Skynet Responder */
  public $skynetService;
  
 /**
  * Constructor
  *
  * @param bool $startSender Autostarts Skynet Sender
  * @param bool $startResponder Autostarts Skynet Responder
  *
  * @return Skynet
  */
  public function __construct($startSender = false, $startResponder = false)
  {
    $this->skynet = new Skynet($startSender);
    $this->skynetService = new SkynetResponder($startResponder);       
  }
  
  public function __toString()
  {
    return (string)$this->skynet->renderOutput(); 
  }
}

/**
 * Skynet/SkynetVersion.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Version and website info
  */
class SkynetVersion
{
  /** @var string version */
   const VERSION = '1.2.0';
   
   /** @var string build */
   const BUILD = '2017.04.29';
   
   /** @var string website */
   const WEBSITE = 'https://github.com/szczyglinski/skynet';
   
   /** @var string blog */
   const BLOG = 'https://skynetframework.blogspot.com';
}

/**
 * Skynet/State/SkynetState.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet State
  *
  * Stores internal information about state
  */
class SkynetState
{
  /** @var integer Code */
  private $code;

  /** @var string Message */
  private $msg;

  /** @var integer State/connect ID */
  private $stateId;
  

 /**
  * Constructor
  *
  * @param integer $code State Code
  * @param string $msg State Message
  */
  public function __construct($code, $msg)
  {
    $this->code = $code;
    $this->msg = $msg;
  }

 /**
  * Sets global statesID
  *
  * @param integer $id
  */
  public function setStateId($id)
  {
    $this->stateId = $id;
  }

 /**
  * Sets state code
  *
  * @param integer $code
  */
  public function setCode($code)
  {
    $this->code = $code;
  }

 /**
  * Sets state message
  *
  * @param string $msg
  */
  public function setMsg()
  {
    $this->msg = $msg;
  }

 /**
  * Returns state code
  *
  * @return integer
  */
  public function getCode()
  {
    return $this->code;
  }

 /**
  * Returns stateID
  *
  * @return integer
  */
  public function getStateId()
  {
    return $this->stateId;
  }

 /**
  * Returns state message
  *
  * @return string
  */
  public function getMsg()
  {
    return $this->msg;
  }

 /**
  * Returns state as string
  *
  * @return string
  */
  public function __toString()
  {
    $id = '';
    if($this->stateId !== null) $id = '[@'.$this->stateId.'] ';
    return '<b>'.$id.$this->code.'</b>: '.$this->msg;
  }
}

/**
 * Skynet/State/SkynetStatesRegistry.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet States Registry
  *
  * Registry stores all states generates by Skynet
  */
class SkynetStatesRegistry
{
  /** @var SkynetState[] Array of states */
  protected $states = [];

  /** @var SkynetStatesRegistry Instance of this */
  private static $instance = null;

 /**
  * Constructor (private)
  */
  protected function __construct() {}

 /**
  * __clone (private)
  */
  protected function __clone() {}

 /**
  * Returns instance of this
  *
  * @return SkynetStatesRegistry
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
    }
    return self::$instance;
  }

 /**
  * Adds state to registry
  *
  * @param SkynetState $state
  */
  public function addState(SkynetState $state)
  {
    $this->states[] = $state;
  }

 /**
  * Returns stored states
  *
  * @return SkynetState[]
  */
  public function getStates()
  {
    return $this->states;
  }

 /**
  * Checks for states exists in registry
  *
  * @return bool True if are states
  */
  public function areStates()
  {
    if(count($this->states) > 0) return true;
  }
} 

/**
 * Skynet/Tools/SkynetCompiler.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */
 
 

 /**
  * Standalone version compiler
  */   
class SkynetCompiler
{
  /** @var string Sources root dir */
  private $srcDir = 'src';
  
  /** @var string Output dir */
  private $compileDir = '_compiled';
  
  /** @var string Output file name */
  private $fileName = 'skynet';
  
  /** @var string Suffix for output file */
  private $suffix;
  
  /** @var string Output file extension */
  private $ext = 'php';
  
  /** @var string[] Sources list */
  private $sourcesList = [];
  
  /** @var string[] Sources content */
  private $sourcesFiles = [];
  
  /** @var string[] Sources paths */
  private $paths = [];
  
  /** @var string[] Elements to remove */
  private $replaceWith = [];
  
  /** @var bool Sets removing comments */
  private $removeComments = false;
  
  /** @var string New line in generated file */
  private $nl1 = "\r\n";
  
  /** @var string New line in status */
  private $nl2 = "<br>";

 /**
  * Constructor
  */  
  public function __construct()
  {
    $this->suffix = '_'.time();
  }

 /**
  * Resursively loads source files list
  *
  * @param string $folder Directory to get file list
  * @param string $pattern Pattern
  *
  * @return string[] Files list
  */  
  private function rsearch($folder, $pattern) 
  {
    $dir = new \RecursiveDirectoryIterator($folder);
    $ite = new \RecursiveIteratorIterator($dir);
    $files = new \RegexIterator($ite, $pattern, \RegexIterator::GET_MATCH);
    $fileList = array();
    foreach($files as $file) 
    {
        $fileList = array_merge($fileList, $file);
    }   
    return $fileList;
  }

 /**
  * Loads source files content
  */   
  private function loadClasses()
  {
    $path1 = $this->srcDir.'/SkynetUser/';
    $dir1 = $this->rsearch($path1, '/.*.php/');  
    
    $path2 = $this->srcDir.'/Skynet/';
    $dir2 = $this->rsearch($path2, '/.*.php/');   
    
    $dir = array_merge($dir1, $dir2);
    
    $srcClasses = [];
    $srcAbstract = [];
    $srcInterface = [];
    $srcTrait = [];   
    $srcConfig = [];
    
    $configClass = null;
    foreach($dir as $file)
    {
      $this->paths[] = $file;
      $className = str_replace(array($path1, $path2), '', $file);
      $this->sourcesList[] = $file;
      
      if(strpos($className, 'Abstract.php') !== false)
      {
        $srcAbstract[$className] = trim(file_get_contents($file));
      } elseif(strpos($className, 'Interface.php') !== false)
      {
        $srcInterface[$className] = trim(file_get_contents($file));
      } elseif(strpos($className, 'Trait.php') !== false)
      {
        $srcTraits[$className] = trim(file_get_contents($file));
      } elseif(strpos($className, 'Config.php') !== false)
      {
        $srcConfig[$className] = trim(file_get_contents($file));
      } else {
        $srcClasses[$className] = trim(file_get_contents($file));
      }      
    } 
    
    $this->sourcesFiles = array_merge($srcConfig, $srcAbstract, $srcInterface, $srcTraits, $srcClasses);
  } 
 
 /**
  * Generates array with directives to replace
  */   
  public function generateReplace()
  {
    $files = [];
    $files[] = 'Skynet';
    $files[] = 'SkynetUser';
    
    $replaceUse = [];
    $replaceNamespace = [];
    $replacePrefix = [];
    
    foreach($this->paths as $file)
    {
      $files[] = str_replace(array('src/', '.php', '/'), array('', '', '\\'), $file);      
    }
    
    foreach($files as $file)
    {
      $replaceUse[] = 'use '.$file.';';
      
      $namespace = 'namespace '.pathinfo($file, PATHINFO_DIRNAME).';';
      if(!in_array($namespace,  $replaceNamespace)) 
      {
        $replaceNamespace[] = $namespace;
      }
      $ns = pathinfo($file, PATHINFO_DIRNAME);
      if($ns != '.' && !in_array($ns.'\\', $replacePrefix))
      {
        $replacePrefix[] = '\\'.$ns.'\\';      
        $replacePrefix[] = $ns.'\\';         
      }
    }
    
    $this->replaceWith = array_merge($replaceUse, $replaceNamespace, $replacePrefix);
  }

 /**
  * Sets sources dir
  *
  * @param string $srcDir Sources root dir
  */    
  public function setSrcDir($srcDir)
  {
    $this->srcDir = $srcDir;
  }

 /**
  * Sets new line char in compiled file
  *
  * @param string $char New line
  */    
  public function setNl1($char)
  {
    $this->nl1 = $char;
  }  
 
 /**
  * Sets new line char in status output
  *
  * @param string $char New line
  */    
  public function setNl2($char)
  {
    $this->nl2 = $char;
  }
  
 /**
  * Sets output file name
  *
  * @param string $fileName Output compiled file name
  */    
  public function setFileName($fileName = 'skynet')
  {
    $this->fileName = $fileName;
  }
 
 /**
  * Sets suffix for output file
  *
  * @param string $suffix Suffix
  */   
  public function setSuffix($suffix)
  {
    $this->suffix = $suffix;
  }

 /**
  * Sets extension for output file
  *
  * @param string $ext Extension for file
  */    
  public function setExt($ext = 'php')
  {
    $this->ext = $ext;
  }
 
 /**
  * Sets destination dir for compile
  *
  * @param string $compileDir Output dir
  */   
  public function setCompileDir($compileDir = '_compiled')
  {
    $this->compileDir = $compileDir;
  }

 /**
  * Strips new lines
  *
  * @param string $src Source string
  *
  * @return string Parsed string
  */    
  private function stripNewLines($src)
  {
    $src = str_replace("\r\n", "\n", $src);
    $src = str_replace("\n\n\n", "\n", $src);    
    $src = str_replace("\n\n", "\n", $src);      
    return $src;
  }
  
 /**
  * Strips DOCBLOCK comments
  *
  * @param string $src Source string
  *
  * @return string Parsed string
  */   
  private function stripDocBlock($src)
  {   
    $src = preg_replace('#/\*[^*]*\*+([^/][^*]*\*+)*/#', '', $src);     
    return $src;
  }

 /**
  * Parse and replace code
  *
  * @param string $name Class name
  * @param string $src Source 
  *
  * @return string Parsed string
  */    
  private function parseSrc($name, $src)
  {
    $eraseArray = ['', ''];
    $src = str_replace($this->replaceWith, '', $src);
    $src = str_replace($eraseArray, '', $src); 
    $src = str_replace('\\', '', $src);
    $src = str_replace('\\', '', $src);
    
    $src = preg_replace('/(\r?\n){2,}/', "\n\n", $src);
    
    if($this->removeComments) 
    {
      $src = $this->stripDocBlock($src);
      $src = $this->stripNewLines($src);
      $src = $this->nl1."/* ".$name." */".$src;
    }
    return $src;
  }
 
 /**
  * Generates compiled file body
  *
  * @param string $src Source string
  *
  * @return string Parsed string
  */   
  private function generateStandalone($src)
  {     
    $header = " ".$this->nl1.$this->nl1."/* Skynet Standalone | version compiled: ".date('Y.m.d H:i:s')." (".time().") */".$this->nl1.$this->nl1."".$this->nl1;
    $code = $this->nl1."\$skynet = new SkynetLauncher(true, true);".$this->nl1."echo \$skynet;";
    $src = $header.$src.$code;
    return $src;
  }

 /**
  * Compiles standalone
  *
  * @param string $mode HTML or CLI
  *
  * @return string Status
  */    
  public function compile($mode = 'html')
  {
    if($mode == 'cli')
    {
      $this->setNl2("\n");
    }
    
    $this->loadClasses();    
    $this->generateReplace();
    
    $compiledSource = '';    
    $i = 1;         
    
    foreach($this->sourcesFiles as $className => $classCode)
    {
      $compiledSource.= $this->parseSrc($className, $classCode);    
      echo $i.') Compiling: '.$className.$this->nl2;
      $i++;
    } 
    
    if(!empty($compiledSource))
    {
      $dir = '';
      if(!empty($this->compileDir)) 
      {
        $dir = $this->compileDir.'/';
      }
      
      if(!is_dir($dir))
      {
        if(!mkdir($dir))
        {
          return false;
        }
      }
      
      $newFileName = $dir.$this->fileName.$this->suffix. '.' .$this->ext;
      if(file_put_contents($newFileName, $this->generateStandalone($compiledSource))) 
      {
        return 'Compiled '.count($this->sourcesList).' classes.'.$this->nl2.'Standalone Skynet is ready: '.$newFileName;          
      }        
    }
  }
} 

/**
 * Skynet/Tools/SkynetKeyGen.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */
 
 

 /**
  * Standalone KEY ID generator
  */   
class SkynetKeyGen
{  

 /**
  * Constructor
  */  
  public function __construct()
  {
    
  }
  
 /**
  * Generates key
  *
  * @return string Generated Skynet KEY ID
  */    
  public function generate()
  {
    $rand = rand(0,99999);
    $key = sha1(time().$rand);    
    return $key;
  }

 /**
  * Generates key
  *
  * @param string $mode HTML or CLI
  *
  * @return string Generated Skynet KEY ID
  */   
  public function show($mode = 'cli')
  {
    $output = '';
    switch($mode)
    {
      case 'html':
        $output = '<h1>'.$this->generate().'</h1>Place generated key into const <b>KEY_ID</b> in <b>/src/SkynetUser/SkynetConfig.php</b> configuration file.</br>Refresh (F5) page to generate another key.';
      break;
      
      
      case 'cli':
        $output = "\n===================\nKEY: ".$this->generate()."\n===================\nPlace generated key into const KEY_ID into 'src/Skynet/SkynetConfig.php' file.\nRelaunch script to generate another key.";
      break;      
    }    
    return $output;
  }
} 

/**
 * Skynet/Tools/SkynetPwdGen.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */
 
 

 /**
  * Standalone password hash generator
  */   
class SkynetPwdGen
{  

 /**
  * Constructor
  */  
  public function __construct()
  {
    
  }
  
 /**
  * Generates key
  *
  * @param string $password Plain password
  *
  * @return string Generated hash
  */    
  public function generate($password)
  {    
    return password_hash($password, PASSWORD_BCRYPT);
  }

 /**
  * Generates hash
  *
  * @param string $mode HTML or CLI
  *
  * @return string Generated Skynet password hash
  */   
  public function show($mode = 'html')
  {
    $output = '';
    $typeHtml = '<h1>Password hash generator</h1><form method="post">Type your password as plain text and click on GENERATE: <input type="text" name="pwd"><input type="submit" value="GENERATE"></form>';
    $typeCli = 'Type your password as argument';
    
    switch($mode)
    {
      case 'html':
        if(isset($_POST['pwd']) && !empty($_POST['pwd']))
        {
          $output = 'Generated hash for password <b>'.$_POST['pwd'].'</b>: <h2>'.$this->generate($_POST['pwd']).'</h2>Place generated password hash into const <b>PASSWORD</b> in <b>/src/SkynetUser/SkynetConfig.php</b> configuration file.<hr>'.$typeHtml;
        } else {
          $output = $typeHtml;
        }
      break;
      
      
      case 'cli':
        $c = $_SERVER['argc']; 
        $pwdIndex = $c - 1;
        if($c > 1 && !empty($_SERVER['argv'][$pwdIndex]))
        {
           $output = "\nGenerated hash for password [".$_SERVER["argv"][$pwdIndex]."]: >>> ".$this->generate($_SERVER["argv"][$pwdIndex])." <<< \nPlace generated password hash into const PASSWORD in /src/SkynetUser/SkynetConfig.php configuration file.\n\n";
        } else {
           $output = $typeCli;
        }
      break;      
    }
    return $output;
  }
}

/**
 * Skynet/Updater/SkynetUpdater.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

 /**
  * Skynet Updater
  *
  * Self-updater engine
  */
class SkynetUpdater
{
  use SkynetErrorsTrait, SkynetStatesTrait;
   
   /** @var SkynetVerifier SkynetVerifier instance */
   protected $verifier;

 /**
  * Constructor
  */
   public function __construct()
   {    
     $this->verifier = new SkynetVerifier();
     $this->showSourceCode();
   }

 /**
  * Generates PHP code of Skynet standalone file and shows it
  */
   private function showSourceCode()
   {
     if(isset($_REQUEST['@code']))
     {
        $encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
        
        if(!$this->verifier->isRequestKeyVerified())
        {
          $request = "\r\n";
          foreach($_REQUEST as $k => $v)
          {
            $request.= $k.'='.$encryptor->decrypt($v)."\r\n";
          }
          
          $this->addError(SkynetTypes::VERIFY, 'SELF-UPDATER: UNAUTHORIZED REQUEST FOR SOURCE CODE FROM: '.$_SERVER['REMOTE_HOST'].$_SERVER['REQUEST_URI'].' IP: '.$_SERVER['REMOTE_ADDR'].$request);
          exit;
          return false;
        }
      
        $ary = [];
        $file = @file_get_contents(SkynetHelper::getMyBasename());
        
        $ary['version'] = SkynetVersion::VERSION;
        $ary['code'] = $file;
        $ary['checksum'] = md5($file);
        
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($ary);
        exit;
     }
   }
}
$skynet = new SkynetLauncher(true, true);
echo $skynet;