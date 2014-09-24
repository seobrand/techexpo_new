
<?php 
	echo $this->Html->script('front_js/lib/jquery.simplyscroll.js');
	echo $this->Html->css('front_css/jquery.simplyscroll.css');
?>
<script type="text/javascript">
(function($) {
	$(function() {
		$("#scroller").simplyScroll();
	});
})(jQuery);



</script>
<?php 
if(!isset($this->params['prefix']) || $this->params['prefix']!='superadmin'){
	App::import('Model', 'Partner');
	$partner = new Partner();
	$partners = $partner->find('all');
	
}
?>

<div class="scroller_panel">
  <h5>Our Partners</h5>
  <div class="partners">
    <ul id="scroller" >
      <?php foreach($partners as $partner){?>
      <?php if($partner['Employer']['logo_file']!=''){?>
      <li style="margin-right:20px;vertical-align:middle !important">
        <div style="margin-right:10px;height:67px;">
          <div style="margin-right:10px;background-color:#FFFFFF;height:57px;vertical-align:middle !important;display:table-cell;text-align:center;border:1px solid #ddd">
            <?php 
		
			
			if(empty($partner['Employer']['url']))
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
			}
			
			if($partner['Employer']['logo_file'])
			{
			 ?>
             
           
             
            <a href="<?php echo FULL_BASE_URL.router::url('/',false);?>Jobseeker/candidates/employeDetail/<?php echo $partner['Partner']['employer_id']; ?>" target="_blank" > <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$partner['Employer']['logo_file'];?>&maxw=163&maxh=55"  alt="<?php echo $partner['Partner']['partner_name']; ?>"  title="<?php echo $partner['Partner']['partner_name']; ?>" style="margin:0px 10px;"/> </a>
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
