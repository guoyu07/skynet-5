<?php

/**
 * Skynet/Database/SkynetDatabase.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Database;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\Common\SkynetTypes;
use Skynet\Error\SkynetException;

 /**
  * Skynet Database Connection
  *
  * Base class for database connection
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetDatabase
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var bool Status of database connection */
  protected $db_connected = false;

  /** @var bool Status of tables schema */
  protected $db_created = false;

  /** @var SkynetDatabase Instance of this */
  private static $instance = null;
  
  /** @var string[] Array with table names */
  private $dbTables;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var PDO Connection */
  private $db;


 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}

 /**
  * Connects to database
  *
  * @return PDO
  */
  public function connect()
  {
    if($this->db !== null) return $this->db;
    
    if(\SkynetUser\SkynetConfig::get('db_type') == 'sqlite')
    {
      if(empty(\SkynetUser\SkynetConfig::get('db_file')))
      {
        \SkynetUser\SkynetConfig::set('db_file', '.'.str_replace('.', '_', pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)).'.db');
      }

      if(!empty(\SkynetUser\SkynetConfig::get('db_file_dir')))
      {
        $db_path = \SkynetUser\SkynetConfig::get('db_file_dir');
        if(substr($db_path, -1) != '/') $db_path.= '/';
        if(!is_dir($db_path)) 
        {
          try
          {
            if(mkdir($db_path))
            {
              \SkynetUser\SkynetConfig::set('db_file', $db_path.\SkynetUser\SkynetConfig::get('db_file'));
            } else {
              throw new SkynetException('ERROR CREATING DIR: '.$db_path);
            }
          } catch(SkynetException $e)
          {
            $this->addError(SkynetTypes::DB, 'DATABASE FILE DIR: '.$e->getMessage(), $e);
          }         
        }
      }
    }

    try
    {
       /* Try to connect... */
       if(\SkynetUser\SkynetConfig::get('db_type') != 'sqlite')
       {
         $dsn = \SkynetUser\SkynetConfig::get('db_type') .
         ':host=' . \SkynetUser\SkynetConfig::get('db_host') .
         ';port=' .\SkynetUser\SkynetConfig::get('db_port') .
         ';encoding=' . \SkynetUser\SkynetConfig::get('db_encoding') .
         ';dbname=' . \SkynetUser\SkynetConfig::get('db_dbname');
       } else {
         $dsn = \SkynetUser\SkynetConfig::get('db_type') .':'. \SkynetUser\SkynetConfig::get('db_file');
       }

       $options = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION);
       $this->db = new \PDO($dsn, \SkynetUser\SkynetConfig::get('db_user'),  \SkynetUser\SkynetConfig::get('db_password'), $options);
       $this->db_connected = true;
       $this->addState(SkynetTypes::DB, SkynetTypes::DBCONN_OK.' : '. \SkynetUser\SkynetConfig::get('db_type'));

       /* Check for database schema */
       $this->checkSchemas();

       return $this->db;

    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Returns tables names
  *
  * @return string[]
  */   
  public function getDbTables()
  {
    $this->dbTables = [];    
    $this->dbTables['skynet_clusters'] = 'Clusters';
    $this->dbTables['skynet_registry'] = 'Registry';
    $this->dbTables['skynet_options'] = 'Options';
    $this->dbTables['skynet_chain'] = 'Chain';
    $this->dbTables['skynet_logs_responses'] = 'Logs: Responses';
    $this->dbTables['skynet_logs_requests'] = 'Logs: Requests';
    $this->dbTables['skynet_logs_echo'] = 'Logs: Echo';
    $this->dbTables['skynet_logs_broadcast'] = 'Logs: Broadcasts';
    $this->dbTables['skynet_errors'] = 'Logs: Errors';
    $this->dbTables['skynet_access_errors'] = 'Logs: Access Errors';
    $this->dbTables['skynet_logs_selfupdate'] = 'Logs: Self-updates';  
    
    return $this->dbTables;   
  }


 /**
  * Returns tables fields
  *
  * @return string[]
  */  
  public function getTablesFields()
  {
    $this->tablesFields['skynet_clusters'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'url' => 'URL Address',
    'ip' => 'IP Address',
    'version' => 'Skynet version',
    'last_connect' => 'Last connection',
    'registrator' => 'Added by'
    ];
    
    $this->tablesFields['skynet_registry'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Last update',
    'key' => 'Key',
    'content' => 'Value'
    ];
    
     $this->tablesFields['skynet_options'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Last update',
    'key' => 'Key',
    'content' => 'Value'
    ];
    
    $this->tablesFields['skynet_chain'] = [
    'id' => '#ID',
    'chain' => 'Current Chain Value',
    'updated_at' => 'Last update'
    ];
    
    $this->tablesFields['skynet_logs_responses'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'content' => 'Full Response',
    'sender_url' => 'Response Sender',
    'receiver_url' => 'Response Receiver'
    ];
    
    $this->tablesFields['skynet_logs_requests'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'content' => 'Full Request',
    'sender_url' => 'Response Sender',
    'receiver_url' => 'Response Receiver'
    ];
    
    $this->tablesFields['skynet_logs_echo'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'request' => 'Echo Full Request',    
    'ping_from' => '@Echo received from',
    'ping_to' => '@Echo resended to',
    'urls_chain' => 'URLs Chain'
    ];
    
    $this->tablesFields['skynet_logs_broadcast'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'request' => 'Echo Full Request',    
    'ping_from' => '@Broadcast received from',
    'ping_to' => '@Broadcast resended to',
    'urls_chain' => 'URLs Chain'
    ];
    
    $this->tablesFields['skynet_errors'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Created At',
    'content' => 'Error log',    
    'remote_ip' => 'IP Address'
    ];
    
    $this->tablesFields['skynet_access_errors'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Created At',
    'request' => 'Full Request',
    'remote_cluster' => 'Remote Cluster Address',
    'request_uri' => 'Request URI',
    'remote_host' => 'Remote Host',
    'remote_ip' => 'Remote IP Address'
    ];
    
    $this->tablesFields['skynet_logs_selfupdate'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Created At',
    'request' => 'Full Request',
    'sender_url' => 'Update command Sender',
    'source' => 'Update remote Source Code',
    'status' => 'Update Status',
    'from_version' => 'From version (before)',
    'to_version' => 'To version (after)'
    ];
    
    return $this->tablesFields;
  }
  
  
 /**
  * Returns table records count
  *
  * @param string $table Table name
  * 
  * @return int
  */  
  public function countTableRows($table)
  {
    $counter = 0;
    try
    {
      $stmt = $this->db->query('SELECT count(*) as c FROM '.$table.' LIMIT 200');     
      $stmt->execute();
      $row = $stmt->fetch();
      $counter = $row['c'];
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting records from database table: '.$table.' failed', $e);
      return false;
    }    
    return $counter;   
  }

 /**
  * Deletes record from table
  *
  * @param string $table Table name
  * @param int $id Record ID
  * 
  * @return bool
  */  
  public function deleteRecordId($table, $id)
  {    
    try
    {
      $stmt = $this->db->prepare('DELETE FROM '.$table.' WHERE id = :id');   
      $stmt->bindParam(':id', $id);        
      $stmt->execute();
      return true;
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Error deleting [ID: '.$id.' ] from table: '.$table, $e);      
    }       
  }
  
 /**
  * Deletes all records from table
  *
  * @param string $table Table name
  * 
  * @return bool
  */  
  public function deleteAllRecords($table)
  {    
    try
    {
      $stmt = $this->db->query('DELETE FROM '.$table); 
      $stmt->execute();       
      return true;      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Error deleting all records from table: '.$table, $e);      
    }       
  }
  
 /**
  * Returns rows from table
  *
  * @param string $table Table name
  * @param int $startFrom Limit offset
  * @param int $limitTo Limit
  * @param string $sortBy Sort by column
  * @param string $sortOrder Sort order ASC|DESC
  * 
  * @return mixed[] Record's rows
  */  
  public function getTableRows($table, $startFrom = null, $limitTo = null, $sortBy = null, $sortOrder = null)
  {
    $rows = [];
    $limit = '';
    $sort = ''; 
    $order = '';     
    if($limitTo !== null) $limit = ' LIMIT '.intval($startFrom).', '.intval($limitTo);
    if($sortBy !== null) $sort = ' ORDER BY '.$sortBy;
    if($sortOrder !== null) $order = ' '.$sortOrder;
    
    try
    {
      $query = 'SELECT * FROM '.$table.$sort.$order.$limit;      
      $stmt = $this->db->query($query);     
      $stmt->execute();
           
      while($row = $stmt->fetch())
      {
        $rows[] = $row;
      }
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting records from database table: '.$table.' failed', $e);
      return false;
    }    
    return $rows;   
  }
  
  
   /**
  * Returns row from table
  *
  * @param string $table Table name
  * @param int $id Record ID
  * 
  * @return mixed[] Record's row
  */  
  public function getTableRow($table, $id)
  {   
    try
    {
      $query = 'SELECT * FROM '.$table.' WHERE id = :id';      
      $stmt = $this->db->prepare($query);   
      $stmt->bindParam(':id', $id);
      $stmt->execute();           
      $row = $stmt->fetch();
      $stmt->closeCursor();
      return $row;
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting record from database table: '.$table.' failed (id: '.$id.')', $e);
      return false;
    }  
  }
  
 /**
  * Checks database tables and creates schema if not exists
  *
  * @return bool
  */
  private function checkSchemas()
  {
    $error = false;
    $queries = [];

    $queries['skynet_clusters'] = 'CREATE TABLE skynet_clusters (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), url TEXT, ip VARCHAR (15), version VARCHAR (6), last_connect INTEGER, registrator TEXT)';
    $queries['skynet_logs_responses'] = 'CREATE TABLE skynet_logs_responses (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, sender_url TEXT, receiver_url TEXT)';
    $queries['skynet_logs_requests'] = 'CREATE TABLE skynet_logs_requests (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, sender_url TEXT, receiver_url TEXT)';
    $queries['skynet_chain'] = ['CREATE TABLE skynet_chain (id INTEGER PRIMARY KEY AUTOINCREMENT, chain BIGINT, updated_at INTEGER)', 'INSERT INTO skynet_chain (id, chain, updated_at) VALUES(1, 0, 0)'];
    $queries['skynet_logs_echo'] = 'CREATE TABLE skynet_logs_echo (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, ping_from TEXT, ping_to TEXT, urls_chain TEXT)';
    $queries['skynet_logs_broadcast'] = 'CREATE TABLE skynet_logs_broadcast (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, ping_from TEXT, ping_to TEXT, urls_chain TEXT)';
    $queries['skynet_errors'] = 'CREATE TABLE skynet_errors (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, remote_ip VARCHAR (15))';
    $queries['skynet_access_errors'] = 'CREATE TABLE skynet_access_errors (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, remote_cluster TEXT, request_uri TEXT, remote_host TEXT, remote_ip VARCHAR (15))';
    $queries['skynet_registry'] = 'CREATE TABLE skynet_registry (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, key VARCHAR (15), content TEXT)';
    $queries['skynet_options'] = 'CREATE TABLE skynet_options (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, key VARCHAR (15), content TEXT)';
    $queries['skynet_logs_selfupdate'] = 'CREATE TABLE skynet_logs_selfupdate (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, sender_url TEXT, source  TEXT, status TEXT, from_version VARCHAR (15), to_version VARCHAR (15))';

    foreach($queries as $table => $query)
    {
      if(!$this->isTable($table))
      {
        $error = true;
        if($this->createTable($query))
        {
          $error = false;
          $this->addState(SkynetTypes::DB, 'DATABASE TABLE ['.$table.'] CREATED');
        }
      }
    }

    if(!$error)
    {
      $this->db_created = true;
      $this->addState(SkynetTypes::DB, 'DATABASE SCHEMA IS CORRECT');
    }
  }

 /**
  * Creates table in database
  *
  * @param string|string[] $queries Queries for schema creation
  *
  * @return bool
  */
  private function createTable($queries)
  {
    $i = 0;
    try
    {
      if(is_array($queries))
      {
        foreach($queries as $query)
        {
          $this->db->query($query);
          $i++;
        }
      } else {
         $this->db->query($queries);
         $i++;
      }
      return true;

    } catch (\PDOException $e)
    {
      $this->addState(SkynetTypes::DB, 'DATABASE SCHEMA NOT CREATED...');
      $this->addError(SkynetTypes::PDO, 'DATABASE SCHEMA BUILDING ERROR: Exception: '.$e->getMessage(), $e);
    }
  }

 /**
  * Checks for table exists
  *
  * @param string $table Table name
  *
  * @return bool
  */
  private function isTable($table)
  {
    try
    {
        $result = $this->db->query("SELECT 1 FROM ".$table." LIMIT 1");

    } catch (\PDOException $e)
    {
        $this->addState(SkynetTypes::DB, 'DATABASE TABLE: ['.$table.'] NOT EXISTS...TRYING TO CREATE...');
        return false;
    }
    return $result !== false;
  }

 /**
  * Returns Connection
  *
  * @return PDO PDO Connection object
  */
  public function getDB()
  {
    return $this->db;
  }

 /**
  * Returns instance of this
  *
  * @return SkynetDatabase
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
      self::$instance->connect();
    }
    return self::$instance;
  }

 /**
  * Checks for connection
  *
  * @return bool True if connected to database
  */
  public function isDbConnected()
  {
    return $this->db_connected;
  }

 /**
  * Checks for database schema is created
  *
  * @return bool True if schema exists in database
  */
  public function isDbCreated()
  {
    return $this->db_created;
  }

 /**
  * Disconnects with database
  */
  public function disconnect()
  {
    $this->db = null;
  }
}