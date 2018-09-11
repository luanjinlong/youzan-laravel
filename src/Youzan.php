<?php


namespace Long\Youzan;

use Illuminate\Support\Facades\Facade;
use Long\Youzan\Open\Client;

/**
 * Class Youzan
 *
 * @author overtrue <i@overtrue.me>
 */
class Youzan extends Facade
{
    public static function getFacadeAccessor()
    {
        return Client::class;
    }
}