<?php
/**
 * SkynetCluster [standalone]
 * @version 1.0.0
 * @build 25.03.2017
 * @www http://github.com/szczyglis/skynet_cluster
 * GNU/GPL
 */
namespace Skynet;

interface SkynetConnectionInterface
{
  public function setUrl($url);
  public function getUrl();
  public function getParams();
  public function connect();
  public function getData();
  public function assignRequest(SkynetRequest $request);
}