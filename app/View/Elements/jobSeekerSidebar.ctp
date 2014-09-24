<?php $matchingJob=$common->getJobSeekerMatchingJob(); 
	$profileImageRec=$common->getprofileImage();
	//
	$profileImage=$profileImageRec['Candidate']['candidate_image'];
	$profile_description=$profileImageRec['Candidate']['profile_description'];
	
	
	
?>
 <script type="text/javascript">
$(document).ready(function(){

		$('.seeker_pro_img').click(function(){
		
			window.location='<?php echo FULL_BASE_URL.router::url('/',false); ?>Jobseeker/candidates/profileImage';
		});


			<?php  $sessroom_id = $this->Session->read('Chat.room_id'); 
			if(empty($sessroom_id)){
			?>
			
			$('#content1').hide();
			$('#discussion_board').css({'height':'100px'});
			
			
			<?php }
			 if(isset($sessroom_id) && !empty($sessroom_id) ){ ?>
			
					$('#content').html(' ');
					var room_id = <?php echo $this->Session->read('Chat.room_id'); ?>;
					$.ajax({
					  type: "POST",
					  url: "<?php echo $this->webroot; ?>chats/enteruser",
					  data: { room_id: room_id },
					  success: function(data) {
						  if(data)
						 $('#content').append(data);
						 
						 
						  }
						})
 			<?php } ?>
				$("#groupchat_id").change(function(){
					$('#content').html(' ');
					var room_id =$("#groupchat_id").val();
					
					$.ajax({
					  type: "POST",
					  url: "<?php echo $this->webroot; ?>chats/enteruser",
					  data: { room_id: room_id },
					  success: function(data) {
						  if(data)
						 $('#content').append(data);
						  $('#content1').show();
						 $('#discussion_board').css({'height':'358px'});
							  if(room_id=='')
							   {
								   $('#content1').hide();
								   $('#discussion_board').css({'height':'100px'});
								}
						  }
						})
 				   });
				
				});
		</script> 
