<?php 
class EmailTemplates extends AppModel {
	var $name="EmailTemplate";
	/*This is validation rule for ppc add form*/
	var $validate =  array(
				 'title'=>array('rule' => 'notEmpty',
        		 				'message' => 'Please insert Title.'),
				 'subject' => array(
        						'rule' => 'notEmpty',
        						'message' => 'Please insert Subject.'),
				 'message' => array(
        						'rule' =>array('contentValidation'),
        						'message' => 'Please insert Message.')
						
				 );

	function contentValidation() {
		if(strip_tags($this->data['EmailTemplate']['message'])=='') {
	    	 return false;
	  }
	  return true;
	}	
}	 
?>
