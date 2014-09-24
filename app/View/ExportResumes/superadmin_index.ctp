<?php
echo $this->Html->css('demos');
echo $this->Html->css('jquery-ui');
 echo $this->Html->script('date/jquery.ui.core.js'); ?>
<?php echo $this->Html->script('date/jquery.ui.datepicker.js'); ?>
<?php echo $this->Html->script('date/jquery.ui.widget.js'); ?>

<?php $page = $this->params['paging']['Resume']['page'];?>
<?php $pageLimit = $this->params['paging']['Resume']['limit'];?>
<?php $page_start = ($page*$pageLimit-$pageLimit)+1;?>
<script> 
	$(function() {
		$( "#startdate" ).datepicker();
		$( "#enddate" ).datepicker();
	});
</script> 

<?php  	echo $this->Html->script('front_js/jquery-ui-1.7.2.custom.min.js');
echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
 ?>
<script type="text/javascript">
$(function(){
	
$(".pager").css({ 'word-wrap': 'break-word' });
$(".pager span").css({ 'line-height':'22px' });

$(".databaselistdrop input:checkbox").click(function(){
    var pos = $(".databaselistdrop input:checkbox").index(this);
    if(pos == 0){
        $(".databaselistdrop input:checkbox").not(this).attr("checked", false);
    }
    else{
        $(".databaselistdrop input:checkbox:first").attr("checked", false);
    }
});

$(".statelistdrop input:checkbox").click(function(){
    var pos = $(".statelistdrop input:checkbox").index(this);
    if(pos == 0){
        $(".statelistdrop input:checkbox").not(this).attr("checked", false);
    }
    else{
        $(".statelistdrop input:checkbox:first").attr("checked", false);
    }
});




});
</script>

<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'ExportResume')); 
$theComponent = new commonComponent(new ComponentCollection());

