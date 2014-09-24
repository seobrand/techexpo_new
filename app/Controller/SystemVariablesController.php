<?php 
/**************************************************************************
 Coder  : Apurav Gaur
 Object : Controller to handle admin role, add, edit and delete operation
**************************************************************************/ 
class SystemVariablesController extends AppController {
	var $name = 'SystemVariables'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler','Common');  //add some other component to controller . this component file is exists in app/controllers/components
	var $uses = array('SystemVariable');
	
	var $layout = 'admin'; //this is the layout for admin panel 
	/*************************************************************************
	This function call by default when a controller is called 
	*************************************************************************/

	// use to manage chat history	
	public function superadmin_index() {
        $this->set('meta_title','System Variables');
        $var_data = array();
        
        $system_variable = $this->SystemVariable->find('all');
        $this->set('system_variable',$system_variable);
		 
		if($this->request->is('post')){	
			foreach($this->request->data['SystemVariable']['variables'] as $var_id => $var_value){
				$var_data['SystemVariable']['id'] =  $var_id;
				$var_data['SystemVariable']['variable_value'] =  $var_value;
				$this->SystemVariable->save($var_data);
			}
			
		  $this->Session->write('popup','Variables has been updated successfully.');
		  $this->Session->setFlash('Variables has been updated successfully.');  
		  $this->redirect(array('controller'=>'system_variables','action' => "index/message:success"));
			
		}
	}
	
		
		
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeFilter(){
	  
		parent::beforeFilter();
//		$this->Auth->allow('send_message','load_messages','load_users','enteruser');
		
	} 
	
	
}//end class
?>