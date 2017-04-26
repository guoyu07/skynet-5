<?php

/**
 * Skynet/Cluster/SkynetClustersRegistry.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.0.0
 */

namespace Skynet\Cluster;

use Skynet\Error\SkynetErrorsTrait;
use Skynet\State\SkynetStatesTrait;
use Skynet\Database\SkynetDatabase;
use Skynet\Common\SkynetTypes;
use Skynet\Common\SkynetHelper;
use Skynet\Secure\SkynetVerifier;

 /**
  * Skynet Clusters Database Operations
  *
  * Manipulate clusters saved in database
  *
  * @uses SkynetErrorsTrait
  * @uses SkynetStatesTrait
  */
class SkynetClustersRegistry
{
  use SkynetErrorsTrait, SkynetStatesTrait;

  /** @var bool Status od database connection */
  protected $db_connected = false;

  /** @var bool Status of tables schema */
  protected $db_created = false;

  /** @var string URL od receiver */
  protected $receiverClusterUrl;

  /** @var string[] Array of received remote data from cluster */
  protected $remoteData = [];

  /** @var PDO PDO connection instance */
  protected $db;

  /** @var SkynetClusterHeader SkynetClusterHeader instance */
  private $clusterHeader;

  /** @var SkynetCluster Actual cluster entity */
  private $cluster;
  
  /** @var SkynetVerifier Verifier instance */
  private $verifier;

 /**
  * Constructor
  */
  public function __construct()
  {
    $dbInstance = SkynetDatabase::getInstance();
    $this->db_connected = $dbInstance->isDbConnected();
    $this->db_created = $dbInstance->isDbCreated();
    $this->db = $dbInstance->getDB();
    $this->verifier = new SkynetVerifier();
  }

 /**
  * Sets cluster header
  *
  * @param SkynetClusterHeader $header
  */
  public function setClusterHeader(SkynetClusterHeader $header)
  {
    $this->clusterHeader = $header;
  }

 /**
  * Sets cluster entity
  *
  * @param SkynetCluster $cluster
  */
  public function setCluster(SkynetCluster $cluster)
  {
    $this->cluster = $cluster;
  }

 /**
  * Returns cluster header
  *
  * @return SkynetClusterHeader
  */
  public function getClusterHeader()
  {
    return $this->cluster->getHeader();
  }

 /**
  * Returns cluster entity
  *
  * @return SkynetCluster
  */
  public function getCluster()
  {
    return $this->cluster;
  }

 /**
  * Sets array with remote data
  *
  * @param string[] $data
  */
  public function setRemoteData($data)
  {
    $this->remoteData = $data;
  }

 /**
  * Adds cluster into database
  *
  * @param SkynetCluster $cluster
  *
  * @return bool
  */  
  public function add(SkynetCluster $cluster = null)
  {
    /* Update from remote list from header */
    if($cluster === null)
    {
        return false;
    }
    
    if($cluster->getHeader() !== null  && !empty($cluster->getHeader()->getClusters()))
    {
      $this->updateFromHeader($cluster);
    }  
    
    if($this->isCluster($cluster))
    {
      return $this->update($cluster);
      
    } else {
      if(!$this->isClusterBlocked($cluster))
      {
        return $this->insert($cluster);
      }
    }    
  }  

 /**
  * Adds cluster into database
  *
  * @param SkynetCluster $cluster
  *
  * @return bool
  */  
  public function addBlocked(SkynetCluster $cluster = null)
  {
    /* Update from remote list from header */
    if($cluster === null)
    {
      return false;
    }   
    if(!$this->isClusterBlocked($cluster))
    {     
      return $this->insertBlocked($cluster);
    }
  }    
  
 /**
  * Returns number of clusters in database
  * 
  * @return int
  */  
  public function countClusters()
  {
    $counter = 0;
    try
    {
      $stmt = $this->db->query(
        'SELECT count(*) as c FROM skynet_clusters');     
      $stmt->execute();
      $row = $stmt->fetch();
      $counter = $row['c'];
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting records from database table: clusters failed', $e);
      return false;
    }    
    return $counter;   
  }

