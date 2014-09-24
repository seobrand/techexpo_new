<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'TestimonialEdit')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Update Testimonial</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('Testimonial',array('action'=>'edit','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
           
            <tr>
              <td width="25%" align="right" valign="middle">Testimonial Title: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('name',array('class'=>'inputbox1','type'=>'text'));?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Sort Order: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('sort',array('class'=>'inputbox1','type'=>'text'));?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Testimonial By: </td>
              <td width="74%"  align="left" valign="top">
              <?php echo $this->Form->input('testimonial_by',array('label'=>'','options'=>array('j'=>'Job Seekers','e'=>'Employers'),'empty'=>'Select','type'=>'select','error'=>false));?>
              </td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Text: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('text',array('class'=>'inputbox1','type'=>'textarea'));?></td>
            </tr>            
            <tr>
              <td align="right" valign="middle"> Logo / Profile Image: </td>
              <td align="left" valign="top">
              <?php echo $this->element('photo_gallery_upload',array('id'=>'TestimonialLogoFile','name'=>"data[Testimonial][logo_file1]",'radiofieldname'=>"upload_photo"));?>
              <?php echo $this->Form->input('logo_file',array('type'=>'file')); ?>  Want to Keep the same ? Don't upload new one.</td>
            </tr>  
            
               <tr>
              <td align="right" valign="middle"><b>Current file name:</b> &nbsp;&nbsp;-&nbsp;&nbsp;<br /> <?php echo $this->data['Testimonial']['logo_file']; ?>
		<b>Preview:</b> &nbsp;&nbsp;-&nbsp;&nbsp; </td>
              <td align="left" valign="top">             
		<?php  echo $this->Html->image('testimonial/'.$this->data['Testimonial']['logo_file'],array('align'=>'absmiddle')); ?>
             </td>
            </tr>

            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->submit('Update Testimonial',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                echo "&nbsp;&nbsp;";
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('curr_pic_filename',array('value'=>$this->data['Testimonial']['logo_file']));
                echo $this->Form->end();
                echo $this->Form->postLink('Delete Testimonial',array('action'=>'delete',$this->data['Testimonial']['id']),array('confirm'=>'Are you sure want to delete?','class'=>'a-state-default'));                
              ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
 </div>
        <!-- end table --> 
      </div>

