<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlDatabaseRenderer.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Renderer\Html;

use Skynet\Database\SkynetDatabase;
use Skynet\Database\SkynetDatabaseSchema;
use Skynet\Common\SkynetHelper;
use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Cluster\SkynetCluster;

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
  
  /** @var SkynetDatabaseSchema DB Schema */
  protected $databaseSchema;
  
  /** @var PDO Connection instance */
  protected $db;
  
  /** @var string[] Array with tables fields */
  protected $tablesFields = [];
  
  /** @var string Sort by */
  protected $tableSortBy;
  
  /** @var string Sort order */
  protected $tableSortOrder;
  
  /** @var int EditID */
  protected $tableEditId = 0;
  
  /** @var int Current pagination */
  protected $tablePage;
  
  /** @var int Limit records per page */
  protected $tablePerPageLimit;
  
  /** @var SkynetClustersRegistry Clusters */
  protected $clustersRegistry;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();
    $this->database = SkynetDatabase::getInstance();  
    $this->databaseSchema = new SkynetDatabaseSchema;    
    $this->dbTables = $this->databaseSchema->getDbTables();   
    $this->tablesFields = $this->databaseSchema->getTablesFields();
    $this->tablePerPageLimit = 20;
    $this->clustersRegistry = new SkynetClustersRegistry();
    
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
    
    if(isset($_REQUEST['_skynetEditId']) && !empty($_REQUEST['_skynetEditId']) && is_numeric($_REQUEST['_skynetEditId']))
    {
      $this->tableEditId = intval($_REQUEST['_skynetEditId']);
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
  * Delete controller
  *
  * @return string HTML code
  */   
  private function deleteRecord()
  {
    $output = [];
    
    if($this->selectedTable != 'skynet_chain')
    {
      if(isset($_REQUEST['_skynetDeleteRecordId']) && !empty($_REQUEST['_skynetDeleteRecordId']) && is_numeric($_REQUEST['_skynetDeleteRecordId']))
      {
        /* If cluster delete then add cluster to blocked list */
        if($this->selectedTable == 'skynet_clusters')
        {
          $row = $this->database->ops->getTableRow($this->selectedTable, intval($_REQUEST['_skynetDeleteRecordId']));
          $cluster = new SkynetCluster;
          $cluster->setUrl($row['url']);
          $this->clustersRegistry->addBlocked($cluster);          
        }
    
        if($this->database->ops->deleteRecordId($this->selectedTable, intval($_REQUEST['_skynetDeleteRecordId'])))
        {
          $output[] = $this->elements->addMonitOk('Record deleted.');
        } else {
          $output[] = $this->elements->addMonitError('Record delete error.');
        }
      }    

      if(isset($_REQUEST['_skynetDeleteAllRecords']) && $_REQUEST['_skynetDeleteAllRecords'] == 1)
      {
        if($this->database->ops->deleteAllRecords($this->selectedTable))
        {
          $output[] = $this->elements->addMonitOk('All records deleted.');
        } else {
          $output[] = $this->elements->addMonitError('All records delete error.');
        }
      }   
    } 
    
    
    
    
    return implode('', $output);
  }

 /**
  * Inserts record
  *
  * @return string HTML result
  */    
  private function newRecord()
  {
    $output = [];
    
    $data = [];
    $fields = $this->tablesFields[$this->selectedTable];
    
    foreach($fields as $k => $v)
    {
      if($k != 'id')
      {
        $data[$k] = '';
        if(isset($_POST['record_'.$k]))
        {
          $data[$k] = $_POST['record_'.$k];
        }        
      }      
    }     
   
    if($this->database->ops->newRow($this->selectedTable, $data))
    {     
      $output[] = $this->elements->addMonitOk('Record inserted');
    } else {
      $output[] = $this->elements->addMonitError('Record insert error.');
    } 
    return implode('', $output);
  }
  
 /**
  * Updates record
  *
  * @return string HTML result
  */    
  private function updateRecord()
  {
    $output = [];
    
    $data = [];
    $fields = $this->tablesFields[$this->selectedTable];
    
    foreach($fields as $k => $v)
    {
      if($k != 'id')
      {
        $data[$k] = '';
        if(isset($_POST['record_'.$k]))
        {
          $data[$k] = $_POST['record_'.$k];
        }        
      }      
    }     
   
    if($this->database->ops->updateRow($this->selectedTable, $this->tableEditId, $data))
    {     
      $output[] = $this->elements->addMonitOk('Record updated');
    } else {
      $output[] = $this->elements->addMonitError('Record update error.');
    } 
    return implode('', $output);
  }  
    
 /**
  * Renders and returns records
  *
  * @return string HTML code
  */  
  public function renderDatabaseView()
  {
    $output = [];
    
    $recordRows = [];    
    $start = 0;
    if($this->tablePage > 1)
    {
      $min = (int)$this->tablePage - 1;
      $start = $min * $this->tablePerPageLimit;
    }
    
    $output[] = $this->deleteRecord();
    $rows = $this->database->ops->getTableRows($this->selectedTable, $start, $this->tablePerPageLimit, $this->tableSortBy, $this->tableSortOrder);
    
    if(isset($_REQUEST['_skynetSaveRecord']))
    {
      $output[] = $this->updateRecord();
    }   

    if(isset($_REQUEST['_skynetInsertRecord']))
    {
      $output[] = $this->newRecord();
    }     
    
    if(!empty($this->tableEditId))
    {
      $output[] = $this->renderEditForm();
    } elseif(isset($_REQUEST['_skynetNewRecord']))
    {
      $output[] = $this->renderEditForm(true);
    }
    
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
      
      $allRecords = $this->database->ops->countTableRows($this->selectedTable);
      
      $output[] = $this->elements->beginTable('dbTable');   
      $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle($this->selectedTable.' ('.$i.'/'.$allRecords.')').$this->getNewButton(), count($fields) + 1);      
      $output[] = implode('', $recordRows);
      $output[] = $this->elements->endTable();
      
      return implode('', $output);
      
    } else {
      
      $fields = $this->tablesFields[$this->selectedTable];   
      $header = $this->renderTableHeader($fields);      
     
      $output[] = $this->elements->beginTable('dbTable'); 
      $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle($this->selectedTable).$this->getNewButton(), count($fields) + 1);
      $output[] = $header;           
      $output[] = $this->elements->addRow('No records', count($fields) + 1);
      $output[] = $this->elements->endTable();
      
      return implode('', $output);
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
      $numRecords = $this->database->ops->countTableRows($k);
      
      if($k == $this->selectedTable)
      {
        $options[] = $this->elements->addOption($k, $v.' ('.$numRecords.')', true);
      } else {
        $options[] = $this->elements->addOption($k, $v.' ('.$numRecords.')');
      }
    }   
      
    return '<form method="GET" action="">
    Select database table: <select name="_skynetDatabase">'.implode('', $options).'</select>
    <input type="submit" value="Show stored data"/>
    <input type="hidden" name="_skynetView" value="database" />
    </form>'.$this->renderTableSorter();      
  }

 /**
  * Renders new record btn
  *
  * @return string HTML code
  */ 
  private function getNewButton()
  {
    $newHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetNewRecord=1&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;    
    return $this->elements->getNl().$this->elements->addUrl($newHref, $this->elements->addBold('[+] New record'), false, 'btnNormal').$this->elements->getNl().$this->elements->getNl();
  }  
  
 /**
  * Renders edit form
  *
  * @return string HTML code
  */   
  public function renderEditForm($new = false)
  {  
    $output = [];
    $deleteHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetDeleteRecordId='.$this->tableEditId.'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $deleteLink = 'javascript:if(confirm(\'Delete record from database?\')) window.location.assign(\''.$deleteHref.'\');';
    $saveBtn = '<input type="submit" value="Save record"/>';    
    $deleteBtn = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete'), false, 'btnDelete');
    $actionsEdit = $saveBtn.' '.$deleteBtn;
    $actionsNew = '<input type="submit" value="Add record"/>';
    
    $formAction = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $output[] = '<form method="POST" action="'.$formAction.'">';
    $output[] = $this->elements->beginTable('dbTable'); 
    
    if($new)
    {
       $title = $this->elements->addSubtitle($this->selectedTable.' | CREATING NEW RECORD');
    } else {
       $title = $this->elements->addSubtitle($this->selectedTable.' | EDITING RECORD ID: '.$this->tableEditId);
    }
   
    $output[] = $this->elements->addHeaderRow($title, 2);
    
    if($new)
    {
      $output[] = $this->elements->addFormActionsRow($actionsNew);  
    } else{
      $output[] = $this->elements->addFormActionsRow($actionsEdit);  
    }      
    
    $fields = $this->tablesFields[$this->selectedTable]; 
    
    foreach($fields as $k => $v)
    {
      if($new)
      {
        if($k != 'id')
        {
          $output[] = $this->elements->addFormRow($this->elements->addSubtitle($v).'<br>('.$k.')', '<textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" name="record_'.$k.'"></textarea>'); 
        } 
        
      } else {
        $row = $this->database->ops->getTableRow($this->selectedTable, $this->tableEditId);
        if($k == 'id')
        {
          $output[] = $this->elements->addFormRow($this->elements->addSubtitle($v).'<br>('.$k.')', '<textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" name="record_'.$k.'" readonly>'.htmlentities($row[$k]).'</textarea>'); 
        } else {
          $output[] = $this->elements->addFormRow($this->elements->addSubtitle($v).'<br>('.$k.')', '<textarea autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" name="record_'.$k.'">'.htmlentities($row[$k]).'</textarea>');    
        }
      }
    }    
    
    if($new)
    {
      $output[] = $this->elements->addFormActionsRow($actionsNew);
      $output[] = $this->elements->addFormActionsRow('<input type="hidden" name="_skynetInsertRecord" value="1">');      
    } else {
      $output[] = $this->elements->addFormActionsRow($actionsEdit);  
      $output[] = $this->elements->addFormActionsRow('<input type="hidden" name="_skynetSaveRecord" value="1">');      
    }
    
    $output[] = $this->elements->endTable();
    $output[] = '</form>';
    
    return implode('', $output); 
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
   
    $numRecords = $this->database->ops->countTableRows($this->selectedTable);
    $numPages = (int)ceil($numRecords / $this->tablePerPageLimit);    
    $order = ['ASC' => 'Ascending', 'DESC' => 'Descending'];    
    
    foreach($this->tablesFields[$this->selectedTable] as $k => $v)
    {     
      if($k == $this->tableSortBy)
      {
        $optionsSortBy[] = $this->elements->addOption($k, $v, true);
      } else {
        $optionsSortBy[] = $this->elements->addOption($k, $v);
      }
    }   
    
    foreach($order as $k => $v)
    {     
      if($k == $this->tableSortOrder)
      {
        $optionsOrderBy[] = $this->elements->addOption($k, $v, true);
      } else {
        $optionsOrderBy[] = $this->elements->addOption($k, $v);
      }
    }   
    for($i = 1; $i <= $numPages; $i++)
    {    
      if($i == $this->tablePage)
      {
        $optionsPages[] = $this->elements->addOption($i, $i.' / '.$numPages, true);
      } else {
        $optionsPages[] = $this->elements->addOption($i, $i.' / '.$numPages);
      }
    }      
    
    $deleteHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetDeleteAllRecords=1&_skynetPage=1&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $allDeleteLink = '';
    
    if($this->database->ops->countTableRows($this->selectedTable) > 0 && $this->selectedTable != 'skynet_chain')
    {
      $deleteLink = 'javascript:if(confirm(\'Delete ALL RECORDS from this table?\')) window.location.assign(\''.$deleteHref.'\');';
      $allDeleteLink = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete ALL RECORDS'), false, 'btnDelete');
    }   
    
    $output = [];
    $output[] = '<form method="GET" action="">';
    if($this->database->ops->countTableRows($this->selectedTable) > 0)
    {
      $output[] = 'Page:<select name="_skynetPage">'.implode('', $optionsPages).'</select> ';
    }
    $output[] = 'Sort By: <select name="_skynetSortBy">'.implode('', $optionsSortBy).'</select>  ';
    $output[] = '<select name="_skynetSortOrder">'.implode('', $optionsOrderBy).'</select> ';
    $output[] = '<input type="submit" value="Execute"/> '.$allDeleteLink;
    $output[] = '<input type="hidden" name="_skynetView" value="database"/>';
    $output[] = '<input type="hidden" name="_skynetDatabase" value="'.$this->selectedTable.'"/>';
    $output[] = '</form>';

    return implode('', $output);
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
    $td[] = '<th>Save as TXT / Edit / Delete</th>';         
    return '<tr>'.implode('', $td).'</tr>';    
  }

 /**
  * Decorates data
  *  
  * @param string $rowName
  * @param string $rowValue
  *
  * @return string Decorated value
  */  
  private function decorateData($rowName, $rowValue)
  {
    $typesTime = ['created_at', 'updated_at', 'last_connect'];
    $typesSkynetId = ['skynet_id'];
    $typesUrl = ['sender_url', 'receiver_url', 'ping_from', 'url', 'remote_cluster'];
    $typesData = [];
    
    if(in_array($rowName, $typesTime) && is_numeric($rowValue))
    {
      $rowValue = date(\SkynetUser\SkynetConfig::get('core_date_format'), $rowValue);
    }
    
    if(in_array($rowName, $typesUrl) && !empty($rowValue))
    {     
      $urlName = $rowValue;
      if(SkynetHelper::getMyUrl() == $rowValue)
      {
        $urlName = '<span class="marked"><b>[ME]</b> '.$rowValue.'</span>';
      }
      $rowValue = $this->elements->addUrl(\SkynetUser\SkynetConfig::get('core_connection_protocol').$rowValue, $urlName);
    }
    
    if(in_array($rowName, $typesSkynetId) && !empty($rowValue))
    {
      $rowValue = $this->elements->addSpan($rowValue, 'marked');
    }
    
    if(empty($rowValue)) 
    {
      $rowValue = '-';
    }
    
    return str_replace("; ", ";<br>", $rowValue);
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
    
    foreach($fields as $k => $v)
    {
      if(array_key_exists($k, $rowData))
      {
        $data = htmlentities($rowData[$k]);       
        
        $data = $this->decorateData($k, $data);
        
        $td[] = '<td>'.$data.'</td>';
      }     
    }
    $deleteStr = '';
    $txtLink = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetGenerateTxtFromId='.$rowData['id'].'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $deleteHref = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetDeleteRecordId='.$rowData['id'].'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $editLink = '?_skynetDatabase='.$this->selectedTable.'&_skynetView=database&_skynetEditId='.$rowData['id'].'&_skynetPage='.$this->tablePage.'&_skynetSortBy='.$this->tableSortBy.'&_skynetSortOrder='.$this->tableSortOrder;
    $deleteLink = 'javascript:if(confirm(\'Delete record from database?\')) window.location.assign(\''.$deleteHref.'\');';
    if($this->selectedTable != 'skynet_chain')
    {
      $deleteStr = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete'), false, 'btnDelete');
    }
    $editStr = $this->elements->addUrl($editLink, $this->elements->addBold('Edit'), false, 'btnNormal'); 
    $td[] = '<td class="tdActions">'.$this->elements->addUrl($txtLink, $this->elements->addBold('Generate TXT'), false, 'btnNormal').' '.$editStr.' '.$deleteStr.'</td>';
    
    return '<tr>'.implode('', $td).'</tr>';    
  }
}