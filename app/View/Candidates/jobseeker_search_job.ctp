<?php 	$firstSting = $this->Session->read('searchKeyword');   ?>
<?php $all_words = explode(" ",$firstSting);?>

      
                <style> 
				.highlight { background-color: yellow }
				</style> 
          <script type="text/javascript" >
		  
		  <?php if(isset($firstSting)) { ?>
		  $(document).ready(function() {
			 
		$('.keywordHighlight').highlight('<?php echo $firstSting; ?>');

		<?php foreach($all_words as $words){?>
		$('.keywordHighlight').highlight('<?php echo $words; ?>');
		<?php }?>
		
		
			$('.applyjobs').click(function(){
				alert('You must be logged in to perform this action');
			});
			
			$('.emailtofriends').click(function(){
				alert('You must be logged in to perform this action');
			});
		
			});
			
		<?php } ?>	
			jQuery.fn.highlight = function(pat) {
			
 function innerHighlight(node, pat) {
  var skip = 0;
  if (node.nodeType == 3) {
   var pos = node.data.toUpperCase().indexOf(pat);
   if (pos >= 0) {
    var spannode = document.createElement('span');
    spannode.className = 'highlight';
    var middlebit = node.splitText(pos);
    var endbit = middlebit.splitText(pat.length);
    var middleclone = middlebit.cloneNode(true);
    spannode.appendChild(middleclone);
    middlebit.parentNode.replaceChild(spannode, middlebit);
    skip = 1;
   }
  }
  else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
   for (var i = 0; i < node.childNodes.length; ++i) {
    i += innerHighlight(node.childNodes[i], pat);
   }
  }
  return skip;
 }
 return this.length && pat && pat.length ? this.each(function() {
  innerHighlight(this, pat.toUpperCase());
 }) : this;
};

jQuery.fn.removeHighlight = function() {
 return this.find("span.highlight").each(function() {
  this.parentNode.firstChild.nodeName;
  with (this.parentNode) {
   replaceChild(this.firstChild, this);
   normalize();
  }
 }).end();
};// JavaScript Document
		 </script>     

<?php 
echo $this->element('ajax', array('cache' => true));
?>
<script type="text/javascript">
   <?php
  	 if($searchresult)
	  {
	 ?>	
	$(document).ready(function()
	{
	 window.scrollTo(0, 850);
	});
	<?php } ?>
