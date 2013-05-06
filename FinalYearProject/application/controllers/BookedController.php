<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BookedController
 *
 * @author nkbhat
 */
class BookedController extends Zend_Rest_Controller {

    
    
    const LAYERID='LAYERID';
    
    const LAYOUTNAME = 'LAYOUTNAME';
    const CITY = 'CITY';
    const AREA = 'AREA';
    
    const POSITION='POSITION';
    
    
    
    public function deleteAction() {

        
        
    }

    public function getAction() {
        
        $response=$this->getResponse();
        
        $user= $this->_getParam ('user');
        
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="SELECT S.LAYERID,S.POSITION,S.TIMEIN,L.LAYOUTNAME,L.CITY,L.AREA FROM SLOTS S,LAYOUT L WHERE L.LAYOUTID=S.LAYOUTID AND S.USER=".$user;
                
                $res=mysql_query($query);
                while($row = mysql_fetch_array($res))
                {
                    
                    $lyerid=$row[self::LAYERID];
                    $lyoutname=$row[self::LAYOUTNAME];
                    $pos=$row[self::POSITION];
                    $city = $row[self::CITY];
                    $area = $row[self::AREA];
                    
                    
                    
                    $slots[]=array(self::LAYERID=>$lyerid,self::LAYOUTNAME=>$lyoutname,self::POSITION=>$pos,self::CITY=>$city,  self::AREA=>$area);
                 }
                 $jsonreturn['SLOTS']=$slots;
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
