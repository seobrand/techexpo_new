<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TechExpo Admin Panel :<?php echo isset($meta_title) ? $meta_title : ''; ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=8" >

<link rel="SHORTCUT ICON" href="<?php echo BASE_URL; ?>/img/favicon.ico">
<!-- stylesheets -->
<?php 
echo $this->Html->css('reset');
echo $this->Html->css('style');
?>
<!--[if IE 7]>
<?php echo $this->Html->css('ie7'); ?>
<![endif]-->
<?php
echo $this->Html->css('blue'); 
/*echo $this->Html->script('Calendar.js');
echo $this->Html->css('Calendar.css');*/
echo $this->Html->script('jq-cal/jquery.js');
echo $this->Html->script('jq-cal/jquery-ui.js');
echo $this->Html->css('jq-cal/smoothness/jquery-ui.css');
?>

<!-- scripts (jquery) -->
<?php 
echo $this->Html->script('functions.js');
echo $this->Html->script('jquery-1.4.4.min');
//echo $this->Html->script('jquery-ui-1.8.custom.min');

?>
<!--[if IE]><?php echo $this->Html->
script('excanvas.min'); ?>
<![endif]-->
<!-- scripts (custom) -->
<?php 
//echo $this->Html->script('smooth');
//echo $this->Html->script('smooth.menu');
?>
<?php if($this->Session->read('popup')) {?>
</head>
<body onload="javascript:autoClick()">
<?php } else {?>
</head>
<body>
<?php } ?>
<input type="hidden" value="<?php echo $this->Session->check('popup') ?  $this->Session->read('popup') : 'no'; ?>" id="popcheck" />
<script language="javascript">
function goto_club() {
if(document.getElementById('popup_check').value=='yes') {
	document.getElementById('closethisLink').click();	
	document.getElementById('popup_check').value = 'no';
 } 
 }
window.setInterval(function(){
if(document.getElementById('popcheck').value != 'no') {
  goto_club();
  }
}, 5000);
</script>
<script type="text/javascript">
	function isNumericKey(e)
	{
		if (window.event) { var charCode = window.event.keyCode; }
		else if (e) { var charCode = e.which; }
		else { return true; }
		if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; }
		return true;
	}
	</script>
