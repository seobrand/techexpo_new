<?php 
    echo $this->Html->script('front_js/tabcontent.js');
    echo $this->Html->css('front_css/tabcontent.css');
?>
<?php   
// for facny box
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');	
	


/*if($type=='c')
{
$main_select ='selected';	
$cand_select = 'selected';
}

if($type=='e')
{
$main_select ='selected';	
$emp_select = 'selected';
}
	*/
	
	
	
?>
<script type="text/javascript">

$(document).ready(function(){	
	$(".ajax").colorbox();	
	
	
	<?php if($type=='c') {  ?>
	$('a[rel="text02"]').addClass('selected');
	$('a[rel="text01"]').removeClass('selected');
	$('#text01').hide();
	$('#text02').show();
	<?php } ?>
	
	
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
    <?php $bannerDt = $common->getbannerImage('12');   ?>
    <div class="static_inner_banner">
      <div class="static_title_bar">
        <p>
          <?php  echo $this->Text->truncate($bannerDt['OtherBanner']['name'], 40); ?>
        </p>
      </div>
      <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  /> </div>
  </div>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <div class="whiteB_bottom">
            <div class="content">
              <ul id="countrytabs" class="shadetabs">
                <li class="Tabfirst1"><a href="#" rel="country1"  ><span>Testimonials</span></a></li>
                <li class="Tabfirst2" ><a href="#" rel="country2" ><span>Videos</span></a></li>
              </ul>
              <div class="clear"></div>
              <div class="wrap_testy">
                <div id="country1" class="tabcontent">
                  <!--testimonials div start -->
                  <div class="tabs_wrapper">
                    <ul id="countrytabs01" class="shadetabs02">
                      <li class="testimonials01"><a href="#" rel="text01"  >Employers</a></li>
                      <li class="testimonials02"><a href="#" rel="text02" >Job Seekers</a></li>
                    </ul>
                     <?php if($this->Session->read('Auth.Clients')){ ?>
                   		  <a href="<?php echo FULL_BASE_URL.router::url('/',false)?>testimonials/addTestimonial" style="float:right;margin-right:4px;">
                     			<img src="<?php echo FULL_BASE_URL.router::url('/',false)?>img/add-testminial.png"/>
                    	  </a>
                       <?php } ?>
                    <div class="clear"></div>
                    <div class="tabs_collm">
                      <div class="tabcontent" id="text01">
                        <ul class="testimonial_list">
                          <?php  
				if(count($testimonials_emp)> 0){
				foreach($testimonials_emp as $testimonail) { ?>
                          <li>
                            <div class="testimonial_img">
                              <?php if(file_exists('img/testimonial/'.$testimonail['Testimonial']['logo_file'])) 
							  {
					 // echo $this->Html->image('testimonial/resized_'.$testimonail['Testimonial']['logo_file'],array('style'=>''));
					  ?>
                      <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'img/testimonial/'.$testimonail['Testimonial']['logo_file'];?>&maxw=120&maxh=90" style="margin:7px 0 0 -10px!important;" /> 
                      <?php 
					  }
					  else
					  {
					  	echo $this->Html->image('testimonial/no_image.jpg',array('style'=>'margin:7px 0 0 -10px!important;width:120px;'));
					}
					   ?>
                            </div>
                            <div class="testi_description">
                              <p class="indent_testimonial">
                                <?php  echo $testimonail['Testimonial']['text'] ;  ?>
                              </p>
                              <p><span class="italic">
                                <?php  echo $testimonail['Testimonial']['name'] ;  ?>
                                </span><br />
                                <span class="red"></span></p>
                            </div>
                          </li>
                          <?php } } else { ?>
                          Employer testimonial are coming here...<br />
                          <?php } ?>
                        </ul>
                      </div>
                      <div class="tabcontent" id="text02">
                        <ul class="testimonial_list">
                          <?php  
				if(count($testimonials_candi)> 0){
				foreach($testimonials_candi as $testimonail ) {
				
			echo $testimonail['Testimonial']['user_id'];
				
				 ?>
                          <li>
                            <div class="testimonial_img">
                              <?php  if(file_exists('img/testimonial/'.$testimonail['Testimonial']['logo_file'])) 
							 	{
							   ?>
							    <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'img/testimonial/'.$testimonail['Testimonial']['logo_file'];?>&maxw=120&maxh=90" style="margin:7px 0 0 -10px!important;" /> 
                                <?php
					 // echo $this->Html->image('testimonial/resized_'.$testimonail['Testimonial']['logo_file'],array('style'=>'margin:7px 0 0 -10px!important;width:120px;'));
					  }
					  else
					  {
					  echo $this->Html->image('testimonial/no_image.jpg',array('style'=>'margin:7px 0 0 -10px!important;width:120px;'));
					  } ?>
                            </div>
                            <div class="testi_description">
                              <p class="indent_testimonial">
                                <?php  echo $testimonail['Testimonial']['text'] ;  ?>
                              </p>
                              <p><span class="italic">
                                <?php  echo $testimonail['Testimonial']['name'] ;  ?>
                                </span><br />
                                <span class="red"></span></p>
                            </div>
                          </li>
                          <?php } } else { ?>
                          Job Seeker testimonial are coming here...<br />
                          <?php } ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <!--testimonials div end -->
                </div>
                <div id="country2" class="tabcontent">
                  <!--videos div start -->
                  <div class="tabs_wrapper">
                    <ul id="countrytabs02" class="shadetabs02">
                      <li class="video01"><a href="#" rel="play01">Employers</a></li>
                      <li class="video02"><a href="#" rel="play02">Job Seekers</a></li>
                    </ul>
                    <div class="clear"></div>
                    <div class="tabs_collm">
                      <div class="tabcontent" id="play01">
                        <ul class="videos_collm">
                          <?php  
				if(count($emp_videos)> 0){
					$i= '1';
				foreach($emp_videos as $emp_video ) {  
		
			if($emp_video['EmployerVideo']['video_type']=='upload')
                        {
                        $imagePath = 'images/video_img.jpg';
                        }
                        else {
						$youtubeId = end(explode('/',$emp_video['EmployerVideo']['video']));
						$imagePath = 'http://img.youtube.com/vi/'.$youtubeId.'/0.jpg';	
                         } ?>
                          <li> <?php echo $this->Html->link($this->Html->image($imagePath,array('style'=>'width:284px;height:168px;')), array('controller'=>'employers','action'=>'empshowVideo',$emp_video['EmployerVideo']['id']),array('class'=>'ajax','escape'=>false)); ?> <a href=" <?php echo $this->Html->url(array("controller" => "Jobseeker","action" => "candidates/employeDetail",$emp_video['EmployerVideo']['employer_id']));?>" target="_blank" > <span><?php echo $this->Text->truncate(ucfirst($emp_video['Employer']['employer_name']), 30); ?></span> </a> </li>
                          <?php
               if($i%2=='0')
               { ?>
                        </ul>
                        <ul class="videos_collm">
                          <?php }
           		$i=$i+1;
				} 
                ?>
                        </ul>
                        <?php
                
                } else { ?>
                        Employer videos are coming here...<br />
                        <?php } ?>
                      </div>
                      <div class="tabcontent" id="play02">
                        <ul class="videos_collm">
                          <?php  
				if(count($can_videos)> 0){
					$i= 1;
				foreach($can_videos as $can_video ) {  
			
				if($can_video['CandidateVideo']['video_type']=='upload')
                        {
                        $imagePath = 'images/video_img.jpg';
                        }
                        else {
						$youtubeId = end(explode('/',$can_video['CandidateVideo']['video']));
						$imagePath = 'http://img.youtube.com/vi/'.$youtubeId.'/0.jpg';	
                         } ?>
                          <li> <?php echo $this->Html->link($this->Html->image($imagePath,array('style'=>'width:284px;height:168px;')), array('controller'=>'Jobseeker','action'=>'candidates/showVideo/'.$can_video['CandidateVideo']['id']),array('class'=>'ajax','escape'=>false));  ?> <span><?php echo $this->Text->truncate(ucfirst($can_video['CandidateVideo']['description']), 30); ?></span> </li>
                          <?php
               if($i%2=='0')
               { ?>
                        </ul>
                        <ul class="videos_collm">
                          <?php }
           		$i=$i+1;
				} 
                ?>
                        </ul>
                        <?php
                
                } else { ?>
                        Job Seeker videos are coming here...<br />
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <!--videos div end -->
                </div>
              </div>
              <script type="text/javascript">
            
            var countries=new ddtabcontent("countrytabs")
            countries.setpersist(true)
            countries.setselectedClassTarget("link") //"link" or "linkparent"
            countries.init()
			
			 var countries=new ddtabcontent("countrytabs01")
            countries.setpersist(true)
            countries.setselectedClassTarget("link") //"link" or "linkparent"
            countries.init()
			
              var countries=new ddtabcontent("countrytabs02")
            countries.setpersist(true)
            countries.setselectedClassTarget("link") //"link" or "linkparent"
            countries.init()
            </script>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="rt_col_inner">
      <?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
    </div>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
