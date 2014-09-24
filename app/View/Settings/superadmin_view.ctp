<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'viewsetting'));?>
<?php echo $this->Form->create('Setting', array('action'=>'create','id'=>'form'));?>
<div class="title-pad">
  <div class="title">
    <h5>View Setting Details</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="13%" align="right" valign="middle">Name :</td>
        <td width="87%" align="left" valign="middle"><?php echo $data['Setting']['name']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Value :</td>
        <td align="left" valign="middle"><?php echo $data['Setting']['value']; ?></td>
      </tr>	
      <tr>
        <td align="right" valign="middle">Description :</td>
        <td align="left" valign="middle"><?php echo $data['Setting']['description']; ?></td>
      </tr>		   
    </table>
  </div>
</div>
<?php echo $this->Form->end();?> 