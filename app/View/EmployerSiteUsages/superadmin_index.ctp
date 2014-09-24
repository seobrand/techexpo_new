<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'siteusage')); ?>
<style type="text/css">
	input[type="text"]{	width:180px!important;}
</style>
<script>
$(function() {
       $("#startdatepicker").datepicker({ dateFormat: "yy-mm-dd" });
	   $("#enddatepicker").datepicker({ dateFormat: "yy-mm-dd" });
});
</script>
<div id="right2">
  <!-- table -->
  <div class="box1">
    <!-- box / title -->
    <?php if(isset($showstat)===false){?>
    <div class="title-pad">
      <div class="title">
        <h5 style="width:97%;">
          <div style="float:left;">Employer Site Usage Stats</div>
          <div style="float:right;font-weight:bold;"></div>
        </h5>
      </div>
    </div>
    <div class="display_row">
      <div class="table">
        <table border="0" cellpadding="0" align="left">
          <?php  echo $this->Form->create('EmployerStat'); ?>
          <tbody>
            <tr>
              <td width="25%" valign="middle" align="right">Choose a start date for your statistics:</td>
              <td valign="middle" width="74%"  align="left"><?php echo $this->Form->input('start_dt',array('label'=>false,'div'=>false,'maxlength'=>'50','class'=>'inputbox1','error'=>false,'id'=>'startdatepicker'));?><br>
              </td>
            </tr>
            <tr>
              <td valign="middle" align="right">Choose an end date for your statistics:</td>
              <td valign="middle" align="left"><?php echo $this->Form->input('end_dt',array('label'=>false,'div'=>false,'maxlength'=>'50','class'=>'inputbox1','error'=>false,'id'=>'enddatepicker'));?> </td>
            </tr>
            <tr>
              <td valign="middle" align="right"></td>
              <td valign="middle" align="left"><?php echo $this->Form->submit('Generate Stats !',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?> <?php echo $this->Form->hidden('generate_stats',array('value'=>'generate_stats'));?> </td>
            </tr>
          </tbody>
          <?php echo $this->Form->end();?>
        </table>
      </div>
    </div>
    <?php } ?>
    <?php /*** SHOW THE EMPLOYER STATISTICS HERE ***/?>
    <?php if(isset($showstat)===true){?>
    <div class="title-pad">
      <div class="title">
        <h5 style="width:97%;">
          <div style="float:left;">Analysis Report List</div>
          <div style="float:right;font-weight:bold;"></div>
        </h5>
      </div>
    </div>
	<?php // difference of total days in two dates
		$starttime = new DateTime($start_dt);
		$enditme = new DateTime($end_dt);
		$interval = $enditme->diff($starttime);
		$totaldays = $interval->format('%a');
		$max_width=400;
	?>
    <div class="display_row">
      <div class="table">
        <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody>
            <tr>
              <td align="left" valign="middle"><div><strong>Employer Statistics from <?php echo date("d/m/Y",strtotime($start_dt)) ?> to <?php echo date("d/m/Y",strtotime($end_dt)) ?></strong>.<br /><br /><br /></div>
               <div>  <strong> Logins:</strong> </div></td>
            </tr>
			<?php 
			$loginHistory = $common->showEmployerPagesVisitHistory('login',$start_dt,$end_dt);
			//pr($loginHistory);
			if(count($loginHistory) != 0){
				$max_val= $loginHistory[0][0]['cnt'];
			}else{
				$max_val= 0;
			}
			
			if(count($loginHistory) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($loginHistory as $login_emp){?>
				<?php $len=ceil($ratio*$login_emp[0]['cnt']); ?>
				<?php $avg = $login_emp[0]['cnt']/$totaldays; ?>
					<li><span class="static_text"><?php echo $login_emp[0]['cnt']; ?> <span>(avg. = <?php echo $avg;?> / day)</span></span><span class="bar"><img src="<?php echo $this->webroot;?>img/red_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><?php echo $login_emp['Employer']['employer_name']; ?> / <?php echo $login_emp['EmployerContact']['contact_name']; ?>
					</li>
				<?php } ?>	
				</ul>
			 </td>
          </tr>
		  <?php /******** Statisctics for Resume Search Page ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong> Resume Searches:</strong> <br/><br/></td>
            </tr>
			<?php 
			$resumeSearchHistory = $common->showEmployerPagesVisitHistory('resumeSearchResult',$start_dt,$end_dt);
			//pr($loginHistory);
			if(count($resumeSearchHistory) != 0){
				$max_val= $resumeSearchHistory[0][0]['cnt'];
			}else{
				$max_val= 0;
			}
			
			if(count($resumeSearchHistory) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($resumeSearchHistory as $resumeSearchHistory){?>
				<?php $len=ceil($ratio*$resumeSearchHistory[0]['cnt']); ?>
				<?php $avg = $resumeSearchHistory[0]['cnt']/$totaldays; ?>
					<li><span class="static_text"><?php echo $resumeSearchHistory[0]['cnt']; ?> <span>(avg. = <?php echo $avg;?> / day)</span></span><span class="bar"><img src="<?php echo $this->webroot;?>img/dgreen_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><?php echo $resumeSearchHistory['Employer']['employer_name']; ?> / <?php echo $resumeSearchHistory['EmployerContact']['contact_name']; ?>
					</li>
				<?php } ?>	
				</ul>
			 </td>
          </tr>
		  <?php /******** Statisctics for Pre-Registered Candidate Resume Searches ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong> Pre-Registered Candidate Resume Searches:</strong><br/><br/></td>
            </tr>
			<?php 
			$resumePreSearchHistory = $common->showEmployerPagesVisitHistory('searchRegResult',$start_dt,$end_dt);
			//pr($loginHistory);
			if(count($resumePreSearchHistory) != 0){
				$max_val= $resumePreSearchHistory[0][0]['cnt'];
			}else{
				$max_val= 0;
			}
			
			if(count($resumePreSearchHistory) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($resumePreSearchHistory as $resumePreSearchHistory){?>
				<?php $len=ceil($ratio*$resumePreSearchHistory[0]['cnt']); ?>
				<?php $avg = $resumePreSearchHistory[0]['cnt']/$totaldays; ?>
					<li><span class="static_text"><?php echo $resumePreSearchHistory[0]['cnt']; ?> <span>(avg. = <?php echo $avg;?> / day)</span></span><span class="bar"><img src="<?php echo $this->webroot;?>img/green_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><?php echo $resumePreSearchHistory['Employer']['employer_name']; ?> / <?php echo $resumePreSearchHistory['EmployerContact']['contact_name']; ?>
					</li>
				<?php } ?>	
				</ul>
			 </td>
          </tr>
		  <?php /******** Statisctics for Resume Views ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong> Resume Views:</strong><br/><br/></td>
            </tr>
			<?php 
			$showResumeHistory = $common->showEmployerPagesVisitHistory('showResume',$start_dt,$end_dt);
			//pr($loginHistory);
			if(count($showResumeHistory) != 0){
				$max_val= $showResumeHistory[0][0]['cnt'];
			}else{
				$max_val= 0;
			}
			
			if(count($showResumeHistory) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($showResumeHistory as $showResumeHistory){?>
				<?php $len=ceil($ratio*$showResumeHistory[0]['cnt']); ?>
				<?php $avg = $showResumeHistory[0]['cnt']/$totaldays; ?>
					<li><span class="static_text"><?php echo $showResumeHistory[0]['cnt']; ?> <span>(avg. = <?php echo $avg;?> / day)</span></span><span class="bar"><img src="<?php echo $this->webroot;?>img/purple_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><?php echo $showResumeHistory['Employer']['employer_name']; ?> / <?php echo $showResumeHistory['EmployerContact']['contact_name']; ?>
					</li>
				<?php } ?>	
				</ul>
			 </td>
          </tr>
		   <?php /******** Statisctics for Pre-registered Candidate Resume Views: ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong>Pre-registered Candidate Resume Views:</strong><br/><br/></td>
            </tr>
			<?php 
			$showRegisterResume = $common->showEmployerPagesVisitHistory('showRegisterResume',$start_dt,$end_dt);
			//pr($loginHistory);
			if(count($showRegisterResume) != 0){
				$max_val= $showRegisterResume[0][0]['cnt'];
			}else{
				$max_val= 0;
			}
			
			if(count($showRegisterResume) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($showRegisterResume as $showRegisterResume){?>
				<?php $len=ceil($ratio*$showRegisterResume[0]['cnt']); ?>
				<?php $avg = $showRegisterResume[0]['cnt']/$totaldays; ?>
					<li><span class="static_text"><?php echo $showRegisterResume[0]['cnt']; ?> <span>(avg. = <?php echo $avg;?> / day)</span></span><span class="bar"><img src="<?php echo $this->webroot;?>img/light_purple_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><?php echo $showRegisterResume['Employer']['employer_name']; ?> / <?php echo $showRegisterResume['EmployerContact']['contact_name']; ?>
					</li>
				<?php } ?>	
				</ul>
			 </td>
          </tr>
		   <?php /******** Statisctics for Resume Downloads ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong>Resume Downloads:</strong><br/><br/></td>
            </tr>
			<?php 
			$exportResume = $common->showEmployerPagesVisitHistory('exportResume',$start_dt,$end_dt);
			//pr($loginHistory);
			if(count($exportResume) != 0){
				$max_val= $exportResume[0][0]['cnt'];
			}else{
				$max_val= 0;
			}
			
			if(count($exportResume) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($exportResume as $exportResume){?>
				<?php $len=ceil($ratio*$exportResume[0]['cnt']); ?>
				<?php $avg = $exportResume[0]['cnt']/$totaldays; ?>
					<li><span class="static_text"><?php echo $exportResume[0]['cnt']; ?> <span>(avg. = <?php echo $avg;?> / day)</span></span><span class="bar"><img src="<?php echo $this->webroot;?>img/blue_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><?php echo $exportResume['Employer']['employer_name']; ?> / <?php echo $exportResume['EmployerContact']['contact_name']; ?>
					</li>
				<?php } ?>	
				</ul>
			 </td>
          </tr>
		   <?php /******** Statisctics for Resumes forwarded by e-mail ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong> Resumes forwarded by e-mail:</strong><br/><br/></td>
            </tr>
			<?php 
			$mailResume = $common->showEmployerPagesVisitHistory('mailResume',$start_dt,$end_dt);
			//pr($loginHistory);
			if(count($mailResume) != 0){
				$max_val= $mailResume[0][0]['cnt'];
			}else{
				$max_val= 0;
			}
			
			if(count($mailResume) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($mailResume as $mailResume){?>
				<?php $len=ceil($ratio*$mailResume[0]['cnt']); ?>
				<?php $avg = $mailResume[0]['cnt']/$totaldays; ?>
					<li><span class="static_text"><?php echo $mailResume[0]['cnt']; ?> <span>(avg. = <?php echo $avg;?> / day)</span></span><span class="bar"><img src="<?php echo $this->webroot;?>img/purplepink_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><?php echo $mailResume['Employer']['employer_name']; ?> / <?php echo $mailResume['EmployerContact']['contact_name']; ?>
					</li>
				<?php } ?>	
				</ul>
			 </td>
          </tr>
		  <?php /******** Statisctics for Resumes filed to folders for later e-mail forwarding / mass e-mail ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong> Resumes filed to folders for later e-mail forwarding / mass e-mail:</strong><br/><br/></td>
            </tr>
			<?php 
			$massEmail = $common->showEmployerPagesVisitHistory('resumefiletofolder',$start_dt,$end_dt);
			//pr($loginHistory);
			if(count($massEmail) != 0){
				$max_val= $massEmail[0][0]['cnt'];
			}else{
				$max_val= 0;
			}
			
			if(count($massEmail) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($massEmail as $massEmail){?>
				<?php $len=ceil($ratio*$massEmail[0]['cnt']); ?>
				<?php $avg = $massEmail[0]['cnt']/$totaldays; ?>
					<li><span class="static_text"><?php echo $massEmail[0]['cnt']; ?> <span>(avg. = <?php echo $avg;?> / day)</span></span><span class="bar"><img src="<?php echo $this->webroot;?>img/orange_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><?php echo $massEmail['Employer']['employer_name']; ?> / <?php echo $massEmail['EmployerContact']['contact_name']; ?>
					</li>
				<?php } ?>	
				</ul>
			 </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    <?php } ?>
  </div>
  <!-- end table -->
</div>
