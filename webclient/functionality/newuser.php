<html>
<?php
    $user=$_POST['username'];
    $pwd=$_POST['password'];
    $cpwd=$_POST['confirm_password'];
    trim($user);
    trim($pwd);
    trim($cpwd);
    
    if($pwd==$cpwd)
    {
        print "Validated";
                
        $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/User/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch,CURLOPT_POSTFIELDS,"{\"USER\":\"".$user."\",\"PASSWORD\":\"".$pwd."\"}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        print $result;
        curl_close($ch);
    }
    else
    {
        print "Incorrect password";
    }
?>
</html> 