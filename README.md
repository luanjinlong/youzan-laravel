# youzan-laravel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

youzan-laravel


## Install


``` 
$ composer require luanjinlong/youzan
```


## 应用

- 组件已经默认为你获取 `access_token` 无需获取

### 1. 获取 accessToken

#### 根据关注时间段批量查询微信粉丝用户信息

````
<?php

namespace App\Http\Controllers;

use Long\Youzan\RequestMethod\Users;

class UsersController extends Controller
{
    /**
     * @param Users $users
     */
    public function index(Users $users)
    {
        $response = $users->getUsersWeixinFollowerSearch('2018-09-10','2018-09-11',10);
        dd($response);
    }
}

````

其实本质是调用的 `Long\Youzan\Open\Client` 这个类，调取这个类的方式有以下几种

````
1. app('youzan')
2. app(Client::class)
3. 或者直接在控制器里面依赖注入 Long\Youzan\Open\Client
<?php

namespace App\Http\Controllers;

use Long\Youzan\Open\Client;

class TestController extends Controller
{
    /**
     * @param Client $client
     */
    public function index(Client $client)
    {
        $token = $client->getAccessToken();
        dd($token);
    }
}

````

#### 2.其实上面那个 `` 也是直接通过封装每个函数获取的，其实你也可以自己写。比如，还是根据关注时间段批量查询微信粉丝用户信息

````
<?php

namespace App\Http\Controllers;
use Long\Youzan\Open\Client;

class TestController extends Controller
{
    // 根据关注时间段批量查询微信粉丝用户信息
    const USERS_WEIXIN_FOLLOWER_SEARCH = 'youzan.users.weixin.followers.info.search';
    const API_VERSION = '3.0.0';

    /**
     * @param Client $client
     * @return array
     */
    public function index(Client $client)
    {
        $my_params = [
            'start_follow' => '2018-09-11',
            'page_size' => 10,
            'end_follow' => '2018-09-12',
        ];
        return $client->post(self::USERS_WEIXIN_FOLLOWER_SEARCH, self::API_VERSION,$my_params);
    }
}
````
## License

The MIT License. Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/youzan/open-sdk.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/youzan/open-sdk.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/luanjinlong/youzan
[link-downloads]: https://packagist.org/packages/luanjinlong/youzan