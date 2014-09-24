<?php echo $this->Html->script('jquery.pajinate.js');?>
<script type="text/javascript">
function setupselect(select_photo_url)
{
	parent.document.getElementById('<?php echo $parentWindowId?>_photo_gallery_image').value=select_photo_url;
	parent.document.getElementById('<?php echo $parentWindowId?>_selected_photo').innerHTML=select_photo_url;	
	parent.$.colorbox.close();
	return false;
}

var jk = jQuery.noConflict();			
jk(document).ready(function(){
	jk('#paging_container8').pajinate({
		start_page : 0,
		items_per_page : 10	
	});
});	

function submitform(){
	jk('#photocategoryform').submit();
}			           
</script>
<style type="text/css">
#paging_container8 .no_more{
    background-color: white;
    color: gray;
    cursor: default;
}

.ellipse{
	float: left;
}

.page_navigation , .alt_page_navigation{
	padding-bottom: 10px;
	
}

.page_navigation a, .alt_page_navigation a{
	padding:3px 5px;
	margin:2px;
	color:white;
	text-decoration:none;
	float: left;
	font-family: Tahoma;
	font-size: 12px;
	background-color:#706C6C;
}
.active_page{
	background-color:white !important;
	color:black !important;
}	

.content, .alt_content{
	color: black;
}

.content li, .alt_content li, .content > p{
	/*padding: 5px*/
}
</style>


<!-- container start -->
<div class="container">
  <div class="container_top">
    <div class="container_bottom">
    	<table width="100%">
			<tr>
				<td width="50%" align="left">
          			<h4>Browse Photo Gallery</h4>
				</td>
			</tr>
		</table>
            
       <?php echo $this->Form->create('PhotoCategory',array('id'=>'photocategoryform'));?>       
        <table width="100%" border="0" cellpadding="5" cellspacing="5" class="search_bar">
          <tr>
            <td width="14%" align="center" class="noborder"><b>Search Criteria :</b></td>
            <td class="noborder" align="left" width="60%">
            <?php $categories = $common->getAllPhotoCategory();?>
            <?php echo $this->Form->input('photo_category',array('type'=>'select','options'=>$categories,'empty'=>'-Select Category-','div'=>false,'label'=>false,'onchange'=>'submitform()'));?>
            </td>            
           <span id="busyspn" style="display:none;"><?php echo $this->Html->image('front/loading_new.gif',array('style'=>'width:30px;'));?></span>
          </tr>
        </table>
        <?php echo $this->Form->end();?>
        
      <div id="main_table">
      <div id="searchresult">
       <table width="100%" class="date_table">
       <?php if(count($galleries)==0){ ?>        
          <tr>
            <td  colspan="6" class="errorMsg"><?php echo 'No photo available in gallery.'; ?></td>
          </tr>        
        <?php } else{ ?>
   		<tr>
        <td align="center">
       <ul class="gallery-list">
		<?php  
		  foreach($galleries as $gallery):
		  if(isset($gallery['PhotoGallery']['image']) && $gallery['PhotoGallery']['image']!='' && file_exists(WWW_ROOT.'img/photo_gallery/'.$gallery['PhotoGallery']['image'])){
		  ?>         
			<li style="display:inline; text-align:center;  float:left;  font:bold 13px Arial, Helvetica, sans-serif; color:#fff;">
               <div style="width:170px; margin:0 0 20px 0; text-align:center;">
                  <img src="<?php echo FULL_BASE_URL.router::url('/',false).'img/photo_gallery/'.$gallery['PhotoGallery']['image']; ?>" width="140px" height="160px" style="border:1px solid #666;" onclick="setupselect('<?php echo $gallery['PhotoGallery']['image'];?>')"/>
               </div>
	        </li>
	    <?php } endforeach; ?>
	  </ul>
        
        </td>
      </tr>
     
      </tbody>
      </table>
        <?php } ?>
      </div>
      </div>
    </div>
  </div>
</div>

<!-- container end -->