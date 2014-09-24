<?php 
/**************************************************************************
 Coder  : Pushkar Soni
 Object : Controller for login, logout and registration process of candidate
**************************************************************************/ 
class CandidatesController extends AppController {
 	//var $name = 'Users'; //Model name attached with this controller 
 	var $helpers = array('Html','Javascript','Text','Paginator','Ajax','Text'); //add some required helpers to this controller
 	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler','Captcha');  //add some required component to this controller .
	
	
	
	
	var $layout = 'front'; //this is the layout for front panel 
	var $currUser = 0;
	var $uses = array('Candidate','User','Code','Resume','ResumeSkill','ApplyHistory','JobPosting','ShowCompanyProfile','Employer','TrainingSchool','JobPostingSkill','Code','FolderContent','ShowInterview','Show','Registration','CandidateVideo','City','JobEmailHistory','State','Newsletter','CandidateNewsletter');
	/* This function call by default when a controller is called */
	
	function index()
	{
	
	}
	
	
	function register()
	{
		$cityList=array('0'=>'please select state');
		
		$this->set('cityList',$cityList);
		$this->set('statList',$this->common->getAjaxStateList(15)); //    find statelist
		
		$this->set('meta_title','Jobseeker Register');
		
		if($this->Session->read('Auth.Client.User.id')!=''){ 
		$this->redirect(array('controller'=>'users','action'=>'index'));
		}else
		{
		

		
			if($this->request->data):
			
			// 21 aug 2013
			$this->request->data['User'] = array_map('trim', $this->request->data['User']);
			$errorsArr=array();
			$errorsArr1=array();
					$this->Candidate->invalidate('candidate_state22','' );
					
					if(is_array($this->request->data['Candidate']['security_clearance_code']))
						{
							$this->request->data['Candidate']['security_clearance_code']=implode(',',$this->request->data['Candidate']['security_clearance_code']);
						}
									
					
					//pr($this->request->data);					
					$this->User->set($this->request->data);
					$this->Candidate->set($this->request->data);
					
					// for login condition after registration 19-11-12
					$this->Session->write('Candidate',$this->request->data['User']);
					// end
					
									
					if(empty($this->request->data['Candidate']['security_clearance_code']))
					{
						$this->Candidate->invalidate('security_clearance_code','Please select at least one security clearance'); 
					}
				
				
				
					if(!empty($this->request->data['Candidate']['country_code']))
					{	
						
						if($this->request->data['Candidate']['country_code']!='15' and $this->request->data['Candidate']['country_code']!='16')
						{
							if(empty($this->request->data['Candidate']['candidate_state22']))
							{
								$this->Candidate->invalidate('candidate_state22', 'Please enter state' );
							}
						}else
						{
							if(empty($this->request->data['Candidate']['candidate_state']))
							{
								$this->Candidate->invalidate('candidate_state','Please select state' );
							}
						}
					}
					
					if(!$this->User->RegisterValidate()){
						$errorsArr = $this->User->validationErrors;	
					}
					if(!$this->Candidate->RegisterValidate()){
						$errorsArr1 = $this->Candidate->validationErrors;
					}
					
					$errorsArr=array_merge($errorsArr,$errorsArr1);
					$error=count($errorsArr);
					if($error):
					
						$this->request->data['Candidate']['security_clearance_code']=explode(',',$this->request->data['Candidate']['security_clearance_code']);	
							
											
						if(!empty($this->request->data['Candidate']['country_code']))
						{
							$this->set('statList',$this->common->getAjaxStateList($this->request->data['Candidate']['country_code']));
						}else
						{
							$this->set('statList',$this->common->getAjaxStateList(15));
						}
						
					else:
						
							if($this->request->data['Candidate']['country_code']!='15' and $this->request->data['Candidate']['country_code']!='16')
							{
								if(!empty($this->request->data['Candidate']['candidate_state22']))
								{
									$this->request->data['Candidate']['candidate_state']=$this->request->data['Candidate']['candidate_state22'];
								}
							}
						
						
						$this->request->data['Candidate']['candidate_name']=$this->request->data['Candidate']['candidate_fname'].' '.$this->request->data['Candidate']['candidate_lname'];
						 $this->request->data['Candidate']['citizen_status_code'] =25;
						 
						$this->request->data['User']['old_password']=$this->request->data['User']['password'];
						$this->Resume->unbindModel(array('hasMany'=>array('ResumeSkill')));
						if($this->Candidate->saveAll($this->request->data)):
						
						//mail to candidate 
						$sendto = $this->request->data['Candidate']['candidate_email'];
						$sendfrom = 'amanda@TechExpoUSA.com';
						
						$subject = "Welcome to TechExpoUSA.com";
						$bodyText ="Dear ".$this->request->data['Candidate']['candidate_name'].",<br/><br/>

Thank you for joining the TECHEXPO online member community. The TECHEXPO team is excited to welcome you to the website. We hope you will use this site to achieve your professional goals and stay informed about our upcoming hiring events and open positions.<br/>

Please note that by becoming a website member this does not automatically register you for upcoming hiring events. Registration for each hiring event must be done seperately. To do that, simply log into your account and visit the event registration center located on your personal Dashboard. ".FULL_BASE_URL.router::url('/',false)."Jobseeker/shows/eventList to actually register. <br/><br/>

For security purposes, the username and password you created will always be required to enter the website to access your professional profile and dashboard.<br/><br/>

If you have forgotten your username or password please visit the link below to retreive your account information.  ".FULL_BASE_URL.router::url('/',false)."users/forgotpassword to have your login e-mailed to you from a secure SSL server. It will simply require you to enter the e-mail address you originally registered with.<br/><br/>

As TECHEXPO's web administrator, I would also like to personally welcome you to the site and extend to you what few other sites will do: the highest possible level of service. <br/><br/>

You can reply to this message or e-mail Amanda@TechExpoUSA.com with any questions or comments, a reply will be sent to you within 24 hours. <br/><br/>

Again, welcome to our TECHEXPO online community and we wish you the best of luck in your career search. <br/><br/>

Best Regards,<br/>
Amanda Alessio<br/>
Marketing Director
";
						
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
							
							
							$this->Session->write('popup','Congratulations, your Job Seeker profile has been created! You will now be prompted to complete the registration process.');
							$this->Session->write('UserName',$this->request->data['User']['username']);
							$this->redirect(array('controller'=>'resumes','action'=>'resume'));
						endif;
					endif;
				endif;
		}
	}
	
	
	function thankyou($loginCk = null)
	{	
		
		if($this->Session->read('Auth.Clients.id'))
		{
			$this->redirect(array('controller'=>'users','action'=>'index'));
		}
		
		$username = $this->Session->read('Candidate.username');
		$password = $this->Session->read('Candidate.password');
		
		
		if($loginCk=='login')
		{
			$condition = "User.username='".$username."' AND User.password='".md5($password)."'";
						$authenticate = $this->User->find('first',array('conditions'=>$condition));
						
						// save the newsletter info						
						if(is_array($this->request->data['Newsletter'])){
							foreach($this->request->data['Newsletter']['id'] as $newsletter_id){
								$data['CandidateNewsletter']  = array('candidate_id'=>$authenticate['User']['candidate_id'],'newsletter_id'=>$newsletter_id);
								$this->CandidateNewsletter->create();
								$this->CandidateNewsletter->save($data);
							}
						}
						
						if(!empty($authenticate)) 
						{
							$this->Session->write('Auth.Clients',$authenticate['User']);
						}
						
						if($this->Session->check('Auth.Clients'))
						{
							$this->Session->write('Auth.Client',$authenticate);
							$redirect=$this->Session->read('Auth.redirect');
							
							if($this->Session->read('Auth.Redirects'))
								{
									$redirect=str_replace('&matching=','?matching=',$this->Session->read('Auth.Redirects'));
									$this->Session->delete('Auth.Redirects');
									$this->redirect($redirect);
								}else
								{
									$usertype=$this->Session->read('Auth.Clients.user_type');
									$referrar  = BASE_URL."".$_SERVER['REQUEST_URI'];
									$pagename  = "/".end(explode("/",$_SERVER['REQUEST_URI']));
									$remoteAddress  = $_SERVER['REMOTE_ADDR'];
									// insert into webstat 
									$this->common->saveDetailedTrafficHistory($pagename,$remoteAddress,$referrar);
									
									if($usertype=='E' || $usertype=='e'){
										// make entry in employer stat for login history
										$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
										$this->common->saveEmployerPagesVisitHistory($employerID,$pagename,$remoteAddress,$referrar);										
									}
									
								
										if($this->Session->read('redirect_action_url')!="")
										{
											$redirect_path = $this->Session->read('redirect_action_url');
											$this->redirect('/'.$redirect_path);
										}else{											
											$this->redirect(array('controller' => 'candidates', 'action' => 'candidateprofile','Jobseeker'=>true));
										}
									
								}
						}
		}
			// task id 4542 point 1 by jitendra
			$newsletter = $this->Newsletter->find('all',array('conditions'=>array('Newsletter.active'=>1),'order'=>array('Newsletter.id DESC')));
			$this->set('newsletter',$newsletter);
			//pr($newsletter);
			$this->set('meta_title','Jobseeker Thankyou');
	}
	function Jobseeker_addSkill()
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
				
				   
						   
				
				
		 }
		
				
						
						//   $this->set('keywordArray',$keywordArray);
						   
		}else
		{
				$this->redirect(array('controller'=>'users','action'=>'index','Jobseeker'=>false));
		}
	
	}
	
	function Jobseeker_updateDB()
	{
				$action 			= $_POST['action']; 
				$updateRecordsArray 	= $_POST['recordsArray'];
				$listingCounter = 1;
				if ($action == "updateRecordsListings")
				{
				
				
	
					$listingCounter = 1;
					foreach ($updateRecordsArray as $key=>$value) {
						
						
						$query = $this->User->query("UPDATE records SET recordListingID = " . $listingCounter . " WHERE id = '". $value."' and user_id='".$this->Session->read('Auth.Client.User.candidate_id')."'" );
					
					$listingCounter = $listingCounter + 1;	
					}
					
				}
				die;
				//print_r($updateRecordsArray);die;
	}	
	
	function Jobseeker_candidateprofile($id =null)
	{
		$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','Jobseeker Dashboard');
		$CandidateId=$this->Session->read('Auth.Client.User.candidate_id');
		
		
		
	 // code for box drag and drop
		$Rec=$this->User->query("SELECT * FROM records  where user_id='".$CandidateId."' ORDER BY recordListingID ASC");
		if(count($Rec))
		{
			$this->set('RecId',$Rec);
		}else
		{
			
			$this->User->query("insert into records set recordID='1',recordListingID='1',user_id='".$CandidateId."'");
			$this->User->query("insert into records set recordID='2',recordListingID='2',user_id='".$CandidateId."'");
			$this->User->query("insert into records set recordID='3',recordListingID='3',user_id='".$CandidateId."'");
			$this->User->query("insert into records set recordID='4',recordListingID='4',user_id='".$CandidateId."'");
			$this->redirect(array('controller'=>'candidates','action'=>'candidateprofile','Jobseeker'=>true));
			
			$Rec=$this->User->query("SELECT * FROM records  where user_id='".$CandidateId."' ORDER BY recordListingID ASC");
			$this->set('RecId',$Rec);
		}  // end
		
		
		
		if(!empty($id))
		{
			if($this->Resume->find('count',array('conditions'=>'Resume.id="'.$id.'" and Resume.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"','action'=>'')))
			{
		
			$this->Resume->delete($id);
			$this->Session->write('popup','Resume has been deleted successfully.');
			$this->redirect(array('controller'=>'candidates','action'=>'candidateprofile'));
			}
			else
			{
				$this->Session->write('popup','Did not have a permission to delete.');
				$this->redirect(array('controller'=>'candidates','action'=>'candidateprofile'));			
			}
		}
		
			$this->set('WorkTypeList',$this->common->getWorkTypeList());  // get work type list code in common
			$this->set('WorkTimeList',$this->common->getWorkTimeList());   // get work time list code in common
			$this->set('WorkLocationList',$this->common->getWorkLocationList()); // get work location list code in common
			$this->set('GovCleareanceList',$this->common->getGovCleareanceList()); // get security clearance list code in common
			$this->set('IndustriesList',$this->common->getIndustriesList()); // get industries list code in common
			$this->set('statList',$this->common->getStateList());
			$cityList=array('0'=>'please select a city');
		$this->set('cityList',$cityList);	
			  
			  // dashboard video code
			$dashboard_video= $this->CandidateVideo->find('first',array('conditions'=>array('CandidateVideo.candidate_id'=> $CandidateId,'CandidateVideo.set_dashboard="1" and isApproved="Y"')));			
			$this->set('dashboard_video',$dashboard_video);            
			
			
			$this->Resume->unBindModel(array('hasMany' => array('ResumeSkill')));  // resume list at dashoard
			$resumeRec=$this->Resume->find('all',array('fields'=>'Resume.id,Resume.resume_title',
														'conditions'=>'Resume.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"',
														'order'=>'Resume.id desc',
														'limit'=>'6'
														));
			$this->set('resumeRec',$resumeRec);
			
			
			//$this->Show->recursive = -1;  // upcomoin event for dashboard
			$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			$condition  = "Show.show_dt >= '".$targetdate."' and Show.published=1 ";	
			/*$showlisting=$this->Show->find("all",array('conditions'=> $condition,
															'order' => array('show_dt ASC'),
															'limit' =>'5'
															
															));
			$this->set('showRec',$showlisting);*/
			
			/**************** update code  29 aug 2013 apurav gaur******************/
			
			$this->Show->unBindModel(array('hasMany' => array('Registration')));
			$eventDetail = $this->Show->find("all",array('joins' => array(
				array(
					'table' => 'shows_home',
					'alias' => 'ShowsHome',
					'type' => 'INNER',
					'conditions' => array(
					'ShowsHome.show_id = Show.id'
					)
				)
		),'fields' => array('Show.id','Show.show_name','Show.sec_clearance_req','Show.show_dt','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>$condition,'order' => array('show_dt ASC'),'limit' =>3));
			
			$this->set('showRec',$eventDetail);
			
			
			
			/**************** update code  29 aug 2013 apurav gaur******************/
			
			
	}
	
		// set as desktop video 
	public function Jobseeker_setDeskVideo($id = null  )
	{ 
		$candidateId=$this->Session->read('Auth.Client.User.candidate_id');
		$this->layout = false;
		$this->autoRender = false; 
		
		$this->CandidateVideo->query("UPDATE candidate_videos SET set_dashboard = '0' WHERE candidate_id =".$candidateId);
		
		if(!empty($id))
		{
		$this->request->data['CandidateVideo']['id']=$id;
		$this->request->data['CandidateVideo']['set_dashboard']='1';	
		$this->CandidateVideo->save($this->request->data);
		$this->Session->write('popup','Video Set for your Dashboard.');
		$this->redirect(array('controller'=>'candidates','action'=>'videoList'));
		}
	}
	
	
	
	#=================  Update Job Seeker Profile ===============
	function Jobseeker_editprofile()
	{
		$this->Candidate->id=$this->Session->read('Auth.Client.User.candidate_id');
		$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','Jobseeker Edit Profile');
	//pr($this->Session->check('Auth.Client'));
	
		$this->set('mandatory','');
		$id=$this->Session->read('Auth.Client.User.candidate_id'); // jobseekerid
		$this->set('securityerror','');
		
		$this->set('statList1',$this->common->getStateList());  //    find statelist
		$this->set('experienceArray',$this->common->getExperienceList());  // find experince array
		$this->set('citizenshipArray',$this->common->getCitizenShipList());  // find citizenship array
		$this->set('govenmentclearanceArray',$this->common->getGovCleareanceList());  // find Govenment Clearance array
		$this->set('noticeperidArray',$this->common->getnoticeperiodList());   // find Govenment Clearance array
		$this->set('industriesArray',$this->common->getIndustriesList());  // find Industries Type
		$this->set('salaryTypeList',$this->common->getSalaryTypeList());  // get salary type list
	
	
		if($this->request->data):
		
		 if($this->request->data['Candidate']['SUBMIT']=='UPDATE'):	
			
		 		$this->request->data['Candidate']['candidate_name']=$this->request->data['Candidate']['candidate_fname'].' '.$this->request->data['Candidate']['candidate_lname'];
				
				if(is_array($this->request->data['Candidate']['security_clearance_code']))
				{
					$this->request->data['Candidate']['security_clearance_code']=implode(',',$this->request->data['Candidate']['security_clearance_code']);
				}
				if($this->request->data['Candidate']['pref_industries'])
				{
				$this->request->data['Candidate']['pref_industries']=implode(',',$this->request->data['Candidate']['pref_industries']);
				}
		
				if(is_array($this->request->data['Candidate']['pref_locations']))
				{
				$this->request->data['Candidate']['pref_locations']=implode(',',$this->request->data['Candidate']['pref_locations']);
				}
				
				
				
				
				$this->Candidate->set($this->request->data);  // check validation and save record	
				$this->User->set($this->request->data);
				
				$errorsArr=array();
			
				if(!empty($this->request->data['Candidate']['country_code']))
					{	
						
						
						if($this->request->data['Candidate']['country_code']!='15' and $this->request->data['Candidate']['country_code']!='16')
						{
							
							if(empty($this->request->data['Candidate']['candidate_state22']))
							{
								$this->Candidate->invalidate('candidate_state22', 'Please enter state' );
							}
							
						}else
						{
							if(empty($this->request->data['Candidate']['candidate_state']))
							{
								
								$this->Candidate->invalidate('candidate_state','Please select state' );
							}
						}
					}
					
			
			
				if(!$this->User->editProfile() || !$this->Candidate->editProfile()) 
				{
				  	$errorsArr1 = $this->Candidate->validationErrors;
					$errorsArr2 = $this->User->validationErrors;
					$errorsArr=array_merge($errorsArr1,$errorsArr2);
					
					
					if(!empty($this->request->data['Candidate']['country_code']))
						{
							$this->set('statList',$this->common->getAjaxStateList($this->request->data['Candidate']['country_code']));
						}else
						{
							$this->set('statList',$this->common->getAjaxStateList(15));
						}
					
				}
				
				if($errorsArr)
				{
					$this->request->data['Candidate']['security_clearance_code']=explode(',',$this->request->data['Candidate']['security_clearance_code']);
					$this->request->data['Candidate']['pref_industries']=explode(',',$this->request->data['Candidate']['pref_industries']);
					$this->request->data['Candidate']['pref_locations']=explode(',',$this->request->data['Candidate']['pref_locations']);
				}else
				{
					if($this->request->data['Candidate']['country_code']!='15' and $this->request->data['Candidate']['country_code']!='16')
							{
								if(!empty($this->request->data['Candidate']['candidate_state22']))
								{
									$this->request->data['Candidate']['candidate_state']=$this->request->data['Candidate']['candidate_state22'];
								}
							}
					
					
					
					if($this->request->data['Candidate']['candidate_privacy']=='1'):
						$this->request->data['Candidate']['candidate_privacy']='Y';
					else:
						$this->request->data['Candidate']['candidate_privacy']='N';
					endif;
					
					if(!empty($this->request->data['User']['password']))
					{
					$this->request->data['User']['old_password']=$this->request->data['User']['password'];
					}
					
					
					if(!$this->request->data['User']['password']){  // =========unset password and confirm password if blanck =====
						unset($this->request->data['User']['password']);
					}else
					{
						$this->request->data['User']['old_password']=$this->request->data['User']['password'];
						if(empty($this->request->data['User']['cpassword']))
						{
							$this->request->data['User']['cpassword']='';
						}
					}
				
					if(!$this->request->data['User']['cpassword']){  // =========unset onfirm password if blanck =====
						unset($this->request->data['User']['cpassword']);
					}else
					{
						if(empty($this->request->data['User']['password'])){
						$this->request->data['User']['password']='';
						}
					}
					
					// 24 july 2013
					if(empty($this->request->data['Candidate']['citizen_status_code']))
					unset($this->request->data['Candidate']['citizen_status_code']);
					
					
					if($this->Candidate->saveAll($this->request->data))
					{
							$this->Session->write('popup','Profile has been updated successfully.');			
							$this->redirect(array('controller'=>'candidates','action'=>'editprofile/'.$this->Session->read('Auth.Client.User.candidate_id')));
					}
					
				}
			
		 endif;
				
		else:
			$condition='Candidate.id='.$id;
			$candidateREC=$this->Candidate->find('first',array('conditions'=>$condition));
			
			$candidate_name = explode(" ",$candidateREC['Candidate']['candidate_name']);
			$candidateREC['Candidate']['candidate_fname'] = preg_replace('~\s+\S+$~', '', $candidateREC['Candidate']['candidate_name']);
			$candidateREC['Candidate']['candidate_lname'] = end($candidate_name);
			
			if($candidateREC['Candidate']['country_code'])
			{
				$this->set('statList',$this->common->getAjaxStateList($candidateREC['Candidate']['country_code'])); //    find statelist
			}else
			{
				$this->set('statList',$this->common->getAjaxStateList(15)); //    find statelist
			}
			
			
			if($candidateREC['Candidate']['country_code']!='15' and $candidateREC['Candidate']['country_code']!='16')
							{
								if(!empty($candidateREC['Candidate']['candidate_state']))
								{
									$candidateREC['Candidate']['candidate_state22']=$candidateREC['Candidate']['candidate_state'];
								}
							}
			
			//pr($candidateREC);die;
			unset($candidateREC['User']['password']);
			
			$this->request->data=$candidateREC;	
			$this->request->data['Candidate']['security_clearance_code']=explode(',',$candidateREC['Candidate']['security_clearance_code']);
			$this->request->data['Candidate']['pref_industries']=explode(',',$candidateREC['Candidate']['pref_industries']);
			$this->request->data['Candidate']['pref_locations']=explode(',',$candidateREC['Candidate']['pref_locations']);
			
			//pr($this->request->data['Candidate']['candidate_state']);die;
			
			if($candidateREC['Candidate']['candidate_privacy']=='Y'):
				$this->request->data['Candidate']['candidate_privacy']='1';
			else:
				$this->request->data['Candidate']['candidate_privacy']='0';
			endif;
			
			
		endif;
		
		
		$cityList=$this->common->getCityList($this->request->data['Candidate']['candidate_state']);
		$this->set('cityList',$cityList);	
	}
	
	
	
	function jobseeker_trackApplication()		//================= Track Application===============
	{	$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','Jobseeker Applied Job List');
		
		
		$this->paginate = array(
					'fields'=>'ApplyHistory.track_id,ApplyHistory.dt,ApplyHistory.job_title,ApplyHistory.employer_name,ApplyHistory.notes, 					 		 
								Employer.employer_name,Employer.id,Resume.resume_title,Resume.id,JobPosting.posting_id,JobPosting.job_title',
					'conditions'=>'ApplyHistory.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"',
					'order'=>'ApplyHistory.track_id DESC',
					'paramType' => 'querystring',
					'limit'=>'10'
				);
				$empRec= $this->paginate('ApplyHistory');
			$this->set('seekerApplyhistory',$empRec);
	}
	
	
	function jobseeker_scheduledInterviewList($showId= null)		//================= Scheduled interview list===============
	{
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Jobseeker Interview List');
		$this->paginate = array(
					'conditions'=>'ShowInterview.show_id="'.$showId.'" and  ShowInterview.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'" ',
					'order'=>'ShowInterview.show_id DESC',
					'paramType' => 'querystring',
					'limit'=>'10'
				);
		$InterviewRec= $this->paginate('ShowInterview');
		$this->set('InterviewRec',$InterviewRec);
	}
	
	
	
	function Jobseeker_jobDetail($postingId=NULL)   //=============== Job Detail===============
	{
	
		//$this->Session->write('redirect_action_url','Jobseeker/candidates/jobDetail/?jobId='.$postingId);
		//$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','JobDetail');
		$this->set('backtoSearchPage',$this->Session->read('queryString'));
		
		if(!empty($this->params->query['jobId']))
		{
			$postingId=$this->params->query['jobId'];
		}
		
		if($postingId)
		{
		$conditions='';
			
			$jobPostingDetail=$this->JobPosting->find('first',array('conditions'=>'JobPosting.posting_id="'.$postingId.'" and 
																JobPosting.start_dt > DATE(NOW() - INTERVAL 180 DAY) and JobPosting.active=1
																'));
			
			$this->set('jobPostingDetail',$jobPostingDetail);
			
			$SearchIdList=$this->Session->read('SearchIdList');
			if(isset($SearchIdList) && !empty($SearchIdList))
			{
			$CurrentPostKey= array_pop(array_keys($this->Session->read('SearchIdList'),$postingId));
			$nextJobId=''; 
			$previousJobId='';
			
			
			
			if(array_key_exists($CurrentPostKey+1,$SearchIdList))
			{
				$nextJobId=$SearchIdList[$CurrentPostKey+1];
			}
			
			if(array_key_exists($CurrentPostKey-1,$SearchIdList))
			{
				$previousJobId=$SearchIdList[$CurrentPostKey-1];
			}
			$this->set('nextJobId',$nextJobId);
			$this->set('previousJobId',$previousJobId);
			}
			
			
		}
		
		
		
		
	}
	
	function Jobseeker_jobDetails($postingId=NULL)   //=============== Job Detail===============
	{
		$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','JobDetail');
		
		if($this->request->is('get'))
		{
			$jobPostingDetail=$this->JobPosting->find('first',array('conditions'=>'JobPosting.posting_id="'.$postingId.'"'));
			$this->set('jobPostingDetail',$jobPostingDetail);
			
			$CurrentPostKey= array_pop(array_keys($this->Session->read('autoMatchList'),$postingId));
			$nextJobId='';
			$previousJobId='';
			$autoMatchList=$this->Session->read('autoMatchList');
			
			
			if(array_key_exists($CurrentPostKey+1,$autoMatchList))
			{
				$nextJobId=$autoMatchList[$CurrentPostKey+1];
			}
			
			if(array_key_exists($CurrentPostKey-1,$autoMatchList))
			{
				$previousJobId=$autoMatchList[$CurrentPostKey-1];
			}
			$this->set('nextJobId',$nextJobId);
			$this->set('previousJobId',$previousJobId);
		}
	
		
	}
	
	function Jobseeker_appliedjobDetail()   //=============== Job Detail for whic applied by user===============
	{
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Applied Job Detail');
		$postingId=$this->params->params['pass']['0'];
		if($postingId):
			$jobPostingDetail=$this->JobPosting->find('first',array('conditions'=>'JobPosting.posting_id="'.$postingId.'"'));
			$this->set('jobPostingDetail',$jobPostingDetail);
		endif;
	}
	
	
	
	function Jobseeker_employeDetail()  // Employee Detail 
	{
		//$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Employer Detail');
		
		$employeeId=$this->params->params['pass']['0'];
		$this->set('employerDetail',$this->Employer->find('first',array('conditions'=>array('Employer.id="'.$employeeId.'"'))));
		
		$this->loadModel('EmployerVideo');
		$EmployerVd = $this->EmployerVideo->find('first',array('conditions'=>array('EmployerVideo.employer_id'=>$employeeId,'EmployerVideo.isApproved'=>'Y'),'order'=>'EmployerVideo.id DESC','fields'=>array('video_type','video','description','id')));
		$this->set('EmployerVd',$EmployerVd);
	}
	
	function Jobseeker_higherEducationPlan()  // Employee Detail 
	{
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Higher Education');
		$this->set('trainingschools',$this->TrainingSchool->find('all',array('fields'=>'ts_profile,ts_logo_path,ts_web')));
	}
	
	function Jobseeker_searchJob()  // action for job searching.......
	{	
		$this->set('statList',$this->common->getStateList());
		$candidateId=$this->Session->read('Auth.Client.User.candidate_id');
		
		
		//$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','Search Job');
		
			/* if($this->Session->read('Auth.Client.User.id')=='')
			{ 
				
				$this->Session->Write('Auth.Redirects',str_replace('&matching=','?matching=',$_SERVER['QUERY_STRING']));
				$this->redirect(array('controller'=>'users','action'=>'login','Jobseeker'=>false));
			}else
			{
			$this->isJobSeekerLogin();  // login check  */
			
			
				$queryString=explode('?',$_SERVER['REQUEST_URI']);  //session for  back to search button
				$this->Session->Write('queryString',$queryString[count($queryString)-1]);
							
				
				$this->set('WorkTypeList',$this->common->getWorkTypeList());
				$this->set('WorkTimeList',$this->common->getWorkTimeList());
				$this->set('WorkLocationList',$this->common->getWorkLocationList());
				$this->set('GovCleareanceList',$this->common->getGovCleareanceList());
				$cityList=array('0'=>'please select a city');
				$this->set('cityList',$cityList);
		
				$stringPostingIds='';
				$conditions='';
				
				
			
				if(count($this->params->query))
				{
				
					$this->Session->Write('searchKeyword',$this->params->query['keyword']);
					if(!empty($this->params->query['matching']))
					{
						$matchingType=$this->params->query['matching'];
					}else
					{
						$matchingType='';
					}
					$this->request->data['JobPosting']['matching']=$matchingType;
					
					if(!empty($this->params->query['data']['location_city']))
					{
						$this->request->query['location_city']=$this->params->query['data']['location_city'];
					}
					if(!empty($this->params->query['data']['security_clearance_code']))
					{
						$this->request->query['security_clearance_code']=$this->params->query['data']['security_clearance_code'];
					}
					
					if(!empty($this->params->query['data']['location_state']))
					{
						$this->request->query['location_state']=$this->params->query['data']['location_state'];
					}
					
					switch($matchingType)
					{
						case 'Any':
								if(!empty($this->params->query['keyword']))
									{	
									$keyword=str_replace(',',' ',trim($this->params->query['keyword']));
									$keyword=str_replace('(',' ',$keyword);
									$keyword=str_replace(' and ',' ',$keyword);
									$keyword=str_replace(' or ',' ',$keyword);
									$keyword=str_replace(' not ','',$keyword);
									$keyword=str_replace("'",' ',$keyword);
									$keyword=str_replace(")",' ',$keyword);
									
									$arrayKeyword=explode(' ',$keyword);
									$arrayKeyword=array_filter($arrayKeyword);
									$arrayKeyword=array_values($arrayKeyword);
									
									$totalKeyword=count($arrayKeyword);
									$i=1;
									foreach($arrayKeyword as $KeywordKey =>$KeywordValue)
									{	
										
										if($KeywordValue)
										{
											if(!empty($conditions))
											{
												$conditions.=' or ';
											}
											if($i=='1')
											{
												$conditions.=' ( ';
											}
											
											$conditions.= '(JobPosting.full_descr like "%'.$KeywordValue.'%" or JobPosting.job_title like "%'.$KeywordValue.'%" or Employer.employer_name like "%'.$KeywordValue.'%")';
											
											if($i==$totalKeyword)
											{
											$conditions.=' ) ';
											}
										}
									
										$i=$i+1;
									}
									
										$this->request->data['Candidates']['keyword']=$this->params->query['keyword'];
									}
								break;
								
						case 'All':
								if(!empty($this->params->query['keyword']))
									{		
									$keyword=str_replace(',',' ',trim($this->params->query['keyword']));
									$keyword=str_replace('(',' ',$keyword);
									$keyword=str_replace(' and ',' ',$keyword);
									$keyword=str_replace(' or ',' ',$keyword);
									$keyword=str_replace(' not ','',$keyword);
									$keyword=str_replace("'",' ',$keyword);
									$keyword=str_replace(")",' ',$keyword);
									
									$arrayKeyword=explode(' ',$keyword);
									$arrayKeyword=array_filter($arrayKeyword);
									$arrayKeyword=array_values($arrayKeyword);
									
									foreach($arrayKeyword as $KeywordKey =>$KeywordValue)
									{
										if(!empty($conditions))
										{
											$conditions.=' and ';
										}
										
										$conditions.= '(JobPosting.full_descr like "%'.$KeywordValue.'%" or JobPosting.job_title like "%'.$KeywordValue.'%" or Employer.employer_name like "%'.$KeywordValue.'%")';	
									}
									
									 $this->request->data['Candidates']['keyword']=$this->params->query['keyword'];
									}
								break;
						
						case 'Exact':
									if(!empty($this->params->query['keyword']))
									{		
									$keyword=str_replace(',',' ',trim($this->params->query['keyword']));
									$keyword=str_replace('(',' ',$keyword);
									$keyword=str_replace(' and ',' ',$keyword);
									$keyword=str_replace(' or ',' ',$keyword);
									$keyword=str_replace(' not ','',$keyword);
									$keyword=str_replace("'",' ',$keyword);
									$keyword=str_replace(")",' ',$keyword);
									
									$arrayKeyword=explode(' ',$keyword);
									$arrayKeyword=array_filter($arrayKeyword);
									$arrayKeyword=array_values($arrayKeyword);
									
									$conditions.= '( JobPosting.full_descr like "%'.implode(' ',$arrayKeyword).'%" or JobPosting.full_descr like "%'.trim($this->params->query['keyword']).'%"  or JobPosting.job_title like "%'.trim($this->params->query['keyword']).'%" or Employer.employer_name like "%'.$KeywordValue.'%")';	
									
									 $this->request->data['Candidates']['keyword']=$this->params->query['keyword'];
									}
									
								break;
								
						case 'default':
								break;
					}
					
					
				
						if(!empty($this->params->query['work_type_code']))
							{
										if(!empty($conditions))
										{
											$conditions.=' and ';
											
										}
										$conditions.='JobPosting.work_type_code="'.$this->params->query['work_type_code'].'"';
										$this->request->data['JobPosting']['work_type_code']=$this->params->query['work_type_code'];
							}
							
							
						if(!empty($this->params->query['candidate_state']))
							{
										if(!empty($conditions))
										{
											$conditions.=' and ';
											
										}
										$conditions.='JobPosting.work_type_code="'.$this->params->query['work_type_code'].'"';
										$this->request->data['JobPosting']['work_type_code']=$this->params->query['work_type_code'];
							}
									
							
									
						if(!empty($this->params->query['work_location_code']))
							{
										if(!empty($conditions))
										{
											$conditions.=' and ';
											
										}
										$conditions.='JobPosting.work_location_code="'.$this->params->query['work_location_code'].'"';
										$this->request->data['JobPosting']['work_location_code']=$this->params->query['work_location_code'];
									}
									
						if(!empty($this->params->query['work_time_code']))
							{
										if(!empty($conditions))
										{
											$conditions.=' and ';
											
										}
										$conditions.='JobPosting.work_time_code="'.$this->params->query['work_time_code'].'"';
										$this->request->data['JobPosting']['work_time_code']=$this->params->query['work_time_code'];
							}
						
						
							if(!empty($this->params->query['location_state']))
							{
										if(!empty($conditions))
										{
											$conditions.=' and ';
											
										}
										$conditions.='JobPosting.location_state	="'.$this->params->query['location_state'].'"';
										$this->request->data['JobPosting']['location_state']=$this->params->query['location_state'];
							
										$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$this->params->query['location_state'].'"','fields'=>'city,city','order by city ASC'));
										$this->set('cityList',$cityList);
							}		
								
							if(!empty($this->params->query['location_city']))
							{
								
										if(!empty($conditions))
										{
											$conditions.=' and (';
										}else
										{
											$conditions.=' ( ';
										}
										
										if(is_array($this->params->query['location_city']))
										{
											$locationCities=$this->params->query['location_city'];
											count($locationCities);
											$totallocationCities=count($locationCities);
											$stringlocationCities='';
											$i=1;
											foreach($locationCities as $key7=>$value7)
											{
												$conditions.= 'JobPosting.location_city like "%'.$value7.'%"';
												
												if($i!=$totallocationCities)
												{
													$conditions.=" or ";
												}else
												{
													$conditions.=" ) ";
												}
												$i=$i+1;
												
												$this->request->data['JobPosting']['location_city'][$value7]=$value7;
												$this->request->data['JobPosting']['data']['location_city'][$value7]=$value7;
											}
											
										 }
										 
										  
								
									}	
									
								
								
						if(!empty($this->params->query['security_clearance_code']))
							{
								
										if(!empty($conditions))
										{
											$conditions.=' and (';
										}else
										{
											$conditions.=' ( ';
										}
										
										if(is_array($this->params->query['security_clearance_code']))
										{
											$securityClearances=$this->params->query['security_clearance_code'];
											count($securityClearances);
											$totalSecurityClearance=count($securityClearances);
											$stringSecurityClearance='';
											$i=1;
											foreach($securityClearances as $key7=>$value7)
											{
												$conditions.= 'JobPosting.security_clearance_code like "%'.$value7.'%"';
												
												if($i!=$totalSecurityClearance)
												{
													$conditions.=" or ";
												}else
												{
													$conditions.=" ) ";
												}
												$i=$i+1;
												
												
												$this->request->data['JobPosting']['security_clearance_code'][$value7]=$value7;
											}
											
										 }
										 else
										 {
										 	
											$conditions.= 'JobPosting.security_clearance_code like "%'.$this->params->query['security_clearance_code'].'%" )';
											
											$this->request->data['JobPosting']['security_clearance_code'][$this->params->query['security_clearance_code']]=$this->params->query['security_clearance_code'];
										 }
										  
								
									}
										
						
								
						if(!empty($this->params->query['employer_name']))
							{
							if(!empty($conditions))
										{
											$conditions.=' and ';
										}
										$conditions.='Employer.employer_name like "%'.$this->params->query['employer_name'].'%"';
										
										$this->request->data['Employer']['employer_name']=$this->params->query['employer_name'];
							}
						
						// task id 2598 
							if(isset($this->params->query['keyword']) && !empty($this->params->query['keyword']))
							{
								//$conditions.=' OR Employer.employer_name like "%'.$this->params->query['keyword'].'%" ';	
							}	
				
					if(!empty($this->params->query['employer_type_code']))
							{
										if(!empty($conditions))
										{
											$conditions.=' and ';
										}
										$conditions.='Employer.employer_type_code="%'.$this->params->query['employer_type_code'].'%"';
										
										$this->request->data['Employer']['employer_type_code']=$this->params->query['employer_type_code'];
							}
							
					$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
					if($conditions)
					{
						$conditions.=' and JobPosting.start_dt > DATE(NOW() - INTERVAL 180 DAY) and JobPosting.active=1	';
					}else
					{
						$conditions.=' JobPosting.start_dt > DATE(NOW() - INTERVAL 180 DAY) and JobPosting.active=1	';
					}
					
					if($conditions)
					{
						$this->JobPosting->unbindModel(array('hasMany' => array('ResumeScore','JobScore')));
						$this->paginate = array(
							'limit' => 10,
							'conditions'=>$conditions,
							'paramType' => 'querystring',
							'order' => 'JobPosting.start_dt DESC'
						);
						$jobLists= $this->paginate('JobPosting');
						
						
				//		echo $this->JobPosting->getLastQuery();
					//	die;
						/*echo $conditions;
						echo '<pre>';
						print_r($jobLists);die;*/
						$this->set('jobLists', $jobLists);
						
						//  session to calulate previous or next button 
						$this->JobPosting->recursive = 0;
						$SearchIdList = $this->JobPosting->find("all",array('conditions'=>$conditions,'paramType' => 'querystring','order' => 'JobPosting.start_dt DESC'));
						$totalJobs =count($SearchIdList);
						$this->set('totalJobs', $totalJobs);
						$SearchIdList = Set::extract('/JobPosting/posting_id', $SearchIdList);
						$this->Session->Write('SearchIdList',$SearchIdList);	
						/*** Just display related jobs from same events with same skills there if no records found ***/
						
						
						
						//echo $totalJobs;
						if($totalJobs==0){
							
							$candidateId=$this->Session->read('Auth.Client.User.candidate_id');
							if($candidateId){
							$options['joins'] = array(
									array('table' => 'job_posting_skills',
											'alias' => 'JobPostingSkill',
											'type' => 'inner',
											'conditions' => array(
													'JobPosting.posting_id = JobPostingSkill.posting_id'
											)
									),
									array('table' => 'resume_skills',
											'alias' => 'ResumeSkill',
											'type' => 'inner',
											'conditions' => array(
													'JobPostingSkill.skill_id = ResumeSkill.skill_id'
											)
									),
									array('table' => 'resumes',
											'alias' => 'Resume',
											'type' => 'inner',
											'conditions' => array(
													'ResumeSkill.resume_id = Resume.id'
											)
									)
							);
							//Resume.candidate_id=".$candidateId." AND
							//$skill_jobs_condition = "JobPosting.start_dt > DATE(NOW() - INTERVAL 180 DAY) and JobPosting.active=1";
							$skill_jobs_condition = "Resume.candidate_id=".$candidateId." AND JobPosting.start_dt > DATE(NOW() - INTERVAL 180 DAY) and JobPosting.active=1";
							
							$options['conditions'] = array($skill_jobs_condition);
							$options['fields'] = array("distinct(JobPosting.posting_id),JobPosting.job_title,JobPosting.location_state,JobPosting.location_city,JobPosting.work_location_code,JobPosting.work_type_code,JobPosting.start_dt,Employer.employer_name,JobPosting.short_descr,JobPosting.salary_type_code,JobPosting.security_clearance_code");
							
							$options['order'] = array("JobPosting.start_dt DESC");
							$this->JobPosting->recursive = 0;
							$relatedjobs = $this->JobPosting->find('all', $options);
							
							$relatedjobs_count = count($relatedjobs);
							$this->set('relatedjobs', $relatedjobs);
							$this->set('relatedjobs_count', $relatedjobs_count);
							
							
							//// set section to calculate next and previous buton
							$this->JobPosting->recursive = 0;
							$autoMatchList = $this->JobPosting->find("all",$options);
							
							$autoMatchList = Set::extract('/JobPosting/posting_id', $autoMatchList);
							$this->Session->Write('autoMatchList',$autoMatchList);	
						}else{
							$this->Session->Write('autoMatchList','');	
						}
						}
						$this->set('searchresult','searchresult');
					}
					else
					{
						$array=array('Please enter a keyword');
						$this->set('jobLists',array());
						
					}	
						
					
				}else
				{
					$this->set('jobLists',array());
				}
			/* }	 */
	
	}
	
	function Jobseeker_autoMatching($ResumeId=null)  // action for job searching.......
	{
		$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','Job Matching');
		$conditions='';
		
		if(empty($ResumeId)) // all matching jobs basic of all resume
		{
				$candidateId=$this->Session->read('Auth.Client.User.candidate_id');
				$options['joins'] = array(
									array('table' => 'job_posting_skills',
											'alias' => 'JobPostingSkill',
											'type' => 'inner',
											'conditions' => array(
													'JobPosting.posting_id = JobPostingSkill.posting_id'
											)
									),
									array('table' => 'resume_skills',
											'alias' => 'ResumeSkill',
											'type' => 'inner',
											'conditions' => array(
													'JobPostingSkill.skill_id = ResumeSkill.skill_id'
											)
									),
									array('table' => 'resumes',
											'alias' => 'Resume',
											'type' => 'inner',
											'conditions' => array(
													'ResumeSkill.resume_id = Resume.id'
											)
									)
							);
							$skill_jobs_condition = "Resume.candidate_id=".$candidateId." AND JobPosting.start_dt > DATE(NOW() - INTERVAL 180 DAY) and JobPosting.active=1";
							
							$options['conditions'] = array($skill_jobs_condition);
							$options['limit']=10;
							$options['paramType']='querystring';
							$options['fields']="distinct(JobPosting.posting_id),JobPosting.posting_id,JobPosting.job_title,JobPosting.work_location_code, 		
												JobPosting.start_dt,JobPosting.end_dt,JobPosting.short_descr,JobPosting.salary_type_code,JobPosting.security_clearance_code, 
												JobPosting.work_type_code, Employer.employer_name";
							$options['order'] ="JobPosting.start_dt desc";
							$this->JobPosting->recursive = 0;
							$this->paginate = $options;
							$jobLists= $this->paginate('JobPosting');
							$relatedjobsCount = count($jobLists);
							$this->set('jobLists', $jobLists);
							$this->set('totalRelatedjobs', $relatedjobsCount);
							
							
							
							/// find list of all record fetch for this condition
							$this->JobPosting->recursive = 0;
							$autoMatchList = $this->JobPosting->find("all",$options);
							
							$autoMatchList = Set::extract('/JobPosting/posting_id', $autoMatchList);
							$this->Session->Write('autoMatchList',$autoMatchList);	
							
							
							// end 								
		}
		else   	// all matching jobs for selected  resume
		{
				$candidateId=$this->Session->read('Auth.Client.User.candidate_id');
				$options['joins'] = array(
									array('table' => 'job_posting_skills',
											'alias' => 'JobPostingSkill',
											'type' => 'inner',
											'conditions' => array(
													'JobPosting.posting_id = JobPostingSkill.posting_id'
											)
									),
									array('table' => 'resume_skills',
											'alias' => 'ResumeSkill',
											'type' => 'inner',
											'conditions' => array(
													'JobPostingSkill.skill_id = ResumeSkill.skill_id'
											)
									),
									array('table' => 'resumes',
											'alias' => 'Resume',
											'type' => 'inner',
											'conditions' => array(
													'ResumeSkill.resume_id = "'.$ResumeId.'"'
											)
									)
							);
							$skill_jobs_condition = "Resume.candidate_id=".$candidateId." AND JobPosting.start_dt > DATE(NOW() - INTERVAL 180 DAY) and JobPosting.active=1";
							
							$options['conditions'] = array($skill_jobs_condition);
							$options['limit']=10;
							$options['paramType']='querystring';
							$options['fields'] = array("distinct(JobPosting.posting_id),JobPosting.*,Employer.*");
							
							$options['order'] = array("JobPosting.start_dt DESC");
							$this->JobPosting->recursive = 0;
							$this->paginate = $options;
							$jobLists= $this->paginate('JobPosting');
							
							$relatedjobsCount = count($jobLists);
							$this->set('jobLists', $jobLists);
							$this->set('totalRelatedjobs', $relatedjobsCount);
							
							
							/// find list of all record fetch for this condition
							$this->JobPosting->recursive = 0;
							$autoMatchList = $this->JobPosting->find("all",$options);
							
							$autoMatchList = Set::extract('/JobPosting/posting_id', $autoMatchList);
							$this->Session->Write('autoMatchList',$autoMatchList);	
								
												
		
	}
	
	}
	
	function Jobseeker_searchCompanies()
	{	
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('industryList',$this->common->getIndustriesList());  // get industry list
		$this->set('stateList',$this->common->getStateList());  // get state list
		$this->set('companyDiv','');
		$this->set('meta_title','Search Company');
		$this->set('empRecNonAlpha',array());
		$this->set('start','');
		
		//pr($this->params->query);die;
		
		
	
		if(empty($this->params->query['employer_name'])  and empty($this->params->query['employer_type_code']) and empty($this->params->query['contact_state']))
		{	
		
			if(empty($this->params->query))
			{
				$this->params->query['start']='a,b,c';
			}
			
		
			if(!empty($this->params->query['num']))
			{
					$this->Employer->unBindModel(array('hasMany' => array('EmployerContact','JobPosting')));
					$empRecNonAlpha=$this->Employer->find('all',array('conditions'=>'ASCII(employer_name) not in(65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122)'));
			$this->set('empRecNonAlpha',$empRecNonAlpha);	
			}
		
					
			$this->set('start',$this->params->query['start']);
			$arrayStart=explode(',',$this->params->query['start']);
			foreach($arrayStart as $key=>$value)
			{
			 	$this->paginate = array(
					'conditions'=>'Employer.employer_name like"'.$value.'%"',
					'paramType' => 'querystring',
					'limit'=>'2000'
				);
				$empRec= $this->paginate('Employer');
				
				//echo $this->Employer->getLastQuery();
				
			//	$empRec=$this->Employer->find('all',array('conditions'=>'Employer.employer_name like"'.$value.'%"'));
				/*echo '<pre>';
				print_r($empRec);*/
				$this->set($value,$empRec);
			}	
			
		}
		else
		{
			$this->params->query['employer_name'] = str_replace('"','\"',$this->params->query['employer_name']);
			$this->set('empRecNonAlpha',array());
			$this->set('start',$this->params->query['employer_name']);
			
			
			$condition='';
			if($this->params->query['employer_name'])
			{
				$condition ='Employer.employer_name like"%'.$this->params->query['employer_name'].'%" ';
			}
			
			if($this->params->query['employer_type_code'])
			{
				if($condition)
				{
					$condition.=' and ';
				}
				$condition .=' Employer.employer_type_code like"%'.$this->params->query['employer_type_code'].'%" ';
			}
			
			if($this->params->query['contact_state'])
			{
				if($condition)
				{
					$condition.=' and ';
				}
				$condition .=' EmployerContact.contact_state like"%'.$this->params->query['contact_state'].'%" ';
				
			}
			
			$this->paginate = array(
					'conditions'=>$condition,
					'paramType' => 'querystring',
					'limit'=>'5000'
				);
				$empRec= $this->paginate('Employer');
			
			$this->set('companyList',$empRec);
			
			$this->set('companyDiv','Company');
			$this->request->data['Candidates']['employer_name']=$this->params->query['employer_name'];
			$this->request->data['Candidates']['employer_type_code']=$this->params->query['employer_type_code'];
			$this->request->data['Candidates']['contact_state']=$this->params->query['contact_state'];
		}
	}
	
	function Jobseeker_jobApply()
	{
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Apply for Job');
		$this->set('Error','');
		
		if($this->Session->read('Auth.Client.User.id'))
		{	
		$ResumeList=$this->Resume->find('list',array('fields'=>'id,resume_title','conditions'=>'Resume.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"'));
		$this->set('ResumeList',$ResumeList);
		$this->set('JobId',$this->params->query['jobId']);
		}
		
		
		if(!empty($this->request->data['ApplyHistory']['SUBMIT']))
		{
		
				
				$this->ApplyHistory->set($this->request->data);
				
				if(!$this->ApplyHistory->validationApplyJob()):
					$errorsArr = $this->ApplyHistory->validationErrors;	
				else:
				//pr($this->request->data['ApplyHistory']['resume_id']);die;
				$data=$this->request->data;
			
				$ResumeTitle = $this->Resume->find('first',array('fields'=>'resume_title', 
															   'conditions'=>'Resume.id="'.$this->request->data['ApplyHistory']['resume_id'].'"')); //# RESUME TITLE
				
				#==== jobdetail of employeer
				
				$this->JobPosting->unBindModel(array('hasMany' => array('JobPostingSkill','JobScore','ResumeScore')));
				
				$jobDetail=$this->JobPosting->find('first',array(												'conditions'=>'JobPosting.posting_id="'.$this->params->query['jobId'].'"'));
				
				$this->loadModel('EmployerContact');  // get employeer email for mail
	
				 
				$this->EmployerContact->unBindModel(array('hasOne'=>array('User'),'belongsTo'=>array('Employer')));
				$employeer_contact_detail=$this->EmployerContact->findByemployer_id($jobDetail['Employer']['id']);
				
			
				
				$data['ApplyHistory']['contact_email_job']=$employeer_contact_detail['EmployerContact']['contact_email_job'];
				
				
				$data['ApplyHistory']['candidate_id']=$this->Session->read('Auth.Client.User.candidate_id');
				$data['ApplyHistory']['resume_title']=$ResumeTitle['Resume']['resume_title'];
				$data['ApplyHistory']['posting_id']=$jobDetail['JobPosting']['posting_id'];
				$data['ApplyHistory']['job_title']=$jobDetail['JobPosting']['job_title'];
				$data['ApplyHistory']['employer_id']=$jobDetail['Employer']['id'];
				$data['ApplyHistory']['employer_name']=$jobDetail['Employer']['employer_name'];
				$data['ApplyHistory']['dt']=date('Y-m-d',time());
				
				
				//======== check already for job or not==============
				$checkApplyExists=$this->ApplyHistory->find('count',array(	
										'conditions'=>'ApplyHistory.posting_id="'.$data['ApplyHistory']['posting_id'].'" and
														ApplyHistory.resume_id="'.$data['ApplyHistory']['resume_id'].'" and
													ApplyHistory.candidate_id="'.$data['ApplyHistory']['candidate_id'].'"',
										'order' => array('ApplyHistory.id DESC')
																		)
															 );
															 
				if($checkApplyExists)
				{
					$this->set('Error','Already applied for this job');
				}else
				{
			
				
			if(strpos($data['ApplyHistory']['contact_email_job'],';')){
			
				$email_address=explode(';',$data['ApplyHistory']['contact_email_job']);
				$email_address = array_filter(array_map('trim', $email_address));
				
				
			}else if(strpos($data['ApplyHistory']['contact_email_job'],',')){
				$email_address=explode(',',$data['ApplyHistory']['contact_email_job']);
				$email_address = array_filter(array_map('trim', $email_address));
				
			}else{
				$email_address=(array)$data['ApplyHistory']['contact_email_job'];
				$email_address = array_filter(array_map('trim', $email_address));
				
			}	
				
			
			
			$email_address = array_filter(array_map('trim', $email_address));
			
				
				$this->Candidate->id=$this->Session->read('Auth.Client.User.candidate_id');
				$from=$this->Candidate->field('candidate_email');
				//mail to candidate 
				
						$sendto=$email_address;
						$sendfrom = 'resumes@techexpousa.com';//$from;
						//$emailMessage = $this->request->data['MASSEMAIL']['message'];
						$subject ="Resume sent via techexpoUSA.com for the following job:".$data['ApplyHistory']['job_title'];
						 						
											
						$bodyText =$data['ApplyHistory']['notes'];
						
						$bodyData = "Hello <br/><br/>
									  A candidate applied for your job opening: <strong>".$data['ApplyHistory']['job_title']." </strong><br/><br/>
									".$bodyText."
									<br/><br/>
									Thank You
									";
				
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						
						
						$this->Resume->id = $this->request->data['ApplyHistory']['resume_id'];
						
						$getfilename = $this->Resume->field('filename');
					
						$attachfilePath = WWW_ROOT."candidateDocument/resume/".$getfilename;
						if(!empty($getfilename) && file_exists( WWW_ROOT."candidateDocument/resume/".$getfilename)){
						
							$email->attachments(array($attachfilePath));
						}else
						{ 
							$getResumevalue = $this->Resume->field('resume_content');
							$rtf=strip_tags($getResumevalue,'<br>&nbsp;');  // creating rtf file
							file_put_contents('candidateDocument/resumeSend/resume_'.$this->request->data['ApplyHistory']['resume_id'].'.rtf', $rtf);	
							$attachfilePath = 'candidateDocument/resumeSend/resume_'.$this->request->data['ApplyHistory']['resume_id'].'.rtf';
							$email->attachments(array($attachfilePath));
							
						}
					
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$email->send($bodyData);
							
							
				
				
				if($this->ApplyHistory->save($data)):
						$this->Session->write('popup','Application for this job has been sent successfully.');
						$this->redirect(array('controller'=>'candidates','action'=>'searchJob'));
					endif;
				} 
				
				endif;
			
		}
	}
	
	function Jobseeker_sendEmailToFriend() // Function for send a mail to friend
	{
		
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Tell a Friend');
		$this->set('JobId',$this->params->query['jobId']);
		if($this->request->data)
		{
			if($this->request->data['Candidate']['SUBMIT']=='SUBMIT')
			{
				$jobDetail=$this->JobPosting->find('first',array('fields'=>'JobPosting.posting_id,JobPosting.job_title,JobPosting.last_salary,JobPosting.location_city,
																			JobPosting.location_state,JobPosting.short_descr,Employer.id,Employer.employer_name',
																'conditions'=>'JobPosting.posting_id="'.$this->params->query['jobId'].'"'));
				
				
				$this->set('candidateEmail',$this->request->data['Candidate']['candidate_email']);
				
				$this->Candidate->set($this->request->data);
				
				$errorsArr='';
					if(!$this->Candidate->sendEmailToFriend()):
					
						$errorsArr = $this->Candidate->validationErrors;	
					else:
					
					endif;
				
				if(!$errorsArr){
	
					$postingID				= 	$jobDetail['JobPosting']['posting_id'];
					$jobTitle 				= 	$jobDetail['JobPosting']['job_title'];
					$jobEmployer 			= 	$jobDetail['Employer']['employer_name'];
					$jobSalary 				= 	$jobDetail['JobPosting']['last_salary'];
					$jobLocationCity 		= 	$jobDetail['JobPosting']['location_city'];
					$jobLocationState 		= 	$jobDetail['JobPosting']['location_state'];
					$jobShortDesc 			= 	$jobDetail['JobPosting']['short_descr'];
					$jobUrl					=	FULL_BASE_URL.router::url('/',false)."employers/jobdetail/".$postingID;
						
						// Email configuration
						$sendto = $this->request->data['Candidate']['candidate_friend_email'];
						
						if(strpos($this->request->data['Candidate']['candidate_friend_email'],',')){
							$sendto=explode(',',$this->request->data['Candidate']['candidate_friend_email']);
							
							$sendto = array_filter(array_map('trim', $sendto));
							
						}else{
							$sendto=(array)$this->request->data['Candidate']['candidate_friend_email'];
							$sendto = array_filter(array_map('trim', $sendto));
							
						}
						
					
						$sendfrom = $this->request->data['Candidate']['candidate_email'];
						$emailMessage = $this->request->data['Candidate']['message'];
						
						$subject = "A friend is forwarding you a job on techexpoUSA.com";
						/*$bodyText = "Someone you know has forwarded you a job. This job is posted on TechExpoUSA.com, the career center of choice for all technology professionals. To view this job and apply please visit the following link.<br/>".$jobUrl."<br/><br/>*************************************************************************************
						<br/><br/>Your friend or relative's e-mail address:  ".$sendfrom."
						<br/><br/>Your friend or relative's message (optional): ".nl2br($emailMessage)."
						<br/><br/>
						Job Title: ".$jobTitle."
						<br/>Employer: ".$jobEmployer."
						<br/>Salary (not always indicated): ".$jobSalary."
						<br/>Location: ".$jobLocationCity.", ".$jobLocationState."
						<br/>Short Description: ".$jobShortDesc." ";*/
						
						$bodyText = "$sendfrom has forwarded you a job from TechExpoUSA.com, the career center of choice for technology and Intelligence professionals.<br/>  To view and apply to this job visit :<br/>".$jobUrl."<br/><br/>*************************************************************************************
						<br/><br/>Message: ".nl2br($emailMessage)."
						<br/><br/>
						Job Title: ".$jobTitle."
						<br/>Employer: ".$jobEmployer."
						<br/>Salary (not always indicated): ".$jobSalary."
						<br/>Location: ".$jobLocationCity.", ".$jobLocationState."
						<br/>Short Description: ".$jobShortDesc." ";	
						
										
						
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
						
						
						$jobEmailHistory['JobEmailHistory']['from_email']=$this->request->data['Candidate']['candidate_email'];
						$jobEmailHistory['JobEmailHistory']['posting_id']=$this->params->query['jobId'];
						$jobEmailHistory['JobEmailHistory']['friend_email']=$this->request->data['Candidate']['candidate_friend_email'];
						$jobEmailHistory['JobEmailHistory']['date']=date('Y-m-d h:m:i');
						
						
						$this->JobEmailHistory->save($jobEmailHistory);
							
						$this->Session->write('popup','This Job has been sent successfully.');
						$this->redirect(array('controller'=>'candidates','action' => "sendEmailToFriend?jobId=".$postingID));
						
				
				}
			}
		}else
		{
			$this->set('candidateEmail',$this->Session->read('Auth.Client.Candidate.candidate_email'));
			
		}
	}
	
	
	// Function for view the employer registered event detail information
	public function Jobseeker_eventinfo($showID = null){
		$this->isJobSeekerLogin();  // login check 
	
	$this->set('meta_title','Techexpo: EventInfo');
		$this->set('meta_title','Employer Registered Event Information');
		$this->loadModel('Show');
		
		if($this->request->is('get')){
			// get only one month old events
			$condition  = "Show.id = ".$showID." ";	
		//	$eventInfo = $this->Show->find("first",array('conditions'=>array($condition)));
			
			$eventInfo = $this->Show->find("first",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'LEFT',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=> $condition));
	
			$this->set('regEventInfo',$eventInfo);
			// get the list of other employers who are also registered with this event
			$options['joins'] = array(
				array('table' => 'show_employers',
					'alias' => 'ShowEmployer',
					'type' => 'inner',
					'conditions' => array(
						'ShowEmployer.employer_id = Employer.id',
						/*'ShowEmployer.payment_status' => 'y',*/ //comment 01-11-2013 
						'ShowEmployer.show_id = '.$showID						
					)
				)
			);
			$options['order'] = array("Employer.employer_name ASC");
			$this->Employer->recursive = 1;
			$otherRegEmployer = $this->Employer->find('all', $options);
			
			$this->set('otherRegEmployer',$otherRegEmployer);
			// task id 3853
			$this->set('show_id',$showID);
		}
	}
	
	
	
	
	
	public function Jobseeker_upcomingEvent($showID = null)  // upcomin listing
	{
			$this->isJobSeekerLogin();  // login check 
			$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			
			
			$this->paginate = array('limit' => 10,
										'conditions'=>array('show_dt>="'.$targetdate.'" and Show.published=1 '),
										'paramType' => 'querystring',
										'order'=>'Show.show_dt asc'
										);
			$showRec= $this->paginate('Show');
			//pr($showRec);die;
			
			$this->set('showRec',$showRec); 	
	}
	
	public function Jobseeker_profileImage($showID = null)
	{
		$this->isJobSeekerLogin();  // login check 
		
		
		if($this->request->data)
		{
			if($this->request->data['UPLOAD']='UPLOAD')
			{
				//pr($this->request->data);die;
				$this->Candidate->set($this->request->data);  // check validation and save record	
				$errorsArr=array();
				
				if(!$this->Candidate->uploadProfileImage()) 
				{
				  	$errorsArr = $this->Candidate->validationErrors;	
				}
				else
				{
					/*$name = time().'_'.$this->data['Candidate']['candidate_image']['name']; // move file
					move_uploaded_file( $this->data['Candidate']['candidate_image']['tmp_name'], "upload/" .$name);
					$this->request->data['Candidate']['id']=$this->Session->read('Auth.Client.User.candidate_id');
					$this->request->data['Candidate']['candidate_image']=$name;*/
					App::import('Vendor', 'Uploader.Uploader');
					$this->Uploader = new Uploader();
					$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'upload/'));
					$fileUploadPath=$this->Uploader->upload($this->request->data['Candidate']['candidate_image'],array('prepend'=>time().'_','overwrite'=>true));               $this->Uploader->resize(array('width' => '150','height' => '80','prepend'=>"150x80_".time()."_",'append'=>false,'aspect'=>false,'expand'=>false));
					$this->request->data['Candidate']['id']=$this->Session->read('Auth.Client.User.candidate_id');
					$this->request->data['Candidate']['candidate_image'] 	=  end(explode('/',$fileUploadPath['path']));
					
					
					
					
					
					$this->Candidate->unBindModel(array('hasMany' => array('Resume')));
					$candidateRec=$this->Candidate->find('first',array('fields'=>'candidate_image',
																		'conditions'=>'Candidate.id="'.$this->Session->read('Auth.Client.User.candidate_id').'"'));
					
					
					if($candidateRec['Candidate']['candidate_image'])
					{
						unlink("upload/".$candidateRec['Candidate']['candidate_image']);
					}
					
					
					$this->Candidate->set($this->request->data); 
					if($this->Candidate->save($this->request->data))
					{
						$this->Session->write('popup','Thank you. Your profile image has been uploaded successfully.');
						$this->redirect(array('controller'=>'candidates','action'=>'profileImage'));
					}
					 
				}
			}
		}	
		
		$this->set('description',$this->Candidate->find('first',array('fields'=>'candidate_image,profile_description','conditions'=>'Candidate.id="'.$this->Session->read('Auth.Client.User.candidate_id').'"')));
	}
	
	/*************************Video list and upload section****************************/
	public function Jobseeker_videoList($action = null,$id = null)
	{
		$this->isJobSeekerLogin();  // login check 
		//pr($this->$this->Session->read('Auth'));
		
		$this->set('meta_title','Video List');
		$candidateID = $this->Session->read('Auth.Client.User.candidate_id');
		
		$candidatevideo_list =  $this->CandidateVideo->find('all',array('conditions'=>array('CandidateVideo.candidate_id="'.$candidateID.'" and isApproved="Y"'),'limit'=>'5'));
		$this->set('candidatevideo_list',$candidatevideo_list);
		
		
		if($this->request->data)
		{
			if($this->request->data['Candidate']['video_type']=='youtube')
			{
			$this->request->data['CandidateVideo']=$this->request->data['Candidate'];	
			$this->request->data['CandidateVideo']['candidate_id']= $candidateID;
			$this->CandidateVideo->save($this->request->data); 	
			/*$this->Session->write('popup','Thank you for submitting your video. Our TECHEXPO team is reviewing and it should appear in your dashboard shortly .');
			$this->redirect(array('controller'=>'candidates','action' => "videoList"));*/
			}
			else if($this->request->data['Candidate']['video_type']=='upload')
			{	
					$name = time().'_'.$this->data['Candidate']['video2']['name']; // move file
					move_uploaded_file( $this->data['Candidate']['video2']['tmp_name'], "upload/video/candidate/" .$name);
					//pr(move_uploaded_file( $this->data['Candidate']['video']['tmp_name'], "upload/video/candidate/" .$name));die;
					$this->request->data['Candidate']['video']=$name;
				
					$this->request->data['CandidateVideo']=$this->request->data['Candidate'];	
					$this->request->data['CandidateVideo']['candidate_id']= $candidateID;
					
					$this->CandidateVideo->save($this->request->data); 
					
			}
			
			// mail to admin
						$sendto =array('brand@techexpousa.com','pprobert@techexpousa.com','kfuller@techexpousa.com');
						$sendfrom = $this->Session->read('Auth.Client.Candidate.candidate_email');
						
						$subject = "Confirmation of candidate video";
						$bodyText = "Candidate has been uploaded new video please test and verify.";
						
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
						
						
			
			$this->Session->write('popup','Thank you for submitting your video. Our TECHEXPO team is reviewing your video and should appear in your dashboard shortly.');
			$this->redirect(array('controller'=>'candidates','action' => "videoList"));
			
		}
		
		
		if(!empty($id) && $action=='delete')
		{	 
			
			if($this->CandidateVideo->find('count',array('conditions'=>'CandidateVideo.id="'.$id.'" and CandidateVideo.candidate_id="'.$candidateID.'"','action'=>'')))
			{
		
			$this->CandidateVideo->delete($id);
			$this->Session->write('popup','Video has been deleted successfully.');
			$this->redirect(array('controller'=>'candidates','action'=>'videoList'));
			}
			else
			{
				$this->Session->write('popup','video not have a permission to delete.');
				$this->redirect(array('controller'=>'candidates','action'=>'videoList'));			
			}
		}
	}
	
	public function Jobseeker_showVideo($id = null  )
	{ 
		$this->layout = false;
		$video_dt = $this->CandidateVideo->find('first',array('conditions'=>array('CandidateVideo.id'=>$id)));
		$this->set('video_dt',$video_dt);
	}
	
	public function Jobseeker_editVideo($id = null)
	{
		$this->isJobSeekerLogin();  // login check  
		
		$candidateID = $this->Session->read('Auth.Client.User.candidate_id');
		
		if($this->request->is('post')){
			
			if($this->request->data['CandidateVideo']['video_type']=='youtube')
			{
				$this->CandidateVideo->save($this->request->data); 	
				$this->Session->write('popup','Video Edited successfully.');
				$this->redirect(array('controller'=>'candidates','action' => "videoList"));
			}
			else if($this->request->data['CandidateVideo']['video_type']=='upload')
			{	
					if($this->data['CandidateVideo']['videoFile']['name'])
					{
						$name = time().'_'.$this->data['CandidateVideo']['videoFile']['name']; // move file
						move_uploaded_file( $this->data['CandidateVideo']['videoFile']['tmp_name'], "upload/video/candidate/" .$name);
						$this->request->data['CandidateVideo']['video']=$name;
						
						if($this->request->data['CandidateVideo']['oldvideo'])
						{
							unlink("upload/video/candidate/".$this->request->data['CandidateVideo']['oldvideo']);
						}
					}else
					{
						$this->request->data['CandidateVideo']['video']=$this->request->data['CandidateVideo']['oldvideo'];
					}
					
					if($this->CandidateVideo->save($this->request->data))
					{
						$this->Session->write('popup','Video updated successfully.');
						$this->redirect(array('controller'=>'candidates','action' => "videoList"));
					}
					
			}
		}else
		{
			//$employervideo_list = $this->CandidateVideo->find('count',array('conditions'=>'CandidateVideo.candidate_id="'.$candidateID.'"','action'=>''));
			$candidateRec=$this->CandidateVideo->find('first',array('conditions'=>'CandidateVideo.id="'.$id.'" and CandidateVideo.candidate_id="'.$candidateID.'"','action'=>''));
			 
			$candidateRec['CandidateVideo']['oldvideo']=$candidateRec['CandidateVideo']['video'];
           	$this->request->data=$candidateRec;
		}
				
	}
	
	function Jobseeker_appliedHistory()  // list of applied job
	{
		$this->set('meta_title','Jobseeker Applied History');
		$this->isJobSeekerLogin();  // login check 
		$this->layout = 'front';
		$this->paginate = array(
					'conditions'=>'ApplyHistory.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"',
					'order'=>'ApplyHistory.track_id	 DESC',
					'recursive'=>-1,
					'paramType' => 'querystring',
					'limit'=>'10'
				);
		
		$applyHistory= $this->paginate('ApplyHistory');
		$this->set('applyHistory',$applyHistory);
	
	}
	
	function jobseeker_InterviewLists($ShowId = null,$candidateId = null , $empId = null, $status = null)		//================= Scheduled interview list===============
	{
	
		$this->isJobSeekerLogin();  // login check 
	
		$this->set('meta_title','Jobseeker Interview List');
		$this->paginate = array(
					'conditions'=>'ShowInterview.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'" ',
					'order'=>'ShowInterview.show_id DESC',
					'paramType' => 'querystring',
					'limit'=>'10'
				);
		$InterviewRec= $this->paginate('ShowInterview');
		$this->set('InterviewRec',$InterviewRec);
		
		
	
		if(!empty($ShowId) and !empty($candidateId) and !empty($empId) and $status=='ACCEPT')
		{
		
		
			$this->request->data['ShowInterview']['show_id']=$ShowId;
			$this->request->data['ShowInterview']['candidate_id']=$candidateId;
			$this->request->data['ShowInterview']['employer_id']=$empId;
			$this->request->data['ShowInterview']['status']=$status;
			$this->ShowInterview->set($this->request->data);
			
			
			$this->ShowInterview->query('update show_interviews set status="'.$status.'" where show_id="'.$ShowId.'" and  candidate_id="'.$candidateId.'" and  employer_id="'.$empId.'"');
			$this->Session->write('popup','Your accepation is successfully send to Employer');
			
			$this->redirect($this->referer());
			
		}
		
		if(!empty($ShowId) and !empty($candidateId) and !empty($empId) and $status=='DENIED')
		{
			$this->request->data['ShowInterview']['show_id']=$ShowId;
			$this->request->data['ShowInterview']['candidate_id']=$candidateId;
			$this->request->data['ShowInterview']['employer_id']=$empId;
			$this->request->data['ShowInterview']['status']=$status;
			$this->ShowInterview->set($this->request->data);
			
			$this->ShowInterview->query('update show_interviews set status="'.$status.'" where show_id="'.$ShowId.'" and  candidate_id="'.$candidateId.'" and  employer_id="'.$empId.'"');
			$this->Session->write('popup','Your denied is successfully send to Employer');
			$this->redirect($this->referer());
		}
		
		
		
		if(!empty($ShowId) and !empty($candidateId) and !empty($empId) and $status=='delete')
		{
		
			$this->ShowInterview->query('delete from show_interviews where show_id="'.$ShowId.'" and  candidate_id="'.$candidateId.'" and  employer_id="'.$empId.'"');
			$this->Session->write('popup','Record deleted successfully');
			$this->redirect($this->referer());
		
			
		}
		
	}
	
	/*** function for show job list for given skill***/
	function jobseeker_jobsbyskill($skillID=null){
		$queryString=explode('?',$_SERVER['REQUEST_URI']);
		$this->set('queryString',$queryString[count($queryString)-1]);
		
		$options['joins'] = array(
				array('table' => 'job_posting_skills',
						'alias' => 'JobPostingSkill',
						'type' => 'inner',
						'conditions' => array(
								'JobPosting.posting_id = JobPostingSkill.posting_id',
								'JobPostingSkill.skill_id' => $skillID
						)
				)
		);
		
		// edited 14122012 apurav day 180 to 365
		$skill_jobs_condition = "JobPosting.start_dt > DATE(NOW() - INTERVAL 365 DAY) and JobPosting.active=1";
		
		$options['conditions'] = array($skill_jobs_condition);
		$options['fields'] = array("distinct(JobPosting.posting_id)");
		
		$options['order'] = array("JobPosting.start_dt DESC");
		$this->JobPosting->recursive = -1;				
		$relatedjobs = $this->JobPosting->find('all', $options);	
		$relatedjobs_result = count($relatedjobs);
		
		$reslist="";
		$scrlist="";
		$loopcnt="1";
			
		foreach($relatedjobs as $jobs){
			$res	=	$jobs['JobPosting']['posting_id'];
			if($loopcnt!=1){
				$reslist	=	$reslist.",".$res;
			}else{
				$reslist	=	$reslist.$res;
			}
			$loopcnt	=	$loopcnt+1;
		}
			
		$this->JobPosting->recursive = 1;
		if($relatedjobs_result>0){
			$this->paginate = array(
					'conditions' => array('(JobPosting.posting_id IN ('.$reslist.'))'),
					'limit' => '10',
					'order' => array(
							'start_dt' => 'desc'
					)
			);
				
			$jobLists= $this->paginate('JobPosting');
			//pr($resumeLists);
			$countTotalRecords = $this->JobPosting->find('count',array('fields'=>'distinct(JobPosting.posting_id)','conditions'=>array('(JobPosting.posting_id IN ('.$reslist.'))')));
		}else{
			$countTotalRecords = $relatedjobs_result;
			$jobLists = array();
		}
		
		$this->set('jobLists', $jobLists);
		$this->set('totalJobs', $countTotalRecords);
	}
	
		// chnage password popup
	function jobseeker_changepassword()
	{
		$this->layout = false;
		
		if($this->request->is('post')){
		//	pr($this->Session->read('Auth.Client.User.id'));
		//	pr($this->request->data);die;
		$data = array('User' => array('id'=>$this->Session->read('Auth.Client.User.id'),'password'=>$this->request->data['password'],'old_password'=>$this->request->data['password']));
		$this->User->save($data, false, array('password','old_password'));
		$this->Session->write('popup','Your password updated successfully.');
		$this->Session->write('Auth.Clients.old_password',$this->request->data['password']);
		$this->redirect(array('controller'=>'candidates','action'=>'candidateprofile','Jobseeker'=>true));
		exit;
		}
		
	}
	
	function beforeFilter() 
	{ 
			parent::beforeFilter();
			
		$this->set('common',$this->common);
		$this->Auth->autoRedirect = false;
		
		$usertype=$this->Session->read('Auth.Clients.user_type');
		if($usertype=='C')
		{
			$this->Auth->allow('*');
		}else
		{
			$this->Auth->allow('register','index','thankyou','Jobseeker_searchJob','Jobseeker_employeDetail','Jobseeker_addSkill','addSkill','Jobseeker_showVideo','Jobseeker_jobDetail');
			$this->Auth->deny('Jobseeker_candidateprofile');
		}
	
		if($usertype=='E')
		{
			$this->Auth->loginRedirect =array('controller'=>'employers','action'=>'dashboard');
		}
		if($usertype=='C')
		{
			$this->Auth->loginRedirect = array('controller' => 'candidates', 'action' => 'candidateprofile','Jobseeker'=>true);
		}
		
	
		$this->Auth->fields = array(
            'username' => 'username',
            'password' => 'password'
        );
		
		
		
		$this->Auth->authenticate = array(
				'Form' => array('userModel' => 'User')                                
		);
		
		
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login','Jobseeker'=>false);
		$this->Auth->loginError = "Login failed. Invalid Email or Password.";
   	}
	
}
?>