<!-- header -->
<div id="header">
  <!-- logo -->
  <div id="logo">
   <h1>
  <?php echo $this->Html->link('TechExpo Admin Panel',array('controller'=>'adminusers','action'=>'home'),array('escape'=>false,'title'=>'TechExpo Admin Panel','alt'=>'TechExpo Admin Panel')); ?>
   </h1>
  </div>
  <!-- end logo -->
  <!-- user -->
  <?php if($this->Session->check('Auth.User.Adminuser.username')) { ?>
  <ul id="user1">
    <li>
      <table cellpadding="0" cellspacing="0" border="0" style="margin-right:10px;">
        <tr>
          <td><strong>Hello <?php echo ucfirst($this->Session->read('Auth.User.Adminuser.first_name')); ?> |</strong> <?php echo $this->Html->link('Logout',array('controller'=>'adminusers','action'=>'logout')); ?><b> | Server Date :
            <?=date('d M Y')?>
            </b></td>
        </tr>
      </table>
    </li>
  </ul>
  <?php } ?>
  <!-- end user -->
  <div id="header-inner">
    <?php if($this->Session->check('Auth.User.Adminuser.username')) { ?>
    <!-- quick -->
    <ul id="quick">
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('home.png',array('alt'=>'Home')).'</span><span>Dashboard</span>',array('controller'=>'adminusers','action'=>'home'),array('escape'=>false)); ?></li>
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('award_star_bronze_1.png',array('alt'=>'Admin')).'</span><span>Admin</span>','#',array('escape'=>false));?>
        <ul>
          <li><?php echo $this->Html->link('System Manager',array('#'),array('class'=>'childs')); ?>
            <ul>
              <li><?php echo $this->Html->link('Locations',array('controller'=>'locations','action'=>'index')); ?></li>
             <?php /*?> <li><?php echo $this->Html->link('Shows',array('controller'=>'shows','action'=>'index')); ?></li><?php */?>
              <li><?php echo $this->Html->link('Codes',array('controller'=>'codes','action'=>'index')); ?></li>
              <li><?php echo $this->Html->link('Sets',array('controller'=>'sets','action'=>'index')); ?></li>              
            </ul>
          </li>
          <li><?php echo $this->Html->link('Generate Show Book',array('controller'=>'generate_show_books','action'=>'index')); ?></li>
		  <li><?php echo $this->Html->link('Order Management',array('#'),array('class'=>'childs')); ?>
		  	<ul>
              <li><?php echo $this->Html->link('Manage Job Plan',array('controller'=>'orders','action'=>'index')); ?></li>
              <li><?php echo $this->Html->link('View Job Plan History',array('controller'=>'orders','action'=>'viewhistory')); ?></li>
            </ul>
		  </li>
          <li><?php echo $this->Html->link('Block Ip Address',array('controller'=>'IpBlocks','action'=>'blockip')); ?></li>
          <li><?php echo $this->Html->link('System Variable',array('controller'=>'system_variables','action'=>'index')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('script.png',array('alt'=>'Home')).'</span><span>Content Management</span>',array('#'),array('escape'=>false)); ?>          
        <ul>
          <li><?php echo $this->Html->link('Homepage Shows',array('controller'=>'showsHomes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Homepage Expo Team message',array('controller'=>'homepageDynamicContents','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Dashboard Announcements',array('controller'=>'homepageMessages','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Upload event pictures',array('controller'=>'pixes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Upload press releases',array('controller'=>'pressReleases','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Training Schools Manager',array('controller'=>'training_schools','action'=>'index')); ?></li>
          <li><a href="javascript:void(0);">Testimonials Manager</a>
          		<ul>
                	<li><?php echo $this->Html->link('Testimonials Manager',array('controller'=>'testimonials','action'=>'index')); ?>
                    </li>
                    <li>
                    	<?php echo $this->Html->link('Testimonials approval List',array('controller'=>'testimonials','action'=>'testimonailApproval')); ?>
                    </li>
                   
                </ul>
          </li>
		  <li><?php echo $this->Html->link('Update Candidate Mass E-mail Message Footers',array('controller'=>'admincandidates','action'=>'candidateEmailMessage')); ?></li>
		  <li><?php echo $this->Html->link('Email Template',array('controller'=>'emailTemplates','action'=>'index')); ?></li>
		  <li><?php echo $this->Html->link('Privacy Policy',array('controller'=>'testimonials','action'=>'privacyPolicy')); ?></li>
		  <li><?php echo $this->Html->link('Terms Of Use',array('controller'=>'testimonials','action'=>'termsOfUse')); ?></li>
          <li><?php echo $this->Html->link('Resume Writing',array('controller'=>'testimonials','action'=>'resumewriting')); ?></li>
           <li><?php echo $this->Html->link('Why Attend',array('controller'=>'testimonials','action'=>'whyattend')); ?></li>
           <li><?php echo $this->Html->link('Recruit With Us',array('controller'=>'testimonials','action'=>'recruitwithus')); ?></li>
          <li><?php echo $this->Html->link('Job posting',array('controller'=>'testimonials','action'=>'jobposting')); ?></li>
           
           <li><?php echo $this->Html->link('Manage Photo Gallery',array('controller'=>'photo_galleries','action'=>'index')); ?></li>
           <li><?php echo $this->Html->link('Exhibitor Manager',array('controller'=>'exhibitors','action'=>'index')); ?></li>
           <li><?php echo $this->Html->link('Marketing Partner',array('controller'=>'marketing_exhibitors','action'=>'index')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('world_link.png',array('alt'=>'Home')).'</span><span>Marketing</span>',array('#'),array('escape'=>false)); ?>          
        <ul>
          <li><?php echo $this->Html->link('Special Partner Tracking',array('controller'=>'marketings','action'=>'index')); ?></li>
		  <li><?php echo $this->Html->link('Home Page Scroll',array('controller'=>'partners','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Export Resumes',array('controller'=>'ExportResumes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Banner Management',array('#'),array('class'=>'childs')); ?>
            <ul>
              <li><?php echo $this->Html->link('Manage Banners',array('controller'=>'banners','action'=>'index')); ?></li>
              <li><?php echo $this->Html->link('Banner Reports',array('controller'=>'banner_reports','action'=>'index')); ?></li>
              <li><?php echo $this->Html->link('Other Banner',array('controller'=>'other_banners','action'=>'index')); ?></li>
            </ul>
          </li>
          <li><?php echo $this->Html->link('Download Email Subscriptions',array('controller'=>'newsletters','action'=>'index')); ?></li>
          
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('user.png',array('alt'=>'Home')).'</span><span>Clients</span>',array('#'),array('escape'=>false)); ?>
        <ul>
          <li><?php echo $this->Html->link('Client Manager',array('controller'=>'clients','action'=>'clientmanager')); ?> </li>
          <li><?php echo $this->Html->link('View Exhibitor List',array('controller'=>'clients','action'=>'viewexhibitorlist')); ?> </li>
          <li><?php echo $this->Html->link('New Client',array('controller'=>'clients','action'=>'addnewclient')); ?> </li>
   
		  <li><?php echo $this->Html->link('Send Resumes to Clients',array('controller'=>'clients','action'=>'sendresume')); ?></li>
          <li><?php echo $this->Html->link('Create Trial Account',array('controller'=>'clients','action'=>'createtrailaccount')); ?> </li>
          <li><?php echo $this->Html->link('Trial Account Tracker',array('controller'=>'clients','action'=>'trialaccounttracker')); ?> </li>
          <li><?php echo $this->Html->link('Company Videos',array('controller'=>'clients','action'=>'clientvideo')); ?> </li>
        </ul>
      </li>      
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('user_red.png',array('alt'=>'Home')).'</span><span>Candidates</span>',array('#'),array('escape'=>false)); ?>          
        <ul>
      
        
          <li><?php echo $this->Html->link('Search',array('controller'=>'admincandidates','action'=>'candidateInfo')); ?> </li>
           <li><?php echo $this->Html->link('Upload Resume',array('controller'=>'admincandidates','action'=>'uploadResumeStep1')); ?> </li>
          <li><?php echo $this->Html->link('Paperless Candidate Processing',array('controller'=>'admincandidates','action'=>'unregisterCandidate')); ?> </li>
          <li><?php echo $this->Html->link('Candidate Mass E-mail',array('controller'=>'admincandidates','action'=>'registerCandidateMassEmail')); ?> </li>
          
           <li><?php echo $this->Html->link('Mass e-mail Invite',array('controller'=>'admincandidates','action'=>'invitationToCandidate')); ?> </li>
          
          <li><?php echo $this->Html->link('Resumes to BluePoint',array('controller'=>'admincandidates','action'=>'mailResume')); ?> </li>
          <li><?php echo $this->Html->link('Candidate Videos',array('controller'=>'admincandidates','action'=>'candidatevideo')); ?> </li>
          <li><?php echo $this->Html->link('Email History',array('controller'=>'admincandidates','action'=>'emailhistory')); ?> </li>
         
        <!--  <li><?php echo $this->Html->link('Upload Resumes',array('controller'=>'codes','action'=>'index')); ?> </li>
        
          
          <li><?php echo $this->Html->link('Candidate Login Lookup',array('controller'=>'codes','action'=>'index')); ?> </li>-->
        </ul>
      </li>
      <?php /*
	  <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('newletter.png',array('alt'=>'Newsletter')).'</span><span>Newsletter</span>',array('#'),array('escape'=>false)); ?>
	  	<ul>
          <li><?php echo $this->Html->link('Newsletter Subscribers',array('controller'=>'newsletters','action'=>'index')); ?></li>
        <li><?php echo $this->Html->link('Send Newsletter',array('controller'=>'newsletters','action'=>'sendnewsletter')); ?></li>
		</ul>
	  </li>
	  */ ?>
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('page_white_copy.png',array('alt'=>'Home')).'</span><span>Statistics</span>',array('#'),array('escape'=>false)); ?>          
        <ul>
<li><?php echo $this->Html->link('Employer site usage',array('controller'=>'EmployerSiteUsages','action'=>'index')); ?></li>
<li><?php echo $this->Html->link('Last Employer logins',array('controller'=>'employerLastVisits','action'=>'index')); ?></li>
<li><?php echo $this->Html->link('Site Wide Resume',array('controller'=>'SiteWideResumes','action'=>'index')); ?></li>
<li><?php echo $this->Html->link('Detailed Traffic',array('controller'=>'DetailedTrafficStats','action'=>'index')); ?></li>
<li><?php echo $this->Html->link('Pre-Registrations',array('controller'=>'PreRegistrations','action'=>'index')); ?></li>
<li><?php echo $this->Html->link('Resume Database Counts',array('controller'=>'clients','action'=>'resumedbcount')); ?> </li>
        </ul>
      </li>
      
      <?php /*
      <li>
	  <a href="#"><span class="icon"><?php echo  $this->Html->image('page_white_copy.png',array('alt'=>'Chat')); ?></span><span>Chat</span></a>
	           
        <ul  style="width:100px!important;">
          <li><?php echo $this->Html->link('Chat Groups',array('controller'=>'chats','action'=>'chatgroup')); ?></li>
          <li ><?php echo $this->Html->link('Current User',array('controller'=>'chats','action'=>'users')); ?></li>
           <li ><?php echo $this->Html->link('Chat History',array('controller'=>'chats','action'=>'chathistory')); ?></li>

        </ul>
      </li>
      */ ?>
    </ul>
    <?php } ?>
    <!-- end quick -->
    <div class="corner tl"></div>
    <div class="corner tr"></div>
  </div>
</div>
<!-- end header -->
<!-- content -->
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="box"> <?php echo $this->element('admin_msg'); ?>
      <div class="breadcrumb"><?php echo $this->element('breadcrumb-topcode');?></div>
      <div class="content">
        <div id="right">
          <div class="box" style="height:250px;"> 
          <h1 class="bluecolor" style="margin-left:200px;padding-top:80px;"> 
Techexpo: The requested URL was not found on this server.
</h1>
          
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end content / right -->
</div>
<!-- end content -->
<!-- footer -->
<div id="footer">
  <p>&copy;<?php echo date('Y'); ?> Copyright TechExpo USA. All rights reserved.</p>
</div>
<!-- end footert -->
<div style="font-size:16px">
  <?php //echo $this->element('sql_dump'); ?>
</div>
</body>
</html>
