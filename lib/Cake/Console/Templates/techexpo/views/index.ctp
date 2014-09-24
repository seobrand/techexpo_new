<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>


<?php  
 echo "<?php echo \$this->element('admin-breadcrumbs',array('pageName'=>'adminuser'));";
 echo "\$this->set('title_for_layout', 'User Profile List');";
?>
<?php //$this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<div class="title-pad">
  <div class="title">
    <h5><?php echo "<?php echo __('{$pluralHumanName}');?>";?></h5>
    <div class="search">
      <div class="button"> <?php echo "<?php echo \$this->Form->create('Location', array('action'=>'index')); echo \$this->Form->input('search',array('label'=>'','value'=>{$search},'class'=>'inputbox','div'=>false));?>" ?>
        <?php 
	   echo "<?php echo \$this->Form->select('act',array('role'=>'Groups','name'=>'User Name'),array('empty'=>'Filter By','class'=>'selectbox1'));"; ?>
	   ?>
        <?php 
	   echo "<?php echo \$this->Form->select('active',array('no'=>'No','yes'=>'Yes'),array('empty'=>'Active','class'=>'selectbox1'));"; ?>
	   ?>
        <?php echo "<?php echo \$this->Form->submit('Filter',array('class'=>'cursorclass ui-state-default ui-corner-all','id'=>'button41','div'=>false));?> <?php echo \$this->Form->end();?>"; ?> </div>
      <div class="input">
        <div class="button" style="margin-top:1px;"><?php echo "<?php echo \$this->Html->link('Add New Location',array('controller'=>'locations','action'=>'add'),array('escape'=>false)); ?> <?php echo \$this->Form->end();?>"; ?> </div>
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
            <?php  foreach ($fields as $field):?>
          <th align="center"><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
      <?php endforeach;?>
          <th width="8%" align="center"><?php echo __('Actions');?></th>
        </tr>
      </thead>
      <tbody>      
         
          
          <?php
	echo "<?php
	foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t<tr>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t<td align='center'>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
			}
		}

		echo "\t\t<td class=\"actions\">\n";
                echo '<table width="100%" border="0"><tr>';
		echo "\t\t\t<td width='33%' style='padding:0px;border:none;' align='center'><?php echo \$this->Html->link(\$this->Html->image('zoom.png',array('alt'=>'\$modelClass','width'=>16,'height'=>16,'title'=>'\$modelClass')), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape' => false)); ?>\n</td>";
	 	echo "\t\t\t<td width='33%' style='padding:0px;border:none;' align='center'><?php echo \$this->Html->link(\$this->Html->image('application_edit.png',array('alt'=>'\$modelClass','width'=>16,'height'=>16,'title'=>'\$modelClass')), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('escape' => false)); ?>\n</td>";
	 	echo "\t\t\t<td width='34%' style='padding:0px;border:none;' align='center'><?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), null, __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n</td>";
		echo "\t\t</tr></table></td>\n";
	echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
          
     
      </tbody>
    </table>
  </div>
</div>
<!-- display box / first end here -->
<div style="clear:both">
  <div class="title-pad"> 
        <?php echo "<?php
	echo \$this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>";?>
     <?php
		echo "<?php\n";
		echo "\t\techo \$this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));\n";
		echo "\t\techo \$this->Paginator->numbers(array('separator' => ''));\n";
		echo "\t\techo \$this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));\n";
		echo "\t?>\n";
	?>
        <?php //echo $this->element('admin-paging');?> </div>
</div>
<?php
	/*	}
		else  {*/ ?>
<!--<tr>
  <td colspan="8" align="center">No records found.</td>
</tr>-->
</tbody>
</table>
</div>
</div>
<?php // } ?>



