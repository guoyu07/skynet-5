<?php

/**
 * Skynet/Database/SkynetDatabaseOperations.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.3
 */

namespace Skynet\Database;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\Common\SkynetTypes;
use Skynet\Error\SkynetException;

 /**
  * Skynet Database Operations
  *
  * Base class for database ops
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetDatabaseOperations
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var string[] Array with table names */
  private $dbTables;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var bool Status of tables schema */
  protected $dbCreated = false;
  
  /** @var PDO Connection */
  private $db;

 /**
  * Constructor
  */
  public function __construct() 
  {   
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
      if($stmt->execute())
      {
        return true;
      }
      
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
      if($stmt->execute())
      {
        return true;      
      }
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
    if($limitTo !== null) 
    {
      $limit = ' LIMIT '.intval($startFrom).', '.intval($limitTo);
    }
    
    if($sortBy !== null) 
    {
      $sort = ' ORDER BY '.$sortBy;
    }
    
    if($sortOrder !== null) 
    {
      $order = ' '.$sortOrder;
    }
    
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
  * Updates row
  *
  * @param string $table Table name
  * @param int $id Record ID
  * @param mixed[] $data Data
  * 
  * @return bool True if success
  */   
  public function updateRow($table, $id, $data)
  {      
    $params = [];
    foreach($data as $k => $v)
    {
      $params[] = $k.'=:'.$k;      
    }
    $paramsSet = implode(',', $params);    
    $query =  'UPDATE '.$table.' SET '.$paramsSet.' WHERE id=:id';    
    
    try
    {
      $stmt = $this->db->prepare($query); 
      $stmt->bindValue(':id', $id);
      foreach($data as $k => $v)
      {
        $stmt->bindValue(':'.$k, $v);
      }
      
      if($stmt->execute())
      {
        return true;
      }
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Update record in table: '.$table.' failed', $e);
      return false;
    } 
  }  
 
 /**
  * Create record row
  *
  * @param string $table Table name
  * @param mixed[] $data Data
  * 
  * @return bool True if success
  */   
  public function newRow($table, $data)
  {      
    $params = [];
    $insert = [];
    foreach($data as $k => $v)
    {
      $params[] = ':'.$k;  
      $insert[] = $k;
    }
    $paramsSet = implode(',', $params);  
    $fieldsStr = implode(',', $insert);  
    $query =  'INSERT INTO '.$table.'('.$fieldsStr.') VALUES('.$paramsSet.')';    
    
    var_dump($query);
    
    try
    {
      $stmt = $this->db->prepare($query);       
      foreach($data as $k => $v)
      {
        $stmt->bindValue(':'.$k, $v);
      }
      
      if($stmt->execute())
      {
        return true;
      }
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'New record in table: '.$table.' failed', $e);
      return false;
    } 
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
  public function checkSchemas()
  {
    $error = false;
    $createQueries = [];
    $dbSchema = new SkynetDatabaseSchema();
    $createQueries = $dbSchema->getCreateQueries();

    foreach($createQueries as $table => $query)
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
      $this->dbCreated = true;
      $this->addState(SkynetTypes::DB, 'DATABASE SCHEMA IS CORRECT');
    }
  }

  public function getDbCreated()
  {
    return $this->dbCreated;
  }
  
 /**
  * Creates table in database
  *
  * @param string|string[] $queries Queries for schema creation
  *
  * @return bool
  */
  public function createTable($queries)
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
  public function isTable($table)
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
  * Sets DB
  *
  * @param PDO PDO Connection object
  */
  public function setDB($db)
  {
   $this->db = $db;
  } 
}