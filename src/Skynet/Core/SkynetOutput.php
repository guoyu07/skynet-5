<?php

/**
 * Skynet/Core/SkynetOutput.php
 *
 * @package Skynet
 * @version 1.1.1
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.1
 */

namespace Skynet\Core;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\Error\SkynetException;
use Skynet\State\SkynetStatesTrait;
use Skynet\EventListener\SkynetEventListenersLauncher;
use Skynet\Common\SkynetHelper;
use Skynet\Secure\SkynetVerifier;
use Skynet\Core\SkynetChain;
use Skynet\Data\SkynetRequest;
use Skynet\Data\SkynetResponse;
use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Common\SkynetTypes;
use Skynet\Database\SkynetOptions;
use Skynet\Console\SkynetCli;
use Skynet\Secure\SkynetAuth;
use Skynet\Renderer\SkynetRenderersFactory;

 /**
  * Skynet Event Listeners Launcher
  *
  */
class SkynetOutput
{     
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var SkynetRequest Assigned request */
  private $request;
  
  /** @var SkynetResponse Assigned response */
  private $response; 
  
  /** @var integer Actual connection number */
  private $connectId = 0; 
  
  /** @var SkynetCli CLI Console */
  private $cli;
  
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;
  
  /** @var SkynetEventListenersLauncher Listeners Launcher */
  private $eventListenersLauncher;
  
  /** @var SkynetChain SkynetChain instance */
  private $skynetChain;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetCluster Actual cluster */
  private $cluster = null; 
  
  /** @var SkynetAuth Authentication */
  private $auth;
  
  /** @var SkynetCluster[] Array of clusters */
  private $clusters = [];
  
  /** @var bool Status od connection with cluster */
  private $isConnected = false;
  
  /** @var bool Status of broadcast */
  private $isBroadcast = false;  
  
  /** @var SkynetOptions Options getter/setter */
  private $options;
  
  /** @var integer Connections finished with success */
  private $successConnections;
  
  /** @var integer Actual connection in broadcast mode */
  private $broadcastNum;
  
  /** @var bool Controller for break connections if specified receiver set */
  private $breakConnections = false;
  
  /** @var string[] Array with connections debug */
  private $connectionData = [];
 
  /** @var string[] Array of monits */  
  private $monits = [];
  
  /** @var string[] Array of console outputs */
  private $consoleOutput;
  
  /** @var string[] Array of cli outputs */
  private $cliOutput;
  
  /** @var bool If true then ajax output */ 
  private $inAjax = false;

 /**
  * Constructor
  */
  public function __construct()
  { 
    $this->verifier = new SkynetVerifier();
    $this->clustersRegistry = new SkynetClustersRegistry();
    $this->skynetChain = new SkynetChain();
    $this->options = new SkynetOptions();
    $this->cli = new SkynetCli();
    $this->auth = new SkynetAuth();
  }  
  
