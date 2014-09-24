<?php
class PhotoGallery extends AppModel {
	var $name = 'PhotoGallery';	
	
	//Validation for ImageLibrary
	// var $validate =  ''; 
	  var $validate = array(																	
		'image' => array(
				'Rule-1'=> array(
					'rule' => 'nullImageCheck',
					'message' => 'Please upload image.',
					'last'=>true
				),
				'Rule-2'=>array(
						'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
						'message' => 'Please upload .jpg file or .png file or .gif file only.'						
				)
			)
	 );
	
	function nullImageCheck()
	{
		if(!isset($this->request->data['PhotoGallery']['id']) && isset($this->data['PhotoGallery']['image']['name']) && $this->data['PhotoGallery']['image']['name']=='')
		{
			return false;
		}
		return true;
	}
}
?>