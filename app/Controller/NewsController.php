<?php 
/******************************************************************************************
 Coder  : Keshav Sharma 
 Object : Controller to handle News operations - view , add, edit and delete
******************************************************************************************/ 
class NewsController extends AppController {
	var $name = 'News'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 

	function superadmin_index() {
	
	/*if($this->params['url']['url'] == 'superadmin/news') {
		if($this->Session->read('param_search')) {
				$this->Session->delete('param_search');
			}
		if($this->Session->read('data_search')) {
				$this->Session->delete('data_search');
			}
	}	*/
	
	
		$this->set('meta_title','All News');
		$search = '';
		$active = '';		
		$argArr = array();
		$cond = '';		
	if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
		$this->Session->write('per_page_record',$this->params['pass'][0]);
	}		
		/* Search conditon for  text value   */
		if(!empty($this->request->data)) {
			$search = $this->request->data['News']['search'];
			$this->Session->write('data_search',$this->request->data['News']);
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
			  		$cond[]  = array('OR'=>array('News.title LIKE'=>'%'.$search.'%','News.description LIKE'=>'%'.$search.'%'));
		     		//$cond[]  = array('OR'=>array('News.title LIKE'=>'%'.$search.'%','News.content LIKE'=>'%'.$search.'%','News.doc_name LIKE'=>'%'.$search.'%'));
			 }
		/* End Search conditon for  text value   */
		/* Search conditon for  Active  status */
		if(isset($this->request->data['News']['active']) && $this->request->data['News']['active']) {
			$active = $this->request->data['News']['active'];
		}
		else if(isset($this->params['named']['active']) && $this->params['named']['active']) {
			$active = $this->params['named']['active'];
		}
		else {
			$active = ($this->Session->read('data_search.active')) ? $this->Session->read('data_search.active') : $this->Session->read('param_search.active');
		}		
		if($active) {
		    $cond[]  = array('News.active'=>$active);
		}
		//all active and inactive records for paging.
		$active_record = $this->News->find('count',array('conditions'=>array('News.active'=>'yes',$cond)));
		$inactive_record = $this->News->find('count',array('conditions'=>array('News.active'=>'no',$cond)));
		$this->set('active_record',$active_record);
		$this->set('inactive_record',$inactive_record);			
		/* End Search conditon for  pages page_type */
		$condition = $cond;
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		$this->paginate = array('limit' => $record,'order' => array('News.title'=>'ASC'));
		$data = $this->paginate('News', $condition);
		$this->set('data', $data); 
		$this->set('search', $search); 
		$this->set('active', $active); 
		$this->set('argArr', $argArr);

	 }
	 /*********************************************************************
	 Function to create new page
	 **********************************************************************/
	function superadmin_create() {
	
		$errors ='';
		
		
		if(!empty($this->request->data['SUBMIT']) && is_array($this->request->data))  {
		
	
			$this->News->set($this->request->data['News']);
			if(!$this->News->validates()) {
				$errors = $this->News->validationErrors;	
				//$errors = @implode('<br>', $errorsArr);
				
			}
                        $alias = $this->common->makeAlias($this->request->data['News']['alias']);
			if(!$alias) {
				$alias = $this->common->makeAlias($this->request->data['News']['title']);
			}
			$i = 1;
			$newalias = $alias;
			while($this->checkAliasExist($newalias)) {
				$newalias = $alias.'-'.$i;
				$i++;
			}
			$this->request->data['News']['alias'] = $newalias;	
			if($errors) {
			
				$argArr['publish'] = $this->request->data['News']['publish'];
				$argArr['expire'] = $this->request->data['News']['expire'];
				$this->set('argArr',$argArr);
				$this->set('errors',$errors);
				$this->set('data',$this->request->data);
				
			 	
			}
			else {  
				//pr($this->request->data);	
				$this->request->data['News']['description'] = str_replace('../../../../',FULL_BASE_URL.router::url('/',false),$this->request->data['News']['description']);	
				$this->request->data['News']['description'] = str_replace('../../../',FULL_BASE_URL.router::url('/',false),$this->request->data['News']['description']);		
				$this->request->data['News']['description'] = str_replace('../../',FULL_BASE_URL.router::url('/',false),$this->request->data['News']['description']);
				$this->request->data['News']['publish'] = str_replace('.','-',$this->request->data['News']['publish']);
				$this->request->data['News']['publish'] = str_replace('/','-',$this->request->data['News']['publish']);
				$this->request->data['News']['expire'] = str_replace('.','-',$this->request->data['News']['expire']);
				$this->request->data['News']['expire'] = str_replace('/','-',$this->request->data['News']['expire']);	
				$this->request->data['News']['published_time'] = strtotime($this->request->data['News']['publish']);
				$this->request->data['News']['expiry_time'] = strtotime($this->request->data['News']['expire']);							
				//echo htmlentities($this->request->data['News']['description']);
				//exit;
				if($this->News->save($this->request->data)) {
				$this->Session->write('popup','News has been created successfully.');
					$this->Session->setFlash('News has been created successfully.');  
					$this->redirect(array('controller'=>'news','action' => "index/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
	 } 
	/*********************************************************************************************
	Function to view page detail 
	*********************************************************************************************/ 
	function superadmin_view($id=NULL) {
		$this->set('meta_title','News detail');
		$this->id= (int)$id;
		if(!$this->id) {
			$this->Session->setFlash('Invalid page id.');
			$this->redirect(array('controller'=>'news','action' => "index"));  
		}
		$this->set('data',$this->News->read('',$this->id));
	}
	/*******************************************************************************************
	Function to update page
	*******************************************************************************************/
	function superadmin_update($id=null) {
		 $this->set('meta_title','Update News');
		 $errors ='';
		 if(isset($this->request->data['News']['id'])) {
			 $this->id = (int)$this->request->data['News']['id'];
			 $this->set('id',$this->id);
		 }
		 else {
		 	$this->id = (int)$id;
			$this->set('id',$this->id);
		 }	
		 if(!$this->id) {
		 	$this->Session->setFlash('Invalid News id.');
		    $this->redirect(array('controller'=>'news','action'=>'index'));
		 }
		 
		$errors ='';
		
		if(!empty($this->request->data['SUBMIT']) && is_array($this->request->data))  {
			$this->News->set($this->request->data['News']);
			if(!$this->News->validates()) {
				$errors = $this->News->validationErrors;	
			}
                        
                        
                        $alias = $this->common->makeAlias($this->request->data['News']['alias']);
			if(!$alias) {
				$alias = $this->common->makeAlias($this->request->data['News']['title']);
			}
			$i = 1;
			$newalias = $alias;
			while($this->checkAliasExist($newalias,$this->id)) {
				$newalias = $alias.'-'.$i;
				$i++;
			}
			$this->request->data['News']['alias'] = $newalias;
			
			if($errors) {
			
				$this->Set('errors',$errors);
				 $this->set('data',$this->request->data);
			}
			else { 
				$this->request->data['News']['description'] = str_replace('../../../../',FULL_BASE_URL.router::url('/',false),$this->request->data['News']['description']);	
				$this->request->data['News']['description'] = str_replace('../../../',FULL_BASE_URL.router::url('/',false),$this->request->data['News']['description']);		
				$this->request->data['News']['description'] = str_replace('../../',FULL_BASE_URL.router::url('/',false),$this->request->data['News']['description']);
				$this->request->data['News']['publish'] = str_replace('.','-',$this->request->data['News']['publish']);
				$this->request->data['News']['publish'] = str_replace('/','-',$this->request->data['News']['publish']);
				$this->request->data['News']['expire'] = str_replace('.','-',$this->request->data['News']['expire']);
				$this->request->data['News']['expire'] = str_replace('/','-',$this->request->data['News']['expire']);
				$this->request->data['News']['published_time'] = strtotime($this->request->data['News']['publish']);
				$this->request->data['News']['expiry_time'] = strtotime($this->request->data['News']['expire']);						
								
				if($this->News->save($this->request->data)) {
					$this->Session->write('popup','News has been updated successfully.');
					$this->Session->setFlash('News has been updated successfully.');  
					$this->redirect(array('controller'=>'news','action' => "index/message:success"));
				}	
				else {
					$this->Session->setFlash('Data save problem, Please try again.');  
				}	
			}//end if not error
		}// end if of check data array
		else
		{
			$this->set('data',$this->News->read('',$this->id));
		}
	   
	 } 
	/*****************************************************************************************************************
	Function to delete News( Content or document) 
	@param : $id is record id to be deleted
	*****************************************************************************************************************/
	function superadmin_delete($id=NULL) {
	   $this->id = (int)$id;
	   if(!$this->id) {
		 	$this->Session->setFlash('Invalid News id');
		    $this->redirect(array('controller'=>'news','action'=>'index'));
	   }
	   if($this->News->delete($this->id,false)) { //second param for casecade delete
	   $this->Session->write('popup','News has been deleted successfully.');
			$this->Session->setFlash('News has been deleted successfully.');  
			$this->redirect(array('controller'=>'news','action' => "index/message:success")); 
		}
	  else {
	  		$this->Session->setFlash('Deletion problem, Please try again.');  
	      	$this->redirect(array('controller'=>'news','action' => "index"));
	  	}	
	 }
	 
	
	function index() {
	$this->layout = 'default';
		$this->set('meta_title','News');
		$date = strtotime(date('d-m-Y'));
		$date1 = date('d-m-Y');
		//echo $date;
		$search = '';	
		$argArr = array();

		$cond[] = array("(News.published_time <=".$date." OR News.publish =".$date1.") AND (".$date." <= News.expiry_time OR ".$date1." = News.expire) AND (News.active = 'yes')" );		

		/* End Search conditon for  text value   */
		$this->set('argArr', $argArr);		
		$condition = $cond;
		$this->paginate = array('limit' =>5,'order' => array('News.modified' => 'DESC','News.id' => 'DESC'));
		$data = $this->paginate('News', $condition);
		$this->set('data', $data); 	
	} 
	
	
	function archiveNews() {
	$this->layout = 'default';
		$this->set('meta_title','Archive News');
		$date = strtotime(date('d-m-Y'));
		$date1 = date('d-m-Y');
		$search = '';	
		$argArr = array();
		
		$cond[] = array("(News.published_time <=".$date." OR News.publish =".$date1.") AND (".$date." <= News.expiry_time OR ".$date1." = News.expire) AND (News.active = 'yes')" );				

		/* End Search conditon for  text value   */
		$this->set('argArr', $argArr);		
		$condition = $cond;
		$this->paginate = array('limit' =>PER_PAGE_RECORD,'offset' => '5','order' => array('News.modified' => 'DESC','News.id' => 'DESC'));
		$data = $this->paginate('News', $condition);
		$this->set('data', $data); 	
	}
	/********************************************************************
	Function to view News detail 
	********************************************************************/ 
	function view($id=NULL) {
	$this->layout = 'default';
		$this->set('meta_title','News Details');
		$this->id= (int)$id;
		if(!$this->id) {
			$this->Session->setFlash('Invalid News Id.');
			$this->redirect(array('controller'=>'adminjobs','action' => "index"));  
		}
		$this->set('data',$this->News->read());
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
		$this->Auth->allow('index','view','archiveNews');
		//$this->Auth->loginAction = array('controller' => 'pages', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'Adminuser', 'action' => 'home','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
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
			$arr['News.id !='] = $id; 
		}
		$arr['News.alias'] = $alias;
	    $count = $this->News->find("count", array("conditions" =>$arr));
		if ($count == 0) {
			return false; //return false if not exist
		} else {
			return true;//return true if exist
		}
	}
}//end class
?>