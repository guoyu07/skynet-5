<?php

/**
 * Skynet/Filesystem/SkynetCloner.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Filesystem;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\Secure\SkynetVerifier;
use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Cluster\SkynetCluster;
use Skynet\Error\SkynetException;
use Skynet\Common\SkynetTypes;

 /**
  * Skynet Cloner
  *
  * Creates another Skynet clusters on-fly
  */
class SkynetCloner
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  /** @var SkynetClustersRegistry ClustersRegistry instance */
  private $clustersRegistry;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->clustersRegistry = new SkynetClustersRegistry();    
  }

 /**
  * Starts clone process
  *
  * @return string[] Array of clones addresses or false
  */
  public function startCloning()
  {   
    $dirsList = $this->inspectDirs();
    $success = [];
    
    if($dirsList !== false)
    {
      foreach($dirsList as $dir)
      {
        $newClone = $this->cloneTo($dir);
        if($newClone !== false)
        {
          $success[] = $newClone;
        }        
      }      
    
      if(count($success) > 0)
      {
        return $this->registerNewClones($success);        
      } 
      return false;
    }
  }

 /**
  * Registers new clones in DB
  *
  * @param string[] $clusters Array with addresses of new clones
  *
  * @return string[] Array of clones addresses or false
  */  
  public function registerNewClones($clusters)
  {
    $success = [];
    
    foreach($clusters as $address)
    {
      $cluster = new SkynetCluster();
      $cluster->setUrl($address);
      $cluster->getHeader()->setUrl($address);
      if($this->clustersRegistry->add($cluster))
      {
        $success[] = $address;
      }
    }    
    
    if(count($success) > 0)
    {
      return $success;
    } 
    return false;
  }  

 /**
  * Gets list of dirs
  *
  * @param string $from Start directory
  *
  * @return string[] Array of dirs paths or false
  */  
  public function inspectDirs($from = null)
  {
    if($from !== null && !empty($from))
    {
      if(substr($from, -1) != '/')
      {
        $from.= '/';
      }
      if(!is_dir($from))
      {
        $this->addError(SkynetTypes::CLONER, 'DIR: '.$from.' NOT EXISTS');  
        return false;
      }
    }
    
    $dir = @glob($from.'*');
    $dirs = [];
    foreach($dir as $path)
    {
      if(is_dir($path))
      {
        $base = basename($path);
        if($base != 'logs')
        {
          $dirs[] = $path;
        }
      }
    }
    
    if(count($dirs) > 0)
    {
      return $dirs;
    } 
    return false;
  }

 /**
  * Clones Skynet to another file
  *
  * @param string $dir Destination dir
  *
  * @return string[] Array of cloned addresses or false
  */
  public function cloneTo($dir)
  {
    if(substr($dir, -1) != '/')
    {
      $dir.= '/';
    }
    
    $myFile = basename($_SERVER['PHP_SELF']);   
    $hash = substr(md5($_SERVER['PHP_SELF']), -5, 5);    
    $newFile = $dir.$hash.'_'.$myFile;  
    
    if(file_exists($newFile))
    {
      return false;
    }
    
    try
    {      
      if(copy($myFile, $newFile))
      {
        $this->addState(SkynetTypes::CLONER,'CLONED TO: '.$newFile);  
        $address = $_SERVER['HTTP_HOST'].str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']).$newFile;       
        return $address;
        
      } else {        
        throw new SkynetException('CLONED TO: '.$newFile.' FAILED');    
      }
    } catch(SkynetException $e)
    {
      $this->addError(SkynetTypes::CLONER, $e->getMessage(), $e);  
      return false;
    }
  }
}