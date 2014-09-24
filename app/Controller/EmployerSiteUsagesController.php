<?php
App::uses('AppController', 'Controller');
/**
 * HomepageMessages Controller
 *
 * @property HomepageMessage $HomepageMessage
 */
class EmployerSiteUsagesController extends AppController {
    public $components = array('Auth','Session','common');
    public $layout = "admin";
	var $uses = array('EmployerLastVisit','User','EmployerContact','EmployerSet','Employer','CustomEmployerSet','CustomEmployerSet','EmployerStat','JobPosting','Resume','Candidate','Folder','FolderContent','ResumeAccessStat','OfccpTracking','ShowEmployer','ShowCompanyProfile','ShowInterview','TrialAccount');

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
        $this->set('meta_title','Employer Site Usage');
		$errorsArr = '';

		if($this->request->is('post')){
			//pr($this->request->data);
			$today_dt = date('Y-m-d');
			$start_dt = $this->request->data['EmployerStat']['start_dt'];
			$end_dt = $this->request->data['EmployerStat']['end_dt'];	
			
			// check dates validation
			if($start_dt==''){
				$errorsArr['start_dt'][0] = 'Plese select start date from you want statistics';
			}elseif($end_dt==''){
				$errorsArr['end_dt'][0] = 'Please select end date to you want statistics';
			}elseif($start_dt > $today_dt){
				$errorsArr['start_dt'][0] = 'The start date for the statistics cannot be greater than today date';
			}elseif($end_dt > $today_dt){
				$errorsArr['end_dt'][0] = 'The end date for the statistics cannot be greater than today date';
			}elseif($start_dt > $end_dt){
				$errorsArr['start_dt'][0] = 'The start date for the statistics cannot be greater than the end date';
			}
			if($errorsArr){
				$this->Set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			// dates validations end

			if(!$errorsArr){
				$this->set('showstat','showStatistics');
				$this->set('start_dt',$start_dt);
				$this->set('end_dt',$end_dt);		
			}
			
					
		}
		       
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
		$this->Auth->loginRedirect = array('controller' => 'EmployerSiteUsages', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');		
   	}
	
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
