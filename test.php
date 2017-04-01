<?php
/**
 * Created by xcar.com.cn
 * User: zng
 * Date: 2017/4/1
 * Time: 10:22
 */
require 'ConsulClient.php';
$cc = new ConsulClient(['host' => '10.20.28.51:8500']);
//var_dump( $cc->catalog->services());
//var_dump($cc->kv->get('service/0000'));
//var_dump($cc->agent->self());
//echo $cc->kv->set('test/test1', 'zng');
//$cc->kv->delete('test/test1');
$str = '{
  "ID": "redis1",
  "Name": "redis",
  "Tags": [
    "primary",
    "v1"
  ],
  "Address": "127.0.0.1",
  "Port": 8000,
  "EnableTagOverride": false
}';
//$param = json_decode($str, true);
//var_dump($cc->agent->service('register', $param));
//$cc->agent->service('deregister','redis1');
//$rsp=$cc->catalog->service('XE');

$json_str = '{
                 "Datacenter": "dc1",
                 "ID": "40e4a748-2192-161a-0510-9bf59fe950b5",
                 "Node": "foobar",
                 "Address": "192.168.10.10",
                 "TaggedAddresses": {
                   "lan": "192.168.10.10",
                   "wan": "10.0.10.10"
                 },
                 "NodeMeta": {
                   "somekey": "somevalue"
                 },
                 "Service": {
                   "ID": "redis1",
                   "Service": "redis",
                   "Tags": [
                     "primary",
                     "v1"
                   ],
                   "Address": "127.0.0.1",
                   "Port": 8000
                 },
                 "Check": {
                   "Node": "foobar",
                   "CheckID": "service:redis1",
                   "Name": "Redis health check",
                   "Notes": "Script based health check",
                   "Status": "passing",
                   "ServiceID": "redis1"
                 }
               }';
$json = json_decode($json_str, true);
$rsp = $cc->catalog->register($json);
var_dump($rsp);