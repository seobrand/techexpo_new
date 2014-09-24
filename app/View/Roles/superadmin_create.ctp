<?php  
 echo $this->element('admin-breadcrumbs',array('pageName'=>'addrole'));
 $this->set('title_for_layout', 'Add User Group');
?>
<?php echo $this->Form->create('Role', array('action'=>'create','id'=>'form'));?>
<div class="title-pad">
  <div class="title">
    <h5>Add New User Group</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="15%" align="right" valign="top"><span class="required">*</span>Group Name :</td>
        <td width="85%" align="left" valign="top"><?php echo $this->Form->input('role_name', array('label'=>'','id'=>'role_name','class'=>'inputbox1','tabindex'=>1,'div'=>false,'style'=>'width:192px;height:15px;','error'=>false,'error'=>false)); ?></td>
      </tr>
	  
      <?php //starting permissions..... ?>
      <?php 
	 if(!isset($userpermissions) || is_array($userpermissions) ) { $userpermissions = array();}
	  if(in_array($this->params['controller'].'/'.substr($this->params['action'],6),$userpermissions) || $this->Session->read('Auth.Adminuser.role_id')==1) { ?>
      <tr>
        <td align="right" valign="top"> <strong>Permissions</strong></td>

      <?php 
		 $defaultArr = array(); 
		?>
        <td align="left" valign="top"><?php echo '&nbsp;&nbsp;'.$form->checkbox('main',array('onClick' => 'makeSelectedCheckboxs("RoleAllowedfunctions",this.checked,"counterId")')); ?>&nbsp;Select All</td>
      </tr>
      <tr>
        <td align="right" valign="top"> Dashboard </td>
        <td align="left" valign="top"><?php echo '&nbsp;&nbsp;'.$this->Form->checkbox('dashboard_view',array('checked'=>'checked','disabled'=>'disabled')); ?>&nbsp;View</td>
      </tr>		  
      <?php $permissionArr = array(				
		'Client'=>array(
			'adminclients/index'=>'List',
			'adminclients/create'=>'Add',
			'adminclients/update'=>'Edit',
			'adminclients/view'=>'View',
			'adminclients/delete'=>'Delete'
			),
		'Candidate'=>array(
			'candidates/index'=>'List',
			'candidates/create'=>'Add',
			'candidates/update'=>'Edit',
			'candidates/view'=>'View',
			'candidates/delete'=>'Delete',
			'candidates/send_mails'=>'Mail Merge'
			),
		'Temp Timesheet'=>array(
			'usertimesheets/index'=>'List',
			'usertimesheets/create'=>'Add',
			'usertimesheets/update'=>'Edit',
			'usertimesheets/view'=>'View',
			'usertimesheets/delete'=>'Delete'
			),	
		'Jobs'=>array(
			'adminjobs/index'=>'List',
			'adminjobs/create'=>'Add',
			'adminjobs/update'=>'Edit',
			'adminjobs/view'=>'View',
			'adminjobs/delete'=>'Delete'
			),
		'News'=>array(
			'news/index'=>'List',
			'news/create'=>'Add',
			'news/update'=>'Edit',
			'news/view'=>'View',
			'news/delete'=>'Delete'
			),			
		'Area of Interest'=>array(
			'areaofinterests/index'=>'List',
			'areaofinterests/create'=>'Add',
			'areaofinterests/update'=>'Edit',
			'areaofinterests/view'=>'View',
			'areaofinterests/delete'=>'Delete',
			'areaofinterests/update_order'=>'Update'
			),	
		'Ethnicity'=>array(
			'ethnicities/index'=>'List',
			'ethnicities/create'=>'Add',
			'ethnicities/update'=>'Edit',
			'ethnicities/view'=>'View',
			'ethnicities/delete'=>'Delete',
			'ethnicities/update_order'=>'Update'	
			),	
		'Job Types'=>array(
			'jobtypes/index'=>'List',
			'jobtypes/create'=>'Add',
			'jobtypes/update'=>'Edit',
			'jobtypes/view'=>'View',
			'jobtypes/delete'=>'Delete',
			'jobtypes/update_order'=>'Update'			
			),	
		'Locations'=>array(
			'joblocations/index'=>'List',
			'joblocations/create'=>'Add',
			'joblocations/update'=>'Edit',
			'joblocations/view'=>'View',
			'joblocations/delete'=>'Delete',
			'joblocations/update_order'=>'Update'			
			),	
		'Salary'=>array(
			'salaries/index'=>'List',
			'salaries/create'=>'Add',
			'salaries/update'=>'Edit',
			'salaries/view'=>'View',
			'salaries/delete'=>'Delete',
			'salaries/update_order'=>'Update'			
			),	
		'Titles'=>array(
			'titles/index'=>'List',
			'titles/create'=>'Add',
			'titles/update'=>'Edit',
			'titles/view'=>'View',
			'titles/delete'=>'Delete',

			'titles/update_order'=>'Update'			
			),
		'Postcode Group'=>array(
			'postcodechoices/index'=>'List',
			'postcodechoices/create'=>'Add',
			'postcodechoices/update'=>'Edit',
			'postcodechoices/view'=>'View',
			'postcodechoices/delete'=>'Delete',
			'postcodechoices/update_order'=>'Update'			
			),		
		'Pages'=>array(
			'pages/index'=>'List',
			'pages/create'=>'Add',
			'pages/update'=>'Edit',
			'pages/view'=>'View',
			'pages/delete'=>'Delete'
			),
		'Images'=>array(
			'images/index'=>'List',
			'images/create'=>'Add',
			'images/update'=>'Edit',
			'images/view'=>'View',
			'images/delete'=>'Delete',
			'images/update_order'=>'Update'				
			),						
		'User Groups'=>array(
			'roles/index'=>'List',
			'roles/create'=>'Add',
			'roles/update'=>'Edit',
			'roles/view'=>'View',
			'roles/delete'=>'Delete'
			),	
		'Settings'=>array(
			'settings/index'=>'List',
			'settings/create'=>'Add',
			'settings/update'=>'Edit',
			'settings/view'=>'View',
			'settings/delete'=>'Delete'
			),	
		'Email Templates'=>array(
			'email_templates/index'=>'List',
			'email_templates/create'=>'Add',
			'email_templates/update'=>'Edit',
			'email_templates/view'=>'View',
			'email_templates/delete'=>'Delete'
			),
		'Version Control'=>array(
			'versions/index'=>'List',
			'versions/create'=>'Add',
			'versions/update'=>'Edit',
			'versions/view'=>'View',
			'versions/delete'=>'Delete'
			),			
		'User Profiles'=>array(
			'adminusers/index'=>'List',
			'adminusers/create'=>'Add',
			'adminusers/update'=>'Edit own record',
			'adminusers/view'=>'View own record',			
			//'adminusers/editadminuser'=>'Edit other admin users'
			),
		 'Job board'=>array(
			'jobboards/index'=>'List',
			'jobboards/create'=>'Add',
			'jobboards/update'=>'Edit',
			'jobboards/response_board'=>'View Active Job Board',
			'jobboards/delete'=>'Delete',
			'jobboards/send_mails'=>'Mail Merge',
			'jobboards/update_rating'=>'Update Rating'
			//'adminusers/editadminuser'=>'Edit other admin users'
			)		
																					
		);
		$i=0; 
		
		foreach($permissionArr as $title=>$permission) {
			 echo '<tr><td align="right" valign="top">'.$title.'</td>';
			 echo '<td align="left" valign="top">';
			 
			 foreach($permission as $key=>$val)  {
			 
			 	 echo '&nbsp;&nbsp;';
				 echo $form->input('Role.allowedfunctions.'.$i,array('label'=>'','type'=>'checkbox','value'=>$key,'checked'=>in_array($key,$defaultArr),'div'=>false));
				 
				echo '&nbsp;&nbsp;';
				 echo $val;
			 
				$i++;
			 }
		 
			 echo '</td></tr>';
		 }
		 echo $form->input('counterId',array('type'=>'hidden','value'=>$i,'id'=>'counterId'));
		?>
    <?php } ?>	 	  
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
     </table>
  </div>
</div>
<input type="hidden" value="SUBMIT" name="SUBMIT" />
<?php echo $this->Form->end();?> 