<?php
class DummyController extends Zend_Rest_Controller
{

    public function init()
    {
	    print "Inside Init of Dummy Controller kaa beenneer";
		/* Initialize action controller here */
    }
	
	public function putAction()
	{	
		$incoming = file_get_contents("php://input");
        $json = json_decode($incoming,true);
        $password =  $json['password'];
        //$aws = AwsConnect::connectDynamoDB();
        
	$response=$this->getResponse();
	$response->setHttpResponseCode(400);
        //$why["error"]="Could not find email";
        //$why["code"]="27";
	$why=$password."nitin";
        return $response->setBody(json_encode($why));
    }
	
    public function headAction() 
    {
        
    }

    public function indexAction() 
    {
        
    }

    public function postAction() 
    {
        
    }
    
    public function getAction()
    {
    }

    public function deleteAction() {
        
    }
	 
}