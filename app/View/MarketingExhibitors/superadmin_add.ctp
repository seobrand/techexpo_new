<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'AddMarketingExhibitor')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Add Marketing Partner</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('MarketingExhibitor',array('action'=>'add','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
           
<tr>
<td width="25%" align="right" valign="middle">Title: </td>
<td width="74%"  align="left" valign="top"><?php echo $this->Form->input('MarketingExhibitor.title',array('class'=>'inputbox1','type'=>'text'));?></td>
</tr>

<tr>
<td width="25%" align="right" valign="middle">Description: </td>
<td width="74%"  align="left" valign="top"><?php echo $this->Form->input('MarketingExhibitor.description',array('class'=>'inputbox12','type'=>'textarea','cols'=>100,'rows'=>30));?>
</td>
</tr>
            
              
            <tr id="imagesection">
              <td align="right" valign="middle"> Image to upload: </td>
              <td align="left" valign="top">
              <?php echo $this->element('photo_gallery_upload',array('id'=>'PixPicFilename','name'=>"data[MarketingExhibitor][image1]",'radiofieldname'=>"upload_photo"));?>
              <?php echo $this->Form->input('MarketingExhibitor.image',array('type'=>'file')); ?>  </td>
            </tr>
           
        
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->input('Add Marketing Partner',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all'));
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
