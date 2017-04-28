<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlHeaderRenderer.php
 *
 * @package Skynet
 * @version 1.1.5
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
    $this->themes = new SkynetRendererHtmlThemes();  
  }  
 
 /**
  * Renders theme switcher
  *
  * @return string HTML code
  */   
  private function renderThemeSwitcher()
  {    
    $themes = $this->themes->getAvailableThemes();
    $options = [];
    
    foreach($themes as $k => $v)
    {
      if(isset($_SESSION['_skynetOptions']['theme']) && $_SESSION['_skynetOptions']['theme'] == $k)
      {
        $options[] = '<option value="'.$k.'" selected>'.$v.'</option>';
      } else {
        $options[] = '<option value="'.$k.'">'.$v.'</option>';
      }
    }    
    return '<select onchange="skynetControlPanel.changeTheme(this)" name="_skynetTheme">'.implode('', $options).'</select> ';
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
    
    
    $output[] = $this->elements->addSectionClass('hdrSwitch');
    
    $output[] = '<form method="get" action="" class="formViews" id="_skynetThemeForm">';
    $output[] = '<input type="hidden" name="_skynetView" value="'.$this->mode.'">';
    $output[] = 'View: '.$this->renderViewSwitcher();
    $output[] = ' Theme: '.$this->renderThemeSwitcher();
    $output[] = $this->renderLogoutLink();
    $output[] = '</form>';
    
    if($this->mode == 'connections')
    {
      $output[] = '<div class="innerGotoConnection">'.$this->connectionsRenderer->renderGoToConnection($this->connectionsData[0]).'</div>';
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
    if($this->auth->isPasswordGenerated())
    {
      return $this->elements->addUrl('?_skynetLogout=1', $this->elements->addBold('LOGOUT'), false, 'aLogout'); 
    }      
  } 
}