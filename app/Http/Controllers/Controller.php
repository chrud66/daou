<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkCash($tag, $key)
    {
        return Cache::tags($tag)->has($key);
    }

    public function getCash($tag, $key)
    {
        return Cache::tags($tag)->get($key);
    }

    public function putCache($tag, $key, $value, $expireSecond = 10)
    {
        return Cache::tags($tag)->put($key, $value, $expireSecond);
    }

    public function flushCache($tags = null)
    {
        if($tags === null) {
            return Cache::flush();
        }

        return Cache::tags($tags)->flush();
    }
}
