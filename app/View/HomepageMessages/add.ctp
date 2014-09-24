<div class="homepageMessages form">
<?php echo $this->Form->create('HomepageMessage');?>
	<fieldset>
		<legend><?php echo __('Add Homepage Message'); ?></legend>
	<?php
		echo $this->Form->input('type');
		echo $this->Form->input('msg');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Homepage Messages'), array('action' => 'index'));?></li>
	</ul>
</div>
