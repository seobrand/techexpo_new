<?php
App::uses('AppController', 'Controller');
/**
 * HomepageMessages Controller
 *
 * @property HomepageMessage $HomepageMessage
 */
class HomepageMessagesController extends AppController {

    public $layout = "admin";
	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
		$this->set('meta_title','Homepage Messages');
		$this->HomepageMessage->recursive = 0;
		$this->set('homepageMessages', $this->paginate());
	}

/**
 * superadmin_view method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_view($id = null) {
		$this->HomepageMessage->id = $id;
		if (!$this->HomepageMessage->exists()) {
			throw new NotFoundException(__('Invalid homepage message'));
		}
		$this->set('homepageMessage', $this->HomepageMessage->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
	
		if ($this->request->is('post')) {
			$this->HomepageMessage->create();
			if ($this->HomepageMessage->save($this->request->data)) {
			
			
				$this->flash(__('Homepagemessage saved.'), array('action' => 'index'));
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
	public function superadmin_edit($id = null) {  
		$errors = '';
		$this->set('meta_title','Edit Homepage Message');
		$this->HomepageMessage->type = $id;                
		if (!$this->HomepageMessage->exists($id)) {
			throw new NotFoundException(__('Invalid homepage message'));
		}
		
	
		
		if ($this->request->is('post') || $this->request->is('put')) {
                   
                    $this->HomepageMessage->set($this->request->data); 
                    if(!$this->HomepageMessage->validates()) {
                       $errors = $this->HomepageMessage->validationErrors;                                
                    }	
                    App::import('Vendor', 'Uploader.Uploader');
                    $this->Uploader = new Uploader();
                    $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/homepage'));
                    if($errors) {
                        $this->set('errors',$errors);
                    }else {                    	
                    	if($this->request->data['HomepageMessage']['upload_photo']==0 && $this->request->data['HomepageMessage']['del'] != 'y'){
                    		if(is_array($this->request->data['HomepageMessage']['img']) && $this->request->data['HomepageMessage']['img']['name']!=''){
                    			$fileUploadPath=$this->Uploader->upload($this->request->data['HomepageMessage']['img'],array('overwrite'=>false));
                    			$this->Uploader->resize(array('width' => HOMEMESSSAGE_PIX_WIDTH,'height' => HOMEMESSSAGE_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
                    			$this->request->data['HomepageMessage']['img'] = end(explode('/',$fileUploadPath['path']));
                    			$this->Uploader->delete(HOMEMESSAGE.$this->request->data['HomepageMessage']['curr_pic_filename']);
                    			$this->Uploader->delete(HOMEMESSAGE.'resized_'.$this->request->data['HomepageMessage']['curr_pic_filename']);
                    		}                    		
                    	}elseif($this->request->data['HomepageMessage']['upload_photo']==1 && $this->request->data['HomepageMessage']['del'] != 'y'){
                    		//copy file from PHOTO_GALLERY to press realese.
                    		$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['HomepageMessage']['img1'];
                    		$destination_file_ext 	= end(explode(".",$this->request->data['HomepageMessage']['img1']));
                    		$destination_file_name 	= time().".".$destination_file_ext;
                    		$destination_file_loc_resize = WWW_ROOT."img/homepage/resized_".$destination_file_name;
                    		$destination_file_loc_orig 	 = WWW_ROOT."img/homepage/".$destination_file_name;
                    		$ok = copy($source_file, $destination_file_loc_resize);
                    		$ok = copy($source_file, $destination_file_loc_orig);
                    		// delete old file
                    		@unlink(WWW_ROOT."img/homepage/resized_".$this->request->data['HomepageMessage']['curr_pic_filename']);
                    		@unlink(WWW_ROOT."img/homepage/".$this->request->data['HomepageMessage']['curr_pic_filename']);
                    		$this->request->data['HomepageMessage']['img'] = $destination_file_name;
                    	}else{
                    		if($this->request->data['HomepageMessage']['del'] == 'y'){
                    			$this->request->data['HomepageMessage']['img'] = '';
                    			$this->Uploader->delete(HOMEMESSAGE.$this->request->data['HomepageMessage']['curr_pic_filename']);
                    			$this->Uploader->delete(HOMEMESSAGE.'resized_'.$this->request->data['HomepageMessage']['curr_pic_filename']);
                    		}else{
                    			$this->request->data['HomepageMessage']['img'] = $this->request->data['HomepageMessage']['curr_pic_filename'];
                    		}
                    	}   
                     
					 
					 // pushkar 29/7/2013 ticket after error given by lalit sir
						
						if(empty($this->request->data['HomepageMessage']['img']['name'])){
							if(!empty($this->request->data['HomepageMessage']['curr_pic_filename'])){
							$this->request->data['HomepageMessage']['img']=$this->request->data['HomepageMessage']['curr_pic_filename'];		
							}	
						}
						
						
                        if ($this->HomepageMessage->save($this->request->data)) {
                            $this->Session->write('popup','Press Release has been updated successfully.');
                            $this->Session->setFlash('Press Release has been updated successfully.');      
                            $this->redirect(array('controller'=>'homepageMessages','action' => "index/message:success"));
                        } else {
                            $this->Session->setFlash(__('The Home Message could not be saved. Please, try again.'));
                        }
                    }
		} else {                    
			$this->request->data = $this->HomepageMessage->read(null, $id);
                        $this->set("data",$this->request->data);
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
		$this->HomepageMessage->id = $id;
		if (!$this->HomepageMessage->exists()) {
			throw new NotFoundException(__('Invalid homepage message'));
		}
		if ($this->HomepageMessage->delete()) {
			$this->flash(__('Homepage message deleted'), array('action' => 'index'));
		}
		$this->flash(__('Homepage message was not deleted'), array('action' => 'index'));
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
		
		$this->Auth->allow('login');
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'homepageMessages', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
		
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
