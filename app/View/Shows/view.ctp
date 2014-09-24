<?php  	
error_reporting(0);

	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
	 $employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
 ?>
<script type="text/javascript">
$(function(){
	$(".ajax").colorbox({width:'500px',height:'320px'});
	});
</script>
<?php 
 echo $this->Html->css('front_css/tabcontent.css');
	echo $this->Html->script('front_js/tabcontent.js');
  ?>
  
<script type="text/javascript">
	function mypopup()
	{

    mywindow = window.open("<?php echo FULL_BASE_URL.router::url('/',false).'users/tellaFriend'; ?>", "mywindow", "location=1,status=1,scrollbars=1,  width=500,height=300");
    mywindow.moveTo(0, 0);
	}

	function checkvalidation()
	{
		var email = document.getElementById("newLatter").value;
			var validation='';
		
		if(email=='' || email=='Email')
		{	
			validation +='Please Enter Email\n';
				
		}
		
		if(email!='' && email!='Email')
		{	
			
				filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (filter.test(email)) 
					{
 					
					}
				  else
				  	{
						validation +='Please Enter Validate Email\n';
					}
	
				
		}
		
		if(validation)
		{
			alert(validation);
			return false;
		}
		
	}
</script>
<?php  	
$theComponent = new commonComponent(new ComponentCollection());
$location_city = $theComponent->getLocationInfo('location_city',$shows['Show']['location_id']);
$location_state = $theComponent->getLocationInfo('location_state',$shows['Show']['location_id']);
$location_address = $theComponent->getLocationInfo('site_address',$shows['Show']['location_id']);
							
?>
<?php 
 	$show_time=strtotime($shows['Show']['show_dt']);
	$current_time=time();	
	$diff=$show_time-$current_time;	
   	$days = (floor(($diff) / (60 * 60 * 24))) + 1; 
	
	
?>

<?php $candidateID = $this->Session->read('Auth.Client.Candidate.id'); ?>
<?php /***** check candidate is registered in this event or not ******/ ?>
<?php $chekRegistration = $common->isCandidateRegForEvent($candidateID,$shows['Show']['id']);?>

