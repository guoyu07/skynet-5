<?php
/* Skynet Client example */

spl_autoload_register(function($class)
{ 
  require_once 'src/'.str_replace("\\", "/", $class).'.php'; 
});

/* Create client */
$client = new Skynet\SkynetClient();

/* Set request field */
$client->request->set('foo', 'bar');

/* Send request and get response */
$client->connect('http://localhost/skynet/skynet.php');


/* If connected then get response */
if($client->isConnected)
{
  echo $client->response->get('@foo');
}