<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

class SkynetRequest extends SkynetCoreAbstract
{
  private $fields = [];
  private $requests = [];
   
  
  public function prepareRequestsArray()
  {
    $requestsEncrypted = [];
    foreach($this->fields as $field)
    {
      $fieldKey = $field->getName();
      $fieldValue = $field->getValue();
      if($this->options['core_raw']) 
      {
        $requestsEncrypted[$fieldKey] = $fieldValue;   
      } else {
        $requestsEncrypted[$fieldKey] = SkynetEncrypt::encrypt($fieldValue);    
      }        
      $this->requests[$fieldKey] = $fieldValue;     
    } 
    return $requestsEncrypted;
  }
  
  public function getRequests()
  {
    return $this->requests;
  }
  
  public function getFields()
  {
    return $this->fields;
  }
  
  public function getEncryptedFields()
  {
    if($this->options['core_raw'])  return $this->fields;
      
    $fields = [];
    foreach($this->fields as $field)
    {
      $fields[] = new SkynetField($field->getName(), SkynetEncrypt::encrypt($field->getValue()));      
    }    
    return $fields;
  } 
  
  private function reloadRequest()
  {
    $this->loadRequest();
    $this->prepareRequestsArray();    
  }
  
  public function get($key = null)
  {
    if($key !== null)
    {
      if(!is_array($this->requests) || count($this->requests) > 0) 
      {
        $this->reloadRequest();
      }
      if(array_key_exists($key, $this->requests)) 
      {
        if($this->options['core_raw']) 
        {
          return $this->requests[$key];
        } else {
          return SkynetEncrypt::encrypt($this->requests[$key]);
        }        
      }
    }
  }
  
  public function addMetaData()
  {
    $this->fields[] = new SkynetField('_skynet', 1);
    $this->fields[] = new SkynetField('_skynetID', $this->skynetID);
    $this->fields[] = new SkynetField('_skynet_sender_ip', $_SERVER['REMOTE_ADDR']);
    $this->fields[] = new SkynetField('_skynet_sender_time', time());    
  }
  
  public function loadRequest()
  {   
    if(is_array($_REQUEST) && count($_REQUEST) > 0) 
    {
      foreach($_REQUEST as $requestKey => $requestValue)
      {
        if($this->options['core_raw']) 
        {
          $this->addField(new SkynetField($requestKey, $requestValue));  
        } else {
          $this->addField(new SkynetField($requestKey, SkynetEncrypt::decrypt($requestValue))); 
        }
      }    
    }
    return $this;
  }
  
  public function addField(SkynetField $field)
  {
    $this->fields[] = $field;   
    return $this;
  }

  public function dumpRequest()
  {
    var_dump($this->requests);    
  }
  
  public function dump()
  {
    var_dump($this->fields);    
  }
}