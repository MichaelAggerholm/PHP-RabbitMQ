<?php
# initializing composer
require __DIR__ . '/vendor/autoload.php';

# the CouchDB client object
use  PHPOnCouch\CouchClient;
use PHPOnCouch\Exceptions;

# making a db connection
$client = new couchClient(
    "http://admin:YOURPASSWORD@localhost:5984/", # username / password / host / port
    "couchdb" # database
);
if (!$client->databaseExists()) {
    $client->createDatabase();
}

/*try{
    $client->getDoc('the id');
    echo 'Document found';
}
catch(Exceptions\CouchNotFoundException $ex){
    if($ex->getCode() == 404)
        echo 'Document not found';
}*/



$store = true;
while ($store) {

    $randomNumber = rand(0, 100);
    $date = date("d-m-Y H:i:s");

    /*-----------------------------*/
    $new_doc = new stdClass();
    $new_doc->newproperty = array($date, "Provider_one", $randomNumber);
    try {
        $response = $client->storeDoc($new_doc);
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . " (" . $e->getCode() . ")<br>\n";
    }
    echo "Doc recorded. id = " . $response->id . " and revision = " . $response->rev . "<br>\n";
    // Doc recorded. id = 0162ff06747761f6d868c05b7aa8500f and revision = 1-249007504
    /*-----------------------------*/

    sleep(0.5);
}