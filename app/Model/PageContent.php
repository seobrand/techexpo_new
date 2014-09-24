<?php 
class PageContent extends AppModel {
	var $name="PageContent";

	/**** validation for banner *****/
	public $validate = array(
		'content' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter page content.'
		)
	);
	
}
?>