<div class="homepageDynamicContents view">
<h2><?php  echo __('Homepage Dynamic Content');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($homepageDynamicContent['HomepageDynamicContent']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($homepageDynamicContent['HomepageDynamicContent']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Img'); ?></dt>
		<dd>
			<?php echo h($homepageDynamicContent['HomepageDynamicContent']['img']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Desc'); ?></dt>
		<dd>
			<?php echo h($homepageDynamicContent['HomepageDynamicContent']['desc']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Align'); ?></dt>
		<dd>
			<?php echo h($homepageDynamicContent['HomepageDynamicContent']['align']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image Link'); ?></dt>
		<dd>
			<?php echo h($homepageDynamicContent['HomepageDynamicContent']['image_link']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($homepageDynamicContent['HomepageDynamicContent']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sort'); ?></dt>
		<dd>
			<?php echo h($homepageDynamicContent['HomepageDynamicContent']['sort']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($homepageDynamicContent['HomepageDynamicContent']['type']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Homepage Dynamic Content'), array('action' => 'edit', $homepageDynamicContent['HomepageDynamicContent']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Homepage Dynamic Content'), array('action' => 'delete', $homepageDynamicContent['HomepageDynamicContent']['id']), null, __('Are you sure you want to delete # %s?', $homepageDynamicContent['HomepageDynamicContent']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Homepage Dynamic Contents'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Homepage Dynamic Content'), array('action' => 'add')); ?> </li>
	</ul>
</div>
