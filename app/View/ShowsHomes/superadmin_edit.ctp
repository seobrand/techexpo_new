<div class="showsHomes form">
<?php echo $this->Form->create('ShowsHome');?>
	<fieldset>
		<legend><?php echo __('Superadmin Edit Shows Home'); ?></legend>
	<?php
		echo $this->Form->input('show_id');
		echo $this->Form->input('display_name');
		echo $this->Form->input('special_message');
		echo $this->Form->input('image_file');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ShowsHome.show_id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ShowsHome.show_id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Shows Homes'), array('action' => 'index'));?></li>
	</ul>
</div>
