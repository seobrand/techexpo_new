<?php 
/**************************************************************************
 Coder  : Apurav Gaur  
 Object : Controller to handle admin login, add, edit and delete operation
**************************************************************************/ 
class AdminusersController extends AppController {
	var $name = 'Adminusers'; //Model name attached with this controller 
	var $helpers = array('Paginator'); //add some other helpers to controller
	public $components = array('Auth','common','Session','Cookie','Email');  //add some other component to controller . this component file is exists in app/controllers/components
	var $uses = array('EmployerContact','JobPosting','Adminuser','Candidate');
	var $layout = 'admin'; //this is the layout for admin panel 
	/*************************************************************************
	This function call by default when a controller is called 
	*************************************************************************/
	function index() {
	
	
		if($this->Session->check('Auth.Adminusers')){
			$this->redirect(array('controller'=>'adminusers','action' => "home"));
		}
		else {
			$this->Session->setFlash(__d('adminuser','You are not authorized to access this location.',true));
			$this->redirect(array('controller'=>'adminusers','action' => "login"));
		}
	}	
	/*********************************************************************
	This function call by default when a controller is called 
	Function will show list of all admin users
	********************************************************************/
	function superadmin_index() {
	
	if($this->request->url == 'superadmin') 
	{
		if($this->Session->read('param_search')) 
			{
				$this->Session->delete('param_search');
			}
		if($this->Session->read('data_search')) 
			{
				$this->Session->delete('data_search');
			}
	}	
	
		$this->set('meta_title','Admin users');
		$search = '';
		$act  = '';
		$active = '';
		$argArr = array();
		$cond = '';		
	if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
		$this->Session->write('per_page_record',$this->params['pass'][0]);
	}		
		/* Search conditon for  text value   */
		
		
		if(!empty($this->request->data)) {
			$search = $this->request->data['Adminuser']['search'];
			$act = $this->request->data['Adminuser']['act'];
			$this->Session->write('data_search',$this->data['Adminuser']);
				if($this->Session->read('param_search')) {
					$this->Session->delete('param_search');
				}			
		}
		else if(isset($this->params['named']['search']) && $this->params['named']['search']) {
			 $search = $this->params['named']['search'];
			 $act =  $this->params['named']['act'];
			 $this->Session->write('param_search',$this->params['named']);
				 if($this->Session->read('data_search')) {
					$this->Session->delete('data_search');
				}				 
		}
		else if($this->Session->read('data_search')) {
			$search = $this->Session->read('data_search.search');
			$act =  $this->Session->read('data_search.act');
				if($this->Session->read('param_search')) {
					$this->Session->delete('param_search');
				}		
		}
		else if($this->Session->read('param_search')) {
			$search = $this->Session->read('param_search.search');
			$act =  $this->Session->read('param_search.act');
				 if($this->Session->read('data_search')) {
					$this->Session->delete('data_search');
				}		
		}		
		
		if($search) {
			$argArr['search'] = $search;
			$argArr['act'] = $act;
		    switch($search) {
		    	case 'name' : 
			  		$cond[]  = array('OR'=>array('Adminuser.first_name LIKE'=>'%'.$search.'%','Adminuser.last_name LIKE'=>'%'.$search.'%'));
			     	break;
			  	case 'email' : 
			  	 	$cond[]  = array('Adminuser.email LIKE'=>'%'.$search.'%');
			     	break;	
			  	case 'role' : 
			  	 	$cond[]  = array('Role.role_name LIKE'=>'%'.$search.'%');
			     	break;		  
			  	default :	 
		     		$cond[]  = array('OR'=>array('Adminuser.first_name LIKE'=>'%'.$search.'%','Adminuser.last_name LIKE'=>'%'.$search.'%','Adminuser.username LIKE'=>'%'.$search.'%','Adminuser.email LIKE'=>'%'.$search.'%','Role.role_name LIKE'=>'%'.$search.'%'));
			 }
		}
		
		$this->set('search', $search); 
		$this->set('active', $active); 
		$this->set('act', $act); 
		$this->set('argArr', $argArr);
		/* End Search conditon for  text value   */
		/* Search conditon for  Active  status */
		if(isset($this->data['Adminuser']['active']) && $this->data['Adminuser']['active']) {
			$active = $this->data['Adminuser']['active'];
		}
		else if(isset($this->params['named']['active']) && $this->params['named']['active']) {
			$active = $this->params['named']['active'];
		}
		else {
			$active = ($this->Session->read('data_search.active')) ? $this->Session->read('data_search.active') : $this->Session->read('param_search.active');
		}		
		if($active) {
		   	$this->set('active',$active);
		    $cond[]  = array('Adminuser.active'=>$active);
		}
	
