<?php
class DummyController extends Zend_Rest_Controller
{

    public function init()
    {
//        $this->_helper->viewRenderer->setNoRender(true);
	    print "Inside Init of Dummy Controller kaa beenneer\n";
		/* Initialize action controller here */
    }
	
    public function putAction()
    {	
        print "\n------->PUTACTION<-------\n";
//        $this->getResponse()
//            ->appendBody("From postAction() returning the requested article");
//        print "aa\n";
        $incoming = file_get_contents("php://input");
        $json = json_decode($incoming,true);
        $password =  $json['email'];
        print $password."\n";
	$response=$this->getResponse();
        $response->appendBody("From postAction() returning the requested article");
//	$response->setHttpResponseCode(400);
        $why["error"]="Could not find email";
        $why["code"]="27";
//	$why=$password."nitin";
        return $response->appendBody(json_encode($why));
    }
	
    public function headAction() 
    {
        print "\n------->HEADACTION<-------\n";
        
    }

    public function indexAction() 
    {
        print "\n------->INDEXACTION<-------\n";
    }

    public function postAction() 
    {
        print "\n------->POSTACTION<-------\n";
         $incoming = file_get_contents("php://input");
        $json = json_decode($incoming,true);
        $password =  $json['email'];
        print $password."\n";
	$response=$this->getResponse();
        $response->appendBody("From postAction() returning the requested article");
//	$response->setHttpResponseCode(400);
        $why["error"]="Could not find email";
        $why["code"]="27";
//	$why=$password."nitin";
        return $response->appendBody(json_encode($why));
        
    }
    
    public function getAction()
    {
        print "\n------->GETACTION<-------\n";
        $password = $this->_getParam ('id');
        print $password."a\n";
	$response=$this->getResponse();
        $response->appendBody("From postAction() returning the requested article");
//	$response->setHttpResponseCode(400);
        $why["error"]="Could not find email";
        $why["code"]="27";
//	$why=$password."nitin";
        return $response->appendBody(json_encode($why));
    }

    public function deleteAction()
    {
        print "\n------->DELETEACTION<-------\n";
        $incoming = file_get_contents("php://input");
        $json = json_decode($incoming,true);
        $password =  $json['email'];
        print $password."\n";
	$response=$this->getResponse();
        $response->appendBody("From postAction() returning the requested article");
//	$response->setHttpResponseCode(400);
        $why["error"]="Could not find email";
        $why["code"]="27";
//	$why=$password."nitin";
        return $response->appendBody(json_encode($why));
    }
	 
}
?>