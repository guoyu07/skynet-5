<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetCluster extends SkynetCoreAbstract 
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  private $response;
  private $request;  
  private $requestURI;
 
  
  public function __construct()
  {
    $this->assignRequest();
    $this->assignResponse();
    $this->requestURI = $_SERVER['REQUEST_URI'];
    return $this;
  }  
  
  public function setRaw($mode)
  {
    $this->raw = $mode;
  }
  
  private function assignResponse(SkynetResponse $response = null)
  {
    ($response !== null) ? $this->response = $response : $this->response = new SkynetResponse(); 
    if($this->response !== null) $this->addState(new SkynetState(1, 'RESPONSE_SET'));    
  }
  
  private function assignRequest(SkynetRequest $request = null)
  {
    ($request !== null) ? $this->request = $request : $this->request = new SkynetRequest();
    if($this->request !== null) 
    {
      $this->addState(new SkynetState(1, 'REQUEST_SET')); 
      $this->request->loadRequest();
      $this->request->prepareRequestsArray();
    }      
  }
  
  public function getRequest()
  {
    return $this->request;
  }  
  
  public function getResponse()
  {
    return $this->response;
  }    
  
  public function launch()
  {
    return $this->response->generateResponse();    
  }
  
  public function __toString()
  {
    $debug = '<h1>SKYNET CLUSTER</h1>';
    $debug.= SkynetDebug::dump(array(
      'skynetID' => $this->skynetID, 
      'requestURI' => $this->requestURI, 
      'time' => time()
    ));
    $debug.= SkynetDebug::dump($this->states, 'States');
    $debug.= SkynetDebug::dump($this->errors, 'Errors');
    $debug.= SkynetDebug::dump($this->response->getFields(), 'Response Fields');
    $debug.= SkynetDebug::dump($this->request->getFields(), 'Request Fields');
    $debug.= SkynetDebug::dump($this->request->getRequests(), 'Request Requests');
    return $debug; 
  }
}