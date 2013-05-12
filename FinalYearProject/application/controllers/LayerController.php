<?php

class LayerController extends Zend_Rest_Controller {

    const LAYERID = 'LAYERID';
    const LAYOUTID = 'LAYOUTID';
    const LAYOUTSIZE = 'LAYOUTSIZE';

    public function deleteAction() {
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming, true);
        $layerid = $json[self::LAYERID];
        $layoutid = $json[self::LAYOUTID];
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);
            $query = "DELETE FROM LAYER WHERE LAYOUTID='" . $layoutid . "' AND LAYERID='" . $layerid . "'";
            $res = mysql_query($query);
            
            $query = "UPDATE LAYOUT SET NUMOFLAYERS = NUMOFLAYERS - 1 WHERE LAYOUTID='" . $layoutid ."'";
            $res = mysql_query($query);
        }
        mysql_close($con);
    }

    public function getAction() {
        $response = $this->getResponse();
        $layerid = $this->_getParam('layerid');
        $layoutid = $this->_getParam('layoutid');

        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) 
        {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } 
        else 
        {
            mysql_select_db(parent::DATABASE, $con);
            if($layerid==NULL)
            {
               $query = "SELECT * FROM LAYER WHERE LAYOUTID='" . $layoutid . "'";
            }
            else
            {
                $query = "SELECT * FROM LAYER WHERE LAYOUTID='" . $layoutid . "' AND LAYERID='" . $layerid . "'";
            }
            $res = mysql_query($query);
            while ($row = mysql_fetch_array($res)) {
                $lyerid = $row[self::LAYERID];
                $lyoutid = $row[self::LAYOUTID];
                $size = $row[self::LAYOUTSIZE];
                $layers[] = array(self::LAYERID => $lyerid, self::LAYOUTID => $lyoutid, self::LAYOUTSIZE => $size);
            }
            $jsonreturn['LAYERS'] = $layers;
            return $response->appendBody(json_encode($jsonreturn));
        }
        mysql_close($con);
    }

    public function headAction() {
        
    }

    public function indexAction() {
        $response = $this->getResponse();
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming, true);
        $lyout = $json[self::LAYOUTID];
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);
            $query = "SELECT * FROM LAYER WHERE LAYOUTID=" . $lyout . "";
            $res = mysql_query($query);
            while ($row = mysql_fetch_array($res)) {
                $lyerid = $row[self::LAYERID];
                $lyoutid = $row[self::LAYOUTID];
                $size = $row[self::LAYOUTSIZE];
                $layers[] = array(self::LAYERID => $lyerid, self::LAYOUTID => $lyoutid, self::LAYOUTSIZE => $size);
            }
            $jsonreturn['LAYERS'] = $layers;
            return $response->appendBody(json_encode($jsonreturn));
        }
        mysql_close($con);
    }

    public function postAction() {
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming, true);
        $lyerid = $json[self::LAYERID];
        $lyout = $json[self::LAYOUTID];
        $lysize = $json[self::LAYOUTSIZE];
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);
            $query = "UPDATE LAYER SET LAYOUTSIZE=" . $lysize . " WHERE LAYERID=" . $lyerid . " AND LAYOUTID='" . $lyout . "'";
            $res = mysql_query($query);
            
            $query = "DELETE FROM SLOTS WHERE LAYERID=".$lyerid;
            $res= mysql_query($query);
            
            $n = $lysize % 10;
            $m = ($lysize - $n) / 10;

            for ($i = 1; $i <= $m; $i++) {
                for ($j = 1; $j <= $n; $j++) {
                    $appendid = ($i * 10) + $j;
                    $sid = $lyout . "." . $lyerid . "." . $appendid;
//                    $rate = 100.0;
                    $usr = "";
                    $query = "INSERT INTO SLOTS VALUES ('" . $sid . "'," . $lyerid . ",'" . $lyout . "'," . $appendid . ",'" . $usr . "','0000-00-00 00:00:00',0)";
                    $res = mysql_query($query);
                }
            }
            
                    
        }
        mysql_close($con);
    }

    public function putAction() {
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming, true);
        $lyerid = $json[self::LAYERID];
        $lyout = $json[self::LAYOUTID];
        $lysize = $json[self::LAYOUTSIZE];
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);
            $query = "UPDATE LAYER SET LAYOUTSIZE=" . $lysize . " WHERE LAYERID=" . $lyerid . " AND LAYOUTID='" . $lyout . "'";
            $res = mysql_query($query);

            $n = $lysize % 10;
            $m = ($lysize - $n) / 10;

            for ($i = 1; $i <= $m; $i++) {
                for ($j = 1; $j <= $n; $j++) {
                    $appendid = ($i * 10) + $j;
                    $sid = $lyout . "." . $lyerid . "." . $appendid;
//                    $rate = 100.0;
                    $usr = "";
                    $query = "INSERT INTO SLOTS VALUES ('" . $sid . "'," . $lyerid . ",'" . $lyout . "'," . $appendid . ",'" . $usr . "','0000-00-00 00:00:00',0)";
                    $res = mysql_query($query);
                }
            }
        }
        mysql_close($con);
    }
}
?>
