<?php
/**************************************************************************
 Coder  : Jitendra Pradhan  
 Object : Controller to registration process of client
**************************************************************************/ 

class MarketingsController extends AppController {
	var $name = 'Marketings'; /*Model name attached with this controller*/ 
	var $layout = 'admin'; /*this is the layout for front panel*/ 
	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array('TrackingPage','Banner');
	
	/****function for creating new organization tracking page from admin ***/
	public function superadmin_index(){
			$this->set('meta_title','All Tracking Pages');
			
			$argArr = array();
			if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
				$this->Session->write('per_page_record',$this->params['pass'][0]);
			}
			
			$this->set('argArr', $argArr);
			$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
			
			$this->paginate = array('limit' =>$record,'order' => array('TrackingPage.organization' => 'ASC'));
        	$data = $this->paginate('TrackingPage');
			$this->set('data',$data);
		
	}
	
	/****function for creating new organization tracking page from admin ***/
	public function superadmin_createtrackingpage() {
			$this->set('meta_title','Create Tracking Page');
			$errorsArr ='';
			
			if($this->request->is('post')){
					$this->TrackingPage->set($this->request->data);
					if(!$this->TrackingPage->validates()){
						$errorsArr = $this->TrackingPage->validationErrors;
					}
					
					if($errorsArr){
						$this->set("errors",$errorsArr);
						$this->set("data",$this->request->data);
					}
					
					if(!$errorsArr){
						$this->TrackingPage->save($this->request->data);
						/* This should be uncomment later */
						$email = new CakeEmail('smtp');
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
						$subject = "TECHEXPO TrackingPage information";
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$bodyText = 'Dear Client,<br/><br/>Your special tracking page has been created successfully by admin on www.TechExpoUSA.com.<br/><br/>
						Your tracking page URL is as following:<br/>http://www.techexpoUSA.com/index_'.$this->request->data['TrackingPage']['page_name'].'. <br/><br/>
						If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225.  <br/><br/>
						Sincerely, <br/>
						Nancy Mathew<br/>
						Events Director<br/>
						212.655.4505 ext. 225';
						
						if(Validation::email($this->request->data['TrackingPage']['contact_email'])){
							$email->to($this->request->data['TrackingPage']['contact_email']);
							$email->send($bodyText);
						}
						
						$this->Session->write('popup','A new partner tracking page successfully created.');
						$this->Session->setFlash('A new partner tracking page successfully created.');  
						$this->redirect(array('controller'=>'marketings','action' => "index/message:success"));
					}
			}
	}
	
	/****function for UPdating organization tracking page from admin ***/
	public function superadmin_edittrackingpage($page_id=null) {
			$this->set('meta_title','Update Tracking Page');
			$errorsArr ='';
			if($this->request->is('get')){
				$this->request->data = $this->TrackingPage->find("first",array('conditions'=>array('page_id'=>$page_id)));
				$this->request->data['TrackingPage']['curr_page'] = $this->request->data['TrackingPage']['page_name'];
			}
			if($this->request->is('post')){
					$this->TrackingPage->set($this->request->data);
					if(!$this->TrackingPage->validates()){
						$errorsArr = $this->TrackingPage->validationErrors;
					}
					
					if($errorsArr){
						$this->set("errors",$errorsArr);
						$this->set("data",$this->request->data);
					}
					
					if(!$errorsArr){
				
						$this->TrackingPage->save($this->request->data);
						// send email to contact email
						/* This should be uncomment later*/
						$email = new CakeEmail('smtp');
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
						$subject = "TECHEXPO TrackingPage information";
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$bodyText = 'Dear Client,<br/><br/>
						Your special tracking page has been created successfully by admin on www.TechExpoUSA.com.<br/><br/>
						Your tracking page url is as following:<br/>
						http://www.techexpoUSA.com/index_'.$this->request->data['TrackingPage']['page_name'].'. <br/><br/>
						If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225.  <br/><br/>
						Sincerely, <br/>
						Nancy Mathew<br/>
						Events Director<br/>
						212.655.4505 ext. 225';
						if(Validation::email($this->request->data['TrackingPage']['contact_email'])){
							$email->to($this->request->data['TrackingPage']['contact_email']);
							$email->send($bodyText);
						}
						
						$this->Session->write('popup','A new partner tracking page successfully updated.');
						$this->Session->setFlash('A new partner tracking page successfully updated.');  
						$this->redirect(array('controller'=>'marketings','action' => "index/message:success"));
					}
			}
			
	}
	
	/***** Function for delete partner *********/
	public function superadmin_deletepartner($page_id=null){
			$this->TrackingPage->delete($page_id);			
			$this->Session->write('popup','Partner tracking page successfully deleted.');
			$this->Session->setFlash('Partner tracking page successfully deleted.');  
			$this->redirect(array('controller'=>'marketings','action' => "partnertracking/message:success"));
	}
	
	/********* Function for serach resume database **********/
	public function superadmin_searchresumedb(){
			$this->set('meta_title',' Search Resume Database');
			
			
	
	}
	
	function beforeFilter() { 
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
			
        if($this->Session->check('Auth.User.Adminuser.id'))
		{
			$this->Auth->allow('*');
		}else
		{
			//$this->Auth->allow('superadmin_deletetrialaccount');
		}
        
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
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