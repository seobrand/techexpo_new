<div class="homepageMessages index">
	<h2><?php echo __('Homepage Messages');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('type');?></th>
			<th><?php echo $this->Paginator->sort('msg');?></th>
			<th><?php echo $this->Paginator->sort('img');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($homepageMessages as $homepageMessage): ?>
	<tr>
		<td><?php echo h($homepageMessage['HomepageMessage']['type']); ?>&nbsp;</td>
		<td><?php echo h($homepageMessage['HomepageMessage']['msg']); ?>&nbsp;</td>
		<td><?php echo h($homepageMessage['HomepageMessage']['img']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $homepageMessage['HomepageMessage']['img'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $homepageMessage['HomepageMessage']['img'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $homepageMessage['HomepageMessage']['img']), null, __('Are you sure you want to delete # %s?', $homepageMessage['HomepageMessage']['img'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Homepage Message'), array('action' => 'add')); ?></li>
	</ul>
</div>
