<?php
App::uses('AppModel', 'Model');
/**
 * JobPosting Model
 *
 * @property JOB $Employer
 * @property  $
 */
class ShowInterview extends AppModel {
var $name="ShowInterview";


/**
 * belongsTo associations
 *
 * @var array
 */
 public $belongsTo = array(
          'Candidate' => array(
            'className'    => 'Candidate',
			'fields'           => array('id','candidate_name','experience_code','candidate_email'),
            'foreignKey'   => 'candidate_id'
        ),
		'Show' => array(
            'className'    => 'Show',
			'fields'           => array('id','show_dt','show_name','show_hours'),
            'foreignKey'   => 'show_id'
        ),
		'Employer' => array(
            'className'    => 'Employer',
			'fields'           => array('id','employer_name'),
            'foreignKey'   => 'employer_id'
        )
    );


}
