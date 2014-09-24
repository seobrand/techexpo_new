<div class="pixes view">
<h2><?php  echo __('Pix');?></h2>
	<dl>
		<dt><?php echo __('Pic Id'); ?></dt>
		<dd>
			<?php echo h($pix['Pix']['pic_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pic Title'); ?></dt>
		<dd>
			<?php echo h($pix['Pix']['pic_title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pic Filename'); ?></dt>
		<dd>
			<?php echo h($pix['Pix']['pic_filename']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pix'), array('action' => 'edit', $pix['Pix']['pic_id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Pix'), array('action' => 'delete', $pix['Pix']['pic_id']), null, __('Are you sure you want to delete # %s?', $pix['Pix']['pic_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pixes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pix'), array('action' => 'add')); ?> </li>
	</ul>
</div>
