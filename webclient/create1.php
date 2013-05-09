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
        <title>CREATE LAYOUT</title>
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
        var test = function( text ){
   
                $.cookie("CREATELAYERID",text);
                
                 
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

                                <li><a href="monitor.php">Monitor </a></li>
                                <li><a href="view.php" >View </a></li>
                                <li><a href="create.php" class='active-link'>Create</a></li>
                                <li><a href="modify.php" >Alter </a></li>


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
        <div class="row-fluid">
            <form class="form-horizontal" action='index.php'>
                <fieldset>
                    <div id="legend">
                        <legend class="">Create Layers in the Layout</legend>
                    </div>

                    <?php
//        print "it starts ";
//        print $aa;
//        print "number of lay : $numOfLayers";
                    ?>
                    <table class="table table-hover">
                        <tr>
                            <td>Layer Number</td>
                            <td>Status</td>
                        </tr>


                        <?php
                        if (isset($_COOKIE['CREATELAYOUTID'])) {
                            $layoutID = $_COOKIE['CREATELAYOUTID'];
                            $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout?id=' . $layoutID);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $result = curl_exec($ch);
                            curl_close($ch);

                            $results = json_decode($result, true);

                            $layernum = $results['LAYOUTS'][0]['NUMOFLAYERS'];


                            for ($i = 0; $i < $layernum; $i++) {

                                $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer?id=0&&layoutid=' . $layoutID . '&&layerid=' . $i);
                                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $result = curl_exec($ch);
                                curl_close($ch);
                                $results = json_decode($result, true);

                                $size = $results['LAYERS'][0]['LAYOUTSIZE'];


//                                print '<tr><td><a onclick="test(\''.$i.'\')" href="./create2.php">' . $i . '</a>';
                                if ($size == 0) {
                                    print '<tr class=".error" ><td><a onclick="test(\''.$i.'\')" href="./create2.php">' . $i . '</a></td><td>Not Defined</td></tr>';
                                } else{ 
                                    print '<tr class=".success" ><td><a onclick="test(\''.$i.'\')" href="./create2.php">' . $i . '</a></td><td>Done</td></tr>';
                                }
                            }
                        }
                        ?>
                    </table>
                    <div class="control-group">
                        <div class="controls">
                            <button class="btn btn-success">Done</button>
                        </div>
                    </div>

                </fieldset>
            </form>
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
    </body>
</html>