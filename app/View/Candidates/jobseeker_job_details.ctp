<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container"> <?php echo $this->element('front_innerpage_siderbar', array('cache' => true)); ?>
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Job posting Details</h1>
          <div class="content">
            <ul class="footer_btn notoppadding" style="margin-left:10px;">
              <?php if($nextJobId){ ?>
              <li> <?php echo $this->Html->link($this->Html->image('images/next_job.jpg'),array('controller'=>'candidates','action'=>'jobDetails/'.$nextJobId),array('escape'=>false)); 			
			  	?> </li>
              <?php } ?>
              <?php if($previousJobId){ ?>
              <li> <?php echo $this->Html->link($this->Html->image('images/prev.jpg'),array('controller'=>'candidates','action'=>'jobDetails/'.$previousJobId),array('escape'=>false)); 			
			  	?> </li>
              <?php } ?>
              <li> <?php echo $this->Html->link($this->Html->image('images/bk_search.jpg'),array('controller'=>'candidates','action'=>'autoMatching'),array('escape'=>false)); ?> </li>
            </ul>
            <!--  <ul class="footer_btn notoppadding" style="margin-left:10px;">
            	  <?php if($previousJobId){ ?>
             <li> 
              <?php echo $this->Html->link($this->Html->image('images/prev.jpg'),array('controller'=>'candidates','action'=>'jobDetails/'.$previousJobId),array('escape'=>false)); 			
			  	?>
             </li>
            <?php } ?>
            </ul>-->
            <div class="clear"></div>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
            <?php if($this->Session->read('Auth.Client.Candidate.id')!=''){?>
              <ul class="footer_btn notoppadding">
                <li> <?php echo $this->Html->link($this->Html->image('images/applytojob_new.jpg'),array('controller'=>'candidates','action'=>'Jobseeker_jobApply?jobId='.$jobPostingDetail['JobPosting']['posting_id']),array('escape'=>false)); ?> </li>
                <li> <?php echo $this->Html->link($this->Html->image('images/emailto_friend_new.jpg'),array('controller'=>'candidates','action'=>'sendEmailToFriend/?jobId='.$jobPostingDetail['JobPosting']['posting_id']),array('escape'=>false)); ?> </li>
              </ul>
            <?php }?>
              <div class="clear"></div>
              <br />
              <h2 class="mana_subheading">Summary Information</h2>
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Position Title:</label>
                  <div class="form_rt_col1">
                    <label><?php echo $jobPostingDetail['JobPosting']['job_title']; ?></label>
                  </div>
                </li>
                <li>
                  <label>Employer Name:</label>
                  <div class="form_rt_col1">
                    <label><a style="color: #013DB9" href="<?php echo FULL_BASE_URL?>/Jobseeker/candidates/employeDetail/<?php echo $jobPostingDetail['Employer']['id']?>" target="_blank"><?php echo $jobPostingDetail['Employer']['employer_name']; ?></a></label>
                  </div>
                </li>
                <li>
                  <label>Short Description:</label>
                  <div class="form_rt_col1">
                    <label><?php echo $jobPostingDetail['JobPosting']['short_descr']; ?></label>
                  </div>
                </li>
                <li>
                  <label>State:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getStateName($jobPostingDetail['JobPosting']['location_state']) ?> </label>
                  </div>
                </li>
                <li>
                  <label>City:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $jobPostingDetail['JobPosting']['location_city']; ?> </label>
                  </div>
                </li>
                <li>
                  <label>Location:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getWorkLocation($jobPostingDetail['JobPosting']['work_location_code']) ?> </label>
                  </div>
                </li>
                <li>
                  <label>Work type:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getWorkTypeCode($jobPostingDetail['JobPosting']['work_type_code']) ?> </label>
                  </div>
                </li>
                <li>
                  <label>Working Time:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getWorkTimeCode($jobPostingDetail['JobPosting']['work_time_code']) ?> </label>
                  </div>
                </li>
                <li>
                  <label>Position Type:</label>
                  <div class="form_rt_col1">
                    <label> Terms: Permanent   Location: On-Site Only    Hours: Full Time</label>
                  </div>
                </li>
                <li>
                  <label>Salary Type:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getSalaryType($jobPostingDetail['JobPosting']['salary_type_code']) ?> </label>
                  </div>
                <li>
                  <label>Start Date:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $jobPostingDetail['JobPosting']['start_dt']; ?> </label>
                  </div>
                </li>
                <li>
                  <label>Last Date:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $jobPostingDetail['JobPosting']['end_dt']; ?></label>
                  </div>
                </li>
                <li>
                  <label>Security clearance required: </label>
                  <div class="form_rt_col1">
                    <label>Top Secret w/ Full Scope Lifestyle Poly</label>
                    <br />
                  </div>
                </li>
              </ul>
              <div class="preview_panel">
                <h2 class="mana_subheading">Full Description</h2>
                <?php echo nl2br($jobPostingDetail['JobPosting']['full_descr']); ?> </div>
              <br />
              <?php if($this->Session->read('Auth.Client.Candidate.id')!=''){?>
              <ul class="footer_btn notoppadding">
                <li> <?php echo $this->Html->link($this->Html->image('images/applytojob_new.jpg'),array('controller'=>'candidates','action'=>'Jobseeker_jobApply?jobId='.$jobPostingDetail['JobPosting']['posting_id']),array('escape'=>false)); ?> </li>
                <li> <?php echo $this->Html->link($this->Html->image('images/emailto_friend_new.jpg'),array('controller'=>'candidates','action'=>'sendEmailToFriend/?jobId='.$jobPostingDetail['JobPosting']['posting_id']),array('escape'=>false)); ?> </li>
              </ul>
              <?php }?>
              <div class="clear"></div>
            </div>
            <ul class="footer_btn " style="margin-left:10px;">
              <?php if($nextJobId){ ?>
              <li> <?php echo $this->Html->link($this->Html->image('images/next_job.jpg'),array('controller'=>'candidates','action'=>'jobDetails/'.$nextJobId),array('escape'=>false)); 			
			  	?> </li>
              <?php } ?>
              <?php if($previousJobId){ ?>
              <li> <?php echo $this->Html->link($this->Html->image('images/prev.jpg'),array('controller'=>'candidates','action'=>'jobDetails/'.$previousJobId),array('escape'=>false)); 			
			  	?> </li>
              <?php } ?>
              <li> <?php echo $this->Html->link($this->Html->image('images/bk_search.jpg'),array('controller'=>'candidates','action'=>'autoMatching'),array('escape'=>false)); ?> </li>
            </ul>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>