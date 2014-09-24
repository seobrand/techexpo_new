<script type="text/javascript">
	function isNumericKey(e)
	{
		if (window.event) { var charCode = window.event.keyCode; }
		else if (e) { var charCode = e.which; }
		else { return true; }
		if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; }
		return true;
	}
	</script>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">New Client</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<div class="display_row">
  <div class="table">
  <?php echo $this->Form->create("EmployerContact",array('name'=>'addClient','id'=>'addClient','type'=>'file'));?>
    <table border="0" cellpadding="0" cellspacing="0">
      <tbody>
        <tr>
          <td valign="middle" align="right" width="25%">Username:</td>
          <td valign="top" align="left" width="74%"><?php echo $this->Form->input('User.username',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Password:</td>
          <td valign="top" align="left"><?php echo $this->Form->input('User.password',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Company name:</td>
          <td valign="top" align="left"><?php echo $this->Form->input('Employer.employer_name',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Contact name:</td>
          <td valign="top" align="left"><?php echo $this->Form->input('EmployerContact.contact_name',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Contact email: <br>
            (for TECHEXPO e-mails)</td>
          <td valign="top" align="left"><?php echo $this->Form->input('EmployerContact.contact_email',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Email for resumes:(for candidates to send resumes)</td>
          <td valign="top" align="left"><?php echo $this->Form->input('EmployerContact.contact_email_job',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Logo file:</td>
          <td valign="top" align="left"><?php echo $this->Form->input('Employer.logo_file',array('type'=>'file','label'=>false,'div'=>false,'error'=>false));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Max number of jobs:</td>
          <td valign="top" align="left"><?php echo $this->Form->input('Employer.max_jobs',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1','onkeypress'=>'return isNumericKey(event);'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right"></td>
          <td valign="top" align="left"><?php echo $this->Form->submit('Add Client',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
  <?php echo $this->Form->end();?>
  </div>
</div>
