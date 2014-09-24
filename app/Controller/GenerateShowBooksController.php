<?php
App::uses('CakeEmail', 'Network/Email');
class GenerateShowBooksController extends AppController {

    var $layout = 'admin'; //this is the layout for admin panel     
    var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array('ShowCompanyProfile','ShowEmployer','Employer','JobPosting','Show','EmployerContact');
	
	// function for showing the form list of shows to generate profile report
	public function superadmin_index() { 
		$this->set('meta_title','Generate Show Books');
		
		$cutoff_date = date("Y")."-01-01";
		$condition = "Show.show_dt > '".$cutoff_date."'";
		$this->Show->recursive = 0;
		$eventList = $this->Show->find("all",array('fields'=>array('Show.id','Show.show_dt','Show.show_name','Location.location_city','Location.location_state'),'order'=>array('Show.show_dt'),'conditions'=>$condition));
		$this->set("eventList",$eventList);
		
	}
	
	// function for showing the form list of shows to generate profile report
	public function superadmin_cmpprofileforshow(){ 
		$this->set('meta_title','Company profile for Show');
		
		if($this->request->is('get')){
			
			
			
			
			
			$showID = $this->request->query['show_id'];
			
			
			$this->requestAction(
				array('superadmin'=>true,'controller' => 'shows', 'action' => 'wordguidefile',$showID)
				
			);
			
			
			
			
			
			$this->set('show_name',$this->request->query['show_name']);
			$this->set('show_dt',$this->request->query['show_dt']);
			$this->set('show_id',$showID);
			// get all employer assign to this show
			$this->ShowEmployer->recursive = -1;
			$showEmployers = $this->ShowEmployer->find("all",array('conditions'=>array('ShowEmployer.show_id'=>$showID)));
			// check for all employers of this show have an exhibitor profile, if not have the create from here
			foreach($showEmployers as $showemployer){
				$checkShowprofilecount = $this->ShowCompanyProfile->find("count", array('conditions'=>array('show_id'=>$showID,'employer_id'=>$showemployer['ShowEmployer']['employer_id'])));
				// check employer of this show have an exhibitor profile or not, if  not crate from here
				if($checkShowprofilecount==0){
					// create an event exhibitor Profile
					$data['ShowCompanyProfile']['show_id'] = $showID;
					$data['ShowCompanyProfile']['employer_id'] = $showemployer['ShowEmployer']['employer_id'];
					$this->ShowCompanyProfile->save($data);
				}
			}
			
			// get all exhibitor profiles for this show
			$options['joins'] = array(
				array('table' => 'show_employers',
					'alias' => 'ShowEmployer',
					'type' => 'inner',
					'conditions' => array(
						"ShowEmployer.employer_id = ShowCompanyProfile.employer_id",
						"ShowEmployer.show_id = '".$showID."'"
					)
				)
			);
			$options['conditions'] = array('ShowCompanyProfile.show_id'=>$showID);
			$options['fields'] = array('ShowCompanyProfile.*,Employer.*,ShowEmployer.*');
			$options['order'] = array('Employer.employer_name');
			
			$companyProfiles = $this->ShowCompanyProfile->find("all", $options);
			$this->set('get_profiles',$companyProfiles);
			//pr($companyProfiles);
		}
		
	}
	
