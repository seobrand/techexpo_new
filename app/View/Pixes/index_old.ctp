<?php   
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
	echo $this->Html->script('front_js/jwplayer.js');
?>
<script type="text/javascript">
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".group1").colorbox({rel:'group1' ,maxWidth:"800px", maxheight:"600px"});
			
		});
</script>

<div id="wrapper_outer1">
<div id="wrapper">
  <?php 
	if($this->Session->read('Auth.Client.Candidate.id')!='')
	{
		echo $this->element('jobSeekerMenu', array('cache' => true));
	}
	
	if($this->Session->read('Auth.Client.employerContact.id')!='')
	{
		 echo $this->element('employer_tabs');
	}
 ?>
  <div class="inner_banner">
    <?php $bannerDt = $common->getbannerImage('8');   ?>
    <div class="static_inner_banner">
      <div class="static_title_bar">
        <p>
          <?php  echo $this->Text->truncate($bannerDt['OtherBanner']['name'], 40); ?>
        </p>
      </div>
      <?php // echo $this->Html->image("images/banner_job.jpg");  ?>
      <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  /> </div>
  </div>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Event Photos</h1>
          <div class="content">
            <div class="gray_full_top">
              <div style="text-align:center; padding-top:10px"><strong>Select Photo From</strong>&nbsp;<?php echo $this->Form->input('show_id',array('div'=>false,'label'=>false,'type'=>'select','options'=>$event,'empty'=>array('0'=>'All Events'),'style'=>'width:150px;','onchange'=>'getEventPhoto(this.value)'));?></div>
              <br/>
            </div>
            <div class="gray_full_mid event_padding1" style="padding-top:35px;">
              <ul class="eventPic_list">
                <?php foreach($event_list as  $event_list){ ?>
                <li>
                  <div class="event_pic_panel">
                    <?php
						if($event_list['Pix']['pic_filename'])
						{
						 echo $this->Html->link($this->Html->image('event-pics/resized_'.$event_list['Pix']['pic_filename'],array('height'=>'174','width'=>'226')),EVENTPICS_THUMB.$event_list['Pix']['pic_filename'],array('escape'=>false,'class'=>'group1','title'=>$event_list['Pix']['pic_title'],'data-fancybox-group'=>'gallery'));
						 }
						 ?>
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
    	<?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
<script type="text/javascript">
function getEventPhoto(eventID){
	var curUrl = window.location.href;
	var isindex = curUrl.indexOf('index');
	if(isindex==-1){
			var newUrl = curUrl + '/index/' + eventID
	}else{
		var newUrl = curUrl.replace(/\d+$/g, eventID);
	}
	window.location.href = newUrl;
}
</script>
