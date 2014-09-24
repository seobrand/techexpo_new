<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Generate Show Book</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<div class="display_row">
  <div class="table">
  <?php echo $this->Form->create("generate_show_books",array('action'=>'cmpprofileforshow','type'=>'get'));?>
    <table cellspacing="0" cellpadding="0" border="0" align="center">
      <tr>
        <td valign="middle" align="left"><b>Select a show to create a show book / Create a Report for:</b><br />
          <br />
          <br />
          <select id="ShowEventId" name="show_id">
				<?php foreach($eventList as $key => $event){?>
				<option value="<?php echo $event['Show']['id'];?>"><?php echo date('F d, Y', strtotime($event['Show']['show_dt']));?> - <?php echo $event['Location']['location_city'].", ".$event['Location']['location_state'];?></option>
				<?php } ?>
			</select>
          <br />
          <br />
         <?php echo $this->Form->input('Show.show_name',array('type'=>'hidden','value'=>$event['Show']['show_name']));?>
		 <?php echo $this->Form->input('Show.show_dt',array('type'=>'hidden','value'=>$event['Show']['show_dt']));?>
		  <?php echo $this->Form->submit('Download Show Book',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
    </table>
	<?php echo $this->Form->end();?>
  </div>
</div>
