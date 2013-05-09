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
        <title>ADMIN SIGNUP</title>
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
                $("#create").validate({
                    rules: {
                        username :"required",
                        password: {
                            required: true,
                            minlength: 5
                        },
                        confpassword: {
                            required: true,
                            minlength: 5,
                            equalTo: "#password"
                        }
                    },
                    messages: {
                        username: "Please enter a username",
                        password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        },
                        confpassword: {
                            required: "Please enter the password again ",
                            minlength: "Your password must be at least 5 characters long",
                            equalTo: "Please enter the same password as above"
                        }
                    }
                    
                });                
                 
                 
                 
                $("#signupbtn").click(function(event){
                    
                    var valid = $("#create").valid();     
                    
                    if(valid)
                    {
                        var name = $('#username').val();
                    
                        var pwd = $('#password').val();
                        
                     
                    
                        $.ajax({
                            url: "newuser.php",
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
                                alert(msg);
                                if(msg == "New user created!")
                                {
                                    var url = "index.php";    
                                    $(location).attr('href',url);
                                    return true;
                                }
                                if(msg == "Username already exists")
                                {
                                    $("#username").val("");
                                    $("#password").val("");
                                    $("#confpassword").val("");
                                    
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
                                <li><a href='signup.php' class='active-link' >Sign up</a></li>
                                 <li><a href='signin.php' >Sign in</a></li>

                                


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
            <h1>SIGN UP </h1>
        </div>
        <div class="row">
            <div class="span6 offset3">
                <h4 class="widget-header">Be a CAR PARK ASSIST ADMIN</h4>
                <div class="widget-body">
                    <div class="center-align">
                        <form class="form-horizontal form-signin-signup" action="index.php" id="create">
                            <input type="text" name="username" id="username" placeholder="Username"></br></br>
                            <input type="password" name="password" id="password" placeholder="Password"></br></br>
                            <input type="password" name="confpassword" id="confpassword" placeholder="Password Confirmation"></br></br>
                            <div>
                                <button class="btn btn-success" class="btn btn-primary btn-large" id="signupbtn">SignUp</button>
                            </div>
                        </form>
                        <h4><i class="icon-question-sign"></i> Already have an account?</h4>
                        <a href="signin.php" class="btn btn-large btn-inverse bottom-space">Signin</a>
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

</body>
</html>