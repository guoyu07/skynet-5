<?php 

/**
 * compiler.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

spl_autoload_register(function($class)
{ 
  require_once 'src/'.str_replace("\\", "/", $class).'.php'; 
});

$skynetCompiler = new Skynet\Tools\SkynetCompiler;
$cli = new Skynet\Console\SkynetCli;
if($cli->isCli())
{
  echo $skynetCompiler->compile('cli');
} else {
  echo $skynetCompiler->compile('html');
}