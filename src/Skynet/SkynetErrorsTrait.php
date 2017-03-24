<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

trait SkynetErrorsTrait 
{  
  protected $errors = [];
  
  protected function addError($msg)
  {
    $this->errors[] = $msg;
  }
  
  protected function getErrors()
  {
    return $this->errors;
  }
  
  protected function areErrors()
  {
    if(count($this->errors) > 0) return true;
  }  
  
  protected function dumpErrors()
  {
    $str = '';
    if(count($this->errors) > 0) $str = 'ERRORS:<br/>'.implode('<br/>', $this->errors);
    return $str;
  }
}