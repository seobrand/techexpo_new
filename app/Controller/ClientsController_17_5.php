<?php 
/**************************************************************************
 Coder  : Jitendra Pradhan  
 Object : Controller to registration process of client
**************************************************************************/ 
App::uses('CakeEmail', 'Network/Email');
class ClientsController extends AppController {
 	var $name = 'Clients'; //Model name attached with this controller 
    var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array('Employer','Show','ShowEmployer','ShowInterview','ShowCompanyProfile','EmployerContact','ResumeSetRule','ResumeSet','EmployerSet','Code','User','JobPosting','Folder','JobScore','ResumeScore','CustomEmployerSet','EmployerStat','EmployerLastVisit','ResumeAccessStat','OfccpTracking','Candidate','TrialAccount','TrialAccountTrack','EmployerEmailMessage','EmployerVideo');

	var $layout = 'admin'; //this is the layout for front panel 
	
	/******* Function for client's search form*********/
	public function superadmin_clientmanager(){ 
		$this->set('meta_title','Client Search');
		
		$letter = array('all'=>'show all','a'=>'a','b'=>'b','c'=>'c','d'=>'d','e'=>'e','f'=>'f','g'=>'g','h'=>'h','i'=>'i','j'=>'j','k'=>'k','l'=>'l','m'=>'m','n'=>'n','o'=>'o','p'=>'p','q'=>'q','r'=>'r','s'=>'s','t'=>'t','u'=>'u','v'=>'v','w'=>'w','x'=>'x','y'=>'y','z'=>'z');
		$this->set("letter",$letter);
	
	}
	
	/******* Function for client's search form*********/
	public function superadmin_clientsearch(){
		$this->set('meta_title','Client Search');
		$argArr = array(); 
		//pr($this->params);		
		
		if(isset($this->request->query) && count($this->request->query)>0) {
			if(isset($this->request->query['firstLetter']) && $this->request->query['firstLetter']!='') {
				$firstLetter = $this->request->query['firstLetter'];
				$argArr['firstLetter'] = $firstLetter;
				$Submit = "Save Letter Selection";
			}				
			if(isset($this->request->query['employer_name']) && $this->request->query['employer_name']!='') {
				$employer_name = $this->request->query['employer_name'];
				$argArr['employer_name'] = $employer_name;
				$Submit = "Search";
			}
			if(isset($this->request->query['employer_email']) && $this->request->query['employer_email']!='') {
				$employer_email = $this->request->query['employer_email'];
				$argArr['employer_email'] = $employer_email;
				$Submit = "Search By Email";
			}
			if(isset($this->request->query['limit']) && $this->request->query['limit']!='') {
				$limit = $this->request->query['limit'];
				$argArr['limit'] = $limit;
				$this->Session->write('per_page_record',$limit);
			}
		}
		
		if(isset($this->params['named']) && count($this->params['named'])>0){
			//pr($this->params);
			if(isset($this->params['named']['firstLetter']) && $this->params['named']['firstLetter']!='') {
				$firstLetter = $this->params['named']['firstLetter'];
				$argArr['firstLetter'] = $firstLetter;
				$Submit = "Save Letter Selection";
			}				
			if(isset($this->params['named']['employer_name']) && $this->params['named']['employer_name']!='') {
				$employer_name = $this->params['named']['employer_name'];
				$argArr['employer_name'] = $employer_name;
				$Submit = "Search";
			}
			if(isset($this->params['named']['employer_email']) && $this->params['named']['employer_email']!='') {
				$employer_email = $this->params['named']['employer_email'];
				$argArr['employer_email'] = $employer_email;
				$Submit = "Search By Email";
			}
			if(isset($this->params['named']['limit']) && $this->params['named']['limit']!='') {
				$limit = $this->params['named']['limit'];
				$argArr['limit'] = $limit;
				$this->Session->write('per_page_record',$limit);
			}
		}
			
		$this->set('argArr', $argArr); 
		
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		
		         if(isset($Submit)) { 
			if($Submit == 'Save Letter Selection'){
				$empLetter = $firstLetter;
				if($empLetter!='all'){
					$condition = "Employer.employer_name like '".$empLetter."%'";
				}else{
					$condition = "";
				}
				
				$this->Employer->recursive = 0;
				$this->paginate = array('limit' =>$record,'fields'=>array('Employer.id','Employer.employer_name','Employer.city','Employer.state','EmployerContact.id','EmployerContact.contact_name','EmployerContact.contact_email'),'order' => array('Employer.id'=>'DESC'));
				$employers = $this->paginate('Employer', $condition);
				$this->set('employers',$employers);
				
			}elseif($Submit == 'Search'){
				$empname = $employer_name;
				if($empname!=''){
					$condition = "Employer.employer_name like '".$empname."%'";
				}else{
					$condition = "";
				}
				$this->Employer->recursive = 0;
				$this->paginate = array('limit' =>$record,'fields'=>array('Employer.id','Employer.employer_name','Employer.city','Employer.state','EmployerContact.id','EmployerContact.contact_name','EmployerContact.contact_email'),'order' => array('id DESC'));
				$employers = $this->paginate('Employer', $condition);
				$this->set('employers',$employers);			
				
			}elseif($Submit == 'Search By Email'){
				$empemail = $employer_email;
				if($empemail!=''){
					$condition = "EmployerContact.contact_email like '".$empemail."%'";
				}else{
					$condition = "";
				}
				$this->Employer->recursive = 0;
				$this->paginate = array('limit' =>$record,'fields'=>array('Employer.id','Employer.employer_name','Employer.city','Employer.state','EmployerContact.id','EmployerContact.contact_name','EmployerContact.contact_email'),'order' => array('id DESC'));
				$employers = $this->paginate('Employer', $condition);
				$this->set('employers',$employers);		
					
			}
			$this->set('record',$record);
		 }else
		 { 
		 	$this->Session->write('popup','Please enter some value for search.');
			$this->Session->setFlash('Please enter some value for search.');
		 	$this->redirect(array('controller'=>'clients','action' => "clientmanager/message:error"));
		 }
				 
			
	}
	
	/***** For all new client listing ***********/
	function superadmin_allnewclient() {
		$this->set('meta_title','View All New Client');
		
		$condition = "EmployerContact.contact_name IS NULL AND EmployerContact.contact_email IS NOT NULL AND EmployerContact.created IS NOT NULL";
		$this->LoadModel('EmployerContact');
		$this->EmployerContact->recursive= 0;
		$this->paginate = array('limit' =>10,'fields'=>array('EmployerContact.*','Employer.*'),'order' => array('EmployerContact.id DESC'));
		$employers = $this->paginate('EmployerContact', $condition);
		$this->set('employers',$employers);			
			
	}
	
	/******* Function for client's detail*********/
	public function superadmin_clientdetail($employerID=null,$employerContactID=null){
				$this->set('meta_title','Client Detail');
				
				if($employerID!=''){
					$condition = "Employer.id = ".$employerID." AND EmployerContact.id = ".$employerContactID;
				}else{
					$condition = "";
				}
				
				$this->Employer->recursive = 0;
				$employer = $this->Employer->find('first',array('fields'=>array('Employer.id','Employer.employer_name','Employer.city','Employer.state','EmployerContact.id','EmployerContact.contact_name','EmployerContact.contact_email'),'conditions' => $condition));
				$this->set('employer',$employer);
	}
	
