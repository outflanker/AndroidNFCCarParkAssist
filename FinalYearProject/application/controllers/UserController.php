<?php

class UserController extends Zend_Rest_Controller
{
    public function deleteAction() {
        
    }

    public function getAction() 
    {
        $response=$this->getResponse();
                
        $con = mysql_connect("localhost","appadmin","apppwd");
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db("parkingdatabase", $con);
                $query="SELECT * FROM ACCOUNTS";
                $res=mysql_query($query);
                $jsonreturn=null;
                while($row = mysql_fetch_array($res))
                {
                    $jsonreturn[$row['USER']]=$row['UPASSWORD'];
                 }
                 return $response->appendBody(json_encode($jsonreturn));
         }
        mysql_close($con);
        
    }

    public function headAction() {
        
    }

    public function indexAction() {
        
    }

    public function postAction()
    {
        $incoming = file_get_contents("php://input");
        $json = json_decode($incoming,true);
        $uname =  $json['user'];
        $pass = $json['password'];
        $con = mysql_connect("localhost","appadmin","apppwd");
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db("parkingdatabase", $con);
                $query="INSERT INTO ACCOUNTS (USER,UPASSWORD) VALUES ('".$uname."','".$pass."')";
                $res=mysql_query($query);
         }
        mysql_close($con);
    }

    public function putAction() 
    {
        
    }    
}
?>
