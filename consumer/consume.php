<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$consumer_channel = $connection->channel();

$consumer_channel->queue_declare('first_wave', false, false, false, false);

$callback = function ($msg) {
    if($msg->body >= 90) {
        echo ' [x] Consumed ', $msg->body, "\n";
    }
  };
  
  $consumer_channel->basic_consume('first_wave', '', false, true, false, false, $callback);
  
  while ($consumer_channel->is_open()) {
      $consumer_channel->wait();
  }

  
