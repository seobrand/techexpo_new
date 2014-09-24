<?php 
/**************************************************************************
 Coder  : Anil Agal  
 Object : Controller to handle admin login, add, edit and delete operation
**************************************************************************/ 
class CandidatesController extends AppController {
	var $name = 'Candidates'; //Model name attached with this controller 
	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	/*********************************************************************
	This function call by default when a controller is called 
	Function will show list of all admin users
	********************************************************************/
	function kcms_index() {	
	if($this->params['url']['url'] == 'kcms/candidates') {
		if($this->Session->read('param_search')) {
				$this->Session->delete('param_search');
			}
		if($this->Session->read('data_search')) {
				$this->Session->delete('data_search');
			}
	}				
	if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
		$this->Session->write('per_page_record',$this->params['pass'][0]);
	}
		$this->set('meta_title',' Candidates');
		$search = '';
		$act  = '';
		$active = '';
		$argArr = array();
		$cond = '';
		$job_type = '';		
		/* Search conditon for  text value   */
		if(isset($this->data)) {
			$search = $this->data['Candidate']['search'];
			$act = $this->data['Candidate']['act'];
			$this->Session->write('data_search',$this->data['Candidate']);
				if($this->Session->read('param_search')) {
					$this->Session->delete('param_search');
				}			
		}
		else if(isset($this->params['named']['search']) && $this->params['named']['search']) {
			 $search = $this->params['named']['search'];
			 $this->Session->write('param_search',$this->params['named']);
				 if($this->Session->read('data_search')) {
					$this->Session->delete('data_search');
				}		 
		}
		else if($this->Session->read('data_search')) {
			$search = $this->Session->read('data_search.search');
			$act =  $this->Session->read('data_search.act');
				if($this->Session->read('param_search')) {
					$this->Session->delete('param_search');
				}		
		}
		else if($this->Session->read('param_search')) {
			$search = $this->Session->read('param_search.search');
			$act =  $this->Session->read('param_search.act');
				 if($this->Session->read('data_search')) {
					$this->Session->delete('data_search');
				}		
		}		
		if(isset($this->params['named']['act']) && $this->params['named']['act']) {
			$act =  $this->params['named']['act'];			
		}
		if($search) {
			$argArr['search'] = $search;
			$argArr['act'] = $act;
		    switch($act) {
		    	case 'name' : 
			  		$cond[]  = array('OR'=>array('Candidate.full_name LIKE'=>'%'.$search.'%'));
			     	break;
				case 'postcode' : 
			  		$cond[]  = array('OR'=>array('Candidate.postcode LIKE'=>'%'.$search.'%'));
			     	break;	
			  	case 'email' : 
			  	 	$cond[]  = array('Candidate.email LIKE'=>'%'.$search.'%');
			     	break;
				case 'skill_sets' : 
			  	 	$cond[]  = array('Candidate.area_of_interests LIKE'=>'%'.$search.'%');
			     	break;		
			  	default :	 
		     		$cond[]  = array('OR'=>array('Candidate.full_name LIKE'=>'%'.$search.'%','Candidate.email LIKE'=>'%'.$search.'%','Candidate.postcode LIKE'=>'%'.$search.'%'));
			 }
		}
		$this->set('search', $search); 
		$this->set('active', $active); 
		$this->set('act', $act); 
		$this->set('argArr', $argArr);
		$this->set('job_type', $job_type);
		/* End Search conditon for  text value   */
		/* Search conditon for  Active  status */
		if(isset($this->data['Candidate']['active']) && $this->data['Candidate']['active']) {
			$active = $this->data['Candidate']['active'];
		}
		else if(isset($this->params['named']['active']) && $this->params['named']['active']) {
			$active = $this->params['named']['active'];
		}
		else {
			$active = ($this->Session->read('data_search.active')) ? $this->Session->read('data_search.active') : $this->Session->read('param_search.active');
		}
		if($active) {
		   	$this->set('active',$active);
		    $cond[]  = array('Candidate.active'=>$active);
		}
		/* End Search conditon for  Active  status */
		/* Jobtype conditon status */
		