 /**
  * Returns number of blocked clusters in database
  * 
  * @return int
  */  
  public function countBlockedClusters()
  {
    $counter = 0;
    try
    {
      $stmt = $this->db->query(
        'SELECT count(*) as c FROM skynet_clusters_blocked');     
      $stmt->execute();
      $row = $stmt->fetch();
      $counter = $row['c'];
      $stmt->closeCursor();
      
    } catch(\PDOException $e)
    {
      $this->addError(SkynetTypes::PDO, 'Getting records from database table: clusters_blocked failed', $e);
      return false;
    }    
    return $counter;   
  }
  
 /**
  * Parse clusters from database into clusters chain
  *
  * @return string Chain with Base64 encoded urls
  */
  public function parseMyClusters()
  {
    $clusters = $this->getAll();
    $ary = [];
    $ret = '';
    if(count($clusters) > 0)
    {
      foreach($clusters as $cluster)
      {
        $ary[] = base64_encode($cluster->getUrl());
      }
      $ret = implode(';', $ary);
    }
    return $ret;
  }

 /**
  * Gets and returns clusters stored in database
  *
  * @return SkynetCluster[] Array of clusters
  */
  public function getAll()
  {
    $clusters = [];
    try
    {
      $stmt = $this->db->query(
      'SELECT * FROM skynet_clusters');

      while($row = $stmt->fetch())
      {
        $cluster = new SkynetCluster();
        $cluster->setId($row['id']);
        $cluster->setSkynetId($row['skynet_id']);
        $cluster->setUrl($row['url']);
        $cluster->setIp($row['ip']);
        $cluster->setVersion($row['version']);
        $cluster->setLastConnect($row['last_connect']);
        $cluster->setRegistrator($row['registrator']);
        $clusters[] = $cluster;
      }
      $stmt->closeCursor();
      return $clusters;
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
 /**
  * Checks for address exists
  *
  * @param string $url
  *
  * @return bool
  */ 
  public function addressExists($url)
  {
    $cluster = new SkynetCluster();
    $cluster->getHeader()->setUrl($url);
    if($this->isCluster($cluster))
    {
      return true;
    }    
  }

 /**
  * Checks for cluster exists in database
  *
  * @param SkynetCluster $cluster Cluster entity to check
  *
  * @return bool
  */
  public function isCluster(SkynetCluster $cluster = null)
  {   
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }    
    
    $url = SkynetHelper::cleanUrl($url);  
    
    try
    {
      $stmt = $this->db->prepare(
      'SELECT count(*) as c FROM skynet_clusters WHERE url = :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();

      $stmt->closeCursor();
      if($result['c'] > 0)
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Checks for cluster exists in database
  *
  * @param SkynetCluster $cluster Cluster entity to check
  *
  * @return bool
  */
  public function isClusterBlocked(SkynetCluster $cluster = null)
  {   
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }    
    
    $url = SkynetHelper::cleanUrl($url);
    
    try
    {
      $stmt = $this->db->prepare(
      'SELECT count(*) as c FROM skynet_clusters_blocked WHERE url = :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch();

      $stmt->closeCursor();
      if($result['c'] > 0)
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
 /**
  * Updates cluster in database
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function update(SkynetCluster $cluster = null)
  {
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }

    $url = SkynetHelper::cleanUrl($url);
    
    /* dont do anything when only file name in url */
    if($url == SkynetHelper::getMyself() || strpos($url, '/') === false)
    {
      return false;
    }
    
    $last_connect = time();
    $id = '';
    $ip = '';
    $version = '';
    
    if($cluster->getHeader() !== null)
    {
      $id = $cluster->getHeader()->getId();
      $ip = $cluster->getHeader()->getIp();
      $version = $cluster->getHeader()->getVersion();
    }

    try
    {
      if(!empty($id))
      {
        $stmt = $this->db->prepare('UPDATE skynet_clusters SET skynet_id = :skynet_id, ip = :ip, version = :version, last_connect = :last_connect WHERE url = :url');
        $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
        $stmt->bindParam(':ip', $ip, \PDO::PARAM_STR);
        $stmt->bindParam(':version', $version, \PDO::PARAM_STR);
      } else {
        $stmt = $this->db->prepare('UPDATE skynet_clusters SET last_connect = :last_connect WHERE url = :url');
      }
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->bindParam(':last_connect', $last_connect, \PDO::PARAM_INT);

      if($stmt->execute())
      {
        //$this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] UPDATED IN DB');
        return true;
      } else {
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] NOT UPDATED IN DB');
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

  /**
  * Removes cluster from database
  *
  * @param string $url Not remove
  *
  * @return bool True if success
  */
  public function removeAll($url = null)
  {
    try
    {
      $url = SkynetHelper::cleanUrl($url);
      
      $this->removeAllBlocked($url);
      
      $stmt = $this->db->prepare(
      'DELETE FROM skynet_clusters WHERE url != :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }  
  
 /**
  * Removes cluster from blocked database
  *
  * @param string $url Not remove
  *
  * @return bool True if success
  */
  public function removeAllBlocked($url = null)
  {
    try
    {
      $url = SkynetHelper::cleanUrl($url);
      
      $stmt = $this->db->prepare(
      'DELETE FROM skynet_clusters_blocked WHERE url != :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  } 
  
 /**
  * Removes cluster from database
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function remove(SkynetCluster $cluster = null)
  {
    //$url = $this->cluster->getHeader()->getUrl();
    if($cluster !== null) 
    {
      $url = $cluster->getUrl();
      $url = SkynetHelper::cleanUrl($url);
    }   

    try
    {
      $stmt = $this->db->prepare(
      'DELETE FROM skynet_clusters WHERE url = :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }
  
 /**
  * Removes cluster from blocked in database
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function removeBlocked(SkynetCluster $cluster = null)
  {    
    if($cluster !== null) 
    {
      $url = $cluster->getUrl();
      $url = SkynetHelper::cleanUrl($url);     
    }   

    try
    {
      $stmt = $this->db->prepare(
      'DELETE FROM skynet_clusters_blocked WHERE url = :url');
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      if($stmt->execute()) 
      {
        return true;
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }

 /**
  * Inserts cluster into database
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function insert(SkynetCluster $cluster = null)
  {
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }
    
    $url = SkynetHelper::cleanUrl($url);
    
    if(!$this->verifier->isAddressCorrect($url))
    {
      return false;
    }
    echo 'aaaaaa'.SkynetHelper::getMyUrl();
    /* dont do anything when only file name in url */
    if($url == SkynetHelper::getMyUrl() || $url == SkynetHelper::getMyself() || strpos($url, '/') === false)
    {
      return false;
    }  
    
    try
    {      
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_clusters (skynet_id, url, ip, version, last_connect, registrator)
      VALUES(:skynet_id, :url,  :ip, :version, :last_connect, :registrator)'
      );

      $last_connect = time();
      
      $id = '';
      $ip = '';
      $version = '';
      $registrator = '';
      
      if($cluster->getHeader() !== null)
      {
        $id = $cluster->getHeader()->getId();
        $ip = $cluster->getHeader()->getIp();
        $version = $cluster->getHeader()->getVersion();
        $registrator = $cluster->getHeader()->getUrl();
      } 

      $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->bindParam(':ip', $ip, \PDO::PARAM_STR);
      $stmt->bindParam(':version', $version, \PDO::PARAM_STR);
      $stmt->bindParam(':last_connect', $last_connect, \PDO::PARAM_INT);
      $stmt->bindParam(':registrator', $registrator, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] ADDED TO DB');
        return true;
      } else {
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] NOT ADDED TO DB');
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  }  
 
 /**
  * Inserts cluster into blocked list
  *
  * @param SkynetCluster $cluster Cluster entity to update
  *
  * @return bool True if success
  */
  public function insertBlocked(SkynetCluster $cluster = null)
  {
    if($cluster === null)
    {
      return false;
    }    
  
    if(!empty($cluster->getHeader()->getUrl()))
    {
      $url = $cluster->getHeader()->getUrl();
      
    } elseif(!empty($cluster->getUrl()))
    {
      $url = $cluster->getUrl();
      
    } else {
      
      return false;        
    }
    
    $url = SkynetHelper::cleanUrl($url);
    
    /* dont do anything when only file name in url */
    if($url == SkynetHelper::getMyUrl() || $url == SkynetHelper::getMyself() || strpos($url, '/') === false)
    {
      return false;
    }  
    
    if(!$this->verifier->isAddressCorrect($url))
    {
      return false;
    }
    
    try
    {      
      $stmt = $this->db->prepare(
      'INSERT INTO skynet_clusters_blocked (skynet_id, url, ip, version, last_connect, registrator)
      VALUES(:skynet_id, :url,  :ip, :version, :last_connect, :registrator)'
      );

      $last_connect = time();
      
      $id = '';
      $ip = '';
      $version = '';
      $registrator = '';
      
      if($cluster->getHeader() !== null)
      {
        $id = $cluster->getHeader()->getId();
        $ip = $cluster->getHeader()->getIp();
        $version = $cluster->getHeader()->getVersion();
        $registrator = $cluster->getHeader()->getUrl();
      } 

      $stmt->bindParam(':skynet_id', $id, \PDO::PARAM_STR);
      $stmt->bindParam(':url', $url, \PDO::PARAM_STR);
      $stmt->bindParam(':ip', $ip, \PDO::PARAM_STR);
      $stmt->bindParam(':version', $version, \PDO::PARAM_STR);
      $stmt->bindParam(':last_connect', $last_connect, \PDO::PARAM_INT);
      $stmt->bindParam(':registrator', $registrator, \PDO::PARAM_STR);

      if($stmt->execute())
      {
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] ADDED TO DB');
        return true;
      } else {
        $this->addState(SkynetTypes::CLUSTERS_DB, 'CLUSTER ['.$url.'] NOT ADDED TO DB');
      }
    
    } catch(\PDOException $e)
    {
      $this->addState(SkynetTypes::CLUSTERS_DB, SkynetTypes::DBCONN_ERR.' : '. $e->getMessage());
      $this->addError(SkynetTypes::PDO, 'DB CONNECTION ERROR: '.$e->getMessage(), $e);
    }
  } 
  
 /**
  * Updates clusters in database broadcasted by Skynet
  *
  * @param SkynetCluster $cluster Cluster object
  *
  * @return bool True if success
  */
  private function updateFromHeader(SkynetCluster $cluster)
  {
    $clusters_encoded = $cluster->getHeader()->getClusters();

    $clustersUrls = explode(';', $clusters_encoded);
    $newClusters = [];

    foreach($clustersUrls as $clusterUrlRaw)
    {
      $clusterUrlDecoded = base64_decode($clusterUrlRaw);
      if(strcmp($clusterUrlDecoded, SkynetHelper::getMyUrl()) != 0)
      {
        $url = SkynetHelper::cleanUrl($clusterUrlDecoded);
        $newCluster = new SkynetCluster();
        $newCluster->setUrl($url);
        $newClusters[] = $newCluster;
      }
    }

    /* Insert or update */
    foreach($newClusters as $cluster)
    {
      if(!$this->isClusterBlocked($cluster))
      {
        if($this->isCluster($cluster))
        {
          return $this->update($cluster);
        } else {
          return $this->insert($cluster);
        }
      }
    }
  }
}