<?php

require __DIR__.'/Http.php';
require __DIR__.'/service/service.php';
class ConsulClient
{
    private $http;
    private $base_url = '';
    private $service = array();

    public function __construct($option = array())
    {
        $default = array('host' => '127.0.0.1:8500', 'url' => '/v1/');
        $default = array_replace($default, $option);
        $this->base_url = $default['host'] . $default['url'];
        $this->http = new Http();
        if (!empty($default['token'])) {
            $this->http->query['token'] = $default['token'];
        }
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function get($name)
    {
        if (empty($this->service[$name])) {
            require __DIR__ . '/service/' . $name . '.php';
            $this->service[$name] = new $name($this->base_url, $this->http);
        }
        return $this->service[$name];
    }
}