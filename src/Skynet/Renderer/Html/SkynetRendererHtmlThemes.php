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
    html, body { background: #000; color: #bdd3bf; font-family: Verdana, Arial; font-size: 0.7rem; height: 98%; line-height: 1.4; min-width:1040px }    
    b { color:#87b989; } 
    h2 { color: #5ba15f; } 
    h3 { color:#4f8553; } 
    a { color: #eef6ef; text-decoration: none; } 
    a:hover { color: #fff; text-decoration: underline; } 
    hr { height: 1px;  color: #222e22;  background-color: #222e22;  border: none; }
    textarea { padding:5px; width:100%; height:90%; background: #000; color: green; }
    select, input {  font-family: Verdana, Arial; font-size: 0.8rem; background: #000; color: #9ed4a2; }
    select:hover, input:hover {  color: #fff; }
    table { font-size:1.0em; width:100%; max-width:100%; table-layout: fixed; }
    td { border-bottom: 1px solid #313c33; padding:2px; word-wrap: break-word; }
    th { color: #707070; font-weight: bold; text-align:left; }
    tr:hover { background:#0c0c0c; color: #616f62; } 
    tr:hover a {  } 
    tr:hover th { background:#000; }
    #wrapper { width: 100%; height: 100%; word-wrap: break-word; }
    #header { height: 10%;  }
    #headerLogo { float:left; width:40%; max-height:100%; }
    #headerSwitcher { float:right; width:58%; max-height:100%; text-align:right; padding:5px; padding-right:20px; }   
    #authMain { text-align: center; }    
    #dbSwitch { height: 10%; max-height:10%; min-height:90px; width:100%; overflow:auto; }
    #dbRecords { height: 80%; max-height:80%; overflow:auto; }    
    #console { width: 100%; height: 15%; }    
    #loginSection { text-align:center; margin: auto }
    #loginSection input[type="password"] { width:400px; }
    
    .main { height: 90%; }
    .dbTable { table-layout: auto; }
    .columnDebug { float:left; width:58%; height:100%; max-height:100%; overflow:auto; }
    .columnConnections { float:right; width:40%; height:100%; max-height:100%; overflow:auto; padding-left:5px; padding-right:5px; }    
    
    .monits { padding:8px; font-size:1.1em; border: 1px solid #d7ffff; background:#03312f;}
    
    .monitOK { padding:8px; font-size:1.1em; border: 1px solid #d7ffff; color: #32c434; background:#113112; text-align:center;}
    .monitError { padding:8px; font-size:1.1em; border: 1px solid #fdf6f7; color:#df888a; background:#4c1819; text-align:center;}
    
    .reconnectArea { font-size:0.8rem; }
    .reconnectArea input { width: 30px; }
    .hide { display:none; }
    
    .sectionAddresses { width:50%; float:left; height:100%; max-height:100%;}
    .sectionStates { width:50%; float:right; height:100%; max-height:100%; }
    
    .innerAddresses { width:100%; height:90%; max-height:90%; overflow-y:auto; }
    .innerMode { width:100%; height:10%; max-height:10%; overflow-y:auto; }
    .innerStates { width:100%; height:100%; max-height:100%; overflow-y:auto; }    
   
    .innerConnectionsOptions { width:100%; height:5%; max-height:5%; overflow-y:auto; }
    .innerConnectionsData { width:100%; height:95%; max-height:95%; overflow-y:auto; }
    
    .hdrLogo { width:25%; height:100%; max-height:100%; float:left; overflow-y:auto; }
    .hdrColumn1 { width:25%; height:100%; max-height:100%; float:left; overflow-y:auto; }
    .hdrColumn2 { width:25%; height:100%; max-height:100%; float:left; overflow-y:auto; }
    .hdrSwitch { width:25%; height:100%; max-height:100%; float:left; overflow-y:auto; text-align:right;}
    .hdrConnection { margin-top:5px; font-size: 1.1rem; }
    .hdrConnection .active { background-color: #3ffb6e; color: #000; }
    
    .tabsHeader { border-bottom:1px solid #2e2e2e;  padding-top: 20px; padding-bottom:8px; }
    .tabsHeader a { font-size:1.3em; background: #2e2e2e; padding: 8px; margin-top:8px; margin-bottom:8px;}
    .tabsHeader a.active { background:#fff; color: #000;}
    
    .tabStates { display:block; }
    .tabConsole { display:none; }
    .tabConfig { display:none; }
    .tabErrors { display:none; }
    .tabConsole { display:none; }
    
    .tdClusterStatus { width:10%; }
    .tdClusterUrl { width:60%; }
    .tdClusterPing { width:10%; }
    .tdClusterConn { width:20%; }
    
    .statusIcon { padding: 1px; }
    .statusConnected { background: #3ffb6e; }
    .statusIdle { background: #2e2e2e; }
    .statusError { background: red; }
    
    a.btn { background:#1c281d; border:1px solid #48734f; padding-left:5px; padding-right:5px; color:#fff; }
    a.btn:hover { background:#3ffb6e; color:#000; }
    
    .tdFormKey { width:20%; vertical-align:middle; text-align:center; }
    .tdFormVal { width:80%; vertical-align:top; }
    .tdFormVal textarea { width:100%; height:150px; }
    .tdFormActions { vertical-align:middle; text-align:center; }
    
    .sectionStatus { height:75%; max-height:75%; overflow-y:auto; }
    .sectionConsole { height:20%; max-height:20%; }
    .tdKey { width:30%; }
    .tdVal { width:70%; }
    .tdActions { width:150px; }
    .tdHeader { border:0px; padding-top:30px; }
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
    .logo { font: normal normal 1.2rem \'Trebuchet MS\',Trebuchet,sans-serif; color:#fff; margin-top:0; margin-bottom:0; }
    
    .tblSummary, .tblService, .tblStates, .tblConfig, .tblClusters { table-layout:auto; }
    .tblSummary .tdKey { width:80%; } .tblSummary .tdValue { width:20%; text-align:right }
    .tblService .tdKey { width:40%; } .tblService .tdValue { width:60%; text-align:right }
    .tblStates .tdKey { width:15%; } .tblStates .tdValue { width:85%; }
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