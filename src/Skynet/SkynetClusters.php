<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetClusters extends SkynetCoreAbstract
{
  protected $clusters = [];
  
  public function __construct()
  {
      $this->clusters = 
      ['http://localhost/skynet/skynetCluster.php'];    
  }  
}