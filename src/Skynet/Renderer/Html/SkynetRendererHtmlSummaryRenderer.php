<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlSummaryRenderer.php
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

 /**
  * Skynet Renderer Summary Renderer
  *
  */
class SkynetRendererHtmlSummaryRenderer
{     
  /** @var string[] HTML elements of output */
  private $output = [];   
  
  /** @var SkynetRendererHtmlDebugParser Debug Renderer */
  private $debugParser;
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->elements = new SkynetRendererHtmlElements();    
    $this->debugParser = new SkynetRendererHtmlDebugParser();
  }  
  
  public function renderService($fields)
  {
    $aryService = ['My address', 'Chain', 'Skynet Key ID', 'Sleeped'];
    $aryServiceClasses = ['My address', 'sumChain', 'Skynet Key ID', 'sumSleeped'];
        
    $this->output = [];
    $this->output[] = '<table class="tblService">';
    $this->output[] = $this->parseFields($fields, $aryService, $aryServiceClasses);
    $this->output[] = '</table>';  
    return implode($this->output);   
  }
  
  public function renderSummary($fields)
  {
    $arySummary = ['Broadcasting Clusters', 'Clusters in DB', 'Connection attempts', 'Succesful connections'];
    $arySummaryClasses = ['sumBroadcasted', 'sumClusters', 'sumAttempts', 'sumSuccess'];
    
    $this->output = [];
    $this->output[] = '<table class="tblSummary">';
    $this->output[] = $this->parseFields($fields, $arySummary, $arySummaryClasses);
    $this->output[] = '</table>';  
    return implode($this->output);   
  }
  
   /**
  * Parses assigned custom fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function parseFields($fields, $ary, $aryClasses)
  {
    $rows = [];  
    $i = 0;
    foreach($ary as $field)
    {
      if(array_key_exists($field, $fields))
      {
        $rows[] = $this->elements->addValRow($this->elements->addBold($fields[$field]->getName()), '<span class="'.$aryClasses[$i].'">'.$fields[$field]->getValue().'</span>');
      }
      $i++;
    }    
    return implode('', $rows);
  }
}