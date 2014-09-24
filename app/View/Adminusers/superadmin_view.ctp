<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'viewadminuser'));?>

 <?php   echo $this->Form->create('admin', array('action'=>'create','id'=>'form')); ?>

<div class="title-pad">
  <div class="title">
    <h5>View User Profile Details</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="15%" align="right" valign="middle">First Name :</td>
        <td width="85%" align="left" valign="middle"><?php echo $data['Adminuser']['first_name']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Last Name :</td>
        <td align="left" valign="middle"><?php echo $data['Adminuser']['last_name']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Preferred Name :</td>
        <td align="left" valign="middle"><?php echo $data['Adminuser']['username']; ?> </td>
      </tr>	  
      <tr>
        <td align="right" valign="middle">Email :</td>
        <td align="left" valign="middle"><?php echo $data['Adminuser']['email']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Group Name :</td>
        <td align="left" valign="middle"><?php echo $data['Role']['role_name']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Active :</td>
        <td align="left" valign="middle"><?php echo ucfirst($data['Adminuser']['active']); ?></td>
      </tr> 
    </table>
  </div>
</div>
<?php echo $this->Form->end();?> 