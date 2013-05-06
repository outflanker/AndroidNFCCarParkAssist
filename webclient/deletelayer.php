<?php

$layerid = $_POST['layerid'];
$layoutid =  $_COOKIE['MODIFYLAYOUTID'];


$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer/');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYERID\":\"" . $layerid . "\",\"LAYOUTID\":\"".$layoutid ."\"}");
$result = curl_exec($ch);
curl_close($ch);

echo "Deletion done";
?>
