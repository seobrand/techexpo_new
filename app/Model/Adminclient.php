<?php 
class Adminclient extends AppModel {
	var $name="Client";
	var $useTable = 'homepage_dynamic_content';
	/* This is a virtual field, return full name of client*/
	var $virtualFields = array(
		'full_name' => 'CONCAT(Adminclient.first_name, " ", Adminclient.last_name)'
	);		
	/*This is validation rule for ppc add form*/
	var $validate = array();
	/* Function to check  user information */
	function validatesAdminclientInfo($arr) {
	
	if(!empty($arr['SUBMIT']))
	{
	   $error = array();
	   App::uses('Core', 'Validation'); 
	   $validation = new Validation();
	   /* Account information validation */
	   if(!$arr['Adminclient']['title']) {
	      $error[] = 'Please select Title.';
	   }
	   if(!trim($arr['Adminclient']['first_name'])) {
	      $error[] = 'Please enter First Name.';
	   }	   
	   else if(!preg_match("/^[a-z][\w\- ]*(?<![^a-z])$/i", $arr['Adminclient']['first_name'])) {
	   		$error[] = 'Please enter valid First Name.';
	   }
	   if(!trim($arr['Adminclient']['last_name'])) {
	      $error[] = 'Please enter Surname.';
	   }	   	   
	   else if(!preg_match("/^[a-z][\w\- ]*(?<![^a-z])$/i", $arr['Adminclient']['last_name'])) {
	   		$error[] = 'Please enter valid Surname.';
	   }	
	   if(!trim($arr['Adminclient']['department'])) {
	      $error[] = 'Please enter Title or Department.';
	   }
	   if(!trim($arr['Adminclient']['company_name'])) {
	      $error[] = 'Please enter Company Name.';
	   }
/*	   else if(!$this->isUnique(array('company_name'=>$arr['Adminclient']['company_name']))) {
	      $error[] = 'Company Name already in use. Please enter another Company Name.';
	   }*/	   
	   $primary_contact = $arr['Adminclient']['primary_contact'];
	   if(!$primary_contact) {
	   		$error[] = 'Please select Primary Contact.'; 
	   }
	   else if(!$arr['Adminclient'][$primary_contact]){
	   		$error[] = 'Please enter Primary Contact.'; 	 
	   }
/*	   if(!$validation->alphaNumeric($arr['Client']['postcode'])) {
	      $error[] = 'Please enter valid post code.';
	   }*/
	   if(!trim($arr['Adminclient']['postcode'])) {
	      $error[] = 'Please enter valid Postcode.';
	   }	   	   	
	   if(!$validation->email($arr['Adminclient']['email'])) {
	      $error[] = 'Please enter valid Email Address.';
	   }
	   else if(!$this->isUnique(array('email'=>$arr['Adminclient']['email']))) {
	      $error[] = 'Email Address already in use. Please enter another email address.';
	   }
	   if(!$arr['Adminclient']['password1']) {
	      $error[] = 'Please enter Password.';
	   }
	   if(!$arr['Adminclient']['password2']) {
	      $error[] = 'Please enter Confirm Password.';
	   }
	   if($arr['Adminclient']['password1']!=$arr['Adminclient']['password2']) {
	   	 	$error[] = 'Password and Confirm Password must be same.';
	   }	      
	   if(!isset($arr['Adminclient']['area_of_interests']) || !(is_array($arr['Adminclient']['area_of_interests']) && count($arr['Adminclient']['area_of_interests']))) {
	      $error[] = 'Please select at least one Area of Interest.';
	   }
	   return $error;
	 }
	}
	//Edit a Client
	function validatesAdminclientEditInfo($arr) {            
	   $error = array();
	   $this->id = $arr['Adminclient']['id'];
	   App::uses('Core', 'Validation'); 
	   $validation = new Validation();
	   /* Account information validation */
	   if(!$arr['Adminclient']['title']) {
	      $error[] = 'Please select Title.';
	   }
	   if(!trim($arr['Adminclient']['first_name'])) {
	      $error[] = 'Please enter First Name.';
	   }	   
	   else if(!preg_match("/^[a-z][\w\- ]*(?<![^a-z])$/i", $arr['Adminclient']['first_name'])) {
	   		$error[] = 'Please enter valid First Name.';
	   }
	   if(!trim($arr['Adminclient']['last_name'])) {
	      $error[] = 'Please enter Surname.';
	   }	   	   
	   else if(!preg_match("/^[a-z][\w\- ]*(?<![^a-z])$/i", $arr['Adminclient']['last_name'])) {
	   		$error[] = 'Please enter valid Surname.';
	   }	
	   if(!trim($arr['Adminclient']['department'])) {
	      $error[] = 'Please enter Title or Department.';
	   }
	   if(!trim($arr['Adminclient']['company_name'])) {
	      $error[] = 'Please enter Company Name.';
	   }
/*	   else if(!$this->isUnique(array('company_name'=>$arr['Adminclient']['company_name']))) {
	      $error[] = 'Company Name already in use. Please enter another Company Name.';
	   }*/	   
	   $primary_contact = $arr['Adminclient']['primary_contact'];
	   if(!$primary_contact) {
	   		$error[] = 'Please select Primary Contact.'; 
	   }
	   else if(!$arr['Adminclient'][$primary_contact]){
	   		$error[] = 'Please enter Primary Contact.'; 	 
	   }
	/* if(!$validation->alphaNumeric($arr['Client']['postcode'])) {
	      $error[] = 'Please enter valid post code.';
	   }*/
	   if(!trim($arr['Adminclient']['postcode'])) {
	      $error[] = 'Please enter valid Postcode.';
	   }	   	   	
	   if(!$validation->email($arr['Adminclient']['email'])) {
	      $error[] = 'Please enter valid Email Address.';
	   }
	   else if(!$this->isUnique(array('email'=>$arr['Adminclient']['email']))) {
	      $error[] = 'Email Address already in use. Please enter another email address.';
	   }	   
	   if(!$arr['Adminclient']['password1']) {
	      $error[] = 'Please enter Password.';
	   }
	   if(!$arr['Adminclient']['password2']) {
	      $error[] = 'Please enter Confirm Password.';
	   }
	   if($arr['Adminclient']['password1']!=$arr['Adminclient']['password2']) {
	   	 	$error[] = 'Password and Confirm Password must be same.';
	   }	      
	   if(!isset($arr['Adminclient']['area_of_interests']) || !(is_array($arr['Adminclient']['area_of_interests']) && count($arr['Adminclient']['area_of_interests']))) 				      {
	      $error[] = 'Please select at least one Area of Interest.';
	   }
	   return $error;
	}		
}
?>
