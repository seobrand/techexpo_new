      <?php 	$firstSting = $this->Session->read('searchKeyword');   ?>
      <?php $all_words = explode(" ",$firstSting);?>
                <style> 
				.highlight { background-color: yellow }
				</style> 
          <script type="text/javascript" >
		  $(document).ready(function() {
		  
		$('.applyjobs').click(function(){
				alert('You must be logged in to perform this action');
			});
			
					
		$('.emailtofriends').click(function(){
				alert('You must be logged in to perform this action');
			});
			
		
			});
		  
		  
		  <?php if(isset($firstSting)) { ?>
		  $(document).ready(function() {
			 
		$('.keywordHighlight').highlight('<?php echo $firstSting; ?>');
		
		<?php foreach($all_words as $words){?>
		$('.keywordHighlight').highlight('<?php echo $words; ?>');
		<?php }?>
	
			
		
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
         
       
<div id="wrapper">  <?php 
	// pr($employerDetail);
	 
	if($this->Session->read('Auth.Client.Candidate.id')!='')
	{
		echo $this->element('jobSeekerMenu', array('cache' => true));
	}
	
	if($this->Session->read('Auth.Client.employerContact.id')!='')
	{
		 echo $this->element('employer_tabs');
	}
 ?>
  <div id="container"> <?php //echo $this->element('front_innerpage_siderbar', array('cache' => true)); ?>
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Job posting Details</h1>
          <div class="content">
            <ul class="footer_btn notoppadding" style="margin-left:10px;">
             <?php if($nextJobId){ ?>
              <li class="paddingzero"> 
              <?php echo $this->Html->link($this->Html->image('images/next_job.jpg'),array('controller'=>'candidates','action'=>'jobDetail/'.$nextJobId),array('escape'=>false)); ?>
             </li>
             <?php } ?>
              <li class="paddingzero"> 
              <?php echo $this->Html->link($this->Html->image('images/bk_search.jpg'),array('controller'=>'candidates','action'=>'searchJob/?'.$backtoSearchPage),array('escape'=>false)); ?>
               </li>
              <li class="paddingzero"> 
               <?php echo $this->Html->link($this->Html->image('images/new_search_btn.jpg'),array('controller'=>'candidates','action'=>'searchJob'),array('escape'=>false)); ?>
               </li>
            </ul>
            
            <ul class="footer_btn notoppadding" style="margin-left:10px;">
				<?php if($previousJobId){ ?>
                 <li class="paddingzero"> 
                  <?php echo $this->Html->link($this->Html->image('images/prev.jpg'),array('controller'=>'candidates','action'=>'jobDetail/'.$previousJobId),array('escape'=>false)); 			
                    ?>
                 </li>
                <?php } ?>
            </ul>
            
            
            <br /><br /> <br /><br /> 
            <table width="100%">
            	<tr>
                
                	<td width="70%">
                   <h2 class="mana_subheading" style="font-size:18px;"> <?php echo $jobPostingDetail['Employer']['employer_name'];?></h2>
                  
              <?php echo $jobPostingDetail['JobPosting']['job_title'];?>
                  
                    
                    </td>
                    <td width="28%" align="right"> <?php if($jobPostingDetail['Employer']['logo_file']!=""){?>
	              	<img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$jobPostingDetail['Employer']['logo_file'];?>&maxw=200&maxh=80"  alt="<?php echo $jobPostingDetail['Employer']['employer_name']; ?>"  title="<?php echo $jobPostingDetail['Employer']['employer_name']; ?>"/>
	          	 <?php }?></td>
                 <td width="2%"></td>
                </tr>
            
            </table>
            
            <div class="clear"></div>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid keywordHighlight">
              <ul class="footer_btn notoppadding">
                <li class="paddingzero"> 
               		<?php
					 if($this->Session->read('Auth.Client.Candidate.id')!=''){
							 
							 if($jobPostingDetail['JobPosting']['address_type']=='w')
							 {
								echo $this->Html->link($this->Html->image('images/applytojob.jpg'),$jobPostingDetail['JobPosting']['job_email'],array('escape'=>false,'target'=>'_blank'));			 							 }
							 else
							 {
								echo $this->Html->link($this->Html->image('images/applytojob.jpg'),array('controller'=>'candidates','action'=>'Jobseeker_jobApply?jobId='.$jobPostingDetail['JobPosting']['posting_id']),array('escape'=>false)); 
							 }
					  }else{
					 
					  echo $this->Html->link($this->Html->image('images/applytojob.jpg',array('class'=>'applyjobs')),array('Jobseeker'=>false,'controller'=>'users','action'=>'login'),array('escape'=>false,'target'=>'_blank'));
					 } ?>
                    
                    
                    
                     
                 </li>
                <li class="paddingzero">   
                             
                 <?php 
				  if($this->Session->read('Auth.Client.Candidate.id')!=''){
				  
				 echo $this->Html->link($this->Html->image('images/emailto_friend.jpg'),array('controller'=>'candidates','action'=>'sendEmailToFriend/?jobId='.$jobPostingDetail['JobPosting']['posting_id']),array('escape'=>false));
				 }else{
					 
					  echo $this->Html->link($this->Html->image('images/emailto_friend.jpg',array('class'=>'emailtofriends')),array('controller'=>'users','action'=>'login'),array('escape'=>false,'target'=>'_blank'));
					 } 
				 
				  ?>
                 
                </li>
              </ul>
              <div class="clear"></div>
           
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
                    <label><a style="color:#013DB9" href="<?php echo FULL_BASE_URL?>/Jobseeker/candidates/employeDetail/<?php echo $jobPostingDetail['Employer']['id']?>" target="_blank"><?php echo $jobPostingDetail['Employer']['employer_name']; ?></a></label>
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
                <?php /*?><li>
                  <label>Security clearance required: </label>
                  <div class="form_rt_col1">
                    <label><?php echo $jobPostingDetail['JobPosting']['security_clearance_code']; ?></label>
                    <br />
                  </div>
                </li><?php */?>
                
                <?php $close2= false; 
				if(isset($jobPostingDetail['JobPosting']['security_clearance_code']))
				{
				$securityClearanceCode =explode(',',$jobPostingDetail['JobPosting']['security_clearance_code']);
				if(isset($securityClearanceCode) && (count($securityClearanceCode) > 0)) { 
				 foreach($securityClearanceCode as $key => $securityClearanceCodeID){ 
				 $securityClearancecodeVal =  $common->getSecurityClearanceValue($securityClearanceCodeID);
				if(!empty($securityClearancecodeVal)) {
				if(!$close2) {
				?> 
				<li>
				<label>Security clearance required: </label>
				<div class="form_rt_col1">
				 <?php $close2= true; } ?>
				<label>
				
				<?php
				echo $securityClearancecodeVal;
				 if(count($securityClearanceCode)!=($key+1)){ echo ","; }// end if ?>					
				
				</label>
				<br />
				<?php }  ?>
				<?php  }  ?>
				<?php if($close2) { ?>
				</div>
				</li>
				<?php  } ?>
				<?php } 
				}
				?>
                
              </ul>
              <div class="preview_panel">
                <h2 class="mana_subheading">Full Description</h2>
                
                 <?php  echo nl2br(iconv("", "UTF-8//IGNORE", $jobPostingDetail['JobPosting']['full_descr']));  ?> 
                <?php // echo nl2br($jobPostingDetail['JobPosting']['full_descr']); ?> 
                
                </div>
              <br />
             
               		<?php 
					 if($this->Session->read('Auth.Client.Candidate.id')!=''){
							 if($jobPostingDetail['JobPosting']['address_type']=='w')
							 {
								echo $this->Html->link($this->Html->image('images/applytojob.jpg'),$jobPostingDetail['JobPosting']['job_email'],array('escape'=>false,'target'=>'_blank'));			 							 }
							 else
							 {
								echo $this->Html->link($this->Html->image('images/applytojob.jpg'),array('controller'=>'candidates','action'=>'Jobseeker_jobApply?jobId='.$jobPostingDetail['JobPosting']['posting_id']),array('escape'=>false)); 
							 }
					
					}else{
					 
					  echo $this->Html->link($this->Html->image('images/applytojob.jpg',array('class'=>'applyjobs')),array('Jobseeker'=>false,'controller'=>'users','action'=>'login'),array('escape'=>false,'target'=>'_blank'));
					 } ?>
					
                      &nbsp;         
                 <?php 
				  if($this->Session->read('Auth.Client.Candidate.id')!=''){
					  
				 echo $this->Html->link($this->Html->image('images/emailto_friend.jpg'),array('controller'=>'candidates','action'=>'sendEmailToFriend/?jobId='.$jobPostingDetail['JobPosting']['posting_id']),array('escape'=>false));
				 
				 
				 }else{
					 
					  echo $this->Html->link($this->Html->image('images/emailto_friend.jpg',array('class'=>'emailtofriends')),array('controller'=>'users','action'=>'login'),array('escape'=>false,'target'=>'_blank'));
					 } 
				 
				  ?>
				  
                
              <div class="clear"></div>
            </div>
                <ul class="footer_btn" style="margin:10px 0 0 12px;">
             <?php if($nextJobId){ ?>
              <li class="paddingzero"> 
              <?php echo $this->Html->link($this->Html->image('images/next_job.jpg'),array('controller'=>'candidates','action'=>'jobDetail/'.$nextJobId),array('escape'=>false)); ?>
             </li>
             <?php } ?>
              <li class="paddingzero"> 
              <?php echo $this->Html->link($this->Html->image('images/bk_search.jpg'),array('controller'=>'candidates','action'=>'searchJob/?'.$backtoSearchPage),array('escape'=>false)); ?>
               </li>
              <li class="paddingzero"> 
               <?php echo $this->Html->link($this->Html->image('images/new_search_btn.jpg'),array('controller'=>'candidates','action'=>'searchJob'),array('escape'=>false)); ?>
               </li>
            </ul>
            
            <ul class="footer_btn notoppadding" style="margin-left:10px;">
				<?php if($previousJobId){ ?>
                 <li class="paddingzero"> 
                  <?php echo $this->Html->link($this->Html->image('images/prev.jpg'),array('controller'=>'candidates','action'=>'jobDetail/'.$previousJobId),array('escape'=>false)); 			
                    ?>
                 </li>
                <?php } ?>
            </ul>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
    <div class="clear"></div>
   
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>