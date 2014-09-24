<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addshow')); ?>
<?php   
// for facny box
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
	
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
	
	$(".ajax").colorbox();
});
   
</script>

<div class="display_row">
      <div class="table">
	  <?php  echo $this->Form->create('Show', array('enctype' => 'multipart/form-data') ); ?> 
        <table  cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody>
            <tr>
              <td align="right" valign="middle" width="35%">Does this event require security clearance ?</td>
              <td align="left" valign="top" width="64%"><?php echo $this->Form->input('sec_clearance_req',array('label'=>'','options'=>array('y'=>'Yes','n'=>'No'),'type'=>'select','error'=>false));?></td>
            </tr>
            <tr valign="right" id="clearances_tr">
              <td align="right" valign="middle">Any specific clearances required ?</td>
              <td align="left" valign="top"><?php echo $this->Form->input('sec_clearance_list',array('label'=>'','options'=>$ck,'type'=>'select','multiple'=>true, 'size'=>'10','error'=>false));?>
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
            <tr>
              <td align="right" valign="middle"><span class="required">*</span>Show Date:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_dt',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Show End Date<br />
                (only for events that last more than 1 day):</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_end_dt',array('label'=>'','class'=>'inputbox1','error'=>false,'empty' => true));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle"><span class="required">*</span>Show Name:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_name',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle"><span class="required">*</span>Show Hours:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_hours',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Show description:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_descr', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'40'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Show Requirements</td>
              <td align="left" valign="top">Note: Bullet points MUST BE represented by **<br />
                <?php echo $this->Form->input('requirements', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?>
				</td>
            </tr>
            <tr>
              <td align="right" valign="middle">Show Travel Directions:</td>
              <td align="left" valign="top"> <?php echo $this->Form->input('show_travel_dir', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Special HTML for partners, announcements etc..</td>
              <td align="left" valign="top"><?php echo $this->Form->input('show_special_html', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Confirmation packet file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.show_confirm_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Show guide file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.show_guide_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Calendar / ICS file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.ics_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?></td>
            </tr>
          
            <tr>
              <td align="right" valign="middle">Special text <b>for boutique shows only</b>. Simple HTML tags such as &lt;br&gt;, &lt;b&gt;&lt;/b&gt; can be used to insert breaks, rulers, bold items etc...</td>
              <td align="left" valign="top"><?php echo $this->Form->input('boutique_special_html', array('label'=>'','type' => 'textarea', 'escape' => false,'error'=>false,'cols'=>'60','rows'=>'10'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Banner <b>for boutique shows only</b>:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.boutique_banner_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Banner link / URL <b>for boutique shows only</b>:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('banner_url',array('label'=>'','type' => 'text','value'=>'http://','size'=>'40','class'=>'inputbox1','error'=>false));?>
                <br />
                enter full URL (eg: http://www.techexpoUSA.com)<br />
                <br /></td>
            </tr>            
            <tr>
              <td align="right" valign="middle">Type of pre-registration:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('prereg_type',array('label'=>'','options'=>array('n'=>'Normal - through TECHEXPO site','s'=>'Special - outside web site'),'type'=>'select','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">Resume set for this show:</td>
              <td align="left" valign="top">
               <?php echo $this->Form->input('resume_set_id',array('label'=>'','options'=>$resume_set,'empty'=>'Select Resume Set','type'=>'select','error'=>false));?>
               or    <?php echo $this->Html->link('Click Here to create new resume set', array('controller'=>'sets','action'=>'add'),array('target'=>'blank','escape'=>false)); ?> 
               </td>
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
              <td>&nbsp;</td>
              <td><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
               </td>
            </tr>
          </tbody>
        </table>
			<?php echo $this->Form->end();?>

      </div>
    </div>



