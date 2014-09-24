<?php
App::uses('AppModel', 'Model');
/**
 * JobPosting Model
 *
 * @property JOB $Employer
 * @property  $
 */
class ShowEmployer extends AppModel {
var $name="ShowEmployer";
public $actsAs = array('Containable');


/**
 * belongsTo associations
 *
 * @var array
 */
 public $belongsTo = array(
          'Employer' => array(
            'className'    => 'Employer',
			'fields'           => array('id','employer_name','main_phone','city'),
            'foreignKey'   => 'employer_id'
        ),
		'Show' => array(
			'className' => 'Show',
			'fields'           => array('id','show_dt','show_name','show_hours','show_confirm_file'),
			'foreignKey'   => 'show_id'
		) 
    );


}
