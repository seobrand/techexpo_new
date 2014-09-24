<?php
App::uses('AppController', 'Controller');
/**
 * Pixes Controller
 *
 * @property Pix $Pix
 */
class PixesController extends AppController {
    public $layout = 'admin';
    var $helpers = array('Html','Paginator','Ajax','Javascript','Text');
	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');

/*
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
        $this->set('meta_title','Event Pictures');
		$this->Pix->recursive = -1;
		
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('Pix.pic_id' => 'DESC'));
        $data = $this->paginate('Pix');
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
		$this->Pix->id = $id;
		if (!$this->Pix->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		$this->set('pix', $this->Pix->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
            $errors = '';
            $this->set('meta_title','Upload Event Pictures');
			
		// Generate Event list
		$this->loadModel('Show');
		$event_list =  $this->Show->find("list", array("fields" => array("id", 'show_name')));
		$this->set('event_list',$event_list);
			
		if ($this->request->is('post')) {			
            $this->Pix->set($this->request->data);                        
            if(!$this->Pix->validates()) {
				$errors = $this->Pix->validationErrors;                                
			}			
            if($errors) {
               $this->set('errors',$errors);
			}else {
               if($this->request->data['Pix']['upload_photo']==0){
	               App::import('Vendor', 'Uploader.Uploader');
	               $this->Uploader = new Uploader();
	               $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/event-pics'));                            
	               $fileUploadPath=$this->Uploader->upload($this->request->data['Pix']['pic_filename'],array('overwrite'=>true));                            
	               $this->Uploader->resize(array('width' => EVENT_PIX_WIDTH,'height' => EVENT_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
	               $this->request->data['Pix']['pic_filename'] = end(explode('/',$fileUploadPath['path']));
               }else{   
	               //copy file from PHOTO_GALLERY to press realese.
	               $source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['Pix']['pic_filename1'];
	               $destination_file_ext 	= end(explode(".",$this->request->data['Pix']['pic_filename1']));
	               $destination_file_name 	= time().".".$destination_file_ext;
	               $destination_file_loc_resize = WWW_ROOT."img/event-pics/resized_".$destination_file_name;
	               $destination_file_loc_orig 	 = WWW_ROOT."img/event-pics/".$destination_file_name;
	               $ok = copy($source_file, $destination_file_loc_resize);
	               $ok = copy($source_file, $destination_file_loc_orig);	              
	               $this->request->data['Pix']['pic_filename'] = $destination_file_name;
               }
               unset($this->request->data['Pix']['pic_filename1']);
               
               if($this->Pix->save($this->request->data,false)){
               	 $this->Session->write('popup','Event Picture has been added successfully.');
                 $this->Session->setFlash('Event Picture has been added successfully.');  
                 $this->redirect(array('controller'=>'pixes','action' => "index/message:success"));
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
		$this->Pix->id = $id;
                $errors = '';
                $this->set('meta_title','Upload Event Pictures');
		if (!$this->Pix->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		
		// Generate Event list
		$this->loadModel('Show');
		$event_list =  $this->Show->find("list", array("fields" => array("id", 'show_name')));
		$this->set('event_list',$event_list);
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Pix->set($this->request->data);                        
            if(!$this->Pix->validates()) {
				$errors = $this->Pix->validationErrors;                                
			}			
			if($errors) {
				$this->set('errors',$errors);
			}else {
                       

				if($this->request->data['Pix']['upload_photo']==0){
					if(is_array($this->request->data['Pix']['pic_filename']) && $this->request->data['Pix']['pic_filename']['name']!=''){
                      if(isset($this->request->data['Pix']['keep_same']) && $this->request->data['Pix']['keep_same']=='0'){ 
						App::import('Vendor', 'Uploader.Uploader');
						$this->Uploader = new Uploader();
						$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/event-pics'));                            
						$fileUploadPath=$this->Uploader->upload($this->request->data['Pix']['pic_filename'],array('overwrite'=>true));                            
						$this->Uploader->resize(array('width' => EVENT_PIX_WIDTH,'height' => EVENT_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
						$this->request->data['Pix']['pic_filename'] = end(explode('/',$fileUploadPath['path']));
						$this->Uploader->delete(EVENTPICS.$this->request->data['Pix']['curr_pic_filename']);
						$this->Uploader->delete(EVENTPICS.'resized_'.$this->request->data['Pix']['curr_pic_filename']);
						$this->request->data['Pix']['pic_filename'] = end(explode('/',$fileUploadPath['path']));
					  }else{
						$this->request->data['Pix']['pic_filename'] = $this->request->data['Pix']['curr_pic_filename'];
					  }
                   }else{
                   		$this->request->data['Pix']['pic_filename'] = $this->request->data['Pix']['curr_pic_filename'];
                   }
				}else{
					//copy file from PHOTO_GALLERY to press realese.
					$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['Pix']['pic_filename1'];
					$destination_file_ext 	= end(explode(".",$this->request->data['Pix']['pic_filename1']));
					$destination_file_name 	= time().".".$destination_file_ext;
					$destination_file_loc_resize = WWW_ROOT."img/event-pics/resized_".$destination_file_name;
					$destination_file_loc_orig 	 = WWW_ROOT."img/event-pics/".$destination_file_name;
					$ok = copy($source_file, $destination_file_loc_resize);
					$ok = copy($source_file, $destination_file_loc_orig);
					// delete old file
					@unlink(WWW_ROOT."img/event-pics/resized_".$this->request->data['Pix']['curr_pic_filename']);
					@unlink(WWW_ROOT."img/event-pics/".$this->request->data['Pix']['curr_pic_filename']);
					$this->request->data['Pix']['pic_filename'] = $destination_file_name;
				}
                            //pr($this->request->data);exit;
                                if ($this->Pix->save($this->request->data,false)){
                                    $this->Session->write('popup','Event Picture has been updated successfully.');
                                    $this->Session->setFlash('Event Picture has been updated successfully.');  
                                    $this->redirect(array('controller'=>'pixes','action' => "index/message:success"));
                                }else{
                                        $this->Session->setFlash(__('The pix could not be saved. Please, try again.'));
                                }                            
                        }
		} else {
			$this->request->data = $this->Pix->read(null, $id);
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
		$this->Pix->id = $id;
		if (!$this->Pix->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		App::import('Vendor', 'Uploader.Uploader');
        $this->Uploader = new Uploader();
		$eventContent = $this->Pix->read(null, $id);
	    $this->Uploader->delete(EVENTPICS.$eventContent['Pix']['pic_filename']);
	    $this->Uploader->delete(EVENTPICS.'resized_'.$eventContent['Pix']['pic_filename']);
	 
		if ($this->Pix->delete()) {
			$this->Session->write('popup','Event Picture has been deleted successfully.');
			$this->Session->setFlash('Event Picture has been deleted successfully.');  
			$this->redirect(array('controller'=>'pixes','action' => "index/message:success"));
		}
		$this->Session->setFlash(__('Pix was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
	/**
 * Front index method
 *
 * 
 * @return void
 */
	public function index($eventID = null) {
		$this->layout= 'front';
		$event_list = $this->Pix->find("all",array('order' => array('Pix.pic_id DESC')));
		foreach($event_list as $events){
			if($events['Show']['id']!='')
				$event[$events['Show']['id']] =  $events['Show']['show_name'];
		}
		/*pr($event_list);
		pr($event);*/
		$this->set('event',$event);
		if($eventID!='' && $eventID!='0'){
			$this->request->data['show_id'] = $eventID;
			$event_list_byid = $this->Pix->find("all",array('conditions'=>array('event_id'=>$eventID),'order' => array('Pix.pic_id DESC')));
			$this->set('event_list',$event_list_byid);
		}else{
			$this->set('event_list',$event_list);
		}
	}	
		
	public function photodetail($id = null) {
		$this->layout= 'front';
		
		$event_list = $this->Pix->find("all",array('order' => array('Pix.pic_id DESC'),'conditions' => array('Pix.event_id'=> $id)));
		$this->set('event_list',$event_list);
		}
		
        /* This function is used to call before  */
	function beforeFilter() { 
	
		parent::beforeFilter();
		
		if($this->Session->read('Auth.Client.User.user_type')=='E')
		{
			$this->Auth->allow('index','photodetail');
		}
		
		$this->Auth->allow('index');
		
		
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
         );
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		
		
		$this->Auth->allow('login');
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
