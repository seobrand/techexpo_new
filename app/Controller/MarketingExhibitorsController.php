<?php 
App::uses('AppController', 'Controller');
/**
 * Locations Controller
 *
 * @property Location $Location
 */
class MarketingExhibitorsController extends AppController {
	var $name = 'MarketingExhibitors';
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
        $this->set('meta_title','Marketing Partner');
		$this->MarketingExhibitor->recursive = -1;
		
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('MarketingExhibitor.pic_id' => 'DESC'));
        $data = $this->paginate('MarketingExhibitor');
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
		$this->MarketingExhibitor->id = $id;
		if (!$this->MarketingExhibitor->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		$this->set('pix', $this->MarketingExhibitor->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
            $errors = '';
            $this->set('meta_title','Add Marketing Partner');
			
		
			
		if ($this->request->is('post')) {			
            $this->MarketingExhibitor->set($this->request->data);                        
            if(!$this->MarketingExhibitor->validates()) {
				$errors = $this->MarketingExhibitor->validationErrors;   
				//pr($errors);                           
			}			
            if($errors) {
               $this->set('errors',$errors);
			}else { 
               if($this->request->data['MarketingExhibitor']['upload_photo']==0){
	               App::import('Vendor', 'Uploader.Uploader');
	               $this->Uploader = new Uploader();
	               $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'marketing_exhibitors'));                            
	               $fileUploadPath=$this->Uploader->upload($this->request->data['MarketingExhibitor']['image'],array('overwrite'=>true));                            
	               $this->Uploader->resize(array('width' => EXHIBITOR_IMGAE_WIDTH,'height' => EXHIBITOR_IMGAE_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
	               $this->request->data['MarketingExhibitor']['image'] = end(explode('/',$fileUploadPath['path']));
               }else{   
	               //copy file from PHOTO_GALLERY to press realese.
	               $source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['MarketingExhibitor']['image1'];
	               $destination_file_ext 	= end(explode(".",$this->request->data['MarketingExhibitor']['image1']));
	               $destination_file_name 	= time().".".$destination_file_ext;
	               $destination_file_loc_resize = WWW_ROOT."marketing_exhibitors/resized_".$destination_file_name;
	               $destination_file_loc_orig 	 = WWW_ROOT."marketing_exhibitors/".$destination_file_name;
	               $ok = copy($source_file, $destination_file_loc_resize);
	               $ok = copy($source_file, $destination_file_loc_orig);	              
	               $this->request->data['MarketingExhibitor']['image'] = $destination_file_name;
               }
               unset($this->request->data['MarketingExhibitor']['image1']);
               
               if($this->MarketingExhibitor->save($this->request->data,false)){
               	 $this->Session->write('popup','Marketing Partner has been added successfully.');
                 $this->Session->setFlash('Marketing Partner has been added successfully.');  
                 $this->redirect(array('controller'=>'marketing_exhibitors','action' => "index/message:success"));
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
		$this->MarketingExhibitor->id = $id;
                $errors = '';
                $this->set('meta_title','Upload Event Pictures');
		if (!$this->MarketingExhibitor->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		
		
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->MarketingExhibitor->set($this->request->data);                        
            if(!$this->MarketingExhibitor->validates()) {
				$errors = $this->MarketingExhibitor->validationErrors;                                
			}			
			if($errors) {
				$this->set('errors',$errors);
			}else {
                       

				if($this->request->data['MarketingExhibitor']['upload_photo']==0){
					if(is_array($this->request->data['MarketingExhibitor']['image']) && $this->request->data['MarketingExhibitor']['image']['name']!=''){
                      if(isset($this->request->data['MarketingExhibitor']['keep_same']) && $this->request->data['MarketingExhibitor']['keep_same']=='0'){ 
						App::import('Vendor', 'Uploader.Uploader');
						$this->Uploader = new Uploader();
						$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'marketing_exhibitors'));                            
						$fileUploadPath=$this->Uploader->upload($this->request->data['MarketingExhibitor']['image'],array('overwrite'=>true));                            
						$this->Uploader->resize(array('width' => EXHIBITOR_IMGAE_WIDTH,'height' => EXHIBITOR_IMGAE_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
						$this->request->data['MarketingExhibitor']['image'] = end(explode('/',$fileUploadPath['path']));
						$this->Uploader->delete(EVENTPICS.$this->request->data['MarketingExhibitor']['curr_pic_filename']);
						$this->Uploader->delete(EVENTPICS.'resized_'.$this->request->data['MarketingExhibitor']['curr_pic_filename']);
						$this->request->data['MarketingExhibitor']['image'] = end(explode('/',$fileUploadPath['path']));
					  }else{
						$this->request->data['MarketingExhibitor']['image'] = $this->request->data['MarketingExhibitor']['curr_pic_filename'];
					  }
                   }else{
                   		$this->request->data['MarketingExhibitor']['image'] = $this->request->data['MarketingExhibitor']['curr_pic_filename'];
                   }
				}else{
					//copy file from PHOTO_GALLERY to press realese.
					$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['MarketingExhibitor']['image1'];
					$destination_file_ext 	= end(explode(".",$this->request->data['MarketingExhibitor']['image1']));
					$destination_file_name 	= time().".".$destination_file_ext;
					$destination_file_loc_resize = WWW_ROOT."marketing_exhibitors/resized_".$destination_file_name;
					$destination_file_loc_orig 	 = WWW_ROOT."marketing_exhibitors/".$destination_file_name;
					$ok = copy($source_file, $destination_file_loc_resize);
					$ok = copy($source_file, $destination_file_loc_orig);
					// delete old file
					@unlink(WWW_ROOT."marketing_exhibitors/resized_".$this->request->data['MarketingExhibitor']['curr_pic_filename']);
					@unlink(WWW_ROOT."marketing_exhibitors/".$this->request->data['MarketingExhibitor']['curr_pic_filename']);
					$this->request->data['MarketingExhibitor']['image'] = $destination_file_name;
				}
                            //pr($this->request->data);exit;
                                if ($this->MarketingExhibitor->save($this->request->data,false)){
                                    $this->Session->write('popup','Marketing Partner has been updated successfully.');
                                    $this->Session->setFlash('Marketing Partner  has been updated successfully.');  
                                    $this->redirect(array('controller'=>'marketing_exhibitors','action' => "index/message:success"));
                                }else{
                                        $this->Session->setFlash(__('The pix could not be saved. Please, try again.'));
                                }                            
                        }
		} else {
			$this->request->data = $this->MarketingExhibitor->read(null, $id);
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
		$this->MarketingExhibitor->id = $id;
		if (!$this->MarketingExhibitor->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		App::import('Vendor', 'Uploader.Uploader');
        $this->Uploader = new Uploader();
		$eventContent = $this->MarketingExhibitor->read(null, $id);
	    $this->Uploader->delete(WWW_ROOT.'marketing_exhibitors/'.$eventContent['MarketingExhibitor']['image']);
	    $this->Uploader->delete(WWW_ROOT.'marketing_exhibitors/'.'resized_'.$eventContent['MarketingExhibitor']['image']);
	 
		if ($this->MarketingExhibitor->delete()) {
			$this->Session->write('popup','Event Picture has been deleted successfully.');
			$this->Session->setFlash('Event Picture has been deleted successfully.');  
			$this->redirect(array('controller'=>'marketing_exhibitors','action' => "index/message:success"));
		}
		$this->Session->setFlash(__('Marketing Partner was not deleted'));
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
		$this->Auth->loginRedirect = array('controller' => 'marketing_exhibitors', 'action' => 'index','superadmin'=>true);
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