<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TechExpo</title>
<!--end here-->
<?php 
    echo $this->Html->css('front_css/reset.css');
    echo $this->Html->css('front_css/style.css');
    echo $this->Html->css('front_css/dropdown.css');
?>
<!-- Dropdown -->

<link rel="stylesheet" href="css/dropdown.css" type="text/css" media="screen, projection"/>
<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" />
    <![endif]-->

<script type="text/javascript" src="js/jquery-1.3.1.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.dropdownPlain.js"></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/font_style.js"></script>
<script type="text/javascript" src="js/Myriad_Pro_400.font.js"></script>
<script type="text/javascript" src="js/Myriad_Pro_600.font.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/easySlider1.7.js"></script>
<script type="text/javascript">
$(document).ready(function(){	
$("#slider").easySlider({
	auto: true, 
	continuous: true
});
});	
</script>
<script type="text/javascript" src="js/css_browser_selector.js"></script>
<style>
/*.ie .example {
  background-color: yellow
}
.ie7 .example {
  background-color: orange
}
.gecko .example {
  background-color: gray
}
.win.gecko .example {
  background-color: red
}
.linux.gecko .example {
  background-color: pink
}
.opera .example {
  background-color: green
}
.konqueror .example {
  background-color: blue
}
.safari .example {
  background-color: black
}
.example {
  width: 100px;
  height: 100px;
}
*/


.no_js {
	display: block
}
.has_js {
	display: none
}
.js .no_js {
	display: none
}
.js .has_js {
	display: block
}
</style>

<!-- scroller script started from here-->

<!--
  jQuery library
-->
<script type="text/javascript" src="lib/jquery-1.4.2.min.js"></script>
<!--
  jCarousel library
-->
<script type="text/javascript" src="lib/jquery.jcarousel.min.js"></script>
<!--
  jCarousel skin stylesheets
-->
<link rel="stylesheet" type="text/css" href="skins/tango/skin.css" />
<script type="text/javascript">

jQuery(document).ready(function() {
    // Initialise the first and second carousel by class selector.
	// Note that they use both the same configuration options (none in this case).
	jQuery('.first-and-second-carousel').jcarousel(
	
	{
          auto: 1,
        wrap: 'last',
				visible: 5
			
    }
	);
	
	// If you want to use a caoursel with different configuration options,
	// you have to initialise it seperately.
	// We do it by an id selector here.

});

</script>

<!-- Ended script scroller -->
<!-- Tab Panel Started from here-->

<!--<script src="jquery.js" type="text/javascript" charset="utf-8"></script>
--><script src="js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	// <![CDATA[
		
	$(document).ready(function () {
		$('#menu1').tabify();
	});
			
	// ]]>
</script>

<script type="text/javascript">
	// <![CDATA[
		
	$(document).ready(function () {
		$('#menu2').tabify();
	});
			
	// ]]>
</script>

<!-- Tab Panel Started from here-->

<link rel="SHORTCUT ICON" href="<?php echo BASE_URL; ?>/img/favicon.ico">
</head>

