<?php
$access_token = '1Lei/3H6LFgRRIuoZ3kOTbR+DgezqvoC05THn5/2OBE9GPxXoQrwOdQ93KoVCSQjF8YPCnql4gAV9rwktNqV9Meve9KJrkTz28UXTe5z3yBKQn4O3mKx9wp0m7iXK4jU2J47mdifAjd6JjyWzfF7BQdB04t89/1O/w1cDnyilFU=';

require("phpMQTT.php");

$server = "m11.cloudmqtt.com";     // change if necessary
$port = 14434;                     // change if necessary
$username = "test";                   // set your username
$password = 12345;                   // set your password
$client_id = "Microsek"; // make sure this is unique for connecting to sever - you could use uniqid()
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
    // Loop through each event
    foreach ($events['events'] as $event) {
        // Reply only when message sent is in 'text' format
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // Get text sent
            $text_in = $event['message']['text'];
            // Get replyToken
            $replyToken = $event['replyToken'];
            // Build message to reply back
            //***
            $textin_cmd = explode(':', $text_in); //เอาข้อความมาแยก : ได้เป็น Array
        
            //***
            if($textin_cmd[0]=='สวัสดี')
            {
                $messages = 
                [
                 'type'=> 'sticker',
                 'packageId'=> "2",
                 'stickerId'=> "1"              
                    ];  
            }
            elseif($textin_cmd[0]=='update')
            {
                 $textin_cmd[1];

                $mqtt = new bluerhinos\phpMQTT($server, $port, "".rand());

                if ($mqtt->connect(true, NULL, $username, $password)) {
                    $mqtt->publish("/microsek/esp", $textin_cmd[1], 0);
                    $mqtt->close();
                     $messages = [
                        'type' => 'text',
                        'text' => "เรียบร้อยแล้วครับเจ้านาย"
                    ];
                } else {
                    $messages = [
                        'type' => 'text',
                        'text' => "ติดต่อ mqtt ไม่ได้"
                    ];
                }
               
            }
            
            elseif($textin_cmd[0]=='สถานะ')
            {
                $mqtt = new bluerhinos\phpMQTT($server, $port, "".rand());

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
                    $messages = [
                    'type' => 'text',
                    'text' => $msg
                    ];

            }
            else
            {
                
                $messages = 
                [
                 //'type'=> 'sticker',
                 //'packageId'=> "2",
                 //'stickerId'=> "149"  
                //******************
                    //{
                    //'type'=> "template",
                    //'altText'=> "this is a confirm template",
                    //'template'=> {
                        'type'=> 'confirm',
                        'text'=> "Are you sure?",
                        //'actions'=> [
                        //{
                            //  'type'=> "message",
                            //  'label'=> "Yes",
                            //  'text'=> "yes"
                        //},
                        //{
                            //  'type'=> "message",
                            //  'label'=> "No",
                            //  'text'=> "no"
                        //}
                        //]
                    //}
                    //}         
                //********************
                    ];  

            }
            
            
            
            $url = 'https://api.line.me/v2/bot/message/reply';
            $data = [
                'replyToken' => $replyToken,
                'messages' => [$messages],          
            ];
            $post = json_encode($data);
            $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            echo $result . "\r\n";
        }
    }
}
$fff=[
    'type'=> 'confirm',
    'text'=> "Are you sure?"    
];
echo $fff[0];
?>
