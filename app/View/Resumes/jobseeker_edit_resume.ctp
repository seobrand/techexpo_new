<?php //echo $this->element('tinymce', array('cache' => true));

//pr(count($this->request->data['ResumeSkill']));
 ?>
<?php echo $this->element('wordcounter', array('cache' => true)); ?>
<?php
 if(empty($this->request->data['Update'])){
 
 if(isset($this->request->data['ResumeSkill']) && count($this->request->data['ResumeSkill'])>0)
 {
	$keywordsData = $this->request->data['ResumeSkill'];
		
	foreach($keywordsData as $key =>$keywordData ){
	//pr($keywordData);die;
		$this->request->data['ResumeSkill'][$key+1]['id'] = $keywordData['id'];
		$this->request->data['ResumeSkill'][$key+1]['resume_id'] = $keywordData['resume_id'];
		$this->request->data['ResumeSkill'][$key+1]['skill_id'] = $keywordData['skill_id'];
		$this->request->data['ResumeSkill'][$key+1]['experience_code'] = $keywordData['experience_code'];
		$this->request->data['ResumeSkill'][$key+1]['last_used_code'] = $keywordData['last_used_code'];
		$this->request->data['ResumeSkill'][$key+1]['level_code'] = $keywordData['level_code'];
		$this->request->data['ResumeSkill'][$key+1]['skill_value'] = $keywordData['skill_value'];
		
		
	}
	unset($this->request->data['ResumeSkill']['0']);
  }else{
	$keywordsData = array('ResumeSkill'=>0);
	}
}else
{

	 if(isset($this->request->data['ResumeSkill']) && count($this->request->data['ResumeSkill'])>0)
	 {
	$keywordsData = $this->request->data['ResumeSkill'];
		
	foreach($keywordsData as $key =>$keywordData ){
	//pr($keywordData);die;
		$this->request->data['ResumeSkill'][$key]['id'] = $keywordData['id'];
		$this->request->data['ResumeSkill'][$key]['resume_id'] = $keywordData['resume_id'];
		$this->request->data['ResumeSkill'][$key]['skill_id'] = $keywordData['skill_id'];
		$this->request->data['ResumeSkill'][$key]['experience_code'] = $keywordData['experience_code'];
		$this->request->data['ResumeSkill'][$key]['last_used_code'] = $keywordData['last_used_code'];
		$this->request->data['ResumeSkill'][$key]['level_code'] = $keywordData['level_code'];
		$this->request->data['ResumeSkill'][$key]['skill_value'] = $keywordData['skill_value'];
		
		
	}
	unset($this->request->data['ResumeSkill']['0']);
  	}else{
	$keywordsData = array('ResumeSkill'=>0);
	}
}

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
               url:"<?php echo FULL_BASE_URL.router::url('/',false);?>Jobseeker/candidates/addSkill?name="+skill+"&number="+number,
               success : function(data) {
            	//alert("skillDropdown"+number);
				document.getElementById("skillDropdown"+number).innerHTML=data
				document.getElementById("succMSG").innerHTML='New Keyword has been added successfully'
				
				setTimeout(function() {
      									  $("#cboxClose").click()
  						 			 }, 1200);
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

function checkTotalResume(total)
{
	var totalResume=total;
	if(total>=3)
	{
		alert('Do not have a rights to upload more than 3 resume');
		return false;
	}else
	{
		return true;
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
<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container"> <?php echo $this->Form->create('Resume',array('action'=>'edit_resume/', 'enctype'=>'multipart/form-data')); ?>
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Submit/Edit Resume</h1>
          <div class="error-message"><?php echo $topError;?></div>
          <div class="content"> <?php echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
            <h2 class="mana_subheading">1. Please enter a Title for your Resume &amp; Provide a Short Career summary (2-3 lines)</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Resume Title:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Resume.resume_title',array('class'=>'big237_textfield','label'=>false,'div'=>'','id'=>'resume_title'));?> <br />
                    <strong>Example:</strong><span class="instruction"> "Experienced Database Administrator. Oracle certified."</span></div>
                </li>
                <li>
                  <label>My professional profile can be summarized as:</label>
                  <div class="form_rt_col1" style="overflow:hidden"> <?php echo $this->Form->input('Resume.resume_summary',array('class'=>'textarea_237','type'=>'textarea','label'=>false,'div'=>false,'style'=>'width:400px;overflow:hidden;height:80px;','id'=>'resume_summary'));?> <br />
                    <strong>Example: </strong><span class="instruction">"A database professional with over 10 years of strong design, administration &amp; optimization experience. Expert with SQL Server and Oracle systems."</span></div>
                </li>
              </ul>
            </div>
            <br />
            <br />
            <h2 class="mana_subheading">2. Please provide keywords to attach to your resume. Keywords should represent your CORE or main skills.</h2>
            <p><strong>Please fill out your keyword information carefully.</strong></p>
            <ul class="listing_arrow">
              <li> This is very important for the job matching and automatic scoring process.</li>
              <li>You can enter 1-5 keywords.</li>
              <!--          <li>If you wish to see skills added to the list or have comments about this form, <a href="">click here</a>. </li>-->
            </ul>
            <?php
			//echo '<pre>';
			//print_r($this->request->data);
			  for($i=1;$i<=5;$i++)
				{
			?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0" id="keyword_add_more_<?php echo $i;?>" <?php if($i<=count($keywordsData)){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
              <?php if($i==1){?>
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="258" style="text-align:left">Keyword</th>
                      <th width="153" style="text-align:center">Years of Exp.</th>
                      <th width="139" style="text-align:center">Last Used</th>
                      <th width="114" style="text-align:center">Level</th>
                    </tr>
                  </table></td>
              </tr>
              <?php }?>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="223" style="text-align:left"><div class="dropdown_resume1" id="skillDropdown<?php echo $i;?>"> <?php echo $this->Form->input('ResumeSkill.'.$i.'.id',array('class'=>'big237_textfield','type'=>'hidden','label'=>false,'div'=>''));?>
                          <!-- <?php
					   
					   echo $this->Form->input('ResumeSkill.'.$i.'.skill_id',array('type'=>'select','empty'=>'-Select Keyword-','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
					    ?>-->
                          <?php
					 
					  $keywordArray['addNewSkill']='Add New Skill';
					   $keywordArray=$keywordArray + $common->getKeywordList();
					 
					   echo $this->Form->input('ResumeSkill.'.$i.'.skill_id',array('type'=>'select','empty'=>'-Select Keyword-','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>'','onChange'=>'addkeyword(this.value,this.name,'.$i.')'));
					    ?>
                        </div></td>
                      <td  width="153" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                          <?php 
                        echo $this->Form->input('ResumeSkill.'.$i.'.experience_code',array('type'=>'select','empty'=>'-Select Year of Exp.-','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                          <?php 
                        echo $this->Form->input('ResumeSkill.'.$i.'.last_used_code',array('type'=>'select','empty'=>'-Select Last Time -','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                      <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                          <?php 
                        echo $this->Form->input('ResumeSkill.'.$i.'.level_code',array('type'=>'select','empty'=>'-Select Level-','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                        </div></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <?php }?>
         
            <?php if(!empty($this->request->data['Resume']['count'])) { ?>
            <input type="hidden" value="<?php echo $this->request->data['Resume']['count']; ?>" id="KeywordCount" name="data[Resume][count]">
            <?php }else
		   { ?>
            <input type="hidden" value="1" id="KeywordCount" name="data[Resume][count]">
            <?php } ?>
            
            <div style="float:right;"><a href="javascript:void(0)" onclick="addKeywords()">Add More</a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="removeKeywords()" style="float:right" id="remove">Remove</a></div>
            <br />
            <br />
            <br />
            <h2 class="mana_subheading">3. Please paste a text version of your resume below.</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid"> <?php echo $this->Form->input('Resume.resume_content',array('class'=>'big_textarea','type'=>'textarea','label'=>false,'div'=>''));?> <br />
             <br />  <br />
              <h2 class="mana_subheading">4. Upload your resume.</h2>
              <div class="gray_full_top" style="width:500px;"></div>
              <?php echo $this->Form->input('Resume.filename',array('class'=>'textarea_237','type'=>'file','label'=>'','border'=>'none','div'=>''));?> <br />
            
            <?php if($this->request->data['Resume']['filename']){ ?>
              Resume: <?php echo $this->request->data['Resume']['filename']; ?> 
              <?php } ?>
			  <?php echo $this->Form->input('Resume.oldfile',array('class'=>'textarea_237','type'=>'hidden','label'=>'','border'=>'none','div'=>'','value'=>$this->request->data['Resume']['filename']));?> <br />
              
              Please upload your PDF or Word Document version of your resume.
              <div class="man_resume_footer padding_right_none">
              <!--  <p>Please enter text as shown in image below:</p>
                <ul>
                  <li class="last">
                    <?php //echo $this->Form->submit('Delete',array('name'=>'Delete','value'=>'Delete','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
                  </li>
                  <li> <?php echo $this->Form->input('Resume.captcha',array('autocomplete'=>'off','value'=>'','label'=>false,'class'=>'security_txt','div'=>'')); ?>
                    <div class="error-message"><?php echo $securityerror;?></div>
                    <br />
                  </li>
                  <li > <?php echo $this->Html->image($this->Html->url(array('action'=>'captcha','Jobseeker'=>false), true),array('style'=>'','vspace'=>2)); ?> </li>
                </ul>-->
                <div class="clear"></div>
                <div class="align_right"> <?php echo $this->Form->input('Resume.id',array('class'=>'big237_textfield','type'=>'hidden','label'=>false,'div'=>''));
				
				echo $this->Form->input('Resume.Update',array('class'=>'big237_textfield','type'=>'hidden','label'=>false,'div'=>'','value'=>'Update'));
				
				?>
                
                 <?php echo $this->Form->submit('images/update_new.png',array('name'=>'Update','value'=>'Update','onClick'=>'return checkTotalResume(0);','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
                 
                 
               <?php /*?>   echo $this->Form->submit('images/update_new.png',array('name'=>'Update','value'=>'Update','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                
                /img/images/update_new.png  <?php */?>
                 
                 
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php  $this->end();?>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
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
	
	
	document.getElementById("ResumeSkill"+count+"SkillId").value='';
	document.getElementById("ResumeSkill"+count+"ExperienceCode").value='';
	document.getElementById("ResumeSkill"+count+"LastUsedCode").value='';
	document.getElementById("ResumeSkill"+count+"LastUsedCode").value='';
	document.getElementById("ResumeSkill"+count+"LevelCode").value='';
	
	
	document.getElementById("keyword_add_more_"+count).style.display = 'none';
	count = count - 1;
	//alert(count);
	
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
    <div style='margin:0 auto; width:400px;'> <br/>
      <br/>
      <form action="" method="post">
        Add New Skill :
        <input type="text" name="skill" id="skill" class="input_208" style="width:178px" />
        <input type="hidden" name="number" value="number" id="number"/>
        <span style="vertical-align:top;">
        <input type="image" name="SUBMIT" value="SUBMIT"  onclick="return validationCheck();" src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/send.jpg"/>
        </span>
      </form>
    </div>
  </div>
</div>
