<?php

namespace Deepwell\Helper;

use Hyperf\Di\Annotation\Inject;
use Hyperf\Redis\Redis;

/**
 * 适用单机
 * 在集群时使用Redisson的FairLock和RLock
 */
class RedisLock
{
    #[Inject]
    protected Redis $redis;

    public function execute($lockKey, $callback, $timeout = 5): void
    {
        // 尝试获取锁
        if ($this->acquireLock($lockKey, $timeout)) {
            try {
                // 执行业务逻辑
                call_user_func($callback);
            } finally {
                // 释放锁
                $this->releaseLock($lockKey);
            }
        }
    }

    public function acquireLock($lockKey, $timeout = 10): bool
    {
        $requestId = uniqid();
        return $this->redis->set($lockKey, $requestId, ['NX', 'EX' => $timeout]);
    }

    public function releaseLock($lockKey): false|int
    {
        return $this->redis->del($lockKey);
    }
}