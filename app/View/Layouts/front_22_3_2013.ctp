<?php
$Controlleraction=$this->request->params['controller'].'_'.$this->request->params['action'];
 $Controlleraction;
 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=8" >
<link rel="SHORTCUT ICON" href="<?php echo BASE_URL; ?>/img/favicon.ico">

<title>TechExpo : <?php echo isset($meta_title) ? $meta_title : ''; ?></title>  
<!--end here-->
<?php 
    echo $this->Html->css('front_css/reset.css');
    echo $this->Html->css('front_css/style.css');
    echo $this->Html->css('front_css/dropdown.css');
?>
<script type="text/javascript">	 
	
	function autoClickFront() {
	   document.getElementById('thisLink').click();
	  
	}
	function closePopup(){
		document.getElementById("closelink").click()
	}
	function showClickFront(showMessage) {
	   document.getElementById('show_message').innerHTML = showMessage;
	   document.getElementById('thisLinkhere').click();
	}
	//window.setInterval('document.getElementById("closelink").click()', 5000);		 
</script>
<!-- Dropdown -->
	<!--[if lte IE 7]>
        <link rel="stylesheet" type="text/css" href="css/ie.css" media="screen" />
    <![endif]-->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<?php 
   echo $this->Html->script('front_js/jquery.dropdownPlain.js');
    echo $this->Html->script('front_js/cufon-yui.js');
    echo $this->Html->script('front_js/font_style.js');	
    echo $this->Html->script('front_js/Myriad_Pro_400.font.js');	
    echo $this->Html->script('front_js/Myriad_Pro_600.font.js');	
    //echo $this->Html->script('front_js/jquery.js');
    //echo $this->Html->script('front_js/easySlider1.7.js');
    echo $this->Html->script('front_js/css_browser_selector.js');
	echo $this->Html->script('front_js/chat/jquery.scrollTo-min.js');
//	echo $this->Html->script('front_js/chat/chatfunctions.js');

?> 
<script type="text/javascript">
var SITE_PATH = "<?php echo $this->webroot; ?>";
</script>

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

<?php 
  //  echo $this->Html->script('front_js/lib/jquery.jcarousel.min.js');
   // echo $this->Html->css('front_css/skins/tango/skin.css');
?>
<!--
  jCarousel skin stylesheets
-->

<!-- Ended script scroller -->

<!-- Ended script scroller -->
<!-- Tab Panel Started from here-->

<!--<script src="jquery.js" type="text/javascript" charset="utf-8"></script>
-->
<?php   echo $this->Html->script('front_js/jquery.tabify.js'); ?>
<script type="text/javascript">
	// <![CDATA[
		
	$(document).ready(function () {
		$('#menu1').tabify();
		$('#menu2').tabify();
		

		
	});
			
	// ]]>
</script>

<!-- Tab Panel Started from here-->
<link href='http://fonts.googleapis.com/css?family=Homenaje' rel='stylesheet' type='text/css'>
<!-- Place this tag in your head or just before your close body tag. -->
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
</head>
<!-- Jitendra <Include the message_popup.ctp element file for shows popup in frontend> -->
<?php echo $this->element("message_popup");?>


