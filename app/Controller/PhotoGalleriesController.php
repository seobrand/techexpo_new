<?php
/*
   Coder: Manoj Pandit
   Date  : 15 Apr 2013
*/

class PhotoGalleriesController extends AppController {
	var $name = 'PhotoGalleries'; //Model name attached with this controller
	 var $helpers = array('Html','Javascript','Text','Paginator','Ajax');
	 var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	 var $uses = array('PhotoGallery','PhotoCategory');
	 var $layout = 'admin';
	
/***-----------------------This function is the Index function i.e. call by default-------------------------------------------------------------------------------*/
	public function superadmin_index(){
		$this->set('meta_title','Photo Gallery');
		$this->PhotoGallery->recursive = 0;
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('PhotoGallery.id' => 'DESC'));
		$this->set('photolist', $this->paginate('PhotoGallery'));
	}
/***-----------------------This function Add new photo in gallery----------------------------------------------------------*/
	function superadmin_add(){
		$this->layout = 'admin_colorbox';
		//get the option value for category dropdown
		$photo_category = $this->PhotoCategory->find('list',array('fields'=>array('id','category_name'),'order'=>array('PhotoCategory.category_name ASC')));
		$this->set('photo_cat_option',$photo_category);
		
		if($this->request->is('post')){
			$this->PhotoGallery->set($this->request->data);
			if($this->PhotoGallery->validates())
			{
				$this->request->data['PhotoGallery']['image']['name'] = $this->common->getTimeStamp()."_".str_replace(' ','-',$this->request->data['PhotoGallery']['image']['name']);
				$docDestination = WWW_ROOT.'img/photo_gallery/'.$this->request->data['PhotoGallery']['image']['name'];
			
				move_uploaded_file($this->request->data['PhotoGallery']['image']['tmp_name'], $docDestination) or die($docDestination);
			
				$this->request->data['PhotoGallery']['image'] = $this->request->data['PhotoGallery']['image']['name'];
				
				$this->PhotoGallery->save($this->request->data,false);			
				
				$this->Session->write('popup','Photo is successfully saved in gallery.');
                $this->Session->setFlash('Photo is successfully saved in gallery.');  
                $this->redirect(array('controller'=>'photo_galleries','action' => "index/message:success"));
			}
			else
			{
				$errors = $this->PhotoGallery->validationErrors;
				$this->set('errors',$errors);
			}
		}
	}
/***----------------------This function Edit Existing photo in gallery------------------------------------------------------------------------------------*/
	function superadmin_edit($id=null){
		$this->layout = 'admin_colorbox';
		$this->set('title_for_layout','Update the Photo Gallery');
		//get the option value for category dropdown
		$photo_category = $this->PhotoCategory->find('list',array('fields'=>array('id','category_name'),'order'=>array('PhotoCategory.category_name ASC')));
		$this->set('photo_cat_option',$photo_category);
		if(isset($this->request->data['PhotoGallery']['id']))
		{
				$photoid = $this->request->data['PhotoGallery']['id']; 
				$this->PhotoGallery->set($this->request->data);
				  if($this->PhotoGallery->validates())
				  {						
						$this->request->data['PhotoGallery']['image']['name'] = $this->common->getTimeStamp()."_".str_replace(' ','-',$this->request->data['PhotoGallery']['image']['name']);
						$docDestination = WWW_ROOT.'img/photo_gallery/'.$this->request->data['PhotoGallery']['image']['name'];
						@chmod(WWW_ROOT.'img/photo_gallery',0777);
						
						$ok = move_uploaded_file($this->request->data['PhotoGallery']['image']['tmp_name'], $docDestination) or die($docDestination);
					
						// delete old file
						if($ok){
							$old_image = $this->PhotoGallery->findById($photoid);
							$old_image_path = WWW_ROOT.'img/photo_gallery/'.$old_image['PhotoGallery']['image'];
							@unlink($old_image_path);
						}
						// update new image
						$this->request->data['PhotoGallery']['image'] = $this->request->data['PhotoGallery']['image']['name'];
						$this->PhotoGallery->save($this->request->data,false);			
						
						$this->Session->write('popup','Photo is successfully updated in gallery.');
		                $this->Session->setFlash('Photo is successfully updated in gallery.');  
		                $this->redirect(array('controller'=>'photo_galleries','action' => "index/message:success"));
				  }
				  else
				  {
					$errors = $this->PhotoGallery->validationErrors;
					$this->set('errors',$errors);
					$this->PhotoGallery->id = $id;
					$this->request->data = $this->PhotoGallery->read();
				  }
			} else { 
				$this->PhotoGallery->id = $id;
				$this->request->data = $this->PhotoGallery->read();
			}
		
	}
