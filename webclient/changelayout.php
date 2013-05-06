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
                    $latitude = $_POST['lati'];
                    $longitude = $_POST['longi'];
                    $rate = $_POST['rate'];
                    

                    trim($layoutName);
                    trim($city);
                    trim($area);
                    trim($latitude);
                    trim($longitude);
                    trim($rate);
                    





//        print "it starts ".$numOfLayers;


    $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout/');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYOUTID\":\"" . $layoutID . "\",\"LAYOUTNAME\":\"" . $layoutName . "\",\"CITY\":\"" . $city . "\",
                                \"AREA\":\"" . $area . "\",\"LATITUDE\":\"" . $latitude . "\",\"LONGITUDE\":\"" . $longitude . "\",\"PARKINGRATE\":\"" . $rate . "\"}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
      
    curl_close($ch);

    
    header("Location: ".$_COOKIE["MODIFYLAYOUTREDIRECT"]);
}
?>