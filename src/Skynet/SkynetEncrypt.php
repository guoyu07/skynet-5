<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetEncrypt implements SkynetEncryptInterface
{
  public static function encrypt($str)
  {
    return base64_encode($str);
  }
  
  public static function decrypt($str)
  {
    return base64_decode($str);
  }
}