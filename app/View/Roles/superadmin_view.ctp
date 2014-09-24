<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'viewrole'));?>
<?php echo $this->Form->create('Role', array('action'=>'create','id'=>'form'));?>
<div class="title-pad">
  <div class="title">
    <h5>View User Group Details</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="15%" align="right" valign="middle">Group Name :</td>
        <td width="85%" align="left" valign="middle"><?php echo $data['Role']['role_name']; ?></td>
      </tr>
    </table>
  </div>
</div>
<?php echo $this->Form->end();?> 