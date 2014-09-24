<?php
App::uses('AppController', 'Controller');
/**
 * HomepageMessages Controller
 *
 * @property HomepageMessage $HomepageMessage
 */
class PreRegistrationsController extends AppController {
    public $components = array('Auth','Session');
    public $layout = "admin";
	var $uses = array('Location','Show','JobPosting','Resume','Candidate','Registration','Code','ShowEmployer','SurveyResult','ShowInterview','SurveyCode');

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
        $this->set('meta_title','Pre-Registrations');
		
		
		$shows = $this->Show->find('list',array('fields'=>array('id','showsNameDate'),'order'=>'show_dt desc'));
		$this->set('show_list',$shows);
		
		
		
		if(isset($this->request->data['PreRegistrations']['show_id']) && !empty($this->request->data['PreRegistrations']['show_id']))
		{ 
			$show_id = $this->request->data['PreRegistrations']['show_id'];	
			$shows = $this->Show->find('first',array('conditions'=>array('Show.id'=>$show_id)));
			$this->set('shows',$shows);
			
			// candidates without security clearance
			$reg_without_cl = $this->Registration->find('count',array('conditions'=>array('Registration.show_id'=>$show_id,'Candidate.security_clearance_code'=>'38')));
			$this->set('reg_without_cl',$reg_without_cl);
			
			
			// candidates with security clearance
			$reg_with_cl = $this->Registration->find('count',array('conditions'=>array('Registration.show_id'=>$show_id,'Candidate.security_clearance_code != 38')));
			$this->set('reg_with_cl',$reg_with_cl);
			
			
			// total pre register candidate
			$total_canidate = $this->Registration->find('count',array('conditions'=>array('Registration.show_id'=>$show_id)));
			$this->set('total_canidate',$total_canidate);
			
			// total survey
			$survey_dt = $this->SurveyCode->query('select c.code_descr,count(b.survey_code_id) as survey_cnt from survey_results b,survey_codes c where b.show_id='.$show_id.'  and b.survey_code_id=c.survey_code_id group by code_descr order by survey_cnt desc');
			$this->set('survey_dt',$survey_dt);
			$this->set('survey_total',$this->SurveyResult->find('count',array('conditions'=>array('SurveyResult.show_id'=>$show_id))));
			
			// POSTCARD TAGGING CODES BREAKDOWN
			$postcard_dt = $this->SurveyCode->query('select postcard_code, count(postcard_code) as pcnt from survey_results where show_id=148 and length(postcard_code) >=1 group by postcard_code order by postcard_code');
			$this->set('postcard_dt',$postcard_dt);
			
			// Security Clearance
			$security_clearance = $this->Code->find('all',array('conditions'=>array('Code.code_name'=>'Security Clearance','Code.code_name != 38'),'fields'=>array('Code.code_id,Code.code_descr'),'order'=>'code_descr'));
			$this->set('security_clearance',$security_clearance);
			
			// REGULAR PRE-REGISTRATIONS:
			$reg_without_cl1 = $this->Registration->find('all',array('conditions'=>array('Registration.show_id'=>$show_id,'Candidate.security_clearance_code'=>'38'),'fields'=>'DISTINCT Candidate.candidate_name,Candidate.id'));
			
			$this->set('reg_without_cl1',$reg_without_cl1);
		//	echo "<pre>";
		//	print_r($reg_without_cl1);
			
			// ACTIVE SECURITY CLEARED PRE-REGISTRATIONS:
			$reg_with_cl_active = $this->Registration->find('all',array('conditions'=>array('Registration.show_id'=>$show_id,'Candidate.security_clearance_code != 38'),'fields'=>'DISTINCT Candidate.candidate_name,Candidate.id'));
			$this->set('reg_with_cl_active',$reg_with_cl_active);
		//	echo "<pre>";
		//	print_r($reg_with_cl_active);
		
		
			// new code add for show candidate list 22 now 2013 apurav
			$this->Registration->unbindModel(array('belongsTo' => array('show')));
			$this->Registration->bindModel(array('belongsTo' => array('Show')));
			$reg_without_cl_candidate = $this->Registration->find('all',array('conditions'=>array('Registration.show_id'=>$show_id,'Candidate.security_clearance_code'=>'38'),'fields'=>array('Candidate.candidate_name','Candidate.id','Registration.hear_about'),'order'=>'candidate_name'));
		
			$this->set('reg_without_cl_candidate',$reg_without_cl_candidate);
			
			$reg_with_cl_candidate = $this->Registration->find('all',array('conditions'=>array('Registration.show_id'=>$show_id,'Candidate.security_clearance_code != 38'),'fields'=>array('Candidate.candidate_name','Candidate.id','Registration.hear_about'),'order'=>'candidate_name'));
			$this->set('reg_with_cl_candidate',$reg_with_cl_candidate);
			
			$this->loadModel('SurveyResult');
			$this->set('SurveyResultCnt',$this->SurveyResult->query("select count(*) as totalcnt from survey_results2 where show_id=".$show_id));
			
			$SurveyResults =$this->SurveyResult->query("select survey_answer, count(survey_answer) as srvcnt from survey_results2  as SurveyResult where show_id=".$show_id." group by survey_answer order by srvcnt desc");
			$this->set('SurveyResults',$SurveyResults );
		
		}
		else
		{
			
		}
		
	}
	
	function superadmin_exportCandidate($id = null ) {
		
		$total_candidate = $this->Registration->find('all',array('conditions'=>array('Registration.show_id'=>$id),'fields'=>array("Candidate.candidate_name","Candidate.candidate_email","Candidate.candidate_address","Candidate.candidate_city","Candidate.candidate_zip")));
		
	
		$this->autoRender = false;
        ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
		
		//create a file
		$filename = "export_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');


		// The column headings of your .csv file
		$header_row = array("candidate_name","candidate_email","candidate_address","candidate_city","candidate_zip");
		fputcsv($csv_file,$header_row,',','"');
	
		// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
		foreach($total_candidate as $result)
		{ 
			// Array indexes correspond to the field names in your db table(s)
		$row = array(
			
			$result['Candidate']['candidate_name'],
			$result['Candidate']['candidate_email'],
			$result['Candidate']['candidate_address'],
			$result['Candidate']['candidate_city'],
			$result['Candidate']['candidate_zip']
		);
		
		fputcsv($csv_file,$row,',','"');
	}
	
	fclose($csv_file);die;
	

	}
	
	function superadmin_exportFullCandidate($id = null ) {
		
		$total_candidate = $this->Registration->find('all',array('conditions'=>array('Registration.show_id'=>$id),'fields'=>array("Candidate.candidate_name","Candidate.candidate_email","Candidate.candidate_address","Candidate.candidate_city","Candidate.candidate_state","Candidate.candidate_phone","Candidate.candidate_zip","Candidate.candidate_fax","Registration.date_time","Registration.id")));
	
		$this->autoRender = false;
        ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
		
		//create a file
		$filename = "export_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');


		// The column headings of your .csv file
		$header_row = array("candidate_name","candidate_email","candidate_address","candidate_city","candidate_state","candidate_phone","candidate_zip","candidate_fax","id","date_time");
		fputcsv($csv_file,$header_row,',','"');
	
		// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
		foreach($total_candidate as $result)
		{ 
			// Array indexes correspond to the field names in your db table(s)
		$row = array(
			
			$result['Candidate']['candidate_name'],
			$result['Candidate']['candidate_email'],
			$result['Candidate']['candidate_address'],
			$result['Candidate']['candidate_city'],
			$result['Candidate']['candidate_state'],
			$result['Candidate']['candidate_phone'],
			$result['Candidate']['candidate_zip'],
			$result['Candidate']['candidate_fax'],
			$result['Registration']['id'],
			$result['Registration']['date_time'],
			
			);
		
		fputcsv($csv_file,$row,',','"');
	}
	
	fclose($csv_file);die;

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
		$this->Auth->loginRedirect = array('controller' => 'PreRegistrations', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');		
   	}
	
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
