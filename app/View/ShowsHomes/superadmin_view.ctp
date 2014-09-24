<div class="showsHomes view">
<h2><?php  echo __('Shows Home');?></h2>
	<dl>
		<dt><?php echo __('Show Id'); ?></dt>
		<dd>
			<?php echo h($showsHome['ShowsHome']['show_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Name'); ?></dt>
		<dd>
			<?php echo h($showsHome['ShowsHome']['display_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Special Message'); ?></dt>
		<dd>
			<?php echo h($showsHome['ShowsHome']['special_message']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image File'); ?></dt>
		<dd>
			<?php echo h($showsHome['ShowsHome']['image_file']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Shows Home'), array('action' => 'edit', $showsHome['ShowsHome']['show_id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Shows Home'), array('action' => 'delete', $showsHome['ShowsHome']['show_id']), null, __('Are you sure you want to delete # %s?', $showsHome['ShowsHome']['show_id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Shows Homes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shows Home'), array('action' => 'add')); ?> </li>
	</ul>
</div>