<div id="wrapper_outer1">
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
  <div class="inner_banner">  <?php $bannerDt = $common->getbannerImage('15');   ?>
 <div class="static_inner_banner">
   <div class="static_title_bar">
  <p><?php  echo $this->Text->truncate($bannerDt['OtherBanner']['name'], 40); ?></p>
  </div>
 
  <?php // echo $this->Html->image("images/banner_job.jpg");  ?>
  <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  />
 
  
  </div>
    <?php ?>
    </div>
  <?php if(!$this->Session->read('Auth.Clients.id')) {?>
  <div class="event_search_panel">
    <div class="event_search_box">
      <ul class="search_list">
        <li class="aligncenter">
          <h1>JOB SEEKERS</h1>
          <?php echo $this->Html->link($this->Html->image("images/submit_res.jpg"),'/jobseeker_register', array('escape' => false)); ?> </li>
        <li class="aligncenter">
          <h1>EMPLOYERS</h1>
          <?php // echo $this->Html->link($this->Html->image("images/postjob.jpg"),'/employers/profile', array('escape' => false)); ?> 
          
           <?php 
				  if($this->Session->read('Auth.Client.Candidate.id'))
				  { 
				   echo $this->Html->link($this->Html->image('images/side_post.jpg'),array('controller'=>'users','action'=>'index'),array('escape'=>false));
				  }
				  else if($this->Session->read('Auth.Client.employer.id'))
				  {
				   echo $this->Html->link($this->Html->image('images/side_post.jpg'),array('controller'=>'employers','action'=>'emppostjob'),array('escape'=>false));
				  }else
				  {
				  	echo $this->Html->link($this->Html->image('images/postjob.jpg'),array('controller'=>'users','action'=>'jobposting'),array('escape'=>false));
				  }
				   ?>
          
          
          </li>
        <li class="last aligncenter">
          <h1>RECRUIT WITH US</h1>
          <?php // echo $this->Html->image("images/submit_exhi.jpg",array('alt'=>'Job Seekers', 'url'=>array('controller'=>'employers', 'action'=>'dashboard'))); ?> 
           <?php 
				  if($this->Session->read('Auth.Client.Candidate.id'))
				  { 
				   echo $this->Html->link($this->Html->image('images/side_become_btn.jpg'),array('controller'=>'users','action'=>'index'),array('escape'=>false));
				  }
				  else if($this->Session->read('Auth.Client.employer.id'))
				  {
				   echo $this->Html->link($this->Html->image('images/side_become_btn.jpg'),array('controller'=>'employers','action'=>'emppostjob'),array('escape'=>false));
				  }else
				  {
				  	echo $this->Html->link($this->Html->image('images/side_become_btn.jpg'),array('controller'=>'users','action'=>'recruitWithUs'),array('escape'=>false));
				  }
				   ?>
          
          
          
          </li>
      </ul>
      <div class="clear"></div>
    </div>
  </div>
  <?php } ?>
  <div id="container" <?php if(!$this->Session->read('Auth.Clients.id')) {?> class="home_con_new"<?php } ?>>
    <div class="new_event_page">
      <div class="new_event_mid">
        <div class="new_event_top">
          <div class="new_event_bot" style="text-align:left !important">
            <h1 class="bluecolor">
            <?php // echo $shows['Show']['show_name']/*.'-'.date('M d,Y', strtotime($shows['Show']['show_dt'])); */ ?>
            <?php  if(!empty($shows['ShowsHome']['display_name'])) echo $shows['ShowsHome']['display_name']; else  echo $shows['Show']['show_name'];?><?php // echo $regEventInfo['Show']['show_name'];?>
           
            </h1>
             
             
            <?php if(strlen(trim($shows['Show']['show_name']))>0){?>
            	<?php //echo $shows['Show']['show_name'];?>
            <?php }?>
            <div class="content">
            <h2 class="mana_subheading"> <?php if(!empty($shows['ShowsHome']['special_message'])) echo $shows['ShowsHome']['special_message']; ?></h2>
              <div class="new_event_gray_mid">
                <div class="new_event_gray_top">
                  <div class="new_event_gray_bot">
                    <h2 class="mana_subheading">
                      <?php if($shows['Show']['sec_clearance_req']=='y'):?>
                     <strong> Security Clearance is <strong style="color:#FF0000">REQUIRED</strong> to attend this show.</strong>
                     <span style="float:right; width:180px;">
                      <?php 
						  $eventShareUrl = FULL_BASE_URL.router::url('/',false)."shows/view/".$shows['Show']['id'];
						  $eventSharetitle = $shows['Show']['show_name'];?>
                     <!--Facebook -->
                      <a href="http://www.facebook.com/sharer.php?u=<?php echo FULL_BASE_URL.router::url('/',false).'shows/view/'.$shows['Show']['id'];?>&t=event" target="_blank"><?php echo $this->Html->image('images/face.jpg');?></a> &nbsp;&nbsp;&nbsp;&nbsp;
                      
                      <!--Twitter -->
                     
                      
                      <a href="http://twitter.com/home?status=Check out the <?php echo $shows['ShowsHome']['display_name'];?> show on <?php echo date('M d, Y', strtotime($shows['Show']['show_dt'])); ?> 
                      

