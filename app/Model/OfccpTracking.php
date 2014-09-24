<?php
App::uses('AppModel', 'Model');
/**
 * ResumeScore Model
 *
 * @property JOB $Employer
 * @property  $
 */
class OfccpTracking extends AppModel {
	var $name="OfccpTracking";
	public $useTable = 'ofccp_tracking';
	public $primaryKey = 'tracking_id';

}