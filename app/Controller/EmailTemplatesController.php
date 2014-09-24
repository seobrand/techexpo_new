<?php 
/**************************************************************************
 Coder  : Keshav Sharma 
 Object : Controller to handle Area of interests add, edit and delete operation
**************************************************************************/ 
class EmailTemplatesController extends AppController {
	var $name = 'EmailTemplates'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	/*********************************************************************
	This function call by default when a controller is called 
	Function will show list of all Email Template
	********************************************************************/
	public function superadmin_index() { 
		$this->set('meta_title','Email Templates');
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('EmailTemplate.title' => 'ASC'));
        $data = $this->paginate('EmailTemplate');
        //pr($data);
		$this->set('emailTemplate', $data);	
		
	}

	/*
	 * superadmin_add method
	 *
	 * @return void
	 */
	public function superadmin_add() {
		$errors ='';
		$this->set('meta_title','Add New Email Template');
		
		if($this->request->is('post')) {		
				$this->EmailTemplate->set($this->request->data);	
			
			if(!$this->EmailTemplate->validates()){		
				$errors = $this->EmailTemplate->validationErrors;                            
			}	
			if($errors) {			
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				if ($this->EmailTemplate->save($this->request->data)) {
					$this->Session->write('popup','EmailTemplate has been added successfully.');
					$this->Session->setFlash('EmailTemplate has been added successfully.');  
					$this->redirect(array('controller'=>'emailTemplates','action' => "index/message:success"));
				}else{
					$this->Session->setFlash('Data save problem, Please try again.');  
                }					
			}	
		}
            
	}

	
	/******************************************************************
	Function to update Email Template
	******************************************************************/
	/**
	 * superadmin_edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function superadmin_edit($ts_id = null) {
			$errors	=	'';
			
            $this->set('meta_title','Edit Email Template');
			$this->set('id',$ts_id);
			
			if ($this->request->is('get')) {
				$this->request->data = $this->EmailTemplate->find('first',array('conditions'=>array('id'=>$ts_id)));
			} else {
			
				$this->EmailTemplate->set($this->request->data);	
			
				if(!$this->EmailTemplate->validates()){		
					$errors = $this->EmailTemplate->validationErrors;                            
				}	
				
				if($errors) {			
					$this->Set('errors',$errors);
					$this->set('data',$this->request->data);
				}else{
					if ($this->EmailTemplate->save($this->request->data)) {
						$this->Session->write('popup','EmailTemplate has been updated successfully.');
						$this->Session->setFlash('EmailTemplate has been updated successfully.');  
						$this->redirect(array('controller'=>'emailTemplates','action' => "index/message:success"));
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'emailTemplates','action' => "edit",$ts_id));
					}
				}
				
			}
	}		 
	
	
	/* This function is used to call before  */
	function beforeFilter() { 
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		//$this->Auth->allow('login');
		//$this->Auth->loginAction = array('controller' => 'ethnicities', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'email_templates', 'action' => 'home','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
   	}
	
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}//end class
?>