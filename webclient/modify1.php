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
            $(document).ready(function(){
                var result = true;   
                
                
                
                $.validator.addMethod("parkingnotEqualTo", function(value, element) {
                    return $('#parkingrate').val() != 0;
                }, "Parking rate cannot be 0");        
                 
                $("#layoutinput").validate({
                    rules: {
                        layoutname :"required",
                        city : "required",
                        area : "required",
                        lati : "required",
                        longi : "required",
                        rate :{
                            required: true,
                            number: true,
                            parkingnotEqualTo : true
                        }                   
                    },
                    messages: {
                        layoutname :"Please enter a layoutname",
                        city : "Please enter a city",
                        area : "Please enter an area",
                        lati : "Please enter a latitude value",
                        longi : "Please enter a longitude value",
                        rate: {
                                                      
                            required: "Please enter the parking rate",
                            number: "Parking rate has to be a number"
                        }
                    
                        
                    }
                    
                });
               
                $("#changelayers").click(function(event){
                    
                    var valid = $("#layoutinput").valid();     
                    if(valid)
                    {
                        $.cookie("MODIFYLAYOUTREDIRECT","modify2.php");
                        return true;
                    }
                    else
                    {
                        return result=false;
                    }
                        
                    
                    
                });
               
               
                $("#done").click(function(event){
                    
                    var valid = $("#layoutinput").valid();     
                    if(valid)
                    {
                        $.cookie("MODIFYLAYOUTREDIRECT","index.php");
                        return true;
                    }
                    else
                    {
                        return result=false;
                    }
                        
                    
                    
                });
                return result;
                            
                

                 
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
        <?php
        if (isset($_COOKIE['MODIFYLAYOUTID'])) {
            $layoutID = $_COOKIE['MODIFYLAYOUTID'];
            $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout?id=' . $layoutID);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            $results = json_decode($result, true);

            $layernum = $results['LAYOUTS'][0]['NUMOFLAYERS'];
            $layoutname = $results['LAYOUTS'][0]['LAYOUTNAME'];
            $layoutcity = $results['LAYOUTS'][0]['CITY'];
            $layoutarea = $results['LAYOUTS'][0]['AREA'];
            $layoutlatitude = $results['LAYOUTS'][0]['LATITUDE'];
            $layoutlongitude = $results['LAYOUTS'][0]['LONGITUDE'];
            $layoutrate = $results['LAYOUTS'][0]['PARKINGRATE'];
            ?>
            <div class="content">
                <div class="container">
                    <div class="row-fluid">
                        <form class="form-horizontal" method="post" id='layoutinput' action="changelayout.php">
                            <fieldset>
                                <div id="legend">
                                    <legend class="">Modify Layout</legend>
                                </div>



                                <!-- Name -->
                                <div class="control-group">
                                    <label class="control-label"  for="layoutname">Layout Name</label>
                                    <div class="controls">
                                        <input type="text" name='layoutname' value="<?php echo $layoutname; ?>" id='layoutname' placeholder="" class="input-xlarge">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"  for="city">City</label>
                                    <div class="controls">
                                        <input type="text"  name='city' value="<?php echo $layoutcity; ?>" id='city' placeholder="" class="input-xlarge">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"  for="area">Area</label>
                                    <div class="controls">
                                        <input type="text" name="area" value="<?php echo $layoutarea; ?>" id="area" placeholder="" class="input-xlarge">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"  for="gps">Latitude</label>
                                    <div class="controls">
                                        <input type="text" name='lati' value="<?php echo $layoutlatitude; ?>" id='lati' placeholder="" class="input-xlarge">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"  for="gps">Longitude</label>
                                    <div class="controls">
                                        <input type="text" name='longi' value="<?php echo $layoutlongitude; ?>" id='longi' placeholder="" class="input-xlarge">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"  for="gps">Parking Rate</label>
                                    <div class="controls">
                                        <input type="text" name='rate' value="<?php echo $layoutrate; ?>" id='rate' placeholder="" class="input-xlarge">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label"  for="numlayers">Number of Layers</label>
                                    <div class="controls">
                                        <input type="text" name='numlayers' value="<?php echo $layernum; ?>" readonly="readonly" id='numlayers' placeholder="" class="input-xlarge">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <button  class="btn btn-success" id='done'>Done</button>
                                    </div>
                                </div>
                        </form>

                        <!-- Submit -->
                        <div class="control-group">
                            <div class="controls">
                                <button  class="btn btn-primary" id='changelayers'>Change Layers</button>
                            </div>
                        </div>






                        </fieldset>

                    </div>
                </div>
            </div>
            <?php
        }
        ?>
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

    </body>
</html>