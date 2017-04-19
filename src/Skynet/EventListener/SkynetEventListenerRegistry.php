<?php

/**
 * Skynet/EventListener/SkynetEventListenerRegistry.php
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

use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;

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
          foreach($params as $param)
          {
            if(is_array($param))
            {
              foreach($param as $key => $value)
              {               
                if($this->reg_set($key, $value))
                {
                  $returnSuccess[] = $key;   
                } else {
                  $returnError[] = $key; 
                  $this->addError(SkynetTypes::REGISTRY, 'UPDATE ERROR: '.$key);                  
                }
              }              
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
   
    $console[] = ['@reg_set', ['key: value', 'key1: value1, key2: value2...'], 'no @to=TO ALL'];   
    $console[] = ['@reg_get', ['key', 'key1,key2, key3...'], 'no @to=TO ALL'];  
    
    return array('cli' => $cli, 'console' => $console);    
  }
}