	/******* Function for assigning a client's to event*********/
	public function superadmin_assignevent($employerID=null){ 
		$this->set('meta_title','Assign Events to Client');
		
		$this->set("employerID",$employerID);
		
		if($this->request->is('get')){
			$cutoff_date = date("Y")."-01-01";
			$condition = "Show.show_dt > '".$cutoff_date."'";
			$this->Show->recursive = 0;
			$eventList = $this->Show->find("all",array('fields'=>array('Show.id','Show.show_dt','Show.show_confirm_file','Location.location_city','Location.location_state'),'order'=>array('Show.show_dt DESC'),'conditions'=>$condition));
			$this->set("eventList",$eventList);
			
		}
		
		if($this->request->is('post')){
			$content = '';
			if(isset($this->request->data['Show']['isAssign'])){
			
				//get employer details
				$employerContact = $this->EmployerContact->find('first',array('conditions'=>array('EmployerContact.employer_id'=>$employerID)));

				foreach($this->request->data['Show']['isAssign'] as $key => $showID ){
					//content to show as output
					$content .= '<font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="3"><b>Assign '.$this->request->data['Show']['employer_name'].' to events</cfoutput></b></font><br><br><br><br><b>Show: '.date("F d, Y",strtotime($this->request->data['Show']['show_dt'][$showID])).' - '.$this->request->data['Show']['location_city'][$showID].', '.$this->request->data['Show']['location_state'][$showID].'</b> -	';
					
					//check whether show confirm file exists
					$showConfirmFile = $this->request->data['Show']['show_confirm_file'][$showID];
					if(strlen($showConfirmFile)>0){
						$do_mail = 1;
					}else{
						$do_mail = 0;
					}
					
					// Check whether this event already assign or not
					$isExist = $this->ShowEmployer->find('count',array('conditions'=>array('show_id'=>$showID,'employer_id'=>$employerID)));
					if($isExist>0){
						$content .='<i><u>WAS ALREADY ASSIGNED TO THIS SHOW</u></i>';
					}elseif($isExist==0){
						// create an event exhibitor Profile
						$data['ShowCompanyProfile']['show_id'] = $showID;
						$data['ShowCompanyProfile']['employer_id'] = $employerID;
						$this->ShowCompanyProfile->save($data);
						
						//check what is exhibitor type select
						if($this->request->data['Show']['exhibitorType'][$showID]=='R'){
							$content .='Company assigned as UNPAID regular exhibitor - ';
							// Assign employer to this event as UNPAID regular exhibitor
							$showEmployerData['ShowEmployer']['show_id'] = $showID;
							$showEmployerData['ShowEmployer']['employer_id'] = $employerID;
							$showEmployerData['ShowEmployer']['payment_status'] = 'n';
							$showEmployerData['ShowEmployer']['virtual'] = 'n';
							$this->ShowEmployer->save($showEmployerData);
							//check whether mail sent IS YES
							if($this->request->data['Show']['emailSend'][$showID]=='Y'){
								if($do_mail==1){
									$content .='E-Mail sent';
									// send email to employer
									$attachfilePath = WWW_ROOT."ShowsDocument/showConfirmFile/".$showConfirmFile;
									
									$email = new CakeEmail();
									$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
									$subject = "Important TECHEXPO information";
									$email->emailFormat('html');
									$email->subject(strip_tags($subject));
									if(file_exists($attachfilePath)){
										$email->attachments(array($attachfilePath));
									}

									
									$bodyText = 'Dear TECHEXPO exhibitor,<br/><br/>Thank you for participating in '.$this->request->data['Show']['location_state'][$showID].'s TECHEXPO on '.date("F d, Y",strtotime($this->request->data['Show']['show_dt'][$showID])).'. You have just been assigned to the show on our website. Attached to this e-mail is your confirmation packet. Please print it out and review it carefully as it contains *VERY IMPORTANT* information. You can also download this packet from your employer homepage, below the "Show Registration & Resume Access Information" heading.<br/><br/>If you have not done so yet, please take a moment to complete your profile and post your 25 jobs at http://www.TechExpoUSA.com/users/login<br/><br/>Why is this important? By visiting the "Event information" areas of our site, technology professionals can see your company name, click on it to view your profile and open positions and apply directly online, sending resumes your way via e-mail. You can then get in touch with candidates via e-mail to schedule show day interviews in advance.  This is also where the site pulls your company information for the event gulde, which goes to print one week prior to the event. A completed profile also gives your company a more professional image and will increase traffic at your booth on the day of the show.<br/><br/>Thank you in advance for your cooperation.<br/><br/>Following the link included above will automatically log you in and take you to your employer home page, but as a reminder, here is your login information:<br/><br/>-Log in from the main homepage at http://www.TechExpoUSA.com<br/>-Your Username: '.$employerContact['User']['username'].' <br/>-Your Password: '.$employerContact['User']['old_password'].' <br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. <br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Director of Events and Marketing<br/>212.655.4505 ext. 225';
									$sendtoemails = explode(",",$employerContact['EmployerContact']['contact_email']);
									/********** Should be uncomment later ****
									if(is_array($sendtoemails)){
										foreach($sendtoemails as $sendTo){
											if(Validation::email($sendTo)){
												$email->to($sendTo);
												$email->send($bodyText);
											}
										}
									}*/
									
								}else{
									$content .='No E-Mail sent (confirmation packet missing)';
								}
							
							}else{
								$content .='No E-Mail sent';
							}
							
						}elseif($this->request->data['Show']['exhibitorType'][$showID]=='PR'){
							
							$content .='Company assigned as PAID regular exhibitor - ';
							// Assign employer to this event as UNPAID regular exhibitor
							$showEmployerData['ShowEmployer']['show_id'] = $showID;
							$showEmployerData['ShowEmployer']['employer_id'] = $employerID;
							$showEmployerData['ShowEmployer']['payment_status'] = 'y';
							$showEmployerData['ShowEmployer']['virtual'] = 'n';
							$this->ShowEmployer->save($showEmployerData);
							//check whether mail sent IS YES
							if($this->request->data['Show']['emailSend'][$showID]=='Y'){
								if($do_mail==1){
									$content .='E-Mail sent';
									// send email to employer
									$attachfilePath = WWW_ROOT."ShowsDocument/showConfirmFile/".$showConfirmFile;
									
									$email = new CakeEmail();
									$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
									$subject = "Important TECHEXPO information";
									$email->emailFormat('html');
									$email->subject(strip_tags($subject));
									if(file_exists($attachfilePath)){
										$email->attachments(array($attachfilePath));
									}
									
									$bodyText = 'Dear TECHEXPO exhibitor,<br/><br/>Thank you for participating in '.$this->request->data['Show']['location_state'][$showID].'s TECHEXPO on '.date("F d, Y",strtotime($this->request->data['Show']['show_dt'][$showID])).'. You have just been assigned to the show on our website. Attached to this e-mail is your confirmation packet. Please print it out and review it carefully as it contains *VERY IMPORTANT* information. You can also download this packet from your employer homepage, below the "Show Registration & Resume Access Information" heading.<br/><br/>If you have not done so yet, please take a moment to complete your profile and post your 25 jobs at http://www.TechExpoUSA.com/users/login<br/><br/>Why is this important? By visiting the "Event information" areas of our site, technology professionals can see your company name, click on it to view your profile and open positions and apply directly online, sending resumes your way via e-mail. You can then get in touch with candidates via e-mail to schedule show day interviews in advance.  This is also where the site pulls your company information for the event gulde, which goes to print one week prior to the event. A completed profile also gives your company a more professional image and will increase traffic at your booth on the day of the show.<br/><br/>Thank you in advance for your cooperation.<br/><br/>Following the link included above will automatically log you in and take you to your employer home page, but as a reminder, here is your login information:<br/><br/>-Log in from the main homepage at http://www.TechExpoUSA.com<br/>-Your Username: '.$employerContact['User']['username'].' <br/>-Your Password: '.$employerContact['User']['old_password'].' <br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. <br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Director of Events and Marketing<br/>212.655.4505 ext. 225';
									
									$sendtoemails = explode(",",$employerContact['EmployerContact']['contact_email']);
									/**** Should be uncomment later
									if(is_array($sendtoemails)){
										foreach($sendtoemails as $sendTo){
											if(Validation::email($sendTo)){
												$email->to($sendTo);
												$email->send($bodyText);
											}
										}
									}*/
									
								}else{
									$content .='No E-Mail sent (confirmation packet missing)';
								}
							
							}else{
								$content .='No E-Mail sent';
							}
												
						}elseif($this->request->data['Show']['exhibitorType'][$showID]=='V'){
											
							$content .='Company assigned as UNPAID virtual exhibitor - ';
							// Assign employer to this event as UNPAID virtual exhibitor
							$showEmployerData['ShowEmployer']['show_id'] = $showID;
							$showEmployerData['ShowEmployer']['employer_id'] = $employerID;
							$showEmployerData['ShowEmployer']['payment_status'] = 'n';
							$showEmployerData['ShowEmployer']['virtual'] = 'y';
							$this->ShowEmployer->save($showEmployerData);
							//check whether mail sent IS YES
							if($this->request->data['Show']['emailSend'][$showID]=='Y'){
								if($do_mail==1){
									$content .='E-Mail sent';
									// send email to employer
									$attachfilePath = WWW_ROOT."ShowsDocument/showConfirmFile/".$showConfirmFile;
									
									$email = new CakeEmail();
									$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
									$subject = "Important TECHEXPO information";
									$email->emailFormat('html');
									$email->subject(strip_tags($subject));
									if(file_exists($attachfilePath)){
										$email->attachments(array($attachfilePath));
									}
									
									$bodyText = 'Dear TechExpoUSA.com client,<br/><br/>Thank you for participating in our virtual job fair at our '.$this->request->data['Show']['location_state'][$showID].'s TECHEXPO on '.date("F d, Y",strtotime($this->request->data['Show']['show_dt'][$showID])).'. You have just been assigned to the show as a virtual exhibitor on our website.<br/><br/>The virtual job fair includes:<br/><br/>- A listing on the show information page as a virtual exhibitor, listed in purple font<br/>- The ability to post 25 jobs on our site<br/>- Access to the resume database for that event including both resumes collected at the show and those submitted online.<br/>- Inclusion In the event guide, which will be passed out on the day of the show. (You must fill out your company profile to be included)<br/><br/>If you have not done so yet, please take a moment to complete your profile and post your jobs at http://www.TechExpoUSA.com/users/login<br/><br/> This is also where the site pulls your company information for the show gulde, which goes to print one week prior to the event.<br/><br/>Why is this important? By visiting the "Event Information" areas of our site, technology professionals can see your company name, click on it to view your profile and open positions and apply directly online, sending resumes your way via e-mail. You can then get in touch with candidates via e-mail to schedule show day interviews in advance.  A completed profile also gives your company a more professional image and will increase your chances of getting responses.<br/><br/>Upon receipt of payment, access to the database will be turned on.  IF you have purchased the Virtual Job Fair to an event that has not yet happened, use the "search pre-registered candidates" tool.  If the event has already passed, please use the "search resumes" tool.<br/><br/>Following the link included above will automatically log you in and take you to your employer home page, but as a reminder, here is your login information:<br/><br/>-Log in from the main homepage at http://www.TechExpoUSA.com<br/><br/>-Your Username:  '.$employerContact['User']['username'].' <br/>-Your Password: '.$employerContact['User']['old_password'].' <br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. <br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Director of Events and Marketing<br/>212.655.4505 ext. 225';
									
									$sendtoemails = explode(",",$employerContact['EmployerContact']['contact_email']);
									/******* Should be uncomment later
									if(is_array($sendtoemails)){
										foreach($sendtoemails as $sendTo){
											if(Validation::email($sendTo)){
												$email->to($sendTo);
												$email->send($bodyText);
											}
										}
									}*/
																		
								}else{
									$content .='No E-Mail sent (confirmation packet missing)';
								}
							
							}else{
								$content .='No E-Mail sent';
							}
						
						}elseif($this->request->data['Show']['exhibitorType'][$showID]=='PV'){
							
							$content .='Company assigned as PAID virtual exhibitor - ';
							// Assign employer to this event as UNPAID virtual exhibitor
							$showEmployerData['ShowEmployer']['show_id'] = $showID;
							$showEmployerData['ShowEmployer']['employer_id'] = $employerID;
							$showEmployerData['ShowEmployer']['payment_status'] = 'y';
							$showEmployerData['ShowEmployer']['virtual'] = 'y';
							$this->ShowEmployer->save($showEmployerData);
							//check whether mail sent IS YES
							if($this->request->data['Show']['emailSend'][$showID]=='Y'){
								if($do_mail==1){
									$content .='E-Mail sent';
									// send email to employer
									$attachfilePath = WWW_ROOT."ShowsDocument/showConfirmFile/".$showConfirmFile;
									
									$email = new CakeEmail();
									$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
									$subject = "Important TECHEXPO information";
									$email->emailFormat('html');
									$email->subject(strip_tags($subject));
									if(file_exists($attachfilePath)){
										$email->attachments(array($attachfilePath));
									}
									
									$bodyText = 'Dear TechExpoUSA.com client,<br/><br/>Thank you for participating in our virtual job fair at our '.$this->request->data['Show']['location_state'][$showID].'s TECHEXPO on '.date("F d, Y",strtotime($this->request->data['Show']['show_dt'][$showID])).'. You have just been assigned to the show as a virtual exhibitor on our website.<br/><br/>The virtual job fair includes:<br/><br/>- A listing on the show information page as a virtual exhibitor, listed in purple font<br/>- The ability to post 25 jobs on our site<br/>- Access to the resume database for that event including both resumes collected at the show and those submitted online.<br/>- Inclusion In the event guide, which will be passed out on the day of the show. (You must fill out your company profile to be included)<br/><br/>If you have not done so yet, please take a moment to complete your profile and post your jobs at http://www.TechExpoUSA.com/users/login<br/><br/> This is also where the site pulls your company information for the show gulde, which goes to print one week prior to the event.<br/><br/>Why is this important? By visiting the "Event Information" areas of our site, technology professionals can see your company name, click on it to view your profile and open positions and apply directly online, sending resumes your way via e-mail. You can then get in touch with candidates via e-mail to schedule show day interviews in advance.  A completed profile also gives your company a more professional image and will increase your chances of getting responses.<br/><br/>Upon receipt of payment, access to the database will be turned on.  IF you have purchased the Virtual Job Fair to an event that has not yet happened, use the "search pre-registered candidates" tool.  If the event has already passed, please use the "search resumes" tool.<br/><br/>Following the link included above will automatically log you in and take you to your employer home page, but as a reminder, here is your login information:<br/><br/>-Log in from the main homepage at http://www.TechExpoUSA.com<br/><br/>-Your Username:  '.$employerContact['User']['username'].' <br/>-Your Password: '.$employerContact['User']['old_password'].' <br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. <br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Director of Events and Marketing<br/>212.655.4505 ext. 225';
									
									$sendtoemails = explode(",",$employerContact['EmployerContact']['contact_email']);
									/******* Should be uncomment later
									if(is_array($sendtoemails)){
										foreach($sendtoemails as $sendTo){
											if(Validation::email($sendTo)){
												$email->to($sendTo);
												$email->send($bodyText);
											}
										}
									}*/
									
								}else{
									$content .='No E-Mail sent (confirmation packet missing)';
								}
							
							}else{
								$content .='No E-Mail sent';
							}
						
						}
						 				
					}	
					
					$content .="<br/><br/><br/>";		
					
				}
				
				$this->set('content',$content);
				
			}
			
		}	
			
	}
	
