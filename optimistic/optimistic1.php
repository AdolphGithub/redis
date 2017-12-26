<?php

$redis = new Redis();
$redis->connect('127.0.0.1',6379);

$strKey = 'pessimistic';
// 自增4次
$redis->incr($strKek);
$redis->incr($strKek);
$redis->incr($strKek);
$redis->incr($strKek);