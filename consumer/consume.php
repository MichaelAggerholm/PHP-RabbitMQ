<?php
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use  PHPOnCouch\CouchClient;
use PHPOnCouch\Exceptions;

// RabbitMQ connection
$rabbitmq_conn = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$consumer_channel = $rabbitmq_conn->channel();

# CouchDB connection
$couchDB = new couchClient(
    "http://admin:YOURPASSWORD@localhost:5984/", # username / password / host / port
    "couchdb"
);
if (!$couchDB->databaseExists()) {
    $couchDB->createDatabase();
}

$callback = function ($msg) use ($couchDB) {
    if ($msg->body >= 90) {
        $date = date("d-m-Y H:i:s");

        // New couchDB document
        $new_doc = new stdClass();
        $new_doc->newproperty = array($date, "test", $msg->body);
        try {
            $response = $couchDB->storeDoc($new_doc);
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")<br>";
        }
        echo "Consumed [".$msg->body."] and saved to couch with id [".$response->id."]<br>\n";
    }
};

// Declaring queue and consuming from RabbitMQ
$consumer_channel->queue_declare('first_wave', false, false, false, false);
$consumer_channel->basic_consume('first_wave', '', false, true, false, false, $callback);

// While RabbitMQ consumer channel is open, wait for messages.
while ($consumer_channel->is_open()) {
    $consumer_channel->wait();
}