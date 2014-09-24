
<?php 


  $upcomingEvents=$common->upcomingevent();  
 $employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
 $logoImage=$common->getemplogo(); 
 ?>
 <script type="text/javascript">
$(document).ready(function(){
			
			
			<?php  $sessroom_id = $this->Session->read('Chat.room_id');
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
						  }
						})
 				   });
				
				});
				
			
				
		</script> 
 
<div class="rt_col_inner">
  <div class="side_box">
    <div class="sideprofile_head">
      <h3 class="jobseeker_ico"><?php echo $this->Text->truncate(ucfirst($this->Session->read('Auth.Clients.username')), 16); ?>'s Profile</h3>
    </div>
    <div class="sidenews_mid employer_mid_profile">
      <div class="sidenews_bottom employer_mid_profile">
        <div class="sidepanel_padding seeker_profile">
          <div class="seeker_pro_img" style="display:table;"> </div>
		     <?php if($logoImage && file_exists('upload/150x80_'.$logoImage)){ ?>
              <div style="height:140px;display:table-cell;  vertical-align:middle;">
              <div style="text-align:center;width:210px;">
             <!-- <img src="<?php echo $this->webroot.'upload/cropped0_'.$logoImage;?>" alt="<?php echo $logoImage; ?>"    style="margin-left:16px;"/>-->
               <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$logoImage;?>&maxw=186&maxh=140" style="margin-left:30px;" />
              </div>
              </div>
             
              <?php }else
			 {
			   ?>
               <div style="height:140px;">
          <?php echo $this->Html->image("images/profile_pic.jpg",array('alt'=>'','url'=>array('controller'=>'','action'=>''),'class'=>'profile_pic'));?>
               </div>
               <?php } ?>
          
          
          <ul class="profile_actions">
            <li class="add"><?php echo $this->Html->link("Add / Change Company Logo", array('controller'=>'employers','action'=>'profileImage'));?></li>
            <li class="edit"><?php echo $this->Html->link("Edit Company Profile", array('controller'=>'employers','action'=>'editprofile'));?></li>
            <li class="upload"><?php echo $this->Html->link("Post a Job", array('controller'=>'employers','action'=>'emppostjob'));?></li>
			<li class="upload"><?php echo $this->Html->link("Buy Job Plan", array('controller'=>'jobplans','action'=>''));?></li>
            <li class="upload_video"><?php echo $this->Html->link("My Video", array('controller'=>'employers','action'=>'empVideo'));?></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="side_box">
    <div class="sideprofile_head">
      <h3 class="upcoming_ico">Upcoming Events </h3>
    </div>
    <div class="sidenews_mid industrynews1">
      <div class="sidenews_bottom industrynews1">
        <ul class="dash_ev_list sidebar_upcoming">
        	<?php if(count($upcomingEvents)>0):
			  	foreach($upcomingEvents as $key => $upcomingEvent){
			  ?>
          <li>
            <div class="date_event">
              <div class="dt_lf">
                <div class="dt_rt">  <?php echo  date('M d,Y', strtotime($upcomingEvent['Show']['show_dt'])) ?></div>
              </div>
            </div>
           
            <?php echo $this->Html->link('view more',array('controller'=>'employers','action'=>'eventinfo',$upcomingEvent['Show']['id']),array('class'=>'viewMore'));?>
            <div class="clear"></div>
            <p><?php echo $upcomingEvent['Show']['show_name'];?> <br/>
			 Security Clearance <?php     if($upcomingEvent['Show']['sec_clearance_req']=='n') echo "<strong>Not</strong>";  ?> REQUIRED</p>
              <p class="employer_profile_action">  
             <?php  $register_check=$common->isEmployerRegisteredForEvent($upcomingEvent['Show']['id'],$employerID);
			 if($register_check) { ?> 
			 <a href="" class="regi_not registered"> Registered</a>
			 <?php } else { ?>
			 <a href="" class="regi_not">Not Registered</a>
			  <?php } ?> </p>
     <!--       <p class="employer_profile_action"> <a href="" class="regi_not">Not Registered</a><a href="" class="sold_out">SOLD OUT</a>&nbsp;&nbsp;</p>-->
            <div class="clear"></div>
          	</li>
   			<?php  } // endoreach
			  else: 
				?>
				<tr>
                <td class="table_row" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="6"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">There is no upcoming event in our database.</font></td>
                    </tr>
                  </table></td>
              </tr>
			<?php endif;?>
        </ul>
      </div>
    </div>
  </div>
  <div class="side_box">
    <div class="sideprofile_head">
      <h3 class="discussion_ico">Discussion Board</h3>
    </div>
    <div class="sidenews_mid discussion_board">
      <div class="sidenews_bottom discussion_board">
        <div class="topic_list">
          <div class="topic_panel">
            <ul>
              <li>
                <div class="topic_title">
                <div id="roomlistdrodown">
                 <?php   $chatRoomList = $common->chatRoomList();
					 echo $this->Form->input('room_id',array('label'=>'','options'=>$chatRoomList,'selected'=>$sessroom_id,'type'=>'select','empty'=>'Select Chat Group','error'=>false,'div'=>false,'label'=>false,'id'=>'groupchat_id','style'=>'width:225px;'));
					   ?></div>
            <!--    </div>
                <div class="joinBtn"><a href=""></a></div>-->
              </li>
         <!--     <li>
                <div class="topic_title">Software Engineer</div>
                <div class="joinBtn"><a href=""></a></div>
              </li>
              <li>
                <div class="topic_title">Core Java</div>
                <div class="joinBtn"><a href=""></a></div>
              </li>-->
            </ul>
        <!--    <div class="createNew_btn">
              <img src="<?php echo $this->webroot;?>img/images/create_new.jpg" />
            </div>-->
          </div>
        </div>
        <div class="line"></div>
        <div class="chat_list" id="content" style="margin:7px 0 10px 2px;height:224px;overflow:scroll;width:236px;">
         
     
        </div>
         <div class="chat_field">
         <form action="#" id="form_send" method="post">
         <input type="hidden" name="user_id" id="user_id" value="<?php  echo $this->Session->read('Auth.Clients.id'); ?>" /> 
             <input type="text" size="10" width="100" maxlength="255" class="chat_fld" name="message" id="message" /> 
          <!--   <textarea maxlength="255" class="chat_fld" name="message" id="message"></textarea>-->
           
             <?php echo $this->Form->submit('images/send.jpg');?> 
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
