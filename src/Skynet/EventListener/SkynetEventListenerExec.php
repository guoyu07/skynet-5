<?php

/**
 * Skynet/EventListener/SkynetEventListenerExec.php
 *
 * @package Skynet
 * @version 1.1.4
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
  * Skynet Event Listener - Exec
  *
  * Skynet Exec & System
  */
class SkynetEventListenerExec extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
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
      /* exec() */
      if($this->request->get('@exec') !== null)
      {
        if(!isset($this->request->get('@exec')['cmd']))
        {
          $this->response->set('@<<exec', 'COMMAND IS NULL');
          return false;
        }
        $cmd = $this->request->get('@exec')['cmd'];
        $return = null;
        $output = [];                
        $result = @exec($cmd, $output, $return);
        $this->response->set('@<<execResult', $result);
        $this->response->set('@<<execReturn', $return); 
        $this->response->set('@<<execOutput', $output); 
        $this->response->set('@<<exec', $this->request->get('@exec')['cmd']);
      }

      /* shell_exec() */
      if($this->request->get('@shellexec') !== null)
      {
        if(!isset($this->request->get('@shellexec')['cmd']))
        {
          $this->response->set('@<<shellexec', 'COMMAND IS NULL');
          return false;
        }
        $cmd = $this->request->get('@shellexec')['cmd'];     
        $result = @exec($cmd);
        $this->response->set('@<<shellexecResult', $result); 
        $this->response->set('@<<shellexec', $this->request->get('@shellexec')['cmd']);
      }   

      /* system() */
      if($this->request->get('@system') !== null)
      {
        if(!isset($this->request->get('@system')['cmd']))
        {
          $this->response->set('@<<system', 'COMMAND IS NULL');
          return false;
        }
        $cmd = $this->request->get('@system')['cmd']; 
        $return = null;        
        $result = @system($cmd, $return);
        $this->response->set('@<<systemResult', $result);
        $this->response->set('@<<systemReturn', $return);        
        $this->response->set('@<<system', $this->request->get('@system')['cmd']);
      } 
      
      /* proc_open() */
      if($this->request->get('@proc') !== null)
      {
        if(!isset($this->request->get('@proc')['proc']))
        {
          $this->response->set('@<<proc', 'COMMAND IS NULL');
          return false;
        }
        
        $proc = $this->request->get('@proc')['proc']; 
        $return = null;   
        
        $descriptorspec = array(
            0 => array('pipe', 'r'), 
            1 => array('pipe', 'w'), 
            2 => array('pipe', 'w') 
        );

        $process = proc_open($proc, $descriptorspec, $pipes);

        if(is_resource($process)) 
        {   
          $result = stream_get_contents($pipes[1]);
          fclose($pipes[0]);
          fclose($pipes[1]);   
          fclose($pipes[2]);
          $return = proc_close($process);
        }
        
        $this->response->set('@<<procResult', $result);
        $this->response->set('@<<procReturn', $return);        
        $this->response->set('@<<proc', $this->request->get('@proc')['proc']);
      }  

      /* eval() */
      if($this->request->get('@eval') !== null)
      {
        if(!isset($this->request->get('@eval')['php']))
        {
          $this->response->set('@<<eval', 'PHP CODE IS NULL');
          return false;
        }
        $php = $this->request->get('@eval')['php'];     
        $result = @eval($php);
        $this->response->set('@<<evalReturn', $result); 
        $this->response->set('@<<eval', $this->request->get('@eval')['php']);
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
    $console[] = ['@exec', 'cmd:"commands_to_execute"', ''];     
    $console[] = ['@system', 'cmd:"commands_to_execute"', '']; 
    $console[] = ['@proc', 'proc:"proccess_to_open"', ''];
    $console[] = ['@eval', 'php:"code_to_execute"', 'no args=TO ALL'];    
    
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