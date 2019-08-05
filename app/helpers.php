<?php
if (! function_exists('checkCash')) {
    function checkCash($tag, $key)
    {
        return Cache::tags($tag)->has($key);
    };
};

if (! function_exists('getCash')) {
    function getCash($tag, $key)
    {
        return Cache::tags($tag)->get($key);
    }
};

if (! function_exists('putCache')) {
    function putCache($tag, $key, $value, $expireSecond = 10)
    {
        return Cache::tags($tag)->put($key, $value, $expireSecond);
    }
};

if (! function_exists('flushCache')) {
    function flushCache($tags = null)
    {
        if($tags === null) {
            return Cache::flush();
        }

        if(is_array($tags)) {
            foreach ($tags as $tag) {
                Cache::tags($tag)->flush();
            }
            return true;
        }

        return Cache::tags($tags)->flush();
    }
};







