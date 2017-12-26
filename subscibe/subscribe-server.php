<?php
ini_set('default_socket_timeout',-1);
$redis  = new Redis();

$redis->connect('127.0.0.1',6379);

$strChannel = 'adolph_channel';

$redis->publish($strChannel,'订阅频道,来自server');
echo '消息推送成功';
// 关闭redis
$redis->close();