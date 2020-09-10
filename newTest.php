<?php
require 'vendor/autoload.php';
require 'weather.php';
const TOKEN ='1074214690:AAEH-tw_ToGRC8C1GmC1XFOGxc0keeD1tHo';
const baseUrl = 'https://api.telegram.org/bot'. TOKEN . '/';

$update = json_decode(file_get_contents('php://input'),JSON_OBJECT_AS_ARRAY); 

$db_connect = pg_connect("host=localhost port=5432 dbname=botelegram user=postgres password=admin");
$chat_id= $update['message']['chat']['id'];
$text= $update['message']['text'];
$name = $update['message']['from']['username'];
$queryName = array('username'=>$name);
$select = pg_select($db_connect,'users',$queryName);
$city = $select['0']['city'];

function sendRequest($method,$params=[]){
    if(!empty($params)){
         $url= baseUrl . $method . '?' . http_build_query($params);
    }
    else
    {
        $url= baseUrl . $method;
    }
    return json_decode(file_get_contents($url), JSON_OBJECT_AS_ARRAY);
}
    if($text=='/subscribe'){
        if($select==false){
            $data = array(
            'username'=>$name,
            'subscribed'=>true,
            'chat_id'=>$chat_id
        );
            $newUser = pg_insert($db_connect,'users',$data);
            sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Вы успешно подписаны на рассылку!']);
            sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Чтобы установить свой город напишите /setcity Название города']);
        }else{
            if($select['0']['subscribed']=="t"){
                sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Вы уже подписаны!']);
       
            }else{
                $updateUser = pg_query($db_connect,'UPDATE users SET subscribed = true WHERE chat_id = ' . $chat_id);
                sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Вы успешно подписаны на рассылку повторно!']);
            }
        }
    }else if($text=='/unsubscribe'){
            if($select==false){
                sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Вы и так не подписаны!']);
            }else if($select['0']['subscribed']=="f"){
                sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Вы и так не подписаны!']);
            }else{
                $updateUser = pg_query($db_connect,'UPDATE users SET subscribed = false WHERE chat_id = ' . $chat_id); 
                sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Вы отписались от рассылки!']);
            }
    }else if(strripos($text,'/setcity ')===0){
        $city = str_replace('/setcity ','',$text);
        if($select==false){
            sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Вы еще не подписаны!']);
            }else{
                $data = array('city'=>$city);
                $condition = array('chat_id'=>$chat_id);
                $updateUser = pg_update($db_connect,'users',$data,$condition);
                sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Вы установили свой город как '. $city . '!']);
            }
    }else if($text=='/getweather'){
            if($city==NULL){
                sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'Вы не установили город!']);
            }else{
            $temperature = getWeather($city);
            sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>$city . ' ' . $temperature . '℃']);
            }
    }else{
            sendRequest('sendMessage',['chat_id'=> $chat_id,'text'=>'иди нахуй']);
    }
?>