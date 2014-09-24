<?php
App::uses('AppController', 'Controller');
/**
 * Pixes Controller
 *
 * @property Testimonial $Testimonial
 */
class TestimonialsController extends AppController {
    public $layout = 'admin';
    var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); 
    var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array('EmployerVideo','CandidateVideo','Testimonial','PageContent');

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
        $this->set('meta_title','Testimonials');
		$this->Testimonial->recursive = 0;
		
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('Testimonial.name' => 'ASC'),'conditions'=> array('Testimonial.aprov'=>'1'));
        $data = $this->paginate('Testimonial');
        //pr($data);
		$this->set('testimonials', $data);
	}


		public function superadmin_testimonailApproval($id=null) {
        $this->set('meta_title','Testimonials');
		$this->Testimonial->recursive = 0;
		
		
		
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order'=> array('Testimonial.name' => 'ASC'),'conditions'=> array('Testimonial.aprov=0'));
        $data = $this->paginate('Testimonial');
        //pr($data);
		$this->set('testimonials', $data);
		
		if($id)
		{
			$testimonail['Testimonial']['id']=$id;
			$testimonail['Testimonial']['aprov']=1;
			
			  if ($this->Testimonial->save($testimonail)){
                                $this->Session->write('popup','Testimonial has been approved successfully.');
                                $this->Session->setFlash('Testimonial has been approved successfully.');  
                                $this->redirect(array('controller'=>'testimonials','action' => "testimonailApproval/message:success"));
                            }else{
                                    $this->Session->setFlash(__('The Testimonial could not be approve. Please, try again.'));
                            }
		}
	}

	public function superadmin_privacyPolicy() {
		$this->set('meta_title','Privacy Policy');
		$errors = "";
		
		if($this->request->is('get')){
			$this->request->data = $this->PageContent->findById('1');			
		}else{
			$this->PageContent->set($this->request->data);
			if(!$this->PageContent->validates()){
				$errors = $this->PageContent->validationErrors;
			}
			if($errors) {
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				
				if ($this->PageContent->save($this->request->data)){
					$this->Session->write('popup','Privacy policy has been changed successfully.');
					$this->Session->setFlash('Privacy policy has been changed successfully.');
					$this->redirect(array('controller'=>'testimonials','action' => "privacyPolicy/message:success"));
				}else{
					$this->Session->setFlash(__('Privacy Policy could not be changed. Please, try again.'));
				}
			}	
		}
	}
	
	public function superadmin_resumewriting() {
		$this->set('meta_title','Resume Writing');
		$errors = "";
		
		
		if($this->request->is('get')){
			$this->request->data = $this->PageContent->findById('3');			
		}else{
			$this->PageContent->set($this->request->data);
			if(!$this->PageContent->validates()){
				$errors = $this->PageContent->validationErrors;
			}
			if($errors) {
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				
				if ($this->PageContent->save($this->request->data)){
					$this->Session->write('popup','Resume Writing has been changed successfully.');
					$this->Session->setFlash('Resume Writing has been changed successfully.');
					$this->redirect(array('controller'=>'testimonials','action' => "resumewriting/message:success"));
				}else{
					$this->Session->setFlash(__('Resume could not be changed. Please, try again.'));
				}
			}	
		}
	}
	
	public function superadmin_termsOfUse() {
		$this->set('meta_title','Terms Of Use');
		$errors = "";
	
		if($this->request->is('get')){
			$this->request->data = $this->PageContent->findById('2');
		}else{
			$this->PageContent->set($this->request->data);
			if(!$this->PageContent->validates()){
				$errors = $this->PageContent->validationErrors;
			}
			if($errors) {
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
	
				if ($this->PageContent->save($this->request->data)){
					$this->Session->write('popup','Terms of use has been changed successfully.');
					$this->Session->setFlash('Terms of use has been changed successfully.');
					$this->redirect(array('controller'=>'testimonials','action' => "termsOfUse/message:success"));
				}else{
					$this->Session->setFlash(__('Terms of use could not be changed. Please, try again.'));
				}
			}
		}
	}
	
		public function superadmin_whyattend() {
		$this->set('meta_title','Why Attend');
		$errors = "";
		
		if($this->request->is('get')){
			$this->request->data = $this->PageContent->findById('4');			
		}else{
			$this->PageContent->set($this->request->data);
			if(!$this->PageContent->validates()){
				$errors = $this->PageContent->validationErrors;
			}
			if($errors) {
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				
				if ($this->PageContent->save($this->request->data)){
					$this->Session->write('popup','Why attend has been changed successfully.');
					$this->Session->setFlash('Why attend has been changed successfully.');
					$this->redirect(array('controller'=>'testimonials','action' => "whyattend/message:success"));
				}else{
					$this->Session->setFlash(__('Why attend could not be changed. Please, try again.'));
				}
			}	
		}
	}

