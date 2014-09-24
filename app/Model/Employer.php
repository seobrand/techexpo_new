<?php
App::uses('AppModel', 'Model');
/**
 * EmployerLastVisit Model
 *
 * @property Employer $Employer
 * @property EmployeeLastVisit $EmployeeLastVisit
 * @property  $
 */
class Employer extends AppModel {
var $name="Employer";
//The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * hasOne associations
 *
 * @var array
 */
	public $hasOne = array(
          'EmployerContact'
    );
	
	public $hasMany = array(
          'JobPosting'=>array('conditions'=>'JobPosting.start_dt > DATE(NOW() - INTERVAL 180 DAY) and JobPosting.active="1"')
		  ,'ShowEmployer'
    );

	// JobPosting.start_dt > DATE(NOW() - INTERVAL 20 DAY) and JobPosting.active="1"
/**
 * data validation of employer form
 *
 * @var array
 */	
	
	var $validate = array(
			'employer_name' => array(
		   		'noBlank' => array(
										'rule'    => 'notEmpty',
										'message' => 'Please enter the company name.'
									)
			),
			'employer_fname' => array(
		   		'noBlank' => array(
										'rule'    => 'notEmpty',
										'message' => 'Please enter the employer first name.'
									)
			),
			'employer_lname' => array(
		   		'noBlank' => array(
										'rule'    => 'notEmpty',
										'message' => 'Please enter the employer last name.'
									)
			),
	      	'main_phone' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the phone number.'
				),
				/*'numeric' => array(
					'rule'    => 'numeric',
					'message' => 'Please enter the phone number in numeric.'
				),*/
				'minlength' => array(
					'rule' => array('minLength', '10'),
            		'message' => 'Phone number should be minimum 10 characters long.'
				)
			),
			'url' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the website url.'
				),
				'numeric' => array(
					'rule'    => 'url',
					'message' => 'Please enter valid url.'
				)
			),
			'address' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the address.'
				)
			),
			'state' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please Select state.'
				)
			),
			'city' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the city.'
				)
			),
			'zip' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the zip.'
				)
			),
			'captcha' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					//'on'      => 'update', // or: 'create'
					'message' => 'Please enter security code.'
				)
			),
			'description' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					//'on'      => 'update', // or: 'create'
					'message' => 'Please enter company description.'
				)
			)
	);
	
	function uploadProfileImage() {	
		$validate1 = array(
			
			'profile_description'=> array('mustNotEmpty'=>array(
												'rule' => 'notEmpty',
												'message'=> 'Please enter profile description',
												'last'=>true)
												),
			'logo_file' => array(
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
	
	function uploadProfileVideo(){
		
			
		$validate1 = array(
			
			'description'=> array('mustNotEmpty'=>array(
												'rule' => 'notEmpty',
												'message'=> 'Please enter video description',
												'last'=>true)
												),
			'video_type'=> array('mustNotEmpty'=>array(
												'rule' => 'notEmpty',
												'message'=> 'Please select video type',
												'last'=>true)
												),									
			'video' => array(
								'mustNotEmpty'=>array(
											'rule' => 'checkvideofile',
											'message'=> 'Please upload file',
											'last'=>true
											),
								'checkfileSize'=>array(
											'rule' => 'checkvideoSize',
											'message'=> 'File Size not more then 10MB',
											'last'=>true
											)
       						 )

				);
			
			$this->validate=$validate1;
			return $this->validates();
	
		
		
		}
	
	function uploadclientlogo() {	
		$validate2 = array(			
			'logo_file' => array(
					'chechExtension'=>array(
						'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
       					'message' => 'Please supply logo with gif, jpeg, jpg, png type.'
					)
			)
		);
			
			$this->validate=$validate2;
			return $this->validates();
	}
	
	
		function checkfile()
	   {	
	   	if($this->data['Employer']['logo_file']['name'])
		{
			return true;
		}
			return false;
	   }
		 function checkSize(){
		 $size=$this->data['Employer']['logo_file']['size'];
			if($size > 12000000){
				return false;
			}
			return true;
		}
		
		function checkvideofile()
	   {	
	   	if($this->data['Employer']['video']['name'])
		{
			return true;
		}
			return false;
	   }
		function checkvideoSize(){
		 $size=$this->data['Employer']['video']['size'];
			if($size > 24000000){
				return false;
			}
			return true;
		}
		
}
