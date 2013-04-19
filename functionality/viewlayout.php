<?php

$layoutid=$_GET['layoutid'];
trim($layoutid);
$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout?id='.$layoutid);
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
             if($keys=="NUMOFLAYERS")
             {
                 $layernum=$values;
             }   
         }
     }
}

print "Select Level/Layer for the given layout.";
?>
<br/>
<?php

for($i=0;$i<$layernum;$i++)
{
    print '<a href="./viewlayer.php?layoutid='.$layoutid.'&&layerid=' . $i . '">'.$i.'</a>'; 
}
?>
