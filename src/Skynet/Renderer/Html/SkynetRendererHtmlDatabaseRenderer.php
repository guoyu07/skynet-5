<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlDatabaseRenderer.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Renderer\Html;

use Skynet\Database\SkynetDatabase;

 /**
  * Skynet Renderer HTML Database Renderer
  *
  */
class SkynetRendererHtmlDatabaseRenderer
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var string Current table in Database view */
  protected $selectedTable;
  
  /** @var string[] Array with table names */
  protected $dbTables;
  
  /** @var SkynetDatabase DB Instance */
  protected $database;
  
  /** @var PDO Connection instance */
  protected $db;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var string Sort by */
  protected $tableSortBy;
  
  /** @var string Sort order */
  protected $tableSortOrder;
  
  /** @var int Current pagination */
  protected $tablePage;
  
  /** @var int Limit records per page */
  protected $tablePerPageLimit;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();
    $this->database = SkynetDatabase::getInstance();    
    $this->dbTables = $this->database->getDbTables();   
    $this->tablesFields = $this->database->getTablesFields();
    $this->tablePerPageLimit = 20;
    
    $this->db = $this->database->connect();
    
    /* Switch database table */
    if(isset($_REQUEST['_skynetDatabase']) && !empty($_REQUEST['_skynetDatabase']))
    {
      if(array_key_exists($_REQUEST['_skynetDatabase'], $this->dbTables))
      {
        $this->selectedTable = $_REQUEST['_skynetDatabase'];
      }
    }
    
    if($this->selectedTable === null)
    {
      $this->selectedTable = 'skynet_clusters';
    }
    
    /* Set default */
    if(isset($_REQUEST['_skynetPage']) && !empty($_REQUEST['_skynetPage']))
    {
      $this->tablePage = (int)$_REQUEST['_skynetPage'];
    }
    
    if(isset($_REQUEST['_skynetSortBy']) && !empty($_REQUEST['_skynetSortBy']))
    {
      $this->tableSortBy = $_REQUEST['_skynetSortBy'];
    }
    
    if(isset($_REQUEST['_skynetSortOrder']) && !empty($_REQUEST['_skynetSortOrder']))
    {
      $this->tableSortOrder = $_REQUEST['_skynetSortOrder'];
    }    
    
    if($this->selectedTable != 'skynet_chain')
    {
      if(isset($_REQUEST['_skynetDeleteRecordId']) && !empty($_REQUEST['_skynetDeleteRecordId']) && is_numeric($_REQUEST['_skynetDeleteRecordId']))
      {
        $this->database->deleteRecordId($this->selectedTable, intval($_REQUEST['_skynetDeleteRecordId']));
      }    

      if(isset($_REQUEST['_skynetDeleteAllRecords']) && $_REQUEST['_skynetDeleteAllRecords'] == 1)
      {
        $this->database->deleteAllRecords($this->selectedTable);
      }   
    }
    
    /* Set defaults */   
    if($this->tableSortBy === null)
    {
      $this->tableSortBy = 'id';
    }
    if($this->tableSortOrder === null)
    {
      $this->tableSortOrder = 'DESC';
    }
    if($this->tablePage === null)
    {
      $this->tablePage = 1;
    }
  }   
  
 /**
  * Assigns Elements Generator
  *
  * @param SkynetRendererHtmlElements $elements
  */
  public function assignElements($elements)
  {
    $this->elements = $elements;   
  }  
  
    
 /**
  * Renders and returns records
  *
  * @return string HTML code
  */  
  public function renderDatabaseView()
  {
    $recordRows = [];    
    $start = 0;
    if($this->tablePage > 1)
    {
      $min = (int)$this->tablePage - 1;
      $start = $min * $this->tablePerPageLimit;
    }
    
    $rows = $this->database->getTableRows($this->selectedTable, $start, $this->tablePerPageLimit, $this->tableSortBy, $this->tableSortOrder);
    if($rows !== false && count($rows) > 0)
    {
      $fields = $this->tablesFields[$this->selectedTable];   
      $header = $this->renderTableHeader($fields);
      $recordRows[] = $header;
      $i = 0;
      foreach($rows as $row)
      {
        $recordRows[] = $this->renderTableRow($fields, $row); 
        $i++;
      }        
      $recordRows[] = $header;
      return '<table id="dbTable">'.implode('', $recordRows).'</table>';
      
    } else {
      return 'No records.';
    }    
  }
  
 /**
  * Renders and returns table form switcher
  *
  * @return string HTML code
  */   
  public function renderDatabaseSwitch()
  {
    $options = [];
    foreach($this->dbTables as $k => $v)
    {
      $numRecords = 0;
      $numRecords = $this->database->countTableRows($k);
      
      if($k == $this->selectedTable)
      {
        $options[] = '<option value="'.$k.'" selected>'.$v.' ('.$numRecords.')</option>';
      } else {
        $options[] = '<option value="'.$k.'">'.$v.' ('.$numRecords.')</option>';
      }
    }   
      
    return '<form method="GET" action="">
    Select database table: <select name="_skynetDatabase">'.implode('', $options).'</select>
    <input type="submit" value="Show stored data"/>
    <input type="hidden" name="_skynetView" value="database" />
    </form>'.$this->renderTableSorter();      
  }

 /**
  * Renders and returns table form switcher
  *
  * @return string HTML code
  */   
  private function renderTableSorter()
  {
    $optionsSortBy = [];
    $optionsOrderBy = [];
    $optionsPages = [];    
   
    $numRecords = $this->database->countTableRows($this->selectedTable);
    $numPages = (int)ceil($numRecords / $this->tablePerPageLimit);    
    $order = ['ASC' => 'Ascending', 'DESC' => 'Descending'];    
    
    foreach($this->tablesFields[$this->selectedTable] as $k => $v)
    {     
      if($k == $this->tableSortBy)
      {
        $optionsSortBy[] = '<option value="'.$k.'" selected>'.$v.'</option>';
      } else {
        $optionsSortBy[] = '<option value="'.$k.'">'.$v.'</option>';
      }
    }   
    
    foreach($order as $k => $v)
    {     
      if($k == $this->tableSortOrder)
      {
        $optionsOrderBy[] = '<option value="'.$k.'" selected>'.$v.'</option>';
      } else {
        $optionsOrderBy[] = '<option value="'.$k.'">'.$v.'</option>';
      }
    }   
    for($i = 1; $i <= $numPages; $i++)
    {    
      if($i == $this->tablePage)
      {
        $optionsPages[] = '<option value="'.$i.'" selected>'.$i.' / '.$numPages.'</option>';
      } else {
        $optionsPages[] = '<option value="'.$i.'">'.$i.' / '.$numPages.'</option>';
      }
    }      
    
    $deleteHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetDeleteAllRecords=1&_skynetPage=1&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $allDeleteLink = '';
    
    if($this->selectedTable != 'skynet_chain')
    {
      $deleteLink = 'javascript:if(confirm(\'Delete ALL RECORDS from this table?\')) window.location.assign(\''.$deleteHref.'\');';
      $allDeleteLink = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete ALL RECORDS'), false, 'aDelete');
    }
    
    return '<form method="GET" action="">
    Page:<select name="_skynetPage">'.implode('', $optionsPages).'</select> Sort By: <select name="_skynetSortBy">'.implode('', $optionsSortBy).'</select> <select name="_skynetSortOrder">'.implode('', $optionsOrderBy).'</select>
    <input type="submit" value="Execute"/> '.$allDeleteLink.'
    <input type="hidden" name="_skynetView" value="database"/>
    <input type="hidden" name="_skynetDatabase" value="'.$this->selectedTable.'"/>
    </form>';      
  }

 /**
  * Renders and returns table header
  *
  * @param string[] $fields Array with table fields
  *
  * @return string HTML code
  */  
  private function renderTableHeader($fields)
  {
    $td = [];
    foreach($fields as $k => $v)
    {     
      $td[] = '<th>'.$v.'</th>';         
    }
    $td[] = '<th>Save as TXT / Delete</th>';         
    return '<tr>'.implode('', $td).'</tr>';    
  }

 /**
  * Renders and returns single record
  *  
  * @param string[] $fields Array with table fields
  * @param mixed[] $rowData Record from database
  *
  * @return string HTML code
  */   
  private function renderTableRow($fields, $rowData)
  {    
    $td = [];
    if(!is_array($fields)) 
    {
      return false;
    }
    
    $typesTime = ['created_at', 'updated_at', 'last_connect'];
    $typesSkynetId = ['skynet_id'];
    $typesUrl = ['sender_url', 'receiver_url', 'ping_from', 'url', 'remote_cluster'];
    $typesData = [];
    
    foreach($fields as $k => $v)
    {
      if(array_key_exists($k, $rowData))
      {
        $data = htmlentities($rowData[$k]);
        
        if(in_array($k, $typesTime))
        {
          $data = date(\SkynetUser\SkynetConfig::get('core_date_format'), $data);
        }
        
        if(in_array($k, $typesUrl) && !empty($data))
        {
          $data = $this->elements->addUrl(\SkynetUser\SkynetConfig::get('core_connection_protocol').$data, $data);
        }
        
        if(in_array($k, $typesSkynetId) && !empty($data))
        {
          $data = $this->elements->addSpan($data, 'marked');
        }
        
        if(empty($data)) 
        {
          $data = '-';
        }
        
        $td[] = '<td>'.$data.'</td>';
      }     
    }
    $deleteStr = '';
    $txtLink = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetGenerateTxtFromId='.$rowData['id'].'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $deleteHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetDeleteRecordId='.$rowData['id'].'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $deleteLink = 'javascript:if(confirm(\'Delete record from database?\')) window.location.assign(\''.$deleteHref.'\');';
    if($this->selectedTable != 'skynet_chain')
    {
      $deleteStr = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete'), false, 'aDelete');
    }
    $td[] = '<td>'.$this->elements->addUrl($txtLink, $this->elements->addBold('Generate TXT'), false, 'aTxtGen').' '.$deleteStr.'</td>';
    
    return '<tr>'.implode('', $td).'</tr>';    
  }
}