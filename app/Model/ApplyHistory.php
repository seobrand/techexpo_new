<?php
/// =================== Pushkar Soni ===============
class ApplyHistory extends AppModel {
	var $useTable = 'apply_history';
	public $belongsTo = array( 
							 'Candidate' => array(
												'foreignKey'   => 'candidate_id'
												),
							'Resume' => array(
												'foreignKey'   => 'resume_id'
												),
							'Employer' => array(
												'foreignKey'   => 'employer_id'
												),
							'JobPosting' => array(
												'foreignKey'   => 'posting_id',
												'primaryKey'   => 'posting_id'
												)
												
							);

	function validationApplyJob() {		
		$validate1 = array(
			'resume_id'=> array(
									'mustNotEmpty'=>array(
									'rule' => 'notEmpty',
									'message'=> 'Please Select Resume')
									)
			);
			
			
			$this->validate=$validate1;
			return $this->validates();
	}
		
}
