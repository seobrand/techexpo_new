<?php 
class Banner extends AppModel {
	var $name="Banner";
	public $useDbConfig = 'bannerDB';
	public $useTable = 'ads';

	var $belongsTo = array(
			'Category' => array(
					'className' => 'BannerCategory',
					'foreignKey'   => 'category_link'
			)
	);
	
	/**** validation for banner *****/
	public $validate = array(
		'name' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter banner title.'
		),
		'href' => array(
				'rule' => 'url',
				'allowEmpty' => true,
				'message' => 'Please enter valid link'
		),
        'filename' => array(
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
		if($this->data['Banner']['filename1']=="" && $this->data['Banner']['filename']['name']=="")
		{
			return false;
		}
		return true;
	}
	
	function fileTypeCheck()
	{
		$ftype = trim(end(explode(".",$this->data['Banner']['filename']['name'])));
	
		if(strlen($ftype)>1){
			if(strtolower($ftype) =="png" || strtolower($ftype) =="jpeg" || strtolower($ftype) =="jpg"  || strtolower($ftype) =="gif"){
				return true;
			}else{
				return false;
			}
		}
		return true;
	
	}
	
}
?>