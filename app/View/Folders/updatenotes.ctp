<script type="text/javascript">
	function notesValidate()
	{
		//var notes=$("$notes").value;
		var notes=document.getElementById('notes').value;
		if(!notes)
		{
			alert('please enter note');
			return false;
		}
		
	}
</script>
<div id='inline_content' style='background:#fff;'>
  <p>
   <?php echo $this->Form->create('Folder',array('name'=>'resumeFolder','id'=>'resumeFolder','onSubmit'=>'return notesValidate()','action'=>'updatenotes/'.$fc['FolderContent']['fc_id']));?> <?php echo $this->Form->hidden('folder_id',array('value'=>$fc['FolderContent']['folder_id']));?>
  <ul class="form_list manage_resume_form">
    <li>
      <label style="margin-left:-42px !important;">Message / Notes:</label><br/>
      <div class="form_rt_col1" style="float:left !important; margin-left:10px !important;"> <?php echo $this->Form->textarea('notes',array('label'=>false,'class'=>'textarea_237 textarea_220','value'=>$fc['FolderContent']['notes'],'style'=>'margin-top:2px;','div'=>false,'id'=>"notes"));?> </div>
    </li>
    
   
    <li style="margin-left:10px !important;">
      Edited By :  <?php echo $this->Form->text('edited_by',array('label'=>false,'value'=>$fc['FolderContent']['edited_by'],'div'=>false,'style'=>'width:180px !important;height:20px !important','maxlength'=>'50'));?>
    </li>
    <li style="margin-left:10px !important;">
      <div class="form_rt_col1" style="width:108px !important"> <?php echo $this->Form->submit('images/submit_btn.jpg',array('div'=>false,'name'=>'Submit','onclick'=>'return notesValidate()'));?>  </div>
      <div style="margin-top:3px !important;" > Last Edit : <?php if(isset($fc['FolderContent']['edit_date'])) { echo date('m/d/Y',strtotime($fc['FolderContent']['edit_date'])); } ?></div>
    </li>
  </ul>
  <?php echo $this->Form->end();?>
  </p>
</div>
