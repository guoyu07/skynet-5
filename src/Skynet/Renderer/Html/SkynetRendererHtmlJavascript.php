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
   var skynetControlPanel = 
{
  
  status: null,
  connectMode: 2,
  connectInterval: 0, 
  connectIntervalNow: 0,
  connectTimer: null,
  connectTimerNow: null,
  cluster: null,
  
  switchTab: function(e) 
  {    
    var tabStates = document.getElementsByClassName('tabStates');
    var tabErrors = document.getElementsByClassName('tabErrors');
    var tabConfig = document.getElementsByClassName('tabConfig');
    var tabConsole = document.getElementsByClassName('tabConsole');
    var tabDebug = document.getElementsByClassName('tabDebug');
    
    tabStates[0].style.display = 'none';
    tabErrors[0].style.display = 'none';
    tabConfig[0].style.display = 'none';
    tabConsole[0].style.display = 'none';
    tabDebug[0].style.display = 'none';
    
    document.getElementsByClassName('tabStatesBtn')[0].className = document.getElementsByClassName('tabStatesBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabErrorsBtn')[0].className = document.getElementsByClassName('tabErrorsBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConfigBtn')[0].className = document.getElementsByClassName('tabConfigBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabConsoleBtn')[0].className = document.getElementsByClassName('tabConsoleBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('tabDebugBtn')[0].className = document.getElementsByClassName('tabDebugBtn')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    
    var btnToActive = e + 'Btn';
    document.getElementsByClassName(btnToActive)[0].className += ' active';
    document.getElementsByClassName(e)[0].style.display = 'block';
  },
  
  switchConnTab: function(e, id) 
  {    
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
  
  insertCommand: function() 
  {    
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
  
  insertConnect: function(url) 
  {  
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
    
  gotoConnection: function() 
  {
    var connectList = document.getElementById('connectList');
    if(connectList.options[connectList.selectedIndex].value > 0) 
    {       
      window.location.assign(window.location.href.replace(location.hash, '') + '#_connection' + connectList.options[connectList.selectedIndex].value); 
    }
  },
  
  switchStatus: function(e)
  {
    var statusIdle = document.getElementsByClassName('statusIdle');
    var statusSingle  = document.getElementsByClassName('statusSingle');
    var statusBroadcast  = document.getElementsByClassName('statusBroadcast');
    
    document.getElementsByClassName('statusIdle')[0].className = document.getElementsByClassName('statusIdle')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('statusSingle')[0].className = document.getElementsByClassName('statusSingle')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    document.getElementsByClassName('statusBroadcast')[0].className = document.getElementsByClassName('statusBroadcast')[0].className.replace(/(?:^|\s)active(?!\S)/g, '');
    
    var toActive = 'status' + e;
    document.getElementsByClassName(toActive)[0].className += ' active';
  },
  
  switchMode: function(connId)
  {
    this.connectMode = connId;
    switch(connId)
    {
      case 0:
        this.switchStatus('Idle');
      break;
      
      case 1:
        this.switchStatus('Single');
      break;
      
      case 2:
        this.switchStatus('Broadcast');
      break;      
    }      
  },
  
  parseParam: function(param, paramClass = null)
  {
    if(param == true || param == false)
    {
     if(paramClass != null)
      {
        paramClass.className = paramClass.className.replace(/(?:^|\s)yes(?!\S)/g, '');
        paramClass.className = paramClass.className.replace(/(?:^|\s)no(?!\S)/g, '');          
      }   
        
      if(param == true)
      {
        paramClass.className += ' yes';
        return 'YES';
      } else {
        paramClass.className += ' no';
        return 'NO';
      }
      
    } else {
      
      return param;
    }    
  },

  load: function(connMode, cmd = false, skynetCluster)
  {   
    this.cluster = skynetCluster;
    var successed = 0;
    
    if(cmd == false)
    {
      this.connectMode = connMode;
      switch(connMode)
      {
        case 0:
          this.switchStatus('Idle');
        break;
        
        case 1:
          this.switchStatus('Single');
        break;
        
        case 2:
          this.switchStatus('Broadcast');
        break;      
      }  
    }    
    
    var divConnectionData = document.getElementsByClassName('innerConnectionsData')[0];
    var divAddresses = document.getElementsByClassName('innerAddresses')[0];
    var divGoto = document.getElementsByClassName('innerGotoConnection')[0];    
    var divTabStates = document.getElementsByClassName('tabStates')[0];
    var divTabErrors = document.getElementsByClassName('tabErrors')[0];
    var divTabConfig = document.getElementsByClassName('tabConfig')[0];
    var divTabConsole = document.getElementsByClassName('tabConsole')[0];  
    var divTabDebug = document.getElementsByClassName('tabDebug')[0];    
    var divNumStates = document.getElementsByClassName('numStates')[0];
    var divNumErrors = document.getElementsByClassName('numErrors')[0];
    var divNumConfig = document.getElementsByClassName('numConfig')[0];
    var divNumConsole = document.getElementsByClassName('numConsole')[0]; 
    var divNumDebug = document.getElementsByClassName('numDebug')[0];
    var divNumConnections = document.getElementsByClassName('numConnections')[0];    
    var divSumBroadcasted = document.getElementsByClassName('sumBroadcasted')[0];
    var divSumClusters = document.getElementsByClassName('sumClusters')[0];
    var divSumAttempts = document.getElementsByClassName('sumAttempts')[0];
    var divSumSuccess = document.getElementsByClassName('sumSuccess')[0];    
    var divSumChain = document.getElementsByClassName('sumChain')[0];
    var divSumSleeped = document.getElementsByClassName('sumSleeped')[0];
    
    divConnectionData.innerHTML = 'Connecting...Please wait...';   
    
    var xhttp;
    if(window.XMLHttpRequest) 
    {
      xhttp = new XMLHttpRequest();
      } else {        
      xhttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    xhttp.onreadystatechange = function() 
    {
      if(this.readyState == 4 && this.status == 200) 
      {  
       try
       {
         var response = JSON.parse(this.responseText);       
         successed = parseInt(response.sumSuccess);
         
         divConnectionData.innerHTML = response.connectionData;
         divAddresses.innerHTML = response.addresses;       
         divGoto.innerHTML = response.gotoConnection;       
         divTabStates.innerHTML = response.tabStates;
         divTabErrors.innerHTML = response.tabErrors;
         divTabConfig.innerHTML = response.tabConfig;
         divTabConsole.innerHTML = response.tabConsole; 
         divTabDebug.innerHTML = response.tabDebug;           
         divNumStates.innerHTML = response.numStates;
         divNumErrors.innerHTML = response.numErrors;
         divNumConfig.innerHTML = response.numConfig;
         divNumConsole.innerHTML = response.numConsole;   
         divNumDebug.innerHTML = response.numDebug;          
         divNumConnections.innerHTML = response.numConnections;       
         divSumBroadcasted.innerHTML = response.sumBroadcasted;
         divSumClusters.innerHTML = response.sumClusters;
         divSumAttempts.innerHTML = response.sumAttempts;
         divSumSuccess.innerHTML = response.sumSuccess;       
         divSumChain.innerHTML = response.sumChain;
         divSumSleeped.innerHTML = skynetControlPanel.parseParam(response.sumSleeped, divSumSleeped);           
         if(successed > 0)
         {
           skynetControlPanel.setFavIcon(1);
         } else {
           skynetControlPanel.setFavIcon(0);
         }       
         skynetControlPanel.switchMode(parseInt(response.connectionMode));
       } catch(e)
       {
         divConnectionData.innerHTML = this.responseText;
       }       
      }
    }
    
    var params = '_skynetAjax=1';
    if(cmd == true)
    {
      params+= '&_skynetCmdCommandSend=1&_skynetCmdConsoleInput='+document.getElementById('_skynetCmdConsoleInput').value;
    } else {
      params+= '&_skynetSetConnMode=' + connMode;
    }
    
    xhttp.open('POST', skynetCluster, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=utf-8');
    xhttp.send(params);
    return false;    
  },
  
  connectionHelper: function()
  {
    var divIntervalStatus = document.getElementById('connIntervalStatus');
    var now = parseInt(this.connectIntervalNow) - 1;
    this.connectIntervalNow = now;
    divIntervalStatus.innerHTML = now+'s';    
  },
  
  connectionClock: function() 
  {
    this.connectIntervalNow = this.connectInterval + 1;
    this.load(this.connectMode, false, this.cluster);
  },
  
  setConnectInterval: function(cluster)
  {
    this.cluster = cluster;
    var divIntervalInput = document.getElementById('connIntervalValue');
    var divIntervalStatus = document.getElementById('connIntervalStatus');
    var interval = parseInt(divIntervalInput.value);
    if(isNaN(interval))
    {
      interval = 0;
    }
    this.connectInterval = interval;
    
    if(interval == 0)
    {
      divIntervalStatus.innerHTML = 'disabled';
      clearInterval(this.connectTimer);
      clearInterval(this.connectTimerNow);
    } else {
      clearInterval(this.connectTimer);
      clearInterval(this.connectTimerNow);
      
      divIntervalStatus.innerHTML = interval +'s';
      var s = interval * 1000;
      this.connectIntervalNow = s;
      
      skynetControlPanel.connectInterval = interval;
      skynetControlPanel.connectIntervalNow = interval;
      this.connectTimer = setInterval(function()
      { 
        skynetControlPanel.connectionClock(); 
      }, s);      
      
      this.connectTimerNow = setInterval(function()
      { 
        skynetControlPanel.connectionHelper(); 
      }, 1000);
    }
  },
  
  setFavIcon: function(mode = 0) 
  {
    var iconIdle = 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAKnRFWHRDcmVhdGlvbiBUaW1lAE4gMjMga3dpIDIwMTcgMDM6NTY6NTUgKzAxMDAVMKR0AAAAB3RJTUUH4QQXATklbcCYqwAAAAlwSFlzAAALEgAACxIB0t1+/AAAAARnQU1BAACxjwv8YQUAAACeSURBVHja7dIxCkIhHMdxb9PsEB1CaAzXukeNuVqbBNkJOk5zk7OLmCD++/WKEIqXvamhz6TCVwVl7K/XDo4wKF4D3WWt9f6reAWPmJxzJKWcW2sPTfES6phzTqWUbr6B5pO994QlyjlTbQvNcUqJ3nm5SR2HELo4xkh9npsopWaYn26LFxBCTDGU9NnZGLNgY6hvM4LW15rAoD/yW64SvPFhV3oXpAAAAABJRU5ErkJggg==';
    var iconSuccess = 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAKnRFWHRDcmVhdGlvbiBUaW1lAE4gMjMga3dpIDIwMTcgMDM6NTY6NTUgKzAxMDAVMKR0AAAAB3RJTUUH4QQXAg0XHHuEhQAAAAlwSFlzAAALEgAACxIB0t1+/AAAAARnQU1BAACxjwv8YQUAAABJSURBVHjaY2AY3iDxn9R/EManhhGfZmT+fKZnjEQbgMtWbIYwEqsZlyGMpGjGZggjqZrRDWEkRzOyIYzkaoYBJko0Dw4DBh4AAJKoH3bZk1EYAAAAAElFTkSuQmCC';
    var docHead = document.getElementsByTagName('head')[0];       
    var newLink = document.createElement('link');
    newLink.rel = 'shortcut icon';
    newLink.id = 'fav';
    oldLink = document.getElementById('fav');
    
    var ico = '';
    if(mode == 0)
    {
      ico = 'data:image/png;base64,'+iconIdle;
    } else {
      ico = 'data:image/png;base64,'+iconSuccess;
    }
    newLink.href = ico;
    if (oldLink) 
    {
      docHead.removeChild(oldLink);
    }
    docHead.appendChild(newLink);    
  }
}
";

  return $js;    
  }
}