$(function(){
$(".pager").css({ 'word-wrap': 'break-word' });
});
</script>
<div id="wrapper">
 <?php 
	if($this->Session->read('Auth.Client.Candidate.id')!='')
	{
		echo $this->element('jobSeekerMenu', array('cache' => true));
	}
	?>


  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
         
         
          <h1 class="bluecolor">Search Jobs</h1>
          <div class="content"> <?php // echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid"> <?php echo $this->Form->create('Candidates',array('action'=>'','type'=>'GET','onsubmit'=>'return checkFormBlank(this)'));?>
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Keywords:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('keyword',array('class'=>'small_Texfield','div'=>false,'label'=>false,'style'=>'font-size: 12px;')); ?>
                    <div class="even_reg_dropdown float_left" style="width:177px!important;">
                      <?php 
                        $option=array('All'=>'All Words','Exact'=>'Exact Phrase','Any'=>'Any Words');
                         echo $this->Form->input('JobPosting.matching',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                    </div>
                  </div>
                </li>
                <li>
                  <label>Work Type:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown">
                      <?php  
                         echo $this->Form->input('JobPosting.work_type_code',array('type'=>'select','options'=>$WorkTypeList,'empty'=>'-Either-','label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                    </div>
                  </div>
                </li>
                <li>
                  <label>Location:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown">
                      <?php  
                         echo $this->Form->input('JobPosting.work_location_code',array('type'=>'select','options'=>$WorkLocationList,'empty'=>'-Select Location-','label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                    </div>
                  </div>
                </li>
                <li>
                  <label><span class="red"></span>State/Province:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown">
                      <?php 
					    echo $this->Form->input('JobPosting.location_state',array('type'=>'select','options'=>$statList,'empty'=>'-Select State-','label'=>false,'class'=>'select1','div'=>'','style'=>'font-size: 12px;'));
                        ?>
                    </div>
                  </div>
                </li>
                <li>
                  <label>Hours:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown">
                      <?php  
                         echo $this->Form->input('JobPosting.work_time_code',array('type'=>'select','options'=>$WorkTimeList,'empty'=>'-Select Hours-','label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                    </div>
                  </div>
                </li>
                <li>
                  <label>Security Clearance:</label>
                  <div class="form_rt_col1">
                    <div class="checkbox_div checkbox_large_div"  style="height:100px">
                      <div class="checkbox_list" style="height:100px">
                        <?php 
							 echo $this->Form->input('JobPosting.security_clearance_code',array('type'=>'select','multiple'=>'checkbox','options'=>$GovCleareanceList,'label'=>false,'div'=>false,'hiddenField' => false)); 
						   ?>
                      </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </li>
                <li>
                  <label>Search for a specific company:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.employer_name',array('class'=>'small_Texfield','div'=>false,'label'=>false,'style'=>'font-size: 12px;')); ?> </div>
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->submit('images/grey_submit.jpg');?> </div>
                </li>
              </ul>
              <?php echo  $this->Form->end(); ?> </div>
          </div><br />
         
          <?php
            
             if(!empty($this->request->query['matching'])) {
              if(count($jobLists)) {
             ?>
          <div id="contentresult" style="clear:both">
           
          </div>
          <h1 class="bluecolor">Search Results</h1>
          <div class="content"> <br />
            <br />
            <div class="pager" style="height:30px;">
              <div style="float:left"><?php echo $totalJobs;?> recent jobs matching </div>
              <div style="float:right;margin-right:20px;width:190px;"> <?php echo $this->element('seeker-paging');?></div>
            </div>
            <br />
            <?php if($this->Paginator->numbers()){ ?>
            <div class="pager_panel">
              <div class="pager">
                <div class="paging"> <?php //echo $this->Paginator->numbers(array('modulus'=>PHP_INT_MAX,'separator'=>'&nbsp;</b>|<b>&nbsp;')); ?>
                
                 <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
                  <?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;&nbsp;'));?>
                  <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
                  
                </div>
                <div class="clear"></div>
              </div>
            </div>
            <?php } ?>
            <br />
            <p class="smalltext">Click on a column heading to sort</p>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                	<tr class="tableHead">
                      <th width="215"> <?php echo $this->Paginator->sort('JobPosting.job_title','Job Title'); ?> </th>
                      <th width="100" colspan="2"> <strong><?php echo $this->Paginator->sort('JobPosting.work_location_code','Location '); ?><br/>Type of Work </strong> </th>
                   <?php /*   <th width="97"> <strong><?php echo $this->Paginator->sort('JobPosting.work_type_code','Type of Work'); ?> </strong> </th> */ ?>
                      <th width="100" colspan="2"> <strong><?php echo $this->Paginator->sort('Employer.employer_name','Company Name'); ?><br/>Date Posted </strong> </th>
                   <?php /*   <th width="77"> <strong><?php echo $this->Paginator->sort('JobPosting.start_dt','Date Posted'); ?> </strong> </th>*/ ?>
                   </tr>
              	</thead>
                
              <tr>
                <td class="whiteBg" colspan="5"></td>
              </tr>
              <tbody>
              <?php foreach($jobLists as  $key=>$value){ ?>
              <tr  class="tablebody2 border_bottom">
                      <td  width="215" style="text-align:left"><strong> <?php echo $this->Html->link($value['JobPosting']['job_title'],
													array('controller'=>'candidates','action'=>'jobDetail?jobId='.$value['JobPosting']['posting_id']),
													array('escape'=>false)); 
								?> </strong></td>
                      <td  width="100" class="normalfont" colspan="2" style="text-align:left"><strong>
                      	<?php echo $value['JobPosting']['location_city'].",".$value['JobPosting']['location_state'].'<br/>';?>
                        <?php  echo $common->getWorkLocation($value['JobPosting']['work_location_code']).'<br/>'.$common->getWorkTypeCode($value['JobPosting']['work_type_code']); ?>
                        </strong> </td>
                  <?php /*    <td  width="97" class="normalfont" style="text-align:left"><strong>
                        <?php  echo $common->getWorkTypeCode($value['JobPosting']['work_type_code']); ?>
                        </strong> </td> */ ?>
                      <td  width="97" class="normalfont" colspan="2" style="text-align:left"><strong> <?php echo $value['Employer']['employer_name'].'<br/>'.date(DATE_FORMAT,strtotime($value['JobPosting']['start_dt'])); ?></strong></strong> </td>
                  <?php /*     <td  width="77" class="last normalfont" style="text-align:left"><strong> <?php echo date(DATE_FORMAT,strtotime($value['JobPosting']['start_dt'])); ?> </strong> </td> */ ?>
                    
              </tr>
              <tr>
                <td class="table_row border_bottom alternate" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="5" class="last keywordHighlight" style="text-align:left"><p><?php echo $value['JobPosting']['short_descr'] ?> </p>
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
                     echo $this->Html->link($this->Html->image('images/viewjob_detail.png'),array('controller'=>'candidates','action'=>'jobDetail/?jobId='.$value['JobPosting']['posting_id']),array('escape'=>false)); ?>
                          </li>
                          <li> 
						 <?php 
						 if($this->Session->read('Auth.Client.Candidate.id')!=''){
							
						 
							  if($value['JobPosting']['address_type']=='w')
								 {
									echo $this->Html->link($this->Html->image('images/applytojob.jpg'),$value['JobPosting']['job_email'],array('escape'=>false,'target'=>'_blank'));			 							 }
								 else
								 {
									echo $this->Html->link($this->Html->image('images/applytojob.jpg'),array('controller'=>'candidates','action'=>'Jobseeker_jobApply?jobId='.$value['JobPosting']['posting_id']),array('escape'=>false)); 
								 }
						 
						  }else{
						 echo $this->Html->link($this->Html->image('images/applytojob.png',array('class'=>'applyjobs')),array('controller'=>'users','action'=>'login','Jobseeker'=>false),array('escape'=>false,'target'=>'_blank'));
						 
						 } ?> </li>
                          <li>
                           <?php
						   if($this->Session->read('Auth.Client.Candidate.id')!=''){
						    echo $this->Html->link($this->Html->image('images/emailto_friend.png'),array('controller'=>'candidates','action'=>'sendEmailToFriend/?jobId='.$value['JobPosting']['posting_id']),array('escape'=>false)); }else{
							
							 echo $this->Html->link($this->Html->image('images/emailto_friend.png',array('class'=>'emailtofriends')),array('controller'=>'users','action'=>'login','Jobseeker'=>false),array('escape'=>false,'target'=>'_blank'));
							 
							}?>
                          
                          
                          
                           </li>
                        </ul></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="whiteBg" colspan="5"></td>
              </tr>
              <tr>
                <td class="whiteBg"  colspan="5"></td>
              </tr>
              <tr>
                <td class="whiteBg"  colspan="5"></td>
              </tr>
              <?php } ?>
               </tbody>
            </table>
            <?php if($this->Paginator->numbers()){ ?>
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
            <?php } ?>
            <div style="clear:both;width:630px;overflow:hidden;border-right:1px;"> </div>
          </div>
          <?php
            }
             else
            {
			?>
            <div class="content">
          <h4 class="bluecolor"> &nbsp;Latest Related Jobs</h4>
          <br />
          <?php if($totalJobs==0){?>
          <table width="100%">
            <tr>
              <td align="center">
              <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr class="tableHead">
                      <th width="77"><?php echo $this->Paginator->sort('JobPosting.job_title','Job Title'); ?> </th>
                      <th width="67"><?php echo $this->Paginator->sort('JobPosting.work_location_code','Location'); ?></th>
                      <th width="97"><?php echo $this->Paginator->sort('JobPosting.work_type_code','Type of Work'); ?></th>
                      <th width="97"><?php echo $this->Paginator->sort('Employer.employer_name','Employee Name'); ?></th>
                      <th width="77"><?php echo $this->Paginator->sort('JobPosting.start_dt','Date Posted'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($relatedjobs_count>0){?>
                    <?php foreach($relatedjobs as $relatedJob){?>
                    <tr  class="tablebody2 border_bottom">
                      <td  width="77" style="text-align:left"><strong> <?php echo $this->Html->link($relatedJob['JobPosting']['job_title'],
                                                        array('controller'=>'candidates','action'=>'jobDetails/'.$relatedJob['JobPosting']['posting_id']),
                                                        array('escape'=>false)); 
                                    ?> </strong></td>
                      <td  width="67" class="normalfont" style="text-align:left"><strong>
                        <?php  echo $common->getWorkLocation($relatedJob['JobPosting']['work_location_code']); ?>
                        </strong> </td>
                      <td  width="97" class="normalfont" style="text-align:left"><strong>
                        <?php  echo $common->getWorkTypeCode($relatedJob['JobPosting']['work_type_code']); ?>
                        </strong> </td>
                      <td  width="97" class="normalfont" style="text-align:left"><strong> <?php echo $relatedJob['Employer']['employer_name']; ?></strong></strong> </td>
                      <td  width="77" class="last normalfont" style="text-align:left"><strong> <?php echo date(DATE_FORMAT,strtotime($relatedJob['JobPosting']['start_dt'])); ?> </strong> </td>
                    </tr>
                    <tr>
                      <td class="table_row border_bottom alternate" colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="5" class="last" style="text-align:left"><p><?php echo $relatedJob['JobPosting']['short_descr'] ?> </p>
                              <!-- <p><strong>Critical skills: -</strong>
                          <?php 
//foreach($value['JobPostingSkill'] as $key1=>$value1)
//{
	//echo $common->getSkillName($value1['skill_id']).' , ';
//}
?>
                        </p>-->
                              <p><strong>Salary: </strong><?php echo $common->getSalaryType($relatedJob['JobPosting']['salary_type_code']) ?></p>
                              <p><strong>Security clearance required:</strong> <?php echo $common->getSecurityClearanceValue($relatedJob['JobPosting']['security_clearance_code']) ?></p>
                              <ul class="footer_btn">
                                <li>
                                
                                  <?php
                     echo $this->Html->link($this->Html->image('images/viewjob_detail.png'),array('controller'=>'candidates','action'=>'jobDetails/'.$relatedJob['JobPosting']['posting_id']),array('escape'=>false,'target'=>'_blank')); ?>
                                </li>
                                <li> <?php echo $this->Html->link($this->Html->image('images/applytojob.png'),array('controller'=>'candidates','action'=>'Jobseeker_jobApply?jobId='.$relatedJob['JobPosting']['posting_id']),array('escape'=>false,'target'=>'_blank')); ?> </li>
                                <li> <?php echo $this->Html->link($this->Html->image('images/emailto_friend.png'),array('controller'=>'candidates','action'=>'sendEmailToFriend/?jobId='.$relatedJob['JobPosting']['posting_id']),array('escape'=>false,'target'=>'_blank')); ?> </li>
                              </ul></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr>
                      <td class="whiteBg"  colspan="5"></td>
                    </tr>
                    <tr>
                      <td class="whiteBg"  colspan="5"></td>
                    </tr>
                    <?php }?>
                    <tr height="40">
                      <td class="whiteBg"  colspan="5"></td>
                    </tr>
                    <?php }else{?>
                    <tr>
                      <td class="table_row border_bottom"  colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td colspan="5" align="center">No active jobs matching for this search criteria added in last 180 days</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr height="40">
                      <td class="whiteBg"  colspan="5"></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
               </td>
            </tr>
          </table>
          <?php }?>
         
         
         </div>  <?php
            
			}
           }else
		   {
		   //		echo '<div style="color:red;margin-left:100px;"><strong>Please Enter a keyword to search your matching job</strong></div>';
		   }
          ?>
        </div>
      </div>
    </div>
    <?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
<script>
function checkFormBlank(docForm){
	var keyword = $.trim($('#CandidatesKeyword').val());
	
	var worktype = $('#JobPostingWorkTypeCode').val();
	var location = $('#JobPostingWorkLocationCode').val();
	var state 	= $('#JobPostingLocationState').val();
	var worktime = $('#JobPostingWorkTimeCode').val();
	var employer = $('#EmployerEmployerName').val();
	
	
	
	
	if(keyword=='' && worktype=='' && location=='' && state=='' && worktime=='' && employer==''){
		alert('Please enter any search criteria for search.');
		return false;
	}	
	return true;
}
</script>