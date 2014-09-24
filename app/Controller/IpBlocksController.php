<?php 
/**************************************************************************
 Coder  : Apurav Gaur
 Object : Controller to handle admin role, add, edit and delete operation
**************************************************************************/ 
class IpBlocksController extends AppController {
	var $name = 'IpBlocks'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler','Common');  //add some other component to controller . this component file is exists in app/controllers/components
	var $uses = array('IpBlock');
	
	var $layout = ''; //this is the layout for admin panel 
	/*************************************************************************
	This function call by default when a controller is called 
	*************************************************************************/

		// use to manage chat history
	
	public function superadmin_blockip() {
		
		$this->layout = 'admin'; 
		$this->set('meta_title','Block Ip Records');
		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('id' => 'ASC'));
        $data = $this->paginate('IpBlock');
		
			$this->set('blockIps', $data);
    
	
	
	}
	
		public function superadmin_addip() {
		$this->layout = 'admin';
		$errors ='';
		$this->set('meta_title','Add Ip for Blocked');
		
		if($this->request->isPost()) {		
		
			if(empty($this->request->data['IpBlock']['ip'])){	
				$errors['ip'][0] ='Please enter ip address';
				               
			}	
			if($errors) {			
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{ 
				if ($this->IpBlock->save($this->request->data)) {
					$this->Session->write('popup','Ip address has been added successfully.');
					$this->Session->setFlash('Ip address has been added successfully.');  
					$this->redirect(array('controller'=>'IpBlocks','action' => "blockip/message:success"));
				}else{
					$this->Session->setFlash('Data save problem, Please try again.');  
                }					
			}	
		}
            
	}
	
	public function superadmin_deleteip($id = null) {
		
		$this->autoRandar = false;
		  if ($this->IpBlock->delete($id,false)) {
	            $this->Session->write('popup','Blocked Ip address  deleted successfully.');
                $this->Session->setFlash('Blocked Ip address  deleted successfully.');  
                $this->redirect(array('controller'=>'IpBlocks','action' => "blockip/message:success"));
                
            } 
	
		}
	
	
	

	
	
	
	public function superadmin_editgroup($id = null) {
		
			$this->layout = 'admin';
			$errors	=	'';
			
            $this->set('meta_title','Edit Chat Group');
			$this->set('id',$id);
			
			if ($this->request->is('get')) {
				$this->request->data = $this->ChatRoom->find('first',array('conditions'=>array('id'=>$id)));
			} else {
			
				$this->ChatRoom->set($this->request->data);	
			
				if(!$this->ChatRoom->validateChats()){			
					$errors = $this->ChatRoom->validationErrors;                            
				}	
				
				if($errors) {			
					$this->Set('errors',$errors);
					$this->set('data',$this->request->data);
				}else{
					if ($this->ChatRoom->save($this->request->data)) {
						$this->Session->write('popup','Chat group has been updated successfully.');
						$this->Session->setFlash('Chat group has been updated successfully.');  
							$this->redirect(array('controller'=>'chats','action' => "chatgroup/message:success"));
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'chats','action' => "editgroup",$id));
					}
				}
				
			}
	
		
		
		
		
		}
		
		
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeFilter(){
	  
		parent::beforeFilter();
//		$this->Auth->allow('send_message','load_messages','load_users','enteruser');
		
	} 
	
	
}//end class
?>