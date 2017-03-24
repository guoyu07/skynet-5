<?php 
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */

spl_autoload_register(function($class)
{ 
  require_once 'src/'.str_replace("\\", "/", $class).'.php'; 
});
 