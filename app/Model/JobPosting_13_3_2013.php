<?php
App::uses('AppModel', 'Model');
/**
 * JobPosting Model
 *
 * @property JOB $Employer
 * @property  $
 */
class JobPosting extends AppModel {
var $name="JobPosting";
var $primaryKey = 'posting_id';
 var $actsAs = array('Containable');

//The Associations below have been created with all possible keys, those that are not needed can be removed
/**
 * hasMany associations
 *
 * @var array
 */
public $hasMany = array(
        'JobPostingSkill' => array(
            'className'     => 'JobPostingSkill',
            'foreignKey'    => 'posting_id',
            'dependent'     => true
        ),
		'JobScore' => array(
            'className'     => 'JobScore',
            'foreignKey'    => 'posting_id',
            'dependent'     => true
        ),
		'ResumeScore' => array(
            'className'     => 'ResumeScore',
            'foreignKey'    => 'posting_id',
            'dependent'     => true
        )
);

/**
 * belongsTo associations
 *
 * @var array
 */
 public $belongsTo = array(
          'Employer' => array(
            'className'    => 'Employer',
			//'fields'           => array('id','employer_name','main_phone'),
            'foreignKey'   => 'employer_id'
        ), 
  );
	
/**
 * Validation for personal contact information
 *
 *@var array
 */
 public $validate = array(
 			'job_title' => array(
				 'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the job title.'
				)
			),
			'short_descr'  => array(
				 'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the short description.'
				)
			),
			'location_state'  => array(
				 'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please select state.'
				)
			),
			'location_city'  => array(
				 'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter city.'
				)
			),
	      	'last_salary' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the job salary.'
				)/*,
				'numeric' => array(
					'rule'    => 'numeric',
					'message' => 'Please enter the salary in numeric.'
				)*/
			),
			'yourEmail'  => array(
				 'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter your email.'
				),
				'validemail' => array(
					'rule'    => 'email',
					'message' => 'Please enter valid email.'
				)
			),
			'friendEmail'  => array(
				 'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the friend emails.'
				),
				'validemail' => array(
					'rule'    => 'email',
					'message' => 'Please enter valid email.'
				)
			),
			'emailMessage'  => array(
				 'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the message.'
				)
			)
			
 );	
 
 function emailValidate() {
		$validate1 = array(
			'job_email' => array(
				  'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter email address.'
				),
				'validEmail' => array(
					'rule' => 'email',
					'message' => 'Please enter valid email address.'
				)
			)
		);
			
			$this->validate=$validate1;
			return $this->validates();
	}
	
	function urlValidate() {
		$validate2 = array(
			'job_url' => array(
				  'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter website url.'
				),
				'validUrl' => array(
					'rule' => 'url',
					'message' => 'Please enter valid website url.'
				)
			)
		);
			
			$this->validate=$validate2;
			return $this->validates();
	}

	
			
 
	
}
