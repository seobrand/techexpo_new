<?php 
/******************************************************************************************
 Coder  : Jitendra Pradhan 
 Object : Controller to handle News operations - view , add, edit and delete
******************************************************************************************/ 
App::uses('CakeEmail', 'Network/Email');

class CronjobsController extends AppController {
	var $name = 'Cronjobs'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript'); //add some other helpers to controller
	var $components = array('common','Session','Cookie','RequestHandler','Captcha','Email');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'front'; //this is the layout for admin panel 
	var $uses = array('Employer','Show','ShowEmployer','ShowInterview','ShowCompanyProfile','EmployerContact','ResumeSetRule','ResumeSet','EmployerSet','Code','User','JobPosting','Folder','JobScore','ResumeScore','CustomEmployerSet','EmployerStat','EmployerLastVisit','ResumeAccessStat','OfccpTracking','Candidate','TrialAccount','TrialAccountTrack','EmployerEmailMessage');
	
	 /******************Function to create new profile***************************/
	
	function activeDeactiveJobs() {
		$this->autoRender = false;
		$cutoffdate = date('Y-m-d', strtotime('-60 days'));
		// find all the active jobs which is not refreshed from 60 days 
		$this->JobPosting->recursive = -1;
		$activeJobs = $this->JobPosting->find('all', array('fields'=>array('DISTINCT JobPosting.posting_id','JobPosting.start_dt','JobPosting.active'),'conditions'=>array('start_dt <'=>$cutoffdate,'active'=>1),'order'=>array('start_dt DESC')));
		//make all these jobs inactive		
		foreach($activeJobs as $activeJobs){
			$activeJob['JobPosting']['posting_id'] = $activeJobs['JobPosting']['posting_id'];
			$activeJob['JobPosting']['active'] = 0;			
			$ok = $this->JobPosting->save($activeJob);			
			
			/** write the log of deactive jobs **/
			$deactiveMessage = "Job ".$activeJobs['JobPosting']['posting_id']." Deactivated successfully";
			CakeLog::write('DeactivatedJobs', $deactiveMessage);
		}
		
	}
	
