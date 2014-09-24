<?php 
/**************************************************************************
 Coder  : Keshav sharma  
 Object : Controller to handle admin login, add, edit and delete operation
**************************************************************************/ 
class AdminclientsController extends AppController {
	var $name = 'Adminclients'; //Model name attached with this controller 
	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	/*********************************************************************
	This function call by default when a controller is called 
	Function will show list of all admin users
	********************************************************************/
	function superadmin_index() {	
	
	if($this->request->url == 'superadmin/adminclients') {
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
		$this->set('meta_title','Clients');
		$search = '';
		$act  = '';
		$active = '';
		$argArr = array();
		$cond = '';
		$job_type = '';		
		/* Search conditon for  text value   */
		if(isset($this->requset->data)) {
			$search = $this->requset->data['Adminclient']['search'];
			$act = $this->requset->data['Adminclient']['act'];
			$this->Session->write('data_search',$this->request->data['Adminclient']);
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
			  		$cond[]  = array('OR'=>array('Adminclient.full_name LIKE'=>'%'.$search.'%'));
			     	break;
				case 'company_name' : 
			  		$cond[]  = array('OR'=>array('Adminclient.company_name LIKE'=>'%'.$search.'%'));
			     	break;	
			  	case 'email' : 
			  	 	$cond[]  = array('Adminclient.email LIKE'=>'%'.$search.'%');
			     	break;	
			  	default :	 
		     		$cond[]  = array('OR'=>array('Adminclient.full_name LIKE'=>'%'.$search.'%','Adminclient.email LIKE'=>'%'.$search.'%','Adminclient.company_name LIKE'=>'%'.$search.'%'));
			 }
		}
		$this->set('search', $search); 
		$this->set('active', $active); 
		$this->set('act', $act); 
		$this->set('argArr', $argArr);
		$this->set('job_type', $job_type);
		/* End Search conditon for  text value   */
		/* Search conditon for  Active  status */
		if(isset($this->request->data['Adminclient']['active']) && $this->request->data['Adminclient']['active']) {
			$active = $this->request->data['Adminclient']['active'];
		}
		else if(isset($this->params['named']['active']) && $this->params['named']['active']) {
			$active = $this->params['named']['active'];
		}
		else {
			$active = ($this->Session->read('data_search.active')) ? $this->Session->read('data_search.active') : $this->Session->read('param_search.active');
		}
		if($active) {
		   	$this->set('active',$active);
		    $cond[]  = array('Adminclient.active'=>$active);
		}
		/* End Search conditon for  Active  status */
		/* Jobtype conditon status */
		
		if(isset($this->request->data['Adminclient']['job_type']) && $this->request->data['Adminclient']['job_type']) {
			$job_type = $this->request->data['Adminclient']['job_type'];
		}
		else if(isset($this->params['named']['job_type']) && $this->params['named']['job_type']) {
			$job_type = $this->params['named']['job_type'];
		}
		else {
			$job_type = ($this->Session->read('data_search.job_type')) ? $this->Session->read('data_search.job_type') : $this->Session->read('param_search.job_type');
		}
		if($job_type) {
		   	$this->set('job_type',$job_type);
		    $cond[]  = array("LOWER(Adminclient.candidate_job_type) LIKE '%$job_type%'");
		}		
		//all active and inactive records for paging.
		$active_record = $this->Adminclient->find('count',array('conditions'=>array('Adminclient.active'=>'yes',$cond)));
		$inactive_record = $this->Adminclient->find('count',array('conditions'=>array('Adminclient.active'=>'no',$cond)));
		$this->set('active_record',$active_record);
		$this->set('inactive_record',$inactive_record);	
		
		/* End Search conditon for  jop_type status */
		$condition = $cond;
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		$this->paginate = array('limit' => $record,'order' => array('Adminclient.full_name' => 'ASC'));
		$data = $this->paginate('Adminclient', $condition);		
		$this->set('data', $data);	
	 }
	 /*********************************************************************
	 Function to save new admin user
	 **********************************************************************/
	 function superadmin_create() {
		$this->set('meta_title',' Client Registration');
		//pr($this->Session->read('register1'));
		if(!empty($this->request->data['SUBMIT'])) {
			$errors = $this->Adminclient->validatesAdminclientInfo($this->request->data);
			if(count($errors)) {
			  // $errors = $this->Adminclient->invalidFields();
			  $errors=implode('<br>', $errors);
			  $this->Session->setFlash($errors);
			}
			else {
				$this->request->data['Adminclient']['area_of_interests']  = implode('|-|',$this->request->data['Adminclient']['area_of_interests']);
				$this->request->data['Adminclient']['orig_password']	= $this->request->data['Adminclient']['password1'];
				$this->request->data['Adminclient']['password']		= $this->Auth->password($this->request->data['Adminclient']['password1']);
				if($this->Adminclient->save($this->request->data)) {
						$this->Session->write('popup','New Client has been added successfully.');					
				    $this->Session->setFlash('New Client has been added successfully.');
		 			$this->redirect(array('controller'=>"adminclients",'action'=>"index/message:success")); 
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
		/* Area of Interest list */
		$this->loadModel('Areaofinterest');
		$condition = array('Areaofinterest.active'=>'yes');
		$orderby   = array('Areaofinterest.ordered','Areaofinterest.area_of_interests');
		$optionAreaofinterest = $this->Areaofinterest->find('threaded',array('conditions'=>$condition,'order'=>$orderby));
		$this->set('optionAreaofinterest',$optionAreaofinterest);			   
	} 
	/********************************************************************
	Function to view amdin user detail 
	********************************************************************/ 
	function superadmin_view($id=NULL) {
		$this->set('meta_title','Client Details View');
		$this->id= (int)$id;
		if(!$this->id) {
			$this->Session->setFlash('Invalid Client id.');
			$this->redirect(array('controller'=>'adminclients','action' => "index"));  
		}
		$this->set('data',$this->Adminclient->read('',$id));
	}
	 /* Function to delete candidate */
	 function superadmin_delete($id=NULL) {
	   $this->id = (int)$id;
	   	
	  $company_name = $this->Adminclient->find('first',array('fields'=>array('Adminclient.company_name'),'conditions'=>array('Adminclient.id'=>$id)));  
	  $c_name = $company_name['Adminclient']['company_name'];
	   $this->LoadModel('Usertimesheet');
	   $client_timesheet = $this->Usertimesheet->find('all',array('conditions'=>array('Usertimesheet.company_name'=>$c_name,'OR'=>array('Usertimesheet.client_status !='=>'agreed','Usertimesheet.kings_status !='=>'agreed'))));
		if(is_array($client_timesheet) && count($client_timesheet)>0) {			
			$this->Session->setFlash('Timesheets require Approval.');  
                        $this->redirect(array('controller'=>'adminclients','action' => "index"));	
                }else {
	   if($this->Adminclient->delete($this->id,false)) {
	   		$this->Session->write('popup','Client has been deleted successfully');	
			$this->Session->setFlash('Client has been deleted successfully.');  
			$this->redirect(array('controller'=>'adminclients','action' => "index/message:success")); 
		}
	  else {
                        $this->Session->setFlash('Deletion problem, Please try again.');  
                        $this->redirect(array('controller'=>'adminclients','action' => "index"));
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
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','superadmin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'adminusers', 'action' => 'home','superadmin'=>true);
		$this->Auth->userScope = array('Adminclient.active' => 'yes');
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
	 function superadmin_update() {	 
	 if(isset($this->params['pass'][0]) && $this->params['pass'][0]) {
	 	$id = $this->params['pass'][0];
	 }
	 else {
	 	$id = $this->request->data['Adminclient']['id'];
	 }
		$this->set('meta_title','Client edit');
		                 
		if(!empty($this->request->data)) {
			$errors = $this->Adminclient->validatesAdminclientEditInfo($this->request->data);
			//Check file type		 
			// exit;
			if(count($errors)) {
			  // $errors = $this->Adminclient->invalidFields();
			   $this->Session->setFlash(implode('<br>', $errors));
			 
			$this->request->data['Adminclient']['orig_password']=$this->request->data['Adminclient']['password1'];
			
			
			    $this->set('data',$this->data); 
			  
			}
			else {	
				$this->request->data['Adminclient']['area_of_interests']  = implode('|-|',$this->request->data['Adminclient']['area_of_interests']);
				$this->request->data['Adminclient']['postcode'] = strtoupper($this->request->data['Adminclient']['postcode']);
				$this->request->data['Adminclient']['orig_password']	= $this->request->data['Adminclient']['password1'];
				$this->request->data['Adminclient']['password']		= $this->Auth->password($this->request->data['Adminclient']['password1']);				
				if($this->Adminclient->save($this->request->data)) {
					$this->Session->write('popup','Client Profile has been updated successfully.');	
                                        $this->Session->setFlash('Client Profile has been updated successfully.');
                                        $this->redirect(array('controller'=>"adminclients",'action'=>"index/message:success"));				
				}
				else {
					$this->Session->setFlash('Data save problem,Please try again.');
				}	
			}
		}else{
                    $data = $this->Adminclient->find('first',array('conditions'=>array('Adminclient.id'=>$id)));
                    $this->set('data',$data); 
                }	
		//Get statics for the candidate registration form
		/* Title list */
		$this->loadModel('Title');
		$fields = array('Title.title_name','Title.title_name');
		$condition = array('Title.active'=>'yes');
		$orderby   = array('Title.ordered','Title.title_name');
		$optionTitles = $this->Title->find('list',array('fields'=>$fields,'conditions'=>$condition,'order'=>$orderby));
		$this->set('optionTitles',$optionTitles);
		/* Job location list */
		$this->loadModel('Areaofinterest');
		$condition = array('Areaofinterest.active'=>'yes');
		$orderby   = array('Areaofinterest.ordered','Areaofinterest.area_of_interests');
		$optionAreaofinterest = $this->Areaofinterest->find('threaded',array('conditions'=>$condition,'order'=>$orderby));
		$this->set('optionAreaofinterest',$optionAreaofinterest);
			   
	}	
        
         public function isAuthorized($user) {
            // Admin can access every action
            if (isset($user['role']) && $user['role'] === 'admin') {
                return true;
            }

            // Default deny
            return false;
        }
}//end class
?>