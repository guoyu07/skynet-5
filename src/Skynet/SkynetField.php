<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetField 
{
  private $name;
  private $value;
  
  public function __construct($name, $value)
  {
    $this->name = $name;
    $this->value = $value;    
  }
  
  public function getName()
  {
    return $this->name;    
  } 
  
  public function getValue()
  {
    return $this->value;
  }
  
  public function __toString() 
  {
    return '<b>'.$this->name.'</b>: '.$this->value;
  }
}