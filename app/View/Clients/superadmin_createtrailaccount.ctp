<?php 
	$resumeSetOptionList = $common->getResumeSetForTrailAccount();
?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">TRIAL ACCOUNT</div>
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
  <?php echo $this->Form->create(array('name'=>'addClient','id'=>'addClient','type'=>'file'));?>
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
          <td valign="middle" align="right">Resume database to assign for trial:</td>
          <td valign="middle" align="left"><?php echo $this->Form->input("EmployerSet.set_id",array('type'=>'select','options'=>$resumeSetOptionList,'div'=>false,'label'=>false));?></td>
        </tr>
		<tr>
          <td valign="middle" align="right">Start date and time for trial account:</td>
          <td valign="middle" align="left">
		 <?php  $current_year = date('Y');
			$max_year = $current_year;
echo $this->Form->input('TrialAccount.start_time', array('type'=>'date', 'default'=>mktime(0,0,0,date('m'),date('d'),date('Y')), 'empty'=>false, 'minYear'=>$current_year, 'maxYear'=>$max_year,'div'=>false,'label'=>false));?>
          &nbsp;&nbsp;
            Time:
			<?php  echo $this->Form->input('TrialAccount.start_time', array('type' => 'time', 'interval' => 1,'timeFormat' => 12,'default' => date('H:i:s'),'label'=>false,'div'=>false)); ?>
		</td>
        </tr>
        <tr>
          <td valign="middle" align="right">End date and time for trial account:</td>
          <td valign="middle" align="left">
		 <?php  $current_year = date('Y');
$max_year = $current_year;
echo $this->Form->input('TrialAccount.end_time', array('type'=>'date', 'default'=>mktime(0,0,0,date('m'),date('d')+1,date('Y')), 'empty'=>false, 'minYear'=>$current_year, 'maxYear'=>$max_year,'div'=>false,'label'=>false));?>
         
            
            &nbsp;&nbsp;
            Time:
			<?php echo $this->Form->input('TrialAccount.end_time', array('type' => 'time', 'interval' => 1, 'default' => '09:00:00','label'=>false,'div'=>false)); ?>
     </td>
        </tr>
        <tr>
          <td valign="middle" align="right">Your name (salesperson):</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('TrialAccount.sales_name',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Your extension (salesperson):</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('TrialAccount.sales_ext',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right">Your email (salesperson):</td>
          <td valign="middle" align="left"><?php echo $this->Form->input('TrialAccount.sales_email',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle" align="right"></td>
          <td valign="top" align="left"><?php echo $this->Form->submit('Create Trial Account',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
  <?php echo $this->Form->end();?>
    
  </div>
</div>
