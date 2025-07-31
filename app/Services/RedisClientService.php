<?php

namespace App\Services;

use Redis;

class RedisClientService
{
    private Redis $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('redis', 6379);
    }

    public function getClient(): Redis
    {
        return $this->redis;
    }
}
