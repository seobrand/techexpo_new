<?php
$messageHomepage = array("e"=>"Employer","c"=>"Candidate");
echo $this->element('admin-breadcrumbs',array('pageName'=>'editHomepageMessage'));
//pr($this->request->data);exit;
?>

<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Edit <?php echo $messageHomepage[$data['HomepageMessage']['type']]; ?> Page Message</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('HomepageMessage',array('action'=>'edit','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
           
            <tr>
              <td width="25%" align="right" valign="middle">Message for <?php echo $messageHomepage[$data['HomepageMessage']['type']]; ?> : </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('msg',array('type'=>'textarea'));?></td>
            </tr>
            
            <tr>
              <td align="right" valign="middle"> Image to upload: </td>
              <td align="left" valign="top">
              <?php echo $this->element('photo_gallery_upload',array('id'=>'HomepageMessageImg','name'=>"data[HomepageMessage][img1]",'radiofieldname'=>"upload_photo"));?>
              <?php echo $this->Form->input('img',array('type'=>'file')); ?>  Keep the same ? Don't upload new.
              </td>
            </tr>  
            
               <tr>
              <td align="right" valign="middle"><b>Current file name:</b> <?php echo $this->data['HomepageMessage']['img']; ?>&nbsp;&nbsp;-&nbsp;&nbsp;
		<b>Preview:</b> </td>
              <td align="left" valign="top">              
		<?php
                echo $this->Html->image('homepage/resized_'.$this->data['HomepageMessage']['img'],array('align'=>'absmiddle'));
                echo $this->Form->checkbox('del',array('value'=>'y'));
                ?> 
                 Delete current Banner
             </td>
            </tr>

            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->submit('Update Message',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                echo "&nbsp;&nbsp;";
                echo $this->Form->hidden('type');
                echo $this->Form->hidden('curr_pic_filename',array('value'=>$this->data['HomepageMessage']['img']));
                echo $this->Form->end();
                //echo $this->Form->postLink('Delete Press',array('action'=>'delete',$this->data['HomepageMessage']['img']),array('confirm'=>'Are you sure want to delete?','class'=>'cursorclass ui-state-default ui-corner-all'));                
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