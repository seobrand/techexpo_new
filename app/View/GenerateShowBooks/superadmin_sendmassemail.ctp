<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Notification to clients:<br/><br/>
</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
  </div>
</div>
<div class="display_row">
	<div class="table">
	<?php echo $this->Form->create("generate_show_books",array('action'=>'massemailstep2'));?>
    <table cellspacing="0" cellpadding="0" border="0" align="center">
      <tr>
        <td valign="middle" align="left"><b><br/>Select an option from the first pull-down menu: either ALL EMPLOYERS,<br/>ALL EMPLOYERS WITH RESUME ACCESS, ALL EMPLOYERS WITH JOB<br/>POSTINGS, ALL EMPLOYERS *WITHOUT* JOB POSTINGS<br/>***OR*** A SHOW (this will select all clients assigned to that show).</b><br />
          <br />
          <br />
          <select id="ShowEventId" name="data[Show][show_id]">
		  		<option value="00">ALL EMPLOYERS</option>
				<option value="01">ALL EMPLOYERS WITH RESUME ACCESS</option>
				<option value="02">ALL EMPLOYERS WITH JOB POSTINGS</option>
				<option value="03">ALL EMPLOYERS *WITHOUT* JOB POSTINGS</option>
				<?php foreach($eventList as $key => $event){?>
				<option value="<?php echo $event['Show']['id'];?>" <?php if($event['Show']['id']==$showID){?> selected="selected"<?php } ?>><?php echo $event['Location']['location_state']." - ".$event['Location']['location_city'];?> - <?php echo date('m/d/Y', strtotime($event['Show']['show_dt']));?></option>
				<?php } ?>
			</select>
          <br />
          <br />
		  </td>
		  </tr>
		  <tr>
        	<td valign="middle" align="left"><b>***IF*** you are sending a show-based e-mail, please select the following option:</b><br />
			  <br />
			  <br />
			  <select id="ShowSendOptionID" name="data[Show][send_option]">
					<option value="a">ALL EXHIBITORS</option>
					<option value="j">EXHIBITORS WITHOUT JOB POSTINGS</option>
					<option value="p" SELECTED>EXHIBITORS WITH MISSING COMPANY PROFILE</option>
				</select>
			  <br />
			  <br />
			  </td>
      		</tr>
		<tr>
		<td>
		  <?php echo $this->Form->submit('Send !',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
    </table>
	<?php echo $this->Form->end();?>
	</div>
</div>