<body <?php if($this->Session->read('popup')){?> onload="autoClickFront()" <?php } ?>>
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
          			<li><?php echo $this->Html->link("Press/Media Coverage",'/pressReleases'); ?></li>
                    <li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>
          		</ul>
          </li>
          <li><?php echo $this->Html->link("events",'/shows'); ?>
          
           	<ul class="sub_menu">
				<li><?php echo $this->Html->link("events",'/shows'); ?></li>            
           		<li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>
               
           	</ul>
          
          </li>
          
          
          <?php if($this->Session->read('Auth.Client.User.candidate_id')){ ?>
          <li><?php echo $this->Html->link("job seekers",array('controller'=>'candidates','action'=>'candidateprofile','Jobseeker'=>true)); ?>
          			<ul class="sub_menu">
                         
                            <li>
                            	<?php echo $this->Html->link("Tell a Friend", array('controller'=>'users','action'=>'tellaFriend'),array('class'=>'ajax','escape'=>false)); ?>
                            </li>
                            <li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>
                             <li> 
                            	<!--<?php echo $this->Html->link("Register", array('controller'=>'candidates','action'=>'register')); ?>-->
                               <a href="<?php echo FULL_BASE_URL.router::url('/',false); ?>jobseeker_register" >Register</a>
                            </li>
                            
                            <li> 
                            	<?php echo $this->Html->link("Resume Writing ", array('controller'=>'users','action'=>'resumewriting','3','Jobseeker'=>false)); ?>
                           		
                            </li>
                        </ul>
          </li>
          <?php } else{?>
			<li><?php echo $this->Html->link("job seekers",array('controller'=>'users','action'=>'login','Jobseeker'=>false)); ?>
            
            			<ul class="sub_menu">
                         
                            <li>
                            	<?php echo $this->Html->link("Tell a Friend", array('controller'=>'users','action'=>'tellaFriend'),array('class'=>'ajax','escape'=>false)); ?>
                            </li>
                            <li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>
                             <li> 
                            	
                               <a href="<?php echo FULL_BASE_URL.router::url('/',false); ?>jobseeker_register" >Register</a>
                            </li>
                            
                              
                            <li> 
                            	<?php echo $this->Html->link("Resume Writing ", array('controller'=>'users','action'=>'resumewriting','3')); ?>
                            </li>
                        </ul>
            
            </li>
          <?php } ?>
          
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
            
            <li><?php echo $this->Html->link("Recruit @Techexpo",array('controller'=>'employers','action'=>'recruitattechexpo')); ?></li>
            <li><?php echo $this->Html->link("Press/Media Coverage",'/pressReleases'); ?></li>
            <li><?php echo $this->Html->link("Exhibitor Resources",'/employers/empexhibitor'); ?></li>
            <li><?php echo $this->Html->link("Event Photos",'/pixes'); ?></li>
            
           
            
           	</ul>
          </li>
          <li class="last"><?php echo $this->Html->link("partners",'#'); ?>
          
          	<ul class="sub_menu">
         
            <li><?php echo $this->Html->link("Continuing Education",'/training_schools'); ?></li>
            
            <li><?php echo $this->Html->link("Techexpo Exhibitors",array('controller'=>'users','action'=>'exihibitors','Jobseeker'=>false)); ?></li>
          	<li><?php echo $this->Html->link("Profile Exhibitors",array('controller'=>'employers','action'=>'empexhibitor')); ?></li>
          
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
  </div>
  

</div>

<?php //pr($_SERVER); 
$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
/******** Insert Data inro employerStats for Emplyer Site usages History****/
// Code for creating employer History for diffrent pages
$prevpage = '';
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=''){
	$prevpage = end(explode("/",$_SERVER['HTTP_REFERER']));
	$referrar = $_SERVER['HTTP_REFERER'];
}else{
	$referrar  = BASE_URL."".$_SERVER['REQUEST_URI'];
}
$pagename  = "/".$this->params['action'];
$remoteAddress  = $_SERVER['REMOTE_ADDR'];

if(isset($employerID) && $employerID!=''){
	// make employer entry for last visit on site
	$common->saveEmployerLastVisit($employerID);
	// employer history for resume search page
	if($pagename=='/resumeSearchResult' && $prevpage=='employers'){
		if(empty($this->request->query['page'])===true){
			$common->saveEmployerPagesVisitHistory($employerID,$pagename,$remoteAddress,$referrar);
		}
	}
	// employer history for resume search page
	if($pagename=='/searchRegResult' && $prevpage=='searchRegCandidate'){
		if(empty($this->request->query['page'])===true){
			$common->saveEmployerPagesVisitHistory($employerID,$pagename,$remoteAddress,$referrar);
		}
	}
	// employer history for resume view page
	if($pagename=='/showResume'){
		$common->saveEmployerPagesVisitHistory($employerID,$pagename,$remoteAddress,$referrar);
	}
	
	// employer history for registered resume view page
	if($pagename=='/showRegisterResume'){
		$common->saveEmployerPagesVisitHistory($employerID,$pagename,$remoteAddress,$referrar);
	}
	
	// employer history for download resumes
	if($pagename=='/exportResume'){
		$common->saveEmployerPagesVisitHistory($employerID,$pagename,$remoteAddress,$referrar);
	}
	
	// employer history for Forwarding email
	if($pagename=='/mailResume'){
		$common->saveEmployerPagesVisitHistory($employerID,$pagename,$remoteAddress,$referrar);
	}
	
	// employer history for resume file to folders for mass email
	if($pagename=='/resumefiletofolder'){
		$common->saveEmployerPagesVisitHistory($employerID,$pagename,$remoteAddress,$referrar);
	}
}

