<table cellpadding="0" cellspacing="5" width="95%" class="nostyle">
  <tr>
    <td colspan="2" style="font-family:Verdana, Arial, Helvetica, sans-serif;"><!--Your password will be sent to the email.-->Please enter Registered Email Address.</td>
  </tr>
  <tr>
    <td width="35%" align="left"><strong style="font-family:Verdana, Arial, Helvetica, sans-serif;">Email Address:</strong></td>
    <td align="left" width="65%"><?php echo $form->input('User.email',array('label'=>false,'class'=>'input_01_email','id'=>'email','div'=>false)); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right" style="padding-right:18px;"><?php echo $form->submit('Submit',array('label'=>'','class'=>'submit','id'=>'submit','div'=>false)); ?></td>
  </tr>
</table>
