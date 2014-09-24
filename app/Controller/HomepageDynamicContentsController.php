<?php
App::uses('AppController', 'Controller');
/**
 * HomepageDynamicContents Controller
 *
 * @property HomepageDynamicContent $HomepageDynamicContent
 */
class HomepageDynamicContentsController extends AppController { 

	public $layout = 'admin';
	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
        $this->set('meta_title','Home Page Team Message');
		$this->HomepageDynamicContent->recursive = 0;
		/*$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('HomepageDynamicContent.id' => 'DESC'));
		$this->set('homepageDynamicContents', $this->paginate());*/
		
		/***** special accouncement *****/
		$specialAnnouncement = $this->HomepageDynamicContent->find("all",array('conditions'=>array('type'=>'s'),'order' => array('sort' => 'ASC','title'=>'ASC')));
		$this->set('homepageDynamicContents',$specialAnnouncement);
		
		/***** President accouncement *****/
		$presidentAnnouncement = $this->HomepageDynamicContent->find("all",array('conditions'=>array('type'=>'p'),'order' => array('sort' => 'ASC','title'=>'ASC')));
		$this->set('presidentAnnouncement',$presidentAnnouncement);
		
	}

/**
 * superadmin_view method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_view($id = null) {
		$this->HomepageDynamicContent->id = $id;
		if (!$this->HomepageDynamicContent->exists()) {
			throw new NotFoundException(__('Invalid homepage dynamic content'));
		}
		$this->set('homepageDynamicContent', $this->HomepageDynamicContent->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
            $errors = '';
            $this->set('meta_title','Add Home Page Team Message');
		if ($this->request->is('post')) {
			$this->HomepageDynamicContent->create();
                        $this->HomepageDynamicContent->set($this->request->data);                          
                        if(!$this->HomepageDynamicContent->validates()) {                           
                            $errors = $this->HomepageDynamicContent->validationErrors;                                
                        }                        
                        if($errors) {
                            $this->set('errors',$errors);
                        }else {  
							// check whether file is uploaded from computer or gallery
                        	if($this->request->data['HomepageDynamicContent']['upload_photo']==0){
								
                        		if(empty($this->request->data['HomepageDynamicContent']['sort']))
								$this->request->data['HomepageDynamicContent']['sort'] ='0';
							  
	                            if(is_array($this->request->data['HomepageDynamicContent']['image']) && $this->request->data['HomepageDynamicContent']['image']['name']!=''){                                                        
	                                App::import('Vendor', 'Uploader.Uploader');
	                                $this->Uploader = new Uploader();
	                                $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/team-message/'));
									$fileUploadPath=$this->Uploader->upload($this->request->data['HomepageDynamicContent']['image'],array('prepend'=>time().'_','overwrite'=>false));                            
									$this->Uploader->resize(array('width' => '150','height' => '80','prepend'=>"150x80_".time()."_",'append'=>false,'aspect'=>true,'expand'=>false));
	                                $this->request->data['HomepageDynamicContent']['image'] = end(explode('/',$fileUploadPath['path'])); 
	                            }else{
									$this->request->data['HomepageDynamicContent']['image'] = '';
								}
								
                        	}else{ // if file is coming from gallery
                        		//copy file from PHOTO_GALLERY to team message.
                        		$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['HomepageDynamicContent']['image1'];
                        		$destination_file_ext 	= end(explode(".",$this->request->data['HomepageDynamicContent']['image1']));
                        		$destination_file_name 	= "150x80_".time().".".$destination_file_ext;
                        		$destination_file_loc 	= WWW_ROOT."img/team-message/".$destination_file_name;
                        		$ok = copy($source_file, $destination_file_loc);
                        		$this->request->data['HomepageDynamicContent']['image'] = time().".".$destination_file_ext;
                        	}	
                        }
						if ($this->HomepageDynamicContent->save($this->request->data)) {
                            $this->Session->write('popup','Team Message has been added successfully.');
                            $this->Session->setFlash('Team Message has been added successfully.');  
                            $this->redirect(array('controller'=>'HomepageDynamicContents','action' => "index/message:success"));
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
		$this->set('meta_title','Edit Home Page Team Message');
		$this->HomepageDynamicContent->id = $id;
		$this->set($this->HomepageDynamicContent->data);
               
		if (!$this->HomepageDynamicContent->exists()) {
			throw new NotFoundException(__('Invalid homepage dynamic content'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    $this->HomepageDynamicContent->set($this->request->data);                          
                        if(!$this->HomepageDynamicContent->validates()) {                           
                            $errors = $this->HomepageDynamicContent->validationErrors;                                
                        }                        
                        if($errors) {
                            $this->set('errors',$errors);
                        }else {     
							App::import('Vendor', 'Uploader.Uploader');
                            $this->Uploader = new Uploader();
							
                            if($this->request->data['HomepageDynamicContent']['upload_photo']==0 && !empty($this->request->data['HomepageDynamicContent']['image']['name'])){
	                            if(is_array($this->request->data['HomepageDynamicContent']['image']) && $this->request->data['HomepageDynamicContent']['image']['name']!=''){                                                        
										$this->Uploader->delete(TEAMMESSAGE.$this->request->data['HomepageDynamicContent']['curr_pic_filename']);
										$this->Uploader->delete(TEAMMESSAGE.'resized_'.$this->request->data['HomepageDynamicContent']['curr_pic_filename']);
										$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/team-message/'));
										$fileUploadPath=$this->Uploader->upload($this->request->data['HomepageDynamicContent']['image'],array('prepend'=>time().'_','overwrite'=>false));                            
										$this->Uploader->resize(array('width' => '150','height' => '80','prepend'=>"150x80_".time()."_",'append'=>false,'aspect'=>true,'expand'=>false));
										$this->request->data['HomepageDynamicContent']['image'] = end(explode('/',$fileUploadPath['path'])); 
	                            }
								else{
										$this->request->data['HomepageDynamicContent']['image'] = $this->request->data['HomepageDynamicContent']['curr_pic_filename'];
									}
			
								
                            }elseif($this->request->data['HomepageDynamicContent']['upload_photo']==1 && !empty($this->request->data['HomepageDynamicContent']['image']['name'])){
	                            	//copy file from PHOTO_GALLERY to team message.
	                            	$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['HomepageDynamicContent']['image1'];
	                            	$destination_file_ext 	= end(explode(".",$this->request->data['HomepageDynamicContent']['image1']));
	                            	$destination_file_name 	= "150x80_".time().".".$destination_file_ext;
	                            	$destination_file_loc 	= WWW_ROOT."img/team-message/".$destination_file_name;
	                            	$ok = copy($source_file, $destination_file_loc);
	                            	// delete old file
	                            	unlink(WWW_ROOT."img/team-message/150x80_".$this->request->data['HomepageDynamicContent']['curr_pic_filename']);
	                            	$this->request->data['HomepageDynamicContent']['image'] = time().".".$destination_file_ext;
                            }else{ 
	                                if($this->request->data['HomepageDynamicContent']['del'] == 'y'){
	                                    $this->request->data['HomepageDynamicContent']['image'] = '';
	                                    $this->Uploader->delete(TEAMMESSAGE.$this->request->data['HomepageDynamicContent']['curr_pic_filename']);
	                                    $this->Uploader->delete(TEAMMESSAGE.'resized_'.$this->request->data['HomepageDynamicContent']['curr_pic_filename']);
	                                }else{
										$this->request->data['HomepageDynamicContent']['image'] = $this->request->data['HomepageDynamicContent']['curr_pic_filename'];
									}
	                        }
                        }                    
             
                    
			if ($this->HomepageDynamicContent->save($this->request->data)) {
			
					$this->Session->write('popup','Team Message has been updated successfully.');
					$this->Session->setFlash('Team Message has been updated successfully.');  
					$this->redirect(array('controller'=>'HomepageDynamicContents','action' => "index/message:success"));
			}
		} else {
			$this->request->data = $this->HomepageDynamicContent->read(null, $id);
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
		$this->HomepageDynamicContent->id = $id;
		if (!$this->HomepageDynamicContent->exists()) {
			throw new NotFoundException(__('Invalid homepage dynamic content'));
		}
		App::import('Vendor', 'Uploader.Uploader');
        $this->Uploader = new Uploader();
		$dynamicContent = $this->HomepageDynamicContent->read(null, $id);
		
		 $this->Uploader->delete(TEAMMESSAGE.$dynamicContent['HomepageDynamicContent']['image']);
         $this->Uploader->delete(TEAMMESSAGE.'resized_'.$dynamicContent['HomepageDynamicContent']['image']);
		 
		if ($this->HomepageDynamicContent->delete()) {
			$this->Session->write('popup','Team Message has been deleted successfully.');
                        $this->Session->setFlash('Team Message has been deleted successfully.');  
                        $this->redirect(array('controller'=>'HomepageDynamicContents','action' => "index/message:success"));
		}
		$this->flash(__('Homepage dynamic content was not deleted'), array('action' => 'index'));
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
		$this->Auth->loginRedirect = array('controller' => 'HomepageDynamicContents', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
		
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
