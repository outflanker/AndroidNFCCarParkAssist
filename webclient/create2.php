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
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js" ></script>
        <script src="js/jquery.cookie.js" ></script>
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js" ></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/signout.js"></script>        
        <script>
            $(document).ready(function(){
                
               
                $.validator.addMethod("sizenotEqualTo", function(value, element) {
                    var intRegex = /^[1-9][1-9]$/;
                    var size = $('#layoutsize').val() ;
                    
                    if(size.match(intRegex))
                        return true;
                    else
                        return false;
                    
                        
                }, "Size is not in the right format (should be in dd format )");
                        
                $("#layerinput").validate({
                    rules: {
                        layoutsize :{
                            required: true,
                            number: true,
                            sizenotEqualTo : true
                        }
                    },
                    messages: {
                        layoutsize :
                            {
                            required : "Please enter the layoutsize",
                            number: "Layout size has to be a number "
                            
                        }
                    }
                    
                });                
                 
                 
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
        <?php
        if (isset($_COOKIE['CREATELAYOUTID']) && isset($_COOKIE['CREATELAYERID'])) {
            $layoutID = $_COOKIE['CREATELAYOUTID'];
            $layerID = $_COOKIE['CREATELAYERID'];

            trim($layoutID);
            trim($layerID);
            ?>


            <div class="row-fluid">
                <form class="form-horizontal" method="post" id="layerinput" action="create3.php">
                    <fieldset>
                        <div id="legend">
                            <legend class="">Create Layer</legend>
                        </div>


                        <input type='hidden' name='layoutid' id='layoutid'  value='<?php echo $layoutID; ?>' />

                        <input type='hidden' name='layerid' id='layerid'  value="<?php echo $layerID; ?>" />   


                        <div class="control-group">
                            <label class="control-label"  for="gps">Layout Size</label>
                            <div class="controls">
                                <input type="text" name='layoutsize' id='layoutsize' placeholder="" class="input-xlarge">
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="control-group">
                            <div class="controls">
                                <button class="btn btn-success">Next >></button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        <?php } ?>
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