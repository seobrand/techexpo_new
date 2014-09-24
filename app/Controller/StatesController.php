<?php 
/**************************************************************************
 Coder  : Pushkar Soni
 Object : Controller to handle admin role, add, edit and delete operation
**************************************************************************/ 
class RolesController extends AppController {
	var $name = 'States'; //Model name attached with this controller 
	var $helpers = array('Paginator'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	/*************************************************************************
	This function call by default when a controller is called 
	*************************************************************************/


	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}//end class
?>