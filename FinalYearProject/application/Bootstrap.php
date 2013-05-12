<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
        protected function _initRestRoute()
        {
            $this->bootstrap('frontController');
			$frontController = Zend_Controller_Front::getInstance();
			$restRoute = new Zend_Rest_Route($frontController,array(), array('default'=>array('Dummy','Layer','Layout','Slot','User','Park','Unregister','Gps','Booked','Addlayer')));
			$frontController->getRouter()->addRoute('default', $restRoute);
        }
}
