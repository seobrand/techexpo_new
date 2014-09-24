<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'UploadPix')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Upload event pictures</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('Pix',array('action'=>'edit','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
           
            <tr>
              <td width="25%" align="right" valign="middle">Title of the picture: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('pic_title',array('class'=>'inputbox1','type'=>'text'));?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Select Event: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('event_id',array('label'=>'','options'=>$event_list,'type'=>'select','error'=>false));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle"> Image to upload: </td>
              <td align="left" valign="top">
              <?php echo $this->element('photo_gallery_upload',array('id'=>'PixPicFilename','name'=>"data[Pix][pic_filename1]",'radiofieldname'=>"upload_photo"));?>
              <?php echo $this->Form->input('pic_filename',array('type'=>'file')); ?>
			  <?php if($this->data['Pix']['pic_filename']!=''){?>
			  <?php echo $this->Form->checkbox('keep_same',array('value'=>'y','checked'=>'checked')); ?> Keep the same image
			  <?php }else{?>
			  <?php echo $this->Form->checkbox('keep_same',array('value'=>'y')); ?> Keep the same image
			  <?php } ?>
			  </td>
            </tr>
            
               <tr>
              <td align="right" valign="middle"><b>Current file name:</b> <?php echo $this->data['Pix']['pic_filename']; ?>&nbsp;&nbsp;-&nbsp;&nbsp;
		<b>Preview:</b> </td>
              <td align="left" valign="top">              
		<?php  echo $this->Html->image('event-pics/resized_'.$this->data['Pix']['pic_filename'],array('align'=>'absmiddle')); ?>
             </td>
            </tr>

            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->submit('Update Picture',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                echo "&nbsp;&nbsp;";
                echo $this->Form->hidden('pic_id');
                echo $this->Form->hidden('curr_pic_filename',array('value'=>$this->data['Pix']['pic_filename']));
                echo $this->Form->end();
                echo $this->Form->postLink('Delete Picture',array('action'=>'delete',$this->data['Pix']['pic_id']),array('confirm'=>'Are you sure want to delete?','class'=>'a-state-default'));                
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

