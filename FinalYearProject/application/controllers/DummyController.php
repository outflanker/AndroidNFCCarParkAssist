<?php

class DummyController extends Zend_Controller_Action
{

    public function init()
    {
	    print "Inside Init of Dummy Controller kaa bee";
		/* Initialize action controller here */
    }


    public function indexAction()
    {
        // action body
    }
	
	public function putAction()
	{	
		$incoming = file_get_contents("php://input");
        $json = json_decode($incoming,true);
        $password =  $json['password'];
        //$aws = AwsConnect::connectDynamoDB();
        
		$response=$this->getResponse();
		$response->setHttpResponseCode(400);
        $why["error"]="Could not find email";
        $why["code"]="27";
		$why["password"]=$password."nitin";
        return $response->setBody(json_encode($why));
	}
}
