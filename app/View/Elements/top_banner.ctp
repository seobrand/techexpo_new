<?php 
	echo $this->Html->script('front_js/responsiveslides.min.js');
	echo $this->Html->css('front_css/responsiveslides.css');
		
?>
<script type="text/javascript">
//jq162 = jQuery.noConflict(true);

 $(function () {
	    $("#slider1").responsiveSlides({
      
        speed: 800
      });

    });

</script>
<?php $banner = $common->getHomePageBanner();

 ?>
<ul class="rslides" id="slider1">
	<?php foreach($banner as $banner){ ?>
      <li><img src="<?php echo FULL_BASE_URL.router::url('/',false); ?>Banner/<?php echo $banner['Banner']['filename']; ?>" /></li>
     <?php } ?>
       
   
    </ul>


