<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetDebug 
{ 
  public static function dump($fields, $title = 'debug', $mode = null)
  {
    $ret = '';
    if(is_array($fields))
    {
       foreach($fields as $k => $v)
       {
         switch($mode)
         {
           case null:
            $var = $v;
           break;
           
           case 'encrypt':
            $var = SkynetEncrypt::encrypt($v);
           break;
           
           case 'decrypt':
            $var = SkynetEncrypt::decrypt($v);
           break;           
         }         
         
         $ret.= '<b>['.$k.']</b> '.$var.'<br/>';
       }
       
    } elseif(is_object($fields))
    {
      var_dump($fields);      
      
    } else {
      
      $ret.= $fields;     
    }
  
    $ret = '<hr/><b>['.$title.']</b><br/>'.$ret;
    return $ret;
  } 
}