<?php

/**
 * Skynet/Common/SkynetHelper.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Common;

 /**
  * Skynet Helper
  *
  * Common used methods
  */
class SkynetHelper
{
 /**
  * Returns cluster address by host or ip
  *
  * @return string
  */
  public static function getServerAddress()
  {
    if(\SkynetUser\SkynetConfig::get('core_connection_mode') == 'host')
    {
      return self::getServerHost();
    } elseif(\SkynetUser\SkynetConfig::get('core_connection_mode') == 'ip')
    {
      return self::getServerIp();
    }
  }

 /**
  * Returns cluster host
  *
  * @return string
  */
  public static function getServerHost()
  {
    if(isset($_SERVER['HTTP_HOST'])) 
    {
      return $_SERVER['HTTP_HOST'];
    }
  }
 
 /**
  * Returns basename
  *
  * @return string
  */ 
  public static function getMyBasename()
  {
    return basename($_SERVER['PHP_SELF']);
  }

 /**
  * Returns cluster IP address
  *
  * @return string
  */
  public static function getServerIp()
  {
   return $_SERVER['SERVER_ADDR'];
  }

 /**
  * Returns cluster filename
  *
  * @return string
  */
  public static function getMyself()
  {
   return $_SERVER['PHP_SELF'];
  }

 /**
  * Returns cluster adress to
  *
  * @return string
  */
  public static function getMyServer()
  {
   return self::getServerAddress().pathinfo($_SERVER['PHP_SELF'], PATHINFO_DIRNAME);
  }
  
 /**
  * Returns cluster full address
  *
  * @return string
  */
  public static function getMyUrl()
  {
    return self::getServerAddress().self::getMyself();
  }
  
  public function isUrl($url)
  {
    if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url))
    {
      return true;
    }
  }
}