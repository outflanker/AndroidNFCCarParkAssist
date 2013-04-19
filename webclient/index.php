<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Bootbusiness | Short description about company">
        <meta name="author" content="Your name">
        <title>HOME</title>
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


                                <?php
                                if (isset($_COOKIE['LOGINUSERNAME'])) {
                                    ?>
                                    <li><a href="monitor.php">Monitor</a></li>
                                    <li><a href="view.php">View </a></li>
                                    <li><a href="create.php">Create Layout</a></li>
                                    <li><a href="modify.php">Alter Layout</a></li>
                                    <?php
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
                                    ?>
                                    <li><a href="signin.php">Monitor</a></li>
                                    <li><a href="signin.php">View </a></li>
                                    <li><a href="signin.php">Create Layout</a></li>
                                    <li><a href="signin.php">Alter Layout</a></li>
                                    <li><a href='signup.php'>Sign up</a></li>
                                    <li><a href='signin.php'>Sign in</a></li>
                                    <?php
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
            <!-- Start: slider -->
            <div class="slider">
                <div class="container-fluid">
                    <div id="heroSlider" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="active item">
                                <div class="hero-unit">
                                    <div class="row-fluid">
                                        <div class="span7 marketting-info">
                                            <h1>Are you running around in circles to find parking for your car ?</h1>
                                            </br>
                                            <p>
                                                Start using the NFC based CAR PARK ASSIST .
                                            </p>

                                        </div>
                                        <div class="span5">
                                            <img src="img/car.jpg" class="thumbnail">
                                        </div>
                                    </div>                  
                                </div>
                            </div>
                            <div class="item">
                                <div class="hero-unit">
                                    <div class="row-fluid">
                                        <div class="span7 marketting-info">
                                            <h1> Have you faced problems with complicated billing systems ?</h1>
                                            <p>
                                                Start using the NFC based CAR PARK ASSIST .
                                            </p>

                                        </div>
                                        <div class="span5">
                                            <img src="img/car_billing_resize.jpg" class="thumbnail">
                                        </div>
                                    </div>                  
                                </div>
                            </div>
                            <div class="item">
                                <div class="hero-unit">
                                    <div class="row-fluid">
                                        <div class="span7 marketting-info">
                                            <h1> Do you want to register brand new layouts created in no time ? </h1>
                                            <p>
                                                Start using the NFC based CAR PARK ASSIST .
                                            </p>

                                        </div>
                                        <div class="span5">
                                            <img src="img/car_create_new.jpg" class="thumbnail">
                                        </div>
                                    </div>                  
                                </div>
                            </div>
                            <div class="item">
                                <div class="hero-unit">
                                    <div class="row-fluid">
                                        <div class="span7 marketting-info">
                                            <h1>Do you want to provide multilevel parking support ?</h1>
                                            <p>
                                                Start using the NFC based CAR PARK ASSIST .
                                            </p>

                                        </div>
                                        <div class="span5">
                                            <img src="img/car_park2_resize.jpg" class="thumbnail">
                                        </div>
                                    </div>                  
                                </div>
                            </div>
                        </div>
                        <a class="left carousel-control" href="#heroSlider" data-slide="prev">‹</a>
                        <a class="right carousel-control" href="#heroSlider" data-slide="next">›</a>
                    </div>
                </div>
            </div>
            <!-- End: slider -->
            <!-- Start: PRODUCT LIST -->
            <!-- End: PRODUCT LIST -->
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