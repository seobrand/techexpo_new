
<?php 
	echo $this->Html->script('front_js/lib/jquery.simplyscroll.js');
	echo $this->Html->css('front_css/jquery.simplyscroll.css');
?>
<script type="text/javascript">

	$(function() {
		$("#scroller").simplyScroll({
        speed: 1,
		frameRate : 40,
		autoMode: 'loop', //auto = true, 'loop' or 'bounce',
		manualMode: 'end', //auto = false, 'loop' or 'end'
    });

	 
	
	
});



</script>
<?php 
if(!isset($this->params['prefix']) || $this->params['prefix']!='superadmin'){
	$partners = $common->getFooterPartnar();
	
}
?>

<div class="scroller_panel">
  <h5 style="color:#0D52B7 !important"><strong>Our Strategic Partners </strong></h5>
  <div class="partners">
    <ul id="scroller" >
      <?php foreach($partners as $partner){?>
      <?php if($partner['MarketingExhibitor']['image']!='' && file_exists('marketing_exhibitors/'.$partner['MarketingExhibitor']['image'])){?>
      <li style="margin-right:20px;vertical-align:middle !important">
        <div style="margin-right:10px;height:67px;">
          <div style="margin-right:10px;background-color:#FFFFFF;height:57px;vertical-align:middle !important;display:table-cell;text-align:center;border:1px solid #ddd">
            <?php 
		
			
		/*	if(empty($partner['Employer']['url']))
			{ $partner['Employer']['url'] = '#';}
			else
			{
			$validurl = strpos($partner['Employer']['url'],'http://');
				if (empty($validurl)) {
					$partner['Employer']['url'] = 'http://'.$partner['Employer']['url'];
				}
				
				if(!$partner['Employer']['url'])
				{
					$partner['Employer']['url']="#";	
				}				
			}*/
			
			if($partner['MarketingExhibitor']['image'])
			{
			 ?>
             
           
            
            <a <?php if(!empty($partner['Partner']['site_url'])) { echo 'target="_blank"'; }   ?> href="<?php if(!empty($partner['Partner']['site_url'])) echo $partner['Partner']['site_url']; else echo "JavaScript:void(0);";  ?>" >
             <img src="<?php echo FULL_BASE_URL.router::url('/',false); ?>thumbnail.php?file=<?php echo 'marketing_exhibitors/'.$partner['MarketingExhibitor']['image'];?>&maxw=163&maxh=55"  alt="<?php echo $partner['Partner']['partner_name']; ?>"  title="<?php echo $partner['Partner']['partner_name']; ?>" style="margin:0px 10px;"/> 
          
             </a>
            <?php } ?>
          </div>
        </div>
      </li>
      <?php } ?>
      <?php } ?>
    </ul>
  </div>
  <div class="clear"></div>
</div>
<br />