<?php

/**
 * Skynet/EventListener/SkynetEventListenersLauncher.php
 *
 * @package Skynet
 * @version 1.1.3
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
  private $connectId = 1; 
  private $clusterUrl;
  private $cli;
  private $console;
  private $eventListeners;
  private $eventLoggers;
  private $cliOutput = [];
  private $consoleOutput = [];
  private $sender = true;
  private $dbTables = [];

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
  
  public function assignCli($cli)
  {
    $this->cli = $cli;
  }
  
  public function assignConsole($console)
  {
    $this->console = $console;
  }
  
  public function getCliOutput()
  {
    return $this->cliOutput;
  }
  
  public function getConsoleOutput()
  {
    return $this->consoleOutput;
  }
  
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
          $listener->setConnId($this->connectId);
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
        }
      break;

      /* Launch before sending request */
      case 'onRequest':
        foreach($this->eventListeners as $listener)
        {
          $listener->setConnId($this->connectId);
          $listener->setSender($this->sender);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          $listener->setReceiverClusterUrl($this->clusterUrl);
          if(method_exists($listener, 'onRequest'))
          {
            $listener->onRequest('beforeSend');
          }
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
        }
      break;

      /* Launch after request listeners */
      case 'onRequestLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->setConnId($this->connectId);
          $listener->setSender($this->sender);
          $listener->assignRequest($this->request);
          $listener->assignResponse($this->response);
          $listener->setReceiverClusterUrl($this->clusterUrl);
          if(method_exists($listener, 'onRequest'))
          {
            $listener->onRequest('beforeSend');
          }
          $requests = $this->request->getRequestsData();
        }
      break;
      
      /* Launch when CLI */
      case 'onCli':
        foreach($this->eventListeners as $listener)
        {
          $listener->assignCli($this->cli);
          if(method_exists($listener, 'onCli'))
          {
            $output = $listener->onCli();
          }
          if($output !== null)
          {
            $this->cliOutput[] = $output;
          }
        }
      break;
      
      /* Launch when Console */
      case 'onConsole':
        foreach($this->eventListeners as $listener)
        {
          $listener->assignConsole($this->console);
          if(method_exists($listener, 'onConsole'))
          {
            $output = $listener->onConsole();
          }
          if($output !== null)
          {
            $this->consoleOutput[] = $output;
          }
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
          $listener->setConnId($this->connectId);
          $listener->setSender($this->sender);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) 
            && isset($requests['_skynet_sender_url']) 
            && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
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
        }
      break;

      /* Launch after receives request */
      case 'onRequest':
        foreach($this->eventListeners as $listener)
        {
          $listener->setConnId($this->connectId);
          $listener->setSender($this->sender);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) 
            && isset($requests['_skynet_sender_url']) 
            && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            if(method_exists($listener, 'onRequest'))
            {
              $listener->onRequest('afterReceive');
            }
          }
        }
      break;

      /* Launch after response listeners */
      case 'onResponseLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->setConnId($this->connectId);
          $listener->setSender($this->sender);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) 
            && isset($requests['_skynet_sender_url']) 
            && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
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
        }
      break;

      /* Launch after request listeners */
      case 'onRequestLoggers':
        foreach($this->eventLoggers as $listener)
        {
          $listener->setConnId($this->connectId);
          $listener->setSender($this->sender);
          $this->request->loadRequest();
          $listener->assignRequest($this->request);
          $this->response->parseResponse();
          $requests = $this->request->getRequestsData();
          $listener->setRequestData($requests);
          $listener->assignResponse($this->response);
          if(isset($requests['_skynet']) 
            && isset($requests['_skynet_sender_url']) 
            && $requests['_skynet_sender_url'] != SkynetHelper::getMyUrl())
          {
            if(method_exists($listener, 'onRequest'))
            {
              $listener->onRequest('afterReceive');
            }
          }
        }
      break;
    }
  }
}