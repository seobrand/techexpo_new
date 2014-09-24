   <div id="wrapper">
    <?php echo $this->element('employer_tabs');
	$theComponent = new commonComponent(new ComponentCollection());
	?>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor"> 
          <?php if(count($regEvents) >= 1) { ?>
             Search Resumes
               <?php } else {  echo 'You must register for an event to use this feature.';} ?> 
             </h1>
            <div class="content">
           <?php if(count($regEvents) >= 1) { ?>
 <h2 class="mana_subheading">Use the form below to search the resumes of candidates who have pre-registered for the following TECHEXPO events.</h2>
 

          <!--    <h2 class="mana_subheading"><strong>VERY IMPORTANT:</strong> CLICK HERE TO READ UPDATED RESUME SEARCH INSTRUCTIONS AND TIPS</h2>
              <h2 class="mana_subheading"> You are currently registered for the following TECHEXPO events:</h2>-->
          
              <ul class="list no_top">
              <?php  foreach ($regEventsshow as $regEvent){?>
                <li><a href="<?php echo $this->webroot; ?>employers/eventinfo/<?php echo $regEvent['Show']['id'] ?>"><?php echo $regEvent['Show']['show_name']; ?> - <?php echo date(DATE_FORMAT,strtotime($regEvent['Show']['show_dt']));?></a></li>
                <?php } ?>
              </ul>
              <div class="gray_full_top"></div>
              <?php echo $this->Form->create('Folders',array('action'=>'searchRegResult','type'=>'get','name'=>"searchform", 'onsubmit'=>"return checkForm(this);"));?>
              <div class="gray_full_mid">
                <ul class="form_list manage_resume_form">
                  <li>
                    <label>Keywords:</label>
                    <div class="form_rt_col1">
                    <?php echo $this->Form->input('words',array('class'=>'small_Texfield','div'=>false,'label'=>false)); ?>
                      <div class="even_reg_dropdown float_left" style="width:199px!important;">
	                    <select name="type" id="FoldersType" class="work_location_code" style="font-size: x-small; font: x-small;">
	                 		<option value="Any">Any Words</option>
							<option value="All" selected>All Words</option>
							<option value="Exact Phrase">Exact Phrase</option>
							<option value="Advanced">Advanced Boolean Search</option>
						</select>                     
                      </div>
                    </div>
                  </li>
                  <li>
                    <label>State:</label>
                    <div class="form_rt_col1">
                      <div class="checkbox_div employeer_search">
                        <div class="checkbox_list checbox-small-size">
                        <?php  $state_list = $theComponent->getStateList();
                         echo $this->Form->input('candidate_state',array('type'=>'select','multiple'=>'checkbox','options'=>$state_list,'empty'=>array('ALL'=>'ALL STATES')/*,'selected' => 'ALL'*/,'label'=>false,'div'=>false,'hiddenField' => false)); 
					  	?></div>
					  </div>
					</div>
                  </li>
                  <li>
                    <label>Citizenship Status:</label>
                    <div class="form_rt_col1">
                      <div class="even_reg_dropdown f_left">                     
					  <select name="citizen_status_code" style="font-size: x-small; font: x-small;">
						 <option value="25" SELECTED>US Citizens Only </option>
						 <option value="0">Will Consider Aliens</option>
					  </select>                     
                      </div>
                      <div class="second_label"> Min. years of Exp:</div>
                      <div class="small_dropdown margin_lf">
                     <?php  $experience_code = $theComponent->getResumeSearchExperienceList();					  
					  echo $this->Form->input('experience_code',array('label'=>'','options'=>$experience_code,'type'=>'select','style'=>'font-size: x-small; font: x-small;','error'=>false,'div'=>false,'label'=>false));
					   ?>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                    <label>Security Clearance:<br />
					<span>Please check all that apply.</span></label>
                    <div class="form_rt_col1">
	                    <div class="checkbox_div checkbox_large_div">
	                     <div class="checkbox_list">
	                       <?php $cleareance_list = $theComponent->getGovCleareanceList();
							 echo $this->Form->input('security_clearance_code2',array('type'=>'select','multiple'=>'checkbox','options'=>$cleareance_list,'label'=>false,'div'=>false,'hiddenField' => false)); 
						   ?>
						 </div>
						 </div>
		                 <div class="clear"></div>
		                <!-- <br />
		                 <br />
	               		 <?php echo $this->Form->input('security_clearance_code',array('class'=>'small_Texfield float_none','div'=>false,'label'=>false,'size'=>'40')); ?>
	                	<br><br><br>
	               		<?php echo $this->Form->checkbox('adv_sec',array('div'=>false,'label'=>false)); ?>
	                	Check to perform an<b> ADVANCED BOOLEAN SEARCH</b> (read instructions).
	                    &nbsp;&nbsp;Check to perform an ADVANCED BOOLEAN SEARCH (read instructions). -->
	               </div>
                  </li>
                  <li>
                    <label>OPTIONAL: Look for resumes submitted in the last:</label>
                    <div class="form_rt_col1">
                      <?php echo $this->Form->input('date_search',array('class'=>'small_Texfield','div'=>false,'label'=>false,'size'=>'3','maxlength'=>'2')); ?>
                      <div class="dropdown_resume4 float_left">
                      <?php 
                        $option=array('day'=>'days','week'=>'weeks','month'=>'months','year'=>'years');
                         echo $this->Form->input('time_units',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;'));
                      ?>
                      </div>
                    </div>
                  </li>
                  <li>
                    <label> Max. number of results:</label>
                    <div class="form_rt_col1">
                      <div class="dropdown_resume4">
                      <?php $options=array('All'=>'View all','100'=>'100','200'=>'200','300'=>'300','500'=>'500','1000'=>'1000');
							echo $this->Form->input('max_rows',array('type'=>'select','options'=>$options,'empty'=>false,'label'=>false,'div'=>''));
						?>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                  <label>Select Database:</label>
                  <div class="form_rt_col1">
                    <div class="checkbox_div checkbox_large_div databasedropdown">
                      <div class="checkbox_list">
                      <?php echo $this->Form->input('show_id', array('type' => 'select','multiple'=>'checkbox','options' => $event_list,'div'=>false,'label'=>false,'hiddenField' => false));?>
                       </div>
                    </div>
                  </div>
                  </li>
                  <li>
                    <label></label>
                    <div class="form_rt_col1">
                    <?php echo $this->Form->submit('images/grey_submit.jpg');?>
                    </div>
                  </li>
                </ul>
              </div>
               <?php echo $this->Form->end(); ?>
               <?php } ?>
               
            </div>
          </div>
        </div>
      </div>
         <?php echo $this->element('employer_left_panel'); ?>
      <div class="clear"></div>
        <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
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
</SCRIPT>	