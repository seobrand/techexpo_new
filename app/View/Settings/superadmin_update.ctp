<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'editsetting')); ?>
<?php echo $this->Form->create('Setting', array('action'=>'update'));?>
<div class="title-pad">
  <div class="title">
    <h5>Edit Setting</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="15%" align="right" valign="top"><span class="required">*</span>Setting Name :</td>
        <td width="85%" align="left" valign="top"><?php echo $this->Form->input('name', array('label'=>'','id'=>'name','class'=>'inputbox1','tabindex'=>1,'div'=>false,'value'=>$data['Setting']['name'],'style'=>'width:255px;height:15px;','error'=>false)); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Setting Value :</td>
        <td align="left" valign="top"><?php echo $this->Form->input('value', array('label'=>'','id'=>'value','class'=>'inputbox1','tabindex'=>1,'div'=>false,'value'=>$data['Setting']['value'],'style'=>'width:255px;height:15px;','error'=>false)); ?></td>
      </tr> 
  <tr>
    <td align="right" valign="top">Description :</td>
    <td align="left" valign="top"><?php echo $this->Form->input('description',array('label'=>'','type'=>'textarea','class'=>'textarea_01','div'=>false,'value'=>$data['Setting']['description'],'rows'=>15,'cols'=>70,'error'=>false));?></td>
  </tr>		      
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td align="left" valign="top">
        <input type="hidden" name="SUBMIT" value="SUBMIT" />
        <?php echo $this->Form->input('id',array('label'=>'','type'=>'hidden','id'=>'settingid','value'=>$id,'div'=>false)); ?>
		<?php echo $this->Form->submit('Update',array('name'=>'update','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
     </table>
  </div>
</div>
<?php echo $this->Form->end();?> 