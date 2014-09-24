<?php
echo $html->script('jquery.min.js');
echo $html->script('fadeslideshow.js');
?>
<!-- slider js, css -->
<?php 
if(is_array($slide_show_image) && count($slide_show_image)) {
foreach($slide_show_image as $slide_show_image) {
$image[] = '["'.FULL_BASE_URL.Router::url("/", false).'/image_resizer.php?img='.WWW_ROOT.'/img/slide_show/'.$slide_show_image['Image']['name'].'&newWidth=974&newHeight=350"]';
}
$slide = implode(',',$image);
}
else {
$slide  = '';
}
?>
<script type="text/javascript">
var mygallery=new fadeSlideShow({
	wrapperid: "fadeshow1", //ID of blank DIV on page to house Slideshow
	dimensions: [974, 350], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [

		<?php echo $slide;?>
 	],
	displaymode: {type:'auto', pause:2800, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 5000, //transition duration (milliseconds)
	descreveal: "ondemand",
	togglerid: ""
})
</script>
    <!-- slider start -->
    <div class="slider">
      <div id="slider">
        <div id="fadeshow1" style="z-index:100;"></div>
      </div>
    </div>
    <!-- slider end -->