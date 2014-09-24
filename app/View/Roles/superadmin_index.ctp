<?php  
 echo $this->element('admin-breadcrumbs',array('pageName'=>'role'));
 $this->set('title_for_layout', 'User Group List');
?>

<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<div class="title-pad">
  <div class="title">
    <h5>User Groups</h5>
    <div class="search">
      <div class="button"> <?php echo $this->Form->create('Role', array('action'=>'index'));?> <?php echo $this->Form->input('search',array('label'=>'','value'=>$search,'class'=>'inputbox','div'=>false));?>
        <?php echo $this->Form->submit('Filter',array('class'=>'cursorclass ui-state-default ui-corner-all','id'=>'button41','div'=>false));?> <?php echo $this->Form->end();?> </div>
      <div class="input">
        <div class="button" style="margin-top:1px;"><?php echo $this->Form->create('Role', array('controller'=>'roles','action'=>'create'));?>
		 <?php echo $this->Html->link('<input type="submit" name="submit" value="Add New User Group" class="cursorclass ui-state-default ui-corner-all"  />',array('controller'=>'roles','action'=>'create'),array('escape'=>false)); ?>
		<?php echo $this->Form->end();?> 
		</div>			
      </div>
    </div>
  </div>
</div>
<!-- end box / title -->
<!-- display box / first -->
<div class="display_row">
  <div class="table">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
      <thead>
        <tr>
          <th width="4%" align="center">
          <?php echo $this->Paginator->sort('Role.id','#'); ?>
          </th>
          <th width="88%" align="center">
           <?php echo $this->Paginator->sort('Role.role_name','User Groups'); ?>
          </th>
          <th width="8%" align="center"><a href="#">Action</a></th>
        </tr>
      </thead>
      <tbody>
        <?php 
			$i=0;
		if(is_array($data) && count($data)) {
			foreach ($data as $record) { ?>
        <tr>
          <td align="center"><?php echo $record['Role']['id']; ?></td>
          <td align="left"><?php echo $record['Role']['role_name']; ?></td>
          <td>
		 <table width="100%" border="0">
		 <tr>
		 <td width="33%" style="padding:0px;border:none;" align="center">		  
		  <?php echo $this->Html->link($this->Html->image('zoom.png',array('alt'=>'View User Group','width'=>16,'height'=>16,'title'=>'View User Group')),array('action'=>'view', $record['Role']['id']), array('escape' => false));?></td>
		  <td width="33%" style="padding:0px;border:none;" align="center">	
		  <?php echo $this->Html->link($this->Html->image('application_edit.png',array('alt'=>'Edit User Group','width'=>16,'height'=>16,'title'=>'Edit User Group')),array('action'=>'update', $record['Role']['id']), array('escape' => false));?></td>
		  
		  <td width="34%" style="padding:0px;border:none;" align="center">	
		  <?php	 echo $this->Html->link($this->Html->image('cancel.png',array('alt'=>'delete','width'=>16,'height'=>16,'title'=>'Delete User Group')),array('action'=>'delete', $record['Role']['id']),array('escape' => false),'Are you sure you wish to Delete this User Group?');?>
		  </td></tr></table>
		  
		  </td>
        </tr>
        <?php $i++;
			} ?>
			      </tbody>
    </table>
  </div>
</div>
<!-- display box / first end here -->
<div style="clear:both">
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
			<?php
		}
		else  { ?>
        <tr>
          <td colspan="3" align="center">No records found.</td>
        </tr>			      </tbody>
    </table>
  </div>
</div>
<?php } ?>