<?php
namespace Seefan\Service;

use Seefan\Http;

class Service
{
    /**
     * @var Http
     */
    protected $http;
    protected $base_url = '';
    public $name = 'agent';

    public function response($str)
    {
        if ($str === false) {
            return false;
        }
        if (empty($str)) {
            return '';
        }
        return json_decode($str, true);
    }

    public function __construct($base_url, $http)
    {
        $this->base_url = $base_url;
        $this->http = $http;
    }

    public function __call($method_name, $args)
    {
        $url = $this->name . '/' . $method_name;
        if (empty($args)) {
            $resp = $this->http->request($this->base_url . $url);
        } else {
            $param = array();
            foreach ($args as $arg) {
                if (is_array($arg)) {
                    $param = array_merge($param, $arg);
                } else {
                    $url .= '/' . $arg;
                }
            }
            if (empty($param)) {
                $resp = $this->http->request($this->base_url . $url);
            } else {
                $resp = $this->http->request($this->base_url . $url, json_encode($param), 'PUT');
            }
        }
        return $this->response($resp);
    }
}
