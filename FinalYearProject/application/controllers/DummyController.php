<?php

class DummyController extends Zend_Controller_Action
{

    public function init()
    {
	    print "Inside Init of Dummy Controller";
		/* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
	
	public function getAction()
	{
		$response = $this->getResponse();
        //$uuid = $this->_getParam ('id');
        //$password = $this->_getParam('password');
        $incoming = file_get_contents("php://input");
        $json = json_decode($incoming,true);
        $password =  $json['password'];
        //$aws = AwsConnect::connectDynamoDB();
        
		$response->setHttpResponseCode(400);
        $why["error"]="Could not find email";
        $why["code"]="27";
		$why["password"]=$password."nitin";
        return $response->setBody(json_encode($why));
	}
}
