<?php
/**
 * Created by xcar.com.cn
 * User: zng
 * Date: 2017/4/1
 * Time: 10:22
 */
require 'Seefan\ConsulClient.php';
$cc = new Seefan\ConsulClient(['host' => '10.15.203.113:8500']);
//var_dump( $cc->catalog->services());
//var_dump($cc->kv->get('service/0000'));
//var_dump($cc->agent->self());
//echo $cc->kv->set('test/test1', 'zng');
$cc->kv->delete('test/test1');
$str = '{
  "ID": "redis1",
  "Name": "scene",
  "Tags": [
    "primary",
    "v1"
  ],
  "Address": "127.0.0.1",
  "Port": 8000,
  "EnableTagOverride": false,
  "Check": {
    "DeregisterCriticalServiceAfter": "90m",
    "HTTP": "http://localhost:5000/health",
    "Interval": "10s",
    "TTL": "10s"
  }
}';

//$rsp=$cc->agent->service('deregister','redis1');
//$param = json_decode($str, true);
//$rsp = $cc->agent->put('service','register', $param);
//$rsp=$cc->catalog->header('service','XE');
//$rsp = $cc->catalog->service('XE', ['tag' => '0000']);
//$json_str = '{
//                 "Datacenter": "dc1",
//                 "ID": "40e4a748-2192-161a-0510-9bf59fe950b5",
//                 "Node": "foobar",
//                 "Address": "192.168.10.10",
//                 "TaggedAddresses": {
//                   "lan": "192.168.10.10",
//                   "wan": "10.0.10.10"
//                 },
//                 "NodeMeta": {
//                   "somekey": "somevalue"
//                 },
//                 "Service": {
//                   "ID": "redis1",
//                   "Service": "redis",
//                   "Tags": [
//                     "primary",
//                     "v1"
//                   ],
//                   "Address": "127.0.0.1",
//                   "Port": 8000
//                 },
//                 "Check": {
//                   "Node": "foobar",
//                   "CheckID": "service:redis1",
//                   "Name": "Redis health check",
//                   "Notes": "Script based health check",
//                   "Status": "passing",
//                   "ServiceID": "redis1"
//                 }
//               }';
//$json = json_decode($json_str, true);
//$rsp = $cc->catalog->register($json);

//$json_str='{
//  "Datacenter": "dc1",
//  "Node": "foobar"
//}';
//$json = json_decode($json_str, true);
//$rsp = $cc->catalog->deregister($json);

//$rsp=$cc->agent->checks();
//$param['recurse'] = true;
//$rsp = $cc->kv->get('config', $param);
$param['recurse'] = true;
$rsp = $cc->kv->get('user', $param);
if (is_array($rsp)) {
    foreach ($rsp as $k => $v) {
        $user[substr($k, 5)] = $v;
    }
}
var_dump($user);
//$http = new Seefan\Http();
//$r=$http->header('10.20.28.51:8500/v1/kv/config', ['recurse' => true]);
//print_r($r);