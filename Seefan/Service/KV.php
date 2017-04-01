<?php
namespace Seefan\Service;
class KV extends Service
{
    public function __construct($base_url, $http)
    {
        parent::__construct($base_url, $http);
        $this->name = 'kv';
    }

    public function get($key)
    {
        $url = $this->name . '/' . $key;
        $resp = $this->http->request($this->base_url . $url);
        return $this->response($resp);
    }

    public function delete($key)
    {
        $url = $this->name . '/' . $key;
        $resp = $this->http->request($this->base_url . $url, '', 'DELETE');
        return $resp == 'true';
    }

    public function set($key, $value)
    {
        $url = $this->name . '/' . $key;
        $resp = $this->http->request($this->base_url . $url, $value, 'PUT');
        return $resp == 'true';
    }

    public function keys($key = '')
    {
        $url = $this->name . '/' . $key . '?keys';
        $resp = $this->http->request($this->base_url . $url);
        return parent::response($resp);
    }

    public function response($str)
    {
        if (!empty($str)) {
            $json = json_decode($str, true);
            if (count($json) > 0) {
                return base64_decode($json[0]['Value']);
            }
        }
        return '';
    }
}