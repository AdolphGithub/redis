<?php
// redis悲观锁
// 解释：悲观锁(Pessimistic Lock), 顾名思义，就是很悲观。
// 每次去拿数据的时候都认为别人会修改，所以每次在拿数据的时候都会上锁。
// 场景：如果项目中使用了缓存且对缓存设置了超时时间。
// 当并发量比较大的时候，如果没有锁机制，那么缓存过期的瞬间，
// 大量并发请求会穿透缓存直接查询数据库，造成雪崩效应。

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
    sleep(5);
    echo '操作成功';
    $redis->unlock($key);
}
else
{
    echo '获取锁失败';
}