/**** insert into webstat ********/
// Detailed Traffic history for jobdetail page ****/

if($pagename=='/Jobseeker_jobDetail' || $pagename=='/jobdetail'){
	$common->saveDetailedTrafficHistory($pagename,$remoteAddress,$referrar);
}
if($pagename=='/showRegisterResume'){
	$common->saveDetailedTrafficHistory($pagename,$remoteAddress,$referrar);
}
if($pagename=='/showResume'){
	$common->saveDetailedTrafficHistory($pagename,$remoteAddress,$referrar);
}
if($pagename=='/empexhibitor'){
	$common->saveDetailedTrafficHistory($pagename,$remoteAddress,$referrar);
}
if($pagename=='/register'){
	$common->saveDetailedTrafficHistory($pagename,$remoteAddress,$referrar);
}
if($pagename=='/Jobseeker_editprofile'){
	$common->saveDetailedTrafficHistory($pagename,$remoteAddress,$referrar);
}

/**** Get Home Page Banner ****/
$banner = $common->getHomePageBanner();
//pr($banner);
?>
<div id="<?php if($Controlleraction=='users_index' || $Controlleraction=='pressReleases_index' || $Controlleraction=='register' || $Controlleraction=='users_home') {?>wrapper_outer<?php }else{?>wrapper_outer1<?php }?>">
<?php if($Controlleraction=='users_index'){?>
<div class="manage_background">


<?php echo $this->element("top_banner");?>

</div>
<?php } ?>
<?php echo $this->fetch('content'); ?>

   <?php
	  
	   $actionURL=$this->params->params['controller'].'/'.$this->params->params['action'];
     if($actionURL!='users/index') { ?>
 	<br />
    <div class="footer-statics">
    <div  class="statics">
    
    	<ul>
        	<li style="width:300px;">
            	<span style="color:#595959">Total Jobs with Secuity Clearance : </span><span>
				<?php 
					echo $this->Number->format($common->totalJobWithSecurityClearances(), array(
										'before' => '',
										'places' => false,
										'escape' => false,
										'decimals' => false,
										'thousands' => ','));
				 ?>
            </li>
            <li style="width:195px;">
            
            	<span style="color:#595959"> Total Members :</span> <span>
             	<?php 
					echo $this->Number->format($common->totalMembers(), array(
										'before' => '',
										'places' => false,
										'escape' => false,
										'decimals' => false,
										'thousands' => ','));
				 ?>
			  </span>
            </li>
            <li style="width:400px;">
            	 <span style="color:#595959"> Total Candidate with Secuity Clearance :</span> <span>
				 <?php 
					echo $this->Number->format($common->candidateWithSecurityClearances(), array(
										'before' => '',
										'places' => false,
										'escape' => false,
										'decimals' => false,
										'thousands' => ','));
				 ?>
				</span>
            </li>
            
        	
        </ul>
    </div>
    </div>
   <?php  } ?>  
   
<div id="foo_wrapper">

 

