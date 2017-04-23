<?php

/**
 * Skynet/Database/SkynetDatabaseSchema.php
 *
 * @package Skynet
 * @version 1.1.3
 * @author Marcin Szczyglinski <szczyglis83@gmail.com>
 * @link http://github.com/szczyglinski/skynet
 * @copyright 2017 Marcin Szczyglinski
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 * @since 1.1.3
 */

namespace Skynet\Database;

 /**
  * Skynet Database Schema
  *
  * Database tables schema
  */
class SkynetDatabaseSchema
{  
  /** @var string[] Array with table names */
  private $dbTables = [];
  
  /** @var string[] Array with tables fields */
  private $tablesFields = [];  
    
  /** @var string[] Array with CREATE queries */
  private $createQueries = [];

 /**
  * Constructor (private)
  */
  public function __construct() 
  {
    
  }
  
 /**
  * Returns create queries
  *
  * @return string[] SQL Queries
  */   
  public function getCreateQueries()
  {   
    $this->createQueries = [];
    
    $this->createQueries['skynet_clusters'] = 'CREATE TABLE skynet_clusters (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), url TEXT, ip VARCHAR (15), version VARCHAR (6), last_connect INTEGER, registrator TEXT)';
    $this->createQueries['skynet_clusters_blocked'] = 'CREATE TABLE skynet_clusters_blocked (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), url TEXT, ip VARCHAR (15), version VARCHAR (6), last_connect INTEGER, registrator TEXT)';
    $this->createQueries['skynet_logs_responses'] = 'CREATE TABLE skynet_logs_responses (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, sender_url TEXT, receiver_url TEXT)';
    $this->createQueries['skynet_logs_requests'] = 'CREATE TABLE skynet_logs_requests (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, sender_url TEXT, receiver_url TEXT)';
    $this->createQueries['skynet_chain'] = ['CREATE TABLE skynet_chain (id INTEGER PRIMARY KEY AUTOINCREMENT, chain BIGINT, updated_at INTEGER)', 'INSERT INTO skynet_chain (id, chain, updated_at) VALUES(1, 0, 0)'];
    $this->createQueries['skynet_logs_echo'] = 'CREATE TABLE skynet_logs_echo (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, ping_from TEXT, ping_to TEXT, urls_chain TEXT)';
    $this->createQueries['skynet_logs_broadcast'] = 'CREATE TABLE skynet_logs_broadcast (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, ping_from TEXT, ping_to TEXT, urls_chain TEXT)';
    $this->createQueries['skynet_errors'] = 'CREATE TABLE skynet_errors (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, content TEXT, remote_ip VARCHAR (15))';
    $this->createQueries['skynet_access_errors'] = 'CREATE TABLE skynet_access_errors (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, remote_cluster TEXT, request_uri TEXT, remote_host TEXT, remote_ip VARCHAR (15))';
    $this->createQueries['skynet_registry'] = 'CREATE TABLE skynet_registry (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, key VARCHAR (15), content TEXT)';
    $this->createQueries['skynet_options'] = 'CREATE TABLE skynet_options (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, key VARCHAR (15), content TEXT)';
    $this->createQueries['skynet_logs_selfupdate'] = 'CREATE TABLE skynet_logs_selfupdate (id INTEGER PRIMARY KEY AUTOINCREMENT, skynet_id VARCHAR (100), created_at INTEGER, request TEXT, sender_url TEXT, source  TEXT, status TEXT, from_version VARCHAR (15), to_version VARCHAR (15))';

    return $this->createQueries;
  }
  
 /**
  * Returns tables names
  *
  * @return string[]
  */   
  public function getDbTables()
  {
    $this->dbTables = [];
    
    $this->dbTables['skynet_clusters'] = 'Clusters';
    $this->dbTables['skynet_clusters_blocked'] = 'Clusters (corrupted/blocked)';
    $this->dbTables['skynet_registry'] = 'Registry';
    $this->dbTables['skynet_options'] = 'Options';
    $this->dbTables['skynet_chain'] = 'Chain';
    $this->dbTables['skynet_logs_responses'] = 'Logs: Responses';
    $this->dbTables['skynet_logs_requests'] = 'Logs: Requests';
    $this->dbTables['skynet_logs_echo'] = 'Logs: Echo';
    $this->dbTables['skynet_logs_broadcast'] = 'Logs: Broadcasts';
    $this->dbTables['skynet_errors'] = 'Logs: Errors';
    $this->dbTables['skynet_access_errors'] = 'Logs: Access Errors';
    $this->dbTables['skynet_logs_selfupdate'] = 'Logs: Self-updates';  
    
    return $this->dbTables;   
  }

 /**
  * Returns tables fields
  *
  * @return string[]
  */  
  public function getTablesFields()
  {
    $this->tablesFields = [];
    
    $this->tablesFields['skynet_clusters'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'url' => 'URL Address',
    'ip' => 'IP Address',
    'version' => 'Skynet version',
    'last_connect' => 'Last connection',
    'registrator' => 'Added by'
    ];
    
    $this->tablesFields['skynet_clusters_blocked'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'url' => 'URL Address',
    'ip' => 'IP Address',
    'version' => 'Skynet version',
    'last_connect' => 'Last connection',
    'registrator' => 'Added by'
    ];
    
    $this->tablesFields['skynet_registry'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Last update',
    'key' => 'Key',
    'content' => 'Value'
    ];
    
     $this->tablesFields['skynet_options'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Last update',
    'key' => 'Key',
    'content' => 'Value'
    ];
    
    $this->tablesFields['skynet_chain'] = [
    'id' => '#ID',
    'chain' => 'Current Chain Value',
    'updated_at' => 'Last update'
    ];
    
    $this->tablesFields['skynet_logs_responses'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'content' => 'Full Response',
    'sender_url' => 'Response Sender',
    'receiver_url' => 'Response Receiver'
    ];
    
    $this->tablesFields['skynet_logs_requests'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'content' => 'Full Request',
    'sender_url' => 'Request Sender',
    'receiver_url' => 'Request Receiver'
    ];
    
    $this->tablesFields['skynet_logs_echo'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'request' => 'Echo Full Request',    
    'ping_from' => '@Echo received from',
    'ping_to' => '@Echo resended to',
    'urls_chain' => 'URLs Chain'
    ];
    
    $this->tablesFields['skynet_logs_broadcast'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Sended/received At',
    'request' => 'Echo Full Request',    
    'ping_from' => '@Broadcast received from',
    'ping_to' => '@Broadcast resended to',
    'urls_chain' => 'URLs Chain'
    ];
    
    $this->tablesFields['skynet_errors'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Created At',
    'content' => 'Error log',    
    'remote_ip' => 'IP Address'
    ];
    
    $this->tablesFields['skynet_access_errors'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Created At',
    'request' => 'Full Request',
    'remote_cluster' => 'Remote Cluster Address',
    'request_uri' => 'Request URI',
    'remote_host' => 'Remote Host',
    'remote_ip' => 'Remote IP Address'
    ];
    
    $this->tablesFields['skynet_logs_selfupdate'] = [
    'id' => '#ID',
    'skynet_id' => 'SkynetID',
    'created_at' => 'Created At',
    'request' => 'Full Request',
    'sender_url' => 'Update command Sender',
    'source' => 'Update remote Source Code',
    'status' => 'Update Status',
    'from_version' => 'From version (before)',
    'to_version' => 'To version (after)'
    ];
    
    return $this->tablesFields;
  }
}