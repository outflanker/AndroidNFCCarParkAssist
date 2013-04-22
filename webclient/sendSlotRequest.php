<?php

print_r($_POST);
print "Hello ";



foreach ($_POST as $key => $value)
    echo htmlspecialchars(' _POST[' . $key . ']=[' . $value . ']');


$slotid = $_POST["slotid"];
$slottype = $_POST["slottype"];

trim($slotid);
trim($slottype);

$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Slot/');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"SLOTID\":\"$slotid\",\"SLOTTYPE\":\"$slottype\"}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
print $result;
curl_close($ch);
?>