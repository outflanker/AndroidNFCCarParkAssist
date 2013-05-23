<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


if (isset($_COOKIE['MODIFYLAYOUTID']) && isset($_COOKIE['MODIFYLAYERID'])) {

            $layoutid = $_COOKIE['MODIFYLAYOUTID'];
            $layerid = $_COOKIE['MODIFYLAYERID'];

            $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer?id=0&&layoutid=' . $layoutid . '&&layerid=' . $layerid);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $results = json_decode($result, true);

            $size = $results['LAYERS'][0]['LAYOUTSIZE'];
            
            trim($size);
            setcookie("MODIFYLAYERSIZEORIGINAL", $size);
            
            
            header("Location: modify3.php");
}
            
            ?>
