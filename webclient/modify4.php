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
        <title>MODIFY</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap responsive -->
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
        <!-- Font awesome - iconic font with IE7 support --> 
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/font-awesome-ie7.css" rel="stylesheet">
        <!-- Bootbusiness theme -->
        <link href="css/boot-business.css" rel="stylesheet">
        <script src="js/jquery.js" ></script>
        <script src="js/jquery.cookie.js" ></script>
        <script src="js/jquery.validate.js" ></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/signout.js"></script>         
        <script>
            function change(slotId,rate)
            {
                if(document.getElementById(slotId).src=="http://localhost:8888/parking/webclient/img/vacant.png")    
                {
                    document.getElementById(slotId).src="http://localhost:8888/parking/webclient/img/noparking.png";
 
 
 
                    var xhr = new XMLHttpRequest();

                    var params = "slotid="+slotId+"&slottype="+"0";
                    xhr.open("POST", "http://localhost:8888/parking/webclient/sendSlotRequest.php", true);
                    xhr.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
                    xhr.setRequestHeader( "Content-length", params.length );
                    xhr.setRequestHeader( "Connection", "close" );

                    xhr.onreadystatechange=function()
                    {
                        if (xhr.readyState==4 && xhr.status==200)
                        {
                       
                        }
                    }

                    xhr.send(params);

                            
                                    
                }
                  
                  
                  
                else if(document.getElementById(slotId).src=="http://localhost:8888/parking/webclient/img/noparking.png")    
                {
                    document.getElementById(slotId).src="http://localhost:8888/parking/webclient/img/vacant.png";
                           
                
                
                    var xhr = new XMLHttpRequest();

                    var params = "slotid="+slotId+"&slottype="+"1";
                    xhr.open("POST", "http://localhost:8888/parking/webclient/sendSlotRequest.php", false);
                    xhr.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
                    xhr.setRequestHeader( "Content-length", params.length );
                    xhr.setRequestHeader( "Connection", "close" );

                    xhr.onreadystatechange=function()
                    {
                        if (xhr.readyState==4 && xhr.status==200)
                        {
                        
                        }
                    }

                    xhr.send(params);
              
                }
                     
                     
                    
            }
        
        
        
        </script>
        <script>

        jQuery(function ($) {
            $("IMG").tooltip()
        });

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

                                <li><a href="monitor.php">Monitor </a></li>
                                <li><a href="view.php" >View </a></li>
                                <li><a href="create.php">Create</a></li>
                                <li><a href="modify.php" class='active-link'>Alter </a></li>


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
                <div class="wrapper">
                    <table border="1" align="center" >

                        <?php
                        if (isset($_COOKIE['MODIFYLAYOUTID']) && isset($_COOKIE['MODIFYLAYERID']) && isset($_COOKIE['MODIFYLAYERSIZEORIGINAL'])) {
                            $layoutID = $_COOKIE['MODIFYLAYOUTID'];
                            $layerID = $_COOKIE['MODIFYLAYERID'];

                            $layoutSize = $_POST['layoutsize'];
                            $layoutSizeOriginal = $_COOKIE['MODIFYLAYERSIZEORIGINAL'];


                            trim($layerID);
                            trim($layoutID);
                            trim($layoutSize);


//                    print_r($_POST);

                            

                            $black = "./img/noparking.png";
                            $red = "./img/occupied.png";
                            $blue = "./img/vacant.png";

//                        echo "layout size is ".$layoutSize ."and the original size is ".$layoutSizeOriginal;


                            if ($layoutSize == $layoutSizeOriginal) {
                                //existing

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
                                            echo "<IMG rel='tooltip' data-placement='left' title=\"" . $array[$i][$j] . "\" id=\"" . $array[$i][$j] . "\" SRC=\"$black\" WIDTH=\"80\" ONCLICK=\"change('" . $array[$i][$j] . "')\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                        } else if ($type == "1") {
                                            echo "<IMG  rel='tooltip' data-placement='left' title=\"" . $array[$i][$j] . "\" id=\"" . $array[$i][$j] . "\" SRC=\"$blue\" WIDTH=\"80\" ONCLICK=\"change('" . $array[$i][$j] . "')\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                        } else if ($type == "2") {
                                            echo "<IMG  rel='tooltip' data-placement='left' title=\"" . $array[$i][$j] . "\" id=\"" . $array[$i][$j] . "\" SRC=\"$red\" WIDTH=\"80\" ONCLICK=\"change('" . $array[$i][$j] . "')\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                        }
                                    }
                                    echo "</td>";
                                }
                                echo "</tr>";
                            } else {
                                //new



                                $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer/');
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                                curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"LAYOUTID\":\"$layoutID\",\"LAYERID\":\"$layerID\",
                \"LAYOUTSIZE\":\"$layoutSize\"}");
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $result = curl_exec($ch);
                                curl_close($ch);







                                $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Slot?id=0&&layoutid=' . $layoutID . '&&layerid=' . $layerID);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $result = curl_exec($ch);

                                $array = array();
//                    print "$result";
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
                                        }
                                        $c = $pos % 10;
                                        $r = ($pos - $c) / 10;

                                        $array[$r - 1][$c - 1] = $slotID;
                                    }
                                }

                                $max_c = $layoutSize % 10;

                                $max_r = ( $layoutSize - $max_c ) / 10;

                                for ($i = 0; $i < $max_r; $i++) {

                                    echo "<tr>";

                                    for ($j = 0; $j < $max_c; $j++) {

                                        echo "<td>";

                                        echo "<IMG rel='tooltip' data-placement='left' title=\"" . $array[$i][$j] . "\" id=\"" . $array[$i][$j] . "\" SRC=\"" . $black . "\" WIDTH=\"100\" HEIGHT=\"100\" BORDER=\"2\" ALT=\"\" ONCLICK=\"change('" . $array[$i][$j] . "')\"  />";

                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                }
                            }
                        }
                        ?>
                    </table>
                    <center>
                        </br>
                    <form action='modify2.php'>
                        <button id="done" class="btn btn-success">DONE</button>
                    </form>
                        </center>
                </div>
            </div>
        </div>
        <!-- End: MAIN CONTENT -->
         <div class="clear"></div>
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
