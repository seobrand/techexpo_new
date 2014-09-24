<?php 
/**************************************************************************
 Coder  : Apurav Gaur
 Object : Controller to handle admin role, add, edit and delete operation
**************************************************************************/ 
class ChatsController extends AppController {
	var $name = 'Chats'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler','Common');  //add some other component to controller . this component file is exists in app/controllers/components
	var $uses = array('ChatMessage','ChatUser','ChatMessage','ChatRoom','ChatUser');
	
	var $layout = ''; //this is the layout for admin panel 
	/*************************************************************************
	This function call by default when a controller is called 
	*************************************************************************/


	
	function index() { 
		$this->layout = false;
		
	}
	
	function enteruser()
	{
	$this->layout = false;	
	
	
	
	if(!empty($this->request->data))
	{    
		// check user is already in chat room
		$login_user_id = $this->Session->read('Auth.Clients.id');
		$check_user = $this->ChatUser->find('first',array('conditions'=>array('ChatUser.login_user_id'=>$login_user_id),'fields'=>array('login_user_id','id')));	
		
		$this->request->data['login_user_id'] 		= $this->Session->read('Auth.Clients.id');
		$this->request->data['user'] 		= $this->Session->read('Auth.Clients.username');
		$this->request->data['timestamp'] 	=  date('Y-m-d H:i:s', time());
		$this->request->data['active'] 	= '1';
		$this->request->data['ip'] 	= $_SERVER['REMOTE_ADDR'];
		$_SESSION['Chat']['last'] 	= time();
		$_SESSION['Chat']['room_id'] = $this->request->data['room_id'];
		
		if(!empty($check_user['ChatUser']['login_user_id']))
		{
			// if already chat room then update room id ( no neer to new entry  )
		$this->request->data['id'] = $check_user['ChatUser']['id'];
		$this->ChatUser->save($this->request->data);
		}
		else{
		$this->ChatUser->save($this->request->data);
		}
		
		// selected group user chat history
		$groupChatHistory = $this->ChatMessage->find('all',array('conditions'=>array('ChatMessage.room_id'=>$this->request->data['room_id']),'fields'=>array('user','id','message','timestamp'),'order'=>'id ASC'));
		$return ='';
		if(count($groupChatHistory)){
			foreach($groupChatHistory as $groupChatHistory){
		$return .= '<div class="box_msg for_you_message box_msg_inline">';
				$return .= '<p><span class="head_msg">';
				$return .= ' <span class="time_msg">'.date('H:i:s', strtotime($groupChatHistory['ChatMessage']['timestamp'])).'</span> ';
				$return .= '<span class="user_name" rel="'.$groupChatHistory['ChatMessage']['id'].'"><b>'.$groupChatHistory['ChatMessage']['user'].'</b></span> ';
				//$return .= '<span class="name_to" rel="'.$to_user.'">'.$name_to.'</span>: ';
				$return .= '<span class="remove_message">(Hide message)</span> ';
				$return .= '</span>';
				$return .= '<br/><span class="message_sent">'.$groupChatHistory['ChatMessage']['message'].'</span> </p>';
			$return .= '</div><br/>';
			}
			echo $return; 
		}
		
	}	
		exit();
	}
	
	function send_message()
	{
	$this->layout = false;
	
		if($this->request->data)
		{
			echo $this->Session->read('Auth.Clients.username');
		$this->request->data['room_id'] = $this->Session->read('Chat.room_id');		
		$_SESSION['chat_login']['last_send'] = $_SERVER['REQUEST_TIME'];
		$this->request->data['timestamp'] =date('Y-m-d H:i:s');	
		$this->request->data['user'] = $this->Session->read('Auth.Clients.username');	
		$result = $this->ChatMessage->save($this->request->data);
		}
		exit();
	}
	
