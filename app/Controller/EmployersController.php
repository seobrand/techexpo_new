<?php 
/******************************************************************************************
 Coder  : Jitendra Pradhan 
 Object : Controller to handle News operations - view , add, edit and delete
******************************************************************************************/ 
App::uses('CakeEmail', 'Network/Email');

class EmployersController extends AppController {
	var $name = 'Employers'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript','Text'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler','Captcha','Email');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'front'; //this is the layout for admin panel 
	var $uses = array('ApplyHistory','Show','ShowEmployer','Employer','EmployerContact','ShowInterview','EmployerVideo','DashboardItem','JobPosting','Resume','Candidate','EmployerSet','Registration','CandidateVideo','Code','City','User');
	//public $displayField = 'employer_name';
	
	 /*********************************************************************
	 Function to create new profile
	 **********************************************************************/
	function profile() {
		$this->set('meta_title','Employer Profile');
		$cityList=array('0'=>'please select State');
		$this->set('cityList',$cityList);
		
		$errorsArr = "";
		$this->loadModel('Code');
		$industryList = $this->common->getIndustriesList();
		$this->set('industryList',$industryList);
		
		if(isset($this->request->data['Employer']['employer_type_code']) )
		$this->request->data['Employer']['employer_type_code'] = implode(',',$this->request->data['Employer']['employer_type_code']);
		
		
		if($this->request->is('post')  && empty($_POST['checkuser'])){		
		
			$this->request->data['Employer']['main_phone']=$this->request->data['Employer']['main_phone1'].''.$this->request->data['Employer']['main_phone2'].''.$this->request->data['Employer']['main_phone3'].''.$this->request->data['Employer']['main_phone4'];
			
			$this->request->data['Employer']['mobile_phone']=$this->request->data['Employer']['mobile_phone1'].''.$this->request->data['Employer']['mobile_phone2'].''.$this->request->data['Employer']['mobile_phone3'];
			
			$this->request->data['Employer']['fax']=$this->request->data['Employer']['fax1'].'-'.$this->request->data['Employer']['fax2'].'-'.$this->request->data['Employer']['fax3'];
		
			if($this->request->data['Employer']['fax']=='--')
			$this->request->data['Employer']['fax'] ='';
			
			$this->request->data['EmployerContact']['contact_email_job']=$this->request->data['EmployerContact']['contact_email'];
							
			$this->Employer->set($this->request->data);
			$this->EmployerContact->set($this->request->data);
			
			if(!$this->Employer->validates()) 
			{
				$errorsArr = $this->Employer->validationErrors;	
			}
			if(!$this->EmployerContact->validates()) 
			{
				$errorsArr = $this->EmployerContact->validationErrors;
				
				$cityList=$this->common->getCityList($this->request->data['Employer']['state']);
				$this->set('cityList',$cityList);
				
				$this->request->data['Employer']['employer_type_code'] = explode(',',$this->request->data['Employer']['employer_type_code']);	
			}
			
			if(!$errorsArr) 
			{	
				$this->request->data['Employer']['main_phone']=$this->request->data['Employer']['main_phone1'].'-'.$this->request->data['Employer']['main_phone2'].'-'.$this->request->data['Employer']['main_phone3'].'-'.$this->request->data['Employer']['main_phone4'];
				
				$this->request->data['Employer']['mobile_phone']=$this->request->data['Employer']['mobile_phone1'].'-'.$this->request->data['Employer']['mobile_phone2'].'-'.$this->request->data['Employer']['mobile_phone3'];
				
				$this->request->data['EmployerContact']['contact_name']=$this->request->data['Employer']['employer_fname'].' '.$this->request->data['Employer']['employer_lname'];
				// by jitendra on 30-07-2013 by ref. of ticket #1297
				$this->request->data['Employer']['max_jobs'] = 0; //10;
				$this->request->data['Employer']['trial_client'] = 'n';
				$this->request->data['Employer']['created'] = date("Y-m-d");
				
				if($this->Employer->save($this->request->data)){
						$employerID = $this->Employer->getLastInsertID();
						$this->request->data['EmployerContact']['employer_id'] = $employerID;
						$this->EmployerContact->save($this->request->data);
						$employerContactID = $this->EmployerContact->getLastInsertID();
						//update into employer
						$this->Employer->updateAll(array('Employer.primary_contact_id'=>$employerContactID), array('Employer.id'=>$employerID));
						
						
						// insert data into user 22 july 2013 (ticket #1297)
						$this->request->data['User']['employer_contact_id'] = $employerContactID;
						$this->request->data['User']['username'] = $this->request->data['EmployerContact']['contact_email'];
						$this->request->data['User']['password'] = 'TECHEXPO';
						$this->request->data['User']['old_password'] = 'TECHEXPO';
						$this->request->data['User']['user_type'] = 'E';
						$this->request->data['User']['created'] = date("Y-m-d");
						$this->User->save($this->request->data);
						// insert data into user 22 july 2013
						
						// send email to admin
						$email = new CakeEmail('smtp');
						$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
			//			$subject = "An employer has created new profile on techexpoUSA.com";
						$subject = $this->request->data['Employer']['employer_name'];
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						
						$bodyText1 = 'Nancy / Brad,<br/><br/>An employer has created a new profile on techexpoUSA.com with the following details:<br/><br/>
						Company Name : '.$this->request->data['Employer']['employer_name'].'<br/>
						Contact Email : '.$this->request->data['EmployerContact']['contact_email'].'<br/>
						Phone : '.$this->request->data['Employer']['main_phone'].' <br/> 
						on date '.date("F d, Y",time()).'.For more detail login to admin section.';
					
						// comment by jitendra on 30-07-2013 by ref. of ticket # 1297
						if(Validation::email('nmathew@techexpoUSA.com')){
							$email->to('nmathew@techexpoUSA.com');
							$email->send($bodyText1);
						}
						if(Validation::email('BRand@TechExpoUSA.com')){
							$email->to('BRand@TechExpoUSA.com');
							$email->send($bodyText1);
						}
						if(Validation::email('david.niry@wanadoo.fr')){
							$email->to('david.niry@wanadoo.fr');
							$email->send($bodyText1);
						}
						
						// added by jitendra on 30-07-2013 by ref. of ticket # 1297
						$system_emails = $this->common->systemSetting();			
						if(!empty($system_emails['Email To'])){
							$sendTo = explode(",", $system_emails['Email To']);
							if(is_array($sendTo)){
								foreach ($sendTo as $send_to){
									if(Validation::email($send_to)){
										$email->to($send_to);
										$email->send($bodyText1);
									} 
								}
							}
						}
				$systemEmail = $this->common->systemSetting();		
				if(strpos($systemEmail['Email To'],',')){
					$sendto=explode(',',$systemEmail['Email To']);
					$sendto = array_filter(array_map('trim', $sendto));
					
				}else{
					$sendto=(array)$systemEmail['Email To'];
					$sendto = array_filter(array_map('trim', $sendto));
				}
				
				if(strpos($systemEmail['Email CC'],',')){
					$sendcc=explode(',',$systemEmail['Email CC']);
					$sendcc = array_filter(array_map('trim', $sendcc));
					
				}else{
					$sendcc=(array)$systemEmail['Email CC'];
					$sendcc = array_filter(array_map('trim', $sendcc));
				}
				
						$email = new CakeEmail('smtp');
						$email->to($sendto);
						$email->cc($sendcc);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText1);
						unset($email);
						//  mail send to employer 
						
						$email = new CakeEmail('smtp');
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$bodyText2 = 'Hello '.$this->request->data['Employer']['employer_name'].',<br/><br/>Thank you for creating your employer account. A TECHEXPO representative will contact you shortly.<br/><br/> Thank You <br/> TechExpo Team';
						if(Validation::email($this->request->data['EmployerContact']['contact_email'])){
							$email->to($this->request->data['EmployerContact']['contact_email']);
							$email->send($bodyText2);
						}
						
						//$popupmsg = 'Thank you for creating your employer account. A TECHEXPO representative will contact you shortly.';
						
						$popupmsg = 'Thank you for registering.   All companies and job postings are screened in advance. A TECHEXPO representative will contact you shortly.  You may contact us directly at 1-212-665-4505 ext. 224 or email us at <a href="mailto:nmathew@techexpousa.com" target="_blank">nmathew@techexpousa.com</a>';
						
						
						$this->Session->write('popup',$popupmsg);
						unset($this->request->data);
				
				}else{
					$this->Session->write('popup','Some problem to save data.Please Try again.');
				}	
					
			}else
			{
				
			}
			
		}

   } 
	/*********************************************************************************************
	Function to view Dashboard
	*********************************************************************************************/ 
	function dashboard($id = null) {
		$this->set('meta_title','Employer My Account');
		// load the models
		$this->loadModel('JobPosting');
		
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		
	/*	$dashboard_items = array();
		$dashboard_items = $this->DashboardItem->find('all',array('conditions'=>array('DashboardItem.user_id'=> $this->Session->read('Auth.Client.User.id')),'limit'=>'4',	'order' => 'DashboardItem.id DESC'));
		//pr($dashboard_items);
		$dashboard_col1 = $this->DashboardItem->find('all',array('conditions'=>array('DashboardItem.user_id'=> $this->Session->read('Auth.Client.User.id'),'DashboardItem.column_no'=> '1'),'limit'=>'4',	'order' => 'DashboardItem.id DESC'));
				$dashboard_col2 = $this->DashboardItem->find('all',array('conditions'=>array('DashboardItem.user_id'=> $this->Session->read('Auth.Client.User.id'),'DashboardItem.column_no'=> '2'),'limit'=>'4',	'order' => 'DashboardItem.id DESC'));
		
		$this->set('dashboard_items',$dashboard_items);
		$this->set('dashboard_col1',$dashboard_col1);
		$this->set('dashboard_col2',$dashboard_col2);*/
		
		
		$UserId=$this->Session->read('Auth.Client.User.id');
		 // code for box drag and drop
		$Rec=$this->User->query("SELECT * FROM records  where user_id='".$UserId."' ORDER BY recordListingID ASC");
		if(count($Rec))
		{
			$this->set('RecId',$Rec);
		}else
		{
			$this->User->query("insert into records set recordID='1',recordListingID='1',user_id='".$UserId."'");
			$this->User->query("insert into records set recordID='2',recordListingID='2',user_id='".$UserId."'");
			$this->User->query("insert into records set recordID='3',recordListingID='3',user_id='".$UserId."'");
			$this->User->query("insert into records set recordID='4',recordListingID='4',user_id='".$UserId."'");
			$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
			
			$Rec=$this->User->query("SELECT * FROM records  where user_id='".$UserId."' ORDER BY recordListingID ASC");
			$this->set('RecId',$Rec);
		}  // end
		
		$dashboard_video= $this->EmployerVideo->find('first',array('conditions'=>array('EmployerVideo.employer_id'=> $employerID,'EmployerVideo.set_dashboard'=>'1','EmployerVideo.isApproved'=>'Y')));
		$this->set('dashboard_video',$dashboard_video);
		// delete the selected job
		if(!empty($id))
		{
			if($this->JobPosting->find('count',array('conditions'=>'JobPosting.posting_id="'.$id.'" and JobPosting.employer_id="'.$employerID.'"','action'=>'')))
			{
		
			$this->JobPosting->delete($id);
			$this->Session->write('popup','Selected Job is deleted.');
			$this->redirect(array('controller'=>'employers','action'=>''));
			}
			else
			{
				$this->Session->write('popup','Did not have a permission to delete.');
				$this->redirect(array('controller'=>'employers','action'=>''));			
			}
		}
		
		
		// latest applicants
		$lastdate = date("Y-m-d",mktime(0, 0, 0, date("m")-3, date("d"), date("Y")));
	
		$apply_list = $this->ApplyHistory->find('all',array('conditions'=>array('ApplyHistory.employer_id'=> $employerID,'ApplyHistory.dt >'=>$lastdate ),'fields'=>array('Candidate.candidate_name','Candidate.experience_code','ApplyHistory.resume_id','ApplyHistory.job_title','ApplyHistory.dt','Candidate.id'),'limit'=>'5',	'order' => 'ApplyHistory.dt DESC'));
		//pr($apply_list);
		$this->set('apply_list',$apply_list);
		
		// event list
		$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m")-1 , date("d"), date("Y")));
		$condition  = "ShowEmployer.employer_id = ".$employerID." AND ShowEmployer.payment_status = 'y' AND Show.show_dt > ".$targetdate." ";	
		
		$events = $this->ShowEmployer->find('all',array('conditions'=>$condition,'fields' => array('Show.show_name','Show.show_dt','Show.id')));
		$event_list = Set::combine($events, '{n}.Show.id', array('{0} {1}', '{n}.Show.show_name', '{n}.Show.show_dt'));
		$this->set('event_list',$event_list);
		
		// Get the list of database which is assign to login employer
		$selected_db = $this->EmployerSet->find('all',array('conditions'=>array('EmployerSet.employer_id'=>$employerID),'fields'=>array('DISTINCT ResumeSetRule.set_id,ResumeSetRule.short_desc'),'order'=>array('ResumeSetRule.end_dt DESC')));
		
		$newstates['all']='All Databases';
		
		if(count($selected_db)){
			foreach($selected_db as $selected_db) {
				$state = $selected_db['ResumeSetRule'];
				$newstates[$state['set_id']] = $state['short_desc'];
				
			}
	
		
		}else{
			$newstates = array();
		}
		
		
		$this->set('selected_db',$newstates);
		
		//pr($selected_db);
		
		// Get the list of login employer job
		$condition  = 'JobPosting.employer_id = '.$employerID.' AND JobPosting.employer_contact_id =  '.$empContactID;	
		$this->paginate = array('limit' =>5,'order' => array('posting_id DESC'));
		$joblists = $this->paginate('JobPosting', $condition);
		$this->set('joblists',$joblists);
		// Get totalcount of jobs
		$jobcount = $this->JobPosting->find("count",array('fields' => 'DISTINCT JobPosting.posting_id','conditions'=>$condition));
		$this->set('jobcount',$jobcount);
		
	}
	
		function updateDB()
	{
				$action 			= $_POST['action']; 
				$updateRecordsArray 	= $_POST['recordsArray'];
				$listingCounter = 1;
				if ($action == "updateRecordsListings")
				{
				
				
	
					$listingCounter = 1;
					foreach ($updateRecordsArray as $key=>$value) {
						
						
						$query = $this->User->query("UPDATE records SET recordListingID = " . $listingCounter . " WHERE id = '". $value."' and user_id='".$this->Session->read('Auth.Client.User.id')."'" );
					
					$listingCounter = $listingCounter + 1;	
					}
					
				}
				die;
				//print_r($updateRecordsArray);die;
	}
	
	
	
	function dashboardsort(){
		$this->autoRender = false;
		$this->layout = false;
		
		
		$data = $this->request->data;
		//pr($data);die;
		$i='0';
		foreach($data['items'] as $d){ 
		   $item_no = split("_",$d['id']); //split item_3 to get 3 and that is our item table id 
		   $d[$i]['id'] = $item_no[1];
					
		   $col_no = split("_", $d['column_no']); //split 
		   $d['column_no'] = $col_no[1];
		  $d['user_id']	= $this->Session->read('Auth.Client.User.id');
			$this->DashboardItem->save($d);
		$i++;}
		
		echo "ffgfg";die;
		}
	/*********************************************************************************************
	Function to view manage account
	*********************************************************************************************/ 
	function manageaccount() {
		$this->set('meta_title','Employer Manage Account');
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		// Get the list of database which is assign to login employer
		$selected_db = $this->EmployerSet->find('all',array('conditions'=>array('EmployerSet.employer_id'=>$employerID),'fields'=>array('DISTINCT 		ResumeSetRule.set_id,ResumeSetRule.short_desc')));
		$this->set('selected_db',$selected_db);
	
	}
	/*******************************************************************************************
	Function to update employer profile
	*******************************************************************************************/
	function editprofile(){
		
		$errorsArr ='';
		$this->set('meta_title','Edit Employer Profile');
		

		// get the list of all indusrty types
		$this->loadModel('Code');
		$this->loadModel('Employer');
		$industryList = $this->common->getIndustriesList();
		$this->set('industryList',$industryList);
		
		$employerProfileID = $this->Session->read('Auth.Client.employerContact.employer_id');
		//pr($this->request->data);die;
		
		if($this->request->is('post')){
			
			$this->request->data['Employer']['mobile_phone']='';
			$this->request->data['Employer']['main_phone']='';
			$this->request->data['Employer']['fax']='';
		
		
			
			$this->request->data['Employer']['main_phone']=$this->request->data['Employer']['main_phone1'].'-'.$this->request->data['Employer']['main_phone2'].'-'.$this->request->data['Employer']['main_phone3'].'-'.$this->request->data['Employer']['main_phone4'];
		
			$this->request->data['Employer']['mobile_phone']=$this->request->data['Employer']['mobile_phone1'].'-'.$this->request->data['Employer']['mobile_phone2'].'-'.$this->request->data['Employer']['mobile_phone3'];
		
			$this->request->data['Employer']['fax']=$this->request->data['Employer']['fax1'].'-'.$this->request->data['Employer']['fax2'].'-'.$this->request->data['Employer']['fax3'];
			
			
			$this->Employer->set($this->request->data);
			
			
			if(!$this->Employer->validates()){
				$errorsArr = $this->Employer->validationErrors;	
			}
			
			if(isset($this->request->data['Employer']['employer_type_code']) )
			$this->request->data['Employer']['employer_type_code'] = implode(',',$this->request->data['Employer']['employer_type_code']);
			
			if(!$errorsArr) 
			{	
				$result = $this->Employer->save($this->request->data);
				$this->Session->write('popup','Your company profile has been updated successfully.');
				$this->redirect(array('controller'=>'employers','action' => "dashboard"));
			}
		}else
		{
			
		 	// Get employer profile record
			$this->Employer->recursive = -1;
			$this->request->data = $this->Employer->find("first", array('conditions' => array('Employer.id'=>$employerProfileID)));
			
		//	pr($this->request->data);
			
			$main_phone=explode('-',$this->request->data['Employer']['main_phone']);
			if(!empty($main_phone[0]))
			{
				$this->request->data['Employer']['main_phone1']=$main_phone[0];
			}
			
			
			if(!empty($main_phone[1]))
			{
				$this->request->data['Employer']['main_phone2']=$main_phone[1];
			}
			if(!empty($main_phone[2]))
			{
				$this->request->data['Employer']['main_phone3']=$main_phone[2];
			}
			if(!empty($main_phone[3]))
			{
				$this->request->data['Employer']['main_phone4']=$main_phone[3];
			}
			
			
			$mobile_phone=explode('-',$this->request->data['Employer']['mobile_phone']);
			if(!empty($mobile_phone[0]))
			{
				$this->request->data['Employer']['mobile_phone1']=$mobile_phone[0];
			}
			
			if(!empty($mobile_phone[1]))
			{
				$this->request->data['Employer']['mobile_phone2']=$mobile_phone[1];
			}
			
			if(!empty($mobile_phone[2]))
			{
				$this->request->data['Employer']['mobile_phone3']=$mobile_phone[2];
			}
			
			$fax=explode('-',$this->request->data['Employer']['fax']);
			if(!empty($fax[0]))
			{
				$this->request->data['Employer']['fax1']=$fax[0];
			}
			
			if(isset($mobile_phone[1]) && !empty($mobile_phone[1]))
			{
				$this->request->data['Employer']['fax2']=$fax[1];
			}
			
			if(isset($mobile_phone[2]) && !empty($mobile_phone[2]))
			{
				$this->request->data['Employer']['fax3']=$fax[2];
			}
			
			
		
			$this->request->data['Employer']['mobile_phone']='';
			$this->request->data['Employer']['main_phone']='';
			$this->request->data['Employer']['fax']='';
		
		}
		
		$cityList=$this->common->getCityList($this->request->data['Employer']['state']);
			
			$this->set('cityList',$cityList);
		
	}
	
	
	/************Function to view employer detail*****************/
	function viewprofile($employerID = null){
		$errorsArr ='';
		$this->set('meta_title','View Employer Profile');
		
		if($this->request->is('get')){
		 	// Get employer profile record
			//$this->Employer->recursive = 1; // commented 10 july 2013
			$employerDetail = $this->Employer->find("first", array('conditions' => array('Employer.id'=>$employerID)));
			$this->set("employerDetail", $employerDetail);
			
			$this->loadModel('EmployerVideo');
			$EmployerVd = $this->EmployerVideo->find('first',array('conditions'=>array('EmployerVideo.employer_id'=>$employerID,'EmployerVideo.isApproved'=>'Y'),'order'=>'EmployerVideo.id DESC','fields'=>array('video_type','video','description','id')));
			$this->set('EmployerVd',$EmployerVd);
		}
		
	}
	
	/***** Function for update personal contact information of employer *******/
	function editpersonalinfo(){
		$errorsArr ='';
		$this->set('meta_title','Edit Employer Profile');
		// load the models
		$this->loadModel('EmployerContact');
		$this->loadModel('User');
		
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		//pr($this->request->data);die;
		
		
		if($this->request->is('get')){
		 	// Get employer personal contact information
			$this->EmployerContact->recursive = 0; // -1 means show only this model information
			$this->request->data = $this->EmployerContact->find("first", array('conditions' => array('EmployerContact.id'=>$empContactID)));
			$this->request->data['User']['newusername'] = $this->request->data['User']['username'];

		

		}else{
			
				
			// set the request data to model for validation
			$this->EmployerContact->set($this->request->data);
			// check data if it is valid or not
			if(!$this->EmployerContact->validates()){
				$errorsArr = $this->EmployerContact->validationErrors;	
			}else{
				// check validation for username & password
				if($this->request->data['User']['username']!=$this->request->data['User']['currentusername']){
					$this->User->set($this->request->data);
					if(!$this->User->changeUserValidate()){
						$errorsArr = $this->User->validationErrors;
					}else{
						$data = array('User' => array('id'=>$this->request->data['User']['id'],'username'=>$this->request->data['User']['username']));
						$this->User->save( $data, false, array('username'));
					}
				}
				
				if(trim($this->request->data['User']['password'])!=$this->request->data['User']['currentpassword']){
					if(trim($this->request->data['User']['password'])!=$this->request->data['User']['confirmpassword']) {
						$this->User->validationErrors['confirmpassword'] = "! Confirm password not matched.";
						$errorsArr = $this->User->validationErrors;	
					}else if(!empty($this->request->data['User']['password'])){
						$data = array('User' => array('id'=>$this->request->data['User']['id'],'password'=>$this->request->data['User']['password'],'old_password'=>$this->request->data['User']['password']));
						$this->User->save($data, false, array('password','old_password'));
					}
				}
				
			}
			
			if(!$errorsArr) 
			{
				$result = $this->EmployerContact->save($this->request->data);
				$this->Session->write('popup','Your personal contact information has been updated successfully.');
			}
			
		}
		
		$cityList=$this->common->getCityList($this->request->data['EmployerContact']['contact_state']);
		$this->set('cityList',$cityList);
	}
	
	// chnage password popup
	function changepassword()
	{
		$this->layout = false;
		
		if($this->request->is('post')){
		//	pr($this->Session->read('Auth.Client.User.id'));
		//	pr($this->request->data);die;
		$data = array('User' => array('id'=>$this->Session->read('Auth.Client.User.id'),'password'=>$this->request->data['password'],'old_password'=>$this->request->data['password']));
		$this->User->save($data, false, array('password','old_password'));
		$this->Session->write('popup','Your password updated successfully.');
		$this->Session->write('Auth.Clients.old_password',$this->request->data['password']);
		$this->redirect(array('controller'=>'employers','action' => "dashboard"));
		exit;
		}
		
	}
	
	/***** Function for post and view jobs by employer *******/
	function emppostjob(){
	
		$this->set('statList',$this->common->getAjaxStateList(15)); //    find statelist
	
		$this->set('securityClearanceError','');
		$errorMSG='';
		$this->set('errorMSG','');
		$cityList=array('0'=>'please select state');
		$this->set('cityList',$cityList);
		
		$errorsArr ='';
		$this->set('meta_title','Post a Job');
		// load the models
		$this->loadModel('Code');
		$this->loadModel('State');
		$this->loadModel('ClearanceKeyword');
	
		//$this->set("skills",$this->common->getKeywordList());
		$this->set("experience",$this->common->getExperienceList());
		$this->set("lastusedcode",$this->common->getLastUsedList());
		$this->set("importance",$this->common->getImportanceList());
		$this->set("worktype",$this->common->getWorkTypeList());
		$this->set("worktime",$this->common->getWorkTimeList());
		$this->set("worklocation",$this->common->getWorkLocationList());
		$this->set("salarytype",$this->common->getSalaryTypeList());
		$this->set("ck",$this->common->getGovCleareanceList());
		$this->set("states",$this->State->find("list",array('fields'=>array('state_abrev','state_name'),'order'=>array("state_name ASC"))));
		
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		//pr($this->request->data);die;
		
		if($this->request->is('get')){
			
		}else{
		
			
			//check whether posted job exceeds the max no. of jobs for an employer 
			$number_of_postedjobs = $this->common->GetPostedJobNumber($employerID);
			$limitJobs = $this->common->GetEmployerJobLimit($employerID);
			if($limitJobs<=0){
				$this->Session->write('popup','Sorry! You have reached the maximum limit of jobs for your company. You can get more jobs in your account by puchasing job plans.');
				$this->redirect(array('controller'=>'employers','action' => "joblists"));
				exit;
			}
			
			$this->loadModel('JobPostingSkill');
			$this->loadModel('JobPosting');
			
			$this->JobPosting->set($this->request->data);
			
			
			
			
			if(!$this->JobPosting->validates()){
				if($this->request->data['JobPosting']['address_type'] == 'e' && !$this->JobPosting->emailValidate()){
					$errorsArr = $this->JobPosting->validationErrors;
				}
				if($this->request->data['JobPosting']['address_type'] == 'w' && !$this->JobPosting->urlValidate()){
					$errorsArr = $this->JobPosting->validationErrors;
					
				}
				
				$errorsArr = $this->JobPosting->validationErrors;
				$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$this->request->data['JobPosting']['location_state'].'"','fields'=>'city,city','order by city ASC'));
				$this->set('cityList',$cityList);
					
			}elseif($this->request->data['JobPosting']['address_type'] == 'e' && !$this->JobPosting->emailValidate()){
				$errorsArr = $this->JobPosting->validationErrors;
			}elseif($this->request->data['JobPosting']['address_type'] == 'w' && !$this->JobPosting->urlValidate()){
				$errorsArr = $this->JobPosting->validationErrors;
			}
			
			if($this->request->data['JobPosting']['security'])
			{
				
				if(!$this->request->data['JobPosting']['security_clearance_code']) 
				{
				
					$errorsArr['job_title']['0']='please select at least one security clearance';
					
					$this->set('securityClearanceError','please select at least one security clearance');
				}
			}
			
			if(!$errorsArr) 
			{
				
				if($this->request->data['JobPosting']['location_country']!='15' and $this->request->data['JobPosting']['location_country']!='16')
							{
								if(!empty($this->request->data['JobPosting']['location_state22']))
								{
									$this->request->data['JobPosting']['location_state']=$this->request->data['JobPosting']['location_state22'];
								}
							}
				
				if(is_array($this->request->data['JobPosting']['security_clearance_code']))
				$this->request->data['JobPosting']['security_clearance_code'] 	= implode(",",$this->request->data['JobPosting']['security_clearance_code']);
				$this->request->data['JobPosting']['employer_id'] = $employerID;
				$this->request->data['JobPosting']['employer_contact_id'] = $empContactID;
				$this->request->data['JobPosting']['start_dt'] = date("Y-m-d");
				$this->request->data['JobPosting']['end_dt'] = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+60,date("Y")));
				
				
				if($this->request->data['JobPosting']['address_type']=='w')
					$this->request->data['JobPosting']['job_email'] = $this->request->data['JobPosting']['job_url'];
				
				//save data in job posting
				$result = $this->JobPosting->save($this->request->data);
				if($result){
					$jobpostingID = $this->JobPosting->getLastInsertID();
					$this->Employer->updateAll(array('Employer.max_jobs' => 'Employer.max_jobs-1'), array('Employer.id' => $employerID));
					
					$keywordCount = $this->request->data['JobPosting']['count'];
					$this->request->data['JobPostingSkill']['posting_id'] = $jobpostingID;
					
					for($i=1;$i<=$keywordCount;$i++){
						$this->JobPostingSkill->create();
						$this->request->data['JobPostingSkill']['skill_id'] = $this->request->data['JobPosting']['skill'.$i];
						$this->request->data['JobPostingSkill']['importance'] = $this->request->data['JobPosting']['importance'.$i];
						$this->request->data['JobPostingSkill']['experience_code'] = $this->request->data['JobPosting']['experiencecode'.$i];
						$this->request->data['JobPostingSkill']['last_used_code'] = $this->request->data['JobPosting']['lastusedcode'.$i];
						$this->JobPostingSkill->save($this->request->data);
					}
					
					$this->Session->write('popup','Your Job has been posted successfully.');
					$this->redirect(array('controller'=>'employers','action' => "joblists"));
				}else{
					$this->Session->write('popup','Sorry! Some Database Error in saving.');
				}				
			}else
			{
				$this->set('errorMSG','There were errors on your job posting,  please scroll down and make the appropriate corrections.');
				$count = $this->request->data['JobPosting']['count'];
				for($j=5;$j>$count;$j--){
					unset($this->request->data['JobPosting']['skill'.$j]);
					unset($this->request->data['JobPosting']['experiencecode'.$j]);
					unset($this->request->data['JobPosting']['lastusedcode'.$j]);
					unset($this->request->data['JobPosting']['importance'.$j]);
				}
				//pr($this->request->data);die;
				
				$this->set('totalSkills',$this->request->data['JobPosting']['count']);
				$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$this->request->data['JobPosting']['location_state'].'"','fields'=>'city,city','order by city ASC'));
				$this->set('cityList',$cityList);
				
				
				if(!empty($this->request->data['JobPosting']['country_code']))
						{
							$this->set('statList',$this->common->getAjaxStateList($this->request->data['JobPosting']['country_code']));
						}else
						{
							$this->set('statList',$this->common->getAjaxStateList(15));
						}
						
			
			}
			
		 }
		
	}
	
	/***** Function for edit jobs by employer *******/
	function empeditjob($postingID = null){
		$errorMSG='';
		$this->set('errorMSG','');
		$errorsArr ='';
		$this->set('meta_title','Edit Job');
		// load the models
		$this->loadModel('Code');
		$this->loadModel('State');
		$this->loadModel('ClearanceKeyword');
	
		//$this->set("skills",$this->common->getKeywordList());
		$this->set("experience",$this->common->getExperienceList());
		$this->set("lastusedcode",$this->common->getLastUsedList());
		$this->set("importance",$this->common->getImportanceList());
		$this->set("worktype",$this->common->getWorkTypeList());
		$this->set("worktime",$this->common->getWorkTimeList());
		$this->set("worklocation",$this->common->getWorkLocationList());
		$this->set("salarytype",$this->common->getSalaryTypeList());
		$this->set("ck",$this->common->getGovCleareanceList());
		$this->set("states",$this->State->find("list",array('fields'=>array('state_abrev','state_name'),'order'=>array("state_name ASC"))));
		
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		//pr($this->request->data);die;
		
		if($this->request->is('get')){
			$this->loadModel('JobPosting');
			$this->request->data = $this->JobPosting->find("first",array('conditions'=>array('JobPosting.posting_id'=>$postingID)));
			$jobactive = $this->request->data['JobPosting']['active'];
			$this->request->data['JobPosting']['active'] = ($jobactive=="") ? 0 : $jobactive; 
			if($this->request->data['JobPosting']['location_country']!='15' and $this->request->data['JobPosting']['location_country']!='16')
			{
				$this->request->data['JobPosting']['location_state22']=$this->request->data['JobPosting']['location_state'];
			}
			if(!empty($this->request->data['JobPosting']['location_country']))
						{
					
						
							$this->set('statList',$this->common->getAjaxStateList($this->request->data['JobPosting']['location_country']));
						}else
						{
							$this->set('statList',$this->common->getAjaxStateList(15));
						}
			
		//	pr($this->request->data);
			if($this->request->data['JobPosting']['address_type'] == 'w'){
				$this->request->data['JobPosting']['job_url'] = $this->request->data['JobPosting']['job_email'];
			}
			if($this->request->data['JobPosting']['security_clearance_code']!=''){
				$this->request->data['JobPosting']['security_clearance_code'] = explode(",",$this->request->data['JobPosting']['security_clearance_code']);
			}
			
			$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$this->request->data['JobPosting']['location_state'].'"',
													'fields'=>'city,city','order by city ASC'));
			$this->set('cityList',$cityList);
			
		}else{ 
			
			$this->loadModel('JobPostingSkill');
			$this->loadModel('JobPosting');
			//pr($this->request->data);die;
			$this->JobPosting->set($this->request->data);
			
			if(!$this->JobPosting->validates()){
				$errorsArr = $this->JobPosting->validationErrors;	
			}elseif($this->request->data['JobPosting']['address_type'] == 'e' && !$this->JobPosting->emailValidate()){
				$errorsArr = $this->JobPosting->validationErrors;
			}elseif($this->request->data['JobPosting']['address_type'] == 'w' && !$this->JobPosting->urlValidate()){
				echo $this->request->data['JobPosting']['job_url'];
				$errorsArr = $this->JobPosting->validationErrors;
			}
			
			//******* task id 3851 *****/
			if($this->request->data['JobPosting']['security'])
			{			
				if(!$this->request->data['JobPosting']['security_clearance_code'])
				{			
					$errorsArr['security']['0']='please select at least one security clearance';						
					$this->set('securityClearanceError','please select at least one security clearance');
				}
			}
			
			if(!$errorsArr) 
			{
				if($this->request->data['JobPosting']['location_country']!='15' and $this->request->data['JobPosting']['location_country']!='16')
					{
						if(!empty($this->request->data['JobPosting']['location_state22']))
							{
								$this->request->data['JobPosting']['location_state']=$this->request->data['JobPosting']['location_state22'];
							}
					}
				
				if(is_array($this->request->data['JobPosting']['security_clearance_code']))
				{
				$this->request->data['JobPosting']['security_clearance_code'] 	= implode(",",$this->request->data['JobPosting']['security_clearance_code']);
				}
				else
				{
					$this->request->data['JobPosting']['security_clearance_code'] ='';	
				}
				
				if($this->request->data['JobPosting']['address_type']=='w')
					$this->request->data['JobPosting']['job_email'] = $this->request->data['JobPosting']['job_url'];
				
				//save data in job posting
				$result = $this->JobPosting->save($this->request->data);
				
				$this->JobPostingSkill->deleteAll(array('JobPostingSkill.posting_id' =>$postingID));
				$keywordCount = $this->request->data['JobPosting']['count'];
				$skill_data['JobPostingSkill']['posting_id'] = $postingID;
				
				for($i=1;$i<=$keywordCount;$i++)
				{
					$this->JobPostingSkill->create();
					$skill_data['JobPostingSkill']['skill_id'] 			= $this->request->data['JobPosting']['skill'.$i];
					$skill_data['JobPostingSkill']['importance'] 		= $this->request->data['JobPosting']['importance'.$i];
					$skill_data['JobPostingSkill']['experience_code'] 	= $this->request->data['JobPosting']['experiencecode'.$i];
					$skill_data['JobPostingSkill']['last_used_code'] 	= $this->request->data['JobPosting']['lastusedcode'.$i];
					$this->JobPostingSkill->save($skill_data);
				}
				
				$this->Session->write('popup','Your Job has been updated successfully.');
				$this->redirect(array('controller'=>'employers','action' => "joblists"));
				
				
			}else
			{
					$this->set('errorMSG','There were errors on your job posting,  please scroll down and make the appropriate corrections.');
					if(!empty($this->request->data['JobPosting']['country_code']))
						{
							$this->set('statList',$this->common->getAjaxStateList($this->request->data['JobPosting']['country_code']));
						}else
						{
							$this->set('statList',$this->common->getAjaxStateList(15));
						}
					
					$totalSkills=$this->request->data['JobPosting']['count'];
					$this->set('totalSkills',$totalSkills);
				
			}
			
		 }
		
	}
	
	/***** Function for view jobs list by employer *******/
	function joblists(){
		$errorsArr ='';
		$this->set('meta_title','View Jobs');
		// load the models
		$this->loadModel('JobPosting');
		
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		
		if($this->request->is('post')){
		/*	if(strtolower($this->Session->read('security_code'))!=strtolower($this->request->data['JobPosting']['captcha'])) {
				$this->JobPosting->validationErrors['captcha'] = "Please enter correct text!";
				$errorsArr = $this->JobPosting->validationErrors;	
			}*/
			
			
			if(!$errorsArr){
			
				// Make active/inactive the selected job
				$activeJobs = $this->request->data['JobPosting']['active'];
				foreach($activeJobs as $postingID => $isActive){
					$activeData = array("JobPosting"=>array('posting_id' =>$postingID,'active'=>$isActive));
					// save the active/inactive jobs		
					$this->JobPosting->save($activeData, false, array('active'));
				}
				
				
				
				if(!empty($this->request->data['JobPosting']['action']))
				{
					if(is_array($this->request->data['JobPosting']['action']))
					{
						
						foreach($this->request->data['JobPosting']['action'] as $key=>$value)
						{
								if($value=='refresh')
								{
										$end_dt = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+60,date("Y")));
										$refreshData = array("JobPosting"=>array('posting_id' =>$key,'start_dt'=>date('Y-m-d'),'end_dt'=>$end_dt));
										// save the refresh jobs		
										$this->JobPosting->save($refreshData, false, array('start_dt','end_dt'));
								}
							
							
							if($value=='delete')
							{
							
								//$deleteData = array("JobPosting"=>array('JobPosting.posting_id="'.$key.'"'));
								// delete the jobs		
								
								$this->JobPosting->query('delete from job_postings where posting_id="'.$key.'"');
							}
						}
					}
				}
				
				// Make refresh the selected job
			/*	if(isset($this->request->data['JobPosting']['refresh'])){
					$refreshJobs = $this->request->data['JobPosting']['refresh'];
					foreach($refreshJobs as $key => $refreshJob){
						$end_dt = date("Y-m-d",mktime(0,0,0,date("m"),date("d")+30,date("Y")));
						$refreshData = array("JobPosting"=>array('posting_id' =>$refreshJob,'start_dt'=>date('Y-m-d'),'end_dt'=>$end_dt));
						// save the refresh jobs		
						$this->JobPosting->save($refreshData, false, array('start_dt','end_dt'));
					}
				}
				// delete the selected job
				if(isset($this->request->data['JobPosting']['delete'])){
					$deleteJobs = $this->request->data['JobPosting']['delete'];
					foreach($deleteJobs as $key => $deleteJob){
						$deleteData = array("JobPosting"=>array('posting_id' =>$deleteJob));
						// delete the jobs		
						$this->JobPosting->delete($deleteJob, true);
					}
				}*/
				
				$this->Session->write('popup','Your job postings have been updated.');
				//unset($this->request->data['JobPosting']['captcha']);
				$this->redirect($this->referer());
			}
			
		}
		
		// Get the list of login employer job
		$this->JobPosting->recursive = -1;
		$condition  = 'JobPosting.employer_id = '.$employerID.' AND JobPosting.employer_contact_id =  '.$empContactID;	
		$this->paginate = array('fields'=>array('posting_id','job_title','start_dt','end_dt','location_state','location_city','active','job_email'),'limit' =>20,'order' => 'JobPosting.posting_id DESC');
		$joblists = $this->paginate('JobPosting', $condition);
		//pr($joblists);die;
		$this->set('joblists',$joblists);
		// Get totalcount of jobs
		$jobcount = $this->JobPosting->find("count",array('fields' => 'DISTINCT JobPosting.posting_id','conditions'=>$condition));
		$this->set('jobcount',$jobcount);
		
	}
	/***** Function for view job matach *******/
	public function jobmatching($jobposting_id = null){
		
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		$this->JobPosting->recursive = 0;
		$select_job = $this->JobPosting->find("first",array('fields' => array('JobPosting.location_state','JobPosting.security_clearance_code','JobPosting.job_title'),'conditions'=>array('JobPosting.posting_id'=>$jobposting_id)));
	
		
		/*pr($this->Resume->Find('all',array('conditions'=>array('Candidate.candidate_state'=>$select_job['JobPosting']['location_state']),'fields'=>array('Resume.resume_summary','Candidate.candidate_name','Candidate.candidate_email','Candidate.candidate_privacy','Candidate.citizen_status_code'),'limit'=>'20')));
		die;*/
		
			$options['joins'] = array(
			array('table' => 'candidates',
				'alias' => 'Candidatenew',
				'type' => 'left',
				'conditions' => array(
					"Candidatenew.id = Resume.candidate_id"
				)
			),
			array('table' => 'job_score',
				'alias' => 'JobScore',
				'type' => 'left',
				'conditions' => array(
					"JobScore.resume_id = Resume.id"
				)
			)
		);
		/***********************************************************************/
							
		$conditions='';
		$arr=explode(",",$select_job['JobPosting']['security_clearance_code']);	
		$totalSecurityClearance=count($arr);
		$stringSecurityClearance='';
		$i=1;
		foreach($arr as $key7=>$value7)
		{
			
			
			$conditions.= 'FIND_IN_SET("'.$value7.'",Candidatenew.security_clearance_code)';
			
			if($i!=$totalSecurityClearance)
			{
				$conditions.=" or ";
			}
			$i=$i+1;
		}
								
								
		$options['conditions'] = array(
			"JobScore.posting_id ='".$jobposting_id."'",
			//'JobScore.resume_id'=>'Resume.resume_id',
			'Candidatenew.candidate_state'=>$select_job['JobPosting']['location_state'],
			'JobScore.score >39',
			$conditions
			
		);
		
		
		  $options['fields'] = array('Resume.posted_dt','Resume.resume_summary','Candidatenew.candidate_name','Candidatenew.candidate_email','Candidatenew.candidate_privacy','Candidatenew.citizen_status_code','Candidatenew.experience_code','Candidatenew.security_clearance_code','Candidatenew.candidate_state','Resume.resume_title','Candidatenew.candidate_city','Candidatenew.pref_locations');
	//$options['order'] = array('JobScore.resume_id desc');
		$options['limit'] = '10';
		
		$joblists = $this->Resume->find('all', $options);
		
		//pr($joblists);die;
		
		$this->set('joblists',$joblists);
		
		
		
		}
	/***** Function for view job detail *******/
	function jobdetail($postingID = null){
		$this->set('meta_title','View Jobs Detail');
		// load the models
		$this->loadModel('JobPosting');
		
		if($this->request->is('get')){
			$this->request->data = $this->JobPosting->find("first",array('conditions'=>array('JobPosting.posting_id'=>$postingID)));
			if($this->request->data['JobPosting']['security_clearance_code']!=''){
				$this->set("securityClearanceCode",explode(",",$this->request->data['JobPosting']['security_clearance_code']));
			}
		}
		
	}
	
	/***** Function for email to friend ******/
	function emailjob($postingID = null){
		$errorsArr = "";
		$this->set('meta_title','Email this job to a friend');
		// load the models
		$this->loadModel('JobPosting');
		$jobdetail = $this->JobPosting->find("first",array('conditions'=>array('JobPosting.posting_id'=>$postingID)));
		$this->set("jobdetail",$jobdetail);
			
		if($this->request->is('post')){
			// Check whether all data is valid or not
			if($this->request->data['JobPosting']['friendEmail']!=''){
				$friendEmails = explode(",",$this->request->data['JobPosting']['friendEmail']);
				foreach($friendEmails as $key => $friendemail){
					$this->request->data['JobPosting']['friendEmail'] = $friendemail;
					$this->JobPosting->set($this->request->data);
					// check data if it is valid or not
					if(!$this->JobPosting->validates()){
						$errorsArr = $this->JobPosting->validationErrors;	
					}//endif	
				}//endforeach	
			}//endif	
				if(empty($this->request->data['JobPosting']['friendEmail']))
				{
						$this->Session->write('popup','Please enter friends email address');
						$this->redirect(array('controller'=>'employers','action' => "emailjob",$postingID));
				}
					
					
			if(!$errorsArr){

				$jobTitle 				= 	$jobdetail['JobPosting']['job_title'];
				$jobEmployer 			= 	$jobdetail['Employer']['employer_name'];
				$jobSalary 				= 	$jobdetail['JobPosting']['last_salary'];
				$jobLocationCity 		= 	$jobdetail['JobPosting']['location_city'];
				$jobLocationState 	= 	$jobdetail['JobPosting']['location_state'];
				$jobShortDesc 		= 	$jobdetail['JobPosting']['short_descr'];
				$jobUrl					= FULL_BASE_URL.router::url('/',false).'employers/jobdetail/'.$postingID;
					
					// Email configuration
					$sendto = $this->request->data['JobPosting']['friendEmail'];
					$sendfrom = $this->request->data['JobPosting']['yourEmail'];
					$emailMessage = $this->request->data['JobPosting']['emailMessage'];
					
					$subject = "A friend is forwarding you a job posted on techexpoUSA.com";
					$bodyText = "This job was forwarded to you by someone you know. It was posted on TechExpoUSA.com, the career center of choice for all technology professionals. To view this job and apply click here:<br/>
					".$jobUrl."<br/><br/>
					
					*************************************************************************************
					
					<br/><br/>
					Your friend or relative's e-mail address:  ".$sendfrom."<br/><br/>
					Your friend or relative's message (optional): ".nl2br($emailMessage)."<br/><br/>
					Job Title: ".$jobTitle."<br/>
					Employer: ".$jobEmployer."<br/>
					Salary (not always indicated): ".$jobSalary."<br/>
					Location: ".$jobLocationCity.", ".$jobLocationState."<br/>
					Short Description: ".$jobShortDesc." ";
					
					$email = new CakeEmail('smtp');
					$email->from(array($sendfrom));
					$email->to($sendto);
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					$ok = $email->send($bodyText);
					
					if($ok){
						$this->Session->write('popup','Your job email to a friend has been sent successfully.');
						$this->redirect(array('controller'=>'employers','action' => "jobdetail",$postingID));
					}
			
			}
			
		}
		
	}
	
	/***** Function for registered event preparation ******/
	function empeventprep(){
		$this->set('meta_title','Employer Event Preparation');
		$this->loadModel('ShowEmployer');
		
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		
		if($this->request->is('get')){
			// get only one month old events
			//$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m")-1 , date("d"), date("Y")));
			
			$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d")-1, date("Y")));
			$condition  = "ShowEmployer.employer_id = ".$employerID." AND ShowEmployer.payment_status = 'y' AND Show.show_dt > '".$targetdate."' AND published = 1 ";	
			
			$this->paginate = array('limit' =>20,'order' => 'Show.show_dt ASC');
			$regEvents = $this->paginate('ShowEmployer', $condition);
			
			$this->set('regEvents',$regEvents);
		}
	
	}
	
	/***** Function for all upcoming event ******/
	function empevent(){
		$this->set('meta_title','Upcoming Event');
		$this->loadModel('Show');
		
		if($this->request->is('get')){
			$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			$condition  = "Show.show_dt > '".$targetdate."' and Show.published=1 AND Show.boutique = 'r'  ";	
			$this->Show->recursive =0;
			$this->paginate = array('limit' =>20,'order' => 'show_dt ASC');
			$upcomingEvents = $this->paginate('Show', $condition);
			$this->set('upcomingEvents',$upcomingEvents);
		}
		
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		$this->set('employerID',$employerID);
	
	}
	
	// Function for view the employer registered event detail information
	public function eventinfo($showID = null){
		$this->set('meta_title','Employer Registered Event Information');
		$this->loadModel('Show');
		
		if($this->request->is('get')){
			// get only one month old events
			/*$condition  = "Show.id = ".$showID." ";	
			$eventInfo = $this->Show->find("first",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'INNER',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
  		  ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=> $condition));
			$this->set('regEventInfo',$eventInfo);*/
			
			$this->loadModel('ShowsHome');
			$showEntCheck = $this->ShowsHome->find('count',array('conditions'=>array('ShowsHome.show_id'=>$showID)));
			if($showEntCheck==1)
			{
			
				$eventDetail = $this->Show->find("first",array('joins' => array(

				array(
				'table' => 'shows_home',
				'alias' => 'ShowsHome',
				'type' => 'LEFT',
				'conditions' => array(
					'ShowsHome.show_id = Show.id'
				)
			)
		),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('Show.id'=>$showID)));
			$this->set('regEventInfo',$eventDetail);
			}
			else
			{
			 $eventDetail =	$this->Show->find('first',array('fields' => array('Show.*'),'conditions'=> array('Show.id'=>$showID)));
			 $this->set('regEventInfo',$eventDetail);				
			}
			
			
			// get the list of other employers who are also registered with this event
			$options['joins'] = array(
				array('table' => 'show_employers',
					'alias' => 'ShowEmployer',
					'type' => 'inner',
					'conditions' => array(
						'ShowEmployer.employer_id = Employer.id',
					/*	'ShowEmployer.payment_status' => 'y',*/ //task id 2309
						'ShowEmployer.show_id = '.$showID						
					)
				)
			);
			$options['order'] = array("Employer.employer_name ASC");
			//$options['fields'] = array('id','employer_name','logo_file');
			$this->Employer->recursive = 1;
			$otherRegEmployer = $this->Employer->find('all', $options);
			//pr($otherRegEmployer);
			$this->set('otherRegEmployer',$otherRegEmployer);
			// task id 3853
			$this->set('show_id',$showID);
		}
	}
	
	// Function for view the list of interview candidates
	public function eventInterviewList($showID = null,$employerID = null){
		$this->set('meta_title','Interview list of candidates');
		$this->loadModel('Resume');
		
		if($this->request->is('get')){
			if($showID!='' && $employerID!=''){
				//$this->Resume->recursive = 0;
				
				$options['joins'] = array(
				array('table' => 'show_interviews',
					'alias' => 'ShowInterview',					
					'type' => 'inner',
					'conditions' => array(
						'ShowInterview.candidate_id = Resume.candidate_id',
						'ShowInterview.show_id = '.$showID,
						'ShowInterview.employer_id = '.$employerID						
					)
				)
			);
			$this->Resume->recursive = 0;
			$candidates = $this->Resume->find('all',$options);
			//pr($candidates);
			$this->set('interviewList',$candidates);
				
			}else{
				$this->Session->write('popup','Can not find interview list for this Event and Company');
				$this->redirect(array('controller'=>'employers','action' => "empeventprep"));
			}
		}
		
	}
	
	/***** function for getting the list of cadidates who applied on jobs *****/
	function empinterview(){
		$this->set('meta_title','Schedule Interview of cadidates');
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		
		// last 3 month records apurav 12182012
		$lastdate = date("Y-m-d",mktime(0, 0, 0, date("m")-3, date("d"), date("Y")));
	
		$apply_list = $this->ApplyHistory->find('all',array('conditions'=>array('ApplyHistory.employer_id'=> $employerID,'ApplyHistory.dt >'=>$lastdate ),'fields'=>array('Candidate.candidate_name','ApplyHistory.job_title','ApplyHistory.resume_id','ApplyHistory.dt','ApplyHistory.posting_id','Candidate.id')));
		$this->loadModel('ShowEmployer');
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		
		// get only one month old events
		$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m"), date("d"), date("Y")));
		$condition  = "ShowEmployer.employer_id = ".$employerID."  AND Show.show_dt > '".$targetdate."' ";
		// updated 31 july 2013
	//	$condition  = "ShowEmployer.employer_id = ".$employerID." AND ShowEmployer.payment_status = 'y' AND Show.show_dt > '".$targetdate."' ";
		$events = $this->ShowEmployer->find('all',array('conditions'=>$condition,'fields'=>array('Show.id','Show.show_name','Show.show_dt')));
		//$event_list = Set::combine($events1, '{n}.Show.id', array('{0}', '{n}.Show.show_name'));
		
		
		if($this->request->data && $this->request->is('post')){
	
		
		 foreach($this->request->data['Candidate']['show_id'] as  $key=>$record){
				
				if($record)
				{
					//echo $key.'++++'.$record.'&nbsp;&nbsp;&nbsp;&nbsp;';
					//echo $this->request->data['Candidate']['id'][$key].'<br>';
					$show_id = $record;
					$candidate_id = current(explode('-',$this->request->data['Candidate']['id'][$key]));
					
					$posting_id = end(explode('-',$this->request->data['Candidate']['id'][$key]));
					
					$check_record = $this->ShowInterview->find('first',array('conditions'=>array('ShowInterview.show_id'=>$show_id,'ShowInterview.candidate_id'=>$candidate_id,'ShowInterview.employer_id'=>$employerID)));
					
					
					
						if(empty($check_record))
						{	
							$interview['ShowInterview']['show_id'] = $show_id ;
							$interview['ShowInterview']['candidate_id'] = $candidate_id;
							$interview['ShowInterview']['employer_id'] =  $employerID;
							$interview['ShowInterview']['posting_id'] =  $posting_id;
						
							if($this->ShowInterview->save($interview))
							
							$this->ApplyHistory->deleteAll(array('ApplyHistory.candidate_id'=>$candidate_id,'ApplyHistory.employer_id'=>$employerID,'ApplyHistory.posting_id'=>$posting_id), false);
						
						}
						
						$this->Session->write('popup','Interview Scheduled successfully.');
						$this->redirect(array('controller'=>'employers','action'=>'empinterview'));
					
				}
			
		 }
		 
		
		}
		
		$this->set('events',$events);
		$this->set('apply_list',$apply_list);
	}
	
	/**** function for show travel direction *******/
	function traveldirection($showID=null){
		$this->set('meta_title','Travel Direction');
		$this->loadModel('Show');
		
		if($this->request->is('get')){
			// get only one month old events.
			$this->Show->recursive = 0;
			$condition  = "Show.id = ".$showID." ";	
			$eventInfo = $this->Show->find("first",array('fields'=>array('id','show_name','show_dt','show_end_dt','location_id','show_travel_dir','Location.*'),'conditions'=>array($condition)));
			$this->set('regEventInfo',$eventInfo);
		}
	}	
	
	/******* function for emp exhibitor resources *******/
	function empexhibitor(){
		$this->set('meta_title','Exhibitor Resources');
		$this->loadModel('Exhibitor');
		$exhibitorList = $this->Exhibitor->find('all',array('order'=>'id DESC'));
		$this->set('exhibitorLists',$exhibitorList);
		
	}

	/******* function for marketing partner *******/
	function partners(){
		$this->set('meta_title','Marketing Partners');
		$this->loadModel('MarketingExhibitor');
		$marketingExhibitorList = $this->MarketingExhibitor->find('all',array('order'=>'title ASC'));
		$this->set('exhibitorLists',$marketingExhibitorList);
		
	}	
	/*************** upload logo **********************/
	public function profileImage($showID = null)
	{
		if($this->request->data)
		{
			if($this->request->data['UPLOAD']='UPLOAD')
			{
				//pr($this->request->data);die;
				$this->Employer->set($this->request->data);  // check validation and save record	
				$errorsArr=array();
				
				if(!$this->Employer->uploadProfileImage()) 
				{
				  	$errorsArr = $this->Employer->validationErrors;	
				
				}
				else
				{
					/*$name = time().'_'.$this->data['Employer']['logo_file']['name']; // move file
					move_uploaded_file( $this->data['Employer']['logo_file']['tmp_name'], "upload/" .$name);
					$this->request->data['Employer']['id']=$this->Session->read('Auth.Client.employerContact.employer_id');
					$this->request->data['Employer']['logo_file']=$name;*/
					//echo $this->request->data['Employer']['logo_file'];die;
					App::import('Vendor', 'Uploader.Uploader');
					$this->Uploader = new Uploader();
					$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'upload/'));
					$timeSet = time();
					$fileUploadPath=$this->Uploader->upload($this->request->data['Employer']['logo_file'],array('prepend'=>$timeSet.'_','overwrite'=>true));  
					 $this->Uploader->resize(array('width' => '150','height' => '80','prepend'=>"150x80_".$timeSet."_",'append'=>false,'aspect'=>true,'expand'=>false));
				//	 $this->Uploader->resize(array('width' => '210','height' => '140','prepend'=>"cropped0_".$timeSet."_",'append'=>false,'aspect'=>true,'expand'=>false));
				//	 $this->Uploader->crop(array('width' => 210, 'height' => 140,'prepend'=>"cropped_".$timeSet."_",'append'=>false, 'location' => Uploader::LOC_CENTER));
					$this->request->data['Employer']['id']=$this->Session->read('Auth.Client.employerContact.employer_id');
					$this->request->data['Employer']['logo_file'] 	=  end(explode('/',$fileUploadPath['path']));
				
									
					$employerRec=$this->Employer->find('first',array('fields'=>'logo_file',
																		'conditions'=>'Employer.id="'.$this->Session->read('Auth.Client.employerContact.employer_id').'"'));
					
					
					if($employerRec['Employer']['logo_file'])
					{
						unlink("upload/".$employerRec['Employer']['logo_file']);
						unlink("upload/150x80_".$employerRec['Employer']['logo_file']);
					}
				
					
				
					
					$this->Employer->set($this->request->data); 
					if($this->Employer->save($this->request->data))
					{
						$this->Session->write('popup','Your company logo has been updated successfully.');
						$this->redirect(array('controller'=>'employers','action'=>'profileImage'));
					}
					 
				}
			}
		
		}else
		{
			$this->Employer->id=$this->Session->read('Auth.Client.employerContact.employer_id');
			$this->request->data['Employer']['logo_description']=$this->Employer->field('logo_description');
			$this->request->data['Employer']['old_logo']=$this->Employer->field('logo_file');
		}
		
	//	$this->set('description',$this->Employer->find('first',array('fields'=>'profile_description,candidate_image','conditions'=>'Employer.id="'.$this->Session->read('Auth.Client.employerContact.employer_id').'"')));
	}
	
	/*************** upload logo **********************/
	public function empVideo($action = null,$id = null  )
	{
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		
		$employervideo_list =  $this->EmployerVideo->find('all',array('conditions'=>array('EmployerVideo.employer_id'=>$employerID,'EmployerVideo.isApproved'=>'Y'),'limit'=>'5'));
		$this->set('employervideo_list',$employervideo_list);
		
			$this->Employer->set($this->request->data);  // check validation and save record	
				$errorsArr=array();
				
		 if($this->request->data)
		{	
			if(count($employervideo_list)>4)
			{
				$this->Session->write('popup','You can\'t upload more then 5 video .');
				$this->redirect(array('controller'=>'employers','action' => "empVideo"));
			}
			
			
			if($this->request->data['Employer']['video_type']=='youtube')
			{
			$this->request->data['EmployerVideo']=$this->request->data['Employer'];	
			$this->request->data['EmployerVideo']['employer_id']= $employerID;
		//		pr($this->request->data);die;
			$this->EmployerVideo->save($this->request->data); 	
			
			//$this->Session->write('popup','Video uploaded successfully.');
			//$this->redirect(array('controller'=>'employers','action' => "empVideo"));
			
			}
			else if($this->request->data['Employer']['video_type']=='upload')
			{	
					$name = time().'_'.$this->data['Employer']['video2']['name']; // move file
					move_uploaded_file( $this->data['Employer']['video2']['tmp_name'], "upload/video/employer/" .$name);
					$this->request->data['Employer']['video']=$name;
										
					
					$this->request->data['EmployerVideo']=$this->request->data['Employer'];	
					$this->request->data['EmployerVideo']['employer_id']= $employerID;
			
					$this->EmployerVideo->save($this->request->data);
					
					 
			}
			
			// mail to admin
						$sendto =array('brand@techexpousa.com','pprobert@techexpousa.com','kfuller@techexpousa.com');
						$sendfrom = $this->Session->read('Auth.Client.employerContact.contact_email');
						
						$subject = "Confirmation of employer video";
						$bodyText = "Employer has been uploaded new video please test and verify.";
						
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
			
			$this->Session->write('popup','Thank you for submitting your video. Our TECHEXPO team is reviewing your video and should appear in your dashboard shortly.');
			$this->redirect(array('controller'=>'employers','action' => "empVideo"));
			
		}
		
		if(!empty($id) && $action=='delete')
		{	 
			
			if($this->EmployerVideo->find('count',array('conditions'=>'EmployerVideo.id="'.$id.'" and EmployerVideo.employer_id="'.$employerID.'"','action'=>'')))
			{
				$this->EmployerVideo->delete($id);
				$this->Session->write('popup','Video has been deleted successfully.');
				$this->redirect(array('controller'=>'employers','action'=>'empVideo'));
			}
			else
			{
				$this->Session->write('popup','video not have a permission to delete.');
				$this->redirect(array('controller'=>'employers','action'=>'empVideo'));			
			}
		}
		
	}
	public function empshowVideo($id = null  )
	{ 
		$this->layout = false;
	//	$this->autoRender = false; 
		$video_dt = $this->EmployerVideo->find('first',array('conditions'=>array('EmployerVideo.id'=>$id)));
		$this->set('video_dt',$video_dt);
	}
	
	// set as desktop video 
	public function setDeskVideo($id = null  )
	{ 
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		$this->layout = false;
		$this->autoRender = false; 
		
		$this->EmployerVideo->query("UPDATE employer_videos SET set_dashboard = '0' WHERE employer_id =".$employerID);
		
		if(!empty($id))
		{
		$this->request->data['EmployerVideo']['id']=$id;
		$this->request->data['EmployerVideo']['set_dashboard']='1';	
		$this->EmployerVideo->save($this->request->data);
		$this->Session->write('popup','Video Set for your Dashboard.');
		$this->redirect(array('controller'=>'employers','action'=>'empVideo'));
		}
	}
	
	public function empeditVideo($id = null  )
	{
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		
			if($this->request->data)
			{
				$this->request->data['Employer']['video_type']=$this->request->data['EmployerVideo']['video_type'];
				$video_detail=$this->request->data;
			
				if($video_detail['EmployerVideo']['video_type']=='youtube')
				{
				
				$this->request->data['EmployerVideo']['description'] = $this->request->data['Employer']['description'];
				$this->request->data['EmployerVideo']['video'] = $this->request->data['Employer']['video'];
				$this->request->data['EmployerVideo']['id']= $id;
				$this->EmployerVideo->save($this->request->data); 	
				$this->Session->write('popup','Video Edited successfully.');
				$this->redirect(array('controller'=>'employers','action' => "empVideo"));
				}
				else if($video_detail['EmployerVideo']['video_type']=='upload')
				{	
						$name = time().'_'.$this->data['Employer']['video2']['name']; // move file
						move_uploaded_file( $this->data['Employer']['video2']['tmp_name'], "upload/video/employer/" .$name);
						$this->request->data['Employer']['video']=$name;
						//echo $this->request->data['Employer']['logo_file'];die;
						
										
						$employerVid=$this->EmployerVideo->find('first',array('fields'=>'video',
																			'conditions'=>'EmployerVideo.id="'.$id.'"'));
						if($employerVid['EmployerVideo']['video'])
						{
							@unlink("upload/video/employer/".$employerVid['EmployerVideo']['video']);
						}
						
						
						$this->request->data['EmployerVideo']['description'] = $this->request->data['Employer']['description'];
						$this->request->data['EmployerVideo']['video'] = $this->request->data['Employer']['video'];
						$this->request->data['EmployerVideo']['id']= $id;
				
						if($this->EmployerVideo->save($this->request->data))
						{
							$this->Session->write('popup','Video updated successfully.');
							$this->redirect(array('controller'=>'employers','action' => "empVideo"));
						}
				
				}
				
			
			}else
			{
				$video_detail = $this->EmployerVideo->find('first',array('conditions'=>'EmployerVideo.id="'.$id.'" and EmployerVideo.employer_id="'.$employerID.'"','action'=>''));
				$this->request->data=$video_detail;
				
				$this->set('video_detail',$video_detail);
			}
		
			
			
			
		
	}
	
	/*********************Job seeker video List***********************/
	public function empJobseekerVideo(){
		$this->set('meta_title','Job seeker video List');
		
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		/*$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m")-1 , date("d"), date("Y")));
		$condition  = "ShowEmployer.employer_id = ".$employerID." AND ShowEmployer.payment_status = 'y' AND Show.show_dt > ".$targetdate." ";	
		$events = $this->ShowEmployer->find('all',array('conditions'=>$condition,'fields' => array('ShowEmployer.show_id')));
	
		$eventstring ='';
		if(count($events) > 1){
		foreach ($events as $events)
		{
			$eventstring.= $events['ShowEmployer']['show_id'].',';
			
		}
		}
		
		$candidateLists = $this->Registration->find('all',array('conditions'=>' Registration.show_id in (\''.$eventstring.'\') ','fields'=>array('candidate_id')));
			
		$candidatestring ='';
		if(count($candidateLists) > 1){
		foreach ($candidateLists as $candidateLists)
		{
			$candidatestring.= $candidateLists['Registration']['candidate_id'].',';
			
		}
		}*/
		
		$candidateLists = $this->ApplyHistory->find('all',array('conditions'=>array('ApplyHistory.employer_id'=>$employerID),'fields'=>array('candidate_id')));
		
			
		$candidatestring ='';
		$countIds = count($candidateLists);
		$i = 1;
		if($countIds > 0){
		foreach ($candidateLists as $candidateLists)
		{
			if($i!=$countIds)	
			$candidatestring.= '\''.$candidateLists['ApplyHistory']['candidate_id'].'\',';
			else
			$candidatestring.= '\''.$candidateLists['ApplyHistory']['candidate_id'].'\'';
			
			$i++;
		}
		}
		
		if(!empty($candidatestring))
		{
		$jobseekervideo_list = $this->CandidateVideo->find('all',array('conditions'=>' CandidateVideo.candidate_id in ('.$candidatestring.') ','fields'=>array('CandidateVideo.*','Candidate.id','Candidate.candidate_name'),'limit'=>5));
	
		$this->set('jobseekervideo_list',$jobseekervideo_list);
		}
		else
		{
			$this->set('jobseekervideo_list',null);
			
		}
	}
	
	/********* function for creating event registration form **********/
	
	public function eventregistrationform(){
		$this->set('meta_title','Event Registration Form');
	}
	
	/********* function for creating event registration form **********/
	public function recruitattechexpo(){
		$this->set('meta_title','Recruit @ Techexpo');
	}
 
 	function addSkill()
	{
	
		if($_GET['name'] and $_GET['number'])
		{
		
			$skillsList=$this->Code->find('count',array('conditions'=>'code_name="Skills" and code_descr="'.$_GET['name'].'"'));
			 if($skillsList)
			 {
				echo '<div style="color:red">This keyword already exits in our database</div>';	
				
				exit;
			 }else
			 {
			
				$this->request->data['Code']['code_name']='Skills';
				$this->request->data['Code']['visible']='Y';
				$this->request->data['Code']['code_descr']=$_GET['name'];
				$this->Code->save($this->request->data);
				
				$this->set('number',$_GET['number']);
				$keywordArray=$this->common->getKeywordList();
				$keywordArray['addNewSkill']='Add New Skill';
							   ksort($keywordArray);
							   
							   
							
				$this->set('skills',$keywordArray);
			}
			
		}else
		{
				$this->redirect(array('controller'=>'users','action'=>'index','Jobseeker'=>false));
		}
	
	}
 
 	function city($state=NULL)
	{
	
		$this->layout=false;
		$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$state.'"','fields'=>'city,city','order by city ASC'));
		$this->set('cityList',$cityList);
	}
	
	function empcotactcity($state=NULL)
	{
	
		$this->layout=false;
		$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$state.'"','fields'=>'city,city','order by city ASC'));
		$this->set('cityList',$cityList);
	}
	
	
	
	function jobcity($state=NULL)
	{
	
		$this->layout=false;
		$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$state.'"','fields'=>'city,city','order by city ASC'));
		$this->set('cityList',$cityList);
	}
 
	function beforeFilter() 
	{ 
		parent::beforeFilter();
		
//		$usertype=$this->Session->read('Auth.Clients.user_type');
		$usertype=$this->Session->read('Auth.Clients.user_type');
		$this->isEmployerLogin();
		if($usertype=='E')
		{
			$this->Auth->allow('*');
		}else
		{
			$this->Auth->allow('profile','jobdetail','emailjob','eventregistrationform','recruitattechexpo','empexhibitor','empshowVideo','city','viewprofile','empcotactcity','partners');
		}
		
		
   	}
	
	
	
}//end class
?>