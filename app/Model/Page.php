<?php 
class Page extends AppModel {
	var $name="Page";
	/*This is validation rule for ppc add form*/
	var $validate = array(
		'title'=>array(
					'rule'=>'notEmpty',
					'message'=>'Please enter page title.'
					),
		'content'=>array(
					'rule' => array('contentValidation'),
					'message'=>'Please enter content.'
					),
		'doc_name'=>array(
					'rule' =>array('fileUploadCheck'),
					'message'=>'Please select document.',
					'on'=>'create'
			)		 	 
		 );
	function fileUploadCheck() {
	  //pr($this->data);
	  if($this->data['Page']['page_type']=='content') {
	    return true;
	  }
	  else if(isset($this->data['Page']['doc_name']['name']) && $this->data['Page']['doc_name']['name']) {
	     return true;
	  }
	  
	  return false;
	}	
	/** Function to validate content if content available */
	function contentValidation() {
		if($this->data['Page']['page_type']=='content' && strip_tags($this->data['Page']['content'])=='') {
	    	 return false;
	  }
	  return true;
	} 
}
?>
