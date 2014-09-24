<?php
App::uses('AppController', 'Controller');
/**
 * HomepageMessages Controller
 *
 * @property HomepageMessage $HomepageMessage
 */
class SiteWideResumesController extends AppController {
    public $components = array('Auth','Session');
    public $layout = "admin";
	var $uses = array('Employer','JobPosting','Resume','Candidate','ApplyHistory','EmployerContact');

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
        $this->set('meta_title','Site wide Resumes');
			
		$this->set('cand_count',$this->Candidate->find('count'));
		$this->set('resume_count',$this->Resume->find('count'));
		$this->set('employer_count',$this->Employer->find('count'));
		
		$this->set('employer_pcount',$this->JobPosting->find('count',array('fields' => 'DISTINCT JobPosting.employer_id')));
		$this->set('application_count',$this->ApplyHistory->find('count'));
		$this->set('postings_count',$this->JobPosting->find('count',array('conditions'=>array('active'=>'1'))));
		
		
		$resume_dt = $this->JobPosting->query("select Employer.employer_name,contact_name,count(distinct JobPosting.posting_id) as cnt_p,count(distinct ApplyHistory.candidate_id)as cnt_c
							from job_postings JobPosting, employers Employer , employer_contacts EmployerContact, apply_history ApplyHistory
							where JobPosting.employer_id=Employer.id and JobPosting.employer_contact_id=EmployerContact.id and JobPosting.posting_id=ApplyHistory.posting_id
							group by Employer.employer_name,contact_name
							order by cnt_p desc");
							
		//		pr($this->ApplyHistory->find('all',array('fields'=>'Employer.employer_name,count(distinct JobPosting.posting_id) as cnt_p,count(distinct ApplyHistory.candidate_id)as cnt_c','group'=>'Employer.employer_name','order'=>'cnt_p desc')));	die;	
							
		$this->set('resume_dt',$resume_dt);				
		
         		$jobresume_dt = $this->JobPosting->query("select ApplyHistory.posting_id,JobPosting.job_title,Employer.employer_name,contact_name, count(*) ascnt
														from apply_history ApplyHistory,job_postings JobPosting, employers Employer , employer_contacts EmployerContact
														where ApplyHistory.posting_id=JobPosting.posting_id and JobPosting.employer_id=Employer.id and JobPosting.employer_contact_id=EmployerContact.id
														group by ApplyHistory.posting_id,JobPosting.job_title,Employer.employer_name,contact_name order by ascnt desc");
		//pr($jobresume_dt);
		$this->set('jobresume_dt',$jobresume_dt);	 
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
		$this->Auth->loginRedirect = array('controller' => 'SiteWideResumes', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');		
   	}
	
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
