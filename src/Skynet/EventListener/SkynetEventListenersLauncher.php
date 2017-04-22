<?php

/**
 * Skynet/EventListener/SkynetEventListenersLauncher.php
 *
 * @package Skynet
 * @version 1.1.1
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.1
 */

namespace Skynet\EventListener;

use Skynet\EventListener\SkynetEventListenersFactory;
use Skynet\EventLogger\SkynetEventLoggersFactory;
use Skynet\Common\SkynetHelper;

 /**
  * Skynet Event Listeners Launcher
  *
  */
class SkynetEventListenersLauncher
{     
  /** @var string[] HTML elements of output */
  private $request;
  private $response; 
  private $connectId; 
  private $clusterUrl;
  private $cli;
  private $console;
  private $eventListeners;
  private $eventLoggers;

 /**
  * Constructor
  */
  public function __construct()
  {
   $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
   $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();
  }  
  
  public function assignRequest($request)
  {
    $this->request = $request;
  }
  
  public function assignResponse($response)
  {
    $this->response = $response;
  }
  
  public function assignConnectId($connectId)
  {
    $this->connectId = $connectId;
  }
  
  public function assignClusterUrl($clusterUrl)
  {
    $this->clusterUrl = $clusterUrl;
  }
  
  public function assignCli($cil)
  {
    $this->cil = $cil;
  }
  
  public function assignConsole($console)
  {
    $this->console = $console;
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
}