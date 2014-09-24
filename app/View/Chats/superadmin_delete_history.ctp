<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'deleteHistory')); ?>
<style type="text/css">
	input[type="text"]{	width:180px!important;}
</style>
<script>
$(function() {
       $("#startdatepicker").datepicker({ dateFormat: "yy-mm-dd" });
	   $("#enddatepicker").datepicker({ dateFormat: "yy-mm-dd" });
});
</script>
<div id="right2">
  <!-- table -->
  <div class="box1">
    <!-- box / title -->

    <div class="title-pad">
      <div class="title">
        <h5 style="width:97%;">
          <div style="float:left;">Employer Site Usage Stats</div>
          <div style="float:right;font-weight:bold;"></div>
        </h5>
      </div>
    </div>
    <div class="display_row">
      <div class="table">
        <table border="0" cellpadding="0" align="left">
          <?php  echo $this->Form->create('ChatMessage'); ?>
          <tbody>
            <tr>
              <td width="25%" valign="middle" align="right">Choose a start date for delete history:</td>
              <td valign="middle" width="74%"  align="left"><?php echo $this->Form->input('start_dt',array('label'=>false,'div'=>false,'maxlength'=>'50','class'=>'inputbox1','error'=>false,'id'=>'startdatepicker'));?><br>
              </td>
            </tr>
            <tr>
              <td valign="middle" align="right">Choose an end date for delete history:</td>
              <td valign="middle" align="left"><?php echo $this->Form->input('end_dt',array('label'=>false,'div'=>false,'maxlength'=>'50','class'=>'inputbox1','error'=>false,'id'=>'enddatepicker'));?> </td>
            </tr>
            <tr>
              <td valign="middle" align="right"></td>
              <td valign="middle" align="left"><?php echo $this->Form->submit('Delete History !',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?> <?php echo $this->Form->hidden('generate_stats',array('value'=>'generate_stats'));?> </td>
            </tr>
          </tbody>
          <?php echo $this->Form->end();?>
        </table>
      </div>
    </div>
  
  </div>
  <!-- end table -->
</div>
