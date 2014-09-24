<?php 
class News extends AppModel {
	var $name="News";
	/*This is validation rule for ppc add form*/
	var $validate = array(
		'title'=>array(
			'rule-1'=> array(					
					'rule'=>'notEmpty',
					'message'=>'Please enter Title.'
					),
			'rule-2'=> array(
					'rule'=>'isUnique',
					'message'=>'Title already exists. Please use another Title.'
					)
				),									
/*		'description'=>array(
					'rule' => array('contentValidation'),
					'message'=>'Please enter Content.'
					),*/
		'publish'=>array(
			'rule-1'=> array(
				'rule' => 'notEmpty',
				'message' => 'Please enter Publish Date.',
				'last'=>true
				),
	   		'rule-2'=>array(
				'rule' => array('publishdateValidation'),
				'message' => 'Invalid Publish Date.'
				)
			),
		'expire'=>array(
			'rule-1'=> array(
				'rule' => array('expiredateValidation'),
				'message'=>'Invalid Expire Date.',
				'last'=>true
				),
	   		'rule-2'=>array(
				'rule' => array('compare'),
				'message' => 'Expire date should not be less than Publish date.'
				)
			)																			 	 
		 );	 
		 
	function contentValidation() {
		if(strip_tags($this->data['News']['description'])=='') {
	    	 return false;
	  }
	  return true;
	}



	function publishdateValidation() {
		$this->data['News']['publish'] = str_replace('.','-',$this->data['News']['publish']);
		$this->data['News']['publish'] = str_replace('/','-',$this->data['News']['publish']);	
  		if (preg_match("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", $this->data['News']['publish'], $parts))
 	 	{
    	//check weather the date is valid of not
				if(!checkdate($parts[2],$parts[1],$parts[3])) {
						return false;
				}
  		}
	  else{
			return false;
		}	
		return true;	 
	}
	
	
	function expiredateValidation() {
		$this->data['News']['expire'] = str_replace('.','-',$this->data['News']['expire']);
		$this->data['News']['expire'] = str_replace('/','-',$this->data['News']['expire']);	
  		if (preg_match("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/", $this->data['News']['expire'], $parts))
 	 	{
    	//check weather the date is valid of not
				if(!checkdate($parts[2],$parts[1],$parts[3])) {
						return false;
				}
  		}
	  else{
			return false;
		}	
				return true;	 
	}
	
	function compare() {

  		if (strtotime($this->data['News']['expire']) < strtotime($this->data['News']['publish']))
 	 	{
			return false;
  		}
				return true;	 
	}	
				 
}
?>
