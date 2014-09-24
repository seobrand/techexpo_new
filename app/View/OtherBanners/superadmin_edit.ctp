<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Banner Management</div>
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
   <?php  echo $this->Form->create('OtherBanner', array('enctype' => 'multipart/form-data','type' => 'post','action' => 'edit') ); ?> 
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
        <tr>
          <td width="25%" align="right" valign="middle">Banner 
            Title: </td>
          <td align="left" width="74%"  valign="top"><?php echo $this->Form->input('name',array('div'=>false,'label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
    
        
        
        <tr>
          <td align="right" valign="middle"> Image to upload: </td>
          <td align="left" valign="top">
		  <?php echo $this->Form->input('filename',array('div'=>false,'label'=>'','class'=>'','error'=>false,'type'=>'file'));?>
           <input type="checkbox" name="data[OtherBanner][keep_same]" value="1" <?php if(isset($this->request->data['OtherBanner']['old_filename'])){?> checked="checked" <?php } ?>>
            <font face="Verdana, Arial, Helvetica, sans-serif" size="1">Keep the same image</font>
            <br/> <b> Image Width 960px and Height 202px </b>
            </td>
        </tr>
		<?php if(isset($this->request->data['OtherBanner']['old_filename'])){?>
        <tr>
          <td valign="middle" align="left" colspan="2"><span style="margin-left:165px !important;"> <b>Current file name:</b> <?php echo $this->request->data['OtherBanner']['old_filename'];?></span></td>
        </tr>
        
        <tr>
       
          <td align="center" valign="middle" colspan="2">
		  	<img src="<?php echo $this->webroot;?>Banner/<?php echo $this->request->data['OtherBanner']['old_filename'];?>" alt="<?php echo $this->request->data['OtherBanner']['alt'];?>" align="absmiddle">
		   </td>
        </tr>
		<?php } ?>
        <tr>
          <td align="right" valign="middle">&nbsp;</td>
          <td align="left" valign="top"><?php echo $this->Form->input('id', array('type' => 'hidden'));?>
		  <?php echo $this->Form->input('old_filename', array('type' => 'hidden','value'=>$this->request->data['OtherBanner']['old_filename']));?>
          <?php echo $this->Form->submit('Update Banner',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
		  <?php echo $this->Form->end();?>
	  
			<?php /*  echo $this->Form->postLink(
				'Delete Banner',
				array('action' => 'deletebanner',$id),
				array('confirm' => 'Are you sure to delete?','class'=>'a-state-default'));
				*/
			?>
		</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