	// load all msg 
	function load_messages()
	{ 
	$this->layout = false;
	
		/*if($this->Session->read('Auth.Clients.id'))
		{}	
	*/
	
		if($this->request->data)
		{
			
		$this->request->data['timestamp'] =date('Y-m-d H:i:s');	
		$result = $this->ChatMessage->save($this->request->data);
		}
		
		// selected group user chat history
	//	pr($this->Session->read());die;
		//	$messages->setCond('timestamp >= "'.date('Y-m-d H:i:s', $_SESSION['chat_login']['last']).'"');
		$groupChatHistory = $this->ChatMessage->find('all',array('conditions'=>array('ChatMessage.room_id'=>$this->Session->read('Chat.room_id'),'ChatMessage.timestamp >='=>date('Y-m-d H:i:s', $this->Session->read('chat_login.last_send'))),'fields'=>array('user','id','message','timestamp'),'order'=>'id ASC'));
		
		//die;
		$return ='';
		if(count($groupChatHistory)){
			foreach($groupChatHistory as $groupChatHistory){
		$return .= '<div class="box_msg for_you_message box_msg_inline">';
				$return .= '<p><span class="head_msg">';
					$return .= '<span class="time_msg">'.date('H:i:s', strtotime($groupChatHistory['ChatMessage']['timestamp'])).'</span> ';
					$return .= '<span class="user_name" rel="'.$groupChatHistory['ChatMessage']['id'].'"><b>'.$groupChatHistory['ChatMessage']['user'].'</b></span> ';
					//$return .= '<span class="name_to" rel="'.$to_user.'">'.$name_to.'</span>: ';
					$return .= '<span class="remove_message">(Hide message)</span> ';
				$return .= '</span>';
				$return .= '<br/><span class="message_sent">'.$groupChatHistory['ChatMessage']['message'].'</span></p>';
			$return .= '</div><br/>';
			}
			echo $return; 
		}
	
				$_SESSION['chat_login']['last_send'] = $_SERVER['REQUEST_TIME'];
			
		exit();
	}
	
	// load user 
	function load_users()
	{ 
		//$this->set('chatRoomList',$this->common->chatRoomList()); 
		$roomLists =$this->common->chatRoomList();
		$list ='<select id="groupchat_id" style="width:225px;" name="data[room_id]"><option>Select Chat Group</option>';
		
		foreach($roomLists as $key => $value )
		{ 
			$list.='<option value="'.$key.'">'.$value.'</option>';
		}
		$list.='</select>';
		echo $list;
		exit();
	}
	
	
	public function superadmin_chatgroup() {
		$this->layout = 'admin';
		
		$this->paginate = array('order' => array('ChatRoom.room' => 'ASC'));
        $data = $this->paginate('ChatRoom');
        //pr($data);
		$this->set('chatRooms', $data);	
		
		

	}
	
