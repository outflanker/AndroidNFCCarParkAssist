<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if (isset($_COOKIE['MODIFYLAYOUTID']) && isset($_COOKIE['MODIFYLAYOUTREDIRECT'])) {
    
   $layoutID = $_COOKIE['MODIFYLAYOUTID'];
    $layoutName = $_POST['layoutname'];
    $city = $_POST['city'];
    $area = $_POST['area'];
    $gps = $_POST['gps'];

    trim($layoutName);
    trim($city);
    trim($area);
    trim($gps);





//        print "it starts ".$numOfLayers;


    $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout/');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYOUTID\":\"" . $layoutID . "\",\"LAYOUTNAME\":\"" . $layoutName . "\",\"CITY\":\"" . $city . "\",
                                \"AREA\":\"" . $area . "\",\"GPS\":\"" . $gps . "\"}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
//        print $result;

    curl_close($ch);

    
    header("Location: ".$_COOKIE["MODIFYLAYOUTREDIRECT"]);
}
?>