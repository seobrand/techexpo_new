<?php 
/******************************************************************************************
 Coder  : Jitendra Pradhan 
 Object : Controller to handle News operations - view , add, edit and delete
******************************************************************************************/ 

App::uses('CakeEmail', 'Network/Email');

class NewslettersController extends AppController {

	var $name = 'Newsletters'; //Model name attached with this controller 
    var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array('NewsletterSubscriber','Newsletter','Show','ShowEmployer','ShowInterview','ShowCompanyProfile','EmployerContact','ResumeSetRule','ResumeSet','EmployerSet','Code','User','JobPosting','Folder','JobScore','ResumeScore','CustomEmployerSet','EmployerStat','EmployerLastVisit','ResumeAccessStat','OfccpTracking','Candidate','TrialAccount','TrialAccountTrack','EmployerEmailMessage');

	var $layout = 'admin'; //this is the layout for front panel 
	
	 /******************Function to create new profile***************************/
	
	/**
	 * Function to show newsletter list
	 * created on Jun 17,2014 (task id 4543)
	 * created By Jitendra
	 */
	public function superadmin_list() {
		$this->set('meta_title','Newsletter Lists');
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
	
		$this->set('argArr', $argArr);
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		$record = 500;
	
		$this->paginate = array('limit'=>$record,'order' => array('id' => 'DESC'));
		$data = $this->paginate('Newsletter');
		//pr($data);
		$this->set('newsletters', $data);
	
	}
	
	/**
	 * Function to add/edit newsletter list
	 * @param id (newsletter id) 
	 * created on Jun 17,2014 (task id 4543)
	 * created By Jitendra
	 */
	public function superadmin_manage($id = null) {
		$this->set('meta_title','Manage Newsletter');
		if($id!=NULL){
			$newsletter = $this->Newsletter->find('first',array('conditions'=>array('Newsletter.id' => $id)));
			$this->set('newsletter',$newsletter);
		}
		if($this->request->is('post')){			
			$this->Newsletter->save($this->request->data['Newsletter']);
			
			$this->Session->write('popup','Newsletter has been successfully saved.');
			$this->Session->setFlash('Newsletter has been successfully saved.');
			$this->redirect(array('controller'=>'newsletters','action' => "list/message:success"));
		}			
		$this->set('id',$id);	
	}
	
	public function superadmin_index() { 
		$this->set('meta_title','Newsletter Subscribers');
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit'=>$record,'order' => array('subscriber_email' => 'ASC'));
        $data = $this->paginate('NewsletterSubscriber');
        //pr($data);
		$this->set('subscriber', $data);	
		
	}
	
	/**** function to send newsletter emails *****/
	function superadmin_sendnewsletter($id=null){
		$this->set('id',$id);
		
		if($id!='' && $id!='all'){
			$user = $this->NewsletterSubscriber->find('first',array('conditions'=>array('NewsletterSubscriber.id' => $id)));
			$this->set('email_id',$user['NewsletterSubscriber']['subscriber_email']);
		}
		
		if($this->request->is('post')){
			//pr($this->request->data);die;
			$subject = $this->request->data['Newsletter']['subject'];
			$message = $this->request->data['Newsletter']['message'];
		
			if($id=='all'){
				$user = $this->NewsletterSubscriber->find('all');
				foreach($user as $user){
					$email = new CakeEmail('smtp');
					$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
					$subject = $subject;
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					$bodyText = $message;
					$sendTo = $user['NewsletterSubscriber']['subscriber_email'];
					if(Validation::email($sendTo)){
						$email->to($sendTo);
						$email->send($bodyText);
					}
				}
			}elseif($id!='' && $id!='all'){
				$sendTo = $this->request->data['Newsletter']['sendemail'];
				$email = new CakeEmail('smtp');
				$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				$subject = $subject;
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				$bodyText = $message;
				if(Validation::email($sendTo)){
					$email->to($sendTo);
					$email->send($bodyText);
				}
			}
			
			$this->Session->write('popup','Newsletter has been successfully send.');
			$this->Session->setFlash('Newsletter has been successfully send.');  
			$this->redirect(array('controller'=>'newsletters','action' => "index/message:success")); 
			
		}

	}
	
	/**** function to unsubscribe emails *****/
	function superadmin_unsubscribe($id=null){
		if($id=='all'){
			$this->NewsletterSubscriber->deleteAll(array('1 = 1'));
		}elseif($id!=''){
			$this->NewsletterSubscriber->deleteAll(array('NewsletterSubscriber.id' => $id), false);
		}
	
		$this->Session->write('popup','Newsletter Subscriber has been unsubscribe successfully.');
		$this->Session->setFlash('Newsletter Subscriber has been unsubscribe successfully.');  
		$this->redirect(array('controller'=>'newsletters','action' => "index/message:success")); 
		
	}
	function superadmin_exportall() {
	
		$this->autoRender = false;
     	
		$results = $this->NewsletterSubscriber->find('all');	
		
		
		ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
		
		//create a file
		$filename = "Email_list_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');


	// The column headings of your .csv file
		$header_row = array("Subscriber Email");
		fputcsv($csv_file,$header_row,',','"');
	
	// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
	foreach($results as $result)
	{ // Array indexes correspond to the field names in your db table(s)
		$row = array(
			
			$result['NewsletterSubscriber']['subscriber_email'],
				
		);
		
		fputcsv($csv_file,$row,',','"');
	}
	
	fclose($csv_file);die;


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