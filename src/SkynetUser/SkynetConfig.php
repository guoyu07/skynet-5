<?php

/**
 * Skynet/SkynetConfig.php
 *
 * @package Skynet
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace SkynetUser;

 /**
  * Skynet Config
  *
  * Global configuration of Skynet
  */
class SkynetConfig
{
  
  /** @var string SKYNET KEY ID, default: 1234567890 */
  const KEY_ID = '1234567890';
  
  /** @var string SKYNET PASSWORD, default: empty */
  const PASSWORD = '';
  
  
  /** @var string[] Array of configuration options */
  private static $config = [

/*
  ==================================
  Core configuration - base options:
  ==================================
*/
    /* core_secure -> bool:[true|false]
    If TRUE, Skynet will verify KEY ID in every response, if FALSE - you will able to connect without key (USE THIS ONLY FOR TESTS!!!) */
    'core_secure' => true,

    /* core_raw -> bool:[true|false]
    If TRUE all sending and receiving data will be encrypted, if FALSE - all data will be send in plain text */
    'core_raw' => false,

    /* core_updater -> bool:[true|false]
    If TRUE Skynet will enable self-remote-update engine, if FALSE - self-remote-engine will be disabled */
    'core_updater' => true,
    
    /* core_cloner -> bool:[true|false]
    If TRUE - cloner will be enabled and listening for clone command */
    'core_cloner' => false,
    
    /* core_check_new_versions -> bool:[true|false]
    If TRUE - information about new version is given from GitHub */
    'core_check_new_versions' => true,


    /* core_encryptor -> string:[openSSL|mcrypt|base64|...]
    Name of registered class used for encrypting data */
    'core_encryptor' => 'openSSL',
    
    /* core_encryptor_algorithm -> string]
    Algorithm for OpenSSL encryption */
    'core_encryptor_algorithm' => 'aes-256-ctr',
    
    /* core_renderer_theme -> string:[dark|light|raw|...]
    Theme CSS configuration for HTML Renderer */
    'core_renderer_theme' => 'dark',
    
    /* core_date_format -> string
    Date format for date() function */
    'core_date_format' => 'H:i:s d.m.Y',
    
/*
  ==================================
  Translate configuration 
  ==================================
*/   
    
    /* translator_config -> bool:[true|false]
    If TRUE - config fields are translated*/
    'translator_config' => true,
    
    /* translator_params -> bool:[true|false]
    If TRUE - param fields are translated*/
    'translator_params' => true,


/*
  ==================================
  Core configuration - connections with clusters:
  ==================================
*/
    /* core_connection_mode -> string:[host|ip]
    Specified connection addresses by host or IP */
    'core_connection_mode' => 'host', // WARNING: at now only host method is supported

    /* core_connection_type -> string:[curl|file_get_contents|...]
    Name of registered class used for connection with clusters */
    'core_connection_type' => 'curl',

    /* core_connection_protocol -> string:[http|https]
    Connections protocol */
    'core_connection_protocol' => 'http://',

    /* core_connection_ssl_verify -> bool:[true|false]
    Only for cURL, set to FALSE to disable verification of SSL certificates */
    'core_connection_ssl_verify' => false,
    
    /* core_connection_curl_cli_echo -> bool:[true|false]
    If true CURL will display connection output in CLI mode (VERBOSE OPTION) */
    'core_connection_curl_output' => true,
    
    /* core_connection_ip_whitelist -> string[]
    IP Whitelist for accepting requests from, if empty then all IP's has access to response */
    'core_connection_ip_whitelist' => [],


/*
  ==================================
  Emailer configuration:
  ==================================
*/
    /* core_email_send -> bool:[true|false]
    TRUE for enable auto-emailer engine for responses, FALSE to disable */
    'emailer_responses' => true,
    
    /* core_email_send -> bool:[true|false]
    TRUE for enable auto-emailer engine for requests, FALSE to disable */
    'emailer_requests' => true,

    /* core_email_address -> [email]
    Specify email address for receiving emails from Skynet */
    'emailer_email_address' => 'your@email.com',


/*
  ==================================
  Response:
  ==================================
*/
    /* response_include_request -> bool:[true|false]
    If TRUE, response will be attaching requests data with @ prefix, if FALSE requests data will not be included into response */
    'response_include_request' => true,


/*
  ==================================
  Logs:
  ==================================
*/
     /* logs_errors_with_full_trace -> bool:[true|false]
    Set TRUE to log errors with full error code, file, line and trace data, set FALSE to log only error messages */
    'logs_errors_with_full_trace' => true,
    
    /* logs_dir -> string:[path/]
    Specify path to dir where Skynet will save logs, or leave empty to save logs in Skynet directory */
    'logs_dir' => 'logs/',

    /* logs_txt_* -> bool:[true|false]
    Enable or disable txt logs for specified Event */
    'logs_txt_access_errors' => true,
    'logs_txt_errors' => true,
    'logs_txt_requests' => true,
    'logs_txt_responses' => true,
    'logs_txt_echo' => true,
    'logs_txt_broadcast' => true,
    'logs_txt_selfupdate' => true,

    /* logs_txt_include_internal_data -> bool:[true|false]
    If TRUE, Skynet will include internal params in txt logs */
    'logs_txt_include_internal_data' => true,


    /* logs_db_* -> bool:[true|false]
    Enable or disable database logs for specified Event */
    'logs_db_access_errors' => true,
    'logs_db_errors' => true,
    'logs_db_requests' => true,
    'logs_db_responses' => true,
    'logs_db_echo' => true,
    'logs_db_broadcast' => true,
    'logs_db_selfupdate' => true,

    /* logs_db_include_internal_data -> bool:[true|false]
    If TRUE, Skynet will include internal params in database logs */
    'logs_db_include_internal_data' => false,


/*
  ==================================
  Database configuration:
  ==================================
*/
    /* db -> bool:[true|false]
    Enable or disable database support. If disabled some of functions of Skynet will not work  */
    'db' => true,

    /* db_type -> string:[dsn]
    Specify adapter for PDO (sqlite is recommended)  */
    'db_type' => 'sqlite',

    /* DB connection config  */
    'db_host' => '127.0.0.1',
    'db_user' => 'root',
    'db_password' => '',
    'db_dbname' => 'skynet',
    'db_encoding' => 'utf-8',
    'db_port' => 3306,

    /* db_file -> string:[filename]
    SQLite database filename, leave empty to let Skynet specify names itself (recommended)  */
    'db_file' => '',
    /* db_file -> string:[path/]
    SQLite database path, if empty db will be created in Skynet directory  */
    'db_file_dir' => '',
    
/*
  ==================================
  Debug options
  ==================================
*/
    /* console_debug -> bool:[true|false]
     If TRUE, console command debugger will be displayed when parsing input */
    'console_debug' => true,
    
     /* debug_exceptions -> bool:[true|false]
     If TRUE, debugger will show more info like line, file and trace on errors */
    'debug_exceptions' => false,
    
    /* debug_internal -> bool:[true|false]
     If TRUE, internal params will be show in debug data */
    'debug_internal' => true,  
    
    /* debug_echo-> bool:[true|false]
     If TRUE, internal @echo params will be show in debug data */
    'debug_echo' => true,
    
     /* debug_key-> bool:[true|false]
     If TRUE, KEY ID will be in debug data */
    'debug_key' => true

/*
 -------- end of config.
*/
  ];


 /**
  * Gets config value
  *
  * @param string $key Config Key
  *
  * @return mixed Config value
  */
  public static function get($key)
  {
    if(array_key_exists($key, self::$config)) 
    {
      return self::$config[$key];
    }
  }

 /**
  * Gets all config values as array
  *
  * @return mixed[]
  */
  public static function getAll()
  {
   return self::$config;
  }

 /**
  * Sets config value
  *
  * @param string $key Config Key
  * @param mixed $value Config Value
  */
  public static function set($key, $value)
  {
    self::$config[$key] = $value;
  }
}