		//all active and inactive records for paging.
		$active_record = $this->Adminuser->find('count',array('conditions'=>array('Adminuser.active'=>'yes',$cond)));
		$inactive_record = $this->Adminuser->find('count',array('conditions'=>array('Adminuser.active'=>'no',$cond)));
		$this->set('active_record',$active_record);
		$this->set('inactive_record',$inactive_record);			
		/* End Search conditon for  Active  status */
		$condition = $cond;
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;		
		$this->paginate = array('limit' => $record,'order' => array('Adminuser.first_name'=>'ASC'));
		$data = $this->paginate('Adminuser', $condition);
		
		 $this->set('data',$data);
		
	 }
	 /*********************************************************************
	 Function to save new admin user
	 **********************************************************************/
	 function superadmin_create() {
		
		
		if(!empty($this->data['Adminuser']) && $this->data['SUBMIT']=='SUBMIT')  {
		$this->Adminuser->set($this->data);
			if(!$this->Adminuser->validates()) 
			{
				$errorsArr = $this->Adminuser->validationErrors;	
				$errors = @implode('<br>', $errorsArr);
			}
			
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->data);
			}
			else {  	  	
				$this->request->data['Adminuser']['password']	= $this->Auth->password($this->data['Adminuser']['new_password']);
				$this->request->data['Adminuser']['orig_password'] 	= $this->data['Adminuser']['new_password'];
				if($this->Adminuser->save($this->data)) {
					$this->Session->write('popup','New User has been created successfully.');			
					$this->Session->setFlash('New User has been created successfully.');  
					$this->redirect(array('controller'=>'adminusers','action' => "index/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
		$this->loadModel('Role');
		$this->set('adminroles',$this->Role->find('list',array('fields'=>array('Role.id','Role.role_name'),'order'=>array('Role.role_name'))));
	 } 
	/********************************************************************
	Function to view amdin user detail 
	********************************************************************/ 
	function superadmin_view($id=NULL) {
	
		$this->set('meta_title','User Details View');
		$this->id= (int)$id;
		if(!$this->id) {
			$this->Session->setFlash('Invalid User id.');
			$this->redirect(array('controller'=>'adminusers','action' => "index"));  
		}
		$this->set('data',$this->Adminuser->read('',$id));
		

	}
	/******************************************************************
	Function to update admin user
	******************************************************************/
	function  superadmin_update($id=null) {
		 $this->set('meta_title','User update');			 
		 $errors ='';
		 if(!empty($this->data['Adminuser']['id'])) {
			 $this->id = (int)$this->data['Adminuser']['id'];
			 $this->set('id',$this->id);
		 }
		 else {
		 	$this->id = (int)$id;
			$this->set('id',$this->id);
		 }	
		 
		 if(!$this->id) {
		 	$this->Session->setFlash('Invalid User update id.');
		    $this->redirect(array('controller'=>'adminusers','action'=>'index'));
		 }
		// $this->Admin->set($this->data['admins']);
		$this->Adminuser->set($this->data);
	  	if(!empty($this->data['Adminuser']) && $this->data['SUBMIT']=='SUBMIT')  {
			if($this->id!=1) { // To protect main admin to deactive 
				$this->request->data['Adminuser']['active']   		= $this->request->data['Adminuser']['active'];
			}
			if(!$this->Adminuser->validates()) {
				$errorsArr = $this->Adminuser->validationErrors;	
			
				
			 //  	$errors = @implode('<br>', $errorsArr);
				$this->set('errors',$errorsArr);
				
				
			}
			

 		   if($errorsArr) {
			   $this->request->data['Adminuser']['orig_password'] 	= $this->request->data['Adminuser']['new_password'];	
			  $this->set('errors',$errorsArr);
			  $this->set('data',$this->data);
			
			}
			else { 
		
		
				  $this->request->data['Adminuser']['id']	= $this->id;
				  $this->request->data['Adminuser']['password'] 	=  $this->Auth->password($this->data['Adminuser']['new_password']);
				  $this->request->data['Adminuser']['orig_password'] 	= $this->request->data['Adminuser']['new_password'];
				 // pr($this->data);
			  	  if($this->Adminuser->save($this->data)) {
				  $this->Session->write('popup','User has been updated successfully.');
						$this->Session->setFlash('User has been updated successfully.');  
						$this->redirect(array('controller'=>'adminusers','action' => 'index/message:success'));
				  }
				  else {
				    	$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'adminusers','action' => "update",$this->id));
				  }		
		 	}//end if not error
	 	}// end if of check data array
		 else {		 
		   $this->set('data',$this->Adminuser->read(null,$id));
		}	 
		$this->loadModel('Role');
		$this->set('adminroles',$this->Role->find('list',array('fields'=>array('Role.id','Role.role_name'),'order'=>array('Role.role_name'))));
		
		
	 } 
	  /* Function to delete admin */
	 function superadmin_delete($id=NULL) {
	 
	   $this->id = (int)$id;
	   if($this->id==1) {
	     $this->Session->setFlash('You can\'t delete this User.');  
	     $this->redirect(array('controller'=>'adminusers','action' => "index"));
	   }
	   if(!$this->id) {
		 	$this->Session->setFlash('Invalid User delete id');
		    $this->redirect(array('controller'=>'adminusers','action'=>'index'));
	   }
	   if($this->Adminuser->delete($this->id,false)) { //second param for casecade delete
	   $this->Session->write('popup','User has been deleted successfully.');
			$this->Session->setFlash('User has been deleted successfully.');  
			$this->redirect(array('controller'=>'adminusers','action' => "index/message:success")); 
		}
	  else {
	  		$this->Session->setFlash('Deletion problem, Please try again.');  
	      	$this->redirect(array('controller'=>'adminusers','action' => "index"));
	  	}	
	 }
	/********************************************************************
	 The AuthComponent provides the needed functionality for login . 
	 ******************************************************************/
        function superadmin_login() {
		 $this->set('meta_title','Login');  

	
          if ($this->request->is('post')) {
            if ($this->Auth->login()) { 
                $this->redirect($this->Auth->redirect());
            } else { 
                //$this->Session->setFlash(__('Invalid username or password, try again'));
                $this->Session->setFlash('Invalid username or password, try again');
            }
        }
         
	 }
	 
	  function superadmin_forgotpassword() {
			//pr($this->Session->read('Auth'));
		 $this->set('meta_title','Forgot Password');  
			$errorsArr  = '';
	 if ($this->request->is('post')) {
			
	
			$userEmail = $this->request->data['Adminuser']['email'];
		
			$this->Adminuser->set($this->request->data);	
			if(!$this->Adminuser->forgotpassValidate())
			{
			$errorsArr = $this->Adminuser->validationErrors;
	
			}
		
			
			if(!$errorsArr){
				
				$condition = "Adminuser.active = 'yes' AND Adminuser.email like '".$userEmail."%' ";
				$userInfo = $this->Adminuser->find("first",array('conditions'=>$condition));
			

				if($userInfo!==false){
					// email user
					$email = new CakeEmail('smtp');
					$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
					$subject = "Admin Login Information for www.techexpoUSA.com";
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					
				
					$username = $userInfo['Adminuser']['first_name'];
					
					
					$bodyText = 'Dear '.$username.',<br/><br/>
					
					Here is your TECHEXPO account information:<br/><br/>
					
					Username:  '.$userInfo['Adminuser']['username'].'<br/>
					Password:  '.$userInfo['Adminuser']['orig_password'].'<br/><br/>
					
					Thank you for your continued support and feel free to e-mail webmaster@TechExpoUSA.com with any questions.<br/><br/>
					Best Regards,<br/>
					The TECHEXPO Team.';
				
					if(Validation::email($userEmail)){
						$email->to($userEmail);
						$email->send($bodyText);
					}

					$this->Session->write('popup','You will receive your username and password by email shortly.');
					unset($this->request->data);
					
				}else{
					$this->Session->write('popup',"We're sorry, this email address is not recorded in our system.Try again.");
				}
				
			}
			
		}
         
         
	 }
	 
    /* Destroy all current sessions for a perticular SuperAdmins and redirect to login page automatically */
	function superadmin_logout() {
		if($this->Session->read('per_page_record')) {
			$this->Session->delete('per_page_record');
		}
   		$this->redirect($this->Auth->logout());
    }
	
	/* Dashboard of admin where we shows summary. */
	function superadmin_home() {
		
		
		
		$this->loadModel('Show');
		$this->Show->unbindModel(array('hasMany'=>array('Registration')));
		$this->Session->check('Auth.User.Adminuser.username');
		$this->set('meta_title','Dashboard');
		
			$targetdate = date('Y-m-d',mktime(0, 0, 0, date("m") , date("d"), date("Y")));
		//	$condition  = "Show.show_dt >= '".$targetdate."' ";	 // comment apurav 06-11-2013
			$condition  = " ";	
		/*	$showList=$this->Show->find("all",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'LEFT',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=> $condition,'order' => array('show_dt DESC'),'limit'=>'50'));*/
	
		$options['joins'] = array(
									array(
								'table' => 'shows_home',
								'alias' => 'ShowsHome',
								'type' => 'LEFT',
								'conditions' => array(
									'ShowsHome.show_id = Show.id'
								)
     						   ),
									
							);
		$options['limit']=10;
		$options['fields']= array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message');
		$options['order'] ="show_dt DESC";		
		$this->paginate = $options;
		$showList= $this->paginate('Show');			
	
	
	$this->set('showLists',$showList);
	
	/*$this->Show->virtualFields = array(
    'ShowDateNameDisplayName' => "CONCAT( DATE_FORMAT(Show.show_dt, '%m/%d/%Y') Show.show_name ShowsHome.display_name ) "
);*/



	$event_list=$this->Show->find("all",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'INNER',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('CONCAT (Show.id) as  id ','CONCAT (DATE_FORMAT(Show.show_dt,"%m-%d-%Y") , " " , Show.show_name, ", " , ShowsHome.display_name) as eventDt'),'order' => array('Show.show_dt  DESC')));
	$result = Set::classicExtract($event_list, '{n}.0');
	$result = Set::combine($result, "{n}.id", "{n}.eventDt");
	
	
	
	$this->Show->unbindModel(array('hasMany'=>array('Registration')));
	$event_list = $this->Show->find('all',array('fields' => array('CONCAT (Show.id) as  id ','CONCAT (DATE_FORMAT(Show.show_dt,"%m-%d-%Y") , " " , Show.show_name) as eventDt'),'order'=>array('Show.id DESC')));
	$result2 = Set::classicExtract($event_list, '{n}.0');
	$result2 = Set::combine($result2, "{n}.id", "{n}.eventDt");


	
	$mainShowList = array_replace($result2, $result);

	
	$this->set('event_lists',$mainShowList);
	
	/*	//
		
		$condition = "User.username IS NULL AND User.password IS NULL AND EmployerContact.contact_email IS NOT NULL AND EmployerContact.created IS NOT NULL";
		$this->EmployerContact->recursive= 0;
		$employer= $this->EmployerContact->find('all',array('limit'=>10,'fields'=>array('EmployerContact.id','EmployerContact.created','User.id','Employer.id','Employer.employer_name'),'conditions'=>$condition,'order'=>array('EmployerContact.id DESC')));
		
		$this->set('employer',$employer);	
		
		
		//get latest 8 candidate record
		$candidateRec=$this->Candidate->find('all',array('fields'=>'Candidate.candidate_name,Candidate.id,Candidate.candidate_title,Candidate.candidate_email',
														'order'=>'Candidate.id desc',
														'recursive'=>'0',
														 'limit'=>'10'));
	
		$this->set('candidateRec',$candidateRec);
		
		// get the latest jobs here
		$this->JobPosting->recursive= 0;
		$jobs = $this->JobPosting->find('all',array('limit'=>16,'fields'=>array('JobPosting.posting_id','JobPosting.employer_id','JobPosting.start_dt','JobPosting.job_title','Employer.employer_name'),'order'=>array('JobPosting.posting_id DESC')));
		$this->set('jobs',$jobs);*/	
			
	}
	
	/* This function is checking username and pasword in database and if true then redirect to home page */
	function beforeFilter() {            
		parent::beforeFilter();
		$this->Auth->autoRedirect = false;
		$this->Auth->authenticate = array(
				'Form' => array('userModel' => 'Adminuser')                                
		);
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
            
		//$this->Session->delete('Auth.redirect');
		$this->Auth->allow('login','superadmin_forgotpassword');
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','superadmin'=>true);		
		$this->Auth->loginRedirect = array('controller' => 'adminusers', 'action' => 'home','superadmin'=>true);
		$this->Auth->scope = array('Adminuser.active' => 'yes');
		
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
        function superadmin_edit_permission() {

        }
}//end class
?>