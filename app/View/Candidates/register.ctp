<?php echo $this->element('ajax', array('cache' => true)); 
echo $this->element('numberformat', array('cache' => true));
$countryList=$common->getCountryList();
$militaryList=$common->getMilitaryList();
//pr($this->request->data['Candidate']);
?>
<script type="text/javascript">
function deleteimage(image)
{
	var CnfrmDelte=confirm('Are you sure you want to delete this image?');
	
	if(CnfrmDelte == true)
	{
		$.ajax({
               type:"POST",
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>users/deleteimage?image="+image,
               success : function(data) {
			   
            	document.getElementById("response").innerHTML = data; 
				document.getElementById("images").value =''; 
				
				
				
			   },
               error : function() {
			   alert('error')
               },
           })
    }
	return false;
}

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
		//$("#"+updateDiv).removeClass('even_reg_dropdown');
		//$("#"+updateDiv).addClass('form_rt_col1');
		$('#textbox').css('display','block');
		$('#dropdown').css('display','none');
		
		
		//document.getElementById('changeTextbox').innerHTML='<div class="form_rt_col1" > <input id="stateDiv" class="input_208" type="text" border="none" maxlength="255" name="data[Candidate][candidate_state]" ></div>';
	}
}

function uploader()
{

	//document.getElementById("randomdiv").innerHTML = res; 
	$("#randomdiv").css("display", "block");
	
	var candidateimage=document.getElementById('candidateimage').value;
	formdata = false;
	var demo=document.getElementById("images").files;
	
	if (window.FormData) {
  		formdata = new FormData();
  		}
		
 		var i = 0, len = demo.length, img, reader, file;
		for ( ; i < len; i++ ) {
			file = demo[i];
			if (file.type.match(/image.*/)) {
				if (formdata) {
					formdata.append("images[]", file);
					
				}
			}	
		}
		
		if (formdata) {
			$.ajax({
				url: "<?php echo FULL_BASE_URL.router::url('/',false);?>upload.php?image="+candidateimage,
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (res) {
					$("#randomdiv").css("display", "none");
					document.getElementById("response").innerHTML = res; 
				}
			});
		}
	
	
	
}
</script>

<div id="wrapper">
  <div class="inner_banner">
    <?php $bannerDt = $common->getbannerImage('3');   ?>
    <div class="static_inner_banner">
      <div class="static_title_bar">
        <p><?php echo $bannerDt['OtherBanner']['name']; ?></p>
      </div>
      <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  /> </div>
  </div>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Create New Account </h1>
          <div class="content">
            <div class="tab_panel_4">
              <ul>
                <li class="firstTab"><?php //echo $this->Html->link("Create New Profile",array('controller'=>'candidates','action'=>'register')); ?></li>
               <li class="firstTab"><a href="<?php echo FULL_BASE_URL.router::url('/',false);?>jobseeker_register"> Create <br />New Profile
                 </a></li>
              
                <li class="secondTab"><a>Post <br />
                  Your Resume</a></li>
                <li class="thirdTab"><a>Register <br />
                  For an Event</a></li>
                <li class="fourthTab"><a>Thank You</a></li>
              </ul>
              <div class="clear"></div>
            </div>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <div class="profile_panel"> <?php echo $this->Form->create('Candidate',array('action'=>'register', 'enctype' => 'multipart/form-data')); ?>
                 <div style="width:250px;font:#2D2D2D"><ul class="form_list manage_resume_form label_small">
