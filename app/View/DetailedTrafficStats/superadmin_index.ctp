<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'trafficstat')); ?>
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
          <div style="float:left;">Detailed Traffic Stats</div>
          <div style="float:right;font-weight:bold;"></div>
        </h5>
      </div>
    </div>
    <div class="display_row">
      <div class="table">
        <table border="0" cellpadding="0" align="left">
          <?php  echo $this->Form->create('DetailedTraffic'); ?>
          <tbody>
            <tr>
              <td width="25%" valign="middle" align="right">Choose a start date for your statistics:</td>
              <td valign="middle" width="74%"  align="left"><?php echo $this->Form->input('start_dt',array('label'=>false,'div'=>false,'maxlength'=>'50','class'=>'inputbox1','error'=>false,'id'=>'startdatepicker'));?><br>
              </td>
            </tr>
            <tr>
              <td valign="middle" align="right">Choose the length of time you wish to see stats for: </td>
              <td valign="middle" align="left"><input type="text" maxlength="2" size="3" name="data[DetailedTraffic][period]">&nbsp;&nbsp;<select name="data[DetailedTraffic][time_units]"><option value="day" selected="" >Days</option><option value="week">Weeks</option><option value="month">Months</option></select></td>
            </tr>
			<tr>
              <td valign="middle" align="right">Summarized by:</td>
              <td valign="middle" align="left"><select name="data[DetailedTraffic][summarize]"><option selected="" value="d">Days</option><option value="ww">Weeks</option><option value="m">Months</option></select></td>
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
              <td align="left" valign="middle"><div><strong>Statistics from <?php echo date("m/d/Y",strtotime($start_dt)) ?> to Statistics from <?php echo date("m/d/Y",strtotime($end_dt)) ?></strong>.<br /><br /><br /></div>
			  <div><font size="3" color="000066"><strong>Summary figures:</strong></font><br/><br/><font size="3" color="000066"><strong>Breakdown over time:</strong></font><br/><br/>
