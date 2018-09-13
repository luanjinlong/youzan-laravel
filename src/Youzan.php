<?php


namespace Long\Youzan;

use Illuminate\Support\Facades\Facade;
use Long\Youzan\Open\Client;

/**
 * Class Youzan
 * @package Long\Youzan
 */
class Youzan extends Facade
{
    public static function getFacadeAccessor()
    {
        return Client::class;
    }
}