<?php

declare(strict_types=1);

namespace App\Factory;

use Redis;

class RedisFactory
{
    private ?Redis $redis = null;

    public function getRedisClient(): Redis
    {
        if (null === $this->redis) {
            $this->redis = new Redis();
            $this->redis->connect('redis_sandbox');
        }

        return $this->redis;
    }
}
