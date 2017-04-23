<?php

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

namespace Skynet\Console;

use Skynet\EventListener\SkynetEventListenersLauncher;
use Skynet\Common\SkynetHelper;
use Skynet\Secure\SkynetVerifier;
use Skynet\Secure\SkynetAuth;
use Skynet\Data\SkynetRequest;
use Skynet\Data\SkynetResponse;
use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Cluster\SkynetCluster;
use Skynet\Common\SkynetTypes;

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
    $this->eventListenersLauncher->assignConnectId($this->connectId);
    $this->eventListenersLauncher->assignClusterUrl($this->clusterUrl);
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