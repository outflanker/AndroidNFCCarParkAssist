<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UnregisterController
 *
 * @author siddharth
 */
class UnregisterController extends Zend_Rest_Controller
{
    const SLOTID='SLOTID';  
    const USER='USER';
    const TIMEIN='TIMEIN';
    const RATE='RATE';
    const SLOTTYPE='SLOTTYPE';

    public function deleteAction() 
    {
        
    }

    public function getAction() 
    {
        $response=$this->getResponse();
        $slotid= $this->_getParam ('slotid');
        $userid= $this->_getParam ('userid');
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                if($slotid!=NULL)
                {
                    $query="SELECT * FROM SLOTS WHERE SLOTID='".$slotid."'";
                }
                else if($userid!=NULL)
                {
                    $query="SELECT * FROM SLOTS WHERE USER='".$userid."'";
                
                }
                $res=mysql_query($query);
                while($row = mysql_fetch_array($res))
                {
                    $slotid=$row[self::SLOTID];
                    $user=$row[self::USER];
                    $timein=$row[self::TIMEIN];
                    $type=$row[self::SLOTTYPE];
                    $slots[]=array(self::SLOTID=>$slotid,self::USER=>$user,self::TIMEIN=>$timein,self::SLOTTYPE=>$type);
                 }
                 $jsonreturn['SLOTS']=$slots;
                 return $response->appendBody(json_encode($jsonreturn));
         }
        mysql_close($con);
        
    }

    public function headAction() {
        
    }

    public function indexAction() 
    {
    }

    public function postAction() {
        
    }

    public function putAction()
    {
        $response=$this->getResponse();
        
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming,true);
        $slotid=$json[self::SLOTID];
        
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $totalfare=null;
                $jsonreturn=null;
               
                $query="SELECT RATE,TIMEIN FROM SLOTS WHERE SLOTID='".$slotid."'";
                $res=mysql_query($query);
                while($row = mysql_fetch_array($res))
                {
                     $rate=$row[self::RATE];
                     $timein=$row[self::TIMEIN];
                 }
                 $query="SELECT TIMESTAMPDIFF(MINUTE,'".$timein."',NOW())";
                $res=mysql_query($query);
                 while($row = mysql_fetch_array($res))
                {
                    $totaltime=$row[0];
                 }
                 $jsonreturn['FARE']=$rate*$totaltime;
                 $response->appendBody(json_encode($jsonreturn));
                 
                $query="UPDATE SLOTS SET SLOTTYPE=1, USER='NOBODY' , TIMEIN='0000-00-00 00:00:00' WHERE SLOTID='".$slotid."'";
                $res=mysql_query($query);
                 
                 return $response;
        }
        mysql_close($con);     
        
    }    
}

?>