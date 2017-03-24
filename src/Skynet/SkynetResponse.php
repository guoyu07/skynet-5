<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetResponse extends SkynetCoreAbstract
{
  use SkynetErrorsTrait, SkynetStatesTrait;
  
  private $fields = [];
  private $params = [];
  private $request;  
  
  public function addField(SkynetField $field)
  {
    $this->fields[] = $field;    
  } 
  public function assignConn(SkynetConnectionInterface $conn)
  {
      $this->conn = $conn;
  }
  
  public function add($name, $value)
  {
    $this->addField(new SkynetField($name, $value));
  }
  
  public function loadResponse()
  {
    $data = $this->conn->getData();
    $json = json_decode($data);

    if($json !== null)
    {      
      foreach($json as $k => $v)
      {
        $this->addField(new SkynetField($k, $v));  
      }
    }
  }
  
  public function getFields()
  {
    return $this->fields;
  }
  
  public function getDecryptedFields()
  {
    if($this->options['core_raw'])  return $this->fields;
      
    $fields = [];
    foreach($this->fields as $field)
    {
      $fields[] = new SkynetField($field->getName(), SkynetEncrypt::decrypt($field->getValue()));      
    }    
    return $fields;
  }
  
  public function getParams()
  {
    return $this->params;
  }
  
  private function addMetaRequest()
  {
    $this->request = new SkynetRequest();
    $this->request->loadRequest();
    $this->request->prepareRequestsArray();
    $requests = $this->request->getRequests();
    foreach($requests as $k => $v)
    {
     $this->fields[] = new SkynetField('@'.$k, $v);
    }    
  }
  
  private function addMetaData()
  {
    $this->fields[] = new SkynetField('_skynet', 1);
    $this->fields[] = new SkynetField('_skynetID', $this->skynetID);
    $this->fields[] = new SkynetField('_skynet_cluster_ip', $_SERVER['REMOTE_ADDR']);
    $this->fields[] = new SkynetField('_skynet_cluster_time', time());    
  }
  
  public function generateResponse()
  {
    $this->addMetaData();
    if($this->options['response_include_request'])  $this->addMetaRequest();
    
    $ary = [];
    foreach($this->fields as $field)
    {
      $key = $field->getName();
      if($this->options['core_raw']) 
      {
        $value = $field->getValue();
      } else {
        $value = SkynetEncrypt::encrypt($field->getValue());
      }
      $ary[$key] = $value;
    }    
    return json_encode($ary);    
  }  
  
  public function dumpResponse()
  {
    $str = '';
    foreach($this->fields as $field)
    {
      $key = $field->getName();
      $value = $field->getValue();
      $str.= $key.' => '.$value.'<br/>';
    }
    return $str;
  }
}