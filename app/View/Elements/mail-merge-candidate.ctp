<?php echo $this->Form->create('Candidate', array('action'=>'send_mails','onsubmit'=>'return subForm();'));?> 
<div style="float:right"><?php echo $this->Html->image('cancel.png',array('width'=>'16','height'=>'16', 'onclick'=>"hideShow('MailMergeBox','')"));?></div>
<table width="600px" border="0"  >
  <tr>
    <td>Subject</td>
    <td>:</td>
    <td><?php echo $this->Form->input('sub',array('label'=>false,'div'=>false,'style'=>'width:580px;','id'=>'sub'));?></td>
  </tr>
  <tr>
    <td>From</td>
    <td>:</td>
    <td><?php /*$currUserId*/ echo $this->Form->select('fromUser',$fromUserList,array('empty'=>'From address','id'=>'fromUser','style'=>'width:585px;'));?></td>
  </tr>
  <tr>
    <td valign="top">Message</td>
    <td valign="top">:</td>
    <td><?php echo $this->Form->textarea('content',array('rows'=>'12','cols'=>'70','div'=>false,'id'=>'content'));?>
	<br /><?php echo $emailContent['EmailTemplate']['message']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $this->Form->input('selIds',array('type'=>'hidden','id'=>'selIds')) ?>
<?php echo $this->Form->input('redirectUrl',array('type'=>'hidden','value'=>$this->params['url']['url'])); ?>
<?php echo $this->Form->submit('Send');?></td>
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