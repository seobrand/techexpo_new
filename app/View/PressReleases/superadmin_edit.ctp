<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'updatepressrelease')); ?>
<script>
$(function() {
       $("#datepicker").datepicker({ dateFormat: "yy-mm-dd" });
});

</script>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Update Press Release</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('PressRelease',array('action'=>'edit','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
           
            <tr>
              <td width="25%" align="right" valign="middle">Title of the press: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('pr_title',array('class'=>'inputbox1','type'=>'text'));?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Press release date: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('pr_date',array('class'=>'inputbox1','type'=>'text','id'=>'datepicker'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle"> PDF to upload: </td>
              <td align="left" valign="top">
              <?php // echo $this->element('photo_gallery_upload',array('id'=>'PressReleasePrFile','name'=>"data[PressRelease][pr_file1]",'radiofieldname'=>"upload_photo"));?>
              <?php echo $this->Form->input('pr_file',array('type'=>'file')); ?>  Keep the same ? Don't upload new.</td>
            </tr>  
            
               <tr>
              <td align="right" valign="middle"><b>Current file :</b>  </td>
              <td align="left" valign="top">              
		<?php //  echo $this->Html->image('press/'.$this->data['PressRelease']['pr_file'],array('align'=>'absmiddle')); ?>
        <a target="_blank" href="<?php echo FULL_BASE_URL.router::url('/',false).'img/press/'.$this->data['PressRelease']['pr_file']; ?>" ><?php echo $this->data['PressRelease']['pr_file']; ?></a>
             </td>
            </tr>

            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->submit('Update Press',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                echo "&nbsp;&nbsp;";
                echo $this->Form->hidden('pr_id');
                echo $this->Form->hidden('curr_pic_filename',array('value'=>$this->data['PressRelease']['pr_file']));?>
                <a onclick="if (confirm('Are you sure want to delete?')) { document.deletepost.submit(); } event.returnValue = false; return false;" class="delete_button_a"><input type="submit" value="Delete Press" class="cursorclass ui-state-default ui-corner-all"></a>
               </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <?php echo $this->Form->end();?>
 </div>
<!-- end table --> 
</div>
<?php echo $this->Form->create('PressRelease',array('name'=>'deletepost','action'=>'delete',$this->data['PressRelease']['pr_id'])); ?>
<?php echo $this->Form->end();?>
