<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addshow')); ?>
<?php   
// for facny box
	
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
	
?>

<script type="text/javascript">

var jk = jQuery.noConflict();

jk(document).ready(function() {
	
	jk("#create_set").hide('500');
	// for security clearance
  	 jk("#ShowResumeSetId").change(function(){
		 var SetId = jk("#ShowResumeSetId").val();
	   if(SetId == '')
	   jk(".create_set").show('500');
	   else 
	   jk(".create_set").hide('500');
    });
	
	// for security clearance
  	 jk("#ShowSecClearanceReq").change(function(){
       var sce_clear = jk("#ShowSecClearanceReq").val();
	   if(sce_clear == 'n')
	   jk("#clearances_tr").hide('500');
	   else if((sce_clear == 'y'))
	   jk("#clearances_tr").show('500');
    });
	
	// for Special e-mail confirmation
  	 jk("#ShowEmailType").change(function(){
       var spc_email = jk("#ShowEmailType").val();
	   if(spc_email == 's')
	   jk("#custom_email_tr").hide('500');
	   else if((spc_email == 'c'))
	   jk("#custom_email_tr").show('500');
    });
	
	jk(".ajax").colorbox();
	jk('.addlocation').colorbox({iframe:true,  width:"60%", height:"100%",onComplete: function(){      
	//	setup_tiny("data[Location][site_travel_direction]");
	//	jk(this).colorbox.resize();
    }});
	
	 jk("#start_dt").datepicker({ dateFormat: "yy-mm-dd" });
	 jk("#end_dt").datepicker({ dateFormat: "yy-mm-dd" });
	 
	 
	  jk("#ShowBoutique").change(function(){
		 var eventType = jk(this).val();
		
		 if(eventType=='b')
		  jk(".secondfour").attr('id','submit_secondfour');
	  
    });
	 
	 
	 
	 
	 
	 // form wizad 
	 jk(".create_second").hide();
	 jk(".create_third").hide();
	 jk(".create_forth").hide();
	 jk(".create_fifth").hide();
	 jk(".create_sixth").hide();
	 jk(".create_seventh").hide();
	 
	 ////slide step1
	 jk('#submit_first').click(function(){
		 
		var ShowShowName =  jk('#ShowShowName').val();
		var ShowLocationId =  jk('#ShowLocationId').val();
		var ShowShowHours =  jk('#ShowShowHours').val();
		if(ShowShowName=='')
		{
			alert('Please enter show name');
			return false;	
		}
		else if(ShowLocationId=='')
		{
			alert('Please select show location');
			return false;	
		}
		else if(ShowShowHours=='')
		{
			alert('Please enter show hours');
			return false;	
		}
		 
		 
		jk('.create_first').slideUp();
		jk('.create_second').slideDown(); 	 
	});
	
	////slide step2
	 jk('#submit_second').click(function(){
		
		
		var ShowResumeSetId =  jk('#ShowResumeSetId').val();
		
		if(ShowResumeSetId=='')
		{
			var ShowSetDescr =  jk('#ShowSetDescr').val();
			var start_dt =  jk('#start_dt').val();
			var end_dt =  jk('#end_dt').val();
			var state_list =  jk('#state_list').val();
			var ShowShortDesc =  jk('#ShowShortDesc').val();
			
			
			if(ShowSetDescr=='')
			{
				alert('Please enter show description');
				return false;	
			}
			else if(start_dt=='')
			{
				alert('Please enter start');
				return false;	
			}
			else if(end_dt=='')
			{
				alert('Please enter end date');
				return false;	
			}
			else if(state_list=='')
			{
				alert('Please enter state list');
				return false;	
			}
			else if(ShowShortDesc=='')
			{
				alert('Please enter show short description');
				return false;	
			}
		}
		
		
		
				
		
		
		
		var eventType = jk("#ShowBoutique").val();
		if(eventType=='r') 
		{
			jk('.create_second').slideUp();
			jk('.create_forth').slideDown();	
		}
		else 
		{ 
			jk('.create_second').slideUp();
			jk('.create_third').slideDown(); 	
		}
	});
	
	
	
	////slide step3
	 jk('#submit_third').click(function(){
		jk('.create_third').slideUp();
		jk('.create_forth').slideDown(); 	 
	});
	
	////slide step4
	 jk('#submit_forth').click(function(){
		jk('.create_forth').slideUp();
		jk('.create_fifth').slideDown(); 	 
	});
	
	
	////slide step5
	 jk('#submit_fifth').click(function(){
		jk('.create_fifth').slideUp();
		jk('.create_sixth').slideDown(); 	 
	});
	
	////slide step6
	 jk('#submit_sixth').click(function(){
		jk('.create_sixth').slideUp();
		jk('.create_seventh').slideDown(); 	 
	});
	
	
	
	
	
		
	
	//step for back button
	jk('.submit_bck_all').click(function(){
		
		var backValue =  jk(this).attr('rel');
		
		
			switch(backValue)
			{
			case 'second':
			 jk('.create_second').slideUp();
			 jk('.create_first').slideDown();
			break;
			case 'third':
			 jk('.create_third').slideUp();
			 jk('.create_second').slideDown();
			break; 
			case 'forth':
			 jk('.create_forth').slideUp();
			 jk('.create_third').slideDown();
			break;
			case 'fifth':
			 jk('.create_fifth').slideUp();
			 jk('.create_forth').slideDown();
			break; 
			case 'sixth':
			  jk('.create_sixth').slideUp();
			 jk('.create_fifth').slideDown();
			break;
			case 'seventh':
			 jk('.create_seventh').slideUp();
			 jk('.create_sixth').slideDown();
			break; 
			default:
			alert("please check your action.")
			}
 
		
		  
		 
 	});
	 
	   
});


