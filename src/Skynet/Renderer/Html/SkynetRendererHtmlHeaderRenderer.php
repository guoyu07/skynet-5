<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlHeaderRenderer.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

namespace Skynet\Renderer\Html;

use Skynet\Renderer\SkynetRendererAbstract;
use Skynet\Database\SkynetDatabaseSchema;
use Skynet\Secure\SkynetAuth;

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
  
  /** @var SkynetDatabaseSchema DB Schema */
  protected $databaseSchema;
  
  /** @var SkynetAuth Authorization */
  private $auth;
  
  /** @var SkynetThemes Themes */
  private $themes;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();  
    $this->summaryRenderer = new  SkynetRendererHtmlSummaryRenderer();
    $this->connectionsRenderer = new  SkynetRendererHtmlConnectionsRenderer();
    $this->databaseSchema = new SkynetDatabaseSchema;    
    $this->auth = new SkynetAuth();   
  }  
 
 /**
  * Renders and returns Switch View links
  *
  * @return string HTML code
  */   
  private function renderViewSwitcher()
  {    
    $modes = [];
    $modes['connections'] = 'CONNECTIONS (<span class="numConnections">'.$this->connectionsCounter.'</span>)';
    $modes['database'] = 'DATABASE ('.$this->databaseSchema->countTables().')';   
    $modes['logs'] = 'TXT LOGS';   
    
    $links = [];
    foreach($modes as $k => $v)
    {
      $name = $v;
      if($this->mode == $k) 
      {
        $name = $this->elements->addBold($v, 'viewActive');
      }
      $links[] = ' <a class="aSwitch" href="?_skynetView='.$k.'" title="Switch to view: '.strip_tags($v).'">'.$name.'</a> ';     
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
    $output[] = $this->elements->getNl();  
    $output[] = 'View: '.$this->renderViewSwitcher();
    
    $output[] = $this->elements->addSectionEnd();
    
    
    $output[] = $this->elements->addSectionClass('hdrColumn1');
    $output[] = $this->summaryRenderer->renderService($this->fields);
    $output[] = $this->elements->addSectionEnd();
    
    $output[] = $this->elements->addSectionClass('hdrColumn2');
    $output[] = $this->summaryRenderer->renderServer($this->fields);
    $output[] = $this->elements->addSectionEnd();
    
    $output[] = $this->elements->addSectionClass('hdrColumn3');
    $output[] = $this->summaryRenderer->renderSummary($this->fields);
    $output[] = $this->elements->addSectionEnd();

    /* Clear floats */  
    $output[] = $this->elements->addClr();
    /* !End of Header */
    $output[] = $this->elements->addSectionEnd();  

    return implode('', $output);
  }
}