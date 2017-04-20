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

 /**
  * Skynet Renderer HTML Connections Renderer
  */
class SkynetRendererHtmlConnectionsRenderer
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
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
      $options[] = '<option value="'.$i.'">#'.$i.' ('.$url.')</option>';     
    }   
      
    return '<form method="GET" action="" class="formConnections">
    Go to connection: <select onchange="if(this.options[this.selectedIndex].value > 0) { window.location.assign(window.location.href.replace(location.hash, \'\') + \'#_connection\' + this.options[this.selectedIndex].value); }" name="_go">'.implode('', $options).'</select></form>';      
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
  public function parseConnectionFields($fields, $clusterUrl)
  {
    $names = [
      'request_raw' => 'Request Fields {sended} (plain) '.$this->elements->getGt().$this->elements->getGt().' to: '.$this->elements->addSpan($clusterUrl, 't'),
      'request_encypted' => 'Request Fields {sended} (encrypted) '.$this->elements->getGt().$this->elements->getGt().' to: '.$this->elements->addSpan($clusterUrl, 't'),
      'response_raw' => 'Response Fields {received} (raw) '.$this->elements->getLt().$this->elements->getLt().' from: '.$this->elements->addSpan($clusterUrl, 't'),
      'response_decrypted' => 'Response Fields {received} (decrypted) '.$this->elements->getLt().$this->elements->getLt().' from: '.$this->elements->addSpan($clusterUrl, 't')
      ];      
    
    $rows = [];   
    foreach($fields as $key => $value)
    {
      $rows[] = 
        $this->elements->addHeaderRow($this->elements->addH3('[ '.$names[$key].' ]')).
        $this->parseParamsArray($value);      
    }
    
    return implode('', $rows);    
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
    $rows[] = '<table>';
      
    $paramsFields = ['SENDED PARAMS', 'SENDED HEADER PARAMS (broadcast)'];  
    $rawDataFields = ['RECEIVED RAW DATA', 'RECEIVED RAW HEADER (broadcast)'];
      
    foreach($connData as $key => $value)
    {
      $parsedValue = $value;
      
      if($key == 'FIELDS')
      {
        $rows[] = $this->parseConnectionFields($value, $connData['CLUSTER URL']);
                
      } else {
        
        $parsedValue = $value;
        
        if($key == 'CLUSTER URL')
        {
          $parsedValue = $this->elements->addUrl($value);
        }
        
        if(in_array($key, $paramsFields))
        {
          $parsedValue = $this->parseDebugParams($value);
          
        } elseif(in_array($key, $rawDataFields))
        {
          $parsedValue = $this->parseResponseRawData($value);
        }        
        
        $rows[] = $this->elements->addValRow($this->elements->addBold('#'.strtoupper($key).' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked'), $parsedValue);   
      }        
    }
    $rows[] = '</table>';
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
    return implode('; ', $fields);
  }
}