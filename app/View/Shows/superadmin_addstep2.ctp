<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addshow')); ?>
<?php   
// for facny box
	
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
	
?>

<script type="text/javascript">

var jk = jQuery.noConflict();

jk(document).ready(function() {
	
	
			 
	   
});



   
</script>

<div class="display_row">
      <div class="table">
	  <?php  echo $this->Form->create('Show', array('action'=>'addstep2','enctype' => 'multipart/form-data','type'=>'post') ); ?> 
        <table  cellspacing="0" cellpadding="0" border="0" align="center">
          <tbody>
    	   <tr>
            <td colspan="2"  valign="middle"><b><h3>Create Event Document  :</h3></b></td>
            
            </tr>
      
        
         
            
            
           <!-------------------------------step7 Start ------------------------------------------------------------>
            <tr class="create_seventh">
              <td align="right" valign="middle" width="300">Confirmation packet file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.show_confirm_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?><br/>
                <?php echo $this->Html->link('Download File',array('superadmin'=>true,'controller'=>'shows','action'=>'downloadguidefile',$event['Show']['show_confirm_file']),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px')); ?>
				<?php echo $this->Form->input('Show.old_show_confirm_file',array('type'=>'hidden','value'=>$event['Show']['show_confirm_file'])); ?>
                <?php // echo $this->Html->link('Download File',array('controller'=>'shows','action'=>'showpacket',$showID),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px')); ?>
                
                <br/>
              </td>
           	 
            </tr>
            <?php /* ==============Removed By Jitendra on 30 July 2013 task #1311 =================== ?>
            <tr class="create_seventh">
              <td align="right" valign="middle">Show guide file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.show_guide_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?><br/>
               <?php echo $this->Html->link('Generate File', array('superadmin'=>false,'controller'=>'users','action'=>'icalender'),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px'));  ?>
              </td>
            </tr>
            <?php ==================================== END ============================================ */?>
            
            <tr class="create_seventh">
              <td align="right" valign="middle">Calendar / ICS file:</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Show.ics_file', array('between'=>'<br />','type'=>'file','size'=>'50','label'=>'','error'=>false));?><br/>
               <?php if(empty($event['Show']['show_end_dt'])) $event['Show']['show_end_dt'] = $event['Show']['show_dt'];
			   
			   $event['Show']['show_end_dt'] = date("Ymd", strtotime($event['Show']['show_end_dt'])) . " +1 day";
			   // comment by Jitendra on 30 july 2013 in reference of ticket id 1311 
			   //$event['Show']['show_name'] = $event['Show']['show_name'].'#Location:'.$event['Location']['site_name'].' '.$event['Location']['site_address'].'#'.$event['Location']['location_city'].' '.$event['Location']['location_state'].' '.$event['Location']['site_zip'];
			   $show_display_name = (!empty($event['ShowsHome']['display_name'])) ? $event['ShowsHome']['display_name'] : $event['Show']['show_name'];
			   $show_detail = "Show Name: ".$event['Show']['show_name'];
			   $show_detail .= (!empty($event['ShowsHome']['special_message'])) ? "#Display Requirement: ".$event['ShowsHome']['special_message'] : "";
			   $show_detail .= (!empty($event['Show']['show_hours'])) ? "#Show Time: ".$event['Show']['show_hours'] : "";
			   $site_address =(!empty($event['Location']['site_address'])) ? ', '.$event['Location']['site_address'] : "";
			   $show_location = $event['Location']['site_name'].''.$site_address;
			
			   echo $this->Html->link('Generate File', array('superadmin'=>false,'controller'=>'users','action'=>'icalender2',date('Ymd', strtotime($event['Show']['show_dt'])),date('Ymd', strtotime($event['Show']['show_end_dt'])),$show_display_name,$show_detail,$show_location),array('escape'=>false,'class'=>'cursorclass ui-state-default ui-corner-all','style'=>'padding:0px 5px 0px'));  ?>
              
              </td>
            </tr>
             <tr class="create_seventh">
              <td>&nbsp;</td>
              <td>
			
			  <?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
               </td>
            </tr>
          
          <!-------------------------------step7 end ------------------------------------------------------------>  
            
              
           
            
            
          </tbody>
        </table>
			<?php echo $this->Form->end();?>

      </div>
    </div>



