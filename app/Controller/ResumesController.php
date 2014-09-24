<?php 
/**************************************************************************
 Coder  : Pushkar Soni
 Object : Controller for login, logout and registration process of candidate
**************************************************************************/ 
class ResumesController extends AppController {
 	//var $name = 'Users'; //Model name attached with this controller 
 	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some required helpers to this controller
 	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler','Captcha');  //add some required component to this controller .
	var $layout = 'front'; //this is the layout for front panel 
	var $currUser = 0;
	var $uses = array('Candidate','User','Code','Resume','ResumeSkill');
	/* This function call by default when a controller is called */
	

	
	function resume()
	{	
		$this->set('securityerror','');
		
		if($this->Session->read('UserName')):
			$userRec = $this->User->find('first',array('conditions'=>array('User.username'=>$this->Session->read('UserName'))));
	 		$candidateId=$userRec['User']['candidate_id'];
			
			$this->set('securityerror','');
			//$this->set('keywordArray',$this->common->getKeywordList()); // Keyword list array
			$this->set('experienceArray',$this->common->getExperienceList()); // experince array
			$this->set('lastUsedArray',$this->common->getLastUsedList()); // Last Used array List
			$this->set('lastLevelArray',$this->common->getlevelList()); // Last Used array List
			
			
			if($this->request->data):
				$errorsArr=array();
			
				
				if(!empty($this->request->data['Delete'])):
				endif;
				
				if(!empty($this->request->data['Update'])):
					
					
					$this->Resume->set($this->request->data);  // check validation and save record	
						if(!$this->Resume->resumeUpload()) 
						{
							$errorsArr = $this->Resume->validationErrors;	
							$count=count($this->request->data['ResumeSkill']);
							for($i=0;$i<=$count;$i++)
							{
								if(empty($this->request->data['ResumeSkill'][$i]['skill_id'])):
									unset($this->request->data['ResumeSkill'][$i]);
								endif;
							}
							$this->request->data['Resume']['Count']=$count;
						
						}
						
					if(strtolower($this->Session->read('security_code'))!=strtolower($this->request->data['Resume']['captcha'])):
						$errorsArr['Resume']['0']='Please Enter Correct Captcha';
						$this->set('securityerror',$errorsArr['Resume']['0']);
					endif;
					
					
					if(count(array_values($errorsArr))):
						
					else:
					
						if($this->data['Resume']['filename']['name'])  // if file upload file
						{
							$name = time().'_'.$this->data['Resume']['filename']['name']; // upload resume
							move_uploaded_file( $this->data['Resume']['filename']['tmp_name'], "candidateDocument/resume/" .$name);
							$this->request->data['Resume']['filename']=$name;
						}else
						{
							$this->request->data['Resume']['filename']='';
						}
						
						
						
						$count=count($this->request->data['ResumeSkill']);
						for($i=0;$i<=$count;$i++)
						{
							if(empty($this->request->data['ResumeSkill'][$i]['skill_id'])):
								unset($this->request->data['ResumeSkill'][$i]);
							endif;
						}
						
						$this->request->data['Resume']['candidate_id']=$candidateId;
						$this->request->data['Resume']['source_code']='0';
						$this->request->data['Resume']['posted_dt']=date('Y-m-d h:i:s',time());
						
							
							
						$data=$this->request->data;
						$data['ResumeSkill']=array_values($data['ResumeSkill']);
						unset($this->Resume->data['ResumeSkill']);
						unset($this->ResumeSkill->data);
						
						$this->Resume->unBindModel(array('hasMany' => array('ResumeSkill')));	
							
						if($this->Resume->saveAll($data)):
						
							$resumeid=$this->Resume->getLastInsertId();  // get last inserted record
							$this->ResumeSkill->deleteAll(array('ResumeSkill.resume_id' =>$resumeid), false);
								
							foreach($data['ResumeSkill'] as $value){
								
									$this->ResumeSkill->create();
									$skill_data['ResumeSkill']=$value;
									$skill_data['ResumeSkill']['resume_id']=$resumeid;
									$this->ResumeSkill->set($skill_data);
									$this->ResumeSkill->save($skill_data);
									
							}
						
						
						
						
							$this->Session->write('candidateUserName',$this->Session->read('UserName'));
							$this->Session->write('candidateId',$candidateId);
							$this->Session->delete('UserName');
							$this->redirect(array('controller'=>'shows','action'=>'eventregistration'));
							
						endif;
					endif;
				endif;
			endif;
		else:
			$this->redirect(array('controller'=>'candidates','action'=>'register'));
		endif;
	}
	
