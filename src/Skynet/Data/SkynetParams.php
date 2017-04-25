<?php

/**
 * Skynet/Data/SkynetParams.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Data;

 /**
  * Skynet Command
  */
class SkynetParams
{  
 /**
  * Constructor
  */
  public function __construct()
  {
    
  }

 /**
  * Returns packed params
  *
  * @param mixed[] $params Params array
  */
  public function packParams($params)
  {       
    if($params === null)
    {
      return false;
    } 
    
    if(!is_array($params))
    {
      return $params;
      
    } else {
      
      if(count($params) == 1)
      {        
        $key = key($params);
        
        if(!is_array($params[$key]) && is_numeric($key))
        {         
          return $params[$key];
        }
      }
    }
    
    $prefix = '';
    $paramsValues = [];
    $c = count($params);
    if($c > 0)
    {
      foreach($params as $p => $param)
      {
        if(is_array($param))
        {
          foreach($param as $k => $v)
          {
            /* pack into key:value string */
            $safeKey = str_replace(array(':', ';', '$#'), array('$$1$$', '$$2$$', '$$3$$'), $k);
            $safeValue = str_replace(array(':', ';', '$#'), array('$$1$$', '$$2$$', '$$3$$'), $v);
            $paramsValues[] = $safeKey.':'.$safeValue;
          }
          
        } else {
          if(is_numeric($p))
          {
            $paramsValues[] = str_replace(';', '', $param);
          } else {
            $safeKey = str_replace(array(':', ';', '$#'), array('$$1$$', '$$2$$', '$$3$$'), $p);
            $safeValue = str_replace(array(':', ';', '$#'), array('$$1$$', '$$2$$', '$$3$$'), $param);
            $paramsValues[] = $safeKey.':'.$safeValue;            
          }
        } 
        //var_dump($param);        
      }                
    }
    if($c > 0) 
    {
      $prefix = '$#';
    }
    return $prefix.implode(';', $paramsValues); 
  }

 /**
  * Returns unpacked params
  *
  * @param mixed $params Packed params string
  */  
  public function unpackParams($params)
  {
    $params = str_replace('$#', '', $params);
    $e = explode(';', $params);
    
    if(count($e) < 1) return $params;
    $fields = [];
    
    foreach($e as $element)
    {
      if(strpos($element, ':') !== false)
      {
        if(strpos($element, '://') === false)
        {
          /* key => val */
          $parts = explode(':', $element);
          $key = $parts[0];
          $val = str_replace(array('$$1$$', '$$2$$', '$$3$$'), array(':', ';', '$#'), $parts[1]);
          $fields[] = [$key => $val];
        } else {
          $val = str_replace(array('$$1$$', '$$2$$', '$$3$$'), array(':', ';', '$#'), $element);
          $fields[] = $val;
        }
        
      } else {
        /* var */
        $val = $element;
        $fields[] = $val;
      }
    }
    
    //var_dump($fields);    
    return $fields;
  }
  
 /**
  * Checks for params is packed
  *
  * @param bool True if packed
  */  
  public function isPacked($params)
  {
    if(strpos($params, '$#') === 0) 
    {
      return true;
    }
  }
  
  public function isInternal($param)
  {
    if(strpos($param, '_') == 0)
    {
      return true;
    } elseif(strpos($param, '@_') == 0)
    {
      return true;
    }
  }
  
  public function translateInternalParam($param)
  {
    $keys = [];
    
    $keys['skynet'] = 'In Skynet';
    $keys['skynet_chain_new'] = 'New Chain value';
    $keys['skynet_clusters_chain'] = 'Clusters Chain';
    $keys['skynet_id'] = 'Skynet Key ID';
    $keys['skynet_ping'] = 'Ping (microtime)';
    $keys['skynet_hash'] = 'Hash';
    $keys['skynet_chain'] = 'Actual Chain value';
    $keys['skynet_chain_updated_at'] = 'Last update of Chain value';
    $keys['skynet_version'] = 'Skynet Version';
    $keys['skynet_cluster_url'] = 'Cluster address';
    $keys['skynet_cluster_ip'] = 'Cluster IP';
    $keys['skynet_cluster_time'] = 'Time of sent';
    $keys['skynet_clusters'] = 'Clusters chain';
    $keys['skynet_sender_time'] = 'Request sender time';
    $keys['skynet_sender_url'] = 'Request sender address';
    $keys['skynet_checksum'] = 'MD5 checksum';
    
    $prefix = '';
    
    $internal = '_'.$param;
    $internalEcho = '@_'.$param;
    
    if(strpos($param, '_') == 0)
    {
      $check = preg_replace('/^_/', '', $param);
    } elseif(strpos($param, '@_') == 0)
    {
      $check = preg_replace('/^@_/', '', $param);
      $prefix = '@>>';
    }
    
    if(array_key_exists($check, $keys))
    {
      return $prefix.$keys[$check];
    } else {
      return $param;
    }
  }
}