Number of pages viewed: <?php echo $total_pv; ?><br/>
Number of member logins: <?php echo $total_lg; ?><br/>
Number of unique visitors: <?php echo count($get_unique_visitors); ?><br/>
Number of resume views: <?php echo $total_rv; ?><br/>
Number of job views: <?php echo $total_jv; ?><br/>
Number of job applications: <?php echo $total_ja; ?><br/>
Number of new candidate profiles: <?php echo $total_nc; ?><br/>
Number candidate profile updates: <?php echo $total_unc; ?><br/>
Number of show registrations: <?php echo $total_sr; ?><br/>
Number of views of "exhibitor resources": <?php echo $total_er; ?><br/>
<!--Number of views of "E-zine": <?php //echo $total_ez; ?><br/>-->
</div>
			  
               </td>
            </tr>
			<?php 
			if($summerize=='d'){
			 for($i=0;$i<=$numdays;$i++){
				$index_date = date ('Y-m-d' , strtotime ( '+'.$i.' day' , strtotime ($start_dt))) ;
				$cntValue[$i] = array();
				$max_val = 0;
				$ratio= 0;
				$totalResult = 0;
				if(count($get_page_views)){
					$max_val = $get_page_views[0][0]['cnt'];
					foreach($get_page_views as $get_page_view){
						//echo $max_val = $get_page_view[0]['cnt'];
						if(strtotime($get_page_view['WebStat']['viewdate'])==strtotime($index_date)){
							$cntValue[$i][] = $get_page_view[0]['cnt'];
						}
					}
					if(count($cntValue[$i]) != 0){
						$ratio=$max_width/$max_val;
						$totalResult = array_sum($cntValue[$i]);
					}else{
						$ratio= 0;
						$totalResult = 0;
					}
				}
			?>
			 	<?php if($i==0){?>
			<tr>
          	 <td>
			 	<div>  <strong> Number of pages viewed:</strong> </div><br/><br/>
				<ul class="bullet_list">
				<?php } ?>
				
				<?php $len=ceil($ratio*$totalResult); ?>
					
					<li><span class="static_text_traffic"><?php echo date("D m/d/Y",strtotime($index_date)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/red_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult; ?></span>
					</li>
				
				<?php if($i==$numdays){?>	
				</ul>
				</td>
          		</tr>
				<?php } ?>
			 
		  <?php } ?>
		  <?php }elseif($summerize=='ww'){ 
			 $max = array();
			  for($i=0;$i<$numweeks;$i++){
				$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
				$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
				
				$cntValue[$i] = array();
				foreach($get_page_views as $get_page_view){
					if((strtotime($get_page_view['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_page_view['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
						$cntValue[$i][] = $get_page_view[0]['cnt'];
					}
					if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_page_view['WebStat']['viewdate']))){
						$cntValue[$i][] = $get_page_view[0]['cnt'];
					}
				}
				
				$max[] = array_sum($cntValue[$i]);
			}
			
			?>
			<tr>
          	 <td>
			 	<div>  <strong> Number of pages viewed:</strong> </div><br/><br/>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$numweeks;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Week of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/red_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>
		  <?php }elseif($summerize=='m'){
				$max = array();
				  for($i=0;$i<$nummonths;$i++){
					$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
					$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
					
					$cntValue[$i] = array();
					foreach($get_page_views as $get_page_view){
						if((strtotime($get_page_view['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_page_view['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
							$cntValue[$i][] = $get_page_view[0]['cnt'];
						}
						if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_page_view['WebStat']['viewdate'])) && ($i==($nummonths-1))){
							$cntValue[$i][] = $get_page_view[0]['cnt'];
						}
					}
					
					$max[] = array_sum($cntValue[$i]);
				}
		 ?>
			<tr>
          	 <td>
			 	<div>  <strong> Number of pages viewed:</strong> </div><br/><br/>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$nummonths;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Month of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/red_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>					
		  <?php } ?>
		  <?php /******** Statisctics for Member Logins (employers and job seekers combined) ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong> Member Logins (employers and job seekers combined):</strong> <br/><br/></td>
            </tr>
			<?php 
			if($summerize=='d'){
			 for($i=0;$i<=$numdays;$i++){
				$index_date = date ('Y-m-d' , strtotime ( '+'.$i.' day' , strtotime ($start_dt))) ;
				$cntValue[$i] = array();
				$max_val = 0;
				$ratio= 0;
				$totalResult = 0;
				if(count($get_logins)>0){
					$max_val = $get_logins[0][0]['cnt'];
					foreach($get_logins as $get_login){
						if(strtotime($get_login['WebStat']['viewdate'])==strtotime($index_date)){
							$cntValue[$i][] = $get_login[0]['cnt'];
						}
					}
					if(count($cntValue[$i]) != 0){
						$ratio=$max_width/$max_val;
						$totalResult = array_sum($cntValue[$i]);
					}else{
						$ratio= 0;
						$totalResult = 0;
					}
				}
			?>
			<?php if($i==0){?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php } ?>
				
				<?php $len=ceil($ratio*$totalResult); ?>
					
					<li><span class="static_text_traffic"><?php echo date("D m/d/Y",strtotime($index_date)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/blue_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult; ?></span>
					</li>
				
				<?php if($i==$numdays){?>	
				</ul>
				 </td>
          		</tr>
				<?php } ?>
			
		  <?php } ?>
		  <?php }elseif($summerize=='ww'){ 
			 $max = array();
			  for($i=0;$i<$numweeks;$i++){
				$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
				$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
				
				$cntValue[$i] = array();
				foreach($get_logins as $get_login){
					if((strtotime($get_login['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_login['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
						$cntValue[$i][] = $get_login[0]['cnt'];
					}
					if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_login['WebStat']['viewdate']))){
						$cntValue[$i][] = $get_login[0]['cnt'];
					}
				}
				
				$max[] = array_sum($cntValue[$i]);
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$numweeks;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Week of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/blue_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>
		  <?php }elseif($summerize=='m'){
				$max = array();
				  for($i=0;$i<$nummonths;$i++){
					$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
					$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
					
					$cntValue[$i] = array();
					foreach($get_logins as $get_login){
						if((strtotime($get_login['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_login['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
							$cntValue[$i][] = $get_login[0]['cnt'];
						}
						if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_login['WebStat']['viewdate'])) && ($i==($nummonths-1))){
							$cntValue[$i][] = $get_login[0]['cnt'];
						}
					}
					
					$max[] = array_sum($cntValue[$i]);
				}
		 ?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$nummonths;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Month of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/blue_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>					
		  <?php } ?>
		  <?php /******** Statisctics for resumes viewed ********/ ?>
			<tr>
              <td align="left" valign="middle">
               <br/><strong> Number of resumes viewed:</strong> <br/><br/></td>
            </tr>
			<?php 
			if($summerize=='d'){
			 for($i=0;$i<=$numdays;$i++){
				$index_date = date ('Y-m-d' , strtotime ( '+'.$i.' day' , strtotime ($start_dt))) ;
				$cntValue[$i] = array();
				$max_val = 0;
				$ratio= 0;
				$totalResult = 0;
				if(count($get_res_views)>0){
					$max_val = $get_res_views[0][0]['cnt'];
					foreach($get_res_views as $get_res_view){
						if(strtotime($get_res_view['WebStat']['viewdate'])==strtotime($index_date)){
							$cntValue[$i][] = $get_res_view[0]['cnt'];
						}
					}
					if(count($cntValue[$i]) != 0){
						$ratio=$max_width/$max_val;
						$totalResult = array_sum($cntValue[$i]);
					}else{
						$ratio= 0;
						$totalResult = 0;
					}
				}
			?>
			<?php if($i==0){?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php } ?>
				
				<?php $len=ceil($ratio*$totalResult); ?>
					
					<li><span class="static_text_traffic"><?php echo date("D m/d/Y",strtotime($index_date)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/green_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult; ?></span>
					</li>
				
				<?php if($i==$numdays){?>	
				</ul>
				 </td>
          		</tr>
				<?php } ?>
			
		  <?php } ?>
		  <?php }elseif($summerize=='ww'){ 
			 $max = array();
			  for($i=0;$i<$numweeks;$i++){
				$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
				$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
				
				$cntValue[$i] = array();
				foreach($get_res_views as $get_res_view){
					if((strtotime($get_res_view['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_res_view['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
						$cntValue[$i][] = $get_res_view[0]['cnt'];
					}
					if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_res_view['WebStat']['viewdate']))){
						$cntValue[$i][] = $get_res_view[0]['cnt'];
					}
				}
				
				$max[] = array_sum($cntValue[$i]);
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$numweeks;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Week of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/green_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>
		  <?php }elseif($summerize=='m'){
				$max = array();
				  for($i=0;$i<$nummonths;$i++){
					$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
					$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
					
					$cntValue[$i] = array();
					foreach($get_res_views as $get_res_view){
						if((strtotime($get_res_view['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_res_view['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
							$cntValue[$i][] = $get_res_view[0]['cnt'];
						}
						if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_res_view['WebStat']['viewdate'])) && ($i==($nummonths-1))){
							$cntValue[$i][] = $get_res_view[0]['cnt'];
						}
					}
					
					$max[] = array_sum($cntValue[$i]);
				}
		 ?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$nummonths;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Month of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/green_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>					
		  <?php } ?>
		  <?php /******** Statisctics for jobs viewed********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong> Number of jobs viewed:</strong> <br/><br/></td>
            </tr>
			<?php 
			if($summerize=='d'){
			 for($i=0;$i<=$numdays;$i++){
				$index_date = date ('Y-m-d' , strtotime ( '+'.$i.' day' , strtotime ($start_dt))) ;
				$cntValue[$i] = array();
				$max_val = 0;
				$ratio= 0;
				$totalResult = 0;
				if(count($get_job_views)>0){
					$max_val = $get_job_views[0][0]['cnt'];
					foreach($get_job_views as $get_job_view){
						if(strtotime($get_job_view['WebStat']['viewdate'])==strtotime($index_date)){
							$cntValue[$i][] = $get_job_view[0]['cnt'];
						}
					}
					if(count($cntValue[$i]) != 0){
						$ratio=$max_width/$max_val;
						$totalResult = array_sum($cntValue[$i]);
					}else{
						$ratio= 0;
						$totalResult = 0;
					}
				}
			?>
			<?php if($i==0){?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php } ?>
				
				<?php $len=ceil($ratio*$totalResult); ?>
					
					<li><span class="static_text_traffic"><?php echo date("D m/d/Y",strtotime($index_date)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/purple_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult; ?></span>
					</li>
				
				<?php if($i==$numdays){?>	
				</ul>
				 </td>
          		</tr>
				<?php } ?>
			
		  <?php } ?>
		  <?php }elseif($summerize=='ww'){ 
			 $max = array();
			  for($i=0;$i<$numweeks;$i++){
				$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
				$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
				
				$cntValue[$i] = array();
				foreach($get_job_views as $get_job_view){
					if((strtotime($get_job_view['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_job_view['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
						$cntValue[$i][] = $get_job_view[0]['cnt'];
					}
					if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_job_view['WebStat']['viewdate']))){
						$cntValue[$i][] = $get_job_view[0]['cnt'];
					}
				}
				
				$max[] = array_sum($cntValue[$i]);
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$numweeks;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Week of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/purple_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>
		  <?php }elseif($summerize=='m'){
				$max = array();
				  for($i=0;$i<$nummonths;$i++){
					$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
					$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
					
					$cntValue[$i] = array();
					foreach($get_job_views as $get_job_view){
						if((strtotime($get_job_view['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_job_view['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
							$cntValue[$i][] = $get_job_view[0]['cnt'];
						}
						if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_job_view['WebStat']['viewdate'])) && ($i==($nummonths-1))){
							$cntValue[$i][] = $get_job_view[0]['cnt'];
						}
					}
					
					$max[] = array_sum($cntValue[$i]);
				}
		 ?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$nummonths;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Month of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/purple_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>					
		  <?php } ?>
		  <?php /******** Statisctics for Number of job applications:********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong> Number of job applications:</strong> <br/><br/></td>
            </tr>
			<?php 
			if($summerize=='d'){
			 for($i=0;$i<=$numdays;$i++){
				$index_date = date ('Y-m-d' , strtotime ( '+'.$i.' day' , strtotime ($start_dt))) ;
				$cntValue[$i] = array();
				$max_val = 0;
				$ratio= 0;
				$totalResult = 0;
				if(count($get_job_apps)>0){
					$max_val = $get_job_apps[0][0]['cnt'];
					foreach($get_job_apps as $get_job_app){
						if(strtotime($get_job_app['ApplyHistory']['dt'])==strtotime($index_date)){
							$cntValue[$i][] = $get_job_app[0]['cnt'];
						}
					}
					if(count($cntValue[$i]) != 0){
						$ratio=$max_width/$max_val;
						$totalResult = array_sum($cntValue[$i]);
					}else{
						$ratio= 0;
						$totalResult = 0;
					}
				}
			?>
			<?php if($i==0){?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php } ?>
				
				<?php $len=ceil($ratio*$totalResult); ?>
					
					<li><span class="static_text_traffic"><?php echo date("D m/d/Y",strtotime($index_date)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/light_purple_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult; ?></span>
					</li>
				
				<?php if($i==$numdays){?>	
				</ul>
				 </td>
          		</tr>
				<?php } ?>
			
		  <?php } ?>
		  <?php }elseif($summerize=='ww'){ 
			 $max = array();
			  for($i=0;$i<$numweeks;$i++){
				$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
				$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
				
				$cntValue[$i] = array();
				foreach($get_job_apps as $get_job_app){
					if((strtotime($get_job_app['ApplyHistory']['dt'])>=strtotime($index_start_dt)) && (strtotime($get_job_app['ApplyHistory']['dt']) < strtotime($index_end_dt)) ){
						$cntValue[$i][] = $get_job_app[0]['cnt'];
					}
					if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_job_app['ApplyHistory']['dt']))){
						$cntValue[$i][] = $get_job_app[0]['cnt'];
					}
				}
				
				$max[] = array_sum($cntValue[$i]);
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$numweeks;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Week of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/light_purple_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>
		  <?php }elseif($summerize=='m'){
				$max = array();
				  for($i=0;$i<$nummonths;$i++){
					$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
					$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
					
					$cntValue[$i] = array();
					foreach($get_job_apps as $get_job_app){
						if((strtotime($get_job_app['ApplyHistory']['dt'])>=strtotime($index_start_dt)) && (strtotime($get_job_app['ApplyHistory']['dt']) < strtotime($index_end_dt)) ){
							$cntValue[$i][] = $get_job_app[0]['cnt'];
						}
						if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_job_app['ApplyHistory']['dt'])) && ($i==($nummonths-1))){
							$cntValue[$i][] = $get_job_app[0]['cnt'];
						}
					}
					
					$max[] = array_sum($cntValue[$i]);
				}
		 ?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$nummonths;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Month of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/light_purple_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>					
		  <?php } ?>
		   <?php /******** Number of NEW candidate profiles submitted:********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong> Number of NEW candidate profiles submitted:</strong> <br/><br/></td>
            </tr>
			<?php 
			if($summerize=='d'){
			 for($i=0;$i<=$numdays;$i++){
				$index_date = date ('Y-m-d' , strtotime ( '+'.$i.' day' , strtotime ($start_dt))) ;
				$cntValue[$i] = array();
				$max_val = 0;
				$ratio= 0;
				$totalResult = 0;
				if(count($get_new_cands)>0){
					$max_val = $get_new_cands[0][0]['cnt'];
					foreach($get_new_cands as $get_new_cand){
						if(strtotime($get_new_cand['WebStat']['viewdate'])==strtotime($index_date)){
							$cntValue[$i][] = $get_new_cand[0]['cnt'];
						}
					}
					if(count($cntValue[$i]) != 0){
						$ratio=$max_width/$max_val;
						$totalResult = array_sum($cntValue[$i]);
					}else{
						$ratio= 0;
						$totalResult = 0;
					}
				}
			?>
			<?php if($i==0){?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php } ?>
				
				<?php $len=ceil($ratio*$totalResult); ?>
					
					<li><span class="static_text_traffic"><?php echo date("D m/d/Y",strtotime($index_date)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/dgreen_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult; ?></span>
					</li>
				
				<?php if($i==$numdays){?>	
				</ul>
				 </td>
          		</tr>
				<?php } ?>
			
		  <?php } ?>
		  <?php }elseif($summerize=='ww'){ 
			 $max = array();
			  for($i=0;$i<$numweeks;$i++){
				$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
				$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
				
				$cntValue[$i] = array();
				foreach($get_new_cands as $get_new_cand){
					if((strtotime($get_new_cand['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_new_cand['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
						$cntValue[$i][] = $get_new_cand[0]['cnt'];
					}
					if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_new_cand['WebStat']['viewdate']))){
						$cntValue[$i][] = $get_new_cand[0]['cnt'];
					}
				}
				
				$max[] = array_sum($cntValue[$i]);
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$numweeks;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Week of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/dgreen_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>
		  <?php }elseif($summerize=='m'){
				$max = array();
				  for($i=0;$i<$nummonths;$i++){
					$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
					$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
					
					$cntValue[$i] = array();
					foreach($get_new_cands as $get_new_cand){
						if((strtotime($get_new_cand['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_new_cand['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
							$cntValue[$i][] = $get_new_cand[0]['cnt'];
						}
						if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_new_cand['WebStat']['viewdate'])) && ($i==($nummonths-1))){
							$cntValue[$i][] = $get_new_cand[0]['cnt'];
						}
					}
					
					$max[] = array_sum($cntValue[$i]);
				}
		 ?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$nummonths;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Month of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/dgreen_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>					
		  <?php } ?>
		   <?php /******** Number of NEW candidate profiles updated:********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong>Number of candidate profile updates:</strong> <br/><br/></td>
            </tr>
			<?php 
			if($summerize=='d'){
			 for($i=0;$i<=$numdays;$i++){
				$index_date = date ('Y-m-d' , strtotime ( '+'.$i.' day' , strtotime ($start_dt))) ;
				$cntValue[$i] = array();
				$max_val = 0;
				$ratio= 0;
				$totalResult = 0;
				if(count($get_upd_cands)>0){
					$max_val = $get_upd_cands[0][0]['cnt'];
					foreach($get_upd_cands as $get_upd_cand){
						if(strtotime($get_upd_cand['WebStat']['viewdate'])==strtotime($index_date)){
							$cntValue[$i][] = $get_upd_cand[0]['cnt'];
						}
					}
					if(count($cntValue[$i]) != 0){
						$ratio=$max_width/$max_val;
						$totalResult = array_sum($cntValue[$i]);
					}else{
						$ratio= 0;
						$totalResult = 0;
					}
				}
			?>
			<?php if($i==0){?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php } ?>
				
				<?php $len=ceil($ratio*$totalResult); ?>
					
					<li><span class="static_text_traffic"><?php echo date("D m/d/Y",strtotime($index_date)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/olive_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult; ?></span>
					</li>
				
				<?php if($i==$numdays){?>	
				</ul>
				 </td>
          		</tr>
				<?php } ?>
			
		  <?php } ?>
		  <?php }elseif($summerize=='ww'){ 
			 $max = array();
			  for($i=0;$i<$numweeks;$i++){
				$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
				$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
				
				$cntValue[$i] = array();
				foreach($get_upd_cands as $get_upd_cand){
					if((strtotime($get_upd_cand['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_upd_cand['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
						$cntValue[$i][] = $get_upd_cand[0]['cnt'];
					}
					if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_upd_cand['WebStat']['viewdate']))){
						$cntValue[$i][] = $get_upd_cand[0]['cnt'];
					}
				}
				
				$max[] = array_sum($cntValue[$i]);
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$numweeks;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Week of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/olive_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>
		  <?php }elseif($summerize=='m'){
				$max = array();
				  for($i=0;$i<$nummonths;$i++){
					$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
					$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
					
					$cntValue[$i] = array();
					foreach($get_upd_cands as $get_upd_cand){
						if((strtotime($get_new_cand['WebStat']['viewdate'])>=strtotime($index_start_dt)) && (strtotime($get_upd_cand['WebStat']['viewdate']) < strtotime($index_end_dt)) ){
							$cntValue[$i][] = $get_upd_cand[0]['cnt'];
						}
						if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_upd_cand['WebStat']['viewdate'])) && ($i==($nummonths-1))){
							$cntValue[$i][] = $get_upd_cand[0]['cnt'];
						}
					}
					
					$max[] = array_sum($cntValue[$i]);
				}
		 ?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$nummonths;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Month of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/olive_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>					
		  <?php } ?>
		  <?php /******** Number of Show Registration ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong>Number of show_registrations:</strong> <br/><br/></td>
            </tr>
			<?php 
			if($summerize=='d'){
			 for($i=0;$i<=$numdays;$i++){
				$index_date = date ('Y-m-d' , strtotime ( '+'.$i.' day' , strtotime ($start_dt))) ;
				$cntValue[$i] = array();
				$max_val = 0;
				$ratio= 0;
				$totalResult = 0;
				if(count($get_show_regs)>0){
					$max_val = $get_show_regs[0][0]['cnt'];
					foreach($get_show_regs as $get_show_reg){
						if(strtotime($get_show_reg['Registration']['date_time'])==strtotime($index_date)){
							$cntValue[$i][] = $get_show_reg[0]['cnt'];
						}
					}
					if(count($cntValue[$i]) != 0){
						$ratio=$max_width/$max_val;
						$totalResult = array_sum($cntValue[$i]);
					}else{
						$ratio= 0;
						$totalResult = 0;
					}
				}
			?>
			<?php if($i==0){?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php } ?>
				
				<?php $len=ceil($ratio*$totalResult); ?>
					
					<li><span class="static_text_traffic"><?php echo date("D m/d/Y",strtotime($index_date)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/orange_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult; ?></span>
					</li>
				
				<?php if($i==$numdays){?>	
				</ul>
				 </td>
          		</tr>
				<?php } ?>
			
		  <?php } ?>
		  <?php }elseif($summerize=='ww'){ 
			 $max = array();
			  for($i=0;$i<$numweeks;$i++){
				$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
				$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
				
				$cntValue[$i] = array();
				foreach($get_show_regs as $get_show_reg){
					if((strtotime($get_show_reg['Registration']['date_time'])>=strtotime($index_start_dt)) && (strtotime($get_show_reg['Registration']['date_time']) < strtotime($index_end_dt)) ){
						$cntValue[$i][] = $get_show_reg[0]['cnt'];
					}
					if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_show_reg['Registration']['date_time']))){
						$cntValue[$i][] = $get_show_reg[0]['cnt'];
					}
				}
				
				$max[] = array_sum($cntValue[$i]);
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$numweeks;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' week' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 week', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Week of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/orange_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>
		  <?php }elseif($summerize=='m'){
				$max = array();
				  for($i=0;$i<$nummonths;$i++){
					$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
					$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
					
					$cntValue[$i] = array();
					foreach($get_show_regs as $get_show_reg){
						if((strtotime($get_show_reg['Registration']['date_time'])>=strtotime($index_start_dt)) && (strtotime($get_show_reg['Registration']['date_time']) < strtotime($index_end_dt)) ){
							$cntValue[$i][] = $get_show_reg[0]['cnt'];
						}
						if((strtotime($end_dt)==strtotime($index_end_dt)) && (strtotime($end_dt)==strtotime($get_show_reg['Registration']['date_time'])) && ($i==($nummonths-1))){
							$cntValue[$i][] = $get_show_reg[0]['cnt'];
						}
					}
					$max[] = array_sum($cntValue[$i]);
				}
		 ?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php $max_val = max($max);?>
				<?php for($i=0;$i<$nummonths;$i++){?>
				<?php 
							$index_start_dt = date ('Y-m-d' , strtotime ( '+'.($i).' month' , strtotime ($start_dt)));
							$index_end_dt = date ('Y-m-d' , strtotime ( '+1 month', strtotime ($index_start_dt)));
							
							if(count($cntValue[$i]) != 0){
								$ratio=$max_width/$max_val;
								$totalResult[$i] = array_sum($cntValue[$i]);
							}else{
								$ratio= 0;
								$totalResult[$i] = 0;
							}
				 ?>
				<?php $len=ceil($ratio*$totalResult[$i]); ?>
					<li><span class="static_text_traffic"><?php echo 'Month of '.date("m/d/Y",strtotime($index_start_dt)); ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/orange_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $totalResult[$i]; ?></span>
					</li>
				<?php }?>
				</ul>
			 </td>
          </tr>					
		  <?php } ?>
		   
		  <?php /******** Number of registered Referrer Breakdown ********/ ?>
		  <tr>
              <td align="left" valign="middle">
               <br/><strong>Referrer Breakdown:</strong> <br/><br/><br/>
			   <?php if(count($get_referrer_traffic2)>0){?>
				<strong>Breakdown of traffic by registered referrer:</strong><br/><br/>
				<?php } ?>
				</td>
            </tr>
			<?php 
			if(count($get_referrer_traffic2) != 0){
				$max_val= $get_referrer_traffic2[0][0]['cnt5'];
			}else{
				$max_val= 0;
			}
			
			if(count($get_referrer_traffic2) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($get_referrer_traffic2 as $get_referrer_traffic2){?>
				<?php $len=ceil($ratio*$get_referrer_traffic2[0]['cnt5']); ?>
				<?php //$avg = $get_referrer_traffic2[0]['cnt']/$totaldays; ?>
					<li><span class="static_text_traffic"><?php echo $get_referrer_traffic2['WebStat']['pagename']; ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/green_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $get_referrer_traffic2[0]['cnt5']; ?></span>
					</li>
				<?php } ?>	
				</ul>
			 </td>
          </tr>		
		   <?php /******** Number of not registered Referrer Breakdown ********/ ?>
		  <tr>
              <td align="left" valign="middle">
			   <?php if(count($get_referrer_traffic)>0){?>
				<strong>Breakdown of traffic by non-registered referrer:</strong><br/><br/>
				<?php } ?>
				</td>
            </tr>
			<?php 
			if(count($get_referrer_traffic) != 0){
				$max_val= $get_referrer_traffic[0][0]['cnt4'];
			}else{
				$max_val= 0;
			}
			
			if(count($get_referrer_traffic) != 0){
				$ratio=$max_width/$max_val;
			}else{
				$ratio= 0;
			}
			
			?>
			<tr>
          	 <td>
				<ul class="bullet_list">
				<?php foreach($get_referrer_traffic as $get_referrer_traffic){?>
				<?php $len=ceil($ratio*$get_referrer_traffic[0]['cnt4']); ?>
				<?php //$avg = $get_referrer_traffic2[0]['cnt']/$totaldays; ?>
					<li><span class="static_text_traffic" style="width:500px; text-align:right;"><?php echo $get_referrer_traffic['WebStat']['referrer']; ?></span><span class="bar"><img src="<?php echo $this->webroot;?>img/purple_square.gif" width="<?php echo $len;?>" height="5" border="0"></span><span><?php echo $get_referrer_traffic[0]['cnt4']; ?></span>
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
