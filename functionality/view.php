<html><body>
<?php

$ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout/');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
?>
<table border="1">
    <tr><th>LAYOUTID</th><th>LAYOUTNAME</th><th>NUMBEROFLAYERS</th><th>AREA</th><th>CITY</th><th>GPS</th></tr>
<?php

$results=  json_decode($result);
foreach ($results as $key => $jsons) 
{
     foreach($jsons as $key => $value) 
     {
         ?>
         <tr>
         <?php
         foreach($value as $keys => $values) 
         {
             if($keys=="LAYOUTID")
             {
                ?>
                <td>
                <?php
                   print '<a href="./viewlayout.php?layoutid=' . $values . '">'.$values.'</a>';   
                ?>
                </td>
                <?php
             }
             else
             {
                ?>
                <td>
                <?php
                   print $values;   
                ?>
                </td>
                <?php
             }
             
         }
         ?>
         </tr>
         <?php
     }
}

?>
</table>
</body>
</html>