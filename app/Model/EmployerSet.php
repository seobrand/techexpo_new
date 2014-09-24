<?php 
class EmployerSet extends AppModel {
	var $name="EmployerSet";
	public $primaryKey = "";
	
	public $belongsTo = array( 
        
		 'ResumeSetRule' => array(
            'foreignKey'   => 'set_id'
        )
    );
	
}
?>