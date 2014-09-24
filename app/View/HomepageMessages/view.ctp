<div class="homepageMessages view">
<h2><?php  echo __('Homepage Message');?></h2>
	<dl>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($homepageMessage['HomepageMessage']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Msg'); ?></dt>
		<dd>
			<?php echo h($homepageMessage['HomepageMessage']['msg']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Img'); ?></dt>
		<dd>
			<?php echo h($homepageMessage['HomepageMessage']['img']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Homepage Message'), array('action' => 'edit', $homepageMessage['HomepageMessage']['img'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Homepage Message'), array('action' => 'delete', $homepageMessage['HomepageMessage']['img']), null, __('Are you sure you want to delete # %s?', $homepageMessage['HomepageMessage']['img'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Homepage Messages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Homepage Message'), array('action' => 'add')); ?> </li>
	</ul>
</div>
