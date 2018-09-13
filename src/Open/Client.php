<?php

namespace Long\Youzan\Open;

use Exception;
use Long\Youzan\RequestMethod\Common;

/**
 * Class Client
 * @package Long\Youzan\Open
 */
class Client
{
    private static $requestUrl = 'https://open.youzan.com/api/oauthentry/';

    private $accessToken;

    public function getAccessToken()
    {
        return $this->accessToken ?: $this->accessToken = app(Token::class)->getToken();
    }


    public function __construct()
    {
        $this->accessToken = $this->getAccessToken();
        if ('' == $this->accessToken) throw new Exception('access_token不能为空');
    }

    public function get($method, $params = array())
    {
        return $this->parseResponse(
            Http::get($this->url($method), $this->buildRequestParams($method, $params))
        );
    }

    public function post($method, $params = array(), $files = array())
    {
        return $this->parseResponse(
            Http::post($this->url($method), $this->buildRequestParams($method, $params), $files)
        );
    }

    /**
     * 获取请求的 url
     * 最终值类的形式似于  "https://open.youzan.com/api/oauthentry/youzan.users.weixin.followers.info/3.0.0/search"
     * @param $method
     * @return string
     */
    public function url($method)
    {
      
        $segments = explode('.', $method);

        // $segments是去掉最后一个参数后剩余的值   $last 是最后一个参数的值
        $last = array_pop($segments);

        return self::$requestUrl . implode('.', $segments) . \sprintf('/%s/%s', Common::API_VERSION, $last);
    }

    private function parseResponse($responseData)
    {
        $data = json_decode($responseData, true);
        if (null === $data) throw new Exception('response invalid, data: ' . $responseData);
        /**
         * error_response: {
        code: 141500101,
        message: "每页条数（page_size）必须在 1-50 区间内"
        }
         */
//        if (isset($data['error_response']))
        return $data;
    }

    private function buildRequestParams($method, $apiParams)
    {
        if (!is_array($apiParams)) $apiParams = array();
        $pairs = $this->getCommonParams($this->accessToken, $method);
        foreach ($apiParams as $k => $v) {
            if (isset($pairs[$k])) throw new Exception('参数名冲突');
            $pairs[$k] = $v;
        }

        return $pairs;
    }

    private function getCommonParams($accessToken, $method)
    {
        $params = array();
        $params[Protocol::TOKEN_KEY] = $accessToken;
        $params[Protocol::METHOD_KEY] = $method;
        return $params;
    }

}