<?php   
// for facny box
	echo $this->Html->script('front_js/jquery.mousewheel-3.0.6.pack.js');
	echo $this->Html->script('front_js/jquery.fancybox.js?v=2.1.0');
	echo $this->Html->css('front_css/jquery.fancybox.css?v=2.1.0');
?>
<script type="text/javascript">
		$(document).ready(function() {
			
			$('.fancybox').fancybox();
			
		});
	</script>
<div id="wrapper_outer1">
  <div id="wrapper">
    <!--<div class="inner_banner"> <img src="images/event_banner.jpg" alt=""  /> </div>-->
    
    <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Event Detail Photos</h1>
            <div class="content">
              
              <div class="gray_full_top"></div>
              
               <div class="gray_full_mid event_padding1">
               <ul class="eventPic_list">
            
            
            <?php foreach($event_list as  $event_list){ ?>
               <li>
               <div class="event_pic_panel">
            	<?php echo $this->Html->link($this->Html->image('event-pics/resized_'.$event_list['Pix']['pic_filename'],array('height'=>'174','width'=>'226')),EVENTPICS_THUMB.$event_list['Pix']['pic_filename'],array('escape'=>false,'class'=>'fancybox','title'=>$event_list['Pix']['pic_title'],'data-fancybox-group'=>'gallery'));?>
                      
                   
                     </div>
               </li>
			<?php } ?>
               
               
               </ul>
               
               
               <div class="clear"></div>
               </div>
               
               
            </div>
          </div>
        </div>
      </div>
      

   		<?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
      <div class="clear"></div>
        <?php echo $this->element('partners', array('cache' => true)); ?>
    </div>
  </div>