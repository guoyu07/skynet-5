<?php

/**
 * Skynet/Connection/SkynetConnectionInterface.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Connection;

 /**
  * Skynet Connection Interface
  *
  * Interface for connection adapters.
  * Every connection adapter must implements this interface and extends [SkynetConnectionAbstract] class.
  */
interface SkynetConnectionInterface
{
 /**
  * Must prepare params to send
  */
  public function prepareParams();

 /**
  * Must receive and returns raw response data from remote address
  *
  * @param string $url URL to connect
  */
  public function connect($url);
}