<?php

/**
 * Skynet/EventListener/SkynetEventListenerFiles.php
 *
 * @package Skynet
 * @version 1.1.3
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
        
        $params = $this->request->get('@fget')[0];
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
        if(isset($params[0]['path']) && !empty($params[0]['path']))
        {
           $file = $params[0]['path'];
        } else {
           $result = 'NO PATH IN PARAM';
           $this->response->set('@<<fputStatus', $result);  
           return false;
        }  
        
        $result = 'TRYING';
        $data = null;
        if(isset($params[1]['data']))
        {
          $data = $params[1]['data'];
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
          $this->response->set('@<<fgetStatus', $result);  
          return false;
        }      
        
        $params = $this->request->get('@fdel')[0];
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
          if(@unlink($file))
          {
            $result = 'FILE DELETED: '.$file;           
          } else {
            $result = 'FILE NOT DELETED: '.$file;
          }
        } else {
          $result = 'FILE NOT EXISTS: '.$file;
        }
        $this->response->set('@<<fgetStatus', $result);  
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
      if($this->response->get('@<<fgetFile') !== null)
      {
        $dir = '_download';
        if(!is_dir($dir))
        {
          if(!@mkdir($dir))
          {
            $this->addError('FGET', 'MKDIR ERROR: '.$dir);  
            return false;
          } 
        }
        
        $fileName = time().'_'.str_replace(array("\\", "/"), "-", $this->response->get('@<<fgetFile'));
        if(!@file_put_contents($dir.'/'.$fileName, $this->response->get('@<<fgetData')))
        {
          $this->addError('FGET', 'FILE SAVE ERROR: '.$dir.'/'.$fileName);       
        } else {
          $this->addState('FGET', 'FILE SAVED: '.$dir.'/'.$fileName);     
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
    $console[] = ['@fget', 'path:/path/to', ''];
    $console[] = ['@fput', 'path:/path/to,data:data_to_save', '']; 
    $console[] = ['@fdel', 'path:/path/to', ''];    
    
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