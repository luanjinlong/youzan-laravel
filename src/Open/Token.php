<?php

namespace Long\Youzan\Open;

use Exception;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

class Token
{

    private static $requestUrl = 'https://open.youzan.com/oauth/token';


    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;


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
    public function getToken($type='self', $keys = array())
    {
        $key = 'youzan-access-token';
        $cached = $this->getCache()->get($key);
        if ($cached) {
            return $cached;
        }

        $config = config('youzan');
        $params = array();
        $params['client_id'] = $config['clientId'];
        $params['client_secret'] = $config['clientSecret'];

        if ($type === 'oauth') {
            $params['grant_type'] = 'authorization_code';
            $params['code'] = $config['code_id'];
            $params['redirect_uri'] = $config['redirect'];
        } elseif ($type === 'refresh_token') {
            $params['grant_type'] = 'refresh_token';
            $params['refresh_token'] = $keys['refresh_token'];
        } elseif ($type === 'self') {
            $params['grant_type'] = 'silent';
            $params['kdt_id'] = $config['kdt_id'];
        } elseif ($type === 'platform_init') {
            $params['grant_type'] = 'authorize_platform';
        } elseif ($type === 'platform') {
            $params['grant_type'] = 'authorize_platform';
            $params['kdt_id'] = $config['kdt_id'];
        }

        $result =  $this->parseResponse(
            Http::post(self::$requestUrl, $params)
        );

        $this->getCache()->set($key, $result['token'], $result['expires_in'] - 1000);

        return $result['token'];
    }

    private function parseResponse($responseData)
    {
        $data = json_decode($responseData, true);
        if (null === $data) throw new Exception('response invalid, data: ' . $responseData);
        return $data;
    }


    /**
     * @param \Psr\SimpleCache\CacheInterface $cache
     *
     * @return $this
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return \Psr\SimpleCache\CacheInterface
     */
    public function getCache()
    {
        return $this->cache ?: $this->cache = new FilesystemCache();
    }


}