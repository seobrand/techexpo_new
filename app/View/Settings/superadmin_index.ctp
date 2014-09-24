<?php
 echo $this->element('admin-breadcrumbs',array('pageName'=>'setting'));
 $this->set('title_for_layout', 'Settings');
?>
<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<div class="title-pad">
  <div class="title">
    <h5>Settings</h5>
    <div class="search">
      <div class="button"> <?php echo $this->Form->create('Setting', array('action'=>'index'));?> <?php echo $this->Form->input('search',array('label'=>'','value'=>$search,'class'=>'inputbox', 'div'=>false));?> <?php echo $this->Form->submit('Filter',array('class'=>'cursorclass ui-state-default ui-corner-all','id'=>'button41','div'=>false));?> <?php echo $this->Form->end();?> </div>
      <div class="input">
        <div class="button" style="margin-top:1px;"><?php echo $this->Form->create('Setting', array('controller'=>'settings','action'=>'create'));?> <?php echo $this->Html->link('<input type="submit" name="submit" value="Add New Setting" class="cursorclass ui-state-default ui-corner-all"  />',array('controller'=>'settings','action'=>'create'),array('escape'=>false)); ?> <?php echo $this->Form->end();?> </div>
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
          <th width="4%" align="center"><?php echo $this->Paginator->sort('Setting.id','#'); ?></th>
          <th width="30%" align="center"><?php echo $this->Paginator->sort('Setting.name','Name'); ?></th>
          <th width="29%" align="center"><?php echo $this->Paginator->sort('Setting.value','Value'); ?></th>
          <th width="29%" align="center"><?php echo $this->Paginator->sort('Setting.description','Description'); ?></th>		  
          <th width="8%" align="center"><a href="#">Action</a></th>
        </tr>
      </thead>
      <tbody>
        <?php 
			$i=0;
		if(is_array($data) && count($data)) {
			foreach ($data as $data) { ?>
        <tr>
          <td align="center"><?php echo $data['Setting']['id']; ?></td>
          <td align="left"><?php echo $data['Setting']['name']; ?></td>
          <td align="left"><?php echo $data['Setting']['value']; ?></td>
          <td align="left"><?php 
		  $module =  explode(' ',$data['Setting']['description']);
		  if(count($module)>6) {
		  		$mod = $module[0].' '.$module[1].' '.$module[2].' '.$module[3].' '.$module[4].' '.$module[5].'...';
		  } else {
		  		$mod = $data['Setting']['description'];
		  }
		  echo $mod;?></td>
		 <?php  if($data['Setting']['name'] == 'DATE_FORMAT' || $data['Setting']['name'] == 'CALENDAR_DATE_FORMAT' || $data['Setting']['name'] == 'ADMIN_PER_PAGE_RECORD')  { ?><td align="left">
		 <table width="100%" border="0">
		 <tr>
		 <td width="100%" style="padding:0px;border:none;" align="left">  
		<?php echo '&nbsp;&nbsp;&nbsp;'.$this->Html->link($this->Html->image('zoom.png',array('alt'=>'View Setting','width'=>16,'height'=>16,'title'=>'View Setting')),array('action'=>'view', $data['Setting']['id']), array('escape' => false));?>
		</td></tr></table>
		</td>		
		<?php
		 } 
		 
		 else { ?>   <td align="left">   
		 <table width="100%" border="0">
		 <tr>
		 <td width="50%" style="padding:0px;border:none;" align="center">     
		  <?php echo '&nbsp;&nbsp;&nbsp;'.$this->Html->link($this->Html->image('zoom.png',array('alt'=>'View Setting','width'=>16,'height'=>16,'title'=>'View Setting')),array('action'=>'view', $data['Setting']['id']), array('escape' => false));?></td>
		  <td width="50%" style="padding:0px;border:none;" align="center"> 
		  <?php echo $this->Html->link($this->Html->image('application_edit.png',array('alt'=>'Edit Setting','width'=>16,'height'=>16,'title'=>'Edit Setting')),array('controller'=>'settings','action'=>'update', $data['Setting']['id']), array('escape' => false));?></td></tr></table></td>
            <?php 		  
	/*if(isset($deletepermissions) && $deletepermissions || $this->Session->read('Auth.Adminuser.role_id')==1) {
		  echo $this->Html->link($this->Html->image('cancel.png',array('alt'=>'delete','width'=>16,'height'=>16,'title'=>'Delete Setting')),array('action'=>'delete', $data['Setting']['id']),array('escape' => false),'Are you sure you wish to Delete this Setting?');
		} 
	else 		   
		{				   
		  echo $this->Html->link($this->Html->image('cancel.png',array('alt'=>'delete','width'=>16,'height'=>16,'title'=>'Delete Client')),array('controller'=>'adminusers','action'=>'home',$this->params['controller']),array('escape' => false));
		  }*/
		   }
		  ?>
		  
		  
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
          <td colspan="5" align="center">No records found.</td>
        </tr>			      </tbody>
    </table>
  </div>
</div>
<?php } ?>