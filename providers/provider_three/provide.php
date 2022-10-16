<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$send = true;
while($send){
    $msg = new AMQPMessage((rand(10,100)));
    $channel->basic_publish($msg, '', 'hello');
    sleep(1);
}

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();
