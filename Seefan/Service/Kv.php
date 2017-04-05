<?php
namespace Seefan\Service;
class KV extends Service
{
    public function __construct($base_url, $http)
    {
        parent::__construct($base_url, $http);
        $this->name = 'kv';
    }

    /**
     * 删除指定键值
     * @param string $key
     *
     * @return bool 是否删除成功
     */
    public function delete($key)
    {
        $url = $this->name . '/' . $key;
        $resp = $this->http->request($this->base_url . $url, '', 'DELETE');
        return $resp == 'true';
    }

    /**
     * 返回指定键下的键名列表，如果指定键下还有子级的话
     * @param string $key
     *
     * @return mixed|string
     */
    public function keys($key = '')
    {
        $url = $this->name . '/' . $key . '?keys';
        $resp = $this->http->request($this->base_url . $url);
        return parent::response($resp);
    }

    protected function response($str)
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