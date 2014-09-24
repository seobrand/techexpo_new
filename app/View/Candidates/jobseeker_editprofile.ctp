<?php echo $this->element('ajax', array('cache' => true));
echo $this->element('numberformat', array('cache' => true));
$countryList=$common->getCountryList();
$militaryList=$common->getMilitaryList();
//pr($this->request->data);

 ?> 
<script type="text/javascript">
$(document).ready(function() {
	
	<?php 
	if(empty($this->request->data['Candidate']['country_code']))
	{
		$this->request->data['Candidate']['country_code']=15;
	}
	if(!empty($this->request->data['Candidate']['country_code']))
	{?>
		var countryId="<?php echo $this->request->data['Candidate']['country_code']; ?>";
	<?php 
	}else
	{
	?>
	var countryId="r";
	<?php
	}
	?>
		if(countryId!=15 && countryId!=16)
		{
			$('#textbox').css('display','block');
			$('#dropdown').css('display','none');
			//$('#stateDropdown').val('');
	                       
		}else
		{
			$('#textbox').css('display','none');
			$('#dropdown').css('display','bock');
			$('#cityTextbox').val('');
		}
		
		
});





function onChangeAjaxGet1(url,value,updateDiv)
{
	
	if(value==15 || value==16)
	{
		$.ajax({
               type:"GET",
               url: "<?php echo FULL_BASE_URL.router::url('/',false);?>"+url+"/"+value,
               success : function(data) {
			
			   $('#textbox').css('display','none');
			   
				$('#dropdown').css('display','block');
				$('#cityTextbox').val('');
				
            	document.getElementById(updateDiv).innerHTML=data;
				
				},
               error : function() {
			   
               },
           })
	}else
	{
		$('#textbox').css('display','block');
		$('#dropdown').css('display','none');
		
	}
}

