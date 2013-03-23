<html>
    <head>
        <title>HOME</title>
    </head>
    <body>	
        <form id='login' action='login.php' method='post' accept-charset='UTF-8'>
            <h1>Login</h1>			 
            <label for='username' >UserName*:</label>
            <input type='text' name='username' id='username'  maxlength="50" />			 
            <label for='password' >Password*:</label>
            <input type='password' name='password' id='password' maxlength="50" />			 
            <input type='submit' name='Submit' value='Submit'/>		 
        </form>
        <a href="./create.php">Create new user</a>
</body>
</html>
