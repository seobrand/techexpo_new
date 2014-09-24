<?php
App::uses('AppModel', 'Model');
/**
 * Testimonial Model
 *
 */
class Testimonial extends AppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
							'rule' => array('notempty'),
							'message' => 'Please enter testimonial title'
							),
			
						),
		'text' => array(
			'notempty' => array(
							'rule' => array('notempty'),
							'message' => 'Please enter description.'
							),
			
						)
					
					
		  /*             
                'logo_file' => array(
                    
					  'image' => array(
										'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
										'allowEmpty' => true,
										'message' => 'You must supply a GIF, PNG or JPG file.',
										'last'=>true
										),
					  'checkfileSize'=>array(
								'rule' =>  array('checkSize',true),
								'message'=> 'Image Size not more then 1 MB',
								'last'=>false
								)
                )*/
	);
	
	function nullImageCheck()
	{
		if($this->data['Testimonial']['logo_file']['name']=="")
		{
			return false;
		}
		return true;
	}
	
	function fileTypeCheck()
	{
		$ftype = trim(end(explode(".",$this->data['Testimonial']['logo_file']['name'])));
	
		if(strlen($ftype)>0){
			if(strtolower($ftype) =="png" || strtolower($ftype) =="jpeg" || strtolower($ftype) =="jpg"  || strtolower($ftype) =="gif"){
				return true;
			}else{
				return false;
			}
		}
		return true;
	
	}
	
	 function checkSize($data, $required = false){
        $data = array_shift($data);
		
        if(!$required && $data['error'] == 4){
            return true;
        }
        if($data['size'] == 0 || $data['size']/1024 > 1024){
		    return true;
        }
        return true;
    }
}
