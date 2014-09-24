<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Add / Edit company contact information</div>
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
  <?php echo $this->Form->create("EmployerContact",array('name'=>'empProfile','id'=>'empProfile'));?>
    <table cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td colspan="2"><strong><?php if(isset($this->request->data['EmployerContact'])){ echo $this->request->data['EmployerContact']['contact_name']; }?></strong></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Name:</td>
          <td width="74%"><?php echo $this->Form->input('EmployerContact.contact_name',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?>
         
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Title:</td>
          <td width="74%"><?php echo $this->Form->input('EmployerContact.contact_title',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Phone:</td>
          <td width="74%"><?php echo $this->Form->input('EmployerContact.contact_phone',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Fax:</td>
          <td width="74%"><?php echo $this->Form->input('EmployerContact.contact_fax',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Email for TECHEXPO<br>
            messages &amp; announcements</td>
          <td width="74%"><?php echo $this->Form->input('EmployerContact.contact_email',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?>
           <?php echo $this->Form->input('EmployerContact.contact_email_old',array('type'=>'hidden','value'=>$empcontact_email));?>
          </td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">E-mail for candidates<br>
            (where resumes are to be sent):</td>
          <td width="74%"><?php echo $this->Form->input('EmployerContact.contact_email_job',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Address:</td>
          <td width="74%"><?php echo $this->Form->input('EmployerContact.contact_address',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">City:</td>
          <td width="74%"><?php echo $this->Form->input('EmployerContact.contact_city',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">State:</td>
          <td><?php echo $this->Form->input('EmployerContact.contact_state',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Zip:</td>
          <td width="74%"><?php echo $this->Form->input('EmployerContact.contact_zip',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Personal LinkedIn Profile URL:</td>
          <td width="74%"><?php echo $this->Form->input('Employer.myprofile',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        
        <tr>
          <td width="25%" valign="middle" align="right">Username:</td>
          <td width="74%"><?php 
		  if(empty($this->request->data['User']['username']))
		   $this->request->data['User']['username'] = $this->request->data['EmployerContact']['contact_email'];	
		   echo $this->Form->input('User.username',array('label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Password:</td>
          <td width="74%"><?php 
		    if(empty($this->request->data['User']['password']))
		  $this->request->data['User']['password']= 'TECHEXPO';
		  else
		  $this->request->data['User']['password']= '';
		  
		  echo $this->Form->input('User.password',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right">Confirm Password:</td>
          <td width="74%"><?php echo $this->Form->input('User.confirmpassword',array('type'=>'text','label'=>false,'div'=>false,'error'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td width="25%" valign="middle" align="right"></td>
          <td width="74%" valign="middle" align="left"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->input('EmployerContact.employer_id',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$employerID));?>
	<?php if(isset($this->request->data['EmployerContact']['id'])){?>
	<?php echo $this->Form->input('EmployerContact.id',array('type'=>'hidden','value'=>$this->request->data['EmployerContact']['id']));?>
	<?php }?>
	
	<?php if(isset($this->request->data['EmployerContact']['id'])){?>
	<?php echo $this->Form->input('User.id',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$this->request->data['User']['id']));?>
	<?php echo $this->Form->input('User.currentusername',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$this->request->data['User']['username']));?>
	<?php echo $this->Form->input('User.currentpassword',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$this->request->data['User']['password']));?>
	<?php }?>
   <?php echo $this->Form->end();?>
  </div>
</div>
