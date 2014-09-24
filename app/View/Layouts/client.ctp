<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TechExpo USA :<?php echo isset($meta_title) ? $meta_title : ''; ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
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
<link rel="shortcut icon" href="<?php echo FULL_BASE_URL.router::url('/',false).'app/webroot/favicon.ico'; ?>" type="image/x-icon"/>
<!-- scripts (jquery) -->
<?php 
echo $this->Html->script('functions.js');
echo $this->Html->script('jquery-1.4.2.min');
echo $this->Html->script('jquery-ui-1.8.custom.min');

?>
<!--[if IE]><?php echo $this->Html->
script('excanvas.min'); ?>
<![endif]-->
<!-- scripts (custom) -->
<?php 
echo $this->Html->script('smooth');
echo $this->Html->script('smooth.menu');
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
<!-- header -->
<div id="header">
  <!-- logo -->
  <div id="logo">
    <h1><a href="#" title="TechExpo Admin Panel" alt="TechExpo Admin Panel">
      <?php //echo $this->Html->image('logo.png',array('alt'=>'Kings Admin Panel','alt'=>'Kings Admin Panel'));?>
      <h1 class="logo"><span>TechExpo Admin Panel</span></h1>
      </a></h1>
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
          <li><?php echo $this->Html->link('System & Show Manager',array('#'),array('class'=>'childs')); ?>
            <ul>
              <li><?php echo $this->Html->link('Locations',array('controller'=>'locations','action'=>'index')); ?></li>
              <li><?php echo $this->Html->link('Shows',array('controller'=>'shows','action'=>'index')); ?></li>
              <li><?php echo $this->Html->link('Codes',array('controller'=>'codes','action'=>'index')); ?></li>
            </ul>
          </li>
          <li><?php echo $this->Html->link('Generate Show Book',array('controller'=>'codes','action'=>'index')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('script.png',array('alt'=>'Home')).'</span><span>Content Management</span>',array('#'),array('escape'=>false)); ?>          
        <ul>
          <li><?php echo $this->Html->link('Homepage Shows',array('controller'=>'showsHomes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Homepage Expo Team message',array('controller'=>'homepageDynamicContents','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Homepage Announcements',array('controller'=>'homepageMessages','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Upload event pictures',array('controller'=>'pixes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Upload press releases',array('controller'=>'pressReleases','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Training Schools Manager',array('controller'=>'training_schools','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Testimonials Manager',array('controller'=>'testimonials','action'=>'index')); ?></li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('world_link.png',array('alt'=>'Home')).'</span><span>Marketing</span>',array('#'),array('escape'=>false)); ?>          
        <ul>
          <li><?php echo $this->Html->link('Special Partner Tracking',array('controller'=>'codes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Export Resumes',array('controller'=>'codes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Banner Management',array('#'),array('class'=>'childs')); ?>
            <ul>
              <li><?php echo $this->Html->link('Manage Banners',array('controller'=>'codes','action'=>'index')); ?></li>
              <li><?php echo $this->Html->link('Banner Reports',array('controller'=>'codes','action'=>'index')); ?></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('user.png',array('alt'=>'Home')).'</span><span>Clients</span>',array('#'),array('escape'=>false)); ?>
        <ul>
          <li><?php echo $this->Html->link('Client Manager',array('controller'=>'codes','action'=>'index')); ?> </li>
          <li><?php echo $this->Html->link('View Exhibitor List',array('controller'=>'codes','action'=>'index')); ?> </li>
          <li><?php echo $this->Html->link('New Client',array('controller'=>'codes','action'=>'index')); ?> </li>
          <li><?php echo $this->Html->link('Resume Database Counts',array('controller'=>'codes','action'=>'index')); ?> </li>
          <li><?php echo $this->Html->link('Resume Search Trial Account',array('controller'=>'codes','action'=>'index')); ?> </li>
          <li><?php echo $this->Html->link('Trial Account Tracker',array('controller'=>'trialAccountsTracks','action'=>'index')); ?> </li>
        </ul>
      </li>      
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('user_red.png',array('alt'=>'Home')).'</span><span>Candidates</span>',array('#'),array('escape'=>false)); ?>          
        <ul>
          <li><?php echo $this->Html->link('Paperless Candidate Processing',array('controller'=>'codes','action'=>'index')); ?> </li>
          <li><?php echo $this->Html->link('Upload Resumes',array('controller'=>'codes','action'=>'index')); ?> </li>
          <li><?php echo $this->Html->link('Candidate Mass E-mail',array('controller'=>'codes','action'=>'index')); ?> </li>
          <li><?php echo $this->Html->link('CD Inclusion',array('controller'=>'codes','action'=>'index')); ?> </li>
          <li><?php echo $this->Html->link('Candidate Login Lookup',array('controller'=>'codes','action'=>'index')); ?> </li>
        </ul>
      </li>
      <li><?php echo $this->Html->link('<span class="icon">'.$this->Html->image('page_white_copy.png',array('alt'=>'Home')).'</span><span>Static</span>',array('#'),array('escape'=>false)); ?>          
        <ul>
          <li><?php echo $this->Html->link('Employer site usage',array('controller'=>'codes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Last Employer logins',array('controller'=>'employerLastVisits','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Site Wide Resume',array('controller'=>'codes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Detailed Traffic',array('controller'=>'codes','action'=>'index')); ?></li>
          <li><?php echo $this->Html->link('Pre-Registrations',array('controller'=>'codes','action'=>'index')); ?></li>
        </ul>
      </li>
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
    <div class="box">
	  <?php echo $this->element('admin_msg'); ?>
      <div class="breadcrumb"><?php echo $this->element('breadcrumb-topcode');?></div>
      <?php echo $content_for_layout; ?>
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
<div style="font-size:16px"> <?php echo $this->element('sql_dump'); ?></div>
<?php echo $this->Html->script("tiny_mce/tiny_mce.js"); ?>
<script language="javascript" type="text/javascript">
	<?php 
	if($preset = "basic")
	{
		$options = '
		mode : "textareas",
		elements : "ajaxfilemanager",
		theme : "advanced",
		editor_deselector : "mceNoEditor",
		plugins : "advimage,advlink,table,media,contextmenu",    
		theme_advanced_buttons1 : "bold,italic,underline,separator,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,outdent,indent,image,code,cut,copy,paste",
		theme_advanced_buttons2 : "fontselect,fontsizeselect,forecolor,backcolor,cleanup,removeformat",
		theme_advanced_buttons3 : "tablecontrols",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		file_browser_callback : "ajaxfilemanager",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		content_css : "/css/'.$this->layout.'.css"    
		';
	}
	?>

		tinyMCE.init({<?php echo($options); ?>});
		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "<?php echo FULL_BASE_URL.Router::url('/', false);?>js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					break;
				case "media":
					break;
				case "flash": 
					break;
				case "file":
					break;
				default:
					return false;
			}
            tinyMCE.activeEditor.windowManager.open({
                url: "<?php echo FULL_BASE_URL.Router::url('/', false);?>js/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",
                width: 752,
                height: 500,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
            
		}

</script>

</body>
</html>