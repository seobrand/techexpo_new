<script type="text/javascript">

$(document).ready(function() {
	 
		<?php if($this->request->data['CandidateVideo']['video_type']=='youtube'){ ?>		
				 $("#direct_upload").hide();
		 <?php }else
		 { ?>
			  $("#youtube_video").hide();
		 <?php } ?>
	
	// for video section
  	 $("#CandidateVideoType").change(function(){
       var video_type = $("#CandidateVideoType").val();
	   
	   
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
	var youtube = $('#CandidateVideo').val();
	var upload = $('#CandidateUpload').val();
	
	
	
	if(descrp=='')
	{ alert('Please enter video description'); return false; }
	if(video_type=='')
    {
	//if(upload=='') 
	//{
		 alert('Please select video type'); return false;
	 
//	  }
	 }
	if(video_type=='youtube'){
	if(youtube=='')
	{ alert('Please enter you tube url'); return false; }
	}
	
	
	if(video_type=='upload')
	{
		var input, file;
		input = document.getElementById('CandidateUpload');
		file = input.files[0];
		
		if(input.value!='')
		{ 
		
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

}  
   
</script>


<div id="wrapper">
 
       <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Upload Company Videos</h1>
            <div class="content">
                <h2 class="mana_subheading">Please enter Short Description (2-3 lines) & Upload Video</h2>
              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
                 <?php echo $this->Form->create('Candidate',array('name'=>'editVideo','id'=>'videoupload','type'=>'post','onsubmit'=>'return validate()','enctype' => 'multipart/form-data'));?>
                <ul class="form_list manage_resume_form ">
                  <li>
                    <label>Video Description:</label>
                    <div class="form_rt_col1">
                         <?php echo $this->Form->input('CandidateVideo.description',array('label'=>false,'class'=>'textarea_237 smallTextB','div'=>false,'id'=>'CandidateDescription'));?>
                    </div>
                  </li>
                  <li>
                    <label>Video Type:</label>
                    <div class="dropdown">
                         <?php //echo $this->Form->input('CandidateVideo.video_type',array('label'=>false,'options'=> array(''=>'select video type','youtube'=>'Youtube','upload'=>'Upload Video'),'type'=>'select','div'=>false,'class'=>'select1','id'=>'CandidateVideoType'));
						 
						 
						  echo $this->Form->input('CandidateVideo.video_type',array('label'=>false,'options'=> array(''=>'Select video type','youtube'=>'YouTube','upload'=>'Upload your own'),'type'=>'select','div'=>false,'class'=>'select1','id'=>'CandidateVideoType'));
						 ?>
                    </div>
                  </li>
     
			<li id="youtube_video">
                    <label>You Tube url:</label>
                    <div class="form_rt_col1">
                    	 <?php echo $this->Form->input('CandidateVideo.video',array('class'=>'smallTextB','error'=>false,'div'=>false,'lable'=>false));?>
                         <br /> <br />
                      <span class="instruction red">Example : http://youtu.be/u5X5cV-4LRo</span>
                    </div>
                  </li>
             <li id="direct_upload">
                    <label>Upload Video:</label>
                    <div class="form_rt_col1">
                      	<?php  echo $this->Form->input('CandidateVideo.videoFile',array('type'=>'file','label'=>false,'border'=>'none','div'=>'','size'=>'29px;','id'=>'CandidateUpload'));?>
                      <br /> <br />
                      <?php if($this->request->data['CandidateVideo']['video_type']=='upload'){ ?>
                      OLD VIDEO &nbsp;:&nbsp;:
                      <?php
					 	 echo $this->request->data['CandidateVideo']['video'];
						 echo $this->Form->input('CandidateVideo.oldvideo',array('type'=>'hidden'));
					   } ?>
                      <span class="instruction red">Maximum size 10MB</span> </div>
                  </li>
           	<li>
                 <label></label>
                    <div class="form_rt_col1">
                    
                       <?php
    					echo $this->Form->input('CandidateVideo.set_dashboard',array('type'=>'hidden'));
						echo $this->Form->input('CandidateVideo.candidate_id',array('type'=>'hidden'));
						echo $this->Form->input('CandidateVideo.id',array('type'=>'hidden'));
						echo $this->Form->input('CandidateVideo.UPLOAD',array('value'=>'UPLOAD','type'=>'hidden'));
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
    <?php echo $this->element('partners', array('cache' => true)); ?>
    </div>
  </div>