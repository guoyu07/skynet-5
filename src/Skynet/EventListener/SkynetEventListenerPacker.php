<?php

/**
 * Skynet/EventListener/SkynetEventListenerPacker.php
 *
 * @package Skynet
 * @version 1.2.1
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.2.1
 */

namespace Skynet\EventListener;

use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;

 /**
  * Skynet Event Listener - Packer/unpacker
  *
  * Skynet packer
  */
class SkynetEventListenerPacker extends SkynetEventListenerAbstract implements SkynetEventListenerInterface
{  
  /** @var ZipArchive Zip archive */
  private $zip;
  
  /** @var int Packed files counter */
  private $counter = 0;
 
 /**
  * Constructor
  */
  public function __construct()
  {
    parent::__construct();   
  }

 /**
  * onConnect Event
  *
  * Actions executes when onConnect event is fired
  *
  * @param SkynetConnectionInterface $conn Connection adapter instance
  */
  public function onConnect($conn = null)  { }

 /**
  * onRequest Event
  *
  * Actions executes when onRequest event is fired
  * Context: beforeSend - executes in sender when creating request.
  * Context: afterReceive - executes in responder when request received from sender.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onRequest($context = null)
  {
    if($context == 'beforeSend')
    {
      if($this->request->get('@zip_put') !== null)
      {  
        $params = $this->request->get('@zip_put');     
        if(isset($params['file']))
        {
          $source = $params['file'];
          if(file_exists($source))
          {
            $data = @file_get_contents($source);
            if($data !== null)
            {
              $params['data'] = base64_encode($data);
              $this->request->set('@zip_put', $params);
              $this->addMonit('[STATUS]: Sending archive: '.$source);
            }            
          } else {            
            $this->addMonit('[ERROR]: File not exists: '.$source);
            return false;
          }
        }
      }      
    }
    
    if($context == 'afterReceive')
    {
      
    }
  }

 /**
  * onResponse Event
  *
  * Actions executes when onResponse event is fired.
  * Context: beforeSend - executes in responder when creating response for request.
  * Context: afterReceive - executes in sender when response for request is received from responder.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onResponse($context = null)
  {
    if($context == 'afterReceive')
    {
      if($this->response->get('@<<zip_putStatus') !== null)
      { 
        $this->addMonit('[ZIP STATUS]: @zip_put: '.$this->response->get('@<<zip_putStatus'));    
      }
      
      if($this->response->get('@<<zip_getStatus') !== null)
      { 
        $this->addMonit('[ZIP STATUS]: @zip_get: '.$this->response->get('@<<zip_getStatus'));    
      }
      
      if($this->response->get('@<<zip_getSaveAs') !== null)
      {         
        if($this->response->get('@<<zip_getData') !== null)
        {          
          if(!is_dir('_download'))
          {
            if(@mkdir('_download'))
            {
              $this->addMonit('[ERROR]: Error creating directory: /_download'); 
              return false;
            }
          }
          
          if(file_put_contents('_download/'.$this->response->get('@<<zip_getSaveAs'), base64_decode($this->response->get('@<<zip_getData'))))
          {
            $this->addMonit('[SAVED AS]: _download/'.$this->response->get('@<<zip_getSaveAs'));
          } else {
            $this->addMonit('[ERROR]: Error saving file: _download/'.$this->response->get('@<<zip_getSaveAs'));
          }
        } else {  
        
          $this->addMonit('[STATUS]: Data is empty.');          
        }        
      }
    }

    if($context == 'beforeSend')
    {      
      /* zip_get */
      if($this->request->get('@zip_get') !== null)
      {       
        $result = [];        
        $params = $this->request->get('@zip_get');  
        
        $path = $params['path'];
        if(!empty($path) && substr($path, -1) != '/')
        {
          $path.= '/';
        }
        
        if(!empty($path) && !is_dir($path))
        {
          $result[] = '[ERROR] Directory not exists: '.$path;
          $this->response->set('@<<zip_getStatus', $result);
          return false;
        }
        
        $saveAs = str_replace("/", "_", $this->myAddress).'_'.time().'.zip';
        
        if(isset($params['file']) || !empty($params['file']))
        {            
          $saveAs = $params['file'];            
        }          
        $this->response->set('@<<zip_getSaveAs', $saveAs);          
        
        $pattern = '*';
        if(isset($params['pattern']) || !empty($params['pattern']))
        {
          $pattern = $params['pattern'];
        }
        
        $tmpZip = 'tmp'.md5(time()).'.zip';
        $data = null;
        $this->zip = new \ZipArchive;
        if($this->zip->open($tmpZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) 
        {
          $this->addDir($path, $pattern);
          $this->zip->close();
          $data = file_get_contents($tmpZip);
          if($data !== null)
          {
            $result[] = 'Successed packed '.$this->counter.' files from dir: '.$path;
            $this->response->set('@<<zip_getData', base64_encode($data));
          } else {
            $result[] = 'Created archive is empty';
          }  
          
          @unlink($tmpZip);            
          
        } else {           
          $result[] = '[ERROR] Zip archive create error: '.$tmpZip;
        }
        
        $this->response->set('@<<zip_getStatus', $result);     
      }
      
      /* zip_put */
      if($this->request->get('@zip_put') !== null)
      {     
        $result = [];        
        $params = $this->request->get('@zip_put');  
        
        $path = $params['path'];
        if(!empty($path) && substr($path, -1) != '/')
        {
          $path.= '/';
        }        
        
        if(isset($params['data']))
        {
          $tmpZip = 'tmp'.md5(time()).'.zip';
          if(@file_put_contents($tmpZip, base64_decode($params['data'])))
          {
            $this->zip = new \ZipArchive;
            if($this->zip->open($tmpZip) === TRUE) 
            {
              if(!empty($path) && !is_dir($path))
              {
                if(!@mkdir($path))
                {
                  $result[] = '[ERROR] Error creating dir: '.$path;
                  $this->response->set('@<<zip_putStatus', $result);
                  return false;
                }
              }
              
              if(substr($path, 0, 1) != '/')
              {
                $path = '/'.$path;
              }
              
              $this->zip->extractTo($path);
              $this->zip->close();
              @unlink($tmpZip);
              
              $result[] = '[SUCCESS] Zip unpacked into dir: '.$path;
              
            } else {
              $result[] = '[ERROR] Zip open error: '.$tmpZip;
            }
            
          } else {
            $result[] = '[ERROR] Zip archive receive error: '.$tmpZip;
          }
          
        } 
        $this->response->set('@<<zip_putStatus', $result);
      }
    }    
  }

 /**
  * onBroadcast Event
  *
  * Actions executes when onBroadcast event is fired.
  * Context: beforeSend - executes in responder when @broadcast command received from request.
  * Context: afterReceive - executes in sender when response for @broadcast received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onBroadcast($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }

 /**
  * onEcho Event
  *
  * Actions executes when onEcho event is fired.
  * Context: beforeSend - executes in responder when @echo command received from request.
  * Context: afterReceive - executes in sender when response for @echo received.
  *
  * @param string $context Context - beforeSend | afterReceive
  */
  public function onEcho($context = null)
  {
    if($context == 'beforeSend')
    {
      
    }
  }     
     
 /**
  * onCli Event
  *
  * Actions executes when CLI command in input
  * Access to CLI: $this->cli
  */ 
  public function onCli()
  {
  
  }

 /**
  * onConsole Event
  *
  * Actions executes when HTML Console command in input
  * Access to Console: $this->console
  */   
  public function onConsole()
  {    
    
  }   
  
 /**
  * Registers commands
  * 
  * Must returns: 
  * ['cli'] - array with cli commands [command, description]
  * ['console'] - array with console commands [command, description]
  *
  * @return array[] commands
  */   
  public function registerCommands()
  {    
    $cli = [];
    $console = [];     
    $console[] = ['@zip_get', ['path:"/path/to", pattern:"*", file:"file.zip"'], ''];
    $console[] = ['@zip_put', ['path:"/path/to", file:"file.zip"'], ''];
    
    return array('cli' => $cli, 'console' => $console);    
  }  
    
 /**
  * Registers database tables
  * 
  * Must returns: 
  * ['queries'] - array with create/insert queries
  * ['tables'] - array with tables names
  * ['fields'] - array with tables fields definitions
  *
  * @return array[] tables data
  */   
  public function registerDatabase()
  {
    $queries = [];
    $tables = [];
    $fields = [];
    return array('queries' => $queries, 'tables' => $tables, 'fields' => $fields);  
  }
  
  private function addDir($path, $pattern) 
  {    
    if(!empty($path))
    {
      if(substr($path, -1) != '/')
      {
        $path.= '/';
      }
    }
    
    $this->zip->addEmptyDir($path); 
    $nodes = glob($path.$pattern); 
    foreach($nodes as $node) 
    {        
      $this->counter++;
      if(is_dir($node)) 
      { 
        $this->addDir($node, $pattern);
        
      } elseif(is_file($node)) 
      { 
        $this->zip->addFile($node); 
      } 
    } 
  } 
}