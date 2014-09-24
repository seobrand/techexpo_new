<?php //echo $this->Html->script('front_js/jquery-ui-1.7.2.custom.min.js');
     echo $this->Html->script('front_js/jquery.colorbox.js');
	 echo $this->Html->css('front_css/colorbox.css');
	 	echo $this->Html->script('jquery-ui-1.7.1.custom.min.js');
 ?>
<style type="text/css">
.column{
	 min-height: 300px;
	 
}
.column .dragbox{
	margin:5px;
	background:#fff;
	position:relative;	
}
.column .dragbox h4{
	margin:0;
	/*background:#f0f0f0;*/
	cursor:move;
}


.column  .placeholder{
	 border: 1px dotted black; visibility: visible !important; height: 50px !important;
}

</style>
<script type="text/javascript">
$(function(){
	
	$(".ajax").colorbox();
	
	
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			$.post("<?php echo FULL_BASE_URL.router::url('/',false)?>employers/updateDB", order, function(theResponse){
				//$("#contentRight").html(theResponse);
			}); 															 
		}								  
		});

});
</script>
<div id="wrapper">
  <?php
	$theComponent = new commonComponent(new ComponentCollection());
	 echo $this->element('employer_tabs');
	 ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head border_top"></div>
      <div class="whiteB_mid border_mid">
        <div class="whiteB_bottom border_btm">
          <div class="content">
            <div class="dashboard_row">
              <div class="announcements_panel">
                <h4 class="dash_heading" style="background-color:#EAEAEC;">Special Announcement</h4>
                <ul class="dash_act_job">
				<?php $announcement = $common->getEmployerAnnouncement();?>
				<?php if(isset($announcement['HomepageMessage']['msg'])){?>
                  <li style="border:none;padding:0 8px 4px 8px">
				  	<?php if(isset($announcement['HomepageMessage']['msg'])){?>
						<?php 
						if(isset($announcement['HomepageMessage']['img'])  && file_exists('img/homepage/'.$announcement['HomepageMessage']['img']))
						echo $this->Html->image("homepage/".$announcement['HomepageMessage']['img'],array('style'=>'float:left;margin:0 20px 20px 0'));
						else 
						echo $this->Html->image('testimonial/no_image.jpg',array('alt'=>'No Image','title'=>'No Image','style'=>'float:left;margin:0 10px 10px 0'));
						?>
						
					<?php } ?>
                    
                    <?php echo $announcement['HomepageMessage']['msg'];?>
				<?php } ?>
                <br />
				</li>				
                </ul>
              </div>
			  <div class="announcements_panel">
                <h4 class="dash_heading" style="background-color:#EAEAEC;">Want to post more Jobs?</h4>
                <ul class="">
                  <li> 					
                   <!-- You have <strong><?php echo $limitJobs = $common->GetEmployerJobLimit($this->Session->read('Auth.Client.employerContact.employer_id'));?> </strong> job postings available.  If you&rsquo;d like to post more listings, you will need to purchase a premium plan. Click the <strong>BUY Now</strong> button to get your premium plan now.-->
                    
                   You have <strong><?php echo $limitJobs = $common->GetEmployerJobLimit($this->Session->read('Auth.Client.employerContact.employer_id'));?> </strong> job postings available.  If you would like post more listings please click the buy now button to see pricing information. 
                    
                    
                      <br/>	<br/>
                    
                    
                    	<span style="float:right"><?php echo $this->Html->link($this->Html->image('images/buynow_new.png'),array('controller'=>'jobplans','action'=>'index'),array('escape'=>false,'alt'=>'Buy Now','title'=>'Buy Now'));?></span>
						<br/><br/>
				</li>				
                </ul>
              </div>
              <!-- This is first column -->
              
     
            </div>
            <div class="dashboard_row">
              
              
              
              
              
              
                 <div style="clear:both"></div>
              <div id="contentLeft">
                <ul style="width:632px;">
                  <?php
				foreach($RecId as $key=>$value9)
				{
				?>
               <?php if($value9['records']['recordID']=='1') {?>
                  <li style="width:290px;float:left;margin:10px;min-height:370px;margin:5px 5px 0px 15px;" id="recordsArray_<?php echo $value9['records']['id']; ?>">
                    <div class="dashboard_col_lf">
                    <h4 class="dash_heading">Employer Preparation</h4>
                    <div class="step_panel">
                      <div class="steps">Step<br />
                        1</div>
                      <div class="step_detail">Enter/Update corporate profile</div>
                      <div class="clear"></div>
                    </div>
                    <div class="step_panel">
                      <div class="steps">Step<br />
                        2</div>
                      <div class="step_detail">
                        <?php $postedJobs = $common->GetPostedJobNumber($this->Session->read('Auth.Client.employerContact.employer_id')); 
						if($postedJobs < 1) {
						 ?>
                       <blink>Enter/Update job postings </blink>
                       <?php }else{ ?>
                       Enter/Update job postings 
                       <?php } ?>
                        </div>
                      <div class="clear"></div>
                    </div>
                    <div class="step_panel">
                      <div class="steps">Step<br />
                        3</div>
                      <div class="step_detail">Show Specifics: # of staff, booth size,  
                        electric/telephone needs </div>
                      <div class="clear"></div>
                    </div>
                    <div class="step_panel">
                      <div class="steps">Step<br />
                        4</div>
                      <div class="step_detail">To ensure a successful event </div>
                      <div class="clear"></div>
                    </div>
                    <div class="alignright"> <?php echo $this->Html->link($this->Html->image("images/viewall.jpg"), array('controller'=>'employers','action'=>'emppostjob'),array('class'=>'f_right padding_right view_edit','escape'=>false,'alt'=>'View All','title'=>'View All'));?> </div>
                  </div>
              </li>
              <?php } ?>
              <?php if($value9['records']['recordID']=='2') {?>
              <li style="width:290px;float:left;margin:10px;min-height:370px;margin:5px 5px 0px 15px;" id="recordsArray_<?php echo $value9['records']['id'];; ?>">
              <div class="dashboard_col_rt">
                    <h4 class="dash_heading">Active Jobs<span class="post_job_btn">
                 	<?php if($limitJobs==0){?>
                 		<a title="Post a Job" alt="Post a Job" class="f_right padding_right view_edit" href="javascript:void(0);" onclick="showPostJobPopup()"><img src="<?php echo $this->webroot;?>img/images/post_job_btn.jpg"></a>
		            <?php }else{ ?>
                     <?php echo $this->Html->link($this->Html->image("images/post_job_btn.jpg"), array('controller'=>'employers','action'=>'emppostjob'),array('class'=>'f_right padding_right view_edit','escape'=>false,'alt'=>'Post a Job','title'=>'Post a Job'));?>
                    <?php }?>
                    </span></h4>
                    <ul class="active_job_heading">
                      <li class="jobname">Job Name</li>
                      <li class="view_actions">View/Edit/Delete</li>
                    </ul>
                    <div class="clear"></div>
                    <ul class="dash_act_job with_action">
                      <?php if(count($joblists)>0):
			   foreach ($joblists as $K=> $joblist):
			  ?>
                      <li> <span class="f_left jobname"><?php echo $joblist['JobPosting']['job_title'];  ?></span><span>
                       <?php echo $this->Html->link($this->Html->image("images/trash.jpg"), array('controller'=>'employers','action'=>'dashboard',$joblist['JobPosting']['posting_id']),array('class'=>'f_right padding_right view_delete','escape'=>false ,'confirm' => 'Are you sure to delete folder?','alt'=>'Delet','title'=>'Delete'));?> 
					   <?php echo $this->Html->link($this->Html->image("images/edit1.jpg"), array('controller'=>'employers','action'=>'empeditjob',$joblist['JobPosting']['posting_id']),array('class'=>'f_right padding_right view_edit','escape'=>false,'alt'=>'Edit','title'=>'Edit'));?> 
					   <?php echo $this->Html->link($this->Html->image("images/preview.jpg"), array('controller'=>'employers','action'=>'jobdetail',$joblist['JobPosting']['posting_id']),array('class'=>'f_right padding_right view_edit','escape'=>false,'alt'=>'Preview','title'=>'Preview'));?> </span>
                        <div class="clear"></div>
                      </li>
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
                    </ul>
                    <div class="alignright viewmore_active"> <?php echo $this->Html->link($this->Html->image("images/view_more.jpg"), array('controller'=>'employers','action'=>'joblists'),array('escape'=>false,'alt'=>'View More','title'=>'View More')); ?> </div>
                  </div>
            </li>
            <?php } ?>
            <?php if($value9['records']['recordID']=='3') {?>
            <li style="width:290px;float:left;margin:10px;min-height:370px;margin:5px 5px 0px 15px;" id="recordsArray_<?php echo $value9['records']['id'];; ?>">
              <div class="dashboard_col_lf">
                    <h4 class="dash_heading">Your Corporate Videos</h4>
                    <?php 
					if($dashboard_video['EmployerVideo']['id']){
					echo $this->Html->link($this->Html->image("images/video.jpg",array('style'=>'width:295px;')), array('controller'=>'employers','action'=>'empshowVideo/'.$dashboard_video['EmployerVideo']['id']),array('class'=>'ajax','escape'=>false,'alt'=>'My Video','title'=>'My Video'));}
					else
					{
					echo $this->Html->image('images/video.jpg',array('style'=>'width:295px;','onclick'=>'alert("Please enter video first");','alt'=>'My Video','title'=>'My Video'));
					}	 ?>
                    <div class="viewmore_active">
                      <!--  <a href="emp-seekers-video.html" class="f_left">
                    <?php  echo $this->Html->image("images/upload_videos.jpg"); ?> </a>--> <?php echo $this->Html->link($this->Html->image("images/manage_videos.jpg"), array('controller'=>'employers','action'=>'empVideo'),array('class'=>'f_right','escape'=>false,'alt'=>'Manage Video','title'=>'Manage Video')); ?> </div>
                  </div>
            </li>
            <?php } ?>
            <?php if($value9['records']['recordID']=='4') {?>
            <li style="width:290px;float:left;margin:10px;min-height:370px;margin:5px 5px 0px 15px;" id="recordsArray_<?php echo $value9['records']['id'];?>"> 
	
              <div class="dashboard_col_rt">
                   <?php echo $this->Form->create('Folders',array('action'=>'resumeSearchResult/dashboardsearch','type'=>'GET','name'=>"searchform", 'onsubmit'=>"return checkForm(this);"));?>
                    <h4 class="dash_heading">Search Resumes</h4>
                    <ul class="dash_search_list">
                    <li>
                      <label>Keywords:</label>
                      <br />
                      <div class="clear"></div>
                      <p class="f_left">
                      <?php echo $this->Form->input('words',array('class'=>'dash_textField_small','div'=>false,'label'=>false)); ?>
                      </p>
                       <p class="f_right dropdown_dash_small">
                       <select name="type" id="FoldersType" style="font-size: x-small; font: x-small;">
	                 		<option value="Any">Any Words</option>
							<option value="All" selected="">All Words</option>
							<option value="Exact Phrase">Exact Phrase</option>
							<option value="Advanced">Advanced Boolean Search</option>
						</select>
                      </p>
                      <div class="clear"></div>
                    </li>
                    <li>
                      <label>State:</label>
                      <br />
                      <div class="checkbox_div_dashboard ">
                        <div class="checkbox_list">
                      <?php  $state_list = $theComponent->getStateList();
                         echo $this->Form->input('candidate_state',array('type'=>'select','multiple'=>'checkbox','options'=>$state_list,'empty'=>array('ALL'=>'ALL STATES'),'selected' => 'ALL','label'=>false,'div'=>false,'hiddenField' => false)); 
					  	?>
					  	</div>
					  </div>
					  <div class="clear"></div>
                    </li>
                    
                    <li>
                      <label>Citizenship Status:</label>
                      <br />
                      <p class="dropdown_dash">
                      <select name="citizen_status_code">
						 <option value="25" SELECTED>US Citizens Only </option>
						 <option value="0">Will Consider Aliens</option>
					  </select> 
                      </p>
                    </li>
                    <li>
                      <label>Min. years of Exp:</label>
                      <br />
                      <p class="dropdown_dash">
                       <?php  $experience_code = $theComponent->getResumeSearchExperienceList();					  
					  	echo $this->Form->input('experience_code',array('label'=>'','options'=>$experience_code,'type'=>'select','error'=>false,'div'=>false,'label'=>false));
					   ?>
                      </p>
                    </li>
                    
                    <li>
                      <label>Security Clearance level desired(optional):</label>
                      <br />
                      <div class="checkbox_div_dashboard">
                        <div class="checkbox_list">
                      <?php $cleareance_list = $theComponent->getGovCleareanceList();
						 echo $this->Form->input('security_clearance_code2',array('type'=>'select','multiple'=>'checkbox','options'=>$cleareance_list,'label'=>false,'div'=>false,'hiddenField' => false)); 
					   ?>
                      	</div>
                      </div><br/>                   
                      <p class="dashfloat_none">If you selected "Other Active Clearance" in the above menu. you may enter security clearance search keywords here (Click on instructions link above for detailed instructions)</p>
                      <p>
                        <?php echo $this->Form->input('security_clearance_code',array('class'=>'dash_textField','div'=>false,'label'=>false,'size'=>'40')); ?>
                       
                      </p>
                     <!-- <p><?php echo $this->Form->checkbox('adv_sec',array('div'=>false,'label'=>false)); ?>&nbsp;&nbsp;Check to perform an <strong>Advanced Boolean Search</strong> (read instructions).</p>-->
                      <div class="clear"></div>
                    </li>
                  
                    
                    <li>
                      <label>Look for resumes<span class="smalltext"> submitted in the last</span>:</label>
                      <br />
                      <div class="clear"></div>
                      <p class="f_left">
                      <?php echo $this->Form->input('date_search',array('class'=>'dash_textField_small','div'=>false,'label'=>false,'size'=>'3','maxlength'=>'2')); ?>
                      </p>
                       <p class="f_right dropdown_dash_small">
                        <?php 
	                        $option=array('day'=>'days','week'=>'weeks','month'=>'months','year'=>'years');
	                         echo $this->Form->input('time_units',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'div'=>''));
	                      ?>
                      </p>
                      <div class="clear"></div>
                    </li>  
                    <li>
                      <label>Max. Number of results:</label>
                      <br />
                      <p class="dropdown_dash">
                       <?php $options=array('All'=>'View all','100'=>'100','200'=>'200','300'=>'300','500'=>'500','1000'=>'1000');
							echo $this->Form->input('max_rows',array('type'=>'select','options'=>$options,'empty'=>false,'label'=>false,'div'=>''));
						?>
                      </p>
                    </li>
                    <li>
                      <label>Look for resumes in:</label>
                      <br />
                      <div class="checkbox_div_dashboard">
                        <div class="checkbox_list">
                        <?php echo $this->Form->input('set_id', array('type' => 'select','multiple'=>'checkbox','options' => $selected_db,'div'=>false,'label'=>false,'hiddenField' => false));?>
                      </div>
                      </div>
                    </li>
                 
                  </ul>       <div class="clear"></div> 
                    <div class="alignright viewmore_active"> <?php echo $this->Form->submit('images/grey_submit.jpg',array('alt'=>'Submit','title'=>'Submit') );?> </div>
                    <?php echo $this->Form->end();?>
                  </div>
              
              
               </li>
            <?php } ?>
            <?php } ?>
            </ul>
          </div>
          <div style="clear:both"></div>
          <div class="clear"></div>
              
              
              
              
              
              
              
              
              
              
              
                         </div>
          </div>
        </div>
      </div>
      <br />
      <div class="whiteB_head blue_head">
        <div class="blue_head_lf">Recent Applicants</div>
        <div class="blue_head_rt"></div>
        <div class="clear"></div>
      </div>
      <div class="whiteB_mid border_mid">
        <div class="whiteB_bottom border_btm">
          <div class="padding_dashboard employee_fixheight">
             <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr class="tableHead">
                      <th width="135">Seeker's Name</th>
                      <th width="135">Applied Job</th>
                      <th width="120">Date</th>
                      <th width="110">Experience</th>
                  
              </tr>
              </thead>
              <tbody>
              <?php  
			  if(count($apply_list)){
			 	$i=$i+1;
			 	foreach($apply_list as  $apply_list) { 
			  ?>
             <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                      <tdstyle="text-align:left">
                      
                         <?php echo $this->Html->link($apply_list['Candidate']['candidate_name'], array('controller'=>'folders','action'=>'showResume',$apply_list['ApplyHistory']['resume_id']),array('escape'=>false,'target'=>'blank')); ?>
                      </td>
                      <td class="normalfont" style="text-align:left" valign="middle"><?php echo $apply_list['ApplyHistory']['job_title'];   ?></td>
                      <td   class="normalfont" style="text-align:left"><?php echo date(DATE_FORMAT,strtotime($apply_list['ApplyHistory']['dt']));   ?></td>
                      <td  class="normalfont" style="text-align:left"><?php echo   $theComponent->getExperienceValue($apply_list['Candidate']['experience_code']);    ?></td>
                   
              </tr>
              <?php $i=$i+1; }
			   } ?>
            </table>
            <br />
            <div class="alignright viewmore_active"> <?php echo $this->Html->link($this->Html->image("images/viewall.jpg"), array('controller'=>'employers','action'=>'empinterview'),array('escape'=>false ,'alt'=>'View All','title'=>'View All')); ?> </div>
            <br />
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel');?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?> </div>
</div>
<SCRIPT TYPE="text/javascript">
function checkForm(form) {
	
	cnt=document.searchform.elements['security_clearance_code2[]'].length;
	
	i = 0;
	other_found=0;

	
	for (i = 0; i < cnt; i++) {
		selected = "";
		if(document.searchform.elements['security_clearance_code2[]'][i].checked) 
        {
		 	selected = document.searchform.elements['security_clearance_code2[]'][i].value;		 	
		 	if (selected =="3922") {
				other_found=1;
			}
        }
	} 
	
	// Other Active Clearance selected but no keywords in security clearance text field
	if ((other_found==1) && (document.searchform.security_clearance_code.value=="" || !document.searchform.security_clearance_code.value)) {
		alert("You selected 'Other Active Clearance' from the security clearance pull-down list, but did not enter any text in the security clearance text field. Please type in your keywords in the security clearance text field.");
		return false;
	}
	
	// Keywords in security clearance text field but Other Active Clearance NOT selected 
	if ((other_found==0) && (document.searchform.security_clearance_code.value!="")) {
		alert("You entered text in the security clearance text field, but did not select 'Other Active Clearance' from the security clearance pull-down list. The security clearance text field can only be used when selecting 'Other Active Clearance' from the list.");
		return false;
	}
	
	// Advanced security clearance checkbox checked, but no double quotes enclosing search words or phrases
	var myString = document.searchform.security_clearance_code.value;
	var index = myString.indexOf("\"");
	
  	if ((index == "-1") && (document.getElementById("FoldersAdvSec").checked==true)) { 
    	alert("You have selected the advanced security clearance keyword search but have not enclosed your search words or phrases in double quotes (\"). Please correct this.");
		return false;
  	}
	
	// Advanced boolean keyword search, but no double quotes enclosing search words or phrases
	var myString2 = document.searchform.words.value;
	var index2 = myString2.indexOf("\"");
  	if ((index2 == "-1") && (document.searchform.type.value=="Advanced")) { 
    	alert("You have selected the advanced boolean keyword search but have not enclosed your search words or phrases in double quotes (\"). Please correct this.");
		return false;
  	}
	
	// Advanced security clearance checkbox checked, odd number of double quotes
	var myString = document.searchform.security_clearance_code.value;
	var index = myString.indexOf("\"");
	var cnt=0;
	var test=0;
	
	while (index != -1) {
		cnt=cnt+1;
		index = myString.indexOf("\"", index + 1);
	}
	
	test = cnt % 2;
	
  	if ((test == 1) && (document.getElementById("FoldersAdvSec").checked==true)) { 
    	alert("You have selected the advanced security clearance keyword search but have an odd number of double quotes in your search syntax(\"). For your syntax to be correct, your search string must have an even number of double quotes. Please correct this.");
		return false;
  	}
	
	// Advanced boolean keyword search, odd number of double quotes
	var myString2 = document.searchform.words.value;
	var index2 = myString2.indexOf("\"");
	var cnt2=0;
	var test2=0;
	
	while (index2 != -1) {
		cnt2=cnt2+1;
		index2 = myString2.indexOf("\"", index2 + 1);
	}
	
	test2 = cnt2 % 2;
	
  	if ((test2 == 1) && (document.searchform.type.value=="Advanced")) { 
    	alert("You have selected the advanced boolean keyword search but have an odd number of double quotes in your search syntax(\"). For your syntax to be correct, your search string must have an even number of double quotes. Please correct this.");
		return false;
  	}

}
</script>