<?php $this->set('title_for_layout', isset($data['Page']['meta_title']) ? $data['Page']['meta_title'] : ' Welcome to Kings Recruitment Consultants');  ?>
<!-- left col end -->
<?php if(is_array($data) && count($data)) {   ?>
<?php if(isset($data['Page']['alias']) && $data['Page']['alias']=='home') { ?>
<div class="left_col">
  <div class="top_head">
    <h1><?php echo str_replace(' ','<span> ',$data['Page']['title']); ?></span></h1>
    <!--<h1>Welcome to <span>Kings Recruitment Consultants</span> </h1>-->
  </div>
  <div style="text-align:justify">
    <?php  
	if($data['Page']['page_type']=='content') {
		echo $data['Page']['content']; 
	}
	?>
  </div>
</div>
<!-- right col start -->
<div class="right_col"><?php echo $this->element('right-col-home'); ?> </div>
<?php }

else if(isset($data['Page']['alias']) && ($data['Page']['alias']=='candidate' || $data['Page']['alias']=='client')) { ?>
<div class="left_col">
  <div class="top_head">
    <h1><?php echo str_replace(' ','<span> ',$data['Page']['title']); ?></span></h1>
    <!--<h1>Welcome to <span>Kings Recruitment Consultants</span> </h1>-->
  </div>
  <div style="text-align:justify">
    <?php  
	if($data['Page']['page_type']=='content') {
		echo $data['Page']['content']; 
	}
 ?>
  </div>
</div>
<div class="right_col" style="padding-right:15px;"><?php echo ($data['Page']['alias']=='client') ? $this->element('right-col-client') : $this->element('right-col-candidate'); ?> </div>
<?php }

	else { ?>
<div class="top_head">
  <h1><?php echo str_replace(' ','<span> ',$data['Page']['title']); ?></span></h1>
  <!--<h1>Welcome to <span>Kings Recruitment Consultants</span> </h1>-->
</div>
<div style="text-align:justify">
  <?php  
	if($data['Page']['page_type']=='content') {
		echo $data['Page']['content']; 
	}
 ?>
</div>
<?php }
 }
else {
   echo "No such page found.";
}  
?>
<!-- right col end -->
