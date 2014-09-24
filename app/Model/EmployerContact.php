<?php
App::uses('AppModel', 'Model');
/**
 * EmployerLastVisit Model
 *
 * @property Employer $Employer
 * @property EmployeeLastVisit $EmployeeLastVisit
 * @property  $
 */
class EmployerContact extends AppModel {
var $name="EmployerContact";
public $primaryKey = 'id';

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasOne associations
 *
 * @var array
 */
 public $hasOne = array(
           'User' => array(
            'className'    => 'User',
			'fields'           => array('id','username','password','user_type','employer_contact_id','candidate_id','status_code','old_password')
        ),
    );

/**
 * belongsTo associations
 *
 * @var array
 */
 public $belongsTo = array(
          'Employer' => array(
            'className'    => 'Employer',
			'fields'           => array('id','employer_name','main_phone','city','state','zip','myprofile','address','created','logo_file'),
            'foreignKey'   => 'employer_id'
        ), 
    );
	
/**
 * Validation for personal contact information
 *
 *@var array
 */
 public $validate = array(
 			'contact_name' => array(
				 'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the contact name.'
				)
			),
			'contact_email'  => array(
				 'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the contact email.'
				)
				/*,
				 'mustUnique'=>array(
					'rule' => 'isUnique',
					'message'=> 'This contact email is already registered'
				 )*/
			),
			'contact_email_job' => array(
				  'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter email for candidates.'
				)
			) 
 );	
 
	
}
