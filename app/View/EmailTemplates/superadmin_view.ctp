<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'viewemailtemplate'));?>
<?php echo $this->Form->create('Emailtemplate', array('action'=>'create','id'=>'form'));?>
<div class="title-pad">
  <div class="title">
    <h5>View Email Template Details</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="15%" align="right" valign="middle">Title :</td>
        <td width="85%" align="left" valign="middle"><?php echo $data['EmailTemplate']['title']; ?></td>
      </tr>
<?php /*?>	   <tr>
        <td align="right" valign="middle">To :</td>
        <td  align="left" valign="middle"><?php echo $data['EmailTemplate']['to']; ?></td>
      </tr>
	   <tr>
        <td align="right" valign="middle">From :</td>
        <td  align="left" valign="middle"><?php echo $data['EmailTemplate']['from']; ?></td>
      </tr><?php */?>
	  
	   <tr>
        <td align="right" valign="middle">Subject :</td>
        <td  align="left" valign="middle"><?php echo $data['EmailTemplate']['subject']; ?></td>
      </tr>	  	  
	  <tr>
        <td align="right" valign="top">Message :</td>
        <td  align="left" valign="middle"><?php 
		$a = str_replace('<p>','<div>',$data['EmailTemplate']['message']);
		$a = str_replace('</p>','</div><br />',$a);
		echo ucfirst($a); ?></td>
      </tr>
    </table>
  </div>
</div>
<?php echo $this->Form->end();?>