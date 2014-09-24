<?php
App::uses('AppModel', 'Model');
/**
 * EmployerLastVisit Model
 *
 * @property Employer $Employer
 * @property EmployeeLastVisit $EmployeeLastVisit
 * @property  $
 */
class EmployerLastVisit extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'employer_id';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'employer_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Employer' => array(
			'className' => 'Employer',
			'foreignKey' => 'employer_id',
			'conditions' => '',
			'fields' => 'id,employer_name',
			'order' => ''
		)
	);
	
	 public $hasOne = array(
           'EmployerContact' => array(
            'className'    => 'EmployerContact',
			'foreignKey' => 'employer_id',
			'fields'           => array('id','employer_id','contact_name')
        ),
    );
}
