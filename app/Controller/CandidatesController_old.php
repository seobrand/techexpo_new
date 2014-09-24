<?php 
/**************************************************************************
 Coder  : Pushkar Soni
 Object : Controller for login, logout and registration process of candidate
**************************************************************************/ 
class CandidatesController extends AppController {
 	//var $name = 'Users'; //Model name attached with this controller 
 	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some required helpers to this controller
 	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler','Captcha');  //add some required component to this controller .
	var $layout = 'front'; //this is the layout for front panel 
	var $currUser = 0;
	var $uses = array('Candidate','User','Code','Resume','ResumeSkill','ApplyHistory','JobPosting','ShowCompanyProfile','Employer','TrainingSchool','JobPostingSkill','Code','FolderContent','ShowInterview','Show','Registration','CandidateVideo');
	/* This function call by default when a controller is called */
	
	function index()
	{
	
	}
	
	function register()
	{
		$this->set('meta_title','Jobseeker Register');
		
		if($this->Session->read('Auth.Client.User.id')!=''){ 
		$this->redirect(array('controller'=>'users','action'=>'index'));
		}else
		{
			$this->set('statList',$this->common->getStateList()); //    find statelist
		
				if($this->request->data):
					$this->User->set($this->request->data);
					$this->Candidate->set($this->request->data);
					
					if(!$this->Candidate->RegisterValidate() && !$this->User->RegisterValidate()):
						
						$errorsArr = $this->User->validationErrors;	
						$errorsArr1 = $this->Candidate->validationErrors;	
					else:
						$this->request->data['User']['old_password']=$this->request->data['User']['password'];
						if($this->Candidate->saveAll($this->request->data)):
						
						//mail to candidate 
						$sendto = $this->request->data['Candidate']['candidate_email'];
						$sendfrom = 'nmathew@techexpoUSA.com';
						
						$subject = "Welcome to TechExpoUSA.com";
						$bodyText = "Dear #candidate_name#,<br>
						Thank you for joining our cutting-edge career center and home of TECHEXPO Hiring Events. The entire TECHEXPO team hopes that this site, as well as our events, help you advance your career and that you will enjoy its many features.<br>
        
Please note that becoming a site member and submitting your resume by themselves do not automatically register you for an event. You must then visit the registration center at ".FULL_BASE_URL.router::url('/',false)."/jobseeker_register to actually register.<br>
        
Please remember the username and password you created so you can later log into the site. Should you lose it, you can always go to ".FULL_BASE_URL.router::url('/',false)."/users/forgotpassword to have your login e-mailed to you from a secure SSL server. It will simply require you to enter the e-mail address you registered with.<br>

        
As TECHEXPO's web administrator, I would also like to personally welcome you to the site and extend to you what few other sites will do: the highest possible level of service. You can reply to this message or e-mail <a href='mailto:nmathew@TechExpoUSA.com'>nmathew@TechExpoUSA.com</a> with any questions or comments at any time. Any questions, comments, suggestions for improvements or bug reports are always welcome, a reply will usually be sent to you within 24 hours. Again, welcome and best of luck in your job search.<br>
        
Best Regards,<br><br>
        
Nancy Mathew<br>
Director of Events and Marketing<br>
212.655.4505 ext. 225 ";
						
						$email = new CakeEmail();
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
							
							
							
							$this->Session->write('UserName',$this->request->data['User']['username']);
							$this->redirect(array('controller'=>'resumes','action'=>'resume'));
						endif;
					endif;
				endif;
		}
	}
	
	
	function thankyou()
	{
			$this->set('meta_title','Jobseeker Thankyou');
	}
	
	function Jobseeker_updateDB()
	{
		
				$action 				= mysql_real_escape_string($_POST['action']); 
				$updateRecordsArray 	= $_POST['recordsArray'];
				
				$listingCounter = 1;
				if ($action == "updateRecordsListings"){
	
					$listingCounter = 1;
					foreach ($updateRecordsArray as $recordIDValue) {
						
						$query = $this->User->query("UPDATE records SET recordListingID = " . $listingCounter . " WHERE recordID = " . $recordIDValue);
					
					$listingCounter = $listingCounter + 1;		
					}
					
					echo 'sdf';die;
		}
	}	
	