	public function superadmin_addgroup() {
		$this->layout = 'admin';
		$errors ='';
		$this->set('meta_title','Add New Chat Group');
		
		if($this->request->is('post')) {		
		
				$this->ChatRoom->set($this->request->data);	
			
			if(!$this->ChatRoom->validateChats()){		
				$errors = $this->ChatRoom->validationErrors;            
				//pr($errors);                
			}	
			if($errors) {			
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{ 
				if ($this->ChatRoom->save($this->request->data)) {
					$this->Session->write('popup','Chat group has been added successfully.');
					$this->Session->setFlash('Chat group has been added successfully.');  
					$this->redirect(array('controller'=>'chats','action' => "chatgroup/message:success"));
				}else{
					$this->Session->setFlash('Data save problem, Please try again.');  
                }					
			}	
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
		
		public function superadmin_deletegroup($id = null) {
		
		$this->autoRandar = false;
		  if ($this->ChatRoom->delete($id,false)) {
			  	$this->ChatMessage->query("delete FROM chat_messages where room_id=".$id);
                $this->Session->write('popup','Chat group has been deleted successfully.');
                $this->Session->setFlash('Chat group has been deleted successfully.');  
                $this->redirect(array('controller'=>'chats','action' => "chatgroup/message:success"));
                
            } 
		
		exit;

		}
		
		
	
	public function superadmin_deleteChatUser($id = null) {
		
		$this->autoRandar = false;
		  if ($this->ChatUser->delete($id,false)) {
			  $this->Session->delete('Chat');
                $this->Session->write('popup','Chat user has been deleted successfully.');
                $this->Session->setFlash('Chat user has been deleted successfully.');  
                $this->redirect(array('controller'=>'chats','action' => "users/message:success"));
                
            } 
		
		exit;

	}
	
	// use to manage chat history
	
	public function superadmin_chathistory() {
		
		$this->layout = 'admin';
		$chatHistory = $this->ChatMessage->find('all',array('fields'=>array('DISTINCT room_id')));
		$this->set('chatHistory',$chatHistory);
	
	}
	
	
	public function superadmin_users() {
		$this->layout = 'admin';
		
		$this->paginate = array('order' => array('ChatUser.user' => 'ASC'));
        $data = $this->paginate('ChatUser');
    //    pr($data);
		$this->set('chatUsers', $data);	
	}
	
	public function superadmin_viewHistory($room_id = null) {
		$this->layout = 'admin';
		
		if ($this->request->is('get')) {
				$this->paginate = array('conditions'=>array('ChatMessage.room_id'=>$room_id),'order' => array('ChatMessage.id' => 'DESC'),'fields'=>array('ChatMessage.user','ChatMessage.message','ChatMessage.timestamp'));
				$data = $this->paginate('ChatMessage');
			   
				$this->set('groupChatHistory', $data);
			}
			
	}
	
	public function superadmin_deleteHistory($room_id = null) {
		$this->layout = 'admin';
		
		 $this->set('meta_title','Delete Chat History');
		$errorsArr = '';

		if($this->request->is('post')){
			//pr($this->request->data);
			$today_dt = date('Y-m-d');
			$start_dt = $this->request->data['ChatMessage']['start_dt'];
			$end_dt = $this->request->data['ChatMessage']['end_dt'];	
			
			// check dates validation
			if($start_dt==''){
				$errorsArr['start_dt'][0] = 'Plese select start date from you want statistics';
			}elseif($end_dt==''){
				$errorsArr['end_dt'][0] = 'Please select end date to you want statistics';
			}elseif($start_dt > $today_dt){
				$errorsArr['start_dt'][0] = 'The start date for the statistics cannot be greater than today date';
			}elseif($end_dt > $today_dt){
				$errorsArr['end_dt'][0] = 'The end date for the statistics cannot be greater than today date';
			}elseif($start_dt > $end_dt){
				$errorsArr['start_dt'][0] = 'The start date for the statistics cannot be greater than the end date';
			}
			if($errorsArr){
				$this->Set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			// dates validations end

			if(!$errorsArr){
				
				if($start_dt == $end_dt)
				$condition = "ChatMessage.room_id = '".$room_id."' AND  ChatMessage.timestamp >= '".$start_dt." 00:00:00' AND ChatMessage.timestamp <= '".$end_dt." 23:59:59' ";
				else
				$condition = "ChatMessage.room_id = '".$room_id."' AND ChatMessage.timestamp >= '".$start_dt."' AND ChatMessage.timestamp <= '".$end_dt." 23:59:59' ";
				
				
				$data = $this->ChatMessage->find('all',array('conditions'=>$condition,'fields'=>array('ChatMessage.id')));
				
				//pr($data);die;
				if(count($data)!='0')
				{
					foreach($data as $data)
					{
					$this->ChatMessage->delete($data['ChatMessage']['id'],false);
					}
					$this->Session->write('popup','Chat history has been deleted successfully.');
               		$this->Session->setFlash('Chat history has been deleted successfully');  
                	$this->redirect(array('controller'=>'chats','action' => "deleteHistory/".$room_id."/message:success"));
				}
				else
				{
					$this->Session->write('popup','No chat history for delete.');
               		$this->Session->setFlash('No chat history for delete.');  
                	$this->redirect(array('controller'=>'chats','action' => "deleteHistory/".$room_id."/message:error"));	
					
				}
				
				
				
			}
			
					
		}
		

	}
	
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeFilter(){
	  
		parent::beforeFilter();
		$this->Auth->allow('send_message','load_messages','load_users','enteruser');
		
	} 
	
	
}//end class
?>