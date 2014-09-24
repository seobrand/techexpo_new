<script type="text/javascript">
function checkValid()
{
	
var password = $.trim($('#UserPassword').val());
var UserCpassword = $.trim($('#UserCpassword').val());

if(password!='' && UserCpassword=='')
{
	alert("Please enter confirm password");	
	return false;
}
if(password!==UserCpassword)
{
	alert("Password does not match");	
	return false;
}


	
}
</script>
<div class="content"> 
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">My Profile</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
          <div class="display_row">
            <div class="table">
            <?php echo $this->Form->create('Admincandidates',array('action'=>'updateCandidateInfo/'.$SeekerId, 'enctype' => 'multipart/form-data','onsubmit'=>'return checkValid();')); ?>
              <table cellspacing="0" cellpadding="0" border="0">
                <tbody>
                 
                  <tr>
                    <td colspan="2"><h2>Personal & Contact information</h2></td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">Name:</td>
                    <td width="74%">
                    	<?php echo $this->Form->input('Candidate.candidate_name',array('class'=>'inputbox1','label'=>false,'border'=>'none','div'=>false));?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">Title:</td>
                    <td width="74%">
                    	<?php echo $this->Form->input('Candidate.candidate_title',array('class'=>'inputbox1','label'=>false,'div'=>''));?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">Phone:</td>
                    <td width="74%">
                    	  <?php echo $this->Form->input('Candidate.candidate_phone',array('class'=>'inputbox1','label'=>false,'div'=>''));?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">Fax:</td>
                    <td width="74%">
                    	<?php echo $this->Form->input('Candidate.candidate_fax',array('class'=>'inputbox1','label'=>false,'div'=>''));?>
                    </td>
                  </tr>
                   <tr>
                    <td width="25%" valign="middle" align="right">Email:</td>
                    <td width="74%">
                    	<?php echo $this->Form->input('Candidate.candidate_email',array('class'=>'inputbox1','type'=>'text','label'=>false,'div'=>''));?>
                    </td>
                  </tr>
                 
                
                  <tr>
                    <td width="25%" valign="middle" align="right">Address:</td>
                    <td width="74%">
                    	 <?php echo $this->Form->input('Candidate.candidate_address',array('class'=>'smallTextB mceNoEditor','label'=>false,'div'=>''));?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">City:</td>
                    <td width="74%">
                     <?php echo $this->Form->input('Candidate.candidate_city',array('class'=>'inputbox1','label'=>false,'div'=>''));?>
                  
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">State:</td>
                    <td>
                    <?php echo $this->Form->input('Candidate.candidate_state',array('type'=>'select','options'=>$statList,
				   																	'empty'=>'-Select State-','label'=>false,'class'=>'select1','div'=>'','class'=>'listbox'));
                     ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">Zip:</td>
                    <td width="74%">
                    	<?php echo $this->Form->input('Candidate.candidate_zip',array('class'=>'smallTextB','label'=>false,'div'=>''));?>
                    </td>
                  </tr>
                
                </tbody>
              </table>
              <br /><br />
              
               <table cellspacing="0" cellpadding="0" border="0">
                <tbody>
                  <tr>
                   <tr>
                    <td colspan="2"><h2>Login info & Privacy</h2></td>
                  </tr>
                    <td width="25%" valign="middle" align="right">Username:</td>
                    <td width="74%">                    
                     <?php echo $this->Form->input('User.username',array('type'=>'text','div'=>'','label'=>false,'style'=>'border:0px;background-color:#EEEEEE;font-size:16px;width:330px;','disabled'=>'disabled')); ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">Password:</td>
                    <td width="74%">
                    <?php echo $this->Form->input('User.password',array('class'=>'inputbox1','label'=>false,'div'=>''));?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">Confirm Password:</td>
                    <td width="74%">
                    	<?php echo $this->Form->input('User.cpassword',array('class'=>'inputbox1','label'=>false,'div'=>'','type'=>'password'));?>
                    </td>
                  </tr>
                  
                   <tr>
                    <td width="25%" valign="middle" align="right">Confidentiality:</td>
                    <td width="74%">
                    	<?php echo $this->Form->input('Candidate.candidate_privacy',array('type'=>'checkbox','div'=>false,'label'=>false)); ?>
                    Check here to keep your name and contact info confidential: (Only your e-mail will be revealed).
                    </td>
                  </tr>
                  
                  
                     
                </tbody>
              </table>
              <br /><br />
               
               
                <table cellspacing="0" cellpadding="0" border="0">
                <tbody>
                	<tr>
                    <td width="25%" valign="middle" align="left" colspan="2"><h2>Professional Profile</h2></td>
                    
                  </tr>
                
                  <tr>
                    <td width="25%" valign="middle" align="right">Number of years of solid professional experience: </td>
                    <td width="74%">                    
                     <?php 
                        echo $this->Form->input('Candidate.experience_code',array('type'=>'select','options'=>$experienceArray,'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','class'=>'listbox'));
                        ?>&nbsp;&nbsp; Years
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">What is your citizenship status ?</td>
                    <td width="74%">
                    <?php 
                        echo $this->Form->input('Candidate.citizen_status_code',array('type'=>'select','options'=>$citizenshipArray,'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','class'=>'listbox'));
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">Do you have current or have you had governmental security clearance in the last 24 months ? </td>
                    <td width="74%">
                    	 <?php 
                        echo $this->Form->input('Candidate.security_clearance_code',array('type'=>'select','options'=>$govenmentclearanceArray,'multiple'=>'multiple','label'=>false,'class'=>'select1','div'=>'','class'=>'listbox'));
                        ?>
                        <br />
                         (Hold down the control/command key to select multiple industries)
                    </td>
                  </tr>
                  
                  
                   <tr>
                    <td width="25%" valign="middle" align="right">
                    	What is your military rank (if applicable) ? 
                    </td>
                    <td width="74%" valign="middle" align="left">
                    		 <?php echo $this->Form->input('Candidate.candidate_military_rank',array('class'=>'smallTextB','class'=>'inputbox1','label'=>false,'border'=>'none','div'=>''));?>
                   	</td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">
                    When would you be available to start working ?
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$noticeperidArray,'label'=>false,'class'=>'select1','div'=>'','class'=>'listbox','class'=>'listbox'));                ?>

                    </td>
                  </tr>
                  
                  <tr>
                    <td width="25%" valign="middle" align="right">
                    	Optional - Indicate your last salary / compensation:
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<table>
                        	<tr>
                            	<td width="20%"> <?php echo $this->Form->input('Candidate.last_salary',array('class'=>'inputbox1','label'=>false,'div'=>''));?></td>
                                <td>
                                <!--<select name="">
                              <option selected="selected">N/A</option>
                            </select>-->
                            
                            </td>
                            </tr>
                        </table>
                    </td>
                  </tr>
                  
                  
                   <tr>
                    <td width="25%" valign="middle" align="right">
                    	Which industries do you have experience in ?
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
                        echo $this->Form->input('Candidate.pref_industries',array('type'=>'select','options'=>$industriesArray,'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','multiple'=>'multiple','class'=>'listbox'));
                        ?><br />
                         (Hold down the control/command key to select multiple industries)
                    </td>
                  </tr>
                  
                   <tr>
                    <td width="25%" valign="middle" align="right">
                    	Are you willing to relocate to other parts of the US ?
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
                        $option=array('Y'=>'Yes','N'=>'No');
                        echo $this->Form->input('Candidate.relocate',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','class'=>'listbox'));
                        ?>
                    </td>
                  </tr>
                  
                   <tr>
                    <td width="25%" valign="middle" align="right">
                    	If you are willing to relocate, which states do you prefer to work in ? 
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
                        echo $this->Form->input('Candidate.pref_locations',array('type'=>'select','options'=>$statList,'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','multiple'=>'multiple','class'=>'listbox'));
                        ?><br />
                        (Hold down the control/command key to select multiple industries) 
                    </td>
                  </tr>
                  
                  
                  <tr>
                    <td width="25%" valign="middle" align="right"></td>
                    <td width="74%" valign="middle" align="left">
                   
                    <?php
                     echo $this->Form->input('User.username',array('type'=>'hidden','div'=>false,'label'=>'false'));
                     echo $this->Form->input('Candidate.id',array('type'=>'hidden','div'=>false,'label'=>'false'));
                     echo $this->Form->input('User.id',array('type'=>'hidden','div'=>false,'label'=>'false'));
                     echo $this->Form->input('Candidate.SUBMIT',array('type'=>'hidden','div'=>false,'label'=>'false','value'=>'UPDATE'));
                     echo $this->Form->submit('images/update.png',array('class'=>'delete_btn')); 
                 ?> 
                    </td>
                  </tr>
                </tbody>
              </table>
              
            <?php $this->end();?>
            </div>
          </div>
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>