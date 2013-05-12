<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newLayer
 *
 * @author nkbhat
 */
class AddlayerController extends Zend_Rest_Controller {
    //put your code here

    const LAYOUTID = 'LAYOUTID';
    const LAYERID = 'LAYERID';

    public function deleteAction() {
        
    }

    public function getAction() {
        
    }

    public function headAction() {
        
    }

    public function indexAction() {
        
    }

    public function postAction() {
        
    }

    public function putAction() {

        //add a new layer to an existing layout 


        $response = $this->getResponse();

        $incoming = file_get_contents(parent::PHPINPUT);
        $json = json_decode($incoming, true);


        $layoutid = $json[self::LAYOUTID];



        $con = mysql_connect(parent::DBSERVER, parent::DBUSER, parent::DBPWD);
        if (!$con) {
            print "Error";
            die('Could not connect: ' . mysql_error());
        } else {
            mysql_select_db(parent::DATABASE, $con);
            $$query = "UPDATE LAYOUT SET NUMOFLAYERS = NUMOFLAYERS + 1 WHERE LAYOUTID='" . $layoutid . "'";
            $res = mysql_query($query);

            $query = "SELECT MAX(LAYERID) AS LAYERID FROM LAYER WHERE LAYOUTID='" . $layoutid . "'";
            $res = mysql_query($query);

            if ($res != NULL) {
                $row = mysql_fetch_array($res);
                $max_layerid = $row[self::LAYERID] + 1;
            } else {
                $max_layerid = 0;
            }
            $size = 0;
            $query = "INSERT INTO LAYER VALUES ('" . $max_layerid . "','" . $layoutid . "','" . $size . "')";
            $res = mysql_query($query);

            $jsonlayer[self::LAYERID] = $max_layerid;
            $response->appendBody(json_encode($jsonlayer));

            mysql_close($con);
            return $response;
        }
    }

}

?>
