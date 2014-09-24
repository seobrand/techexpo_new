<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'viewpage'));?>
<div class="title-pad">
  <div class="title">
    <h5>View Page Details</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="15%" align="right" valign="middle">Page Title :</td>
        <td width="85%" align="left" valign="middle"><?php echo $data['Page']['title']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Alias :</td>
        <td align="left" valign="middle"><?php echo $data['Page']['alias']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Page Type :</td>
        <td align="left" valign="middle"><?php echo ucfirst($data['Page']['page_type']); ?></td>
      </tr>
	  <?php if($data['Page']['page_type']=='content') { ?>
      <tr>
        <td align="right" valign="top" width="14%">Content :</td>
        <td align="left" valign="middle" ><?php echo $data['Page']['content']; ?> </td>
      </tr>
      <tr>
        <td align="right" valign="middle">Meta title :</td>
        <td align="left" valign="middle"><?php echo $data['Page']['meta_title']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Meta description :</td>
        <td align="left" valign="middle"><?php echo $data['Page']['meta_description']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Meta keyword :</td>
        <td align="left" valign="middle"><?php echo $data['Page']['meta_keyword']; ?></td>
      </tr>
	  <?php }
	  else { ?>
      <tr>
        <td align="right" valign="middle" width="14%">Upload document :</td>
        <td align="left" valign="middle"><?php echo $this->Html->link($data['Page']['doc_name'],FULL_BASE_URL.Router::url('/', false).'documents/'.$data['Page']['doc_name'],array('target'=>'_blank')); ?></td>
      </tr>
	  <?php } ?>
      <tr>
        <td align="right" valign="middle">Active :</td>
        <td align="left" valign="middle"><?php echo ucfirst($data['Page']['active']); ?></td>
      </tr>
    </table>
  </div>
</div>
