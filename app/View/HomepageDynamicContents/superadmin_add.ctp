<?php
echo $this->element('admin-breadcrumbs',array('pageName'=>'addHomepagedynamic'));
//pr($this->request->data);exit;
?>

<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Add Home Page Team Message</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('HomepageDynamicContent',array('action'=>'add','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
          <p> 1. Use the link below to choose whether or not you would like to dispay the rotating military banner below the homepage message(s). <br>
                <br>
                2. Use the instructions below to create, update or delete messages. <br>
                <br>
              </p>
            <!--     <p><b>Rotating military image setting: </b>The rotating militray is currently set NOT to be displayed. <a href="#">Click here to choose to display it.</a></p>
        -->
        <table>
          <tbody>
           <tr>
            <td colspan="2"><b>EDIT A HOMEPAGE MESSAGE AND IMAGE</b><br>
              <br>
              1) Enter your text or HTML. <br>
              <br>
              2) Pick an image (optional) and indicate if you want the image to be below the text (good for wide horizontal images), or aligned on the left with the text to the right of the image (better for smaller, squarer images).<br>
              <br>
             <!-- <b><font color="red">IMPORTANT NOTE: maximum image size is now 390 pixels wide</font></b><br>-->
              <br></td>
          </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Type of Announcement : </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('type',array('label'=>'','options'=>array('s'=>'Special Announcement','p'=>'Message from the President'),'type'=>'select','error'=>false)); ?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Announcement is active (displayed on homepage) : </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('active',array('label'=>'','options'=>array('y'=>'Yes','n'=>'No'),'type'=>'select','error'=>false)); ?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Sort Order : </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('sort',array('type'=>'text'));?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Title : </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('title',array('type'=>'text'));?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Announcement text : </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('text',array('type'=>'textarea'));?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Please select an image alignment method : </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('align',array('label'=>'','options'=>array('b'=>'Align image below text','l'=>'Align image left of text'),'type'=>'select','error'=>false)); ?></td>
            </tr>
            
            
            <tr>
              <td align="right" valign="middle"> Banner / image file (optional): </td>
              <td align="left" valign="top">
              <?php
              	echo $this->element('photo_gallery_upload',array('id'=>'HomepageDynamicContentImage','name'=>"data[HomepageDynamicContent][image1]",'radiofieldname'=>"upload_photo"));
                echo $this->Form->input('image',array('type'=>'file'));                                
              ?></td>
            </tr>
            <tr>
              <td width="25%" align="right" valign="middle">Link for banner / image (optional) : </td>
              <td width="74%"  align="left" valign="top"><?php echo $this->Form->input('image_link',array('type'=>'text'));?><br/>enter full URL (eg: http://www.techexpoUSA.com)
              </td>
            </tr>

            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->submit('Add',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                echo $this->Form->end();                
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

