<?php

$redis = new Redis();
$redis->connect('127.0.0.1',6379);

$counter = 'counts';

$redis->set($counter,0);

$redis->incr($counter);
$redis->incr($counter);
$redis->incr($counter);

$strNowCount = $redis->get($counter);
echo '-------- 当前数量为:' . $strNowCount . ' -------';
