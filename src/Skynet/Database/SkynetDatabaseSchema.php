<?php

/**
 * Skynet/Database/SkynetDatabaseSchema.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.3
 */

namespace Skynet\Database;

use Skynet\EventListener\SkynetEventListenersFactory;
use Skynet\EventLogger\SkynetEventLoggersFactory;

 /**
  * Skynet Database Schema
  *
  * Database tables schema
  */
class SkynetDatabaseSchema
{  
  /** @var string[] Array with table names */
  private $dbTables = [];
  
  /** @var string[] Array with tables fields */
  private $tablesFields = [];  
    
  /** @var string[] Array with CREATE queries */
  private $createQueries = [];
  
  /** @var SkynetEventListenersInterface[] Array of Event Listeners */
  private $eventListeners = [];

  /** @var SkynetEventListenersInterface[] Array of Event Loggers */
  private $eventLoggers = [];

 /**
  * Constructor (private)
  */
  public function __construct() 
  {
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();
    $this->registerListenersTables();
  }
  
 /**
  * Registers tables from listeners
  */
  public function registerListenersTables()
  {
    $listenersData = [];
    
    foreach($this->eventListeners as $listener)
    {
      if(method_exists($listener, 'registerDatabase'))
      {
        $data = $listener->registerDatabase();  
        if(is_array($data) && isset($data['queries']) && isset($data['tables']) && isset($data['fields']))
        {
          $listenersData[] = $data;
        }
      }
    }
    foreach($this->eventLoggers as $listener)
    {
      if(method_exists($listener, 'registerDatabase'))
      {
        $data = $listener->registerDatabase(); 
        if(is_array($data) && isset($data['queries']) && isset($data['tables']) && isset($data['fields']))
        {
          $listenersData[] = $data;
        }
      }
    } 
    
    foreach($listenersData as $listenerData)
    {
      $this->createQueries = array_merge($this->createQueries, $listenerData['queries']);
      $this->dbTables = array_merge($this->dbTables, $listenerData['tables']);
      $this->tablesFields = array_merge($this->tablesFields, $listenerData['fields']);      
    }    
  }

 /**
  * Returns tables num
  *
  * @return int Num of tables
  */  
  public function countTables()
  {   
    return count($this->dbTables);
  }
  
 /**
  * Returns create queries
  *
  * @return string[] SQL Queries
  */   
  public function getCreateQueries()
  {   
    return $this->createQueries;
  }
  
 /**
  * Returns tables names
  *
  * @return string[]
  */   
  public function getDbTables()
  {
    return $this->dbTables;   
  }

 /**
  * Returns tables fields
  *
  * @return string[]
  */  
  public function getTablesFields()
  {   
    return $this->tablesFields;
  }
}