<?php

class RedisExample{

    protected $redis = '';

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1',6379);
    }

    /**
     * 获取锁
     * @param string $key   关键字
     * @param int $expire   超时时间
     * @return bool
     */
    public function lock($key = '',$expire = 5)
    {
        // 设置值,如果有值就返回失败.
        $is_lock = $this->redis->setnx($key,time() + $expire);
        // 有值判断时间.
        if(!$is_lock)
        {
            // 获取有效期.
            $lock_time = $this->redis->get($key);
            // 判断有效期,当前时间如果大于设置的日期  就过期了
            if(time() > $lock_time)
            {
                // 删除键 并且重新设值.
                $this->unlock($key);
                $is_lock = $this->redis->setnx($key,time() + $expire);
            }
        }
        return $is_lock ? true : false;
    }


    public function unlock($key = '')
    {
        return $this->redis->del($key);
    }
}

$redis = new RedisExample();

$key = 'lock_key';

$is_lock = $redis->lock($key,10);
if($is_lock)
{
    echo '成功获取锁' . "\n";
    echo '需要做的事情' . "\n";
    sleep(10);
    echo '操作成功';
    $redis->unlock($key);
}
else
{
    echo '获取锁失败';
}