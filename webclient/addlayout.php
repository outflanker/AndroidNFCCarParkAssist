<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

                    $layoutName = $_POST['layoutname'];
                    $city = $_POST['city'];
                    $area = $_POST['area'];
                    $latitude = $_POST['lati'];
                    $longitude = $_POST['longi'];
                    $rate = $_POST['rate'];
                    $numOfLayers = $_POST['numlayers'];

                    trim($layoutName);
                    trim($city);
                    trim($area);
                    trim($latitude);
                    trim($longitude);
                    trim($rate);
                    trim($numOfLayers);

//                    print $layoutName . "    " .$city ."   " .$area . "   " . $latitude . "   " .$longitude . "   " . $rate . "   " . $numOfLayers;
// 

//        print "it starts ".$numOfLayers;


                    $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout/');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYOUTNAME\":\"" . $layoutName . "\",\"CITY\":\"" . $city . "\",
                                \"AREA\":\"" . $area . "\",\"LATITUDE\":\"" . $latitude . "\",\"LONGITUDE\":\"" . $longitude . "\",\"PARKINGRATE\":\"" . $rate . "\",\"NUMOFLAYERS\":\"" . $numOfLayers . "\"}");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
//        print $result;

                    curl_close($ch);

                    $layout = json_decode($result, true);

                    $layoutID = $layout['LAYOUTID'];
                    
//                    print $layoutID;
                    
                    setcookie("CREATELAYOUTID", $layoutID);
                    header("Location: create1.php");
                    
?>
