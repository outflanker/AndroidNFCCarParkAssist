<?php
foreach ($_POST as $entry)
{
     print $entry . "<br>";
}
        $layoutID = $_GET['layoutid'];
        $layerID = $_GET['layerid'];
        
        print $layoutID;
        print $layerID;
        trim($layoutID);
        trim($layerID);
?>
<html>
    <head>
        <title>HOME</title>
    </head>
    <body>	
        <form id='createLayout' action='createGrid.php' method='post' accept-charset='UTF-8'>
            <h1>Login</h1>	
            
            
            <input type='hidden' name='layoutid' id='layoutid'  value='<?php echo $layoutID; ?>' />
            
            <input type='hidden' name='layerid' id='layerid'  value="<?php echo $layerID; ?>" />   
            
                           
            <label for='numlayers'>Layout Size*</label>
            <input type='text' name='layoutsize' id='layoutsize' maxlength='50' />
            
            <label for='parkingrate'>Parking Rate*</label>
            <input type='text' name='parkingrate' id='parkingrate' maxlength='50' />
            
            <input type='submit' name='Submit' value='Submit'/>		 
        </form>
</body>
</html>