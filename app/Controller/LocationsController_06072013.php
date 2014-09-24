<?php
App::uses('AppController', 'Controller');
/**
 * Locations Controller
 *
 * @property Location $Location
 */
class LocationsController extends AppController {

    var $layout = 'admin'; //this is the layout for admin panel     
    var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
/**
 * index method
 *
 * @return void
 */
	public function superadmin_index() { 
		$this->set('meta_title','Locations');
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('Location.id' => 'DESC'));
        $data = $this->paginate('Location');
        //pr($data);
		$this->set('locations', $data);	
		
	}


/**
 * superadmin_view method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_view($id = null) {
		$this->Location->id = $id;
                $this->set('meta_title','View Location');
		if (!$this->Location->exists()) {
			throw new NotFoundException(__('Invalid location'));
		}
		$this->set('location', $this->Location->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
		$errors ='';
		$this->set('meta_title','Add New Location');
		$this->loadModel('State');
		$fields = array('state_abrev','state_name');
		$states = $this->State->find('list',array('fields'=>$fields));
		$this->set('states',$states);  
		
		if($this->request->is('post')) {		
				$this->Location->set($this->request->data);	
			
			if(!$this->Location->validates()){		
				$errors = $this->Location->validationErrors;                            
			}	
			if($errors) {			
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				if ($this->Location->save($this->request->data)) {
					$this->Session->write('popup','Location has been added successfully.');
					$this->Session->setFlash('Location has been added successfully.');  
					$this->redirect(array('controller'=>'locations','action' => "index/message:success"));
				}else{
					$this->Session->setFlash('Data save problem, Please try again.');  
                }					
			}	
		}
            
	}

/**
 * superadmin_edit method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_edit($location_id = null) {
	
			$this->loadModel('State');
			$fields = array('state_abrev','state_name');
			$states = $this->State->find('list',array('fields'=>$fields));
			$this->set('states',$states);
			

            $this->set('meta_title','Edit Location');
			$this->set('id',$location_id);
			
			if ($this->request->is('get')) {
				$this->request->data = $this->Location->find('first',array('conditions'=>array('id'=>$location_id)));
			} else {
				$this->Location->set($this->request->data);	
			
				if(!$this->Location->validates()){		
					$errors = $this->Location->validationErrors;                            
				}	
				
				if($errors) {			
					$this->Set('errors',$errors);
					$this->set('data',$this->request->data);
				}else{
			
					if ($this->Location->save($this->request->data)) {
						$this->Session->write('popup','Your location has been updated successfully.');
						$this->Session->setFlash('Your location has been updated successfully.');  
						$this->redirect(array('controller'=>'locations','action' => "index/message:success"));
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'locations','action' => "edit",$location_id));
					}
				}
				
			}
	}

/**
 * superadmin_delete method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_delete($id = null) {		
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
		if ($this->Location->delete($id)) {
			$this->Session->write('popup','Location has been deleted successfully.');
			$this->Session->setFlash('Location has been deleted successfully.');  
			$this->redirect(array('controller'=>'locations','action' => "index/message:success")); 
		} else {
			$this->Session->setFlash('Deletion problem, Please try again.');  
			$this->redirect(array('controller'=>'locations','action' => "index"));
		}
	}
	
	// function for update location location travel direction from show direction
	/* public function superadmin_copytraveldirection() {
		$this->autoRender = false;
		$this->loadModel('Show');
		$this->Show->recursive = 0;
		$shows = $this->Show->find('all',array('fields'=>'Show.location_id ,Show.show_travel_dir','conditions'=>array('Show.show_travel_dir !=' => ''),'order'=>'Show.id ASC'));
		//pr($shows);
		foreach($shows as $show){
			$loc_data['Location']['id'] = $show['Show']['location_id'];
			$loc_data['Location']['site_travel_direction'] = $show['Show']['show_travel_dir'];
			$this->Location->save($loc_data);
		}
		echo "done";
	} */
        
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
		$this->Auth->loginRedirect = array('controller' => 'locations', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminclient.active' => 'yes');
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	}        
}

