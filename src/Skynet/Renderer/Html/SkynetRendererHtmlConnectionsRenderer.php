<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlConnectionsRenderer.php
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

use Skynet\Data\SkynetParams;
use Skynet\Renderer\SkynetRendererAbstract;

 /**
  * Skynet Renderer HTML Connections Renderer
  */
class SkynetRendererHtmlConnectionsRenderer extends SkynetRendererAbstract
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetParams[] Params */
  private $params;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();
    $this->params = new SkynetParams;
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
  * Renders go to connection form
  *
  * @param mixed[] $connectionsDataArray ConnectionsData
  *
  * @return string HTML code
  */   
  public function renderGoToConnection($connectionsDataArray)
  {   
    $options = [];
    $options[] = '<option value="0"> --- choose from list --- </option>';
    $conns = count($connectionsDataArray);
    if($conns == 0) return false;
    
    for($i = 1; $i <= $conns; $i++)
    {
      $url = '';
      $j = $i - 1;
      if(isset($connectionsDataArray[$j]['CLUSTER URL'])) 
      {
        $url = $connectionsDataArray[$j]['CLUSTER URL'];
      }
      $url = str_replace(array('http://', 'https://'), '', $url);
      if(strlen($url) > 20)
      {
        $url = substr($url, 0, 20).'...'.basename($url);
      }      
      
      $options[] = '<option value="'.$i.'">#'.$i.' ('.$url.')</option>';     
    }   
      
    return '<form method="GET" action="" class="formConnections">
    Go to connection: <select id="connectList" onchange="skynetControlPanel.gotoConnection();" name="_go">'.implode('', $options).'</select></form>';      
  }  
    
 /**
  * Parses array 
  * 
  * @param mixed $fields Array with fields
  *
  * @return string HTML code
  */    
  public function parseParamsArray($fields)
  {
    $rows = [];    
    foreach($fields as $key => $field)
    {
      $paramName = $this->params->translateInternalParam(htmlspecialchars($field->getName(), ENT_QUOTES, "UTF-8"));
      $rows[] = $this->elements->addValRow('<b>'.$paramName.'</b>', str_replace(array("<", ">"), array("&lt;", "&gt;"), $field->getValue()));         
    }
    
    if(count($rows) > 0)
    {      
      return implode('', $rows);       
    } else {
      return $this->elements->addRow(' -- no data -- ');
    }  
  }
  
 /**
  * Parses connection array data fields
  *
  * @param string[] $fields Array of fields arrays
  * @param string $clusterUrl
  *
  * @return string HTML code
  */   
  public function parseConnectionFields($fields, $clusterUrl, $id)
  {
    $names = [
      'request_raw' => ['Request Fields {sended} (plain) '.$this->elements->getGt().$this->elements->getGt().' to: '.$this->elements->addSpan($clusterUrl, 't'), ''],
      'request_encypted' => ['Request Fields {sended} (encrypted) '.$this->elements->getGt().$this->elements->getGt().' to: '.$this->elements->addSpan($clusterUrl, 't'), ''],
      'response_raw' => ['Response Fields {received} (raw) '.$this->elements->getLt().$this->elements->getLt().' from: '.$this->elements->addSpan($clusterUrl, 't'), ''],
      'response_decrypted' => ['Response Fields {received} (decrypted) '.$this->elements->getLt().$this->elements->getLt().' from: '.$this->elements->addSpan($clusterUrl, 't'), '']
      ];      
    
    $rows = [];   
    
    $rows[] = $this->elements->addSectionClass('tabConnPlain'.$id);
    $rows[] = '<table>';
    $rows[] = $this->elements->addHeaderRow($this->elements->addH3('[ '.$names['request_raw'][0].' ]'));
    $rows[] = $this->parseParamsArray($fields['request_raw']);      
    $rows[] = '</table>';      
    
    $rows[] = '<table>';
    $rows[] = $this->elements->addHeaderRow($this->elements->addH3('[ '.$names['response_decrypted'][0].' ]'));
    $rows[] = $this->parseParamsArray($fields['response_decrypted']);      
    $rows[] = '</table>'; 
    $rows[] = $this->elements->addSectionEnd();
    
    $rows[] = $this->elements->addSectionClass('hide tabConnEncrypted'.$id);
    $rows[] = '<table>';
    $rows[] = $this->elements->addHeaderRow($this->elements->addH3('[ '.$names['request_encypted'][0].' ]'));
    $rows[] = $this->parseParamsArray($fields['request_encypted']);      
    $rows[] = '</table>';     
    
    $rows[] = '<table>';
    $rows[] = $this->elements->addHeaderRow($this->elements->addH3('[ '.$names['response_raw'][0].' ]'));
    $rows[] = $this->parseParamsArray($fields['response_raw']);      
    $rows[] = '</table>'; 
    $rows[] = $this->elements->addSectionEnd();
    
    return implode('', $rows);    
  } 
 
 /**
  * Renders tabs
  *
  * @return string HTML code
  */  
  public function renderConnectionTabs($id = 0)
  {
    $output = [];
    $output[] = '<div class="tabsHeader">';
    $output[] = '<a class="tabConnPlainBtn'.$id.' active" href="javascript:skynetControlPanel.switchConnTab(\'tabConnPlain\', '.$id.');">Plain data</a> <a class="tabConnEncryptedBtn'.$id.' errors" href="javascript:skynetControlPanel.switchConnTab(\'tabConnEncrypted\', '.$id.');">Encrypted data</a> <a class="tabConnRawBtn'.$id.'" href="javascript:skynetControlPanel.switchConnTab(\'tabConnRaw\', '.$id.');">Raw data</a>';
    $output[] = '</div>';    
    return implode($output);
  }
  
 /**
  * Parses connection params array
  *
  * @param string[] $connData Array of connection data params
  *
  * @return string HTML code
  */ 
  public function parseConnection($connData)
  {
    $rows = [];
    $rows[] = 
      $this->elements->addHtml('<a name="_connection'.$connData['id'].'"></a>').
      $this->elements->addH2('@'.$connData['id'].' Connection {').
      $this->elements->addH3('@ClusterAddress: '.$this->elements->addUrl($connData['CLUSTER URL']));
    
    
    $rows[] = $this->renderConnectionTabs($connData['id']);
      
    $paramsFields = ['SENDED PARAMS', 'SENDED HEADER PARAMS (broadcast)'];  
    $rawDataFields = ['RECEIVED RAW DATA', 'RECEIVED RAW HEADER (broadcast)'];
    
    $rows[] = '<table>';
    $parsedValue = $this->elements->addUrl($connData['CLUSTER URL']);
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('CLUSTER URL').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $parsedValue);    
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('Connection number').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $connData['id']);    
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('Ping').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $connData['Ping']);   
    $rows[] = '</table>';
    
    
    $rows[] = $this->parseConnectionFields($connData['FIELDS'], $connData['CLUSTER URL'], $connData['id']);
    
    
    $rows[] = $this->elements->addSectionClass('hide tabConnRaw'.$connData['id']);
    $rows[] = '<table>';
    $parsedValue = $this->parseDebugParams($connData['SENDED PARAMS']);
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('CLUSTER URL').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $parsedValue);
    
    $parsedValue = $this->parseDebugParams($connData['SENDED HEADER PARAMS (broadcast)']);
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('SENDED HEADER PARAMS (broadcast)').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $parsedValue);
    
    $parsedValue = $this->parseResponseRawData($connData['RECEIVED RAW DATA']);
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('RECEIVED RAW DATA').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $parsedValue);
    
    $parsedValue = $this->parseResponseRawData($connData['RECEIVED RAW HEADER (broadcast)']);
    $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper('RECEIVED RAW HEADER (broadcast)').' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $parsedValue);
    $rows[] = '</table>';
    $rows[] = $this->elements->addSectionEnd();   
    
    
    $rows[] = $this->elements->addH2('}');
    return implode('', $rows);    
  }

 /**
  * Parses connections data array
  *
  * @param mixed[] $connectionsDataArray Connections data array
  *
  * @return string HTML code
  */  
  public function renderConnections($connectionsDataArray)
  {
    $parsed = [];
    foreach($connectionsDataArray as $connData)
    {
      $parsed[] = $this->parseConnection($connData);
    }        
    return implode($this->elements->getSeparator(), $parsed);
  }
  
 /**
  * Parses raw JSON response, bolds keys
  *
  * @param string $data Raw JSON response
  *
  * @return string Parsed JSON response
  */
  public function parseResponseRawData($data)
  {
    if(!empty($data))
    {
      return str_replace(array('{"', '":', '","'), array('{<b>"', '":</b>', '", <b>"'), $data);
    } else {
      return ' -- no data -- ';
    }
  }

 /**
  * Parses params array
  *
  * @param mixed[] $params Array of params
  *
  * @return string Parsed string
  */
  public function parseDebugParams($params)
  {
    if(!is_array($params) || count($params) == 0) 
    {
      return null;
    }
    $fields = [];
    foreach($params as $k => $v)
    {
      $fields[] = '<b>'.$k.'=</b>'.$v;
    }
    return implode(';'.$this->elements->getNl(), $fields);
  }
  
 /**
  * Renders and returns connections view
  *
  * @return string HTML code
  */    
  public function render($ajax = false)
  {
    if($ajax)
    {
      return $this->renderConnections($this->connectionsData);
    }
    
    $output = [];   
    /* Center Main : Right Column: */
    $output[] = $this->elements->addSectionClass('columnConnections'); 
    
    $output[] = $this->elements->addSectionClass('innerConnectionsOptions'); 
    $output[] = '<div class="reconnectArea">@Auto-reconnect interval: <input value="0" type="text" id="connIntervalValue" name="connectionInterval"> seconds <input type="button" onclick="skynetControlPanel.setConnectInterval(\''.basename($_SERVER['PHP_SELF']).'\')" value="OK"> (<span id="connIntervalStatus">disabled</span>)</div>';
    $output[] = $this->elements->addSectionEnd();      
    
    $output[] = $this->elements->addSectionClass('innerConnectionsData'); 
    $output[] = $this->renderConnections($this->connectionsData);
    $output[] = $this->elements->addSectionEnd();  
    
    $output[] = $this->elements->addSectionEnd();  
    return implode('', $output);      
  } 
}