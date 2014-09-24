<div class="homepageMessages form">
<?php echo $this->Form->create('HomepageMessage');?>
	<fieldset>
		<legend><?php echo __('Edit Homepage Message'); ?></legend>
	<?php
		echo $this->Form->input('type');
		echo $this->Form->input('msg');
		echo $this->Form->input('img');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('HomepageMessage.img')), null, __('Are you sure you want to delete # %s?', $this->Form->value('HomepageMessage.img'))); ?></li>
		<li><?php echo $this->Html->link(__('List Homepage Messages'), array('action' => 'index'));?></li>
	</ul>
</div>
