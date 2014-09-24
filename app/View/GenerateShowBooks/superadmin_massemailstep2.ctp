<div class="title-pad">
  <div class="title">
  </div>
</div>
<div class="display_row">
	<div class="table">
	<?php echo $this->Form->create("generate_show_books",array('action'=>'massemailstep3'));?>
    <table cellspacing="0" cellpadding="0" border="0" align="center">
      <tr>
        <td valign="middle" align="left">
		<b><br/>
		<?php if(($showID!='00') && ($showID!= '01') && ($showID!= '02') && ($showID!= '03')){?>
			<?php if($option=='p'){?>
			You are about to send a mass e-mail reminder for their company profiles to the following show clients: <b><?php echo $event['Location']['location_state'];?> - <?php echo $event['Location']['location_city'];?> -  <?php echo date("m/d/Y",strtotime($event['Show']['show_dt']));?>
			<?php }else{?>
			You are about to send a mass e-mail for resume upload notification to the following show clients: <b><?php echo $event['Location']['location_state'];?> - <?php echo $event['Location']['location_city'];?> -  <?php echo date("m/d/Y",strtotime($event['Show']['show_dt']));?>
			<?php } ?>
		<?php }elseif($showID=='00'){?>
			You are about to send a mass e-mail to all employers
		<?php }elseif($showID=='01'){?>
			You are about to send a mass e-mail to all employers with resume access
		<?php }elseif($showID=='02'){?>
			You are about to send a mass e-mail to all employers WITH job postings
		<?php }elseif($showID=='03'){?>
			You are about to send a mass e-mail to all employers WITHOUT job postings
		<?php } ?>
		</b><br/>
          <br />
          <br />Subject:
		  <?php if(($showID!='00') && ($showID!= '01') && ($showID!= '02') && ($showID!= '03')){?>
			<?php if($option=='p'){?>
				<?php echo $this->Form->input('Show.subject',array('label'=>false,'div'=>false,'value'=>'Important TECHEXPO reminder. Urgent !!'));?>
			<?php }else{?>
				<?php echo $this->Form->input('Show.subject',array('label'=>false,'div'=>false,'value'=>'The TECHEXPO resumes have been uploaded !'));?>
			<?php } ?>
		<?php }else{ ?>
			<?php echo $this->Form->input('Show.subject',array('label'=>false,'div'=>false,'value'=>'Type your subject line here...'));?>
		<?php } ?>
			<br /><br/>
		  </td>
		  </tr>
		  <tr>
        	<td valign="middle" align="left"><br/>
			<b>This is the message you are about to send. <br>You can make changes within the text box area below before sending it out.</b><br/><br/><br/>
		<?php if(($showID!='00') && ($showID!= '01') && ($showID!= '02') && ($showID!= '03')){?>
		<?php if($option=='p'){?>
			<textarea name="data[Show][message]" cols="80" rows=20><?php echo nl2br("Dear TECHEXPO client,
	
Thank you for participating in our upcoming ".$event['Location']['location_city']." - ".$event['Location']['location_state']." event on ".date("l F d, Y").". 
	
This is just a quick reminder that we still need you to complete your company's SHOW PROFILE so we can prepare your company adequately for the show and insure that you will get everything you need for the event (phone, electricity, your company description for the show guide...etc). You may have filled in some of it already but forgot certain fields. Make sure all the fields are filled out.
 
You can do so by logging in to your account at http://www.TechExpoUSA.com and proceed to the login link. When you get to your employer homepage, click on the 'TECHEXPO event preparation center' graphic (4th link down).

IF YOU DO NOT FILL OUT THIS SHOW PROFILE YOUR COMPANY WILL NOT BE INCLUDED IN THE SHOW DIRECTORY DISTRIBUTED TO ALL CANDIDATES AT THE EVENT.

Please remember the deadline to fill out this information is 7 days prior to the show date.

If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. 

Sincerely, 

Nancy Mathew
Vice President Events & Marketing
212.655.4505 ext. 225");?></textarea>
<input type="hidden" name="data[Show][reminder]" value="1">
		<?php }else{?>
			<textarea name="data[Show][message]" cols="80" rows=20><?php echo nl2br("Dear TECHEXPO client,
	
Thank you for participating in our recent ".$event['Location']['location_city']." - ".$event['Location']['location_state']." event on ".date("l F d, Y").". We are pleased to announce that the resumes collected at the show are now available online for searching, along with the additional resumes from professionals who could not attend and submitted their resumes online.
	
To access these resumes, begin searching and posting up to 25 jobs, simply go to http://www.TechExpoUSA.com and log in.
	
If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. 

Sincerely, 

Nancy Mathew
Vice President Events & Marketing
212.655.4505 ext. 225");?></textarea>
			<?php } ?>
		<?php }else{ ?>
			<textarea name="data[Show][message]" cols="80" rows=20>Paste your message here...</textarea>
		<?php } ?>
			</td>
      		</tr>
		<tr>
		<td>
			<input type="hidden" name="data[Show][show_id]" value="<?php echo $showID; ?>">
			<input type ="hidden" name="data[Show][show_id_2]" value="<?php echo $showID; ?>">
			<input type ="hidden" name="data[Show][send_option2]" value="<?php echo $option; ?>">
		  <?php echo $this->Form->submit('Confirm !',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
	  <tr>
		<td><br/><br/>
		<font face="Verdana,Arial,Helvetica,sans-serif" size="2" color="660066"><b>The following paragraph will automatically be appended to the verbiage in the text area box above:</b></font><br><br>
		
		<font face="Verdana,Arial,Helvetica,sans-serif" size="2" color="Black">
		As a reminder, here is your login information:<br><br>
		
		username: ........<br>
		password: ........<br><br>
		
		Sincerely,<br><br>
		
		Nancy Mathew<br>
		Events Coordinator<br>
		212.655.4505 ext. 225<br></font>	<br/><br/>
		</td>
      </tr>
    </table>
	<?php echo $this->Form->end();?>
	</div>
</div>

