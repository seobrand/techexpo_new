<?php //pr($this->request->data);?>
<div id="wrapper">
              <?php if($this->Session->read('Auth.Client.User.user_type')=='E'):?>
  <?php echo $this->element('employer_tabs');?>
  	<?php endif;?>
    
    <?php
	if($this->Session->read('Auth.Client.Candidate.id')!='')
	{
		echo $this->element('jobSeekerMenu', array('cache' => true));
	}
	 ?>
    
    
  <div id="container">
    <?php // echo $this->element('employer_left_panel'); ?>
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Job Detail</h1>
          
          
          <?php
		$data=$this->request->data;
		   ?>
          
          
         <table width="95%" style="margin:0 20px 0 20px">
            	<tr>
                
                		<td width="70%">
        <h2 class="mana_subheading" style="font-size:18px;"> <?php echo iconv("", "UTF-8//IGNORE", $data['Employer']['employer_name']);?></h2>
                  
             <?php echo iconv("", "UTF-8//IGNORE", $data['JobPosting']['job_title']);?>
                    
                    </td>
                   <td width="28%" align="right"> <?php if($data['Employer']['logo_file']!=""){?>
	              	<img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$data['Employer']['logo_file'];?>&maxw=200&maxh=80"  alt="<?php echo $data['Employer']['employer_name']; ?>"  title="<?php echo $data['Employer']['employer_name']; ?>"/>
                    </td>
                    <td width="2%"></td>
	          	 <?php }?>
                
                </tr>
            
            </table>
          
          
          
          
          <div class="content">
            <div class="clear"></div>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="footer_btn notoppadding">
			  <?php if($this->Session->read('Auth.Client.User.user_type')=='C'):?>
                <li> 
					<?php echo $this->Html->link($this->Html->image('images/applytojob.jpg'),array('controller'=>'Jobseeker','action'=>'candidates/jobApply?jobId='.$this->request->data['JobPosting']['posting_id']),array('escape'=>false)); ?>
               </li>
				<?php endif;?>
                <?php $userId = $this->Session->read('Auth.Client.User.id');   
				if(!isset($userId) || $userId==''){ ?>
                <li> 
					<?php echo $this->Html->link($this->Html->image('images/applytojob.jpg'),array('controller'=>'users','action'=>'login'),array('escape'=>false)); ?>
               </li>
				<?php  } ?>
                <?php // task id 3284 ?>
                  <?php //if($this->Session->read('Auth.Client.User.user_type')=='E'):?>
                <li> 
                  <?php echo $this->Html->image("images/emailto_friend.jpg", array('url'=>array('controller'=>'employers','action'=>'emailjob',$this->request->data['JobPosting']['posting_id'])));?>
                  </li>
                  	<?php //endif;?>
              </ul>
              <div class="clear"></div>
              <br />
              <h2 class="mana_subheading">Summary Information</h2>
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Position Title:</label>
                  <div class="form_rt_col1">
                    <label><?php echo iconv("", "UTF-8//IGNORE", $data['JobPosting']['job_title']); ?></label>
                  </div>
                </li>
                <li>
                  <label>Posted on:</label>
                  <div class="form_rt_col1">
                    <label><?php echo date(DATE_FORMAT,strtotime($this->request->data['JobPosting']['start_dt']));?></label>
                  </div>
                </li>
                
                
<?php if(!empty($this->request->data['JobPosting']['short_descr'])) { ?>
<li>
<label>Short Description:</label>
<div class="form_rt_col1">
<label>
<?php echo iconv("", "UTF-8//IGNORE", $this->request->data['JobPosting']['short_descr']);?>
</label>
</div>
</li>
<?php } ?>
                
<?php if(!empty($this->request->data['JobPosting']['location_city']) || !empty($this->request->data['JobPosting']['location_state'])) { ?>
<li>
<label>Location:</label>
<div class="form_rt_col1">
<label>
<?php if(!empty($this->request->data['JobPosting']['location_city'])) { ?>
<strong>City</strong>: <?php echo $this->request->data['JobPosting']['location_city'];?><br/>
<?php } if(!empty($this->request->data['JobPosting']['location_state'])) { ?>
<strong>State</strong>: <?php echo $this->request->data['JobPosting']['location_state'];?>
<?php } ?>
</label>
</div>
</li>
<?php } ?>