	//function for delete trial account
	function deleteTrialAccount(){	
		
		$this->autoRender = false;
		
		$currentdate = date("Y-m-d h:i:s",time());
		
		
		$condition = "end_time < '".$currentdate."' ";
		$trialaccount = $this->TrialAccount->find("all",array('conditions'=> $condition));
		
		foreach($trialaccount as $key => $trialaccount){
			$employerContactID = $trialaccount['TrialAccount']['employer_contact_id'];
			$employerID = $trialaccount['TrialAccount']['employer_id'];
			
			$salesPersonEmail = $trialaccount['TrialAccount']['sales_email'];
			//get employer details
			$employerContact = $this->EmployerContact->find('first',array('conditions'=>array('EmployerContact.employer_id'=>$employerID)));
			
			$getstat = $this->EmployerStat->find('all',array('fields'=>array('pagename','count(pagename) as pgcnt'),'conditions'=>array('EmployerStat.employer_id'=>$employerID),'group'=>array('pagename'),'order'=>array('pgcnt desc')));
			
			$report="";
			$rs=0;
			$prs=0;
			$rv=0;
			$prv=0;
			$lg=0;
			$dw=0;
			$em=0;
			$fl=0;
			
			foreach($getstat as $key =>$stat){
				
				if($stat['EmployerStat']['pagename']=='/login.cfm' || $stat['EmployerStat']['pagename']=='/login') {
					$type="Logins";
					$lg=1;
				}elseif($stat['EmployerStat']['pagename']=='/adv_resume_search.cfm' || $stat['EmployerStat']['pagename']=='/resumeSearchResult'){
					$type="Resume Searches";
					$rs=1;
				}elseif($stat['EmployerStat']['pagename']=='/emp_display_resume2.cfm' || $stat['EmployerStat']['pagename']=='/showResume'){
					$type="Resume Views";
					$rv=1;
				}elseif($stat['EmployerStat']['pagename']=='/emp_download.cfm' || $stat['EmployerStat']['pagename']=='/exportResume'){
					$type="Resume Downloads";
					$dw=1;
				}elseif($stat['EmployerStat']['pagename']=='/emp_email_resume.cfm' || $stat['EmployerStat']['pagename']=='/mailResume'){
					$type="Resumes forwarded by e-mail";
					$em=1;
				}elseif($stat['EmployerStat']['pagename']=='/emp_res_quick_file_action.cfm' || $stat['EmployerStat']['pagename']=='/resumefiletofolder'){
					$type="Resumes filed to folders for later e-mail forwarding / mass e-mail";
					$fl	=1;
				}
				
				$report=$report."- ".$type.": ".$stat[0]['pgcnt']."<br/>";
				
				
			}
			
			if($lg==0)
				$report=$report."- Logins: 0 <br/>";
			if($rs==0)
				$report=$report."- Resume Searches: 0 <br/>";
			if($rv==0)
				$report=$report."- Resume Views: 0 <br/>";
			if($dw==0)
				$report=$report."- Resume Downloads: 0 <br/>";
			if($em==0)
				$report=$report."- Resumes forwarded by e-mail: 0 <br/>";
			if($fl==0)
				$report=$report."- Resumes filed to folders for later e-mail forwarding / mass e-mail: 0 <br/>";
				
				
			//email message 
			$emailmessage = $this->EmployerEmailMessage->find('first');
			
			$email = new CakeEmail('smtp');
			$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
			$subject = "Your techexpoUSA.com trial account has expired";
			$email->emailFormat('html');
			$email->subject(strip_tags($subject));
			
			$bodyText = 'Dear '.$employerContact['EmployerContact']['contact_name'].',<br/><br/>
			
			I hope you enjoyed your free trial on TechExpoUSA.com and I look forward to servicing your recruitment needs in the future. I will be calling you shortly to follow up, but please feel free to contact me at any point:<br/><br/>
			'.$trialaccount['TrialAccount']['sales_name'].'<br/>
			212.655.4505 ext. '.$trialaccount['TrialAccount']['sales_ext'].'<br/>'.$trialaccount['TrialAccount']['sales_email'].'<br/><br/>Again, thank you for trying TechExpoUSA.com.<br/><br/>Sincerely,<br/><br/>'.$trialaccount['TrialAccount']['sales_name'].'<br/><br/>--------------------------------------------------<br/>--------------------------------------------------<br/><br/>'.$emailmessage['EmployerEmailMessage']['msg'].'<br/>';
									
			$sendtoemails = explode(",",$employerContact['EmployerContact']['contact_email']);
			
			
			
			/***** Should be uncomment later ****/
			if(is_array($sendtoemails)){
				foreach($sendtoemails as $sendTo){
					if(Validation::email($sendTo)){
						$email->to($sendTo);
							if(Validation::email($salesPersonEmail)){
							$email->cc($salesPersonEmail);
							}
						$email->send($bodyText);
					}
				}
			}
			
			//send email to Admin
			$email = new CakeEmail('smtp');
			$email->from(array('webmaster@techexpoUSA.com'));
			$subject1 = "Close that deal !!";
			$email->emailFormat('html');
			$email->subject(strip_tags($subject1));
			
			$bodyText1 = $trialaccount['TrialAccount']['sales_name'].',<br/><br/>
			'.$employerContact['EmployerContact']['contact_name'].' ('.$employerContact['Employer']['employer_name'].') trial account has just expired. They received an e-mail to inform them of this and to let them know that you will be contacting them soon. Please contact them as soon as possible to follow up.<br/><br/>
			
			The trial ended: '.$trialaccount['TrialAccount']['end_time'].'<br/><br/>
			
			Here is an archive of their site usage statistics for their trial period, as those have been deleted along with their account.<br/><br/>'.$report.'<br/><br/>
			
			Since the account was deleted, here is their info to copy and paste in order to re-create a regular account for them:<br/><br/>
			Username: '.$employerContact['User']['username'].'<br/>
			Password: '.$employerContact['User']['old_password'].'<br/>
			Company name: '.$employerContact['Employer']['employer_name'].'<br/>
			Contact name: '.$employerContact['EmployerContact']['contact_name'].'<br/>
			Contact e-mail for TECHEXPO: '.$employerContact['EmployerContact']['contact_email'].'<br/>
			Contact e-mail for resumes: '.$employerContact['EmployerContact']['contact_email'];
			
			// Should be uncomment later
		/*************** Mail to client by system variable  ******************/	
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
			
		
			$email->to($sendto);
			$email->cc($sendcc);
			$ok = $email->send($bodyText1);
			
			if(Validation::email('nmathew@techexpousa.com')){
				$email->to('nmathew@techexpoUSA.com');
				$email->cc('brand@techexpousa.com');
				$email->send($bodyText1);
			}
		/*************************************************************************************************/
			
			// delete records from database
			$this->EmployerContact->delete($employerContactID);
			
			// Delete User
			$this->User->deleteAll(array('User.employer_contact_id' => $employerContactID));
		
			// Delete folder and its folder_content of employer
			$this->Folder->deleteAll(array('Folder.employer_contact_id' => $employerContactID), true);
				
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
			
			/** write the log of deleted account **/
			$delMessage = "Employer ".$employerID." Deleted successfully";		
			CakeLog::write('Trailaccount', $delMessage);
		}
		
	}

