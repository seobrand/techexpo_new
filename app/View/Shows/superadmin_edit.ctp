<?php // echo $this->element('admin-breadcrumbs',array('pageName'=>'editshow'));
?>
<script type="text/javascript">
$(document).ready(function() {
	
	// for security clearance
  	 $("#ShowSecClearanceReq").change(function(){
       var sce_clear = $("#ShowSecClearanceReq").val();
	   if(sce_clear == 'n')
	   $("#clearances_tr").hide('500');
	   else if((sce_clear == 'y'))
	   $("#clearances_tr").show('500');
    });
	
	// for Special e-mail confirmation
  	 $("#ShowEmailType").change(function(){
       var spc_email = $("#ShowEmailType").val();
	   if(spc_email == 's')
	   $("#custom_email_tr").hide('500');
	   else if((spc_email == 'c'))
	   $("#custom_email_tr").show('500');
    });
	
});
   
</script>
<?php 
$eventDt =$this->request->data['Show']['show_dt'];
$curentdate = date('Y-m-d', time());

if(strtotime($eventDt) < strtotime($curentdate))
{ $dateinput = $eventDt;   }
else
{ $dateinput = 0;  }


?>

<script>
$(function() {
	
	
   	   
	   	if ($('#startdatepicker').length && $('#enddatepicker').length)
		{ 
			$( "#startdatepicker" ).datepicker({
				dateFormat: "yy-mm-dd" ,
				 minDate: '<?php echo $dateinput;  ?>',
				defaultDate: "+1d",
				changeMonth: false,
				numberOfMonths: 1,
				onClose: function( selectedDate ) {
					$( "#enddatepicker" ).datepicker( "option", "minDate", selectedDate );
				}
			}).datepicker( "option", "maxDate", $('#enddatepicker').val() );
	
			$( "#enddatepicker" ).datepicker({
				dateFormat: "yy-mm-dd", 
				 minDate: '0',
				defaultDate: "+1d",
				changeMonth: false,
				numberOfMonths: 1,
				onClose: function( selectedDate ) {
					$( "#startdatepicker" ).datepicker( "option", "maxDate", selectedDate );
				}
			}).datepicker( "option", "minDate", $('#startdatepicker').val() );
		}
	   
	   
});
</script>

