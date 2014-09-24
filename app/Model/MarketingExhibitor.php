<?php
App::uses('AppModel', 'Model');
/**
 * Pix Model
 *
 */
class MarketingExhibitor extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
public $useTable = 'marketing_exhibitors';



	
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
				'on'=>'create',
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
	
	
		if($this->data['MarketingExhibitor']['image1']=="" && $this->data['MarketingExhibitor']['image']['name']=="")
		{
			return false;
		}
		return true;
	}
	
	function fileTypeCheck()
	{
		$ftype = trim(end(explode(".",$this->data['MarketingExhibitor']['image']['name'])));
	
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
