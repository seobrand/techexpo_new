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
<?php  echo "<?php echo \$this->element('admin-breadcrumbs',array('pageName'=>'addcandidate'));?>"; ?>
 
<?php echo "<?php echo \$this->Form->create('{$modelClass}');?>\n";?>
<div class="title-pad">
  <div class="title">
    <h5><?php echo __('Edit Location'); ?></h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
<table  border="0" cellspacing="0" cellpadding="0"  width="100%">
  <tr>
    <td width="15%" align="right" valign="top"><span class="required">*</span><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></td>
    <td width="75%" align="left" valign="top">
        
        <?php
		echo "\t<?php\n";
		foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				echo "\t\techo \$this->Form->input('{$field}');\n";
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\techo \$this->Form->input('{$assocName}');\n";
			}
		}
		echo "\t?>\n";
?>
        
    </td>
  </tr>  
  <tr>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="left" valign="middle"><?php
	echo "<?php echo \$this->Form->end(__('Submit'));?>\n";
?></td>
      </tr>
</table>
  </div>
</div>
