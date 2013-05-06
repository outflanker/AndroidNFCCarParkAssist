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
class UnregisterController extends Zend_Rest_Controller {

    const SLOTID = 'SLOTID';
    const USER = 'USER';
    const TIMEIN = 'TIMEIN';
    const RATE = 'RATE';
    const SLOTTYPE = 'SLOTTYPE';

    public function deleteAction() {
        
    }

    public function getAction() {
        $response = $this->getResponse();
        $slotid = $this->_getParam('slotid');
        $userid = $this->_getParam('userid');
        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);
            if ($slotid != NULL) {
                $query = "SELECT * FROM SLOTS WHERE SLOTID='" . $slotid . "'";
            } else if ($userid != NULL) {
                $query = "SELECT * FROM SLOTS WHERE USER='" . $userid . "'";
            }
            $res = mysql_query($query);
            while ($row = mysql_fetch_array($res)) {
                $slotid = $row[self::SLOTID];
                $user = $row[self::USER];
                $timein = $row[self::TIMEIN];
                $type = $row[self::SLOTTYPE];
                $slots[] = array(self::SLOTID => $slotid, self::USER => $user, self::TIMEIN => $timein, self::SLOTTYPE => $type);
            }
            $jsonreturn['SLOTS'] = $slots;
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
        $response = $this->getResponse();

        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming, true);
        $slotid = $json[self::SLOTID];

        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);
            $totalfare = null;
            $jsonreturn = null;

            $query = "SELECT TIMEIN FROM SLOTS WHERE SLOTID='" . $slotid . "'";
            $ratequery = "SELECT PARKINGRATE FROM LAYOUT L,SLOTS S WHERE S.LAYOUTID=L.LAYOUTID";

            $res = mysql_query($query);
            $res2 = mysql_query($ratequery);

            while ($row = mysql_fetch_array($res)) {
                $timein = $row[self::TIMEIN];
            }
            while ($row = mysql_fetch_array($res2)) {
                $rate = $row[self::RATE];
            }

            $query = "SELECT TIMESTAMPDIFF(MINUTE,'" . $timein . "',NOW())";
            $res = mysql_query($query);
            while ($row = mysql_fetch_array($res)) {
                $totaltime = $row[0];
            }

            if ($totaltime < 5) {
                $jsonreturn['OUTPUT'] = "error";
                $jsonreturn['FARE'] = -1;
            } else {
                $jsonreturn['OUTPUT'] = "computed";
                $jsonreturn['FARE'] = $rate * $totaltime;
                   $query = "UPDATE SLOTS SET SLOTTYPE=1, USER='NOBODY' , TIMEIN='0000-00-00 00:00:00' WHERE SLOTID='" . $slotid . "'";
                $res = mysql_query($query);
            }
            $response->appendBody(json_encode($jsonreturn));


            return $response;
        }
        mysql_close($con);
    }

}

?>