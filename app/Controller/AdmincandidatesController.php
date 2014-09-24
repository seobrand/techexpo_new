<?php 
/**************************************************************************
 Coder  : Pushkar
 Object : Controller to handle admin candidate information
**************************************************************************/ 
class AdmincandidatesController extends AppController {
	var $name = 'Admincandidates'; 
	var $helpers = array('Paginator'); //add some other helpers to controller
	public $components = array('Auth','common','Session','Cookie','Email');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	var $uses = array('Candidate','User','Code','Resume','ResumeSkill','ApplyHistory','JobPosting','ShowCompanyProfile','Employer','TrainingSchool','JobPostingSkill','Code','FolderContent','ShowInterview','Show','Registration','CandidateEmailMessage','EMAILPREF','CandidateVideo','JobEmailHistory');
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

	 function superadmin_candidateInfo($id=NULL,$delete=NULL) 
	 {

	 	$this->set('meta_title','Search Candidate');	
		$this->set('searcTextError','');
		$this->set('SearchResult','');
		$CandidateREC=array();
	 	
		
		
		
		if(!empty($id) and $delete=='delete')   // delete candidate rec
		{
				$recRec=$this->Resume->find('all',array('conditions'=>'Resume.candidate_id="'.$id.'"'));  // delete Resume skill
				foreach($recRec as $value)
				{
					if($value['Resume']['id'])
					{
					$this->ResumeSkill->deleteAll(array('ResumeSkill.resume_id="'.$value['Resume']['id'].'"'), false); 
					}		
				}
				$this->Candidate->deleteAll(array('Candidate.id="'.$id.'"'), false);  // delete candidate
				$this->User->deleteAll(array('User.candidate_id="'.$id.'"'), false);  // delete User
				$this->Resume->deleteAll(array('Resume.candidate_id="'.$id.'"'), false);  // delete Resume
				
				$this->Session->write('popup','Job Seeker Profile has been deleted successfully.');			
				$this->Session->setFlash('Job Seeker Profile has been deleted successfully.');  
								
				$url=str_replace('/message:success','/',$this->referer());
				$url=explode('?',$url);
				$url['0']=$url['0'].'/message:success';
				$rediect=implode('?',$url);
				$this->redirect($rediect);
		}
		
		
		if(!empty($id) and $delete=='LoginInfo')   // delete candidate rec
		{
		
				$this->Candidate->unBindModel(array('hasMany' => array('Resume')));	
				$candidateRec=$this->Candidate->find('first',array('fields'=>'Candidate.candidate_email,Candidate.candidate_name,User.username,User.old_password',
																	'conditions'=>'Candidate.id="'.$id.'"'));  // delete Resume skill
				
				
										
						// Email configuration
						$sendto = (array) $candidateRec['Candidate']['candidate_email'];
						$sendfrom = 'nmathew@techexpousa.com';
						
						$subject = "TECHEXPO Top Secret online account information";
						$bodyText = "<table>
									<tr>
										<td>
											Dear<strong> ".$candidateRec['Candidate']['candidate_name']."</strong>,
										</td>
									</tr>
									<tr>
										<td>
                                        	You have recently requested your TECHEXPO username and password. Please see your account information provided below:<br>
											<br/>
										</td>
									</tr>
									<tr>
										<td>
											You can log in at <a href='http://www.TechExpoUSA.com'>TechExpoUSA</a>:<br>
											Username: ".$candidateRec['User']['username']."<br>
											Password: ".$candidateRec['User']['old_password']."<br><br>
										</td>
									</tr>
									<tr>
										<td>
										
                                        If you have any questions or need technical assistance, email <a href='mailto:mweiser@techexpousa.com'>mweiser@techexpousa.com</a>
                                        <br>
                                        or call Michelle Weiser at 212.655.4505 ext. 224.<br>  
                                        If you are not <strong>".$candidateRec['Candidate']['candidate_name']."</strong> , please disregard and delete this email immediately.
										<br><br>
										</td>
									</tr>
									<tr>
										<td>
                                        Sincerely,<br>
										Michelle Weiser<br>
										Marketing Coordinator<br>
										212.655.4505 ext. 224<br>
										</td>
									</tr>
									</table>";
						
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
						
						
							$this->Session->setFlash('Login information was e-mailed to '.$candidateRec['Candidate']['candidate_name'].' at '.$candidateRec['Candidate']['candidate_email'].'.<br>You may close this msg.');  
						
				
						$this->Session->write('popup','Login detail has been sent  successfully.');			
						$this->Session->setFlash('Login detail has been sent  successfully');  
										
						$url=str_replace('/message:success','/',$this->referer());
						$url=explode('?',$url);
						$url['0']=$url['0'].'/message:success';
						$rediect=implode('?',$url);
						$this->redirect($rediect);
					
		}
		
		
		if(!empty($this->params->query))  // search
		{	
		
			if($this->params->query['SUBMIT']=='UPDATE')
			{
				$search=$this->params->query['search'];
				$searchingText=$this->params->query['candidate_title'];
				$this->params->query['candidate_title']=$this->params->query['candidate_title'];
				
				$this->Candidate->set($this->request->data);
				$errorsArr=array();
				
			
				if(empty($searchingText)) 
				{
				  $this->set('searcTextError','Please Enter search criterion');
				}
				else
				{
						$conditions='';
						switch($search)
						{
							case 'candidate_name':
											$conditions='Candidate.candidate_name like "%'.$searchingText.'%"';
											break;
							
							case 'candidate_email':
											$conditions='Candidate.candidate_email like "%'.$searchingText.'%"';
											break;	
							case 'username'	:
											$conditions='User.username like"%'.$searchingText.'%"';
											break;				
							default:
								break;
						}
						
						if($conditions)
						{
						
							$this->Candidate->unBindModel(array('hasMany' => array('Resume')));	
							
							$this->paginate = array('fields'=>'Candidate.id,Candidate.candidate_phone,Candidate.candidate_phone
																,Candidate.candidate_name,candidate_email,User.username,User.old_password,
																User.id',
							'conditions'=>$conditions,
							'order'=>'Candidate.id DESC',
							'paramType' => 'querystring',
							'limit'=>'5'
						);
						$CandidateREC= $this->paginate('Candidate');
						
						
				
						}
							
					$this->set('SearchResult','SearchResult');
					$this->request->data['Admincandidates']['candidate_title']=$searchingText;
					$this->request->data['Admincandidates']['search']=$search;
				}
				$this->set('CandidateREC',$CandidateREC);
			}
		}	
	 }
	 
	  function superadmin_candidateDetail($candidateId=NULL) 
	 {

	 	$this->set('meta_title','Candidate Information');	
		
		
		$CandidateExits=$this->common->isCandidateExits($candidateId);
		$this->set('CandidateExits',$CandidateExits);
		if($CandidateExits)  // search
		{	
					$this->Candidate->unBindModel(array('hasMany' => array('Resume')));	
					$CandidateREC= $this->Candidate->find('first',array('fields'=>'Candidate.id,Candidate.candidate_phone,Candidate.candidate_phone
																,Candidate.candidate_name,candidate_email,User.username,User.old_password,
																User.id',
														'conditions'=>'Candidate.id="'.$candidateId.'"'
														));
					$this->set('CandidateREC',$CandidateREC);
		}else
		{
		
							$this->Candidate->unBindModel(array('hasMany' => array('Resume')));	
							$this->paginate = array('fields'=>'Candidate.id,Candidate.candidate_phone,Candidate.candidate_phone
																,Candidate.candidate_name,candidate_email,User.username,User.old_password,
																User.id',
																'order'=>'Candidate.id DESC',
																'paramType' => 'querystring',
																'limit'=>'10'
												);
							$CandidateREC= $this->paginate('Candidate');
							
							$this->set('CandidateREC',$CandidateREC);
						
				
					
		}	
	 }
	 
