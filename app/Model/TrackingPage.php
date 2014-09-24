<?php
class TrackingPage extends AppModel {
	var $name="TrackingPage";
	var $primaryKey = "page_id";
	
	var $validate = array(
			'organization' => array(
				'mustNotEmpty'=>array(
					'rule' => 'notEmpty',
					'message'=> 'Please enter organization'
				)
			),
			'page_name'=> array(
				'mustNotEmpty'=>array(
					'rule' => 'notEmpty',
					'message'=> 'Please enter organization abbreviation.'
				),					
				'mustUnique'=>array(
					'rule' => 'isUnique',
					'message'=> 'This abbreviation has already been taken.'
				)
			)
			
	);
	
}