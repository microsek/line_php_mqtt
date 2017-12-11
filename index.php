<?php

require("../phpMQTT.php");

$server = "m11.cloudmqtt.com";     // change if necessary
$port = 34434;                     // change if necessary
$username = "test";                   // set your username
$password = "12345";                   // set your password
$client_id = "phpMQTT-publisher"; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new phpMQTT($server, $port, $client_id);

if ($mqtt->connect(true, NULL, $username, $password)) {
	$mqtt->publish("/ESP/LED", "Hello World! at " . date("r"), 0);
	$mqtt->close();
} else {
    echo "Time out!\n";
}
