<?php
spl_autoload_register(function($class)
{ 
  require_once 'src/'.str_replace("\\", "/", $class).'.php'; 
});

$skynet = new Skynet\SkynetLauncher(true, true);
echo $skynet;