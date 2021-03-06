<?php

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

namespace Skynet\EventLogger;

use Skynet\EventListener\SkynetEventListenerInterface;
use Skynet\EventListener\SkynetEventListenerAbstract;
use Skynet\Filesystem\SkynetLogFile;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;
use Skynet\SkynetVersion;

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
    if(!\SkynetUser\SkynetConfig::get('logs_txt_requests'))
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
    if(!\SkynetUser\SkynetConfig::get('logs_txt_responses'))
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
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
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
      if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
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
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
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
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
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
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->setHeader("@Broadcast From (sended to me from): ".$senderUrl);
      $logFile->setHeader("@Broadcast To (resended to): ".$receivers_urls);
      $logFile->addLine("URLS CHAIN: ".$urlsChainPlain);
    }
    $logFile->addSeparator();
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
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
      if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
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
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
    {
      $logFile->setHeader("@Self-update request From (sended to me from): ".$senderUrl);
    }
    $logFile->addLine("UPDATE LOG:");
    foreach($logs as $k => $v)
    {     
      $logFile->addLine($this->parseLine($k, $v));     
    }    
    
    $logFile->addSeparator();
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
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
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
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
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
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
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_internal_data') || $force)
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
      if(!\SkynetUser\SkynetConfig::get('logs_txt_include_secure_data'))
      {
        return false;
      }
    }
    
    if($key == '_skynet_cluster_url' || $key == '_skynet_sender_url' || $key == '@_skynet_cluster_url' || $key == '@_skynet_sender_url' || $key == '_skynet_clusters_chain' || $key == '@_skynet_clusters_chain')
    {
      if(!\SkynetUser\SkynetConfig::get('logs_txt_include_clusters_data'))
      {
        return false;
      }
    }
    
    return true;
  }
}