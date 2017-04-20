<?php

/**
 * Skynet/Renderer/Html/SkynetRendererHtml.php
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

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\Renderer\SkynetRendererAbstract;
use Skynet\Renderer\SkynetRendererInterface;


 /**
  * Skynet Html Output Renderer 
  */
class SkynetRendererHtml extends SkynetRendererAbstract implements SkynetRendererInterface
{
  use SkynetErrorsTrait, SkynetStatesTrait;   
  

  /** @var string[] HTML elements of output */
  private $output = [];   
  
  /** @var SkynetRendererHtmlDebugRenderer Debug Renderer */
  private $debugRenderer;
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetRendererHtmlDatabaseRenderer Database Renderer */
  private $databaseRenderer;
  
  /** @var SkynetRendererHtmlConnectionsRenderer Connections Renderer */
  private $connectionsRenderer;
  
  /** @var SkynetRendererHtmlConsoleRenderer Console Renderer */
  private $consoleRenderer;
  
  /** @var SkynetRendererHtmlConsoleRenderer Console Renderer */
  private $summaryRenderer;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();       
     
    $this->elements = new SkynetRendererHtmlElements();    
    $this->debugRenderer = new SkynetRendererHtmlDebugRenderer();
    $this->databaseRenderer = new  SkynetRendererHtmlDatabaseRenderer();
    $this->connectionsRenderer = new  SkynetRendererHtmlConnectionsRenderer();
    $this->consoleRenderer = new  SkynetRendererHtmlConsoleRenderer();
    $this->summaryRenderer = new  SkynetRendererHtmlSummaryRenderer();
  }
  
 /**
  * Renders and returns debug section
  *
  * @return string HTML code
  */     
  private function renderDebugSection()
  {
    $output = [];
     $errors_class = null;
     
    /* Center Main : Left Column */
    $output[] = $this->elements->addSectionClass('columnDebug');   
    
    
    
    $output[] = $this->elements->addSectionClass('sectionStatus');   
    
    
    $output[] = $this->elements->addSectionClass('sectionAddresses');  
    $output[] = $this->elements->addSectionClass('innerMode');
    $output[] = $this->elements->addSectionClass('hdrConnection');
    $output[] = $this->renderModeStatus();
    $output[] = $this->elements->addSectionEnd();
    $output[] = $this->elements->addSectionEnd();   
     
    $output[] = $this->elements->addSectionClass('innerAddresses');
    
    $output[] = '<table class="tblClusters">';
    $output[] = $this->renderClustersData();    
    $output[] = '</table>';    
    
    
    $output[] = $this->elements->addSectionEnd();   
    $output[] = $this->elements->addSectionEnd(); 
    
    
    $output[] = $this->elements->addSectionClass('sectionStates');   
    $output[] = $this->elements->addSectionClass('innerStates');
    
    /* Empty password warning */
    if(empty(\SkynetUser\SkynetConfig::PASSWORD))
    {
      $output[] = $this->elements->addBold('SECURITY WARNING: ', 'error').$this->elements->addSpan('Access password is not set yet. Use [pwdgen.php] to generate your password and place generated password into [/src/SkynetUser/SkynetConfig.php]', 'error').$this->elements->getNl();
    }
    
    /* Default ID warning */
    if(empty(\SkynetUser\SkynetConfig::KEY_ID) || \SkynetUser\SkynetConfig::KEY_ID == '1234567890')
    {
      $output[] = $this->elements->addBold('SECURITY WARNING: ', 'error').$this->elements->addSpan('Skynet ID KEY is empty or set to default value. Use [keygen.php] to generate new random ID KEY and place generated key into [/src/SkynetUser/SkynetConfig.php]', 'error');
    }
    
   
    
   

    /* Center Main : Left Column: errors */   
   
    if(count($this->errorsFields) > 0) 
    {
       $errors_class = 'error';
    }  
    $output[] = $this->renderTabs();
    
    $output[] = $this->elements->addSectionClass('tabErrors');
    $output[] = '<table class="tblErrors">';
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Errors ('.count($this->errorsFields).')', $errors_class));
    $output[] = $this->debugRenderer->parseErrorsFields($this->errorsFields);
    $output[] = '</table>';
    $output[] = $this->elements->addSectionEnd(); 
    
     /* If console input */
    $output[] = $this->elements->addSectionClass('tabConsole');
    if(isset($_REQUEST['_skynetCmdConsoleInput'])) 
    {
       $output[] = $this->elements->addSectionId('consoleDebug');  
       $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Console Input'));       
       $output[] = $this->elements->addRow($this->consoleRenderer->renderConsoleInput());
       $output[] = $this->elements->addSectionEnd(); 
    }
    $output[] = $this->elements->addSectionEnd();    
    
    
    /* Center Main : Left Column: states */
    $output[] = $this->elements->addSectionClass('tabStates');
    $output[] = '<table class="tblStates">';
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('States ('.count($this->statesFields).')'));
    $output[] = $this->debugRenderer->parseStatesFields($this->statesFields);
    $output[] = '</table>';
    $output[] = $this->elements->addSectionEnd(); 

    
    
    /* Center Main : Left Column: Config */
    $output[] = $this->elements->addSectionClass('tabConfig');
    $output[] = '<table class="tblConfig">';
    $output[] = $this->elements->addHeaderRow($this->elements->addSubtitle('Config ('.count($this->configFields).')'));
    $output[] = $this->debugRenderer->parseConfigFields($this->configFields);
    $output[] = '</table>';
    $output[] = $this->elements->addSectionEnd(); 
    
    
    /* end inner states */
    $output[] = $this->elements->addSectionEnd();     
    
    /* end sectionStates */
    $output[] = $this->elements->addSectionEnd(); 
    $output[] = $this->elements->addClr();
    
    
    /* end section status */
    $output[] = $this->elements->addSectionEnd(); 
    
    
    $output[] = $this->elements->addSectionClass('sectionConsole');   
    $output[] = $this->consoleRenderer->renderConsole();
    $output[] = $this->elements->addSectionEnd(); 
   

    /* Center Main : Left Column: END */  
    $output[] = $this->elements->addSectionEnd(); 
    
    return implode('', $output);
  }

 /**
  * Renders and returns logout link
  *
  * @return string HTML code
  */    
  private function renderLogoutLink()
  {
    return $this->elements->addUrl('?_skynetLogout=1', $this->elements->addBold('LOGOUT'), false, 'aLogout');    
  }
  
 /**
  * Renders and returns connections view
  *
  * @return string HTML code
  */    
  private function renderConnectionsSection()
  {
    $output = [];   
    /* Center Main : Right Column: */
    $output[] = $this->elements->addSectionClass('columnConnections');         
    $output[] = $this->connectionsRenderer->renderConnections($this->connectionsData);
    $output[] = $this->elements->addSectionEnd();  
    return implode('', $output);      
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
  * Renders clusters
  *
  * @return string HTML code
  */ 
  private function renderClustersData()
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
         switch($cluster->getHeader()->getResult())
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
         $url = $this->elements->addUrl($cluster->getUrl());
         $output[] = $this->elements->addClusterRow($status, $this->elements->addBold($url), $cluster->getHeader()->getPing().'ms', '<a href="javascript:skynetControlPanel.insertConnect(\''.\SkynetUser\SkynetConfig::get('core_connection_protocol').$cluster->getUrl().'\');" class="btn">CONNECT</a>');
      }      
    } else {
      
      $info = 'No clusters in database.';
      $info.= $this->elements->getNl();
      $info.= 'Add new cluster with:';
      $info.= $this->elements->getNl();
      $info.= $this->elements->addBold('@add "cluster address"').' command';
      $output[] = $this->elements->addRow($info);
    }
   
    return implode($output);    
  } 
 
 /**
  * Renders and returns mode
  *
  * @return string HTML code
  */  
  private function renderModeStatus()
  {
    $output = [];
    $status = $this->connectionMode;
    
    $classes = [];
    $classes['idle'] = '';
    $classes['single'] = '';
    $classes['broadcast'] = '';
    
    switch($status)
    {
      case 0:
       $classes['idle'] = ' active';
      break;
      
      case 1:
       $classes['single'] = ' active';
      break;
      
      case 2:
       $classes['broadcast'] = ' active';
      break;
    }   
    
    $output[] = '<b>SKYNET MODE:</b> ';
    $output[] = '<a href="?_skynetSetConnMode=0"><span class="statusIdle'.$classes['idle'].'">Idle</span></a> ';
    $output[] = '<a href="?_skynetSetConnMode=1"><span class="statusSingle'.$classes['single'].'">Single</span></a> ';
    $output[] = '<a href="?_skynetSetConnMode=2"><span class="statusBroadcast'.$classes['broadcast'].'">Broadcast</span></a>';    
    return implode($output);
  }
  
 /**
  * Renders and returns header
  *
  * @return string HTML code
  */ 
  private function renderHeaderSection()
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
  * Renders tabs
  *
  * @return string HTML code
  */  
  public function renderTabs()
  {     
    $output = [];
    $output[] = '<div class="tabsHeader">';
    $output[] = '<a class="tabStatesBtn active" href="javascript:skynetControlPanel.switchTab(\'tabStates\');">States ('.count($this->statesFields).')</a> ';
    $output[] = '<a class="tabErrorsBtn errors" href="javascript:skynetControlPanel.switchTab(\'tabErrors\');">Errors ('.count($this->errorsFields).')</a> ';
    $output[] = '<a class="tabConfigBtn" href="javascript:skynetControlPanel.switchTab(\'tabConfig\');">Config ('.count($this->configFields).')</a> ';
    $output[] = '<a class="tabConsoleBtn" href="javascript:skynetControlPanel.switchTab(\'tabConsole\');">Console</a>';
    $output[] = '</div>';    
    return implode($output);
  }

 /**
  * Renders and returns HTML output
  *
  * @return string HTML code
  */
  public function render()
  {     
    $this->consoleRenderer->setListenersOutput($this->consoleOutput);
    
    $this->output[] = $this->elements->addHeader();
    
    /* Start wrapper div */
    $this->output[] = $this->elements->addSectionId('wrapper');    

    /* Render header */
    $this->output[] = $this->renderHeaderSection();    
   
    switch($this->mode)
    {
      case 'connections':
         /* --- Center Main --- */
         $this->output[] = $this->elements->addSectionClass('main');          
         $this->output[] = $this->renderDebugSection();
         $this->output[] = $this->renderConnectionsSection();        
         $this->output[] = $this->elements->addClr();  
         $this->output[] = $this->elements->addSectionEnd();         
  
      break; 

      case 'database':
         /* --- Center Main --- */
         $this->output[] = $this->elements->addSectionId('dbSwitch'); 
         $this->output[] = $this->databaseRenderer->renderDatabaseSwitch();
         $this->output[] = $this->elements->addSectionEnd();
         
         $this->output[] = $this->elements->addSectionId('dbRecords'); 
         $this->output[] = $this->databaseRenderer->renderDatabaseView();
         $this->output[] = $this->elements->addSectionEnd();
      break;
    }   
    /* Center Main : END */   

    /* !End of wrapper */
    $this->output[] = $this->elements->addSectionEnd();
    $this->output[] = $this->elements->addFooter();
    
    return implode('', $this->output);
  } 
}