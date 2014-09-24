<?php
App::uses('AppModel', 'Model');
/**
 * Employer Video Model
 *
 * @property JOB $Employer
 * @property  $
 */
class CandidateVideo extends AppModel {
var $name="CandidateVideo";


//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
 public $belongsTo = array(
          'Candidate' => array(
            'className'    => 'Candidate',
            'foreignKey'   => 'candidate_id'
        ), 
  );
	

}
