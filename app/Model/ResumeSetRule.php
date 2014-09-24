<?php 
class ResumeSetRule extends AppModel {
	var $name="ResumeSetRule";
	public $primaryKey = "set_id";
	
		var $validate =  array(
                'set_descr'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert set description.'				
                    ),
                 'start_dt'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert start Date.'				
                    ),
				'end_dt'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert end Date.'				
                    )	,
				'state_list'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert state.'				
                    )	,
				'short_desc'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please short description.'				
                    )	
		);
	
	
	
}
?>