<?php

/**
 * Skynet/Renderer/SkynetRendererInterface.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Renderer;

 /**
  * Skynet Renderer Interface
  *
  * Interface for custom renderer classes. 
  */
interface SkynetRendererInterface
{
 /**
  * Returns rendered data
  *
  * @return string output
  */
  public function render();
}