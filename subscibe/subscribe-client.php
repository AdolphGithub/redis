<?php
ini_set('default_socket_timeout',-1);
$redis = new Redis();
$redis->connect('127.0.0.1',6379);

$strChannel = 'adolph_channel';

echo '开始订阅' . $strChannel . '频道';

$redis->subscribe([$strChannel],function($redis,$channel,$msg){
    print_r([
        'redis'=>$redis,
        'channel'=>$channel,
        'msg'=>$msg
    ]);
});