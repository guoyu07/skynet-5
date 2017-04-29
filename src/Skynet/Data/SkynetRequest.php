<?php

/**
 * Skynet/Data/SkynetRequest.php
 *
 * @package Skynet
 * @version 1.2.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Data;

use Skynet\State\SkynetStatesTrait;
use Skynet\Cluster\SkynetClustersRegistry;
use Skynet\Cluster\SkynetClusterHeader;
use Skynet\Cluster\SkynetClustersUrlsChain;
use Skynet\Core\SkynetChain;
use Skynet\Encryptor\SkynetEncryptorsFactory;
use Skynet\Secure\SkynetVerifier;
use Skynet\Database\SkynetDatabase;
use Skynet\Common\SkynetTypes;
use Skynet\Data\SkynetParams;
use Skynet\Common\SkynetHelper;
use Skynet\SkynetVersion;

 /**
  * Skynet Request
  *
  * Stores and generates Requests
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetRequest
{
  use SkynetStatesTrait;

  /** @var SkynetField[] Array of request fields */
  private $fields = [];

  /** @var string[] Indexed array with requests data */
  private $requests = [];

  /** @var SkynetClustersRegistry SkynetClustersRegistry instance */
  private $clustersRegistry;
  
  /** @var clustersUrlsChain clustersUrlsChain instance */
  private $clustersUrlsChain;

  /** @var SkynetChain SkynetChain instance */
  private $skynetChain;

  /** @var SkynetEncryptorInterface SkynetEncryptor instance */
  private $encryptor;

  /** @var SkynetVerifier SkynetVerifier instance */
  private $verifier;
  
  /** @var SkynetParams Params Operations */
  protected $paramsParser;
  
  /** @var bool True if connection from Client */
  private $isClient = false;


 /**
  * Constructor
  *
  * @param bool $isClient True if Client
  *
  * @return SkynetRequest $this Instance of $this
  */
  public function __construct($isClient = false)
  {
    $this->isClient = $isClient;
    $this->clustersRegistry = new SkynetClustersRegistry($isClient);
    $this->clustersUrlsChain = new SkynetClustersUrlsChain($isClient);
    $this->skynetChain = new SkynetChain($isClient);
    $this->encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $this->verifier = new SkynetVerifier();
    $this->paramsParser = new SkynetParams();
    return $this;
  }  
  
 /**
  * Returns value of request field
  *
  * @param string $key Field key
  * @return string Value of requested field
  */
  public function get($key = null)
  {
    if($key !== null)
    {
      $this->reloadRequest();

      if(array_key_exists($key, $this->requests))
      {
        $field = $this->requests[$key];
        if($this->paramsParser->isPacked($field))
        {
           return $this->paramsParser->unpackParams($field);
        } else {
           return $field;
        }
       
      } else {
        return null;
      }
    }
  }
  
 /**
  * Quick alias for add new request field
  *
  * @param string $name Field name/key
  * @param string $value Field value
  *
  * @return SkynetRequest Instance of $this
  */
  public function add($name, $value)
  {
    return $this->set($name, $value);
  }
  
 /**
  * Quick alias to create new request field
  *
  * @param string $key Key of new request field
  * @param string $value Value of new request field
  *
  * @return SkynetRequest Instance of $this
  */
  public function set($key, $value)
  {
    if(is_array($value))
    {
       $this->addField($key, new SkynetField($key, $this->paramsParser->packParams($value)));
    } else {
       $this->addField($key, new SkynetField($key, $value));
    }
     
    return $this;
  }
  
 /**
  * Generates associative array with requests data indexed by keys of request fields
  *
  * @param bool $encrypted Sets mode for encryption: NULL - do nothing, FALSE - encrypt field, TRUE - decrypt field
  *
  * @return string[] Indexed requests
  */
  public function prepareRequests($encrypted = null)
  {
    $this->requests = [];
    $newFields = [];

    foreach($this->fields as $field)
    {
      $nowEncrypted = $field->getIsEncrypted();
      $field->setIsEncrypted($encrypted);
      $fieldKey = $field->getName();
      $fieldValue = $field->getValue();
      $this->requests[$fieldKey] = $fieldValue;
      $field->setIsEncrypted($nowEncrypted);
    }
    return $this->requests;
  }

 /**
  * Returns requests as array
  *
  * @return string[] Indexed requests
  */
  public function getRequests()
  {
    return $this->requests;
  }

 /**
  * Returns array with request fields objects
  *
  * @return SkynetField[] All request objects
  */
  public function getFields()
  {
    return $this->fields;
  }

 /**
  * Returns array with request fields objects and encrypt them
  *
  * @return SkynetField[] All request objects (encrypted)
  */
  public function getEncryptedFields()
  {
    if(\SkynetUser\SkynetConfig::get('core_raw'))  
    {
      return $this->fields;
    }

    $fields = [];
    foreach($this->fields as $field)
    {
      $key = $field->getName();
      $value = $field->getValue();     
      $fields[$key] = new SkynetField($key, $value);
      $fields[$key]->setIsEncrypted(false);
    }
    return $fields;
  }

 /**
  * Force reload and prepare requests
  */
  private function reloadRequest()
  {
    if(count($this->fields) == 0) 
    {
      $this->loadRequest();
    }
    $this->prepareRequests();
  }

 /**
  * Returns request fields as indexed array
  *
  * @return string[] All requests as indexed array
  */
  public function getRequestsData()
  {
    $fields = [];
    foreach($this->fields as $field)
    {
      $field->setIsEncrypted(null);
      $key = $field->getName();
      $value = $field->getValue();
      $fields[$key] = $value;
    }
    return $fields;
  }

 /**
  * Returns url of remote Skynet instance which was send request
  *
  * @return string Address of cluster
  */
  public function getSenderClusterUrl()
  {
    $url = $this->get('_skynet_cluster_url');

    /* If I'm sender */
    if(isset($_REQUEST['_skynet_cluster_url']))
    {
      if(\SkynetUser\SkynetConfig::get('core_raw'))
      {
        $url = $_REQUEST['_skynet_cluster_url'];
      } else {
        $url = $this->encryptor->decrypt($_REQUEST['_skynet_cluster_url']);
      }
    }

    /* If I'm receiver */
    if(isset($_REQUEST['_skynet_sender_url']))
    {
      if(\SkynetUser\SkynetConfig::get('core_raw'))
      {
        $url = $_REQUEST['_skynet_sender_url'];
      } else {
        $url = $this->encryptor->decrypt($_REQUEST['_skynet_sender_url']);
      }
    }
    return $url;
  }

 /**
  * Returns true if field exists in request
  *
  * @param string $key Name/key of request field
  *
  * @return bool If field exists return true
  */
  public function isField($key)
  {
    if(is_array($this->fields) && count($this->fields) > 0 && array_key_exists($key, $this->fields))
    {     
      return true;     
    }
  }

 /**
  * Adds internal skynet control data to request
  *
  * @param integer $chain New value of chain
  */
  public function addMetaData($chain = null)
  {
    if($chain !== null)
    {
      $this->set('_skynet_chain_new', $chain);
    }
    /* Prepare my header */
    $clusterHeader = new SkynetClusterHeader();
    $clusterHeader->generate();
    
    $milliseconds = round(microtime(true) * 1000);

    /* Create fields */
    $this->set('_skynet', 1);
    $this->set('_skynet_id', $clusterHeader->getId());
    $this->set('_skynet_ping', $milliseconds);
    $this->set('_skynet_hash', $this->verifier->generateHash());
    $this->set('_skynet_chain', $clusterHeader->getChain());
    $this->set('_skynet_chain_updated_at', $clusterHeader->getUpdatedAt());
    $this->set('_skynet_version', $clusterHeader->getVersion());
    $this->set('_skynet_cluster_url', $clusterHeader->getUrl());
    $this->set('_skynet_cluster_ip', $clusterHeader->getIp());
    $this->set('_skynet_cluster_time', time());   
    $this->set('_skynet_sender_time', time());
    $this->set('_skynet_sender_url', SkynetHelper::getMyUrl());
    
    if(\SkynetUser\SkynetConfig::get('core_urls_chain'))
    {
      if(!$this->isClient || \SkynetUser\SkynetConfig::get('client_registry'))
      {
        $this->set('_skynet_clusters_chain', $this->clustersUrlsChain->parseMyClusters());
      }
    }
  }

 /**
  * Loads requests data from GET and POST and put them as fields
  *
  * @return SkynetRequest Instance of $this
  */
  public function loadRequest()
  {
    if(is_array($_REQUEST) && count($_REQUEST) > 0)
    {
      foreach($_REQUEST as $key => $value)
      {
        $this->addField($key, new SkynetField($key, $value, true));
      }
    }
    return $this;
  }

 /**
  * Adds new field to request
  *
  * @param string $key Key
  * @param SkynetField $field New request field
  *
  * @return SkynetRequest Instance of $this
  */
  public function addField($key, SkynetField $field)
  {
    $this->fields[$key] = $field;
    return $this;
  }
}