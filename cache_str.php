<?php

$redis = new Redis();
$redis->connect('127.0.0.1');

$strCacheKey = 'adolph';

$arrData = [
    'name' => 'adolph',
    'age'  => '23',
    'sex'  => '男'
];

$redis->set($strCacheKey,json_encode($arrData));
$redis->expire($strCacheKey,60);

$json_data = $redis->get($strCacheKey);

$data = json_decode($json_data);
// 这里要删除,防止重复的Key

$redis->del($strCacheKey);
var_dump($data);

$arrWebSite = [
    'google'=>[
        'google.com',
        'google.com.hk'
    ]
];

$result = $redis->hSet($strCacheKey,'google',json_encode($arrWebSite['google']));

$json_data = $redis->hGet($strCacheKey,'google');
var_dump(json_decode($json_data));