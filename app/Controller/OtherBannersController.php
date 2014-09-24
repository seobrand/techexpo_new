<?php
/**************************************************************************
 Coder  : Jitendra Pradhan  
 Object : Controller to registration process of client
**************************************************************************/ 

class OtherBannersController extends AppController {
	var $name = 'OtherBanners'; /*Model name attached with this controller*/ 
	var $layout = 'admin'; /*this is the layout for front panel*/ 
	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array('Banner','BannerCategory','OtherBanner');
	
	/******* Function for manage banners *********/
	public function superadmin_index(){

			$this->set('meta_title','Other Banner Management');
			$banner = $this->OtherBanner->find('all',array('order' => array('OtherBanner.name' => 'ASC')));
			$this->set('banner',$banner);
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
			
			
			if($this->request->is('post')) {
				// Form Submit Here
				$this->OtherBanner->set($this->request->data);	
				if(!$this->OtherBanner->validates()){		
					$errors = $this->OtherBanner->validationErrors;                            
				}	
				if($errors) {			
					$this->Set('errors',$errors);
					$this->set('data',$this->request->data);
				}else{ 
						// No Errors	
					App::import('Vendor', 'Uploader.Uploader');
					$this->Uploader = new Uploader();
					$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'Banner/'));
				    $fileUploadPath=$this->Uploader->upload($this->request->data['OtherBanner']['filename'],array('prepend'=>time().'_','overwrite'=>true));
					$this->Uploader->resize(array('width' => 150,'height' => 80,'prepend'=>'150x80_'.time().'_','append'=>false,'aspect'=>false,'expand'=>false));
					$this->request->data['OtherBanner']['filename'] 	=  end(explode('/',$fileUploadPath['path']));
				
					if ($this->OtherBanner->save($this->request->data)) {
						$this->Session->write('popup','Banner has been added successfully.');
						$this->Session->setFlash('Banner has been added successfully.');  
						$this->redirect(array('controller'=>'other_banners','action' => "index/message:success"));
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'other_banners','action' => "add"));
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
		       $this->set('meta_title','Edit Banner');
			$this->set('id',$bannerID);
			
			if ($this->request->is('get')) {
				// get record of banner
				$this->request->data = $this->OtherBanner->find('first',array('conditions'=>array('OtherBanner.id'=>$bannerID)));
				$this->request->data['OtherBanner']['old_filename'] = $this->request->data['OtherBanner']['filename'];
			} else {
				// Form Submit Here
				if(isset($this->request->data['OtherBanner']['keep_same'])){
					$is_keep_banner= 1;
					$this->request->data['OtherBanner']['filename'] = $this->request->data['OtherBanner']['old_filename'];
				}else{
					$is_keep_banner= 0;
				}
			
				$this->OtherBanner->set($this->request->data);	
				if(!$this->OtherBanner->validates()){		
					$errors = $this->OtherBanner->validationErrors;                            
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
						$this->request->data['OtherBanner']['filename'] = $this->request->data['OtherBanner']['old_filename'];
					}else{
						if($this->request->data['OtherBanner']['filename']['error']==4){
							$this->Uploader->remove(WWW_ROOT.'Banner/'.$this->request->data['OtherBanner']['old_filename']);
							$this->Uploader->remove(WWW_ROOT.'Banner/150x80_'.$this->request->data['OtherBanner']['old_filename']);
							$this->request->data['OtherBanner']['filename'] = '';
						}else{
							$this->Uploader->setup(array('tempDir' => TMP,'uploadDir'=>'Banner/'));
							$this->Uploader->remove(WWW_ROOT.'Banner/'.$this->request->data['OtherBanner']['old_filename']);
							$this->Uploader->remove(WWW_ROOT.'Banner/150x80_'.$this->request->data['OtherBanner']['old_filename']);
							$fileUploadPath=$this->Uploader->upload($this->request->data['OtherBanner']['filename'],array('prepend'=>time().'_','overwrite'=>true));                            
							$this->Uploader->resize(array('width' => 150,'height' => 80,'prepend'=>'150x80_'.time().'_','append'=>false,'aspect'=>false,'expand'=>false));
							$this->request->data['OtherBanner']['filename'] 	=  end(explode('/',$fileUploadPath['path']));
						}
					}
					
				
					if ($this->OtherBanner->save($this->request->data)) {
						$this->Session->write('popup','Banner has been updated successfully.');
						$this->Session->setFlash('Banner has been updated successfully.');  
						$this->redirect(array('controller'=>'other_banners','action' => "index/message:success"));
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'other_banners','action' => "edit",$bannerID));
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