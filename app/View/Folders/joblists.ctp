<?php $limitJobs = $common->GetEmployerJobLimit($this->Session->read('Auth.Client.employerContact.employer_id'));?>
 <?php //$this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<div id="wrapper">
 <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Manage Jobs</h1>
          <div class="content">
            <div class="jobseeker_info">
              <p><strong><?php echo $this->Session->read('Auth.Client.employerContact.contact_name');?>'s Job Management Center </strong><br />
                 <?php echo date("l, d/m/Y - h:i A T");?></p>
            </div>
            <?php if($limitJobs==0){?>
            <a href="javascript:void(0);" onclick="showPostJobPopup()"><?php echo $this->Html->image("images/post-new-job.jpg",array('alt'=>'Post Job'));?></a> <br />
            <?php }else{?>
            <a href="<?php echo $this->webroot; ?>employers/emppostjob"><?php echo $this->Html->image("images/post-new-job.jpg",array('alt'=>'Post Job'));?></a> <br />
            <?php }?>
            <br />
            <p><strong>Total number of job postings for your company: <?php echo $jobcount; ?> (maximum of 100 jobs per account) </strong></p>
            <br />
			<?php echo $this->Form->create()?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="16%"><?php echo $this->Paginator->sort('JobPosting.job_title','Job Title'); ?></th>
                      <th width="16%"><?php echo $this->Paginator->sort('JobPosting.start_dt','Date Posted'); ?></th>
                      <th width="13%"><?php echo $this->Paginator->sort('JobPosting.location_city','Location'); ?></th>
                      <th width="10%">Matching<br />
                        Resumes</th>
                      <th width="10%">Preview</th>
                      <th width="10%">Active</th>
                      <th width="10%">Refresh</th>
                      <th width="10%">Delete</th>
                    </tr>
                  </table></td>
              </tr>
			  <?php if(count($joblists)>0):
			   foreach ($joblists as $K=> $joblist):
			  ?>
              <tr>
                <td class="table_row" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="15%"><?php echo $this->Html->link(__($joblist['JobPosting']['job_title']), array('action' => 'empeditjob', $joblist['JobPosting']['posting_id'])); ?></td>
                      <td  width="15%"><?php echo date("d-m-Y",strtotime($joblist['JobPosting']['start_dt']));?></td>
                      <td  width="10%"><?php echo $joblist['JobPosting']['location_city'];?>, <?php echo $joblist['JobPosting']['location_state'];?></td>
                      <td  width="10%"><a href="matching-jobs-emp.html">Matching</a></td>
                      <td  width="10%"><?php echo $this->Html->link("Preview", array('controller'=>'employers','action'=>'jobdetail',$joblist['JobPosting']['posting_id']));?></td>
                      <td  width="10%">
					  <input type="hidden" name="data[JobPosting][active][<?php echo $joblist['JobPosting']['posting_id'];?>]" value="0" id="active<?php echo $joblist['JobPosting']['posting_id'];?>_" />
					  <input type="checkbox" name="data[JobPosting][active][<?php echo $joblist['JobPosting']['posting_id'];?>]" value="1" id="active<?php echo $joblist['JobPosting']['posting_id'];?>"<?php if($joblist['JobPosting']['active']){?> checked="checked" <?php }?>/></td>
                      <td width="10%"><input type="checkbox" name="data[JobPosting][refresh][]" value="<?php echo $joblist['JobPosting']['posting_id']?>" id="refresh<?php echo $joblist['JobPosting']['posting_id'];?>" /></td>
                      <td width="10%" class="last"><input type="checkbox" name="data[JobPosting][delete][]" value="<?php echo $joblist['JobPosting']['posting_id']?>" id="delete<?php echo $joblist['JobPosting']['posting_id'];?>" /></td>
                    </tr>
                  </table></td>
              </tr>
			  <?php endforeach;
				else: 
				?>
				<tr>
                <td class="table_row" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="8">No Jobs Found</td>
                    </tr>
                  </table></td>
              </tr>
			<?php endif;?>
            </table>
			<div class="paginator">
				<?php echo $this->Paginator->numbers(array('first' => 'First page'));?></td>
			</div>
            <div class="man_resume_footer">
              <p>Please enter text as shown in image below:</p>
              <ul>
                <li class="last">
                  <?php echo $this->Form->Submit("images/submit_btn.jpg",array('div'=>false,'name'=>'Submit'));?>
                </li>
				<li>
                   <?php echo $this->Form->input('JobPosting.captcha',array('autocomplete'=>'off','label'=>false,'div'=>false,'class'=>'security_txt'));?>
                </li>
				<li>
                 <?php echo $this->Html->image($this->Html->url(array('action'=>'captcha'), true),array('style'=>'','vspace'=>2)); ?>
                </li>
              </ul>
              <div class="clear"></div>
            </div>
			<?php echo $this->Form->end()?>
            <br />
            <ul class="list">
              <li> <strong> <span class="instruction">Jobs are active for 30 days. If you do not refresh a job after the 30-day period, it will be flagged as inactive and will not show up in job search results.</span></strong></li>
              <li> To edit a posting, click on a job title below.</li>
              <li> You can submit a maximum of 10 jobs.</li>
              <li> You can make a job <strong>ACTIVE or INACTIVE</strong>. Inactive jobs are not visible by job seekers when searching for jobs. You can use this feature to temporarily disable a posting and re-activate it later without having to re-enter all the information.</li>
              <li> To refresh or delete a posting, check the appropriate refresh or delete checkboxes and click on the "Refresh / Delete" button. "Refreshing" a job will update the date of submission of that job to today's date. This will make it look fresh to job seekers when they are searching.</li>
              <li> <strong>MATCHING / SEARCH AGENT:</strong> Click on "match" to instantly view resumes matching your job postings, based on the keywords you selected from the pull-down menus in the job posting screen.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel');?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?>
  </div>
</div>

