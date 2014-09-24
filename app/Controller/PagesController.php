<?php 
/******************************************************************************************
 Coder  : Anil Agal  
 Object : Controller to handle pages like contents and documents  operations - view , add, edit and delete
******************************************************************************************/ 
class PagesController extends AppController {
	var $name = 'Pages'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	/*********************************************************************
	This function call by default when a controller is called 
	Function will show list of all pages- docs and content pages
	********************************************************************/
	function superadmin_index() {

	/*if($this->params['url']['url'] == 'superadmin/pages') {
		if($this->Session->read('param_search')) {
				$this->Session->delete('param_search');
			}
		if($this->Session->read('data_search')) {
				$this->Session->delete('data_search');
			}
	}	*/
		$this->set('meta_title','All pages');
		$search = '';
		$act  = '';
		$active = '';
		$page_type = '';
		$argArr = array();
		$cond = '';		
	if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
		$this->Session->write('per_page_record',$this->params['pass'][0]);
	}		
		/* Search conditon for  text value   */
		if(!empty($this->request->data)) {
			$search = $this->request->data['Page']['search'];
			$act = ($this->request->data['Page']['act']) ? $this->request->data['Page']['act'] : '';
			$this->Session->write('data_search',$this->request->data['Page']);
				if($this->Session->read('param_search')) {
					$this->Session->delete('param_search');
				}			
		}
		else if(isset($this->params['named']['search']) && $this->params['named']['search']) {
			 $search = $this->params['named']['search'];
			 $act =  ($this->params['named']['act']) ? $this->params['named']['act'] : '';
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
				
		if($search) {
			$argArr['search'] = $search;
			$argArr['act'] = $act;
		    switch($act) {
		    	case 'title' : 
			  		$cond[]  = array('Page.title LIKE'=>'%'.$search.'%');
			     	break;
			  	case 'content' : 
			  	 	$cond[]  = array('Page.content LIKE'=>'%'.$search.'%');
			     	break;	
				case 'doc_name' : 
			  	 	$cond[]  = array('Page.doc_name LIKE'=>'%'.$search.'%');
			     	break;	
			  	default :	 
		     		$cond[]  = array('OR'=>array('Page.title LIKE'=>'%'.$search.'%','Page.content LIKE'=>'%'.$search.'%','Page.doc_name LIKE'=>'%'.$search.'%'));
			 }
		}
		/* End Search conditon for  text value   */
		/* Search conditon for  Active  status */
		if(isset($this->request->data['Page']['active']) && $this->request->data['Page']['active']) {
			$active = $this->request->data['Page']['active'];
		}
		else if(isset($this->params['named']['active']) && $this->params['named']['active']) {
			$active = $this->params['named']['active'];
		}
		else {
			$active = ($this->Session->read('data_search.active')) ? $this->Session->read('data_search.active') : $this->Session->read('param_search.active');
		}		
		if($active) {
		    $cond[]  = array('Page.active'=>$active);
		}
		/* Search conditon for  pages page_type */
		if(isset($this->request->data['Page']['page_type']) && $this->request->data['Page']['page_type']) {
			$page_type = $this->request->data['Page']['page_type'];
		}
		else if(isset($this->params['named']['page_type']) && $this->params['named']['page_type']) {
			$page_type = $this->params['named']['page_type'];
		}
		else {
			$page_type = ($this->Session->read('data_search.page_type')) ? $this->Session->read('data_search.page_type') : $this->Session->read('param_search.page_type');
		}		
		if($page_type) {
		    $cond[]  = array('Page.page_type'=>$page_type);
		}
		//all active and inactive records for paging.
		$active_record = $this->Page->find('count',array('conditions'=>array('Page.active'=>'yes',$cond)));
		$inactive_record = $this->Page->find('count',array('conditions'=>array('Page.active'=>'no',$cond)));
		$this->set('active_record',$active_record);
		$this->set('inactive_record',$inactive_record);			
		/* End Search conditon for  pages page_type */
		$condition = $cond;
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		$this->paginate = array('limit' => $record,'order' => array('Page.title' => 'asc'));
		
		$data = $this->paginate('Page',$condition);
		$this->set('data', $data); 
		$this->set('search', $search); 
		$this->set('page_type', $page_type); 
		$this->set('active', $active); 
		$this->set('act', $act); 
		$this->set('argArr', $argArr);

	 }
	 /*********************************************************************
	 Function to create new page
	 **********************************************************************/
	function superadmin_create() {
		$errors ='';
		$errorsArr ='';
		if(!empty($this->request->data['SUBMIT']) && is_array($this->request->data))  {
			if($this->request->data['Page']['page_type']=='content') {
				unset($this->request->data['Page']['doc_name']);
			}
			else {
				unset($this->request->data['Page']['content']);
			}	
			
			$this->Page->set($this->request->data['Page']);
			if(!$this->Page->validates()) {
				$errorsArr = $this->Page->validationErrors;	
				$errors = @implode('<br>', $errorsArr);
			}
			//pr($this->request->data);
			//upload document code
			if(isset($this->request->data['Page']['doc_name']['error']) && !$this->request->data['Page']['doc_name']['error']){
					$parameterArray = array();
					$parameterArray['picture'] = $this->request->data['Page']['doc_name'];
					$uploadedFileList = $this->common->uploadDocuments('documents', $parameterArray);
					if(isset($uploadedFileList['errors']) && is_array($uploadedFileList['errors']) && count($uploadedFileList['errors'])) {
						$errors .= '<br />'.$uploadedFileList['errors'][0];
						$this->request->data['Page']['doc_name'] = '';
					}
					else {
					  $uploadFileName = $uploadedFileList['urls'][0];
					  $this->request->data['Page']['doc_name'] = $uploadFileName;
					}	
			 }
			//end upload document code
			//making alias start
			$alias = $this->common->makeAlias($this->request->data['Page']['alias']);
			if(!$alias) {
				$alias = $this->common->makeAlias($this->request->data['Page']['title']);
			}
			$i = 1;
			$newalias = $alias;
			while($this->checkAliasExist($newalias)) {
				$newalias = $alias.'-'.$i;
				$i++;
			}
			$this->request->data['Page']['alias'] = $newalias;	
			//making alias start   
			if($errorsArr) {
			
			 	
				$this->set('errors',$errorsArr);
				
				if(isset($this->request->data['Page']['doc_name']) && file_exists(WWW_ROOT.'documents/'.$this->request->data['Page']['doc_name'])) {
				   unlink(WWW_ROOT.'documents/'.$this->request->data['Page']['doc_name']);
				}
			}
			else {  
				if($this->request->data['Page']['page_type']=='document') {
					$this->request->data['Page']['content'] 			= '';
					$this->request->data['Page']['meta_title'] 		= '';
					$this->request->data['Page']['meta_keyword'] 	= '';
					$this->request->data['Page']['meta_description'] = '';
				}
				else if($this->request->data['Page']['page_type']=='content') {
					$this->request->data['Page']['doc_name'] 		= '';
				}
				//pr($this->request->data);	
				if($this->Page->save($this->request->data)) {
				$this->Session->write('popup','Page created successfully.');
					$this->Session->setFlash('Page created successfully.');  
					$this->redirect(array('controller'=>'pages','action' => "index/message:success"));
				}	
				else {
					if($this->request->data['Page']['doc_name'] && file_exists(WWW_ROOT.'documents/'.$this->request->data['Page']['doc_name'])) {
				   		unlink(WWW_ROOT.'documents/'.$this->request->data['Page']['doc_name']);
					}
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	/*********************************************************************************************
	Function to view page detail 
	*********************************************************************************************/ 
	function superadmin_view($id=NULL) {
		$this->set('meta_title','Page Detail View');
		$this->id= (int)$id;
		if(!$this->id) {
			$this->Session->setFlash('Invalid page id.');
			$this->redirect(array('controller'=>'pages','action' => "index"));  
		}
		$this->set('data',$this->Page->read('',$id));
	}
	/*******************************************************************************************
	Function to update page
	*******************************************************************************************/
	function  superadmin_update($id=null) {
		 $this->set('meta_title','Update page');
		 $errors ='';
		 if(isset($this->request->data['Page']['id'])) {
			 $this->id = (int)$this->request->data['Page']['id'];
			 $this->set('id',$this->id);
		 }
		 else {
		 	$this->id = (int)$id;
			$this->set('id',$this->id);
		 }	
		 if(!$this->id) {
		 	$this->Session->setFlash('Invalid page id.');
		    $this->redirect(array('controller'=>'pages','action'=>'index'));
		 }
		 
		$errors ='';
		
		if(!empty($this->request->data['SUBMIT']))  {
			if($this->request->data['Page']['page_type']=='content') {
				unset($this->request->data['Page']['doc_name']);
			}
			else {
				unset($this->request->data['Page']['content']);
			}	
			$this->Page->set($this->request->data['Page']);
			$errorsArr='';
			if(!$this->Page->validates()) {
		
				$errorsArr = $this->Page->validationErrors;	
				
			
			}
			//pr($this->request->data);
			//upload document code
		
			if(isset($this->request->data['Page']['doc_name']['error']) && !$this->request->data['Page']['doc_name']['error']){
					$parameterArray = array();
					$parameterArray['picture'] = $this->request->data['Page']['doc_name'];
					$uploadedFileList = $this->common->uploadDocuments('documents', $parameterArray);
					if(isset($uploadedFileList['errors']) && is_array($uploadedFileList['errors']) && count($uploadedFileList['errors'])) {
						$errors .= '<br />'.$uploadedFileList['errors'][0];
						$this->request->data['Page']['doc_name'] = '';
					}
					else {
					  $uploadFileName = $uploadedFileList['urls'][0];
					  $this->request->data['Page']['doc_name'] = $uploadFileName;
					}	
			 }
			 else if(isset($this->request->data['Page']['doc_name']['error']) && $this->request->data['Page']['doc_name']['error']) {
			 		$this->request->data['Page']['doc_name'] = $this->request->data['Page']['oldfilename'];
			 }
			//end upload document code
			//making alias start
			$alias = $this->common->makeAlias($this->request->data['Page']['alias']);
			if(!$alias) {
				$alias = $this->common->makeAlias($this->request->data['Page']['title']);
			}
			$i = 1;
			$newalias = $alias;
			while($this->checkAliasExist($newalias,$this->id)) {
				$newalias = $alias.'-'.$i;
				$i++;
			}
			$this->request->data['Page']['alias'] = $newalias;
			($this->request->data['Page']['page_type']=='document') ? $this->request->data['Page']['content'] = '' : $this->request->data['Page']['doc_name'] = '';
			//making alias start   
			if($errorsArr) {
			
				
				
				$this->set('errors',$errorsArr);
							
				$this->set('data',$this->request->data);
			 	
				
				if($this->request->data['Page']['doc_name']) {
				   $this->deleteDocument($this->request->data['Page']['doc_name']);
				}
			}
			else {  
				if($this->request->data['Page']['page_type']=='document') {
					$this->request->data['Page']['content'] 			= '';
					$this->request->data['Page']['meta_title'] 		= '';
					$this->request->data['Page']['meta_keyword'] 	= '';
					$this->request->data['Page']['meta_description'] = '';
				}
				else if($this->request->data['Page']['page_type']=='content') {
					$this->request->data['Page']['doc_name'] 		= '';
				}
				
				if($this->Page->save($this->request->data)) {
				    if($this->request->data['Page']['content'] && file_exists(WWW_ROOT.'documents/'.$this->request->data['Page']['oldfilename'])) {
				   		@unlink(WWW_ROOT.'documents/'.$this->request->data['Page']['oldfilename']);
					}
					$this->Session->write('popup','Page has been updated successfully.');
					$this->Session->setFlash('Page has been updated successfully.');  
					$this->redirect(array('controller'=>'pages','action' => "index/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}
		else
		{
			$this->set('data',$this->Page->read('',$id));
		}
		// end if of check data array
	   
	 } 
	/*****************************************************************************************************************
	Function to delete Page( Content or document) 
	@param : $id is record id to be deleted
	*****************************************************************************************************************/
	function superadmin_delete($id=NULL) {
	   $this->id = (int)$id;
	   if(!$this->id) {
		 	$this->Session->setFlash('Invalid page id');
		    $this->redirect(array('controller'=>'pages','action'=>'index'));
	   }
	   $docName  = $this->Page->field('doc_name');
	   if($docName) {
	   	  $this->deleteDocument($docName);
	   }
	   if($this->Page->delete($this->id,false)) { //second param for casecade delete
	   $this->Session->write('popup','Page has been deleted successfully.');
			$this->Session->setFlash('Page has been deleted successfully.');  
			$this->redirect(array('controller'=>'pages','action' => "index/message:success")); 
		}
	  else {
	  		$this->Session->setFlash('Deletion problem, Please try again.');  
	      	$this->redirect(array('controller'=>'pages','action' => "index"));
	  	}	
	 }
	/*****************************************************************************************************************
	Function to check the availibility of alias
	@param : $alias : string alias to be checked
	@param : $id    : $id is optional and is used exempt updated record id
	return : Return True if alias name already exist and
	 		 Return False if alias name not exist
	*******************************************************************************************************************/
	function checkAliasExist($alias,$id='') {
	    if($id) {
			$arr['Page.id !='] = $id; 
		}
		$arr['Page.alias'] = $alias;
	    $count = $this->Page->find("count", array("conditions" =>$arr));
		if ($count == 0) {
			return false; //return false if not exist
		} else {
			return true;//return true if exist
		}
	}
	/***************************************************************************************************************** 
	 Function  to delete document 
	 @param : $docName is a name of document to be deleted
	 *****************************************************************************************************************/
	function deleteDocument($docName) {
		if(file_exists(WWW_ROOT.'documents/'.$docName)) {
			@unlink(WWW_ROOT.'documents/'.$docName);
		}
	}
	
	 /* This function call for all page on front end */
	function display($alias=NULL) {
	$this->Session->write('id','UserInfoDiv');
	   //Set default layout
	   $this->layout = 'default';  
	   if((int)$alias) {
	     $this->id = (int)$alias;
		 $data = $this->Page->find('first',array('conditions'=>array('LOWER(Page.id)'=>$this->id,'Page.active'=>'yes')));
	   } 
	   else if($alias){
	     $alias = strtolower(trim($alias));
		 $data = $this->Page->find('first',array('conditions'=>array('LOWER(Page.alias)'=>$alias,'Page.active'=>'yes')));
		} 
	  else {
	  	 $data = $this->Page->find('first',array('conditions'=>array('LOWER(Page.id)'=>1,'Page.active'=>'yes')));
	  }	
	  if($data['Page']['page_type']=='document' && $data['Page']['doc_name'] != '') {
	  	 $this->downloadFile('documents',$data['Page']['doc_name']);
	  }
	  if(isset($this->params['named']['layout']) && $this->params['named']['layout']=='print') {
	  	$this->layout = 'print';
	  }
	  $this->set('meta_title',isset($data['Page']['title']) ? $data['Page']['title'] : '');
	  $this->set('data',$data);
	}
	/***************************************************************************************************************** 
	This function is working at welcome page for candidate.
	 *****************************************************************************************************************/
	function candidate() { 
   	}	
	/***************************************************************************************************************** 
	This function is checking username and pasword in database and if true then redirect to home page 
	 *****************************************************************************************************************/
	function beforeFilter() { 
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		$this->Auth->allow('login','display','candidate');
		//$this->Auth->loginAction = array('controller' => 'pages', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'home','superadmin'=>true);
		$this->Auth->userScope = array('Page.active' => 'yes');
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}//end class
?>