<div class="display_row">
      <div class="table">
	  <?php  echo $this->Form->create('Show', array('enctype' => 'multipart/form-data','type' => 'post','action' => 'edit') ); ?> 
        <table  cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody>
            <tr>
              <td align="right" valign="middle" width="35%">Does this event require security clearance ?</td>
              <td align="left" valign="top" width="64%"><?php echo $this->Form->input('sec_clearance_req',array('label'=>'','options'=>array('y'=>'Yes','n'=>'No'),'type'=>'select','error'=>false));?>
              
             
              </td>
            </tr>
            
            <tr valign="right" id="clearances_tr">
              <td align="right" valign="middle">Any specific clearances required ?</td>
              <td align="left" valign="top"><?php echo $this->Form->input('sec_clearance_list',array('label'=>'','options'=>$ck,'selected'=>$selectedCK,'type'=>'select','multiple'=>true, 'size'=>'10','error'=>false));?>
                <font size="1" face="verdana,arial,helvetica,sans-serif"> <br />
                Hold down the control / command key to select several options</font><br /></td>
            </tr>
            
            <tr>
              <td align="right" valign="middle">Is this event a regular or boutique event ?</td>
              <td align="left" valign="top"><?php echo $this->Form->input('boutique',array('label'=>'','options'=>array('r'=>'Regular','b'=>'Boutique'),'type'=>'select','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle"><span class="required">*</span>Show Location</td>
              <td align="left" valign="top"><?php echo $this->Form->input('location_id',array('label'=>'','options'=>$loc_list,'type'=>'select','error'=>false));?></td>
            </tr>
              <tr class="create_first">
              <td align="right" valign="middle"><span class="required">*</span>Show Date:</td>
              <td align="left" valign="top">
			  <?php //  echo $this->Form->input('show_dt',array('label'=>'','class'=>'inputbox1','error'=>false));?>
              <?php echo $this->Form->input('show_dt',array('label'=>false,'div'=>false,'maxlength'=>'50','class'=>'inputbox1','type'=>'text','id'=>'startdatepicker'));?>
              </td>
            </tr>
            <tr class="create_first">
              <td align="right" valign="middle">Show End Date<br />
                (only for events that last more than 1 day):</td>
              <td align="left" valign="top">
			  <?php // echo $this->Form->input('show_end_dt',array('label'=>'','class'=>'inputbox1','error'=>false,'empty' => true));?>
              <?php echo $this->Form->input('show_end_dt',array('label'=>false,'div'=>false,'maxlength'=>'50','class'=>'inputbox1','type'=>'text','id'=>'enddatepicker'));?> 
              </td>
            </tr>
            
            <tr>
              <td align="right" valign="middle"><span class="required">*</span>Show Name:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_name',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            
             <tr>
              <td align="right" valign="middle"><span class="required"></span>Show Display Name</td>
              <td align="left" valign="top"><?php echo $this->Form->input('display_name',array('label'=>'','class'=>'inputbox1'));?></td>
            </tr>
            
            <tr>
              <td align="right" valign="middle">Show Display Requirements</td>
              <td align="left" valign="top">
               <?php echo $this->Form->input('special_message',array('label'=>'','class'=>'inputbox1'));?>
				</td>
            </tr>
            <tr>
              <td align="right" valign="middle"><span class="required">*</span>Show Hours:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_hours',array('label'=>'','class'=>'inputbox1','error'=>false));?>   <font size="1" face="verdana,arial,helvetica,sans-serif"> <br />
               Example : 10am - 5pm</font><br /></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Show description:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_descr', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'40'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Show Requirements</td>
              <td align="left" valign="top"><!--Note: Bullet points MUST BE represented by **--><br />
                <?php echo $this->Form->input('requirements', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?>
				</td>
            </tr>
            <tr>
              <td align="right" valign="middle">Show Travel Directions:</td>
              <td align="left" valign="top"> <?php echo $this->Form->input('show_travel_dir', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Special HTML for partners, announcements etc..</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.show_special_html', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10','value'=>$this->request->data['Show']['show_special_html']));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Confirmation packet file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.show_confirm_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?>
			  
			  
			    <?php  
				
				echo '<br/>'.$this->Html->link('Download Word (.doc) File',array('superadmin'=>true,'controller'=>'shows','action'=>'wordfile',$this->request->data['Show']['id']),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px;'));
				
				if($this->request->data['Show']['show_confirm_file']!='' && file_exists('ShowsDocument/showConfirmFile/'.$this->request->data['Show']['show_confirm_file']) ){  echo $this->Html->link('Download File',array('superadmin'=>true,'controller'=>'shows','action'=>'downloadfile',$this->request->data['Show']['show_confirm_file'],'show_confirm_file'),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px;margin:0 0 0 10px;')); } 
				

				?>
                
			  <?php // echo $this->request->data['Show']['show_confirm_file'];?>
			  <?php if($this->request->data['Show']['show_confirm_file']!='' && file_exists('ShowsDocument/showConfirmFile/'.$this->request->data['Show']['show_confirm_file']) ){ echo $this->Form->checkbox('keep_conf_same', array('checked'=>'checked','value' => 1)); 
			  
			 /* else{ echo $this->Form->checkbox('keep_conf_same', array('value' => 0)); }*/
			 
			  ?>
			     <font size="1" face="Verdana,Arial,Helvetica,sans-serif">Keep the same file</font> 
                 <?php } else {
				 echo $this->Html->link('Generate File',array('controller'=>'shows','action'=>'showpacket',$this->request->data['Show']['id']),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px'));
				 
				 } 				?>
                </td>
            </tr>
            <tr>
              <td align="right" valign="middle">Show guide file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.show_guide_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?>
			  
			  <?php // echo $this->request->data['Show']['show_guide_file'];?>
              <?php
			  echo '<br/>'.$this->Html->link('Download Word (.doc) File',array('superadmin'=>true,'controller'=>'shows','action'=>'wordguidefile',$this->request->data['Show']['id']),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px;margin-right:10px;'));
			 
			  
			  if($this->request->data['Show']['show_guide_file']!='' && file_exists('ShowsDocument/showGuide/'.$this->request->data['Show']['show_guide_file'])){  echo $this->Html->link('Download File',array('superadmin'=>true,'controller'=>'shows','action'=>'downloadfile',$this->request->data['Show']['show_guide_file'],'show_guide_file'),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px')); } ?>
              
			   <?php if($this->request->data['Show']['show_guide_file']!='' && file_exists('ShowsDocument/showGuide/'.$this->request->data['Show']['show_guide_file'])){ echo $this->Form->checkbox('keep_guide_same', array('checked'=>'checked','value' => 1)); 
			   
			  // else{ echo $this->Form->checkbox('keep_guide_same', array('value' => 0)); }
			     ?>
                <font size="1" face="Verdana,Arial,Helvetica,sans-serif">Keep the same file</font>
                 <br />
               <?php } ?>
               </td>
            </tr>
            <tr>
              <td align="right" valign="middle">Calendar / ICS file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.ics_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?><?php // echo $this->request->data['Show']['ics_file'];?>
              
                <?php  if($this->request->data['Show']['ics_file']!='' && file_exists('ShowsDocument/ics/'.$this->request->data['Show']['ics_file'])){  echo $this->Html->link('Download File',array('superadmin'=>true,'controller'=>'shows','action'=>'downloadfile',$this->request->data['Show']['ics_file'],'ics_file'),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px')); } ?>
              
			  <?php if($this->request->data['Show']['ics_file']!='' && file_exists('ShowsDocument/ics/'.$this->request->data['Show']['ics_file'])){ echo $this->Form->checkbox('keep_ics_same', array('value' => 1,'checked'=>'checked')); 
			  
			  //else{ echo $this->Form->checkbox('keep_ics_same', array('value' => 0));}?>
                <font size="1" face="Verdana,Arial,Helvetica,sans-serif">Keep the same file</font>
                <br />
                <?php } else {
				$show_display_name = (!empty($this->request->data['Show']['display_name'])) ? $this->request->data['Show']['display_name'] : $this->request->data['Show']['show_name'];
				
   $site_address =(!empty($this->request->data['Location']['site_address'])) ? '#'.$this->request->data['Location']['site_address'] : "";	
   $site_address .=(!empty($this->request->data['Location']['location_city'])) ? '#'.$this->request->data['Location']['location_city'].', ' : "";
   $site_address .=(!empty($this->request->data['Location']['location_state'])) ? $this->request->data['Location']['location_state'] : "";  
   $site_address .=(!empty($this->request->data['Location']['site_zip'])) ? " ".$this->request->data['Location']['site_zip'] : "";
   $show_location = "".$this->request->data['Location']['site_name'].' '.$site_address;
			
				
   //  $show_detail = $show_location."#Show Name: ".$event['Show']['show_name'];
$show_detail = $show_location;
$show_detail.= (!empty($this->request->data['Show']['show_hours'])) ? "#Show Time: ".$this->request->data['Show']['show_hours'] : ""; 
$show_detail.= (!empty($this->request->data['Show']['display_name'])) ? "##".$this->request->data['Show']['display_name'] : "";
$show_detail.= (!empty($this->request->data['Show']['special_message'])) ? ",  ".$this->request->data['Show']['special_message'] : "";
			   
		
			   
			   $show_location2 = $this->request->data['Location']['site_name'];
				
			   $Alldaytime =explode('-',$this->request->data['Show']['show_hours']);
			
			   $starttime = date('Ymd H:i:s', strtotime($this->request->data['Show']['show_dt'].' '.$Alldaytime['0']));  
			   if(!empty($this->request->data['Show']['show_end_dt']))
			   $endtime = date('Ymd H:i:s', strtotime($this->request->data['Show']['show_end_dt'].' '.$Alldaytime['1'])); 
			   else
			   $endtime = date('Ymd H:i:s', strtotime($this->request->data['Show']['show_dt'].' '.$Alldaytime['1']));
			   
					// echo '<br/>'.$this->Html->link('Generate File', array('superadmin'=>false,'controller'=>'users','action'=>'icalender2',$starttime,$endtime,$show_display_name,$show_detail,$show_location2),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px'));
					echo '<br/>'.$this->Html->link('Generate File', array('superadmin'=>false,'controller'=>'users','action'=>'icalenderOrg',$this->request->data['Show']['id']),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px'));
					
				} ?>
                
                
                
                </td>
            </tr>
          
            <tr>
              <td align="right" valign="middle">Special text <b>for boutique shows only</b>. Simple HTML tags such as &lt;br&gt;, &lt;b&gt;&lt;/b&gt; can be used to insert breaks, rulers, bold items etc...</td>
              <td align="left" valign="top"><?php echo $this->Form->input('boutique_special_html', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Banner <b>for boutique shows only</b>:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.boutique_banner_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?><?php echo $this->request->data['Show']['boutique_banner_file'];?>
			   <?php if($this->request->data['Show']['boutique_banner_file']){ echo $this->Form->checkbox('banner_not_upload', array('value' => 1,'checked'=>'checked'));}else{ echo $this->Form->checkbox('banner_not_upload', array('value' => 0));} ?>
                <font size="1" face="Verdana,Arial,Helvetica,sans-serif">Do not upload file</font>
                <br />
			  </td>
            </tr>
            <tr>
              <td align="right" valign="middle">Banner link / URL <b>for boutique shows only</b>:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('banner_url',array('label'=>'','type' => 'text','size'=>'40','class'=>'inputbox1','error'=>false));?>
                <br />
                enter full URL (eg: http://www.techexpoUSA.com)<br />
                <br /></td>
            </tr>
			<tr>
              <td align="right" valign="middle">Resume set for this show:</td>
              <td align="left" valign="top">
			  <?php echo $this->Html->link($this->request->data['ResumeSetRule']['set_descr'],array('superadmin'=>true,'controller'=>'sets','action'=>'edit',$this->request->data['ResumeSetRule']['set_id']),array('target'=>'blank')) ?>
			  <?php // echo $this->Form->input('resume_set_id',array('label'=>'','options'=>$resume_set,'type'=>'select','error'=>false,'empty'=>'Select Set'));?></td>
            </tr>            
            <tr>
              <td align="right" valign="middle">Type of pre-registration:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('prereg_type',array('label'=>'','options'=>array('n'=>'Normal - through TECHEXPO site','s'=>'Special - outside web site'),'type'=>'select','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Registration URL (for outside <br />
                web site registration:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('prereg_url',array('label'=>'','type' => 'text','size'=>'40','class'=>'inputbox1','error'=>false));?>
                <br />
                enter full URL (eg: http://www.techexpoUSA.com)<br />
                <br /></td>
            </tr>
            <tr>
              <td align="right" valign="middle">What kind of confirmation e-mail will be sent ?</td>
              <td align="left" valign="top"><?php echo $this->Form->input('email_type',array('label'=>'','options'=>array('s'=>'Standard','c'=>'Custom'),'type'=>'select','error'=>false));?></td>
            </tr>
            <tr id="custom_email_tr">
              <td align="right" valign="middle">Special e-mail confirmation text if selecting "Custom".</td>
              <td align="left" valign="top"><?php echo $this->Form->input('custom_email_message', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
       		 <tr>
              <td align="right" valign="middle">Publish status</td>
              <td align="left" valign="top"><?php /* if($this->request->data['Show']['published']!=''){ echo $this->Form->checkbox('keep_conf_same', array('checked'=>'checked','value' => 1)); }else{ echo $this->Form->checkbox('published', array('value' => 0)); }
	*/
			 echo $this->Form->checkbox('published'); 
			   ?></td>
            </tr>
            <tr>
              <td>
				  <?php echo $this->Form->input('old_conf_file', array('type' => 'hidden','value'=>$this->request->data['Show']['show_confirm_file']));?>
				  <?php echo $this->Form->input('old_guide_file', array('type' => 'hidden','value'=>$this->request->data['Show']['show_guide_file']));?>
				  <?php echo $this->Form->input('old_ics_file', array('type' => 'hidden','value'=>$this->request->data['Show']['ics_file']));?>
				  
				  <?php echo $this->Form->input('old_boutique_file', array('type' => 'hidden','value'=>$this->request->data['Show']['boutique_banner_file']));?>
			  </td>
              <td>
				  <?php echo $this->Form->input('id', array('type' => 'hidden'));?>
				  <?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
				  <?php echo $this->Form->end();?>
			  
					<?php echo $this->Form->postLink(
						'Delete',
						array('action' => 'delete',$id),
						array('confirm' => 'Are you sure to delete?','class'=>'cursorclass ui-state-default ui-corner-all a-state-default','div'=>false,'label'=>false,'style'=>'padding:5px 13px 6px!important;'));
					?>
               </td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>



