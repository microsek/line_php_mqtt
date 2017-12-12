<?php
require("phpMQTT.php");

$server   = "***.cloudmqtt.com"; 
$port     = ;
$username = "";
$password = "";

$message = "Hello CloudAMQP MQTT!";
//MQTT client id to use for the device. "" will generate a client id automatically
$mqtt = new bluerhinos\phpMQTT($host, $port, "ClientID".rand());

if ($mqtt->connect(true,NULL,$username,$password)) {
  $mqtt->publish("topic",$message, 0);
  $mqtt->close();
}else{
  echo "Fail or time out
";
}

?>
