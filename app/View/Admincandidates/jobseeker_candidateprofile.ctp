<?php $SeekAnn=$common->getSeekerAnnouncement();
?>
<?php   
// for facny box
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
	echo $this->Html->script('front_js/jwplayer.js');
	echo $this->Html->script('jquery-ui-1.7.1.custom.min.js');
?>
<script type="text/javascript">

$(document).ready(function() {
	
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

}   

function conformDelete()
{
	var agree=confirm("Are you sure you wish to continue?");
		
		if (agree)
			return true ;
		else
			return false ;
		
		}
   
</script>

<style>

ul {
	margin: 0;
}


#contentLeft {
	float: left;

}

#contentLeft li {
	list-style: none;
	
	
	
}



</style>



<script type="text/javascript">
$(document).ready(function(){ 
						   
	$(function() {
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize") + '&action=updateRecordsListings'; 
			$.post("<?php echo FULL_BASE_URL.router::url('/',false)?>Jobseeker/candidates/updateDB", order, function(theResponse){
				$("#contentRight").html(theResponse);
			}); 															 
		}								  
		});
	});

});	
</script>
<div style="height:20px" id="contentRight">


</div>

<div id="contentWrap">
	</div>

<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head border_top"></div>
      <div class="whiteB_mid border_mid">
        <div class="whiteB_bottom border_btm">
          <div class="content">
            <div class="dashboard_row">
            
            <?php
			
			 if($SeekAnn['HomepageMessage']['msg']){ ?>
                  <div class="announcements_panel">
                    <h4 class="dash_heading">Special Announcement</h4>
                    <ul class="dash_act_job">
                      <li><?php echo $SeekAnn['HomepageMessage']['msg']; ?>
                      <br/>
						<?php echo $this->Html->image("homepage/".$SeekAnn['HomepageMessage']['img'],array('style'=>'max-width:600px'));?>
						<br/><br/>
                      </li>
                    
                    </ul>
                  </div>
               <?php } ?>
               
             
              
              
              <div class="clear"></div>
            </div>
            <div class="dashboard_row">
            
              <div style="clear:both"></div>
            <div id="contentLeft">
				<ul style="width:632px;">
				<?php
				foreach($RecId as $key=>$value9)
				{
				
				?>
				
                	<?php if($value9['records']['recordID']=='1') {?>
                		<li style="width:290px;float:left;margin:10px;min-height:370px;margin:5px 5px 0px 15px;" id="recordsArray_<?php echo $value9['records']['id'];; ?>">
						<div class="dashboard_col_lf">
               				 <h4 class="dash_heading">Upcoming Events</h4>
               					
                                 <ul class="dash_ev_list">
                                          <?php
                                          if(count($showRec))
                                          {
                                           foreach($showRec as $value){ 
                                          ?>
                                          <li>
                                            <div class="date_event">
                                              <div class="dt_lf">
                                                <div class="dt_rt"><?php echo date('M d,Y',strtotime($value['Show']['show_dt'])); ?></div>
                                              </div>
                                            </div>
                                            <?php echo $this->Html->link('Detail.',array('controller'=>'candidates','action'=>'eventinfo',$value['Show']['id']),array('escape'=>false,'class'=>'viewMore','style'=>'float:right')); ?>
                                            <div class="clear"></div>
                                            <p><?php echo $value['Show']['show_name']; ?>&nbsp;&nbsp;(<?php echo $value['Show']['show_hours']; ?>) </p>
                                          </li>
                                          
                                          
                                          <?php } 
                                          ?>
                                  </ul>
                                 <div class="alignright dashboard_readmore"> <?php echo $this->Html->link($this->Html->image('images/view_more.jpg'),array('controller'=>'candidates','action'=>'upcomingEvent'),array('escape'=>false)); ?> </div>
							
         
                              <?php 
                              }else
                              {?>
                              <li>No More Upcoming Events</li>
                              </ul>
                              
                              <?php 
                              }?>
                             </div>
                   		 </li>
                    <?php } ?>
                    
                    
                    <?php if($value9['records']['recordID']=='2') {?>
                	<li style="width:290px;float:left;margin:10px;min-height:370px;margin:5px 5px 0px 15px;" id="recordsArray_<?php echo $value9['records']['id'];; ?>">
						<div class="dashboard_col_rt">
                <h4 class="dash_heading">Resume</h4>
                <ul class="active_job_heading">
                  <li class="jobname">Job Name</li>
                  <li class="view_edit">View</li>
                  <li class="view_edit">Edit</li>
                  <li>Delete</li>
                </ul>
                <div class="clear"></div>
                <ul class="dash_act_job with_action">
                  <?php
				  if(count($resumeRec))
				  {
				   foreach($resumeRec as $value){ ?>
                 		 <li> 
                        <span class="f_left jobname"><?php echo $value['Resume']['resume_title'];?></span><span class="f_right"> 
                                               
                        <?php echo $this->Html->link($this->Html->image('images/trash.jpg'),array('action'=>'',$value['Resume']['id']),array('escape'=>false,'class'=>'f_right padding_right view_delete','onClick'=>'return conformDelete()')); ?>
                        
                          <?php echo $this->Html->link($this->Html->image('images/edit1.jpg'),array('controller'=>'resumes','action'=>'edit_resume',$value['Resume']['id']),array('escape'=>false,'class'=>'f_right padding_right view_delete')); ?>
                          
                          <?php echo $this->Html->link($this->Html->image('images/preview.jpg'),array('controller'=>'resumes','action'=>'viewResume',$value['Resume']['id']),array('escape'=>false,'class'=>'f_right padding_right view_delete')); ?>
                        
                 
                        </span>
                        <div class="clear"></div>
                  </li>
                  
                
                  <?php }
				  ?>

				  	<div class="alignright viewmore_active">
                <?php echo $this->Html->link($this->Html->image('images/view_more.jpg'),array('controller'=>'resumes','action'=>'resumelist'),array('escape'=>false)); ?>
                </div>
                 </ul>
                  <?php 
				  
				  }else
				  {?>
                  <li>No Record Found</li>
                   </ul>
                  <?php }?>
                  
               
              </div>
                    </li>
                    <?php } ?>
                    
                    
                    <?php if($value9['records']['recordID']=='3') {?>
                	<li style="width:290px;float:left;margin:10px;min-height:370px;margin:5px 5px 0px 15px;" id="recordsArray_<?php echo $value9['records']['id'];; ?>">
						<div class="dashboard_col_lf">
                <h4 class="dash_heading">Videos</h4>
                
                 <?php  if($dashboard_video['CandidateVideo']['id']) {
								
				   echo $this->Html->link($this->Html->image("images/video.jpg",array('style'=>'width:295px;')), array('controller'=>'candidates','action'=>'showVideo/'.$dashboard_video['CandidateVideo']['id']),array('class'=>'ajax','escape'=>false)); 
					}
					else
					{
					echo $this->Html->image('images/video.jpg',array('style'=>'width:295px;','onclick'=>'alert("Please enter video first");'));
					}					
					 ?>
                
                <div class="viewmore_active">
                       <?php echo $this->Html->link($this->Html->image("images/manage_videos.jpg"), array('controller'=>'candidates','action'=>'videoList'),array('class'=>'f_right','escape'=>false)); ?>
                  
                  </div>
              </div>
                    </li>
                    <?php } ?>
                    
                       <?php if($value9['records']['recordID']=='4') {?>
                	<li style="width:290px;float:left;margin:10px;min-height:370px;margin:5px 5px 0px 15px;" id="recordsArray_<?php echo $value9['records']['id'];; ?>">
		
        								<?php echo $this->Form->create('Candidates',array('controller'=>'candidates','action'=>'searchJob','type'=>'GET'));?>
             						 <div style="display:none">
                <?php  $option=array('All'=>'All Words','Exact'=>'Exact Phrase','Any'=>'Any Words');
                         echo $this->Form->input('JobPosting.matching',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
              </div>
             						 <div class="dashboard_col_rt">
                <h4 class="dash_heading">Search Jobs</h4>
                <ul class="dash_search_list">
                  <li>
                    <label>Keywords:</label>
                    <br />
                    <p> <?php echo $this->Form->input('keyword',array('class'=>'dash_textField','div'=>false,'label'=>false)); ?> </p>
                  </li>
                  <li>
                    <label>Work Type:</label>
                    <br />
                    <p class="dropdown_dash">
                      <?php 
                         echo $this->Form->input('JobPosting.work_type_code',array('type'=>'select','options'=>$WorkTypeList,'empty'=>'-Either-','label'=>false,'class'=>'work_type_code','div'=>'')); ?>
                    </p>
                  </li>
                  <li>
                    <label>Job Sector:</label>
                    <br />
                    <p class="dropdown_dash">
                      <?php 
                         echo $this->Form->input('Employer.employer_type_code',array('type'=>'select','options'=>$IndustriesList,'empty'=>'-Please Select-','label'=>false,'class'=>'work_type_code','div'=>'')); ?>
                    </p>
                  </li>
                  <li>
                    <label>Location:</label>
                    <br />
                    <p class="dropdown_dash">
                      <?php  
                         echo $this->Form->input('JobPosting.work_location_code',array('type'=>'select','options'=>$WorkLocationList,'empty'=>'-Select Location-','label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                    </p>
                  </li>
                  <li class="last">
                    <label>Job by Clearance Type:</label>
                    <br />
                    <!--   <p class="dropdown_dash"> </p>-->
                      <p class="dropdown_dash">
                      <?php  
                         echo $this->Form->input('JobPosting.security_clearance_code',array('type'=>'select','options'=>$GovCleareanceList,'empty'=>'-Security Clearance-','label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;column:50;row:150;width:277px;')); ?>
                     </p>    
                         
                    
                  </li>
                </ul>
                
                
                <div class="alignright viewmore_active"> <?php echo $this->Form->submit('images/submit.jpg'); ?> </div>
              </div>
              						<?php echo $this->Form->end();?>
                     </li>
                    <?php } ?>
                    
                    
				<?php } ?>
			</ul>
		</div>
            <div style="clear:both"></div>
               
              <div class="clear"></div>
            </div>
          </div>
        </div>
      </div>
      <br />
 
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