	/******* Function for assigning a client's to resume database *********/
	public function superadmin_assignresumedb($employerID=null,$sendEmail=null){ 
		$this->set('meta_title','Assign resume set to clients');
		$employerSetID = array();
		
		$this->set("employerID",$employerID);
		$do_mail = $sendEmail;
		
		if($this->request->is('get')){
			// get employer resume set
			$empresumesetList = $this->EmployerSet->find("all",array('fields'=>array('EmployerSet.set_id'),'conditions'=>array('EmployerSet.employer_id'=>$employerID)));
			foreach($empresumesetList as $key =>$value){
				$employerSetID[]  =  $value['EmployerSet']['set_id'];
			}
			$this->set("employerSetID",$employerSetID);
			
		}
		
		if($this->request->is('post')){
			$content = '';
			//get employer details
			$employerContact = $this->EmployerContact->find('first',array('conditions'=>array('EmployerContact.employer_id'=>$employerID)));
			// Delete old employer resume set
			$this->EmployerSet->deleteAll(array('EmployerSet.employer_id' => $employerID), false);
			
			if(isset($this->request->data['ResumeSetRule']['isAssign'])){
				foreach($this->request->data['ResumeSetRule']['isAssign'] as $key => $resumeSetID ){
					// Check whether this resume set already assign or not
					$isExist = $this->EmployerSet->find('count',array('conditions'=>array('EmployerSet.set_id'=>$resumeSetID,'EmployerSet.employer_id'=>$employerID)));
					if($isExist==0){
						// Assign employer to this resume set
							$resumeData['EmployerSet']['set_id'] = $resumeSetID;
							$resumeData['EmployerSet']['employer_id'] = $employerID;
							$this->EmployerSet->save($resumeData);
						// get set_descr from set_id
							$set_descr = $this->common->getResumeSetDescr($resumeSetID);
							$content .= "- ".$set_descr."<br/>";
					}	
					
				}
			}
			
			//send email to employer
			if($do_mail=='y'){
				$email = new CakeEmail();
				$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				$subject = "Important techexpoUSA.com resume access information";
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				
				$bodyText = 'Dear TECHEXPO Client,<br/><br/>Your resume access privileges have just been updated. You can check which databases you currently have access to from your "employer homepage" (the screen you are taken to after logging in). Visit us at http://www.TechExpoUSA.com to begin searching and post up to 25 jobs.<br/><br/>As a reminder, here is your login information:<br/><br/>-username: '.$employerContact['User']['username'].'<br/>-password: '.$employerContact['User']['old_password'].'<br/><br/>****** ONLINE FEATURES ******<br/><br/>-KEYWORD HIGHLIGHTS: when conducting a resume keyword search, searched keywords are highlighted.<br/><br/>-RESUME FOLDERS. Create resume folders, then file resumes on the fly, copy them from folder to folder, download them... making the organization of resumes around themes, keywords or specific job titles really simple. <br/><br/>To search resumes and post jobs, simply go to http://www.TechExpoUSA.com and log in.<br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225.<br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Director of Events and Marketing<br/>212.655.4505 ext. 225';
				
				$sendtoemails = explode(",",$employerContact['EmployerContact']['contact_email']);
				/* should be uncomment later
				if(is_array($sendtoemails)){
					foreach($sendtoemails as $sendTo){
						if(Validation::email($sendTo)){
							$email->to($sendTo);
							$email->send($bodyText);
						}
					}
				}*/
				
			}
				
			//send email to Admin
			$email = new CakeEmail();
			$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
			$subject1 = "Resume set assigned";
			$email->emailFormat('html');
			$email->subject(strip_tags($subject1));
			
			$bodyText1 = 'Nancy / Brad,<br/><br/>The following resume database(s) was / were just assigned to '.$employerContact['EmployerContact']['contact_name'].' from '.$this->common->getEmployerName($employerID).' :<br/><br/>'.$content.'<br/><br/>The person IP address is: '.$_SERVER['REMOTE_ADDR'].' ';
			
			/* Should be uncomment later
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
			}*/
			
			$showcontent ='<p><br><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Sets assigned.<br/><br/>You may close this window.</font></p>';
					
			$this->set('showcontent',$showcontent);
			
		}	
			
	}
	
