<?php 
require_once 'skynet.php';

$skynetCluster = new Skynet\SkynetCluster();
$response = $skynetCluster->getResponse();
$request = $skynetCluster->getRequest();
//$response->addField(new SkynetField('test', 'xxxxx'));
$response->add('nowe', 'nowawartosc');
//$requests = $request->getRequests();
$x = $request->get('xxx');
//echo $x;


//$skynetCluster->on

//$skynetCluster->getRequest()->dump();
/*
$requests = $skynetCluster->getRequest()->getRequests();
foreach($requests as $k => $v)
{
  $response->addField(new SkynetField('req_'.$k, 'req_'.$v));
}
*/
//echo $skynetCluster;
echo $skynetCluster->launch();

//echo sha1('dsadhsakd38cxzcnzbasdas99wpdjsdsadas');



