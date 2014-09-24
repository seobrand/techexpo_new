<?php   
// for facny box
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
	//echo $this->Html->script('front_js/jwplayer.js');
?>
<script type="text/javascript">

$(document).ready(function() {
	
	//$(".inline").colorbox({inline:true, width:"40%",height:'67%'});
	$(".ajax").colorbox();
			
	 $("#direct_upload").hide();
	   $("#youtube_video").hide();
	// for video section
  	 $("#CandidateVideoType").change(function(){
       var video_type = $("#CandidateVideoType").val();
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
	var descrp = $.trim($('#CandidateDescription').val());
	var video_type = $('#CandidateVideoType').val();
	var youtube = $.trim($('#CandidateVideo').val());
	var upload = $('#CandidateUpload').val();
	
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
		input = document.getElementById('vidoecan');
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
    <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Your Video Resume</h1>
          
            <div class="content">
              <p>You may now present yourself to recruiting companies by attaching a short video. Be sure to state your skill sets, work experience and the type of job you are seeking.</p>
              <br/><br/>
              <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
              	  <tr class="tableHead">
                        <th width="137" style="text-align:center">Description</th>
                        <th width="97" style="text-align:center">Posted Date</th>
                        <th width="222" style="text-align:center">Videos</th>
                        <th width="92" style="text-align:center"></th>
                 </tr>
                </thead>
                <?php  if(count($candidatevideo_list)) {
					$i=1;
					foreach($candidatevideo_list as $candidatevideo) {				
				  ?>
                   	<tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                        <td  width="137" style="text-align:left"><?php echo $candidatevideo['CandidateVideo']['description'];   ?><br/><br/>
                        <?php if($candidatevideo['CandidateVideo']['set_dashboard']=='1'){?> <span style="color:green;font-weight:bold;">Dashboard Video</span><?php }else{ ?><span style="color:#F00;vertical-align:bottom;"><?php echo $this->Html->link('Set as Dashboard Video', array('controller'=>'candidates','action'=>'setDeskVideo',$candidatevideo['CandidateVideo']['id']),array('class'=>'f_right padding_right view_delete','escape'=>false)); }?> </span></td>
                        <td  width="97" class="normalfont" style="text-align:left" valign="middle"><?php echo date(DATE_FORMAT, strtotime( $candidatevideo['CandidateVideo']['created']));   ?></td>
                        <td  width="222" class="normalfont" style="text-align:center">
						<?php // echo $this->Html->link($this->Html->image("images/video.jpg"), array('controller'=>'candidates','action'=>'showVideo',$candidatevideo['CandidateVideo']['id']),array('class'=>'ajax','escape'=>false)); ?>
                          <a href="<?php echo $this->Html->url(FULL_BASE_URL.router::url('/',false).'Jobseeker/candidates/showVideo/'.$candidatevideo['CandidateVideo']['id'], false); ?>" class="ajax" >
                <?php if($candidatevideo['CandidateVideo']['video_type']=='upload')
				{
				 echo $this->Html->image("images/video.jpg",array('style'=>'width:200px;'));
				}
				else {
					$youtubeId = end(explode('/',$candidatevideo['CandidateVideo']['video']));
				 ?>
                <img src="http://img.youtube.com/vi/<?php echo $youtubeId; ?>/0.jpg" style="width:200px;height:131px;"  />
                <?php } ?>
                </a>
                     </td>   
                        
                        <td  width="92" class="normalfont last" style="text-align:center">
                          <?php echo $this->Html->link($this->Html->image("images/edit.gif"), array('controller'=>'candidates','action'=>'editVideo',$candidatevideo['CandidateVideo']['id']),array('escape'=>false,'style'=>'padding-top:10px;')); ?>
                          <?php echo $this->Html->link($this->Html->image("images/delete.gif"), array('controller'=>'candidates','action'=>'videoList','delete',$candidatevideo['CandidateVideo']['id']),array('escape'=>false ,'confirm' => 'Are you sure to delete video?'));?> 
                        </td>
                	</tr>
             	<?php 
				$i=$i+1;
				 }
					}else {
				    ?>
                <tr class="tablebody"><td colspan="4"> No video uploaded by you </td></tr>
                <?php } ?>
              </table>
              <br />
              <h2>Upload Your Video Resume</h2>
              <!--<h2 class="mana_subheading">Please enter Short Description (2-3 lines) & Upload Video</h2>-->
              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
                 <?php echo $this->Form->create('Candidate',array('name'=>'empVideo','id'=>'videoupload','onsubmit'=>'return validate()','enctype' => 'multipart/form-data'));?>
                <ul class="form_list manage_resume_form ">
                  <li>
                    <label>Video Description:</label>
                    <div class="form_rt_col1">
                         <?php echo $this->Form->input('description',array('label'=>false,'class'=>'smallTextB','div'=>false));?>
                    </div>
                  </li>
                   <li>
                    <label>Video Type:</label>
                    <div class="dropdown">
                         <?php echo $this->Form->input('video_type',array('label'=>false,'options'=> array(''=>'Select video type','youtube'=>'YouTube','upload'=>'Upload your own'),'type'=>'select','div'=>false,'class'=>'select1'));?>
                    </div>
                  </li>
                  
                  <li id="youtube_video">
                    <label>You Tube url:</label>
                    <div class="form_rt_col1">
                    
                      <?php echo $this->Form->input('video',array('class'=>'smallTextB','error'=>false,'div'=>false,'lable'=>false));?>
                         <br /> <br />
                      <span class="instruction red">Example : http://youtu.be/u5X5cV-4LRo</span>
                    </div>
                  </li>
                  <li id="direct_upload">
                    <label>Upload Video:</label>
                    <div class="form_rt_col1">
                    
                       
              
                      <?php  echo $this->Form->input('video2',array('type'=>'file','label'=>false,'border'=>'none','div'=>'','size'=>'29px;','id'=>'vidoecan'));?>
                      <br /> <br />
                      <span class="instruction red">Maximum size 10MB</span> </div>
                  </li>
                  <li>
                    <label></label>
                    <div class="form_rt_col1">
                    
                       <?php
    					echo $this->Form->input('Candidate.UPLOAD',array('value'=>'UPLOAD','type'=>'hidden'));
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
       <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
    </div>
  </div>