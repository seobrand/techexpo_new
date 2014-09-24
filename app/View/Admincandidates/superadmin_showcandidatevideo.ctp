<?php   
// for facny box	
	echo $this->Html->script('front_js/jquery-1.8.0.min.js');
	echo $this->Html->script('front_js/jwplayer.js');
?>
<div style="min-height:350px;">               
<object width="480" height="300" type="application/x-shockwave-flash" data="<?php echo $this->webroot; ?>player.swf" id="player_resRemote">
<param name="movie" value="<?php echo $this->webroot; ?>player.swf" />
<param name="flashvars" value="file=<?php  if($video_dt['CandidateVideo']['video_type']=='youtube')  echo $video_dt['CandidateVideo']['video']; else echo FULL_BASE_URL.router::url('/',false).'upload/video/candidate/'.$video_dt['CandidateVideo']['video'];  ?>&autostart=true" />
</object>         
                     
<h4 style="margin-top:10px;text-align:center;"><?php echo $video_dt['CandidateVideo']['description'];   ?></h4>        
</div>