	/**** Function for update compnay profiles ***********/
	public function superadmin_updateshowprofile(){
			//pr($this->request->data);
			if($this->request->data['Submit']=='Update!'){
				$employers = $this->request->data['employerID'];
				$show_id = $this->request->data['show_id'];
				//update show profiles
				foreach($employers as $employerID){
					$company_name 		= $this->request->data['ShowCompanyProfile']['company_name'.$employerID.''];
					$num_badges 		= $this->request->data['ShowCompanyProfile']['num_badges'.$employerID.''];
					$num_lunch_tickets = $this->request->data['ShowCompanyProfile']['num_lunch_tickets'.$employerID.''];
					$electricity 			= $this->request->data['ShowCompanyProfile']['electricity'.$employerID.''];
					$phone 					= $this->request->data['ShowCompanyProfile']['phone'.$employerID.''];
					$booth 					= $this->request->data['ShowCompanyProfile']['booth'.$employerID.''];
					$booth_size 			= $this->request->data['ShowCompanyProfile']['booth_size'.$employerID.''];
					$second_booth 		= $this->request->data['ShowCompanyProfile']['second_booth'.$employerID.''];
					$easel 					= $this->request->data['ShowCompanyProfile']['easel'.$employerID.''];
					$wall 					= $this->request->data['ShowCompanyProfile']['wall'.$employerID.''];
					$free 					= $this->request->data['ShowCompanyProfile']['free'.$employerID.''];
					$booth_num 			= $this->request->data['ShowCompanyProfile']['booth_num'.$employerID.''];
					
					$showProfileData = array('ShowCompanyProfile.company_name'=>"'".$company_name."'",'ShowCompanyProfile.num_badges'=>"'".$num_badges."'",'ShowCompanyProfile.num_lunch_tickets'=>"'".$num_lunch_tickets."'",'ShowCompanyProfile.electricity'=>"'".$electricity."'",'ShowCompanyProfile.booth'=>"'".$booth."'",'ShowCompanyProfile.booth_size'=>"'".$booth_size."'",'ShowCompanyProfile.second_booth'=>"'".$second_booth."'",'ShowCompanyProfile.easel'=>"'".$easel."'",'ShowCompanyProfile.phone'=>"'".$phone."'",'ShowCompanyProfile.wall'=>"'".$wall."'",'ShowCompanyProfile.free'=>"'".$free."'",'ShowCompanyProfile.booth_num'=>"'".$booth_num."'");
					
					$showProfileCondition = array('ShowCompanyProfile.employer_id'=>$employerID,'ShowCompanyProfile.show_id'=>$show_id);
					//update here
					$this->ShowCompanyProfile->updateAll($showProfileData, $showProfileCondition);
				}	
				
				$this->Show->recursive = -1;
				$show = $this->Show->find('first',array('fields'=>array('Show.show_name','Show.show_dt'),'conditions'=>array('Show.id'=>$show_id)));
				
				//redirect to previous page.
				$this->Session->write('popup','Company Show profiles has been updated successfully.');
				$this->Session->setFlash('Company Show profiles has been updated successfully.');  
				$this->redirect(array('controller'=>'generate_show_books','action' => "cmpprofileforshow/message:success","?" => array("show_id" =>$show_id,"show_name" =>$show['Show']['show_name'],"show_dt"=>$show['Show']['show_dt'])));
				
			}
	}
	
	/****** Function for sending mass email ******/
	public function superadmin_sendmassemail($showID=null, $option=null){
		$this->set('meta_title','Send Mass Email to Clients');
		$this->set('showID',$showID);
		$this->set('option',$option);
		
		$cutoff_date = "2001-01-01";
		$condition = "Show.show_dt > '".$cutoff_date."'";
		$this->Show->recursive = 0;
		$eventList = $this->Show->find("all",array('fields'=>array('Show.id','Show.show_dt','Show.show_name','Location.location_city','Location.location_state','Location.site_name'),'order'=>array('Location.location_city','Location.location_state','Show.show_dt'),'conditions'=>$condition));
		$this->set("eventList",$eventList);
	}
	
	public function superadmin_massemailstep2(){
		$this->set('meta_title','Send Mass Email to Clients');
		
		if($this->request->is('post')){
			$condition = "Show.id = ".$this->request->data['Show']['show_id']." ";
			$this->Show->recursive = 0;
			$eventDetail = $this->Show->find("first",array('fields'=>array('Show.id','Show.show_dt','Show.show_name','Location.location_city','Location.location_state','Location.site_name'),'conditions'=>$condition));
			//pr($eventDetail);
			$this->set("event",$eventDetail);
			$this->set("showID",$this->request->data['Show']['show_id']);
			$this->set('option',$this->request->data['Show']['send_option']);
		}
	
	}
	
