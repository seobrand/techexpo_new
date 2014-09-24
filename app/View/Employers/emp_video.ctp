<?php   
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
?>
<script type="text/javascript">

$(document).ready(function() {
	
	$(".ajax").colorbox();
	//$(".inline").colorbox({inline:true, width:"40%"});
			
	 $("#direct_upload").hide();
	   $("#youtube_video").hide();
	// for video section
  	 $("#EmployerVideoType").change(function(){
       var video_type = $("#EmployerVideoType").val();
	   //alert(video_type);return false;
	   if(video_type == 'youtube')
	   {
	   $("#direct_upload").hide();   
	   $("#youtube_video").show('500');
	   }
	   else if((video_type == 'upload'))
	   {
	   $("#youtube_video").hide();	   
	   $("#direct_upload").show('500');
	   }
	   else 
	   {
	   $("#direct_upload").hide();
	   $("#youtube_video").hide();
	    }
	});

	
	
});
   
function validate()
{
	var descrp = $.trim($('#EmployerDescription').val());
	var video_type = $('#EmployerVideoType').val();
	var youtube = $.trim($('#EmployerVideo').val());
	var upload = $('#EmployerUpload').val();
	
	if(descrp=='')
	{ alert('Please enter video description'); return false; }
	if(video_type=='')
    { alert('Please select video type'); return false; }
	if(video_type=='youtube'){
	if(youtube=='')
	{ alert('Please enter you tube url'); return false; }
	}
	
	if(video_type=='upload')
	{
	var input, file;
	input = document.getElementById('vidoeemp');
	file = input.files[0];
	

	if (!input.files[0])
	{
	alert('Please upload a video file');
	return false;	
	}
	else if(file.size > 10213830)
	{
	alert('Maximum size 10MB');
	return false;
	}
	}
}   
   
</script>
<div id="wrapper">
    <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Company Videos</h1>
            <div class="content">
              <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr class="tableHead">
                        <th width="137">Description</th>
                        <th width="97">Posted Date</th>
                        <th width="222">Videos</th>
                        <th width="92"></th>
                </tr>
               </thead>
                <tbody>
                <?php  if(count($employervideo_list)) {
				$i=1;
					foreach($employervideo_list as $employervideo) {				
				  ?>
                <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                        <td   style="text-align:left"><?php echo $employervideo['EmployerVideo']['description'];   ?><br/><br/>
                         <span style="color:#F00;vertical-align:bottom;"><?php if($employervideo['EmployerVideo']['set_dashboard']=='1') echo "Dashboard Video";  ?> </span></td>
                        <td class="normalfont" style="text-align:left" valign="middle"><?php echo date(DATE_FORMAT, strtotime( $employervideo['EmployerVideo']['created']));   ?></td>
                        <td  class="normalfont" style="text-align:center">
                      
                        <?php // echo $this->Html->link($this->Html->image("images/video.jpg"), array('controller'=>'employers','action'=>'empshowVideo',$employervideo['EmployerVideo']['id']),array('class'=>'ajax','escape'=>false)); ?>
                        <a href="<?php echo $this->Html->url(FULL_BASE_URL.router::url('/',false).'employers/empshowVideo/'.$employervideo['EmployerVideo']['id'], false); ?>" class="ajax_empvideo" >
						<?php if($employervideo['EmployerVideo']['video_type']=='upload')
                        {
                        echo $this->Html->image("images/video.jpg",array('style'=>'width:200px;'));
                        }
                        else {
                        $youtubeId = end(explode('/',$employervideo['EmployerVideo']['video']));
                        ?>
                        <img src="http://img.youtube.com/vi/<?php echo $youtubeId; ?>/0.jpg" style="width:200px;height:131px;"  />
                        <?php } ?>
                        </a>
                	
                        
                        
                        </td>
                        <td  class="normalfont last" style="text-align:center">
                          <?php echo $this->Html->link($this->Html->image("images/edit.gif"), array('controller'=>'employers','action'=>'empeditVideo',$employervideo['EmployerVideo']['id']),array('escape'=>false)); ?><br />
                          <br />
                           <?php echo $this->Html->link($this->Html->image("images/delete.gif"), array('controller'=>'employers','action'=>'empVideo','delete',$employervideo['EmployerVideo']['id']),array('style'=>'padding-right:8px!important;', 'class'=>'f_right padding_right view_delete','escape'=>false ,'confirm' => 'Are you sure to delete video?'));?> 
                            <br />
                           <?php echo $this->Html->link('Set as Dashboard Video', array('controller'=>'employers','action'=>'setDeskVideo',$employervideo['EmployerVideo']['id']),array('class'=>'f_right padding_right view_delete','escape'=>false));?> 
                           
                    		</td>
                      
                </tr>
             	<?php 
				$i=$i+1;
				 }
					}else {
				    ?>
                <tr><td colspan="4" class="tablebody border_bottom"> No video uploaded by you </td></tr>
                <?php } ?>
                </tbody>
              </table>
              <br />
              <h2>Upload Company Videos</h2>
       <!--       <h2 class="mana_subheading">Please enter Short Description (2-3 lines) & Upload Video</h2>-->
              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
                 <?php echo $this->Form->create('Employer',array('name'=>'empVideo','id'=>'videoupload','onsubmit'=>'return validate()','enctype' => 'multipart/form-data'));?>
                <ul class="form_list manage_resume_form ">
                  <li>
                    <label>Video Description:</label>
                    <div class="form_rt_col1" style="width:190px;">
                         <?php echo $this->Form->input('description',array('label'=>false,'class'=>'textarea_237','div'=>false,'style'=>'width:255px;'));?>
                    </div>
                  </li>
                   <li>
                    <label>Video Type:</label>
                       <div class="dropdown float_left margin_zero">
                         <?php echo $this->Form->input('video_type',array('label'=>false,'options'=> array(''=>'Select video type','youtube'=>'YouTube','upload'=>'Upload your own'),'type'=>'select','div'=>false,'class'=>'select1'));?>
                         
                    </div>
                  </li>
                
                  <li id="youtube_video">
                    <label>You Tube url:</label>
                    <div class="form_rt_col1">
                      <?php //echo $this->Form->input('video',array('class'=>'input_208','error'=>false,'div'=>false,'lable'=>false));?>
                      
                       <?php echo $this->Form->input('video',array('class'=>'smallTextB','error'=>false,'div'=>false,'lable'=>false));?>
                         <br /><br />
                      <span class="instruction red">Example : http://youtu.be/u5X5cV-4LRo</span>
                    </div>
                  </li>
                  <li id="direct_upload">
                    <label>Upload Video:</label>
                    <div class="form_rt_col1">
                    
                      <?php echo $this->Form->input('video2',array('type'=>'file','label'=>'','border'=>'none','div'=>'','label'=>false,'size'=>'29px;','id'=>'vidoeemp'));?>
                      <br />
                      <span class="instruction red">Maximum size 10MB</span> </div>
                  </li>
                  
                  <li>
                    <label></label>
                    <div class="form_rt_col1">
                    
                       <?php
    					echo $this->Form->input('Employer.UPLOAD',array('value'=>'UPLOAD','type'=>'hidden'));
					    echo $this->Form->submit('images/grey_submit.jpg',array('div'=>false,'name'=>'Submit'));?>
                    </div>
                  </li>
                </ul>
                  <?php echo $this->Form->end();?>
              </div>
              <br />
            </div>
          </div>
        </div>
      </div>
       <?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
    </div>
  </div>