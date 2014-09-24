<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'EditExhibitor')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Add Exhibitor</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('Exhibitor',array('action'=>'edit','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
           
<tr>
<td width="25%" align="right" valign="middle">Title: </td>
<td width="74%"  align="left" valign="top"><?php echo $this->Form->input('Exhibitor.title',array('class'=>'inputbox1','type'=>'text'));?></td>
</tr>

<tr>
<td width="25%" align="right" valign="middle">Description: </td>
<td width="74%"  align="left" valign="top"><?php echo $this->Form->input('Exhibitor.description',array('class'=>'inputbox12','type'=>'textarea','cols'=>100,'rows'=>30));?>
</td>
</tr>
            
              
            
           
               <tr>
              <td align="right" valign="middle"> Image to upload: </td>
              <td align="left" valign="top">
              <?php echo $this->element('photo_gallery_upload',array('id'=>'PixPicFilename','name'=>"data[Exhibitor][image1]",'radiofieldname'=>"upload_photo"));?>
              <?php echo $this->Form->input('Exhibitor.image',array('type'=>'file')); ?>
			  <?php if($this->data['Exhibitor']['image']!=''){?>
			  <?php echo $this->Form->checkbox('keep_same',array('value'=>'y','checked'=>'checked')); ?> Keep the same image
			  <?php }else{?>
			  <?php echo $this->Form->checkbox('keep_same',array('value'=>'y')); ?> Keep the same image
			  <?php } ?>
			  </td>
            </tr>
            
               <tr>
              <td align="right" valign="middle"><b>Current file name:</b> <?php echo $this->data['Exhibitor']['image']; ?>&nbsp;&nbsp;-&nbsp;&nbsp;
		<b>Preview:</b> </td>
              <td align="left" valign="top">              
		<img src="<?php echo FULL_BASE_URL.router::url('/',false).'exhibitors/resized_'.$this->data['Exhibitor']['image']; ?>"  />
             </td>
            </tr>
        
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
            
               <?php
                echo $this->Form->submit('Update exhibitor',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                echo "&nbsp;&nbsp;";
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('curr_pic_filename',array('value'=>$this->data['Exhibitor']['image']));
                echo $this->Form->end();
                echo $this->Form->postLink('Delete Exhibitor',array('action'=>'delete',$this->data['Exhibitor']['id']),array('confirm'=>'Are you sure want to delete?','class'=>'a-state-default'));                
              ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
 <?php echo $this->Form->end(); ?>

 </div>
        <!-- end table --> 
      </div>

