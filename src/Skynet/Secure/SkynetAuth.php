<?php

/**
 * Skynet/Secure/SkynetAuth.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Secure;

use Skynet\Renderer\Html\SkynetRendererHtmlThemes;
use Skynet\Renderer\Html\SkynetRendererHtmlElements;
use Skynet\Secure\SkynetVerifier;

 /**
  * Skynet Authentication
  */
class SkynetAuth
{   
  /** @var Skynet SkynetRendererHtmlThemes Themes Container*/
  private $themes;
  
  /** @var string CSS Stylesheet */
  private $css;
  
  /** @var SkynetRendererHtmlElements HTML Tags generator */
  private $elements;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;
  
 /**
  * Constructor
  */
  public function __construct()
  {
    if(!isset($_SESSION))
    {
      session_start();
    }
    $this->themes = new SkynetRendererHtmlThemes();
    $this->css = $this->themes->getTheme(\SkynetUser\SkynetConfig::get('core_renderer_theme'));
    $this->elements = new SkynetRendererHtmlElements();    
    $this->verifier = new SkynetVerifier();    
    
    if(!$this->verifier->isPing() && isset($_REQUEST['_skynetLogout']))
    {
      $this->doLogout();
    }
  }
  
 /**
  * Returns login form
  *
  * @param string $error Error msg to show
  *
  * @return HTML code
  */ 
  private function showLoginForm($error = null)
  {    
    $form = '<form method="post" class="loginForm">Enter password: <input autofocus type="password" name="_skynetPassword" required/><input type="submit" value="Login to Skynet" />
    <input type="hidden" name="_skynetDoLogin" value="1" /></form>';    
    
    $output = [];
    $output[] = $this->elements->addHeader();
    $output[] = $this->elements->addSectionId('authMain');
    $output[] = $this->elements->addSkynetHeader();     
    $output[] = $this->elements->addSectionId('loginSection');
    
    if($error !== null)
    {
      $output[] = $this->elements->getNl().$this->elements->addBold($error, 'error').$this->elements->getNl();
    }
    
    $output[] = $form;
    $output[] = $this->elements->addSectionEnd();
    $output[] = $this->elements->addSectionEnd();
    $output[] = $this->elements->addFooter();
    echo implode($output);
    //exit;
  }

 /**
  * Checks if user login is correct
  *
  * @param string $pwd Skynet saved password
  * @param string $userPwd User requested password
  *
  * @return bool True if passwords match
  */ 
  private function checkLogin($pwd, $userPwd)
  {
    if(password_verify($userPwd, $pwd))
    {
      return true;
    } 
  }

 /**
  * Authorizes user
  *
  * @param string $pwd Correct password
  */   
  private function doLogin($pwd)
  {
    $token = sha1(substr($pwd, -10, 10));
    
    $_SESSION['_skynetLogged'] = 1;
    $_SESSION['_skynetToken'] = $token;    
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;    
  }

 /**
  * Logouts and destroys session
  */  
  private function doLogout()
  {
    $_SESSION['_skynetLogged'] = null;
    $_SESSION['_skynetToken'] = null;  
    session_destroy();
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;    
  }
  
 /**
  * Checks if user is authorizes
  * 
  * @return bool True if authorized
  */ 
  public function isAuthorized()
  {     
    if(empty(\SkynetUser\SkynetConfig::KEY_ID) || \SkynetUser\SkynetConfig::KEY_ID == '1234567890')
    {
      return true;
    }
    $neededToken = sha1(substr(\SkynetUser\SkynetConfig::PASSWORD, -10, 10));
    if(isset($_SESSION['_skynetLogged']) && $_SESSION['_skynetLogged'] == 1 && isset($_SESSION['_skynetToken']) && strcmp($_SESSION['_skynetToken'], $neededToken) === 0)
    {
      return true; 
    }    
  }
  
 /**
  * Checks if user authorized and displays login form if not
  *
  * @return bool True if authorized
  */
  public function checkAuth()
  {
    $pwd = \SkynetUser\SkynetConfig::PASSWORD;
    $userPwd = null;
    $error = null;
    
    if(empty($pwd))
    {
      return true;
      
    } else {
      
      if($this->isAuthorized())
      {
        return true;
      }
      
      if(isset($_POST['_skynetDoLogin']) && isset($_POST['_skynetPassword']) && !empty($_POST['_skynetPassword']))
      {
        $userPwd = $_POST['_skynetPassword'];
        if($this->checkLogin($pwd, $userPwd))
        {
          if($this->doLogin($pwd))
          {
            return true;
          } else {
            $error = 'Error occured';
          }
          
        } else {
          $this->verifier->saveAccessLogs(array('ACCESS TO SKYNET PANEL' => 'INCORRECT PASSWORD'));
          $error = 'Password incorrect';
        }        
      }     
      $this->showLoginForm($error);      
    }
  }  
}