		//function for send trial account mail
	function sendTrialAccountMail(){	
		
		$this->autoRender = false;
		
		//$currentdate = date("Y-m-d h:i:s",time());
		$currentdate = date("Y-m-d h:i",time());
	//	$currentdate = "%2013-12-10 12:30%";
		$condition = "User.created like '%".$currentdate."%' ";
		$trialaccount = $this->TrialAccount->find("all",array('joins' => array(

				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'LEFT',
					'conditions' => array(
					'User.employer_contact_id = TrialAccount.employer_contact_id'
					)
				),
				array(
					'table' => 'employer_contacts',
					'alias' => 'EmployerContact',
					'type' => 'LEFT',
					'conditions' => array(
					'EmployerContact.id = TrialAccount.employer_contact_id'
					)
				)
			),'conditions'=> $condition,'fields'=>array('TrialAccount.*','User.created','User.username','User.old_password','EmployerContact.contact_email')));
	
	
		
		foreach($trialaccount as $key => $trialaccount){
			
		
			
			// send email
				$email = new CakeEmail('smtp');
				$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
				$subject = "Welcome to TechExpoUSA.com ! Account information enclosed";
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				
				$bodyText = 'Thank you for joining TechExpoUSA.com. Your trial account is now active and you can start searching resumes by visiting http://www.TechExpoUSA.com. <br/><br/>
				
Here is your TECHEXPO trial account information:<br/><br/>
Username: '.$trialaccount['User']['username'].'<br/>
Password: '.$trialaccount['User']['old_password'].'<br/>
Trial account start date time: '.date('d F Y,H:i A',strtotime($trialaccount['User']['created'])).'<br/>
Trial account end date time: '.date('d F Y,H:i A',strtotime($trialaccount['TrialAccount']['end_time'])).' <br/><br/>

You will be notified by e-mail when your trial expires. To purchase permanent access to the resume database, please contact your sales representative<br/><br/>

'.$trialaccount['TrialAccount']['sales_name'].'<br/>
212.655.4505 ext. '.$trialaccount['TrialAccount']['sales_ext'].'<br/>'
.$trialaccount['TrialAccount']['sales_email'].'<br/><br/>

If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. <br/><br/>

Again, it is truly a pleasure to welcome you.<br/><br/>

Sincerely, <br/>
Nancy Mathew<br/>
Events Director<br/>
212.655.4505 ext. 225';
		
							
				$sendtoemails = explode(",",$trialaccount['EmployerContact']['contact_email']);
				$salesPersonEmail = $trialaccount['TrialAccount']['sales_email'];
				
				/********* Should be uncomment later*/
				if(is_array($sendtoemails)){
					foreach($sendtoemails as $sendTo){
						if(Validation::email($sendTo)){
							$email->to($sendTo);
								if(Validation::email($salesPersonEmail)){
								$email->cc($salesPersonEmail);
								}
							$email->send($bodyText);
						}
					}
				}
			
			
			
		
		}
		
	}	
	
	
}