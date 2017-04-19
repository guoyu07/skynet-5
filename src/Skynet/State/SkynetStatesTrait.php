<?php

/**
 * Skynet/State/SkynetStatesTrait.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\State;

 /**
  * Skynet State Trait
  *
  * Trait for handle states
  */
trait SkynetStatesTrait
{
  /** @var SkynetState[] States collection */
  private $states = [];

  /** @var SkynetStatesRegistry Global states registry */
  protected $statesRegistry;

  /** @var integer Current connection ID */
  private $stateId;


 /**
  * Loads states registry
  */
  protected function loadStatesRegistry()
  {
    if($this->statesRegistry == null) $this->statesRegistry = SkynetStatesRegistry::getInstance();
  }

 /**
  * Sets global statesID
  *
  * @param integer $id
  */
  public function setStateId($id)
  {
    $this->stateId = $id;
  }

 /**
  * Adds state to registry
  *
  * @param mixed $code
  * @param string $message
  */
  protected function addState($code, $message)
  {
     $this->loadStatesRegistry();
     $state = new SkynetState($code, $message);
     $state->setStateId($this->stateId);
     $this->statesRegistry->addState($state);
  }

 /**
  * Returns stored states
  *
  * @return SkynetState[]
  */
  protected function getStates()
  {
    $this->loadStatesRegistry();
    return $this->statesRegistry->getStates();
  }

 /**
  * Returns state as string
  *
  * @return string
  */
  protected function dumpState()
  {
    $str = '';
    foreach($this->states as $state)
    {
      $str.= $state->getCode().': '.$state->getMsg().'<br/>';
    }
    return $str;
  }
}