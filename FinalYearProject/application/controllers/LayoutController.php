<?php

class LayoutController extends Zend_Rest_Controller
{
    const LAYOUTID='LAYOUTID';
    const LAYOUTNAME='LAYOUTNAME';
    const NUMLAYERS='NUMOFLAYERS';
    const CITY='CITY';
    const AREA='AREA';
    const GPS='GPS';
    public function deleteAction()
    {
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming,true);
        $inputid =  $json[self::LAYOUTID];
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="DELETE FROM LAYOUT WHERE LAYOUTID='".$inputid."'";
                $res=mysql_query($query);
         }
        mysql_close($con);        
    }

    public function getAction()
    {
        $response=$this->getResponse();
        $inputid= $this->_getParam ('id');
                
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="SELECT * FROM LAYOUT WHERE LAYOUTID='".$inputid."'";
                $res=mysql_query($query);
                while($row = mysql_fetch_array($res))
                {
                    $id=$row[self::LAYOUTID];
                    $name=$row[self::LAYOUTNAME];
                    $numlayers=$row[self::NUMLAYERS];
                    $city=$row[self::CITY];
                    $area=$row[self::AREA];
                    $gps=$row[self::GPS];
                    $layouts[]=array(self::LAYOUTID=>$id, self::LAYOUTNAME=>$name,  self::NUMLAYERS=>$numlayers,  self::CITY=>$city,  self::AREA=>$area,  self::GPS=>$gps);
                 }
                 $jsonreturn['LAYOUTS']=$layouts;
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
                $query="SELECT * FROM LAYOUT";
                $res=mysql_query($query);
                while($row = mysql_fetch_array($res))
                {
                    $id=$row[self::LAYOUTID];
                    $name=$row[self::LAYOUTNAME];
                    $numlayers=$row[self::NUMLAYERS];
                    $city=$row[self::CITY];
                    $area=$row[self::AREA];
                    $gps=$row[self::GPS];
                    $layouts[]=array(self::LAYOUTID=>$id, self::LAYOUTNAME=>$name,  self::NUMLAYERS=>$numlayers,  self::CITY=>$city,  self::AREA=>$area,  self::GPS=>$gps);
                 }
                 $jsonreturn['LAYOUTS']=$layouts;
                 return $response->appendBody(json_encode($jsonreturn));
         }
        mysql_close($con);
    }

    public function postAction() 
    {
        $response=$this->getResponse();
        
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming,true);
        $name=$json[self::LAYOUTNAME];
        $numlayers=$json[self::NUMLAYERS];
        $city=$json[self::CITY];
        $area=$json[self::AREA];
        $gps=$json[self::GPS];
        $id=  substr($city, 0,3).substr($area, 0,3).substr($name, 0,4);
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER,  parent::DBPWD);
        if (!$con)
        {
              print "Error";
              die('Could not connect: ' . mysql_error());
        }
        else
        {
                mysql_select_db(parent::DATABASE, $con);
                $query="INSERT INTO LAYOUT VALUES ('".$id."','".$name."',".$numlayers.",'".$city."','".$area."','".$gps."')";
                $res=mysql_query($query);
                $size=0;
                for($i=0;$i<$numlayers;$i++)
                {
                    $query="INSERT INTO LAYER VALUES (".$i.",'".$id."',".$size.")";
                    $res=mysql_query($query);            
                }
                $jsonlayer[self::LAYOUTID]=$id;
                $response->appendBody(json_encode($jsonlayer));
         }
        mysql_close($con); 
        return $response;
        
    }

    public function putAction() {
        
    }    
}

?>
