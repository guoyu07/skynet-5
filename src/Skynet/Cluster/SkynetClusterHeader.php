<?php

/**
 * Skynet/Cluster/SkynetClusterHeader.php
 *
 * @package Skynet
 * @version 1.0.0
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Cluster;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\Encryptor\SkynetEncryptorsFactory;
use Skynet\Secure\SkynetVerifier;
use Skynet\Connection\SkynetConnectionsFactory;
use Skynet\SkynetVersion;
use Skynet\Common\SkynetHelper;
use Skynet\Common\SkynetTypes;
use Skynet\Data\SkynetRequest;
use Skynet\Data\SkynetResponse;
use Skynet\Core\SkynetChain;
use Skynet\Error\SkynetException;

 /**
  * Skynet Cluster Header Data
  *
  * Stores cluster header
  */
class SkynetClusterHeader
{
  use SkynetStatesTrait, SkynetErrorsTrait;

  /** @var integer Actual value of chain */
  private $chain;

  /** @var string Cluster skynetID*/
  private $id;

  /** @var string Cluster URL */
  private $url;

  /** @var string Cluster IP address */
  private $ip;

  /** @var string Skynet version */
  private $version;

  /** @var integer Skynet param */
  private $skynet;

  /** @var string Chain with clusters from database */
  private $clusters;

  /** @var integer Time of last update in database */
  private $updated_at;

  /** @var SkynetEncryptorInterface Encryptor instance */
  private $encryptor;

  /** @var SkynetVerifier Verifier instance */
  private $verifier;

  /** @var string[] Exploded list of clusters URLs from chain */
  private $clustersList = [];

  /** @var SkynetConnectionInterface Connector instance */
  private $connection;
  
  private $ping = 0;

 /**
  * Constructor
  */
  public function __construct()
  {
    $this->connection = SkynetConnectionsFactory::getInstance()->getConnector(\SkynetUser\SkynetConfig::get('core_connection_type'));
    $this->encryptor = SkynetEncryptorsFactory::getInstance()->getEncryptor();
    $this->verifier = new SkynetVerifier();
  }

 /**
  * Encrypts data with encryptor
  *
  * @param string $str String to be encrypted
  *
  * @return string Encrypted data
  */
  private function encrypt($str)
  {
    if(!\SkynetUser\SkynetConfig::get('core_raw'))
    {
      return $this->encryptor->encrypt($str);
    } else {
      return $str;
    }
  }

 /**
  * Decrypts data with encryptor
  *
  * @param string $str String to be decrypted
  *
  * @return string Decrypted data
  */
  private function decrypt($str)
  {
    if(!\SkynetUser\SkynetConfig::get('core_raw'))
    {
      return $this->encryptor->decrypt($str);
    } else {
      return $str;
    }
  }

 /**
  * Generates and fills header data
  */
  public function generate()
  {
    $skynetChain = new SkynetChain();
    $chainData = $skynetChain->loadChain();

    $this->skynet = 1;
    $this->chain = $chainData['chain'];
    $this->updated_at = $chainData['updated_at'];
    $this->id = $this->verifier->getKeyHashed();
    $this->url = SkynetHelper::getMyUrl();
    if(isset($_SERVER['SERVER_ADDR']))
    {
      $this->ip = $_SERVER['SERVER_ADDR'];
    }
    $this->version = SkynetVersion::VERSION;
    $this->clusters = '';
  }

