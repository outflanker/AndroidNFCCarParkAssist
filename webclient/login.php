<?php
   
    $user=$_POST['username'];
    $pwd=$_POST['password'];
    trim($user);
    trim($pwd);

    
    
    $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/User?id='.$user);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $json=json_decode($result,true);

    if($json['PASSWORD']==$pwd)
    {
        setcookie("LOGINUSERNAME", $user);  /* expire in 1 hour */
        echo "Validated";
    }
    else
    {
        echo "Incorrect password";
    }
?>
