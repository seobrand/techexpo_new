<?php
App::uses('AppModel', 'Model');
/**
 * Employer Video Model
 *
 * @property JOB $Employer
 * @property  $
 */
class EmployerVideo extends AppModel {
var $name="EmployerVideo";


//The Associations below have been created with all possible keys, those that are not needed can be removed

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
	

}
