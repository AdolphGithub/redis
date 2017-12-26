<?php
$redis = new Redis();

$redis->connect('127.0.0.1',6379);

$strQueueName = 'queue';
// 进队列.
$redis->rPush($strQueueName,json_encode(['uid'=>1,'name'=>'Job']));
$redis->rPush($strQueueName,json_encode(['uid'=>2,'name'=>'Tom']));
$redis->rPush($strQueueName,json_encode(['uid'=>3,'name'=>'John']));
echo "------ 进队列成功 ------";

$strCount = $redis->lRange($strQueueName,0,-1);

echo '当该队列数据为:' . count($strCount);

$queue = $redis->lPop($strQueueName);
echo '获取一个队列';

$strCount = $redis->lRange($strQueueName,0,-1);
echo '当前队列为:' . count($strCount);