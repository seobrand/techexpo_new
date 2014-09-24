<?php
/*****************************************************
	Programmer 	: Keshav
	Object 		: Model to handel constants defined by admin.
	Created		: 04 Apr 2011
******************************************************/ 
class Setting extends AppModel {
	var $name="Setting";
	//Validations
	var $validate =  array(
			'name' => array(
				  'Rule-1'=> array(
						'rule' 	  => 'notEmpty',
						'message' => 'Please enter setting name.'
						),
				  'Rule-2'=>array(
						'rule' => 'isUnique',
						'message' => 'Setting name already used , Please use another name.'
						),
				  'Rule-3'=>array(
				   		'rule'=>array('checkConstantArr'),
						'message'=>'Please enter a valid setting name.'
				   		)						
				  ),	
			'value' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter setting value.')
		 );	
	//function to check input name is similar to any of global constants or not. Returns false if yes.
  		function checkConstantArr() {
   							 $array = array('APP','APP_PATH','CACHE','CAKE','COMPONENTS','CONFIGS','CONTROLLER_TESTS','CONTROLLERS','CSS','DS','ELEMENTS','HELPER_TESTS','HELPERS','IMAGES','JS','LAYOUTS','LIB_TESTS','LIBS','LOGS','MODEL_TESTS','MODELS','SCRIPTS','TESTS','TMP','VENDORS','VIEWS','WWW_ROOT');	
							 
							if(in_array(strtoupper($this->data['Setting']['name']), $array)) {
									 return false ;
								}
							return true;	
					}
}
?>