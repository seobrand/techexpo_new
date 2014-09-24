<?php 
 echo $this->element('admin-breadcrumbs',array('pageName'=>'addemailtemplate'));
 $this->set('title_for_layout', 'Add Email Template');
?>
<?php echo $this->element('editor'); ?>
<?php echo $this->Form->create('EmailTemplate', array('action'=>'create','id'=>'form','enctype'=>'multipart/form-data'));?>
<div class="title-pad">
  <div class="title">
    <h5>Add New Email Template</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
	  <tr>
        <td align="right" valign="top"><span class="required">*</span>Title :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('title', array('label'=>'','id'=>'title','class'=>'inputbox1','div'=>false,'style'=>'width:415px;height:15px;','error'=>false)); ?></td>
      </tr>	
	  
	  	
      <tr>
        <td width="15%" align="right" valign="top"><span class="required">*</span>Subject :</td>
        <td width="85%" align="left" valign="top"><?php echo $this->Form->input('subject', array('label'=>'','id'=>'subject','class'=>'inputbox1','div'=>false,'style'=>'width:415px;height:15px;','error'=>false)); ?></td>
      </tr>
	  <tr>
        <td align="right" valign="top"><span class="required">*</span>Message :</td>
        <td align="left" valign="top"><table cellpadding="0" cellspacing="0" border="0" class="nostyle" >
				<tr><td><?php echo $this->Form->input('message', array('label'=>'','type'=>'textarea','cols'=>'50','rows'=>'20','id'=>'message','error'=>false)); ?> </td></tr></table></td>
      </tr>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false,'onsubmit'=>'editor_content()'));?></td>
      </tr>
     </table>
  </div>
</div>
<input type="hidden" name="SUBMIT" value="SUBMIT" />
<?php echo $this->Form->end();?>
<?php /*?>


<script type="text/javascript">

function editor_content() {

var text = tinyMCE.get('desc').getContent();
alert(text);	   
   }
</script><?php */?>