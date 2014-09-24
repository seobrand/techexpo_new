<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addbanner')); ?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Banner Management</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<div class="display_row">
  <div class="table">
   <?php  echo $this->Form->create('Banner', array('enctype' => 'multipart/form-data','type' => 'post','action' => 'add') ); ?> 
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
      <tr>
          <td width="25%" align="right" valign="middle">Banner Order: </td>
          <td align="left" width="74%"  valign="top"><?php echo $this->Form->input('order',array('div'=>false,'label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td width="25%" align="right" valign="middle">Banner 
            Title: </td>
          <td align="left" width="74%"  valign="top"><?php echo $this->Form->input('name',array('div'=>false,'label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Banner 
            Type: </td>
          <td align="left" valign="top"><?php echo $this->Form->input('category_link',array('div'=>false,'type'=>'select','options'=>$bannercategory,'label'=>'','class'=>'','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Banner Status: </td>
          <td align="left" valign="top"><?php echo $this->Form->input('banner_status',array('div'=>false,'type'=>'select','options'=>array('active'=>'Active','inactive'=>'Inactive'),'label'=>'','class'=>'','error'=>false));?></td>
        </tr>
        <tr id="adsposition" style="display:none;">
          <td align="right" valign="middle">Banner Position: </td>
          <td align="left" valign="top"><?php echo $this->Form->input('ad_position',array('div'=>false,'type'=>'select','options'=>array(0=>'Both','1'=>'Home Page Ad','2'=>'Job Seeker Page'),'label'=>'','class'=>'','error'=>false));?></td>
        </tr>
        
        <tr>
          <td align="right" valign="middle">Link:</td>
          <td align="left" valign="top"><?php echo $this->Form->input('href',array('div'=>false,'label'=>'','value'=>'http://','class'=>'inputbox1','error'=>false));?>
          Ex : http://www.techexpousa.com 
          </td>
        </tr>
        <tr>
          <td align="right" valign="middle">Link Type: </td>
          <td align="left" valign="top"><?php echo $this->Form->input('link_type',array('div'=>false,'type'=>'select','options'=>array('external'=>'External','internal'=>'Internal'),'label'=>'','class'=>'','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle">Text label for the image<br>
            (in case image doesn't load):<br>
          </td>
          <td align="left" valign="top"><?php echo $this->Form->input('alt',array('div'=>false,'label'=>'','class'=>'inputbox1','error'=>false));?></td>
        </tr>
        <tr>
          <td align="right" valign="middle"> Image to upload: </td>
          <td align="left" valign="top">
          <?php echo $this->element('photo_gallery_upload',array('id'=>'BannerFilename','name'=>"data[Banner][filename1]",'radiofieldname'=>"upload_photo"));?><br/><br/>
          <?php echo $this->Form->input('filename',array('div'=>false,'label'=>'','class'=>'','error'=>false,'type'=>'file'));?>
          <div style="float:right !important;margin-top:-34px !important;">
          <b>Image Size </b><br/>
        
          
          <table width="200" border="1">
   <tr>
    <td>Banner Type</td>
    <td>Width</td>
    <td>Height</td>
  </tr>       
  <tr>
    <td>Corporation, Media, Platinum</td>
    <td>321px</td>
    <td>249px</td>
  </tr>
  <tr>
    <td>homepage main banner</td>
    <td>1424px</td>
    <td>249px </td>
  </tr>
  <tr>
    <td>Advertising Banners</td>
    <td>333px</td>
    <td>200px</td>
  </tr>
</table>

          
           
           </div>
          </td>
        </tr>
        <tr>
          <td align="right" valign="middle">&nbsp;</td>
          <td align="left" valign="top">
          <?php echo $this->Form->submit('Add Banner',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
		  <?php echo $this->Form->end();?>
		</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">


	$(document).ready(function () {
		
		<?php if(isset($this->request->data['Banner']['category_link']) && $this->request->data['Banner']['category_link']==5) { ?>
		$('#adsposition').show();
		<?php } ?>
		
		
		$("#BannerCategoryLink").change(function()
		{ 
			 var typeId = $(this).val();
			 if(typeId==5)
			 $('#adsposition').show();
			 else
			 $('#adsposition').hide();
		})
	})
</script>
