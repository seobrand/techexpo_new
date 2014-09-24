<?php 
class ClientModel extends AppModel {
	var $name="Client";
	/*This is validation rule for ppc add form*/
	var $validate = array();
	/* Function to check  Client information */
	function validatesClientInfo($arr) {
	   $error = array();
	   App::import('Core', 'Validation'); 
	   $validation = new Validation();
	   /* Account information validation */
	   if(!$arr['Client']['title']) {
	      $error[] = 'Please select Title.';
	   }
	   if(!trim($arr['Client']['first_name'])) {
	      $error[] = 'Please enter First Name.';
	   }	   
	   else if(!preg_match("/^[a-z][\w\- ]*(?<![^a-z])$/i", $arr['Client']['first_name'])) {
	   		$error[] = 'Please enter valid First Name.';
	   }	   
	   if(!trim($arr['Client']['last_name'])) {
	      $error[] = 'Please enter Surname.';
	   }
	   else if(!preg_match("/^[a-z][\w\- ]*(?<![^a-z])$/i", $arr['Client']['last_name'])) {
	   		$error[] = 'Please enter valid Surname.';
	   }	   
/*	   if(!$validation->alphaNumeric($arr['Client']['last_name'])) {
	      $error[] = 'Please enter Surname.';
	   }*/
	   if(!trim($arr['Client']['department'])) {
	      $error[] = 'Please enter Title or Department.';
	   }
	   if(!trim($arr['Client']['company_name'])) {
	      $error[] = 'Please enter Company Name.';
	   }
/*	   else if(!$this->isUnique(array('company_name'=>$arr['Client']['company_name']))) {
	      $error[] = 'Company Name already in use. Please enter another Company Name.';
	   }*/	   
	   $primary_contact = $arr['Client']['primary_contact'];
	   if(!$primary_contact) {
	   		$error[] = 'Please select Primary Contact.'; 
	   }
	   else if(!$arr['Client'][$primary_contact]){
	   		$error[] = 'Please enter Primary Contact.'; 	 
	   }
/*	   if(!$validation->alphaNumeric($arr['Client']['postcode'])) {
	      $error[] = 'Please enter valid post code.';
	   }*/
	   if(!trim($arr['Client']['postcode'])) {
	      $error[] = 'Please enter valid Postcode.';
	   }	   	   	
	   if(!$validation->email($arr['Client']['email'])) {
	      $error[] = 'Please enter valid Email Address.';
	   }
	   else if(!$this->isUnique(array('email'=>$arr['Client']['email']))) {
	      $error[] = 'Email Address already in use. Please enter another email address.';
	   }
	   if(!$arr['Client']['password1']) {
	      $error[] = 'Please enter Password.';
	   }
	   if(!$arr['Client']['password2']) {
	      $error[] = 'Please enter Confirm Password.';
	   }
	   if($arr['Client']['password1']!=$arr['Client']['password2']) {
	   	 	$error[] = 'Password and Confirm Password must be same.';
	   }
	   
	   if(!isset($arr['Client']['area_of_interests']) || !(is_array($arr['Client']['area_of_interests']) && count($arr['Client']['area_of_interests']))) {
	      $error[] = 'Please select at least one Area of Interest.';
	   }
	   if(!$arr['Client']['captcha']) {
	      $error[] = 'Please enter Security Code.';
	   }
	   return $error;
	}
	// validation function for edit profile
	function validatesClientEditInfo($arr) {
	   $error = array();
	   $this->id = $arr['Client']['id'];
	   App::import('Core', 'Validation'); 
	   $validation = new Validation();
	   /* Account information validation */
	   if(!$arr['Client']['title']) {
	      $error[] = 'Please select Title.';
	   }	   
	   if(!trim($arr['Client']['first_name'])) {
	      $error[] = 'Please enter First Name.';
	   }	   
	   else if(!preg_match("/^[a-z][\w\- ]*(?<![^a-z])$/i", $arr['Client']['first_name'])) {
	   		$error[] = 'Please enter valid First Name.';
	   }	   
	   if(!trim($arr['Client']['last_name'])) {
	      $error[] = 'Please enter Surname.';
	   }
	   else if(!preg_match("/^[a-z][\w\- ]*(?<![^a-z])$/i", $arr['Client']['last_name'])) {
	   		$error[] = 'Please enter valid Surname.';
	   }	   
	    if(!trim($arr['Client']['department'])) {
	      $error[] = 'Please enter Title or Department.';
	   }
	   if(!trim($arr['Client']['company_name'])) {
	      $error[] = 'Please enter Company Name.';
	   }
/*	   else if(!$this->isUnique(array('company_name'=>$arr['Client']['company_name']))) {
	      $error[] = 'Company Name already in use. Please enter another Company Name.';
	   }*/	   
	   $primary_contact = $arr['Client']['primary_contact'];
	   if(!$primary_contact) {
	   		$error[] = 'Please select Primary Contact.'; 
	   }
	   else if(!$arr['Client'][$primary_contact]){
	   		$error[] = 'Please enter Primary Contact.'; 	 
	   }
/*	   if(!preg_match("/^[A-Z0-9_ <]+$/", $arr['Client']['postcode'])) {
	   $error[] = 'Please enter valid postcode (like: BR3 1SU).';
	   }*/
	   if(!trim($arr['Client']['postcode'])) {
	      $error[] = 'Please enter valid Postcode.';
	   }		   
	   if(!$validation->email($arr['Client']['email'])) {
	      $error[] = 'Please enter valid Email Address.';
	   }
	   else if(!$this->isUnique(array('email'=>$arr['Client']['email']))) {
	      $error[] = 'Email Address already in use. Please enter another email address.';
	   }	   
	   if(!isset($arr['Client']['area_of_interests']) || !(is_array($arr['Client']['area_of_interests']) && count($arr['Client']['area_of_interests']))) {
	      $error[] = 'Please select at least one Area of Interest.';
	   }
	   if(!$arr['Client']['captcha']) {
	      $error[] = 'Please enter Security Code.';
	   }
	   return $error;
	}
 /* Change password validation */
	  function changePasswordValidation($arr,$encriptOldPassword) {
	  	$error = array(); 
	  	if(!trim($arr['Client']['oldpassword'])) {
		   $error[] = 'Please enter Old Password.';
		}
	  	if(!trim($arr['Client']['password1']) || !trim($arr['Client']['password2'])) {
		   $error[] = 'Please enter New Password or Confirm Password.';
		}
		else if($arr['Client']['password1']!=$arr['Client']['password2']) {
				$error[] = 'New Password and Confirm Password do not match.';	
			 }
			else {
			  $uid = $this->field('Client.id',array('Client.password'=>$encriptOldPassword));
			  if(!$uid) {
			   	$error[] = 'Old Password do not match.';
			  }
			}
		 return $error;	
	  }		
}
?>