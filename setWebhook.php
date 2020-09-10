<?php
//const TOKEN ='1074214690:AAEH-tw_ToGRC8C1GmC1XFOGxc0keeD1tHo';
const TOKEN ='1002035297:AAFEFP0ouA_gMSD7KffsFqkJfkBpNXPLCn8';
$method = 'setWebhook';
$url = 'https://api.telegram.org/bot'. TOKEN . '/' . $method;


$options = [
    'url' =>'https://199df0625443.ngrok.io/corona/newTest.php'
];
$response = file_get_contents($url. '?'. http_build_query($options) );
var_dump($response);
?>

