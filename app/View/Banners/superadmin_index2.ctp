<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'bannerlist')); ?>
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
<!-- box / title -->
<div class="display_row">
  <div class="table">
    <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
        <tr>
          <td align="left" valign="middle"><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add New" name="assign">',array('controller'=>'banners','action'=>'add'),array('escape'=>false)); ?></td>
        </tr>
      <td>
	  <?php if(is_array($home_banner) && count($home_banner)):?>
	  <strong>Homepage Main Banner</strong><br/><br/>
		<?php foreach ($home_banner as $key => $home_banner): ?>
			<ul class="bullet_list"> 
				<li><?php echo $this->Html->link($home_banner['Banner']['name'],array('controller'=>'banners','action'=>'edit',$home_banner['Banner']['id']),array('escape'=>false)); ?></li>
			</ul>
		<?php endforeach; ?>
	  <?php endif;?>
	  <?php if(is_array($corp_banner) && count($corp_banner)):?>
	  <strong>Corporation Banner</strong><br/><br/>
		<?php foreach ($corp_banner as $key => $corp_banner): ?>
			<ul class="bullet_list"> 
				<li><?php echo $this->Html->link($corp_banner['Banner']['name'],array('controller'=>'banners','action'=>'edit',$corp_banner['Banner']['id']),array('escape'=>false)); ?></li>
			</ul>
		<?php endforeach; ?>
	  <?php endif;?>
	  <?php if(is_array($emp_banner) && count($emp_banner)):?>
	  <strong>Platinum Banner</strong><br/><br/>
		<?php foreach ($emp_banner as $key => $emp_banner): ?>
			<ul class="bullet_list"> 
				<li><?php echo $this->Html->link($emp_banner['Banner']['name'],array('controller'=>'banners','action'=>'edit',$emp_banner['Banner']['id']),array('escape'=>false)); ?></li>
			</ul>
		<?php endforeach; ?>
	  <?php endif;?>
	  <?php if(is_array($media_banner) && count($media_banner)):?>
	  <strong>Media Banner</strong><br/><br/>
		<?php foreach ($media_banner as $key => $media_banner): ?>
			<ul class="bullet_list"> 
				<li><?php echo $this->Html->link($media_banner['Banner']['name'],array('controller'=>'banners','action'=>'edit',$media_banner['Banner']['id']),array('escape'=>false)); ?></li>
			</ul>
		<?php endforeach; ?>
	  <?php endif;?>
      
        <?php if(is_array($ads_banner) && count($ads_banner)):?>
	  <strong>Ads Banner</strong><br/><br/>
		<?php foreach ($ads_banner as $key => $ads_banner): ?>
			<ul class="bullet_list"> 
				<li><?php echo $this->Html->link($ads_banner['Banner']['name'],array('controller'=>'banners','action'=>'edit',$ads_banner['Banner']['id']),array('escape'=>false)); ?></li>
			</ul>
		<?php endforeach; ?>
	  <?php endif;?>
      
      
	  </td>
      </tr>
      </tbody>
    </table>
  </div>
</div>
<?php if(count($banner)):?>
<div style="clear:both;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;?>