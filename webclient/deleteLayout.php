<?php

$layoutid = $_POST['layoutid'];

$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout/');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYOUTID\":\"" . $layoutid . "\"}");
$result = curl_exec($ch);
curl_close($ch);

echo "Deletion done";
?>
