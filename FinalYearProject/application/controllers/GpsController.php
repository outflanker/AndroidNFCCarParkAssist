<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GpsController
 *
 * @author nkbhat
 */
class GpsController extends Zend_Rest_Controller {

    const LAYOUTID = 'LAYOUTID';
    const LAYOUTNAME = 'LAYOUTNAME';
    const NUMLAYERS = 'NUMOFLAYERS';
    const CITY = 'CITY';
    const AREA = 'AREA';
    const LATITUDE = 'LATITUDE';
    const LONGITUDE = 'LONGITUDE';
    const RATE = 'PARKINGRATE';

    public function deleteAction() {
        
    }

    public function getAction() {


        
        $response = $this->getResponse();
        
        $my_lat = $this->_getParam('lat');
        $my_long = $this->_getParam('long');

        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);
            $query = "SELECT * FROM LAYOUT";
            $res = mysql_query($query);
            while ($row = mysql_fetch_array($res)) {
                $id = $row[self::LAYOUTID];
                $name = $row[self::LAYOUTNAME];
                $numlayers = $row[self::NUMLAYERS];
                $city = $row[self::CITY];
                $area = $row[self::AREA];
                $latitude = $row[self::LATITUDE];
                $longitude = $row[self::LONGITUDE];
                $rate = $row[self::RATE];

                $kms=0;
                //distance computation in kilometers between two points
                $theta = $my_long - $longitude;
                $dist = sin(deg2rad($my_lat)) * sin(deg2rad($latitude)) + cos(deg2rad($my_lat)) * cos(deg2rad($latitude)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                
                $kms = $miles * 1.609344;
                
            
            if ($kms <= 3.0) {
                $layouts[] = array(self::LAYOUTID => $id, self::LAYOUTNAME => $name, self::NUMLAYERS => $numlayers, self::CITY => $city,
                    self::AREA => $area, self::LATITUDE => $latitude, self::LONGITUDE => $longitude, self::RATE => $rate);
            }
        }
        $jsonreturn['LAYOUTS'] = $layouts;
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
