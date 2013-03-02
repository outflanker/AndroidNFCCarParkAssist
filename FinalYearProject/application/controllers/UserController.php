<?php

class UserController extends Zend_Rest_Controller
{
    const USER_CONST='USER';
    const PASSWORD_CONST='PASSWORD';

    public function deleteAction() 
    {
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming,true);
        $uname =  $json[self::USER_CONST];
        $pass = $json[self::PASSWORD_CONST];
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="DELETE FROM ACCOUNTS WHERE USER='".$uname."' AND UPASSWORD='".$pass."'";
                $res=mysql_query($query);
         }
        mysql_close($con);        
    }

    public function getAction() 
    {
        
    }

    public function headAction() {
        
    }

    public function indexAction() 
    {
        $response=$this->getResponse();
                
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="SELECT * FROM ACCOUNTS";
                $res=mysql_query($query);
                while($row = mysql_fetch_array($res))
                {
                    $user=$row['USER'];
                    $pwd=$row['UPASSWORD'];
                    $users[]=array(self::USER_CONST=>$user, self::PASSWORD_CONST=>$pwd);
                 }
                 $jsonreturn['USERS']=$users;
                 return $response->appendBody(json_encode($jsonreturn));
         }
        mysql_close($con);
    }

    public function postAction()
    {
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming,true);
        $uname =  $json[self::USER_CONST];
        $pass = $json[self::PASSWORD_CONST];
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="INSERT INTO ACCOUNTS (USER,UPASSWORD) VALUES ('".$uname."','".$pass."')";
                print $query;
                $res=mysql_query($query);
         }
        mysql_close($con);
    }

    public function putAction() 
    {
        
    }    
}
?>
