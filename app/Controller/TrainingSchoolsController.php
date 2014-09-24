<?php
App::uses('AppController', 'Controller');
/**
 * Locations Controller
 *
 * @property Location $Location
 */
class TrainingSchoolsController extends AppController {

    var $layout = 'admin'; //this is the layout for admin panel     
	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some required helpers to this controller
 	
    var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
/**
 * index method
 *
 * @return void
 */
	public function superadmin_index() { 
		$this->set('meta_title','Training Schools');
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('TrainingSchool.ts_name' => 'ASC'));
        $data = $this->paginate('TrainingSchool');
        //pr($data);
		$this->set('ts', $data);	
		
	}


/**
 * superadmin_view method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_view($id = null) {
		$this->TrainingSchool->id = $id;
                $this->set('meta_title','View Training School');
		if (!$this->TrainingSchool->exists()) {
			throw new NotFoundException(__('Invalid location'));
		}
		$this->set('location', $this->TrainingSchool->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
		$errors ='';
		$this->set('meta_title','Add New Training School');
		$this->loadModel('State');
		$fields = array('state_abrev','state_name');
		$states = $this->State->find('list',array('fields'=>$fields));
		$this->set('states',$states);  
		
		
		$destination = 'TrainingSchoolDocument/';
		
		
		if($this->request->is('post')) {		
				$this->TrainingSchool->set($this->request->data);	
			
			if(!$this->TrainingSchool->validates()){		
				$errors = $this->TrainingSchool->validationErrors;                            
			}	
			if($errors) {			
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				if($this->request->data['TrainingSchool']['upload_photo']==0){
					App::import('Vendor', 'Uploader.Uploader');
					$this->Uploader = new Uploader();
					$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/TrainingSchools'));
					$fileUploadPath=$this->Uploader->upload($this->request->data['TrainingSchool']['ts_logo_path'],array('overwrite'=>true));
					$this->Uploader->resize(array('width' => TS_PIX_WIDTH,'height' => TS_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
					$this->request->data['TrainingSchool']['ts_logo_path'] 	=  end(explode('/',$fileUploadPath['path']));
				}else{
					//copy file from PHOTO_GALLERY to press realese.
					$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['TrainingSchool']['ts_logo_path1'];
					$destination_file_ext 	= end(explode(".",$this->request->data['TrainingSchool']['ts_logo_path1']));
					$destination_file_name 	= time().".".$destination_file_ext;
					$destination_file_loc_resize = WWW_ROOT."img/TrainingSchools/resized_".$destination_file_name;
					$destination_file_loc_orig 	 = WWW_ROOT."img/TrainingSchools/".$destination_file_name;
					$ok = copy($source_file, $destination_file_loc_resize);
					$ok = copy($source_file, $destination_file_loc_orig);					
					$this->request->data['TrainingSchool']['ts_logo_path'] = $destination_file_name;
				}
					
					
				if ($this->TrainingSchool->save($this->request->data,false)) {
					$this->Session->write('popup','Training School has been added successfully.');
					$this->Session->setFlash('Training School has been added successfully.');  
					$this->redirect(array('controller'=>'training_schools','action' => "index/message:success"));
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
	public function superadmin_edit($ts_id = null) {
			$errors	=	'';
			$this->loadModel('State');
			$fields = array('state_abrev','state_name');
			$states = $this->State->find('list',array('fields'=>$fields));
			$this->set('states',$states);
			
		
            $this->set('meta_title','Edit Training School');
			$this->set('id',$ts_id);
			
			if ($this->request->is('get')) {
				$this->request->data = $this->TrainingSchool->find('first',array('conditions'=>array('id'=>$ts_id)));
			} else {
			
				$this->TrainingSchool->set($this->request->data);	
			
				if(!$this->TrainingSchool->validates()){		
					$errors = $this->TrainingSchool->validationErrors;                            
				}	
				
				if($errors) {			
					$this->Set('errors',$errors);
					$this->set('data',$this->request->data);
				}else{
					
					$is_keep_logo= $this->request->data['TrainingSchool']['keep_logo_same'];
					App::import('Vendor', 'Uploader.Uploader');
					$this->Uploader = new Uploader();
					
					if($is_keep_logo!=0){
						$this->request->data['TrainingSchool']['ts_logo_path'] = $this->request->data['TrainingSchool']['old_logo'];
					}else{
												
						if($this->request->data['TrainingSchool']['upload_photo']==0){
							if($this->request->data['TrainingSchool']['ts_logo_path']['error']==4){
								$this->Uploader->delete(TS.$this->request->data['TrainingSchool']['old_logo']);
								$this->Uploader->delete(TS.'resized_'.$this->request->data['TrainingSchool']['old_logo']);
								$this->request->data['TrainingSchool']['ts_logo_path'] = '';
							}else{
								$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/TrainingSchools'));
								$this->Uploader->remove(WWW_ROOT.'img/TrainingSchools/'.$this->request->data['TrainingSchool']['old_logo']);
								$this->Uploader->remove(WWW_ROOT.'img/TrainingSchools/resized_'.$this->request->data['TrainingSchool']['old_logo']);
								$fileUploadPath=$this->Uploader->upload($this->request->data['TrainingSchool']['ts_logo_path'],array('overwrite'=>true));
								$this->Uploader->resize(array('width' => TS_PIX_WIDTH,'height' => TS_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
								$this->request->data['TrainingSchool']['ts_logo_path'] 	=  end(explode('/',$fileUploadPath['path']));
							}
						}else{
							//copy file from PHOTO_GALLERY to press realese.
							$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['TrainingSchool']['ts_logo_path1'];
							$destination_file_ext 	= end(explode(".",$this->request->data['TrainingSchool']['ts_logo_path1']));
							$destination_file_name 	= time().".".$destination_file_ext;
							$destination_file_loc_resize = WWW_ROOT."img/TrainingSchools/resized_".$destination_file_name;
							$destination_file_loc_orig 	 = WWW_ROOT."img/TrainingSchools/".$destination_file_name;
							$ok = copy($source_file, $destination_file_loc_resize);
							$ok = copy($source_file, $destination_file_loc_orig);
							// delete old file
							@unlink(WWW_ROOT."img/TrainingSchools/resized_".$this->request->data['TrainingSchool']['old_logo']);
							@unlink(WWW_ROOT."img/TrainingSchools/".$this->request->data['TrainingSchool']['old_logo']);
							$this->request->data['TrainingSchool']['ts_logo_path'] = $destination_file_name;
						}
						
					}
					
				
					if ($this->TrainingSchool->save($this->request->data,false)) {
						$this->Session->write('popup','Training School has been updated successfully.');
						$this->Session->setFlash('Training School has been updated successfully.');  
						$this->redirect(array('controller'=>'training_schools','action' => "index/message:success"));
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'training_schools','action' => "edit",$location_id));
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
		}else{
			$this->request->data = $this->TrainingSchool->find('first',array('conditions'=>array('id'=>$id)));						
			
			App::import('Vendor', 'Uploader.Uploader');
			$this->Uploader = new Uploader();
				
			if($this->request->data['TrainingSchool']['ts_logo_path']!=NULL) {
				$this->Uploader->remove(WWW_ROOT.'img/TrainingSchools/'.$this->request->data['TrainingSchool']['ts_logo_path']);
				$this->Uploader->remove(WWW_ROOT.'img/TrainingSchools/resized_'.$this->request->data['TrainingSchool']['ts_logo_path']);
			}		
				
			if ($this->TrainingSchool->delete($id)) {
				$this->Session->write('popup','Training School has been deleted successfully.');
				$this->Session->setFlash('Training School has been deleted successfully.');  
				$this->redirect(array('controller'=>'training_schools','action' => "index/message:success")); 
			} else {
				$this->Session->setFlash('Deletion problem, Please try again.');  
				$this->redirect(array('controller'=>'training_schools','action' => "index"));

			}
		}	
	}
	/**
 * Front index method
 *
 *
 * @return void
 */
	public function index() {	
	
		$this->layout = 'front';
		
		$this->set('trainingschools',$this->TrainingSchool->find('all',array('fields'=>'ts_profile,ts_logo_path,ts_web')));
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
		$this->Auth->loginRedirect = array('controller' => 'EmployerSiteUsages', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');		
   	}
	
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
	