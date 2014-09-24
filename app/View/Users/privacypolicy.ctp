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
	<?php // echo $this->Html->image('images/why_attend.jpg');?>
           <?php $bannerDt = $common->getbannerImage('10');   ?>
 <div class="static_inner_banner">
   <div class="static_title_bar">
  <p><?php  echo $this->Text->truncate($bannerDt['OtherBanner']['name'], 40); ?></p>
  </div>
  <?php // echo $this->Html->image("images/banner_job.jpg");  ?>
  <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  />
  </div>
    
    <?php ?>
    </div>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
             <?php echo $content['PageContent']['content'];?>
          </div>
        </div>
      </div>
      <div class="rt_col_inner">
        
         
        <?php 
		 if($this->Session->read('Auth.Client.Candidate.id')!='')
			{
				echo $this->element('jobSeekerSidebar', array('cache' => true)); 
				
			}elseif($this->Session->read('Auth.Client.employerContact.id')!='')
			{
				echo $this->element('employer_left_panel');
			}else
			{
				echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); 
				echo $this->element('main_login_leftbar', array('cache' => true)); 
			}
	   ?>
        
        
         
      </div>
      <div class="clear"></div>
        <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>