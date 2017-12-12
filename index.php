<?php
require("phpMQTT.php");

$server = "m11.cloudmqtt.com";     // change if necessary
$port = 14434;                     // change if necessary
$username = "test";                   // set your username
$password = 12345;                   // set your password
$client_id = "Microsek"; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new bluerhinos\phpMQTT($server, $port, "".rand());

if ($mqtt->connect(true, NULL, $username, $password)) {
	$mqtt->publish("/ESP/LED", "PHP_HEROKU", 0);
	$mqtt->close();
	echo "Finished Publish\n";
} else {
    echo "Time out!\n";
}

?>
