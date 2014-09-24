<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
        <div class="message message-error" id="message-error" style="display: none"></div>
          <!-- box / title -->
          <div class="title-pad">
          <div class="title">
          <h5 style="width:97%;">
           <div style="float:left;">Edit Photo</div>
           <div style="float:right;font-weight:bold;"></div>
          </h5>        
          <div class="search">
          <div class="input"> </div>
         <div class="button"> </div>
     </div>
   </div>
 </div>
	<?php echo $this->Form->create('PhotoGallery',array('action'=>'edit','type'=>'file','onsubmit'=>'return validation()','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false),'target'=>'_top')); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>           
            <tr>
              <td width="25%" align="right" valign="middle">Category of Photo: </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('photo_category_id',array('class'=>'','type'=>'select','options'=>$photo_cat_option));?></td>
            </tr>            
            <tr>
              <td align="right" valign="middle"> Image to upload: </td>
              <td align="left" valign="top"><?php echo $this->Form->input('image',array('type'=>'file')); ?> </td>
            </tr> 
            <tr>
              <td align="right" valign="middle"> Image Preview: </td>
              <td align="left" valign="top"><img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'img/photo_gallery/'.$this->request->data['PhotoGallery']['image'];?>&maxw=140&maxh=160"></td>
            </tr>  
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php echo $this->Form->input('Update Photo',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','style'=>'float: left; width: 139px;')); ?>&nbsp;
              <a onclick="if (confirm('Are you sure want to delete?')) { document.deletepost.submit(); } event.returnValue = false; return false;" class="delete_button_a"><input type="submit" value="Delete Photo" style="width: 139px;" class="cursorclass ui-state-default ui-corner-all"></a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> 
    <?php echo $this->Form->input('id',array('type'=>'hidden')); ?>
    <?php echo $this->Form->end();?>   
 </div>
<?php echo $this->Form->create('PhotoGallery',array('name'=>'deletepost','action'=>'delete',$this->request->data['PhotoGallery']['id'],'target'=>'_top')); ?>
<?php echo $this->Form->end();?>
<!-- end table --> 
</div>
<script type="text/javascript">
<!--
function validation(){	
	var fileName = document.getElementById('PhotoGalleryImage').value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(fileName==''){
		document.getElementById('message-error').style.display = 'block';
		error = '<div class="image"> <img title="Error" alt="Error" src="<?php echo $this->webroot;?>img/error.png"></div><div class="text"><span>Please upload image.<br></span> </div>';
		document.getElementById('message-error').innerHTML = error;
		return false;
	}else if(ext == "gif" || ext == "GIF" || ext == "JPEG" || ext == "jpeg" || ext == "jpg" || ext == "JPG" || ext == "png" || ext == "PNG")
	{
		parent.jQuery.colorbox.close();
		return true;
	} 
	else
	{
		document.getElementById('message-error').style.display = 'block';
		error = '<div class="image"> <img title="Error" alt="Error" src="<?php echo $this->webroot;?>img/error.png"></div><div class="text"><span>Please upload .jpg file or .png file or .gif file only.<br></span> </div>';
		document.getElementById('message-error').innerHTML = error;
		return false;
	}	
}
//-->
</script>