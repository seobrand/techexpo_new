<div id="wrapper">
  <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor"> Event Details</h1>
          <div class="content">
            <h2 class="mana_subheading"><?php echo $regEventInfo['Show']['show_name'];?> - 
			<?php if($regEventInfo['Show']['show_end_dt']!=''):?>
				<?php echo date("F d, Y",strtotime($regEventInfo['Show']['show_dt']));?> - <?php echo date("M d, Y",strtotime($regEventInfo['Show']['show_end_dt']));?>
			<?php else: ?>
				<?php echo date("F d, Y",strtotime($regEventInfo['Show']['show_dt']));?>
			<?php endif;?>
				</h2>
            <div class="new_event_gray_mid1">
              <div class="new_event_gray_top1">
                <div class="new_event_gray_bot1">
                  <h2 class="mana_subheading">
				  <?php if($regEventInfo['Show']['sec_clearance_req']=='y'):?>
				  	Security clearance is <strong>REQUIRED</strong> to attend this show.
						<?php if(trim($regEventInfo['Show']['sec_clearance_list'])!=''):?><br/>
							IMPORTANT: one or several specific types of clearances are required for this event. If your profile does not meet the requirement, you will not be able to register for the event. We invite you to make sure your <?php echo $this->Html->link("Profile",'editprofile');?> is updated before you register.
						<?php endif;?>
				  <?php else:?>
				  	Security clearance is <strong>NOT REQUIRED</strong> to attend this show.
				  <?php endif;?>
				  </h2>
                  <p><strong>Date & Time:</strong> <span>
				  <?php if($regEventInfo['Show']['show_end_dt']!=''):?>
					<?php echo date("l, F d, Y",strtotime($regEventInfo['Show']['show_dt']));?> - <?php echo date("M d, Y",strtotime($regEventInfo['Show']['show_end_dt']));?> -&nbsp;&nbsp;
				 <?php else: ?>
					<?php echo date("l, F d, Y",strtotime($regEventInfo['Show']['show_dt']));?> -&nbsp;&nbsp;
				<?php endif;?>
				<?php echo $regEventInfo['Show']['show_hours'];?>
				   </span></p>
                  <p><strong>Location: </strong><span><?php echo $regEventInfo['Location']['site_name']." - ".$regEventInfo['Location']['site_address']."&nbsp;".$regEventInfo['Location']['location_city'].", ".$regEventInfo['Location']['location_state']." ".$regEventInfo['Location']['site_zip'];?> </span><br />
                   
                    <span><a href="http://maps.google.com/maps?daddr=<?php echo $regEventInfo['Location']['site_address']." ".$regEventInfo['Location']['location_city']." ".$regEventInfo['Location']['location_state']." ".$regEventInfo['Location']['site_zip'];?>" target="_blank" title="Get directions">Get Directions</a></span></p>
                  <?php if($regEventInfo['Location']['site_phone']!=''):?><p><strong> Phone:</strong> <span><?php echo $regEventInfo['Location']['site_phone']?></span> </p><?php endif;?>
                  <br />
				  <p>
				  <?php if($regEventInfo['Show']['boutique_banner_file']!=''){?>
					 <?php if($regEventInfo['Show']['banner_url']!=''){ ?>
						
                        <a href="<?php echo $regEventInfo['Show']['banner_url'];?>" target="_blank"> <img src="<?php echo $this->webroot;?>ShowsDocument/boutiqueBanner/<?php echo $regEventInfo['Show']['boutique_banner_file'];?>" alt="<?php echo $regEventInfo['Show']['boutique_banner_file'];?>" border="0" height="" width="600px"></a>
                        
                        
					 <?php }else{?>		 
					 	<img src="<?php echo $this->webroot;?>ShowsDocument/boutiqueBanner/<?php echo $regEventInfo['Show']['boutique_banner_file'];?>" alt="<?php echo $regEventInfo['Show']['boutique_banner_file'];?>" border="0" height="" width="600px">
					  <?php }?>
				  <?php }?><br/><br/>
				  <?php echo $regEventInfo['Show']['boutique_special_html'];?>
				  </p>				  
                  <p>
                 
				
                 <!-- <?php echo $this->Html->link($this->Html->image("images/register_event_btn.jpg",array('alt'=>'Invite')),array('controller'=>'shows','action'=>'eventRegister',$regEventInfo['Show']['id']),array('escape'=>false));?>-->
               
				  <?php if($regEventInfo['Show']['ics_file']!=''):?>
				  &nbsp;&nbsp;<a href="<?php echo $this->webroot;?>ShowsDocument/ics/<?php echo $regEventInfo['Show']['ics_file'];?>" target="_blank"><?php echo $this->Html->image("images/add_outlook.jpg",array('alt'=>'Outlook'));?></a>
				  <?php endif;?>
				<!-- <?php echo $this->Html->link($this->Html->image("images/invite_btn.gif",array('alt'=>'Invite')),array('controller'=>'','action'=>''),array('escape'=>false));?>-->
                 </p>
                 
                </div>
              </div>
            </div>
			<?php if($regEventInfo['Show']['boutique']=='b'){ ?>
			  <p><strong>Job Seekers:</strong><span> If you are unable to attend, please<!-- <a href="">submit your resume!</a> --></span></p>
			  <p><strong>Employers/Recruiters:</strong> <span>Interested in exhibiting at our events or having TECHEXPO produce your own open house / customized hiring event?</span> </p>
			  <p><span>Please contact Bradford Rand @ 212.655.4505 x223 or BRand@TechExpoUSA.com.</span></p>
			<?php } ?>
			<?php if($regEventInfo['Show']['boutique']!='b'){ ?>
			
			<?php if($regEventInfo['Show']['show_guide_file']!=''){?> 
			<p>
			 <a href="<?php echo $this->webroot;?>ShowsDocument/showGuide/<?php echo $regEventInfo['Show']['show_guide_file'];?>" target="_blank"><img src="<?php echo $this>webroot;?>img/images/download_show_guide.png" width="250" height="30" alt="" border="0"></a>
			</p>
			<?php } ?>
            <br />
			<?php echo $regEventInfo['Show']['requirements']; ?><br /><br />
			<?php if($regEventInfo['Show']['show_special_html']!=''){ ?>
				<?php echo $regEventInfo['Show']['show_special_html'];?>
			<?php }else{ ?>
				The sponsors of this event have not yet been posted. Please check back with us 2 weeks prior to the event.
			<?php } ?>
			<div class="clear"></div>
            <h1 class="bluecolor"> Exhibitors & Jobs</h1>
            <div class="new_event_gray_mid1">
              <div class="new_event_gray_top1">
                <div class="new_event_gray_bot1">
                  <ul class="new_event_list">
                    <li><span class="event_edit_icon"></span><strong>Company has posted jobs </strong>
                      <div class="clear"></div>
                    </li>
                    <li><span class="event_virtual_icon "></span><strong>Virtual Exhibitors:</strong> they will not be present at the show but are actively hiring & will have the ability to review your resume if you attend or pre-register for this event. You may also apply directly to these companies by clicking on their company links below.
                      <div class="clear"></div>
                    </li>
                  </ul>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
            <div class="alignright"><a href="javascript:void(0);" onclick="showViewList()"><?php echo $this->Html->image("images/viewasLIst_btn.jpg",array('alt'=>'View as List'));?></a></div>
            <div id="viewList" style="display:none;">
			<?php if(count($otherRegEmployer>0)){?>
				<ul class="logo_list">
				<?php foreach($otherRegEmployer as $key => $employer){ $class = ''; ?>
				<?php 
					if(count($employer['JobPosting'])>0){
						$class .= 'class="jobs"';
					}elseif(count($employer['ShowEmployer'])>0){ 
						foreach($employer['ShowEmployer'] as $key => $isvirtual){
							if($isvirtual['virtual'] == 'y'){
								$class .= 'class="virtual"';
							}
						}					
					}else{
						$class .= 'class="no_jobs"';
					}
						
				?>
				  <li <?php echo $class;?>><a href="<?php echo $this->webroot;?>Jobseeker/candidates/employeDetail/<?php echo $employer['Employer']['id'];?>"><div class="logo_img"><img alt="" src="<?php echo $this->webroot;?>img/images/new1.jpg"></div><div class="logo_company"><?php echo $employer['Employer']['employer_name'];?></div> <div class="clear"></div></a></li>
                  
                  
                  
				<?php } ?>
				</ul>
			<?php }?>
			</div>
            <div class="clear"></div>
            <br />
            <div class="new_event_gray_mid1">
              <div class="new_event_gray_top1">
                <div class="new_event_gray_bot1">
                  <ul class="list new_event_list_bullet">
                    <li  style="font-size:14px">Invite your friends, family & colleagues who are experienced professionals with an active  security clearance.</li>
                    <li  style="font-size:14px">This event is for experienced technologists, engineers, programmers, analysts, developers, administrators, 
                      consultants & more...</li>
                    <li  style="font-size:14px">For a full list of companies recruiting at this event and their open jobs, <a href="#viewList" onclick="showViewList()">click here.</a></li>
                    <li  style="font-size:14px">Research the companies you are interested in interviewing with in advance & bring many resumes to the event.</li>
                    <li  style="font-size:14px">Business or military attire is strongly recommended when attending the event.</li>
                    <li  style="font-size:14px">Please visit this website monthly for new hiring events and job opportunities worldwide.</li>
                    <li  style="font-size:14px">Admission is free to attend.</li>
                  </ul>
                  <p><strong>Job Seekers:</strong><span> If you are unable to attend, please <a href="">submit your resume!</a> </span></p>
                  <p><strong>Employers/Recruiters:</strong> <span>Interested in exhibiting at our events or having TECHEXPO produce your own open house / customized hiring event?</span> </p>
                  <p><span>Please contact Bradford Rand @ 212.655.4505 x223 or BRand@TechExpoUSA.com.</span> </p>
                </div>
              </div>
            </div>
            <p class="bigfont">Our professional hiring events have benefited nearly a million attendees since 1993. We look forward to helping you advance your career and saving you time in your job search by providing you the opportunity to meet face to face with the nation's leading companies. Thank you for joining us; we look forward to meeting you at 
              our expos! </p>
            <ul class="list">
              <li style="font-size:14px">Business or military attire is highly recommended when attending the event. Admission is free.</li>
              <li  style="font-size:14px">Bring many copies of your resumes to hand out to employers & arrive early to maximize your interviewing time at the event.</li>
              <li  style="font-size:14px">Be prepared to visit with the companies & organizations of your choice by researching them in advance.</li>
              <li  style="font-size:14px">Pre-register online</li>
              <li  style="font-size:14px">This will allow recruiters to find your resume & schedule face-to-face interviews before the event. It also saves you time when 
                you arrive at the show.</li>
              <li  style="font-size:14px">We encourage you to invite your friends, colleagues & family members who are experienced professionals with an  
                active clearance.</li>
              <li  style="font-size:14px">Prepare & practice your brief personal description of your professional skills, unique abilities, past successful 
                accomplishments & releant experience.</li>
              <li  style="font-size:14px">Follow up immediately with all of the companies that were of strong interest to you with a phone call, email and or letter. </li>
              <li  style="font-size:14px">The evening before the event, get a good night's sleep. The morning of the show try to eat a healthy breakfast and 
                to exercise. </li>
            </ul>
            <p>If you have any questions or require further information, please e-mail <a href="mailto:admin@techexpoUSA.com">admin@techexpoUSA.com.</a> </p>
			<?php } ?>
          </div>
        </div>
      </div>
    </div>
     <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    	<?php echo $this->element('partners', array('cache' => true)); ?> 
  </div>
</div>
<script type="text/javascript">
function showViewList(){
	if(document.getElementById('viewList').style.display =='none')
		document.getElementById('viewList').style.display ='block';
	else
		document.getElementById('viewList').style.display ='none';
	
}
</script>