	/******* Function for edit company profile *********/
	public function superadmin_editcompanyprofile($employerID=null){
		$this->set('meta_title','Edit company profile');
		$errorsArr ='';
		// get the list of all indusrty types
		$industryList = $this->common->getIndustriesList();
		$this->set('industryList',$industryList);
		
		$employerProfileID = $employerID;
		//pr($this->request->data);die;
		
		if($this->request->is('get')){
		 	// Get employer profile record
			$this->Employer->recursive = -1;
			$this->request->data = $this->Employer->find("first", array('conditions' => array('Employer.id'=>$employerProfileID)));
			
		}else{
			
			$this->Employer->set($this->request->data);
			
			if(!$this->Employer->validates()){
				$errorsArr = $this->Employer->validationErrors;	
			}
			if($errorsArr){
				$this->Set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			
			if(!$errorsArr) 
			{	
				$result = $this->Employer->save($this->request->data);
				$this->Session->write('popup','Company profile has been updated successfully.');
				$this->Session->setFlash('Company profile has been updated successfully.');  
				$this->redirect(array('controller'=>'clients','action' => "editcompanyprofile/".$employerProfileID."/message:success"));
			}
			
		}
	
	}
	
	/******* Function for edit contact information *********/
	public function superadmin_editcompanycontact($employerID=null, $employerContactID=null){
		$errorsArr ='';
		$this->set('meta_title','Edit company contact information');
		
		$employerID = $employerID;
		$this->set('employerID',$employerID);
		
		$empContactID = $employerContactID;
		//pr($this->request->data);die;
		
		if($this->request->is('get')){
		 	// Get employer personal contact information
			$this->EmployerContact->recursive = 0; // -1 means show only this model information
			$this->request->data = $this->EmployerContact->find("first", array('conditions' => array('EmployerContact.id'=>$empContactID)));
			$this->request->data['User']['newusername'] = $this->request->data['User']['username'];

		}else{
			
					$this->User->set($this->request->data);
					$this->EmployerContact->set($this->request->data);
					
					if(!$this->EmployerContact->validates()){
						$errorsArr = $this->EmployerContact->validationErrors;	
					}
					if(!$this->User->changeUserValidate()){
						$errorsArr = $this->User->validationErrors;
					}
					
					if($errorsArr){
						$this->Set('errors',$errorsArr);
						$this->set('data',$this->request->data);
					}
					
					if(!$errorsArr){
					
						// insert data into employercontact
						$employerID = $this->request->data['EmployerContact']['employer_id'];
						$this->EmployerContact->save($this->request->data);
						$employerContactID = $this->request->data['EmployerContact']['id'];
						
						// insert data into user
						$this->request->data['User']['employer_contact_id'] = $employerContactID;
						$this->request->data['User']['old_password'] = $this->request->data['User']['password'];
						$this->request->data['User']['user_type'] = 'E';
						$this->request->data['User']['created'] = date("Y-m-d");
						$this->User->save($this->request->data);
						
						$this->Session->write('popup','Company contact information has been added successfully.');
						$this->Session->setFlash('Company contact information has been added successfully.');  
						$this->redirect(array('controller'=>'clients','action' => "editcompanycontact/".$employerID."/".$employerContactID."/message:success"));
				
					}
			
		} // end of post request
	
	}
	
	/******* Function for send login detail to client *********/
	public function superadmin_sendlogindetail($employerID=null, $employerContactID=null){
		$errorsArr ='';
		$this->set('meta_title','Edit company contact information');
		
		$employerID = $employerID;
		$this->set('employerID',$employerID);
		
		$empContactID = $employerContactID;
		//pr($this->request->data);die;
		
		if($this->request->is('get')){
			if($empContactID==NULL){
				$this->Session->write('popup','Client contact information not created yet. Please create contact detail for this client.');
				$this->Session->setFlash('Client contact information not created yet. Please create contact detail for this client.');  
				$this->redirect(array('controller'=>'clients','action' => "addnewclient/".$employerID."/message:success"));
			}
		 	// Get employer personal contact information
			$this->EmployerContact->recursive = 0; // -1 means show only this model information
			$this->request->data = $employerContact = $this->EmployerContact->find("first", array('conditions' => array('EmployerContact.id'=>$empContactID)));
			
		
			$email = new CakeEmail();
			$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
			$subject = "TECHEXPO Top Secret online account information";
			$email->emailFormat('html');
			$email->subject(strip_tags($subject));
			
			$bodyText = 'Dear '.$employerContact['EmployerContact']['contact_name'].',<br/><br/>Per you request, here is your account information:<br/><br/>You can log in at http://www.TechExpoUSA.com<br/><br/>Username: '.$employerContact['User']['username'].'<br/>Password: '.$employerContact['User']['old_password'].'<br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. <br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Director of Events and Marketing<br/>212.655.4505 ext. 225';
			
			$sendtoemails = explode(",",$employerContact['EmployerContact']['contact_email']);
			/****** Should be uncomment later
			if(is_array($sendtoemails)){
				foreach($sendtoemails as $sendTo){
					if(Validation::email($sendTo)){
						$email->to($sendTo);
						$email->send($bodyText);
					}
				}
			}*/
			
		}
	
	}
	
	/********* Function for add update logo file for clients *********/
	public function superadmin_clientlogofile($employerID=null){
		$errorsArr ='';
		$this->set('meta_title','Add/Edit company logo information');
		$this->set('employerID',$employerID);

		if($this->request->is('get')){
		 	// Get employer information
			$this->Employer->recursive = 0; // -1 means show only this model information
			$this->request->data = $this->Employer->find("first", array('fields'=>array('id','logo_file','employer_name'),'conditions' => array('Employer.id'=>$employerID)));
			
			$this->request->data['Employer']['old_logo'] = $this->request->data['Employer']['logo_file'];
			
		}else{
			//pr($this->request->data);
			$this->Employer->set($this->request->data);
			
			if(!$this->Employer->uploadclientlogo()) 
			{
				$errorsArr = $this->Employer->validationErrors;	
			}				
			if($errorsArr) {			
				$this->Set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}else{
				App::import('Vendor', 'Uploader.Uploader');
				$this->Uploader = new Uploader();
				$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'upload/'));
				if(file_exists(WWW_ROOT.'upload/'.$this->request->data['Employer']['old_logo']) && $this->request->data['Employer']['old_logo']!=''){
					$this->Uploader->remove(WWW_ROOT.'upload/'.$this->request->data['Employer']['old_logo']);
					$this->Uploader->remove(WWW_ROOT.'upload/150x80_'.$this->request->data['Employer']['old_logo']);
				}
				$fileUploadPath=$this->Uploader->upload($this->request->data['Employer']['logo_file'],array('prepend'=>time().'_','overwrite'=>true));                           
				$this->Uploader->resize(array('width' => '150','height' => '80','prepend'=>"150x80_".time()."_",'append'=>false,'aspect'=>false,'expand'=>false));
				$filename 	=  end(explode('/',$fileUploadPath['path']));
				
				$data = array('Employer'=>array('id'=>$employerID,'logo_file'=>$filename));
				$this->Employer->save($data, false, array('logo_file'));
				
				$this->Session->write('popup','Client logo has been updated successfully.');
				$this->Session->setFlash('Client logo has been updated successfully.');  
				$this->redirect(array('controller'=>'clients','action' => "clientlogofile/".$employerID."/message:success"));
				
			}
		
		}
			
	}
	
	/********* Function for delete account of clients *********/
	public function superadmin_deleteaccount($employerID=null,$employerContactID=null,$confirm=null){
		$errorsArr ='';
		$this->set('meta_title','Delete Client');
		$this->set('employerID',$employerID);
		
		if($employerContactID!=NULL){
			$this->set('employerContactID',$employerContactID);
		}else{
			$this->set('employerContactID',0);
		}
		
		if($this->request->is('get')){
		 	// Get employer information
			if($confirm==NULL){
				$this->JobPosting->recursive = 0; // -1 means show only this model information
				$jobcount = $this->JobPosting->find("count", array('conditions' => array('JobPosting.employer_id'=>$employerID)));
				
				$this->EmployerSet->recursive = 0; // -1 means show only this model information
				$resumedbcount = $this->EmployerSet->find("count", array('conditions' => array('EmployerSet.employer_id'=>$employerID)));
				
				$this->set('jobcount',$jobcount);
				$this->set('resumedbcount',$resumedbcount);
		
			}elseif($confirm=='yes'){
			   if(isset($employerContactID) && $employerContactID!=''){
					// Delete EmployerContact
					$this->EmployerContact->delete($employerContactID);
					
					// Delete User
					$this->User->deleteAll(array('User.employer_contact_id' => $employerContactID));
				
					// Delete folder and its folder_content of employer
					$this->Folder->deleteAll(array('Folder.employer_contact_id' => $employerContactID), true);
			  }
				
				// Delete folder and its folder_content of employer
				$this->JobPosting->deleteAll(array('JobPosting.employer_id' => $employerID), true);
				
				// Delete EmployerSet
				$this->EmployerSet->deleteAll(array('EmployerSet.employer_id' => $employerID), false);
				
				// Delete CustomEmployerSet
				$this->CustomEmployerSet->deleteAll(array('CustomEmployerSet.employer_id' => $employerID), false);
				
				// Delete employer_stats
				$this->EmployerStat->deleteAll(array('EmployerStat.employer_id' => $employerID), false);
				
				// Delete EmployerLastVisit
				$this->EmployerLastVisit->deleteAll(array('EmployerLastVisit.employer_id' => $employerID));
				
				// Delete resume_access_stats
				$this->ResumeAccessStat->deleteAll(array('ResumeAccessStat.employer_id' => $employerID), false);
				
				// Delete ofccp_tracking
				$this->OfccpTracking->deleteAll(array('OfccpTracking.tracking_employer_id' => $employerID));
				
				// Delete show_employers
				$this->ShowEmployer->deleteAll(array('ShowEmployer.employer_id' => $employerID), false);
				
				// Delete ShowCompanyProfile
				$this->ShowCompanyProfile->deleteAll(array('ShowCompanyProfile.employer_id' => $employerID));
				
				// Delete employer_stats
				$this->ShowInterview->deleteAll(array('ShowInterview.employer_id' => $employerID), false);
				
				// Delete employer_stats
				$this->TrialAccount->deleteAll(array('TrialAccount.employer_id' => $employerID), false);
				
				// Delete Employer
				$this->Employer->recursive = 0;
				$logoFile = $this->Employer->find("first",array('fields'=>array('logo_file'),'conditions'=>array('Employer.id'=>$employerID)));
				if($logoFile['Employer']['logo_file']!=''){
					App::import('Vendor', 'Uploader.Uploader');
					$this->Uploader = new Uploader();
					$this->Uploader->remove(WWW_ROOT.'upload/'.$this->request->data['Employer']['logo_file']);
					$this->Uploader->remove(WWW_ROOT.'upload/150x80_'.$this->request->data['Employer']['logo_file']);
				}
				
				$this->Employer->delete($employerID);				
				
				$this->set('confirm','yes');
				
						$this->Session->write('popup','Company deleted successfully.');
						$this->Session->setFlash('Company deleted successfully.');  
						$this->redirect(array('controller'=>'clients','action' => "clientmanager/message:success"));
				
			}elseif($confirm=='no'){
			
				$this->set('confirm','no');
				
			}
			
		}
			
	}
	
	/********* Function for view exhibitor list *********/
	public function superadmin_viewexhibitorlist(){
		$errorsArr ='';
		$this->set('meta_title','View exhibitor list');
		
		// Get employer information
		$cutoff_date = "2001-01-01";
		$condition = "Show.show_dt > '".$cutoff_date."'";
		$this->Show->recursive = 0;
		$eventList = $this->Show->find("all",array('fields'=>array('Show.id','Show.show_dt','Show.show_confirm_file','Location.location_city','Location.location_state'),'order'=>array('Location.location_state','Location.location_city','Show.show_dt'),'conditions'=>$condition));
		$this->set("eventList",$eventList);
		
		// resume set list
		$condition = "ResumeSetRule.set_id > 66";
		$resumeSetList = $this->ResumeSetRule->find("list",array('fields'=>array('ResumeSetRule.set_id','ResumeSetRule.set_descr'),'conditions'=>$condition,'order'=>array('set_descr')));
		$this->set("resumeSetList",$resumeSetList);
		
		if($this->request->is('get')){
		
			if(isset($this->request->params['pass']) && count($this->request->params['pass'])>0){
				$showID = $this->request->params['pass'][0];
				$employerID = $this->request->params['pass'][1];
				
				if($showID!='' && $employerID!=''){
					$this->ShowEmployer->deleteAll(array('ShowEmployer.employer_id' => $employerID,'ShowEmployer.show_id' => $showID),false);
					$this->ShowCompanyProfile->deleteAll(array('ShowCompanyProfile.employer_id' => $employerID,'ShowCompanyProfile.show_id' => $showID));
					$this->set("cmpDelete",'yes');
				}
				
			}
		 	
		}else{
			if($this->request->data['Submit']=='View / Refresh  Exhibitors' || $this->request->data['Submit']=='Update'){
				
				$showID = $this->request->data['Show']['show_id'];
				$this->set("showID",$showID);
			
				if($this->request->data['Submit']=='Update'){
					$employerID = $this->request->data['Show']['employerID'];
					$payment_status = $this->request->data['Show']['payment_status'];
					
					$update = $this->ShowEmployer->updateAll(array('payment_status'=>"'".$payment_status."'"), array('show_id'=>$showID,'employer_id'=>$employerID));
					
				} 
				
				
				// if resume set is created for the selected show
				$this->Show->recursive = 0;
				$resumeSet = $this->Show->find("first",array('fields'=>array('Show.resume_set_id'),'conditions'=>array('Show.id'=>$showID)));
				$this->set("resumeSetID",$resumeSet['Show']['resume_set_id']);
				
				
				if($resumeSet['Show']['resume_set_id']!=''){
					//get list of assigned employers
					$employerList = $this->ShowEmployer->find("all",array('conditions'=>array('ShowEmployer.show_id'=>$showID)));
					$this->set("employerList",$employerList);
				}
			
			}
			
			if($this->request->data['Submit']=='Assign Resume Database'){ 
				$showID = $this->request->data['Show']['show_id'];
				$this->set("showID",$showID);
				
				$resumeSetID = $this->request->data['Show']['set_id'];
				
				$employerList = $this->ShowEmployer->find("all",array('conditions'=>array('ShowEmployer.show_id'=>$showID)));
				// assign resume set to all employer of this show
				foreach($employerList as $key => $employer){ 
					//check whether it is assigned or not
					$isAssigned = $this->EmployerSet->find("count",array('conditions'=>array('EmployerSet.set_id'=>$resumeSetID,'employer_id'=>$employer['ShowEmployer']['employer_id'])));
					// if not assigned, then
					if($isAssigned==0){
						if($employer['ShowEmployer']['payment_status']=='y'){
							//get employer details
							$this->EmployerContact->recursive = 0;
							$employerContact = $this->EmployerContact->find('first',array('fields'=>array('EmployerContact.contact_email','User.username','User.old_password'),'conditions'=>array('EmployerContact.employer_id'=>$employer['ShowEmployer']['employer_id'])));
							
							// assign this employer to this resume set
							$resumeData['EmployerSet']['set_id'] = $resumeSetID;
							$resumeData['EmployerSet']['employer_id'] = $employer['ShowEmployer']['employer_id'];
							$this->EmployerSet->save($resumeData);
							
							// send email 
							$email = new CakeEmail();
							$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
							$subject = "Important techexpoUSA.com resume access information";
							$email->emailFormat('html');
							$email->subject(strip_tags($subject));
							
							$bodyText = 'Dear TECHEXPO Client,<br/><br/>Your resume access privileges have just been updated. You can check which databases you currently have access to from your "employer homepage" (the screen you are taken to after logging in). Visit us at http://www.TechExpoUSA.com to begin searching and post up to 25 jobs.<br/><br/>As a reminder, here is your login information:<br/><br/>-username: '.$employerContact['User']['username'].'<br/>-password: '.$employerContact['User']['old_password'].'<br/><br/>****** ONLINE FEATURES ******<br/><br/>-KEYWORD HIGHLIGHTS: when conducting a resume keyword search, searched keywords are highlighted.<br/><br/>-RESUME FOLDERS. Create resume folders, then file resumes on the fly, copy them from folder to folder, download them... making the organization of resumes around themes, keywords or specific job titles really simple. <br/><br/>To search resumes and post jobs, simply go to http://www.TechExpoUSA.com and log in.<br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225.<br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Director of Events and Marketing<br/>212.655.4505 ext. 225';
							
							$sendtoemails = explode(",",$employerContact['EmployerContact']['contact_email']);
							/**** Should be uncomment later
							if(is_array($sendtoemails)){
								foreach($sendtoemails as $sendTo){
									if(Validation::email($sendTo)){
										$email->to($sendTo);
										$email->send($bodyText);
									}
								}
							}*/
							
						}
					}
					
				} // endforeach
				
			} // end of assign resume db
			
		}
			
	}
	
	// function for sending email conrimation again (Re-email) form view exhibitor list
	function superadmin_sendemailconfirm($showID=null,$employerID=null){
				
		// get the show confirm file
		$this->Show->recursive = 0;
		$Show = $this->Show->find("first",array('fields'=>array('Show.id','Show.show_dt','Show.show_name','Show.show_confirm_file','Location.location_state'),'conditions'=>array('Show.id'=>$showID)));
		
		//get employer details
		$employerContact = $this->EmployerContact->find('first',array('conditions'=>array('EmployerContact.employer_id'=>$employerID)));
		
		$showConfirmFile = trim($Show['Show']['show_confirm_file']);
		if(strlen($showConfirmFile)>0){
			// file location 
			$attachfilePath = WWW_ROOT."ShowsDocument/showConfirmFile/".$showConfirmFile;
			
			$email = new CakeEmail();
			$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
			$subject = "Important TECHEXPO information";
			$email->emailFormat('html');
			$email->subject(strip_tags($subject));
			if(file_exists($attachfilePath)){
				$email->attachments(array($attachfilePath));
			}
			
			$bodyText = 'Dear TECHEXPO exhibitor,<br/><br/>Thank you for participating in '.$Show['Location']['location_state'].'s TECHEXPO on '.date("F d, Y",strtotime($Show['Show']['show_dt'])).'. You have just been assigned to the show on our website. Attached to this e-mail is your confirmation packet. Please print it out and review it carefully as it contains *VERY IMPORTANT* information. You can also download this packet from your employer homepage, below the "Show Registration & Resume Access Information" heading.<br/><br/>If you have not done so yet, please take a moment to complete your profile and post your 25 jobs at http://www.TechExpoUSA.com/emphomeautologin/'.$employerID.'/'.$employerContact['EmployerContact']['id'].'/'.$employerContact['User']['status_code'].'<br/><br/>Why is this important? By visiting the "Event information" areas of our site, technology professionals can see your company name, click on it to view your profile and open positions and apply directly online, sending resumes your way via e-mail. You can then get in touch with candidates via e-mail to schedule show day interviews in advance.  This is also where the site pulls your company information for the event gulde, which goes to print one week prior to the event. A completed profile also gives your company a more professional image and will increase traffic at your booth on the day of the show.<br/><br/>Thank you in advance for your cooperation.<br/><br/>Following the link included above will automatically log you in and take you to your employer home page, but as a reminder, here is your login information:<br/><br/>-Log in from the main homepage at http://www.TechExpoUSA.com<br/>-Your Username: '.$employerContact['User']['username'].' <br/>-Your Password: '.$employerContact['User']['old_password'].' <br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. <br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Director of Events and Marketing<br/>212.655.4505 ext. 225';
			
			$sendtoemails = explode(",",$employerContact['EmployerContact']['contact_email']);
			/***** Should be uncomment later 
			if(is_array($sendtoemails)){
				foreach($sendtoemails as $sendTo){
					if(Validation::email($sendTo)){
						$email->to($sendTo);
						$email->send($bodyText);
					}
				}
			}*/
			
			$this->set("sendemail",'yes');
			
		}else{
			$this->set("sendemail",'no');
		}
					
	}
	
	// function for add new client
	function superadmin_addnewclient(){
	$errorsArr = '';
	if($this->request->is('post')){
		$errorsArr = array();
		$errorsArr0 = array();
		$errorsArr1 = array();
		$errorsArr2 = array();
		$errorsArr3 = array();
		// check data if it is valid or not
		
		
			$this->User->set($this->request->data);
			$this->Employer->set($this->request->data);
			$this->EmployerContact->set($this->request->data);
			
			if(trim($this->request->data['Employer']['employer_name'])==''){
				$errorsArr1['employer_name'][0] = "Please enter company name.";
			}
			if(!$this->EmployerContact->validates()){
				$errorsArr2 = $this->EmployerContact->validationErrors;	
			}			
			if(!$this->User->changeUserValidate()){
				$errorsArr0 = $this->User->validationErrors;
			}
			if($this->request->data['Employer']['logo_file']['error']!=4){
				if(!$this->Employer->uploadclientlogo()){
					$errorsArr3 = $this->Employer->validationErrors;
				}
			}
			
			$errorsArr = array_merge($errorsArr0,$errorsArr1,$errorsArr2,$errorsArr3);
			
			if($errorsArr){
				$this->Set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			
			if(!$errorsArr){
						
						// insert data in employers
						if($this->request->data['Employer']['logo_file']['name']!=''){
							App::import('Vendor', 'Uploader.Uploader');
							$this->Uploader = new Uploader();
							$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'upload/'));
							
							$fileUploadPath=$this->Uploader->upload($this->request->data['Employer']['logo_file'],array('prepend'=>time().'_','overwrite'=>true));                           
							$this->Uploader->resize(array('width' => '150','height' => '80','prepend'=>"150x80_".time()."_",'append'=>false,'aspect'=>false,'expand'=>false));
							$filename 	=  end(explode('/',$fileUploadPath['path']));
							
							$this->request->data['Employer']['logo_file'] = $filename;
						}else{
							$this->request->data['Employer']['logo_file'] ='';
						}
						
						$this->request->data['Employer']['created'] = date("Y-m-d");
						$this->Employer->save($this->request->data);
						$employerID = $this->Employer->getLastInsertID();
						
						
						// insert data into employercontact
						$this->request->data['EmployerContact']['employer_id'] = $employerID;
						$this->request->data['EmployerContact']['created'] = date("Y-m-d");
						$this->EmployerContact->save($this->request->data);
						$employerContactID = $this->EmployerContact->getLastInsertID();
						//update into employer
						$this->Employer->updateAll(array('Employer.primary_contact_id'=>$employerContactID), array('Employer.id'=>$employerID));
						
						// insert data into user
						$this->request->data['User']['employer_contact_id'] = $employerContactID;
						$this->request->data['User']['old_password'] = $this->request->data['User']['password'];
						$this->request->data['User']['user_type'] = 'E';
						$this->request->data['User']['created'] = date("Y-m-d");
						$this->User->save($this->request->data);
						
						unset($this->request->data);
						
						$this->Session->write('popup','New client added successfully.');
						$this->Session->setFlash('New client added successfully.');  
						$this->redirect(array('controller'=>'clients','action' => "addnewclient/message:success"));
						
		
			}
			
		}	
					
	}
	
	// function for resume database count
	function superadmin_resumedbcount(){
				
		$this->Candidate->unbindModel(array('hasOne' => array('User')));
		$this->Candidate->recursive = 0;
		//get record of current year
		$postedDate = date("Y")."-01-01";
		$options['joins'] = array(
			array('table' => 'resumes',
				'alias' => 'Resume',
				'type' => 'inner',
				'conditions' => array(
					"Resume.candidate_id = Candidate.id"
				)
			)
		);
		$options['conditions'] = array(
			"Resume.posted_dt >= '".$postedDate."'",
			"((LENGTH(Candidate.pref_locations) > 0) OR (Candidate.candidate_state in (select state_abrev from states where state_abrev != '00')))"
		);
		$options['fields'] = array('COUNT(Candidate.candidate_state) as cnt','Candidate.candidate_state','Candidate.pref_locations');
		$options['group'] = array('Candidate.candidate_state');
		$options['order'] = array('COUNT(Candidate.candidate_state) DESC');
		$rec = $this->Candidate->find('all', $options);
		$this->set('rec',$rec);
		
		//get record of previous year
		$postedDate1 = (date("Y")-1)."-01-01";
		$options1['joins'] = array(
			array('table' => 'resumes',
				'alias' => 'Resume',
				'type' => 'inner',
				'conditions' => array(
					"Resume.candidate_id = Candidate.id"
				)
			)
		);
		$options1['conditions'] = array(
			"Resume.posted_dt >= '".$postedDate1."'",
			"Resume.posted_dt < '".$postedDate."'",
			"((LENGTH(Candidate.pref_locations) > 0) OR (Candidate.candidate_state in (select state_abrev from states where state_abrev != '00')))"
		);
		$options1['fields'] = array('COUNT(Candidate.candidate_state) as cnt','Candidate.candidate_state','Candidate.pref_locations');
		$options1['group'] = array('Candidate.candidate_state');
		$options1['order'] = array('COUNT(Candidate.candidate_state) DESC');
		$rec1 = $this->Candidate->find('all', $options1);
		$this->set('rec1',$rec1);
		
		//get record of previous to previous year
		$postedDate2 = (date("Y")-2)."-01-01";
		$options2['joins'] = array(
			array('table' => 'resumes',
				'alias' => 'Resume',
				'type' => 'inner',
				'conditions' => array(
					"Resume.candidate_id = Candidate.id"
				)
			)
		);
		$options2['conditions'] = array(
			"Resume.posted_dt >= '".$postedDate2."'",
			"Resume.posted_dt < '".$postedDate1."'",
			"((LENGTH(Candidate.pref_locations) > 0) OR (Candidate.candidate_state in (select state_abrev from states where state_abrev != '00')))"
		);
		$options2['fields'] = array('COUNT(Candidate.candidate_state) as cnt','Candidate.candidate_state','Candidate.pref_locations');
		$options2['group'] = array('Candidate.candidate_state');
		$options2['order'] = array('COUNT(Candidate.candidate_state) DESC');
		$rec2 = $this->Candidate->find('all', $options2);
		$this->set('rec2',$rec2);
					
	}
	
	// function to send resume email to clients
	function superadmin_sendresume(){
		$errorsArr='';
		$resume_sets = $this->ResumeSetRule->find('list',array('fields'=>array('ResumeSetRule.set_id','ResumeSetRule.set_descr'),'order'=>array('ResumeSetRule.set_descr DESC')));
		$this->set('resume_sets',$resume_sets);
		
		if($this->request->is('post')){
				$resumesetID = $this->request->data['SendResume']['resume_set_id'];
				$method = $this->request->data['SendResume']['method'];
				$subject = trim($this->request->data['SendResume']['subject']);
				$to = strip_tags($this->request->data['SendResume']['to']);
				$message = $this->request->data['SendResume']['message'];
				
				
				if($method=='email'){
					if($subject==''){
						$errorsArr['subject'][0] = "You have selected to e-mail the resumes but have not entered a subject. Please entered the subject.";
					}
					if(strlen($to)<3){
						$errorsArr['to'][0] = "You have selected to e-mail the resumes but have not entered one or more recipients. Please entered one or more recipients.";
					}
					if($message==''){
						$errorsArr['message'][0] = "You have selected to e-mail the resumes but have not entered a message. Please entered a message.";
					}
					
				}
				
				if($errorsArr){
					$this->Set('errors',$errorsArr);
					$this->set('data',$this->request->data);
				}
				
				if(!$errorsArr){
					// get content of all resume of given resume sets
					$resume_contents = $this->ResumeSet->find('all',array('fields'=>array('ResumeSet.resume_id','Resume.id','Resume.resume_content'),'conditions'=>array('ResumeSet.set_id'=>$resumesetID)));
					
					// Empty the folder
					$handler = opendir(WWW_ROOT.'clientDocument/ResumeBluePrint/');  // empty folder 
					 while ($file = readdir($handler)) 
						{
							if(file_exists(WWW_ROOT.'clientDocument/ResumeBluePrint/'.$file))
							{
								if(is_file(WWW_ROOT.'clientDocument/ResumeBluePrint/'.$file))
								{
									unlink(WWW_ROOT.'clientDocument/ResumeBluePrint/'.$file);
								}
							}
						}
					
						// create txt files
						foreach($resume_contents as $resume_content)  // create txt file
						{
							$resumeContent=$resume_content['Resume']['resume_content'];  // creating txt file
							//$resumeContent = str_replace("<br />", "\n", $resumeContent);
							file_put_contents('clientDocument/ResumeBluePrint/'.$resume_content['Resume']['id'].'.txt', $resumeContent);
						}
						
						// create zip folder of all these txt files
						 $results = array();   // ===== create zip file all 
						 $handler = opendir('clientDocument/ResumeBluePrint/');
						 while ($file = readdir($handler)) 
							{
								if ($file != "." && $file != "..")
								{
									$results[] = 'clientDocument/ResumeBluePrint/'.$file;
								}
							}
							
						$ZIPNAME= $resumesetID;
						$result = $this->common->create_zip($results,'clientDocument/ResumeBluePrint/'.$ZIPNAME.'.zip');
						
						if($method=='download'){
							//$downloadUrl = WWW_ROOT.'clientDocument/ResumeBluePrint/'.$ZIPNAME.'.zip';
							$this->set('url',$ZIPNAME.'.zip');
							
						}elseif($method=='email'){
							$toemails = explode(",",$to);
							
							$attachfilePath = WWW_ROOT.'clientDocument/ResumeBluePrint/'.$ZIPNAME.'.zip';
							$email = new CakeEmail();
							$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
							$subject = $subject;
							$email->emailFormat('html');
							$email->subject(strip_tags($subject));
							if(file_exists($attachfilePath)){
								$email->attachments(array($attachfilePath));
							}
							$bodyText = nl2br($message);
							
							/* this shuld be uncomment later
							if(is_array($toemails)){
								foreach($toemails as $sendTo){
									if(Validation::email($sendTo)){
										$email->to($sendTo);
										$email->send($bodyText);
									}
								}
							}*/
							
							$this->set("toemails",$to);
						
						}
						
						
					
				}
				
		}
		
	}
	
	// function to set client as featured or not featured
	function superadmin_setasfeaturedclient($employerID=null){
		if($this->request->is('post')){
			$is_fetaured = $this->request->data['Employer']['is_featured'];
			$employerID = $employerID;
			
			if($is_fetaured=='y'){
				$is_featured_exist = $this->Employer->find("all",array('fields'=>array('Employer.id','Employer.is_featured'),'conditions'=>array('Employer.is_featured'=>'y')));
				if(count($is_featured_exist)>0){
					foreach($is_featured_exist as $featured_emp){
						$empData = array('Employer'=>array('id'=>$featured_emp['Employer']['id'],'is_featured'=>'n'));
						$this->Employer->save($empData,false,array('is_featured'));
					}
				}
			}
			
			$data = array('Employer'=>array('id'=>$employerID,'is_featured'=>$is_fetaured));
			$this->Employer->save($data,false,array('is_featured'));
			$this->set('featured','success');
			
		}
	
	}
	
	// function for create trail account 
	function superadmin_createtrailaccount(){
		$errorsArr ='';
		$curDateTime = time();
		//echo date("d-m-Y h:i:s A",$curDateTime);
		
		if($this->request->is('post')){			
			if($this->request->data['TrialAccount']['start_time']['meridian']=='am'){
				$start_date = $this->request->data['TrialAccount']['start_time']['year']."-".$this->request->data['TrialAccount']['start_time']['month']."-".$this->request->data['TrialAccount']['start_time']['day']." ".$this->request->data['TrialAccount']['start_time']['hour'].":".$this->request->data['TrialAccount']['start_time']['min'].":00";
			}else{
				$start_date = $this->request->data['TrialAccount']['start_time']['year']."-".$this->request->data['TrialAccount']['start_time']['month']."-".$this->request->data['TrialAccount']['start_time']['day']." ".($this->request->data['TrialAccount']['start_time']['hour']+12).":".$this->request->data['TrialAccount']['start_time']['min'].":00";
			}
		
			if($this->request->data['TrialAccount']['end_time']['meridian']=='am'){
				$end_date = $this->request->data['TrialAccount']['end_time']['year']."-".$this->request->data['TrialAccount']['end_time']['month']."-".$this->request->data['TrialAccount']['end_time']['day']." ".$this->request->data['TrialAccount']['end_time']['hour'].":".$this->request->data['TrialAccount']['end_time']['min'].":00";
			}else{
				$end_date = $this->request->data['TrialAccount']['end_time']['year']."-".$this->request->data['TrialAccount']['end_time']['month']."-".$this->request->data['TrialAccount']['end_time']['day']." ".($this->request->data['TrialAccount']['end_time']['hour']+12).":".$this->request->data['TrialAccount']['end_time']['min'].":00";
			}			
			
			$this->User->set($this->request->data);
			$this->Employer->set($this->request->data);
			$this->EmployerContact->set($this->request->data);
			
			if(!$this->EmployerContact->validates()){
				$errorsArr = $this->EmployerContact->validationErrors;	
			}
			if(!$this->User->changeUserValidate()){
				$errorsArr = $this->User->validationErrors;
			}
			
			if(trim($this->request->data['Employer']['employer_name'])==''){
				$errorsArr['employer_name'][0] = "Please enter company name.";
			}
			if(strtotime($start_date) <= $curDateTime){
				$errorsArr['start_time'][0] = "Please enter start time greater than current time.";
			}
			if(strtotime($end_date) <= $curDateTime){
				$errorsArr['end_time'][0] = "Please enter end time greater than current time.";
			}
			if(strtotime($end_date) <= strtotime($start_date)){
				$errorsArr['start_time'][0] = "Please enter end time greater than start time.";
			}
			
			if($errorsArr){
				$this->Set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			
			if(!$errorsArr){
				// insert data in employers
				$this->request->data['Employer']['trial_client'] = 'y';
				$this->request->data['Employer']['created'] = $start_date;
				$this->request->data['Employer']['max_jobs'] = '10';
				$this->Employer->save($this->request->data);
				$employerID = $this->Employer->getLastInsertID();
				
				// insert data into employercontact
				$this->request->data['EmployerContact']['employer_id'] = $employerID;
				$this->EmployerContact->save($this->request->data);
				$employerContactID = $this->EmployerContact->getLastInsertID();
				
				// insert data into user
				$this->request->data['User']['employer_contact_id'] = $employerContactID;
				$this->request->data['User']['old_password'] = $this->request->data['User']['password'];
				$this->request->data['User']['user_type'] = 'E';
				$this->request->data['User']['created'] = $start_date;
				$this->User->save($this->request->data);
				
				// insert data into trail account
				$this->request->data['TrialAccount']['employer_contact_id'] = $employerContactID;
				$this->request->data['TrialAccount']['employer_id'] = $employerID;
				$this->TrialAccount->save($this->request->data);
				
				// insert into employerSet
				$this->request->data['EmployerSet']['employer_id'] = $employerID;
				$this->EmployerSet->save($this->request->data);
				
				// insert into trial_accounts_track
				$this->request->data['TrialAccountTrack']['sales_rep'] = $this->request->data['TrialAccount']['sales_name'];
				$this->request->data['TrialAccountTrack']['company'] = $this->request->data['Employer']['employer_name'];
				$this->request->data['TrialAccountTrack']['contact'] = $this->request->data['EmployerContact']['contact_name'];
				$this->request->data['TrialAccountTrack']['trial_end_date'] = $this->request->data['TrialAccount']['end_time'];
				$this->TrialAccountTrack->save($this->request->data);
				
				// send email
				$email = new CakeEmail();
				$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				$subject = "Welcome to TechExpoUSA.com ! Account information enclosed";
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				
				$bodyText = 'Thank you for joining TechExpoUSA.com. Your trial account is active and you can start searching resumes by visiting http://www.TechExpoUSA.com and logging in.<br/><br/>Following is your trial account information:<br/><br/>Username: '.$this->request->data['User']['username'].'<br/>Password: '.$this->request->data['User']['old_password'].'<br/><br/>You will be notified by e-mail when your trial period expires. To purchase permanent access to the resume database, please contact your sales representative:<br/><br/>'.$this->request->data['TrialAccount']['sales_name'].'<br/>212.655.4505 ext. '.$this->request->data['TrialAccount']['sales_ext'].'<br/>'.$this->request->data['TrialAccount']['sales_email'].'<br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. <br/><br/>Again, it is truly a pleasure to welcome you.<br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Director of Events and Marketing<br/>212.655.4505 ext. 225';
										
				$sendtoemails = explode(",",$this->request->data['EmployerContact']['contact_email']);
				/********* Should be uncomment later
				if(is_array($sendtoemails)){
					foreach($sendtoemails as $sendTo){
						if(Validation::email($sendTo)){
							$email->to($sendTo);
							$email->send($bodyText);
						}
					}
				}*/
				
				//send email to Admin
				$email = new CakeEmail();
				$email->from(array('webmaster@techexpoUSA.com'));
				$subject1 = "Resume set assigned";
				$email->emailFormat('html');
				$email->subject(strip_tags($subject1));
				
				$bodyText1 = 'Nancy / Brad,<br/><br/>A trial account was just created for '.$this->request->data['Employer']['employer_name'].' / '.$this->request->data['EmployerContact']['contact_name'].'. The person who created this account is '.$this->request->data['TrialAccount']['sales_name'].' ';
				
				/* should be uncomment later
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
				}*/
					
				unset($this->request->data);				
				$this->Session->write('popup','The trial account was created! An e-mail notification was automatically sent.');
				$this->Session->setFlash('The trial account was created! An e-mail notification was automatically sent.');  
				$this->redirect(array('controller'=>'clients','action' => "createtrailaccount/message:success"));
		
			}
			
		}
	}
	
	//function for track the trial account
	function superadmin_trialaccounttracker(){
		$cutoff_date = date("Y-m-d h:i:s",mktime(0,0,0,date('m'), date('d')-30, date('Y')));
		$condition = "trial_end_date > '".$cutoff_date."' ";
		$tracks = $this->TrialAccountTrack->find("all",array('conditions'=> $condition, 'order'=>array('sales_rep','trial_end_date DESC')));
		$this->set("tracks",$tracks);
	}
	
	//function for view clients videos
	function superadmin_clientvideo(){		
		$cmpVideo = $this->EmployerVideo->find("all",array('order'=>array('EmployerVideo.created DESC')));
		$this->set("cmpVideo",$cmpVideo);
	}
	
	// function for approve a video
	function superadmin_videoapprove($id = null){
		$this->EmployerVideo->id = $id;
		$videoData = array('EmployerVideo'=>array('isApproved'=>'Y'));
		$this->EmployerVideo->save($videoData, false, array('isApproved'));
		$this->Session->write('popup','Video successfully approved.');
		$this->Session->setFlash('Video successfully approved.');
		$this->redirect(array('controller'=>'clients','action' => "clientvideo/message:success"));
	}
	
	// function for unapprove a video
	function superadmin_videounapprove($id = null){
		$this->EmployerVideo->id = $id;
		$videoData = array('EmployerVideo'=>array('isApproved'=>'N'));
		$this->EmployerVideo->save($videoData, false, array('isApproved'));
		$this->Session->write('popup','Video successfully unapproved.');
		$this->Session->setFlash('Video successfully unapproved.');
		$this->redirect(array('controller'=>'clients','action' => "clientvideo/message:success"));
	}
	
	// function for showing company video
	public function superadmin_showclientvideo($id = null  )
	{
		$this->layout = false;
		//	$this->autoRender = false;
		$video_dt = $this->EmployerVideo->find('first',array('conditions'=>array('EmployerVideo.id'=>$id)));
		$this->set('video_dt',$video_dt);
	}
	
	// function for getting all new clients
	public function superadmin_allnewclients(){	
		$argArr = array();
		if(isset($this->request->query['limit']) && $this->request->query['limit']!='') {
			$limit = $this->request->query['limit'];
			$argArr['limit'] = $limit;
			$this->Session->write('per_page_record',$limit);
		}
		
		$this->set('argArr', $argArr);
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		
		$condition = "User.username IS NULL AND User.password IS NULL AND EmployerContact.contact_email IS NOT NULL AND EmployerContact.created IS NOT NULL";
		
		$this->EmployerContact->recursive= 0;
		$this->paginate = array('limit' =>$record,'conditions'=>$condition,'order' => array('EmployerContact.id' => 'DESC'));
		$data = $this->paginate('EmployerContact');
		//pr($data);
		$this->set('employers',$data);
		$this->set('record',$record);
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
	
	
}//end class
?>