<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_COOKIE['MODIFYLAYOUTID'])) {

    $layoutID = $_COOKIE['MODIFYLAYOUTID'];
    $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Addlayer/');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYOUTID\":\"$layoutID\"}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    $results = json_decode($result, true);

    $layernum = $results['LAYERID'];


    setcookie('CREATELAYOUTID', $layoutID);
    setcookie('CREATELAYERID', $layernum);
    setcookie('CREATEDONE',"modify2.php");
    header("Location: create2.php");
}
?>
