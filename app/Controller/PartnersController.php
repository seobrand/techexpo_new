<?php
/**
 * Pixes Controller
 *
 * @property PressRelease $PressRelease
 */
App::uses('AppController', 'Controller'); 
class PartnersController extends AppController{
    public $layout = 'admin';
	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array("Partner","Employer");

	public function superadmin_index() {
        $this->set('meta_title','Partner');
		$this->Partner->recursive = -1;
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
        $this->paginate = array('limit' =>$record,'order' => array('Partner.id' => 'DESC'));
		$this->set('partners', $this->paginate());
	}
	
	/**
	 * superadmin_add method
	 *
	 * @return void
	 */
	public function superadmin_add() {
            $errors = '';
            $this->set('meta_title','Add Partner');
			
			// task id 2815 commented  and add new
			/*$condition = "Employer.logo_file!='' AND Employer.trial_client!='y'";
			$clientList = $this->Employer->find('list',array('fields'=>array('id','employer_name'),'conditions'=>$condition,'order'=>array('Employer.employer_name ASC'))); */
			$this->loadModel('MarketingExhibitor');
			$clientList = $this->MarketingExhibitor->find('list',array('fields'=>array('id','title'),'order'=>array('MarketingExhibitor.title ASC')));
			
			$this->set('clientList',$clientList);
			
			if ($this->request->is('post')) {			
				$this->Partner->set($this->request->data);                        
				if(!$this->Partner->validates()) {
					$errors = $this->Partner->validationErrors;                                
				}			
				if($errors) {
					$this->set('errors',$errors);
				}else {
					if ($this->Partner->save($this->request->data)){
						$this->Session->write('popup','Partner has been added successfully.');
						$this->Session->setFlash('Partner has been added successfully.');  
						$this->redirect(array('controller'=>'partners','action' => "index/message:success"));
					}else{
						$this->Session->setFlash(__('The Partner could not be saved. Please, try again.'));
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
	public function superadmin_edit($id = null) {
		$this->Partner->id = $id;
		$errors = '';
		$this->set('meta_title','Update Partner');
		// task id 2815 commented  and add new
			/*$condition = "Employer.logo_file!='' AND Employer.trial_client!='y'";
			$clientList = $this->Employer->find('list',array('fields'=>array('id','employer_name'),'conditions'=>$condition,'order'=>array('Employer.employer_name ASC'))); */
			$this->loadModel('MarketingExhibitor');
			$clientList = $this->MarketingExhibitor->find('list',array('fields'=>array('id','title'),'order'=>array('MarketingExhibitor.title ASC')));
		$this->set('clientList',$clientList);
			
		if (!$this->Partner->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Partner->set($this->request->data);                        
                if(!$this->Partner->validates()) {
				$errors = $this->Partner->validationErrors;                                
			}			
			if($errors) {
				$this->set('errors',$errors);
			}else {
				//pr($this->request->data);exit;
				if ($this->Partner->save($this->request->data)){
					$this->Session->write('popup','Partner has been updated successfully.');
					$this->Session->setFlash('Partner has been updated successfully.');  
					$this->redirect(array('controller'=>'partners','action' => "index/message:success"));
				}else{
					$this->Session->setFlash(__('The Partner could not be saved. Please, try again.'));
				}                            
            }
		} else {
			$this->request->data = $this->Partner->read(null, $id);
		}
	}

	/**
	 * superadmin_delete method
	 *
	 * @param string $id
	 * @return void
	 */
	public function superadmin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Partner->id = $id;
		if (!$this->Partner->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		
		if ($this->Partner->delete()) {
			$this->Session->write('popup','Partner has been deleted successfully.');
			$this->Session->setFlash('Partner has been deleted successfully.');  
			$this->redirect(array('controller'=>'partners','action' => "index/message:success"));
		}
		
		$this->Session->setFlash(__('Partner was not deleted'));
		$this->redirect(array('action' => 'index'));
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
		
		$this->Auth->allow('login','index');
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'codes', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
		
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
