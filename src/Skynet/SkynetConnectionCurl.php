<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetConnectionCurl  implements SkynetConnectionInterface
{
  private $url;
  private $state;
  private $data;
  private $params;
  private $request;
  private $requests = [];
  
  public function setUrl($url)
  {
    $this->url = $url;
  }  
  
  private function prepareParams()
  {    
    $fields = [];
    
    if(is_array($this->requests) && count($this->requests) > 0)
    {
      foreach($this->requests as $fieldKey => $fieldValue)
      {
        $fields[] = $fieldKey.'='.$fieldValue;
      }      
      if(count($fields) > 0)  $this->params = '?'.implode('&amp;', $fields);   
    }    
  }  
  
  public function connect()
  {
    $this->prepareParams();
    $this->data = @file_get_contents($this->url.$this->params);
    return $this->data;
  }   
  
  public function assignRequest(SkynetRequest $request)
  {
    $this->request = $request;
    $this->requests = $request->prepareRequestsArray();
  }  
   
  public function getData()
  {
    return $this->data;
  } 
  
  public function getUrl()
  {
    return $this->url;
  }
  
  public function getParams()
  {
    return $this->params;
  }
}