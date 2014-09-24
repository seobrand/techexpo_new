<?php	  $total_lunch = 0;
			$free_cnt=0;
			$phone_cnt=0;
			$elec_cnt=0;
			$easel_cnt=0;
			$cd_cnt = 0;
			$wall_cnt = 0;
			
		    foreach($get_profiles as $profile){
				if(strlen($profile['ShowCompanyProfile']['num_lunch_tickets']) >= 1){
					$total_lunch = $total_lunch + $profile['ShowCompanyProfile']['num_lunch_tickets'];
				}
				if($profile['ShowCompanyProfile']['free']=='y'){
					$free_cnt = $free_cnt + 1;
				}
				if($profile['ShowCompanyProfile']['phone']=='y'){
					$phone_cnt = $phone_cnt + 1;
				}
				if($profile['ShowCompanyProfile']['electricity']=='y'){
					$elec_cnt = $elec_cnt + 1;
				}
				if($profile['ShowCompanyProfile']['easel']=='y'){
					$easel_cnt = $easel_cnt + 1;
				}
				if($profile['ShowCompanyProfile']['wall']=='y'){
					$wall_cnt = $wall_cnt + 1;
				}
			}
			
			$pay_cnt = count($get_profiles) - $free_cnt;
			
?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Generate Profile Report</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <h2>Company profiles for: <?php echo $show_name; ?> on <?php echo date("m/d/Y",strtotime($show_dt));?></h2>
    <p>Total no. of companies: <?php echo count($get_profiles); ?></p>
    <p>Total no. of paying companies: <?php echo $pay_cnt; ?></p>
    <p>Total no. of freebies: <?php echo $free_cnt; ?></p>
    <br />
    <p>Total no. of electricity lines required: <?php echo $elec_cnt; ?></p>
    <p>Total no. of phone lines required: <?php echo $phone_cnt; ?></p>
    <p>Total no. of easels required: <?php echo $easel_cnt; ?></p>
    <p>Total no. of walls required: <?php echo $wall_cnt; ?></p>
    <p>Total no. of lunches required: <?php echo $total_lunch; ?></p>
    <p><?php echo $this->Html->link("Send a mass e-mail reminder to clients.", array('controller'=>'generate_show_books','action'=>'sendmassemail',$show_id,'p')); ?></p>
    <br />
    <table cellspacing="0" cellpadding="0" border="0" class="nobackground">
      <tbody>
        <tr>
          <td width="10" class="green">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td>We have all the information. Company is all set. </td>
        </tr>
        <tr>
          <td   class="blue">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td>We have most of the information but no booth number was assigned. Please indicate a booth number. </td>
        </tr>
        <tr>
          <td  class="maroon">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td>We are missing critical info for the company. Must get missing info. </td>
        </tr>
        <tr>
          <td  class="purple">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
          <td>This company is a virtual exhibitor. They are not concerned by this profile. </td>
        </tr>
      </tbody>
    </table>
    <br />
    <br />
	<?php echo $this->Form->create('',array('controller'=>'generate_show_books','action'=>'updateshowprofile'));?>
    <table cellspacing="2" cellpadding="2" border="0">
      <tbody>
	  	<?php $miss=0; ?>
		<?php foreach($get_profiles as $showprofile){ $virtual=0;?>
		<?php $empid = $showprofile['ShowCompanyProfile']['employer_id'];?>
		<?php if($showprofile['ShowEmployer']['virtual'] == "y") $virtual=1; ?>
		<?php if($virtual==1){
						$class = 'purple';
				   }else{
						if((strlen($showprofile['Employer']['employer_name'])==0)|| (strlen($showprofile['ShowCompanyProfile']['num_badges'])== 0) || (strlen($showprofile['ShowCompanyProfile']['num_lunch_tickets'])== 0) || (strlen($showprofile['ShowCompanyProfile']['electricity'])== 0) || (strlen($showprofile['ShowCompanyProfile']['phone'])== 0) || (strlen($showprofile['ShowCompanyProfile']['booth'])== 0) || (strlen($showprofile['Employer']['description']) < 10)){
							$class = 'maroon';
							$miss=$miss+1;
							
						}elseif(($showprofile['ShowCompanyProfile']['booth_num']==0) || (strlen($showprofile['ShowCompanyProfile']['booth_num'])==0)){
							$class = 'blue';
							
						}else{
							$class = 'green';
							
						}
				   }
		?>
        <tr>
          <td align="left" class="<?php echo $class;?>" ><b>Company</b> </td>
          <td align="left" class="<?php echo $class;?>"><b><i>Exact</i> Company Name</b> </td>
          <td align="center" class="<?php echo $class;?>"><b>No. of badges</b> </td>
          <td align="center" class="<?php echo $class;?>"><b>No. of lunches</b> </td>
          <td align="center" class="<?php echo $class;?>"><b>Electric</b> </td>
          <td align="center" class="<?php echo $class;?>"><b>Phone</b> </td>
          <td align="center" class="<?php echo $class;?>"><b>Booth</b> </td>
          <td align="center" class="<?php echo $class;?>"><b>Booth Size</b> </td>
          <td align="center" class="<?php echo $class;?>"><b> 2nd Booth</b> </td>
        </tr>

        <tr>
          <td align="left"><font size="1" face="Verdana,Geneva,Arial,Helvetica,sans-serif" color="Black"> <b><?php echo $showprofile['Employer']['employer_name'];?></b> </font></td>
          <td align="left"><font size="1" face="Verdana,Geneva,Arial,Helvetica,sans-serif" color="Black">
		  <?php echo $this->Form->input('company_name'.$empid, array('class'=>'inputbox2','maxlength'=>'200','style'=>'font-size: 10px;','label'=>false,'div'=>false,'value'=>$showprofile['ShowCompanyProfile']['company_name']));?>
            </font></td>
          <td align="center"><font size="1" face="Verdana,Geneva,Arial,Helvetica,sans-serif" color="Black">
            <?php echo $this->Form->input('num_badges'.$empid, array('class'=>'inputbox2','maxlength'=>'2','style'=>'font-size: 10px;','label'=>false,'div'=>false,'value'=>$showprofile['ShowCompanyProfile']['num_badges']));?>
            </font></td>
          <td align="center"><font size="1" face="Verdana,Geneva,Arial,Helvetica,sans-serif" color="Black">
            <?php echo $this->Form->input('num_lunch_tickets'.$empid, array('class'=>'inputbox2','maxlength'=>'2','style'=>'font-size: 10px;','label'=>false,'div'=>false,'value'=>$showprofile['ShowCompanyProfile']['num_lunch_tickets']));?>
            </font></td>
          <td align="center"><select style="font-size: 10px;" name="data[ShowCompanyProfile][electricity<?php echo $empid; ?>]" id="electricity<?php echo $empid; ?>">
              <option value="" <?php if($showprofile['ShowCompanyProfile']['electricity']==''){?>selected="selected"<?php } ?>>*** </option>
              <option value="y" <?php if($showprofile['ShowCompanyProfile']['electricity']=='y'){?>selected="selected"<?php } ?>>Yes </option>
              <option value="n" <?php if($showprofile['ShowCompanyProfile']['electricity']=='n'){?>selected="selected"<?php } ?>>No </option>
            </select></td>
          <td align="center"><select style="font-size: 10px;" name="data[ShowCompanyProfile][phone<?php echo $empid; ?>]" id="phone<?php echo $empid; ?>">
              <option value="" <?php if($showprofile['ShowCompanyProfile']['phone']==''){?>selected="selected"<?php } ?>>*** </option>
              <option value="y" <?php if($showprofile['ShowCompanyProfile']['phone']=='y'){?>selected="selected"<?php } ?>>Yes </option>
              <option value="n" <?php if($showprofile['ShowCompanyProfile']['phone']=='n'){?>selected="selected"<?php } ?>>No </option>
            </select></td>
          <td align="center"><select style="font-size: 10px;" name="data[ShowCompanyProfile][booth<?php echo $empid; ?>]" id="booth<?php echo $empid; ?>">
              <option value="" <?php if($showprofile['ShowCompanyProfile']['booth']==''){?>selected="selected"<?php } ?>>*** </option>
              <option value="y" <?php if($showprofile['ShowCompanyProfile']['booth']=='y'){?>selected="selected"<?php } ?>>Yes </option>
              <option value="n" <?php if($showprofile['ShowCompanyProfile']['booth']=='n'){?>selected="selected"<?php } ?>>No </option>
            </select></td>
          <td align="center"><font size="1" face="Verdana,Geneva,Arial,Helvetica,sans-serif" color="Black">
            <?php echo $this->Form->input('booth_size'.$empid, array('class'=>'inputbox2','maxlength'=>'100','style'=>'font-size: 10px;','label'=>false,'div'=>false,'value'=>$showprofile['ShowCompanyProfile']['booth_size']));?>
            </font></td>
          <td align="center"><select style="font-size: 10px;" name="data[ShowCompanyProfile][second_booth<?php echo $empid; ?>]" id="second_booth<?php echo $empid; ?>">
              <option value="y" <?php if($showprofile['ShowCompanyProfile']['second_booth']=='y'){?>selected="selected"<?php } ?>>Yes </option>
              <option value="n" <?php if($showprofile['ShowCompanyProfile']['second_booth']=='n'){?>selected="selected"<?php } ?>>No </option>
            </select></td>
        </tr>
        <tr>
          <td align="left" colspan="9"><font size="1" face="Verdana,Geneva,Arial,Helvetica,sans-serif" color="Red"> <b>Admin Only:</b></font> <font size="1" face="Verdana,Geneva,Arial,Helvetica,sans-serif"> <b>Have Profile ? <?php if(strlen($showprofile['Employer']['description']) > 10){?><font color="Green">Yes</font><?php }else{ ?><font color="red">No</font> <?php } ?></b>&nbsp;&nbsp;&nbsp;
            Need Easel?
            <select style="font-size: 10px;" name="data[ShowCompanyProfile][easel<?php echo $empid; ?>]" id="easel<?php echo $empid; ?>">
              <option value="n" <?php if($showprofile['ShowCompanyProfile']['easel']=='n'){?>selected="selected"<?php } ?>>No </option>
              <option value="y" <?php if($showprofile['ShowCompanyProfile']['easel']=='y'){?>selected="selected"<?php } ?>>Yes </option>
            </select>
            &nbsp;&nbsp;&nbsp;
            
            Need Wall ?
            <select style="font-size: 10px;" name="data[ShowCompanyProfile][wall<?php echo $empid; ?>]" id="wall<?php echo $empid; ?>">
              <option value="n" <?php if($showprofile['ShowCompanyProfile']['wall']=='n'){?>selected="selected"<?php } ?>>No </option>
              <option value="y" <?php if($showprofile['ShowCompanyProfile']['wall']=='y'){?>selected="selected"<?php } ?>>Yes </option>
            </select>
            &nbsp;&nbsp;&nbsp;
            
            Freebie ?
            <select style="font-size: 10px;" name="data[ShowCompanyProfile][free<?php echo $empid; ?>]" id="free<?php echo $empid; ?>">
              <option value="n" <?php if($showprofile['ShowCompanyProfile']['free']=='n'){?>selected="selected"<?php } ?>>No </option>
              <option value="y" <?php if($showprofile['ShowCompanyProfile']['free']=='y'){?>selected="selected"<?php } ?>>Yes </option>
            </select>
            &nbsp;&nbsp;&nbsp;<b>Booth Number:</b>
             <?php echo $this->Form->input('booth_num'.$empid, array('class'=>'inputbox2','maxlength'=>'4','style'=>'font-size: 10px;','label'=>false,'div'=>false,'value'=>$showprofile['ShowCompanyProfile']['booth_num']));?>
            </font></td>
        </tr>
        <tr>
          <td align="left" colspan="9"><font size="1" face="Verdana,Geneva,Arial,Helvetica,sans-serif"><b>
		  <input type="hidden" name="data[employerID][]" value="<?php echo $empid;?>" />
            <?php echo $this->Form->input('employerID[]', array('type'=>'hidden','value'=>$empid));?>
			<?php echo $this->Html->link("View / Edit Recruiter Info", array('controller'=>'clients','action'=>'editcompanycontact',$empid,$showprofile['Employer']['primary_contact_id']),array('target' => '_blank')); ?>&nbsp;&nbsp; <?php echo $this->Html->link("View / Edit Company Info", array('controller'=>'clients','action'=>'editcompanyprofile',$empid),array('target' => '_blank')); ?> &nbsp;&nbsp; <?php echo $this->Html->link("View / Edit Show Profile", array('controller'=>'generate_show_books','action'=>'viewshowprofile',$empid,$show_id)); ?>&nbsp;&nbsp; <?php echo $this->Html->link("Send Email Reminder", array('controller'=>'generate_show_books','action'=>'sendemailreminder',$empid,$show_id)); ?>&nbsp;&nbsp; <?php echo $this->Html->link("Assign Resume DB's", array('controller'=>'clients','action'=>'assignresumedb',$empid,'y'),array('target' => '_blank')); ?></b></font></td>
        </tr>        
        <tr bgcolor="ffffff">
          <td height="2" class="whitespace" align="left" colspan="9"></td>
        </tr>
		<?php } ?>
        <tr>
          <td colspan="9"><input type="hidden" name="data[show_id]" value="<?php echo $showprofile['ShowCompanyProfile']['show_id'];?>" />
            <?php echo $this->Form->submit('Update!',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
	<?php $this->Form->end();?><br/><br/>
	<font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="2"><b>Number of missing profiles: <?php echo $miss;?></b></font><br/><br/>
  </div>
</div>
