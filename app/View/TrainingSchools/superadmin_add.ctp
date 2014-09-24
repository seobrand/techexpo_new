<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addtrainingschool')); ?>
<div class="display_row">
  <div class="table">
  <?php  echo $this->Form->create('TrainingSchool',array('enctype' => 'multipart/form-data','type' => 'post')); ?> 
  		<table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
            <tr>
              <td width="25%" valign="middle" align="right"><b>Training School Name</b></td>
              <td valign="top" width="74%"  align="left"><?php echo $this->Form->input('ts_name',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">Contact Name</td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_contact_name',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">Address</td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_address',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">City</td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_city',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">State</td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_state',array('label'=>false,'type'=>'select','options'=>$states,'error'=>false,'class'=>'inputbox1'));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">ZIP</td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_zip',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">Phone</td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_phone',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">Fax</td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_fax',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">E-mail</td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_email',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right"> <b>Web site URL</b></td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_web',array('label'=>'','class'=>'inputbox1','error'=>false));?>
                <br>
                eg: http://iashel.com/clk/zoufanpianlaozei</td>
            </tr>
            <tr>
              <td valign="middle" align="right"><b>Logo</b></td>
              <td valign="top" align="left">
              <?php echo $this->element('photo_gallery_upload',array('id'=>'TrainingSchoolTsLogoPath','name'=>"data[TrainingSchool][ts_logo_path1]",'radiofieldname'=>"upload_photo"));?>
              <?php echo $this->Form->input('TrainingSchool.ts_logo_path',array('label'=>'','class'=>'inputbox1','error'=>false,'type'=>'file'));?></td>
            </tr>            
            <tr>
              <td valign="middle" align="right"><b> Profile</b></td>
              <td valign="top" align="left"><?php echo $this->Form->input('ts_profile',array('label'=>'','class'=>'inputbox1','error'=>false,'type'=>'textarea'));?></td>
            </tr>
            <tr>
              <td valign="top" align="left"></td>
              <td valign="top" align="left"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
            </tr>
          </tbody>
        </table>
			<?php echo $this->Form->end();?>
  </div>
</div>



