<?php

/**
 * Skynet/Renderer/Html/SkynetRendererHtml.php
 *
 * @package Skynet
 * @version 1.1.2
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
 
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetRendererHtmlDatabaseRenderer Database Renderer */
  private $databaseRenderer;
  
  /** @var SkynetRendererHtmlConnectionsRenderer Connections Renderer */
  private $connectionsRenderer;   
  
  /** @var SkynetRendererHtmlHeaderRenderer Header Renderer */
  private $headerRenderer;
  
  /** @var SkynetRendererHtmlStatusRenderer Status Renderer */
  private $statusRenderer;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();       
     
    $this->elements = new SkynetRendererHtmlElements();       
    $this->databaseRenderer = new  SkynetRendererHtmlDatabaseRenderer();
    $this->connectionsRenderer = new  SkynetRendererHtmlConnectionsRenderer();   
    $this->headerRenderer = new  SkynetRendererHtmlHeaderRenderer();    
    $this->statusRenderer = new  SkynetRendererHtmlStatusRenderer(); 
  }

  
  public function renderAjaxOutput()
  {
    $output = [];    
   
    $output['test'] = 'xxxxx';
    $output['addresses'] = $this->statusRenderer->renderClusters(true);  
    $output['connectionData'] = $this->connectionsRenderer->render(true);  
    $output['gotoConnection'] = $this->connectionsRenderer->renderGoToConnection($this->connectionsData);
    
    $output['tabStates'] = $this->statusRenderer->renderStates(true);
    $output['tabErrors'] = $this->statusRenderer->renderErrors(true);
    $output['tabConfig'] = $this->statusRenderer->renderConfig(true);
    $output['tabConsole'] = $this->statusRenderer->renderConsoleDebug(true);
    
    $output['numStates'] = count($this->statesFields);
    $output['numErrors'] = count($this->errorsFields);
    $output['numConfig'] = count($this->configFields);
    $output['numConsole'] = count($this->consoleOutput);
    
    $output['numConnections'] = $this->connectionsCounter;
    
    $output['sumBroadcasted'] = $this->fields['Broadcasting Clusters']->getValue();
    $output['sumClusters'] = $this->fields['Clusters in DB']->getValue();
    $output['sumAttempts'] = $this->fields['Connection attempts']->getValue();
    $output['sumSuccess'] = $this->fields['Succesful connections']->getValue();
    
    $output['sumChain'] = $this->fields['Chain']->getValue();
    $output['sumSleeped'] = $this->fields['Sleeped']->getValue();
    
    return json_encode($output);
  }
  
 /**
  * Renders and returns HTML output
  *
  * @return string HTML code
  */
  public function render()
  {  
    $this->headerRenderer->setConnectionsCounter($this->connectionsCounter);
    $this->headerRenderer->setFields($this->fields);
    $this->headerRenderer->addConnectionData($this->connectionsData);
    $this->headerRenderer->setMode($this->mode);

    $this->statusRenderer->setConnectionMode($this->connectionMode);
    $this->statusRenderer->setClustersData($this->clustersData);
    $this->statusRenderer->setErrorsFields($this->errorsFields);
    $this->statusRenderer->setConfigFields($this->configFields);
    $this->statusRenderer->setStatesFields($this->statesFields);
    $this->statusRenderer->setConsoleOutput($this->consoleOutput);
    $this->statusRenderer->setMonits($this->monits);
    
    $this->connectionsRenderer->setConnectionsData($this->connectionsData);
    
    if($this->inAjax)
    {
      return $this->renderAjaxOutput();
    }
    
    $this->output[] = $this->elements->addHeader();
    
    /* Start wrapper div */
    $this->output[] = $this->elements->addSectionId('wrapper');    

      /* Render header */    
      $this->output[] = $this->headerRenderer->render();    
     
      switch($this->mode)
      {
        case 'connections':
           /* --- Center Main --- */
           $this->output[] = $this->elements->addSectionClass('main');   
           $this->output[] = $this->statusRenderer->render();
           $this->output[] = $this->connectionsRenderer->render();        
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