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
    if(!\SkynetUser\SkynetConfig::get('core_connection_ssl_verify'))
    {
       $options = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ));
      return file_get_contents($address, false, stream_context_create($options));
    } else {
      return file_get_contents($address);
    }
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
    $this->data = $this->init($address.$this->params);
    if($this->data === null) 
    {
      $this->addError(SkynetTypes::FILE_GET_CONTENTS, 'Connection error: RESPONSE DATA IS NULL');
    }
    $this->launchConnectListeners();
    return $this->data;
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