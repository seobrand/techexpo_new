<?php
App::uses('AppModel', 'Model');
/**
 * Employer Folder  Model
 *
 */
class Folder extends AppModel {
var $name="Folder";
var $primaryKey = 'folder_id';

public $hasMany = array(
        'FolderContent' => array(
            'className'     => 'FolderContent',
            'foreignKey'    => 'folder_id',
            'dependent'     => true
        )
);

	
/**
 * data validation of folder form
 *
 * @var array
 */	
	
	var $validate = array(
			'folder_descr' => array(
		   		'noBlank' => array(
					'rule'    => 'notEmpty',
					'message' => 'Please enter the folder name.'
				)/*,
				'alphaNumeric' => array(
					'rule'    => 'alphaNumeric',
					'message' => 'Please enter valid folder name.'
				)*/
			),
	      	
	);
	
		function sendEmailToCandidate() {	
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
			'message' => array(
					'rule' => 'notEmpty',
					'message' => "Please anter a message"			
				)
			);
			
			$this->validate=$validate1;
			return $this->validates();
	}
	
		function validEmailResume() {	
		$validate1 = array(
			'email'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter your e-mail address',
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => array('email'),
						'message' => 'Please enter valid e-mail address',
						'last'=>true)
					),
			'mailnotes' => array(
					'rule' => 'notEmpty',
					'message' => "Please enter a message"			
				)
			);
			
			$this->validate=$validate1;
			return $this->validates();
	}
}
