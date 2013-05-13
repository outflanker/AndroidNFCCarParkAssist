<?php
class SlotController extends Zend_Rest_Controller
{
    const SLOTID='SLOTID';    
    const LAYERID='LAYERID';
    const LAYOUTID='LAYOUTID';
    const POSITION='POSITION';
    const SLOTTYPE='SLOTTYPE';

    public function deleteAction() 
    {
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
                $type=0;
                mysql_select_db(parent::DATABASE, $con);
                $query="UPDATE SLOTS SET SLOTTYPE=".$type." WHERE SLOTID='".$slotid."'";
                $res=mysql_query($query);
        }
        mysql_close($con);  
    }

    public function getAction() 
    {
        $response=$this->getResponse();
        $layerid= $this->_getParam ('layerid');
        $layoutid=$this->_getParam('layoutid');
                
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="SELECT * FROM SLOTS WHERE  LAYOUTID='".$layoutid."' AND LAYERID='".$layerid."'";
                $res=mysql_query($query);
                while($row = mysql_fetch_array($res))
                {
                    $slotid=$row[self::SLOTID];
                    $lyerid=$row[self::LAYERID];
                    $lyoutid=$row[self::LAYOUTID];
                    $pos=$row[self::POSITION];
                    $type=$row[self::SLOTTYPE];
                    $slots[]=array(self::SLOTID=>$slotid,self::LAYERID=>$lyerid,self::LAYOUTID=>$lyoutid,self::POSITION=>$pos,self::SLOTTYPE=>$type);
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
                    $type=$row[self::SLOTTYPE];
                    $slots[]=array(self::SLOTID=>$slotid,self::LAYERID=>$lyerid,self::LAYOUTID=>$lyoutid,self::POSITION=>$pos,self::SLOTTYPE=>$type);
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
        $type=$json[self::SLOTTYPE];
                
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="UPDATE SLOTS SET SLOTTYPE=".$type." WHERE SLOTID='".$slotid."'";
                $res=mysql_query($query);
        }
        mysql_close($con);        
    }    
}

?>
