<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmLogsRenderer.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.2.0
 */

namespace Skynet\Renderer\Html;

use Skynet\Common\SkynetHelper;
use Skynet\Secure\SkynetVerifier;

 /**
  * Skynet Renderer HTML Database Renderer
  *
  */
class SkynetRendererHtmlLogsRenderer
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var string Error types */
  protected $showType = 'all';
  
  /** @var SkynetVerifier Verifier */
  protected $verifier;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();      
    $this->verifier = new SkynetVerifier();
    
    /* Switch types */
    if(isset($_REQUEST['_skynetLogShowType']) && !empty($_REQUEST['_skynetLogShowType']))
    {
      $this->showType = $_REQUEST['_skynetLogShowType'];
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
  private function deleteFiles()
  {
    $output = [];    
    
    if(isset($_REQUEST['_skynetDeleteLogFile']) && isset($_REQUEST['_skynetLogFile']) && !empty($_REQUEST['_skynetLogFile']))
    {
      if(@unlink(urldecode($_REQUEST['_skynetLogFile'])))
      {
        $output[] = $this->elements->addMonitOk('File "'.urldecode($_REQUEST['_skynetLogFile']).'" deleted.');
      } else {
        $output[] = $this->elements->addMonitError('File "'.urldecode($_REQUEST['_skynetLogFile']).'" delete error.');
      }
    }
    
    if(isset($_REQUEST['_skynetDeleteAllLogFiles']))
    {
      $logsDir = \SkynetUser\SkynetConfig::get('logs_dir');
      if(!empty($logsDir) && substr($logsDir, -1) != '/')
      {
        $logsDir.= '/';
      }
      
      $prefix = '';      
      if($this->showType != 'all')
      {
        $prefix = '*_'.$this->showType.'_';
      }        
      
      $pattern = $prefix.'*.txt';
      $d = glob($logsDir.$pattern);    
      $countFiles = count($d);
      
      if($countFiles > 0)
      {
        $i = 0; 
        foreach($d as $file)
        {
          if(@unlink($file))
          {
            $i++;
          }
        }      
      } 
      
      if($i > 0)
      {
        $output[] = $this->elements->addMonitOk($i.' files deleted in directory "'.$logsDir.'"');
      } else {
        $output[] = $this->elements->addMonitError('Files delete error. Deleted files: 0');
      }      
    }
    
    return implode('', $output);
  }
    
 /**
  * Renders and returns txt logs
  *
  * @return string HTML code
  */  
  public function render()
  {  
    $output = [];
    $fields = [];
    $fields['no'] = 'No.'; 
    $fields['filename'] = 'File name'; 
    $fields['time'] = 'Time';      
    $fields['type'] = 'Event';  
    $fields['context'] = 'Context';  
    $fields['cluster'] = 'Cluster';  
    
    $output[] = $this->renderTypesSorter();
    
    $output[] = $this->deleteFiles();

    $logsDir = \SkynetUser\SkynetConfig::get('logs_dir');
    if(!empty($logsDir) && substr($logsDir, -1) != '/')
    {
      $logsDir.= '/';
    }
    
    $prefix = '';
    
    $types = [];
    $types['all'] = '--All--';
    $types['log'] = 'User Logs';
    $types['error'] = 'Errors-';
    $types['access'] = 'Access Errors';
    $types['request'] = 'Requests';
    $types['response'] = 'Responses';   
    $types['echo'] = 'Echo';
    $types['broadcast'] = 'Broadcast';
    $types['selfupdate'] = 'Self-update';
    
    if($this->showType != 'all')
    {
      $prefix = '*_'.$this->showType.'_';
    }        
    
    $pattern = $prefix.'*.txt';
    $d = glob($logsDir.$pattern);    
    $countFiles = count($d);
    
    if($countFiles > 0)
    {
      $i = 1;
      rsort($d);
      $files = [];
      foreach($d as $file)
      {
        $files[] = $this->renderTableRow($i, $logsDir, $file);
        $i++;
      }      
    }    
    
    $dirPath = SkynetHelper::getMyServer().'/'.$logsDir;
    $dirName = $logsDir.$pattern;
    $header = $this->renderTableHeader($fields);    
    $txtTitle =  $this->elements->addSectionClass('txtTitle').$this->elements->addSubtitle($dirName).$this->elements->getNl().$dirPath.' ('.$countFiles.')'.$this->elements->addSectionEnd();    
    
    $output[] = $this->elements->beginTable('txtTable'); 
    $output[] = $this->elements->addHeaderRow($txtTitle, count($fields) + 1);
    $output[] = $header;
    if($countFiles > 0)
    {
      $output[] = implode('', $files);
      
    } else {
      
      $output[] = $this->elements->addRow('No .txt log files', count($fields) + 1);
    }
    $output[] = $this->elements->endTable();
    
    return implode('', $output);
  } 
   
 /**
  * Renders and returns types switch
  *
  * @return string HTML code
  */   
  private function renderTypesSorter()
  {
    $options = [];      
   
    $types = [];
    $types['all'] = '--All--';
    $types['log'] = 'User Logs';
    $types['error'] = 'Errors-';
    $types['access'] = 'Access Errors';
    $types['request'] = 'Requests';
    $types['response'] = 'Responses';   
    $types['echo'] = 'Echo';
    $types['broadcast'] = 'Broadcast';
    $types['selfupdate'] = 'Self-update';
    
    foreach($types as $k => $v)
    {     
      if($k == $this->showType)
      {
        $options[] = $this->elements->addOption($k, $v, true);
      } else {
        $options[] = $this->elements->addOption($k, $v);
      }
    }     
    
    $deleteHref = '?_skynetView=logs&_skynetDeleteAllLogFiles=1&_skynetLogShowType='.$this->showType;   
    $allDeleteLink = '';  
    $deleteLink = 'javascript:if(confirm(\'Delete ALL TXT LOG FILES?\')) window.location.assign(\''.$deleteHref.'\');';
    $allDeleteLink = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete ALL TXT FILES'), false, 'btnDelete');
         
    $output = [];
    $output[] = '<form method="GET" action="">';   
    $output[] = 'Show logs: <select name="_skynetLogShowType">'.implode('', $options).'</select>  ';  
    $output[] = '<input type="submit" value="Show"/> '.$allDeleteLink;
    $output[] = '<input type="hidden" name="_skynetView" value="logs"/>';    
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
    $td[] = '<th>Delete</th>';         
    return '<tr>'.implode('', $td).'</tr>';    
  }
 
 /**
  * Renders and returns single record
  *  
  * @param int $number Row number
  * @param string $logsDir Dir
  * @param string $file Filename
  *
  * @return string HTML code
  */   
  private function renderTableRow($number, $logsDir, $file)
  {    
    $td = [];
    $file = str_replace($logsDir, '', $file);    
    
    $parts = explode('_', $file);
    $time = '';
    $direction = '';
    $context = '';
    $type = '';
    $cluster = '';
    
    if(isset($parts[0]))
    {
      $time = intval($parts[0]);
    }    
    
    if(isset($parts[1]) && $parts[1] == 'log')
    {
      $type = $parts[1];
      
      if(isset($parts[2]))
      {
        $cluster = $parts[2];
      }
      
      if(isset($parts[3]))
      {
        for($i=3; $i < count($parts); $i++)
        {
          $cluster.= '_'.$parts[$i];
        }
      }
      
    } elseif(isset($parts[1]))
    {
      $type = $parts[1];
      
      if(isset($parts[2]))
      {
        $direction = $parts[2]; 
      }  
      
      if(isset($parts[3]))
      {
        $cluster = $parts[3];
      }
      
      if(isset($parts[4]))
      {
        for($i=4; $i < count($parts); $i++)
        {
          $cluster.= '_'.$parts[$i];
        }
      }     
    }    
    
    $cluster = str_replace(array('-', '.txt'), array('/', ''), $cluster);
    $clusterAddr = $cluster;
    $clusterParts = explode('.php', $cluster);
    if(isset($clusterParts[0]))
    {
      $clusterAddr = $clusterParts[0].'.php';
    }
    
    $class = '';
    
    switch($direction)
    {
      case 'in':
        $context = 'RECEIVER';
      break;
      
      case 'out':
        $context = 'SENDER';
        $class = 'marked';
      break;      
    }
    
    $clusterPrefix = '';
    if($this->verifier->isMyUrl($clusterAddr))
    {
      $clusterPrefix = '#[ME] ';
    }
    
    $td[] = '<td>'.$this->elements->addSectionClass($class).$number.')'.$this->elements->addSectionEnd().'</td>';
    $td[] = '<td>'.$this->elements->addUrl($logsDir.$file, $this->elements->addSectionClass($class).$file.$this->elements->addSectionEnd()).'</td>';
    $td[] = '<td>'.$this->elements->addSectionClass($class).date(\SkynetUser\SkynetConfig::get('core_date_format'), $time).$this->elements->addSectionEnd().'</td>';
    $td[] = '<td>'.$this->elements->addSectionClass($class).$type.$this->elements->addSectionEnd().'</td>';
    $td[] = '<td>'.$this->elements->addSectionClass($class).$context.$this->elements->addSectionEnd().'</td>';
    $td[] = '<td>'.$this->elements->addUrl(\SkynetUser\SkynetConfig::get('core_connection_protocol').$clusterAddr, $this->elements->addSectionClass($class).$clusterPrefix.$clusterAddr.$this->elements->addSectionEnd()).'</td>';
   
    $deleteStr = '';   
    $deleteHref = '?_skynetLogFile='.urlencode($logsDir.$file).'&_skynetView=logs&_skynetDeleteLogFile=1&_skynetLogShowType='.$this->showType;   
    $deleteLink = 'javascript:if(confirm(\'Delete .txt file?\')) window.location.assign(\''.$deleteHref.'\');';
    $deleteStr = $this->elements->addUrl($deleteLink, $this->elements->addBold('Delete'), false, 'btnDelete');    
    $td[] = '<td class="tdActions">'.$deleteStr.'</td>';
    
    return '<tr>'.implode('', $td).'</tr>';    
  }
}