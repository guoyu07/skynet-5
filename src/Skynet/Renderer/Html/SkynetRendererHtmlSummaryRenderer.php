<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlSummaryRenderer.php
 *
 * @package Skynet
 * @version 1.1.3
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

 /**
  * Parses fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */   
  public function renderService($fields)
  {
    $aryService = ['My address', 'Chain', 'Skynet Key ID', 'Sleeped'];
    $aryServiceClasses = ['My address', 'sumChain', 'Skynet Key ID', 'sumSleeped'];
        
    $this->output = [];
    $this->output[] = $this->elements->beginTable('tblService');
    $this->output[] = $this->parseFields($fields, $aryService, $aryServiceClasses);
    $this->output[] = $this->elements->endTable();
    return implode($this->output);   
  }

  
 /**
  * Parses fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function renderServer($fields)
  {
    $arySummary = ['Cluster IP', 'Your IP', 'Encryption', 'Connections'];
    $arySummaryClasses = ['sumClusterIP', 'sumYourIP', 'sumEncryption', 'sumConnections'];
    
    $this->output = [];
    $this->output[] = $this->elements->beginTable('tblService');
    $this->output[] = $this->parseFields($fields, $arySummary, $arySummaryClasses);
    $this->output[] = $this->elements->endTable();
    return implode($this->output);   
  }
  
 /**
  * Parses fields
  *
  * @param SkynetField[] $fields
  *
  * @return string HTML code
  */    
  public function renderSummary($fields)
  {
    $arySummary = ['Broadcasting Clusters', 'Clusters in DB', 'Connection attempts', 'Succesful connections'];
    $arySummaryClasses = ['sumBroadcasted', 'sumClusters', 'sumAttempts', 'sumSuccess'];
    
    $this->output = [];
    $this->output[] = $this->elements->beginTable('tblSummary');
    $this->output[] = $this->parseFields($fields, $arySummary, $arySummaryClasses);
    $this->output[] = $this->elements->endTable();
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
        $value = $fields[$field]->getValue(); 
        if($value === true)
        {
          $value = '<span class="yes">YES</span>';
        } elseif($value === false)
        {
          $value = '<span class="no">NO</span>';
        }
        
        $rows[] = $this->elements->addValRow($this->elements->addBold($fields[$field]->getName()), '<span class="'.$aryClasses[$i].'">'.$value.'</span>');
      }
      $i++;
    }    
    return implode('', $rows);
  }
}