<?php  
 echo $this->element('admin-breadcrumbs',array('pageName'=>'addadminuser'));
 $this->set('title_for_layout', 'Add Admin User');
?>
<?php echo $this->Form->create('Adminuser', array('action'=>'create','id'=>'form'));?>
<div class="title-pad">
  <div class="title">
    <h5>Add New User Profile</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="15%" align="right" valign="top"><span class="required">*</span>First name :</td>
        <td width="85%" align="left" valign="top"><?php echo $this->Form->input('first_name', array('label'=>'','id'=>'first_name','class'=>'inputbox1','div'=>false,'style'=>'width:280px;height:15px;','error'=>false)); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Surname :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('last_name', array('label'=>'','id'=>'last_name','class'=>'inputbox1','div'=>false,'style'=>'width:280px;height:15px;','error'=>false)); ?></td>
      </tr>
	  <tr>
        <td align="right" valign="top"><span class="required">*</span>Preferred Name :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('username', array('label'=>'','id'=>'username','class'=>'inputbox1','div'=>false,'style'=>'width:280px;height:15px;','error'=>false)); ?> </td>
      </tr>	  
	  <tr>
        <td align="right" valign="top"><span class="required">*</span>Email :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('email', array('label'=>'','id'=>'email','class'=>'inputbox1','div'=>false,'style'=>'width:280px;height:15px;','error'=>false)); ?></td>
      </tr>

	  <tr>
        <td align="right" valign="top"><span class="required">*</span>Password :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('new_password',array('label'=>'','type'=>'password','class'=>'inputbox1','id'=>'new_password','div'=>false,'style'=>'width:280px;height:15px;','error'=>false)); ?></td>
      </tr>
	  <tr>
        <td align="right" valign="top"><span class="required">*</span>Confirm Password :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('repassword', array('label'=>'','type'=>'password','class'=>'inputbox1','id'=>'repassword','div'=>false,'style'=>'width:280px;height:15px;','error'=>false)); ?></td>
      </tr>
	  <tr>
        <td align="right" valign="top"><span class="required">*</span>Group Name :</td>
        <td align="left" valign="top"><?php echo $this->Form->select('role_id',$adminroles,array('class'=>'selectbox','empty'=>'Select User Group','id'=>'role_id','div'=>false,'escape'=>false,'style'=>'width:288px;height:23px;','error'=>false)); ?></td>
      </tr>
	   <tr>
        <td align="right" valign="top">Active :</td>
        <td align="left" valign="top"><?php  $options=array('yes'=>'Yes','no'=>'No');
 $attributes=array('label'=>false,'legend'=>false,'default'=>'yes','div'=>false,'id'=>'active');
 echo $this->Form->radio('active',$options,$attributes); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
     </table>
  </div>
</div>
<input type="hidden" value="SUBMIT" name="SUBMIT" />
<?php echo $this->Form->end();?> 