/***--------------------------------------------------This function Delete the photo from gallery---------------------------------------------------------------*/
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
		$this->PhotoGallery->id = $id;
		if (!$this->PhotoGallery->exists()) {
			throw new NotFoundException(__('Invalid pix'));
		}
		
		$pressContent = $this->PhotoGallery->read(null, $id);
		unlink(WWW_ROOT.'img/photo_gallery/'.$pressContent['PhotoGallery']['image']);
		 
		if ($this->PhotoGallery->delete()) {
			$this->Session->write('popup','Photo has been deleted successfully.');
            $this->Session->setFlash('Photo has been deleted successfully.');  
            $this->redirect(array('controller'=>'photo_galleries','action' => "index/message:success"));
		}
		$this->Session->setFlash(__('Photo was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function crop($pass='') {
	if($pass!='') {
		$break = explode('/',base64_decode($pass));
		if(count($break)==2) {
			$img = base64_decode($break[0]);
			$url = base64_decode($break[1]);
			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				if(trim($_POST['w'])=='' || trim($_POST['h'])=='') {
					$this->Session->setFlash('Invalid dimensions for resizing.');
				} else {
				ini_set('memory_limit', '-1');
				$size = getimagesize(WWW_ROOT.'img/'.$img); 
					switch ($size['mime']) { 
					case "image/gif": 
						$src_image = imagecreatefromgif(WWW_ROOT.'img/'.$img);
						break; 
					case "image/jpeg": 
						$src_image = imagecreatefromjpeg(WWW_ROOT.'img/'.$img);
						break; 
					case "image/png": 
						$src_image = imagecreatefrompng(WWW_ROOT.'img/'.$img);
						break;
					}
					
					$dst_x = 0;
					$dst_y = 0;
					$src_x = $_POST['x1']; // Crop Start X
					$src_y = $_POST['y1']; // Crop Srart Y
					$dst_w = (int)$_POST['w']; // Thumb width
					$dst_h = (int)$_POST['h']; // Thumb height
					$src_w = (int)$_POST['w'];//(int)($_POST['w']+$_POST['x2']);
					$src_h = (int)$_POST['h'];//(int)($_POST['h']+$_POST['y2']);
					
					$dst_image = imagecreatetruecolor($dst_w,$dst_h);
					imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
					
					switch ($size['mime']) { 
					case "image/gif": 
						imagegif($dst_image, WWW_ROOT.'img/'.$img);
						break; 
					case "image/jpeg": 
						imagejpeg($dst_image, WWW_ROOT.'img/'.$img);
						break; 
					case "image/png": 
						imagepng($dst_image, WWW_ROOT.'img/'.$img);
						break;
					}
					$this->Session->setFlash('Image has been resized successfully.');
					$this->redirect($url.'/type:success');
				}	
			}
			$this->set('img',$img);
			$this->set('url',$url);
		} else {
			$this->redirect($this->referer());
		}
	} else {
		$this->redirect($this->referer());
	}
}								
/***-------------------------this function is checking username and password in database and if true then redirect to home page----------------------------------*/		
	function beforeFilter() {
		  $this->Auth->fields = array(
			   'username' => 'username', 
			   'password' => 'password'
		   );
		  $this->Auth->loginRedirect = array('controller' => 'admins', 'action' => 'home');
	}
/***-----------------------This function is used to select photo in popup--------------------------------------------------------------------------------------*/
	function superadmin_photouploader($parentWindowId = null){
		$this->layout = 'admin_colorbox';
		$this->set('title_for_layout','Photo Gallery Manager');
		$this->set('parentWindowId',$parentWindowId);
		
		$this->PhotoGallery->recursive = 0;
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;
		
		
		if($this->request->is('post')){
			$condition = "PhotoGallery.photo_category_id = ".$this->request->data['PhotoCategory']['photo_category'];
			$this->paginate = array('limit' =>$record,'conditions'=>array($condition),'order' => array('PhotoGallery.id' => 'DESC'));
		}else{
			$this->paginate = array('limit' =>$record,'order' => array('PhotoGallery.id' => 'DESC'));
		}
		$this->set('galleries', $this->paginate('PhotoGallery'));
		
	}

/***----------------------ajax filter result ---------------------------------------------------------------------*/
function filterResult($mycat=0,$subcat=0,$stext='')
{
	$this->layout=false;
	

		$cond = '';
		$this->paginate = array('limit' => PER_PAGE_RECORD,'order' => array('PhotoGallery.id' => 'DESC'));
		
		if($mycat!=0 || $subcat!=0)
		{
			$cond['PhotoGallery.subcategory'] = $mycat.'/'.$subcat;
		}
		
		if(isset($stext) && $stext !='' && $stext!='Tag'){
		 	$cond['PhotoGallery.tags LIKE'] = '%'.$stext.'%';
		}

		$data = $this->paginate('PhotoGallery', $cond);
		$this->set('galleries', $data);
}

/***---------------------- This function is setting all info about current Admins in currentAdmin array so we can use it anywhere lie name id etc.------------------*/
	 function beforeRender() {		   
			$this->set('common',$this->common);			
	  }
}
?>