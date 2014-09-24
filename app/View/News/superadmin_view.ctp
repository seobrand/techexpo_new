<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'viewnews'));?>
<div class="title-pad">
  <div class="title">
    <h5>View News Detail</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="15%" align="right" valign="middle">News Title :</td>
        <td width="85%" align="left" valign="middle"><?php echo $data['News']['title']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="top" width="14%">Content :</td>
        <td align="left" valign="middle" ><?php echo $data['News']['description']; ?> </td>
      </tr>
      <tr>
        <td align="right" valign="middle">Publish :</td>
        <td align="left" valign="middle"><?php echo ucfirst($data['News']['publish']); ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Expire :</td>
        <td align="left" valign="middle"><?php echo ucfirst($data['News']['expire']); ?></td>
      </tr>	  	  
      <tr>
        <td align="right" valign="middle">Active :</td>
        <td align="left" valign="middle"><?php echo ucfirst($data['News']['active']); ?></td>
      </tr>
    </table>
  </div>
</div>