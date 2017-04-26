<?php

/**
 * Skynet/Encryptor/SkynetEncryptorMcrypt.php
 *
 * @package Skynet
 * @version 1.1.5
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.5
 */

namespace Skynet\Encryptor;

 /**
  * Skynet Encryptor - Mcrypt
  *
  * Simple encryptor uses Mcrypt to encrypt and decrypt sending data
  */
class SkynetEncryptorMcrypt implements SkynetEncryptorInterface
{
 /**
  * Encrypts data
  *
  * @param string $str Data to encrypt
  *
  * @return string Encrypted data
  */
  public static function encrypt($decrypted)
  {    
    $key = md5(\SkynetUser\SkynetConfig::KEY_ID); 
    
    $mcrypt = mcrypt_module_open('rijndael-256', '', 'cbc', '');
    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($mcrypt), MCRYPT_DEV_RANDOM); 
    $iv_base64 = base64_encode($iv);
    
    mcrypt_generic_init($mcrypt, $key, $iv);
    $encryptedData = mcrypt_generic($mcrypt, $decrypted);
    mcrypt_generic_deinit($mcrypt);
    mcrypt_module_close($mcrypt);        
    
    return base64_encode($iv_base64.base64_encode($encryptedData));
  }

 /**
  * Decrypts data
  *
  * @param string $str Data to decrypt
  *
  * @return string Decrypted data
  */
  public static function decrypt($encrypted)
  {
     $key = md5(\SkynetUser\SkynetConfig::KEY_ID);
     
     $encrypted = base64_decode($encrypted);
     if(strlen($encrypted) < 44 || empty($encrypted) || $encrypted === null)
     {
       return $encrypted;
     }     
     
     $str = base64_decode(substr($encrypted, 44));
     $iv = base64_decode(substr($encrypted, 0, 43).'==');
     
     if(strlen($iv) < 32)
     {
       return $encrypted;
     }
     
     $mcrypt = mcrypt_module_open('rijndael-256', '', 'cbc', '');
     mcrypt_generic_init($mcrypt, $key, $iv);
     $decryptedData = rtrim(mdecrypt_generic($mcrypt, $str), "\0\4");   
     mcrypt_generic_deinit($mcrypt);
     mcrypt_module_close($mcrypt);
     
     return $decryptedData;
  }
}