 /**
  * Returns rendered output
  *
  * @return string Output
  */ 
  public function renderOutput()
  {
    if($this->cli->isCli())
    {
        $renderer = SkynetRenderersFactory::getInstance()->getRenderer('cli');
        
    } else {
        
        if(!$this->auth->isAuthorized())
        {
          if($this->verifier->isPing())
          {
            return '';
          } else {
            $this->auth->checkAuth();
            return '';
          }
        }        
        
        $renderer = SkynetRenderersFactory::getInstance()->getRenderer('html');
    }   
    
    $this->loadErrorsRegistry();
    $this->loadStatesRegistry();
    if($this->verifier->isPing()) 
    {
      return '';
    }
    
    $chainData = $this->skynetChain->loadChain();   
    
    /* assign monits */
    if(count($this->monits) > 0)
    {
      foreach($this->monits as $monit)
      {
        $renderer->addMonit($monit);
      }    
    }

    /* set connection mode to output */
    if($this->isBroadcast)
    {
      $renderer->setConnectionMode(2);
    } elseif($this->isConnected)
    {
      $renderer->setConnectionMode(1);
    } else {
      $renderer->setConnectionMode(0);
    }
    
    $key = \SkynetUser\SkynetConfig::KEY_ID;
    if(!\SkynetUser\SkynetConfig::get('debug_key'))
    {
      $key = '****';
    }
    
    $encryptorAlgorithm = '';
    if(\SkynetUser\SkynetConfig::get('core_encryptor') == 'openSSL')
    {
      $encryptorAlgorithm = ' ('.\SkynetUser\SkynetConfig::get('core_encryptor_algorithm').')';
    }
    
    $renderer->setInAjax($this->inAjax);
    $renderer->setClustersData($this->clusters);
    $renderer->setConnectionsCounter($this->successConnections);
    $renderer->addField('My address', SkynetHelper::getMyUrl());
    $renderer->addField('Cluster IP', SkynetHelper::getServerIp());
    $renderer->addField('Your IP', SkynetHelper::getRemoteIp());
    $renderer->addField('Encryption', \SkynetUser\SkynetConfig::get('core_encryptor').$encryptorAlgorithm);
    $renderer->addField('Connections', \SkynetUser\SkynetConfig::get('core_connection_type').' | By '.\SkynetUser\SkynetConfig::get('core_connection_mode').' | '.\SkynetUser\SkynetConfig::get('core_connection_protocol'));    
    $renderer->addField('Broadcasting Clusters', $this->broadcastNum);
    $renderer->addField('Clusters in DB', $this->clustersRegistry->countClusters().' / '.$this->clustersRegistry->countBlockedClusters()); 
    $renderer->addField('Connection attempts', $this->connectId);
    $renderer->addField('Succesful connections', $this->successConnections);
    $renderer->addField('Chain', $chainData['chain'] . ' (updated: '.date('H:i:s d.m.Y', $chainData['updated_at']).')');
    $renderer->addField('Skynet Key ID', $key);
    $renderer->addField('Time now', date('H:i:s d.m.Y').' ['.time().']');  
    $renderer->addField('Sleeped', ($this->options->getOptionsValue('sleep') == 1) ? true : false);
    
    foreach($this->connectionData as $connectionData)
    {
      $renderer->addConnectionData($connectionData);
    }
    foreach($this->statesRegistry->getStates() as $state)
    {
      $renderer->addStateField($state->getCode(), $state->getMsg());
    }
    foreach($this->errorsRegistry->getErrors() as $error)
    {
      $renderer->addErrorField($error->getCode(), $error->getMsg(), $error->getException());
    }
    foreach(\SkynetUser\SkynetConfig::getAll() as $k => $v)
    {
      $renderer->addConfigField($k, $v);
    }
    
    $renderer->setConsoleOutput($this->consoleOutput);
    $renderer->setCliOutput($this->cliOutput);
    
    return $renderer->render();
  } 

 /**
  * Sets monits
  *
  * @param string[] $monits
  */  
  public function setMonits($monits)
  {
    $this->monits = $monits;
  }

 /**
  * Sets connID
  *
  * @param int $connectId
  */    
  public function setConnectId($connectId)
  {
    $this->connectId = $connectId;
  }
 
 /**
  * Sets in ajax
  *
  * @param bool $ajax
  */  
  public function setInAjax($ajax)
  {
    $this->inAjax = $ajax;
  }
  
 /**
  * Sets clusters
  *
  * @param SkynetCluster[] $clusters
  */   
  public function setClusters($clusters)
  {
    $this->clusters = $clusters;
  }
 
 /**
  * Sets is broadcast
  *
  * @param bool $isBroadcast
  */   
  public function setIsBroadcast($isBroadcast)
  {
    $this->isBroadcast = $isBroadcast;
  }

 /**
  * Sets if is connected
  *
  * @param bool $isConnected
  */    
  public function setIsConnected($isConnected)
  {
    $this->isConnected = $isConnected;
  }
 
 /**
  * Sets connection data debug
  *
  * @param string[] $connectionData
  */   
  public function setConnectionData($connectionData)
  {
    $this->connectionData = $connectionData;
  }
 
 /**
  * Sets number of broadcasted
  *
  * @param int $broadcastNum
  */   
  public function setBroadcastNum($broadcastNum)
  {
    $this->broadcastNum = $broadcastNum;
  }
 
 /**
  * Sets successful connections
  *
  * @param int $successConnections
  */   
  public function setSuccessConnections($successConnections)
  {
    $this->successConnections = $successConnections;
  }

 /**
  * Sets console output
  *
  * @param string $consoleOutput
  */     
  public function setConsoleOutput($consoleOutput)
  {
    $this->consoleOutput = $consoleOutput;
  }
 
 /**
  * Sets cli output
  *
  * @param string $cliOutput
  */   
  public function setCliOutput($cliOutput)
  {
    $this->cliOutput = $cliOutput;
  }
  
 /**
  * __toString
  *
  * @return string Debug data
  */
  public function __toString()
  {   
    return (string)$this->renderOutput();
  }  
}