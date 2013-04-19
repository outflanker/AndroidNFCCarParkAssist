<html><body>
<?php

$layoutid=$_GET['layoutid'];
$layerid=$_GET['layerid'];
trim($layerid);
trim($layoutid);

$black="./black.jpg";
$red="./red.jpg";
$blue="./blue.jpg";

$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Slot?id=0&&layoutid='.$layoutid.'&&layerid='.$layerid);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$results=  json_decode($result);
foreach ($results as $key => $jsons) 
{
     foreach($jsons as $key => $value) 
     {
         
         foreach($value as $keys => $values) 
         {
             if($keys=="POSITION")
             {
                 $pos=$values;
             }
             if($keys=="SLOTTYPE")
             {
                 $type=$values; 
             
             }            
             
         }
         $c=$pos%10;
         $r=($pos-$c)/10;
        $style="position:absolute;TOP:".$r."00px;LEFT:".$c."00px";
        if($type=="0")
        {
            echo "<IMG STYLE=\"$style\" SRC=\"$black\" WIDTH=\"40\" HEIGHT=\"40\" BORDER=\"2\" ALT=\"\"  \/>";
        
        }
        else if($type=="1")
        {
            echo "<IMG STYLE=\"$style\" SRC=\"$red\" WIDTH=\"40\" HEIGHT=\"40\" BORDER=\"2\" ALT=\"\"  \/>";
        
        }
        else if($type=="2")
        {
            echo "<IMG STYLE=\"$style\" SRC=\"$blue\" WIDTH=\"40\" HEIGHT=\"40\" BORDER=\"2\" ALT=\"\"  \/>";
        }
     }
}

?>
</body></html>
