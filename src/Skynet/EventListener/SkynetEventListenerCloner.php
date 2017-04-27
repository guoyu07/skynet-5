<?php

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

namespace Skynet\EventListener;

use Skynet\Filesystem\SkynetCloner;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;
use Skynet\Core\SkynetPeer;

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
        $monit.= implode('<br>', $cloned);
        
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
            $address = \SkynetUser\SkynetConfig::get('core_connection_protocol').$this->request->get('_skynet_sender_url');
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
    if($this->console->isConsoleCommand('clone') && \SkynetUser\SkynetConfig::get('core_cloner'))
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