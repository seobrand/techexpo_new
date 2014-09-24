<?php //pr($employerDetail);?>
<div id="wrapper">
    <?php if($this->Session->read('Auth.Client.User.user_type')=='E'):?>
  <?php echo $this->element('employer_tabs');?>
  	<?php endif;?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Company Profile </h1>
            <?php if($employerDetail['Employer']['logo_file']!=""){?>
	              	<div class="compnay_profile_logo"><img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$employerDetail['Employer']['logo_file'];?>&maxw=200&maxh=80"  alt="<?php echo $employerDetail['Employer']['employer_name']; ?>"  title="<?php echo $employerDetail['Employer']['employer_name']; ?>"/>&nbsp;</div>
	          	 <?php }?>
                 
            <div style="clear:both" ></div>     
          <div class="content">
        
           <div class="border_bottom">
	             
              	<div class="compnay_name"><?php echo $employerDetail['Employer']['employer_name'];?></div>
              </div>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
            <br/>
              <ul class="form_list manage_resume_form">
              
                <li>
                  <label>City:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $employerDetail['Employer']['city'];?></label>
                  </div>
                </li>
                <li>
                  <label>State:</label>
                  <div class="form_rt_col1">
                  
                    <label><?php echo $employerDetail['Employer']['state'];?></label>
                  </div>
                </li>
                <li>
                  <label>Web URL:</label>
                  <div class="form_rt_col1">
                  <?php if (!preg_match("~^(?:f|ht)tps?://~i", $employerDetail['Employer']['url'])) {
							$url = "http://" . $employerDetail['Employer']['url'];
						}
						else
						{
						 $url = $employerDetail['Employer']['url'];	
						}
						 ?>
                    <label> <a href="<?php echo $url;?>" target="_blank"><?php echo $employerDetail['Employer']['url'];?></a></label>
                  </div>
                </li>
                <li>
                  <label>Stock Symbol:</label>
                  <div class="form_rt_col1">
                    <label><?php echo $employerDetail['Employer']['stock_symbol'];?></label>
                  </div>
                </li>
                <li>
                  <label>Annual Revenue:</label>
                  <div class="form_rt_col1">
                    <label> <?php if($employerDetail['Employer']['annual_revenue']!='') echo "$".$employerDetail['Employer']['annual_revenue'];?></label>
                  </div>
                </li>
                <li>
                  <label>Number of Employees:</label>
                  <div class="form_rt_col1">
                    <label><?php echo $employerDetail['Employer']['number_of_employees'];?></label>
                  </div>
                </li>
                <li>
                  <label>Answer to the question "Do you occasionally sponsor H1-B visas ?"</label>
                  <div class="form_rt_col1">
                    <label><?php echo ucfirst($employerDetail['Employer']['visa_status']);?></label>
                  </div>
                </li>
                <li>
                  <label>Industry: </label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getIndustriesName($employerDetail['Employer']['employer_type_code']);?></label>
                  </div>
                </li>
                <li>
                  <label>Company Description: </label>
                  <div class="form_rt_col1">
                    <label><?php echo nl2br($employerDetail['Employer']['description']);?></label>
                  </div>
                </li>
              </ul>
              
                 <?php if(!empty($EmployerVd['EmployerVideo']['id'])) {   ?>
                <div class="preview_panel">
                <h2 class="border_botom">Company Video</h2>
             
                
                <a href="<?php echo $this->Html->url(FULL_BASE_URL.router::url('/',false).'employers/empshowVideo/'.$EmployerVd['EmployerVideo']['id'], false); ?>" class="ajax_empvideo" >
             <?php if($EmployerVd['EmployerVideo']['video_type']=='upload')
				{
				 echo $this->Html->image("images/video.jpg",array('style'=>'width:200px;'));
				}
				else {
					$youtubeId = end(explode('/',$EmployerVd['EmployerVideo']['video']));
				 ?>
                <img src="http://img.youtube.com/vi/<?php echo $youtubeId; ?>/0.jpg" style="width:200px;"  />
                <?php } ?>
                </a>
                
                </div>
                <?php } ?>
                
                
              <div class="preview_panel">
                <h2 class="border_botom"><?php echo $employerDetail['Employer']['employer_name'];?>'s Open Jobs </h2>
				<?php $employerOpenJobs = $employerDetail['JobPosting'];?>
				<?php if(count($employerOpenJobs)>0){ $i = 0; ?>
					<?php foreach($employerOpenJobs as $key => $empopenjobs){?>
							<?php if($empopenjobs['active']){?>
							<p><strong><?php echo $this->Html->link($empopenjobs['job_title'],array('controller'=>'employers','action'=>'jobdetail',$empopenjobs['posting_id']));?></strong><br />
						 <?php echo nl2br($empopenjobs['short_descr']);?></p>
							<?php $i++; } ?>
					 <?php } ?> 
				<?php } ?>
				<?php if(count($employerOpenJobs)==0 || $i==0){ ?>
					<p>This company has not posted any jobs yet, please visit this company's website to view its open positions.</p>
				<?php }?>  
              </div>
              <br />
            </div>
          </div>
        </div>
      </div>
    </div>
        <?php 
		 if($this->Session->read('Auth.Client.Candidate.id')!='')
			{
				echo $this->element('jobSeekerSidebar', array('cache' => true)); 
				
			}elseif($this->Session->read('Auth.Client.employerContact.id')!='')
			{
				echo $this->element('employer_left_panel');
			}else
			{
				echo $this->element('main_login_leftbar', array('cache' => true)); 
       			echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); 
			}
	   ?>
    <div class="clear"></div>
   <?php echo $this->element('partners'); ?>
  </div>
</div>