<div id="wrapper">
  <div class="foo_lf">
	<ul>
	  <li><?php echo $this->Html->link("Home",'/'); ?> l
	  <?php echo $this->Html->link("About us",'/about_us'); ?> l 
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
<?php echo $this->element('sql_dump'); ?>
<?php //if($this->Session->read('popup')){?>
<!-- script for showing message popup box -->
<a href="#?w=400" rel="popup_name" class="poplight" style="display:none;"><input type="hidden" id="thisLink"/></a>
<?php if($this->Session->read('popup')) {?>
<div id="popup_name" class="popup_block"><?php echo $this->Html->image("images/close.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close'));?>
   <div id="show_message"><?php echo $this->Session->read('popup');
   		SessionComponent::delete('popup');
   ?></div>
</div>
<?php 
}
?>


<!-- script for showing message popup box -->
<a href="#?w=400" rel="popup_name_here" class="poplight" style="display:none;"><input type="hidden" id="thisLinkhere"/></a>
<?php /*if($this->Session->read('popup')) {*/?>
<div id="popup_name_here" class="popup_block"><?php echo $this->Html->image("images/close.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close'));?>
   <div id="show_message"></div>
</div>


<?php //} ?>

<a href="#?w=610" rel="postjobpopup_name" class="poplight" style="display:none;"><input type="hidden" id="postjob"/></a>
  <div id="postjobpopup_name" class="popup_block"><?php echo $this->Html->image("images/close.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close'));?>
   <div id="show_message" style="text-align:left">
    Sorry, your account has no more available job postings. If you would like to post a job, please upgrade to any one of our job plans by clicking the BUY NOW button.<br/><br/>
    <span style="float:right"> <?php echo $this->Html->link($this->Html->image('images/buynow.png'),array('controller'=>'jobplans','action'=>'index'),array('escape'=>false,'alt'=>'Buy Now','title'=>'Buy Now'));?></span>
	</div>
</div>

<a href="#?w=320" rel="registerpopup_name" class="poplight" style="display:none;"><input type="hidden" id="register"/></a>
  <div id="registerpopup_name" class="popup_block"><?php echo $this->Html->image("images/close.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close'));?>
   <div id="show_message" style="text-align:center">
     <?php echo $this->Html->link($this->Html->image("images/register-jobseeker.png"),'/jobseeker_register', array('escape' => false));?><br/><br/>
    <?php echo $this->Html->link($this->Html->image("images/register-employer.png"),array('controller'=>'employers','action'=>'profile'), array('escape' => false));?> 
 </div>
</div>


<script type="text/javascript">
function showPostJobPopup(){
	 document.getElementById('postjob').click();
}
function showRegisterPopup(){
	  document.getElementById('register').click();
}
</script>
</script>
<?php echo $this->Html->script('front_js/allowcharacter.js'); ?>
<?php 
//echo $this->Html->script('front_js/jquery-ui-1.7.2.custom.min.js');
echo $this->Html->script('front_js/jquery.colorbox.js');
echo $this->Html->css('front_css/colorbox.css');
?>
<script type="text/javascript">
$(function(){

	$(".ajax").colorbox({width:'650px', height:'370px'});
	 $(".ajax").colorbox({width:'650px', height:'370px'});
			
			<?php  $sessroom_id = $this->Session->read('Chat.room_id'); 
				if(empty($sessroom_id)){
			?>
			
			$('#content1').hide();
			$('#discussion_board').css({'height':'100px'});
			
			
			<?php }
			 if(isset($sessroom_id) && !empty($sessroom_id) ){ ?>
			
					$('#content').html(' ');
					var room_id = <?php echo $this->Session->read('Chat.room_id'); ?>;
					$.ajax({
					  type: "POST",
					  url: "<?php echo $this->webroot; ?>chats/enteruser",
					  data: { room_id: room_id },
					  success: function(data) {
						  if(data)
						 $('#content').append(data);
						 
						  }
						})
 			<?php } ?>
			
				$("#groupchat_id").change(function(){
					$('#content').html(' ');
					var room_id =$("#groupchat_id").val();
					$.ajax({
					  type: "POST",
					  url: "<?php echo $this->webroot; ?>chats/enteruser",
					  data: { room_id: room_id },
					  success: function(data) {
						  if(data)
						 $('#content').append(data);
						 	  $('#content1').show();
						 $('#discussion_board').css({'height':'358px'});
							  if(room_id=='')
							   {
								   $('#content1').hide();
								   $('#discussion_board').css({'height':'100px'});
								}
						  }
						})
 				   });
				
				
	
	
	});
</script>

</body>
</html>
