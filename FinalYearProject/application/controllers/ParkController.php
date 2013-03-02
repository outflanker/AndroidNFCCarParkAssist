<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ParkController
 *
 * @author siddharth
 */
class ParkController extends Zend_Rest_Controller
{
    const SLOTID='SLOTID';    
    const LAYERID='LAYERID';
    const LAYOUTID='LAYOUTID';
    const POSITION='POSITION';
    const USER='USER';
    const TIMEIN='TIMEIN';
    const RATE='RATE';
    const SLOTTYPE='SLOTTYPE';

    public function deleteAction() 
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

    public function getAction() {
        
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
                $query="SELECT * FROM SLOTS";
                $res=mysql_query($query);
                while($row = mysql_fetch_array($res))
                {
                    $slotid=$row[self::SLOTID];
                    $lyerid=$row[self::LAYERID];
                    $lyoutid=$row[self::LAYOUTID];
                    $pos=$row[self::POSITION];
                    $rate=$row[self::RATE];
                    $type=$row[self::SLOTTYPE];
                    $slots[]=array(self::SLOTID=>$slotid,self::LAYERID=>$lyerid,self::LAYOUTID=>$lyoutid,self::POSITION=>$pos,  self::RATE=>$rate,  self::SLOTTYPE=>$type);
                 }
                 $jsonreturn['SLOTS']=$slots;
                 return $response->appendBody(json_encode($jsonreturn));
         }
        mysql_close($con);
    }

    public function postAction() {
        
    }

    public function putAction()
    {
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming,true);
        $slotid=$json[self::SLOTID];
        $user=$json[self::USER];
        
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="UPDATE SLOTS SET SLOTTYPE=2, USER='".$user."' , TIMEIN=NOW() WHERE SLOTID='".$slotid."'";
                $res=mysql_query($query);
        }
        mysql_close($con);      
        
    }    
}

?>
