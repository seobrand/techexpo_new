<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'editadminclient'));
$this->set('title_for_layout', 'Edit Client'); ?>
<?php echo $this->Form->create('Adminclient', array('action'=>'update','id'=>'form','enctype'=>'multipart/form-data'));?>

<div class="title-pad">
  <div class="title">
    <h5>Edit Client</h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table  border="0" cellspacing="0" cellpadding="0"  width="100%">
      <tr>
        <td width="20%" align="right" valign="top"><span class="required">*</span>Title</td>
        <td width="80%" align="left" valign="top"><?php echo $this->Form->input('title',array('label'=>'','empty'=>'Select','type'=>'select','options'=>$optionTitles,'class'=>'select_03','div'=>false,'default'=>$data['Adminclient']['title'],'style'=>'width:263px;height:23px;'));?></td>
      </tr>
      <tr><?php echo $this->Form->input('id',array('type'=>'hidden','label'=>'','class'=>'inputbox1','div'=>false,'value'=>$data['Adminclient']['id']));?>
        <td align="right" valign="top"><span class="required">*</span>First Name</td>
        <td align="left" valign="top"><?php echo $this->Form->input('first_name',array('label'=>'','class'=>'inputbox1','div'=>false,'value'=>$data['Adminclient']['first_name'],'style'=>'width:255px;height:15px;'));?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Surname</td>
        <td align="left" valign="top"><?php echo $this->Form->input('last_name',array('label'=>'','class'=>'inputbox1','div'=>false,'value'=>$data['Adminclient']['last_name'],'style'=>'width:255px;height:15px;'));?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Title or Department</td>
        <td align="left" valign="top"><?php echo $this->Form->input('department',array('label'=>'','class'=>'inputbox1','div'=>false,'value'=>$data['Adminclient']['department'],'style'=>'width:255px;height:15px;'));?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Company Name</td>
        <td align="left" valign="top"><?php echo $this->Form->input('company_name',array('label'=>'','class'=>'inputbox1','div'=>false,'value'=>$data['Adminclient']['company_name'],'style'=>'width:255px;height:15px;'));?></td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Telephone Number
          <input name="data[Adminclient][primary_contact]" id="AdminclientPrimaryContact_" value="" type="hidden"></td>
        <td align="left" valign="top"><?php echo $this->Form->input('contact1',array('label'=>'','class'=>'inputbox1','div'=>false,'value'=>$data['Adminclient']['contact1'],'style'=>'width:255px;height:15px;'));?>
          <?php if($data['Adminclient']['primary_contact'] == 'contact1') { ?>
          <input name="data[Adminclient][primary_contact]" id="AdminclientPrimaryContactContact1" value="contact1" type="radio" checked="checked">
          <?php } else {?>
          <input name="data[Adminclient][primary_contact]" id="AdminclientPrimaryContactContact1" value="contact1" type="radio">
          <?php }?>
          &nbsp;Primary </td>
      </tr>
      <tr>
        <td align="right" valign="top">&nbsp;</td>
        <td align="left" valign="top"><?php echo $this->Form->input('contact2',array('label'=>'','class'=>'inputbox1','div'=>false,'value'=>$data['Adminclient']['contact2'],'style'=>'width:255px;height:15px;'));?>
          <?php if($data['Adminclient']['primary_contact'] == 'contact2') { ?>
          <input name="data[Adminclient][primary_contact]" id="AdminclientPrimaryContactContact2" value="contact2" type="radio" checked="checked">
          <?php } else {?>
          <input name="data[Adminclient][primary_contact]" id="AdminclientPrimaryContactContact2" value="contact2" type="radio">
          <?php }?>
          &nbsp;Primary</td>
      </tr>
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Postcode</td>
        <td align="left" valign="top"><?php echo $this->Form->input('postcode',array('label'=>'','class'=>'inputbox1','div'=>false,'value'=>$data['Adminclient']['postcode'],'style'=>'width:255px;height:15px;text-transform:uppercase'));?></td>
      </tr>	  
      <tr>
        <td align="right" valign="top"><span class="required">*</span>Email</td>
        <td align="left" valign="top"><?php echo $this->Form->input('email',array('label'=>'','class'=>'inputbox1','div'=>false,'value'=>$data['Adminclient']['email'],'style'=>'width:255px;height:15px;'));?></td>
      </tr>
  <tr>
    <td align="right" valign="top"><span class="required">*</span>Password</td>
    <td align="left" valign="top"><?php echo $this->Form->input('password1',array('label'=>'','type'=>'password','class'=>'inputbox1','div'=>false,'style'=>'width:255px;height:15px;','value'=>$data['Adminclient']['orig_password']));?></td>
  </tr>
  <tr>
    <td align="right" valign="top"><span class="required">*</span>Confirm Password</td>
    <td align="left" valign="top"><?php echo $this->Form->input('password2',array('label'=>'','type'=>'password','class'=>'inputbox1','div'=>false,'style'=>'width:255px;height:15px;','value'=>$data['Adminclient']['orig_password']));?></td>
  </tr>	  
      <tr>
        <td align="right" valign="top">Enquiry/Comments</td>
        <td align="left" valign="top"><?php echo $this->Form->input('comments',array('label'=>'','type'=>'textarea','class'=>'textarea_01','div'=>false,'value'=>$data['Adminclient']['comments']));?></td>
      </tr>
      <tr>
        <td align="right" valign="top">Areas of Interest</td>
        <td align="left" valign="top" class="nopadding"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="noborder">
            <?php //pr($optionAreaofinterest);?>
            <?php 
		if(is_array($optionAreaofinterest) && count($optionAreaofinterest)) {
			foreach($optionAreaofinterest as $key=>$val) {
			//pr($val);
				?>
            <tr>
              <td align="left" valign="top">
              <?php if($this->request->is('post'))
              {
              $area_of_interests_array = $data['Adminclient']['area_of_interests'];
              }
              else
              {
              $area_of_interests_array = explode('|-|',$data['Adminclient']['area_of_interests']);
              }
              ?>
              
              
              <?php $areaOfInterestId = 'interestId'.$val['Areaofinterest']['id'];?>
                <input type="checkbox" name="data[Adminclient][area_of_interests][]" value="<?php echo $val['Areaofinterest']['area_of_interests']; ?>"  onclick="if(this.checked) { hideShow('','<?php echo $areaOfInterestId; ?>'); } else { hideShow('<?php echo $areaOfInterestId; ?>',''); }"
			
			
            
            <?php if(in_array($val['Areaofinterest']['area_of_interests'],$area_of_interests_array)) { 
			   		echo " Checked ='Checked' ";
					} ?> 
			 />
             
             
                &nbsp;<?php echo $val['Areaofinterest']['area_of_interests']; ?></td>
            </tr>
            <?php if(is_array($val['children']) && count($val['children'])) {
		 ?>
            <tr>
              <td align="left" valign="top" style="padding-left:18px;" class="nopadding"><div <?php if(isset($data['Adminclient']['area_of_interests']) && in_array($val['Areaofinterest']['area_of_interests'],$area_of_interests_array)) { 
			   		echo ' style="display:block;" ';
					} else { echo 'style="display:none;"'; } ?> id="<?php echo $areaOfInterestId; ?>">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php 
				foreach($val['children'] as $key1=>$val1) { ?>
                    <tr>
                      <td align="left" valign="top"><input type="checkbox" name="data[Adminclient][area_of_interests][]" value="<?php echo $val['Areaofinterest']['area_of_interests'].'-'.$val1['Areaofinterest']['area_of_interests']; ?>"
				  <?php if(in_array($val['Areaofinterest']['area_of_interests'].'-'.$val1['Areaofinterest']['area_of_interests'],$area_of_interests_array)) { 
			   		echo " Checked ='Checked' ";
					} ?> 
				   />
                        &nbsp;<?php echo $val1['Areaofinterest']['area_of_interests']; ?></td>
                    </tr>
                    <?php } ?>
                  </table>
                </div></td>
            </tr>
            <?php			
		  } ?>
            <?php
			}
		}
		?>
          </table></td>
      </tr>
              <tr>
                <td align="right" valign="middle">How do you prefer to communicate</td>
                 <td align="left" valign="middle"> <?php 
			$checked = ($data['Adminclient']['comm_telephone']=='yes') ? true :false;
			echo $this->Form->input('comm_telephone',array('type'=>'checkbox','label'=>false,'div'=>false,'value'=>'yes','checked'=>$checked)); ?>
                 Telephone&nbsp;
                  <?php 
			$checked = ($data['Adminclient']['comm_email']=='yes') ? true :false;
			echo $this->Form->input('comm_email',array('type'=>'checkbox','label'=>false,'div'=>false,'value'=>'yes','checked'=>$checked)); ?>
                  Email</td>
              </tr>	  
      <tr>
        <td align="right" valign="middle">Active</td>
        <td align="left" valign="middle"><?php  $options=array('yes'=>'Yes','no'=>'No');
 $attributes=array('label'=>false,'legend'=>false,'default'=>$data['Adminclient']['active'],'div'=>false,'id'=>'active');
 echo $this->Form->radio('active',$options,$attributes); ?></td>
      </tr>
      <tr>
        <td align="right" valign="middle">&nbsp;</td>
        <td align="left" valign="middle"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
      </tr>
    </table>
  </div>
</div>
<input type="hidden" name="SUBMIT" value="SUBMIT" />
<?php echo $this->Form->end();?>