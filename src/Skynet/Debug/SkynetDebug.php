<?php

/**
 * Skynet/Core/SkynetDebug.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.3
 */

namespace Skynet\Debug;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\Error\SkynetException;
use Skynet\State\SkynetStatesTrait;

 /**
  * Skynet Debugger
  *
  */
class SkynetDebug
{     
  use SkynetErrorsTrait, SkynetStatesTrait; 

 /**
  * Constructor
  */
  public function __construct()
  {
        
  }  
 
 /**
  * Returns debug data
  *
  * @return string[] Debug
  */ 
  public function getData()
  {
    $this->newSession();    
    $output = [];
    
    $c = count($_SESSION['_skynetDebugger']);
    if($c > 0)
    {
      foreach($_SESSION['_skynetDebugger'] as $k => $v)
      {
        $output[$k] = $this->decorate($v);
      }    
    }
    
    return $output;    
  }

 /**
  * Adds div to output
  *
  * @param string $input
  *
  * @return string Output
  */   
  private function decorate($input)
  {
    return '<div class="debuggerField">'.$input.'</div>';    
  }

 /**
  * Resets debug fields
  */    
  public function resetDebug()
  {
    $_SESSION['_skynetDebugger'] = [];
  }

 /**
  * Dumps var
  *
  * @param mixed $var
  * @param string|null $name
  */    
  public function dump($var = null, $name = null)
  {
    if($name === null)
    {
      $file = debug_backtrace()[0]['file']; 
      $line = debug_backtrace()[0]['line'];    
      $name = '<b>'.basename($file).'</b><br>Line: '.$line;
    }
    
    $this->newSession();    
    ob_start(); 
    var_dump($var);
    $output = ob_get_clean();
    $this->addDebugField($output, $name);
  }
  
 /**
  * Adds debug text
  *
  * @param string $var
  */   
  public function txt($var = null)
  {    
    $file = debug_backtrace()[0]['file']; 
    $line = debug_backtrace()[0]['line'];    
    $name = '<b>'.basename($file).'</b><br>Line: '.$line;
     
    if(is_array($var))
    {
      $dbg = implode('<br>', $var);
    } elseif(is_string($var)) 
    {
      $dbg = $var;
    } else {
      $this->dump($var, $name);
      return false;
    }
    $this->addDebugField($dbg, $name);
  }

 /**
  * Counts debug fields
  *
  * @return int 
  */   
  public function countDebug()
  {
    $this->newSession(); 
    return count($_SESSION['_skynetDebugger']);    
  }

 /**
  * Adds debug to session
  *
  * @param mixed $debug
  * @param string|null $name
  */   
  private function addDebugField($debug, $name = null)
  {
    if($name === null)
    {
      $_SESSION['_skynetDebugger'][] = $debug;
    } else {
      $_SESSION['_skynetDebugger'][$name] = $debug;
    }    
  }

 /**
  * Stats session if not exists
  */    
  private function newSession()
  {
    if(!isset($_SESSION))
    {
      session_start();
    } 
    if(!isset($_SESSION['_skynetDebugger']))
    {
      $_SESSION['_skynetDebugger'] = [];
    }
  }
}