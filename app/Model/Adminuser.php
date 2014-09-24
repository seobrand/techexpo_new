<?php
/****************************************************
Model to handle valiation of amdin users
*****************************************************/ 
class Adminuser extends AppModel {
	var $name="Adminuser";
	var $belongsTo = array('Role');
	var $validate =  array(
		'first_name' => array(
			'rule' 	  => 'alphaNumeric',
			'message' => 'Please enter First Name.'
			),
		'last_name' => array(
			'rule' 	  => 'alphaNumeric',
			'message' => 'Please enter Surname.'
			),			
		'username' => array(
			'emailRule-1'=> array(
				'rule' => 'notEmpty',
				'message' => 'Please insert valid Preferred Name.',
				'last'=>true
			),
/*			'emailRule-2' => array(
				'rule' => array('minLength', '6'),
				'message' => 'Username should be Minimum 6 characters long.',
				'last'=>true
			),*/
			'emailRule-3'=>array(
				'rule' => 'isUnique',
				'message' => 'Username already in use, Please try another.'
			)
		 ),	
		'email' => array(
				'emailRule-1'=> array(
					'rule' => 'email',
					'message' => 'Please insert valid Email Address.',
					'last'=>true
				),
				'emailRule-2'=>array(
					'rule' 	  => 'isUnique',
					'message' => 'Email Address already in use. Please enter another Email Address.'
				)
		),							  
		'new_password' => array(
			'password-rule-1'=>array(
				'rule'	  => 'notEmpty',
				'message' => 'Please insert Password.',
				//'on' => 'create',
				'last'=>true
			)/*,
			'password-rule-2'=>array(
				'rule' => array('minLength', '6'),
				'message' => 'Password should be Minimum 6 characters long.'
				//'on' => 'create'
			)*/
		 ),
		'repassword' => array(
			'rule-1'=>array(
				'rule' => 'notEmpty',
				'message' => 'Please insert Confirm Password.',
				//'on' => 'create',
				'last'=>true
			),
			'rule-2'=>array(
				'rule' => array('checkSamePassword'),
				'message' => 'Password and Confirm Password should be same.'
				//'on' => 'create'
			)
		),
		'role_id' => array(
			'rule' 	  => 'notEmpty',
			'message' => 'Please select Group name.'
			),	 	
	);	
	/* Function to make sure password and Confirm password are same */		 
	function checkSamePassword() {
	  return ($this->data['Adminuser']['new_password']!=$this->data['Adminuser']['repassword']) ?  false :  true;
	}
	
	//===============   validation for forgot password	==============
function forgotpassValidate() {
		$validate1 = array(	'email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter email',
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid email',
						'last'=>true)
					)
					
					);
			
			$this->validate=$validate1;
			return $this->validates();
	}
}
?>