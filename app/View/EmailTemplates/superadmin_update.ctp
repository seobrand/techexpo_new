<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'editemailtemplate')); ?>
<?php echo $this->Form->create('EmailTemplate', array('action'=>'update'));?>
<?php echo $this->element('editor'); ?>
<div class="title-pad">
  <div class="title">
    <h5>Edit Email Template</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
	  <tr>
        <td align="right" valign="top"><span class="required">*</span>Title :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('title', array('label'=>'','id'=>'title','class'=>'inputbox1','tabindex'=>1,'div'=>false,'style'=>'width:415px;height:15px;','value'=>$data['EmailTemplate']['title'],'error'=>false)); ?></td>
      </tr>	  	
      <tr>
        <td width="15%" align="right" valign="top"><span class="required">*</span>Subject :</td>
        <td width="85%" align="left" valign="top"><?php echo $this->Form->input('subject', array('label'=>'','id'=>'subject','class'=>'inputbox1','tabindex'=>1,'div'=>false,'style'=>'width:415px;height:15px;','value'=>$data['EmailTemplate']['subject'],'error'=>false)); ?></td>
      </tr>
	  <tr>
        <td align="right" valign="top"><span class="required">*</span>Message :</td>
        <td align="left" valign="top"><table cellpadding="0" cellspacing="0" border="0" class="nostyle" >
				<tr><td><?php echo $this->Form->input('message', array('label'=>'','type'=>'textarea','cols'=>'50','rows'=>'20','value'=>$data['EmailTemplate']['message'],'error'=>false)); ?> </td></tr></table></td>
      </tr>
      <tr>
        <td align="right" valign="top"><?php echo $this->Form->input('id', array('type'=>'hidden','label'=>'','div'=>false,'value'=>$id)); ?></td>
        <td align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
     </table>
  </div>
</div>
<input type="hidden" name="SUBMIT" value="SUBMIT" />
<?php echo $this->Form->end();?>