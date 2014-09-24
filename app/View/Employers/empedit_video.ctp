<script type="text/javascript">

$(document).ready(function() {
	
	
	
	//$(".ajax").colorbox();
	//$(".inline").colorbox({inline:true, width:"40%"});
	<?php if($this->request->data['EmployerVideo']['video_type']=='youtube'){ ?>
		 $("#direct_upload").hide();
	 <?php }else{ ?>
	  	$("#youtube_video").hide();
	 <?php } ?>
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
	var youtube = $('#EmployerVideo').val();
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
	
	
	if(input.value!='')
	{	if (!input.files[0])
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
   
   
function is_valid_url(url)
{
     return url.match(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
}   
</script>
<div id="wrapper">
 
    	<?php 
	 echo $this->element('employer_tabs');?>
    <div id="container">
    
    
      
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Upload Company Videos</h1>
            <div class="content">
              

         <!--<h2 class="mana_subheading">Please enter Short Description (2-3 lines) & Upload Video</h2>-->
              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
                 <?php echo $this->Form->create('Employer',array('name'=>'empeditVideo','id'=>'videoupload','onsubmit'=>'return validate()','enctype' => 'multipart/form-data'));?>
                <ul class="form_list manage_resume_form ">
                  <li>
                    <label>Video Description:</label>
                    <div class="form_rt_col1">
                         <?php echo $this->Form->input('description',array('label'=>false,'class'=>'textarea_237','div'=>false,
						 								'value'=>$video_detail['EmployerVideo']['description'],'style'=>"width:256px"));?>
                    </div>
                  </li>
                  
               <li>
                    <label>Video Type:</label>
                       <div class="dropdown float_left margin_zero">
                         <?php echo $this->Form->input('EmployerVideo.video_type',array('label'=>false,'options'=> array(''=>'Select video type','youtube'=>'Youtube','upload'=>'Upload your own'),'type'=>'select','div'=>false,'class'=>'select1','id'=>'EmployerVideoType'));?>
                         
                    </div>
                  </li>
                               
                  <li id="youtube_video">
                    <label>You Tube url:</label>
                    <div class="form_rt_col1">
                       <?php echo $this->Form->input('video',array('class'=>'smallTextB','error'=>false,'div'=>false,'label'=>false,'value'=>$video_detail['EmployerVideo']['video']));?>
                         <br /><br />
                      <span class="instruction red">Example : http://youtu.be/u5X5cV-4LRo</span>
                    </div>
                  </li>
                  <li id="direct_upload">
                    <label>Upload Video:</label>
                    <div class="form_rt_col1">
                    
                      <?php echo $this->Form->input('video2',array('type'=>'file','label'=>'','border'=>'none','div'=>'','label'=>false,'size'=>'29px;','id'=>'vidoeemp'));?>
                      
                      <br />
                    
                      <?php if($video_detail['EmployerVideo']['video_type']=='upload'){
					  ?>
                        OLD VIDEO &nbsp; :
                      <?php
					echo   $video_detail['EmployerVideo']['video'];
					  } ?>
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
                  <?php echo $this->Form->end(); ?>
              </div>
              <br />
              
            
            </div>
          </div>
        </div>
      </div>
      

      <?php echo $this->element('employer_left_panel');?>
      <div class="clear"></div>
      <?php echo $this->element('scroll_panel');?>
    </div>
  </div>