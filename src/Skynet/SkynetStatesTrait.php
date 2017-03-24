<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

trait SkynetStatesTrait 
{
  protected $states = [];
   
  protected function addState(SkynetState $state)
  {
    $this->states[] = $state;
  }
  
  protected function dumpState()
  {
    $str = '';
    foreach($this->states as $state)
    {
      $str.= $state->getCode().': '.$state->getMsg().'<br/>';
    }
    return $str;
  }
  
  protected function renderState()
  {
    $str = '';
    foreach($this->states as $state)
    {
      $str.= $state->getCode().': '.$state->getMsg().'<br/>';
    }
    return $str;
  }  
}