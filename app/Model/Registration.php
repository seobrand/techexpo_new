<?php
class Registration extends AppModel {
var $name="Registration";
var $belongsTo=array( 
					 'show' => array('foreignKey'   => 'show_id'),
					 'Candidate' => array('foreignKey'   => 'candidate_id')
					);
					
	
function eventValidate() {	  
		$validate1 = array(
				'show_id'=> array(
					'multiple'=>array(
						'rule' => 'multiple',
						'message'=> 'Please select event',
						'last'=>true),
					'mustBeEmail'=> array(
						'rule' => 'checkEventRegistration',
						'message' => 'Already registered for this event',
						'last'=>true)
					),
				'hear_about'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please enter hear about this event',
						'last'=>true)
					)
			);
			$this->validate=$validate1;
			return $this->validates();
	}
	
function checkParerlessCandidate() {	  // validation for paperless candidate registration 
		$validate1 = array(
				'show_id'=> array(
					'mustNotEmpty'=>array(
						'rule' => 'notEmpty',
						'message'=> 'Please select show',
						'last'=>true)
					)
			);
			$this->validate=$validate1;
			return $this->validates();
	}
	

protected function checkEventRegistration() // check for alrready register for this event or not
	{ 
		$rec=$this->query('select count(*) as total from registrations where candidate_id="'.$this->data['Registration']['candidate_id'].'" && show_id="'.$this->data['Registration']['show_id'].'"');
		
		if($rec['0']['0']['total'])
		{
			return false;
		}else
		{
			return true;
		}
	
	}


}
