<?php
namespace Seefan;

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
        $name = ucwords($name);
        if (empty($this->service[$name])) {
            $class_name = "Seefan\\Service\\$name";
            $this->service[$name] = new $class_name($this->base_url, $this->http);
        }
        return $this->service[$name];
    }

}

spl_autoload_register(function ($class) {
    $file = $class . '.php';
    if (is_file($file)) {
        require($file);
    }
}
);