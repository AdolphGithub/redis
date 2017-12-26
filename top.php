<?php

$redis = new Redis();
$redis->connect('127.0.0.1',6379);

$top_str = 'top10';
$redis->zAdd($top_str,'50',json_encode(['name'=>'tom']));
$redis->zAdd($top_str,'60',json_encode(['name'=>'adolph']));

$redis->zAdd($top_str,'40',json_encode(['name'=>'blank']));

$dataOne = $redis->zRevRange($top_str,0,-1,true);
echo '从大到小：';
print_r($dataOne);

$dataTwo = $redis->zRange($top_str,0,-1,true);
echo '从小到大:';
print_r($dataTwo);
