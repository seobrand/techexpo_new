<?php echo $this->element('ajax', array('cache' => true)); 
$countryList=$common->getCountryList();
?>
<script type="text/javascript">
function addkeyword(id,name,number)
{
	if(id=='addNewSkill')
	{
		$('#linkSkill').trigger('click');
		document.getElementById("number").value=number;
	}
}


function validationCheck()
{
		var validation='';
		var skill = document.getElementById("skill").value;
		var number = document.getElementById("number").value;
		if(skill=='')
		{	
			validation +='Please Enter Skill Keyword\n';
		}
		
		
		if(validation)
		{
			alert(validation);
			return false;
		}else
		{
			$.ajax({
               type:"GET",
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>employers/addSkill?name="+skill+"&number="+number,
               success : function(data) {
            	//alert("skillDropdown"+number);if(data=='<div style="color:red">This keyword already exits in our database</div>')
				if(data=='<div style="color:red">This keyword already exits in our database</div>')
				{
					document.getElementById("succMSG").innerHTML=data;
				}else
				{
					document.getElementById("skillDropdown"+number).innerHTML=data;
					document.getElementById("succMSG").innerHTML='New Keyword has been added successfully';
				}
				setTimeout(function() {
      									  $("#cboxClose").click()
  						 			 }, 1500);
			   },
               error : function() {
			   alert('error')
               },
           })
		   
		   document.getElementById("succMSG").innerHTML='';
		   document.getElementById("skill").value='';
		   
		   
		   return false;
		}

		
	}

