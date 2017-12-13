<?php

require("phpMQTT.php");
$server = "m11.cloudmqtt.com";     // change if necessary
$port = 14434;                     // change if necessary
$username = "test";                   // set your username
$password = 12345;                   // set your password
$client_id = "Microsek";
$mqtt = new bluerhinos\phpMQTT($server, $port, "ClientID".rand());

if(!$mqtt->connect(true,NULL,$username,$password)){
  exit(1);
}

//currently subscribed topics
$topics['/microsek/esp'] = array("qos"=>0, "function"=>"procmsg");
$mqtt->subscribe($topics,0);

while($mqtt->proc()){
}

$mqtt->close();
function procmsg($topic,$msg){
  echo "Msg Recieved: $msg";
}

?>


