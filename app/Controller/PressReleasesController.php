<?php
App::uses('AppController', 'Controller');
/**
 * Pixes Controller
 *
 * @property PressRelease $PressRelease
 */
class PressReleasesController extends AppController {
    public $layout = 'admin';
	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some required helpers to this controller
 	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
        $this->set('meta_title','Press Releases');
		$this->PressRelease->recursive = 0;
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('PressRelease.id' => 'DESC'));
		$this->set('pressreleases', $this->paginate());
	}
	

/**
 * superadmin_view method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_view($id = null) {
		$this->PressRelease->id = $id;
		if (!$this->PressRelease->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		$this->set('pix', $this->PressRelease->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
            $errors = '';
            $this->set('meta_title','Add Press Releases');
		if ($this->request->is('post')) {
				
			$this->PressRelease->set($this->request->data);                        
            if(!$this->PressRelease->validates()) {
				$errors = $this->PressRelease->validationErrors;                                
			}			
            if($errors) {
                            $this->set('errors',$errors);
			}else {
						if($this->request->data['PressRelease']['upload_photo']==0){ 
	                            App::import('Vendor', 'Uploader.Uploader');
	                            $this->Uploader = new Uploader();
	                            $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/press'));                            
	                            $fileUploadPath=$this->Uploader->upload($this->request->data['PressRelease']['pr_file'],array('overwrite'=>true));                            
	                            $this->Uploader->resize(array('width' => EVENT_PIX_WIDTH,'height' => EVENT_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
	                            $this->request->data['PressRelease']['pr_file'] = end(explode('/',$fileUploadPath['path']));
                            }else{
                            	//copy file from PHOTO_GALLERY to press realese.
                            	$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['PressRelease']['pr_file1'];
                            	$destination_file_ext 	= end(explode(".",$this->request->data['PressRelease']['pr_file1']));
                            	$destination_file_name 	= time().".".$destination_file_ext;
                            	$destination_file_loc = WWW_ROOT."img/press/".$destination_file_name;
                            	$ok = copy($source_file, $destination_file_loc);
                            	$this->request->data['PressRelease']['pr_file'] = $destination_file_name;
                            }
                            unset($this->request->data['PressRelease']['pr_file1']);
                            if ($this->PressRelease->save($this->request->data,false)){
                                $this->Session->write('popup','Press Release has been added successfully.');
                                $this->Session->setFlash('Press Release has been added successfully.');  
                                $this->redirect(array('controller'=>'pressReleases','action' => "index/message:success"));
                            }else{
                            	//debug($this->PressRelease->validationErrors);die;
                            	$this->Session->setFlash(__('The Press Release could not be saved. Please, try again.'));
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
		$this->PressRelease->id = $id;
                $errors = '';
                $this->set('meta_title','Update Press Releases');
		if (!$this->PressRelease->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			
			if($this->request->data['PressRelease']['pr_file']['name']=='')
			unset($this->request->data['PressRelease']['pr_file']);
			
			
			
			
			$this->PressRelease->set($this->request->data);                        
            if(!$this->PressRelease->validates()) {
				$errors = $this->PressRelease->validationErrors;                                
			}			
            if($errors) {
             	$this->set('errors',$errors);
			}else {
						if($this->request->data['PressRelease']['upload_photo']==0){	 
                            if(isset($this->request->data['PressRelease']['pr_file']['name']) && is_array($this->request->data['PressRelease']['pr_file']) && $this->request->data['PressRelease']['pr_file']['name']!=''){
                                App::import('Vendor', 'Uploader.Uploader');
                                $this->Uploader = new Uploader();
                                $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/press'));                            
                                $fileUploadPath=$this->Uploader->upload($this->request->data['PressRelease']['pr_file'],array('overwrite'=>false));                            
                                //$this->Uploader->resize(array('width' => EVENT_PIX_WIDTH,'height' => EVENT_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
                                $this->request->data['PressRelease']['pr_file'] = end(explode('/',$fileUploadPath['path']));
                                $this->Uploader->delete(PRESS.$this->request->data['PressRelease']['curr_pic_filename']);
                            }else{
                                $this->request->data['PressRelease']['pr_file'] = $this->request->data['PressRelease']['curr_pic_filename'];
                            }
						}else{
							//copy file from PHOTO_GALLERY to press realese.
							$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['PressRelease']['pr_file1'];
							$destination_file_ext 	= end(explode(".",$this->request->data['PressRelease']['pr_file1']));
                            $destination_file_name 	= time().".".$destination_file_ext;
                            $destination_file_loc 	= WWW_ROOT."img/press/".$destination_file_name;
                            $ok = copy($source_file, $destination_file_loc);
                            // delete old file
                            unlink(WWW_ROOT."img/press/".$this->request->data['PressRelease']['curr_pic_filename']);
                            $this->request->data['PressRelease']['pr_file'] = $destination_file_name;
						}
						   unset($this->request->data['PressRelease']['pr_file1']);
	                       //pr($this->request->data);exit;
	                       if ($this->PressRelease->save($this->request->data,false)){
	                       $this->Session->write('popup','Press Release has been updated successfully.');
	                       $this->Session->setFlash('Press Release has been updated successfully.');  
	                       $this->redirect(array('controller'=>'pressReleases','action' => "index/message:success"));
	                       }else{
	                       		debug($this->PressRelease->validationErrors);die;
	                            $this->Session->setFlash(__('The Press Release could not be saved. Please, try again.'));
	                       }                            
	            }
		} else {
			$this->request->data = $this->PressRelease->read(null, $id);
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
		$this->PressRelease->id = $id;
		if (!$this->PressRelease->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		App::import('Vendor', 'Uploader.Uploader');
        $this->Uploader = new Uploader();
		$pressContent = $this->PressRelease->read(null, $id);
		$this->Uploader->delete(PRESS.$pressContent['PressRelease']['pr_file']);
		 
		if ($this->PressRelease->delete()) {
			$this->Session->write('popup','Press Release has been deleted successfully.');
                        $this->Session->setFlash('Press Release has been deleted successfully.');  
                        $this->redirect(array('controller'=>'pressReleases','action' => "index/message:success"));
		}
		$this->Session->setFlash(__('Press Release was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	/**
 * front_index method
 *
 * 
 * @return void
 */
	public function index() {
		
		$this->layout ='front';
		$this->set('pressreleases',$this->PressRelease->find('all',array('order'=>'pr_date desc')));
		
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
