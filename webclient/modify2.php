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
            var modify = function(layoutid, layerid) {

                $.cookie("MODIFYLAYERID", layoutid);

                $.ajax({
                    url: "checkmodifylayer.php",
                    type: 'POST',
                    data: "layoutid=" + layoutid + "&layerid=" + layerid,
                    datatype: "text",
                    async: false,
                    cache: false,
                    timeout: 30000,
                    error: function() {
                        return true;
                    },
                    success: function(msg) {


                        if (msg == 0) {
                            
                                window.location = "modifyaddcookie.php";


                        }
                        else
                        {
                            alert("slots are occupied ! Free them to modify");
                            location.reload();
                        }





                    }


                });


            }

            var del = function(id) {

                var ans = confirm("Are you sure you want to delete the entire layer : " + id + " ?");
                if (ans == true)
                {
                    $.ajax({
                        url: "deletelayer.php",
                        type: 'POST',
                        data: "layerid=" + id,
                        datatype: "text",
                        async: false,
                        cache: false,
                        timeout: 30000,
                        error: function() {
                            return true;
                        },
                        success: function(msg) {
                            alert(msg);

                            location.reload();



                        }


                    });
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

                <?php
//                    $layoutID = $_GET['layoutid'];
                if (isset($_COOKIE['MODIFYLAYOUTID'])) {

                    $layoutID = $_COOKIE['MODIFYLAYOUTID'];

                    trim($layoutID);
                    $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer?id=0&&layoutid=' . $layoutID);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    $results = json_decode($result);

                    $numentries = json_decode($result, true);

                    $layernum = $numentries['LAYERS'];

                    if ($layernum != NULL) {
                        ?>
                        <h1>Select Level/Layer for the given layout</h1>
                        <table border="1" class="table table-hover">
                            <tr>
                                <th>Layer No</th>
                                <th>Status</th>
                                <th>Modify</th>
                                <th>Delete</th>

                            </tr>
                            <?php
                            foreach ($results as $key => $jsons) {
                                foreach ($jsons as $key => $value) {

                                    foreach ($value as $keys => $values) {
                                        if ($keys == "LAYERID") {
                                            $i = $values;
                                            ?>
                                            <br/>

                                            <?php
                                            $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layer?id=0&&layoutid=' . $layoutID . '&&layerid=' . $i);
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            $result = curl_exec($ch);
                                            curl_close($ch);
                                            $results = json_decode($result, true);

                                            $size = $results['LAYERS'][0]['LAYOUTSIZE'];


                                            if ($size == 0) {
                                                print '<tr><td>' . $i . '</td>';
                                                print '<td>Not Defined</td>';
                                            } else {
                                                print '<tr><td><a href="./view3.php?layoutid=' . $layoutID . '&&layerid=' . $i . '">' . $i . '</a></td>';
                                                print '<td>Done</td>';
                                            }
                                            ?>
                                            <td>
                                                <button class="btn btn-success" onclick="modify('<?php echo $layoutID; ?>', '<?php echo $i ?>')">Modify</button>
                                            </td>
                                            <td>
                                                <button class="btn btn-success" onclick="del('<?php echo $i; ?>')">Delete</button>
                                            </td>
                                            <?php
                                        }
                                    }
                                }
                            }
                        } else {
                            print "<h1>No levels to display</h1>";
                        }
                        ?>
                    </table>  
                    <br>

                    <center>
                        <form action="addlayer.php">
                            <button class="btn btn-success">Add A Layer</button>
                        </form>
                        <form action='index.php'>
                            <button id="done" class="btn btn-success">DONE </button>
                        </form>
                    </center>
                    <?php
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
