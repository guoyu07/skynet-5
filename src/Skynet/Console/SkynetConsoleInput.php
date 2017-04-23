<?php

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
                //$this->console->clear();
                
                /* Launch Console commands listeners */
                $this->prepareListeners();
                $this->eventListenersLauncher->launch('onConsole');
                $this->consoleOutput[] = $this->eventListenersLauncher->getConsoleOutput();                  
                
              } elseif(is_string($param) && $param != 'all')
              {
                $this->startBroadcast = false;
                if($this->verifier->isAddressCorrect($param))
                {                 
                  $this->addresses[] = $param;
                }  
              } elseif(is_string($param) && $param == 'all')
              {
                $toAll = true;
              }
            }           
          }  
        }        
      } 
      if($toAll)
      {
        $this->startBroadcast = true;
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