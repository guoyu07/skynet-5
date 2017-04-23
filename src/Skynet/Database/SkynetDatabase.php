<?php

/**
 * Skynet/Database/SkynetDatabase.php
 *
 * @package Skynet
 * @version 1.1.3
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
  protected $dbConnected = false;

  /** @var bool Status of tables schema */
  protected $dbCreated = false;

  /** @var SkynetDatabase Instance of this */
  private static $instance = null;
  
  /** @var string[] Array with table names */
  private $dbTables;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var PDO Connection */
  private $db;
  
  /** @var SkynetDatabaseOperations DB Methods */
  public $ops;

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
    if($this->db !== null) 
    {
      return $this->db;
    }
    
    if(\SkynetUser\SkynetConfig::get('db_type') == 'sqlite')
    {
      if(empty(\SkynetUser\SkynetConfig::get('db_file')))
      {
        \SkynetUser\SkynetConfig::set('db_file', '.'.str_replace('.', '_', pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)).'.db');
      }

      if(!empty(\SkynetUser\SkynetConfig::get('db_file_dir')))
      {
        $db_path = \SkynetUser\SkynetConfig::get('db_file_dir');
        if(substr($db_path, -1) != '/') 
        {
          $db_path.= '/';
        }
        
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
       $this->dbConnected = true;
       $this->addState(SkynetTypes::DB, SkynetTypes::DBCONN_OK.' : '. \SkynetUser\SkynetConfig::get('db_type'));

       
       $this->ops = new SkynetDatabaseOperations();
       $this->ops->setDb($this->db);
       
       /* Check for database schema */
       $this->ops->checkSchemas();
       $this->dbCreated = $this->ops->getDbCreated();

       return $this->db;

    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
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
    return $this->dbConnected;
  }

 /**
  * Checks for database schema is created
  *
  * @return bool True if schema exists in database
  */
  public function isDbCreated()
  {
    return $this->dbCreated;
  }

 /**
  * Disconnects with database
  */
  public function disconnect()
  {
    $this->db = null;
  }
}