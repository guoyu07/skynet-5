<?php

/**
 * Skynet/Renderer/Cli/SkynetRendererCliConnectionsRenderer.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Renderer\Cli;

 /**
  * Skynet Renderer HTML Connections Renderer
  */
class SkynetRendererCliConnectionsRenderer
{   
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererCliElements();
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
  * Parses array 
  * 
  * @param string[] $fields Array with fields
  * @param string[] $onlyFields Only selected fields
  *
  * @return string HTML code
  */    
  public function parseParamsArray($fields, $onlyFields = null)
  {
    $rows = [];    
    foreach($fields as $key => $value)
    {
      if($onlyFields === null)
      {
        $rows[] = strip_tags($value);  
      } else {
        
        if(is_array($onlyFields))
        {
          if(in_array($key, $onlyFields))
          {
            $rows[] = strip_tags($value);   
          }
        } else {
          
          $rows[] = strip_tags($value);  
        }
      }      
    }
    return implode(';'.$this->elements->getNl(), $rows);        
  }
  
 /**
  * Parses connection array data fields
  *
  * @param string[] $fields Array of fields arrays
  * @param string $clusterUrl
  * @param string[] $onlyFields Only selected fields
  *
  * @return string HTML code
  */   
  public function parseConnectionFields($fields, $clusterUrl, $onlyFields = null)
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
      if($onlyFields === null)
      {
        $rows[] = 
        $this->elements->addH3('[### '.$names[$key].' ###]').
        $this->parseParamsArray($value);
      } else {
        if($key == 'response_decrypted')
        {
          $rows[] = $clusterUrl." {\n".$this->parseParamsArray($value, $onlyFields)."\n}";
        }
      }      
    }
    if($onlyFields === null)
    {
      return implode($this->elements->getNl().$this->elements->getSeparator().$this->elements->getNl(), $rows);   
    } else {
      return implode($this->elements->getNl(), $rows); 
    }    
  }
 
 /**
  * Parses connection params array
  *
  * @param string[] $connData Array of connection data params
  * @param string[] $onlyFields Only selected fields
  *
  * @return string HTML code
  */ 
  public function parseConnection($connData, $onlyFields = null)
  {
    $rows = [];
    
    if($onlyFields === null)
    {
      $rows[] =     
      $this->elements->addH2('@'.$connData['id'].' Connection {').
      $this->elements->addH3('@ClusterAddress: '.$this->elements->addUrl($connData['CLUSTER URL']));
    }
      
    $paramsFields = ['SENDED PARAMS', 'SENDED HEADER PARAMS'];  
    $rawDataFields = ['RECEIVED RAW DATA', 'RECEIVED RAW HEADER'];
      
    foreach($connData as $key => $value)
    {
      $parsedValue = $value;
      
      if($key == 'FIELDS')
      {
        $rows[] = $this->parseConnectionFields($value, $connData['CLUSTER URL'], $onlyFields);
                
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
        
        if($onlyFields === null)
        {
           $rows[] = $this->elements->addBold('#'.strtoupper($key).' '.$this->elements->getGt().$this->elements->getGt().$this->elements->getGt(), 'marked').' '.$parsedValue;   
        }
      }        
    }
    
    if($onlyFields === null)
    {
       $rows[] = $this->elements->addH2('}');
    }
    return implode($this->elements->getNl().$this->elements->getNl(), $rows);    
  }

 /**
  * Parses connections data array
  *
  * @param mixed[] $connectionsDataArray Connections data array
  * @param string[] $onlyFields Only selected fields
  *
  * @return string HTML code
  */  
  public function renderConnections($connectionsDataArray, $onlyFields = null)
  {
    $parsed = [];
    foreach($connectionsDataArray as $connData)
    {
      $parsed[] = $this->parseConnection($connData, $onlyFields);
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
    return $data;
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
      $fields[] = $k.': '.$v;
    }
    return implode('; ', $fields);
  }
}