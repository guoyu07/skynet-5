<?php

/**
 * Skynet/Renderer/Html/SkynetRendererHtmlThemes.php
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
  * Skynet Renderer HTML Themes
  */
class SkynetRendererHtmlThemes
{    
  /** @var string[] Array of themes CSS's */
  private $themes = [];
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->themes['raw'] = '
    <style>
    html, body { font-family: Verdana, Arial; font-size: 0.8rem; line-height: 1.4; } 
    textarea { padding:5px; width:100%; height:300px; } 
    </style>';
    
    $this->themes['dark'] = '
    <style>
    html, body { background: #000; color: #bdd3bf; font-family: Verdana, Arial; font-size: 0.8rem; height: 98%; line-height: 1.4; }    
    b { color:#4d734f; } 
    h2 { color: #5ba15f; } 
    h3 { color:#4f8553; } 
    a { color: #eef6ef; text-decoration: none; } 
    a:hover { color: #fff; text-decoration: underline; } 
    hr { height: 1px;  color: #222e22;  background-color: #222e22;  border: none; }
    textarea { padding:5px; width:100%; height:90%; background: #000; color: green; }
    select, input {  font-family: Verdana, Arial; font-size: 0.8rem; background: #000; color: #9ed4a2; }
    select:hover, input:hover {  color: #fff; }
    table { font-size:0.8rem; width:100%; max-width:100%; table-layout: fixed; }
    td { border-bottom: 1px solid #313c33; padding:4px; word-wrap: break-word; }
    th { color: #707070; font-weight: bold; text-align:left; }
    tr:hover { background:#0c0c0c; color: #616f62; } 
    tr:hover a {  } 
    tr:hover th { background:#000; }
    #wrapper { width: 100%; height: 100%; word-wrap: break-word; }
    #header { height: 10%; min-height:120px; }
    #headerLogo { float:left; width:40%; max-height:100%; }
    #headerSwitcher { float:right; width:58%; max-height:100%; text-align:right; padding:5px; padding-right:20px; }   
    #main { height: 70%; }
    #dbSwitch { height: 15%; max-height:15%; min-height:90px; width:100%; overflow:auto; }
    #dbRecords { height: 70%; max-height:70%; overflow:auto; }
    #columnDebug { float:left; width:40%; max-height:100%; overflow:auto; }
    #columnConnections { float:right; width:58%; max-height:100%; overflow:auto; padding-left:5px; padding-right:5px; }
    #console { width: 100%; height: 15%; }
    #consoleDebug, #consoleDebug h3 { color: #3ffb6e }
    #loginSection { text-align:center; margin: auto }
    #loginSection input[type="password"] { width:400px; }
    #dbTable { table-layout: auto; }
    #authMain { text-align: center; }
    .tdKey { width:30%; }
    .tdVal { width:70%; }
    .tdHeader { border:0px; padding-top:50px; }
    .marked { color: #5ba15f; } 
    .exception { color: #ae3516; }
    .exception b { color: red; }
    .error { color: red; }
    .yes { color: green; }
    .no { color: #ae3516; }
    .viewActive { color: #40ff40; }    
    .genLink:hover { color: #fff; }
    .formConnections { padding-top:30px }
    .sendBtn { background: #50ea59; color: #000;}
    .sendBtn:hover { background: #89f190; color: #000;}
    .aSwitch, .aTxtGen { border:1px solid #2a2a2a; padding:3px; }
    .aTxtGen b { color:#6f8f69; }
    .aTxtGen:hover b { color: #fff; }
    .aSwitch:hover, .aTxtGen:hover { border:1px solid #b5b5b5; background: #2a2a2a; padding:3px; text-decoration:none; color: #fff}
    .aDelete, .aLogout { background:#fde1ea; border:1px solid red; padding:3px; color:black; }
    .aDelete:hover, .aLogout:hover { background:red; border:1px solid red; padding:3px; color:black; text-decoration:none; }
    .aDelete b, .aLogout b { color: #831c15; }
    .aDelete:hover b, .aLogout:hover b { color: #fff; text-decoration:none;}
    .clr { clear: both; }
    .loginForm { padding-top:100px; }
    .logo { font: normal normal 2.0rem \'Trebuchet MS\',Trebuchet,sans-serif; color:#fff; }
    </style>';
  }    

 /**
  * Returns theme CSS
  *
  * @param string $name Theme name
  *
  * @return string CSS 
  */
  public function getTheme($name)
  {
    return $this->themes[$name];
  }
}