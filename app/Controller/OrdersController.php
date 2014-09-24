<?php
/******************************************************************************************
 Coder  : Jitendra Pradhan 
 Object : Controller to handle News operations - view , add, edit and delete
******************************************************************************************/ 

 App::uses('CakeEmail', 'Network/Email');

class OrdersController extends AppController {
    var $name = 'Orders'; //Model name attached with this controller 
    var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array("Jobplan","JobplanHistory","Employer");
	var $layout = 'admin'; //this is the layout for front panel 

	/**
	 * superadmin_index method
	 *
	 * @return void
	 */
	public function superadmin_index() { 
		$this->set('meta_title','Order Manager');
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('subscriber_email' => 'ASC'));
        $data = $this->paginate('Jobplan');
        //pr($data);
		$this->set('jobplans', $data);	
	}
	
	/**
	 * superadmin_add method
	 *
	 * @return void
	 */
	public function superadmin_add(){
		$errors ='';
		$this->set('meta_title','Add Job Plan');
		//get employer list
		$employer = $this->Employer->Find('list',array('fields'=>array('id','employer_name'),'order'=>array('employer_name ASC')));
		$this->set('employer',$employer);

		if($this->request->is('post')) {		
			$this->Jobplan->set($this->request->data);	
			if(!$this->Jobplan->validates()){		
				$errors = $this->Jobplan->validationErrors;                            
			}	
			if($errors) {			
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				$available_for = $this->request->data['Jobplan']['available_for'];
				if(is_array($available_for)){
					if(in_array('all', $available_for)){
						$this->request->data['Jobplan']['available_for'] = 'all';
					}else{
						$this->request->data['Jobplan']['available_for'] = implode(",", $available_for);
					}
				}else{
					$this->request->data['Jobplan']['available_for'] = 'all';
				}
				
				if ($this->Jobplan->save($this->request->data)) {
					$this->Session->write('popup','Job Plan has been added successfully.');
					$this->Session->setFlash('Job Plan has been added successfully.');  
					$this->redirect(array('controller'=>'orders','action' => "index/message:success"));
				}else{
					$this->Session->setFlash('Data save problem, Please try again.');  
                }			
			}	
		}
            
	}	
	
	/**
	 * superadmin_edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function superadmin_edit($id = null){
		$errors ='';
		$this->set('meta_title','Edit Job Plan');
		$this->set('id',$id);
		//get employer list
		$employer = $this->Employer->Find('list',array('fields'=>array('Employer.id','Employer.employer_name'),'order'=>array('Employer.employer_name ASC')));
		$this->set('employer',$employer);
		
		if($this->request->is('get')){
			$this->request->data = $this->Jobplan->find('first',array('conditions'=>array('id'=>$id)));
			// get selected employer
			$this->request->data['Jobplan']['available_for'] = explode(",", $this->request->data['Jobplan']['available_for']);
			
		}elseif($this->request->is('post')) {
			$this->Jobplan->set($this->request->data);	
			if(!$this->Jobplan->validates()){		
				$errors = $this->Jobplan->validationErrors;                            
			}	
			if($errors) {			
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				$available_for = $this->request->data['Jobplan']['available_for'];
				if(is_array($available_for)){
					if(in_array('all', $available_for)){
						$this->request->data['Jobplan']['available_for'] = 'all';
					}else{
						$this->request->data['Jobplan']['available_for'] = implode(",", $available_for);
					}
				}else{
					$this->request->data['Jobplan']['available_for'] = 'all';
				}
				
				if ($this->Jobplan->save($this->request->data)){
					$this->Session->write('popup','Job Plan has been updated successfully.');
					$this->Session->setFlash('Job Plan has been updated successfully.');  
					$this->redirect(array('controller'=>'orders','action' => "index/message:success"));
				}else{
					$this->Session->setFlash('Data save problem, Please try again.');  
                }			
			}	
		}
            
	}	
	
	/**
	 * superadmin_delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function superadmin_delete($id = null) {		
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}else{
			if ($this->Jobplan->delete($id)) {
				$this->Session->write('popup','Job plan has been deleted successfully.');
				$this->Session->setFlash('Job plan has been deleted successfully.');  
				$this->redirect(array('controller'=>'orders','action' => "index/message:success")); 
			} else {
				$this->Session->setFlash('Deletion problem, Please try again.');  
				$this->redirect(array('controller'=>'orders','action' => "index"));
			}
		}	
	}
	
	/**
	 * superadmin_viewhistory method
	 *
	 * @param string $id
	 * @return void
	 */
	public function superadmin_viewhistory() {
		$this->set('meta_title','View Job Plan History');
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('order' => array('order_date' => 'DESC'));
        $data = $this->paginate('JobplanHistory');
        //pr($data);
		$this->set('jobplanhistory', $data);	
	}
	
	/**
	 * superadmin_delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function superadmin_deletehistory($id = null) {		
		if ($this->JobplanHistory->delete($id)) {
			$this->Session->write('popup','Job plan history has been deleted successfully.');
			$this->Session->setFlash('Job plan history has been deleted successfully.');  
			$this->redirect(array('controller'=>'orders','action' => "viewhistory/message:success")); 
		} else {
			$this->Session->setFlash('Deletion problem, Please try again.');  
			$this->redirect(array('controller'=>'orders','action' => "viewhistory"));
		}
	}
	
	public function superadmin_deleteAllHistory($id = null) {		
		if($id=='all'){
			$this->JobplanHistory->deleteAll(array('1 = 1'));
			$this->Session->write('popup','Orders history has been deleted successfully.');
			$this->Session->setFlash('Orders history has been deleted successfully.');  
			$this->redirect(array('controller'=>'orders','action' => "viewhistory/message:success")); 
		}
	}
	/* This function is checking username and pasword in database and if true then redirect to home page */
	function beforeFilter() { 
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
        );
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		$this->Auth->allow('login','index');
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','superadmin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'trainingschools', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminclient.active' => 'yes');
   	}
	
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	}    

}