 /**
  * Fills header data from remote address
  *
  * Method connects to remote cluster and gets cluster header from connection
  *
  * @param string $address Remote Cluster URL
  *
  * @return string[] Array with raw received data and params
  */
  public function fromConnect($address = null)
  {
    if($address === null)
    {
       $this->addState(SkynetTypes::HEADER, 'CLUSTER ADDRESS IS NOT SET');
       return false;
    }
    
    $address = \SkynetUser\SkynetConfig::get('core_connection_protocol').$address;
    if($this->stateId !== null) 
    {
      $this->connection->setStateId($this->stateId);
    }

    $ary = [];
    $key = $this->verifier->getKeyHashed();

    $ary['_skynet_hash'] = $this->verifier->generateHash();
    $ary['_skynet_chain_request'] = '1';
    $ary['_skynet_id'] = $key;

    if(!\SkynetUser\SkynetConfig::get('core_raw'))
    {
      $ary['_skynet_hash'] = $this->encryptor->encrypt($ary['_skynet_hash']);
      $ary['_skynet_chain_request'] = $this->encryptor->encrypt($ary['_skynet_chain_request']);
      $ary['_skynet_id'] = $this->encryptor->encrypt($key);
    }

    $this->connection->setRequests($ary);
    
    try
    {
      /* Try to connect to get header data */
      $adapter = $this->connection->connect($address);
      $data = $adapter['data'];
    
      if($data === null || empty($data))
      {
        throw new SkynetException('CLUSTER HEADER IS NULL: '.$address);
      }
      
      /* Decode received header */
      $remoteHeader = json_decode($data);
      
    } catch(SkynetException $e)
    {
      $this->addState(SkynetTypes::HEADER, 'CLUSTER HEADER IS NULL');
      $this->addError(SkynetTypes::HEADER, $e->getMessage(), $e);
    }

    /* Assign received header data */
    if(isset($remoteHeader->_skynet_chain)) 
    {
      $this->chain = (int)$this->decrypt($remoteHeader->_skynet_chain);
    }
    
    if(isset($remoteHeader->_skynet_chain_updated_at)) 
    {
      $this->updated_at = $this->decrypt($remoteHeader->_skynet_chain_updated_at);
    }
    
    if(isset($remoteHeader->_skynet_id)) 
    {
      $this->id = $this->decrypt($remoteHeader->_skynet_id);
    }
    
    if(isset($remoteHeader->_skynet_cluster_url)) 
    {
      $this->url = $this->decrypt($remoteHeader->_skynet_cluster_url);
    }
    
    if(isset($remoteHeader->_skynet_cluster_ip)) 
    {
      $this->ip = $this->decrypt($remoteHeader->_skynet_cluster_ip);
    }
    
    if(isset($remoteHeader->_skynet_version)) 
    {
      $this->version = $this->decrypt($remoteHeader->_skynet_version);
    }
    
    if(isset($remoteHeader->_skynet_clusters)) 
    {
      $this->clusters = $this->decrypt($remoteHeader->_skynet_clusters);
    }
    
    if(isset($remoteHeader->_skynet_ping)) 
    {
      $this->ping = round(microtime(true) * 1000) - $this->decrypt($remoteHeader->_skynet_ping);
    }

    /* For debug, return received data */
    return $adapter;
  }

 /**
  * Fills header data from response object
  *
  * @param SkynetResponse $response
  */
  public function fromResponse(SkynetResponse $response)
  {
    $data = $response->getResponseData();
    
    if(isset($data['_skynet_chain'])) 
    {
      $this->chain = (int)$data['_skynet_chain'];
    }
    
    if(isset($data['_skynet_chain_updated_at'])) 
    {
      $this->updated_at = $data['_skynet_chain_updated_at'];
    }
    
    if(isset($data['_skynet_id'])) 
    {
      $this->id = $data['_skynet_id'];
    }
    
    if(isset($data['_skynet_cluster_url'])) 
    {
      $this->url = $data['_skynet_cluster_url'];
    }
    
    if(isset($data['_skynet_cluster_ip'])) 
    {
      $this->ip = $data['_skynet_cluster_ip'];
    }
    
    if(isset($data['_skynet_version'])) 
    {
      $this->version = $data['_skynet_version'];
    }
    
    if(isset($data['_skynet_clusters'])) 
    {      
      $this->clusters = $data['_skynet_clusters'];   
    }
    
    if(isset($data['_skynet_ping'])) 
    {      
      $this->ping = round(microtime(true) * 1000) - $data['_skynet_ping'];   
    }
  }

