<?php 
/**************************************************************************
 Coder  : Anil Agal  
 Object : Controller to handle admin role, add, edit and delete operation
**************************************************************************/ 
class RolesController extends AppController {
	var $name = 'Roles'; //Model name attached with this controller 
	var $helpers = array('Paginator'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	/*************************************************************************
	This function call by default when a controller is called 
	*************************************************************************/
	function index() {
		if($this->Session->check('Auth.Adminuser')){
			$this->redirect(array('controller'=>'roles','action' => "home"));
		}
		else {
			$this->Session->setFlash(__d('adminuser','You are not authorized to access this location.',true));
			$this->redirect(array('controller'=>'roles','action' => "login"));
		}
	}	
	/*********************************************************************
	This function call by default when a controller is called 
	Function will show list of all admin users
	********************************************************************/
	function superadmin_index() {
		$this->set('meta_title','User Group');
		$search = '';
		$argArr = array();
		$cond = '';		
	if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
		$this->Session->write('per_page_record',$this->params['pass'][0]);
	}		
		/* Search conditon for  text value   */
		if(!empty($this->data)) {
			$search = $this->data['Role']['search'];
			$this->Session->write('data_search',$this->data['Role']);
				if($this->Session->read('param_search')) {
					$this->Session->delete('param_search');
				}			
		}
		else if(isset($this->params['named']['search']) && $this->params['named']['search']) {
			 $this->Session->write('param_search',$this->params['named']);
				 if($this->Session->read('data_search')) {
					$this->Session->delete('data_search');
				}			 
			 
		}
		else if($this->Session->read('data_search')) {
			$search = $this->Session->read('data_search.search');
				if($this->Session->read('param_search')) {
					$this->Session->delete('param_search');
				}		
		}
		else if($this->Session->read('param_search')) {
			$search = $this->Session->read('param_search.search');
				 if($this->Session->read('data_search')) {
					$this->Session->delete('data_search');
				}		
		}
		if($search) {
			$argArr['search'] = $search;
		    $cond[]  = array('OR'=>array('Role.role_name LIKE'=>'%'.$search.'%'));
		}
		$this->set('search', $search); 
		$this->set('argArr', $argArr);
		/* End Search conditon for  text value   */
		$condition = $cond;
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		$this->paginate = array('limit' =>$record,'order' => array('Role.role_name' => 'ASC'));
		$data = $this->paginate('Role', $condition);
		$this->set('data', $data); 
	 }
	 /*********************************************************************
	 Function to save new admin user
	 **********************************************************************/
	 function superadmin_create() {
		$errors ='';
		
		
		
		$this->Role->set($this->request->data);
		
			if(!empty($this->data['Role']) && $this->data['SUBMIT']=='SUBMIT')  {
		
		
		if(!$this->Role->validates()) 
			{
				$errorsArr = $this->Role->validationErrors;	
				
			}
		
		
			
			if($errorsArr) {
			 //	$this->Session->setFlash($errors);
				$this->set('errors',$errorsArr);
				 $this->set('data',$this->data);
			}
			else 
			{ 
			$userpermissions='';
			 /*if(in_array($this->params['controller'].'/'.substr($this->params['action'],5),$userpermissions) || $this->Session->read('Auth.Adminuser.role_id')==1) {
				   $this->data['Role']['allowedfunctions']= $this->common->arrayToCsvString($this->data['Role']['allowedfunctions']);
				  }	*/			 	  	
				if($this->Role->save($this->data)) {
				$this->Session->write('popup','User Group has been created successfully.');
					$this->Session->setFlash('User Group has been created successfully.');  
					$this->redirect(array('controller'=>'roles','action' => "index/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	/********************************************************************
	Function to view amdin user detail 
	********************************************************************/ 
	function superadmin_view($id=NULL) {
		$this->set('meta_title','User Group Details');
		$this->id= (int)$id;
		if(!$this->id) {
			$this->Session->setFlash('Invalid admin user id.');
			$this->redirect(array('controller'=>'roles','action' => "index"));  
		}
		$this->set('data',$this->Role->read('',$id));
	}
	/******************************************************************
	Function to update admin user
	******************************************************************/
	function  superadmin_update($id=NULL) {
		 $this->set('meta_title','Edit User Group');
		 $errors ='';
		 if(isset($this->data['Role']['id'])) {
			 $this->id = (int)$this->data['Role']['id'];
			 $this->set('id',$this->id);
		 }
		 else {
		 	$this->id = (int)$id;
			$this->set('id',$this->id);
		 }	
		 if(!$this->id) {
		 	$this->Session->setFlash('Invalid User Group update id.');
		    $this->redirect(array('controller'=>'roles','action'=>'index'));
		 }
		 $this->Role->set($this->data);
		
	  	 if(!empty($this->data) && is_array($this->data)){
		 
			
		  
		  $this->Role->set($this->data);
		  
		$errorsArr='';
		  if(!$this->Role->validates()) 
			{
			
				$errorsArr = $this->Role->validationErrors;	
				
				
			}
			
		
 		   if($errorsArr) {
		   
		   $this->Session->setFlash($errors);
				
				 $this->set('data',$this->data);
				
			// $this->redirect(array('controller'=>'roles','action' =>"update",$this->id));
			}
			else { 
				  $this->request->data['Role']['id']	= $this->id;
				  if($this->request->data['Role']['id'] != 1) {
					 if(in_array($this->params['controller'].'/'.substr($this->params['action'],5),$userpermissions) || $this->Session->read('Auth.Adminuser.role_id')==1) {
					   $this->data['Role']['allowedfunctions']= $this->common->arrayToCsvString($this->data['Role']['allowedfunctions']);
					  }	
				 } 			  
				 // pr($this->data);
			  	  if($this->Role->save($this->data)) {
				  $this->Session->write('popup','User Group has been updated successfully.');
						$this->Session->setFlash('User Group has been updated successfully.');  
						$this->redirect(array('controller'=>'roles','action' => "index/message:success"));
				  }
				  else {
				    	$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'roles','action' => "update",$this->id));
				  }		
		 	}//end if not error
	 	}// end if of check data array
		 else {
		   $this->set('data',$this->Role->read('',$id));
		 }
	 } 
	  /* Function to delete admin */
	 function superadmin_delete($id=NULL) {
	   $this->id = (int)$id;
	   if($this->id==1) {
	     $this->Session->setFlash('You can\'t delete this User Group.');  
	     $this->redirect(array('controller'=>'roles','action' => "index"));
	   }
	   if(!$this->id) {
		 	$this->Session->setFlash('Invalid User Group delete id');
		    $this->redirect(array('controller'=>'roles','action'=>'index'));
	   }
	   //Get admins which are belongs to this role
	   $this->loadModel('Adminuser');
	   if($this->Adminuser->find('count',array('conditions'=>array('Adminuser.role_id'=>$this->id)))) {
	   		$this->Session->setFlash('Please first delete Users Profiles which are using this role.');
		    $this->redirect(array('controller'=>'roles','action'=>'index'));
	   }
	   if($this->Role->delete($this->id,false)) { //second param for casecade delete
	   $this->Session->write('popup','User Group has been deleted successfully.');
			$this->Session->setFlash('User Group has been deleted successfully.');  
			$this->redirect(array('controller'=>'roles','action' => "index/message:success")); 
		}
	  else {
	  		$this->Session->setFlash('Deletion problem, Please try again.');  
	      	$this->redirect(array('controller'=>'roles','action' => "index"));
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
		//$this->Auth->allow('login');
		//$this->Auth->loginAction = array('controller' => 'roles', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'roles', 'action' => 'home','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}//end class
?>