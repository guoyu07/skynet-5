<?php

/**
 * Skynet/Renderer/SkynetRenderersFactory.php
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

use Skynet\Renderer\Html\SkynetRendererHtml;
use Skynet\Renderer\Cli\SkynetRendererCli;

 /**
  * Skynet Renderers Factory
  *
  * Factory for renderers.
  */
class SkynetRenderersFactory
{
  /** @var SkynetRendererInterface[] Array of renderers */
  private $renderersRegistry = [];

  /** @var SkynetRendererInterface Choosen renderer instance */
  private $renderer;

  /** @var SkynetRenderersFactory Instance of this */
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
  * Registers renderer classes in registry
  */
  private function registerRenderers()
  {
    $this->register('html', new SkynetRendererHtml());
    $this->register('cli', new SkynetRendererCli());
  }

 /**
  * Returns choosen renderer from registry
  *
  * @param string $name
  *
  * @return SkynetRendererInterface Renderer
  */
  public function getRenderer($name = null)
  {
    if($name === null)
    {
      $name = \SkynetUser\SkynetConfig::get('core_renderer');
    }
    if(is_array($this->renderersRegistry) && array_key_exists($name, $this->renderersRegistry))
    {
      return $this->renderersRegistry[$name];
    }
  }

 /**
  * Registers renderer in registry
  *
  * @param string $id name/key of renderer
  * @param SkynetRendererInterface $class New instance of renderer class
  */
  private function register($id, SkynetRendererInterface $class)
  {
    $this->renderersRegistry[$id] = $class;
  }

 /**
  * Returns instance
  *
  * @return SkynetRenderersFactory
  */
  public static function getInstance()
  {
    if(self::$instance === null)
    {
      self::$instance = new static();
      self::$instance->registerRenderers();
    }
    return self::$instance;
  }
}