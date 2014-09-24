<?php 
class Candidate extends AppModel {
	var $name="Candidate";
	var $useTable='candidates';
	//public $primaryKey = 'candidate_id';	
	 var $hasOne = 'User'; 
	 var $hasMany  = 'Resume'; 
	//var $belongsTo = 'Code';
	
	
	
	
	 
	function RegisterValidate() {
		
	
		$validate1 = array(
			'username'=> array(
									'mustNotEmpty'=>array(
									'rule' => 'notEmpty',
									'message'=> 'Please enter name')
									),	
			'candidate_fname'=> array(
									'mustNotEmpty'=>array(
									'rule' => 'notEmpty',
									'message'=> 'Please enter first name')
									),
			'terms' => array(
						   'rule' => array('comparison', 'equal to', 1),
						   'required' => true,
						   'allowEmpty' => false,
						   'on' => 'index',
						   'message' => 'You have to agree terms & conditions'
               ),
			'candidate_lname'=> array(
									'mustNotEmpty'=>array(
									'rule' => 'notEmpty',
									'message'=> 'Please enter last name')
									),		
			/*'candidate_title' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter title'
				),*/
			'candidate_phone' => array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter phone number',
						'last'=>true)			
				),
			'candidate_city' => array(
					'rule' 	  => 'notEmpty',
					'message' => 'Please enter city'
				),
			'candidate_address' => array(
					'rule' 	  => 'notEmpty',
					'message' => 'Please enter address'
				),
			'candidate_zip'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter zip Code',
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => 'numeric',
						'message' => 'Please enter valid zip Code',
						'last'=>true),
					'mustBeLonger' => array(
						'rule'    => array('minLength', 5),
						'message' => 'Please enter valid zip Code'
					),
					'maxlength' => array(
						'rule'    => array('maxLength', 5),
						'message' => 'Please enter valid zip Code'
					)
					),
		'candidate_email'=> array(
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
		'candidate_secondary_email'=> array(
					'allowEmpty'=> array(
						'rule' => 'email',
						'allowEmpty' => true,
						'message' => 'Please enter valid email',
						'last'=>true)
					
					)
			);
			
			
			
			$this->validate=$validate1;
			return $this->validates();
	}
	
	
	function editProfile() {		
		$validate1 = array(
			/*'candidate_name'=> array(
									'mustNotEmpty'=>array(
									'rule' => 'notEmpty',
									'message'=> 'Please enter name')
									),		
			'candidate_phone' => array(
					'rule' => 'notEmpty',
					'message' => 'Please enter phone number'			
				),*/
			'candidate_fname'=> array(
					'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter first name')
			),
			'candidate_lname'=> array(
					'mustNotEmpty'=>array(
							'rule' => 'notEmpty',
							'message'=> 'Please enter last name')
			),
			'candidate_city' => array(
					'rule' 	  => 'notEmpty',
					'message' => 'Please enter city'
				),
			'candidate_address' => array(
					'rule' 	  => 'notEmpty',
					'message' => 'Please enter address'
				),
			
			'candidate_zip'=> array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter zip Code',
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => 'numeric',
						'message' => 'Please enter valid zip Code',
						'last'=>true),
					'mustBeLonger' => array(
						'rule'    => array('minLength', 5),
						'message' => 'Please enter valid zip Code'
					),
					'maxlength' => array(
						'rule'    => array('maxLength', 5),
						'message' => 'Please enter valid zip Code'
					)
					),
		'last_salary'=> array(
					'allowEmpty'=> array(
						'rule' => 'numeric',
						'allowEmpty' => true,
						'message' => 'Last salary must be fill with number',
						'last'=>true)	
					),
		'candidate_email'=> array(
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
					)
			);
			
			
			
			$this->validate=$validate1;
			return $this->validates();
	}
	
	function sendEmailToFriend() {	
		$validate1 = array(
			
			'candidate_email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter your e-mail address',
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid e-mail address',
						'last'=>true)
					),
			'candidate_friend_email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> "Please enter your friend's e-mail address",
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid e-mail address',
						'last'=>true)
					)/*,
			'message' => array(
					'rule' => 'notEmpty',
					'message' => "Please anter a message"			
				)*/
			);
			
			$this->validate=$validate1;
			return $this->validates();
	}
	
	
	function uploadProfileImage() {	
		$validate1 = array(
			
			'profile_description'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter profile description',
						'last'=>true)
					),
			'candidate_image' => array(
								'mustNotEmpty'=>array(
											'rule' => 'checkfile',
											'message'=> 'Please upload file',
											'last'=>true
											),
								'checkfileSize'=>array(
											'rule' => 'checkSize',
											'message'=> 'File Size not more then 5MB',
											'last'=>true
											)
       						 )

				);
			$this->validate=$validate1;
			return $this->validates();
	}
	
		
	function adminSeekerSearch() {	 // validation  for admin 
		$validate1 = array(
			'candidate_title'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please fill search criterion',
						'last'=>true)
					)

				);
			
			$this->validate=$validate1;
			return $this->validates();
	}
	
	
	

   

	function checkfile()
	   {	
	   	if($this->data['Candidate']['candidate_image']['name'])
		{
			return true;
		}
			return false;
	   }
	   
    function checkSize(){
     $size=$this->data['Candidate']['candidate_image']['size'];
        if($size > 12000000){
            return false;
        }
        return true;
    }
	 function checkType(){
      echo $size=basename($this->data['Candidate']['candidate_image']['name'],'.');die;
      $allowedMime=array();
	   if(($size / 1024) > 5){
            $allowedMime = array('image/gif','image/jpeg','image/pjpeg','image/png');
        }

        if(!in_array($data['type'], $allowedMime)){
            return false;
        }
        return true;
		
    }

	
}
?>