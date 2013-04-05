<html><body>
    
<?php

foreach ($_POST as $entry)
{
     print $entry . "<br>";
}
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
        
        
      

        print "it starts ".$numOfLayers;
        

        $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch,CURLOPT_POSTFIELDS,"{\"LAYOUTNAME\":\"".$layoutName."\",\"CITY\":\"".$city."\",
                                \"AREA\":\"".$area."\",\"GPS\":\"".$gps."\",\"NUMOFLAYERS\":\"".$numOfLayers."\"}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        print $result;
      
        curl_close($ch);
        
        $layoutID = json_decode($result,true);
        
        $aa=$layoutID['LAYOUTID'];
        print "it starts ";
        print $aa;
        print "number of lay : $numOfLayers";
        for($i=0;$i<$numOfLayers;$i++)
        {
            print '<a href="./createLayer2.php?layoutid='.$aa.'&&layerid=' . $i . '">'.$i.'</a>';
        }
       
?>
</body>
</html>