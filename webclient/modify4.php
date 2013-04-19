<!DOCTYPE html>
<?php
if (!isset($_COOKIE['LOGINUSERNAME']))
    header("Location: index.php");
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Bootbusiness | Short description about company">
        <meta name="author" content="Your name">
        <title>VIEW GRID</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap responsive -->
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
        <!-- Font awesome - iconic font with IE7 support --> 
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/font-awesome-ie7.css" rel="stylesheet">
        <!-- Bootbusiness theme -->
        <link href="css/boot-business.css" rel="stylesheet">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" ></script>
        <script src="js/jquery.cookie.js" ></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js" ></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/signout.js"></script>        
        <script>
        function change(slotId,rate)
        {
            if(document.getElementById(slotId).src=="http://localhost:8888/parking/webclient/img/blue.jpg")    
            {
                document.getElementById(slotId).src="http://localhost:8888/parking/webclient/img/black.jpg";
 
 
 
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

                            
                                    
            }
                  
                  
                  
            else if(document.getElementById(slotId).src=="http://localhost:8888/parking/webclient/img/black.jpg")    
            {
                document.getElementById(slotId).src="http://localhost:8888/parking/webclient/img/blue.jpg";
                           
                
                
                var xhr = new XMLHttpRequest();

                var params = "slotid="+slotId+"&rate="+rate+"&slottype="+"1";
                xhr.open("POST", "http://localhost:8888/parking/webclient/sendSlotRequest.php", false);
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
              
            }
                     
                     
                    
        }
        
        
        
    </script>
    </head>
    <body>
        <!-- Start: HEADER -->
        <header>
            <!-- Start: Navigation wrapper -->
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <a href="index.php" class="brand brand-bootbus">NFC CAR PARK ASSIST ADMIN PAGE</a>
                        <!-- Below button used for responsive navigation -->
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- Start: Primary navigation -->
                        <div class="nav-collapse collapse">        
                            <ul class="nav pull-right">

                                <li><a href="view.php">View </a></li>
                                <li><a href="create.php">Create Layout</a></li>
                                <li><a href="modify.php">Alter Layout</a></li>


                                <?php
                                if (isset($_COOKIE['LOGINUSERNAME'])) {
                                    print "<li class = 'dropdown'><a href = '#' class = 'dropdown-toggle'";
                                    print "data-toggle = 'dropdown' >" . $_COOKIE['LOGINUSERNAME'] . "<b class = 'caret'></b></a>";
                                    ?>
                                    <ul class = "dropdown-menu">
                                        <li><a id="log_out">Sign Out</a></li>
                                        <li><a href = "changepwd.php">Change Password</a></li>
                                    </ul>
                                    </li>
                                    <?php
                                } else {
                                    print "<li><a href='signup.php'>Sign up</a></li>";
                                    print "<li><a href='signin.php'>Sign in</a></li>";
                                }
                                ?>       



                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End: Navigation wrapper -->   
        </header>
        <!-- End: HEADER -->
        <!-- Start: MAIN CONTENT -->
        <div class="content">
            <div class="container">
                <table border="1" align="center">
                    <?php
                    if (isset($_COOKIE['MODIFYLAYOUTID']) && isset($_COOKIE['MODIFYLAYERID']) && isset($_COOKIE['MODIFYLAYERSIZEORIGINAL'])) {
                        $layoutID = $_COOKIE['MODIFYLAYOUTID'];
                        $layerID = $_COOKIE['MODIFYLAYERID'];
                        
                        $layoutSize = $_POST['layoutsize'];
                        $layoutSizeOriginal = $_COOKIE['MODIFYLAYERSIZEORIGINAL'];
                        
                        $parkingRate = $_POST['parkingrate'];
                        trim($layerID);
                        trim($layoutID);
                        trim($layoutSize);
                        trim($parkingRate);

//                    print_r($_POST);
                        
                        $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer/');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYOUTID\":\"$layoutID\",\"LAYERID\":\"$layerID\",
                \"LAYOUTSIZE\":\"$layoutSize\"}");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
//                    print $result;
                        curl_close($ch);
                        
                         $black = "./img/black.jpg";
                        $red = "./img/red.jpg";
                        $blue = "./img/blue.jpg";
                        
                        
                        

                        if($layoutSize == $layoutSizeOriginal)
                        {
                        
                            $max_c = $layoutSize % 10;
                        $max_r = ( $layoutSize - $max_c) / 10;


                        $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Slot?id=0&&layoutid=' . $layoutID . '&&layerid=' . $layerID);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        
                        
                        
                        curl_close($ch);
                        $array = array();
                        
                        $results = json_decode($result);

                        
                        foreach ($results as $key => $jsons) {
                            foreach ($jsons as $key => $value) {

                                foreach ($value as $keys => $values) {
                                    if ($keys == "POSITION") {
                                        $pos = $values;
                                    }
                                    if ($keys == "SLOTTYPE") {
                                        $type = $values;
                                    }
                                     if ($keys == "SLOTID") {
                                        $slotID = $values;
                                    }
                                }
                                $c = $pos % 10;
                                $r = ($pos - $c) / 10;

                                $array[$r - 1][$c - 1] = $slotID;
                                $typer[$r - 1][$c - 1] = $type;
                                
                            }
                        }

                        for ($i = 0; $i < $max_r; $i++) {

                            echo "<tr>";

                            for ($j = 0; $j < $max_c; $j++) {

                                echo "<td>";

                                $type = $typer[$i][$j];

                                if ($type == "0") {
                                    echo "<IMG id=\"" . $array[$i][$j] . "\" SRC=\"$black\" WIDTH=\"80\" ONCLICK=\"change('" . $array[$i][$j] . "','" . $parkingRate . "')\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                } else if ($type == "1") {
                                    echo "<IMG  id=\"" . $array[$i][$j] . "\" SRC=\"$blue\" WIDTH=\"80\" ONCLICK=\"change('" . $array[$i][$j] . "','" . $parkingRate . "')\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
//                                } else if ($type == "2") {
//                                    echo "<IMG  id=\"" . $array[$i][$j] . "\" SRC=\"$red\" WIDTH=\"80\" ONCLICK=\"change('" . $array[$i][$j] . "','" . $parkingRate . "')\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
//                                }
                                }
                                echo "</td>";
                            }
                            echo "</tr>";
                        }
                    }
                    }
                    ?>
                </table>
            </div>
        </div>
        <!-- End: MAIN CONTENT -->
        <!-- Start: FOOTER -->
        <footer>
            <hr class="footer-divider">
            <div class="container">
                <p>
                    Developed using twitter bootstrap by Siddharth , Shamyak , Spoorthi and Nitin .
                </p>
            </div>
        </footer>
        <!-- End: FOOTER -->
        <!-- End: FOOTER -->
    </body>
</html>