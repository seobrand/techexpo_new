<?php

class MASSEMAIL extends AppModel {
var $useTable = 'mailing_list';
public $primaryKey = 'list_id';
//public $primaryKey = 'ts_id';	
	
		function newsLetterValidate() {
		$validate1 = array(
				'list_email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter email',
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid email',
						'last'=>true),
					'mustUnique'=>array(
						'rule' =>'isUnique',
						'message' =>'This email is already registered',
						)
					),
			'list_first_name' => array(
					'rule' 	  => 'notEmpty',
					'message' => 'Please enter first name'
				),
			'list_last_name' => array(
					'rule' 	  => 'notEmpty',
					'message' => 'Please enter last name'
				)
			);
			
			
			
			$this->validate=$validate1;
			return $this->validates();
	}
	
}