$(document).ready(function() {
	
	<?php 
	if(empty($this->request->data['JobPosting']['location_country']))
	{
		$this->request->data['JobPosting']['location_country']=15;
	}

	if(!empty($this->request->data['JobPosting']['location_country']))
	{?>
		var countryId="<?php echo $this->request->data['JobPosting']['location_country']; ?>";
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

</script>
<?php   
// for facny box
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
?>
<script>
			$(document).ready(function(){
				$(".inline").colorbox({inline:true, width:"35%"});
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
			
		</script>
<style>
ul {
	margin: 0;
}
#contentLeft {
	float: left;
}
#contentLeft li {
	list-style: none;
}
</style>
<?php //pr($this->request->data);?>
<?php if(isset($this->request->data['JobPostingSkill']) && count($this->request->data['JobPostingSkill'])>0){
	$keywordsData = $this->request->data['JobPostingSkill'];
	foreach($keywordsData as $key =>$keywordData ){
	//pr($keywordData);die;
		$this->request->data['JobPosting']['skill'.($key+1)] = $keywordData['skill_id'];
		$this->request->data['JobPosting']['importance'.($key+1)] = $keywordData['importance'];
		$this->request->data['JobPosting']['experiencecode'.($key+1)] = $keywordData['experience_code'];
		$this->request->data['JobPosting']['lastusedcode'.($key+1)] = $keywordData['last_used_code'];
	}
	
	$totalKeywordsData =count($keywordsData);
}else{
	//$keywordsData = array('jobPostingSkill'=>0);
	$totalKeywordsData =$totalSkills;
	
}
?>
<div id="wrapper">
  <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Edit Job</h1>
		  <div style="color:#FF0000;margin:0 0 0 20px;"><?php echo $errorMSG; ?></div>
		  <?php echo $this->Form->create(array('name'=>'empjobposting','id'=>'empjobposting'));?>
          
          <div class="content">
            <h2 class="mana_subheading">1. Please enter a Title &amp; Short Description (2-3 lines)</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form ">
                <li>
                  <label>Position Title:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('JobPosting.job_title',array('label'=>false,'div'=>false,'class'=>'big237_textfield','style'=>'width:229px!important;'));?>
                  </div>
                </li>
                <li>
                  <label>Short Description:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('JobPosting.short_descr',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'textarea_237'));?>
                  </div>
                </li>
              </ul>
            </div>
            <br />
            <h2 class="mana_subheading">2. Please enter an e-mail where resumes are to be sent to for this position. It defaults to the e-mail address you entered in your recruiter profile, but you can change it here if you want someone else to receive resumes for this position.</h2>
            <p><strong>NOTE:</strong> <span class="instruction">You can also enter a web link in the form <span class="red">http://something.yourdomain.com (or .net, .org, .mil, .us... etc)</span>. In both cases; you must specify what type of address you are entering in the pull-down menu.</span></p>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <p>E-mail or web address to send resumes to for this position:</p>
              <ul class="form_list manage_resume_form form_padding_top">
                <li>
                  <label>Type of address:</label>
                  <div class="form_rt_col1">
                    <div class="dropdown_resume4">
                      <?php echo $this->Form->input('JobPosting.address_type',array('type'=>'select','options'=>array('e'=>'E-mail','w'=>'Website'),'label'=>false,'div'=>false,'onchange'=>'displayField(this.value)'));?>
                    </div>
                    <span class="instruction">If you are entering a web site address, it must a fully qualified URL in the form: <span class="red">http://something.yourdomain.com (or .net, .org, .mil, .us... etc)</span></span> </div>
                </li>
                <li>
                  <label>Address:</label>
                  <div class="form_rt_col1" id="emailaddress">
				  <?php if(isset($this->request->data['JobPosting']['address_type']) && $this->request->data['JobPosting']['address_type']=='e'){?>
                    <?php echo $this->Form->input('JobPosting.job_email',array('id'=>'e_id','type'=>'text','label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
					<?php echo $this->Form->input('JobPosting.job_url',array('id'=>'w_id','type'=>'text','label'=>false,'div'=>false,'class'=>'big237_textfield','style'=>'display:none'));?>
				 <?php }else{?>
				 <?php echo $this->Form->input('JobPosting.job_email',array('id'=>'e_id','type'=>'text','label'=>false,'div'=>false,'class'=>'big237_textfield','style'=>'display:none'));?>
					<?php echo $this->Form->input('JobPosting.job_url',array('id'=>'w_id','type'=>'text','label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
				<?php }?>
                  </div>
                </li>
              </ul>
              <div class="clear"></div>
            </div>
            <br />
            <h2 class="mana_subheading">3. You can make a job active or inactive. Inactive jobs are not visible by job seekers when searching for jobs. You can use this feature to temporarily disable a posting and re-activate it later without having to re-enter all the information.</h2>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Is this job active ?</label>
                  <div class="form_rt_col1">
                    <div class="dropdown_resume4">
                      <?php echo $this->Form->input('JobPosting.active',array('type'=>'select','options'=>array('1'=>'Yes','0'=>'No'),'label'=>false,'div'=>false));?>
                    </div>
                  </div>
                </li>
              </ul>
              <div class="clear"></div>
            </div>
            <br />
            <h2 class="mana_subheading">4. Would you like to receive automatic weekly e-mails with fresh resumes matching your job ? Note that you must have purchased resume access for the current quarter for this to work. To purchase resume databases call Nancy Mathew at 212.655.4505 ext. 225 or e-mail <a href="mailto:nmathew@TechExpoUSA.com">nmathew@TechExpoUSA.com.</a> </h2>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Receive automatic e-mails with matching resumes for this job ?</label>
                  <div class="form_rt_col1">
                    <div class="dropdown_resume4">
                      <?php echo $this->Form->input('JobPosting.agent',array('type'=>'select','options'=>array('y'=>'Yes','n'=>'No'),'label'=>false,'div'=>false));?>
                    </div>
                  </div>
                </li>
              </ul>
              <div class="clear"></div>
            </div>
            <br />
            <h2 class="mana_subheading">5. Keywords </h2>
            <br />
            <p> <strong>Please fill out your keyword information carefully.</strong></p>
            <ul class="list">
              <li>This is very important for the resume matching process.</li>
              <li>You can enter 1-5 keywords.</li>
       <!--       <li>If you wish to see skills added to the list or have comments about this form, <a href="mailto:nmathew@TechExpoUSA.com">click here</a></li>-->
            </ul>
			<?php for($i=1;$i<=5;$i++){?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0" id="keyword_add_more_<?php echo $i;?>" <?php if($i<=$totalKeywordsData){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
			<?php if($i==1){?>
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="258" style="text-align:left">Keyword</th>
                      <th width="153" style="text-align:center">Years of Exp.</th>
                      <th width="139" style="text-align:center">Last Used</th>
                      <th width="114" style="text-align:center">Skill Importance</th>
                    </tr>
                  </table></td>
              </tr>
			 <?php }?>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="223" style="text-align:left">
					  	<div class="dropdown_resume1" id="skillDropdown<?php echo $i;?>">
						   <?php
                         
                           $skills['addNewSkill']='Add New Skill';
					  	   $skills=$skills + $common->getKeywordList();
                           echo $this->Form->input('JobPosting.skill'.$i,array('type'=>'select','options'=>$skills,'label'=>false,'div'=>false,
                                                            'empty'=>'Please select skill','onChange'=>'addkeyword(this.value,this.name,'.$i.')'));
                           ?>
                        
                        </div></td>
                      <td  width="153" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                          <?php echo $this->Form->input('JobPosting.experiencecode'.$i,array('type'=>'select','options'=>$experience,'label'=>false,'div'=>false));?>
                        </div></td>
                      <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                          <?php echo $this->Form->input('JobPosting.lastusedcode'.$i,array('type'=>'select','options'=>$lastusedcode,'label'=>false,'div'=>false));?>
                        </div></td>
                      <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                          <?php echo $this->Form->input('JobPosting.importance'.$i,array('type'=>'select','options'=>$importance,'label'=>false,'div'=>false));?>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
			<?php } ?>
            
           
            	<input type="hidden" value="<?php echo $totalKeywordsData;?>" id="KeywordCount" name="data[JobPosting][count]">
            
			
            
			<div style="float:right;"><a href="javascript:void(0)" onclick="addKeywords()">Add More</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="removeKeywords()" style="display:none;float:right" id="remove">Remove</a></div>
            <br />
            <h2 class="mana_subheading">6. Location of the Job </h2>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
              <li>
                  <label><!--<span class="red">*</span>-->Country:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown" style="clear:both">
                      <?php 
                       echo $this->Form->input('JobPosting.location_country',array('type'=>'select','options'=>$countryList,
					   															'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','onChange'=>'onChangeAjaxGet1("users/state",this.value,"stateDropdown")'));
                      ?>
                        <br /> <br />
                    </div>
                  </div>
                </li>
              
              <li>
                  <label>State/Province:</label>
                  <div class="form_rt_col1">
                   
                    <div  style="clear:both" id="dropdown">
                   		 <div class="even_reg_dropdown"> 
						 <?php 
                           echo $this->Form->input('JobPosting.location_state',array('type'=>'select','empty'=>false,'options'=>$statList,
                                                                                    'empty'=>false,'label'=>false,'class'=>'select1','div'=>'','id'=>'stateDropdown'));
                          ?>
                          
                     </div>
                    </div>
                    
                    <div  style="clear:both;display:none" id="textbox" >
                    	<div class="form_rt_col1" > 
                        	  <?php echo $this->Form->input('JobPosting.location_state22',array('class'=>'big237_textfield','label'=>'','border'=>'none','div'=>'','id'=>'cityTextbox','style'=>'width:248'));?> 
                         </div>
                    </div>
                    
                  </div>
                </li>
              
              <li>
                  <label >City:</label>
                  <div class="form_rt_col1">
                    
                    <div >  
                    
	  <?php echo $this->Form->input('JobPosting.location_city',array('label'=>false,'div'=>false,'class'=>'big237_textfield','style'=>'width:248'));?></div>
                    <div class="clear"></div>
                  </div>
                </li>

                <!--<li>
                  <label style="width:145px;">Position Location:</label>
                  <div class="form_rt_col1" style="width:435px;">
                    <div class="dropdown_resume2 float_left margin_zero">
                      <?php 
					 echo $this->Form->input('JobPosting.location_state',array('type'=>'select','options'=>$states,'label'=>false,'div'=>false));?>
                    </div>
                    <div class="second_label" style="width:35px"> City:</div>
                      <div id="cityDiv">  
                   


                      <?php echo $this->Form->input('JobPosting.location_city',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?></div>
					  
                    <div class="clear"></div>
                  </div>
                </li>-->
              </ul>
              <div class="clear"></div>
            </div>
            <br />
            <h2 class="mana_subheading">7. Position Type &amp; Salary </h2>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Position Type:</label>
                  <div class="form_rt_col1">
                    <div class="dropdown_resume1 float_left margin_zero">
                      <?php echo $this->Form->input('JobPosting.work_type_code',array('type'=>'select','options'=>$worktype,'label'=>false,'div'=>false));?>
                    </div>
                    <div class="second_label" style="width:45px"> Hours:</div>
                    <div class="dropdown_resume4 float_left">
                     <?php echo $this->Form->input('JobPosting.work_time_code',array('type'=>'select','options'=>$worktime,'label'=>false,'div'=>false));?>
                    </div>
                    <div class="clear"></div>
                  </div>
                </li>
                <li>
                  <label>Location:</label>
                  <div class="form_rt_col1">
                    <div class="dropdown_resume1 float_left margin_zero">
                      <?php echo $this->Form->input('JobPosting.work_location_code',array('type'=>'select','options'=>$worklocation,'label'=>false,'div'=>false));?>
                    </div>
                    <div class="clear"></div>
                  </div>
                </li>
                <li>
                  <label>Salary:</label>
                  <div class="form_rt_col1">
                    <div class="float_left margin_zero" style="width:237px">
                      <?php echo $this->Form->input('JobPosting.last_salary',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                    </div>
                    <div class="dropdown_resume4 float_left">
                      <?php echo $this->Form->input('JobPosting.salary_type_code',array('type'=>'select','options'=>$salarytype,'label'=>false,'div'=>false));?>
                    </div>
                    <div style="clear:both">
                      <!--<strong>Format 99999.00 - do not include commas</strong>-->
                      </div>
                    <div class="clear"></div>
                  </div>
                </li>
              </ul>
              <div class="clear"></div>
            </div>
            <br />
            <h2 class="mana_subheading">8. Security Clearance Required ?</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label></label>
                	<div class="form_rt_col1">                
                    <div>
					<?php					   
					  $security_clearance=array('1'=>'&nbsp;Yes&nbsp;&nbsp;&nbsp;','0'=>'&nbsp;No');
					  $default_val = (is_array($this->request->data('JobPosting.security_clearance_code'))) ? "1" : "0";
                      echo $this->Form->input('JobPosting.security',array('type'=>'radio','options'=>$security_clearance,'default'=>$default_val,'label'=>false,'class'=>'select1','div'=>false,'legend' => false));
                     ?> 
                    </div>
                    <div class="error-message"><?php echo $securityClearanceError;?></div>
                    <div class="clear"></div>
                  </div><br /> <br />
                  <label>Select an option:</label>
                  <div class="form_rt_col1">
	                    <div class="checkbox_div checkbox_large_div">
	                     <div class="checkbox_list">
	                       <?php 
							 echo $this->Form->input('JobPosting.security_clearance_code',array('type'=>'select','multiple'=>'checkbox','options'=>$ck,'label'=>false,'div'=>false,'hiddenField' => false)); 
						   ?>
						 </div>
						 </div>
		                 <div class="clear"></div>		                
	               </div>
                  <!-- <div class="form_rt_col1">
                    <div class="listbox1">
					<?php echo $this->Form->input('JobPosting.security_clearance_code',array('type'=>'select','options'=>$ck,'multiple'=>true, 'size'=>'5','label'=>false,'div'=>false));?>
                    </div>
                    <div class="clear"></div>
                    <span class="instruction">Hold down the control / command key to select several options <br />
                    </span>
                    <div class="clear"></div>
                  </div> -->
                </li>
              </ul>
            </div>
            <br />
            <h2 class="mana_subheading">9. Please enter a detailed job description.</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Full Description:</label>
                  <div class="form_rt_col1">
				  <?php echo $this->Form->input('JobPosting.full_descr',array('label'=>false,'div'=>false,'class'=>'big_textarea'));?>
                    <div class="clear"></div>
                  </div>
                </li>
              </ul>
            </div>
            <div class="submit_btn">
			<?php echo $this->Form->submit('images/submit.jpg',array('div'=>false,'name'=>'Submit'));?>
            </div>
          </div>
		  <?php echo $this->Form->input('JobPosting.posting_id',array('type'=>'hidden','value'=>$this->request->data['JobPosting']['posting_id']));?>
		  <?php echo $this->Form->end();?>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel');?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?>
  </div>
</div>
<script type="text/javascript">
  function displayField(val){
		
		if(val=='e'){
			document.getElementById('e_id').style.display = 'block';
			document.getElementById('w_id').style.display = 'none';
		}else{
			document.getElementById('w_id').style.display = 'block';
			document.getElementById('e_id').style.display = 'none';
		}
  }
  
var Ccontent ='';
var count = parseInt(document.getElementById('KeywordCount').value);

function addKeywords() {
	var i = count+1;
	if(count<=4){
		document.getElementById("keyword_add_more_"+i).style.display = 'block';
		count = count + 1;
		if(count>1){
			document.getElementById("remove").style.display = 'block';
			document.getElementById("KeywordCount").value = i;
		}
		
	}else{
		alert("Sorry you can only add total of 5 keywords set");
	}

}

function removeKeywords(){
	document.getElementById("keyword_add_more_"+count).style.display = 'none';
	count = count - 1;
	document.getElementById("KeywordCount").value = count;
	
	if(count==1){
		document.getElementById("remove").style.display = 'none';
	}
	
}

</script>


<a class='inline' href="#inline_content" id="linkSkill" style="display:none">Inline HTML</a>

<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
            <div id="succMSG" style="color:#003300"></div>
            	<div style='margin:0 auto; width:400px;'>
                <br/>  <br/>
                <form action="" method="post">
                Add New Skill :
                <input type="text" name="skill" id="skill" class="input_208" style="width:178px" />
                <input type="hidden" name="number" value="number" id="number"/>
                <span style="vertical-align:top;">
                <input type="image" name="SUBMIT" value="SUBMIT"  onclick="return validationCheck();" src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/send.jpg"/>
                </span>
                </form>

			</div>
</div></div>