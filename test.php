<?php
require 'vendor/autoload.php';
const TOKEN ='1074214690:AAEH-tw_ToGRC8C1GmC1XFOGxc0keeD1tHo';

$url='https://api.telegram.org/bot'. TOKEN . '/sendMessage';
$url1='https://api.telegram.org/bot'. TOKEN . '/getUpdates';
$params = [
    'chat_id'=>486340051,
    'text' =>'пошел нахуй'
];
$url=$url .'?' . http_build_query($params);

//$response = json_decode(file_get_contents($url),JSON_OBJECT_AS_ARRAY);

$response = json_decode(file_get_contents($url1),JSON_OBJECT_AS_ARRAY);
$name=$response['result'][0]['message']['from']['first_name'];
$chat_id=$response['result'][0]['message']['chat']['id'];


echo $newname;
$db_connect = pg_connect("host=localhost port=5432 dbname=botelegram user=postgres password=admin");
//$updateUser = pg_query($db_connect,'UPDATE users SET subscribed = true WHERE name = ' . $name);
$id=array('id'=>16);
//$queryName = array('name'=>$name);
$select = pg_select($db_connect,'users',$id);

//$query = 'UPDATE users SET subscribed = false WHERE chat_id = ' . $chat_id;
var_dump($select[0]['city']==NULL);
//$update = pg_query($db_connect,$query);

//var_dump($select==false);
//var_dump($response);
?>