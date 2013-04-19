<html>
    <script>
		function change(slotId,rate)
		{
                     var img = document.getElementById(slotId).src;
                     
                     //<?php
//                     $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Slot/');
//                     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//                     curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"PUT");
//                     
//                     ?>
                             
                     if(img=="blue.jpg")    
                     {
                         img="black.jpg";
                         
                     //<?php
//                     curl_setopt($ch,CURLOPT_POSTFIELDS,"{\"SLOTID\":\"slotId\",\"RATE\":\"rate\"\n\,
//                         \"SLOTTYPE\":\"0\"}");
//                     ?>
                     }
                  
                  
                  
                     if(img=="black.jpg")    
                     {
                         img="blue.jpg";
                     //<?php
//                     
//                     curl_setopt($ch,CURLOPT_POSTFIELDS,"{\"SLOTID\":\"slotId\",\"RATE\":\"rate\"\n\,
//                                    \"SLOTTYPE\":\"1\"}");
//                     ?>
                     }
                     
                     
                     //<?php
//                     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);           
//                     $result = curl_exec($ch);
//                     print $result;
//                     curl_close($ch); 
//                     ?>
		}
    </script>
<body>
<?php
$layoutID=$_POST['layoutid'];
$layerID=$_POST['layerid'];
$layoutSize = $_POST['layoutsize'];
$parkingRate =  $_POST['parkingrate'];
trim($layerID);
trim($layoutID);
trim($layoutSize);
trim($parkingRate);

print_r($_POST);

$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer/');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch,CURLOPT_CUSTOMREQUEST,"PUT");
curl_setopt($ch,CURLOPT_POSTFIELDS,"{\"LAYOUTID\":\"$layoutID\",\"LAYERID\":\"$layerID\",
                \"LAYOUTSIZE\":\"$layoutSize\"}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
print $result;
curl_close($ch);


print "IT starts";




$black="./black.jpg";
$red="./red.jpg";
$blue="./blue.jpg";

$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Slot?id=0&&layoutid='.$layoutID.'&&layerid='.$layerID);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);

print "$result";
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
             if($keys=="SLOTID")
             {
                 $slotID=$values;
             }
             if($keys=="SLOTTYPE")
             {
                 $type=$values; 
             
             }            
             
         }
         $c=$pos%10;
         $r=($pos-$c)/10;
         $style="position:absolute;TOP:".$r."00px;LEFT:".$c."00px";
         echo "Hello!!!";
         echo "<IMG id=\"$slotID\" STYLE=\"$style\" SRC=\"$black\" WIDTH=\"40\" HEIGHT=\"40\" BORDER=\"2\" ALT=\"\" ONCLICK=\"change('$slotID,$parkingRate')\"  />";
       
     }
}

?>
</body></html>
