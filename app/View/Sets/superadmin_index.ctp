
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'setslist')); ?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Sets</div>
      
      <div style="float:right;font-weight:bold;"></div>
      
    </h5>
  </div>
  <?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add New Set" name="assign">',array('controller'=>'sets','action'=>'add'),array('escape'=>false)); ?>
</div>

<div class="display_row">
  <div class="table">
  <br/>
<!--  <?php echo $this->Form->postLink(
						'Delete All History',
						array('action' => 'deleteAllHistory','all'),
						array('confirm' => 'Are you sure to delete all history?','class'=>'a-state-default'));
					?><br/><br/><br/>-->
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <thead>
        <tr>
          <th width="5%" align="left" valign="middle"> Show Name  </th>


		  <th width="10%" align="center" valign="middle"> Action</th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($resumesetRecords as $resumesetRecord){?>
        <tr>
        
          <td align="left"><?php echo $resumesetRecord['ResumeSetRule']['set_descr']; ?></td>
	  <td align="center"><?php echo $this->Html->link('Edit Set',array('controller' => 'sets', 'action' => 'edit', $resumesetRecord['ResumeSetRule']['set_id'])); ?>
      &nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->Html->link('Delete Set',array('controller' => 'sets', 'action' => 'deleteSet', $resumesetRecord['ResumeSetRule']['set_id']),array('escape'=>false,'confirm' => 'Are you sure to delete set?')); 
	  ?>


</td>
        </tr>
        <?php } ?>
		<?php if(count($resumesetRecords)==0){?>
		<tr>
         <td colspan="8" align="center">No Sets available Yet.</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
