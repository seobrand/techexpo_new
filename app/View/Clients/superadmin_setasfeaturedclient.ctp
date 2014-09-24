<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Set client as featured client</div>
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
  <?php if(!isset($featured)){?>
  <?php echo $this->Form->create("Employer", array('type'=>'post'));?>
    <table width="100%">
      <tbody>
        <tr>
          <td valign="middle" align="left">Set as featured:&nbsp;
            <?php echo $this->Form->input('is_featured',array('type'=>'select','options'=>array('y'=>'Yes','n'=>'No'),'div'=>false,'error'=>false,'label'=>false));?>
			<br />
          </td>
        </tr>
        <tr>
          <td><input type="submit" class="cursorclass ui-state-default ui-corner-all" name="operation" value="Set"></td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->end();?>
	<?php }else{?>
	<table width="100%">
      <tbody>
        <tr>
          <td valign="middle" align="left"><br/>This employer successfully set as featured employer...<br/><br/>
		  You can close this window.<br/><br/></td>
		 </tr>
		</tbody>
	</table>
	<?php } ?>
  </div>
</div>
