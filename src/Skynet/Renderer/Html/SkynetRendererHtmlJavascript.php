<?php

/**
 * Skynet/Renderer/Html//SkynetRendererHtmlJavascript.php
 *
 * @package Skynet
 * @version 1.1.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.0
 */

namespace Skynet\Renderer\Html;

 /**
  * Skynet Renderer Javascript
  *
  */
class SkynetRendererHtmlJavascript
{     
 

 /**
  * Constructor
  */
  public function __construct()
  {
    
  }    
 
 /**
  * Returns jS
  *
  * @return string JS code
  */  
  public function getJavascript()
  {
    $js = "
    var skynetControlPanel = {
  
  status: null,
  
  switchTab: function(e) {
    
    var tabStates = document.getElementsByClassName('tabStates');
    var tabErrors = document.getElementsByClassName('tabErrors');
    var tabConfig = document.getElementsByClassName('tabConfig');
    var tabConsole = document.getElementsByClassName('tabConsole');
    
    tabStates[0].style.display = 'none';
    tabErrors[0].style.display = 'none';
    tabConfig[0].style.display = 'none';
    tabConsole[0].style.display = 'none';
    
    document.getElementsByClassName('tabStatesBtn')[0].className = document.getElementsByClassName('tabStatesBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabErrorsBtn')[0].className = document.getElementsByClassName('tabErrorsBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConfigBtn')[0].className = document.getElementsByClassName('tabConfigBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConsoleBtn')[0].className = document.getElementsByClassName('tabConsoleBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    
    var btnToActive = e + 'Btn';
    document.getElementsByClassName(btnToActive)[0].className += ' active';
    document.getElementsByClassName(e)[0].style.display = 'block';
  },
  
  switchConnTab: function(e, id) {
    
    var tabConnPlain = document.getElementsByClassName('tabConnPlain'+id);
    var tabConnEncrypted = document.getElementsByClassName('tabConnEncrypted'+id);
    var tabConnRaw = document.getElementsByClassName('tabConnRaw'+id);
    
    tabConnPlain[0].style.display = 'none';
    tabConnEncrypted[0].style.display = 'none';
    tabConnRaw[0].style.display = 'none';
    
    document.getElementsByClassName('tabConnPlainBtn'+id)[0].className = document.getElementsByClassName('tabConnPlainBtn'+id)[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConnEncryptedBtn'+id)[0].className = document.getElementsByClassName('tabConnEncryptedBtn'+id)[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConnRawBtn'+id)[0].className = document.getElementsByClassName('tabConnRawBtn'+id)[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    
    var btnToActive = e + 'Btn' + id;
    document.getElementsByClassName(btnToActive)[0].className += ' active';
    document.getElementsByClassName(e + id)[0].style.display = 'block';
  },
  
  insertCommand: function() {
    
    var cmdsList = document.getElementById('cmdsList');
    if(cmdsList.options[cmdsList.selectedIndex].value != '0') 
    { 
        if(document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value == '' || document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value == null) 
        {
          document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value = cmdsList.options[cmdsList.selectedIndex].value + ' ';
          document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].focus();
        } else {
          document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value = document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value + '\\r\\n' + cmdsList.options[cmdsList.selectedIndex].value + ' ';
          document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].focus();
        }        
    }
  },
  
  insertConnect: function(url) {    
    
    var cmd = '@connect ' + url;
    
    if(document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value == '' || document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value == null) 
    {
      document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value = cmd + ' ';
      document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].focus();
    } else {
      document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value = document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].value + '\\r\\n' + cmd + ' ';
      document.forms['_skynetCmdConsole']['_skynetCmdConsoleInput'].focus();
    }    
  },
    
  gotoConnection() {
    
    var connectList = document.getElementById('connectList');
    if(connectList.options[connectList.selectedIndex].value > 0) {       
      window.location.assign(window.location.href.replace(location.hash, '') + '#_connection' + connectList.options[connectList.selectedIndex].value); 
    }
  },
  
  switchStatus(e)
  {
    var statusIdle = document.getElementsByClassName('statusIdle');
    var statusSingle  = document.getElementsByClassName('statusSingle');
    var statusBroadcast  = document.getElementsByClassName('statusBroadcast');
    
    document.getElementsByClassName('statusIdle')[0].className = document.getElementsByClassName('statusIdle')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('statusSingle')[0].className = document.getElementsByClassName('statusSingle')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('statusBroadcast')[0].className = document.getElementsByClassName('statusBroadcast')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    
    var toActive = 'status' + e;
    document.getElementsByClassName(toActive)[0].className += ' active';
  }  
}
";

  return $js;    
  }
}