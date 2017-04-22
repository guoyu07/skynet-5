<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlClustersRenderer.php
 *
 * @package Skynet
 * @version 1.1.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

namespace Skynet\Renderer\Html;

use Skynet\Renderer\SkynetRendererAbstract;

 /**
  * Skynet Renderer Clusters list Renderer
  *
  */
class SkynetRendererHtmlClustersRenderer extends SkynetRendererAbstract
{     
  /** @var string[] HTML elements of output */
  private $output = [];    
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();  
  }  
  
 /**
  * Renders clusters
  *
  * @return string HTML code
  */ 
  public function render()
  {
    $c = count($this->clustersData);
    $output = [];
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Your Skynet clusters ('.$c.')'));
    if($c > 0)
    {
      $output[] = $this->elements->addHeaderRow3('Status', 'Cluster address', 'Ping', 'Connect');
      foreach($this->clustersData as $cluster)
      {
         $class = '';
         $result = $cluster->getHeader()->getResult();
                 
         switch($result)
         {
           case -1:
            $class = 'statusError';
           break;
           
           case 0:
            $class = 'statusIdle';
           break;
           
           case 1:
            $class = 'statusConnected';
           break;          
         }
         
         $id = $cluster->getHeader()->getConnId();
         
         // var_dump($cluster->getHeader());         
         $status = '<span class="statusId'.$id.' statusIcon '.$class.'">( )</span>';
         $url = $this->elements->addUrl(\SkynetUser\SkynetConfig::get('core_connection_protocol').$cluster->getHeader()->getUrl());
         $output[] = $this->elements->addClusterRow($status, $url, $cluster->getHeader()->getPing().'ms', '<a href="javascript:skynetControlPanel.insertConnect(\''.\SkynetUser\SkynetConfig::get('core_connection_protocol').$cluster->getHeader()->getUrl().'\');" class="btn">CONNECT</a>');
      }      
    } else {
      
      $info = 'No clusters in database.';
      $info.= $this->elements->getNl();
      $info.= 'Add new cluster with:';
      $info.= $this->elements->getNl();
      $info.= $this->elements->addBold('@add "cluster address"').' or '.$this->elements->addBold('@connect "cluster address"').' command';
      $output[] = $this->elements->addRow($info);
    }
   
    return implode($output);    
  } 
}