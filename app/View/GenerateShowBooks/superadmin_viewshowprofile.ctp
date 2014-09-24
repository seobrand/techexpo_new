<?php //pr($this->request->data);?>
<div class="title-pad">
  <div class="title">
   <script type="text/javascript">
	function isNumericKey(e)
	{
		if (window.event) { var charCode = window.event.keyCode; }
		else if (e) { var charCode = e.which; }
		else { return true; }
		if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; }
		return true;
	}
	</script> <h5 style="width:97%;">
      <div style="float:left;">Exhibitor's Profile</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<!-- box / title -->
<div class="display_row">
  <div class="table">
  <?php echo $this->Form->create('',array('name'=>'showprofile','id'=>'showprofile'));?>
    <table cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td width="35%" valign="middle"  align="right"> Please enter your company name exactly as it should appear on your table sign </td>
          <td valign="middle" width="64%" align="left"><?php echo $this->Form->input('ShowCompanyProfile.company_name',array('label'=>false,'div'=>false,'class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td valign="middle"  align="right"> How many company badges will you need ? </td>
          <td valign="middle" width="64%" align="left"><?php echo $this->Form->input('ShowCompanyProfile.num_badges',array('label'=>false,'div'=>false,'class'=>'smallTextField','maxlength'=>'2','type'=>'text','onkeypress'=>'return isNumericKey(event);'));?></td>
        </tr>
        <tr>
          <td valign="middle"  align="right"> How many representatives will be attending lunch ? </td>
          <td valign="middle" width="64%" align="left"> <?php echo $this->Form->input('ShowCompanyProfile.num_lunch_tickets',array('label'=>false,'div'=>false,'class'=>'smallTextField','maxlength'=>'2','type'=>'text','onkeypress'=>'return isNumericKey(event);'));?></td>
        </tr>
        <tr>
          <td valign="middle"  align="right"> Please indicate if you require electricity </td>
          <td valign="middle" width="64%" align="left"><?php echo $this->Form->input('ShowCompanyProfile.electricity',array('type'=>'select','options'=>array('y'=>'Yes','n'=>'No'),'label'=>false,'div'=>false));?></td>
        </tr>
        <tr>
          <td valign="middle"  align="right"> Please indicate if you require a phone / modem connection </td>
          <td valign="middle" width="64%" align="left"> <?php echo $this->Form->input('ShowCompanyProfile.phone',array('type'=>'select','options'=>array('y'=>'Yes','n'=>'No'),'label'=>false,'div'=>false));?></td>
        </tr>
        <tr>
          <td valign="middle"  align="right"> Are you bringing a display booth ? </td>
          <td valign="middle" width="64%" align="left"><?php echo $this->Form->checkbox('ShowCompanyProfile.booth', array('value' => 'y')); ?>
            &nbsp;check if you are bringing a booth </td>
        </tr>
        <tr>
          <td valign="middle"  align="right"> If you are bringing a booth, please enter its dimensions </td>
          <td valign="middle" width="64%" align="left"><?php echo $this->Form->input('ShowCompanyProfile.booth_size',array('label'=>false,'div'=>false,'class'=>'smallTextField'));?>
          </td>
        </tr>
        <tr>
          <td valign="middle"  align="right"> Would you like a second booth at the show ? </td>
          <td valign="middle" width="64%" align="left"><?php echo $this->Form->input('ShowCompanyProfile.second_booth',array('type'=>'select','options'=>array('y'=>'Yes','n'=>'No'),'label'=>false,'div'=>false));?>
            <br>
            <br>
            <i>Please note that there is an additional charge of $995 for a second booth. The additional cost will be billed accordingly.</i><br>
          </td>
        </tr>
        <tr>
          <td valign="top"  align="right"> This is you company profile, which can be edited separately on your company profile page. </td>
          <td valign="middle" width="64%" align="left"> This is the main company profile, which will be used for all show guides. If you wish to edit it, please visit the <?php echo $this->Html->link("Company profile page", array('controller'=>'clients','action'=>'editcompanyprofile',$employerID)); ?><br>
            <br>
            <i>Remember to include contact information (fax, e-mail, web site address..etc) if you wish candidates to be able to contact you directly after the show (many candidates will take the show guide home with them and later apply for your positions if they didn't get to interview with you at the show).<br>
            <br>
            </i> <?php echo nl2br($profile);?> </td>
        </tr>
        <tr>
          <td valign="middle"  align="right"> Special Notes </td>
          <td valign="middle" width="64%" align="left"><?php echo $this->Form->input('ShowCompanyProfile.notes',array('type'=>'textarea','label'=>false,'div'=>false,'rows'=>5,'cols'=>'50'));?><!--<textarea cols="50" wrap="soft" rows="5" name="notes"></textarea>--></td>
        </tr>
        <tr>
          <td></td>
          <td valign="middle" align="left"><br>
		  	<?php echo $this->Form->input('ShowCompanyProfile.id',array('type'=>'hidden','value'=>$showProfile['ShowCompanyProfile']['id']));?>
            <?php echo $this->Form->input('ShowCompanyProfile.show_id',array('type'=>'hidden','value'=>$showID));?>
            <?php echo $this->Form->input('ShowCompanyProfile.employer_id',array('type'=>'hidden','value'=>$employerID));?>
            <?php if(count($showProfile)>0){?>
				<?php echo $this->Form->submit('Update Event Profile',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
			<?php }else{ ?>
				<?php echo $this->Form->submit('Submit Event Profile',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
			<?php } ?>
			</td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->end();?>
  </div>
</div>
