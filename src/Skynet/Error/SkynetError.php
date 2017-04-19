<?php

/**
 * Skynet/Error/SkynetError.php
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
  * Skynet Error
  *
  * Stores internal errors
  */
class SkynetError
{
  /** @var integer Code */
  private $code;

  /** @var string Message */
  private $msg;

  /** @var integer Error/connect ID */
  private $errorId;
  
  /** @var \Exception Exception object */
  private $exception;

 /**
  * Constructor
  *
  * @param integer $code Error Code
  * @param string $msg Error Message
  * @param \Exception $exception Exception object
  */
  public function __construct($code, $msg, $exception = null)
  {
    $this->code = $code;
    $this->msg = $msg;
    $this->exception = $exception;
  }

 /**
  * Sets global errorsID
  *
  * @param integer $id
  */
  public function setErrorId($id)
  {
    $this->errorId = $id;
  }

 /**
  * Sets error code
  *
  * @param integer $code
  */
  public function setCode($code)
  {
    $this->code = $code;
  }

 /**
  * Sets error message
  *
  * @param string $msg
  */
  public function setMsg()
  {
    $this->msg = $msg;
  }

 /**
  * Returns error code
  *
  * @return integer
  */
  public function getCode()
  {
    return $this->code;
  }

 /**
  * Returns errorID
  *
  * @return integer
  */
  public function getErrorId()
  {
    return $this->errorId;
  }

 /**
  * Returns error message
  *
  * @return string
  */
  public function getMsg()
  {
    return $this->msg;
  }
  
 /**
  * Returns error Eception
  *
  * @return Exception
  */
  public function getException()
  {
    return $this->exception;
  }

 /**
  * Returns error as string
  *
  * @return string
  */
  public function __toString()
  {
    $id = '';
    if($this->errorId !== null) $id = '[@'.$this->errorId.'] ';
    return '<b>'.$id.$this->code.'</b>: '.$this->msg;
  }
}