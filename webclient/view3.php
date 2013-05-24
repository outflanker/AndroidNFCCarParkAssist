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
        <script src="js/jquery.js" ></script>
        <script src="js/jquery.cookie.js" ></script>
        <script src="js/jquery.validate.js" ></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/signout.js"></script>       

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
                                <li><a href="view.php" class='active-link' >View </a></li>
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
            </div>
            <!-- End: Navigation wrapper -->   
        </header>
        <!-- End: HEADER -->
        <!-- Start: MAIN CONTENT -->
        <div class="content">
            <div class="container">
                <table border="1" align="center">
                    <?php
                    if (isset($_COOKIE['VIEWLAYOUTID'])) {
                        $layoutid = $_COOKIE['VIEWLAYOUTID'];
                        $layerid = $_GET['layerid'];
                        trim($layerid);
                        trim($layoutid);

//                        $black = "./img/black.jpg";
//                        $red = "./img/red.jpg";
//                        $blue = "./img/blue.jpg";


                        $black = "./img/noparking.png";
                        $red = "./img/occupied.png";
                        $blue = "./img/vacant.png";


                        $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer?id=0&&layoutid=' . $layoutid . '&&layerid=' . $layerid);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        curl_close($ch);
                        $results = json_decode($result, true);

                        $size = $results['LAYERS'][0]['LAYOUTSIZE'];


                        $max_c = $size % 10;
                        $max_r = ( $size - $max_c) / 10;


                        $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Slot?id=0&&layoutid=' . $layoutid . '&&layerid=' . $layerid);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $result = curl_exec($ch);
                        curl_close($ch);
                        $results = json_decode($result);




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
                                }
                                $c = $pos % 10;
                                $r = ($pos - $c) / 10;

                                $array[$r - 1][$c - 1] = $type;
                            }
                        }

                        for ($i = 0; $i < $max_r; $i++) {

                            echo "<tr>";

                            for ($j = 0; $j < $max_c; $j++) {

                                echo "<td>";

                                $type = $array[$i][$j];

                                if ($type == "0") {
                                    echo "<IMG  SRC=\"$black\" WIDTH=\"80\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                } else if ($type == "1") {
                                    echo "<IMG  SRC=\"$blue\" WIDTH=\"80\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                } else if ($type == "2") {
                                    echo "<IMG  SRC=\"$red\" WIDTH=\"80\" HEIGHT=\"80\" BORDER=\"2\" ALT=\"\"  \/>";
                                }
                                echo "</td>";
                            }
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
                </br>
                <center>
                    <form action='view2.php'>
                        <button id="done" class="btn btn-inverse">Back << </button>
                    </form>
                </center>
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