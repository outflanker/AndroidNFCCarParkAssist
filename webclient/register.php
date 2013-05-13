<?php

print_r($_POST);


foreach ($_POST as $key => $value)
    echo htmlspecialchars(' _POST[' . $key . ']=[' . $value . ']');


$slotid = $_POST["slotid"];
$user = $_POST["user"];

trim($slotid);
trim($user);

$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Park/');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"SLOTID\":\"$slotid\",\"USER\":\"$user\"}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
print $result;
curl_close($ch);
?>