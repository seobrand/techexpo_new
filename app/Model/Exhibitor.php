<?php
App::uses('AppModel', 'Model');
/**
 * Pix Model
 *
 */
class Exhibitor extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
public $useTable = 'exhibitors';



	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter title.',
				)
		),
		'description' => array(
			'notempty' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter description.'
			)
		),
		'image' => array(
             'Rule-1'=> array(
				'rule' => 'nullImageCheck',
				'message' => 'Please upload image.',
                 'last' => true
			  ),
			  'Rule-2'=>array(
				'rule'    => array('fileTypeCheck'),
				'message' => 'Please upload .jpg file or .png file or .gif file only.'
			  )
         )
	);
	
	function nullImageCheck()
	{ 
		if($this->data['Exhibitor']['image1']=="" && $this->data['Exhibitor']['image']['name']=="")
		{
			return false;
		}
		return true;
	}
	
	function fileTypeCheck()
	{
		$ftype = trim(end(explode(".",$this->data['Exhibitor']['image']['name'])));
	
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
