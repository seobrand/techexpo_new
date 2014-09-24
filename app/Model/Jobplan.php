<?php
class Jobplan extends AppModel{
    var $name = "Jobplan";
	
	var $validate = array(
		'title' => array(
			'noBlank' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter the job plan title.'
			)
		),
		'price' => array(
			'noBlank' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter the job plan price.'
			),
			'validPrice' => array(
				 'rule'    => 'numeric',
       			 'message' => 'Please enter valid price amount.'
			)
		),
		'jobs' => array(
			'noBlank' => array(
				'rule'    => 'notEmpty',
				'message' => 'Please enter the number of job for this plan.'
			),
			'validJobs' => array(
				 'rule'    => 'numeric',
       			 'message' => 'Please enter valid job.'
			)
		)
	);
	
}
?>