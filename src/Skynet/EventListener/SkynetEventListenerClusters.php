<?php

/**
 * Skynet/EventListener/SkynetEventListenerClusters.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\EventListener;

use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Cluster\SkynetCluster;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;

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