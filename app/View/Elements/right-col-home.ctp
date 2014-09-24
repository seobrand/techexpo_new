<div class="top_head2">
  <h2>Business Support Areas</h2>
</div>
<div class="services_col">
  <li><?php echo $html->link('Scanning, E-Bibles, IT &amp; DTP',array('controller'=>'pages','action'=>'scanning-e-bibles-it-dtp'),array('escape'=>false)); ?></li>
  <li><?php echo $html->link('Print &amp; Document Production',array('controller'=>'pages','action'=>'print-document-production'),array('escape'=>false)); ?>
  </li>
  <li><?php echo $html->link('Archives, Storage &amp; Logistics',array('controller'=>'pages','action'=>'archives-storage-logistics'),array('escape'=>false)); ?></li>
  <li><?php echo $html->link('Post, GO &amp; Facilities Support',array('controller'=>'pages','action'=>'post-go-facilities-support'),array('escape'=>false)); ?></li>
</div>
<div class="services_img">
<?php 
if(is_array($Business_Support_Areas) && count($Business_Support_Areas)) {

 echo '<img src="'.FULL_BASE_URL.Router::url("/", false).'/image_resizer.php?img='.WWW_ROOT.'/img/slide_show/'.$Business_Support_Areas['Image']['name'].'&newWidth=206&newHeight=165" alt="Services" title="Services"/>';

}?>


<?php //echo $html->image('services_img.jpg',array('alt'=>'Services','title'=>'Services')); ?></div>