<html>
    <head>
        <title>HOME</title>
    </head>
    <body>
       	<form id='login' action='newuser.php' method='post' accept-charset='UTF-8'>
            <h1>New User</h1>			 
            <label for='username' >UserName*:</label>
            <input type='text' name='username' id='username'  maxlength="50" />			 
            <label for='password' >Password*:</label>
            <input type='password' name='password' id='password' maxlength="50" />	
            <label for='confirm_password' >Confirm Password*:</label>
            <input type='password' name='confirm_password' id='confirm_password' maxlength="50" />			 
            <input type='submit' name='Submit' value='Submit'/>		 
        </form>
    </body>
</html>
