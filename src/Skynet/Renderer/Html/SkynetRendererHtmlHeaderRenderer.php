<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlHeaderRenderer.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Renderer\Html;

use Skynet\Renderer\SkynetRendererAbstract;

 /**
  * Skynet Renderer Mode Renderer
  *
  */
class SkynetRendererHtmlHeaderRenderer extends SkynetRendererAbstract
{     
  /** @var string[] HTML elements of output */
  private $output = [];    
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  
  
  /** @var SkynetRendererHtmlConsoleRenderer Console Renderer */
  private $summaryRenderer;
  
  /** @var SkynetRendererHtmlConnectionsRenderer Connections Renderer */
  private $connectionsRenderer;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();  
    $this->summaryRenderer = new  SkynetRendererHtmlSummaryRenderer();
    $this->connectionsRenderer = new  SkynetRendererHtmlConnectionsRenderer();
  }  
 
 /**
  * Renders and returns Switch View links
  *
  * @return string HTML code
  */   
  private function renderViewSwitcher()
  {    
    $modes = [];
    $modes['connections'] = 'CONNECTIONS ('.$this->connectionsCounter.')';
    $modes['database'] = 'DATABASE';   
    
    $links = [];
    foreach($modes as $k => $v)
    {
      $name = $v;
      if($this->mode == $k) 
      {
        $name = $this->elements->addBold($v, 'viewActive');
      }
      $links[] = ' <a class="aSwitch" href="?_skynetView='.$k.'" title="Switch to view: '.$v.'">'.$name.'</a> ';     
    }    
    return implode(' ', $links);
  } 
  
 /**
  * Renders and returns header
  *
  * @return string HTML code
  */ 
  public function render()
  {
    $output = [];  
    $header = $this->elements->addSkynetHeader();   
    
    /* --- Header --- */
    $output[] = $this->elements->addSectionId('header');
    
    
    $output[] = $this->elements->addSectionClass('hdrLogo');
    $output[] = $header;       
    $output[] = $this->elements->addSectionEnd();
    
    
    $output[] = $this->elements->addSectionClass('hdrColumn1');
    $output[] = $this->summaryRenderer->renderService($this->fields);
    $output[] = $this->elements->addSectionEnd();
    
    
    $output[] = $this->elements->addSectionClass('hdrColumn2');
    $output[] = $this->summaryRenderer->renderSummary($this->fields);
    $output[] = $this->elements->addSectionEnd();
    
    
    $output[] = $this->elements->addSectionClass('hdrSwitch');
    $output[] = $this->elements->addHtml('Select view mode: '.$this->renderViewSwitcher());
    $output[] = $this->renderLogoutLink();
    
    if($this->mode == 'connections')
    {
      $output[] = $this->connectionsRenderer->renderGoToConnection($this->connectionsData);
    }
    $output[] = $this->elements->addSectionEnd();


    /* Clear floats */  
    $output[] = $this->elements->addClr();
    /* !End of Header */
    $output[] = $this->elements->addSectionEnd();  

    return implode('', $output);
  }
  
 /**
  * Renders and returns logout link
  *
  * @return string HTML code
  */    
  public function renderLogoutLink()
  {
    return $this->elements->addUrl('?_skynetLogout=1', $this->elements->addBold('LOGOUT'), false, 'aLogout');    
  }
 
}