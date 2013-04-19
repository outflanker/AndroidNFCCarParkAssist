<html>
    <head>
        <title>LOGIN</title>
        <script>
            function validatelogin()
            {
                var username = document.getElementById("login_username").value;
                var password = document.getElementById("login_password").value;
                if(username==null || username == "")
                {
                    alert("Username is empty");
                    return false;
                }    
                if(password ==null || password == "")
                {
                    alert("Password is empty");
                    return false;
                } 
                
                var xhrequest = new XMLHttpRequest();

                var params = "username="+username+"&password="+password;
                
//                var params = "username=doton&password=pehi";
//                
//                 
               xhrequest.open("POST", "http://localhost:8888/parking/webclient/functionality/login.php", false);
               
                xhrequest.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
                xhrequest.setRequestHeader( "Content-length", params.length );
                xhrequest.setRequestHeader( "Connection", "close" );
              
                xhrequest.onreadystatechange=function()
                {
                                   
                    //alert("the ready state is "+xhrequest.readyState);
                    //alert("the status is "+xhrequest.status);
                    if (xhrequest.readyState==4 && xhrequest.status  == 200)
                    {
                            
                
                            document.getElementById("myDiv").innerHTML = xhrequest.responseText;
                            
                                   
                             if(xhrequest.responseText == "Validated")
                                 {
                                     document.create.submit();
                                     
                                     
                                      }
           
                                 else if(xhrequest.responseText == "Incorrect password")
                                 {
                                          
                                          document.getElementById("create_username").value = "";
                                     document.getElementById("create_password").value = "";
                                     document.getElementById("create_confirm_password").value = "";        
                                            
                                   
                                       }
                             
                         
                    }
                }
                xhrequest.send(params);

         
                
                
            }
            
            
            function validatecreate()
            {
                var username = document.getElementById("create_username").value;
                var password = document.getElementById("create_password").value;
                var confirm_password = document.getElementById("create_confirm_password").value;
                
                if(username== null || username == "")
                {
                    alert("Username is empty");
                    return false;
                }    
                if(password == null || password == "")
                {
                    alert("Password is empty");
                    return false;
                } 
                 if(confirm_password == null || confirm_password == "")
                {
                    alert("Confirm Password is empty");
                    return false;
                }
                if(password != confirm_password)
                {
                    alert("password and confirm password do not match !")
                    return false;
                }
                
                var xhrequest = new XMLHttpRequest();
                var params = "username="+username+"&password="+password+"&confirm_password="+confirm_password;
                xhrequest.open("POST", "http://localhost:8888/parking/webclient/functionality/newuser.php", false);
               
                xhrequest.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
                xhrequest.setRequestHeader( "Content-length", params.length );
                xhrequest.setRequestHeader( "Connection", "close" );
              
                xhrequest.onreadystatechange=function()
                {
                                   
                    //alert("the ready state is "+xhrequest.readyState);
                    //alert("the status is "+xhrequest.status);
                    if (xhrequest.readyState==4 && xhrequest.status  == 200)
                    {
                            
                            document.getElementById("myDiv").innerHTML = xhrequest.responseText;
                            
                            
                         
                    }
                }
                xhrequest.send(params);
                
                
                
            }
              
        </script>
    </head>
    <body>	
        <table>
            <tr>
                
            <td>
        <form id='login' action="http://localhost:8888/parking/webclient/index.html" method='post'  accept-charset='UTF-8' float="left">
            <h1>Login</h1>			 
            <label for='username' >UserName*:</label>
            <input type='text' id='login_username' name='username'  maxlength="50" />	
            </br></br>

            <label for='password' >Password*:</label>
            <input type='password' id='login_password' name='password' maxlength="50" />
            </br></br>

                      
            <button type="button" onclick='validatelogin()'>Login</button>
        </form>
       
            </td>
            <td />
            <td />
            <td />
       
             <td>   
        <form id='create' name="create" action="http://localhost:8888/parking/webclient/index.html" method='post' accept-charset='UTF-8' float="right">
            <h1>New User</h1>			 
            <label for='username' >UserName*:</label>
            <input type='text' id='create_username' name='username'  maxlength="50" />	
            </br></br>
            <label for='password' >Password*:</label>
            <input type='password' id='create_password' name='password' maxlength="50" />	
            </br></br>
            <label for='confirm_password' >Confirm Password*:</label>
            <input type='password' id='create_confirm_password' name='confirm_password' maxlength="50" />			 
            </br></br>
            
            <button type="button" onclick='validatecreate()'>Create New User</button>
        </form>
             </td>
        </tr>
        
    </table>
        <h2><div id="myDiv"></div></h2>
    </body>
</html>



