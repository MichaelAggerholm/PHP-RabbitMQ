<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$provider_channel = $connection->channel();

$provider_channel->queue_declare('first_wave', false, false, false, false);

$send = true;
while($send){
    $msg = new AMQPMessage((rand(10,100)));
    $provider_channel->basic_publish($msg, '', 'first_wave');
    
    sleep(1);
    echo " [x] Sent $msg->body\n";
}

$provider_channel->close();
$connection->close();
