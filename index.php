<?php
require("phpMQTT.php");

$server = "m11.cloudmqtt.com";     // change if necessary
$port = 14434;                     // change if necessary
$username = "test";                   // set your username
$password = "12345";                   // set your password
$client_id = "phpMQTT-subscriber"; // make sure this is unique for connecting to sever - you could use uniqid()

$message = "Hello CloudAMQP MQTT!";
//MQTT client id to use for the device. "" will generate a client id automatically
$mqtt = new bluerhinos\phpMQTT($host, $port, "".rand());

if ($mqtt->connect(true,NULL,$username,$password)) {
  $mqtt->publish("topic",$message, 0);
  $mqtt->close();
}else{
  echo "Fail or time out
";
}

?>
