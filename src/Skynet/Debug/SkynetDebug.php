<?php

/**
 * Skynet/Core/SkynetDebug.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.3
 */

namespace Skynet\Debug;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\Error\SkynetException;
use Skynet\State\SkynetStatesTrait;

 /**
  * Skynet Event Listeners Launcher
  *
  */
class SkynetDebug
{     
  use SkynetErrorsTrait, SkynetStatesTrait; 
  
  

 /**
  * Constructor
  */
  public function __construct()
  {
        
  }  
}