	function Jobseeker_upload_resume()  // function to add new resume
	{	
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('topError','');
		$this->set('securityerror','');
		
		//$this->set('keywordArray',$this->common->getKeywordList());  // Keyword list array
		$this->set('experienceArray',$this->common->getExperienceList());   // experince array
		$this->set('lastUsedArray',$this->common->getLastUsedList());  // Last Used array List
		$this->set('lastLevelArray',$this->common->getlevelList());  // Last Used array List
	
	//pr($this->request->data);die;
		
			$userTotalResume=$this->Resume->find('count',array('conditions'=>'Resume.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"'));
			$this->set('userTotalResume',$userTotalResume);
			$this->set('securityerror','');
			
			if($this->Session->check('Auth.Client.User.candidate_id'))  // check for session
			{		
				
				$candidateId=$this->Session->read('Auth.Client.User.candidate_id');
				
				if($this->request->data)
				{
					$errorsArr=array();
				
							
					if(!empty($this->request->data['Resume']['Update']))
					{
						
						$this->Resume->set($this->request->data);  // check validation and save record	
						$this->ResumeSkill->set($this->request->data);  // check validation and save record	
						if(!$this->Resume->resumeUpload())   // check for validation
						{
							$errorsArr = $this->Resume->validationErrors;	
						}
						
											
						if(count(array_values($errorsArr)))
						{
							$count=count($this->request->data['ResumeSkill']);
							
							for($i=0;$i<=$count;$i++)
							{
								if(empty($this->request->data['ResumeSkill'][$i]['skill_id'])):
									unset($this->request->data['ResumeSkill'][$i]);
								endif;
							}
							
							$this->request->data['Resume']['count']=count($this->request->data['ResumeSkill']);
							
							
							$this->set('topError','Please fill all mendatory fields');
						}
						else
						{
						
						if($this->data['Resume']['filename']['name'])  // if file upload file
						{
							$name = time().'_'.$this->data['Resume']['filename']['name']; // upload resume
							move_uploaded_file( $this->data['Resume']['filename']['tmp_name'], "candidateDocument/resume/" .$name);
							$this->request->data['Resume']['filename']=$name;
						}else
						{
							$this->request->data['Resume']['filename']='';
						}
																		
							$count=count($this->request->data['ResumeSkill']);
							for($i=0;$i<=$count;$i++)
							{
								if(empty($this->request->data['ResumeSkill'][$i]['skill_id'])):
									unset($this->request->data['ResumeSkill'][$i]);
								endif;
							}
							
							$this->request->data['Resume']['candidate_id']=$candidateId;
							$this->request->data['Resume']['source_code']='0';
							$this->request->data['Resume']['posted_dt']=date('Y-m-d h:i:s',time());
							
					
					
						
						$data=$this->request->data;
						$data['ResumeSkill']=array_values($data['ResumeSkill']);
						unset($this->Resume->data['ResumeSkill']);
						unset($this->ResumeSkill->data);
						
						$this->Resume->unBindModel(array('hasMany' => array('ResumeSkill')));
						 
						 
						if($this->Resume->save($data))  // save record
							{
								$resumeid=$this->Resume->getLastInsertId();  // get last inserted record
								$this->ResumeSkill->deleteAll(array('ResumeSkill.resume_id' =>$resumeid), false);
								
							foreach($data['ResumeSkill'] as $value){
								
									$this->ResumeSkill->create();
									$skill_data['ResumeSkill']=$value;
									$skill_data['ResumeSkill']['resume_id']=$resumeid;
									$this->ResumeSkill->set($skill_data);
									$this->ResumeSkill->save($skill_data);
									
							}
								
								
								
								
								
								$rtf=strip_tags($this->request->data['Resume']['resume_content'],'<br>&nbsp;');  // creating rtf file
								file_put_contents('candidateDocument/resume/resume_'.$resumeid.'.rtf', $rtf);
							
								$this->Session->write('popup','Resume has been added successfully..');
								$this->redirect(array('controller'=>'resumes','action'=>'resumelist')); 
							}
						}
					}
				}
			
			}
		
	}
	