<body>
<div id="wrapper">
  <div id="header">
    <div id="logo"><?php echo $this->Html->link('','/');?></div>
    <div id="callus"> 
    <?php if($this->Session->read('Auth.Client.User.id')!='' or $this->Session->read('Auth.Client.employer.id')!=''){ ?>
    
    
    
    
    
     <div class="top_link_panel">
     <div class="top_link_btns"><?php echo $this->Html->link($this->Html->image('images/logout.jpg'),array('controller'=>'users','action'=>'home','Jobseeker'=>false),array('escape'=>false)); ?></div>
      <div class="top_link_btns">
	  <?php 
	  if($this->Session->read('Auth.Clients.user_type')=='C')
	  echo $this->Html->link($this->Html->image('images/myaccount.png'),array('controller'=>'Jobseeker','action'=>'/','Jobseeker'=>false),array('escape'=>false));
	  else
	  echo $this->Html->link($this->Html->image('images/myaccount.png'),array('controller'=>'employers','action'=>'/','Jobseeker'=>false),array('escape'=>false)); ?>
      </div>
   
  </div>
   <div class="welcome_txt_new">Hello, <span><?php echo ucfirst($this->Session->read('Auth.Clients.username')); ?></span></div>
  
  
  
    <?php } else { ?>
   <div style="float:right;padding:45px 0 0 0;font-size:12px;font-weight:700;">
   <?php echo $this->Html->link($this->Html->image('images/login.png'),array('controller'=>'users','action'=>'login','Jobseeker'=>false),array('escape'=>false));?>
     <a href="javascript:void(0);" onclick="showRegisterPopup()">
   <?php echo $this->Html->image('images/register_header.png'); ?> </a></div>
    <?php } ?>
    </div>
    <div class="clear"></div>
    <div id="nav">
      <div class="menu">
        <ul class="top_menu">
          <li><?php echo $this->Html->link("Home",'/'); ?>
          			<!--<ul class="sub_menu">
                        	
                     </ul>-->
          </li>
          <li><?php echo $this->Html->link("about us",'/about_us'); ?>
          		<ul class="sub_menu">
          			<li><?php echo $this->Html->link("Press / Media Coverage",'/pressReleases'); ?></li>
                    <li><?php echo $this->Html->link("Recruit @ Techexpo",array('controller'=>'employers','action'=>'recruitattechexpo','Jobseeker'=>false)); ?></li>
                    <li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>   
                    <li><?php echo $this->Html->link("Testimonials",'/testimonials'); ?></li>   
                    <li><?php echo $this->Html->link("Contact Us",array('controller'=>'users','action'=>'contactUs','Jobseeker'=>false)); ?> </li>                
          		</ul>
          </li>
          <li>
		  
				  <?php if($this->Session->read('Auth.Client.User.candidate_id')){ ?>
                        	<?php echo $this->Html->link("events",'/Jobseeker/shows/eventList'); ?>
                  <?php }else{ ?>
                        
                             <?php echo $this->Html->link("events",'/shows'); ?>
                   <?php } ?>
           	<ul class="sub_menu">
				<?php if($this->Session->read('Auth.Client.User.candidate_id')){ ?>
                	<li><?php echo $this->Html->link("events",'/Jobseeker/shows/eventList'); ?></li>
                
				<?php }else{ ?>
                
               		<li><?php echo $this->Html->link("events",'/shows'); ?></li>
                
                <?php } ?>
                            
           		<li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>
               
           	</ul>
          
          </li>
          
           <?php  if($this->Session->read('Auth.Client.User.user_type')!='E') { ?>
          <?php if($this->Session->read('Auth.Client.User.candidate_id')){ ?>
          <li><?php echo $this->Html->link("job seekers",array('controller'=>'candidates','action'=>'candidateprofile','Jobseeker'=>true)); ?>
          			<ul class="sub_menu">
                       <?php /*?>  	<li>
                            	<?php echo $this->Html->link("Why Attend?", array('controller'=>'users','action'=>'whyAttend','Jobseeker'=>false),array('class'=>'','escape'=>false)); ?>
                            </li>
                            <li> 
                               <a href="<?php echo FULL_BASE_URL.router::url('/',false); ?>jobseeker_register" >Register</a>
                            </li><?php */?>
                            <li>
                            	<?php echo $this->Html->link("Tell a Friend", array('controller'=>'users','action'=>'tellaFriend','Jobseeker'=>false),array('class'=>'ajax','escape'=>false)); ?>
                            </li>
                            <li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>
                            <li> 
                            	<?php echo $this->Html->link("Resume Writing ", array('controller'=>'users','action'=>'resumewriting','3','Jobseeker'=>false)); ?>                           		
                            </li>
                              <li><?php echo $this->Html->link("Testimonials",'/testimonials/index/c'); ?></li> 
                        </ul>
          </li>
          <?php } else{?>
			<li><?php echo $this->Html->link("job seekers",array('controller'=>'users','action'=>'login','Jobseeker'=>false)); ?>
            
            			<ul class="sub_menu">
                         	<li>
                            	<?php echo $this->Html->link("Why Attend?", array('controller'=>'users','action'=>'whyAttend','Jobseeker'=>false),array('class'=>'','escape'=>false)); ?>
                            </li>
                            <li>                             	
                               <a href="<?php echo FULL_BASE_URL.router::url('/',false); ?>jobseeker_register" >Register</a>
                            </li>
                            <li>
                            	<?php echo $this->Html->link("Tell a Friend", array('controller'=>'users','action'=>'tellaFriend','Jobseeker'=>false),array('class'=>'ajax','escape'=>false)); ?>
                            </li>
                            <li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>
                            <li> 
                            	<?php echo $this->Html->link("Resume Writing ", array('controller'=>'users','action'=>'resumewriting','3')); ?>
                            </li>
                              <li><?php echo $this->Html->link("Testimonials",'/testimonials/index/c'); ?></li> 
                        </ul>
            
            </li>
          <?php } } ?>
          
          
          
          <?php  if($this->Session->read('Auth.Client.User.user_type')!='C') { ?>
          <li><?php echo $this->Html->link("employers",'#'); ?>
          
          <ul class="sub_menu">
            <li>
            <?php // pr(Auth.Client);die;
			if($this->Session->read('Auth.Client.employerContact.id')=='' && $this->Session->read('Auth.Client.Candidate.id')==''){ 
			 echo $this->Html->link("Employer Dashboard",array('controller'=>'users','action'=>'login','Jobseeker'=>false),array('escape'=>false)); 
			}
			else {
			 if($this->Session->read('Auth.Client.Candidate.id')==''){ 
			 echo $this->Html->link("Employer Dashboard",'/employers'); 
			}else{
			echo $this->Html->link("Employer Dashboard",array('controller'=>'users','action'=>'index','Jobseeker'=>false),array('escape'=>false));
			}
			}
			?>
            
            </li>
            
            <li><?php echo $this->Html->link("Recruit @ Techexpo",array('controller'=>'employers','action'=>'recruitattechexpo','Jobseeker'=>false)); ?></li>
            <li><?php echo $this->Html->link("Exhibitor Resources",'/employers/empexhibitor'); ?></li>
            <li><?php echo $this->Html->link("Press / Media Coverage",'/pressReleases'); ?></li>
           <li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>
             <li><?php echo $this->Html->link("Testimonials",'/testimonials'); ?></li> 
             <li><?php echo $this->Html->link("Contact Us",array('controller'=>'users','action'=>'contactUs','Jobseeker'=>false)); ?> </li> 
           	</ul>
          </li>
          <?php } ?>
          
          <li class="last"><?php echo $this->Html->link("partners",'#'); ?>
          
          	<ul class="sub_menu">
         
            <li><?php echo $this->Html->link("Continuing Education",'/training_schools'); ?></li>
            
            <li><?php echo $this->Html->link("Techexpo Exhibitors",array('controller'=>'users','action'=>'exihibitors','Jobseeker'=>false)); ?></li>
          	<li><?php echo $this->Html->link("Profile Exhibitors",array('controller'=>'employers','action'=>'empexhibitor','Jobseeker'=>false)); ?></li>
            <li><?php echo $this->Html->link("Testimonials",'/testimonials'); ?></li> 
            <li><?php echo $this->Html->link("Contact Us",array('controller'=>'users','action'=>'contactUs','Jobseeker'=>false)); ?> </li> 
           	</ul>
         </li>
         <li></li>
        </ul>
        <div style="width:50px;float:right"></div>
        <div class="clear"></div>
      </div>
      <div class="social_icon">
        <ul>
                 <li><?php echo $this->Html->link($this->Html->image('images/face.jpg'),'http://www.facebook.com/techexpotopsecret',array('escape'=>false,'target'=>'_blank'));?></li>
        <li><?php echo $this->Html->link($this->Html->image('images/twitt.jpg'),'http://twitter.com/TechExpoJobFair',array('escape'=>false,'target'=>'_blank'));?></li>
        <li><?php echo $this->Html->link($this->Html->image('images/link.jpg'),'http://www.linkedin.com/groups?gid=113669',array('escape'=>false,'target'=>'_blank'));?></li>
        <li class="last"><?php echo $this->Html->link($this->Html->image('images/goplus.jpg'),'https://plus.google.com/share?url=techexpousa.com',array('escape'=>false,'target'=>'_blank'));?>
        </li>

        </ul>
        <div class="clear"></div>
      </div>
      <div class="clear"></div>
    </div>
    <?php $actionURL2=$this->params->params['controller'].'/'.$this->params->params['action'];
     if($actionURL2=='users/index') { ?>
     <div class="clear"></div>
      <?php 
	if($this->Session->read('Auth.Clients.user_type')=='C')
	{
		echo $this->element('jobSeekerMenu', array('cache' => true));
		
	}
	
	if($this->Session->read('Auth.Clients.user_type')=='E')
	{
		 echo $this->element('employer_tabs');
	}
	
	
	 }
 	?>
     
  </div>
