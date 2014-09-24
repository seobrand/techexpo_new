<style type="text/css">
	ul.list li{ font-size:14px;}
</style>
<?php 
	
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
 ?>
<script type="text/javascript">
$(function(){
	$(".ajax").colorbox();
});
function mypopup()
{
	mywindow = window.open("<?php echo FULL_BASE_URL.router::url('/',false).'users/tellaFriend'; ?>", "mywindow", "location=1,status=1,scrollbars=1,  width=500,height=300");
	mywindow.moveTo(0, 0);
}
</script>
<?php 
$show_time=strtotime($regEventInfo['Show']['show_dt']);
$current_time=time();	
$diff=$show_time-$current_time;	
$days = (floor(($diff) / (60 * 60 * 24))) + 1;
?>
<div id="wrapper">

 <?php 
	if($this->Session->read('Auth.Client.Candidate.id')!='')
	{
		echo $this->element('jobSeekerMenu', array('cache' => true));
	}
	
	if($this->Session->read('Auth.Client.employerContact.id')!='')
	{
		 echo $this->element('employer_tabs');
	}
 ?>
<?php $candidateID = $this->Session->read('Auth.Client.Candidate.id'); ?>
<?php /***** check candidate is registered in this event or not ******/ ?>
<?php $chekRegistration = $common->isCandidateRegForEvent($candidateID,$regEventInfo['Show']['id']);?> 
 
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor"><?php  if(!empty($regEventInfo['ShowsHome']['display_name'])) echo $regEventInfo['ShowsHome']['display_name']; else  echo $regEventInfo['Show']['show_name'];?><?php // echo $regEventInfo['Show']['show_name'];?>
          </h1>

          <div class="content">
            <h2 class="mana_subheading">
             <?php if(!empty($regEventInfo['ShowsHome']['special_message'])) echo $regEventInfo['ShowsHome']['special_message']; ?>
              <?php /* if($regEventInfo['Show']['show_end_dt']!=''):?>
              <?php echo date("F d, Y",strtotime($regEventInfo['Show']['show_dt']));?> - <?php echo date("M d, Y",strtotime($regEventInfo['Show']['show_end_dt']));?>
              <?php else: ?>
              <?php echo date("F d, Y",strtotime($regEventInfo['Show']['show_dt']));?>
              <?php endif; */?>
            </h2>
            <div class="new_event_gray_mid1">
              <div class="new_event_gray_top1">
                <div class="new_event_gray_bot1">
                  <h2 class="mana_subheading">
                    <?php if($regEventInfo['Show']['sec_clearance_req']=='y'):?>
                    Security Clearance is <strong style="color:#FF0000">REQUIRED</strong> to attend this show.<br/>
                    
                    <?php if(trim($regEventInfo['Show']['sec_clearance_list'])!=''):?>
                    <br/>
                    IMPORTANT: one or several specific types of clearances are required for this event. If your profile does not meet the requirement, you will not be able to register for the event. We invite you to make sure your <?php echo $this->Html->link("Profile",'editprofile');?> is updated before you register.
                    <?php endif;?>
                    <?php else:?>
                    Security Clearance is <strong>NOT REQUIRED</strong> to attend this show.
                    <?php endif;?>
                  </h2>
                  <!--------------------------------------------------------------------------------->
                   <?php /* <span style="float:right;">
                      <?php 
						  $eventShareUrl = $_SERVER['SERVER_NAME'].$this->webroot."shows/view/".$regEventInfo['Show']['id'];
						  $eventSharetitle = $regEventInfo['Show']['show_name'];?>
                      <a href="http://www.facebook.com/sharer.php?u=<?php echo FULL_BASE_URL.router::url('/',false).'shows/view/'.$regEventInfo['Show']['id'];?>&t=event" target="_blank"><?php echo $this->Html->image('images/face.jpg');?></a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="http://twitter.com/home?status=<?php echo $eventShareUrl;?>" title="Click to share this post on Twitter" target="_blank"><img src="<?php echo $this->webroot;?>img/images/twitt.jpg" alt="" /></a> &nbsp;&nbsp; <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $eventShareUrl; ?>&title=<?php echo $eventSharetitle; ?>&summary=<?php echo $regEventInfo['Show']['show_name'].'-'.date('M d,Y', strtotime($regEventInfo['Show']['show_dt']));  ?>source=techexpousa.com" target="_blank"><img src="<?php echo $this->webroot;?>img/images/link.jpg" alt="" /></a> &nbsp;&nbsp;
                
                      
                       <a href="https://plus.google.com/share?url=<?php echo $currentURL;?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img
  src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/images.png" alt="Share on Google+" /></a>
  
                      </span>  <span style="float:right;margin:5px 10px 0 0;"> Share this event: </span><br/> */?>
                  <!--------------------------------------------------------------------------------->
                  
                  <p><strong>Date & Time:</strong> <span class="event_datetime_text">
                    <?php if($regEventInfo['Show']['show_end_dt']!=''):?>
                    <?php echo date("l, F d, Y",strtotime($regEventInfo['Show']['show_dt']));?> - <?php echo date("M d, Y",strtotime($regEventInfo['Show']['show_end_dt']));?> -&nbsp;
                    <?php else: ?>
                    <?php echo date("l, F d, Y",strtotime($regEventInfo['Show']['show_dt']));?> -&nbsp;
                    <?php endif;?>
                    <?php echo $regEventInfo['Show']['show_hours'];?> </span></p><p></p>
                    
                     <?php  $addressRT='';
	  if($this->Session->read('Auth.Clients.user_type')=='C')
	  { 
		 //$addressRT = $this->Session->read('Auth.Client.Candidate.candidate_address').'&nbsp;'.$this->Session->read('Auth.Client.Candidate.candidate_city').'&nbsp;'.$this->Session->read('Auth.Client.Candidate.candidate_zip');
		 
		 $addressRT = $this->Session->read('Auth.Client.Candidate.candidate_address');
	  }
	  else if($this->Session->read('Auth.Clients.user_type')=='E')
	  {
		 $addressRT = $this->Session->read('Auth.Client.employerContact.contact_address').'&nbsp;'.$this->Session->read('Auth.Client.employerContact.contact_city').'&nbsp;'.$this->Session->read('Auth.Client.employerContact.contact_zip'); 
		  
	  }
	 
	  
	  
	  
	 ?>
	            <div class="showsdetail_location_label"><strong>Location: </strong></div>
				<div class="showsdetail_location_val">
					<span><?php echo $regEventInfo['Location']['site_name']."<br/>".$regEventInfo['Location']['site_address']."<br/>".$regEventInfo['Location']['location_city'].", ".$regEventInfo['Location']['location_state']." ".$regEventInfo['Location']['site_zip'];?> </span><br />
	                <span><a href="http://maps.google.com/maps?saddr=<?php echo $addressRT; ?>&daddr=<?php echo $regEventInfo['Location']['site_address']." ".$regEventInfo['Location']['location_city']." ".$regEventInfo['Location']['location_state']." ".$regEventInfo['Location']['site_zip'];?>" target="_blank" title="Get directions">Get Directions</a></span>
	            </div>                  
                   
                  <?php if($regEventInfo['Location']['site_phone']!=''):?>
                  <p><strong>Venue Telephone:</strong> <span><?php echo $regEventInfo['Location']['site_phone']?></span> </p>
                  <?php endif;?>
                  <?php if($days > 0){?>
                   		<p><strong>Countdown to Event :</strong> <?php echo $days; ?> Days</p>
                    <?php } ?>
                  <p>
                    <?php if($regEventInfo['Show']['boutique_banner_file']!=''){?>
                    <?php if($regEventInfo['Show']['banner_url']!=''){ ?>
                    <a href="<?php if (strpos($regEventInfo['Show']['banner_url'],'http://') === false){ echo 'http://'.$regEventInfo['Show']['banner_url']; }else{ echo $regEventInfo['Show']['banner_url'];}?>" target="_blank"> <img src="<?php echo $this->webroot;?>ShowsDocument/boutiqueBanner/<?php echo $regEventInfo['Show']['boutique_banner_file'];?>" alt="<?php echo $regEventInfo['Show']['boutique_banner_file'];?>" border="0" height="" width="600px"></a>
                    <?php }else{?>
                    <img src="<?php echo $this->webroot;?>ShowsDocument/boutiqueBanner/<?php echo $regEventInfo['Show']['boutique_banner_file'];?>" alt="<?php echo $regEventInfo['Show']['boutique_banner_file'];?>" border="0" height="" width="600px">
                    <?php }?>
                    <?php }?>
                    <?php if($regEventInfo['Show']['boutique_special_html']!=''){?>
                    <br/>
                    <br/>
                    <?php echo $regEventInfo['Show']['boutique_special_html'];?>
                    <?php } ?>
                     <?php  	$theComponent = new commonComponent(new ComponentCollection());
							$location_city = $theComponent->getLocationInfo('location_city',$regEventInfo['Show']['location_id']);
							$location_state = $theComponent->getLocationInfo('location_state',$regEventInfo['Show']['location_id']);
							$location_address = $theComponent->getLocationInfo('site_address',$regEventInfo['Show']['location_id']);
							
				?>
                  </p>
                  <p>
                    <?php if($this->Session->read('Auth.Client.employerContact.employer_id')!=''){?>
                    <?php echo $this->Html->image("images/register_event_btn.jpg",array('url'=>array('controller'=>'employers','action'=>'eventregistrationform'),'alt'=>'Register for this event'));?>
                    <?php } ?>
                    <?php if($regEventInfo['Show']['ics_file']!='' && file_exists('ShowsDocument/ics/'.$regEventInfo['Show']['ics_file'])){?>
	                   <?php /*?> &nbsp;&nbsp;<a href="<?php echo ICAL_PATH;?>ShowsDocument/ics/<?php echo $regEventInfo['Show']['ics_file'];?>" target="_blank"><?php echo $this->Html->image("images/add_outlook_blue.jpg",array('alt'=>'Outlook'));?>
	                    </a><?php */?>
                     <?php 
					  echo $this->Html->link($this->Html->image("images/add_outlook_blue.jpg"), array('Jobseeker'=>false,'controller'=>'users','action'=>'downloadfilehome',$regEventInfo['Show']['ics_file']),array('escape'=>false));
					 
					 }else{?>                      
                      <?php
					  echo $this->Html->link($this->Html->image("images/add_outlook_blue.jpg",array('alt'=>'Outlook')), array('controller'=>'users','action'=>'icalenderOrg',$regEventInfo['Show']['id'],'Jobseeker'=>false),array('escape'=>false));
					   /*echo $this->Html->link($this->Html->image("images/add_outlook_blue.jpg",array('alt'=>'Outlook')), array('controller'=>'users','action'=>'icalender','Jobseeker'=>false,date('Ymd', strtotime($regEventInfo['Show']['show_dt'])),$regEventInfo['Show']['show_name'],$regEventInfo['Show']['show_name']."\n ".$regEventInfo['Location']['site_name']."\n ".$regEventInfo['Location']['site_address']."\n ".$regEventInfo['Location']['location_city']."\n ".$regEventInfo['Location']['location_state']." ".$regEventInfo['Location']['site_zip']),array('escape'=>false));*/
					   
					    } ?>
                    &nbsp;&nbsp;<?php echo $this->Html->link($this->Html->image("images/invite_btn.gif",array('class'=>'newsletter_submit')), array('controller'=>'users','action'=>'tellaFriendEvent','Jobseeker'=>false),array('class'=>'ajax','escape'=>false)); ?>&nbsp;&nbsp;
                    <?php if($chekRegistration){?>                      	
                      	<strong style="position: relative;top:-10px;font-size:10px;"> <?php echo $this->Html->image("registered.png"); ?> <!--You are currently registered for this show--></strong>
                      <?php }elseif($this->Session->read('Auth.Clients.user_type')=='C'){ ?>
                      	<?php echo $this->Html->image("images/register_event_btn.jpg",array('url'=>array('controller'=>'','action'=>'shows/eventRegister',$regEventInfo['Show']['id']),'alt'=>'Register for this event'));?>
                      <?php }elseif($candidateID=="" && $this->Session->read('Auth.Client.employerContact.id')==""){ ?>
                      	<?php echo $this->Html->image("images/register_event_btn_new.jpg",array('url'=>array('controller'=>'','action'=>'jobseeker_register'),'alt'=>'Register for this event'));?>
                      <?php }?>
                    </p>
                </div>
              </div>
            </div>
            <?php if($regEventInfo['Show']['boutique']=='b'){ ?>
            <p><strong>Job Seekers:</strong><span> If you are unable to attend, please <?php echo $this->Html->link('Submit your resume!', array('controller'=>'candidates','action'=>'register'));?> </span></p>
            <p><strong>Employers/Recruiters:</strong> <span>Interested in exhibiting at our events or having TECHEXPO produce your own open house / customized hiring event?</span> </p>
            <p><span>Please contact Bradford Rand @ 212.655.4505 x223 or BRand@TechExpoUSA.com.</span></p>
            <?php } ?>
            <?php if($regEventInfo['Show']['boutique']!='b'){ ?>
            <?php if($regEventInfo['Show']['show_guide_file']!=''){?>
            <p> <a href="<?php echo $this->webroot; ?>ShowsDocument/showGuide/<?php echo $regEventInfo['Show']['show_guide_file'];?>" target="_blank"> <img src="<?php echo $this->webroot;?>img/images/download_show_guide.png" width="250" height="30" alt="" border="0"></a> </p>
            <?php } ?>
            
            
            
          
    <!--        <div class="new_event_gray_mid1">
              <div class="new_event_gray_top1">
                <div class="new_event_gray_bot1">
                  <?php if($regEventInfo['Show']['requirements']!=''){ ?>
                  <?php echo str_replace('<ul>','<ul class="list new_event_list_bullet">', $regEventInfo['Show']['requirements']);?>
                  <?php } ?>
                  <ul class="list new_event_list_bullet">
                    <li  style="font-size:14px">Invite your friends, family & colleagues who are experienced professionals with an active  security clearance.</li>
                    <li  style="font-size:14px">This event is for experienced technologists, engineers, programmers, analysts, developers, administrators, 
                      consultants & more...</li>
                    <li  style="font-size:14px">For a full list of companies recruiting at this event and their open jobs, <a href="#viewAll" >click here.</a></li>
                    <li  style="font-size:14px">Research the companies you are interested in interviewing with in advance & bring many resumes to the event.</li>
                    <li  style="font-size:14px">Business or military attire is strongly recommended when attending the event.</li>
                    <li  style="font-size:14px">Please visit this website monthly for new hiring events and job opportunities worldwide.</li>
                    <li  style="font-size:14px">Admission is free to attend.</li>
                  </ul>
               
                  <p><strong>Employers/Recruiters:</strong> <span>Interested in exhibiting at our events or having TECHEXPO produce your own open house / customized hiring event?</span> </p>
                  <p><span>Please contact Bradford Rand @ 212.655.4505 x223 or BRand@TechExpoUSA.com.</span> </p>
                </div>
              </div>
            </div>-->
         
            
            
            <div class="clear"></div>
            <h1 class="bluecolor"> Exhibitors & Jobs</h1>
            <div class="new_event_gray_mid1">
              <div class="new_event_gray_top1">
                <div class="new_event_gray_bot1">
                  <ul class="new_event_list" id="exhibitors_info" style="display:none;" >
                    <li><span class="event_edit_icon"></span><strong>Company has posted jobs </strong>
                      <div class="clear"></div>
                    </li>
                    <li><span class="event_virtual_icon "></span><strong>Virtual Exhibitors:</strong> they will not be present at the show but are actively hiring & will have the ability to review your resume if you attend or pre-register for this event. You may also apply directly to these companies by clicking on their company links below.
                      <div class="clear"></div>
                    </li>
                  </ul>
                  <div class="clear"></div>
                  <div id="viewAll" >
                  <div class="alignright" id="viewAsList" style="display:block;"><a href="javascript:void(0);" onclick="showViewList()">
				  <?php echo $this->Html->image("images/viewasLIst_btn.jpg",array('alt'=>'View as List'));?>
                  
                  
                  </a></div>
				  <div class="alignright" id="viewAsLogo" style="display:none;">
                  <a href="javascript:void(0);" onclick="showViewList()"><?php echo $this->Html->image("images/view_logo_btn.jpg",array('alt'=>'View as Logo'));?></a></div>
                  </div>
                  <br/>
                  <?php if(count($otherRegEmployer)==0){?>
                      <div style="text-align: center;" class="bigfont">Please check back 2 weeks before this event to view what companies are participating.</div>
                  <?php }?>
                  <br/>
                  <div id="viewLogoList" style="display:block;overflow:hidden;">
                    <?php if(count($otherRegEmployer>0)){?>
                     <div class="show_virtualsap" id="currentExhib"> Current Exhibitors</div>
                    <ul class="logo_list" id="currentExhibdata">
                      <?php foreach($otherRegEmployer as $key => $employer){ $class = ''; ?>
                      <?php $VirtualExhibitor=0;
							if(count($employer['JobPosting'])>0){
								$class .= 'class="jobs"';
							}elseif(count($employer['ShowEmployer'])>0){ 
								foreach($employer['ShowEmployer'] as $key => $isvirtual){
									if($isvirtual['show_id']==$show_id){ // task id #3853
										if($isvirtual['virtual'] == 'y'){
											$class = 'class="virtual"';
											$VirtualExhibitor = 1;
										}else{
											$VirtualExhibitor = 0;
											
										}
									}
								}					
							}else{
								$class .= 'class="no_jobs"';
							}
						?>
                        
                          <?php if($VirtualExhibitor!=1) { ?> 
                      <li  style="height:auto !important"> <a href="<?php echo $this->webroot;?>employers/viewprofile/<?php echo $employer['Employer']['id'];?>">
                        <div class="logo_img" style="width:200px;">
                        <div style="text-align:center;width:176px;height:110px;display:table-cell;vertical-align:middle;background-image:url(<?php echo FULL_BASE_URL.router::url('/',false); ?>img/images/new_event_box.jpg);">
                            <?php if($employer['Employer']['logo_file']!=''){?>
                            <?php // echo $this->Html->image('../upload/150x80_'.$employer['Employer']['logo_file'],array('width'=>'150px','height'=>'80px','title'=>$employer['Employer']['employer_name'])); ?>
                            <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$employer['Employer']['logo_file'];?>&maxw=150&maxh=80" alt="<?php echo $employer['Employer']['employer_name']; ?>" title="<?php echo $employer['Employer']['employer_name']; ?>"  />
                            <?php }else{ ?>
                            <?php // echo $this->Html->image('no_logo_thumb.jpg',array('width'=>'150px','height'=>'80px','title'=>$employer['Employer']['employer_name'])); ?>
                            <div class="show_noimage" ><?php echo $employer['Employer']['employer_name']; ?></div>
                            <?php } ?>
                          </div>
						</div>
                        <div class="clear"></div>
                        </a> </li>
                      <?php } } ?>
                    </ul>
                    
                      <div style="clear:both;"></div>
                       <div class="show_virtualsap" id="virtualExhib"> Virtual Exhibitors</div>
                    <ul class="logo_list" id="virtualExhibdata">
                      <?php foreach($otherRegEmployer as $key => $employer){ $class = ''; ?>
                      <?php $VirtualExhibitor=0;
							if(count($employer['JobPosting'])>0){
								$class .= 'class="jobs"';
							}elseif(count($employer['ShowEmployer'])>0){ 
								foreach($employer['ShowEmployer'] as $key => $isvirtual){
									if($isvirtual['show_id']==$show_id){ // task id #3853
										if($isvirtual['virtual'] == 'y'){
											$class = 'class="virtual"';
											$VirtualExhibitor = 1;
											
										}else{
											$VirtualExhibitor = 0;
										}
									}
								}					
							}else{
								$class .= 'class="no_jobs"';
							}
						?>
                          <?php if($VirtualExhibitor==1) { ?> 
                      <li  style="height:auto !important"> <a href="<?php echo $this->webroot;?>employers/viewprofile/<?php echo $employer['Employer']['id'];?>">
                        <div class="logo_img" style="width:200px;">
                        <div style="text-align:center;width:176px;height:110px;display:table-cell;vertical-align:middle;background-image:url(<?php echo FULL_BASE_URL.router::url('/',false); ?>img/images/new_event_box.jpg);">
                            <?php if($employer['Employer']['logo_file']!=''){?>
                            <?php // echo $this->Html->image('../upload/150x80_'.$employer['Employer']['logo_file'],array('width'=>'150px','height'=>'80px','title'=>$employer['Employer']['employer_name'])); ?>
                            <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$employer['Employer']['logo_file'];?>&maxw=150&maxh=80" alt="<?php echo $employer['Employer']['employer_name']; ?>" title="<?php echo $employer['Employer']['employer_name']; ?>"  />
                            <?php }else{ ?>
                            <?php // echo $this->Html->image('no_logo_thumb.jpg',array('width'=>'150px','height'=>'80px','title'=>$employer['Employer']['employer_name'])); ?>
                            <div class="show_noimage" ><?php echo $employer['Employer']['employer_name']; ?></div>
                            <?php } ?>
                          </div>
						</div>
                        <div class="clear"></div>
                        </a> </li>
                      <?php } } ?>
                    </ul>
                    
                    
                 
                    <?php }?>
                  </div>
                         <script type="text/javascript">
					$(function(){
						if($("#currentExhibdata li").size() == 0)
						{
						$("#currentExhib").hide();
						}
						if($("#virtualExhibdata li").size() == 0)
						{
						$("#virtualExhib").hide();
						}
						});
					</script>
                  <div id="viewNameList" style="display:none;overflow:hidden;">
                    <?php if(count($otherRegEmployer>0)){?>
                    <ul class="logo_list">
                      <?php foreach($otherRegEmployer as $key => $employer){ $class = ''; ?>
                      <?php 
							if(count($employer['JobPosting'])>0){
								$class .= 'class="jobs"';
							}elseif(count($employer['ShowEmployer'])>0){ 
								foreach($employer['ShowEmployer'] as $key => $isvirtual){
									if($isvirtual['show_id']==$show_id){ // task id #3853
										if($isvirtual['virtual'] == 'y'){
											$class = 'class="virtual"';
										}else{
											$class = 'class="jobs no_jobs"';
										}
									}
								}					
							}else{
								$class .= 'class="jobs no_jobs"';
							}
								
						?>
                      <li <?php echo $class;?>><a href="<?php echo $this->webroot;?>employers/viewprofile/<?php echo $employer['Employer']['id'];?>">
                        <div class="logo_company2 logo_company_text"><?php echo $employer['Employer']['employer_name'];?></div>
                        <div class="clear"></div>
                        </a> </li>
                      <?php } ?>
                    </ul>
                    <?php }?>
                  </div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <h1 class="bluecolor"> Be Prepared</h1>
            <div class="new_event_gray_mid1">
              
              <div class="new_event_gray_bot1">
                    <p class="bigfont" style="font-size:14px; color:#3A3A3A;">Our professional hiring events have benefited nearly a million attendees since 1993. We look forward to helping you advance your career and saving you time in your job search by providing you the opportunity to meet face to face with the nation's leading companies. Thank you for joining us; we look forward to meeting you at our expos!</p>
                    <ul class="list">
                      <li style="font-size:14px">Business or military attire is highly recommended when attending the event. Admission is free.</li>
                      <li  style="font-size:14px">Bring many copies of your resume to hand out to employers & arrive early to maximize your interviewing time at the event.</li>
                      <li  style="font-size:14px">Be prepared to visit with the companies & organizations of your choice by researching them in advance.</li>
                      <li  style="font-size:14px">
                      
                     
                      
                                 <?php  
	   
		echo $this->Html->link('Pre-register online',array('controller'=>'shows','action'=>'eventRegister',$regEventInfo['Show']['id'],'Jobseeker'=>true), array('escape' => false));
	
	  
	  
	 ?>
              
                      
                      This will allow recruiters to find your resume & schedule face-to-face interviews before the event. It also saves you time when you arrive at the show.</li>
                      <li  style="font-size:14px">We encourage you to invite your friends, colleagues & family members who are experienced professionals with an active clearance.</li>
                      <li  style="font-size:14px">Prepare & practice your brief personal description of your professional skills, unique abilities, past successful accomplishments & relevant experience.</li>
                      <li  style="font-size:14px">Follow up immediately with all of the companies that were of strong interest to you with a phone call, email and/or letter. </li>
                      <li  style="font-size:14px">The evening before the event, get a good night's sleep. The morning of the show try to eat a healthy breakfast and exercise. </li>
                    </ul>
                    <span><strong>Job Seekers</strong>: If you are unable to attend, please Submit your resume!</span><br/><br/>
                    <span><strong>Employers/Recruiters</strong>: Interested in exhibiting at our events or having TECHEXPO produce your own open house or customized hiring event? </span><br/><br/>
					<span>	Please contact Bradford Rand @ 212.655.4505 x223 or <a href="mailto:BRand@TechExpoUSA.com">BRand@TechExpoUSA.com</a>.</span><br/><br/>
                    <span>If you have any questions or require further information, please e-mail <a href="mailto:Amanda@TechExpoUSA.com">Amanda@TechExpoUSA.com.</a> </span>
                  </div>
            </div>
            <div class="clear"></div>
            
           <div class="new_event_gray_mid1">
              <div class="new_event_gray_top1">
                <div class="new_event_gray_bot1">
                  <?php if($regEventInfo['Show']['show_special_html']!=''){ ?>
                  <?php echo $regEventInfo['Show']['show_special_html'];?>
                  <?php }else{ ?>
                  <p>The exhibitors of this event have not yet been posted. Please check back with us 2 weeks prior to the event.</p>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
   <?php 
		 if($this->Session->read('Auth.Client.Candidate.id')!='')
			{
			
				echo $this->element('jobSeekerSidebar', array('cache' => true)); 
				
			}elseif($this->Session->read('Auth.Client.employerContact.id')!='')
			{
				
				echo $this->element('employer_left_panel');
			}else
			{
				echo $this->element('main_login_leftbar', array('cache' => true)); 
       			echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); 
			}
	   ?>
    <div class="clear"></div>
    <?php echo $this->element('partners'); ?> </div>
</div>
<script type="text/javascript">
function showViewList(){
	
	if(document.getElementById('viewLogoList').style.display =='block'){
		document.getElementById('viewLogoList').style.display ='none';
		document.getElementById('viewNameList').style.display ='block';
		document.getElementById('viewAsList').style.display ='none';
		document.getElementById('viewAsLogo').style.display ='block';
		document.getElementById('exhibitors_info').style.display ='block';
	}else{
		document.getElementById('viewNameList').style.display ='none';
		document.getElementById('viewLogoList').style.display ='block';
		document.getElementById('viewAsList').style.display ='block';
		document.getElementById('viewAsLogo').style.display ='none';
		document.getElementById('exhibitors_info').style.display ='none';
	}
}
</script>
