<?php

/**
 * Skynet/Console/SkynetConsole.php
 *
 * @package Skynet
 * @version 1.1.4
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Console;

use Skynet\EventListener\SkynetEventListenersFactory;
use Skynet\EventLogger\SkynetEventLoggersFactory;
use Skynet\Secure\SkynetVerifier;
use Skynet\Debug\SkynetDebug;


 /**
  * Skynet Console 
  */
class SkynetConsole
{    
  /** @var SkynetCommand[] Array of helper commands */
  private $commands = [];
  
  /** @var SkynetCommand[] Array of console commands */
  private $consoleCommands = [];
  
   /** @var mixed[] Array of console requests */
  private $consoleRequests = [];
  
  /** @var SkynetCommand[] Array of helper custom commands */
  private $customCommands = [];
  
  /** @var string[] Parser Errors */
  private $parserErrors = [];
  
  /** @var string[] Parser States */
  private $parserStates = [];
  
  /** @var int actual parsed query */
  private $actualQueryNumber;
  
  /** @var SkynetEventListenersInterface[] Array of Event Listeners */
  private $eventListeners = [];

  /** @var SkynetEventListenersInterface[] Array of Event Loggers */
  private $eventLoggers = [];
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
  /** @var SkynetDebug Debugger */
  private $debugger;
  

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->eventListeners = SkynetEventListenersFactory::getInstance()->getEventListeners();
    $this->eventLoggers = SkynetEventLoggersFactory::getInstance()->getEventListeners();    
    $this->registerListenersCommands();
    $this->verifier = new SkynetVerifier();
    $this->debugger = new SkynetDebug();
  }

 /**
  * Registers listeners commands
  */  
  private function registerListenersCommands()
  {
    foreach($this->eventListeners as $listener)
    {
      if(method_exists($listener, 'registerCommands'))
      {
        $tmpCommands = $listener->registerCommands();      
      }
      
      if(is_array($tmpCommands) && isset($tmpCommands['console']) && is_array($tmpCommands['console']))
      {
        foreach($tmpCommands['console'] as $command)
        {
          $cmdName = '';
          $cmdDesc = '';
          $cmdDefaults = '';
          
          if(isset($command[0]))
          {
            $cmdName = $command[0];
          }
          
          if(isset($command[1]))
          {
            $cmdDesc = $command[1];
          }
          
          if(isset($command[2]))
          {
            $cmdDefaults = $command[2];
          }
          
          $this->addCommand($cmdName, $cmdDesc, $cmdDefaults);                  
        }
      }
    }   
  }

 /**
  * Returns true if is console input
  *
  * @return bool True if is input
  */
  public function isInput()
  {
    if(isset($_REQUEST['_skynetCmdCommandSend']) && isset($_REQUEST['_skynetCmdConsoleInput'])) 
    {
      return true;
    }    
  }
  
 /**
  * Adds command to registry
  *
  * @param string $code Command code
  * @param string[]|null $params Command params
  * @param string|null $desc Command description
  */
  public function addCommand($code, $params = null, $desc = null)
  {    
    if($params !== null)
    {
      if(is_array($params))
      {
        $paramsAry = $params;
      } else {
        $paramsAry = [];
        $paramsAry[0] = $params;
      }      
    }
    $this->commands[$code] = new SkynetCommand($code, $paramsAry, $desc);    
  }
  
 /**
  * Adds custom command to registry
  *
  * @param string $code Command code
  * @param string[]|null $params Command params
  * @param string|null $desc Command description
  */
  public function addCustomCommand($code, $params = null, $desc = null)
  {    
    if($params !== null)
    {
      if(is_array($params))
      {
        $paramsAry = $params;
      } else {
        $paramsAry = [];
        $paramsAry[0] = $params;
      }      
    }
    $this->customCommands[$code] = new SkynetCommand($code, $paramsAry, $desc);    
  }

 /**
  * Returns commands registry
  *
  * @return SkynetCommand[] Commands
  */  
  public function getCommands()
  {
    return $this->commands;
  }
  
 /**
  * Returns custom commands registry
  *
  * @return SkynetCommand[] Commands
  */  
  public function getCustomCommands()
  {
    return $this->customCommands;
  }
  
 /**
  * Returns console parsed commands
  *
  * @return SkynetCommand[] Commands
  */  
  public function getConsoleCommands()
  {
    return $this->consoleCommands;
  }
  
 /**
  * Returns console parsed requests
  *
  * @return mixed[] Requests
  */  
  public function getConsoleRequests()
  {
    return $this->consoleRequests;
  }
  
 /**
  * Returns command by code
  *
  * @param string $code Command code
  *
  * @return SkynetCommand Command
  */  
  public function getCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->commands))
    {
      return $this->commands[$code];
    }
  }
  
 /**
  * Returns custom command by code
  *
  * @param string $code Command code
  *
  * @return SkynetCommand Command
  */  
  public function getCustomCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->commands))
    {
      return $this->customCommands[$code];
    }
  }  
  
 /**
  * Returns console command by code
  *
  * @param string $code Command code
  *
  * @return SkynetCommand Command
  */  
  public function getConsoleCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->consoleCommands))
    {
      return $this->consoleCommands[$code];
    }
  }
  
 /**
  * Checks for command exists
  *
  * @param string $code Command code
  *
  * @return bool True if exists
  */  
  public function isCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->commands))
    {
      return true;
    }
  }
  
 /**
  * Checks for custom command exists
  *
  * @param string $code Command code
  *
  * @return bool True if exists
  */  
  public function isCustomCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->customCommands))
    {
      return true;
    }
  }
  
 /**
  * Checks for console command exists
  *
  * @param string $code Command code
  *
  * @return bool True if exists
  */  
  public function isConsoleCommand($code = null)
  {
    if(!empty($code) && array_key_exists($code, $this->consoleCommands))
    {
      return true;
    }
  }
  
 /**
  * Checks for ny console command exists
  *
  * @return bool True if are commands
  */  
  public function isAnyConsoleCommand()
  {
    if(count($this->consoleCommands) > 0)
    {
      return true;
    }
  }
  
 /**
  * Returns parser errors
  *
  * @return string[] Erros
  */    
  public function getParserErrors()
  {
    return $this->parserErrors;    
  }
  
 /**
  * Adds parse error
  *
  * @param string $msg error
  */    
  public function addParserError($msg)
  {
    if($this->actualQueryNumber !== null)
    {
      $msg = 'Cmd['.$this->actualQueryNumber.']: '.$msg;
    }
    $this->parserErrors[] = $msg;    
  }

 /**
  * Returns parser states
  *
  * @return string[] Erros
  */    
  public function getParserStates()
  {
    return $this->parserStates;    
  }
  
 /**
  * Adds parser state
  *
  * @param string $msg state
  */    
  public function addParserState($msg)
  {
    if($this->actualQueryNumber !== null)
    {
      $msg = 'Query['.$this->actualQueryNumber.']: '.$msg;
    }
    $this->parserStates[] = $msg;    
  }
 
 /**
  * Returns type of query, false if incorrect query
  *
  * @param string $query Query to check
  *
  * @return string Query type
  */  
  private function getQueryType($query)
  {
    if(empty($query))
    {
      return false;
    }
    
    /* command */
    if(strpos($query, '@') === 0)
    {     
      return 'cmd';
    }
    
    if($this->isParamKeyVal($query))
    {
      return 'param';
    }
    
    /* incorrect */
    return false;
  }

 /**
  * Checks if param is pair key=val
  *
  * @param string $input
  *
  * @return bool True if is param key-value
  */ 
  private function isParamKeyVal($input)
  {
    if(!empty($input) && preg_match('/^[^http]+[a-zA-Z0-9_-]+: *"{0,1}.+"{0,1}$/', $input))
    {
      return true;
    }
  }
  
 /**
  * Removes multiple spaces
  *
  * @param string $str Original string
  *
  * @return string String with single spaces
  */    
  private function parseMultipleSpacesIntoSingle($str)
  {
    return preg_replace("/ {2,}/", " ", $str);    
  }
 
 /**
  * Checks if there are addresses in input
  *
  * @param string $input
  *
  * @return bool
  */ 
  private function areAddresses($input)
  {
   $urls = false;
   $e = explode(',', $input);
   $c = count($e);
   if($c > 0)
   {
     foreach($e as $param)
     {
       if($this->verifier->isAddressCorrect(trim($param)))
       {
         $urls = true;
       }
     }     
   }
   return $urls;   
  } 
 
 /**
  * Removes last ; char
  *
  * @param string $input
  *
  * @return string
  */  
  private function removeLastSemicolon($input)
  {
    return rtrim($input, ';');   
  }
 
 /**
  * Parses and returns params from params string
  *
  * @param string $paramsStr String with params
  *
  * @return mixed[] Array with params
  */   
  private function parseCmdParams($paramsStr)
  {
    $params = [];
    $paramsStr = $this->removeLastSemicolon($paramsStr);
   
    if(empty($paramsStr))
    {
      return false;
    }   
   
    /* if param is quoted */
    if($this->isQuoted($paramsStr))
    {
      $data = $this->unQuote($paramsStr);      
      return array(0 => $data);
    }    
   
    /* if not quoted explode for params */
    $e = explode(',', $paramsStr);
    $numOfParams = count($e); 
    
    if(!$this->areAddresses($paramsStr))
    {
      $pattern = '/[a-zA-Z0-9_-]+: *"{0,1}([^"]+)"{0,1}[^,]?/';
      if(preg_match_all($pattern, $paramsStr, $matches, PREG_PATTERN_ORDER) != 0)
      {
        $e = $matches[0];
      } 
    }   
    
    foreach($e as $param)
    {
      $params[] = trim($param);
    }
    
    return $params;    
  }

 /**
  * Returns param type
  *
  * @param string $paramStr param raw string
  *
  * @return string Type of param
  */    
  private function getParamType($paramStr)
  {
    if(empty($paramStr))
    {
      return false;
    }
    
    if(strpos($paramStr, ':') === false)
    {
      return 'value';
    } else {
      if(strpos($paramStr, '://') === false)
      {
        return 'keyvalue';
      } else {
        return 'value';
      }
    }    
  }

 /**
  * Returns array [key] => value from parsed param
  *
  * @param string $paramStr param raw string
  *
  * @return string[] Param array
  */    
  private function getParamKeyVal($paramStr)
  {
    if(empty($paramStr))
    {
      return false;
    }    
    
    $e = explode(':', $paramStr);
    
    $parts = count($e);
    if($parts < 2)
    {
      $this->addParserError('PARAM INCORRECT: '.$paramStr);
      return false;
      
    } else {
      
      $key = trim($e[0], '" ');
      if($parts == 2)
      {
        $value = trim($e[1], '" ');
      } else {
        $valueParts = [];
        $value = '';
        for($i = 1; $i < $parts; $i++)
        {
          $valueParts[] = trim($e[$i], '" ');
        }
        $value.= implode(':', $valueParts);
      }       
      if(substr($value, -1) == ';')
      {
        $value = rtrim($value, ';');
      }
     
      $cleanValue = $this->unQuoteValue($value);
      $ary = [$key => $cleanValue];
     
      $this->addParserState('KEY_VALUE: '.$key.' => '.$cleanValue);
      return $ary;
    } 
  }

 /**
  * Parses command query, returns array with command name and params
  *
  * @param string $query Command single query
  *
  * @return mixed[] Array with command data
  */    
  private function getCommandFromQuery($query)
  {
    $haveParams = false;
    $paramsFromPos = null;
    $paramsStr = '';    
      
    $str = ltrim($query, '@');
    
    /* get command name */
    $cmdName = strstr($str, ' ', true);
    /* no space after command == no params */
    
    if($cmdName === false)
    {
      /* no params */
      $cmdName = $str;
      $haveParams = false;
    } else {        
      $paramsFromPos = strpos($str, ' ');        
      $paramsStr = trim(substr($str, $paramsFromPos, strlen($str)));
      $haveParams = true;
    }    
    
    /* gets params as array */
    $paramsAry = $this->parseCmdParams($paramsStr);    
    
    $data = [];
    $data['command'] = $cmdName;
    $data['params'] = $paramsAry;    
    return $data;          
  } 
  
 /**
  * Returns command from query
  *
  * @param string $query raw query
  *
  * @return SkynetCommand Parsed command with params
  */    
  private function createCommand($query)
  {
     /* parse command data */
    $data = $this->getCommandFromQuery($query);    
       
    $numOfParams = count($data['params']);
    $this->addParserState('COMMAND: '.$data['command']);
    $this->addParserState('NUM OF PARAMS: '.$numOfParams);       
    
    /* new command */
    $command = new SkynetCommand($data['command']);
    
    /* if params */
    if(is_array($data['params']) && $numOfParams > 0)
    {
      /* loop on params */
      $tmpParams = [];
      foreach($data['params'] as $param)
      {                    
        $paramType = $this->getParamType($param);
        $this->addParserState('PARAM: '.$param);
        $this->addParserState('PARAM_TYPE: '.$paramType);
        
        /* switch param type */
        switch($paramType)
        {
          case 'value':
          /* if single param add as string to command params array */
            $tmpParams[] = $param;
          break;
          
          case 'keyvalue':
          /* if key:value assignment add as array [key] => [value] */
            $tmpParams[] = $this->getParamKeyVal($param);
          break;
        }
      }
      /* set parsed param to command */      
      $command->setParams($tmpParams);           
    }  
    
    return $command;     
  }
  
 /**
  * Returns key value pair array from param/query
  *
  * @param string $query raw query/param
  *
  * @return mixed[] Array [key] => value
  */   
  private function createParamRequest($query)
  {
    return $this->getParamKeyVal($query);   
  }
  
 /**
  * Explodes queries
  *
  * @param string $input
  *
  * @return string[] Queries
  */   
  private function explodeQuery($input)
  {
    if($this->isEndQuoted($input))
    {
      return array(0 => $input);
    } else {
      return explode(";\n", $input);  
    }      
  }

 /**
  * Checks if input is quoted
  *
  * @param string $input
  *
  * @return bool True if quoted
  */    
  private function isQuoted($input)
  {  
     if(preg_match('/^"{1}[^"]+"{1}$/', $input))
     {
       return true;
     }     
  }
 
 /**
  * Checks if input is endquoted
  *
  * @param string $input
  *
  * @return bool True if quoted
  */  
  private function isEndQuoted($input)
  {
    if(substr($input, -1) === '"' || substr($input, -1) === '\'' || substr($input, -1) === '";' || substr($input, -1) === '\';')
    {
      return true;
    }
  }

 /**
  * Unquotes input
  *
  * @param string $input
  *
  * @return string Cleaned string
  */   
  private function unQuote($input)
  {
    $len = strlen($input);
    if(substr($input, -1) === ';')
    {
      $input = rtrim($input, ';');
    }
    if(strpos($input, '"') === 0)
    {
      $input = trim($input, '"');
    }
    if(strpos($input, '\'') === 0)
    {
     $input = trim($input, '\'');
    } 
    return $input;
  }

 /**
  * Unquotes value
  *
  * @param string $input
  *
  * @return string Cleaned string
  */     
  private function unQuoteValue($input)
  {
    $len = strlen($input);    
    if(strpos($input, '"') === 0)
    {
      $input = trim($input, '"');
    }
    if(substr($input, -1) == '"')
    {
      $input = rtrim($input, '"');
    }
    if(strpos($input, '\'') === 0)
    {
     $input = trim($input, '\'');
    } 
    return $input;
  }
  
 /**
  * Parses input
  *
  * @param string $input Console input
  */    
  public function parseConsoleInput($input)
  {
    $querys = [];
    
    /* get input */
    $input = str_replace("\r\n", "\n", trim($input));  
    $input = $this->parseMultipleSpacesIntoSingle($input);
    
    if(substr($input, -1) != ';')
    {
      $input.= ';';
    }
    /* explode by ";" separator */
    $querys = $this->explodeQuery($input);
    
    $numOfQueries = count($querys);
    
    /* if queries */
    if($numOfQueries > 0)
    {
      $this->addParserState('Num of Queries: '.$numOfQueries);
      $i = 1;
      foreach($querys as $query)
      {
        $this->actualQueryNumber = $i;  
        
        $cleanQuery = trim($query);
        $queryType = $this->getQueryType($cleanQuery);
        
        /* switch query type */
        if($queryType !== false)
        {          
          $this->addParserState('Type: '.$queryType);   
            
          switch($queryType)
          {
              case 'cmd': 
                $command = $this->createCommand($cleanQuery);                 
                $this->consoleCommands[$command->getCode()] = $command;                
              break;              
              
              case 'param':
                $this->consoleRequests[] = $this->createParamRequest($cleanQuery);              
              break;            
          }          
        } else {
          $this->addParserState('Type: NOT RECOGNIZED. Ignoring...');
          $this->addParserError('TYPE NOT RECOGNIZED');          
        }        
        /* query counter */
        $i++;
      }
      //$this->debugger->dump($this->consoleCommands); 
      return true;
      
    } else {
      $this->addParserError('No queriws');
      return false;
    }
  }
  
 /**
  * Resets REQUEST
  */   
  public function clear()
  {
    $_REQUEST['_skynetCmdCommandSend'] = null;
    unset($_REQUEST['_skynetCmdCommandSend']);
  }
}