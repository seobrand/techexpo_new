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
echo $this->Html->css('jq-cal/smoothness/jquery-ui.css');
?>
<!-- scripts (jquery) -->
<?php 
echo $this->Html->script('functions.js');
echo $this->Html->script('jquery-1.4.4.min');
?>
<!--[if IE]><?php echo $this->Html->
script('excanvas.min'); ?>
<![endif]-->
<!-- scripts (custom) -->

</head>
<body>

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

<!-- content -->
<div class="content colorbox">
  <!-- content / right -->
  <div id="right2">
    <div class="box">	  
      <?php echo $content_for_layout; ?>
	</div>
  </div>
  <!-- end content / right -->
</div>
<!-- end content -->
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