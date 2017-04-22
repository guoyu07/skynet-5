<?php

/**
 * Skynet/Connection/SkynetConnectionFileGetContents.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Connection;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\SkynetVersion;
use Skynet\Common\SkynetTypes;
use Skynet\Error\SkynetException;

 /**
  * Skynet Connection [file_get_contents()]
  *
  * Adapter for simple connection via file_get_contents() function.
  * May be useful if there is no cURL extension on server.
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetConnectionFileGetContents extends SkynetConnectionAbstract implements SkynetConnectionInterface
{
  use SkynetErrorsTrait, SkynetStatesTrait;

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();
  }

 /**
  * Opens connection and gets response data
  *
  * @param string $address URL to connect
  *
  * @return string Received raw data
  */
  private function init($address)
  {
    $data = null; 
    $result = null;
    try 
    {
      if(!\SkynetUser\SkynetConfig::get('core_connection_ssl_verify'))
      {
         $options = array(
          "ssl" => array(
              "verify_peer" => false,
              "verify_peer_name" => false,
          ));
        $data = @file_get_contents($address, false, stream_context_create($options));       
      } else {
        $data = @file_get_contents($address);
      }   
      
      if($data === null || $data === false)
      {
        $result = false;
        throw new SkynetException('DATA IS NULL');
      }    
      
      $preResponse = json_decode($data);
      if($preResponse !== null && isset($preResponse->_skynet))
      {        
        $result = true;
      }     
      
    } catch(SkynetException $e)
    {
      $this->addError(SkynetTypes::FILE_GET_CONTENTS, 'Connection error: NO DATA RECEIVED', $e);            
    }   
    
    $ret['data'] = $data;
    $ret['result'] = $result;
    return $ret;
  }

 /**
  * Connects to remote address and gets response data
  *
  * @param string|null $remote_address URL to connect
  *
  * @return string Raw received data
  */
  public function connect($remote_address = null)
  {
    $this->data = null;
    if($this->cluster !== null) 
    {
      $address = $this->cluster->getUrl();
    }
    if($remote_address !== null) 
    {
      $address = $remote_address;
    }

    if(empty($address) || $address === null)
    {
      $this->addError(SkynetTypes::FILE_GET_CONTENTS, 'Connection error: NO ADDRESS TAKEN');
      return false;
    }

    $this->prepareParams();
    $data = $this->init($address.$this->params);
    $this->data = $data['data'];
    if($this->data === null) 
    {
      $this->addError(SkynetTypes::FILE_GET_CONTENTS, 'Connection error: RESPONSE DATA IS NULL');
    }
    $this->launchConnectListeners($this);
    
    $adapter = [];
    $adapter['data'] = $this->data;
    $adapter['params'] = $this->requests;
    $adapter['result'] = $data['result'];
      
    return $adapter;
  }

 /**
  * Parse params into string (for debug)
  */
  public function prepareParams()
  {
    $fields = [];

    if(is_array($this->requests) && count($this->requests) > 0)
    {
      foreach($this->requests as $fieldKey => $fieldValue)
      {
        $fields[] = $fieldKey.'='.$fieldValue;
      }
      if(count($fields) > 0) 
      {
        $this->params = '?'.implode('&', $fields);
      }
    }
  }
}