<?php
//App::uses('AppModel', 'Model');
/**
 * Location Model
 *
 */
class Location extends AppModel {
var $name = 'Location';


//public $primaryKey = 'location_id';	


	var $virtualFields = array('location_name' => 'CONCAT(Location.location_state," ",Location.site_name)');

		
	public $validate = array(
    	'site_name' => array(
        'rule'       => 'notEmpty', // or: array('ruleName', 'param1', 'param2' ...)
        'message'    => 'Please Enter Site Name'
		),
		'site_address' => array(
			'rule'       => 'notEmpty', // or: array('ruleName', 'param1', 'param2' ...)
			'message'    => 'Please Enter Site Address'
		),
		'location_city' => array(
			'rule'       => 'notEmpty', // or: array('ruleName', 'param1', 'param2' ...)
			'message'    => 'Please Enter City Name'
		),
		'location_state' => array(
			'rule'       => 'notEmpty', // or: array('ruleName', 'param1', 'param2' ...)
			'message'    => 'Please Enter State Name'
		),
		'site_zip' => array(
			'rule'       => 'notEmpty', // or: array('ruleName', 'param1', 'param2' ...)
			'message'    => 'Please Enter Zip Code'
		),
		'site_electricity_cost' => array(
			'rule' 		 => '/^[0-9]{1,7}(\.[0-9]{1,2})?$/', // or: array('ruleName', 'param1', 'param2' ...)
			'allowEmpty' => false,
			'message'    => 'Please Enter Valid Electricity Cost'
		),
		'internet_connectivity_cost' => array(
			'rule' 		 => '/^[0-9]{1,7}(\.[0-9]{1,2})?$/', // or: array('ruleName', 'param1', 'param2' ...)
			'allowEmpty' => false,
			'message'    => 'Please Enter Valid Internet Connectivity Cost'
		)
	);
	
}
