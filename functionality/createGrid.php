<html>
    <script>
        function change(slotId,rate)
        {
            if(document.getElementById(slotId).src=="http://localhost:8888/parking/webclient/functionality/blue.jpg")    
            {
                document.getElementById(slotId).src="http://localhost:8888/parking/webclient/functionality/black.jpg";
 
 
 
                var xhr = new XMLHttpRequest();

                var params = "slotid="+slotId+"&rate="+rate+"&slottype="+"0";
                xhr.open("POST", "http://localhost:8888/parking/webclient/functionality/sendSlotRequest.php", true);
                xhr.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
                xhr.setRequestHeader( "Content-length", params.length );
                xhr.setRequestHeader( "Connection", "close" );

                xhr.onreadystatechange=function()
                {
                    if (xhr.readyState==4 && xhr.status==200)
                    {
                        document.getElementById("myDiv").innerHTML=xhr.responseText;
                    }
                }

                xhr.send(params);
       
                         
                //                $(document).ready(function () {
                //
                //                    $.ajax({ 
                //                        type: 'POST', 
                //                        url: 'http://localhost:8888/parking/webclient/functionality/sendSlotRequest.php',
                //                        data: { slotid:'222',rate:'22',slottype:'33'  },
                //                        dataType:'string',
                //                        success: function (data) { 
                //                            alert('success');
                //                        }
                //                    }); 
                ////                    error: function () { 
                ////                        console.log(XMLHttpRequest.errorThrown); 
                ////                    }
                //
                //                });
                //           
                            
                                    
            }
                  
                  
                  
            else if(document.getElementById(slotId).src=="http://localhost:8888/parking/webclient/functionality/black.jpg")    
            {
                document.getElementById(slotId).src="http://localhost:8888/parking/webclient/functionality/blue.jpg";
                           
                
                
                var xhr = new XMLHttpRequest();

                var params = "slotid="+slotId+"&rate="+rate+"&slottype="+"1";
                xhr.open("POST", "http://localhost:8888/parking/webclient/functionality/sendSlotRequest.php", false);
                xhr.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
                xhr.setRequestHeader( "Content-length", params.length );
                xhr.setRequestHeader( "Connection", "close" );

                xhr.onreadystatechange=function()
                {
                    if (xhr.readyState==4 && xhr.status==200)
                    {
                        document.getElementById("myDiv").innerHTML=xhr.responseText;
                    }
                }

                xhr.send(params);

                /*                $(document).ready(function () {

                    $.ajax({ 
                        type: 'POST', 
                        url: 'http://localhost:8888/parking/webclient/functionality/sendSlotRequest.php',
                        data: { slotid:'2dfdffd',rate:'2fdfdf2',slottype:'3fdf3'  },
                        dataType:'string',
                        success: function (data) { 
                            alert('success');
                        }
                    }); 
//                    error: function () { 
//                        console.log(XMLHttpRequest.errorThrown); 
//                    }

                });
                 */                
            }
                     
                     
                    
        }
    </script>
    <body onload="alert('tekkai');" >
        <?php
        $layoutID = $_POST['layoutid'];
        $layerID = $_POST['layerid'];
        $layoutSize = $_POST['layoutsize'];
        $parkingRate = $_POST['parkingrate'];
        trim($layerID);
        trim($layoutID);
        trim($layoutSize);
        trim($parkingRate);

        print_r($_POST);

        $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYOUTID\":\"$layoutID\",\"LAYERID\":\"$layerID\",
                \"LAYOUTSIZE\":\"$layoutSize\"}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        print $result;
        curl_close($ch);


        print "IT starts";




        $black = "./black.jpg";
        $red = "./red.jpg";
        $blue = "./blue.jpg";

        $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Slot?id=0&&layoutid=' . $layoutID . '&&layerid=' . $layerID);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        print "$result";
        curl_close($ch);
        $results = json_decode($result);
        foreach ($results as $key => $jsons) {

            foreach ($jsons as $key => $value) {

                foreach ($value as $keys => $values) {
                    if ($keys == "POSITION") {
                        $pos = $values;
                    }
                    if ($keys == "SLOTID") {
                        $slotID = $values;
                    }
                    if ($keys == "SLOTTYPE") {
                        $type = $values;
                    }
                }
                $c = $pos % 10;
                $r = ($pos - $c) / 10;
                $style = "position:absolute;TOP:" . $r . "00px;LEFT:" . $c . "00px";
                echo "Hello!!!";

                echo "<IMG id=\"$slotID\" STYLE=\"$style\" SRC=\"$black\" WIDTH=\"40\" HEIGHT=\"40\" BORDER=\"2\" ALT=\"\" ONCLICK=\"change('$slotID','$parkingRate')\"  />";
            }
        }
        ?>
        <div id="myDiv"><h2>Let AJAX change this text</h2></div>
    </body></html>
