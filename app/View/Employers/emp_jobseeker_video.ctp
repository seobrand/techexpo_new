<?php   
// for facny box
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
	
	echo $this->Html->script('front_js/jwplayer.js');
?>
<script type="text/javascript">

$(document).ready(function() {
	
	$(".inline").colorbox({inline:true, width:"40%"});
			
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
	var descrp = $.trim($('#EmployerDescription').val());
	var video_type = $('#CandidateVideoType').val();
	var youtube = $.trim($('#CandidateVideo').val());
	var upload = $('#EmployerUpload').val();
	
	if(descrp=='')
	{ alert('Please enter video description'); return false; }
	if(video_type=='')
    { alert('Please select video type'); return false; }
	if(video_type=='youtube'){
	if(youtube=='')
	{ alert('Please enter you tube url'); return false; }
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
            <h1 class="bluecolor">Seeker's Latest 5 Videos</h1>
            <div class="content">
              <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                    <tr class="tableHead">
                        <th width="137">Seeker's Name</th>
                        <th width="97">Applied Post</th>
                        <th width="222">Videos</th>
                    </tr>
                </thead>
                <tbody>
                <?php  if(count($jobseekervideo_list)) {
				$i=1;
					foreach($jobseekervideo_list as $jobseekervideo) {				
				  ?>
                <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                        <td  width="137" style="text-align:left"><?php echo $jobseekervideo['CandidateVideo']['description'];   ?></td>
                        <td  width="97" class="normalfont" style="text-align:left" valign="middle"><?php echo date('d-m-Y', strtotime( $jobseekervideo['CandidateVideo']['created']));   ?></td>
                        <td  width="222" class="normalfont" style="text-align:center">
                        <a class='inline' title="<?php echo $jobseekervideo['CandidateVideo']['description'];   ?>" href="#inline_content<?php echo $jobseekervideo['CandidateVideo']['id'];  ?>"><?php echo $this->Html->image("images/video.jpg");  ?></a>
                        <div style='display:none'>
                        <div id='inline_content<?php echo $jobseekervideo['CandidateVideo']['id'];  ?>' style='padding:10px; background:#fff;'>
                        <div id="mediaplayer"></div>
	
                        <script type="text/javascript">
                            jwplayer("mediaplayer").setup({
								autostart: true,
                                flashplayer: "<?php echo $this->webroot; ?>player.swf",
                                file: "<?php  if($jobseekervideo['CandidateVideo']['video_type']=='youtube')  echo $jobseekervideo['CandidateVideo']['video']; else echo EMPLOYERVIDEO.$jobseekervideo['CandidateVideo']['video'];  ?>",
                                image: "preview.jpg",
                                height: 300,
                                width: 480,
								plugins: {
								sharing: { link: false }
								},
								
								
                            });
                        </script>
                        </div>
                        </div>
                        
                        
                        </td>
                        <!--<td  width="92" class="normalfont last" style="text-align:center">
                          <?php echo $this->Html->link($this->Html->image("images/edit.gif"), array('controller'=>'employers','action'=>'empeditVideo',$jobseekervideo['CandidateVideo']['id']),array('escape'=>false)); ?><br />
                          <br />
                           <?php echo $this->Html->link($this->Html->image("images/delete.gif"), array('controller'=>'employers','action'=>'empVideo','delete',$jobseekervideo['CandidateVideo']['id']),array('class'=>'f_right padding_right view_delete','escape'=>false ,'confirm' => 'Are you sure to delete video?'));?> 
                           
                    		</td>-->
                      
                </tr>
             	<?php  
					$i=$i+1;
				}
					}else {
				    ?>
                <tr><td colspan="3"> <h1 align="center">No video uploaded </h1> </td></tr>
                <?php } ?>
               </tbody>
              </table>
           
           
            </div>
          </div>
        </div>
      </div>
       <?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
    </div>
  </div>