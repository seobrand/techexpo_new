<?php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
var $name="User";

/********* Relationship of users ***********/
public $belongsTo = array( 
        'employerContact' =>

array(
            'className'    => 'EmployerContact',
            'foreignKey'   => 'employer_contact_id'
        ),
		 'Candidate' => array(
            'foreignKey'   => 'candidate_id'
        )
    );
//===============   validation for user registration	==============
function RegisterValidate() {
		$validate1 = array(
			'username'=> array(
								'mustNotEmpty'=>array(
								'rule' => 'notEmpty',
								'message'=> 'Please enter username'),
								
								'mustUnique'=>array(
								'rule' => 'isUnique',
								'message'=> 'User name is already registered')
							 ),
			'password'=> array(
								'mustNotEmpty'=>array(
													'rule' => 'notEmpty',
													'message'=> 'Please enter password'
													
													),
													
								'minlength'=>array(
													'rule'    => array('minLength', 5),
													'message' => 'Password must be greater than 5 character'
													
													)
							  ),
			'cpassword'=>array('notEmpty'=>array(
									'rule' => 'notEmpty',
									'message'=> 'Please re-enter password',
									'last'=>true),
								'confirm'=> array(
										'rule' => 'verifies2',
										'message' => 'Password does not match',
										'last'=>true)				  
			
							)
						);
			
			$this->validate=$validate1;
			return $this->validates();
	}
//===============   validation for change username	==============
function changeUserValidate() {
		$validate1 = array(
			'username'=> array(
				'mustNotEmpty'=>array(
					'rule' => 'notEmpty',
					'message'=> 'Please enter username'
				),
				'mustUnique'=>array(
					'rule' => 'isUnique',
					'message'=> 'This user name is already registered'
				)
		 	)
		);
			
			$this->validate=$validate1;
			return $this->validates();
	}
//===============   validation for forgot password	==============
function forgotpassValidate() {
		$validate1 = array(	'contact_email'=> array(
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
//===============   validation for user login check	==============
function loginValidate() {
		$validate1 = array(
			'username'=> array(
								'mustNotEmpty'=>array(
								'rule' => 'notEmpty',
								'message'=> 'Please enter username')
							),
			'password'=> array(
								'mustNotEmpty'=>array(
								'rule' => 'notEmpty',
								'message'=> 'Please enter password')
							  ),
			
						);
			
			$this->validate=$validate1;
			return $this->validates();
	}
//===============   end	==============

//===============   validation for user login check	==============
function editProfile() {

		$validate1 = array(
			'username'=> array(
								'mustNotEmpty'=>array(
								'rule' => 'notEmpty',
								'message'=> 'Please enter username'),
								
								'mustUnique'=>array(
								'rule' => 'isUnique',
								'message'=> 'User name is already registered')
							 ),
			'password'=> array(
								'mustNotEmpty'=>array(
													'rule' => 'notEmpty',
													 'allowEmpty' => true,
													'message'=> 'Please enter password',
													'on'=>'create'
													),
													
								'minlength'=>array(
													'rule'    => array('minLength', 5),
													'allowEmpty' => true,
													'message' => 'Password must be greater than 5 character',
													)
							  ),
			'cpassword'=>array('notEmpty'=>array(
									'rule' => 'notEmpty',
									'allowEmpty' => true,
									'message'=> 'Please re-enter password',
									'last'=>true),
								'confirm'=> array(
										'rule' => 'verifies',
										'message' => 'Password does not match',
										'last'=>true)				  
			
							)
						);
			
			$this->validate=$validate1;
			return $this->validates();
	}
	
	protected function verifies() {
	
		if(!empty($this->data['User']['id']) && !empty($this->data['Candidate']['id']))
		{
			if(!empty($this->data['User']['cpassword']) && !empty($this->data['User']['password']))
				{
			
					if($this->data['User']['password']===$this->data['User']['cpassword'])
					{
						return true;
					}else
					{
						return false;
					}
				}else
				{
					return true;
				}
		}else
		{
			return true;
		}
	}
	
	protected function verifies2() {
	
		
			if(!empty($this->data['User']['cpassword']) && !empty($this->data['User']['password']))
				{
			
					if($this->data['User']['password']===$this->data['User']['cpassword'])
					{
						return true;
					}else
					{
						return false;
					}
				}else
				{
					return true;
				}
		
	}
//===============   end	==============
	
	public function beforeSave() {
			if (isset($this->data[$this->alias]['password'])) {
				$this->data[$this->alias]['password'] = md5($this->data[$this->alias]['password']);
			}
			return true;
		}
}