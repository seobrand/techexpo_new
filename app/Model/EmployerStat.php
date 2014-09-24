<?php 
class EmployerStat extends AppModel {
	var $name="EmployerStat";
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	 public $belongsTo = array(
			  'Employer' => array(
				'className'    => 'Employer',
				'fields'           => array('id','employer_name'),
				'foreignKey'   => 'employer_id'
			), 
		);
	
}
?>