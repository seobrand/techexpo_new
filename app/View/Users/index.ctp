<?php  
echo $this->element('ajax', array('cache' => true));
echo $this->Html->script('front_js/jquery-ui-1.7.2.custom.min.js');
?>
<script type="text/javascript">
	function mypopup()
	{

    mywindow = window.open("<?php echo FULL_BASE_URL.router::url('/',false).'users/tellaFriend'; ?>", "mywindow", "location=1,status=1,scrollbars=1,  width=600,height=300");
    mywindow.moveTo(0, 0);
	}

	function checkvalidation()
	{
		var email = document.getElementById("newLatter").value;
			var validation='';
		
		if(email=='' || email=='Email')
		{	
			validation +='Please Enter E-mail Address\n';
				
		}
		
		if(email!='' && email!='Email')
		{	
				filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				if (filter.test(email)) 
					{
 					
					}
				  else
				  	{
						validation +='Please Enter Valid E-mail Address\n';
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
if($this->Session->read('Auth.Client.employerContact.employer_id'))
{
 $limitJobs = $common->GetEmployerJobLimit($this->Session->read('Auth.Client.employerContact.employer_id'));
 }else
 {
 	$limitJobs=1;
 }
 ?>
  
<div id="wrapper">
  <div class="home_slogan_panel"></div>
  
  <div class="search_panel">
    <div class="event_search_box">
      <ul class="search_list">
        <li class="aligncenter">
          <h1>JOB SEEKERS</h1>
          <?php
		  if($this->Session->read('Auth.Client.Candidate.id')){
		   echo $this->Html->link($this->Html->image("images/submit_res.jpg"),array('controller'=>'resumes','action'=>'resumelist','Jobseeker'=>true), array('escape' => false));
		   
		    }else{
		 	
			echo $this->Html->link($this->Html->image("images/submit_res.jpg"),array('controller'=>'users','action'=>'login'), array('escape' => false));
		   
		   }?> <br />
        </li>
        <li class="aligncenter">
          <h1>EMPLOYERS</h1>
          <?php 
				  if($this->Session->read('Auth.Client.Candidate.id'))
				  { 
				   echo $this->Html->image('images/postjob.jpg',array('onClick'=>'javascript:alert("You are log in as Jobseeker, so don\'t have rights to access this.")'));
				   
				  }
				  else if($this->Session->read('Auth.Client.employerContact.employer_id') && $limitJobs>0)
				  {
				   	echo $this->Html->link($this->Html->image('images/postjob.jpg'),array('controller'=>'employers','action'=>'emppostjob'),array('escape'=>false));
				  }elseif($this->Session->read('Auth.Client.employerContact.employer_id') && $limitJobs==0)
				  {
				  	echo $this->Html->link($this->Html->image('images/postjob.jpg'),array('controller'=>'','action'=>'#'),array('escape'=>false,'onclick'=>'showPostJobPopup()'));
				  }
				  else
				  {
				  	echo $this->Html->link($this->Html->image('images/postjob.jpg'),array('controller'=>'users','action'=>'jobposting'),array('escape'=>false));
				  }
		 ?>
        </li>
        <li class="last aligncenter">
          <h1>RECRUIT WITH US</h1>
          <?php 
				  if($this->Session->read('Auth.Client.Candidate.id'))
				  { 
				 
				   //echo $this->Html->link($this->Html->image('images/submit_exhi.jpg'),array('controller'=>'users','action'=>'index'),array('escape'=>false));
				   
				   echo $this->Html->image('images/submit_exhi.jpg',array('onClick'=>'javascript:alert("You are log in as Jobseeker, so don\'t have rights to access this.")'));
				   
				  }
				  else if($this->Session->read('Auth.Client.employerContact.employer_id') && $limitJobs>0)
				  {
				   	echo $this->Html->link($this->Html->image('images/submit_exhi.jpg'),array('controller'=>'employers','action'=>'emppostjob'),array('escape'=>false));
				  }elseif($this->Session->read('Auth.Client.employerContact.employer_id') && $limitJobs==0)
				  {
				  	echo $this->Html->link($this->Html->image('images/submit_exhi.jpg'),array('controller'=>'','action'=>'#'),array('escape'=>false,'onclick'=>'showPostJobPopup()'));
				  }else
				  {
				  	echo $this->Html->link($this->Html->image('images/submit_exhi.jpg'),array('controller'=>'users','action'=>'recruitWithUs'),array('escape'=>false));
				  }
		 ?>
        </li>
      </ul>
      <div class="clear"></div>
    </div>
    
  </div>
  
  
  <div id="container" class="home_con_new">
  
  <?php /*if($this->params->params['controller']=='users' && $this->params->params['action']=='index') { ?>
 	<div  class="statics">
    	<ul>
        	<li style="width:300px;">
            	<span style="color:#595959">Total Jobs with Security Clearance : </span><span>
					<?php 
						echo $this->Number->format($common->totalJobWithSecurityClearances(), array(
										'before' => '',
										'places' => false,
										'escape' => false,
										'decimals' => false,
										'thousands' => ','));
					 ?>
				</span>
            </li>
            <li  style="width:195px;">
            	<span style="color:#595959"> Total Members :</span> <span>
					<?php 
					echo $this->Number->format($common->totalMembers(), array(
										'before' => '',
										'places' => false,
										'escape' => false,
										'decimals' => false,
										'thousands' => ','));
				 ?>
                </span>
            </li>
            <li  style="width:400px;">
            	 <span style="color:#595959"> Total Candidate with Security Clearance :</span> <span>
				 	<?php echo $this->Number->format($common->candidateWithSecurityClearances(), array(
										'before' => '',
										'places' => false,
										'escape' => false,
										'decimals' => false,
										'thousands' => ','));
				 	?>
                </span>
            </li>
        </ul>
  </div>
   <?php }*/ ?>
 
    <div class="lf_col"> 
      <div class="box">
        <div class="event_head">Upcoming Events</div>
        <div class="event_mid">
          <div class="event_bottom">
            <div class="event_padding">
              <ul class="event_list">
                <?php foreach($events as $event) {  ?>
                <li>
                  <div class="event_panel">
                    <div class="event_date">
                    <a href="<?php echo $this->Html->url( array('controller'=>'shows','action'=>'view',$event['Show']['id'])); ?>" >
                      <div class="date"> <span><?php echo date('M', strtotime($event['Show']['show_dt']));  ?></span><span class="dt"><?php echo date('d', strtotime($event['Show']['show_dt']));  ?></span> </div>
                      </a>
                    </div>
                    <div class="event_desc">
                      <p> <?php /* echo $this->Html->link($event['ShowsHome']['display_name'].' <span class="italic">'.date(DATE_FORMAT, strtotime($event['Show']['show_dt'])).'</span>', array('controller'=>'shows','action'=>'view',$event['Show']['id']),array('escape'=>false)); */ ?>
                     <strong>  <?php echo $this->Html->link($event['ShowsHome']['display_name'], array('controller'=>'shows','action'=>'view',$event['Show']['id']),array('escape'=>false)); ?>
                      </strong>
                      
                       <br />
                        <?php $theComponent = new commonComponent(new ComponentCollection());
							$location_city = $theComponent->getLocationInfo('location_city',$event['Show']['location_id']);
							$location_state = $theComponent->getLocationInfo('location_state',$event['Show']['location_id']);
							  ?>
                        <span><?php echo $event['Show']['show_name']; ?> - <?php echo $location_city.', '.$location_state;  ?> <br />
                        <?php echo $event['ShowsHome']['special_message']; ?> </span></p>
                    </div>
                    <div class="event_outlook">
                    	<?php
						if($this->Session->read('Auth.Client.Candidate.id'))
						  { 
						 ?>
                         <div style="margin:0px 0px 7px 0;clear:both;">
                        <a href="<?php echo FULL_BASE_URL.router::url('/',false);?>Jobseeker/shows/eventRegister/<?php echo $event['Show']['id'];?>"><img src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/images/cal-register_new.png" />
                        </a>
                        </div>
                        <br />
                    	<?php }elseif($this->Session->read('Auth.Client.employerContact.employer_id'))
         				{ ?>
                        	 <div style="margin:0px 0px 7px 0;clear:both;">
                        	<a href="<?php echo FULL_BASE_URL.router::url('/',false);?>employers/eventregistrationform"><img src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/images/cal-register_new.png" /></a>
                            </div>
                        <?php }else
         				{ ?>
                         <div style="margin:0px 0px 7px 0;clear:both;">
                        <a href="<?php echo FULL_BASE_URL.router::url('/',false);?>users/login" ><img src="<?php echo FULL_BASE_URL.router::url('/',false);?>img/images/cal-register_new.png"/>
                        </a>
                        </div>
                        <?php } ?>
                     
        
                      <?php if($event['Show']['ics_file']!='' && file_exists('ShowsDocument/ics/'.$event['Show']['ics_file'])){  
					  
					  echo $this->Html->link('Add to Outlook <br />or iCalendar', array('controller'=>'users','action'=>'downloadfilehome',$event['Show']['ics_file']),array('escape'=>false)); 
						 }else{ 
					 	$show_display_name = (!empty($event['ShowsHome']['display_name'])) ? $event['ShowsHome']['display_name'] : $event['Show']['show_name'];

   $site_address =(!empty($event['Location']['site_address'])) ? '#'.$event['Location']['site_address'] : "";	
   $site_address .=(!empty($event['Location']['location_city'])) ? '#'.$event['Location']['location_city'].', ' : "";
   $site_address .=(!empty($event['Location']['location_state'])) ? $event['Location']['location_state'] : "";  
   $site_address .=(!empty($event['Location']['site_zip'])) ? " ".$event['Location']['site_zip'] : "";
   $show_location = "".$event['Location']['site_name'].' '.$site_address;

 //  $show_detail = $show_location."#Show Name: ".$event['Show']['show_name'];
    $show_detail = $show_location;
   $show_detail .= (!empty($event['Show']['show_hours'])) ? "#Show Time: ".$event['Show']['show_hours'] : ""; 
   $show_detail .= (!empty($event['ShowsHome']['display_name'])) ? "##".$event['ShowsHome']['display_name'] : "";
   $show_detail .= (!empty($event['ShowsHome']['special_message'])) ? ",  ".$event['ShowsHome']['special_message'] : "";
   
  	
			   
			   $show_location2 = $event['Location']['site_name'];
			   
			   $Alldaytime =explode('-',$event['Show']['show_hours']);
			
			   $starttime = date('Ymd H:i:s', strtotime($event['Show']['show_dt'].' '.$Alldaytime['0']));  
			   if(!empty($event['Show']['show_end_dt']))
			   $endtime = date('Ymd H:i:s', strtotime($event['Show']['show_end_dt'].' '.$Alldaytime['1'])); 
			   else
			   $endtime = date('Ymd H:i:s', strtotime($event['Show']['show_dt'].' '.$Alldaytime['1']));	  
					  
					  // echo $this->Html->link('Add to Outlook <br />or iCalendar', array('controller'=>'users','action'=>'icalender2',$starttime,$endtime,$show_display_name,$show_detail,$show_location2),array('escape'=>false)); 
					echo $this->Html->link('Add to Outlook <br />or iCalendar', array('controller'=>'users','action'=>'icalenderOrg',$event['Show']['id']),array('escape'=>false));    
					   
					   } ?>
                    </div>
                    <div class="clear"></div>
                  </div>
                </li>
                <?php } ?>
                <?php if(count($events)==0){?>
                <li>
                  <div class="no_event_panel">
                  	No Calendar Event Available.
                  </div>
                </li>
                <?php }?>  
              </ul>
            </div>
          </div>
        </div>
      </div>
      
       <?php 
        if($this->Session->read('Auth.Client.employerContact.employer_id')=='')
         {
		
        ?>
      <div class="box">
        <!--<div class="findjob_head"><?php echo $this->Html->image('images/findjob_txt.jpg'); ?></div>-->
         <div class="event_head">Search Career Opportunities</div>
        
        <div class="find_mid">
        
        <?php if($this->Session->read('Auth.Client.User.id'))
		 {
		 ?>
          <form id="CandidatesForm" accept-charset="utf-8" method="get" action="Jobseeker/candidates/searchJob">
          <?php }else{?>
          <form id="CandidatesForm" accept-charset="utf-8" method="get" action="Jobseeker/candidates/searchJob">
           <?php } ?>
        
        <div class="search-new-row">
        
        <div class="search-new-col1">
        	<div class="search_col1">
                    <label>WORK TYPE:</label>
                    <br />
                    <div class="select_new dropdown">
                      <?php 
                         echo $this->Form->input('work_type_code',array('type'=>'select','name'=>'work_type_code',
						 											'options'=>$WorkTypeList,'empty'=>'Show All','label'=>false,'class'=>'work_type_code','div'=>'')); ?>
                    </div>
                    
                    <label>State:</label>
                    <br />
                    <div class="select_new dropdown search-big-dropdown">
                      <?php  
						 $statList=$common->getStateList();
						  echo $this->Form->input('location_state',array('type'=>'select','options'=>$statList,
						  												'empty'=>'-Select State-','label'=>false,'class'=>'work_location_code',
																		'div'=>'','style'=>'font-size: 12px;')); 
                        ?>
                    </div>
                   
                  </div>
        
        </div>
                <div class="search-new-col2">
                	<div class="search_col1 search-list-box">
                    
                    
                    <label>SELECT JOBS BY CLEARANCE:</label>
                    <br />
                    
                    <div class="checkbox_div checkbox_large_div"  style="height:155px; width:100%; padding:0 0 0 10px;">
                      <div class="checkbox_list checkbox_list_home" style="width:100%;">
                        <?php 
							 echo $this->Form->input('security_clearance_code',array('type'=>'select','multiple'=>'checkbox',
							 														'options'=>$GovCleareanceList,'label'=>false,'div'=>false,'hiddenField' => false)); 
						   ?>
                      </div>
                    </div>
                  </div>
                  
                  
                </div>
                <div class="clear"></div>
        </div>
        
              
        
         
            
            <div class="search-new-row search-new-row2">
         <label>Keywords:</label>
                    <br />
                    <div style="display:none">
                      <select id="JobPostingMatching" class="work_location_code" style="font-size: 12px;" name="matching">
                        <option value="All">All Words</option>
                        <option value="Exact">Exact Phrase</option>
                        <option value="Any">Any Words</option>
                      </select>
                    </div>
                    
                    
                    
                    <input name="keyword" class="keyword-txt" type="text" />
                    
         <div class="search_btn"> <?php echo $this->Form->submit('images/search.jpg');?> </div>
        </div>
          </form>
        </div>
      </div>
      <?php } ?>
      
      <div class="box">
        <div class="event_head">Special Announcements</div>
        <div class="special_mid">
          <div class="special_bottom">
            <div class="special_padding">
              <ul class="special_list">
                <?php 
				
				
			  		foreach($specialAnnounces as $announce){ 
					$announce = $announce['HomepageDynamicContent'];
					$announce['image_link'] = (strpos($announce['image_link'], 'http') === false) ? 'http://'.$announce['image_link'] : $announce['image_link'];
					?>
                <li>
                  <?php  if(file_exists('img/team-message/'.$announce['image'])) {
						if($announce['image_link']!='http://'){
					  		//echo $this->Html->image('team-message/150x80_'.$announce['image'], array("alt" => $announce['title'], "title"=>$announce['title'], 'url' => $announce['image_link'])); ?>
                  <a href="<?php echo $announce['image_link']; ?>" > <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'img/team-message/'.$announce['image'];?>&maxw=133" alt="<?php echo $announce['title']; ?>" title="<?php echo $announce['title']; ?>"  /> </a>
                  <?php 	
						  }else{
						 // 	echo $this->Html->image('team-message/150x80_'.$announce['image'], array("alt" => $announce['title'], "title"=>$announce['title'])); 
							?>
                  <a href="<?php echo $announce['image_link']; ?>" > <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'img/team-message/'.$announce['image'];?>&maxw=133&maxh=80" alt="<?php echo $announce['title']; ?>" title="<?php echo $announce['title']; ?>" /> </a>
                  <?php 
						  }					  
					  }else{
					  echo $this->Html->image('no_image_announc.jpg',array("alt"=>$announce['title'],"title"=>$announce['title']));
					  }
					   ?>
                  <div class="special_desc"><?php echo $announce['text']; ?> <?php /*?><a href="<?php echo $announce['image_link']; ?>">Click here to find out more!</a><?php */ ?></div>
                  <div class="clear"></div>
                </li>
                <?php	}
			  ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <?php echo $this->element('front_sidebar', array('cache' => true)); ?> </div>
    
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
