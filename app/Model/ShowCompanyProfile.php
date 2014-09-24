<?php
/// =================== Pushkar Soni ===============
class ShowCompanyProfile extends AppModel {
	
	public $belongsTo = array( 
	'Employer' => array(
		'foreignKey'   => 'employer_id'
		)
	);
}