</div>
<div id="wrapper_outer">
  <div id="wrapper">
    
    <div id="container">
      <div class="new_event_page">
        <div class="new_event_mid">
          <div class="new_event_top">
            <div class="new_event_bot">
              <h1 class="bluecolor" style="padding-top:80px;"> 
Techexpo: The requested URL was not found on this server.
</h1>
              
            </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      </div>
  </div>
  <div id="foo_wrapper">

 

<div id="wrapper">
  <div class="foo_lf">
	<ul>
	  <li><?php echo $this->Html->link("Home",'/'); ?> l
	  <?php echo $this->Html->link("About Us",'/about_us'); ?> l 
	   <?php echo $this->Html->link("Why Attend",array('controller'=>'users','action'=>'whyAttend','Jobseeker'=>false)); ?> l 
	  <?php echo $this->Html->link("Testimonials",'/testimonials'); ?> l 
	  <?php echo $this->Html->link("Contact Us",array('controller'=>'users','action'=>'contactUs','Jobseeker'=>false)); ?> 
      l 
	  <?php echo $this->Html->link("Privacy Policy",array('controller'=>'users','action'=>'privacypolicy','Jobseeker'=>false)); ?> 
     
	 </li>
	</ul>
	<p class="copyright">Copyright © 2013 TECHEXPO Top Secret  <br />