	public function superadmin_massemailstep3(){
		$this->autoRender =false;
		$this->set('meta_title','Send Mass Email to Clients');
		if($this->request->is('post')){
			//pr($this->request->data);
			$showID1 = $this->request->data['Show']['show_id'];
			$showID2 = $this->request->data['Show']['show_id'];
			$send_option = $this->request->data['Show']['send_option2'];
			if(($showID2!='00') && ($showID2!= '01') && ($showID2!= '02') && ($showID2!= '03')){
				if($send_option=='p'){
					$options['joins'] = array(
						array('table' => 'show_employers',
							'alias' => 'ShowEmployer',
							'type' => 'inner',
							'conditions' => array(
								"ShowEmployer.employer_id = Employer.id"
							)
						)
					);
					$options['conditions'] = array(
						"ShowEmployer.show_id = '".$showID2."'",
						"ShowEmployer.virtual = 'n'",
						"((Employer.description = '') OR (ShowEmployer.employer_id in (select employer_id from show_company_profiles where show_id='".$showID2."' and ((LENGTH(company_name) = 0) OR (company_name = '') OR (LENGTH(num_badges) = 0) OR (num_badges ='') OR (LENGTH(electricity) = 0) OR (electricity ='') OR (LENGTH(phone) = 0) OR (phone ='') OR (LENGTH(resume_access) = 0) OR (resume_access ='') OR (LENGTH(booth) = 0) OR (booth ='')))) OR (ShowEmployer.employer_id NOT IN (select employer_id from show_company_profiles)) )"						
					);
					
				}else{
					$options['joins'] = array(
						array('table' => 'show_employers',
							'alias' => 'ShowEmployer',
							'type' => 'inner',
							'conditions' => array(
								"ShowEmployer.employer_id = Employer.id"
							)
						)
					);
					if($send_option=='j'){
						$options['conditions'] = array(
							"ShowEmployer.show_id = '".$showID2."'",
							"ShowEmployer.virtual = 'n'",
							"ShowEmployer.employer_id NOT IN (select employer_id from job_postings)"
						);
					}else{
						$options['conditions'] = array(
							"ShowEmployer.show_id = '".$showID2."'",
							"ShowEmployer.virtual = 'n'"
						);
					}
				}
				// get the detail of show
				$condition = "Show.id = ".$showID2." ";
				$this->Show->recursive = 0;
				$eventDetail = $this->Show->find("first",array('fields'=>array('Show.id','Show.show_dt','Show.show_name','Location.location_city','Location.location_state','Location.site_name'),'conditions'=>$condition));
				
			}elseif($showID2=='00'){
				$options['joins'] = array();
			}elseif($showID2=='01'){
				$options['joins'] = array();
				$options['conditions'] = array(
					"Employer.id IN (select employer_id from employer_sets)"
				);
			}elseif($showID2=='02'){
				$options['joins'] = array();
				$options['conditions'] = array(
					"Employer.id IN (select employer_id from job_postings)"
				);
			}elseif($showID2=='03'){
				$options['joins'] = array();
				$options['conditions'] = array(
					"Employer.id NOT IN (select employer_id from job_postings)"
				);
			}
				
			$options['fields'] = array('Employer.employer_name','Employer.city','EmployerContact.employer_id','EmployerContact.contact_name','EmployerContact.contact_email','EmployerContact.id');
			$options['order'] = array('Employer.employer_name');
			$this->Employer->recursive = 0;
			$rec = $this->Employer->find('all', $options);
			
			$subject = $this->request->data['Show']['subject'];
			$message = nl2br($this->request->data['Show']['message']);
			
			foreach($rec as $employer){
					$userinfo = $this->common->usernamePassword($employer['EmployerContact']['id']);
					// send email to employer
					$email = new CakeEmail('smtp');
					$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					$bodyText = $message."<br/><br/>As a reminder, here is your login information:<br/><br/>username: ".$userinfo[0]."<br/>password: ".$userinfo[1]."<br/><br/>Sincerely,<br/><br/>Nancy Mathew<br/>Events Coordinator<br/>212.655.4505 ext. 225";
					
					$sendtoemails = explode(",",$employer['EmployerContact']['contact_email']);
					/* This should */
					if(is_array($sendtoemails)){
						foreach($sendtoemails as $sendTo){
							if(Validation::email($sendTo)){
								$email->to($sendTo);
								$email->send($bodyText);
							}
						}
					}
			}
			
			// email to president
			$email = new CakeEmail('smtp');
			$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
			$email->emailFormat('html');
			$email->subject(strip_tags($subject));
			$bodyText = "Dear Mr. President,<br/><br/>this is an automated message to notify you that our clients received the following message:<br/><br/>Subject: ".$subject."<br/><br/>".$message."<br/><br/>As a reminder, here is your login information:<br/><br/>username: ........(merge field)<br/>password: ........(merge field)<br/><br/>Sincerely,<br/><br/>Nancy Mathew<br/>Events Coordinator<br/>212.655.4505 ext. 225";
			
			if(Validation::email('brand@techexpoUSA.com')){
				$email->to('brand@techexpoUSA.com');
				$email->send($bodyText);
			}
			
			$this->Session->write('popup','Mass email sended successfully to clients.');
			$this->Session->setFlash('Mass email sended successfully to clients.');  
			$this->redirect(array('controller'=>'generate_show_books','action' => "cmpprofileforshow/message:success","?" => array("show_id" =>$showID1,"show_name" =>$eventDetail['Show']['show_name'],"show_dt"=>$eventDetail['Show']['show_dt'])));
			
						
		}
	
	}
	
