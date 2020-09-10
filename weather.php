<?php
require_once ('vendor/autoload.php');
use \Dejurin\GoogleTranslateForFree;

 function getWeather($city){
        $db_connect = pg_connect("host=localhost port=5432 dbname=botelegram user=postgres password=admin");
        $source = 'ru';
        $target = 'en';
        $attempts = 5;
        $text = $city;
        $tr = new GoogleTranslateForFree();
        $q = $tr->translate($source, $target, $text, $attempts);
        $url="http://api.openweathermap.org/data/2.5/forecast?q=" . $q . ",usl&APPID=5099c5feb579c7a17b030de0d009282f&units=metric";
        $json=file_get_contents($url);
        $data=json_decode($json);
        return $data->list[0]->main->temp;
}



