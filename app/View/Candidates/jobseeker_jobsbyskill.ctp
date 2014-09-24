<script type="text/javascript">
$(function(){

$(".paging b:nth-child(22)").append("<br/>");
$(".paging b:nth-child(41)").append("<br/>");
$(".paging b:nth-child(60)").append("<br/>");
$(".paging b:nth-child(79)").append("<br/>");
$(".paging b:nth-child(98)").append("<br/>");
$(".paging b:nth-child(114)").append("<br/>");
$(".paging b:nth-child(129)").append("<br/>");
$(".paging b:nth-child(144)").append("<br/>");
$(".paging b:nth-child(159)").append("<br/>");
$(".paging b:nth-child(174)").append("<br/>");
$(".paging b:nth-child(189)").append("<br/>");
$(".paging b:nth-child(204)").append("<br/>");
$(".paging b:nth-child(219)").append("<br/>");
$(".paging b:nth-child(234)").append("<br/>");
$(".paging b:nth-child(249)").append("<br/>");
$(".paging b:nth-child(264)").append("<br/>");
$(".paging b:nth-child(279)").append("<br/>");
$(".paging b:nth-child(294)").append("<br/>");
$(".paging b:nth-child(309)").append("<br/>");
$(".paging b:nth-child(324)").append("<br/>");
$(".paging b:nth-child(339)").append("<br/>");

$(".paging b:nth-child(354)").append("<br/>");
$(".paging b:nth-child(369)").append("<br/>");
$(".paging b:nth-child(384)").append("<br/>");
$(".paging b:nth-child(399)").append("<br/>");
$(".paging b:nth-child(414)").append("<br/>");
$(".paging b:nth-child(429)").append("<br/>");
$(".paging b:nth-child(444)").append("<br/>");
$(".paging b:nth-child(459)").append("<br/>");
$(".paging b:nth-child(474)").append("<br/>");

$(".paging b:nth-child(489)").append("<br/>");
$(".paging b:nth-child(504)").append("<br/>");
$(".paging b:nth-child(519)").append("<br/>");
$(".paging b:nth-child(534)").append("<br/>");
$(".paging b:nth-child(549)").append("<br/>");
$(".paging b:nth-child(565)").append("<br/>");
$(".paging b:nth-child(580)").append("<br/>");
$(".paging b:nth-child(595)").append("<br/>");

$(".paging b:nth-child(610)").append("<br/>");
$(".paging b:nth-child(625)").append("<br/>");
$(".paging b:nth-child(640)").append("<br/>");
$(".paging b:nth-child(655)").append("<br/>");
$(".paging b:nth-child(670)").append("<br/>");

$(".paging b:nth-child(685)").append("<br/>");
$(".paging b:nth-child(700)").append("<br/>");
$(".paging b:nth-child(715)").append("<br/>");
$(".paging b:nth-child(730)").append("<br/>");
$(".paging b:nth-child(745)").append("<br/>");
$(".paging b:nth-child(760)").append("<br/>");
$(".paging b:nth-child(775)").append("<br/>");
$(".paging b:nth-child(790)").append("<br/>");
$(".paging b:nth-child(805)").append("<br/>");

$(".paging b:nth-child(825)").append("<br/>");
$(".paging b:nth-child(840)").append("<br/>");
$(".paging b:nth-child(855)").append("<br/>");
$(".paging b:nth-child(870)").append("<br/>");
$(".paging b:nth-child(885)").append("<br/>");
$(".paging b:nth-child(900)").append("<br/>");
$(".paging b:nth-child(915)").append("<br/>");
$(".paging b:nth-child(930)").append("<br/>");
$(".paging b:nth-child(945)").append("<br/>");
$(".paging b:nth-child(960)").append("<br/>");
$(".paging b:nth-child(975)").append("<br/>");

$(".paging b:nth-child(990)").append("<br/>");
$(".paging b:nth-child(1003)").append("<br/>");
$(".paging b:nth-child(1015)").append("<br/>");



});
</script>
<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Search Jobs List By skills</h1>                    
          <?php if($totalJobs>0){?>          
          <div class="content">
           <?php echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
            <br />
            <br />
            <div class="pager" style="height:30px;"><div style="float:left"><?php echo $totalJobs;?> recent jobs matching </div> 
			<div style="float:right;margin-right:20px;width:190px;">
			<?php echo $this->element('seeker-paging');?></div></div>
            
            <br />
            <div class="pager_panel">
            <?php if($totalJobs>10){?>
              <div class="pager">
                <div class="paging"><?php echo $this->Paginator->numbers(array('modulus'=>PHP_INT_MAX,'separator'=>'&nbsp;</b>|<b>&nbsp;')); ?>&nbsp;</b>|<b>&nbsp; </div>
               <div class="clear"></div>
              </div>
              <?php }?>
            </div>
            <br />
            <p class="smalltext">Click on a column heading to sort by that criterion</p>
            <?php foreach($jobLists as  $key=>$value){ ?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="77" style="text-align:left"> <?php echo $this->Paginator->sort('JobPosting.job_title','Job Title'); ?> </th>
                      <th width="47" style="text-align:left"> <strong> <?php echo $this->Paginator->sort('JobPosting.job_title','Score'); ?></strong> </th>
                      <th width="67" style="text-align:left"> <strong><?php echo $this->Paginator->sort('JobPosting.work_location_code','Location'); ?> </strong> </th>
                      <th width="97" style="text-align:left"> <strong><?php echo $this->Paginator->sort('JobPosting.work_type_code','Type of Work'); ?> </strong> </th>
                      <th width="97" style="text-align:left"> <strong><?php echo $this->Paginator->sort('Employer.employer_name','Job Title'); ?> </strong> </th>
                      <th width="77" style="text-align:left"> <strong><?php echo $this->Paginator->sort('JobPosting.start_dt','Date Posted'); ?> </strong> </th>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="whiteBg"></td>
              </tr>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="77" style="text-align:left"><strong> <?php echo $this->Html->link($value['JobPosting']['job_title'],array('controller'=>'candidates','action'=>'jobDetail?jobId='.$value['JobPosting']['posting_id'].'&'.$queryString),array('escape'=>false)); ?> </strong></td>
                      <td  width="47" class="normalfont" style="text-align:left"><strong>
                       <!-- <?php  echo $common->getWorkLocation($value['JobPosting']['work_location_code']); ?>-->NA
                        </strong></td>
                      <td  width="67" class="normalfont" style="text-align:left"><strong>
                        <?php  echo $common->getWorkLocation($value['JobPosting']['work_location_code']); ?>
                        </strong> </td>
                      <td  width="97" class="normalfont" style="text-align:left"><strong>
                        <?php  echo $common->getWorkTypeCode($value['JobPosting']['work_type_code']); ?>
                        </strong> </td>
                      <td  width="97" class="normalfont" style="text-align:left"><strong> <?php echo $value['Employer']['employer_name']; ?></strong></strong> </td>
                      <td  width="77" class="last normalfont" style="text-align:left"><strong> <?php echo $value['JobPosting']['start_dt'] ?> </strong> </td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="table_row border_bottom alternate"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="5" class="last" style="text-align:left"><p><?php echo $value['JobPosting']['short_descr'] ?> </p>
                        <p><strong>Critical skills: -</strong>
                          <?php 
foreach($value['JobPostingSkill'] as $key1=>$value1)
{
	echo $common->getSkillName($value1['skill_id']).' , ';
}
?>
                        </p>
                        <p><strong>Salary: </strong><?php echo $common->getSalaryType($value['JobPosting']['salary_type_code']) ?></p>
                        <p><strong>Security clearance required:</strong> <?php echo $common->getSecurityClearanceValue($value['JobPosting']['security_clearance_code']) ?></p>
                        <ul class="footer_btn">
                          <li>
                            <?php
                     echo $this->Html->link($this->Html->image('images/viewjob_detail.jpg'),array('controller'=>'candidates','action'=>'jobDetail/?jobId='.$value['JobPosting']['posting_id'].'&'.$queryString),array('escape'=>false,'target'=>'_blank')); ?>
                          </li>
                          <li> <?php echo $this->Html->link($this->Html->image('images/applytojob.jpg'),array('controller'=>'candidates','action'=>'Jobseeker_jobApply?jobId='.$value['JobPosting']['posting_id']),array('escape'=>false,'target'=>'_blank')); ?> </li>
                          <li> <?php echo $this->Html->link($this->Html->image('images/emailto_friend.jpg'),array('controller'=>'candidates','action'=>'sendEmailToFriend/?jobId='.$value['JobPosting']['posting_id']),array('escape'=>false,'target'=>'_blank')); ?> </li>
                        </ul></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="whiteBg"></td>
              </tr>             
            </table>
            <?php } ?>            
           </div>
          <?php
            }else{?>
            
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="77" style="text-align:left">Job Title</th>
                      <th width="47" style="text-align:left"> Score </th>
                      <th width="67" style="text-align:left"> Location</th>
                      <th width="97" style="text-align:left"> Type of Work</th>
                      <th width="97" style="text-align:left"> Job Title</th>
                      <th width="77" style="text-align:left"> Date Posted</th>
                    </tr>
                  </table></td>
              </tr>  
              <tr>
              <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="6" align="center">No Jobs Found of this skill</td>
                      
                    </tr>
                  </table></td> 
             </tr>
             </table>         	
         <?php }           
          ?>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>