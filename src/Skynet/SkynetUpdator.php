<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetUpdator extends SkynetCoreAbstract
{
   private $skynetBaseFile;
   
   public function __construct($skynetBaseFile)
   {
     $this->skynetBaseFile = $skynetBaseFile;
     $this->showCode();     
   }
   
   private function showCode()
   {
     if(isset($_REQUEST['code']) && $_REQUEST['code'] = 1)
     {
        $file = file_get_contents($this->skynetBaseFile);
        echo $file;
        exit;       
     }     
   }
}