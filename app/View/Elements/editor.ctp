<?php echo $this->Html->script("tiny_mce/tiny_mce.js");?>
<script language="javascript" type="text/javascript">
<?php 
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
    extended_valid_elements : "a[name|href|target|title|onclick],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
    content_css : "'.FULL_BASE_URL.Router::url('/',false).'css/styles_front.css"    
    ';
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