<?php if(!empty($this->request->data['JobPosting']['work_type_code']) || !empty($this->request->data['JobPosting']['work_location_code']) || !empty($this->request->data['JobPosting']['work_time_code'])) { ?>
<li>
<label>Position Type:</label>
<div class="form_rt_col1">
<label>
<?php if(!empty($this->request->data['JobPosting']['work_type_code'])) { ?>
<strong>Terms</strong>: <?php echo $common->getWorkTypeCode($this->request->data['JobPosting']['work_type_code']);?><br/>
<?php } if(!empty($this->request->data['JobPosting']['work_location_code'])) {  ?>
<strong>Location</strong>: <?php echo $common->getWorkLocation($this->request->data['JobPosting']['work_location_code']);?><br/>
<?php } if(!empty($this->request->data['JobPosting']['work_time_code'])) {  ?>
<strong>Hours</strong>: <?php echo $common->getWorkTimeCode($this->request->data['JobPosting']['work_time_code']);?>
<?php } ?>
</label>
</div>
</li>
<?php } ?>

<?php if(!empty($this->request->data['JobPosting']['last_salary']) && !empty($this->request->data['JobPosting']['work_type_code'])) { ?>
<li>
<label>Salary:</label>
<div class="form_rt_col1">
<label>$<?php echo $this->request->data['JobPosting']['last_salary'];?> - <?php echo $common->getSalaryType($this->request->data['JobPosting']['salary_type_code']);?></label>
</div>
</li>
<?php } ?>

<?php $close= false;  if(count($this->request->data['JobPostingSkill']) > 0) { ?>
<?php foreach($this->request->data['JobPostingSkill'] as $key => $skills):?>
<?php   $getSkillName = $common->getSkillName($skills['skill_id']); 
if(!empty($getSkillName)) {
if(!$close) { ?>
<li>
<label>Required Core Skills:</label>
<div class="form_rt_col1">
 <?php $close= true; } ?>
<label><strong><?php  echo $common->getSkillName($skills['skill_id']);?></strong> - Required Experience: <?php echo $common->getExperienceValue($skills['experience_code']);?> - Importance: <?php echo $common->getImportanceValue($skills['importance']);?></label>
<br />
<?php  }  ?>
<?php endforeach;?>
<?php if($close) { ?>
</div>
</li>
<?php  } ?>
<?php  } ?>  

              
                
<?php $close2= false; 
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
<?php } ?>
                
              </ul>
              <div class="preview_panel">
                <h2 class="mana_subheading">Full Description</h2>
                <?php // echo  iconv("", "UTF-8//IGNORE", nl2br($this->request->data['JobPosting']['full_descr'])); ?>
                <?php echo  nl2br(iconv("", "UTF-8//IGNORE", $this->request->data['JobPosting']['full_descr'])); ?>
                <?php // echo iconv("", "UTF-8//IGNORE", $this->request->data['JobPosting']['full_descr']);?>
              </div>
              <br />
              <ul class="footer_btn notoppadding">
                <?php if($this->Session->read('Auth.Client.User.user_type')=='C'):?>
                <li> 
				
                	<?php echo $this->Html->link($this->Html->image('images/applytojob.jpg'),array('controller'=>'Jobseeker','action'=>'candidates/jobApply?jobId='.$this->request->data['JobPosting']['posting_id']),array('escape'=>false)); ?>
               </li>
				<?php endif;?>
                 <?php 
				if(!isset($userId) || $userId==''){ ?>
                <li> 
					<?php echo $this->Html->link($this->Html->image('images/applytojob.jpg'),array('controller'=>'users','action'=>'login'),array('escape'=>false)); ?>
               </li>
				<?php  } ?>
				<?php // task id 3284 ?>
                  <?php //if($this->Session->read('Auth.Client.User.user_type')=='E'):?>
                <li> 
                  <?php echo $this->Html->image("images/emailto_friend.jpg", array('url'=>array('controller'=>'employers','action'=>'emailjob',$this->request->data['JobPosting']['posting_id'])));?>
                  </li>
                  	<?php //endif;?>
              </ul>
              <div class="clear"></div>
            </div>
            <div class="clear"></div>
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
    <?php echo $this->element('partners');?>
  </div>
</div>
