<?php

$loop = React\EventLoop\Factory::create();
$redisFactory = new \Clue\React\Redis\Factory($loop);
$redis = $redisFactory->createLazyClient('redis://redis:6379'); // clue/reactphp-redis

