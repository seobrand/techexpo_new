<?php

class SettingsController extends AppController {
	var $name = 'Settings'; //Model name attached with this controller 
	var $helpers = array('Paginator'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	/*********************************************************************
	This function call by default when a controller is called 
	Function will show list of all settings
	********************************************************************/
	function superadmin_index() {
		$this->set('meta_title','Settings');
		$search = '';
		$argArr = array();
		$cond = '';		
	if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
		$this->Session->write('per_page_record',$this->params['pass'][0]);
	}		
		/* Search conditon for  text value   */
		if(!empty($this->data)) {
			$search = $this->request->data['Setting']['search'];
			$this->Session->write('data_search',$this->request->data['Setting']);
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
		    $cond[]  = array('OR'=>array('Setting.name LIKE'=>'%'.$search.'%'));
		}
		$this->set('search', $search); 
		$this->set('argArr', $argArr);
		/* End Search conditon for  text value   */
		$condition = $cond;
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		$this->paginate = array('limit' =>$record,'order' => array('Setting.name' => 'ASC'));
		$data = $this->paginate('Setting', $condition);
		$this->set('data', $data); 
	 }
	 /*********************************************************************
	 Function to create new setting
	 **********************************************************************/
	 function superadmin_create() {
		$errors ='';
		
		if(!empty($this->request->data['SUBMIT']) && is_array($this->request->data))  {
                        $this->Setting->set($this->request->data['Setting']);
		
		
			
			
			if(!$this->Setting->validates()) {
				$errors = $this->Setting->validationErrors;	
			}
			
			if($errors) {
			 
				$this->Set('errors',$errors);
				$this->Set('data',$this->data);
				
			}
			else {
			$this->data['Setting']['name'] = strtoupper($this->data['Setting']['name']);  	
				if($this->Setting->save($this->data)) {
				//define the setting in to file 'config/core.php'
					$this->superadmin_write();
					$this->Session->write('popup','Setting has been created successfully.');
					$this->Session->setFlash('Setting has been created successfully.');  
					$this->redirect(array('controller'=>'settings','action' => "index/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	/********************************************************************
	Function to view setting detail 
	********************************************************************/ 
	function superadmin_view($id=NULL) {
		$this->set('meta_title','Setting Detail View');
		$this->id= (int)$id;
		if(!$this->id) {
			$this->Session->setFlash('Invalid Setting id.');
			$this->redirect(array('controller'=>'settings','action' => "index"));  
		}
		$this->set('data',$this->Setting->read('',$this->id));
	}
	/******************************************************************
	Function to update Setting
	******************************************************************/
	function  superadmin_update($id=NULL) {
		 $this->set('meta_title','Setting Update');
		 $errors ='';
		 if(isset($this->data['Setting']['id'])) {
			 $this->id = (int)$this->data['Setting']['id'];
			 $this->set('id',$this->id);
		 }
		 else {
		 	$this->id = (int)$id;
			$this->set('id',$this->id);
		 }	
		 if(!$this->id) {
		 	$this->Session->setFlash('Invalid Setting update id.');
		    $this->redirect(array('controller'=>'settings','action'=>'index'));
		 }
		 
	  	 if(!empty($this->data['SUBMIT']) && is_array($this->data))   {
		 $this->Setting->set($this->request->data['Setting']);
			if(!$this->Setting->validates()) {
				$errors = $this->Setting->validationErrors;	
			}
			
 		   if($errors) {
			  $this->Set('errors',$errors);
			  $this->Set('data',$this->data);
			}
			else { 
				  $this->request->data['Setting']['id']	= $this->id;
				 // pr($this->data);
				 $this->request->data['Setting']['name'] = strtoupper($this->data['Setting']['name']); 
			  	  if($this->Setting->save($this->data)) {
				//define the setting in to file 'config/core.php'
				  		$this->superadmin_write();
						$this->Session->write('popup','Setting has been updated successfully.');
						$this->Session->setFlash('Setting has been updated successfully.');  
						$this->redirect(array('controller'=>'settings','action' => "index/message:success"));
				  }
				  else {
				    	$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'settings','action' => "update",$this->id));
				  }		
		 	}//end if not error
	 	}// end if of check data array
		 else {
		   $this->set('data',$this->Setting->read('',$this->id));
		 }
	 } 
	/******************************************************************
	Function to delete a setting
	******************************************************************/	 
	 function superadmin_delete($id=NULL) {
	   $this->id = (int)$id;
	   if($this->Setting->delete($this->id,false)) { //second param for casecade delete
		//define the setting in to file 'config/core.php'
	   		$this->superadmin_write();
			$this->Session->write('popup','Setting has been deleted successfully.');
			$this->Session->setFlash('Setting has been deleted successfully.');  
			$this->redirect(array('controller'=>'settings','action' => "index/message:success")); 
		}
	  else {
	  		$this->Session->setFlash('Deletion problem, Please try again.');  
	      	$this->redirect(array('controller'=>'settings','action' => "index"));
	  	}	
	 }
	/******************************************************************
	Function to write settings in file 'config/core.php'
	******************************************************************/	 
	 function superadmin_write() {
	 		$stringData = '<?php 
';
			$myFile = 'settings.php';
			$fh = fopen($myFile, 'w') or die("can't open file");
			$setting_data = $this->Setting->find('all');
				foreach($setting_data as $setting_data)
					{				
						$stringData .= "define('".$setting_data['Setting']['name']."', '".$setting_data['Setting']['value']."');
";}
				$stringData .= '
?>';	
			fwrite($fh, $stringData);
			fclose($fh);
	 }
	/******************************************************************
	This function is used to call before 
	******************************************************************/		 				 
	function beforeFilter() { 
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		//$this->Auth->allow('login');
		//$this->Auth->loginAction = array('controller' => 'ethnicities', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'settings', 'action' => 'home','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
   	}
	/******************************************************************
	 This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.
	******************************************************************/		
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}//end class
?>