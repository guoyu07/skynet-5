<?php

/**
 * Skynet/Renderer/SkynetRendererAbstract.php
 *
 * @package Skynet
 * @version 1.1.2
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Renderer;

use Skynet\Console\SkynetCli;
use Skynet\Data\SkynetField;

 /**
  * Skynet Renderer Base
  *
  * Assigns data to renderers
  */
abstract class SkynetRendererAbstract
{   
  /** @var SkynetField[] Custom data fields */
  protected $fields = [];
  
  /** @var SkynetField[] States data fields */
  protected $statesFields = [];
  
  /** @var SkynetError[] Errors data fields */  
  protected $errorsFields = [];
  
  /** @var SkynetField[] Config data fields */
  protected $configFields = [];
  
  /** @var mixed[] Conenctions data fields */
  protected $connectionsData = [];  
    
  /** @var int Num of success connects */
  protected $connectionsCounter;
  
  /** @var string Current view mode (connections|database|...) */
  protected $mode;  
  
  /** @var SkynetCli Cli commands parser */ 
  protected $cli;
  
  /** @var string[] Output from listeners */
  protected $cliOutput = [];
  
  /** @var string[] Output from listeners */
  protected $consoleOutput = [];
  
  /** @var string[] Clusters debug data */
  protected $clustersData = [];
  
  /** @var int Connection Mode | 0 - idle, 1 - single, 2 - broadcast */
  protected $connectionMode = 0;
 
  /** @var string[] Monits */ 
  protected $monits = [];


 /**
  * Constructor
  */
  public function __construct()
  {
    $this->mode = 'connections';
    $this->cli = new SkynetCli();
    
        /* Switch View */
    if(!$this->cli->isCli())
    {
      if(isset($_REQUEST['_skynetView']) && !empty($_REQUEST['_skynetView']))
      {
        switch($_REQUEST['_skynetView'])
        {
          case 'connections':
            $this->mode = 'connections';
          break;
          
          case 'database':       
            $this->mode = 'database';
          break;          
        } 
      }
    } else {
      if($this->cli->isCommand('db'))
      {
        $this->mode = 'database';
      }
    }
  }   

 /**
  * Assigns data fields array to renderer
  *
  * @param mixed $key
  * @param mixed $value
  */
  public function addField($key, $value)
  {
    $this->fields[$key] = new SkynetField($key, $value);
  }
 
 /**
  * Assigns data fields array to renderer
  *
  * @param mixed[] $fields
  */
  public function setFields($fields)
  {
    $this->fields = $fields;
  }
  
 /**
  * Sets num of connections
  *
  * @param int $num
  */    
  public function setConnectionsCounter($num)
  {
    $this->connectionsCounter = $num;
  }
  
 /**
  * Assigns conenctions debug data array to renderer
  *
  * @param mixed[] $data
  */
  public function addConnectionData($data)
  {
    $this->connectionsData[] = $data;
  }  
  
  
 /**
  * Assigns conenctions 
  *
  * @param mixed[] $data
  */
  public function setConnectionsData($data)
  {
    $this->connectionsData = $data;
  }  
  
 /**
  * Assignsclusters debug data array to renderer
  *
  * @param SkynetCluster[] $clusters
  */
  public function setClustersData($clusters)
  {
    $this->clustersData = $clusters;
  }

 /**
  * Assigns State data field to renderer
  *
  * @param mixed $key
  * @param mixed $value
  */  
  public function addStateField($key, $value)
  {
    $this->statesFields[] = new SkynetField($key, $value);
  }

  /**
  * Sets state fields
  *
  * @param mixed[] 
  */  
  public function setStatesFields($fields)
  {
    $this->statesFields = $fields;
  }
  
 /**
  * Assigns Error debug data field to renderer
  *
  * @param mixed $key
  * @param mixed $value
  * @param Exception $exception 
  */  
  public function addErrorField($key, $value, $exception = null)
  {
    $this->errorsFields[] = new SkynetField($key, array($value, $exception));
  }
  
 /**
  * Sets error fields
  *
  * @param mixed[] 
  */  
  public function setErrorsFields($fields)
  {
    $this->errorsFields = $fields;
  }

 /**
  * Assigns config data array to renderer
  *
  * @param mixed $key
  * @param mixed $value
  */  
  public function addConfigField($key, $value)
  {
    $this->configFields[] = new SkynetField($key, $value);
  }
 
 /**
  * Sets config fields
  *
  * @param mixed[] 
  */  
  public function setConfigFields($fields)
  {
    $this->configFields = $fields;
  }
  
 /**
  * Adds monit
  *
  * @param string $msg
  */  
  public function addMonit($msg)
  {
    $this->monits[] = $msg;
  }
  
 /**
  * Adds monit
  *
  * @param string $msg
  */  
  public function setMonits($monits)
  {
    $this->monits = $monits;
  }
  
 /**
  * Sets view mode
  *
  * @param string $mode
  */
  public function setMode($mode)
  {
    $this->mode = $mode;
  }
  
 /**
  * Returns current view mode
  *
  * @return string
  */
  public function getMode()
  {
    return $this->mode;
  }
 
 /**
  * Sets connection mode
  *
  * @param int $mode
  */
  public function setConnectionMode($mode)
  {
    $this->connectionMode = $mode;
  }
  
 /**
  * Returns connection view mode
  *
  * @return int
  */
  public function getConnectionMode()
  {
    return $this->connectionMode;
  }
  
 /**
  * Sets cli listeners output data
  *
  * @param string $output
  */
  public function setCliOutput($output)
  {
    $this->cliOutput = $output;
  }
  
 /**
  * Sets console listeners output data
  *
  * @param string $output
  */
  public function setConsoleOutput($output)
  {
    $this->consoleOutput = $output;
  }
}