276 Fifth Avenue, Suite 906 - New York, NY 10001 <br />
Tel: 212-655-4505 ext. 224 <br />
Site by:   <a href="http://seobrand.com/" target="_blank">SEOBrand.com  </a>  / <a href=" http://businesstech.fr" target="_blank">Business Tech  </a>
 <br />
	 <!-- <?php echo $this->Html->link("Privacy Policy",array('controller'=>'users','action'=>'privacypolicy','Jobseeker'=>false)); ?>
      - site by <?php echo $this->Html->link('Seobrand.com','http://www.Seobrand.com',array('escape'=>false,'target'=>'_blank'));?>-->
      
      </p>
  
  </div>
  <div class="foo_rt">
	<ul>
        <li><?php echo $this->Html->link($this->Html->image('images/face.jpg'),'http://www.facebook.com/techexpotopsecret',array('escape'=>false,'target'=>'_blank'));?></li>
        <li><?php echo $this->Html->link($this->Html->image('images/twitt.jpg'),'http://twitter.com/TechExpoJobFair',array('escape'=>false,'target'=>'_blank'));?></li>
        <li><?php echo $this->Html->link($this->Html->image('images/link.jpg'),'http://www.linkedin.com/groups?gid=113669',array('escape'=>false,'target'=>'_blank'));?></li>
        <li class="last"><?php echo $this->Html->link($this->Html->image('images/goplus.jpg'),'https://plus.google.com/share?url=techexpousa.com',array('escape'=>false,'target'=>'_blank'));?>
        </li>
	</ul>
	<div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
</div> 
</div>
</body>
</html>
