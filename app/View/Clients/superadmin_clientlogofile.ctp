<?php //pr($this->request->data);?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Logo Upload</div>
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
  <?php echo $this->Form->create("Employer",array('type'=>'file'));?>
    <table>
      <tbody>
        <tr>
          <td width="24%"></td>
          <td width="74%">Update logo file for: <?php echo $common->getEmployerName($employerID); ?></td>
        </tr>
        <tr>
          <td valign="top" align="right">Logo file:</td>
          <td valign="top" align="left">
            <?php echo $this->Form->input("Employer.logo_file",array('type'=>'file','label'=>false,'div'=>false,'error'=>false));?>
			<br />
			<?php if($this->request->data['Employer']['old_logo']!=''){?>
				<?php echo $this->Html->image("../upload/".$this->request->data['Employer']['old_logo']);?>
			<?php } ?>
			</td>
        </tr>
        <tr>
          <td width="24%"></td>
          <td width="74%"><?php echo $this->Form->submit('Submit Logo',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->input("Employer.old_logo",array('type'=>'hidden','value'=>$this->request->data['Employer']['logo_file']));?>
	<?php echo $this->Form->end();?>
  </div>
</div>
