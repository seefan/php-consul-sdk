# php-consul-sdk

简单好用的consul的php客户端，并且因为是php的客户端，所以也不准备支持consul的所有功能，只支持简单的查询功能，不支持session和watch等长连接的功能。

## 使用方法

#### 仔细的看consul
使用sdk需要你仔细的了解consul的http的API，因为php-consul-sdk是基于它实现的。

调用方式也遵循api的结构。
> 示例

实例化客户端

    require __DIR__.'/ConsulClient.php';
    $cc = new ConsulClient(['host' => '10.20.28.51:8500']);
调用API

consul支持的服务中，php-consul-sdk只支持了catalog、kv、agent、health几个。

kv服务因为特殊性单独实现了一些方法，请参见API。
   
#### 通用的consul的API

无参数

###### /v1/catalog/nodes : Lists nodes in a given DC
    
    //客户端调用
    $cc->catalog->nodes();
    
###### /v1/agent/services : Returns the services the local agent is managing

    //客户端调用
    $cc->agent->services();
    
有参数

###### /v1/catalog/service/\<service\> : Lists the nodes in a given service

    //客户端调用
    $cc->catalog->service('XE');

###### /v1/catalog/register : Registers a new node, service, or check

    $json_str='{
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
     $json=json_decode($json_str,true);
     $cc->catalog->register($json);
     
多个层级

###### /v1/agent/service/register : Registers a new local service

    $json_str='{
                 "ID": "redis1",
                 "Name": "redis",
                 "Tags": [
                   "primary",
                   "v1"
                 ],
                 "Address": "127.0.0.1",
                 "Port": 8000,
                 "EnableTagOverride": false,
                 "Check": {
                   "DeregisterCriticalServiceAfter": "90m",
                   "Script": "/usr/local/bin/check_redis.py",
                   "HTTP": "http://localhost:5000/health",
                   "Interval": "10s",
                   "TTL": "15s"
                 }
               }';
     $json=json_decode($json_str,true);
     $cc->agent->service('register',$json);
     $cc->agent->service('deregister','redis1');