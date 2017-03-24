<?php
require_once 'skynet.php';

$skynet = new \Skynet\Skynet('http://localhost/skynet/skynetCluster.php');
$skynet->getRequest()->addField(new \Skynet\SkynetField('field1', 'val1'));
$skynet->getRequest()->addField(new \Skynet\SkynetField('field222', 'val222'));
$skynet->getRequest()->addField(new \Skynet\SkynetField('field3333', 'val333'));
$skynet->connect();
$skynet->getResponse()->loadResponse();
echo $skynet;
//echo $skynetCluster->getRequest()->dumpRequest();

//echo $skynetCluster->renderResponse();

