<html>
    <head>
        <title>HOME</title>
    </head>
    <body>	
        <form id='createLayout' action='createLayer1.php' method='post' accept-charset='UTF-8'>
            <h1>Login</h1>	
            
            <label for='layoutname' >Layout Name*:</label>
            <input type='text' name='layoutname' id='layoutname'  maxlength="50" />
            
            <label for='city' >City*:</label>
            <input type="text" name='city' id='city' maxlength="50" />
            
            <label for="area" >Area*</label>
            <input type='text' name="area" id="area" maxlength="50" />
            
            <label for='gps' >GPS Postion*</label>
            <input type='text' name='gps' id='gps' maxlength='50' />
                   
            <label for='numlayers'>Number of Layers*</label>
            <input type='text' name='numlayers' id='numlayers' maxlength='50' />
            
            
            <input type='submit' name='Submit' value='Submit'/>		 
        </form>
</body>
</html>



