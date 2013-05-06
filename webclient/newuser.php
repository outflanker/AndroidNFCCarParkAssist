<?php
        $user = $_POST['username'];
        $pwd = $_POST['password'];
        
        trim($user);
        trim($pwd);
        

        $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/User?id=' . $user);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

            
        if ($result=="null") {
            $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/User/');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"USER\":\"" . $user . "\",\"PASSWORD\":\"" . $pwd . "\"}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            setcookie("LOGINUSERNAME", $user);  /* expire in 1 hour */
            echo "New user created!";
            curl_close($ch);
            
        } else {
            
            echo "Username already exists";
        }
        ?>
