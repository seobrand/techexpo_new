<?php 
class ChatRoom extends AppModel {
	var $name="ChatRoom";
	
	var $hasMany = array(
		'ChatUser' => array(
				'className' => 'ChatUser',
				'foreignKey'   => 'room_id'
		)
	);
	
		function validateChats() {	
		$validate1 = array(
			
			'room'=> array('mustNotEmpty'=>array(
												'rule' => 'notEmpty',
												'message'=> 'Please enter group name',
												'last'=>true)
												),
			'capacity'=> array('mustNotEmpty'=>array(
													'rule' => 'notEmpty',
													'message'=> 'Please enter capacity',
													'last'=>true)
													),
			'capacity_exclusive'=> array('mustNotEmpty'=>array(
															'rule' => 'notEmpty',
															'message'=> 'Please enter capacity exclusive',
															'last'=>true)
															),
				);
			
			$this->validate=$validate1;
			return $this->validates();
	}
	
	
}
?>