function insert_states(){
	var states_list ='AL,AK,AZ,AR,CA,CO,CT,DE,DC,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY';
	jk("#state_list").attr('value',states_list);
	}
   
</script>

<div class="display_row">
      <div class="table">
	  <?php  echo $this->Form->create('Show', array('enctype' => 'multipart/form-data') ); ?> 
        <table  cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody>
    	   <tr>
            <td colspan="2"  valign="middle"><b><h3>Create  Event :</h3></b></td>
            
            </tr>
          <!-------------------------------step1 start ------------------------------------------------------------>
         	<tr class="create_first">
              <td align="right" valign="middle" width="300"><span class="required">*</span>Show Name:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_name',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr class="create_first">
              <td align="right" valign="middle"><span class="required">*</span>Show Location</td>
              <td align="left" valign="top"><?php echo $this->Form->input('location_id',array('label'=>'','options'=>$loc_list,'type'=>'select','div'=>false,'class'=>'inputbox1'));?>
              <?php echo $this->Html->link('Create',array('controller'=>'locations','action'=>'add2'),array('escape'=>false,'class'=>'addlocation')); ?>
              </td>
            </tr>
            <tr class="create_first">
              <td align="right" valign="middle"><span class="required"></span>Show Display Name</td>
              <td align="left" valign="top"><?php echo $this->Form->input('display_name',array('label'=>'','class'=>'inputbox1'));?></td>
            </tr>
            
            <tr class="create_first">
              <td align="right" valign="middle">Show entry Requirements</td>
              <td align="left" valign="top">
               <?php echo $this->Form->input('special_message',array('label'=>'','class'=>'inputbox1'));?>
				</td>
            </tr>
                <tr class="create_first">
              <td align="right" valign="middle"><span class="required">*</span>Show Date:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_dt',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr class="create_first">
              <td align="right" valign="middle">Show End Date<br />
                (only for events that last more than 1 day):</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_end_dt',array('label'=>'','class'=>'inputbox1','error'=>false,'empty' => true));?></td>
            </tr>
            <tr class="create_first">
              <td align="right" valign="middle"><span class="required">*</span>Show Hours:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_hours',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr class="create_first">
              <td align="right" valign="middle">Show description:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_descr', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'40'));?></td>
            </tr>
            <tr class="create_first">
              <td align="right" valign="middle">Is this event a regular or boutique event ?</td>
              <td align="left" valign="top"><?php echo $this->Form->input('boutique',array('label'=>'','options'=>array('r'=>'Regular','b'=>'Boutique'),'type'=>'select','error'=>false));?></td>
            </tr>
            <tr class="create_first">
              <td align="right" valign="middle"></td>
              <td align="left" valign="top">  <input name="" type="button" value="Next" class="cursorclass ui-state-default ui-corner-all" id="submit_first"></td>
            </tr>
            
           <!-------------------------------step1 end ------------------------------------------------------------>
             
          
           <!-------------------------------step2 start ------------------------------------------------------------>
            <tr class="create_second">
            <td colspan="2"  valign="middle"><b><h3>Create new set or select already created sets, if want to create set then please fill set form  first then event form</h3></b></td>
            
            </tr>
            <tr class="create_second">
            <td align="right" valign="middle" width="300">Resume set for this show:</td>
            <td align="left" valign="top">
            <?php echo $this->Form->input('resume_set_id',array('label'=>'','options'=>$resume_set,'empty'=>'Create Resume Set','type'=>'select','error'=>false));?>
            <!--          or    <?php   echo $this->Html->link('Click Here to create new resume set', array('controller'=>'sets','action'=>'add'),array('target'=>'blank','escape'=>false)); ?> -->
            </td>
            </tr> 
            
            <tr class="create_set create_second">
            <td align="right" valign="middle" width="300"><span class="required"></span>Set Description:</td>
            <td align="left" valign="top" ><?php echo $this->Form->input('set_descr',array('label'=>'','class'=>'inputbox1', 'error'=>false));?></td>
            </tr>
            
            
            <tr class="create_set create_second">
            <td align="right" valign="middle"><span class="required"></span>Start Date: yyyy-mm-dd:</td>
            <td align="left" valign="top"><?php echo $this->Form->input('start_dt',array('label'=>'','class'=>'inputbox1','id'=>'start_dt','error'=>false));?></td>
            </tr>
            <tr class="create_set create_second">
            <td align="right" valign="middle"><span class="required"></span>End Date: yyyy-mm-dd:</td>
            <td align="left" valign="top"><?php echo $this->Form->input('end_dt',array('label'=>'','class'=>'inputbox1','id'=>'end_dt','error'=>false));?></td>
            </tr>
            <tr class="create_set create_second">
            <td align="right" valign="middle"><span class="required"></span>State List: NY,NJ...:</td>
            <td align="left" valign="top"><?php echo $this->Form->input('state_list',array('label'=>'','class'=>'inputbox1','error'=>false,'id'=>'state_list','style'=>'width:600px;'));?><br/>
            <a onclick="insert_states();" > INSERT ALL STATES </a>
            </td>
            </tr>
            <tr class="create_set create_second">
            <td align="right" valign="middle"><span class="required"></span>Keywords filtering (open houses): </td>
            <td align="left" valign="top"><?php echo $this->Form->input('custom_clause',array('type'=>'textarea','label'=>'','class'=>'smallTextB mceNoEditor','error'=>false));?>								
            <small>	
            Enter a boolean search phrase as in the adavanced resume search, enclosing keywords in double-quotes. e.g: "Java" OR "JSP" OR "Java Server Pages" OR "JDBC"</small>
            </td>
            </tr>
            <tr class="create_set create_second">
            <td align="right" valign="middle">Short Description:</td>
            <td align="left" valign="top"><?php echo $this->Form->input('short_desc',array('label'=>'','class'=>'inputbox1'));?></td>
            </tr>
            <tr class="create_set create_second">
            <td align="right" valign="middle" > </td>
            <td align="left" valign="top">
            <? foreach($showRecords as  $key=>$value) 
            { ?>
            <input type="Checkbox" name="show[<?php echo $key; ?>]"   value="<?php echo $value['Show']['id']; ?>">
            <?php  echo $value['Show']['show_dt']." ".$value['Show']['show_name']."<br/>";   
            }
            
            ?>  
            </td>
            </tr>
            <tr class="create_second">
              <td align="right" valign="middle"></td>
              <td align="left" valign="top">  
               <input name="" type="button" value="Previous" rel="second" class="submit_bck_all cursorclass ui-state-default ui-corner-all" id="submit_bck">
              <input name="" type="button" value="Next" class="next_btn secondfour cursorclass ui-state-default ui-corner-all" id="submit_second"></td>
            </tr>
            <!-------------------------------step2 end ------------------------------------------------------------>
          
          
          
          
          <!-------------------------------step3 start ------------------------------------------------------------> 
           	<tr class="create_third">
              <td align="right" valign="middle" width="300">Special text <b>for boutique shows only</b>. Simple HTML tags such as &lt;br&gt;, &lt;b&gt;&lt;/b&gt; can be used to insert breaks, rulers, bold items etc...</td>
              <td align="left" valign="top"><?php echo $this->Form->input('boutique_special_html', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
            <tr class="create_third">
              <td align="right" valign="middle">Banner <b>for boutique shows only</b>:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.boutique_banner_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?></td>
            </tr>
            <tr class="create_third">
              <td align="right" valign="middle">Banner link / URL <b>for boutique shows only</b>:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('banner_url',array('label'=>'','type' => 'text','value'=>'http://','size'=>'40','class'=>'inputbox1','error'=>false));?>
                <br />
                enter full URL (eg: http://www.techexpoUSA.com)<br />
                <br /></td>
            </tr>
            <tr class="create_third">
              <td align="right" valign="middle"></td>
              <td align="left" valign="top">  
               <input name="" type="button" value="Previous" rel="third" class="submit_bck_all cursorclass ui-state-default ui-corner-all" id="submit_bck">
              <input name="" type="button" value="Next" class="next_btn cursorclass ui-state-default ui-corner-all" id="submit_third"></td>
            </tr>     
          <!-------------------------------step3 end ------------------------------------------------------------>
          
          
          
           <!-------------------------------step4 Start ------------------------------------------------------------>
          <tr class="create_forth">
              <td align="right" valign="middle" width="300">Does this event require security clearance ?</td>
              <td align="left" valign="top" ><?php echo $this->Form->input('sec_clearance_req',array('label'=>'','options'=>array('y'=>'Yes','n'=>'No'),'type'=>'select','error'=>false));?></td>
            </tr>
          <tr class="create_forth" valign="right" id="clearances_tr">
              <td align="right" valign="middle">Any specific clearances required ?</td>
              <td align="left" valign="top"><?php echo $this->Form->input('sec_clearance_list',array('label'=>'','options'=>$ck,'type'=>'select','multiple'=>true, 'size'=>'10','error'=>false));?>
                <font size="1" face="verdana,arial,helvetica,sans-serif"> <br />
                Hold down the control / command key to select several options</font><br /></td>
            </tr>
          <tr class="create_forth" >
              <td align="right" valign="middle">Show Requirements</td>
              <td align="left" valign="top">Note: Bullet points MUST BE represented by **<br />
                <?php echo $this->Form->input('requirements', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?>
				</td>
            </tr>
            <tr class="create_forth">
              <td align="right" valign="middle"></td>
              <td align="left" valign="top">  
               <input name="" type="button" value="Previous" rel="forth" class="submit_bck_all cursorclass ui-state-default ui-corner-all" id="submit_bck">
              <input name="" type="button" value="Next" class="next_btn cursorclass ui-state-default ui-corner-all" id="submit_forth"></td>
            </tr> 
          
          <!-------------------------------step4 end ------------------------------------------------------------> 
          
          
          
          
          
          <!-------------------------------step5 Start ------------------------------------------------------------>
            <tr class="create_fifth">
              <td align="right" valign="middle" width="300">Show Travel Directions:</td>
              <td align="left" valign="top"> <?php echo $this->Form->input('show_travel_dir', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
            <tr class="create_fifth">
              <td align="right" valign="middle">Special HTML for partners, announcements etc..</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_special_html', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
            <tr class="create_fifth">
              <td align="right" valign="middle"></td>
              <td align="left" valign="top">  
               <input name="" type="button" value="Previous" rel="fifth" class="submit_bck_all cursorclass ui-state-default ui-corner-all" id="submit_bck">
              <input name="" type="button" value="Next" class="next_btn cursorclass ui-state-default ui-corner-all" id="submit_fifth"></td>
            </tr> 
          
          <!-------------------------------step5 end ------------------------------------------------------------> 
          
          
        
        <!-------------------------------step6 Start ------------------------------------------------------------>
           <tr class="create_sixth">
              <td align="right" valign="middle" width="300">Type of pre-registration:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('prereg_type',array('label'=>'','options'=>array('n'=>'Normal - through TECHEXPO site','s'=>'Special - outside web site'),'type'=>'select','error'=>false));?></td>
            </tr>
            
            
            <tr class="create_sixth">
              <td align="right" valign="middle">Registration URL (for outside <br />
                web site registration:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('prereg_url',array('label'=>'','type' => 'text','size'=>'40','class'=>'inputbox1','error'=>false));?>
                <br />
                enter full URL (eg: http://www.techexpoUSA.com)<br />
                <br /></td>
            </tr>
            <tr class="create_sixth">
              <td align="right" valign="middle">What kind of confirmation e-mail will be sent ?</td>
              <td align="left" valign="top"><?php echo $this->Form->input('email_type',array('label'=>'','options'=>array('s'=>'Standard','c'=>'Custom'),'type'=>'select','error'=>false));?></td>
            </tr>
            <tr class="create_sixth" id="custom_email_tr">
              <td align="right" valign="middle">Special e-mail confirmation text if selecting "Custom".</td>
              <td align="left" valign="top"><?php echo $this->Form->input('custom_email_message', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
            <tr class="create_sixth">
              <td align="right" valign="middle"></td>
              <td align="left" valign="top">  
               <input name="" type="button" value="Previous" rel="sixth" class="submit_bck_all cursorclass ui-state-default ui-corner-all" id="submit_bck">
              <input name="" type="button" value="Next" class="next_btn cursorclass ui-state-default ui-corner-all" id="submit_sixth"></td>
            </tr> 
          
          <!-------------------------------step6 end ------------------------------------------------------------> 
        
         
            
            
           <!-------------------------------step7 Start ------------------------------------------------------------>
            <tr class="create_seventh">
              <td align="right" valign="middle" width="300">Confirmation packet file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.show_confirm_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?>
                <input name="" type="button" value="Generate File"  class="cursorclass ui-state-default ui-corner-all">
              </td>
           	 
            </tr>
            <tr class="create_seventh">
              <td align="right" valign="middle">Show guide file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.show_guide_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?>
                <input name="" type="button" value="Generate File"  class="cursorclass ui-state-default ui-corner-all">
              </td>
            </tr>
            <tr class="create_seventh">
              <td align="right" valign="middle">Calendar / ICS file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.ics_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?>
                <input name="" type="button" value="Generate File"  class="cursorclass ui-state-default ui-corner-all">
              </td>
            </tr>
             <tr class="create_seventh">
              <td>&nbsp;</td>
              <td>
			   <input name="" type="button" value="Previous" rel="seventh" class="submit_bck_all cursorclass ui-state-default ui-corner-all" id="submit_bck">
			  <?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
               </td>
            </tr>
          
          <!-------------------------------step7 end ------------------------------------------------------------>  
            
            
        
            
            
                             
            
        
           
            
            
          </tbody>
        </table>
			<?php echo $this->Form->end();?>

      </div>
    </div>