</script>
<div id="wrapper">
  <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Submit/Edit Profile</h1>
          <?php echo $this->Form->create('Candidate',array('action'=>'editprofile', 'enctype' => 'multipart/form-data')); ?>
          <div class="content">
            <div class="jobseeker_info">
              <p><strong>
              <?php echo $this->Session->read('Auth.Client.Candidate.candidate_name'); ?>
              </strong><br />
                Update your personal information and profile.</p>
                <div class="success-message">
            <?php echo $this->Session->flash(); ?>
            </div>
            
            	<div style="color:#FF0000">
                <?php
				if($mandatory)
				{
				echo $mandatory;
				}
				?>
                </div>
            </div>
            <div class="gray_full_top">
            
            </div>
            <div class="gray_full_mid">
              <h2>Personal &amp; Contact information</h2>
              <ul class="form_list">
                <li>
                  <label><span class="red">*</span>First Name:
                  		<?php 
					  $gender=array('Mr.'=>'Mr.','Mrs.'=>'Mrs.','Ms.'=>'Ms.');
                       echo $this->Form->input('Candidate.candidate_gender',array('type'=>'select','options'=>$gender,
					   															'empty'=>true,'label'=>false,'class'=>'select1','div'=>'','style'=>'width:50px;'));
                      ?>
                  
                  </label>
                  <div style="float:right;width:287px;"><?php echo $this->Form->input('Candidate.candidate_fname',array('class'=>'smallTextB','label'=>false,'border'=>'none','div'=>false));?></div>
                    </li>
                    <li>
	                  <label><span class="red">*</span>Last Name:</label>
	                  <div style="float:right;width:287px;"><?php echo $this->Form->input('Candidate.candidate_lname',array('class'=>'smallTextB','label'=>false,'border'=>'none','div'=>false));?></div>
                    </li>
                    <!--<li>
                    <label>Title: </label>
                    <div style="float:right;width:287px;">
                    <?php echo $this->Form->input('Candidate.candidate_title',array('class'=>'smallTextB','label'=>false,'div'=>''));?>
                    </div>
                    </li>-->
                    <li>
                    <label>Phone:</label>
                    <div style="float:right;width:287px;">
                    <?php echo $this->Form->input('Candidate.candidate_phone',array('class'=>'smallTextB','label'=>false,'div'=>'','id'=>'mobilenumber'));?>
                    </div></li>
                    <!--<li>
                    <label>Fax: </label>
                    <div style="float:right;width:287px;">
                    <?php echo $this->Form->input('Candidate.candidate_fax',array('class'=>'smallTextB','label'=>false,'div'=>''));?>
                    </div></li>-->
                    <li>
                    <label><span class="red">*</span>Email: </label>
                    <div style="float:right;width:287px;">
                    <?php echo $this->Form->input('Candidate.candidate_email',array('class'=>'smallTextB','label'=>false,'type'=>'text','div'=>''));?>
                    </div>
                    </li>
                    
                    <li>
                    <label>Alternate Email: </label>
                    <div style="float:right;width:287px;">
                    <?php echo $this->Form->input('Candidate.candidate_secondary_email',array('class'=>'smallTextB','type'=>'text','label'=>'','border'=>'none','div'=>''));?>
                    </div>
                    </li>
                    
                    
                   
                    
                    <li>
                    <label><span class="red">*</span>Country:</label>
                    <div class="dropdown" style="height:24px;;margin-left:2px;">
                    <?php 
                     echo $this->Form->input('Candidate.country_code',array('type'=>'select','options'=>$countryList,
					   															'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','onChange'=>'onChangeAjaxGet1("users/state",this.value,"stateDropdown")'));
					
					?>
                    </div>
                    </li>
                    
                     <li>
                    <label><span class="red">*</span>Address: </label>
                    <div style="float:right;width:287px;">
                    <?php echo $this->Form->input('Candidate.candidate_address',array('class'=>'smallTextB','label'=>false,'div'=>'','style'=>'width:264px'));?>
                    </div>
                    </li>
                    
                     <li>
                    <label><span class="red">*</span>City:</label>
                    <div style="float:right;width:287px;">
                    <?php echo $this->Form->input('Candidate.candidate_city',array('class'=>'smallTextB','label'=>false,'div'=>'','style'=>'margin-left:0px !important;')); ?>
                    </div>
                    </li>
                    
                    <li>
                    <label><span class="red">*</span>State/Province:</label>
                    <div class="dropdown" style="height:24px;margin-left:2px;" id="dropdown">
                    <?php 
                           echo $this->Form->input('Candidate.candidate_state',array('type'=>'select','empty'=>false,'options'=>$statList,
                                                                                    'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','id'=>'stateDropdown'));
                          ?>
                    </div>
                    
                     <div style="float:right;width:287px;clear:both;display:none;margin-top:-25px;"   id="textbox" >
                    	<?php echo $this->Form->input('Candidate.candidate_state22',array('class'=>'smallTextB','label'=>'','border'=>'none','div'=>'','id'=>'cityTextbox'));?> 
                    </div>
                    </li>
                    
                   
                    
                     <li>
                    <label><span class="red">*</span>Zip:</label>
                    <div style="float:right;width:287px;">
                    &nbsp;<?php echo $this->Form->input('Candidate.candidate_zip',array('class'=>'smallTextB','label'=>false,'div'=>'','style'=>'margin-left:0px !important;'));?>
                    </div>
                    </li>
                    
                    
                    
                    
                    <li>
                    <label>LinkedIn Profile::</label>
                    <div style="float:right;width:287px;">
                    &nbsp;<?php echo $this->Form->input('Candidate.linkedin',array('class'=>'smallTextB','label'=>false,'div'=>'','style'=>'margin-left:0px !important;'));?>
                    </div>
                    </li>
                    
                    <li>
                    <label>Twitter:</label>
                    <div style="float:right;width:287px;">
                    &nbsp;<?php echo $this->Form->input('Candidate.twitter',array('class'=>'smallTextB','label'=>false,'div'=>'','style'=>'margin-left:0px !important;'));?>
                    </div>
                    </li>
                    
                    
                    
                    <li>
                    <label><span class="red">*</span>How did you find out about our events ? </label>&nbsp;
                    <?php echo $this->Form->input('Candidate.here_from',array('class'=>'smallTextB','label'=>false,'div'=>'','style'=>'margin-left:2px !important;'));?>
                    <?php //echo $this->Form->input('Candidate.here_from',array('class'=>'smallTextB','label'=>false,'div'=>''));?> 
                    </li>
                    
                    </li>
                    </ul>
                    </div>
                    <br />
                    <div class="gray_full_top"></div>
                    <div class="gray_full_mid">
                    <h2>Login info &amp; Privacy</h2>
                    <ul class="form_list">
                    <li>
                    
                    <label><span class="red">*</span>Username:</label>
                    <div class="form_rt_col">
                    <?php echo $this->Form->input('User.username',array('class'=>'smallTextB','label'=>false,'div'=>'','style'=>'margin-left:2px !important;'));?>
                    </div>
                    </li>
                    <li>
                    <label>Password: </label>
                    <div class="form_rt_col">
                    <?php echo $this->Form->input('User.password',array('class'=>'smallTextB','label'=>false,'div'=>''));?>
                    </div>
                    </li>
                    <li>
                    <label>Confirm Password:</label>
                    <div style="float:right;width:287px;">
                    <?php echo $this->Form->input('User.cpassword',array('class'=>'smallTextB','type'=>'password','label'=>false,'div'=>'','style'=>'margin-left:-2px !important;'));?>
                    </div>
                    </li>
                    
                    </ul>
                    </div>
                    <br />
                    <div class="gray_full_top"></div>
                    <div class="gray_full_mid">
                    <h2>Professional Profile</h2>
                    <ul class="form_list">
                    <li>
                    <label>Number of years of solid professional experience:</label>
                    <div class="small_dropdown">
                    <?php 
                    echo $this->Form->input('Candidate.experience_code',array('type'=>'select','options'=>$experienceArray,'empty'=>'-Select-','label'=>false,'class'=>'select1','div'=>''));
                    ?>
                    
                    &nbsp;&nbsp; </div>
                    </li>
                    <li>
                    <label>Are you currently 
                    employed ?</label>
                    <div class="small_dropdown">
                    <?php 
                    $option=array('Y'=>'Yes','N'=>'No');
                    echo $this->Form->input('Candidate.employment_status',array('type'=>'select','options'=>$option,'label'=>false,'class'=>'select1','div'=>''));
                    ?>
                    &nbsp;&nbsp;</div>
                    </li>
                    <li>
                    <label>What is your citizenship status ?</label>
                    <div class="dropdown">
                    <?php 
                    echo $this->Form->input('Candidate.citizen_status_code',array('type'=>'select','options'=>$citizenshipArray,'empty'=>'-Select-','label'=>false,'class'=>'select1','div'=>''));
                    ?>
                    &nbsp;&nbsp;</div>
                    </li>
                    <li>
                    <label>Do you have current or have you had governmental security clearance in the last 24 months ? </label>
                    <div class="candidateEditProfile">
                    <div class="checkbox_div1"  style="height:100px">
                    <div class="checkbox_list" style="height:100px">
                    <?php 
                    echo $this->Form->input('Candidate.security_clearance_code',array('type'=>'select','options'=>$govenmentclearanceArray,'multiple'=>'checkbox','label'=>false,'class'=>'select1','div'=>''));
                    ?>
                  
                    </div>
                    </div>
                    </div>
                    </li>
                    
                    
                    <li>
                    <label>Military Services:</label>
                    <div class="dropdown">
                    <?php 
                    echo $this->Form->input('Candidate.military_service',array('type'=>'select','options'=>$militaryList,
                            'empty'=>'-Select Military Services-','label'=>false,'class'=>'select1','div'=>''));
                    ?>
                    &nbsp;&nbsp;</div>
                    </li>
                    
                    <li>
                    <label>Military Status:</label>
                    <div class="form_rt_col">
                    
                    <?php 
                    $military_service_status=array('1'=>'Active','0'=>'Inactive');
                    echo $this->Form->input('Candidate.military_service_status',array('type'=>'radio','options'=>$military_service_status,
                                'label'=>false,'class'=>'select1','style'=>'width:30px;','default'=>'1','div'=>false,'label'=>false,'legend' => false,));
                    ?>
                    
                    &nbsp;&nbsp;</div>
                    </li>
                    
                    
                    
                    <li>
                    <label>What is your military rank (if applicable) ? </label>
                    <?php echo $this->Form->input('Candidate.candidate_military_rank',array('class'=>'smallTextB','label'=>false,'border'=>'none','div'=>''));?>
                    
                    </li>
                    
                    
                    <li>
                    <label>When would you be available to start working ? </label>
                    <div class="dropdown">
                    <?php 
                    echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$noticeperidArray,'label'=>false,'class'=>'select1','div'=>''));
                    ?>
                    </div>
                    </li>
                    
                    <li>
                    <label>Optional - Indicate your last salary / compensation:</label>
                    <div class="form_rt_col">
                    <table width="100%" border="0" cellspacing="0" cellpadding="">
                    <tr>
                    <td valign="middle" width="10" height="27"> $ </td>
                    <td valign="middle" width="72" height="27">
                    <?php echo $this->Form->input('Candidate.last_salary',array('class'=>'smallTextField','label'=>false,'div'=>'','style'=>'top:1px !important'));?>
                    </td>
                    <td valign="middle" width="10" height="27"> - </td>
                    <td valign="middle" width="72" height="27">
                    <div class="small_dropdown_new" >
                    <?php
                    echo $this->Form->input('Candidate.salary_type_code',array('type'=>'select','options'=>$salaryTypeList,
                                            'label'=>false,'div'=>'','empty'=>'--select salary type--'));
                    ?>
                    </div></td>
                    <td valign="middle" width="60" height="27"></td>
                    </tr>
                    <tr>
                    <td colspan="5" valign="middle" style="padding:5px 0 0 0">This field must be filled as an integer (no commas, $ signs or periods). Thank you.</td>
                    </tr>
                    </table>
                    </div>
                    </li>
                    <li>
                    <label>Which industries do you have experience in ?</label>
                    
                    <div class="candidateEditProfile">
                    <div class="checkbox_div1"  style="height:100px">
                    <div class="checkbox_list" style="height:100px">
                    <?php 
                    echo $this->Form->input('Candidate.pref_industries',array('type'=>'select','options'=>$industriesArray,'multiple'=>'checkbox','label'=>false,'class'=>'select1','div'=>''));
                    ?>
                    
                    <!--
                    <div class="form_rt_col">
                    <div class="listbox">
                    
                    <?php 
                    echo $this->Form->input('Candidate.pref_industries',array('type'=>'select','options'=>$industriesArray,'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','multiple'=>'multiple'));
                    ?>
                    -->
                    </div>
                    </div>
                    </div>
                    </li>
                    <li>
                    <label>Are you willing to relocate to other parts of the US ?</label>
                    <div class="small_dropdown">
                    
                    <?php 
                    $option=array('Y'=>'Yes','N'=>'No');
                    echo $this->Form->input('Candidate.relocate',array('type'=>'select','options'=>$option,'empty'=>'-Select-','label'=>false,'class'=>'select1','div'=>''));
                    ?>
                    </div>
                    </li>
                    <li>
                    <label>If you are willing to relocate, which states do you prefer to work in ? </label>
                    <!-- <div class="form_rt_col">
                    <div class="listbox">
                    
                    
                    <?php 
                    echo $this->Form->input('Candidate.pref_locations',array('type'=>'select','options'=>$statList,'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','multiple'=>'multiple'));
                    ?>-->
                    <div class="candidateEditProfile">
                    <div class="checkbox_div1"  style="height:100px">
                    <div class="checkbox_list" style="height:100px">
                    <?php 
                    echo $this->Form->input('Candidate.pref_locations',array('type'=>'select','options'=>$statList1,'multiple'=>'checkbox','label'=>false,'class'=>'select1','div'=>''));
                    ?>
                    </div>
                    
                    
                    </div>
                    </div>
                    </li>
                    
          
                
                <li>
                  <label>Confidentiality: </label>
                  <div class="form_rt_col">
                    
                    <?php echo $this->Form->input('Candidate.candidate_privacy',array('type'=>'checkbox','div'=>false,'label'=>false)); ?>
                    Check here to keep your name and contact info confidential: (Only your e-mail will be revealed). </div>
                </li>
              </ul>
            </div>
            <div class="man_resume_footer">
