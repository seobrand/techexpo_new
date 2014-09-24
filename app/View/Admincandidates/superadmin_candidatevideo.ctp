<?php   
// for facny box
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
</script>

<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Candidate Videos</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <table border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th width="30%" align="left" valign="middle"> Candidate Name </th>
          <th align="left" valign="middle"> Video Description </th>
          <th align="left" valign="middle"> Posted Date </th>
          <th align="left" valign="middle"> Video </th>
          <th align="left" valign="middle"> Approve </th>
          <th align="left" valign="middle">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($candVideo as $video){?>
        <tr>
          <td width="25%"  align="left"><?php echo $video['Candidate']['candidate_name'];?> </td>
          <td align="left"> <?php echo $video['CandidateVideo']['description'];?></td>
          <td align="left"> <?php echo date("m/d/Y",strtotime($video['CandidateVideo']['created']));?></td>
          <td align="left">
           <?php // echo $this->Html->link($this->Html->image("images/video.jpg"), array('controller'=>'admincandidates','action'=>'showcandidatevideo',$video['CandidateVideo']['id']),array('class'=>'ajax','escape'=>false)); ?> 
            <a href="<?php echo $this->Html->url(FULL_BASE_URL.router::url('/',false).'Jobseeker/candidates/showVideo/'.$video['CandidateVideo']['id'], false); ?>" class="ajax" >
						<?php if($video['CandidateVideo']['video_type']=='upload')
                        {
                        echo $this->Html->image("images/video.jpg",array('style'=>'width:200px;'));
                        }
                        else {
                        $youtubeId = end(explode('/',$video['CandidateVideo']['video']));
                        ?>
                        <img src="http://img.youtube.com/vi/<?php echo $youtubeId; ?>/0.jpg" style="width:200px;height:131px;"  />
                        <?php } ?>
                        </a>
           
           </td>
          <td align="left"> <?php if($video['CandidateVideo']['isApproved']=='N') echo "Not Approved"; else echo "Approved";?> </td>
          <td align="left"><?php if($video['CandidateVideo']['isApproved']=='N'){ echo $this->Form->postLink('Approve',array('action'=>'videoapprove',$video['CandidateVideo']['id']),array('confirm'=>'Are you sure want to Approve this video?','class'=>'a-state-default'));}else{ echo $this->Form->postLink('UnApprove',array('action'=>'videounapprove',$video['CandidateVideo']['id']),array('confirm'=>'Are you sure want to UnApprove this video?','class'=>'a-state-default'));}?></td>
        </tr>
        <?php } ?>
		<?php if(count($candVideo)==0){?>
		<tr>
          <td colspan="5" align="center">There is no candidate video uploaded yet..</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
