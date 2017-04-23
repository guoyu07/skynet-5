<?php

/**
 * Skynet/Database/SkynetGenerator.php
 *
 * Checking and veryfing access to skynet
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

use Skynet\Secure\SkynetVerifier;
use Skynet\Filesystem\SkynetLogFile;

 /**
  * Skynet Generator
  *
  * TXT Generator
  */
class SkynetGenerator
{
  /** @var string Current table in Database view */
  protected $selectedTable;
  
  /** @var string[] Array with table names */
  protected $dbTables;
  
  /** @var SkynetDatabase DB Instance */
  protected $database;
  
  /** @var SkynetDatabaseSchema DB Schema */
  protected $databaseSchema;
  
  /** @var PDO Connection instance */
  protected $db;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier; 

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->database = SkynetDatabase::getInstance();   
    $this->databaseSchema = new SkynetDatabaseSchema;        
    $this->dbTables = $this->databaseSchema->getDbTables();   
    $this->tablesFields = $this->databaseSchema->getTablesFields();      
    $this->db = $this->database->connect();
    $this->verifier = new SkynetVerifier();
    
    if(isset($_REQUEST['_skynetGenerateTxtFromId']) && isset($_REQUEST['_skynetDatabase']))
    {
      $this->generateFromTable($_REQUEST['_skynetDatabase'], $_REQUEST['_skynetGenerateTxtFromId']);   
    }
  }

 /**
  * Generates TXT from record
  *
  * @param string $table Table
  * @param int $id Record ID
  */  
  private function generateFromTable($table, $id)
  {
    $row = $this->database->ops->getTableRow($table, $id);
    
    $fileName = date('Y-m-d_H-i-s').'_'.$table.'_'.$id.'.txt';
    $logFile = new SkynetLogFile('RECORD #ID '.$id);
    $logFile->setFileName($fileName);
    $logFile->setHeader('RECORD #ID '.$id.' FROM '.$table);

    foreach($this->tablesFields[$table] as $k => $v)
    {     
      $data = $row[$k];
      $logFile->addLine($this->parseLine($k, $data));
    }  
    
    $file = $logFile->save(null, false);
    
    if(!empty($file))
    {
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename='.$fileName);
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      echo $file;
      exit;
    }    
  }
  
   /**
  * Parse single line
  *
  * @param string $k Field name/key
  * @param string $v Field value
  * @param bool $force Force include if internal param
  *
  * @return string Parsed line
  */
  private function parseLine($k, $v, $force = false)
  {     
    $row = '';
    if(\SkynetUser\SkynetConfig::get('logs_txt_include_internal_data') || $force)
    {
       $row = "  ".$k.": ".$this->decodeIfNeeded($k, $v);
    } else {
       if(!$this->verifier->isInternalParameter($k)) 
       {
         $row = "  ".$k.": ".$this->decodeIfNeeded($k, $v);
       }
    }       
    return $row;
  }
  
  /**
  * Decodes value if encrypted
  *
  * @param string $key Field name/key
  * @param string $val Value
  *
  * @return string Decoded value
  */
  private function decodeIfNeeded($key, $val)
  {
    if(is_numeric($key)) return $val;
    if($key == '_skynet_clusters' || $key == '@_skynet_clusters')
    {
      $ret = [];
      $clusters = explode(';', $val);
      foreach($clusters as $cluster)
      {
        $ret[] = base64_decode($cluster);
      }
      return implode('; ', $ret);
    }

    $toDecode = ['_skynet_clusters_chain', '@_skynet_clusters_chain'];
    if(in_array($key, $toDecode))
    {      
      return base64_decode($val);
    } else {     
      return $val;
    }
  }
}