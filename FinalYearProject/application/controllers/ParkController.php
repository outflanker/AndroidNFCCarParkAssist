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
class ParkController extends Zend_Rest_Controller {

    const SLOTID = 'SLOTID';
    const USER = 'USER';
    const TIMEIN = 'TIMEIN';
    const RATE = 'PARKINGRATE';
    const SLOTTYPE = 'SLOTTYPE';
    const LAYOUTNAME = 'LAYOUTNAME';
    const CITY = 'CITY';
    const AREA = 'AREA';
    const POSITION = 'POSITION';

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
            
                 $query1 = "SELECT L.LAYOUTNAME,L.CITY,L.AREA FROM SLOTS S,LAYOUT L WHERE L.LAYOUTID=S.LAYOUTID AND S.SLOTID='". $slotid ."'";
                          $res1 = mysql_query($query1);
            while ($row1 = mysql_fetch_array($res1)) {

                $lyoutname = $row1[self::LAYOUTNAME];
                
                $city = $row1[self::CITY];
                $area = $row1[self::AREA];

            }
            
                
                $slots[] = array(self::SLOTID => $slotid, self::USER => $user, self::TIMEIN => $timein, self::SLOTTYPE => $type,  self::LAYOUTNAME =>$lyoutname,  self::AREA=>$area,  self::CITY=>$city);
            
            }
            
            $jsonreturn['SLOTS'] = $slots;
            return $response->appendBody(json_encode($jsonreturn));
        }
        mysql_close($con);
    }

    public function headAction() {
        
    }

    public function indexAction() {
        $response = $this->getResponse();

        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);
            $query = "SELECT * FROM SLOTS";
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

    public function postAction() {
        
    }

    public function putAction() {
        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming, true);
        $slotid = $json[self::SLOTID];
        $user = $json[self::USER];

        $response = $this->getResponse();

        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);

            $query = "SELECT USER,SLOTTYPE FROM SLOTS WHERE SLOTID='" . $slotid . "'";
            $res = mysql_query($query);
            while ($row = mysql_fetch_array($res)) {
                $user_db = $row[self::USER];
                $slottype = $row[self::SLOTTYPE];
            }

//            print $user;
//            print $user_db;



            if ($user == "NOBODY" && $slottype == 2) {
                $query = "UPDATE SLOTS SET SLOTTYPE=1, USER='NOBODY' , TIMEIN='0000-00-00 00:00:00' WHERE SLOTID='" . $slotid . "'";
                $res = mysql_query($query);
                $jsonreturn['OUTPUT'] = "madevacant";
                $jsonreturn['FARE'] = -1;
            } else if ($slottype == 2 && (strcmp($user, $user_db) == 0)) {
                //unregister
                $totalfare = null;
                $jsonreturn = null;

                $query = "SELECT TIMEIN,PARKINGRATE FROM LAYOUT L,SLOTS S WHERE S.LAYOUTID=L.LAYOUTID AND S.SLOTID='" . $slotid . "'";
                $res = mysql_query($query);

                while ($row = mysql_fetch_array($res)) {
                    $timein = $row[self::TIMEIN];
                    $rate = $row[self::RATE];
                }

                $query = "SELECT TIMESTAMPDIFF(MINUTE,'" . $timein . "',NOW())";
                $res = mysql_query($query);
                while ($row = mysql_fetch_array($res)) {
                    $totaltime = $row[0];
                }

//                    print "rate is ---".$rate."    and timei is ---".$timein."---- and totaltime is ---".$totaltime."----";

                if ($totaltime < 1) {
                    //unregister unsuccessful due to time out less than 1 min from timein
                    $jsonreturn['OUTPUT'] = "timeerror";
                    $jsonreturn['FARE'] = -1;
                } else {

                    //unregister successful
                    $jsonreturn['OUTPUT'] = "unregistered";
                    $jsonreturn['FARE'] = $rate * $totaltime;
                    $query = "UPDATE SLOTS SET SLOTTYPE=1, USER='NOBODY' , TIMEIN='0000-00-00 00:00:00' WHERE SLOTID='" . $slotid . "'";
                    $res = mysql_query($query);
                }
            } else if ($slottype == 1 && (strcmp("NOBODY", $user_db) == 0)) {

                //register
                $jsonreturn['OUTPUT'] = "registered";
                $jsonreturn['FARE'] = -1;
                $query = "UPDATE SLOTS SET SLOTTYPE=2, USER='" . $user . "' , TIMEIN=NOW() WHERE SLOTID='" . $slotid . "'";
                $res = mysql_query($query);
            } else if ($slottype == 2 && (strcmp($user, $user_db) != 0 )) {
                //other user trying to register/un-register for a already registered slot

                $jsonreturn['OUTPUT'] = "usererror";
                $jsonreturn['FARE'] = -1;
            } else {
                //other error
                $jsonreturn['OUTPUT'] = "otherrerror";
                $jsonreturn['FARE'] = -1;
            }
            $response->appendBody(json_encode($jsonreturn));
            return $response;
        }
        mysql_close($con);
    }

}

?>
