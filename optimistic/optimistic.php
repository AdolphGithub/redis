<?php
// 乐观锁
// 解释：乐观锁(Optimistic Lock), 顾名思义，就是很乐观。
// 每次去拿数据的时候都认为别人不会修改，所以不会上锁。
// watch命令会监视给定的key，当exec时候如果监视的key从调用watch后发生过变化，则整个事务会失败。
// 也可以调用watch多次监视多个key。这样就可以对指定的key加乐观锁了。
// 注意watch的key是对整个连接有效的，事务也一样。
// 如果连接断开，监视和事务都会被自动清除。
// 当然了exec，discard，unwatch命令都会清除连接中的所有监视。

$redis = new Redis();
$redis->connect('127.0.0.1',6379);

$strKey = 'pessimistic';

$redis->set($strKey,10);

$age = $redis->get($strKey);

echo '------ Current Age:' . $age . "\n";

$redis->watch($strKey);
// 开启事务
$redis->multi();

$redis->set($strKey,30);
$redis->set($strKey,20);
// 休息30秒让其他去操作

sleep(30);
$redis->exec();

$age = $redis->get($strKey);
echo "----- Current Age:{$age}\n";