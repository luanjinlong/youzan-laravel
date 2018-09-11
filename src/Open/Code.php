<?php

namespace Long\Youzan\Open;

use Exception;

/**
 * 没写完
 * 跳转到有赞授权  暂时没用到  本来是想 oauth 方式获取  accessToken 使用的
 * Class Code
 * @package Youzan\Open
 */
class Code
{
    private static $requestUrl = 'https://open.youzan.com/oauth/authorize';

    public function __construct()
    {

    }

    /**
     * 获取access_token
     *
     * @param $type
     * @param array $keys
     *
     * @return mixed
     */
    public function getCode($type='oauth', $keys = array())
    {
        $params = [
            'client_id' => config('youzan.clientId'),
            'response_type' => 'code',
            'state' => 'teststate',
        ];
        return $this->parseResponse(
            Http::Get(self::$requestUrl, $params)
        );
    }

    private function parseResponse($responseData)
    {
//        $data = json_decode($responseData, true);
        if (null === $responseData) throw new Exception('response invalid, data: ' . $responseData);
        return $responseData;
    }
}