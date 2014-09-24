<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'partnertracking')); ?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">List of registered marketing partners</div>
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
          <td align="left" valign="middle"><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Create a new tracking page" name="assign">',array('controller'=>'marketings','action'=>'createtrackingpage'),array('escape'=>false)); ?></td>
        </tr>
		<tr>
      <td><ul class="bullet_list">
	  <?php foreach($data as $key => $data){?>
            <li><?php echo $this->Html->link($data['TrackingPage']['organization'],array('controller'=>'marketings','action'=>'edittrackingpage',$data['TrackingPage']['page_id']));?> (<?php echo $data['TrackingPage']['page_name']." / index_".$data['TrackingPage']['page_name'].")"; ?></li>
		<?php }?>
          </ul></td>
      </tr>
	  	<?php if(count($data)==0){?>
		  <tr>
		  <td>Sorry no oraganization tracking pages found..</td>
		  </tr>
	  	<?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php if(count($data)):?>
<div style="clear:both;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;?>
