<?php
App::uses('AppModel', 'Model');
/**
 * PressRelease Model
 *
 */
class PressRelease extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'pr_id';
/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'pr_id';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
	
				'pr_title' => array(
					'notempty' => array(
						'rule' => 'notEmpty',
						'message' => 'Please Enter Press Title',
						//'allowEmpty' => false,
						//'required' => false,
						//'last' => false, // Stop validation after this rule
						//'on' => 'create', // Limit validation to 'create' or 'update' operations
					)
				),
                'pr_date' => array(
                    'rule'       => array('date','ymd'),
                    'message'    => 'Enter a valid date'                    
                ),
                'pr_file' => array(
                    'Rule-1'=> array(
						'rule' => 'nullImageCheck',
						'message' => 'Please upload pdf file.',
                    	'last' => true
					),
					'Rule-2'=>array(
						'rule'    => array('fileTypeCheck'),
						'message' => 'Please upload .pdf file only.'
					)
                )
	);
	
	function nullImageCheck()
	{ 
		if($this->data['PressRelease']['pr_file']['name']=="")
		{
			return false;
		}
		return true;
	}
	
	function fileTypeCheck()
	{
		$ftype = trim(end(explode(".",$this->data['PressRelease']['pr_file']['name'])));
		
		if(strlen($ftype)>0){
		//		if(strtolower($ftype) =="png" || strtolower($ftype) =="jpeg" || strtolower($ftype) =="jpg"  || strtolower($ftype) =="gif"){
			if(strtolower($ftype) =="pdf"){
				return true;
			}else{
				return false;
			}
		}
		return true;
		
	}
	
}
