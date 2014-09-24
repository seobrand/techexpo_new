<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'editlocation')); ?>
<div class="display_row">
  <div class="table">
  <?php  echo  $this->Form->create('Location', array('type' => 'post','action' => 'edit')); ?> 
  <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
        <tr>
          <td align="right" valign="middle" width="35%"><span class="required">*</span>Site Name:</td>
          <td align="left" valign="top" width="64%"><?php echo $this->Form->input('site_name',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Address:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_address',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">City:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('location_city',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">State:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('location_state',array('label'=>'','options'=>$states,'type'=>'select','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Zip:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_zip',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Url:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_url',array('label'=>'','class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Phone:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_phone',array('label'=>'','class'=>'inputbox1'));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required">*</span>Electricity Cost:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_electricity_cost',array('type'=>'text','label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"><span class="required">*</span>Internet Connectivity Cost:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('internet_connectivity_cost',array('type'=>'text','label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Show Travel Directions:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('site_travel_direction',array('type'=>'textarea','label'=>'','class'=>'inputbox1'));?></td>
        </tr>
        <tr>
         <td align="right" valign="middle">&nbsp;</td>
          <td>
		  <?php echo $this->Form->input('id', array('type' => 'hidden'));?>
		  <?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
	   	  <?php echo $this->Form->end(); // Form end ?>
				
		  <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $id),
                array('confirm' => 'Are you sure to delete?','class'=>'a-state-default'));
            ?>
		  </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>









