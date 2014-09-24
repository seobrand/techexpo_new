<?php $limitJobs = $common->GetEmployerJobLimit($this->Session->read('Auth.Client.employerContact.employer_id'));?>
<script type="text/javascript">
function confirmfrmSubmit()
{
	var agree=confirm("Are you sure to continue?");
	if (agree)
		return true ;
	else
		return false ;
}
</script>
<div id="wrapper">
  <?php echo $this->element('employer_tabs');?>
  <div id="container">
    
    
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Manage Job Postings
            <div class="psotjob_button">
            <?php   $trialAccunt = $this->Session->read('TrialAccountEmp');
			if($trialAccunt==1){    ?> 
             <a href="javascript:void(0);" onclick="trialAccountPopup()"><?php echo $this->Html->image("images/post-new-job.jpg",array('alt'=>'Post Job'));?></a><br />
            <?php } else if($limitJobs>0){?>
            <a href="<?php echo $this->webroot; ?>employers/emppostjob"><?php echo $this->Html->image("images/post-new-job.jpg",array('alt'=>'Post Job'));?></a><br />
            <?php }else{?>
            <a href="javascript:void(0);" onclick="showPostJobPopup()"><?php echo $this->Html->image("images/post-new-job.jpg",array('alt'=>'Post Job'));?></a><br />
            <?php }?>
            </div></h1>
          <div class="content">            
            <ul class="list joblist_information">
               <li> <strong> <span class="instruction">Jobs are active for 60 days. If you do not refresh a job after the 60-day period, it will be flagged as inactive and omitted from future job search results."</span></strong></li>
              <li> To edit a posting click on a job title below.</li>
              <li> You can make a job ACTIVE or INACTIVE. Inactive jobs are not visible by job seekers when searching for jobs. You can use this feature to temporarily disable a posting and re-activate it later without having to re-enter all the information.</li>
              <li> To refresh or delete a posting, select the option from the drop down and click the submit button. "Refreshing" a job will update the date of submission of that job to today's date. This will make it look new to job seekers when they are searching.</li>
           <?php /*?>   <li> The “Matching resumes” view allows you to instantly view resumes matching your job postings, based on the keywords you selected from the pull-down menus in the job posting screen.</li><?php */?>
            </ul>
            <?php if($this->Paginator->numbers()):?>
            <br />
            <div class="pager_panel">
              <div class="pager">
                <div class="paging"> 
				<?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                  <?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;&nbsp;'));?>
                  <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
                
                 </div>
                <div class="clear"></div>
              </div>
            </div>
            <br />
            <?php endif;?>
            <p><strong>Total number of job postings for your company: <?php echo $jobcount; ?></strong></p>
            <br />
            <?php echo $this->Form->create();
			if(count($joblists)>0):
			?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr class="tableHead">
                  <th width="17%" align="center"><?php echo $this->Paginator->sort('JobPosting.job_title','Job Title'); ?></th>
                  <th width="7%" align="center"><!--<?php echo $this->Html->image("images/preview.jpg");?>--></th>
                  <th width="9%" align="center"><?php echo $this->Paginator->sort('JobPosting.start_dt','Days Left'); ?></th>
                  <th width="18%" style="padding-left:0px!important;" align="center"><?php echo $this->Paginator->sort('JobPosting.location_city','Location'); ?></th>
                 <?php /*?> <th width="6%" style="padding-left:0px!important;" align="center"><?php echo $this->Html->image("images/preview.jpg");?>
                    Match</th><?php */?>
                  <th width="5%" style="padding-right:0px!important;" align="center">Active</th>
                  <th width="11%" style="padding-right:0px!important;" align="center">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
				$i=1;
			   foreach ($joblists as $K=> $joblist):
			  ?>
                <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                  <td ><?php echo $this->Html->link(__($joblist['JobPosting']['job_title']), array('action' => 'empeditjob', $joblist['JobPosting']['posting_id'])); ?></td>
                  <td ><?php echo $this->Html->link($this->Html->image('images/Job_Preview_Icon.png'),
					  							array('controller'=>'employers','action'=>'jobdetail',$joblist['JobPosting']['posting_id']),
												array('escape' => false,'title' =>'Preview','alt' =>'Preview'));?> </td>
                  <td ><?php
				$diff = abs(strtotime($joblist['JobPosting']['end_dt']) - strtotime($joblist['JobPosting']['start_dt']));
				$joblist['JobPosting']['end_dt'];
				$joblist['JobPosting']['start_dt'];
				$days = ($diff) / (60 * 60 * 24);
				
				$days2 = (abs(strtotime($joblist['JobPosting']['end_dt']) - strtotime(date('Y-m-d')))) / (60 * 60 * 24);
				
						/* if($days && ($days2 < 61 && $days2>0))
						{
						 echo floor($days2).'&nbsp;&nbsp;Days'.'<br>';
						}else
						{
							echo '<span class="red_message">Expired</span>';
						} */
				
				if($days && (strtotime(date('Y-m-d')) <= strtotime($joblist['JobPosting']['end_dt']))){
					echo floor($days2).'&nbsp;&nbsp;Days'.'<br>';
				}else{
					echo '<span class="red_message">Expired</span>';
				}
						  //echo date(DATE_FORMAT,strtotime($joblist['JobPosting']['start_dt']));?>
                  </td>
                  <td ><?php echo $joblist['JobPosting']['location_city'];?>, <?php echo $joblist['JobPosting']['location_state'];?></td>
                  <?php /*?><td><?php echo $this->Html->link($this->Html->image('images/matching_icon.png'),
					  				array('controller'=>'employers','action'=>'jobmatching',$joblist['JobPosting']['posting_id']),
																	array('escape' => false,'title' =>'Match','alt' =>'Match'));?> </td><?php */?>
                  <td><input type="hidden" name="data[JobPosting][active][<?php echo $joblist['JobPosting']['posting_id'];?>]" value="0" id="active<?php echo $joblist['JobPosting']['posting_id'];?>_" />
                    <input type="checkbox" name="data[JobPosting][active][<?php echo $joblist['JobPosting']['posting_id'];?>]" value="1" id="active<?php echo $joblist['JobPosting']['posting_id'];?>"<?php if($joblist['JobPosting']['active']){?> checked="checked" <?php }?>/>
                  </td>
                  <td><select name="data[JobPosting][action][<?php echo $joblist['JobPosting']['posting_id'];?>]" style="width: 77px;">
                      <option value="">Select&nbsp;</option>
                      <option value="refresh">Refresh</option>
                      <option value="delete">Delete&nbsp;</option>
                    </select>
                  </td>
                </tr>
                <?php 
				$i=$i+1;
				endforeach;
				?>
              </tbody>
            </table>
            <?php 
            else: 
				?>
                 <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="table_row" width="100%" colspan="7"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="8">No Jobs Found</td>
                      </tr>
                    </table></td>
                </tr>
                 </table>
                <?php endif;?>
          	 <?php if(count($joblists)>0) { ?>
            <div class="man_resume_footer joblist_submit">
             <ul>
                <li class="last"> <?php echo $this->Form->Submit("images/submit_btn.jpg",array('div'=>false,'name'=>'Submit','onclick'=>'return confirmfrmSubmit()'));?> </li>
              </ul>
              <div class="clear"></div>
            </div>
            <?php } ?>
            <?php if($this->Paginator->numbers()):?>
            <br />
            <div class="pager_panel">
              <div class="pager">
                <div class="paging"> 
				
				<?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                  <?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;&nbsp;'));?>
                  <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
                
                </div>
                <div class="clear"></div>
              </div>
            </div>
            <br />
            <?php endif;?>
            </td>
          </div>
          <?php echo $this->Form->end()?> <br />
        </div>
      </div>
    </div>
    
    
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?>
  </div>
</div>


