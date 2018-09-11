<?php

namespace Long\Youzan\RequestMethod;

use Long\Youzan\Open\Client;

/**
 * 重新执行 composer 文件需要加载到此命名空间才可以
 * 有赞的相关请求方法参数
 * Class Uri
 * @package Youzan\Open
 */
class Users
{
    const API_VERSION = '3.0.0';
    // 客户管理
    // 用户API
    // 根据关注时间段批量查询微信粉丝用户信息
    const USERS_WEIXIN_FOLLOWER_SEARCH = 'youzan.users.weixin.followers.info.search';
    // 获取单个粉丝标签集合
    const USERS_WEIXIN_FOLLOWER_TAG = 'youzan.users.weixin.followers.info.search';

    // 使用手机号获取用户openId
    const USERS_WEIXIN_OPENID_GET = 'youzan.user.weixin.openid.get';

    //根据微信粉丝用户的 weixin_openid 或 fans_id 获取用户信息
    const USERS_WEIXIN_FOLLOWER_GET = 'youzan.users.weixin.follower.get';

    //根据微信粉丝用户的 weixin_openid 或 fans_id 绑定对应的标签
    const USERS_WEIXIN_FOLLOWER_TAG_ADD = 'youzan.users.weixin.follower.tags.add';

    //根据微信粉丝用户的 weixin_openid 或 fans_id 删除对应的标签 一次删除的标签数量不能大于20
    const USERS_WEIXIN_FOLLOWER_TAG_DELETE = 'youzan.users.weixin.follower.tags.delete';

    //获取用户简要信息
    const USERS_BASIC_GET = 'youzan.user.basic.get';

    //根据多个微信粉丝用户的 openid 或 user_id 获取用户信息   返回的是true/false   这个肯呢过是用来验证用户是否存在的
    const USERS_WEIXIN_FOLLOWER_GETS = 'youzan.users.weixin.follower.gets';

    //不受关注时间限制，按照粉丝编码正序查询 该接口即将废弃，请使用
    const USERS_WEIXIN_FOLLOWERS_PULL = 'youzan.users.weixin.followers.pull';

    /**
     * @return Client
     */
    protected function getClient()
    {
        static $client;
        if ($client) {
            return $client;
        }
        return $client = app(Client::class);
    }


    /**
     * 根据关注时间段批量查询微信粉丝用户信息
     * @param $start_follow
     * @param $end_follow
     * @param int $page_size
     * @return array
     */
    public function getUsersWeixinFollowerSearch($start_follow,$end_follow,$page_size=10)
    {
        $my_params = [
            'start_follow' => $start_follow,
            'page_size' => $page_size,
            'end_follow' => $end_follow,
        ];

        return $this->getClient()->post(self::USERS_WEIXIN_FOLLOWER_SEARCH, self::API_VERSION,$my_params);
    }


}