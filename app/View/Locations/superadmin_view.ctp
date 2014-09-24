<?php
 echo $this->element('admin-breadcrumbs',array('pageName'=>'viewlocation'));
?>
<div class="title-pad">
  <div class="title">
    <h5><?php  echo __('View Location Detail');?></h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="candidate_registration">
      <tr>
        <td width="20%" align="right" valign="top"><?php echo __('Site Name'); ?></td>
        <td width="80%" align="left" valign="top"><?php echo h($location['Location']['site_name']); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><?php echo __('Address'); ?></td>
        <td align="left" valign="top"><?php echo h($location['Location']['address']); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><?php echo __('City'); ?></td>
        <td align="left" valign="top"><?php echo h($location['Location']['city']); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">T<?php echo __('State'); ?></td>
        <td align="left" valign="top"><?php echo h($location['Location']['state_id']); ?></td>
      </tr>	  
      <tr>
        <td align="right" valign="top"><?php echo __('Zip'); ?></td>
        <td align="left" valign="top"><?php echo h($location['Location']['zip']); ?></td>
      </tr>	  
      <tr>
        <td align="right" valign="top"><?php echo __('Url'); ?></td>
        <td align="left" valign="top"><?php echo h($location['Location']['url']); ?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><?php echo __('Phone'); ?></td>
        <td align="left" valign="top"><?php echo h($location['Location']['phone']); ?></td>
      </tr>
      
    </table>
  </div>
</div>
<!--
<div class="locations view">
<h2><?php  //echo __('Location');?></h2>
	<dl>
		<dt><?php //echo __('Id'); ?></dt>
		<dd>
			<?php //echo h($location['Location']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php //echo __('Site Name'); ?></dt>
		<dd>
			<?php //echo h($location['Location']['site_name']); ?>
			&nbsp;
		</dd>
		<dt><?php //echo __('Address'); ?></dt>
		<dd>
			<?php //echo h($location['Location']['address']); ?>
			&nbsp;
		</dd>
		<dt><?php //echo __('City'); ?></dt>
		<dd>
			<?php //echo h($location['Location']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php //echo __('State'); ?></dt>
		<dd>
			<?php //echo h($location['Location']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php //echo __('Zip'); ?></dt>
		<dd>
			<?php //echo h($location['Location']['zip']); ?>
			&nbsp;
		</dd>
		<dt><?php //echo __('Url'); ?></dt>
		<dd>
			<?php //echo h($location['Location']['url']); ?>
			&nbsp;
		</dd>
		<dt><?php //echo __('Phone'); ?></dt>
		<dd>
			<?php //echo h($location['Location']['phone']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>
		<li><?php //echo $this->Html->link(__('Edit Location'), array('action' => 'edit', $location['Location']['id'])); ?> </li>
		<li><?php //echo $this->Form->postLink(__('Delete Location'), array('action' => 'delete', $location['Location']['id']), null, __('Are you sure you want to delete # %s?', $location['Location']['id'])); ?> </li>
		<li><?php //echo $this->Html->link(__('List Locations'), array('action' => 'index')); ?> </li>
		<li><?php //echo $this->Html->link(__('New Location'), array('action' => 'add')); ?> </li>
	</ul>
</div>
-->