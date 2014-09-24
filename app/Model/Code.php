<?php
class Code extends AppModel {
	var $name="Code";	
	//var $hasOne = array('Adminpermission');
	//Validation for users
        public $primaryKey = 'code_id';
	var $validate =  array(
                    'code_descr'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert Code.'				
                    )	,
                    'code_name'=> array(
				'rule' => 'notEmpty',                                
				'message' => 'Please insert Code Name.'				
                    )	
		);
		
	function non_zero() {
		if(isset($this->data['Code']['sort_order']) && $this->data['Code']['sort_order']==0) {
                    return false;
		}else {
                    return true;
		}
	}			
}
?>