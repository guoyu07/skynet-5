<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class Skynet extends SkynetCoreAbstract
{  
  use SkynetErrorsTrait, SkynetStatesTrait;

  private $clasterUrl;
  private $response;
  private $responseData;
  private $request;
  private $isConnected = false; 
 
  
  public function __construct($url = null)
  {   
    parent::__construct();
    
    if($url !== null) $this->clusterUrl = $url;    
    $this->request = new SkynetRequest();
    $this->response = new SkynetResponse();
  }  
  
  public function setClusterUrl($url)
  {
      $this->clusterUrl = $url;
  }
  
  public function connect()
  {
    try 
    {      
      $this->conn->setUrl($this->clusterUrl);
      $this->request->addMetaData();
      $this->conn->assignRequest($this->request);
      $this->responseData = $this->conn->connect();    
      
      if($this->responseData == null) throw new \Exception('CONNECTION ERROR');
      $this->response->assignConn($this->conn);
      $this->isConnected = true;
      $this->addState(new SkynetState(1, 'CONNECTED: '. $this->conn->getUrl().$this->conn->getParams()));      
      
    } catch(\Exception $e)
    {
      $this->addState(new SkynetState(0, 'NOT_CONNECTED: '. $this->conn->getUrl().$this->conn->getParams()));
      $this->addError('Connection error: '.$e->getMessage()); 
    }    
  }
  
  public function getResponse()
  {
    return $this->response;
  }  
  
  public function getRequest()
  {
    return $this->request;
  } 
  
  public function dumpResponse()
  {
    return $this->response->dumpResponse();
  }  
  
  public function __toString()
  {
    $debug = '<h1>SKYNET</h1>';
    $debug.= SkynetDebug::dump(array(
      'skynetID' => $this->skynetID, 
      'clusterURL' => $this->clusterUrl, 
      'clusterParams' => $this->conn->getParams(),
      'time' => time()
    ));
    $debug.= SkynetDebug::dump($this->states, 'States');
    $debug.= SkynetDebug::dump($this->errors, 'Errors');    
    $debug.= SkynetDebug::dump($this->request->getFields(), 'Request Fields {sended} (raw)');
    if(!$this->options['core_raw']) $debug.= SkynetDebug::dump($this->request->getEncryptedFields(), 'Request Fields {sended} (encrypted)'); 
    if(!$this->options['core_raw']) $debug.= SkynetDebug::dump($this->response->getDecryptedFields(), 'Response Fields {received} (decrypted)');       
    $debug.= SkynetDebug::dump($this->response->getFields(), 'Response Fields {received} (raw)');
    $debug.= SkynetDebug::dump($this->options, 'Options');
    return $debug;    
  }
}