/**
 * superadmin_view method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_view($id = null) {
		$this->Testimonial->id = $id;
		if (!$this->Testimonial->exists()) {
			throw new NotFoundException(__('Invalid Testimonial'));
		}
		$this->set('testimonial', $this->Testimonial->read(null, $id));
	}

/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
            $errors = '';
            $this->set('meta_title','Add Testimonial');
		if ($this->request->is('post')) {			
                        $this->Testimonial->set($this->request->data);                        
                        if(!$this->Testimonial->validates()) {
				$errors = $this->Testimonial->validationErrors;                                
			}			
                        if($errors) {
                            $this->set('errors',$errors);
			}else {
			
			
			                            
                            if(!$this->request->data['Testimonial']['sort']) {
                                $this->request->data['Testimonial']['sort'] = $this->Testimonial->field('MAX(sort)')+1;
                            }
                            
                            if($this->request->data['Testimonial']['upload_photo']==0){
	                            App::import('Vendor', 'Uploader.Uploader');
	                            $this->Uploader = new Uploader();
	                            $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/testimonial'));                            
	                            $fileUploadPath=$this->Uploader->upload($this->request->data['Testimonial']['logo_file'],array('overwrite'=>false));                            
	                            $this->Uploader->resize(array('width' => TEST_PIX_WIDTH,'height' => TEST_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
	                            $this->request->data['Testimonial']['logo_file'] = end(explode('/',$fileUploadPath['path']));
							}else{
								//copy file from PHOTO_GALLERY to press realese.
								$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['Testimonial']['logo_file1'];
								$destination_file_ext 	= end(explode(".",$this->request->data['Testimonial']['logo_file1']));
								$destination_file_name 	= time().".".$destination_file_ext;
								$destination_file_loc_resize = WWW_ROOT."img/testimonial/resized_".$destination_file_name;
								$destination_file_loc_orig 	 = WWW_ROOT."img/testimonial/".$destination_file_name;
								$ok = copy($source_file, $destination_file_loc_resize);
								$ok = copy($source_file, $destination_file_loc_orig);								
								$this->request->data['Testimonial']['logo_file'] = $destination_file_name;
							}
							
                            if ($this->Testimonial->save($this->request->data,false)){
                                $this->Session->write('popup','Testimonial has been added successfully.');
                                $this->Session->setFlash('Testimonial has been added successfully.');  
                                $this->redirect(array('controller'=>'testimonials','action' => "index/message:success"));
                            }else{
                                    $this->Session->setFlash(__('The Testimonial could not be saved. Please, try again.'));
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
		$this->Testimonial->id = $id;
                $errors = '';
                $this->set('meta_title','Update Testimonial');
		if (!$this->Testimonial->exists()) {
			throw new NotFoundException(__('Invalid Testimonial'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Testimonial->set($this->request->data);                        
                        if(!$this->Testimonial->validates()) {
				$errors = $this->Testimonial->validationErrors;                                
			}			
                        if($errors) {
                            $this->set('errors',$errors);
			}else {
                            /*if(!$this->request->data['Testimonial']['sort']) {
                                $this->request->data['Testimonial']['sort'] = $this->Testimonial->field('MAX(sort)')+1;
                            }*/
                            //pr($this->request->data);exit;
						if($this->request->data['Testimonial']['upload_photo']==0){
                            if(is_array($this->request->data['Testimonial']['logo_file']) && $this->request->data['Testimonial']['logo_file']['name']!=''){
                                App::import('Vendor', 'Uploader.Uploader');
                                $this->Uploader = new Uploader();
                                $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/testimonial'));                            
                                $fileUploadPath=$this->Uploader->upload($this->request->data['Testimonial']['logo_file'],array('overwrite'=>false));                            
                                $this->Uploader->resize(array('width' => TEST_PIX_WIDTH,'height' => TEST_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
                                $this->request->data['Testimonial']['logo_file'] = end(explode('/',$fileUploadPath['path']));
                                $this->Uploader->delete(TESTIMONIAL.$this->request->data['Testimonial']['curr_pic_filename']);
							    $this->Uploader->delete(TESTIMONIAL.'resized_'.$this->request->data['Testimonial']['curr_pic_filename']);

                            }else{
                                $this->request->data['Testimonial']['logo_file'] = $this->request->data['Testimonial']['curr_pic_filename'];
                            }
						}else{   
                            
                            //copy file from PHOTO_GALLERY to press realese.
                            $source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['Testimonial']['logo_file1'];
                            $destination_file_ext 	= end(explode(".",$this->request->data['Testimonial']['logo_file1']));
                            $destination_file_name 	= time().".".$destination_file_ext;
                            $destination_file_loc_resize = WWW_ROOT."img/testimonial/resized_".$destination_file_name;
                            $destination_file_loc_orig 	 = WWW_ROOT."img/testimonial/".$destination_file_name;
                            $ok = copy($source_file, $destination_file_loc_resize);
                            $ok = copy($source_file, $destination_file_loc_orig);
                            // delete old file
                            @unlink(WWW_ROOT."img/testimonial/resized_".$this->request->data['Testimonial']['curr_pic_filename']);
                            @unlink(WWW_ROOT."img/testimonial/".$this->request->data['Testimonial']['curr_pic_filename']);
                            $this->request->data['Testimonial']['logo_file'] = $destination_file_name;
                            
						}    
                            //pr($this->request->data);exit;
                                if ($this->Testimonial->save($this->request->data,false)){
                                    $this->Session->write('popup','Testimonial has been updated successfully.');
                                    $this->Session->setFlash('Testimonial has been updated successfully.');  
                                    $this->redirect(array('controller'=>'testimonials','action' => "index/message:success"));
                                }else{
                                        $this->Session->setFlash(__('The Testimonial could not be saved. Please, try again.'));
                                        $this->Uploader->delete($this->request->data['Testimonial']['logo_file']);
                                }                            
                        }
		} else {
			$this->request->data = $this->Testimonial->read(null, $id);
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
		$this->Testimonial->id = $id;
		if (!$this->Testimonial->exists()) {
			throw new NotFoundException(__('Invalid Testimonial'));
		}
		$this->request->data = $this->Testimonial->find('first',array('conditions'=>array('id'=>$id)));						
			
		App::import('Vendor', 'Uploader.Uploader');
		$this->Uploader = new Uploader();
			
		if($this->request->data['Testimonial']['logo_file']!=NULL) {
			$this->Uploader->remove(WWW_ROOT.'img/testimonial/'.$this->request->data['Testimonial']['logo_file']);
			$this->Uploader->remove(WWW_ROOT.'img/testimonial/resized_'.$this->request->data['Testimonial']['logo_file']);
		}
		
		if ($this->Testimonial->delete()) {
			$this->Session->write('popup','Testimonial has been deleted successfully.');
                        $this->Session->setFlash('Testimonial has been deleted successfully.');  
                        $this->redirect(array('controller'=>'testimonials','action' => "index/message:success"));
		}
		$this->Session->setFlash(__('Testimonial was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
	/**
 * front index method
 *
 * @return void
 */
	public function index($type=null) {
        $this->set('meta_title','Testimonials');
		$this->layout = 'front';
		if(isset($this->request->params['pass'][0])){
			$testimonial_type = $this->request->params['pass'][0];
			$this->set('testimonial_type',$testimonial_type);
		}
		
		$testimonials_emp = $this->Testimonial->find('all',array('conditions'=>array('Testimonial.testimonial_by="e" and Testimonial.aprov=1'),'order'=> 'id DESC'));
		$this->set('testimonials_emp',$testimonials_emp);
		
		$testimonials_candi = $this->Testimonial->find('all',array('conditions'=>array('Testimonial.testimonial_by="j" and Testimonial.aprov=1'),'order'=> 'id DESC'));
		$this->set('testimonials_candi',$testimonials_candi);
		
		$emp_video= $this->EmployerVideo->find('all',array('conditions'=>array('EmployerVideo.isApproved'=>'Y'),'fields'=>array('EmployerVideo.id','EmployerVideo.description','EmployerVideo.employer_id','EmployerVideo.video_type','EmployerVideo.video','Employer.employer_name'),'limit'=>'5','order'=>'EmployerVideo.id DESC'));
		$this->set('emp_videos',$emp_video);
		
		$can_video= $this->CandidateVideo->find('all',array('conditions'=>array('CandidateVideo.isApproved'=>'Y'),'fields'=>array('CandidateVideo.id','CandidateVideo.description','CandidateVideo.video_type','CandidateVideo.video'),'limit'=>'5','order'=>'CandidateVideo.id DESC'));
		$this->set('can_videos',$can_video);
		
		$this->set('type',$type);
	}	
		
        /* This function is used to call before  */
	function beforeFilter() { 
	
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
			
		$this->Auth->allow('index','addTestimonial');
		
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		
		$this->Auth->allow('login');
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'testimonials', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
		
   	}
	
	public function addTestimonial() {
		$this->set('meta_title','Testimonials');
		$this->layout = 'front';
		
		if($this->Session->read('Auth.Clients.user_type')!='C' and $this->Session->read('Auth.Clients.user_type')!='E')
		{
			$this->redirect(array('controller'=>'testimonials','action'=>'index'));	
		}
		
		if($this->Session->read('Auth.Clients.user_type')=='C'){
		$this->loadModel('Candidate');
		$this->Candidate->id=$this->Session->read('Auth.Clients.candidate_id');
		
		$name=$this->Candidate->field('candidate_name');
		
		}else{
			$employer_contact_id=$this->Session->read('Auth.Clients.employer_contact_id');
			$this->loadModel('EmployerContact');
			$rec=$this->EmployerContact->find('first',array('conditions'=>array('EmployerContact.id'=>$employer_contact_id),'fields'=>array('Employer.id','Employer.employer_name','EmployerContact.id')));
			$name=$rec['Employer']['employer_name'];
			//employer_name
		}
		
		
		
		
        $errors = '';
           
		if ($this->request->is('post'))
		 {	
		          $this->Testimonial->set($this->request->data);                        
                  if(!$this->Testimonial->validates()) {
		    		 $errors = $this->Testimonial->validationErrors;  
					}			
                       
		 if($errors) {
                       $this->set('errors',$errors);
			}else {                            
                         
				if($this->Session->read('Auth.Clients.user_type')=='C'){	
					$this->request->data['Testimonial']['testimonial_by']='j';
					
				}
			
			if($this->Session->read('Auth.Clients.user_type')=='E'){
				$this->request->data['Testimonial']['testimonial_by']='e';
			}
			 
			$this->request->data['Testimonial']['user_id']=$this->Session->read('Auth.Clients.id');
			
					
				/*	Ticket id 1305	
					
                            //pr($this->request->data);
                            App::import('Vendor', 'Uploader.Uploader');
                            $this->Uploader = new Uploader();
                            $this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'img/testimonial'));                            
                            $fileUploadPath=$this->Uploader->upload($this->request->data['Testimonial']['logo_file'],array('overwrite'=>false));                            
                            $this->Uploader->resize(array('width' => TEST_PIX_WIDTH,'height' => TEST_PIX_HEIGHT,'prepend'=>'resized_','append'=>false,'aspect'=>false,'expand'=>false));
                            $this->request->data['Testimonial']['logo_file'] = end(explode('/',$fileUploadPath['path']));
							
							*/
                            
                            if ($this->Testimonial->save($this->request->data)){
                               
                               $this->Session->write('popup','Thank you for submitting your testimonial. Our TECHEXPO team is reviewing your testimonial and should appear shortly.');

                                $this->redirect(array('controller'=>'testimonials','action' => "index"));
                            }else{
                                    $this->Session->write(__('popup','The Testimonial could not be saved. Please, try again.'));
                            }
                        }
		}else{
		
		$this->request->data['Testimonial']['name']=$name;
		
		}
	
	}
	
	
	
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	
		
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
