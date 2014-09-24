<?php
/**************************************************************************
 Coder  : Jitendra Pradhan  
 Object : Controller to manage banner of site home page and jobseeker dashboard.
**************************************************************************/ 

class BannersController extends AppController {
	var $name = 'Banners'; /*Model name attached with this controller*/ 
	var $layout = 'admin'; /*this is the layout for front panel*/ 
	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array('Banner','BannerCategory');
	
	/******* Function for manage banners *********/
	public function superadmin_index(){
			$this->set('meta_title',' Banner Management');
			$corp_banner = $this->Banner->find('all',array('conditions'=>array('Category.category_name' => 'corp'),'order' => array('Banner.name' => 'ASC')));
			$this->set('corp_banner',$corp_banner);
			
			$emp_banner = $this->Banner->find('all',array('conditions'=>array('Category.category_name' => 'emp'),'order' => array('Banner.name' => 'ASC')));
			$this->set('emp_banner',$emp_banner);
			
			$media_banner = $this->Banner->find('all',array('conditions'=>array('Category.category_name' => 'media'),'order' => array('Banner.name' => 'ASC')));
			$this->set('media_banner',$media_banner);
			
			$media_banner = $this->Banner->find('all',array('conditions'=>array('Category.category_name' => 'homepage main banner'),'order' => array('Banner.name' => 'ASC')));
			$this->set('home_banner',$media_banner);
			
			$ads_banner = $this->Banner->find('all',array('conditions'=>array('Category.category_name' => 'Advertising Banners'),'order' => array('Banner.name' => 'ASC')));
			$this->set('ads_banner',$ads_banner);
			
			$Allbanner = $this->Banner->find('all',array('order' => array('Banner.name' => 'ASC')));
			$this->set('Allbanner',$Allbanner);
			
			
		
	}
	
	
	/**
	 * superadmin_add method
	 * Method for add new banner
	 * @return void
	 */
	public function superadmin_add() {
            $this->set('meta_title','Add New Banner');
			$errors	=	'';
			// list of category
			$this->set('bannercategory',$this->BannerCategory->find('list',array('fields'=>array('BannerCategory.id','BannerCategory.category_name'))));
			
			if($this->request->is('post')) {
				// Form Submit Here							
				$href = $this->request->data['Banner']['href'];
				$href = substr($href,7);
				
				if(strlen($href)==0){
					$this->request->data['Banner']['href']="";
					$this->Banner->set($this->request->data);
					if(!$this->Banner->validates(array('fieldList' => array('name', 'filename')))){								
						$errors = $this->Banner->validationErrors;                            
					}
				}else{
					$this->Banner->set($this->request->data);
					if(!$this->Banner->validates()){							
						$errors = $this->Banner->validationErrors;
					}
				}					
					
				if($errors) {			
					$this->Set('errors',$errors);
					$this->set('data',$this->request->data);
				}else{
					if($this->request->data['Banner']['upload_photo']==0){ 	
						App::import('Vendor', 'Uploader.Uploader');
						$this->Uploader = new Uploader();
						$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'Banner/'));
					    $fileUploadPath=$this->Uploader->upload($this->request->data['Banner']['filename'],array('prepend'=>time().'_','overwrite'=>true));
						$this->request->data['Banner']['filename'] 	=  end(explode('/',$fileUploadPath['path']));
					}else{
						//copy file from PHOTO_GALLERY to Banner.
						$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['Banner']['filename1'];
						$destination_file_ext 	= end(explode(".",$this->request->data['Banner']['filename1']));
						$destination_file_name 	= time().".".$destination_file_ext;
						$destination_file_loc = WWW_ROOT."Banner/".$destination_file_name;
						$ok = copy($source_file, $destination_file_loc);
						$this->request->data['Banner']['filename'] = $destination_file_name;
					}
					unset($this->request->data['Banner']['filename1']);
					
					if ($this->Banner->save($this->request->data,false)) {
						$this->Session->write('popup','Banner has been added successfully.');
						$this->Session->setFlash('Banner has been added successfully.');  
						$this->redirect(array('controller'=>'banners','action' => "index/message:success"));
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'banners','action' => "add"));
					}
				}
				
			}
            
	}

	
	/**
	 * superadmin_edit method
	 * This is for updating banner
	 * @param string $id
	 * @return void
	 */
	public function superadmin_edit($bannerID = null) {
			$errors	=	'';
			// list of category
			$this->set('bannercategory',$this->BannerCategory->find('list',array('fields'=>array('BannerCategory.id','BannerCategory.category_name'))));
			
		
            $this->set('meta_title','Edit Banner');
			$this->set('id',$bannerID);
			
			if ($this->request->is('get')) {
				// get record of banner
				$this->request->data = $this->Banner->find('first',array('conditions'=>array('Banner.id'=>$bannerID)));
				$this->request->data['Banner']['old_filename'] = $this->request->data['Banner']['filename'];
			} else {
				// Form Submit Here
				if(isset($this->request->data['Banner']['keep_same'])){
					$is_keep_banner= 1;
					$this->request->data['Banner']['filename'] = $this->request->data['Banner']['old_filename'];
				}else{
					$is_keep_banner= 0;
				}
				//pr($this->request->data);die;
				$href = $this->request->data['Banner']['href'];
				$href = substr($href,7);	
				
				if(strlen($href)==0){
					$this->request->data['Banner']['href']="";
					$this->Banner->set($this->request->data);
					if(!$this->Banner->validates(array('fieldList' => array('name', 'filename')))){								
						$errors = $this->Banner->validationErrors;                            
					}
				}else{
					$this->Banner->set($this->request->data);
					if(!$this->Banner->validates()){							
						$errors = $this->Banner->validationErrors;
					}
				}
					
				if($errors) {			
					$this->Set('errors',$errors);
					$this->set('data',$this->request->data);
				}else{
					// No Errors	
					//pr($this->request->data);die;
					App::import('Vendor', 'Uploader.Uploader');
					$this->Uploader = new Uploader();
					
					if($is_keep_banner!=0){
						$this->request->data['Banner']['filename'] = $this->request->data['Banner']['old_filename'];
					}else{
						
						if($this->request->data['Banner']['upload_photo']==0){
							$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'Banner/'));
							$this->Uploader->remove(WWW_ROOT.'Banner/'.$this->request->data['Banner']['old_filename']);
							$this->Uploader->remove(WWW_ROOT.'Banner/150x80_'.$this->request->data['Banner']['old_filename']);
							$fileUploadPath=$this->Uploader->upload($this->request->data['Banner']['filename'],array('prepend'=>time().'_','overwrite'=>true));                            
							$this->Uploader->resize(array('width' => 150,'height' => 80,'prepend'=>'150x80_'.time().'_','append'=>false,'aspect'=>false,'expand'=>false));
							$this->request->data['Banner']['filename'] 	=  end(explode('/',$fileUploadPath['path']));
						}else{
							//copy file from PHOTO_GALLERY to press realese.
							$source_file = WWW_ROOT."img/photo_gallery/".$this->request->data['Banner']['filename1'];
							$destination_file_ext 	= end(explode(".",$this->request->data['Banner']['filename1']));
							$destination_file_name 	= time().".".$destination_file_ext;
							$destination_file_loc 	= WWW_ROOT."Banner/".$destination_file_name;
							$ok = copy($source_file, $destination_file_loc);
							// delete old file
							@unlink(WWW_ROOT."Banner/".$this->request->data['Banner']['old_filename']);
							$this->request->data['Banner']['filename'] = $destination_file_name;
						}
						unset($this->request->data['Banner']['filename1']);
						
					}
					
				
					if ($this->Banner->save($this->request->data,false)) {
						$this->Session->write('popup','Banner has been updated successfully.');
						$this->Session->setFlash('Banner has been updated successfully.');  
						$this->redirect(array('controller'=>'banners','action' => "index/message:success"));
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'banners','action' => "edit",$bannerID));
					}
				}
				
			}
	}
	
	/**
	 * superadmin_delete method
	 * Method for delete banner
	 * @param string $id
	 * @return void
	 */
	public function superadmin_deletebanner($id = null) {		
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}else{
			$this->request->data = $this->Banner->find('first',array('conditions'=>array('Banner.id'=>$id)));						
			
			App::import('Vendor', 'Uploader.Uploader');
			$this->Uploader = new Uploader();
				
			if($this->request->data['Banner']['filename']!=NULL) {
				$this->Uploader->remove(WWW_ROOT.'Banner/'.$this->request->data['Banner']['filename']);
				$this->Uploader->remove(WWW_ROOT.'Banner/150x80_'.$this->request->data['Banner']['filename']);
			}		
				
			if ($this->Banner->delete($id)) {
				$this->Session->write('popup','Banner has been deleted successfully.');
				$this->Session->setFlash('Banner has been deleted successfully.');  
				$this->redirect(array('controller'=>'banners','action' => "index/message:success")); 
			} else {
				$this->Session->setFlash('Deletion problem, Please try again.');  
				$this->redirect(array('controller'=>'banners','action' => "index"));

			}
		}	
	}
	
	function beforeFilter() { 
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
			
        if($this->Session->check('Auth.User.Adminuser.id'))
		{
			$this->Auth->allow('*');
		}else
		{
			//$this->Auth->allow('superadmin_deletetrialaccount');
		}
        
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','superadmin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'trainingschools', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminclient.active' => 'yes');
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	}  
	

}