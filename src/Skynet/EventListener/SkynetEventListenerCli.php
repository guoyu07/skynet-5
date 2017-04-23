<?php

/**
 * Skynet/EventListener/SkynetEventListenerCli.php
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

use Skynet\Console\SkynetConsole;
use Skynet\Console\SkynetCli;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;
use Skynet\Tools\SkynetCompiler;
use Skynet\Tools\SkynetKeyGen;
use Skynet\Tools\SkynetPwdGen;

 /**
  * Skynet Event Listener - CLI
  *
  * Gets requests from CLI
  */
class SkynetEventListenerCli extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{ 
  /** @var bool Status of input */
  private $inputReceived = false;

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
    $this->console = new SkynetConsole();
    $this->cli = new SkynetCli();
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
      if(($this->auth->isAuthorized() && $this->console->isInput()) || $this->cli->isCli())
      {       
        if(!$this->inputReceived)
        {
          if(!$this->cli->isCli())
          {
            /* HTML console */
            $this->console->parseConsoleInput($_REQUEST['_skynetCmdConsoleInput']);
            $this->inputReceived = true;
          } else {
            
            /* CLI */
            if($this->cli->isCommand('send'))
            {
              $cliParams = $this->cli->getParam('send');
              if(!empty($cliParams))
              {
                $this->console->parseConsoleInput($cliParams);
                $this->inputReceived = true;
              }
            } else {
              return false;
            }
          }
        }
        /* get data from console */
        $commands = $this->console->getConsoleCommands();
        $requests = $this->console->getConsoleRequests();       
        
        /* add param requests */
        if(count($requests) > 0)
        {          
           /* assign data to request */
           foreach($requests as $request)
           {
              foreach($request as $k => $v)
              {
                $this->request->set($k, $v);
              }         
           }            
        } 

        /* add command requests */
        if(count($commands) > 0)
        {          
           /* assign data to request */
           foreach($commands as $command)
           {
              $cmdName = '@'.$command->getCode();
              $params = $command->getParams();              
              $this->request->set($cmdName, $params); 
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
       echo $this->response->get('@cipka');
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
    /* if compile */
    if($this->cli->isCommand('compile'))
    {       
      $compiler = new SkynetCompiler;
      return $compiler->compile('cli');
    }
    
    /* if keygen */
    if($this->cli->isCommand('keygen'))
    { 
      $keyGen = new SkynetKeyGen;    
      return $keyGen->show('cli');
    }
    
    /* if pwdgen */
    if($this->cli->isCommand('pwdgen'))
    { 
      $pwdGen = new SkynetPwdGen;    
      return $pwdGen->show('cli');
    }
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
    
    $cli[] = ['-debug', '', 'Displays connections full debug'];
    $cli[] = ['-dbg', '', 'Displays connections full debug (alias)'];
    $cli[] = ['-cfg', '', 'Displays configuration'];
    $cli[] = ['-status', '', 'Displays status'];
    $cli[] = ['-out', ['field', 'field1, field2...'], 'Displays only specified fields returned from response'];
    $cli[] = ['-connect', 'address', 'Connects to single specified address'];
    $cli[] = ['-c', 'address', 'Connects to single specified address (alias)'];
    $cli[] = ['-broadcast', '', 'Broadcasts all addresses (starts Skynet)'];
    $cli[] = ['-b', '', 'Broadcasts all addresses (starts Skynet) (alias)'];
    $cli[] = ['-send', '"request params"', 'Sends request from command line, see documentation for syntax'];
    $cli[] = ['-db', 'table name', '[optional: page sortByColumn ASC', 'DESC Displays logs records from specified table in database'];
    $cli[] = ['-db', 'table name -del record ID', 'Erases record from database table'];     
    $cli[] = ['-db', 'table name -truncate', 'Erases ALL RECORDS from database table'];  
    $cli[] = ['-help', '', 'Displays this help'];
    $cli[] = ['-h', '', 'Displays this help (alias)'];
    $cli[] = ['-pwdgen', 'your password', 'Generates new password hash from plain password'];
    $cli[] = ['-keygen', '', 'Generates new SKYNET ID KEY'];
    $cli[] = ['-compile', '', 'Compiles Skynet sources to standalone file'];
    
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