<li>Upload Your Profile Image</li>
</ul>
                 </div>
                <div class="profile_img">
               
                <div id="randomdiv" style="position:absolute;margin:20px 0 0 60px;display:none"><img src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/loading.gif"  width="70" height="" /></div>
                  <?php if(!empty($this->request->data['Candidate']['candidate_image'])) {?>
                  <div id="response">
				  
                  
				  
				  <?php echo $this->Html->image('upload/'.$this->request->data['Candidate']['candidate_image']); ?> <img src="<?php echo FULL_BASE_URL.router::url('/',false).'/upload/150x80_'.$this->request->data['Candidate']['candidate_image'];?>" style="width:160px" height="115px;" border="0"/>
                    <input  type="hidden" value="<?php echo $this->request->data['Candidate']['candidate_image']; ?>" name="data[Candidate][candidate_image]" id="candidateimage">
                  </div>
                  <?php } else
				 {?>
                  <div id="response"><?php echo $this->Html->image('images/new_account_pic.jpg'); ?>
                    <input  type="hidden" name="data[Candidate][candidate_image]" id="candidateimage">
                  </div>
                  <?php } ?>
                  <br />
                  <input type="file" name="images" id="images" onChange="uploader();" multiple style="width:200px;"/>
                </div>
              </div>
              <ul class="form_list manage_resume_form label_small">
                <li>
                  <label><span class="red">*</span>Username:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('User.username',array('class'=>'input_208','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                <li>
                  <label><span class="red">*</span>Password:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('User.password',array('class'=>'input_208','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                <li>
                  <label><span class="red">*</span>Confirm Password:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('User.cpassword',array('type'=>'password','class'=>'input_208','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                <li>
                  <label><span class="red">*</span>First Name:
                  		
                      <?php 
					  $gender=array('Mr.'=>'Mr.','Mrs.'=>'Mrs.','Ms.'=>'Ms.');
                       echo $this->Form->input('Candidate.candidate_gender',array('type'=>'select','options'=>$gender,
					   															'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','style'=>'width:50px;'));
                      ?>
                  </label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.candidate_fname',array('class'=>'input_208','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                <li>
                  <label><span class="red">*</span>Last Name:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.candidate_lname',array('class'=>'input_208','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                <!--<li>
                  <label><span class="red">*</span>Title:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.candidate_title',array('class'=>'input_208','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>-->
                <li>
                  <label><span class="red">*</span>Phone:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.candidate_phone',array('id'=>'mobilenumber','class'=>'input_208','label'=>'','border'=>'none','div'=>'','onkeypress'=>"return isNumericKey(event);"));?> </div>
                </li>
               <!-- <li>
                  <label>Fax:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.candidate_fax',array('class'=>'input_208','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>-->
                <li>
                  <label><span class="red">*</span>Email:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.candidate_email',array('class'=>'input_208','type'=>'text','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                
                <li>
                  <label>Alternate Email:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.candidate_secondary_email',array('class'=>'input_208','type'=>'text','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                
               
                
              
                 <li>
                  <label><!--<span class="red">*</span>-->Country:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown" style="clear:both">
                      <?php 
                       echo $this->Form->input('Candidate.country_code',array('type'=>'select','options'=>$countryList,
					   															'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','onChange'=>'onChangeAjaxGet1("users/state",this.value,"stateDropdown")'));
                      ?>
                        <br /> <br />
                    </div>
                  </div>
                </li>
                
                <li>
                  <label><span class="red">*</span>Address:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.candidate_address',array('class'=>'input_208','type'=>'text','label'=>'','border'=>'none','div'=>''));?>                   </div>
                </li>
                
                <li>
                  <label><span class="red">*</span>City:</label>
                  <div class="form_rt_col1" id="cityDiv"> <?php echo $this->Form->input('Candidate.candidate_city',array('class'=>'input_208','label'=>'','border'=>'none','div'=>''));?>                  </div>
                </li>
                
                
             	 <li>
                  <label><span class="red">*</span>State/Province:</label>
                  <div class="form_rt_col1">
                   
                    <div  style="clear:both" id="dropdown">
                   		 <div class="even_reg_dropdown"> 
						 <?php 
                           echo $this->Form->input('Candidate.candidate_state',array('type'=>'select','empty'=>false,'options'=>$statList,
                                                                                    'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','id'=>'stateDropdown'));
                          ?>
                          
                     </div>
                    </div>
                    
                    <div  style="clear:both;display:none" id="textbox" >
                    	<div class="form_rt_col1" > 
                        	  <?php echo $this->Form->input('Candidate.candidate_state22',array('class'=>'input_208','label'=>'','border'=>'none','div'=>'','id'=>'cityTextbox'));?> 
                         </div>
                    </div>
                    
                  </div>
                </li>
                   
                   
                     <!--,'onkeypress'=>"return allowNoAlpha(event);"  -->     
                
                <li>
                  <label><span class="red">*</span>Zip:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.candidate_zip',array('class'=>'input_208','label'=>'','border'=>'none','div'=>'','onkeypress'=>"return isNumericKey(event);"));?> </div>
                </li>
               
               
                  <li>
                  <label>
                 Security Clearance:<span class="red">*</span>
                <span style="font-size:11px;color:#2D2D2D;" > <br/><br/> Please indicate any government security clearance you currently have or have had in the past 24 months </span> </label>
                  <div class="form_rt_col1">
                    <div class="form_rt_col1" style="clear:both">
                    
                     <div class="candidateRegister">
                   		 <div class="checkbox_div1"  style="height:110px">
                   		 <div class="checkbox_list" style="height:110px">
                      <?php 
					  	$govenmentclearanceArray=$common->getGovCleareanceList();
				
                    echo $this->Form->input('Candidate.security_clearance_code',array('type'=>'select','options'=>$govenmentclearanceArray,'multiple'=>'checkbox','error'=>false,'label'=>false,'class'=>'select1','div'=>''));
                    ?>
                 
                    
                    		</div>
                            </div>
                            </div>
                            <div style="clear:both;color:red;width:300px !important"><?php echo $this->Form->error('security_clearance_code',null,array('class'=>'')); ?></div>
                        
                    </div>
                  </div>
                </li>
                
               
               
               	<li>
                  <label>Military Service:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown" style="clear:both">
                      <?php 
                       echo $this->Form->input('Candidate.military_service',
					   							array('type'=>'select','options'=>$militaryList,
					   								'empty'=>'-Select Military Services-','label'=>false,'class'=>'select1','div'=>''));
                      ?>
                        <br /> <br />
                    </div>
                  </div>
                </li>
                
                
                	<li>
                  <label>Military Status:</label>
                  <div class="form_rt_col1">
                    <div class="form_rt_col1" style="clear:both">
                      <?php 
					  $military_service_status=array('1'=>'&nbsp;Active&nbsp;&nbsp;&nbsp;','0'=>'&nbsp;Inactive');
                      echo $this->Form->input('Candidate.military_service_status',array('type'=>'radio','options'=>$military_service_status,
					   																'label'=>false,'class'=>'select1','default'=>'0','div'=>false,'label'=>false,'legend' => false,));
                     ?>
                        <br /> <br />
                    </div>
                  </div>
                </li>
                
             
                
               
               
                   <li>
                  <label>LinkedIn Profile:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.linkedin',array('class'=>'input_208','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
               
               
                <li>
                  <label>Twitter:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Candidate.twitter',array('class'=>'input_208','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                
            
               <li>
                 <label></label>
                  <div class="form_rt_col1 termsConditions" >
                 	<?php $termsofuse = Router::url('/',true).'users/termsofuse'; ?>
                 	 <?php echo $this->Form->input('Candidate.terms',array('type'=>'checkbox','label'=>'I agree to the <a href="'.$termsofuse.'" target="_blank">User Terms and Privacy Policy</a>','border'=>'none','div'=>''));?>
                   </div>
                 </li>
                 
               
                <li>
                  <label></label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('User.user_type',array('value'=>'C','type'=>'hidden'));
                      echo $this->Form->input('Candidate.REGISTER',array('name'=>'candidate.REGISTER','value'=>'REGISTER','type'=>'hidden'));
                      echo $this->Form->submit('images/submit.jpg');?>                  </div>
                </li>
                
              
                
                 <li>
                 <label></label>
                  <div class="form_rt_col1 termsConditions" >
                 
                <!--   	 <span style="margin-left:5px;"> <strong>Disclaimer : </strong>"TechExpo will never share your information"</span>       -->  
                   </div>
                 </li>
              </ul>
            <?php echo  $this->Form->end(); ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="rt_col_inner">
		<?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
  </div>
  <div class="clear"></div>
  <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
