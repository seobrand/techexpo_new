<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addset')); ?>
<script>
$(function() {	
       $("#start_dt").datepicker({ dateFormat: "yy-mm-dd" });
	   $("#end_dt").datepicker({ dateFormat: "yy-mm-dd" });
});

function insert_states(){
	var states_list ='AL,AK,AZ,AR,CA,CO,CT,DE,DC,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY';
	$("#state_list").attr('value',states_list);
	}
</script>

<div class="display_row">
  <div class="table">
  <?php  echo $this->Form->create('Set'); ?> 
  <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
        <tr>
          <td align="right" valign="middle" width="35%"><span class="required"></span>Set Description::</td>
          <td align="left" valign="top" width="64%"><?php echo $this->Form->input('set_descr',array('label'=>'','class'=>'inputbox1', 'error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required"></span>Start Date: yyyy-mm-dd</td>
          <td align="left" valign="top"><?php echo $this->Form->input('start_dt',array('label'=>'','class'=>'inputbox1','id'=>'start_dt','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required"></span>End Date: yyyy-mm-dd:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('end_dt',array('label'=>'','class'=>'inputbox1','id'=>'end_dt','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required"></span>State List: NY,NJ...:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('state_list',array('label'=>'','class'=>'inputbox1','error'=>false,'id'=>'state_list','style'=>'width:600px;'));?><br/>
         <a onclick="insert_states();" > INSERT ALL STATES </a>
          </td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required"></span>Keywords filtering (open houses): </td>
          <td align="left" valign="top"><?php echo $this->Form->input('custom_clause',array('type'=>'textarea','label'=>'','class'=>'smallTextB mceNoEditor','error'=>false));?>								
          <small>	
Enter a boolean search phrase as in the adavanced resume search, enclosing keywords in double-quotes. e.g: "Java" OR "JSP" OR "Java Server Pages" OR "JDBC"</small>
          </td>
        </tr>
        <tr>
          <td align="right" valign="middle">Short Description:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('short_desc',array('label'=>'','class'=>'inputbox1'));?></td>
        </tr>
        <?php /*
        <tr>
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
		*/ ?>
        <tr>
         <td align="right" valign="middle">&nbsp;</td>
          <td><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->end();?>
  </div>
</div>