 /**
  * Generates header data from response object
  *
  * @param SkynetRequest $request
  */
  public function fromRequest(SkynetRequest $request)
  {
    $data = $request->getRequestsData();
    
    if(isset($data['_skynet_chain'])) 
    {
      $this->chain = (int)$data['_skynet_chain'];
    }
    
    if(isset($data['_skynet_chain_updated_at'])) 
    {
      $this->updated_at = $data['_skynet_chain_updated_at'];
    }    
    
    if(isset($data['_skynet_id'])) 
    {
      $this->id = $data['_skynet_id'];
    }
    
    if(isset($data['_skynet_cluster_url'])) 
    {
      $this->url = $data['_skynet_cluster_url'];      
    }
    
    if(isset($data['_skynet_cluster_ip'])) 
    {
      $this->ip = $data['_skynet_cluster_ip'];
    }
    
    if(isset($data['_skynet_version'])) 
    {
      $this->version = $data['_skynet_version'];
    }
    
    if(isset($data['_skynet_clusters'])) 
    {
      $this->clusters = $data['_skynet_clusters'];
    }
    
    if(isset($data['_skynet_ping'])) 
    {      
      $this->ping = round(microtime(true) * 1000) - $data['_skynet_ping'];   
    }
  }

 /**
  * Returns chain value
  *
  * @return integer
  */
  public function getChain()
  {
    return $this->chain;
  }

 /**
  * Returns SkynetID/key
  *
  * @return string
  */
  public function getId()
  {
    return $this->id;
  }

 /**
  * Returns cluster URL
  *
  * @return string
  */
  public function getUrl()
  {
    return $this->url;
  }

 /**
  * Returns cluster IP
  *
  * @return string
  */
  public function getIp()
  {
    return $this->ip;
  }

 /**
  * Returns cluster Skynet version
  *
  * @return string
  */
  public function getVersion()
  {
    return $this->version;
  }

 /**
  * Returns clusters chain
  *
  * @return string Base64 encoded addresses, separated by ";"
  */
  public function getClusters()
  {
    return $this->clusters;
  }

 /**
  * Returns time of last update in database
  *
  * @return integer Unix time format
  */
  public function getUpdatedAt()
  {
    return $this->updated_at;
  }

 /**
  * Returns clusters urls array
  *
  * @return string[]
  */
  public function getClustersList()
  {
    return $this->clusterList;
  }

 /**
  * Gets ping
  */
  public function getPing()
  { 
    return $this->ping;
  }
  
 /**
  * Sets chain value
  *
  * @param integer $chain
  */
  public function setChain($chain)
  {
    $this->chain = $chain;
  }

 /**
  * Sets skynetID/key
  *
  * @param string $id
  */
  public function setId($id)
  {
    $this->id = $id;
  }

 /**
  * Sets cluster URL
  *
  * @param string $url
  */
  public function setUrl($url)
  {
    $this->url = $url;
  }

 /**
  * Sets cluster IP
  *
  * @param string $ip
  */
  public function setIp($ip)
  {
    $this->ip = $ip;
  }

 /**
  * Sets cluster's Skynet version
  *
  * @param string $version
  */
  public function setVersion($version)
  {
    $this->version = $version;
  }

 /**
  * Sets clusters URLs chain
  *
  * @param string[] $clusters Base64 encoded chain, clusters separated by ";"
  */
  public function setClusters($clusters)
  {
    $this->clusters = $clusters;
  }

 /**
  * Sets updat time
  *
  * @param integer $updated_at Unix time format
  */
  public function setUpdatedAt($updated_at)
  {
    $this->updated_at = $updated_at;
  }

 /**
  * Sets clusters list array
  *
  * @param string[] $clustersList
  */
  public function setClustersList($clustersList)
  {
    $this->clustersList = $clustersList;
  }
}