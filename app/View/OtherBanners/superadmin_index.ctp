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
          <td align="left" valign="middle"><?php // echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add New" name="assign">',array('controller'=>'other_banners','action'=>'add'),array('escape'=>false)); ?></td>
        </tr>
      <td>
	  <?php if(is_array($banner) && count($banner)):?>
	  <strong>Manager Front Banner</strong><br/><br/>
		<?php foreach ($banner as $key => $banner): ?>
			<ul class="bullet_list"> 
				<li><?php echo $this->Html->link($banner['OtherBanner']['name'],array('controller'=>'other_banners','action'=>'edit',$banner['OtherBanner']['id']),array('escape'=>false)); ?></li>
			</ul>
		<?php endforeach; ?>
	  <?php endif;?>


	
	  </td>
      </tr>
      </tbody>
    </table>
  </div>
</div>
<?php if(count($banner12)):?>
<div style="clear:both;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;?>