if(count($resumeLists) <1) {
?>


<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Export Resumes for Mail and Mass E-mail Campaigns OR Export Resumes as TEXT FILES to send to clients
</div>
                <div style="float:right;font-weight:bold;">&nbsp;</div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>

    <div class="display_row">
      <div class="table"> <br />
        <p><b><u><blink>VERY IMPORTANT:</blink></u> <a  class="ajax" target="_blank" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "info"));?>" >CLICK HERE TO READ <i style="background-color: Yellow;">UPDATED</i> RESUME SEARCH INSTRUCTIONS AND TIPS</a></b></p>
        <br />
        <table cellpadding="0" cellspacing="0" border="0">
          <?php echo $this->Form->create('ExportResumes',array('action'=>'','type'=>'GET','name'=>"searchform", 'onsubmit'=>"return checkForm(this);"));?>
          <tbody>
          	
            <tr valign="middle">
              <td align="right" valign="middle">Keywords:</td>
              <td align="left" colspan="2" valign="top" nowrap=""><input type="text" class="inputbox1"  name="words" size="35"  value="<?php echo $keyword; ?>">
                &nbsp;
                <?php 
				if($selected)
				{
				$selected=$selected;
				}else
				{
				$selected='';
				}
                 /*$option=array('Any'=>'Any Words','All'=>'All Words','Exact Phrase'=>'Exact Phrase','Advanced'=>'Advanced Boolean Search'); echo $this->Form->input('type',array('type'=>'select','default'=>$selected,'options'=>$option,'selected'empty'=>false,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: x-small; font: x-small;'));**/ ?>
                <select name="type" id="ExportResumesType" class="work_location_code" style="font-size: x-small; font: x-small;">
                 	<option value="Any">Any Words</option>
					<option value="All" selected>All Words</option>
					<option value="Exact Phrase">Exact Phrase</option>
					<option value="Advanced">Advanced Boolean Search</option>
				</select>
                </td>
            </tr>
            <tr valign="middle">
              <td valign="top" align="right"> Look for resumes in: </td>
              <td valign="top" align="left" colspan="2">
              	<div class="checkbox_div_resumesearch databaselistdrop">
              		<?php echo $this->Form->input('set_id',array('type'=>'select','multiple'=>'checkbox','options'=>$selected_db,'empty'=>false,'label'=>false,'class'=>'','div'=>'','style'=>'font-size: 12px;','selected'=>$this->request->data['set_id'])); ?>
              	</div>
              </td>
            </tr>
            <tr valign="middle">
              <td align="right" valign="top">State:</td>
              <td colspan="2" valign="top" align="left">
              <div class="checkbox_div_resumesearch statelistdrop">
                  <?php  $state_list = $theComponent->getStateList();
                         echo $this->Form->input('candidate_state',array('type'=>'select','multiple'=>'checkbox','options'=>$state_list,'empty'=>array('ALL'=>'--ALL--'),'label'=>false,'class'=>'','div'=>false,'style'=>'font-size: x-small; font: x-small;','selected'=>$this->request->data['candidate_state'])); 
					  ?>
			  </div></td>
            </tr>
            <tr valign="middle">
              <td align="right" valign="middle">Citizenship Status:</td>
              <td colspan="2" valign="top" align="left">
              <?php  /** $citizen_list = $theComponent->getCitizenShipList();echo $this->Form->input('citizen_status_code',array('label'=>'','options'=>$citizen_list,'type'=>'select','empty'=>'select','style'=>'font-size: x-small; font: x-small;','error'=>false,'div'=>false,'label'=>false));**/ ?>
              <select name="citizen_status_code" style="font-size: x-small; font: x-small;">
				 <option value="25" SELECTED>US Citizens Only </option>
				 <option value="0">Will Consider Aliens</option>
			  </select>
                &nbsp;&nbsp; Min. years of Exp: &nbsp;&nbsp;
                <?php  $experience_code = $theComponent->getResumeSearchExperienceList();					  
					  echo $this->Form->input('experience_code',array('label'=>'','options'=>$experience_code,'type'=>'select','style'=>'font-size: x-small; font: x-small;','error'=>false,'div'=>false,'label'=>false));
					   ?>
                  </td>
            </tr>
            <tr valign="top">
              <td align="right" valign="top">Security clearance level desired (optional):<br></td>
              <td colspan="2" valign="top" align="left">
               <div class="checkbox_div_resumesearch">              
                    <?php $cleareance_list = $theComponent->getGovCleareanceList();
							 $state_list = $theComponent->getStateList();
                         echo $this->Form->input('security_clearance_code2',array('type'=>'select','multiple'=>'checkbox','options'=>$cleareance_list,'label'=>false,'class'=>'','div'=>false,'style'=>'font-size: x-small; font: x-small;','selected'=>$this->request->data['security_clearance_code2'])); 
					  ?>
				</div><br/>
                <font color="000066" size="1" face="verdana,arial,helvetica,sans-serif line-height:16px;">If you wish to see a security category added to the list, <a href="mailto:sberk@TechExpoUSA.com?subject=Please add a security category to your list"><strong>please click here</strong></a>. </font><br>
                <!-- <font face="Verdana, Arial, Helvetica, sans-serif" size="1" style="background-color: Yellow; line-height:16px;">If you selected "Other Active Clearance" in the above menu, you may enter security clearance search keywords here (click on instructions link above for detailed instructions)</font><br> -->
               <?php //echo $this->Form->input('security_clearance_code',array('class'=>'inputbox1','div'=>false,'label'=>false,'size'=>'40')); ?>
                <br>
               <?php //echo $this->Form->checkbox('adv_sec',array('div'=>false,'label'=>false)); ?>
                <!-- Check to perform an<b> ADVANCED BOOLEAN SEARCH</b> (read instructions). -->
                
                </td>
            </tr>
            
            <tr valign="middle">
              <td valign="middle" align="right"> OPTIONAL: Look for resumes submitted in the last: </td>
              <td colspan="2" valign="top" align="left">
              <?php echo $this->Form->input('date_search',array('class'=>'inputbox1','div'=>false,'label'=>false,'size'=>'3','maxlength'=>'2')); ?>
                &nbsp;&nbsp;
                <?php 
                        $option=array('day'=>'days','week'=>'weeks','month'=>'months','year'=>'years');
                         echo $this->Form->input('time_units',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                </td>
            </tr>
            
            
            <!-- <tr valign="middle">
              <td valign="middle" align="right"> Start Date</td>
              <td colspan="2" valign="top" align="left">
              <?php echo $this->Form->input('startdate',array('class'=>'inputbox1','div'=>false,'id'=>'startdate','label'=>false,'size'=>'3','maxlength'=>'2')); ?>
            
                </td>
            </tr>
            
              <tr valign="middle">
              <td valign="middle" align="right"> Start Date</td>
              <td colspan="2" valign="top" align="left">
              <?php echo $this->Form->input('enddate',array('class'=>'inputbox1','id'=>'enddate','div'=>false,'label'=>false,'size'=>'3','maxlength'=>'2')); ?>
            
                </td>
            </tr>  -->
            <tr valign="middle">
              <td valign="middle" align="right">&nbsp;&nbsp; </td>
              <td valign="top" align="left" colspan="2">

                  <?php echo $this->Form->submit('Submit',array('class'=>'cursorclass ui-state-default ui-corner-all','align'=>'absmiddle'));?>
                  <?php echo $this->Form->hidden('searchResume',array('value'=>'searchResume')); ?>
              </td>
            </tr>
          </tbody>
          <?php $this->end();?>
        </table>
      </div>
    </div>
  




 </div>
        <!-- end table --> 
      </div>
      
 <?php  }else { ?>
 
 <div id="right2"> 
        <!-- table -->
        <div class="box1">
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">List of registered candidates</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              
             
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
              
            </div>
          </div>
             
          <!-- box / title -->
          
          <div class="display_row">
            <div class="table">
             <div class="pager"><?php if(isset($countTotalRecords)) echo $countTotalRecords;  ?> resumes matching your search </div> 
              <br />
   
              <div class="pager">
                <div class="paging">  <?php echo $this->Paginator->numbers(array('modulus'=>PHP_INT_MAX,'separator'=>'&nbsp;<b>|</b>&nbsp;')); ?>&nbsp;<b>|</b>&nbsp; </div>
         
                <div class="clear"></div>
              </div>
              <br />
            
              <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "index"));?>">
              New Search
              
              </a>&nbsp;&nbsp;<a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "resumeDetailAll"));?>">
              Export Addresses / Email / Name
              </a>&nbsp;&nbsp;<a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "resumeExportAll"));?>">
             Export Resumes as Text Files
              </a>
              &nbsp;&nbsp;<a target="_blank" class="cursorclass ui-state-default ui-corner-all"  href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "emailResume"));?>">
             Email Resume
              </a> <br />
              <br />
              <table border="0" cellpadding="0" cellspacing="0">
                <thead>
                  <tr>
                 
                    <th valign="middle" class="black_head"  width="28%" align="left"> <?php echo $this->Paginator->sort('Candidate.candidate_name','Candidate Name'); ?></th>
                  <!--  <th valign="middle"  width="10%"  class="black_head" align="left"><a href="">Score</a></th> -->
                    <th valign="middle"  width="18%" align="left" class="black_head"><?php echo $this->Paginator->sort('Resume.resume_title','Resume Title'); ?></th>
                    <th valign="middle"   width="20%" align="center" class="black_head"><?php echo $this->Paginator->sort('Resume.candidate_state','Location'); ?></th>
                    <th valign="middle"   width="18%" align="center" class="black_head"><?php echo $this->Paginator->sort('Resume.posted_dt','Date Posted'); ?></th>
                  </tr>
                </thead>
              </table>
              <br />
        		<?php   foreach($resumeLists as $key =>$resumeList){ ?>
              <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                  <tr>
                    <th valign="middle" width="28%"align="left"><?php echo $page_start;?>.&nbsp;&nbsp;
                    <?php if(strlen($resumeList['Candidate']['candidate_privacy'])>0){ if($resumeList['Candidate']['candidate_privacy']=='Y'){?><b><i style="color:#fff;">Confidential</i></b><?php }elseif(strlen($resumeList['Candidate']['candidate_name'])>0){ echo "<b>".$resumeList['Candidate']['candidate_name']."</b>";}else{?><b>Unnamed</b><?php } }elseif(strlen($resumeList['Candidate']['candidate_name'])>0){ echo "<b>".$resumeList['Candidate']['candidate_name']."</b>";}else{?><b>Unnamed</b><?php }?></th>
                  <!--  <th valign="middle" width="10%"  align="left"> 3790 </th> -->
                    <th valign="middle" width="18%" align="left"> <a href="<?php echo $this->Html->url(array("controller" => "ExportResumes",'action'=>'viewResume',$resumeList['Resume']['id']));?>"><?php  echo $resumeList['Resume']['resume_title'];  ?></a></th>
                    <th valign="middle" width="20%" align="center"><?php  echo $resumeList['Candidate']['candidate_state'].''.$resumeList['Candidate']['candidate_city'];  ?> </th>
                    <th valign="middle"  width="18%" align="center"><?php  echo date('m/d/Y', strtotime($resumeList['Resume']['posted_dt']));  ?></th>
                  </tr>
                </thead>
                <tr>
                  <td  colspan="6"><p><i> Will relocate to <?php echo $resumeList['Candidate']['pref_locations']; ?></i><br></p>
                   
                    <p><strong>Overall years of experience:</strong>&nbsp; <?php  echo $common->getExperienceValue($resumeList['Candidate']['experience_code']);  ?>
                    &nbsp;&nbsp; <strong>Citizenship:</strong>&nbsp;<?php  echo $common->getCitizenShipValue($resumeList['Candidate']['citizen_status_code']);  ?></p>
                    <p><strong>Security Clearance:</strong>&nbsp; 
					<?php 
				//	$securityCl =  $common->getSecurityClearanceValue($resumeList['Candidate']['security_clearance_code']);
				//	  echo str_ireplace('None','Viewable inside resume detail',$securityCl);  ?> 
                      
                      <?php 
                    	$clearanceArray=explode(',',$resumeList['Candidate']['security_clearance_code']);
                    	
                        $totalRec=count($clearanceArray);
                        $i=1;
                        foreach($clearanceArray as $key =>$value)
                        {
                        
                        	 $securityCl =   $common->getSecurityClearanceValue($value);
							 echo str_ireplace('None','Viewable inside resume detail',$securityCl);
                              if($i!=$totalRec):
                                echo '&nbsp;,&nbsp;';
                              endif;
                              $i=$i+1;
                              
                        }
                    ?>
                      
                      </p>
                 <p><strong>Skills / Keywords:</strong>
                    
                   <?php 
					   $pos = strpos($this->Session->read('queryString'),"type=Advanced");
					 	$pos2 = strpos($this->Session->read('queryString'),"type=Any");
						$pos3 = strpos($this->Session->read('queryString'),"type=All");
					    if ( ($pos !== false) || ($pos2 !== false) || ($pos3 !== false) ) { 
						   $advancSrchKeyword = $this->Session->read('exSrchKeyword');
						   						
							foreach($advancSrchKeyword as $adk)
							{ 
								echo substr_count(strtoupper($resumeList['Resume']['resume_content']), strtoupper($adk))." hits on '".$adk."' &nbsp;&nbsp;";	
							}
							
						}
					   else
					   {
					    echo substr_count(strtoupper($resumeList['Resume']['resume_content']), strtoupper($this->Session->read('search_db_word_admin')));  ?> hits on '
                          <?php  echo $this->Session->read('search_db_word_admin'); ?>
                          '
                        <?php } ?>
                     </p>
                 
                 <i><?php 
foreach($resumeList['ResumeSkill'] as $value1)
{
	echo $common->getSkillName($value1['skill_id']).' - ';
}
?>
</i></p>
                      
                       
                   <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes",'action'=>'viewResume',$resumeList['Resume']['id']));?>">
             View resume detail
             </a>     </td>
                 
                </tr>
              </table> <br />
        		<?php  $page_start++; } ?>

            
              <div class="pager">
                <div class="paging"> <?php echo $this->Paginator->numbers(array('modulus'=>PHP_INT_MAX,'separator'=>'&nbsp;<b>|</b>&nbsp;')); ?>&nbsp;<b>|</b>&nbsp;</div>
      
                <div class="clear"></div>
              </div>
              <div class="pager"> <!-- <?php echo $this->Paginator->counter();  ?>  recent resumes  &nbsp;&nbsp; - &nbsp;&nbsp; <span>sorted by date posted</span> &nbsp;&nbsp;&nbsp;&nbsp;viewing resumes 1- 0 of 0   (page 1 of 0) --></div>
              <br />
            </div>
          </div>
        </div>
        
        
        <div style="width:100%;">
         
           <?php if($query1) { echo $query1."<br/>"; } ?>
          </div>
        
        
        
        <!-- end table --> 
      </div>
 
 
 
 <?php } ?>     
 
