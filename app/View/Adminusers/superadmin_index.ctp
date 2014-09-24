<?php  
//echo Configure::version();
 echo $this->element('admin-breadcrumbs',array('pageName'=>'adminuser'));
 $this->set('title_for_layout', 'User Profile List');
?>
<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<div class="title-pad">
  <div class="title">
    <h5>User Profiles</h5>
    <div class="search">
      <div class="button"> <?php echo $this->Form->create('Adminuser', array('action'=>'index'));?> <?php echo $this->Form->input('search',array('label'=>'','value'=>$search,'class'=>'inputbox','div'=>false));?>
        <?php $optionList =  array('role'=>'Groups','name'=>'User Name');
	   echo $this->Form->select('act',$optionList,array('empty'=>'Filter By','class'=>'selectbox1'));
	   ?>
        <?php $optionList =  array('no'=>'No','yes'=>'Yes');
	   echo $this->Form->select('active',$optionList,array('empty'=>'Active','class'=>'selectbox1'));
	   ?>
        <?php echo $this->Form->submit('Filter',array('class'=>'cursorclass ui-state-default ui-corner-all','id'=>'button41','div'=>false));?> <?php echo $this->Form->end();?> </div>
      <div class="input">
        <div class="button" style="margin-top:1px;"><?php echo $this->Form->create('Adminuser', array('controller'=>'adminusers','action'=>'create'));?> <?php echo $this->Html->link('<input type="submit" name="submit" value="Add New User Profile" class="cursorclass ui-state-default ui-corner-all"  />',array('controller'=>'adminusers','action'=>'create'),array('escape'=>false)); ?> <?php echo $this->Form->end();?> </div>
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
          <th width="4%" align="center"><?php echo $this->Paginator->sort('Adminuser.id','#'); ?></th>
          <th width="20%" align="center"><?php echo $this->Paginator->sort('Adminuser.first_name','User Name'); ?></th>
          <th width="20%" align="center"><?php echo $this->Paginator->sort('Adminuser.username','Preferred Name'); ?></th>
          <th width="20%" align="center"><?php echo $this->Paginator->sort('Adminuser.email','Email'); ?></th>
          <th width="12%" align="center"><?php echo $this->Paginator->sort('Role.role_name','Groups'); ?></th>
          <th width="11%" align="center"><?php echo $this->Paginator->sort('Adminuser.created','Date Created'); ?></th>
          <th width="5%" align="center"><?php echo $this->Paginator->sort('Adminuser.active','Active'); ?></th>
          <th width="8%" align="center"><a href="#">Action</a></th>
        </tr>
      </thead>
      <tbody>
        <?php 
			$i=0;
		if(is_array($data) && count($data)) {
			foreach ($data as $record) { ?>
        <tr>
          <td align="center"><?php echo $record['Adminuser']['id']; ?></td>
          <td align="left"><?php echo $record['Adminuser']['first_name'].' '.$record['Adminuser']['last_name']; ?></td>
          <td align="left"><?php echo $record['Adminuser']['username']; ?></td>
          <td align="left"><?php echo $record['Adminuser']['email']; ?></td>
          <td align="left"><?php echo ucfirst($record['Role']['role_name']); ?></td>
          <td align="center"><?php echo date('d M Y',strtotime($record['Adminuser']['created'])); ?></td>
          <td align="center"><?php echo ucfirst($record['Adminuser']['active']); ?></td>
         <td><table width="100%" border="0">
              <tr>
                <td width="33%" style="padding:0px;border:none;" align="center"><?php echo $this->Html->link($this->Html->image('zoom.png',array('alt'=>'View User','width'=>16,'height'=>16,'title'=>'View User')),array('action'=>'view', $record['Adminuser']['id']), array('escape' => false));?></td>
                <td width="33%" style="padding:0px;border:none;" align="center"><?php echo $this->Html->link($this->Html->image('application_edit.png',array('alt'=>'Edit User','width'=>16,'height'=>16,'title'=>'Edit User')),array('action'=>'update', $record['Adminuser']['id']), array('escape' => false));?></td>
                
                <td width="34%" style="padding:0px;border:none;" align="center"><?php echo $this->Html->link($this->Html->image('cancel.png',array('alt'=>'delete','width'=>16,'height'=>16,'title'=>'Delete User')),array('action'=>'delete', $record['Adminuser']['id']),array('escape' => false),'Are you sure you wish to Delete this User?');  ?>	   
		 </td>
          
          
              </tr>
            </table></td>
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
  <td colspan="8" align="center">No records found.</td>
</tr>
</tbody>
</table>
</div>
</div>
<?php } ?>