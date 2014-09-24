<?php
class JobplanHistory extends AppModel{
    var $name = "JobplanHistory";
	var $useTable  = 'jobplan_history';
	
	var $belongsTo = array(
		'Employer' => array(
			'class' => 'Employer',
			'fields' => 'employer_name',
			'foreign_key' => 'employer_id'
		)
	);
	
}
?>