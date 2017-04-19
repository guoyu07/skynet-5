<?php

/**
 * Skynet/Error/SkynetErrorsTrait.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Error;

use Skynet\Filesystem\SkynetLogFile;
use Skynet\Database\SkynetDatabase;

 /**
  * Skynet Errors Trait
  *
  * Trait for creating error messages
  */
trait SkynetErrorsTrait
{
  /** @var SkynetError[] Array of errors */
  protected $errors = [];

  /** @var SkynetErrorsRegistry Errors global registry */
  protected $errorsRegistry;

 /**
  * Loads errors registry
  *
  * @return SkynetErrorsRegistry
  */
  protected function loadErrorsRegistry()
  {
    if($this->errorsRegistry === null) 
    {
      $this->errorsRegistry = SkynetErrorsRegistry::getInstance();
    }
  }

 /**
  * Adds error to registry
  *
  * @param mixed $code
  * @param string $msg
  * @param \Exception|null $e
  */
  protected function addError($code, $msg, \Exception $e = null)
  {
    $error = new SkynetError($code, $msg, $e);
    
    $data = $code.': '.$msg;
    if($e !== null && \SkynetUser\SkynetConfig::get('logs_errors_with_full_trace'))
    {
      $data = $msg.' { File:'.$e->getFile().' | Line:'.$e->getLine().' | Trace:'.$e->getTraceAsString().' }';
    }        
    $this->loadErrorsRegistry();
    $this->errorsRegistry->addError($error);
    if(\SkynetUser\SkynetConfig::get('logs_txt_errors'))
    {
      $this->saveErrorInLogFile($data);
    }
    if(\SkynetUser\SkynetConfig::get('logs_db_errors'))
    {
      $this->saveErrorInDb($data);   
    }      
  }

 /**
  * Returns stored errors as array
  *
  * @return string[]
  */
  protected function getErrors()
  {
     $this->loadErrorsRegistry();
     $this->errorsRegistry->getErrors();
  }

 /**
  * Checks for errors exists in registry
  *
  * @return bool True if are errors
  */
  protected function areErrors()
  {
     $this->loadErrorsRegistry();
     if(count($this->errorsRegistry->getErrors()) > 0) 
     {
       return true;
     }
  }

 /**
  * Dump errors array
  *
  * @return string
  */
  protected function dumpErrors()
  {
    $str = '';
    if(count($this->errorsRegistry->getErrors()) > 0) 
    {
      $str = 'ERRORS:<br/>'.implode('<br/>', $this->errorsRegistry->getErrors());
    }
    return $str;
  }
 
 /**
  * Save error in file
  *
  * @param string $msg Error message 
  *
  * @return bool
  */ 
  private function saveErrorInLogFile($msg)
  {
    $fileName = 'errors';
    $logFile = new SkynetLogFile('ERRORS');
    $logFile->setFileName($fileName);
    $logFile->setTimePrefix(false);
    $logFile->setHeader("#ERRORS:");    
    $time_prefix = '@'.date('H:i:s d.m.Y').' ['.time().']: ';
    $logFile->addLine($time_prefix.$msg);    
    return $logFile->save('after');
  }
 
 /**
  * Save error in database
  *
  * @param string $msg Error message 
  *
  * @return bool
  */  
  private function saveErrorInDb($msg)
  {
    $db = SkynetDatabase::getInstance()->getDB();
    
    try
    {
      $stmt = $db->prepare(
        'INSERT INTO skynet_errors (skynet_id, created_at, content, remote_ip)
        VALUES(:skynet_id, :created_at, :content, :remote_ip)'
        );
      $time = time();
      $remote_ip = '';
      if(isset($_SERVER['REMOTE_ADDR']))
      {
        $remote_ip = $_SERVER['REMOTE_ADDR'];
      }
      $skynet_id = \SkynetUser\SkynetConfig::KEY_ID;
      $stmt->bindParam(':skynet_id', $skynet_id, \PDO::PARAM_STR);
      $stmt->bindParam(':created_at', $time, \PDO::PARAM_INT);
      $stmt->bindParam(':content', $msg, \PDO::PARAM_STR);
      $stmt->bindParam(':remote_ip', $remote_ip, \PDO::PARAM_STR);
      if($stmt->execute())
      {
        return true;
      }    
    } catch(\PDOException $e)  { /* End of The World. Error when saving info about error... :/ */ }
  }
}