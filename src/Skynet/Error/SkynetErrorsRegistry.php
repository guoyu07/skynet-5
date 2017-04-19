<?php

/**
 * Skynet/Error/SkynetErrorsRegistry.php
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

 /**
  * Skynet Errors Registry
  *
  * Registry stores all errors generates by Skynet
  */
class SkynetErrorsRegistry
{
  /** @var string[] Aray with errors */
  protected $errors = [];

  /** @var SkynetErrorsRegistry Instance of this */
  private static $instance = null;

 /**
  * Constructor (private)
  */
  private function __construct() {}

 /**
  * __clone (private)
  */
  private function __clone() {}

 /**
  * Returns instance of this
  *
  * @return SkynetErrorsRegistry
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
    }
    return self::$instance;
  }

 /**
  * Adds error message to registry
  *
  * @param SkynetError
  */
  public function addError(SkynetError $error)
  {
    $this->errors[] = $error;
  }

 /**
  * Returns stored errors as array
  *
  * @return string[]
  */
  public function getErrors()
  {
    return $this->errors;
  }

 /**
  * Checks for errors exists in registry
  *
  * @return bool True if are errors
  */
  public function areErrors()
  {
    if(count($this->errors) > 0) return true;
  }

 /**
  * Dump errors array
  *
  * @return string
  */
  public function dumpErrors()
  {
    $str = '';
    if(count($this->errors) > 0) $str = 'ERRORS:<br/>'.implode('<br/>', $this->errors);
    return $str;
  }
}