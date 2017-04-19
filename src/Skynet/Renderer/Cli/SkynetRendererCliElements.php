<?php

/**
 * Skynet/Renderer/Cli/SkynetRendererCliElements.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Renderer\Cli;

use Skynet\SkynetVersion;

 /**
  * Skynet Renderer HTML Elements generator
  *
  */
class SkynetRendererCliElements
{   
  /** @var string New Line Char */
  private $nl;
  
  /** @var string > Char */
  private $gt;
  
  /** @var string < Char */
  private $lt;
  
  /** @var string Separator tag */
  private $separator;
  
  /** @var string CSS Stylesheet */
  private $css;
  
  
 /**
  * Constructor
  */
  public function __construct()
  {
    $this->nl = "\n";
    $this->gt = ">";
    $this->lt = "<";
    $this->separator = $this->nl."------------------------".$this->nl; 
  }   
  
 /**
  * Sets CSS styles
  *
  * @param string $styles CSS styles data
  */ 
  public function setCss($styles)
  {
    $this->css = $styles;    
  }
  
 /**
  * Adds subtitle
  * 
  * @param string $title Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */  
  public function addSubtitle($title, $class = null)
  {  
    return $this->addH3('[### '.$title.' ###]', $class);
  }
  
 /**
  * Returns line separator tag
  *
  * @return string HTML code
  */  
  public function addSeparator()
  {
    return $this->separator;
  } 
  
  /**
  * Adds bold
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */    
  public function addBold($html, $class = null)
  {
    return strip_tags($html);
  }
 
 /**
  * Adds span
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addSpan($html, $class = null)
  {   
    return strip_tags($html);
  } 
 
 /**
  * Adds Heading1
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addH1($html, $class = null)
  {   
    return strip_tags($html).$this->nl.$this->nl;
  }
  
 /**
  * Adds Heading2
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addH2($html, $class = null)
  {
    return strip_tags($html).$this->nl.$this->nl;
  }
  
 /**
  * Adds Heading3
  * 
  * @param string $html Text to decorate
  * @param string|null $class Optional CSS class
  *
  * @return string HTML code
  */   
  public function addH3($html, $class = null)
  {
    return strip_tags($html).$this->nl.$this->nl;
  }
  
 /**
  * Adds URL
  * 
  * @param string $link URL
  * @param string $name Name of link
  * @param bool $target True if _blank
  *
  * @return string HTML code
  */   
  public function addUrl($link, $name = null, $target = true)
  {
    return $link;    
  }

 /**
  * Adds any HTML
  * 
  * @param string $html HTML code
  *
  * @return string HTML code
  */    
  public function addHtml($html)
  {
    return $html;
  }

 
 /**
  * Adds section container
  * 
  * @param string $id Identifier
  *
  * @return string HTML code
  */    
  public function addSectionId($id)
  {
    return $this->separator;
  }
  
 /**
  * Adds section container
  * 
  * @param string $class Class name
  *
  * @return string HTML code
  */
  public function addSectionClass($class)
  {
    return $this->nl.$this->separator.$this->nl;
  }
  
 /**
  * Adds section closing tag
  * 
  * @param string $id Identifier
  *
  * @return string HTML code
  */
  public function addSectionEnd()
  {
    return $this->nl.$this->nl;
  }
  
 /**
  * Adds clearing floats
  * 
  * @param string $title Text to decorate
  *
  * @return string HTML code
  */   
  public function addClr()
  {
    return $this->nl;
  }
 
 /**
  * Adds HTML head tags
  *
  * @return string HTML code
  */ 
  public function addHeader()
  {   
    $line = '++++++++++++++++++++++++++++++++++++++++++++++++';
    return $this->nl.$line.$this->nl." SKYNET ".SkynetVersion::VERSION." (CLI MODE)".$this->nl.$line;
  } 
      
 /**
  * Adds HTML body ending tags
  *
  * @return string HTML code
  */
  public function addFooter()
  {
    $html = $this->nl;
    return $html;
  }
  
 /**
  * Returns new line
  *
  * @return string HTML 
  */
  public function getNl()
  {
    return $this->nl;
  }
  
 /**
  * Returns > arrow
  *
  * @return string HTML 
  */
  public function getGt()
  {
    return $this->gt;
  }
  
 /**
  * Returns < arrow
  *
  * @return string HTML 
  */
  public function getLt()
  {
    return $this->lt;
  }
  
 /**
  * Returns separator
  *
  * @return string HTML 
  */
  public function getSeparator()
  {
    return $this->separator;
  }
}