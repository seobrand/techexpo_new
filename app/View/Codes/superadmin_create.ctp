<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addcode')); ?>


<div class="display_row">
  <div class="table">
  <?php  echo $this->Form->create('Code' ,array('action'=>'create')); ?> 
  <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
        <tr>
          <td align="right" valign="middle" width="35%"><span class="required">*</span>Code Name:</td>
          <td align="left" valign="top" width="64%"><?php echo $this->Form->input('code_name',array('class'=>'inputbox1','label'=>false,'div'=>false,'id'=>'code_name','error'=>false)); ?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Visible:</td>
          <td align="left" valign="top"><?php  echo $this->Form->checkbox('visible',array('value'=>'Y'));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Sort Order:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('sort_order',array('type'=>'text','onkeypress'=>'return isNumericKey(event)','class'=>'sort_textfield','label'=>false,'div'=>false)); ?></td>
        </tr>        
        <tr>
         <td align="right" valign="middle">&nbsp;</td>
          <td><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->end();?>
  </div>
</div>