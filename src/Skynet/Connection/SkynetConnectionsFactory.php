<?php

/**
 * Skynet/Connection/SkynetConnectionsFactory.php
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

 /**
  * Skynet Connections Factory
  *
  * Factory for connection adapters
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetConnectionsFactory
{
  /** @var SkynetConnectionInterface[] Array of connectors */
  private $connectorsRegistry = [];

  /** @var SkynetConnectionsFactory Instance of this */
  private static $instance = null;

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}

 /**
  * Registers all connection adapters into registry
  */
  private function registerConnectors()
  {
    $this->register('file_get_contents', new SkynetConnectionFileGetContents());
    $this->register('curl', new SkynetConnectionCurl());
  }

 /**
  * Returns choosen adapter
  *
  * @param string $name Name(key) od registered adapter
  *
  * @return SkynetConnectionInterface Connection adapter
  */
  public function getConnector($name = null)
  {
    if($name === null)
    {
      $name = \SkynetUser\SkynetConfig::get('core_connection_type');
    }
    if(array_key_exists($name, $this->connectorsRegistry))
    {
      return $this->connectorsRegistry[$name];
    }
  }

 /**
  * Registers adapter into registry
  *
  * @param string $id Name(key) od registered adapter
  * @param SkynetConnectionInterface $class New Connection adapter instance
  */
  private function register($id, SkynetConnectionInterface $class)
  {
    $this->connectorsRegistry[$id] = $class;
  }

 /**
  * Returns connection adapters array
  *
  * @param string $id Name(key) od registered adapter
  * @param SkynetConnectionInterface $class New Connection adapter instance
  *
  * @return SkynetConnectionInterface[] Connection adapters array
  */
  public function getConnectors()
  {
    return $this->connectorsRegistry;
  }

 /**
  * Checks for connection adapters already registered
  *
  * @return bool True if registered
  */
  public function areRegistered()
  {
    if($this->connectorsRegistry !== null && count($this->connectorsRegistry) > 0) return true;
  }

 /**
  * Returns instance of factory
  *
  * @return SkynetConnectionsFactory Instance of factory
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
      if(!self::$instance->areRegistered()) self::$instance->registerConnectors();
    }
    return self::$instance;
  }
}