<div class="rt_col_inner">
      <div class="side_box">
        <div class="sideprofile_head">
          <h3 class="jobseeker_ico"><?php /*echo substr(ucfirst($this->Session->read('Auth.Clients.username')),0,13);*/  echo $this->Text->truncate(ucfirst($this->Session->read('Auth.Clients.username')), 14); ?>'s Profile</h3>
        </div>
        <div class="sidenews_mid jobseeker_mid_profile">
          <div class="sidenews_bottom jobseeker_mid_profile">
            <div class="sidepanel_padding seeker_profile" style="padding-top:8px!important;">
              <div class="seeker_pro_img" style="display:table;" > </div>
              
              <?php if($profileImage && file_exists('upload/150x80_'.$profileImage)){ ?>
              <div style="height:140px;display:table-cell;  vertical-align:middle;">
              <div style="text-align:center;width:210px;">
      
             <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$profileImage;?>&maxw=186&maxh=140" style="margin-left:30px;" alt="<?php echo $profile_description; ?>"/>
               </div>
              </div>
              <?php $profileImg ='Edit Profile Image'; }else
			 {
				 $profileImg ='Upload Profile Image';
			  
			   ?>
               
               <div style="height:140px;">
               <?php echo $this->Html->image('/upload/index.jpg',array('style'=>'height:140px;width:186px;margin-left:30px;clear:both"')); ?>
               </div>
               <?php } ?>
              <ul class="profile_actions" style="padding-top:14px!important;">
              	 <li class="add">
                 
                 	<?php  echo $this->Html->link($profileImg,array('controller'=>'candidates','action'=>'profileImage','Jobseeker'=>true)); ?>
                  </li>
                 
                <li class="edit">
                   <?php  echo $this->Html->link("Edit Your Profile",array('controller'=>'candidates','action'=>'editprofile','Jobseeker'=>true,$this->Session->read('Auth.Client.User.candidate_id'))); ?>
               
                </li>
                <li class="view">
                  <?php  echo $this->Html->link("Manage Resumes",array('controller'=>'resumes','action' =>'resumelist','Jobseeker'=>true)); ?>
                </li>
                <li class="upload">
                  <?php  echo $this->Html->link("Upload Your Resume",array('controller'=>'resumes','action'=>'upload_resume','Jobseeker'=>true)); ?>
                </li>
                <li class="upload_video">
                  <?php  echo $this->Html->link("Your Video Resume",array('controller'=>'candidates','action'=>'videoList','Jobseeker'=>true)); ?>
                </li>
                
                
                
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="side_box">
        <div class="sideprofile_head">
          <h3 class="jobs_ico">Matching Jobs</h3>
        </div>
        <div class="sidenews_mid industrynews">
          <div class="sidenews_bottom industrynews">
            <ul class="industry_news">
         
            
           
            
            
             <?php
			if(count($matchingJob))
			{
			  foreach($matchingJob as $value){ ?>
              <li> 
             
             <div class="job_sidebar_logo" >
              	<?php 
					$logo=$value['Employer']['logo_file'];
					
					if($value['Employer']['logo_file'])
					{
					echo $this->Html->link('<img src="'.$this->webroot.'thumbnail.php?file=upload/'.$logo.'&maxw=50&maxh=50"   />',array('Jobseeker'=>true,'controller'=>'candidates','action'=>'jobDetail?jobId='.$value['JobPosting']['posting_id']),array('escape'=>false)); 
					}
					
				 ?>
			</div>
                
              	
                
                <div class="totaljobs" >
				
					<?php echo $this->Html->link($value['JobPosting']['job_title'],array('Jobseeker'=>true,'controller'=>'candidates','action'=>'jobDetail?jobId='.$value['JobPosting']['posting_id']),array('escape'=>false)); ?>
				<br />
             </div>
                <div class="clear"></div>
              </li>
              
              <?php }}
			  else
			  {
			  ?>
              <li>No matching jobs found</li>
              <?php 
			  }  ?>
               <?php
			if(count($matchingJob) > 0){ ?>
			
              <div class="alignright readmore_link">
            	<?php echo $this->Html->link('View All..',array('Jobseeker'=>true,'controller'=>'candidates','action'=>'Jobseeker_autoMatching'),array('escape'=>false)); ?>
             </div>
           <?php } ?>
            </ul>
            
          </div>
        </div>
      </div>
             <!---------------------------------Discussion Board start-------------------------------------> 
    <!--  <div class="side_box">
        <div class="sideprofile_head">
          <h3 class="discussion_ico">Discussion Board</h3>
        </div>
        <div class="sidenews_mid discussion_board" id="discussion_board">
          <div class="sidenews_bottom discussion_board">
        <div class="topic_list">
          <div class="topic_panel">
            <ul>
              <li>
                <div class="topic_title">
                <div id="roomlistdrodown">
               


<div class="dropdown10">




                
                
                 <?php   $chatRoomList = $common->chatRoomList();
				 
					 echo $this->Form->input('room_id',array('label'=>'','options'=>$chatRoomList,'selected'=>$sessroom_id,'type'=>'select','empty'=>'Select Chat Group','error'=>false,'div'=>false,'label'=>false,'id'=>'groupchat_id','style'=>'posiotion:absolute !important'));
					   ?>
       
              </li>
    
            </ul>
    
          </div>
        </div>
              <div id="content1">
        <div class="line"></div>
        <div class="chat_list" id="content" style="margin:7px 0 10px 2px;height:224px;overflow:scroll;width:236px;">
         
     
        </div>
         <div class="chat_field">
         <form action="#" id="form_send" method="post">
         <input type="hidden" name="user_id" id="user_id" value="<?php  echo $this->Session->read('Auth.Clients.id'); ?>" /> 
             <input type="text" size="10" maxlength="255" class="chat_fld" name="message" id="message" /> 
       
           <?php echo $this->Form->submit('images/send.jpg'); ?>
           
         
           
           
            </form>
          </div>
          
          </div>
      </div>
        </div>
      </div>-->
      
       <!---------------------------------Discussion Board End-------------------------------------> 
   <div class="side_box">
    <div class="sideprofile_head">
      <h3 class="linkedIn_ico">LinkedIn</h3>
    </div>
    <div class="sidenews_front_mid" style="width:271px!important;vertical-align:middle;text-align:center;padding:25px 0 25px 0;">
               	<?php echo $this->Html->link($this->Html->image('images/join-group.jpg'),'http://www.linkedin.com/groups?gid=113669',array('escape'=>false,'target'=>'_blank'));?>
        </div>
  </div>
  
  
  
  
  
    </div>