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
<?php echo $this->Form->create('Pix',array('action'=>'add','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
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
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('event_id',array('label'=>'','empty'=>'--Select Event--','options'=>$event_list,'type'=>'select','error'=>false));?></td>
            </tr>
            <tr id="imagesection">
              <td align="right" valign="middle"> Image to upload: </td>
              <td align="left" valign="top">
              <?php echo $this->element('photo_gallery_upload',array('id'=>'PixPicFilename','name'=>"data[Pix][pic_filename1]",'radiofieldname'=>"upload_photo"));?>
              <?php echo $this->Form->input('pic_filename',array('type'=>'file')); ?>  </td>
            </tr>
           
         <!--   <tr >
              <td align="right" valign="middle">  </td>
              <td align="left" valign="top"> <a href="JavaScript:void(0);" id="addButton" > Add More </a> </td>
            </tr>-->
            
               <!--<tr>
              <td align="right" valign="middle"><b>Current file name:</b> ACFEA8D.jpg&nbsp;&nbsp;-&nbsp;&nbsp;
		<b>Preview:</b> </td>
              <td align="left" valign="top">
              
		<img src="img/ACFEA8D.jpg" alt="" align="absmiddle">
							</td>
            </tr>-->

            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->input('Add Picture',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all'));
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
      
      <script type="text/javascript">
 
$(document).ready(function(){
 
    var counter = 1;
 
    $("#addButton").click(function () {
 
	if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
	}   
 
//	$('#imagesection').clone().appendTo('#addhere');
	 $('#imagesection').after("<tr id='imagesection'></tr>");
 
	counter++;
     });
 
     $("#removeButton").click(function () {
	if(counter==1){
          alert("No more textbox to remove");
          return false;
       }   
 
	counter--;
 
        $("#TextBoxDiv" + counter).remove();
 
     });
 
     $("#getButtonValue").click(function () {
 
	var msg = '';
	for(i=1; i<counter; i++){
   	  msg += "\n Textbox #" + i + " : " + $('#textbox' + i).val();
	}
    	  alert(msg);
     });
  });
</script>