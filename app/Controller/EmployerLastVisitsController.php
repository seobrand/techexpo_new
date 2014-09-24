<?php
App::uses('AppController', 'Controller');
/**
 * HomepageMessages Controller
 *
 * @property HomepageMessage $HomepageMessage
 */
class EmployerLastVisitsController extends AppController {
    public $components = array('Auth','Session');
    public $layout = "admin";
	var $uses = array('EmployerLastVisit','User','EmployerContact','EmployerSet','Employer','CustomEmployerSet','CustomEmployerSet','EmployerStat','JobPosting','Resume','Candidate','Folder','FolderContent','ResumeAccessStat','OfccpTracking','ShowEmployer','ShowCompanyProfile','ShowInterview','TrialAccount');

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index($employerID=null,$employerContactID=null) {
        $this->set('meta_title','Employer Last Visit');
		$this->EmployerLastVisit->recursive = 0;
	 	$this->set('employerLastVisits', $this->EmployerLastVisit->find('all',array('order'=>array("EmployerLastVisit.last_visit DESC"))));
		
		
		$WithOutActive = $this->EmployerLastVisit->query("select Employer.id, Employer.employer_name, EmployerContact.contact_name, EmployerContact.id
from employers Employer, employer_contacts EmployerContact 
where Employer.id not in (select employer_id from employer_last_visits)
and Employer.id=EmployerContact.employer_id
order by employer_name");

		$this->set('WithOutActive',$WithOutActive);
		
		
		
		if(!empty($employerID) && !empty($employerContactID))
		{
			
			
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
				$this->Session->write('popup','Account successfully deleted.');
				
				
			
		}
		
		
     // pr($this->EmployerLastVisit->find('all',array('order'=>array("EmployerLastVisit.last_visit DESC"))));        
	}
        
         /* This function is used to call before  */
	function beforeFilter() {
		parent::beforeFilter();
                $this->Auth->fields = array(
                    'username' => 'username', 
                    'password' => 'password'
            );
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		
		$this->Auth->allow('login');
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'employerLastVisits', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');		
   	}
	
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
