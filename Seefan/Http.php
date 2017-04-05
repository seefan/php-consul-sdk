<?php
namespace Seefan;
class Http
{
    /**
     * @var array 公用的header
     */
    private $headers = array(
        'User-Agent' => 'php-consul-sdk',
        'Content-Type' => 'application/x-www-form-urlencoded',
        'Cache-Control' => 'max-age=0',
        'Accept' => '*/*',
        'Accept-Language' => 'zh-CN,zh;q=0.8',
    );

    /**
     * @var array 公用的URL参数
     */
    public $query = array();

    /**
     * http的语法
     *
     * @param    string $url 地址
     * @param string    $param 参数
     * @param string    $method 请求类型
     * @param array     $header 自定义头
     *
     * @return string
     */
    public function request($url, $param = '', $method = 'GET', $header = array())
    {
        $url = 'http://' . $url;
        if (strpos($url, '?') === false) {
            $url .= '?' . http_build_query($this->query);
        } else {
            $url .= '&' . http_build_query($this->query);
        }
        if (is_array($param)) {
            $param = http_build_query($param);
        }
        $http['method'] = $method;
        $http['header'] = '';
        $header['Content-Length'] = strlen($param);
        $header = array_replace($this->headers, $header);
        foreach ($header as $k => $v) {
            if (!empty($v)) {
                $http['header'] .= $k . ':' . $v . "\r\n";
            }
        }
        $http['content'] = $param;
        $opts = array('http' => $http);
        $context = stream_context_create($opts);
        return @file_get_contents($url, false, $context);
    }
}