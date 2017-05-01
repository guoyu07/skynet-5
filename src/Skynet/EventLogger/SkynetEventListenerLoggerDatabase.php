<?php

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

namespace Skynet\EventLogger;

use Skynet\Core\SkynetChain;
use Skynet\EventListener\SkynetEventListenerInterface;
use Skynet\EventListener\SkynetEventListenerAbstract;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;
use Skynet\SkynetVersion;

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
    if(\SkynetUser\SkynetConfig::get('db') && \SkynetUser\SkynetConfig::get('logs_db_requests')) 
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
    if(\SkynetUser\SkynetConfig::get('db') && \SkynetUser\SkynetConfig::get('logs_db_responses')) 
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
      if(\SkynetUser\SkynetConfig::get('logs_db_include_internal_data'))
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

      $sender = $this->senderClusterUrl;
      $receiver = $this->receiverClusterUrl;
      $skynet_id = '';
      $logInfo = '';

      if($context == 'beforeSend')
      {         
         $skynet_id = \SkynetUser\SkynetConfig::KEY_ID;
         $logInfo = 'to &gt;&gt; '.$receiver;         
      } else {        
         $skynet_id = $this->responseData['_skynet_id'];
         if($this->verifier->isMyKey($skynet_id))
         {
           $skynet_id = \SkynetUser\SkynetConfig::KEY_ID;
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
      if(\SkynetUser\SkynetConfig::get('logs_db_include_internal_data'))
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
             $skynet_id = \SkynetUser\SkynetConfig::KEY_ID;
           }
         }
         
      } else {        
         $skynet_id = \SkynetUser\SkynetConfig::KEY_ID;
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
      if(\SkynetUser\SkynetConfig::get('logs_db_include_internal_data'))
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
      $id = \SkynetUser\SkynetConfig::KEY_ID;
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
      if(\SkynetUser\SkynetConfig::get('logs_db_include_internal_data'))
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
      $id = \SkynetUser\SkynetConfig::KEY_ID;
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
      if(\SkynetUser\SkynetConfig::get('logs_db_include_internal_data'))
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
      $id = \SkynetUser\SkynetConfig::KEY_ID;
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
      $id = \SkynetUser\SkynetConfig::KEY_ID;
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