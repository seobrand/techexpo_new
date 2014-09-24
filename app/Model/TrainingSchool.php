<?php
//App::uses('AppModel', 'Model');
/**
 * Location Model
 *
 */
class TrainingSchool extends AppModel {
var $name = 'TrainingSchool';
//public $primaryKey = 'ts_id';	
	
	public $validate = array(
    	'ts_name' => array(
        'rule'       => 'notEmpty', // or: array('ruleName', 'param1', 'param2' ...)
        'message'    => 'Please enter training school name.'
		),
		'ts_web' => array(
			'rule'       => 'url', // or: array('ruleName', 'param1', 'param2' ...)
			'message'    => 'Please enter valid website url.'
		),
		'ts_logo_path' => array(
			'Rule-1'=> array(
				'rule' => 'nullImageCheck',
				'message' => 'Please upload image.',
				'last' => true
			),
			'Rule-2'=>array(
				'rule'    => array('fileTypeCheck'),
				'message' => 'Please upload .jpg file or .png file or .gif file only.'
			)				
		),
		'ts_profile' => array(
			'rule'       => 'notEmpty', // or: array('ruleName', 'param1', 'param2' ...)
			'message'    => 'Please enter profile text.'
		),
		'ts_email' => array(
		    'rule' => 'email',
			'message' => 'Enter a valid email',
			'allowEmpty' => true
		)	
	);
	
	function nullImageCheck()
	{
		if($this->data['TrainingSchool']['ts_logo_path1']=="" && $this->data['TrainingSchool']['ts_logo_path']['name']=="")
		{
			return false;
		}
		return true;
	}
	
	function fileTypeCheck()
	{
		$ftype = trim(end(explode(".",$this->data['TrainingSchool']['ts_logo_path']['name'])));
	
		if(strlen($ftype)>0){
			if(strtolower($ftype) =="png" || strtolower($ftype) =="jpeg" || strtolower($ftype) =="jpg"  || strtolower($ftype) =="gif"){
				return true;
			}else{
				return false;
			}
		}
		return true;
	
	}
	
}