<!--              <p>Please enter text as shown in image below:</p>
-->              <ul>
                <li class="last"> <!--<?php echo $this->Form->submit('images/delete.png',array('class'=>'delete_btn')); ?>--> </li>
                <li> 
                <?php
                 
                     echo $this->Form->input('Candidate.id',array('type'=>'hidden','div'=>false,'label'=>'false'));
                     echo $this->Form->input('User.id',array('type'=>'hidden','div'=>false,'label'=>'false'));
                     echo $this->Form->input('SUBMIT',array('type'=>'hidden','div'=>false,'label'=>'false','value'=>'UPDATE'));
                     echo $this->Form->submit('images/update_new.png',array('class'=>'delete_btn')); 
                 ?> 
                 
                 </li>
                <!--<li>
                 <?php                    
                   echo $this->Form->input('Candidate.captcha',array('autocomplete'=>'off','autocomplete'=>'off','value'=>'','label'=>false,'class'=>'security_txt','div'=>''));
                  ?>
                  <div style="color:#FF0000"><?php echo $securityerror; ?></div>
                </li>
                <li>
                <?php echo $this->Html->image($this->Html->url(array('controller'=>'candidates', 'action'=>'captcha', 'Jobseeker'=>false), true),array('style'=>'','vspace'=>2)); ?>
              </li>-->
              </ul>
              <div class="clear"></div>
            </div>
          </div>
          
          <?php echo  $this->Form->end();?>
        </div>
      </div>
    </div>
    
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    
    <div class="clear"></div>
   	 <?php echo $this->element('partners', array('cache' => true)); ?>
  </div>
</div>
