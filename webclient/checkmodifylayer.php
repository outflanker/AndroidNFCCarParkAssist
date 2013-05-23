<?php

$layerid = $_POST['layerid'];

$layoutid =  $_COOKIE['MODIFYLAYOUTID'];




$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Booked/');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYERID\":\"" . $layerid . "\",\"LAYOUTID\":\"".$layoutid ."\"}");
$result = curl_exec($ch);

$json = json_decode($result,true);
$num = $json['NUMOCCUPIED'];
print $num;

curl_close($ch);



?>