	function Jobseeker_edit_resume()
	{	
		$this->isJobSeekerLogin();  // login check 
		
		$this->set('securityerror','');
		$this->set('topError','');
		
	  
		//$this->set('keywordArray',$this->common->getKeywordList()); // Keyword list array
		$this->set('experienceArray',$this->common->getExperienceList());  // experince array
		$this->set('lastUsedArray',$this->common->getLastUsedList());  // Last Used array List
		$this->set('lastLevelArray',$this->common->getlevelList());  // Last Used array List
	
		$resumeid=$this->params->params['pass']['0'];
	

			
		if(!empty($this->request->data))
		{
		
		
				$errorsArr=array();
				if(!empty($this->request->data['Resume']['Update']))
				{
					
								
					$this->Resume->set($this->request->data);  // check validation and save record	
					
					if(!$this->Resume->resumeUpload()) 
					{
						$errorsArr = $this->Resume->validationErrors;	
					}
					
						
				
					
					if(count(array_values($errorsArr)))
					{
							
						$count=count($this->request->data['ResumeSkill']);
							for($i=0;$i<=$count;$i++)
							{
								if(empty($this->request->data['ResumeSkill'][$i]['skill_id'])):
									unset($this->request->data['ResumeSkill'][$i]);
								endif;
							}
							
						$this->request->data['Resume']['Count']=$count;
						$this->set('topError','Please fill all mendatory fields');
					}
					else
					{
					
						$count=count($this->request->data['ResumeSkill']);
							for($i=0;$i<=$count;$i++)
							{
								if(empty($this->request->data['ResumeSkill'][$i]['skill_id'])):
									unset($this->request->data['ResumeSkill'][$i]);
								endif;
							}
							
					
						
						
						if(!empty($this->request->data['Resume']['filename']['name']))
						{
							$name = time().'_'.$this->data['Resume']['filename']['name']; // upload resume
							move_uploaded_file( $this->data['Resume']['filename']['tmp_name'], "candidateDocument/resume/" .$name);
							$this->request->data['Resume']['filename']=$name;
						}else
						{
							$this->request->data['Resume']['filename']=$this->request->data['Resume']['oldfile'];
						}
						
						if (file_exists('candidateDocument/resume/resume_'.$this->request->data['Resume']['id'].'.rtf')) {
							unlink('candidateDocument/resume/resume_'.$this->request->data['Resume']['id'].'.rtf');
						}
						
						$rtf=strip_tags($this->request->data['Resume']['resume_content'],'<br>&nbsp;');  // creating rtf file
						file_put_contents('candidateDocument/resume/resume_'.$this->request->data['Resume']['id'].'.rtf', $rtf);
						
						
						
						
						$this->request->data['Resume']['posted_dt']=date('Y-m-d h:i:s',time());
						
						$resumeid=$this->request->data['Resume']['id'];
						$this->ResumeSkill->deleteAll(array('ResumeSkill.resume_id' =>$resumeid), false);
						
						
						if($this->Resume->saveAll($this->request->data))
						{
							$this->Session->write('popup','Resume has been updated successfully.');
							$this->redirect(array('controller'=>'resumes','action'=>'resumelist')); 
						}	
						
					}
				}
		}
		else
		{
			
			$this->request->data=$this->Resume->find('first',array('conditions'=>'Resume.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"
																				 and Resume.id="'.$resumeid.'"'));
			
			
			
			if(count($this->request->data['ResumeSkill']) > 4)
			{
				$this->request->data['Resume']['count']=5;
			}else
			{
				$this->request->data['Resume']['count']=count($this->request->data['ResumeSkill'])+1;
			}
			
			$this->request->data['Resume']['id']=$resumeid;
		}
	}

	function Jobseeker_viewResume()
	{
		$this->isJobSeekerLogin();  // login check 
		
		if(!empty($this->request->params['pass']['0'])):
			
			$candidateRec=$this->Resume->find('first',array('conditions'=>'Resume.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'" and Resume.id="'.$this->request->params['pass']['0'].'"'));
		endif;
		
		$this->set('candidateRec',$candidateRec);
		
		$this->loadModel('CandidateVideo');
		$CandidateVd = $this->CandidateVideo->find('first',array('conditions'=>array('CandidateVideo.candidate_id'=>$candidateRec['Resume']['candidate_id'],'CandidateVideo.isApproved'=>'Y'),'order'=>'CandidateVideo.id DESC','fields'=>array('video_type','video','description','id')));
		$this->set('CandidateVd',$CandidateVd);
	
	}
	
	function Jobseeker_resumelist()  // resume listing in candidate profile
	{
		$this->isJobSeekerLogin();  // login check 
		
		$errorsArr=array();
		$this->set('securityerror','');	
		
		//================ get Resume 
		$resumeRec=$this->Resume->find('all',array('conditions'=>'Resume.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"'));
		$this->set('resumeRec',$resumeRec);
		
	
		if(!empty($this->request->data)):   // submit form
		
			/*if(strtolower($this->Session->read('security_code'))!=strtolower($this->request->data['Resume']['captcha']))  // security code validation
			{
						$errorsArr['Resume']['0']='Please Enter Correct Captcha';
						$this->request->data['Resume']['captcha']['0']='Please Enter Correct Captcha';
			}*/
			
			
			if(count(array_values($errorsArr))) // if not enter correct security code
			{  
				$this->set('securityerror',$errorsArr['Resume']['0']);	
			}
			else{
					
					if(!empty($this->request->data['Resume']['action']))
					{
						if(is_array($this->request->data['Resume']['action']))
						{
							
							foreach($this->request->data['Resume']['action'] as $key=>$value)
							{
								if($value=='refresh')
								{
										$this->Resume->data['Resume']['posted_dt']=date('Y-m-d h:i:s',time());
										$this->Resume->data['Resume']['id']=$key;
										$this->Resume->save($this->Resume->data);
								}
							
							
								if($value=='delete')
								{
									
									$this->Resume->delete($key);
									$this->Resume->query('delete from resume_skills where resume_id="'.$key.'"');
								}
							}
							
							$this->Session->write('popup','Resume has been Refreshed/ Deleted successfully.');
							$this->redirect($this->referer());
						}
						
						
					}
					
					
					
					/*foreach($this->request->data['Resume']['refresh'] as $key => $value):     // update resume
						if($value):
							
							$this->Resume->data['Resume']['posted_dt']=date('Y-m-d h:i:s',time());
							$this->Resume->data['Resume']['id']=$value;
							$this->Resume->save($this->Resume->data);
							$this->Session->write('popup','Resume Successfully Updated.');
						endif;
					endforeach;
					
					foreach($this->request->data['Resume']['delete'] as $key => $value):  // delete resume
						if($value):
							$this->Resume->delete($value);
							$this->Resume->query('delete from resume_skills where resume_id="'.$value.'"');
							$this->Session->write('popup','Resume has been deleted successfully.');
						endif;
					endforeach;*/
				
					$this->redirect(array('controller'=>'resumes','action'=>'resumelist')); 
			}
		endif;
		
	}
	
	function beforeFilter() 
	{ 
		parent::beforeFilter();
		
		if($this->Session->read('Auth.Client.User.user_type')=='C')
		{
			$this->Auth->allow('*');
		}else
		{
			$this->Auth->allow('register','index','resume','captcha');
		}
   	}
	
}
?>