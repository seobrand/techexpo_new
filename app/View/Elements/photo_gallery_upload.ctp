<?php unset($this->request->data['PhotoGallery']['upload_photo']);?>
<?php echo $this->Html->css("colorbox");?>
<?php echo $this->Html->script('plugins/jquery.colorbox');?>
<span class="photo_selecter_span">
<?php $options = array('0'=>'Select from computer','1'=>'Select from photo gallery');?>
<?php echo $this->Form->input($radiofieldname,array('type'=>'radio','options'=>$options,'id'=>$id."_select",'default'=>'0','onchange'=>"showPhotoUploader(this.value,'".$id."')",'legend'=>false,'label'=>false));?>
<?php echo $this->Form->input("",array('name'=>$name,'type'=>'hidden','id'=>$id.'_photo_gallery_image','value'=>''));?>
</span>
<div style="display: none;" id="<?php echo $id?>_uploader" class="photo_browse_button">
<?php echo $this->Html->link('Browse from Gallery',array('controller'=>'photo_galleries','action'=>'photouploader',$id),array('escape'=>false,'class'=>'iframe ui-state-default'));?>
<br/><br/>
<span id="<?php echo $id?>_selected_photo" class="photo_gallery_url"></span>
</div>
<script>	
	$(document).ready(function(){
		$(".iframe").colorbox({iframe:true, width:'70%', height:'70%'});
	});	
</script>
<script type="text/javascript">
function showPhotoUploader(val,inputid){
	if(val==1){
		$('#'+inputid).hide();
		$('#'+inputid+'_uploader').show();
	}else{
		$('#'+inputid).show();
		$('#'+inputid+'_uploader').hide();
	}
}
</script>