	/******* Function for edit show profiles or exhibitior profiles ********/
	public function superadmin_viewshowprofile($employerID=null, $showID=null){
		$this->set('meta_title','View Edit Shows Profile');
		$this->set('showID',$showID);
		$this->set('employerID',$employerID);
		$jobs = '';
		$cnt = 1;
		
		$this->Show->recursive = -1;
		$showInfo = $this->Show->find('first',array('fields'=>array('Show.show_name','Show.show_dt'),'conditions'=>array('Show.id'=>$showID)));

		if(isset($this->request->data['Submit'])){
			
			if($this->request->data['Submit']=='Submit Event Profile'){
				//insert data in show profile
				$this->request->data['ShowCompanyProfile']['profile'] = '';
				$this->request->data['ShowCompanyProfile']['status'] = 'OK';
				$this->ShowCompanyProfile->save($this->request->data);
				$this->Session->write('popup','Show profile successfully created.');
				$this->Session->setFlash('Show profile successfully created.'); 
			}else{
				$this->request->data['ShowCompanyProfile']['profile'] = '';
				$this->ShowCompanyProfile->save($this->request->data);
				$this->Session->write('popup','Show profile successfully updated.');
				$this->Session->setFlash('Show profile successfully updated.'); 
			}		
			
			$this->redirect(array('controller'=>'generate_show_books','action' => "cmpprofileforshow/message:success","?" => array("show_id" =>$showID,"show_name" =>$showInfo['Show']['show_name'],"show_dt"=>$showInfo['Show']['show_dt'])));
				
		}
	
		//get jobs of employer
		$this->JobPosting->recursive = -1;
		$jobslist = $this->JobPosting->find('all',array('fields'=>'JobPosting.job_title','conditions'=>array('JobPosting.employer_id'=>$employerID),'order'=>array('JobPosting.start_dt desc')));
		
		foreach($jobslist as $job){
			if($cnt==1){
				$jobs .= $job['JobPosting']['job_title'];
			}else{
				$jobs .= ", ".$job['JobPosting']['job_title'];
			}
			$cnt=$cnt+1;
		}
		
		// get employer info
		$this->Employer->recursive = -1;
		$employer = $this->Employer->find('first',array('fields'=>array('employer_name','description'),'conditions'=>array('Employer.id'=>$employerID)));

		// check show profile is created or not
		$this->ShowCompanyProfile->recursive = -1;
		$this->request->data = $showProfile = $this->ShowCompanyProfile->find('first',array('conditions'=>array('ShowCompanyProfile.employer_id'=>$employerID,'ShowCompanyProfile.show_id'=>$showID)));
		
		if(count($showProfile)==0){
			$this->request->data['ShowCompanyProfile']['company_name'] = $employer['Employer']['employer_name'];
			$profile = $employer['Employer']['description'];
			$profile .= "<br/><br/>We are currently recruiting for the following jobs: ".$jobs;
			
		}else{
			if(strlen($showProfile['ShowCompanyProfile']['profile'])==0){
				$profile = $employer['Employer']['description'];
				$profile .= "<br/><br/>We are currently recruiting for the following jobs: ".$jobs;
			}
			if(strlen($showProfile['ShowCompanyProfile']['company_name'])==0){
				$this->request->data['ShowCompanyProfile']['company_name'] = $employer['Employer']['employer_name'];
			}
		
		}
		$this->set('profile',$profile);
		$this->set('showProfile',$showProfile);
		
	}
	
	/***** Function for sending email reminder to employer **********/
	public function superadmin_sendemailreminder($employerID=null, $showID=null){
		
		// employer contact info
		$employer = $this->EmployerContact->find('first',array('conditions'=>array('EmployerContact.employer_id'=>$employerID)));
		$this->set('employer',$employer);
		
		$this->Show->recursive = 0;
		$show = $this->Show->find('first',array('fields'=>array('Show.show_name','Show.show_dt','Location.location_city','Location.location_state'),'conditions'=>array('Show.id'=>$showID)));
		$this->set('show',$show);
		
		if($this->request->is('post')){
			//pr($this->request->data);
			// email to president
			$email = new CakeEmail('smtp');
			$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
			$email->emailFormat('html');
			$email->subject(strip_tags($this->request->data['ShowCompanyProfile']['subject']));
			
			if(Validation::email($this->request->data['ShowCompanyProfile']['sendto'])){
				$email->to($this->request->data['ShowCompanyProfile']['sendto']);
				$email->send(nl2br($this->request->data['ShowCompanyProfile']['message']));
			}
			
			$this->Session->write('popup','Reminder Email has been successfully sent');
			$this->Session->setFlash('Reminder Email has been successfully sent'); 
			$this->redirect(array('controller'=>'generate_show_books','action' => "cmpprofileforshow/message:success","?" => array("show_id" =>$showID,"show_name" =>$show['Show']['show_name'],"show_dt"=>$show['Show']['show_dt'])));
			
		}
				
	}
	
	/*This function is checking username and pasword in database and if true then redirect to home page */
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

?>