<?php echo $eventShareUrl;?>" title="Click to share this post on Twitter" target="_blank"><img src="<?php echo $this->webroot;?>img/images/twitt.jpg" alt="" /></a> 
                      
                      
                      <!--Linked in -->
                      &nbsp;&nbsp; <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $eventShareUrl; ?>&title=<?php echo $eventSharetitle; ?>&summary=<?php echo $shows['Show']['show_name'].'-'.date('M d, Y', strtotime($shows['Show']['show_dt']));  ?>source=techexpousa.com" target="_blank"><img src="<?php echo $this->webroot;?>img/images/link.jpg" alt="" /></a> &nbsp;&nbsp;
                    
                      
                      <!--Google plus -->
                       <a href="https://plus.google.com/share?url=<?php echo $currentURL;?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img
  src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/images.png" alt="Share on Google+" /></a>
  
                      </span>  <span style="float:right;margin:5px 10px 0 0;"> Share this event: </span><br/>
                      <?php if(trim($shows['Show']['sec_clearance_list'])!=''):?>
                      <br/>
                      IMPORTANT: one or several specific types of clearances are required for this event. If your profile does not meet the requirement, you will not be able to register for the event. We invite you to make sure your 
					  <?php
					   if($this->Session->read('Auth.Clients.user_type')=='C')
					  { 
						 echo $this->Html->link('Profile',array('Jobseeker'=>true,'controller'=>'candidates','action'=>'editprofile'), array('escape' => false)); 
					  }
					  else if($this->Session->read('Auth.Clients.user_type')=='E')
					  {
						 echo $this->Html->link('Profile',array('controller'=>'employers','action'=>'editprofile'), array('escape' => false));  
					  }
					  else
					  {	
						echo $this->Html->link('Profile',array('controller'=>'users','action'=>'login'), array('escape' => false));  
						
					  } ?> is updated before you register.
                      <?php endif;?>
                      <?php else:?>
                      Security Clearance is <strong>NOT REQUIRED</strong> to attend this show. 
                      <span style="float:right;width:180px;">
                      <?php 
						  $eventShareUrl = $_SERVER['SERVER_NAME'].$this->webroot."shows/view/".$shows['Show']['id'];
						  $eventSharetitle = $shows['Show']['show_name'];?>
                     
                     
                      <a href="http://www.facebook.com/sharer.php?u=<?php echo FULL_BASE_URL.router::url('/',false).'shows/view/'.$shows['Show']['id'];?>&t=event" target="_blank"><?php echo $this->Html->image('images/face.jpg');?></a> &nbsp;&nbsp;&nbsp;&nbsp;
                      
                      
                   <?php /*?>   <a href="http://twitter.com/home?status=<?php echo $eventShareUrl;?>" title="Click to share this post on Twitter" target="_blank"><img src="<?php echo $this->webroot;?>img/images/twitt.jpg" alt="" /></a> 
                      <?php */?>
                       <a href="http://twitter.com/home?status=Check out the <?php echo $shows['ShowsHome']['display_name'];?> show on <?php echo date('M d, Y', strtotime($shows['Show']['show_dt'])); ?> 
                      

