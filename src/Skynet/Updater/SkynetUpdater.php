<?php

/**
 * Skynet/Updater/SkynetUpdater.php
 *
 * @package Skynet
 * @version 1.1.6
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Updater;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\Secure\SkynetVerifier;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;
use Skynet\SkynetVersion;
use Skynet\Encryptor\SkynetEncryptorsFactory;

 /**
  * Skynet Updater
  *
  * Self-updater engine
  */
class SkynetUpdater
{
  use SkynetErrorsTrait, SkynetStatesTrait;
   
   /** @var SkynetVerifier SkynetVerifier instance */
   protected $verifier;

 /**
  * Constructor
  */
   public function __construct()
   {    
     $this->verifier = new SkynetVerifier();
     $this->showSourceCode();
   }

 /**
  * Generates PHP code of Skynet standalone file and shows it
  */
   private function showSourceCode()
   {
     if(isset($_REQUEST['@code']))
     {
        $encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
        
        if(!$this->verifier->isRequestKeyVerified())
        {
          $request = "\r\n";
          foreach($_REQUEST as $k => $v)
          {
            $request.= $k.'='.$encryptor->decrypt($v)."\r\n";
          }
          
          $this->addError(SkynetTypes::VERIFY, 'SELF-UPDATER: UNAUTHORIZED REQUEST FOR SOURCE CODE FROM: '.$_SERVER['REMOTE_HOST'].$_SERVER['REQUEST_URI'].' IP: '.$_SERVER['REMOTE_ADDR'].$request);
          exit;
          return false;
        }
      
        $ary = [];
        $file = @file_get_contents(SkynetHelper::getMyBasename());
        
        $ary['version'] = SkynetVersion::VERSION;
        $ary['code'] = $file;
        $ary['checksum'] = md5($file);
        
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($ary);
        exit;
     }
   }
}