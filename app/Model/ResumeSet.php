<?php 
class ResumeSet extends AppModel {
	var $name="ResumeSet";
	
		public $belongsTo = array( 
							 'Resume' => array(
							 'className'    => 'Resume',
							 'foreignKey'   => 'resume_id'
							 )
												
							);
	
}
?>
