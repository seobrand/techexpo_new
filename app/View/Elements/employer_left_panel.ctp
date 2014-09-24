<?php 
$limitJobs = $common->GetEmployerJobLimit($this->Session->read('Auth.Client.employerContact.employer_id'));

 $upcomingEvents=$common->upcomingevent();  
 $employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
 $logoImage=$common->getemplogo(); 
 $getemplogoDes=$common->getemplogoDes();
 ?>
 <script type="text/javascript">
$(document).ready(function(){
			
			
			
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
      <h3 class="jobseeker_ico"><!--<?php echo $this->Text->truncate(ucfirst($this->Session->read('Auth.Clients.username')), 16); ?>'s Profile-->
      Company Profile</h3>
    </div>
   
    <div class="sidenews_mid employer_mid_profile">
      <div class="sidenews_bottom employer_mid_profile">
        <div class="sidepanel_padding seeker_profile">
   		<a href="<?php echo Router::url('/', true); ?>employers/profileImage">
          <div class="seeker_pro_img" style="display:table;"> </div>
          
		     <?php
			
			 
			  if($logoImage && file_exists('upload/150x80_'.$logoImage)){ ?>
             
              <div style="height:140px;display:table-cell;  vertical-align:middle;">
              <div style="text-align:center;width:210px;">
             <!-- <img src="<?php echo $this->webroot.'upload/cropped0_'.$logoImage;?>" alt="<?php echo $logoImage; ?>"    style="margin-left:16px;"/>-->
               <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$logoImage;?>&maxw=186&maxh=140" style="margin-left:30px;"  alt="<?php echo $getemplogoDes; ?>"/>
              </div>
              </div>
           <?php }else{ ?>
               <div style="height:140px;">
               <img src="<?php echo $this->webroot?>img/images/profile_pic.jpg" class="profile_pic" />
          		<?php //echo $this->Html->image("images/profile_pic.jpg",array('alt'=>'','url'=>array('controller'=>'employers','action'=>'profileImage'),'class'=>'profile_pic'));?>
               </div>
           <?php } ?>
           </a>
          <ul class="profile_actions">
            <li class="add"><?php echo $this->Html->link("Add / Change Company Logo", array('controller'=>'employers','action'=>'profileImage'));?></li>
            <li class="edit"><?php echo $this->Html->link("Edit Company Profile", array('controller'=>'employers','action'=>'editprofile'));?></li>
            
    <?php   $trialAccunt = $this->Session->read('TrialAccountEmp');
			if($trialAccunt==1){    ?>       
<li class="upload"><a href="javascript:void(0);" onclick="trialAccountPopup()" >Manage Jobs </a> </li>
<li class="upload"><a href="javascript:void(0);" onclick="trialAccountPopup()" >Purchase Job Postings </a></li>
   <?php } else { ?>  
  <li class="upload"><?php echo $this->Html->link("Manage Jobs", array('controller'=>'employers','action'=>'joblists'));?></li>
<li class="upload"><?php echo $this->Html->link("Purchase Job Postings", array('controller'=>'jobplans','action'=>''));?></li>         
           
    <?php } ?>
            <li class="upload_video"><?php echo $this->Html->link("Corporate Videos", array('controller'=>'employers','action'=>'empVideo'));?></li>
            <li class="register_events"><?php echo $this->Html->link("Register For Events", array('controller'=>'employers','action'=>'eventregistrationform'));?></li>
            
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!--------------------------------------  employer event section ------------------------------------------------->      
  
  <div class="side_box">
    <div class="sideprofile_head">
      <h3 class="upcoming_ico">Upcoming Events </h3>
    </div>
    <div class="sidenews_mid industrynews1">
      <div class="sidenews_bottom industrynews1">
        <ul class="dash_ev_list sidebar_upcoming">
        	<?php
			
			 if(count($upcomingEvents)>0)
			{
			
			
			  	foreach($upcomingEvents as $key => $upcomingEvent){
			  ?>
          <li>
           
            <p> 
            <span>
			<a href="<?php echo $this->Html->url(array('controller'=>'shows','action'=>'view',$upcomingEvent['Show']['id'])) ; ?>" >
			<?php  if(!empty($upcomingEvent['ShowsHome']['display_name'])) echo $upcomingEvent['ShowsHome']['display_name']; else  echo $upcomingEvent['Show']['show_name'];?>
            </a>
            </span>
            <br/>
            <?php  /*$upcomingEvent['Location']['site_address'].','.$upcomingEvent['Location']['site_name'].'<br/>'.*/ echo $upcomingEvent['Location']['location_city'].','.$upcomingEvent['Location']['location_state'];?><br/>
			
            <?php if(!empty($upcomingEvent['ShowsHome']['special_message'])) echo $upcomingEvent['ShowsHome']['special_message']; else { ?>
        
        	 Security Clearance <?php     if($upcomingEvent['Show']['sec_clearance_req']=='n') echo "<strong>Not</strong>";  ?> REQUIRED</p>
             <?php } ?>
                <div class="date_event">
                <div class="dt_lf">
                <div class="dt_rt">  <?php echo  date('M d, Y', strtotime($upcomingEvent['Show']['show_dt'])) ?></div>
                </div>
                </div>
                <?php // echo $this->Html->link('view more',array('controller'=>'shows','action'=>'view',$upcomingEvent['Show']['id']),array('class'=>'viewMore'));?>
                <span style="float:right;">  
             <?php  $register_check=$common->isEmployerRegisteredForEvent($upcomingEvent['Show']['id'],$employerID);
			
			if($register_check) { ?> 
			 <span class="regi_not" style="margin-top:3px !important"><?php echo $this->Html->image("registered.png");?> </span>
			 <?php } else { 
            if($this->Session->read('Auth.Client.User.user_type')=='E')
			{ ?>
			 <font color="#B40105" ><a style="text-decoration:none !important;" href="<?php echo $this->Html->url(array('controller'=>'employers','action'=>'eventinfo',$upcomingEvent['Show']['id'])) ; ?>" >
			Register </a> </font>
			<?php 
    		}
			else{ ?>
      	   <font color="#B40105" ><a style="text-decoration:none !important;" href="<?php echo $this->Html->url(array('controller'=>'shows','action'=>'view',$upcomingEvent['Show']['id'])) ; ?>" >
			Register </a> </font>
	   		<?php } ?>
             <?php } ?> </span>
            
              <p class="employer_profile_action">  
             </p>
     <!--       <p class="employer_profile_action"> <a href="" class="regi_not">Not Registered</a><a href="" class="sold_out">SOLD OUT</a>&nbsp;&nbsp;</p>-->
           
            
          <br/>
           
           
          	</li>
   			<?php  }} // endoreach
			  else
			  {
				?>
				<tr>
                <td class="table_row" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="6"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">There is no upcoming event in our database.</font></td>
                    </tr>
                  </table></td>
              </tr>
			<?php } ?>
        </ul>
      </div>
    </div>
  </div>
  
   <!--------------------------------------  employer event section ------------------------------------------------->        
  
</div>
