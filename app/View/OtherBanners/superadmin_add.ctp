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
   <?php  echo $this->Form->create('OtherBanner', array('enctype' => 'multipart/form-data','type' => 'post','action' => 'add') ); ?> 
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
      
        <tr>
          <td width="25%" align="right" valign="middle">Banner 
            Title: </td>
          <td align="left" width="74%"  valign="top"><?php echo $this->Form->input('name',array('div'=>false,'label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        
    
        <tr>
          <td align="right" valign="middle"> Image to upload: </td>
          <td align="left" valign="top"><?php echo $this->Form->input('filename',array('div'=>false,'label'=>'','class'=>'','error'=>false,'type'=>'file'));?>
          <br/> <b> Image Width 960px and Height 202px </b></td>
        </tr>
        
        <tr>
          <td align="right" valign="middle">&nbsp;</td>
          <td align="left" valign="top">
          <?php echo $this->Form->submit('Add Banner',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
		  <?php echo $this->Form->end();?>
		</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