	function Jobseeker_candidateprofile($id =null)
	{
		$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','Jobseeker Dashboard');
		$this->isJobSeekerLogin();  // login check 
		 
		
		$this->set('RecId',$this->User->query("SELECT * FROM records ORDER BY recordListingID ASC"));
		
		
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
			
			
			
			$videoRec=$this->Resume->query('select * from candidate_videos where set_dashboard="1" limit 1'); // video for dashboard
			$this->set('videoRec',$videoRec);
                        
			
			
			$this->Resume->unBindModel(array('hasMany' => array('ResumeSkill')));
			$resumeRec=$this->Resume->find('all',array('fields'=>'Resume.id,Resume.resume_title',
														'conditions'=>'Resume.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"'));
			
			$this->set('resumeRec',$resumeRec);
			
			// register event listig for dashboard
			$this->paginate = array('fields'=>'show.show_name,show.id,show.show_hours,show.show_hours,show.show_dt,show.location_id',
					'conditions'=>'Registration.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'" and show.show_dt>="'.date('y-m-d',time()).'"',
					'order'=>'Registration.id DESC',
					'paramType' => 'querystring',
					'limit'=>'3'
				);
			$showRec= $this->paginate('Registration');
			$this->set('showRec',$showRec);
			
			
	}
	
	
	
