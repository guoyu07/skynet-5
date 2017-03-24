<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

abstract class SkynetCoreAbstract
{
  protected $skynetID = '2d78098aa0061387301adf84a1341b3491b7eecd';
  
  protected $states = [];
  protected $config = [];
  protected $conn;
  protected $connectors = [];   
  private $updator;
  
  public function __construct()
  {    
    $this->options['core_raw'] = true;  
    $this->options['core_updator'] = true; 
    $this->options['core_update_url'] = 'http://localhost/skynet/skynet_root.php?code=1';  
    $this->options['core_connection_type'] = 'file_get_contents';  
    $this->options['core_email_send'] = false;  
    $this->options['core_email_address'] = 'szczyglis83@gmail.com';  
    $this->options['response_include_request'] = true;  

    $this->connectors = [
    'file_get_contents' => new SkynetConnectionFileGetContents(), 
    'curl' => new SkynetConnectionCurl()
    ];  
    
    $this->registerConnector($this->connectors[$this->options['core_connection_type']]);   
    if($this->options['core_updator']) $this->updator = new SkynetUpdator(__FILE__);    
  }
  
  protected function registerConnector(SkynetConnectionInterface $conn)
  {
    $this->conn = $conn;
  }
  
  public function getOption($key)
  {
    if(is_array($this->options) && array_key_exists($key, $this->options)) return $this->options[$key];
  }
  
  public function setOption($key, $value)
  {
    $this->options[$key] = $value;
  }  
}