		if(isset($this->data['Candidate']['job_type']) && $this->data['Candidate']['job_type']) {
			$job_type = $this->data['Candidate']['job_type'];
		}
		else if(isset($this->params['named']['job_type']) && $this->params['named']['job_type']) {
			$job_type = $this->params['named']['job_type'];
		}
		else {
			$job_type = ($this->Session->read('data_search.job_type')) ? $this->Session->read('data_search.job_type') : $this->Session->read('param_search.job_type');
		}
		if($job_type) {
		   	$this->set('job_type',$job_type);
		    $cond[]  = array("LOWER(Candidate.candidate_job_type) LIKE '%$job_type%'");
		}		
		//all active and inactive records for paging.
		$active_record = $this->Candidate->find('count',array('conditions'=>array('Candidate.active'=>'yes',$cond)));
		$inactive_record = $this->Candidate->find('count',array('conditions'=>array('Candidate.active'=>'no',$cond)));
		$this->set('active_record',$active_record);
		$this->set('inactive_record',$inactive_record);	
		
		/* End Search conditon for  jop_type status */
		$condition = $cond;
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		$this->paginate = array('limit' => $record,'order' => array('Candidate.modified' => 'DESC','Candidate.id' => 'DESC'));
		$data = $this->paginate('Candidate', $condition);		
		$this->set('data', $data);	
	 }
	 /*********************************************************************
	 Function to save new admin user
	 **********************************************************************/
	 function kcms_create() {
		$this->set('meta_title','Candidate Registration');
		//pr($this->Session->read('register1'));
		if(isset($this->data)) {
			$errors = $this->Candidate->validatesCandidateInfo($this->data);
			//Check file type
			if(!count($errors)) {
				if(isset($this->data['Candidate']['candidate_cv']['error']) && !$this->data['Candidate']['candidate_cv']['error']){
						$parameterArray = array();
						$parameterArray['picture'] = $this->data['Candidate']['candidate_cv'];
						$uploadedFileList = $this->common->uploadDocuments('documents/cv', $parameterArray);
						if(isset($uploadedFileList['errors']) && is_array($uploadedFileList['errors']) && count($uploadedFileList['errors'])) {
							$errors[] = $uploadedFileList['errors'][0];
							$this->data['Candidate']['candidate_cv'] = '';
						}
						else {
						  $uploadFileName = $uploadedFileList['urls'][0];
						  $this->data['Candidate']['candidate_cv'] = $uploadFileName;
						}	
				 }
				else {
					$this->data['Candidate']['candidate_cv'] = '';
				} 
			 }	
			 
			// exit;
			if(count($errors)) {
			  // $errors = $this->Candidate->invalidFields();
			  echo $this->Session->setFlash(implode('<br>', $errors));
			}
			else {
				$this->data['Candidate']['candidate_job_type'] = array_reverse($this->data['Candidate']['candidate_job_type']);
			    $this->data['Candidate']['candidate_job_type'] = implode('|-|',$this->data['Candidate']['candidate_job_type']);
				$this->data['Candidate']['candidate_location'] = implode('|-|',$this->data['Candidate']['candidate_location']);
				$this->data['Candidate']['area_of_interests']  = implode('|-|',$this->data['Candidate']['area_of_interests']);
				$this->data['Candidate']['user_type'] = 'candidate';
				$this->data['Candidate']['candidate_date_of_birth'] = str_replace('.','-',$this->data['Candidate']['candidate_date_of_birth']);
				$this->data['Candidate']['candidate_date_of_birth'] = str_replace('/','-',$this->data['Candidate']['candidate_date_of_birth']);				
				list($day,$month,$year) = explode('-',$this->data['Candidate']['candidate_date_of_birth']);
				$this->data['Candidate']['candidate_date_of_birth'] =  mktime(date('H'),date('i'),date('s'),$month,$day,$year);
				$this->data['Candidate']['password']	= $this->Auth->password($this->data['Candidate']['password1']);
				$this->data['Candidate']['postcode'] = strtoupper($this->data['Candidate']['postcode']);
				$this->data['Candidate']['orig_password']	= $this->data['Candidate']['password1'];
				if($this->Candidate->save($this->data)) {
				    $candiate_id = $this->Candidate->getLastInsertId();
					if(isset($this->data['Candidate']['candidate_cv']) && $this->data['Candidate']['candidate_cv']) {
						$ext = end(explode('.',$this->data['Candidate']['candidate_cv']));
						$newFileName = ucfirst($this->data['Candidate']['last_name']).'_'.Inflector::slug(ucfirst(substr($this->data['Candidate']['first_name'],0,1)).'_CV_'.$candiate_id, '_').'.'.$ext;
						if(rename(WWW_ROOT.'documents/cv/'.$this->data['Candidate']['candidate_cv'],WWW_ROOT.'documents/cv/'.$newFileName)) {
							$updateRecord['Candidate']['id'] = $candiate_id;
							$updateRecord['Candidate']['candidate_cv'] = $newFileName;
							$this->Candidate->save($updateRecord);
						}
					}	
					$this->Session->write('popup','New Candidate has been added successfully.');
				    $this->Session->setFlash('New Candidate has been added successfully.');
		 			$this->redirect(array('controller'=>"candidates",'action'=>"index/message:success")); 
				}
				else {
					$this->Session->setFlash('Data save problem,Please try again.');
				}	
			}
		}	
		//Get statics for the candidate registration form
		/* Title list */
		$this->loadModel('Title');
		$fields = array('Title.title_name','Title.title_name');
		$condition = array('Title.active'=>'yes');
		$orderby   = array('Title.ordered','Title.title_name');
		$optionTitles = $this->Title->find('list',array('fields'=>$fields,'conditions'=>$condition,'order'=>$orderby));
		$this->set('optionTitles',$optionTitles);
		/* Salary bracket list */
		$this->loadModel('Salary');
		$fields = array('Salary.salary','Salary.salary');
		$condition = array('Salary.active'=>'yes');
		$orderby   = array('Salary.ordered','Salary.salary');
		$optionSalary = $this->Salary->find('list',array('fields'=>$fields,'conditions'=>$condition,'order'=>$orderby));
		$this->set('optionSalary',$optionSalary);
		/* Ethenicities list */
		$this->loadModel('Ethnicity');
		$fields = array('Ethnicity.ethnicity','Ethnicity.ethnicity');
		$condition = array('Ethnicity.active'=>'yes');
		$orderby   = array('Ethnicity.ordered','Ethnicity.ethnicity');
		$optionEthnicities = $this->Ethnicity->find('list',array('fields'=>$fields,'conditions'=>$condition,'order'=>$orderby));
		$this->set('optionEthnicities',$optionEthnicities);
		/* Job types list */
		$this->loadModel('Jobtype');
		$fields = array('Jobtype.job_types','Jobtype.job_types');
		$condition = array('Jobtype.active'=>'yes');
		$orderby   = array('Jobtype.ordered','Jobtype.job_types');
		$optionJobtypes = $this->Jobtype->find('list',array('fields'=>$fields,'conditions'=>$condition,'order'=>$orderby));
		$this->set('optionJobtypes',$optionJobtypes);
		/* Job location list */
		$this->loadModel('Joblocation');
		$condition = array('Joblocation.active'=>'yes');
		$orderby   = array('Joblocation.ordered','Joblocation.job_locations');
		$optionJoblocations = $this->Joblocation->find('threaded',array('conditions'=>$condition,'order'=>$orderby));
		$this->set('optionJoblocations',$optionJoblocations);
		/* Job location list */
		$this->loadModel('Areaofinterest');
		$condition = array('Areaofinterest.active'=>'yes');
		$orderby   = array('Areaofinterest.ordered','Areaofinterest.area_of_interests');
		$optionAreaofinterest = $this->Areaofinterest->find('threaded',array('conditions'=>$condition,'order'=>$orderby));
		$this->set('optionAreaofinterest',$optionAreaofinterest);
			   
	} 
	/********************************************************************
	Function to view amdin user detail 
	********************************************************************/ 
	function kcms_view($id=NULL) {
		$this->set('meta_title','Candidate Details');
		$this->id= (int)$id;
		if(!$this->id) {
			$this->Session->setFlash('Invalid candidate id.');
			$this->redirect(array('controller'=>'candidates','action' => "index"));  
		}
		$this->set('data',$this->Candidate->read());
	}
	/********************************************************************
	 The AuthComponent provides the needed functionality for login . 
	 ******************************************************************/
    function kcms_login() {
		if($this->Session->check('Auth.Adminuser')){
			$this->redirect(array('controller'=>'candidates','action' => "home"));
		}
		else{
			 if($this->data){
				 $this->Session->setFlash(__d('Candidate','Login failed. Invalid Email or Password.',true));
			 }
		}
    }
    /* Destroy all current sessions for a perticular SuperAdmins and redirect to login page automatically */
	function kcms_logout() {
   		$this->redirect($this->Auth->logout());
    }
	/* Dashboard of admin where we shows summary. */
	function kcms_home() {
	  
	}
	 /* Function to delete candidate */
	 function kcms_delete($id=NULL) {
	   $this->id = (int)$id;
	   
	   $this->LoadModel('Savetimesheet');
	   $Savetimesheet = $this->Savetimesheet->find('all',array('conditions'=>array('Savetimesheet.user_id'=>$this->id)));	   
	   
	   $this->LoadModel('Usertimesheet');
	   $user_timesheet = $this->Usertimesheet->find('all',array('conditions'=>array('Usertimesheet.user_id'=>$this->id,'OR'=>array('Usertimesheet.client_status !='=>'agreed','Usertimesheet.kings_status !='=>'agreed'))));
	   
	if(is_array($Savetimesheet) && count($Savetimesheet)>0) {
			
			$this->Session->setFlash('Timesheet require to be Submitted.');  
	      	$this->redirect(array('controller'=>'candidates','action' => "index"));
	} 
		else if(is_array($user_timesheet) && count($user_timesheet)>0) {
			
			$this->Session->setFlash('Timesheets require Approval.');  
	      	$this->redirect(array('controller'=>'candidates','action' => "index"));
	
	}	else {
	   $candidate_cv = $this->Candidate->field('Candidate.candidate_cv',array('Candidate.id'=>$this->id));
	   if($this->Candidate->delete($this->id,false)) { //second param for casecade delete
	        if($candidate_cv && file_exists(WWW_ROOT.'documents/cv/'.$candidate_cv)) {
			  @unlink(WWW_ROOT.'documents/cv/'.$candidate_cv);
			}
			$this->Session->write('popup','Candidate has been deleted successfully.');
			$this->Session->setFlash('Candidate has been deleted successfully.');  
			$this->redirect(array('controller'=>'candidates','action' => "index/message:success")); 
		}
	  else {
	  		$this->Session->setFlash('Deletion problem, Please try again.');  
	      	$this->redirect(array('controller'=>'candidates','action' => "index"));
	  	}
	}
}

	/* This function is checking username and pasword in database and if true then redirect to home page */
	function beforeFilter() { 
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		$this->Auth->allow('login');
		//$this->Auth->loginAction = array('controller' => 'candidates', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'candidates', 'action' => 'home','kcms'=>true);
		$this->Auth->userScope = array('Candidate.active' => 'yes');
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
	
	 /*********************************************************************
	 Function to save new admin user
	 **********************************************************************/
	 function kcms_update() {
	 
	 if(isset($this->params['named']['updateId']) && isset($this->params['named']['status']) && (int)$this->params['named']['updateId'] && $this->params['named']['updateId'] ) {
		    $this->data['Candidate']['id'] = (int)$this->params['named']['updateId'];
			$this->data['Candidate']['candidate_status'] = $this->params['named']['status'];
			if($this->Candidate->save($this->data)) {
			$this->Session->write('popup','Candidate status has beeen changed successfully.');
			    $this->Session->setFlash('Candidate status has beeen changed successfully.');
		 		$this->redirect(array('controller'=>"candidates",'action'=>"index/message:success")); 
			}
			else {
				$this->Session->setFlash('Status change problem,Please try again.');
			}	
			
		}
	 
	 
	 
	 if(isset($this->params['pass'][0]) && $this->params['pass'][0]) {
	 	$id = $this->params['pass'][0];
	 }
	 else {
	 	$id = $this->data['Candidate']['id'];
	 }
		$this->set('meta_title','Edit Candidate');
		$data = $this->Candidate->find('first',array('conditions'=>array('Candidate.id'=>$id)));
		 $this->set('data',$data);  
		if(isset($this->data)) {
			$errors = $this->Candidate->validatesCandidateEditInfo($this->data);
			//Check file type		 
			// exit;
			if(count($errors)) {
			  // $errors = $this->Candidate->invalidFields();
			  echo $this->Session->setFlash(implode('<br>', $errors));
			}
			else {
			if(isset($this->data['Candidate']['candidate_cv']['error']) && !$this->data['Candidate']['candidate_cv']['error']){
					$parameterArray = array();
					$parameterArray['picture'] = $this->data['Candidate']['candidate_cv'];
					$uploadedFileList = $this->common->uploadDocuments('documents/cv', $parameterArray);
					if(isset($uploadedFileList['errors']) && is_array($uploadedFileList['errors']) && count($uploadedFileList['errors'])) {
						$errors .= '<br />'.$uploadedFileList['errors'][0];
						$this->data['Candidate']['candidate_cv'] = '';
					}
					else {
					  $uploadFileName = $uploadedFileList['urls'][0];
					  $this->data['Candidate']['candidate_cv'] = $uploadFileName;
					}	
			 }
			 else {
			 		$this->data['Candidate']['candidate_cv'] = $this->data['Candidate']['oldfilename'];
			 }	
				$this->data['Candidate']['candidate_job_type'] = array_reverse($this->data['Candidate']['candidate_job_type']);			 
			    $this->data['Candidate']['candidate_job_type'] = implode('|-|',$this->data['Candidate']['candidate_job_type']);
				$this->data['Candidate']['candidate_location'] = implode('|-|',$this->data['Candidate']['candidate_location']);
				$this->data['Candidate']['area_of_interests']  = implode('|-|',$this->data['Candidate']['area_of_interests']);
				$this->data['Candidate']['user_type'] = 'candidate';
				$this->data['Candidate']['candidate_date_of_birth'] = str_replace('.','-',$this->data['Candidate']['candidate_date_of_birth']);
				$this->data['Candidate']['candidate_date_of_birth'] = str_replace('/','-',$this->data['Candidate']['candidate_date_of_birth']);					
				list($day,$month,$year) = explode('-',$this->data['Candidate']['candidate_date_of_birth']);
				$this->data['Candidate']['candidate_date_of_birth'] =  mktime(date('H'),date('i'),date('s'),$month,$day,$year);
				$this->data['Candidate']['postcode'] = strtoupper($this->data['Candidate']['postcode']);				
				$this->data['Candidate']['password']	= $this->Auth->password($this->data['Candidate']['password1']);
				$this->data['Candidate']['orig_password']	= $this->data['Candidate']['password1'];				
				if($this->Candidate->save($this->data)) {			
			 	if($this->data['Candidate']['candidate_cv'] == $uploadFileName)  {														
					$candiate_id = $this->data['Candidate']['id'];
					if(isset($this->data['Candidate']['candidate_cv']) && $this->data['Candidate']['candidate_cv']) {
						$ext = end(explode('.',$this->data['Candidate']['candidate_cv']));
						$newFileName = ucfirst($this->data['Candidate']['last_name']).'_'.Inflector::slug(ucfirst(substr($this->data['Candidate']['first_name'],0,1)).'_CV_'.$candiate_id, '_').'.'.$ext;//Inflector::slug(ucfirst($this->data['Candidate']['last_name']).'_'.ucfirst(substr($this->data['Candidate']['first_name'],0,1)).'_CV_'.$candiate_id, '_').'.'.$ext;
						if(rename(WWW_ROOT.'documents/cv/'.$this->data['Candidate']['candidate_cv'],WWW_ROOT.'documents/cv/'.$newFileName)) {
						$updateRecord['Candidate']['id'] = $candiate_id;
						$updateRecord['Candidate']['candidate_cv'] = $newFileName;
						$this->Candidate->save($updateRecord);
					  }
				   }
				}
				$this->Session->write('popup','Candidate Profile has been updated successfully.');
				$this->Session->setFlash('Candidate Profile has been updated successfully.');
		 		$this->redirect(array('controller'=>"candidates",'action'=>"index/message:success"));				
				}
				else {
					$this->Session->setFlash('Data save problem,Please try again.');
				}	
			}
		}	
		//Get statics for the candidate registration form
		/* Title list */
		$this->loadModel('Title');
		$fields = array('Title.title_name','Title.title_name');
		$condition = array('Title.active'=>'yes');
		$orderby   = array('Title.ordered','Title.title_name');
		$optionTitles = $this->Title->find('list',array('fields'=>$fields,'conditions'=>$condition,'order'=>$orderby));
		$this->set('optionTitles',$optionTitles);
		/* Salary bracket list */
		$this->loadModel('Salary');
		$fields = array('Salary.salary','Salary.salary');
		$condition = array('Salary.active'=>'yes');
		$orderby   = array('Salary.ordered','Salary.salary');
		$optionSalary = $this->Salary->find('list',array('fields'=>$fields,'conditions'=>$condition,'order'=>$orderby));
		$this->set('optionSalary',$optionSalary);
		/* Ethenicities list */
		$this->loadModel('Ethnicity');
		$fields = array('Ethnicity.ethnicity','Ethnicity.ethnicity');
		$condition = array('Ethnicity.active'=>'yes');
		$orderby   = array('Ethnicity.ordered','Ethnicity.ethnicity');
		$optionEthnicities = $this->Ethnicity->find('list',array('fields'=>$fields,'conditions'=>$condition,'order'=>$orderby));
		$this->set('optionEthnicities',$optionEthnicities);
		/* Job types list */
		$this->loadModel('Jobtype');
		$fields = array('Jobtype.job_types','Jobtype.job_types');
		$condition = array('Jobtype.active'=>'yes');
		$orderby   = array('Jobtype.ordered','Jobtype.job_types');
		$optionJobtypes = $this->Jobtype->find('list',array('fields'=>$fields,'conditions'=>$condition,'order'=>$orderby));
		$this->set('optionJobtypes',$optionJobtypes);
		/* Job location list */
		$this->loadModel('Joblocation');
		$condition = array('Joblocation.active'=>'yes');
		$orderby   = array('Joblocation.ordered','Joblocation.job_locations');
		$optionJoblocations = $this->Joblocation->find('threaded',array('conditions'=>$condition,'order'=>$orderby));
		$this->set('optionJoblocations',$optionJoblocations);
		/* Job location list */
		$this->loadModel('Areaofinterest');
		$condition = array('Areaofinterest.active'=>'yes');
		$orderby   = array('Areaofinterest.ordered','Areaofinterest.area_of_interests');
		$optionAreaofinterest = $this->Areaofinterest->find('threaded',array('conditions'=>$condition,'order'=>$orderby));
		$this->set('optionAreaofinterest',$optionAreaofinterest);
			   
	}	
}//end class
?>