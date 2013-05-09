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
        <title>MONITOR LAYOUT</title>
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
            function change(slotId)
            {
                if(document.getElementById(slotId).src=="http://localhost:8888/parking/webclient/img/vacant.png")    
                {
                    document.getElementById(slotId).src="http://localhost:8888/parking/webclient/img/occupied.png";
 
 
 
                    var xhr = new XMLHttpRequest();

                    var params = "slotid="+slotId+"&slottype="+"2";
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
                  
                  
                  
                else if(document.getElementById(slotId).src=="http://localhost:8888/parking/webclient/img/occupied.png")    
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
            $(document).ready(function (){
                function generate_handler( j ) {
                    return function(event) {
        
                        $('html, body').animate({
                            scrollTop: $('#span'+j).offset().top-160
                        }, 2000);
        
                    };
                }
                
                for(var i = 0; i <= 2; i++){
                    $('#lay'+ i).click( generate_handler( i ) );
                }
 
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

                                <li><a href="monitor.php" class='active-link' >Monitor </a></li>
                                <li><a href="view.php" >View </a></li>
                                <li><a href="create.php">Create</a></li>
                                <li><a href="modify.php">Alter </a></li>

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
                <div class="navbar-inner">
                    <div class="container">
                        <a href="index.php" class="brand brand-bootbus" style="font-size:large">Select Layer :</a>
                        <!-- Start: Primary navigation -->
                        <div class="nav-collapse collapse">        
                            <ul class="nav pull-right">

                                <?php
                                if (isset($_COOKIE['MONITORLAYOUTID'])) {
                                    $layoutid = $_COOKIE['MONITORLAYOUTID'];
//                        $layerid = $_GET['layerid'];
//                        trim($layerid);
                                    trim($layoutid);

                                    $black = "./img/noparking.png";
                                    $red = "./img/occupied.png";
                                    $blue = "./img/vacant.png";

                                    $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout?id=' . $layoutid);

                                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    $result = curl_exec($ch);



                                    curl_close($ch);

                                    $results = json_decode($result, true);
                                    $numlayers = $results['LAYOUTS'][0]['NUMOFLAYERS'];

//                                    print $numlayers;
//                                    print "<li>Select the layers</li>";
                                    for ($r = 0; $r < $numlayers; $r++) {
//                                        print '<li><a id='lay' . $r . '' href='#' onclick=scroll(\'".$r."'\') > Layer No : " . $r . "</a></li>";
//                                        print '<li><a onclick="scroll(\'' . $r . '\')" id="lay' . $r . '" href="#" >' . $r . '</a>';
                                        print '<li><a id="lay' . $r . '" >' . $r . '</a>';
                                    }
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

                <?php
                echo "</br></br></br></br></br>";
                for ($k = 0; $k < $numlayers; $k++) {




                    $layerid = $k;
                    $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer?id=0&&layoutid=' . $layoutid . '&&layerid=' . $layerid);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $results = json_decode($result, true);





                    $size = $results['LAYERS'][0]['LAYOUTSIZE'];

                    
                    
                    if ($size!=0) {

                        print "<span id='span" . $k . "' >";


                        $max_c = $size % 10;
                        $max_r = ( $size - $max_c) / 10;

                        print "<h2>  LEVEL   : " . $k . "    </h2>";

                        $ch1 = curl_init('http://localhost:8888/parking/FinalYearProject/public/Slot?id=0&&layoutid=' . $layoutid . '&&layerid=' . $layerid);
                        curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                        $result1 = curl_exec($ch1);
                        curl_close($ch1);
                        $array = array();

                        $results1 = json_decode($result1, true);

//                        print $results1['SLOTS'][0]['SLOTID'];


                        foreach ($results1 as $key => $jsons) {
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

                        
                        print "<table border='1' id='tab" . $k . "' align='center'>";

                        for ($i = 0; $i < $max_r; $i++) {

                            echo "<tr>";

                            for ($j = 0; $j < $max_c; $j++) {

                                echo "<td>";

                                $type = $typer[$i][$j];

                                if ($type == "0") {
                                    echo "<IMG id=\"" . $array[$i][$j] . "\" SRC=\"$black\" WIDTH=\"80\" ONCLICK=\"change('" . $array[$i][$j] . "')\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                } else if ($type == "1") {
                                    echo "<IMG  id=\"" . $array[$i][$j] . "\" SRC=\"$blue\" WIDTH=\"80\" ONCLICK=\"change('" . $array[$i][$j] . "')\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                } else if ($type == "2") {
                                    echo "<IMG  id=\"" . $array[$i][$j] . "\" SRC=\"$red\" WIDTH=\"80\" ONCLICK=\"change('" . $array[$i][$j] . "')\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                }
                                
                                echo "</td>";
                            }
                            echo "</tr>";
//                            echo "</br></br></br></br>";
                        }
                        print "</table></span>";
                    }
                    echo "</br></br></br></br></br></br></br></br></br></br>";
                }
                ?>

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
