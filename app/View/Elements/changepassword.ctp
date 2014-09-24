<table cellpadding="2" cellspacing="5" width="100%">
  <tr>
    <td colspan="2">Please enter Old Password and New Password.</td>
  </tr>
  <tr>
    <td><span style="color:#FF0000;">*</span><strong>Old Password:</strong></td>
    <td><?php echo $form->input('User.oldpassword',array('label'=>'','type'=>'password','class'=>'input_01','id'=>'oldpassword','div'=>false)); ?></td>
  </tr>
  <tr>
    <td><span style="color:#FF0000;">*</span><strong>New Password:</strong></td>
    <td><?php echo $form->input('User.password1',array('label'=>'','type'=>'password','class'=>'input_01','id'=>'password1','div'=>false)); ?></td>
  </tr>
  <tr>
    <td><span style="color:#FF0000;">*</span><strong>Confirm New Password:</strong></td>
    <td><?php echo $form->input('User.password2',array('label'=>'','type'=>'password','class'=>'input_01','id'=>'password2','div'=>false)); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="padding-right:17px;"><?php echo $form->submit('Submit',array('label'=>'','class'=>'submit','id'=>'submit','div'=>false)); ?></td>
  </tr>
</table>