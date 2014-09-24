<?php
/*************************************
Admin user role model
Object : All validation of admin role management will goes here 
*************************************/ 
class Role extends AppModel {
	var $name="Role";
	//var $hasOne = array('Adminpermission');
	//Validation for users
	var $validate =  array(
		'role_name' => array(
			'emailRule-1'=> array(
				'rule' => 'notEmpty',
				'message' => 'Please insert role name.',
				'last'=>true
				),
			'emailRule-2'=>array(
				'rule' => 'isUnique',
				'message' => 'Role name already in use, Please try another.'
				)
			)
		);	
}
?>