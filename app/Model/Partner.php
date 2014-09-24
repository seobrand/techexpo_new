<?php
App::uses('AppModel', 'Model');
/**
 * PressRelease Model
 *
 */
class Partner extends AppModel {
	
	public $validate = array(
		'partner_name' => array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please enter partner name',
			)
		),
		'employer_id'	=> array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please select partner which logo file want to associate.',
			)
		),
		'marketing_exhibitor_id'	=> array(
			'notempty' => array(
				'rule' => 'notEmpty',
				'message' => 'Please select marketing partner.',
			)
		)
		/*'partner_logo' => array(
			'rule' => array(
				'extension', array('jpeg', 'jpg','png','gif')
			 ),
			'message' => 'You must supply a valid logo file.',
		)*/
	);
	
/*	var $belongsTo = array(
		'MarketingExhibitor' => array(
			'className' => 'MarketingExhibitor',
			'fields' =>array('id','employer_name','logo_file','url'),
			'foreign_key' => 'employer_id'
		)
	);*/
	
}
