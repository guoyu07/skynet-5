<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetState 
{  
  private $code;
  private $msg;
  
  public function __construct($code, $msg)
  {
    $this->code = $code;
    $this->msg = $msg;
  }  
  
  public function getCode()
  {
    return $this->code;
  }
  
  public function getMsg()
  {
    return $this->msg;
  }
  
  public function __toString() 
  {
    return '<b>'.$this->code.'</b>: '.$this->msg;
  }
}