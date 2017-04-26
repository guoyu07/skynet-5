<?php

/**
 * Skynet/Renderer/Cli/SkynetRendererCli.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Renderer\Cli;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\Renderer\SkynetRendererAbstract;
use Skynet\Renderer\SkynetRendererInterface;
use Skynet\EventListener\SkynetEventListenersFactory;
use Skynet\EventLogger\SkynetEventLoggersFactory;
use Skynet\SkynetVersion;
use Skynet\Database\SkynetDatabase;
use Skynet\Database\SkynetDatabaseSchema;

 /**
  * Skynet CLI Output Renderer 
  */
class SkynetRendererCli extends SkynetRendererAbstract implements SkynetRendererInterface
{
  use SkynetErrorsTrait, SkynetStatesTrait;   
  

  /** @var string[] HTML elements of output */
  private $output = [];   
  
  /** @var SkynetRendererHtmlDebugRenderer Debug Renderer */
  private $debugRenderer;
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetRendererHtmlDatabaseRenderer Database Renderer */
  private $databaseRenderer;
  
  /** @var SkynetRendererHtmlConnectionsRenderer Connections Renderer */
  private $connectionsRenderer; 
  
  /** @var SkynetEventListenersInterface[] Array of Event Listeners */
  private $eventListeners = [];

  /** @var SkynetEventListenersInterface[] Array of Event Loggers */
  private $eventLoggers = [];

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct(); 
    