	#=================  Update Job Seeker Profile ===============
	function Jobseeker_editprofile()
	{
		$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','Jobseeker Edit Profile');
	//pr($this->Session->check('Auth.Client'));
	
		$this->set('mandatory','');
		$id=$this->Session->read('Auth.Client.User.candidate_id'); // jobseekerid
		$this->set('securityerror','');
		
		$this->set('statList',$this->common->getStateList());  //    find statelist
		$this->set('experienceArray',$this->common->getExperienceList());  // find experince array
		$this->set('citizenshipArray',$this->common->getCitizenShipList());  // find citizenship array
		$this->set('govenmentclearanceArray',$this->common->getGovCleareanceList());  // find Govenment Clearance array
		$this->set('noticeperidArray',$this->common->getnoticeperiodList());   // find Govenment Clearance array
		$this->set('industriesArray',$this->common->getIndustriesList());  // find Industries Type
		
		
		
		
	
		if($this->request->data):
		
		 if($this->request->data['Candidate']['SUBMIT']=='UPDATE'):	
			
				if(!$this->request->data['User']['password']):  // =========unset password and confirm password if blanck =====
					unset($this->request->data['User']['password']);
					
				endif;
				if(!$this->request->data['User']['cpassword']):  // =========unset onfirm password if blanck =====
					unset($this->request->data['User']['cpassword']);
				endif;
				
				$this->request->data['Candidate']['security_clearance_code']=implode(',',$this->request->data['Candidate']['security_clearance_code']);
				
				if($this->request->data['Candidate']['pref_industries'])
				{
				$this->request->data['Candidate']['pref_industries']=implode(',',$this->request->data['Candidate']['pref_industries']);
				}
				$this->request->data['Candidate']['pref_locations']=implode(',',$this->request->data['Candidate']['pref_locations']);
				
				
				
				
				$this->Candidate->set($this->request->data);  // check validation and save record	
				$this->User->set($this->request->data);
				
				$errorsArr=array();
				
			
				if(!$this->Candidate->editProfile() && !$this->User->editProfile()) 
				{
				  	$errorsArr = $this->Candidate->validationErrors;	
				
					$errorsArr = $this->User->validationErrors;
				
				}
					
					
			if(strtolower($this->Session->read('security_code'))!=strtolower($this->request->data['Candidate']['captcha'])) {
					$errorsArr['Candidate']['0']='Please Enter Correct Captcha';
					$this->set('mandatory','Please fill the all mandatory fields');
					$this->set('securityerror',$errorsArr['Candidate']['0']);
				}
			
				
			
		
				if(count(array_values($errorsArr))):
					
				
					$this->request->data['Candidate']['security_clearance_code']=explode(',',$this->request->data['Candidate']['security_clearance_code']);
					$this->request->data['Candidate']['pref_industries']=explode(',',$this->request->data['Candidate']['pref_industries']);
					$this->request->data['Candidate']['pref_locations']=explode(',',$this->request->data['Candidate']['pref_locations']);
					
				else:
				
					if($this->request->data['Candidate']['candidate_privacy']=='1'):
						$this->request->data['Candidate']['candidate_privacy']='Y';
					else:
						$this->request->data['Candidate']['candidate_privacy']='N';
					endif;
				
				
					if($this->Candidate->saveAll($this->request->data)):
							$this->Session->write('popup','Profile has been updated successfully update');			
							$this->redirect(array('controller'=>'candidates','action'=>'editprofile'));
					endif;
				endif;
			
		 endif;
				
		else:
			$condition='Candidate.id='.$id;
			$candidateREC=$this->Candidate->find('first',array('conditions'=>$condition));
			//pr($candidateREC);die;
			unset($candidateREC['User']['password']);
			
			$this->request->data=$candidateREC;	
			$this->request->data['Candidate']['security_clearance_code']=explode(',',$candidateREC['Candidate']['security_clearance_code']);
			$this->request->data['Candidate']['pref_industries']=explode(',',$candidateREC['Candidate']['pref_industries']);
			$this->request->data['Candidate']['pref_locations']=explode(',',$candidateREC['Candidate']['pref_locations']);
			
			if($candidateREC['Candidate']['candidate_privacy']=='Y'):
				$this->request->data['Candidate']['candidate_privacy']='1';
			else:
				$this->request->data['Candidate']['candidate_privacy']='0';
			endif;
				
			
		endif;
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
	
	
	
	function Jobseeker_jobDetail()   //=============== Job Detail===============
	{
		$this->isJobSeekerLogin();  // login check 
		$this->set('meta_title','JobDetail');
		
		$postingId=$this->params->query['jobId'];
		if($postingId):
		$conditions='';
		
		
				if(!empty($this->params->query['matching']))
					{
						$matchingType=$this->params->query['matching'];
						$this->request->data['JobPosting']['matching']=$matchingType;
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
									
									foreach($arrayKeyword as $key19 =>$value19)
									{	
										if($value19)
										{
										$keyword=$this->params->query['keyword'];
										$codeIds=$this->Code->find('all',array('fields'=>array('code_id'),'order'=>array('code_id'),'conditions'=>array('code_name'=>'Skills','visible'=>'Y','code_descr like "%'.$value19.'%"'),'order'=>array("sort_order ASC")));
										$totalSkills=count($codeIds);
										$stringSkills='';
										$i=1;
										foreach($codeIds as $key=>$value)
										{
											$stringSkills.=$value['Code']['code_id'];
											
											if($i!=$totalSkills)
											{
												$stringSkills.=',';
											}
											$i=$i+1;
										}
										
										
										if($stringSkills)
										{
											$postingIds=$this->JobPostingSkill->find('all',array('fields'=>'posting_id','conditions'=>'JobPostingSkill.skill_id in ('.$stringSkills.')'));
											$totalPostingIds=count($postingIds);
											$stringPostingIds='';
											$j=1;
											
										
											foreach($postingIds as $key=>$value)
											{
												
												$stringPostingIds.=$value['JobPostingSkill']['posting_id'];
												
												if($j!=$totalPostingIds)
												{
													$stringPostingIds.=',';
												}
												$j=$j+1;
											}
									
											
											
											if($stringPostingIds)
											{
												if(!empty($conditions))
												{
												$conditions.=' or ';
												}
												$conditions.=' JobPosting.posting_id in ('.$stringPostingIds.') ';
											}
										}	
										
										
										if(!empty($conditions))
										{
											$conditions.=' or ';
										}
										$conditions.= 'JobPosting.full_descr like "%'.$value19.'%"';
										}
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
				
									foreach($arrayKeyword as $Key12 =>$value12)
									{
										if($value12)
										{
										
									$codeIds=$this->Code->find('all',array('fields'=>array('code_id'),'order'=>array('code_id'),'conditions'=>array('code_name'=>'Skills','visible'=>'Y','code_descr like "%'.$value12.'%"'),'order'=>array("sort_order ASC")));
										$totalSkills=count($codeIds);
										$stringSkills='';
										$i=1;
										foreach($codeIds as $key=>$value)
										{
											$stringSkills.=$value['Code']['code_id'];
											
											if($i!=$totalSkills)
											{
												$stringSkills.=',';
											}
											$i=$i+1;
										}
										
										if($stringSkills)
										{
											$postingIds=$this->JobPostingSkill->find('all',array('fields'=>'posting_id','conditions'=>'JobPostingSkill.skill_id in ('.$stringSkills.')'));
											$totalPostingIds=count($postingIds);
											$stringPostingIds='';
											$j=1;
											
										
											foreach($postingIds as $key=>$value)
											{
												$stringPostingIds.=$value['JobPostingSkill']['posting_id'];
												
												if($j!=$totalPostingIds)
												{
													$stringPostingIds.=',';
												}
												$j=$j+1;
											}
									
											
											
											if($stringPostingIds)
											{
												if(!empty($conditions))
												{
													$conditions.=' and ';
												}
												$conditions.=' JobPosting.posting_id in ('.$stringPostingIds.') ';
											}
										}	
										}
										
										if(!empty($conditions))
										{
											$conditions.=' and ';
										}
										
										$conditions.= 'JobPosting.full_descr like "%'.$value12.'%"';
										
									}
								
							
									
										
										$this->request->data['Candidates']['keyword']=$this->params->query['keyword'];
									}
								break;
						
						case 'Exact':
									if(!empty($this->params->query['keyword']))
									{		
										
									$keyword=$this->params->query['keyword'];
										$codeIds=$this->Code->find('all',array('fields'=>array('code_id'),'order'=>array('code_id'),'conditions'=>array('code_name'=>'Skills','visible'=>'Y','code_descr like "%'.$keyword.'%"'),'order'=>array("sort_order ASC")));
										$totalSkills=count($codeIds);
										$stringSkills='';
										$i=1;
										foreach($codeIds as $key=>$value)
										{
											$stringSkills.=$value['Code']['code_id'];
											
											if($i!=$totalSkills)
											{
												$stringSkills.=',';
											}
											$i=$i+1;
										}
										
										if($stringSkills)
										{
											$postingIds=$this->JobPostingSkill->find('all',array('fields'=>'posting_id','conditions'=>'JobPostingSkill.skill_id in ('.$stringSkills.')'));
											$totalPostingIds=count($postingIds);
											$stringPostingIds='';
											$j=1;
											
										
											foreach($postingIds as $key=>$value)
											{
												$stringPostingIds.=$value['JobPostingSkill']['posting_id'];
												
												if($j!=$totalPostingIds)
												{
													$stringPostingIds.=',';
												}
												$j=$j+1;
											}
									
										
											
											if($stringPostingIds)
											{
												$conditions.=' JobPosting.posting_id in ('.$stringPostingIds.') ';
											}
									 }
										
									
										if(!empty($conditions))
										{
											$conditions.=' and ';
										}
										
										
											
										
										$conditions.= 'JobPosting.full_descr like "%'.$this->params->query['keyword'].'%"';
										$this->request->data['Candidates']['keyword']=$this->params->query['keyword'];
									}
									
								break;
								
						case 'default':
								break;
					}
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
						
						
				if(!empty($this->params->query['security_clearance_code']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								
								$securityClearances=$this->params->query['security_clearance_code'];
								count($securityClearances);
							//	echo explode(',',$this->params->query['security_clearance_code']);die;
								
								$totalSecurityClearance=count($securityClearances);
								$stringSecurityClearance='';
								$i=1;
								foreach($securityClearances as $key7=>$value7)
								{
									
									
									$conditions.= 'FIND_IN_SET("'.$value7.'",JobPosting.security_clearance_code)';
									
									if($i!=$totalSecurityClearance)
									{
										$conditions.=" and ";
									}
									$i=$i+1;
									
									//pr($this->params->query['security_clearance_code']);die;
									
									$this->request->data['JobPosting']['security_clearance_code'][$value7]=$value7;
								}
								// pr($this->request->data['JobPosting']);die;
								  $conditions;
						
							}
								
				if(!empty($this->params->query['employer_name']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
								}
								$conditions.='Employer.employer_name="'.$this->params->query['employer_name'].'"';
								
								$this->request->data['Employer']['employer_name'][$value7]=$this->params->query['employer_name'];
					}
					
				if(!empty($this->params->query['jobId']))
					{
							if(!empty($conditions))
							{
								$conditions.=' and ';
							}
							$conditions.='JobPosting.posting_id >"'.$this->params->query['jobId'].'"';
							
							
							
					}

	
		
			
			
		$nextJobRec=$this->JobPosting->find('first',array('fields'=>'JobPosting.posting_id','conditions'=>$conditions));
		$currentJobIds='jobId='.$this->params->query['jobId'];
		
		$queryString=explode('?',$_SERVER['REQUEST_URI']);
		$queryString=$queryString[count($queryString)-1];
		$queryString=str_replace($currentJobIds,'jobId='.$nextJobRec['JobPosting']['posting_id'],$queryString);
		$this->set('queryString',$queryString);
		
		
		
	
			$jobPostingDetail=$this->JobPosting->find('first',array('conditions'=>'JobPosting.posting_id="'.$postingId.'"'));
			$this->set('jobPostingDetail',$jobPostingDetail);
		endif;
		
		
		
		
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
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Employer Detail');
		
		$employeeId=$this->params->params['pass']['0'];
		$this->set('employerDetail',$this->Employer->find('first',array('conditions'=>array('Employer.id="'.$employeeId.'"'))));
	}
	
	function Jobseeker_higherEducationPlan()  // Employee Detail 
	{
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Higher Education');
		$this->set('trainingschools',$this->TrainingSchool->find('all',array('fields'=>'ts_profile,ts_logo_path,ts_web')));
	}
	
	function Jobseeker_searchJob()  // action for job searching.......
	{	
		$this->set('meta_title','Search Job');
		
			if($this->Session->read('Auth.Client.User.id')=='')
			{ 
				$this->Session->Write('Auth.Redirects',str_replace('&matching=','?matching=',$_SERVER['QUERY_STRING']));
				$this->redirect(array('controller'=>'users','action'=>'login','Jobseeker'=>false));
			}else
			{
				$queryString=explode('?',$_SERVER['REQUEST_URI']);
				$this->set('queryString',$queryString[count($queryString)-1]);
				
				
				$this->set('WorkTypeList',$this->common->getWorkTypeList());
				$this->set('WorkTimeList',$this->common->getWorkTimeList());
				$this->set('WorkLocationList',$this->common->getWorkLocationList());
				$this->set('GovCleareanceList',$this->common->getGovCleareanceList());
				$stringPostingIds='';
				$conditions='';
				
				if(count($this->params->query))
				{
					$matchingType=$this->params->query['matching'];
					$this->request->data['JobPosting']['matching']=$matchingType;
					
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
											
											$conditions.= 'JobPosting.full_descr like "%'.$KeywordValue.'%"';
											
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
										
										$conditions.= 'JobPosting.full_descr like "%'.$KeywordValue.'%"';	
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
									
									$conditions.= '( JobPosting.full_descr like "%'.implode(' ',$arrayKeyword).'%" or JobPosting.full_descr like "%'.trim($this->params->query['keyword']).'%" )';	
									
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
								
								
						if(!empty($this->params->query['security_clearance_code']))
							{
								
								//pr($this->params->query['security_clearance_code']);
										if(!empty($conditions))
										{
											$conditions.=' and (';
											
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
												//$conditions.= 'FIND_IN_SET("'.$value7.'",JobPosting.security_clearance_code)';
												
												if($i!=$totalSecurityClearance)
												{
													$conditions.=" or ";
												}else
												{
													$conditions.=" ) ";
												}
												$i=$i+1;
												
												//pr($this->params->query['security_clearance_code']);die;
												
												$this->request->data['JobPosting']['security_clearance_code'][$value7]=$value7;
											}
											// pr($this->request->data['JobPosting']);die;
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
										$conditions.='Employer.employer_name="'.$this->params->query['employer_name'].'"';
										
										$this->request->data['Employer']['employer_name']=$this->params->query['employer_name'];
							}
							
					if(!empty($this->params->query['employer_type_code']))
							{
										if(!empty($conditions))
										{
											$conditions.=' and ';
										}
										$conditions.='Employer.employer_type_code="'.$this->params->query['employer_type_code'].'"';
										
										$this->request->data['Employer']['employer_type_code']=$this->params->query['employer_type_code'];
							}
							
					$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
					if($conditions)
					{
						$conditions.=' and JobPosting.start_dt >"'.$targetdate.'"';
					}else
					{
						$conditions.=' JobPosting.start_dt >"'.$targetdate.'"';
					}
					
						
					if($conditions)
					{
						 $this->paginate = array(
							'limit' => 10,
							'conditions'=>$conditions,
							'paramType' => 'querystring'
						);
						$jobLists= $this->paginate('JobPosting');
						
						
						$totalJobs=$this->JobPosting->find('count',array('conditions'=>$conditions,'paramType' => 'querystring'));
						$this->set('totalJobs', $totalJobs);
						$this->set('jobLists', $jobLists);
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
			}	
	
	}
	
	function Jobseeker_autoMatching()  // action for job searching.......
	{
			$this->isJobSeekerLogin();  // login check 
			
			$this->set('meta_title','Job Match');
			$conditions='';
			$candidateId=$this->Session->read('Auth.Client.User.candidate_id');
			$securityClearances=$this->Session->read('Auth.Client.Candidate.security_clearance_code');
			
			
			
			APP::import('Model','Resume');  
			$this->Resume = new Resume(); 
			$this->Resume->unBindModel(array('belongsTo' => array('Candidate')));	
			$candidatResumeRec=$this->Resume->find("all",array('fields'=>'resume.id','conditions'=>'resume.candidate_id="'.$candidateId.'"'));
			$Candidateskills='';
			
			$i=1;
			$totalCandidatResumeRec=count($candidatResumeRec);
			
			foreach($candidatResumeRec as $recumeRec)  // matching condition for candidate id
			{
				if($Candidateskills)
				{
					if($j!=$totalCandidatResumeRec)
						{
							$Candidateskills.=',';
						}
				}
				
				
				$totalResumeSkill=count($recumeRec['ResumeSkill']);
				$j=1;
				foreach($recumeRec['ResumeSkill'] as $recumSkil)
				{
					if($recumSkil['skill_id'])
					{
						$Candidateskills.=$recumSkil['skill_id'];
						if($j!=$totalResumeSkill)
						{
							$Candidateskills.=',';
						}
					
					}
						
					$j=$j+1;
				}
				$i=$i+1;
			}
			
			if($Candidateskills)
			{
				APP::import('Model','JobPostingSkill');  
				$this->JobPostingSkill = new JobPostingSkill(); 
				$postingIds=$this->JobPostingSkill->find('all',array('fields'=>'posting_id',
																	'conditions'=>'JobPostingSkill.skill_id in ('.$Candidateskills.')'));
			
			
		
			$k=1;
			$PostinIdList='';
			$totalpostingIds=count($postingIds);
			foreach($postingIds as $value)
			{
				$PostinIdList.=$value['JobPostingSkill']['posting_id'];
				
				if($k!=$totalpostingIds)
				{
					$PostinIdList.=',';
				}
				$k=$k+1;
			}
			
			
			if($PostinIdList)
			{
				
				$conditions.=' JobPosting.posting_id in ('.$PostinIdList.') ';
				
			}
			}
	
			if(!empty($securityClearances))  // matching condition for security clearance
				{
					if(!empty($conditions))
					{
						$conditions.=' and ';
					}
					
					$securityClearances=explode(',',$securityClearances);
					
					$totalSecurityClearance=count($securityClearances);
					$stringSecurityClearance='';
					$i=1;
					foreach($securityClearances as $key7=>$value7)
					{
						$conditions.= 'FIND_IN_SET("'.$value7.'",JobPosting.security_clearance_code)';
						if($i!=$totalSecurityClearance)
						{
							$conditions.=" or ";
						}
						$i=$i+1;
					}
				}
				
				
				APP::import('Model','JobPosting');
				$this->JobPosting = new JobPosting(); 
				$this->JobPosting->unBindModel(array('hasMany' => array('JobPostingSkill')
													));		
				$this->paginate = array(
										'limit' => 10,
										'conditions'=>$conditions,
										'paramType' => 'querystring',
										'order' => 'JobPosting.posting_id ASC'
										);
				$jobLists= $this->paginate('JobPosting');						
				$this->set('jobLists',$jobLists);									
		
	}
	
	function Jobseeker_searchCompanies()
	{	
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Search Company');
		$this->set('empRecNonAlpha',array());
		$this->set('start','');
		if(empty($this->params->query['employer_name']))
		{	
			if(empty($this->params->query))
			{
				$this->params->query['start']='a,b,c';
			}
			/*
			if(empty($this->params->query['employer_name']))
			{
				$this->params->query['start']='a,b,c';
			}*/
		
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
					'paramType' => 'querystring'
				);
				$empRec= $this->paginate('Employer');
				$this->set($value,$empRec);
			}	
			
		}
		else
		{
			$this->set('empRecNonAlpha',array());
			$this->set('start',$this->params->query['employer_name']);
			
			
			$this->paginate = array(
					'conditions'=>'Employer.employer_name like"%'.$this->params->query['employer_name'].'%"',
					'paramType' => 'querystring'
				);
				$empRec= $this->paginate('Employer');
			
			
			$this->set('companyList',$empRec);
			$this->request->data['Candidates']['employer_name']=$this->params->query['employer_name'];
			
			
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
			
				$ResumeTitle=$this->Resume->find('first',array('fields'=>'resume_title', 
															   'conditions'=>'Resume.id="'.$this->request->data['ApplyHistory']['resume_id'].'"')); //# RESUME TITLE
				
				#==== jobdetail for which user apply
				$jobDetail=$this->JobPosting->find('first',array('fields'=>'JobPosting.posting_id,JobPosting.job_title,Employer.id,Employer.employer_name',
																'conditions'=>'JobPosting.posting_id="'.$this->params->query['jobId'].'"'));
				
				$this->request->data['ApplyHistory']['candidate_id']=$this->Session->read('Auth.Client.User.candidate_id');
				$this->request->data['ApplyHistory']['resume_title']=$ResumeTitle['Resume']['resume_title'];
				$this->request->data['ApplyHistory']['posting_id']=$jobDetail['JobPosting']['posting_id'];
				$this->request->data['ApplyHistory']['job_title']=$jobDetail['JobPosting']['job_title'];
				$this->request->data['ApplyHistory']['employer_id']=$jobDetail['Employer']['id'];
				$this->request->data['ApplyHistory']['employer_name']=$jobDetail['Employer']['employer_name'];
				$this->request->data['ApplyHistory']['dt']=date('Y-m-d',time());
				
				
				
				$checkApplyExists=$this->ApplyHistory->find('count',array(	
																'conditions'=>'ApplyHistory.posting_id="'.$this->request->data['ApplyHistory']['posting_id'].'" and
																				ApplyHistory.resume_id="'.$this->request->data['ApplyHistory']['resume_id'].'" and
																			ApplyHistory.candidate_id="'.$this->request->data['ApplyHistory']['candidate_id'].'"',
																'order' => array('ApplyHistory.id DESC')
																		)
															 );
				
			
				if($checkApplyExists)
				{
				
					$this->set('Error','Already apply for this job');
					
				}else
				{
					if($this->ApplyHistory->save($this->request->data)):
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
					$jobUrl					=	FULL_BASE_URL.router::url('/',false)."/employers/jobdetail/".$postingID;
						
						// Email configuration
						$sendto = $this->request->data['Candidate']['candidate_friend_email'];
						$sendfrom = $this->request->data['Candidate']['candidate_email'];
						$emailMessage = $this->request->data['Candidate']['message'];
						
						$subject = "A friend is forwarding you a job on techexpoUSA.com";
						$bodyText = "This job was forwarded to you by someone you know. It was posted on TechExpoUSA.com, the career center of choice for all technology professionals. To view the details of this job, go to<br/>".$jobUrl."<br/><br/>*************************************************************************************<br/><br/>Your friend or relative's e-mail address:  ".$sendfrom."<br/><br/>Your friend or relative's message (optional): ".nl2br($emailMessage)."<br/><br/>Job Title: ".$jobTitle."<br/>Employer: ".$jobEmployer."<br/>Salary (not always indicated): ".$jobSalary."<br/>Location: ".$jobLocationCity.", ".$jobLocationState."<br/>Short Description: ".$jobShortDesc." ";
						
						//echo $bodyText;die;
						
						$email = new CakeEmail();
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
						
						if($ok){
							$this->Session->write('popup','Your job email to a friend has been sent successfully.');
							$this->redirect(array('controller'=>'candidates','action' => "sendEmailToFriend?jobId=".$postingID));
						}
				
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
			$eventInfo = $this->Show->find("first",array('conditions'=>array($condition)));
			$this->set('regEventInfo',$eventInfo);
			// get the list of other employers who are also registered with this event
			$options['joins'] = array(
				array('table' => 'show_employers',
					'alias' => 'ShowEmployer',
					'type' => 'inner',
					'conditions' => array(
						'ShowEmployer.employer_id = Employer.id',
						'ShowEmployer.payment_status' => 'y',
						'ShowEmployer.show_id = '.$showID						
					)
				)
			);
			
			$this->Employer->recursive = 1;
			$otherRegEmployer = $this->Employer->find('all', $options);
			
			$this->set('otherRegEmployer',$otherRegEmployer);
		}
	}
	
	public function Jobseeker_upcomingEvent($showID = null)
	{
			$this->isJobSeekerLogin();  // login check 
			
			$this->paginate = array('limit' => 10,
										'conditions'=>array('show_dt>="'.date('y-m-d',time()).'"'),
										'paramType' => 'querystring',
										'order'=>'Show.id desc'
										);
			$showRec= $this->paginate('Show');
			$this->set('showRec',$showRec); 	
			
			//pr($showRec);
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
						$this->Session->write('popup','New profile image uploaded successfully.');
						$this->redirect(array('controller'=>'candidates','action'=>'profileImage'));
					}
					 
				}
			}
		}	
	}
	
	/*************************Video list and upload section****************************/
	public function Jobseeker_videoList($action = null,$id = null)
	{
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('meta_title','Video List');
		$candidateID = $this->Session->read('Auth.Client.User.candidate_id');
		
		$candidatevideo_list =  $this->CandidateVideo->find('all',array('conditions'=>array('CandidateVideo.candidate_id'=>$candidateID),'limit'=>'5'));
		$this->set('candidatevideo_list',$candidatevideo_list);
		
		if($this->request->data)
		{
			
			
			
			if($this->request->data['Candidate']['video_type']=='youtube')
			{
			$this->request->data['CandidateVideo']=$this->request->data['Candidate'];	
			$this->request->data['CandidateVideo']['candidate_id']= $candidateID;
			$this->CandidateVideo->save($this->request->data); 	
			$this->Session->write('popup','Video uploaded successfully.');
			$this->redirect(array('controller'=>'candidates','action' => "videoList"));
			}
			else if($this->request->data['Candidate']['video_type']=='upload')
			{	
					$name = time().'_'.$this->data['Candidate']['video']['name']; // move file
					move_uploaded_file( $this->data['Candidate']['video']['tmp_name'], "upload/video/candidate/" .$name);
					//pr(move_uploaded_file( $this->data['Candidate']['video']['tmp_name'], "upload/video/candidate/" .$name));die;
					$this->request->data['Candidate']['video']=$name;
				
					
					
					$this->request->data['CandidateVideo']=$this->request->data['Candidate'];	
					$this->request->data['CandidateVideo']['candidate_id']= $candidateID;
					if($this->CandidateVideo->save($this->request->data))
					{
						$this->Session->write('popup','Video uploaded successfully.');
						$this->redirect(array('controller'=>'candidates','action' => "videoList"));
					}
					 
				
			
			}
			
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
		$this->isJobSeekerLogin();  // login check 
		$this->layout = false;
		$video_dt = $this->CandidateVideo->find('first',array('conditions'=>array('CandidateVideo.id'=>$id)));
		$this->set('video_dt',$video_dt);
	}
	
	public function Jobseeker_editVideo($id = null  )
	{
		$this->isJobSeekerLogin();  // login check  
		
		$candidateID = $this->Session->read('Auth.Client.User.candidate_id');
		$video_detail = $this->CandidateVideo->find('first',array('conditions'=>'CandidateVideo.id="'.$id.'" and CandidateVideo.candidate_id="'.$candidateID.'"','action'=>''));
		$this->set('video_detail',$video_detail);
		
		if($this->request->data)
		{	
			if(count($employervideo_list)>4)
			{
				$this->Session->write('popup','You can\'t upload more then 5 video .');
				$this->redirect(array('controller'=>'candidate','action' => "videoList"));
			}
			
			if($video_detail['CandidateVideo']['video_type']=='youtube')
			{
			$this->request->data['CandidateVideo']['description'] = $this->request->data['Candidate']['description'];
			$this->request->data['CandidateVideo']['video'] = $this->request->data['Candidate']['video'];
			$this->request->data['CandidateVideo']['id']= $id;
			$this->EmployerVideo->save($this->request->data); 	
			$this->Session->write('popup','Video Edited successfully.');
			$this->redirect(array('controller'=>'candidates','action' => "editVideo"));
			}
			else if($video_detail['CandidateVideo']['video_type']=='upload')
			{	
					$name = time().'_'.$this->data['Candidate']['video']['name']; // move file
					move_uploaded_file( $this->data['Candidate']['video']['tmp_name'], "upload/video/candidate/" .$name);
					$this->request->data['Candidate']['video']=$name;
					//echo $this->request->data['Employer']['logo_file'];die;
					
									
					$candidateVid=$this->CandidateVideo->find('first',array('fields'=>'video',
																		'conditions'=>'CandidateVideo.id="'.$id.'"'));
					if($candidateVid['CandidateVideo']['video'])
					{
						unlink("upload/video/candidate/".$candidateVid['CandidateVideo']['video']);
					}
					
					
					$this->request->data['CandidateVideo']['description'] = $this->request->data['Candidate']['description'];
					$this->request->data['CandidateVideo']['video'] = $this->request->data['Candidate']['video'];
					$this->request->data['CandidateVideo']['id']= $id;
			
					if($this->CandidateVideo->save($this->request->data))
					{
						$this->Session->write('popup','Video updated successfully.');
						$this->redirect(array('controller'=>'candidates','action' => "videoList"));
					}
					 
				
			
			}
			
		}
				
	}
	
	function beforeFilter() 
	{ 
		$this->set('common',$this->common);
		
		$usertype=$this->Session->read('Auth.Clients.user_type');
		if($usertype=='C')
		{
			$this->Auth->allow('*');
		}else
		{
			$this->Auth->allow('register','index','thankyou','Jobseeker_searchJob');
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