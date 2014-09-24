<?php 
class OtherBanner extends AppModel {
	var $name="OtherBanner";
	public $useTable = 'other_banners';

	/**** validation for banner *****/
	public $validate = array(
		'name' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter banner title.'
		),
		'filename' => array(
				'rule' => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
				'message' => 'Please supply image with gif, jpeg, jpg or png type.' 
		)
	
	);
	

	
}
?>