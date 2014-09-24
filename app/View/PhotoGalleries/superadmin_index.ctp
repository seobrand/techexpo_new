<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php echo $this->Html->css("colorbox");?>
<?php echo $this->Html->script('plugins/jquery.colorbox');?>
<script>
//Examples of how to assign the Colorbox event to elements
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('.addiframe').colorbox({iframe:true,  width:"60%", height:"46%"});
	jQuery('.editiframe').colorbox({iframe:true,  width:"60%", height:"65%"});		
});
</script>	
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
        <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Photo Gallery List</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
          <!-- box / title -->
          
<div class="display_row">
  <div class="table">
  <table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
      <tbody>
        <tr>
          <td align="left" valign="middle"><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add Photo" name="assign">',array('controller'=>'photo_galleries','action'=>'add'),array('escape'=>false,'class'=>'addiframe')); ?></td>
		</tr>
      <td> 
     	<ul class="gallery-list">
           <?php foreach($photolist as $photo){?>   
           <?php $img_loc = WWW_ROOT."img/photo_gallery/".$photo['PhotoGallery']['image']; ?>  
           <?php if(file_exists($img_loc)){?>    
			<li>
				<a href="<?php echo Router::url('/')?>superadmin/photo_galleries/edit/<?php echo $photo['PhotoGallery']['id'];?>" class="editiframe">
					<img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'img/photo_gallery/'.$photo['PhotoGallery']['image'];?>&maxw=140&maxh=160">
				</a>
			</li>
			<?php }?>
			<?php } // if file exist?>
		  </ul>        
         </td></tr>
      
      </tbody>
    </table>
  </div>
</div>
</div>
<!-- end table --> 
</div>
</div>
</div>
<!-- end content / right -->
</div>
<?php //if(count($pressreleases)):?>
<div style="clear:both; margin: 5px 60px;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php //endif;?>
