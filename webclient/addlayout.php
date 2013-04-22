<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

                    $layoutName = $_POST['layoutname'];
                    $city = $_POST['city'];
                    $area = $_POST['area'];
                    $gps = $_POST['gps'];
                    $numOfLayers = $_POST['numlayers'];

                    trim($layoutName);
                    trim($city);
                    trim($area);
                    trim($gps);
                    trim($numOfLayers);




//        print "it starts ".$numOfLayers;


                    $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout/');
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYOUTNAME\":\"" . $layoutName . "\",\"CITY\":\"" . $city . "\",
                                \"AREA\":\"" . $area . "\",\"GPS\":\"" . $gps . "\",\"NUMOFLAYERS\":\"" . $numOfLayers . "\"}");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
//        print $result;

                    curl_close($ch);

                    $layout = json_decode($result, true);

                    $layoutID = $layout['LAYOUTID'];
                    
                    setcookie("CREATELAYOUTID", $layoutID);
                    header("Location: create1.php");
                    
?>
