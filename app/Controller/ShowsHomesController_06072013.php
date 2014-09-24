<?php
App::uses('AppController', 'Controller');

/**
 * ShowsHomes Controller
 *
 * @property ShowsHome $ShowsHome
 * @property commonComponent $common
 */
class ShowsHomesController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Javascript');
/**
 * Components
 *
 * @var array
 */
	public $components = array('common','Auth','Session');
        
        var $layout = 'admin'; //this is the layout for admin panel 

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
         $this->set('meta_title','Shows for Home');
         $this->loadModel('Show');
		//$this->Shows->recursive = 0; 
         $ok = false;
		 $targetdate = date("Y-m-d",mktime(0,0,0,date('m'),date('d')-90,date('Y')));
		 $this->set('shows', $this->Show->find('all',array('fields'=>array('id','show_dt','show_name'),'conditions'=>array("Show.show_dt >= '".$targetdate."'"),'order'=>array('Show.show_dt DESC'))));
		 
		if ($this->request->is('post')) {
			//pr($this->request->data);exit;
			$this->ShowsHome->deleteAll(array('1 = 1'));
			$chk_var = "";
			//pr($this->request->data['ShowsHome']);
				foreach($this->request->data['ShowsHome'] as $key => $dataCheck){ 
				  $this->ShowsHome->create();
				  if(is_array($dataCheck) && $dataCheck['c']!='0'){
				  	$chk_var = "{$key}_upload_photo";
				  	if($this->request->data['ShowsHome'][$chk_var]==0){
				  		App::import('Vendor', 'Uploader.Uploader');
						$this->Uploader = new Uploader();						
						$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/showshome'));
						if(is_array($dataCheck['image_file']) && $dataCheck['image_file']['name']!=''){	
							$fileUploadPath=$this->Uploader->upload($dataCheck['image_file'],array('overwrite'=>false));
							$dataCheck['image_file'] = end(explode('/',$fileUploadPath['path'])); 
							if($dataCheck['show_image']!='')
								$this->Uploader->delete('img/showshome/'.$dataCheck['show_image']);
						}else{
							$dataCheck['image_file'] = $dataCheck['show_image']; 
						}
				  	}else{
				  		//copy file from PHOTO_GALLERY to press realese.
						$source_file = WWW_ROOT."img/photo_gallery/".$dataCheck['image_file1'];
						$destination_file_ext 	= end(explode(".",$dataCheck['image_file1']));
                        $destination_file_name 	= time().".".$destination_file_ext;
                        $destination_file_loc 	= WWW_ROOT."img/showshome/".$destination_file_name;
                        $ok = copy($source_file, $destination_file_loc);
                        // delete old file
                        @unlink(WWW_ROOT."img/showshome/".$dataCheck['show_image']);
                        $dataCheck['image_file'] = $destination_file_name;
				  	}	
						//pr($dataCheck);die;
						$this->ShowsHome->save($dataCheck);
						$ok = true;
						/*if ($this->ShowsHome->save($dataCheck)) {
							$this->Session->write('popup','Shows Home has been created successfully.');
							$this->Session->setFlash('Shows has been updated successfully.');  
							$this->redirect(array('controller'=>'ShowsHomes','action' => "index/message:success"));
						}*/
					}else{
						$this->ShowsHome->delete($dataCheck['show_id']);
						if($dataCheck['show_image'] != ''){
							@unlink(SHOWSHOME.$dataCheck['show_image']);
						}
						//pr($dataCheck);exit;
					}
				}
				if($ok){
					  $this->Session->write('popup','Shows Home has been created successfully.');
					  $this->Session->setFlash('Shows has been updated successfully.');  
					  $this->redirect(array('controller'=>'ShowsHomes','action' => "index/message:success"));
				}
}
	}

/**
 * superadmin_view method
 *
 * @param string $id
 * @return void
 */
	/*public function superadmin_view($id = null) {
		$this->ShowsHome->id = $id;
		if (!$this->ShowsHome->exists()) {
			throw new NotFoundException(__('Invalid shows home'));
		}
		$this->set('showsHome', $this->ShowsHome->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	/*public function superadmin_add() {
		if ($this->request->is('post')) {
			$this->ShowsHome->create();
			if ($this->ShowsHome->save($this->request->data)) {
				$this->flash(__('Showshome saved.'), array('action' => 'index'));
			} else {
			}
		}
	}

/**
 * superadmin_edit method
 *
 * @param string $id
 * @return void
 */
	/*public function superadmin_edit($id = null) {
		$this->ShowsHome->id = $id;
		if (!$this->ShowsHome->exists()) {
			throw new NotFoundException(__('Invalid shows home'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ShowsHome->save($this->request->data)) {
				$this->flash(__('The shows home has been saved.'), array('action' => 'index'));
			} else {
			}
		} else {
			$this->request->data = $this->ShowsHome->read(null, $id);
		}
	}

/**
 * superadmin_delete method
 *
 * @param string $id
 * @return void
 */
	/*public function superadmin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->ShowsHome->id = $id;
		if (!$this->ShowsHome->exists()) {
			throw new NotFoundException(__('Invalid shows home'));
		}
		if ($this->ShowsHome->delete()) {
			$this->flash(__('Shows home deleted'), array('action' => 'index'));
		}
		$this->flash(__('Shows home was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}*/
        
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
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','superadmin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'ShowsHomes', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
		
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
} 