    $this->elements = new SkynetRendererCliElements();    
    $this->debugRenderer = new SkynetRendererCliDebugRenderer();
    $this->databaseRenderer = new  SkynetRendererCliDatabaseRenderer();
    $this->connectionsRenderer = new  SkynetRendererCliConnectionsRenderer();  
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();    
  }
  
 /**
  * Renders and returns debug section
  *
  * @return string Output string
  */     
  private function renderDebugSection()
  {
    $output = [];   
     
    /* Center Main : Left Column */
    $output[] = $this->elements->addSectionId('columnDebug');   

    /* Center Main : Left Column: summary */
    $output[] = $this->elements->addSubtitle('Summary');
    $output[] = $this->debugRenderer->parseFields($this->fields);

    /* Center Main : Left Column: errors */
    $output[] = $this->elements->addSeparator();    
   
    if(count($this->errorsFields) > 0)
    {
      $output[] = $this->elements->addSubtitle('Errors');
      $output[] = $this->debugRenderer->parseErrorsFields($this->errorsFields);
    }

    if($this->cli->haveArgs() && $this->cli->isCommand('status'))
    {
      /* Center Main : Left Column: states */
      $output[] = $this->elements->addSeparator();
      $output[] = $this->elements->addSubtitle('States');
      $output[] = $this->debugRenderer->parseStatesFields($this->statesFields);
    }

    if($this->cli->haveArgs() && $this->cli->isCommand('cfg'))
    {
      /* Center Main : Left Column: Config */
      $output[] = $this->elements->addSeparator();
      $output[] = $this->elements->addSubtitle('Config');
      $output[] = $this->debugRenderer->parseConfigFields($this->configFields);
    }
    
    return implode('', $output);
  }
  
 /**
  * Renders and returns connections view
  *
  * @return string Output string
  */    
  private function renderConnectionsSection()
  {
    $output = [];   
    /* Center Main : Right Column: */
    $output[] = $this->elements->addSectionId('columnConnections');         
    $output[] = $this->connectionsRenderer->renderConnections($this->connectionsData);
    $output[] = $this->elements->addSectionEnd();  
    return implode('', $output);      
  } 

 /**
  * Renders and returns header
  *
  * @return string Output string
  */ 
  private function renderHeaderSection()
  {
    $output = [];
    
    //$header = $this->elements->getNl().$this->elements->addH1('//\\\\ SKYNET v.'.SkynetVersion::VERSION);
    $header = $this->elements->getNl().'(c) 2017 Marcin Szczyglinski | Check for newest versions here: '.$this->elements->addUrl(SkynetVersion::WEBSITE);
    $header.= $this->elements->getNl();
    $output[] = $header;      
    return implode('', $output);
  }
  
 /**
  * Generates new password hash
  *
  * @return string Output string
  */
  public function renderPwdGen()
  {
    $params = $this->cli->getParams('pwdgen');
    if($params !== null && isset($params[0]) && !empty($params[0]))       
    {
      return $this->elements->getNl().'Password hash for "'.$params[0].'": '.password_hash($params[0], PASSWORD_BCRYPT).$this->elements->getNl().'(you can put this password hash into your SkynetConfig.php)';
    } else {
      return $this->elements->getNl().'Password string missing. Use: -pwdgen <your password> to generate hash';
    }    
  } 

 /**
  * Generates new Skynet ID Key
  *
  * @return string Output string
  */
  public function renderKeyGen()
  {
    $rand = rand(0,99999);   
    $key = sha1(time().md5($rand));
    return $this->elements->getNl().'New randomly generated SKYNET ID KEY: '.$key.$this->elements->getNl().'(you can put this ID Key into your SkynetConfig.php)';
  } 
  
 /**
  * Prepare listeners commands
  */  
  private function prepareListenersCommands()
  {
    $commands = [];    
    foreach($this->eventListeners as $listener)
    {
      $tmpCommands = $listener->registerCommands();      
      
      if(is_array($tmpCommands) && isset($tmpCommands['cli']) && is_array($tmpCommands['cli']))
      {
        foreach($tmpCommands['cli'] as $command)
        {
          $cmdName = '';
          $cmdDesc = '';
          $cmdParams = '';
          
          if(isset($command[0]))
          {
            $cmdName = $command[0];
          }
          
          if(isset($command[1]))
          {
            if(is_array($command[1]))
            {
              $params = [];
              foreach($command[1] as $param)
              {
                if(!empty($param))
                {
                  $params[] = '<'.$param.'>';
                }
              }              
              $cmdParams = ' '.implode(' or ', $params).' ';
            } else {
              
              if(!empty($command[1]))
              {
                $cmdParams = ' <'.$command[1].'> ';
              } else {
                $cmdParams = '';
              }
            }
          }
          
          if(isset($command[2]))
          {
            $cmdDesc = $command[2];
          }
          
          $commands[] = ' '.$cmdName.$cmdParams.' | '.$cmdDesc;                
        }
      }
    }   
    return $commands;
  }
  
 /**
  * Renders and returns commands helper
  *
  * @return string Output string
  */
  private function renderCommandsHelp()
  {
    $databaseSchema = new SkynetDatabaseSchema();
    $tables = ' [?] Database tables: '.implode(', ', array_flip($databaseSchema->getDbTables()));
    $listenersCommands = $this->prepareListenersCommands();
   
    $str = $this->elements->getSeparator()." [?] HELP: Commands list [you can put multiple params at once, separating by space]:".$this->elements->getSeparator().$this->elements->getNl();      
    $str.= implode($this->elements->getNl(), $listenersCommands);    
    $str.= $this->elements->getNl().$this->elements->getNl().$tables.$this->elements->getNl();
    
    return $str;
  }  
  
 /**
  * Renders ad commands
  *
  * @return string Output string
  */ 
  private function renderEndCommands()
  {
    $output = [];
    
    if($this->cli->haveArgs() && ($this->cli->isCommand('h') || $this->cli->isCommand('help')))
    {
      $output[] = $this->renderCommandsHelp();
    } else {
      $output[] = $this->elements->getSeparator().' [?] HELP: "php '.$_SERVER['argv'][0].' -h" OR "php '.$_SERVER['argv'][0].' -help" displays Skynet CLI commands list.';
    }
    
    return implode('', $output);   
  }
  
 /**
  * Renders and returns HTML output
  *
  * @return string Output string
  */
  public function render()
  {     
    $listenersOutput = implode($this->elements->getNl(), $this->cliOutput);    
    
    if(!$this->cli->haveArgs() || ($this->cli->haveArgs() && !$this->cli->isCommand('out')))
    {
      $this->output[] = $this->elements->addHeader();  

      /* Render header */
      $this->output[] = $this->renderHeaderSection();    
          
      switch($this->mode)
      {
        case 'connections':
           /* --- Center Main --- */      
           $this->output[] = $this->renderDebugSection();
           $this->output[] = $this->renderEndCommands();
           
           if($this->cli->haveArgs() && ($this->cli->isCommand('dbg') || $this->cli->isCommand('debug')))
           {
              $this->output[] = $this->renderConnectionsSection();
           } else {
             $this->output[] = $this->elements->getSeparator().$this->elements->getNl().'[RESULT] Executed connections to clusters: '.count($this->connectionsData);
           }
           $this->output[] = $this->elements->addSectionEnd();        
   
        break; 

        case 'database':
           /* --- Center Main --- */
           $this->output[] = $this->renderEndCommands();
           $this->output[] = $this->elements->addSectionId('dbRecords'); 
           $this->output[] = $this->databaseRenderer->renderDatabaseView();
           $this->output[] = $this->elements->addSectionEnd();
        break;
      }   
      /* Center Main : END */   
      
      $this->output[] = $listenersOutput;    

      $params = $this->cli->getParams('send');
      
      $this->output[] = $this->elements->addFooter();
      
    } else {
        $params = $this->cli->getParams('out');        
        if($params !== null && isset($params[0]))
        {
          $e = explode(',', $params[0]);
          $outputParams = [];
          if($e > 0)
          {
            foreach($e as $paramKey)
            {
              $outputParams[] = trim($paramKey);
            }            
          }          
          
          $this->output[] = $this->connectionsRenderer->renderConnections($this->connectionsData, $outputParams);         
        } else {
          $this->output[] = $this->connectionsRenderer->renderConnections($this->connectionsData, true);
        }
    }  
    
    return implode('', $this->output);
  } 
}