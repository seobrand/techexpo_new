<?php //pr($eventList);?>
<div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Assign <?php echo $common->getEmployerName($employerID) ?> to events</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<div class="display_row">
 <?php if(!isset($content)){?> 
  <div class="table">
  <?php echo $this->Form->create("Show");?>
    <table cellspacing="0" cellpadding="0" border="0"> 
      <tbody>
	  <?php if(isset($eventList) && count($eventList)>0){?>
		  <?php foreach($eventList as $key => $event){?>
			<tr>
			  <td valign="middle" align="left"><input type="checkbox" id="ShowIsAssign" value="<?php echo $event['Show']['id'];?>" name="data[Show][isAssign][]">
				<b><?php echo date('F d, Y', strtotime($event['Show']['show_dt']));?> - <?php echo $event['Location']['location_city'].", ".$event['Location']['location_state'];?></b></td>
			  <td valign="middle" align="left"><i>Select type of exhibitor : </i>
				<select id="ShowExhibitorType" name="data[Show][exhibitorType][<?php echo $event['Show']['id'];?>]">
				<!--	<option value="R">UNPAID Regular exhibitor</option>-->
					<option value="PR">PAID regular exhibitor</option>
				<!--	<option value="V">UNPAID Virtual exhibitor</option>-->
					<option value="PV">PAID virtual exhibitor</option>
				</select>
			  </td>
			  <td valign="middle" align="left"><i>Send e-mail :</i>
				<select id="ShowEmailSend" name="data[Show][emailSend][<?php echo $event['Show']['id'];?>]">
					<option value="Y">Yes</option>
					<option value="N">No</option>
				</select>
				<input type="hidden" id="ShowConfirmFile" value="<?php echo $event['Show']['show_confirm_file'];?>" name="data[Show][show_confirm_file][<?php echo $event['Show']['id'];?>]">
	<input type="hidden" id="ShowShowdt" value="<?php echo $event['Show']['show_dt'];?>" name="data[Show][show_dt][<?php echo $event['Show']['id'];?>]">
	<input type="hidden" id="ShowLocationCity" value="<?php echo $event['Location']['location_city'];?>" name="data[Show][location_city][<?php echo $event['Show']['id'];?>]">
	<input type="hidden" id="ShowLocationState" value="<?php echo $event['Location']['location_state'];?>" name="data[Show][location_state][<?php echo $event['Show']['id'];?>]">
    <input type="hidden" id="ShowBoutique" value="<?php echo $event['Show']['boutique'];?>" name="data[Show][boutique][<?php echo $event['Show']['id'];?>]">
			  </td>
			</tr>
		  <?php }?>
        <tr>
          <td colspan="3"> <?php echo $this->Form->submit('Assign',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
	  <?php }else{?>
	  <tr>
          <td valign="middle" align="left" colspan="3">Sorry, There is no current year events exist in our database..</td>
        </tr>
	  <?php }?>	
      </tbody>
    </table>
	<?php echo $this->Form->input('employer_name',array('type'=>'hidden','value'=>$common->getEmployerName($employerID)));?>
  <?php echo $this->Form->end();?>	
  </div>
  <?php }else{?>
  	<div class="table">
    <table cellspacing="0" cellpadding="0" border="0">
      <tbody>
	  <tr>
          <td valign="middle" align="left" colspan="3">
		  <?php if($content!=''){ echo $content; }else{?>
		  Sorry there was some problem to assign events to <strong><?php echo $common->getEmployerName($employerID) ?></strong>
		  <?php }?>
		  </td>
        </tr>
      </tbody>
    </table>
  </div>
  <?php }?>
</div>
