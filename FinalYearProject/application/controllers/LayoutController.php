<?php

class LayoutController extends Zend_Rest_Controller
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
                $query="SELECT * FROM LAYOUT";
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

    public function postAction() {
        
    }

    public function putAction() {
        
    }    
}

?>
