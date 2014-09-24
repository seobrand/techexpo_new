<?php 
echo $form->create('Jobboard', array('action'=>'send_mails/'.$jobId,'id'=>'mergeJobId','onsubmit'=>'return subForm();'));?> 
<div style="float:right"><?php echo $html->image('cancel.png',array('width'=>'16','height'=>'16', 'onclick'=>"hideShow('MailMergeBox','')"));?></div>
<table width="600px" border="0"  >
  <tr>
    <td>Subject</td>
    <td>:</td>
    <td><?php echo $form->input('sub',array('label'=>false,'value'=>$jobName,'div'=>false,'style'=>'width:582px;','id'=>'sub'));?></td>
  </tr>
  <tr>
    <td>From</td>
    <td>:</td>
    <td><?php echo $form->select('fromUser',$fromUserList,$currUserId,array('empty'=>'From address','id'=>'fromUser','style'=>'width:585px;'));?></td>
  </tr>
  <tr>
    <td valign="top">Message</td>
    <td valign="top">:</td>
    <td><?php echo $form->textarea('content',array('rows'=>'12','cols'=>'70','div'=>false,'id'=>'content'));?>
	<br /><?php echo $emailContent['EmailTemplate']['message']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $form->input('selIds',array('type'=>'hidden','id'=>'selIds')) ?>
<?php echo $form->input('redirectUrl',array('type'=>'hidden','value'=>$this->params['url']['url'])); ?>
<?php echo $form->submit('Send');?></td>
  </tr>
</table>
<script type="text/javascript">
function subForm() {
	if(!document.getElementById('sub').value) {
	  alert('Please enter subject');
	  return false;
	}
	if(!document.getElementById('fromUser').value) {
	  alert('Please select from User');
	  return false;
	}
	if(!document.getElementById('content').value) {
	  alert('Please enter content');
	  return false;
	}
	return true;
	//document.getElementById('mergeJobId').submit();
}	
</script>