<SCRIPT TYPE="text/javascript">
function checkForm(form) {
	
	cnt=document.getElementById('ExportResumesSecurityClearanceCode2').length;
	i = 0;
	other_found=0;


	var countdbSelect = $(".databaselistdrop > div > input:checked").length;
	if(countdbSelect==0)
	{
	alert('Please select at least one database');	
	return false;
	}
	
	var countState = $(".statelistdrop > div > input:checked").length;
	if(countState==0)
	{
	alert('Please select at least one state');	
	return false;
	}
	
	
	for (i = 0; i < cnt; i++) {
		selected = "";
		if(document.searchform.elements['security_clearance_code2[]'].options[i].selected) 
        {
		 	selected = document.searchform.elements['security_clearance_code2[]'].options[i].value;
		 	if (selected =="3922") {
				other_found=1;
			}
        }
	} 
	
	// Other Active Clearance selected but no keywords in security clearance text field
/*	if ((other_found==1) && (document.searchform.security_clearance_code.value=="" || !document.searchform.security_clearance_code.value)) {
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
	
  	if ((index == "-1") && (document.getElementById("ExportResumesAdvSec").checked==true)) { 
    	alert("You have selected the advanced security clearance keyword search but have not enclosed your search words or phrases in double quotes (\"). Please correct this.");
		return false;
  	}*/
	
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
	
  	if ((test == 1) && (document.getElementById("ExportResumesAdvSec").checked==true)) { 
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