<?php echo $eventShareUrl;?>" title="Click to share this post on Twitter" target="_blank"><img src="<?php echo $this->webroot;?>img/images/twitt.jpg" alt="" /></a> 
                      
                      
                      &nbsp;&nbsp; <a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $eventShareUrl; ?>&title=<?php echo $eventSharetitle; ?>&summary=<?php echo $shows['Show']['show_name'].'-'.date('M d, Y', strtotime($shows['Show']['show_dt']));  ?>&source=techexpousa.com" target="_blank"><img src="<?php echo $this->webroot;?>img/images/link.jpg" alt="" /></a> &nbsp;&nbsp;
                      <!-- Place this tag where you want the +1 button to render. -->
                      <span style="padding-top:5px;">
                      <!--<script src="https://apis.google.com/js/plusone.js"></script>
                      <g:plus action="share" annotation="bubble"></g:plus>-->
                      <a href="https://plus.google.com/share?url=<?php echo $currentURL;?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><img
  src="<?php echo FULL_BASE_URL.router::url('/',false);?>/img/images/images.png" alt="Share on Google+" /></a>
                      </span> </span><span style="float:right;margin:5px 10px 0 0;"> Share this event: </span>
                      <?php endif;?>
                    </h2>
                    <p><strong>Date & Time:</strong> <span class="event_datetime_text">
                      <?php if($shows['Show']['show_end_dt']!=''):?>
                      <?php echo date("l, F d, Y",strtotime($shows['Show']['show_dt']));?>  
					  <?php if(!empty($shows['Show']['show_end_dt']) && $shows['Show']['show_dt']!=$shows['Show']['show_end_dt'])   echo "<strong>to</strong> ".date("l, F d, Y",strtotime($shows['Show']['show_end_dt']));?> -&nbsp;
                      <?php else: ?>
                      <?php echo date("l, F d, Y",strtotime($shows['Show']['show_dt']));?> -&nbsp;
                      <?php endif;?>
                      <?php echo $shows['Show']['show_hours'];?> </span></p><br/>
                      <div class="showsdetail_location_label"><strong>Location: </strong></div>
                      <div class="showsdetail_location_val" style="width: 750px;">
						<span><?php echo $shows['Location']['site_name']."<br/>".$shows['Location']['site_address']."<br/>".$shows['Location']['location_city'].", ".$shows['Location']['location_state']." ".$shows['Location']['site_zip'];?> </span><br />
                        <span>
	                      <?php  $addressRT='';
								  if($this->Session->read('Auth.Clients.user_type')=='C')
								  { 
									 $addressRT = $this->Session->read('Auth.Client.Candidate.candidate_address').'&nbsp;'.$this->Session->read('Auth.Client.Candidate.candidate_city').'&nbsp;'.$this->Session->read('Auth.Client.Candidate.candidate_zip');
								  }
								  else if($this->Session->read('Auth.Clients.user_type')=='E')
								  {
									 $addressRT = $this->Session->read('Auth.Client.employerContact.contact_address').'&nbsp;'.$this->Session->read('Auth.Client.employerContact.contact_city').'&nbsp;'.$this->Session->read('Auth.Client.employerContact.contact_zip');
								  }
						 ?>
                      		<a href="http://maps.google.com/maps?saddr=<?php echo $addressRT; ?>&daddr='<?php echo $shows['Location']['site_address']." ".$shows['Location']['location_city']." ".$shows['Location']['location_state']." ".$shows['Location']['site_zip'];?>" target="_blank" title="Get directions">Get Directions</a>
                      	</span>
			          </div> 
                    <?php if($shows['Location']['site_phone']!=''):?>
                    <p><strong> Venue Telephone:</strong> <span><?php echo $shows['Location']['site_phone']?></span> </p>
                    <?php endif;?>
                    <?php if($days > 0){?>
                   		<p><strong>Countdown to Event :</strong> <?php echo $days; ?> Days</p>
                    <?php } ?>
                    
                    <div style="clear:both;background-color:#FFFFFF;display:block;padding:0 15px 0 15px;">
                    
                      <?php if($shows['Show']['boutique_banner_file']!=''){?>
                      <p>
                      <?php if($shows['Show']['banner_url']!=''){ ?>
                      <a href="<?php if (strpos($shows['Show']['banner_url'],'http://') === false){ echo 'http://'.$shows['Show']['banner_url']; }else{ echo $shows['Show']['banner_url'];}?>" target="_blank"> <img src="<?php echo $this->webroot;?>ShowsDocument/boutiqueBanner/<?php echo $shows['Show']['boutique_banner_file'];?>" alt="<?php echo $shows['Show']['boutique_banner_file'];?>" border="0" height="" width="600px"></a>
                      <?php }else{?>
                      <img src="<?php echo $this->webroot;?>ShowsDocument/boutiqueBanner/<?php echo $shows['Show']['boutique_banner_file'];?>" alt="<?php echo $shows['Show']['boutique_banner_file'];?>" border="0" height="" width="600px">
                      <?php }?>
                      </p>
                      <?php }?>
                      <?php if($shows['Show']['boutique_special_html']!=''){?>
                      <p>
                      <br/>
                      <br/>
                      <?php
					  $shows['Show']['boutique_special_html'] = str_replace('&Acirc;','',$shows['Show']['boutique_special_html']);
					   echo iconv("", "UTF-8//IGNORE", $shows['Show']['boutique_special_html']); //utf8_encode($shows['Show']['boutique_special_html']);?>
                       </p>
                      <?php } ?>
                   
                   
                    
                    </div>
                    
                    
                    
                    <p style="display:block;width:100%;text-align:center;margin-top:22px;">                      
                      <?php if($shows['Show']['ics_file']!='' && file_exists('ShowsDocument/ics/'.$shows['Show']['ics_file']) ){ ?>
                      <?php /*?>	<a href="<?php echo ICAL_PATH;?>/ShowsDocument/ics/<?php echo $shows['Show']['ics_file'];?>" target="_blank"><?php echo $this->Html->image("images/add_outlook_blue.jpg",array('alt'=>'Outlook'));?></a><?php */?>
                        
                      <?php 
					  
					  echo $this->Html->link($this->Html->image("images/add_outlook_blue.jpg"), array('controller'=>'users','action'=>'downloadfilehome',$shows['Show']['ics_file']),array('escape'=>false));
					  
					  }else{?>
                      
                      
                      	<?php echo $this->Html->link($this->Html->image("images/add_outlook_blue.jpg",array('alt'=>'Outlook')), array('controller'=>'users','action'=>'icalenderOrg',$shows['Show']['id']),array('escape'=>false));?>
                        
                        
                        
                        
	 				  <?php }?>&nbsp;&nbsp;
                      <?php echo $this->Html->link($this->Html->image("images/invite_btn.gif",array('class'=>'newsletter_submit')), array('controller'=>'users','action'=>'tellaFriendEvent'),array('class'=>'ajax','escape'=>false)); ?>
                      &nbsp;&nbsp;
                      
                      <?php if($chekRegistration){?>                      	
                      		<strong style="position: relative;top:-10px;font-size:10px;"> <?php echo $this->Html->image("registered.png"); ?> <!--You are currently registered for this show--></strong>
                      <?php }
					  else if($this->Session->read('Auth.Clients.user_type')=='C'){ ?>
                      <?php echo $this->Html->image("images/register_event_btn.jpg",array('url'=>array('controller'=>'Jobseeker','action'=>'shows/eventRegister',$shows['Show']['id']),'alt'=>'Register for this event'));?>
                      <?php }
					  elseif($candidateID=="" && $this->Session->read('Auth.Client.employerContact.id')==""){ ?>
                      	<?php echo $this->Html->image("images/register_event_btn.jpg",array('url'=>array('controller'=>'users','action'=>'login'),'alt'=>'Register for this event'));?>
                      <?php }?>
                      <?php  $register_check=$common->isEmployerRegisteredForEvent($shows['Show']['id'],$employerID); 
					  if(!$register_check && !empty($employerID)) { ?> 
			 <?php echo $this->Html->image("images/register_event_btn.jpg",array('url'=>array('controller'=>'employers','action'=>'eventregistrationform'),'alt'=>'Register for this event'));?>
			 <?php } ?>
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
              
              
              
              
              
              <!--<div class="new_event_gray_mid">
                <div class="new_event_gray_top">
                  <div class="new_event_gray_bot">
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
                    <p><strong>Job Seekers:</strong><span> If you are unable to attend, please <?php // echo $this->Html->link('Submit your resume!', array('controller'=>'candidates','action'=>'register'));?></span></p>
                    <p><strong>Employers/Recruiters:</strong> <span>Interested in exhibiting at our events or having TECHEXPO produce your own open house / customized hiring event?</span> </p>
                    <p><span>Please contact Bradford Rand @ 212.655.4505 x223 or BRand@TechExpoUSA.com.</span> </p>
                  </div>
                </div>
              </div>-->
              
              
              <div class="clear"></div>
              <h1 class="bluecolor"> Exhibitors & Jobs</h1>
              <div class="new_event_gray_mid">
                <div class="new_event_gray_top">
                  <div class="new_event_gray_bot">
                    <ul class="new_event_list" id="exhibitors_info" style="display:none;">
                      <li><span class="event_edit_icon"></span><strong>Company has posted jobs </strong>
                        <div class="clear"></div>
                      </li>
                      <li><span class="event_virtual_icon "></span><strong>Virtual Exhibitors:</strong> they will not be present at the show but are actively hiring & will have the ability to review your resume if you attend or pre-register for this event. You may also apply directly to these companies by clicking on their company links below.
                        <div class="clear"></div>
                      </li>
                    </ul>
                    <div class="clear"></div>
                    <div id="viewAll">
                      <div class="alignright" id="viewAsList" style="display:block;"><a href="javascript:void(0);" onclick="showViewList()"><?php echo $this->Html->image("images/viewasLIst_btn.jpg",array('alt'=>'View as List'));?></a></div>
                      <div class="alignright" id="viewAsLogo" style="display:none;"><a href="javascript:void(0);" onclick="showViewList()"><?php echo $this->Html->image("images/view_logo_btn.jpg",array('alt'=>'View as Logo'));?></a></div>
                    </div>
                    <?php if(count($otherRegEmployer)==0){?>
                      		<div style="text-align: center;" class="bigfont">Please check back 2 weeks before this event to view what companies are participating.</div>
                    <?php }?>
                    <br/>
                    <div id="viewLogoList" style="display:block;overflow:hidden;">
                      <?php if(count($otherRegEmployer>0)){?>
                      <div class="show_virtualsap" id="currentExhib"> Current Exhibitors</div>
                      
                      <ul class="logo_list" id="currentExhibdata">
                        <?php foreach($otherRegEmployer as $key => $employer){ $class = ''; ?>
                        <?php $VirtualExhibitor =0;
							/* if(count($employer['JobPosting'])>0){
								$class .= 'class="jobs"';
							}else */if(count($employer['ShowEmployer'])>0){ 
								foreach($employer['ShowEmployer'] as $key => $isvirtual){
									if($isvirtual['show_id']==$show_id){ // task id #3853
										if($isvirtual['virtual'] == 'y'){
											$class = 'class="virtual"';
											$VirtualExhibitor = 1;
											
										}else{
											$class = 'class="jobs no_jobs"';
											$VirtualExhibitor = 0;
											
										}
									}
								}					
							}else{
								$class .= 'class="no_jobs"';
							}
							
						?>
                        
                        <?php if($VirtualExhibitor!=1) { ?>
                        <li style="height:110px !important">
                        
                        <a href="<?php echo $this->webroot;?>employers/viewprofile/<?php echo $employer['Employer']['id'];?>">
                       
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
                        <?php $VirtualExhibitor =0;
							/* if(count($employer['JobPosting'])>0){
								$class .= 'class="jobs"';
							}else */if(count($employer['ShowEmployer'])>0){ 
								foreach($employer['ShowEmployer'] as $key => $isvirtual){
									if($isvirtual['show_id']==$show_id){ // task id #3853
										if($isvirtual['virtual'] == 'y'){
											$class = 'class="virtual"';
											$VirtualExhibitor = 1;
											$VirtualExhib = 1;
										}else{
											$class = 'class="jobs no_jobs"';
											$VirtualExhibitor = 0;
										}
									}
								}					
							}else{
								$class .= 'class="no_jobs"';
							}
							
						?>
                        
                        <?php if($VirtualExhibitor==1) { ?>
                        <li style="height:110px !important">
                        
                        <a href="<?php echo $this->webroot;?>employers/viewprofile/<?php echo $employer['Employer']['id'];?>">
                       
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
                      
                      <?php }   ?>
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
							if(count($employer['ShowEmployer'])>0){ 
								foreach($employer['ShowEmployer'] as $key => $isvirtual){
									if($isvirtual['show_id']==$show_id){ // task id #3853
										if($isvirtual['virtual'] == 'y'){
											$class = 'class="virtual"';
										}
									}
								}					
							}
							
							if(strlen($class)==0 && count($employer['JobPosting'])>0){
								$class .= 'class="jobs"';
							}elseif(strlen($class)==0){
								$class .= 'class="jobs no_jobs"';
							}
							
						?>
                        <li <?php echo $class;?> style="height:auto !important;"><a href="<?php echo $this->webroot;?>employers/viewprofile/<?php echo $employer['Employer']['id'];?>" style="width:420px">
                          <div class="logo_company logo_company_text"><?php echo $employer['Employer']['employer_name'];?></div>
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
              <div class="new_event_gray_mid">
                <div class="new_event_gray_top">
                  <div class="new_event_gray_bot">
                    <p class="bigfont" style="font-size:14px; color:#3A3A3A;">Our professional hiring events have benefited nearly a million attendees since 1993. We look forward to helping you advance your career and saving you time in your job search by providing you the opportunity to meet face to face with the nation's leading companies. Thank you for joining us; we look forward to meeting you at our expos!</p>
                    <ul class="list">
<li style="font-size:14px">Business or military attire is highly recommended when attending the event. Admission is free.</li>
<li  style="font-size:14px">Bring many copies of your resume to hand out to employers & arrive early to maximize your interviewing time at the event.</li>
<li  style="font-size:14px">Be prepared to visit with the companies & organizations of your choice by researching them in advance.</li>
<li  style="font-size:14px">
                      
                     
                      
                                 <?php  
	  if($this->Session->read('Auth.Clients.user_type')=='C')
	  { 
		echo $this->Html->link('Pre-register online',array('controller'=>'shows','action'=>'eventRegister',$shows['Show']['id'],'Jobseeker'=>true), array('escape' => false));
	  }
	  else if($this->Session->read('Auth.Clients.user_type')=='E')
	  {
		echo "Pre-register online ";
	  }
	  else
	  {
		echo $this->Html->link('Pre-register online ',array('controller'=>'users','action'=>'login'), array('escape' => false));  
	  }	
	  
	  
	  
	 ?>
              
                      
                       : This will allow recruiters to find your resume & schedule face-to-face interviews before the event. It also saves you time when you arrive at the show.</li>
                      <li  style="font-size:14px">We encourage you to invite your friends, colleagues & family members who are experienced professionals with an active clearance.</li>
                      <li  style="font-size:14px">Prepare & practice your brief personal description of your professional skills, unique abilities, past successful accomplishments & relevant experience.</li>
                      <li  style="font-size:14px">Follow up immediately with all of the companies that were of strong interest to you with a phone call, email and/or letter. </li>
                      <li  style="font-size:14px">The evening before the event, get a good night's sleep. The morning of the show try to eat a healthy breakfast and  exercise. </li>
                    </ul>
                    <span><strong>Job Seekers</strong>: If you are unable to attend, please Submit your resume!</span><br/><br/>
                    <span><strong>Employers/Recruiters</strong>: Interested in exhibiting at our events or having TECHEXPO produce your own open house or customized hiring event? </span><br/><br/>
					<span>	Please contact Bradford Rand @ 212.655.4505 x223 or <a href="mailto:BRand@TechExpoUSA.com">BRand@TechExpoUSA.com</a>.</span><br/><br/>
                    <span>If you have any questions or require further information, please e-mail <a href="mailto:Amanda@TechExpoUSA.com">Amanda@TechExpoUSA.com.</a> </span>
                  </div>
                </div>
              </div>
              <div class="clear"></div>
           
              <!--<div class="new_event_gray_mid">
                <div class="new_event_gray_top">
                  <div class="new_event_gray_bot">
                    <?php
					
					 if($regEventInfo['Show']['show_special_html']!=''){ ?>
                    <?php echo $regEventInfo['Show']['show_special_html'];?>
                    <?php }else{ ?>
                    <p>The exhibitors of this event have not yet been posted. Please check back with us 2 weeks prior to the event.</p>
                    <?php } ?>
                  </div>
                </div>
              </div>-->
              <div class="clear"></div> 
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
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
