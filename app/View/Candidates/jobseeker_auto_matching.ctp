<script type="text/javascript">
$(function(){
$(".pager").css({ 'word-wrap': 'break-word' });
});
</script>

<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Auto Matching</h1>
          <div class="content">
            <div class="content"> <?php echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
              <?php if($this->Paginator->numbers()){ ?>
              <div class="pager">
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
              </div>
              <?php }?>
              <br />
              <p class="smalltext">Click on a column heading to sort</p>
               <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                	<tr class="tableHead">
                        <th width="77"><?php echo $this->Paginator->sort('JobPosting.job_title','Job Title'); ?> </th>
                        <th width="97"><?php echo $this->Paginator->sort('JobPosting.work_type_code','Type of Work'); ?></th>
                        <th width="97"><?php echo $this->Paginator->sort('Employer.employer_name','Company Name'); ?></th>
                        <th width="77"><?php echo $this->Paginator->sort('JobPosting.start_dt','Date Posted'); ?></th>
                      </tr>
                 </thead>
               <tbody>
                <?php
				$i=1;
				if($jobLists)
				{
				 foreach($jobLists as $key=>$value){?>
                <tr  class="tablebody2 border_bottom">
                    	<td  width="77" style="text-align:left"><strong> <?php echo $this->Html->link($value['JobPosting']['job_title'],
													array('controller'=>'candidates','action'=>'jobDetails/'.$value['JobPosting']['posting_id']),
													array('escape'=>false)); 
								?> </strong> <br />
                          <?php  echo $common->getWorkLocation($value['JobPosting']['work_location_code']); ?>
                        </td>
                        <td  width="97" class="normalfont" style="text-align:left"><strong>
                          <?php  echo $common->getWorkTypeCode($value['JobPosting']['work_type_code']); ?>
                          </strong> </td>
                        <td  width="97" class="normalfont" style="text-align:left"><strong> <?php echo $value['Employer']['employer_name']; ?></strong></strong> </td>
                        <td  width="77" class="last normalfont" style="text-align:left"><strong> <?php echo date(DATE_FORMAT,strtotime($value['JobPosting']['start_dt'])); ?> </strong> </td>
                     
                </tr>
                <tr>
                  <td class="table_row border_bottom alternate" colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="5" class="last" style="text-align:left"><p><?php echo $value['JobPosting']['short_descr'] ?> </p>
                          
                          <p><strong>Salary: </strong><?php echo $common->getSalaryType($value['JobPosting']['salary_type_code']) ?></p>
                          <p><strong>Security clearance required:</strong> <?php echo $common->getSecurityClearanceValue($value['JobPosting']['security_clearance_code']) ?></p>
                          <ul class="footer_btn">
                            <li>
                              <?php
                     echo $this->Html->link($this->Html->image('images/viewjob_detail.png'),array('controller'=>'candidates','action'=>'jobDetails/'.$value['JobPosting']['posting_id']),array('escape'=>false,'target'=>'_blank')); ?>
                            </li>
                            <li> <?php echo $this->Html->link($this->Html->image('images/applytojob.jpg'),array('controller'=>'candidates','action'=>'Jobseeker_jobApply?jobId='.$value['JobPosting']['posting_id']),array('escape'=>false,'target'=>'_blank')); ?> </li>
                            <li> <?php echo $this->Html->link($this->Html->image('images/emailto_friend.jpg'),array('controller'=>'candidates','action'=>'sendEmailToFriend/?jobId='.$value['JobPosting']['posting_id']),array('escape'=>false,'target'=>'_blank')); ?> </li>
                          </ul></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td class="whiteBg" colspan="4"></td>
                </tr>
                <tr>
                  <td class="whiteBg" colspan="4"></td>
                </tr>
                <tr>
                  <td class="whiteBg" colspan="4"></td>
                </tr>
                <?php 
				$i=$i+1;
				} }else
				{
				?>
                <tr>
                  <td align="center" valign="middle" height="40px;" style="color:#003300" colspan="4"><strong> No jobs for you</strong> </td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
              <br />
              <?php if($this->Paginator->numbers()){ ?>
              <div class="pager">
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
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
