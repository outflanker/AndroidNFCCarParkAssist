<!DOCTYPE html>
<?php
if (isset($_COOKIE['LOGINUSERNAME']))
       header("Location: index.php");
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Bootbusiness | Short description about company">
        <meta name="author" content="Your name">
        <title>ADMIN SIGNIN</title>
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
        <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js" ></script>
        <script src="js/bootstrap.js"></script>
        <script>
            $(document).ready(function(){
                
                var result = true;
                
                $("#login1").validate({
                    
                    rules: {
                       
                        lusername :"required",
                        lpassword: "required"
                            
                    },
                    messages: {
                        lusername: "Please enter a username",
                        lpassword: "Please enter a password"
                            
                               
                    }

                });
               
                $("#loginbtn").click(function(event){
                    
                    
                    var valid = $("#login1").valid();     
                    
                    if(valid)
                    {
                        var name = $('#lusername').val();
                        var pwd = $('#lpassword').val();
                    
                    
                        $.ajax({
                            url: "login.php",
                            type: 'POST',
                            data : "username="+name+"&password="+pwd ,
                            datatype :"text",
                            async: false, 
                            cache: false,
                            timeout: 30000,
                            error: function(){
                                return true;
                            },
                            success: function(msg){                        
                                
                                if(msg == "Validated")
                                {
                                    return true;                                                                                        
                                }
                                if(msg=="Incorrect password")
                                {
                                    alert(msg);
                                    $("#lusername").val("");
                                    $("#lpassword").val("");
                                    
                                    return result=false;
                                     
                                }    
                           
                            }
                    

                        });
                    }
                    return result;
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

                                <li><a href="signin.php">Monitor</a></li>
                                <li><a href="signin.php">View</a></li>
                                <li><a href="signin.php">Create</a></li>
                                <li><a href="signin.php">Alter</a></li>
                                <li><a href='signup.php' >Sign up</a></li>
                                 <li><a href='signin.php' class='active-link'>Sign in</a></li>

                                


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
                <div class="page-header">
                    <h1>SIGN IN</h1>
                </div>
                <div class="row">
                    <div class="span6 offset3">
                        <h4 class="widget-header"><i class="icon-lock"></i> Signin to CAR PARK ASSIST </h4>
                        <div class="widget-body">
                            <div class="center-align">
                                <form class="form-horizontal form-signin-signup" action="index.php" id="login1">

                                    <input type="text" name="lusername" id="lusername" placeholder="Username">
                                    </br></br>

                                    <input type="password" name="lpassword" id="lpassword" placeholder="Password">
                                    <div class="remember-me">
                                        <div class="pull-left">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <button class="btn btn-success" id="loginbtn">Login</button>
                                </form>

                                </br>
                                </br>

                                <h4><i class="icon-question-sign"></i> Don't have an account?</h4>
                                <a href="signup.php" class="btn btn-large btn-inverse bottom-space">Signup</a>
                            </div>
                        </div>
                    </div>
                </div>
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