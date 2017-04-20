<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlElements.php
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

use Skynet\SkynetVersion;

 /**
  * Skynet Renderer HTML Elements generator
  *
  */
class SkynetRendererHtmlElements
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
  
  /** @var Skynet SkynetRendererHtmlThemes Themes Container*/
  private $themes;
  
  private $js;
  
  
 /**
  * Constructor
  */
  public function __construct()
  {
    $this->themes = new SkynetRendererHtmlThemes();
    $this->js = new SkynetRendererHtmlJavascript();
    $this->css = $this->themes->getTheme(\SkynetUser\SkynetConfig::get('core_renderer_theme'));
    $this->nl = '<br/>';
    $this->gt = '&gt;';
    $this->lt = '&lt;';
    $this->separator = '<hr/>'; 
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
    return $this->addH3('[ '.$title.' ]', $class);
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
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<b'.$cls.'>'.$html.'</b>';
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
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<span'.$cls.'>'.$html.'</span>';
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
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<h1'.$cls.'>'.$html.'</h1>';
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
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<h2'.$cls.'>'.$html.'</h2>';
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
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<h3'.$cls.'>'.$html.'</h3>';
  }
  
 /**
  * Adds URL
  * 
  * @param string $link URL
  * @param string $name Name of link
  * @param bool $target True if _blank
  * @param string $class CSS class
  *
  * @return string HTML code
  */   
  public function addUrl($link, $name = null, $target = true, $class = null)
  {
    if($name === null) 
    {
      $name = $link;
    }
    $blank = '';
    if($target) 
    {
      $blank = ' target="_blank"';
    }
    $cls = '';
    if(!$class !== null) 
    {
      $cls = ' class="'.$class.'"';
    }
    return '<a'.$cls.' href="'.$link.'"'.$blank.' title="'.strip_tags($name).'">'.$name.'</a>';    
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
    return '<div id="'.$id.'">';
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
    return '<div class="'.$class.'">';
  }
  
 /**
  * Adds section closing tag
  *
  * @return string HTML code
  */
  public function addSectionEnd()
  {
    return '</div>';
  }
  
 /**
  * Adds clearing floats
  * 
  *
  * @return string HTML code
  */   
  public function addClr()
  {
    return '<div class="clr"></div>';
  }
 
 /**
  * Adds table key => value row
  * 
  * @param string $status TD 1
  * @param string $url TD 1
  * @param string $ping TD 1
  *
  * @return string HTML code
  */   
  public function addClusterRow($status, $url, $ping, $conn)
  {
    return '<tr><td class="tdClusterStatus">'.$status.'</td><td class="tdClusterUrl">'.$url.'</td><td class="tdClusterPing">'.$ping.'</td><td class="tdClusterConn">'.$conn.'</td></tr>';
  }
 
 /**
  * Adds table key => value row
  * 
  * @param string $key TD 1
  * @param string $val TD 1
  *
  * @return string HTML code
  */   
  public function addValRow($key, $val)
  {
    return '<tr><td class="tdKey">'.$key.'</td><td class="tdVal">'.$val.'</td></tr>';
  }
 
 /**
  * Adds table header row
  * 
  * @param string $val TD 1
  *
  * @return string HTML code
  */   
  public function addHeaderRow3($col1, $col2, $col3, $col4)
  {
    return '<tr><th class="tdHeader">'.$col1.'</th><th class="tdHeader">'.$col2.'</th><th class="tdHeader">'.$col3.'</th><th class="tdHeader">'.$col4.'</th></tr>';
  } 
  
 /**
  * Adds table header row
  * 
  * @param string $val TD 1
  *
  * @return string HTML code
  */   
  public function addHeaderRow($val)
  {
    return '<tr><th class="tdHeader" colspan="2">'.$val.'</th></tr>';
  } 
 
 /**
  * Adds table row
  * 
  * @param string $val TD 1
  *
  * @return string HTML code
  */   
  public function addRow($val)
  {
    return '<tr><td colspan="2">'.$val.'</td></tr>';
  } 
  
 /**
  * Adds HTML head tags
  *
  * @return string HTML code
  */ 
  public function addHeader()
  {
    $html = '<html><head>';
    $html.= '<title>SKYNET '.SkynetVersion::VERSION.'</title>';
    $html.= $this->css;
    $html.= '</head><body>';
    return $html;
  } 
      
 /**
  * Adds HTML body ending tags
  *
  * @return string HTML code
  */
  public function addFooter()
  {
    //$html = '<script src="skynet.js"></script>';
    $html = '<script>'.$this->js->getJavascript().'</script>';
    $html.= '</body></html>';
    return $html;
  }
  
 /**
  * Returns header
  *
  * @return string HTML code
  */  
  public function addSkynetHeader()
  {
    $header = $this->addH1('<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAaCAYAAAD1wA/qAAAALHRFWHRDcmVhdGlvbiBUaW1lAMWaciAxOSBrd2kgMjAxNyAwMjo1Njo0NSArMDEwMBachLcAAAAHdElNRQfhBBMAORXFuVVnAAAACXBIWXMAAAsSAAALEgHS3X78AAAABGdBTUEAALGPC/xhBQAAAx9JREFUeNrtl19IU1Ecx+/+Ovtjioj5oEEPPS0J6inaW4EPBjXooVgPJfbQg+0hmBAoY7FUamwPU/eyDWszaq5oC5kVW8m0Qool+rIYDPawQpq49sf97XfmOTW16Zlt3oK+8OVc7j1/fp97zu/ccxnmv7aWUCgslCqViq/X6xvQtUgkYjus8sTj8QqlRCJhgsHg3Wg06pHL5XXFz/56kUA7OjqYUCikzWPFYrHp3t7e+n8Chs/nF0qpVMqEw2FDfoOSyeR7pVLZhOpwuVy2w90aQiaTMUtLS2P5EkqlUr7BwcFDqC6Hw2E77N9DdHd3cyORiDW/jTKZzH2dTsd22OtF1ntPT49wZWXFvh0E6C24OZfLMQaDge3w10MoFIpaSOZJCohZcAOYAXPBd8xm8zFWIUiy9vf31yUSCTcFhBdcjyGQzfh+aHx8XMwKBEnSgYGBRkjeWQqIafABDMABP9jwPGy324+zAqPVag9C0n6ggHgN3l+0nB6WqPcNYE7u6kyMjIy0ZbPZBQoItOT2YQge+PFWlWEDWB4dHZVUFYIk9tDQ0GEY8zMFxCvwXgwhAD+haIP03WQynakKBEnsvr6+I5DYAYpgXoD3YIga8DNKCKKk1Wo9W1EIspzUavXR1dXVEEUQLnAthhCBn5cJQZSamJg4X1EYjUZzIp1Of6UYfBIHz+AZce0QgijrdDovVgRieHj4FCR2hGJQ9OZrMATKjZd/CPFTU1NTVzeukLJkNBpPQz9RirEcYCGGQFutu1IQRB6P59qOYCwWSye0T1CM8TS/tishCPTRe1NpCKKZmZkbZcHYbLYL0C5N0be9CAKdobzVgiCam5tTkDg3/dMU0zkcjktQP0fRpw3MxxCN4HfVhiDy+Xy3NsEUU7lcriuUfT3Kr32pEUQTelG7BUG0uLh4u7W1tRC3QCD4NStut/s6ZR/orMTFEM3gj7sNQeT3+++1t7evAbS0tDBer/cmZVt0auVgiDbwJ7YgiAKBgK6rq0vImZ+fPycWi1XAhP5XMyXyHx20voA7wTF8Tw2+DF4uf2OvmFBeCOLx+NgP1c7Cc+35//8AAAAASUVORK5CYII=
"/> SKYNET v.'.SkynetVersion::VERSION, 'logo');
    $header.= '(c) 2017 Marcin Szczyglinski<br>Updates: '.$this->addUrl(SkynetVersion::WEBSITE).'<br>Website: '.$this->addUrl(SkynetVersion::BLOG);
    $header.= $this->getNl();      
    return $header;
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