	 #=================  Update Job Seeker Profile ===============
	function superadmin_updateCandidateInfo($SeekerId=NULL)
	{
		$this->set('mandatory','');
		$id=$SeekerId; // jobseekerid
		$this->set('SeekerId',$SeekerId);
		$this->set('securityerror','');
		
		
		$this->set('statList',$this->common->getStateList());  //    find statelist
		
		$this->set('experienceArray',$this->common->getExperienceList()); // find experince array
		$this->set('citizenshipArray',$this->common->getCitizenShipList()); // find citizenship array
		$this->set('govenmentclearanceArray',$this->common->getGovCleareanceList()); // find Govenment Clearance array
		$this->set('noticeperidArray',$this->common->getnoticeperiodList()); // find Govenment Clearance array
		$this->set('industriesArray',$this->common->getIndustriesList()); // find Industries Type
		
		
		if($this->request->data):
		
		 if($this->request->data['Candidate']['SUBMIT']=='UPDATE'):	
			
				if(!$this->request->data['User']['password']):  // =========unset password and confirm password if blanck =====
					unset($this->request->data['User']['password']);
				endif;
				if(!$this->request->data['User']['cpassword']):  // =========unset onfirm password if blanck =====
					unset($this->request->data['User']['cpassword']);
				endif;
				
				
				if($this->request->data['Candidate']['security_clearance_code'])
				{
				$this->request->data['Candidate']['security_clearance_code']=implode(',',$this->request->data['Candidate']['security_clearance_code']);
				}
				if($this->request->data['Candidate']['pref_industries'])
				{
				$this->request->data['Candidate']['pref_industries']=implode(',',$this->request->data['Candidate']['pref_industries']);
				}
				if($this->request->data['Candidate']['pref_locations'])
				{
				$this->request->data['Candidate']['pref_locations']=implode(',',$this->request->data['Candidate']['pref_locations']);
				}
				
				
				
				$this->Candidate->set($this->request->data);  // check validation and save record	
				$this->User->set($this->request->data);
				
				$errorsArr=array();
				
			
				if(!$this->Candidate->editProfile() && !$this->User->editProfile()) 
				{
				  	$errorsArr = $this->Candidate->validationErrors;	
					$errorsArr = $this->User->validationErrors;
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
					
					if(isset($this->request->data['User']['password'])  &&  !empty($this->request->data['User']['password'])):
					$this->request->data['User']['old_password']=$this->request->data['User']['password'];
					endif;
					
				
				
					if($this->Candidate->saveAll($this->request->data)):
					
							$this->Session->write('popup','Profile has been updated successfully update');			
							$this->Session->setFlash('Job Seeker Profile has been updated successfully.');  
							$this->redirect(array('controller'=>'admincandidates','action'=>'updateCandidateInfo/message:success',$id));
							
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
	
	function superadmin_unregisterCandidate()  // function to register unregister candidates using csv upload
	{	
	
		$showList=$this->Show->find('list',array('fields'=>array('id','show_name'),'order'=>array('id'),'conditions'=>array('show_dt<"'.date('y-m-d',time()).'"')));
		
		$this->set('showList',$showList); // get shows lists
		$this->set('errorFile','');
		$errorsArr=array();
		if($this->request->data)
		{
			if($this->request->data['Candidate']['SUBMIT']=='uploadCSV')
			{
				$this->Registration->set($this->request->data);
				$this->Candidate->set($this->request->data);
				
				if(!$this->Registration->checkParerlessCandidate())  // validation check for form
				{
					$errorsArr = $this->Registration->validationErrors;	
				}
				if(empty($this->request->data['Candidate']['File']['name']))
				{
					$this->set('errorFile','please upload csv  file');
					$errorsArr['File'][0]='please upload csv file';
				}
				else
				{
					
				$extension=end(explode('.',$this->request->data['Candidate']['File']['name']));
					if($extension!='csv')
					{
						$errorsArr['File'][0]='please upload only csv file';
						$this->set('errorFile','please upload only csv  file');
					}
				}           										 //end  validation checking for form
				
			
				if(count($errorsArr)):
						
				else:
					
					if ($this->request->data['Candidate']['File']['size'] > 0) 
					{
								//get the csv file
								$file = $this->request->data['Candidate']['File']['tmp_name'];
								$handle = fopen($file,"r");
								//loop through the csv file and insert into database
    							while ($data = fgetcsv($handle,1000000,",","'"))
								{
									if ($data[0]) 
									{
										if($this->common->checkJobSeekerEmail($data[1]))  // check for email exists
										{
											$this->request->data['Candidate']['candidate_name']=$data[1];   // create new candidate
											$this->request->data['Candidate']['candidate_title']='register for event';
											$this->request->data['Candidate']['candidate_email']=$data[1];
											$this->request->data['User']['status_code']='PROF';
											$this->request->data['User']['username']=$data[1];
											$this->request->data['User']['password']=$data[1];
											$this->request->data['User']['user_type']='C';
											$this->request->data['User']['old_password']=$data[1];
											
											if($this->Candidate->saveAll($this->request->data)):  // save record for new candidate
												$lastCandidateId=$this->Candidate->getLastInsertId();
												
												$this->request->data['Resume']['candidate_id']=$lastCandidateId;  // create resume for this user
												$this->request->data['Resume']['resume_title']='Please Upload resume';
												$this->request->data['Resume']['posted_dt']=date('Y-m-d h:m:s',time());
												$this->Resume->save($this->request->data);     // save new resume for user
												
												$this->request->data['Registration']['candidate_id']=$lastCandidateId;  // register for event
												$this->request->data['Registration']['show_id']=$this->request->data['Registration']['show_id'];
												$this->request->data['Registration']['date_time']=date('Y-m-s',time());
												$this->request->data['Registration']['vip']=$data[2];
												$this->Registration->save($this->request->data);     // save new resume for user
												
											endif;
											
											
										}else
										{  // else emmail id found in database then update the resume of this resume for this email address
											
											$candidateRec = $this->Candidate->find("first",array('fields'=>'Candidate.id',
																							'conditions'=>array('Candidate.candidate_email' =>$data[1])));
										
											foreach($candidateRec['Resume'] as $value)
											{
												//pr($value['id']);die;
												$this->request->data['Resume']['id']=$value['id'];
												$this->request->data['Resume']['posted_dt']=date('Y-m-d',time());
												$this->Resume->save($this->request->data);
											}
										}
									}
								}
								
								
								$this->Session->write('popup','CSV file successfully uploaded.');
								$this->Session->setFlash('CSV file successfully uploaded.');  
								$this->redirect(array('controller'=>'admincandidates','action'=>'unregisterCandidate/message:success'));
					}
				endif;
			}
		}
	}
	
	function superadmin_registerCandidateMassEmail()  // function to mail all register candidate
	{
		$this->set('showList',$this->common->getShowList()); // get shows lists
		
	}
	
	function superadmin_registerCandidateMassEmail2()  // function to mail all register candidate
	{
		$this->set('showList',$this->common->getShowList()); // get shows lists
		
		if($this->request->data['Registration']['SUBMIT']=='Email')
			{
			
				$showDetail=$this->Show->find('first',array(  
																	'conditions'=>array('show_dt> "05/01/2005" and 
																	Show.id="'.$this->request->data['Registration']['show_id'].'"'),
																	'order'=>'show_dt desc'));  
										
				$this->set('showDetail',$showDetail);
			}
			
			
			
			if($this->request->data['Registration']['SUBMIT']=='Email2')
			{
			
			
				$showDetail=$this->Show->find('first',array('order'=>array('id'),   // get shows lists
																	'conditions'=>array('show_dt> "05/01/2005" and 
																	Show.id="'.$this->request->data['Registration']['show_id'].'"'),
																	'order'=>'show_dt desc'));  
					
				$this->set('showDetail',$showDetail);
				
				
				$RecRegCand=$this->Registration->find('all',array('fields'=>'show.id,show.show_dt,show.show_name,show.show_hours,show.location_id	,Registration.id,Candidate.id,Candidate.candidate_email,Candidate.candidate_name,
					Candidate.candidate_name',
									'conditions'=>'Registration.show_id="'.$this->request->data['Registration']['show_id'].'"')); // register candidate email id
					
					
		
					foreach($RecRegCand as $value)
					{
								if($this->common->checkPreRegisterUser($value['Candidate']['id']))  // check user is preregisterd or not
								{
										
									// Email configuration
									$sendto =strip_tags(trim($value['Candidate']['candidate_email']));
									$sendfrom =trim('nmathew@techexpousa.com');
									$subject = $this->request->data['Registration']['subject'];
							 	$bodyText = "<table>
											<tr>
												<td>
													************************************************************************<br>
													<br>
													If you wish to unsubscribe, please click on the link below.:<br>
													".FULL_BASE_URL.router::url('/',false)."   (your login will be required to unsubscribe)
													<br><br>
													************************************************************************<br><br>
													
													Dear  ".$value['Candidate']['candidate_name'].",
												</td>
											</tr>
											<tr>
												<td>
													".$this->request->data['Registration']['message']."
												</td>
											</tr>
											<tr>
												<td>
												You can now access your account by entering your log in information at ".FULL_BASE_URL.router::url('/',false)." <br>
												<br>
			
												Sincerely,<br>
												Nancy Mathew<br>
												Events Coordinator<br>
												212.655.4505 ext. 225<br>
												276 Fifth Avenue, Suite 303<br>
												New York, NY 10001<br>
					
												</td>
											</tr>
											</table>";
								
								$email = new CakeEmail('smtp');
								$email->from(array($sendfrom));
								$email->to($sendto);
								$email->emailFormat('html');
								$email->subject(strip_tags($subject));
								$ok = $email->send($bodyText);
						}
					}
					
					$this->Session->write('popup','E-mail has been send successfully.');
					$this->Session->setFlash('E-mail has been send successfully.'); 
					
					/*$url=str_replace('/message:success','/',$this->referer());
					$url=explode('?',$url);
					$url['0']=$url['0'].'/message:success';
					$rediect=implode('?',$url);
					$this->redirect($rediect);*/
					
					$this->redirect(array('controller'=>'admincandidates','action'=>'registerCandidateMassEmail/message:success'));
				
			}
			
			
	
	}
	
		  
	function superadmin_invitationToCandidate()  // function to send invation
	{
		
		$showList=$this->Show->find('list',array('fields'=>array('id','showsNameDate'),'order'=>array('id'),   // get shows lists
															'conditions'=>array('show_dt> "05/01/2005"'),
															'order'=>'show_dt desc'));  
		$this->set('showList',$showList); 
		$this->set('stateList',$this->common->getStateList()); // get shows lists
		$this->set('previousShowList',$this->common->getPreiousShowList()); // get shows lists
	
		/*if($this->request->data)  
		{
			if($this->request->data['Registration']['SUBMIT']=='Email')
			{
				
		$this->set('showList',$this->common->getShowList()); // get shows lists
		
		if($this->request->data)  
		{
			if($this->request->data['Registration']['SUBMIT']=='Email')
			{
				$this->Registration->set($this->request->data);
				if(!$this->Registration->checkParerlessCandidate())  // validation check for form
				{
					//
				}else
				{
				$conditions='';
				
					//pref_locations
					$i=1;
					$totalstate='';
					$stateArry=array();
				
					
					$totalstate=count($this->request->data['Registration']['state_id']);
				
					if(!empty($this->request->data['Registration']['state_id']))
					{
						$stateArry=$this->request->data['Registration']['state_id'];
						foreach($stateArry as $key=>$value)
						{
							$conditions.=" or ";
							$conditions.= 'FIND_IN_SET("'.$value.'",Candidate.pref_locations)';
							$i=$i+1;
						}
					}
					
					$totalshows=count($this->request->data['Registration']['showid']);
					if(!empty($this->request->data['Registration']['showid'])) // condition for non register (who is register using admin)
					{
						$showid=$this->request->data['Registration']['showid'];
						$CandidateList=$this->Resume->query('select candidate_id  from resumes as Resume where source_code in ('.implode(',',$showid).')');
						$totalCandidate=count($CandidateList);
						$string='';
						$i=1;
						foreach($CandidateList as $value)
						{
						
							$string.=$value['Resume']['candidate_id'];
							if($totalCandidate!=$i)
							{
								$string.=',';
							}
							$i=$i+1;
						}
						if($string)
						{
						$conditions.=" or Candidate.id in(".$string.")";
						}
					
					}
				
					if($this->request->data['Registration']['security_clearance_code']=='n') // check for security clearance is require or not
					{
					$RecRegCand=$this->Registration->find('all',array('fields'=>'show.id,show.show_dt,show.show_name,show.show_hours,show.location_id		
															,Registration.id,Candidate.id,Candidate.candidate_email,Candidate.candidate_name,
															Candidate.pref_locations,Candidate.candidate_name',
									'conditions'=>'Registration.show_id="'.$this->request->data['Registration']['show_id'].'" '.$conditions.'')); // register candidate email id
				
					}
					else
					{
						$RecRegCand=$this->Registration->find('all',array('fields'=>'show.id,show.show_dt,show.show_name,show.show_hours,show.location_id	
															,Registration.id,Candidate.id,Candidate.candidate_email,Candidate.candidate_name,Candidate.pref_locations,
															Candidate.candidate_name',
									'conditions'=>'Registration.show_id="'.$this->request->data['Registration']['show_id'].'" and Candidate.security_clearance_code != "38" and Candidate.security_clearance_code != "3650" and Candidate.security_clearance_code not like "%38%" and Candidate.security_clearance_code not like "%3650%"'.$conditions.'
									')); // register candidate email id
					}				
				
					
					foreach($RecRegCand as $value)
					{
								if($this->common->checkPreRegisterUser($value['Candidate']['id']))  // check user is preregisterd or not
								{
										
									// Email configuration
									$sendto =strip_tags(trim($value['Candidate']['candidate_email']));
									$sendfrom =trim('nmathew@techexpousa.com');
									$subject = "TECHEXPO Top Secret online account information";
									$bodyText = "<table>
											<tr>
												<td>
													Dear ".$value['Candidate']['candidate_name'].",
												</td>
											</tr>
											<tr>
												<td>
													Thank you for pre-registering for our ".$value['show']['show_name']." TECHEXPO.<br><br>
												Just a quick reminder that the show is coming up tomorrow. Make sure to bring plenty of resumes with you, remember an active security clearance (or one that has been used within the past 24 months) is required to enter.  Be prepared to interview for specific positions by consulting the jobs our exhibitors have posted: <a href='".FULL_BASE_URL.router::url('/',false)."shows/view/".$value['show']['id']."' target='_blank'>Click Here</a><br><br>
		Pass this message on to any other qualified professionals you may know.<br><br>
		Thanks again and see you at the show.<br><br>
		Sincerely,<br>
												</td>
											</tr>
											
											
											<tr>
												<td>
												Michelle Weiser<br>
												Marketing & Events Associate<br>
												212.655.4505 ext. 224<br>
												</td>
											</tr>
											</table>";
								
								$email = new CakeEmail();
								$email->from(array($sendfrom));
								//$email->to($sendto);
								$email->emailFormat('html');
								$email->subject(strip_tags($subject));
								$ok = $email->send($bodyText);
						}
					}
					
					
						
					$this->Session->write('popup','E-mail has been send successfully.');
					$this->Session->setFlash('E-mail has been send successfully.'); 
					
					$url=str_replace('/message:success','/',$this->referer());
					$url=explode('?',$url);
					$url['0']=$url['0'].'/message:success';
					$rediect=implode('?',$url);
					$this->redirect($rediect); 
					
				}
			}
		}
	
			}
		}*/
	}
	
	
	function superadmin_invitationToCandidate2()  // function to send invation
	{
		$this->set('showDetail','');
		$this->set('doaminList',array());
		
	
		
		$FooterMsg=$this->Show->query('select '.$this->request->data['Registration']['footer_type'].' as footer from candidate_email_messages limit 1');
		$this->set('FooterMsg',$FooterMsg['0']['candidate_email_messages']);
		
		$doaminList=$this->Show->query('select * from exclude_domains order by domain_name');
		$this->set('doaminList',$doaminList);
		
		
		
		
		if($this->request->data['Registration']['SUBMIT']=='Email')  // first form submition
		{
			if(is_array($this->request->data['Registration']['show_id']))
			{
				if(!empty($this->request->data['Registration']['show_id']))
				{
					$this->request->data['Registration']['state_id']=implode(',',$this->request->data['Registration']['state_id']);
				}
			}
			
			
			if(is_array($this->request->data['Registration']['state_id']))
			{
				if(!empty($this->request->data['Registration']['state_id']))
				{
					$this->request->data['Registration']['state_id']=implode("','",$this->request->data['Registration']['state_id']);
					$this->request->data['Registration']['state_id']="'".$this->request->data['Registration']['state_id']."'";
				}
			}
			if(is_array($this->request->data['Registration']['showid']))
			{
				if(!empty($this->request->data['Registration']['showid']))
				{
					$this->request->data['Registration']['showid']=implode(',',$this->request->data['Registration']['showid']);
				}
			}
			
			
				$showDetail=$this->Show->find('first',array('order'=>array('id'),   // get shows lists
																	'conditions'=>array('show_dt> "05/01/2005" and 
																	Show.id="'.$this->request->data['Registration']['show_id'].'"'),
																	'order'=>'show_dt desc'));  
			
					
				$this->set('showDetail',$showDetail);
				
				
															
		}												
	
	
	
		if($this->request->data['Registration']['SUBMIT']=='Email2')
		{
		
		
		if($this->request->data['Registration']['test_email'])  // first send testmail
		{
			if(!empty($this->request->data['Registration']['test_address']))  // first send testmail
			{
				$sendfrom =trim('nmathew@techexpousa.com');
							$subject = $this->request->data['Registration']['subject'];
						$bodyText = "
							<br><br>************************************************************************
	<br><br>
							To unsubscribe from all future communications with TechExpoUSA.com, please follow this link:
							".FULL_BASE_URL.router::url('/',false)."   (your login will be required to unsubscribe)
			<br><br>				
							************************************************************************
					<br><br>		
							Dear Admin
							<br><br>
							Many thanks for being a member of the TECHEXPO Top Secret mailing list.<br>
							<br><br>
							".$this->request->data['Registration']['message']."<br><br>
							
							".$this->request->data['Registration']['message_footer']."<br><br><br>"; 
																// Email configuration
								$sendto =strip_tags(trim($this->request->data['Registration']['test_address']));
								
								$email = new CakeEmail('smtp');
								$email->from(array($sendfrom));
								$email->to($sendto);
								$email->emailFormat('html');
								$email->subject(strip_tags($subject));
								$ok = $email->send($bodyText);
					
				
						$showDetail=$this->Show->find('first',array('order'=>array('id'),   // get shows lists
																	'conditions'=>array('show_dt> "05/01/2005" and 
																	Show.id="'.$this->request->data['Registration']['show_id'].'"'),
																	'order'=>'show_dt desc'));  
					
						$this->set('showDetail',$showDetail);
			
						
					//	$this->Session->write('popup','Test E-mail has been send successfully.');
					//$this->Session->setFlash('Test E-mail has been send successfully.'); 
			
			}
			
		}
		else /// if not test email  than send to all
		{	
						$condition =' ';
		
						$state_id='';
						if($this->request->data['Registration']['state_id'])
						{
							$state_id.= 'and  a.candidate_state in('.$this->request->data['Registration']['state_id'].')';
						}
						
						
						$securityClearance='';
						if($this->request->data['Registration']['security_clearance_code']=='y') // check for security clearance is require or not
							{
								$securityClearance ='and (d.source_code=0 and a.security_clearance_code != "38" and a.security_clearance_code != "3650"
				 and a.security_clearance_code not like "%38%" and a.security_clearance_code not like "%3650%")' ;
							}
						
						$exclude_domian='';
						if(!empty($this->request->data['Registration']['exclude_domian'])) // check for exclude domain
							{
							$exclude_domian=' and (';
							
								if(count($this->request->data['Registration']['exclude_domian']))
								{
									
									$i=1;
									$totalDomain=count($this->request->data['Registration']['exclude_domian']);
									foreach($this->request->data['Registration']['exclude_domian'] as $key=>$value)
									{
										if($i!='1')
										{
											$exclude_domian .=' and  ' ;
										}
										$exclude_domian .=' a.candidate_email not like "%'.$value.'%"';
										if($totalDomain==$i)
										{
											$exclude_domian .=' )  ' ;
										}
										
										$i=$i+1;
									}
								}
							}
						
						$showids='';
						if($this->request->data['Registration']['showid'])
						{
						//	$showids='or
						//		(a.candidate_email  in
						//		(select candidate_id  from resumes as Resume where source_code in ('.$this->request->data['Registration']['showid'].')))';
						}
			
			
					$query= 'SELECT DISTINCT d.source_code,e.show_id,a.candidate_email as email,a.candidate_name as name, "C" as type, "OK" as code
						 FROM 
						   candidates a, email_prefs b, users c, resumes d,registrations e
							where a.id=b.candidate_id 
								and a.id=c.candidate_id 
								and a.id=e.candidate_id 
								and a.id=d.candidate_id
								and (e.show_id="'.$this->request->data['Registration']['show_id'].'"
								'.$securityClearance.' '.$state_id.') and (a.candidate_email not in
						(select email from list_remove))
						and (a.candidate_email not in
						(select email from list_bad_emails)'.$exclude_domian.')
						'.$showids;
		
					$RecRegCand=$this->Registration->query($query); 
		
		
	
	
				foreach($RecRegCand as $value)  // send mail to all
					{
								
								$sendfrom =trim('nmathew@techexpousa.com');
							$subject = $this->request->data['Registration']['subject'];
							$bodyText = "************************************************************************
	
							To unsubscribe from all future communications with TechExpoUSA.com, please follow this link:
							".FULL_BASE_URL.router::url('/',false)."    (your login will be required to unsubscribe)
							
							************************************************************************
							
							Dear ".$value['a']['name']."
							
							Thank you for becoming a member of TECHEXPO Top Secret. You have successfully signed up for our mailing list.<br>
							
							".$this->request->data['Registration']['message']."<br>
							
							".$this->request->data['Registration']['message_footer']."<br>";
								
								// Email configuration
								$sendto =strip_tags(trim($value['a']['email']));
								
								$email = new CakeEmail('smtp');
								$email->from(array($sendfrom));
								$email->to($sendto);
								$email->emailFormat('html');
								$email->subject(strip_tags($subject));
								$ok = $email->send($bodyText);
					
					}
					
					
						
					$this->Session->write('popup','E-mail has been send successfully.');
					$this->Session->setFlash('E-mail has been send successfully.'); 
					
					$url=str_replace('/message:success','/',$this->referer());
					$url=explode('?',$url);
					$url['0']=$url['0'].'/message:success';
					$rediect=implode('?',$url);
					$this->redirect(array('controller'=>'admincandidates','action'=>'invitationToCandidate/message:success'));
				
		}
			
		}
		
	}
	
	
		function superadmin_mailResume()  // mail resume
		{ 
			$this->set('stateList',$this->common->getStateList()); // get shows lists
			$this->set('totalResume','');
			
			ini_set('max_execution_time', 600);
			if($this->request->data)  
			{ 
				$this->set('resumeTotalAll',0);
				if(!empty($this->request->data['count']))  // code to create rtf file and there zip file
				{
					 $handler = opendir(WWW_ROOT.'candidateDocument/resumeBluePrint/');  // empty folder 
					 while ($file = readdir($handler)) 
						{
							if(file_exists(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file))
							{
								if(is_file(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file))
								{
									unlink(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file);
								}
							}
						}
				
					$condition='';
					$csv_file_name='';
					$i=1;
					$stateArray= $this->request->data['Candidate']['state_id'];
					$totalState=count($this->request->data['Candidate']['state_id']);
				     // task id 2806
					if (in_array("USA", $this->request->data['Candidate']['state_id'])) {
						$this->loadModel('State');
						$stateList =$this->State->find('list',array('fields'=>array('id','state_abrev'),'conditions'=>'State.state_abrev!="00" and State.country="usa"','order'=>array('state_name')));
						 $this->request->data['Candidate']['state_id']=array_merge($this->request->data['Candidate']['state_id'],$stateList);
					
					}
					 // task id 2806
					if (in_array("Canada", $this->request->data['Candidate']['state_id'])) {
						$this->loadModel('State');
						$stateList =$this->State->find('list',array('fields'=>array('id','state_abrev'),'conditions'=>'State.state_abrev!="00" and State.country="ca"','order'=>array('state_name')));
						 $this->request->data['Candidate']['state_id']=array_merge($this->request->data['Candidate']['state_id'],$stateList);
					
					}
				
				
					$condition.=' AND ( (0=1)';
					if($this->request->data['Candidate']['state_id'])
					{	
					foreach($this->request->data['Candidate']['state_id'] as $value)
					{
						$condition .= ' OR ( (Candidate.candidate_state like "'.trim($value).'" ) OR (Candidate.pref_locations like "%'.trim($value).'%") )';
					}
					}
					$condition.=' ) ';
					
					
					$this->Resume->unBindModel(array('hasMany' => array('ResumeSkill')),false);  // all resume content
					$date=date('Y-m-d h:m:s',strtotime($this->request->data['Resume']['posteddt']));
					$resumeTotal=$this->Resume->find('count',array('conditions'=>'Resume.posted_dt > "'.$date.'"'.$condition));
					
					
					if($resumeTotal==0)
					{
						$resumeTotal="No Records Found";
					}else{
						
 						//--create the candidateXlsDocuments folder if not exist start--//
						$directory=WWW_ROOT."candidateXlsDocuments/"; 
						if(!file_exists($directory)) 
						{ 
							mkdir($directory,0777); 
						}
						//--create the candidateXlsDocuments folder if not exist end--//
						
						//-- clean the candidateXlsDocuments folder start --//
						$dir = WWW_ROOT."candidateXlsDocuments/"; 
						$dirHandle = opendir($dir); 
						while ($file = readdir($dirHandle)) { 
							if(!is_dir($file)) { 
								unlink ("$dir"."$file");
							}
						}
						closedir($dirHandle);
						//-- clean the candidateXlsDocuments folder end --//
						
						
						$condition='';
						$i=1;
						$totalState=count($this->request->data['Candidate']['state_id']);
						
						  // task id 2806
						if (in_array("USA", $this->request->data['Candidate']['state_id'])) {
							$this->loadModel('State');
							$stateList =$this->State->find('list',array('fields'=>array('id','state_abrev'),'conditions'=>'State.state_abrev!="00" and State.country="usa"','order'=>array('state_name')));
							 $this->request->data['Candidate']['state_id']=array_merge($this->request->data['Candidate']['state_id'],$stateList);
						
						}
						 // task id 2806
						if (in_array("Canada", $this->request->data['Candidate']['state_id'])) {
							$this->loadModel('State');
							$stateList =$this->State->find('list',array('fields'=>array('id','state_abrev'),'conditions'=>'State.state_abrev!="00" and State.country="ca"','order'=>array('state_name')));
							 $this->request->data['Candidate']['state_id']=array_merge($this->request->data['Candidate']['state_id'],$stateList);
						
						}
						
						$condition.=' AND ( (0=1)';
						if($this->request->data['Candidate']['state_id'])
						{	
					foreach($this->request->data['Candidate']['state_id'] as $value)
					{
						$condition .= ' OR ( (Candidate.candidate_state like "'.trim($value).'" ) OR (Candidate.pref_locations like "%'.trim($value).'%") )';
					}
					}
					$condition.=' ) ';
						$date=date('Y-m-d h:m:s',strtotime($this->request->data['Resume']['posteddt']));
						
					
					$resumeTotalAll=$this->Resume->find('all',array('conditions'=>'Resume.posted_dt > "'.$date.'"'.$condition,'fields'=>array('Resume.*,Candidate.id,Candidate.candidate_name,Candidate.candidate_email,Candidate.candidate_address,Candidate.candidate_city,Candidate.candidate_state,Candidate.candidate_zip,Candidate.candidate_phone')));
					
						
					$this->set('resumeTotalAll',count($resumeTotalAll));
					///////  csv file ////////////
						
						
					ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
	
					//create a file
						$csv_file_name="export_".date("Y_m_d_H_i_s").".csv";
						$csv_handler = fopen (WWW_ROOT."candidateXlsDocuments/".$csv_file_name,"w");
					// The column headings of your .csv file
						$csv = "id,Name,Email,address,City,State,Zip,Phone \n";//Column headers
					fwrite ($csv_handler,$csv);
					
					foreach($resumeTotalAll as $result)
					{
						// Array indexes correspond to the field names in your db table(s)
						
						$csv= 'resume_'.$result['Candidate']['id'].'.rtf'.','.$result['Candidate']['candidate_name'].','.$result['Candidate']['candidate_email'].','.$result['Candidate']['candidate_address'].','.$result['Candidate']['candidate_city'].','.$result['Candidate']['candidate_state'].','.$result['Candidate']['candidate_zip'].','.$result['Candidate']['candidate_phone']."\n"; //Append data to csv
						
	
						fwrite ($csv_handler,$csv);
	
					}
					
					fclose ($csv_handler);
						
						
					}
					$this->set('csv_file_name',$csv_file_name);
					$this->set('totalResume',$resumeTotal);
						$this->request->data['Candidate']['state_id'] = $stateArray;
				}
			
				if(!empty($this->request->data['Send']))  // code to create rtf file and there zip file
				{
					
						$this->Resume->unBindModel(array('hasMany' => array('ResumeSkill')),false); 
					 $handler = opendir(WWW_ROOT.'candidateDocument/resumeBluePrint/');  // empty folder 
					 while ($file = readdir($handler)) 
						{
							if(file_exists(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file))
							{
								if(is_file(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file))
								{
									unlink(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file);
								}
							}
						}
				
				
				
				
					$condition='';
					$i=1;
					$totalState=count($this->request->data['Candidate']['state_id']);
					
					  // task id 2806
					if (in_array("USA", $this->request->data['Candidate']['state_id'])) {
						$this->loadModel('State');
						$stateList =$this->State->find('list',array('fields'=>array('id','state_abrev'),'conditions'=>'State.state_abrev!="00" and State.country="usa"','order'=>array('state_name')));
						 $this->request->data['Candidate']['state_id']=array_merge($this->request->data['Candidate']['state_id'],$stateList);
					
					}
					
					$condition.=' AND ( (0=1)';
					if($this->request->data['Candidate']['state_id'])
					{	
					foreach($this->request->data['Candidate']['state_id'] as $value)
					{
						$condition .= ' OR ( (Candidate.candidate_state like "'.trim($value).'" ) OR (Candidate.pref_locations like "%'.trim($value).'%") )';
					}
					}
					$condition.=' ) ';
				
					//$this->Resume->unBindModel(array('hasMany' => array('ResumeSkill')));  // all resume content
					$date=date('Y-m-d h:m:s',strtotime($this->request->data['Resume']['posteddt']));
					$resumeTotal=$this->Resume->find('all',array('conditions'=>'Resume.posted_dt > "'.$date.'"'.$condition,'fields'=>array('Resume.*,Candidate.id,Candidate.candidate_name,Candidate.candidate_email,Candidate.candidate_address,Candidate.candidate_city,Candidate.candidate_state,Candidate.candidate_zip,Candidate.candidate_phone')));
					
					
					
					///////  csv file ////////////
					
					
					 //increase max_execution_time to 10 min if data set is very large

					//create a file
					/*$filename = "export_".date("Y.m.d").".csv";
					$csv_file = fopen('php://output', 'w');
					header('Content-type: application/csv');
					header('Content-Disposition: attachment; filename="'.$filename.'"');
				// The column headings of your .csv file
					$header_row = array("id", "Name", "Email", "address", "City", "State", "Zip", "Phone");
					fputcsv($csv_file,$header_row,',','"');
				// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
				foreach($resumeTotal as $result)
				{
					// Array indexes correspond to the field names in your db table(s)
					$row = array(

						'resume_'.$result['Candidate']['id'].'.rtf',

						$result['Candidate']['candidate_name'],

						$result['Candidate']['candidate_email'],

						$result['Candidate']['candidate_address'],

						$result['Candidate']['candidate_city'],

						$result['Candidate']['candidate_state'],

						$result['Candidate']['candidate_zip'],

						$result['Candidate']['candidate_phone']

					);

					

					fputcsv($csv_file,$row,',','"');

				}
*/
				

				//fclose($csv_file);die;

					
					
					/////////// end /////
					
					
					
					foreach($resumeTotal as $value)  // create rtf file
					{
						$rtf=strip_tags($value['Resume']['resume_content'],'<br>&nbsp;');  // creating rtf file
						file_put_contents('candidateDocument/resumeBluePrint/resume_'.$value['Resume']['id'].'.rtf', $rtf);
					}
					
					$results = array();   // ===== create zip file all 
					 $handler = opendir('candidateDocument/resumeBluePrint/');
					 while ($file = readdir($handler)) 
						{
							if ($file != "." && $file != "..")
							{
								$results[] = 'candidateDocument/resumeBluePrint/'.$file;
							}
						}
						
						if(isset($this->request->data['Resume']['filename']) && !empty($this->request->data['Resume']['filename']))
						{
						$ZIPNAME = $this->request->data['Resume']['filename'] ;	
						}
						else
						{
						$ZIPNAME=DATE('D_m_Y_m_s',time());
						}
						
						
						$result = $this->common->create_zip($results,'candidateDocument/resumeBluePrint/'.$ZIPNAME.'.zip');
					
				
				///===========================  TRANSFER FTP FILE
						/*$server='livemarketnews.com';
						$ftp_user_name='livemark';
						$ftp_user_pass='Dm349fal23iudfjhaw';*/
						
						
						$systemEmail = $this->common->systemSetting();
						
						
						$server=$systemEmail['Server for bluepoint'];
						$ftp_user_name=$systemEmail['FTP Username'];
						$ftp_user_pass=$systemEmail['FTP Password'];
						
						$conn_id = ftp_connect($server);
						$file ='candidateDocument/resumeBluePrint/'.$ZIPNAME.'.zip';
						if(file_exists($file))
						{
						
							$conn_id = ftp_connect($server);
							$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
							@ftp_pasv($conn_id, true);
							
						//	$ftp_root = 'public_html/demo_p/'.$ZIPNAME.'.zip';
							$ftp_root = $ZIPNAME.'.zip';
							if (ftp_put($conn_id,$ftp_root,$file, FTP_BINARY)) 
							{
								$this->Session->write('popup','zip file send successfully.');			
								$this->Session->setFlash('zip file send successfully.');  
								$this->redirect(array('controller'=>'admincandidates','action'=>'mailResume/message:success','superadmin'=>true));		
							} else {
								
								$this->Session->setFlash('Problem in sending zip file.');  
								$this->redirect(array('controller'=>'admincandidates','action'=>'mailResume'));
							}
				
						}
				///===========================	
			
						$this->Session->write('popup','zip file send successfully.');			
						$this->Session->setFlash('zip file send successfully.');  
						$this->redirect(array('controller'=>'admincandidates','action'=>'mailResume/message:success','superadmin'=>true));		
					
				}
			}
			
			
			
		}
		/*** function for updating candidate mass email message ********/
		function superadmin_candidateEmailMessage(){
			$this->set('meta_title','Candidate Mass email message');	
			
			if($this->request->is('post')){
				$this->CandidateEmailMessage->updateAll(
						array('CandidateEmailMessage.msg1'=>'"'.addslashes($this->request->data['CandidateEmailMessage']['msg1']).'"','CandidateEmailMessage.msg2'=>'"'.addslashes($this->request->data['CandidateEmailMessage']['msg2']).'"','CandidateEmailMessage.msg3'=>'"'.addslashes($this->request->data['CandidateEmailMessage']['msg3']).'"'),
						array('CandidateEmailMessage.msg_id'=>$this->request->data['CandidateEmailMessage']['msg_id'])
				);
			}
			
			$messages = $this->CandidateEmailMessage->find('first');
			//pr($messages);
			$this->set('emailmessge1',$messages['CandidateEmailMessage']['msg1']);
			$this->set('emailmessge2',$messages['CandidateEmailMessage']['msg2']);
			$this->set('emailmessge3',$messages['CandidateEmailMessage']['msg3']);
			$this->set('emailmessgeID',$messages['CandidateEmailMessage']['msg_id']);
			
			
			
		}
		
		
		function superadmin_uploadResumeStep1()
		{
			
			$this->set('errorFile','');
			$errorsArr=array();
			if(!empty($this->request->data))
			{
				if($this->request->data['Candidate']['SUBMIT']=='uploadCSV')
				{
						if(empty($this->request->data['Candidate']['File']['name']))
						{
							$this->set('errorFile','please upload csv  file');
							$errorsArr['File'][0]='please upload csv file';
						}
						else
						{
							$extension=end(explode('.',$this->request->data['Candidate']['File']['name']));
							if($extension!='csv')
							{
								$errorsArr['File'][0]='please upload only csv file';
								$this->set('errorFile','please upload only csv  file');
							}
						}  
						
						if(count($errorsArr))
						{
						}
						else
						{
							if ($this->request->data['Candidate']['File']['size'] > 0) 
							{
										//get the csv file
										$file = $this->request->data['Candidate']['File']['tmp_name'];
										$handle = fopen($file,"r");
										$csvFile=array();
										$alreadyExistEmail=array();
										//loop through the csv file and insert into database
										$i=0;
										
										while ($data = fgetcsv($handle,1000000,",","'"))
										{ 
										  // temp line 11 set 2013
									
											
											
											if ($data[0] && Validation::email($data[11])) 
											{
												if($this->common->checkJobSeekerEmail($data[11]))  // check for email exists
												{
													$csvFile[$i]['Candidate']['candidate_name']=$data[2].' '.$data[3].' '.$data[4];   // create new candidate												
													$csvFile[$i]['Candidate']['candidate_address']=$data[5];
													$csvFile[$i]['Candidate']['candidate_city']=$data[7];
													$csvFile[$i]['Candidate']['candidate_state']=$data[8];
													$csvFile[$i]['Candidate']['candidate_zip']=$data[9];
													$csvFile[$i]['Candidate']['candidate_phone']=$data[10];
													$csvFile[$i]['Candidate']['candidate_email']=$data[11];
													$csvFile[$i]['Candidate']['file_name']=$data[0];
													$csvFile[$i]['User']['status_code']='PROF';
													$csvFile[$i]['User']['username']=$data[11];
													$csvFile[$i]['User']['password']='techexpo';
													$csvFile[$i]['User']['user_type']='C';
													$csvFile[$i]['User']['old_password']='techexpo';
													
												}
												else
												{
													// if already exist then entry
													$alreadyExistEmail[$i]['Candidate']['candidate_email']=$data[11];
													$alreadyExistEmail[$i]['Candidate']['file_name']=$data[0];
												}
												$i=$i+1;
											}
											
											
										}
									//	pr($csvFile);
									//	pr($alreadyExistEmail);die;
										
										if(count($csvFile)>0 || count($alreadyExistEmail)>0)
										{	
											
											$this->Session->Write('csvFile',$csvFile);
											$this->Session->Write('alreadyExistEmail',$alreadyExistEmail);
											$this->redirect(array('controller'=>'admincandidates','action'=>'uploadResumeStep2','superadmin'=>true));
										}else
										{ 
											
											$this->Session->write('popup','please uploaded valid file.');			
											$this->Session->setFlash('please uploaded another file, all e-mail address are exits already.');  
										//	$this->redirect(array('controller'=>'admincandidates','action'=>'uploadResumeStep1/message:success','superadmin'=>true));
										}
							}
							
						}
				}
			}
		}
		
		function superadmin_uploadResumeStep2()
		{
			$this->set('errorFile','');
			$errorsArr=array();
			if(!empty($this->request->data))
			{
				if($this->request->data['Candidate']['SUBMIT']=='uploadZip')
				{
						if(empty($this->request->data['Candidate']['File']['name']))
						{
							$this->set('errorFile','please upload zip  file');
							$errorsArr['File'][0]='please upload zip file';
						}
						else
						{
							$extension=end(explode('.',$this->request->data['Candidate']['File']['name']));
							if($extension!='zip')
							{
								$errorsArr['File'][0]='please upload only zip file';
								$this->set('errorFile','please upload only zip  file');
							}
						}  
						
						
						if(count($errorsArr))
						{
						}
						else
						{
							$handler = opendir(WWW_ROOT.'candidateDocument/resumeBluePrint/');  // empty folder before up-load zip file
								 while ($file = readdir($handler)) 
									{
										if(file_exists(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file))
										{
											if(is_file(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file))
											{
												unlink(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file);
											}
										}
									}
						
					
						$name = $this->request->data['Candidate']['File']['name']; // mupload file
						move_uploaded_file( $this->data['Candidate']['File']['tmp_name'], WWW_ROOT."/candidateDocument/resumeBluePrint/" .$name);
						
						$zip = new ZipArchive; // extract uploaded zip file
						if ($zip->open(WWW_ROOT."/candidateDocument/resumeBluePrint/".$this->request->data['Candidate']['File']['name']) === TRUE) 
						{
						  $zip->extractTo(WWW_ROOT."/candidateDocument/resumeBluePrint/");
						  $zip->close();
						}
						
						$csvFile=$this->Session->read('csvFile');  //take a resume content in session
						
						if(count($csvFile) > 0 ){
							foreach($csvFile as $key=>$value)
							{	
								if(file_exists(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$value['Candidate']['file_name']))
								{
									$resumeContent=file_get_contents(WWW_ROOT."/candidateDocument/resumeBluePrint/".$value['Candidate']['file_name']);
									$csvFile[$key]['Resume']['resume_content']=$resumeContent;
								}else
								{
									$csvFile[$key]['Resume']['resume_content']='';
								}
							}
						}
						
						$alreadyExistEmail=$this->Session->read('alreadyExistEmail');  //take a resume content in session
						if(count($alreadyExistEmail) > 0 ){
							foreach($alreadyExistEmail as $key=>$value)
							{	
								if(file_exists(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$value['Candidate']['file_name']))
								{
									$resumeContent=file_get_contents(WWW_ROOT."/candidateDocument/resumeBluePrint/".$value['Candidate']['file_name']);
									$alreadyExistEmail[$key]['Resume']['resume_content']=$resumeContent;
								}else
								{
									$alreadyExistEmail[$key]['Resume']['resume_content']='';
								}
							}
						}
						
						
						
						
						$handler = opendir(WWW_ROOT.'candidateDocument/resumeBluePrint/');  // empty folder before after resuem content in session
					
								 while ($file = readdir($handler)) 
									{
										if(file_exists(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file))
										{
											if(is_file(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file))
											{
												unlink(WWW_ROOT.'candidateDocument/resumeBluePrint/'.$file);
											}
										}
									}
									
						
						$this->Session->Write('csvFile',$csvFile);
						$this->Session->Write('alreadyExistEmail',$alreadyExistEmail);
						$this->redirect(array('controller'=>'admincandidates','action'=>'uploadResumeStep3','superadmin'=>true));
						
					}
				}
			}
		
		}
		
		function superadmin_uploadResumeStep3()  // 3 step for upload resume
		{
		
			//pr($this->Session->Read('csvFile'));
			//pr($this->Session->Read('alreadyExistEmail'));die;
			$this->set('errorFile','');
			$this->set('errorFile1','');
			$errorsArr=array();
		//	$showList2=$this->Show->find('list',array('fields'=>array('id','showsNameDate'),'order'=>array('Show.show_dt DESC'),'conditions'=>array('show_dt > "01/01/2001"')));
			$this->Show->unBindModel(array('hasMany' => array('Registration')));
			$showList2=$this->Show->find('all',array('fields'=>array('Show.id','Show.show_name','DATE_FORMAT(Show.show_dt,"%m-%d-%Y") date'),'order'=>array('Show.show_dt DESC'),'conditions'=>array('show_dt > "01/01/2001"')));
			
			
			foreach($showList2 as $value)
			{
				
			$ShowHomeEnrty =  $this->common->getShowHomeName($value['Show']['id']);	
			if(isset($ShowHomeEnrty) && !empty($ShowHomeEnrty))
			$result[$value['Show']['id']] = $value[0]['date'].' '.$value['Show']['show_name'].', '.$ShowHomeEnrty;
			else
			$result[$value['Show']['id']] = $value[0]['date'].' '.$value['Show']['show_name'];
			
			}
			
			
					
		/*	$showList=$this->Show->find("all",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'INNER',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('CONCAT (Show.id) as  id ','CONCAT (DATE_FORMAT(Show.show_dt,"%m-%d-%Y") , " " , Show.show_name, ", " , ShowsHome.display_name) as eventDt'),'conditions'=>array('Show.show_dt > '=>'"01/01/2001"'),'order' => array('Show.show_dt  DESC')));
			$result = Set::classicExtract($showList, '{n}.0');
			$result = Set::combine($result, "{n}.id", "{n}.eventDt");*/
			
			
			
			
			$this->set('showList',$result); // get shows lists
			
			//pr($this->Session->read('csvFile'));
			
			if(!empty($this->request->data))
			{ 
			
			
				if($this->request->data['Candidate']['SUBMIT']=='Upload')
				{
						if(empty($this->request->data['Registration']['show_id']))
						{
							$this->set('errorFile','please select show');
							$errorsArr['File'][0]='please select show';
						}
						if(empty($this->request->data['Resume']['resume_title']))
						{
							$this->set('errorFile1','please enter title');
							$errorsArr['File'][1]='please enter title';
						}
						
						
						if(count($errorsArr))
						{
						}
						
						else
						{
							
							$csvFile=$this->Session->read('csvFile');  //take a resume content in session
							if(count($csvFile) > 0) {
							$resumeTitle=$this->request->data['Resume']['resume_title'];
							$showId=$this->request->data['Registration']['show_id'];
							
							
							$overright=$this->request->data['Registration']['overright'];
							
							if(!empty($overright))
							{
								if($this->common->checkShowId($overright))
								{
									$showId=$this->request->data['Registration']['overright'];
								}
							}
							
							foreach($csvFile as $key=>$value)
							{	
									$resumeContent=$value['Resume']['resume_content'];
									unset($value['Resume']);
									$this->request->data=$value;
																		
									if($this->Candidate->saveAll($this->request->data))
									{
										$candidateId=$this->Candidate->getLastInsertId();
										
										$this->request->data['Resume']['resume_title']=$resumeTitle;
										$this->request->data['Resume']['resume_content']=$resumeContent;
										$this->request->data['Resume']['posted_dt']=date('Y-m-d',time());
										// add 14 feb 2014
										$this->request->data['Resume']['source_code']= 0 ;
										
										$this->request->data['Registration']['show_id']=$showId;
										$this->request->data['Registration']['date_time']=date('Y-m-d',time());
										
									
									
										$this->request->data['Registration']['candidate_id']=$candidateId;
										$this->request->data['Resume']['candidate_id']=$candidateId;

									
										$this->Registration->save($this->request->data);
										$this->Resume->save($this->request->data);
										
										
										// insert in resume_set table 22/08/2013 START
										$lastResumeId=$this->Resume->getLastInsertId();
										$this->Show->id = $this->request->data['Registration']['show_id'];
										$getFieldvalue = $this->Show->field('resume_set_id');
										$this->loadModel('ResumeSet');
										if(!empty($lastResumeId) && !empty($getFieldvalue))
										{
											$data['ResumeSet']['set_id'] = $getFieldvalue;
											$data['ResumeSet']['resume_id'] = $lastResumeId;
											$this->ResumeSet->save($data,array('validate'=>false));
										}
										// insert in resume_set table 22/08/2013 End
										
										
										$this->Registration->id='';
										$this->Resume->id='';
										////// save record for email preference
										$this->request->data['EMAILPREF']['candidate_id']=$candidateId;
										$this->request->data['EMAILPREF']['show_mail']="Y";
										$this->request->data['EMAILPREF']['show_states']="ALL";
										$this->request->data['EMAILPREF']['job_mail']="y";
										$this->request->data['EMAILPREF']['num_jobs']="10";
										$this->request->data['EMAILPREF']['res_mail']="y";
										$this->request->data['EMAILPREF']['num_res']="10";
										$this->request->data['EMAILPREF']['num_res']="50";
										$this->request->data['EMAILPREF']['partner_mail']="n";
										$this->request->data['EMAILPREF']['employer_mail']="n";
			
										$this->EMAILPREF->save($this->request->data);
										
												
										//mail to candidate 
									$sendto = $this->request->data['Candidate']['candidate_email'];
									$sendfrom = 'nmathew@techexpoUSA.com';
									
									$subject = "Welcome to TechExpoUSA.com";
									$bodyText = "Dear ".$this->request->data['Candidate']['candidate_name'].",<br><br>
									Thank you for attending our most recent TECHEXPO Top Secret Hiring Event. We are pleased to inform you that the resume you have provided us at the event was successfully uploaded to our website. Your resume will be available for search only to the companies at that particular hiring event including virtual exhibitors. We encourage you to actively log in at www.TechExpoUSA.com and update your personal profile located on your dashboard. To do so, log in from the homepage with the following information:<br>
									<br><br>
									Username: ".$this->request->data['User']['username']."<br>
									Password: ".$this->request->data['User']['password']."
									 <br><br>
									After you have logged in successfully, click on the 'DASHBOARD' button to manage your personal profile. Here, you can upload a profile image, update your profressional experience on your profile, search for matching jobs, track applications, view scheduled interviews, research companies and manage your resumes.<br><br>
									 
									If you would like to delete your account and resume on the website entirely you may do that here as well.<br><br>
									 
									Thank you for attending the TECHEXPO Hiring Event. We wish you the best of luck with your career search.<br><br>
									 
									Best Regards,<br>
									The TECHEXPO Team.<br>
									Nancy Mathew<br>
									Director of Events and Marketing<br>
									212.655.4505 ext. 225 ";
									
									
							
						
									$email = new CakeEmail('smtp');
									$email->from(array($sendfrom));
									$email->to($sendto);
									$email->emailFormat('html');
									$email->subject(strip_tags($subject));
									$ok = $email->send($bodyText);
							
									
							}		
									
							}
							
							}
							
							// used to save already exist candidate resume , and assign in set
							
							$alreadyExistEmail=$this->Session->read('alreadyExistEmail');  //take a resume content in session
							if(count($alreadyExistEmail) > 0) {
							$resumeTitle=$this->request->data['Resume']['resume_title'];
							$showId=$this->request->data['Registration']['show_id'];
							
							
							if(isset($this->request->data['Registration']['overright']) && !empty($this->request->data['Registration']['overright'])){
							$overright=$this->request->data['Registration']['overright'];
							
							if(!empty($overright))
							{
								if($this->common->checkShowId($overright))
								{
									$showId=$this->request->data['Registration']['overright'];
								}
							}
							}
							
							foreach($alreadyExistEmail as $key=>$value)
							{	
									$resumeContent=$value['Resume']['resume_content'];
									unset($value['Resume']);
									$this->request->data=$value;
									$this->Candidate->unbindModel(array('hasMany'=>array('Resume')));
									$candidateReds = $this->Candidate->find('first',array('conditions'=>array('Candidate.candidate_email'=>$value['Candidate']['candidate_email']),'fields'=>array('Candidate.id','Candidate.candidate_email')));	
																	
									if(isset($candidateReds['Candidate']['id']) && !empty($candidateReds['Candidate']['id']))
									{
										$candidateId=$candidateReds['Candidate']['id'];
										
										$this->request->data['Resume']['resume_title']=$resumeTitle;
										$this->request->data['Resume']['resume_content']=$resumeContent;
										$this->request->data['Resume']['posted_dt']=date('Y-m-d',time());
										$this->request->data['Registration']['show_id']=$showId;
										$this->request->data['Registration']['date_time']=date('Y-m-d',time());
										
									
									
										$this->request->data['Registration']['candidate_id']=$candidateId;
										$this->request->data['Resume']['candidate_id']=$candidateId;

									
										$this->Registration->save($this->request->data);
										$this->Resume->save($this->request->data);
										
										
										// insert in resume_set table 22/08/2013 START
										$lastResumeId=$this->Resume->getLastInsertId();
										$this->Show->id = $this->request->data['Registration']['show_id'];
										$getFieldvalue = $this->Show->field('resume_set_id');
										$this->loadModel('ResumeSet');
										if(!empty($lastResumeId) && !empty($getFieldvalue))
										{
											$data['ResumeSet']['set_id'] = $getFieldvalue;
											$data['ResumeSet']['resume_id'] = $lastResumeId;
											$this->ResumeSet->save($data,array('validate'=>false));
										}
										// insert in resume_set table 22/08/2013 End
										
										
										$this->Registration->id='';
										$this->Resume->id='';
										////// save record for email preference
									/*	$this->request->data['EMAILPREF']['candidate_id']=$candidateId;
										$this->request->data['EMAILPREF']['show_mail']="Y";
										$this->request->data['EMAILPREF']['show_states']="ALL";
										$this->request->data['EMAILPREF']['job_mail']="y";
										$this->request->data['EMAILPREF']['num_jobs']="10";
										$this->request->data['EMAILPREF']['res_mail']="y";
										$this->request->data['EMAILPREF']['num_res']="10";
										$this->request->data['EMAILPREF']['num_res']="50";
										$this->request->data['EMAILPREF']['partner_mail']="n";
										$this->request->data['EMAILPREF']['employer_mail']="n";
			
										$this->EMAILPREF->save($this->request->data);
										
												
										//mail to candidate 
									$sendto = $this->request->data['Candidate']['candidate_email'];
									$sendfrom = 'nmathew@techexpoUSA.com';
									
									$subject = "Welcome to TechExpoUSA.com";
									$bodyText = "Dear ".$this->request->data['Candidate']['candidate_name'].",<br><br>
									Many thanks for attending one of our recent TECHEXPO events. We are pleased to inform you that the resume you have given us at the event was uploaded to our website. It will be available for searching by just those companies who participated in the recent job fair along with a few companies that were virtual exhibitors.  We invite you to log in at www.TechExpoUSA.com and, if necessary, update your profile. To do so, log in from the homepage with the following information:<br>
									<br><br>
									Username: ".$this->request->data['User']['username']."
									Password: ".$this->request->data['User']['password']."
									 <br><br>
									After logging in, click on the 'MANAGE PROFILE' button on your personal homepage. Here, you can modify your password and enter any additional information about yourself and your professional profile. This also where you should go if you would like to delete your account and resume on the site altogether.<br><br>
									 
									Also, please make sure to visit the 'EMAIL PREFERENCES' section to update your preferences regarding the e-mails we send you about jobs, future events or on behalf of employers or partners.<br><br>
									 
									Again, thank you for attending a TECHEXPO event and best of luck with you career.<br><br>
									 
									Best Regards,<br>
									The TECHEXPO Team.<br>
									Nancy Mathew<br>
									Director of Events and Marketing<br>
									212.655.4505 ext. 225 ";
									
									
							
						
									$email = new CakeEmail('smtp');
									$email->from(array($sendfrom));
									$email->to($sendto);
									$email->emailFormat('html');
									$email->subject(strip_tags($subject));
									$ok = $email->send($bodyText);*/
							
									
							}		
									
							}
							
							}
							
							$this->Session->write('popup','Resumes are uploaded.');			
							$this->Session->setFlash('Resumes are uploaded.');  
								
				
							$this->redirect(array('controller'=>'admincandidates','action'=>'uploadResumeStep1/message:success','superadmin'=>true));
						
					}
				}
			}
			
			
		}
		
		//function for view candidate videos
		function superadmin_candidatevideo(){		
			$candVideo = $this->CandidateVideo->find("all",array('order'=>array('CandidateVideo.created DESC')));
			$this->set("candVideo",$candVideo);
		}
		
		// function for approve a video
		function superadmin_videoapprove($id = null){
			$this->CandidateVideo->id = $id;
			$videoData = array('CandidateVideo'=>array('isApproved'=>'Y'));
			$this->CandidateVideo->save($videoData, false, array('isApproved'));
			$this->Session->write('popup','Video successfully approved.');
			$this->Session->setFlash('Video successfully approved.');
			$this->redirect(array('controller'=>'admincandidates','action' => "candidatevideo/message:success"));
		}
		
		// function for unapprove a video
		function superadmin_videounapprove($id = null){
			$this->CandidateVideo->id = $id;
			$videoData = array('CandidateVideo'=>array('isApproved'=>'N'));
			$this->CandidateVideo->save($videoData, false, array('isApproved'));
			$this->Session->write('popup','Video successfully unapproved.');
			$this->Session->setFlash('Video successfully unapproved.');
			$this->redirect(array('controller'=>'admincandidates','action' => "candidatevideo/message:success"));
		}
		
		// function for showing candidate video
		public function superadmin_showcandidatevideo($id = null  )
		{
			$this->layout = false;
			//$this->autoRender = false;
			$video_dt = $this->CandidateVideo->find('first',array('conditions'=>array('CandidateVideo.id'=>$id)));
			$this->set('video_dt',$video_dt);
		}
		
		function beforeFilter() {            
		parent::beforeFilter();
		$this->Auth->authenticate = array(
				'Form' => array('userModel' => 'Adminuser')                                
		);
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
            
		//$this->Session->delete('Auth.redirect');
		$this->Auth->allow('login');
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','superadmin'=>true);		
		$this->Auth->loginRedirect = array('controller' => 'adminusers', 'action' => 'home','superadmin'=>true);
		$this->Auth->scope = array('Adminuser.active' => 'yes');
                
            
   	}
	
	function  superadmin_emailhistory($action=NULL,$Id=NULL)
	{
						
		$this->paginate = array('all',
					'order'=>'JobEmailHistory.id DESC',
					'paramType' => 'querystring',
					'limit'=>'15'
				);
				$JobEmailHistory= $this->paginate('JobEmailHistory');
				$this->set('JobEmailHistory',$JobEmailHistory);

		
		if($action=='delete' && !empty($Id))
		{
			 if ($this->JobEmailHistory->delete($Id,false))
			  {
	            $this->Session->write('popup','E-mail history has been deleted successfully.');
				$this->Session->setFlash('E-mail history has been deleted successfully.');  
				$url=$this->referer().'/message:success';
                $this->redirect(array('controller'=>'admincandidates','action' => "emailhistory/message:success"));
              } 
		}
		
		
		
	}
	
	function superadmin_downloadCSV()
	{
		
			 $this->downloadFile('uploaded','csv_format.csv');
		
		
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