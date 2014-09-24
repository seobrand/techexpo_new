<?php 
App::uses('AppController', 'Controller');
/**
 * Locations Controller
 *
 * @property Location $Location
 */
class ExhibitorsController extends AppController {
	var $name = 'Exhibitors';
    var $layout = 'admin'; //this is the layout for admin panel    
	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some required helpers to this controller
 	
    var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
/**
 * index method
 *
 * @return void
 */
	/*public function superadmin_index() { 
		$this->set('meta_title','Techexpo Exhibitors');
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('order' => array('Exhibitor.ts_name' => 'ASC'));
        $data = $this->paginate('Exhibitor');
        //pr($data);
		$this->set('exhibitor', $data);	
		
	}*/
	
	public function superadmin_index() {
        $this->set('meta_title','Exhibitor');
		$this->Exhibitor->recursive = -1;
		
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('Exhibitor.pic_id' => 'DESC'));
        $data = $this->paginate('Exhibitor');
       // pr($data);
		$this->set('pixes', $data);	
	}

/**
 * superadmin_view method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_view($id = null) {
		$this->Exhibitor->id = $id;
		if (!$this->Exhibitor->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		$this->set('pix', $this->Exhibitor->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
            $errors = '';
            $this->set('meta_title','Add exhibitor');
			
		
			
		if ($this->request->is('post')) {			
            $this->Exhibitor->set($this->request->data);                        
            if(!$this->Exhibitor->validates()) {
				$errors = $this->Exhibitor->validationErrors;   
				//pr($errors);                           
			}			
            if($errors) {
               $this->set('errors',$errors);
			}else { 
               if($this->request->data['Exhibitor']['upload_photo']==0){
	               App::import('Vendor', 'Uploader.Uploader');
	               $this->Uploader = new Uploader();
	               $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'exhibitors'));                            
	               $fileUploadPath=$this->Uploader->upload($this->request->data['Exhibitor']['image'],array('overwrite'=>true));                            
	               $this->Uploader->resize(array('width' => EXHIBITOR_IMGAE_WIDTH,'height' => EXHIBITOR_IMGAE_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
	               $this->request->data['Exhibitor']['image'] = end(explode('/',$fileUploadPath['path']));
               }else{   
	               //copy file from PHOTO_GALLERY to press realese.
	               $source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['Exhibitor']['image1'];
	               $destination_file_ext 	= end(explode(".",$this->request->data['Exhibitor']['image1']));
	               $destination_file_name 	= time().".".$destination_file_ext;
	               $destination_file_loc_resize = WWW_ROOT."exhibitors/resized_".$destination_file_name;
	               $destination_file_loc_orig 	 = WWW_ROOT."exhibitors/".$destination_file_name;
	               $ok = copy($source_file, $destination_file_loc_resize);
	               $ok = copy($source_file, $destination_file_loc_orig);	              
	               $this->request->data['Exhibitor']['image'] = $destination_file_name;
               }
               unset($this->request->data['Exhibitor']['image1']);
               
               if($this->Exhibitor->save($this->request->data,false)){
               	 $this->Session->write('popup','Exhibitor has been added successfully.');
                 $this->Session->setFlash('Exhibitors has been added successfully.');  
                 $this->redirect(array('controller'=>'exhibitors','action' => "index/message:success"));
               }else{
               	 $this->Session->setFlash(__('The pix could not be saved. Please, try again.'));
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
		$this->Exhibitor->id = $id;
                $errors = '';
                $this->set('meta_title','Upload Event Pictures');
		if (!$this->Exhibitor->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		
		
		
		if ($this->request->is('post') || $this->request->is('put')) {
			
		
		
		if(empty($this->request->data['Exhibitor']['image']['name']) &&  $this->request->data['Exhibitor']['keep_same']=='y' && $this->request->data['Exhibitor']['upload_photo']!=1 )
		{
		
		unset($this->request->data['Exhibitor']['image']);
		}
			
			$this->Exhibitor->set($this->request->data);                        
            if(!$this->Exhibitor->validates()) {
				$errors = $this->Exhibitor->validationErrors;                                
			}			
			if($errors) {
				$this->set('errors',$errors);
			}else {
          
				
				if($this->request->data['Exhibitor']['upload_photo']==0){
					if(is_array($this->request->data['Exhibitor']['image']) && $this->request->data['Exhibitor']['image']['name']!=''){
                      if(isset($this->request->data['Exhibitor']['keep_same']) && $this->request->data['Exhibitor']['keep_same']=='0'){ 
						App::import('Vendor', 'Uploader.Uploader');
						$this->Uploader = new Uploader();
						$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'exhibitors'));                            
						$fileUploadPath=$this->Uploader->upload($this->request->data['Exhibitor']['image'],array('overwrite'=>true));                            
						$this->Uploader->resize(array('width' => EXHIBITOR_IMGAE_WIDTH,'height' => EXHIBITOR_IMGAE_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
						$this->request->data['Exhibitor']['image'] = end(explode('/',$fileUploadPath['path']));
						$this->Uploader->delete(EVENTPICS.$this->request->data['Exhibitor']['curr_pic_filename']);
						$this->Uploader->delete(EVENTPICS.'resized_'.$this->request->data['Exhibitor']['curr_pic_filename']);
						$this->request->data['Exhibitor']['image'] = end(explode('/',$fileUploadPath['path']));
					  }else{
						$this->request->data['Exhibitor']['image'] = $this->request->data['Exhibitor']['curr_pic_filename'];
					  }
                   }else{
                   		$this->request->data['Exhibitor']['image'] = $this->request->data['Exhibitor']['curr_pic_filename'];
                   }
				}else{
					//copy file from PHOTO_GALLERY to press realese.
					if(isset($this->request->data['Exhibitor']['keep_same']) && $this->request->data['Exhibitor']['keep_same']=='0'){
					$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['Exhibitor']['image1'];
					$destination_file_ext 	= end(explode(".",$this->request->data['Exhibitor']['image1']));
					$destination_file_name 	= time().".".$destination_file_ext;
					$destination_file_loc_resize = WWW_ROOT."exhibitors/resized_".$destination_file_name;
					$destination_file_loc_orig 	 = WWW_ROOT."exhibitors/".$destination_file_name;
					$ok = copy($source_file, $destination_file_loc_resize);
					$ok = copy($source_file, $destination_file_loc_orig);
					// delete old file
					@unlink(WWW_ROOT."exhibitors/resized_".$this->request->data['Exhibitor']['curr_pic_filename']);
					@unlink(WWW_ROOT."exhibitors/".$this->request->data['Exhibitor']['curr_pic_filename']);
					$this->request->data['Exhibitor']['image'] = $destination_file_name;
					}
				}
                            //pr($this->request->data);exit;
                                if ($this->Exhibitor->save($this->request->data,false)){
                                    $this->Session->write('popup','Exhibitors has been updated successfully.');
                                    $this->Session->setFlash('Exhibitors has been updated successfully.');  
                                    $this->redirect(array('controller'=>'exhibitors','action' => "index/message:success"));
                                }else{
                                        $this->Session->setFlash(__('The pix could not be saved. Please, try again.'));
                                }                            
                        }
		}
		$this->request->data = $this->Exhibitor->read(null, $id);
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
		$this->Exhibitor->id = $id;
		if (!$this->Exhibitor->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		App::import('Vendor', 'Uploader.Uploader');
        $this->Uploader = new Uploader();
		$eventContent = $this->Exhibitor->read(null, $id);
	    $this->Uploader->delete(WWW_ROOT.'exhibitors/'.$eventContent['Exhibitor']['image']);
	    $this->Uploader->delete(WWW_ROOT.'exhibitors/'.'resized_'.$eventContent['Exhibitor']['image']);
	 
		if ($this->Exhibitor->delete()) {
			$this->Session->write('popup','Event Picture has been deleted successfully.');
			$this->Session->setFlash('Event Picture has been deleted successfully.');  
			$this->redirect(array('controller'=>'exhibitors','action' => "index/message:success"));
		}
		$this->Session->setFlash(__('Exhibitor was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	function beforeFilter() { 
		
            parent::beforeFilter();
                
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
        
        
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		$this->Auth->allow('login','index');
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','superadmin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'exhibitors', 'action' => 'index','superadmin'=>true);
		$this->Auth->userScope = array('Adminclient.active' => 'yes');
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	}     
	
}
?>