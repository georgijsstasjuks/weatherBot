<?php


function getStatistic( String $city){
$update = json_decode(file_get_contents('https://api.thevirustracker.com/free-api?countryTotals=ALL'),JSON_OBJECT_AS_ARRAY);

$countries=[];
foreach($update['countryitems']['0'] as $item){
    $countries[$item['title']] =  $item['code'];
};


var_dump($countries);
}


getStatistic('Riga');

?>