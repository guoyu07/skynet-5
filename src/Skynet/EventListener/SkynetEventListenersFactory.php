<?php

/**
 * Skynet/EventListener/SkynetEventListenersFactory.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\EventListener;

use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;

 /**
  * Skynet Event Listeners Factory
  *
  * Factory for Event Listeners
  */
class SkynetEventListenersFactory
{
  /** @var SkynetEventListenerInterface[] Array of Event Listeners */
  private $eventListeners = [];

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}


 /**
  * Registers Event Listeners classes in registry
  */
  private function registerEventListeners()
  {
    $this->register('exec', new SkynetEventListenerExec());
    $this->register('clusters', new SkynetEventListenerClusters());
    $this->register('cloner', new SkynetEventListenerCloner());
    $this->register('cli', new SkynetEventListenerCli());  
    $this->register('files', new SkynetEventListenerFiles());    
    $this->register('options', new SkynetEventListenerOptions());
    $this->register('registry', new SkynetEventListenerRegistry());
    $this->register('my', new \SkynetUser\SkynetEventListenerMyListener());    
    $this->register('echo', new SkynetEventListenerEcho());
    $this->register('sleeper', new SkynetEventListenerSleeper());
    $this->register('updater', new SkynetEventListenerUpdater());
  }

 /**
  * Returns choosen Event Listener from registry
  *
  * @param string $name
  *
  * @return SkynetEventListenerInterface EventListener
  */
  public function getEventListener($name)
  {
    if(array_key_exists($name, $this->eventListeners))
    {
      return $this->eventListeners[$name];
    }
  }

 /**
  * Returns all Event Listeners from registry as array
  *
  * @return SkynetEventListenerInterface[] Array of Event Listeners
  */
  public function getEventListeners()
  {
    return $this->eventListeners;
  }

 /**
  * Checks for Event Listeners in registry
  *
  * @return bool True if events exists
  */
  public function areRegistered()
  {
    if($this->eventListeners !== null && count($this->eventListeners) > 0) return true;
  }

 /**
  * Registers Event Listener in registry
  *
  * @param string $id name/key of listener
  * @param SkynetEventListenerInterface $class New instance of listener class
  */
  private function register($id, SkynetEventListenerInterface $class)
  {
    $this->eventListeners[$id] = $class;
  }

 /**
  * Returns instance
  *
  * @return SkynetEventListenersFactory
  */
  public static function getInstance()
  {
    static $instance = null;
    if($instance === null)
    {
      $instance = new static();
      if(!$instance->areRegistered()) 
      {
        $instance->registerEventListeners();
      }
    }
    return $instance;
  }
}