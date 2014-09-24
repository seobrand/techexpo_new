<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'viewAreaofinterest'));?><?php echo $this->Form->create('Areaofinterest', array('action'=>'create','id'=>'form'));?>

<div class="title-pad">
  <div class="title">
    <h5>View Areas of Interest / Skill Sets Details</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0" id="login" align="center">
      <tr>
        <td width="15%" align="right" valign="middle">AOI / SS Name :</td>
        <td width="85%" align="left" valign="middle"><?php 		  
		  			if($data['Areaofinterest']['parent_id'] == 0) {
							echo $data['Areaofinterest']['area_of_interests'];
					} else {
						for($i=0;$i<count($parent);$i++) {
								if($data['Areaofinterest']['parent_id'] == $parent[$i]['Areaofinterest']['id']) {
									echo $parent[$i]['Areaofinterest']['area_of_interests'];							
								}
							}
					} 
		  ?>
        </td>
      </tr>
      <tr>
        <td width="15%" align="right" valign="middle">Sub Area :</td>
        <td width="85%" align="left" valign="middle"><?php 		  
		  			if($data['Areaofinterest']['parent_id'] == 0) {
							echo '-';
					} else {
						echo $data['Areaofinterest']['area_of_interests'];
					} 
		  ?>
          <?php // echo $data['Areaofinterest']['area_of_interests']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Order :</td>
        <td  align="left" valign="middle"><?php echo $data['Areaofinterest']['ordered']; ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Active :</td>
        <td  align="left" valign="middle"><?php echo ucfirst($data['Areaofinterest']['active']); ?></td>
      </tr>
    </table>
  </div>
</div>
<?php echo $this->Form->end();?> 