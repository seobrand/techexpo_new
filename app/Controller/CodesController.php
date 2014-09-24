<?php 
/**************************************************************************
 Coder  : Keshav Sharma 
 Object : Controller to handle Area of interests add, edit and delete operation
**************************************************************************/ 
class CodesController extends AppController {
	var $name = 'Codes'; //Model name attached with this controller 
	var $helpers = array('Paginator'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	/*********************************************************************
	This function call by default when a controller is called 
	Function will show list of all Area of interests
	********************************************************************/
	function superadmin_index() {
	
		$this->set('meta_title','Codes');
		/*$search = '';
		$argArr = array();
		$cond = '';*/	
                $argArr = array();
                if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
                    $this->Session->write('per_page_record',$this->params['pass'][0]);
                }		
		/*$parent = $this->Code->find('all');
		$this->set('parent', $parent);*/
		/* Search conditon for  text value   */
		/*if(!empty($this->request->data)) {
			$search = $this->request->data['Code']['search'];
			$this->Session->write('data_search',$this->request->data['Code']);
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
                        
		    $cond[]  = array('OR'=>array('Code.code_name LIKE'=>'%'.$search.'%','Code.parent_name LIKE'=>'%'.$search.'%'));
		}
		$this->set('search', $search); 
		$this->set('argArr', $argArr);
		
		$active_record = $this->Code->find('count',array('conditions'=>array('Code.visible'=>'Y',$cond)));
		$inactive_record = $this->Code->find('count',array('conditions'=>array('Code.visible'=>'N',$cond)));
		$this->set('active_record',$active_record);
		$this->set('inactive_record',$inactive_record);	*/		
		/* End Search conditon for  text value   */
		//$condition = $cond;
                $this->set('argArr', $argArr);
                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
                $this->paginate = array('limit' =>$record,'order' => array('Code.code_name' => 'ASC'),'group'=>array('code_name'));
		//$data = $this->paginate('Code', $condition);
                //$this->paginate = array('fields'=>array('DISTINCT code_name'));
                $data = $this->paginate('Code');
                //pr($data);
		$this->set('data', $data);
	 }
	 /*********************************************************************
	 Function to save new Area of interests
	 **********************************************************************/
	 function superadmin_create() {
		$this->set('meta_title','Create New Code/Value');	 
		$errors ='';
		//get last order
		$last_order1 = $this->Code->find('first', array('fields'=>array('MAX(sort_order) as sort_order')));
		$this->set('last_order',$last_order1[0]['sort_order']);				
	
           // pr($this->request->data);exit;
		if(is_array($this->request->data) && $this->request->is('post'))  {	
                        $this->Code->set($this->request->data);
			if(!$this->Code->validates()){		
				$errors = $this->Code->validationErrors;                            
			}
			if($errors) {			
			 	$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{ 
                           
                            if(!$this->request->data['Code']['sort_order']) {
                                $this->request->data['Code']['sort_order'] = $this->Code->field('MAX(sort_order)')+1;
                            }
                            if($this->request->data['Code']['code_descr'] == '') {                                
                                $this->request->data['Code']['code_descr'] = $this->request->data['Code']['code_name']; 
                            }					 	  	
                            if($this->Code->save($this->request->data,array('validate'=>false))) {
                                $this->Session->write('popup','Code has been created successfully.');
                                $this->Session->setFlash('Code has been created successfully.');  
                                $this->redirect(array('controller'=>'codes','action' => "index/message:success"));
                            }else {
                                $this->Session->setFlash('Data save problem, Please try again.');  
                            }	
                        }//end if not error
                }// end if of check data array
	 } 
	/********************************************************************
	Function to view Code detail 
	********************************************************************/ 
	function superadmin_view($id=NULL) {
		$this->set('meta_title','Code Detail View');
		$this->id= (int)$id;
		if(!$this->id) {
			$this->Session->setFlash('Invalid Code id.');
			$this->redirect(array('controller'=>'codes','action' => "index"));  
		}
		$this->set('data',$this->Code->read('',$this->id));
		
		$parent = $this->Code->find('all');
		$this->set('parent', $parent);
	}
	/******************************************************************
	Function to update Area of interests
	******************************************************************/
	function  superadmin_update($codename=NULL,$codeid = NULL) {
		 $this->set('meta_title','Update Code');		
		 $errors ='';                              
		 if($codename != NULL && $codeid == NULL){
		 	$this->codename = (string)$codename;
			$this->set('codename',$this->codename);
                 }elseif($codeid != NULL){
                     $this->codename = (string)$codename;
                     $this->set('codename',$this->codename);
                     $this->codeid = (int)$codeid;
		     $this->set('codeid',$this->codeid);
                 }
		 	
		 
                 
                 
	  	 if($this->request->is('post')){
                   // pr($this->request->data);exit;
                     $this->Code->set($this->request->data);
			if(!$this->Code->validates()) {
				$errors = $this->Code->validationErrors;
                                
			}			
                    if($errors) {
			 	$this->Set('errors',$errors);
                                $this->set('codeid',$codeid);
                                if($codeid != NULL){
                                    $codedescr = $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'conditions'=>array('code_name'=>$codename),'order'=>'code_descr'));                
                                    $this->set('codedescr',$codedescr); 
                                    $data = $this->Code->find('first',array('conditions'=>array('AND'=>array('code_id'=>$codeid,'code_name'=>$codename))));
                                    $this->request->data = $data;                            
                                }else{
                                    $codedescr = $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'conditions'=>array('code_name'=>$codename),'order'=>'code_descr'));                
                                    $this->set('codedescr',$codedescr); 
                                }
			}else { 				  							 
			  //pr($this->request->data);exit;
                            if(!$this->request->data['Code']['sort_order']) {
                                $this->request->data['Code']['sort_order'] = $this->Code->field('MAX(sort_order)')+1;
                            }
                            if($this->Code->save($this->request->data)) {
                                        $this->Session->write('popup','Code has been updated successfully.');
					$this->Session->setFlash('Code has been updated successfully.');  
					$this->redirect(array('controller'=>'codes','action' => "update/".$this->codename."/".$this->codeid."/message:success"));
				  }
				  else {
				    	$this->Session->setFlash('Data save problem, Please try again.');  
					$this->redirect(array('controller'=>'codes','action' => "update",$this->codename,$this->codeid));
				  }		
		 	}//end if not error
	 	}// end if of check data array
		 else {		                       
                    if($codeid != NULL){
                        $codedescr = $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'conditions'=>array('code_name'=>$codename),'order'=>'code_descr'));                
                        $this->set('codedescr',$codedescr); 
                        $data = $this->Code->find('first',array('conditions'=>array('AND'=>array('code_id'=>$codeid,'code_name'=>$codename))));
                        $this->request->data = $data;                        
                    }else{
                        $codedescr = $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'conditions'=>array('code_name'=>$codename),'order'=>'code_descr'));                
                        $this->set('codedescr',$codedescr); 
                    }
		 }
	 } 
	  /* Function to delete Area of interests */
	 function superadmin_delete($id=NULL,$codename=NULL) {
             
           
            $this->Code->code_id = $id;
           
            if ($this->Code->delete($this->Code->code_id,false)) {
                $this->Session->write('popup','Code Value has been deleted successfully.');
                $this->Session->setFlash('Code Value has been deleted successfully.');  
                $this->redirect(array('controller'=>'codes','action' => "update/".$codename."/message:success")); 
                exit;
            }            
             
             
	   /*$this->codeid = (int)$id;
	   
	   {
			  if($this->Code->delete($this->id,false)) { //second param for casecade delete
			  $this->Session->write('popup','Code has been deleted successfully.');
					$this->Session->setFlash('Code has been deleted successfully.');  
					$this->redirect(array('controller'=>'codes','action' => "index/message:success")); 
				}
			  else {
					$this->Session->setFlash('Deletion problem, Please try again.');  
					$this->redirect(array('controller'=>'codes','action' => "index"));
				}
		}*/		
	 }
	/* This function is used to update orders  */	
	function superadmin_update_order() {
	$i =0; 
	$data1 = array();
	foreach($this->request->data['Code'] as $key=>$value) {
			
			$get_id = explode('_',$key);	
						if(!isset($get_id[1])) {
			break;
			}else {	
			$id = $get_id[1];
			$data1[$i]['Code']['id']		= $id;
			$data1[$i]['Code']['ordered']  = $value;
			$i++;
			}
				
	}

		$this->Code->saveAll($data1);	
		$this->redirect(array('controller'=>'codes','action' => "index")); 	
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
		$this->Auth->loginRedirect = array('controller' => 'Codes', 'action' => '','superadmin'=>true);
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