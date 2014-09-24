<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Delete Company Account</div>
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
    <table cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td align="left" valign="middle" colspan="2">
		  <p>
		  <?php if(isset($jobcount) && $jobcount>0){?>
		  <br><b><u>WARNING:</u> This account has job postings associated with it.</b><br>
		  <?php } ?>
		  <?php if(isset($resumedbcount) && $resumedbcount>0){?>
		  <br><b><u>WARNING:</u> This account has resume database access associated with it.</b> <?php echo $this->Html->link("see resume access rights", array('controller'=>'clients','action'=>'assignresumedb',$employerID,'n'),array('target' => '_blank')); ?><br>
		  <?php } ?>
		  <?php if(!isset($confirm)){?>
		  <br>You are about to delete this account. Are you sure you want to do this ?<br><br>
		<?php echo $this->Html->link("Yes", array('controller'=>'clients','action'=>'deleteaccount',$employerID,$employerContactID,'yes')); ?>
		&nbsp;&nbsp;&nbsp;
		<?php echo $this->Html->link("No", array('controller'=>'clients','action'=>'deleteaccount',$employerID,$employerContactID,'no')); ?>
		<?php }elseif($confirm=='yes'){?>
			<br>Company deleted. You may close this window. 
		<?php }elseif($confirm=='no'){?>
			<br>Operation aborted. Close this window.
		<?php } ?>
		  </p></td>
        </tr>
      </tbody>
    </table>
    </div>
</div>
