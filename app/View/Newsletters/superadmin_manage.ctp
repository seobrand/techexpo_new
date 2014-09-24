<?php $checked = ($newsletter['Newsletter']['active']==1)? true : false; ?>
<?php  //echo $this->element('admin-breadcrumbs',array('pageName'=>'editset')); ?>
<div class="display_row">
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Create/Edit Newsletter</div>      
      <div style="float:right;font-weight:bold;"></div>      
    </h5>
  </div>
  <?php //echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add New Set" name="assign">',array('controller'=>'sets','action'=>'add'),array('escape'=>false)); ?>
</div>
  <div class="table">
  <?php  echo $this->Form->create('Newsletter'); ?> 
  <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
        <tr>
          <td align="right" valign="middle" width="35%"><span class="required"></span>NewsLetter Title:</td>
          <td align="left" valign="top" width="64%"><?php echo $this->Form->input('newsletter_title',array('label'=>'','value'=>$newsletter['Newsletter']['newsletter_title'],'class'=>'inputbox1','error'=>false,'style'=>'width:468px'));?></td>
        </tr>        
        <tr>
          <td align="right" valign="top"><span class="required"></span> Description: </td>
          <td align="left" valign="top"><?php echo $this->Form->input('newsletter_description',array('type'=>'textarea','label'=>'','class'=>'mceEditor','value'=>$newsletter['Newsletter']['newsletter_description'],'error'=>false));?> </td>
        </tr> 
        <tr>
          <td align="right" valign="middle">&nbsp;</td>
          <td align="left" valign="top"><?php echo $this->Form->input('active',array('type'=>'checkbox','label'=>false,'div'=>false,'value'=>$newsletter['Newsletter']['active'],'error'=>false,'checked'=>$checked));?>Active</td>
        </tr>              
        <tr>
         <td align="right" valign="middle">&nbsp;</td>
          <td><?php echo $this->Form->submit('Save',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
	<?php 
	 echo $this->Form->input('id', array('type' => 'hidden','value'=> $id));
	echo $this->Form->end();?>
  </div>
</div>



