<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">View Exhibitors List</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<div class="display_row">
<?php if(isset($cmpDelete) && $cmpDelete=='yes'){?>
<div class="table">
	<table><tr><td>Company Deleted from show. <?php echo $this->Html->link("Return to view company screen", array('controller'=>'clients','action'=>'viewexhibitorlist')); ?></td></tr></table>
</div>
<?php }else{?>
  <div class="table">
    <h2>View 
      a show's exhibitor list<br>
      &amp; REMOVE a company from an event:)</h2>
	<?php echo $this->Form->create("Show");?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
          <td valign="middle">Select the show for which you want to see a list of exhibitors or for which you want to assign a resume set:<br>
            <br>
            <select id="ShowShowId" name="data[Show][show_id]">
			<?php foreach($eventList as $key => $event){?>
			<option value="<?php echo $event['Show']['id'];?>" <?php if(isset($showID) && ($event['Show']['id']==$showID)){?> selected="selected" <?php } ?>><?php echo $event['Location']['location_state']." - ".$event['Location']['location_city']." - ".date("F d, Y",strtotime($event['Show']['show_dt']));?></option>
			<?php } ?>
			</select>
          </td>
        </tr>
        <tr>
          <td valign="middle"> Click this buttom to view or refresh the exhibitor list<br>
            <br>
            <?php echo $this->Form->submit('View / Refresh  Exhibitors',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
          </td>
        </tr>
        <tr>
          <td valign="middle"> Select the resume set and click this buttom to assign the resume set to the exhibitor list<br>
            <br>
            <?php echo $this->Form->input('Show.set_id',array('type'=>'select','options'=>$resumeSetList,'label'=>false,'div'=>false));?>
            <br />
            <br>
            <?php echo $this->Form->submit('Assign Resume Database',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
            <br />
            <br>
            <span style="font-size:20px; font-weight:bold; color:#CC0000;">Click on a company name to REMOVE it from the show .</span>
            <br>
			</td>
		  </tr>
		<?php echo $this->Form->end();?>
		<tr>
			<td>
			<?php //pr($employerList);?>
            <div id="isChromeWebToolbarDiv" <?php if(isset($resumeSetID)){?> style="display:block;"<?php }else{?> style="display:none;" <?php } ?>>
			<br/>
			<?php if(isset($resumeSetID) && $resumeSetID!=''){?>
				<strong>Total number of companies: <?php echo count($employerList);?></strong><br/>
				<?php foreach($employerList as $key => $employer){?>
					<div style="margin:20px">
					<span style="font-size:20px; font-weight:bold;">
					<a href="<?php echo $this->webroot;?>superadmin/clients/viewexhibitorlist/<?php echo $employer['ShowEmployer']['show_id'] ?>/<?php echo $employer['ShowEmployer']['employer_id'];?>" onclick="return confirm('Are you sure you want to delete?')">
					<?php if($employer['ShowEmployer']['virtual']=="y"){?>
					<font color="red"><?php echo $employer['Employer']['employer_name'];?> *** VIRTUAL ***</font>
					<?php }else{?>
					<?php echo $employer['Employer']['employer_name'];?>
					<?php } ?>
					</a></span><br><br>
					
					<font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					<?php echo $this->Html->link("Assign resume to databases", array('controller'=>'clients','action'=>'assignresumedb',$employer['Employer']['id'],'y'),array('target' => '_blank')); ?>
					</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1">
					<?php echo $this->Html->link("Re-email confirmation.", array('controller'=>'clients','action'=>'sendemailconfirm',$employer['ShowEmployer']['show_id'],$employer['Employer']['id']),array('target' => '_blank')); ?>					
					</font><br><br>
					
					<!-- Create Form for update status -->
					<?php echo $this->Form->create("Show",array('id'=>'showemployer'.$employer['Employer']['id']));?>
					<font size="1" color="000000">
					City: <?php echo $employer['Employer']['city'] ?> &nbsp; &nbsp; Contact: <?php echo $common->getEmployerContactName($employer['Employer']['id']);?><br><br>
					Payment status: 
					<?php if($employer['ShowEmployer']['payment_status']=="y"){?>
					<select id="ShowPaymentStatus" name="data[Show][payment_status]">
					<option value="y" selected="selected">Paid</option>
					<option value="n">Unpaid</option>
					</select>
					<?php }elseif($employer['ShowEmployer']['payment_status']=="n"){?>
					<select id="ShowPaymentStatus" name="data[Show][payment_status]">
					<option value="y">Paid</option>
					<option value="n" selected="selected">Unpaid</option>
					</select>
					<?php }else{?>
					<select id="ShowPaymentStatus" name="data[Show][payment_status]">
					<option value="y">Paid</option>
					<option value="n" selected="selected">Unpaid</option>
					</select><br>
					<?php } ?>
					<?php echo $this->Form->input("Show.employerID",array('type'=>'hidden','value'=>$employer['Employer']['id']));?>
					<?php echo $this->Form->input("Show.show_id",array('type'=>'hidden','value'=>$employer['ShowEmployer']['show_id']));?>
					<?php echo $this->Form->submit('Update',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
					</font>
					<br>
					<?php $varifycount = $common->getResumeSetCount($resumeSetID,$employer['Employer']['id']);?>
					<?php if($varifycount>0){?>
						<font face="Verdana, Arial, Helvetica, sans-serif" size="-2" color="CC3300"><i>
						resume set assigned</i></font>
					<?php } ?>
					<?php echo $this->Form->end();?>
					</div>
				 <?php } // end foreach ?>
				 <!-- ok --> 
			<?php }else{?>
			The list of companies could not be displayed because the resume set corresponding to this show has not yet been created. Please create the resume set first.
			<?php } ?>	
			</div>
			</td>
        </tr>
      </tbody>
    </table>
  </div>
<?php } ?>

</div>
