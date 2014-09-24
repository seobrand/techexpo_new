<?php  	echo $this->Html->script('front_js/jquery-ui-1.7.2.custom.min.js');
echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
 ?>
 <script type="text/javascript">
$(function(){
	$(".ajax").colorbox();
	});
</script>
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
<div id="wrapper">
  <div class="search_panel">
    <div class="search">
      <ul class="search_list">
        <li class="aligncenter">
          <h1>JOB SEEKERS</h1>
          <?php echo $this->Html->link($this->Html->image("images/submit_res.jpg"),array('controller'=>'users','action'=>'login'), array('escape' => false)); ?> <br />
        
        </li>
        <li class="aligncenter">
          <h1>EMPLOYERS</h1>
          <?php 
				  if($this->Session->read('Auth.Client.Candidate.id'))
				  { 
				   echo $this->Html->link($this->Html->image('images/postjob.jpg'),array('controller'=>'users','action'=>'index'),array('escape'=>false));
				  }
				  else if($this->Session->read('Auth.Client.employerContact.employer_id'))
				  {
				   echo $this->Html->link($this->Html->image('images/postjob.jpg'),array('controller'=>'employers','action'=>'emppostjob'),array('escape'=>false));
				  }else
				  {
				  	echo $this->Html->link($this->Html->image('images/postjob.jpg'),array('controller'=>'users','action'=>'login'),array('escape'=>false));
				  }
		 ?>
          
           </li>
        <li class="last aligncenter">
          <h1>RECRUIT WITH US</h1>
          <?php 
				  if($this->Session->read('Auth.Client.Candidate.id'))
				  { 
				 
				   echo $this->Html->link($this->Html->image('images/submit_exhi.jpg'),array('controller'=>'users','action'=>'index'),array('escape'=>false));
				  }
				  else if($this->Session->read('Auth.Client.employerContact.employer_id'))
				  {
			
				   echo $this->Html->link($this->Html->image('images/submit_exhi.jpg'),array('controller'=>'employers','action'=>'emppostjob'),array('escape'=>false));
				  }else
				  {
				  	echo $this->Html->link($this->Html->image('images/submit_exhi.jpg'),array('controller'=>'users','action'=>'login'),array('escape'=>false));
				  }
		 ?>
          
          </li>
      </ul>
      <div class="clear"></div>
    </div>
  </div>
  <div id="container">
    <div class="lf_col">
		<?php 
        if($this->Session->read('Auth.Client.employerContact.employer_id')=='')
         {
		
        ?>
      		<div class="box">
        <div class="findjob_head"><?php echo $this->Html->image('images/findjob_txt.jpg'); ?></div>
        <div class="find_mid">
         <?php if($this->Session->read('Auth.Client.User.id')){
	
		 ?>
        	<form id="CandidatesForm" accept-charset="utf-8" method="get" action="Jobseeker/candidates/searchJob">
          <?php }else{?>
          <form id="CandidatesForm" accept-charset="utf-8" method="get" action="Jobseeker/candidates/searchJob">
          	<!--<form id="CandidatesForm" accept-charset="utf-8" method="get" action="users/login">-->
          <?php } ?>
          <div class="find_bottom">
            <div class="search_padding">
              <div class="search_action">
                <div class="search_col1">
                  <label>Keywords:</label>
                  <br />
                    <div style="display:none">
                    <select id="JobPostingMatching" class="work_location_code" style="font-size: 12px;" name="matching">
                        <option value="All">All Words</option>
                        <option value="Exact">Exact Phrase</option>
                        <option value="Any">Any Words</option>
                    </select>
                  </div>
                  
                  <input name="keyword" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'All Sectors':this.value;" value="All Sectors" type="text" />
                  <label>Work Type:</label>
                  <br />
                  <div class="dropdown">
                      <?php 
                         echo $this->Form->input('work_type_code',array('type'=>'select','name'=>'work_type_code','options'=>$WorkTypeList,'empty'=>'-Either-','label'=>false,'class'=>'work_type_code','div'=>'')); ?>
                  </div>
                </div>
                <div class="search_col1">
                  <label>Location:</label>
                  <br />
                  <div class="dropdown">
                     <?php  
                         echo $this->Form->input('work_location_code',array('type'=>'select','name'=>'work_location_code','options'=>$WorkLocationList,'empty'=>'-Select Location-','label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                  </div>
                  <label>Job by Clearance Type:</label>
                  <br />
                  <div class="dropdown">
                     <?php  
                         echo $this->Form->input('security_clearance_code',array('name'=>'security_clearance_code','type'=>'select','options'=>$GovCleareanceList,'empty'=>'-Security Clearance-','label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                  </div>
                </div>
                <div class="search_btn"> 
                	<?php echo $this->Form->submit('images/search.jpg');?> 
             	</div>
                <div class="clear"></div>
              </div>
            </div>
          </div>
         </form>
        </div>
      </div>
      <?php } ?>
      <div class="box">
        <div class="event_head">Calendar of Events</div>
        <div class="event_mid">
          <div class="event_bottom">
            <div class="event_padding">
              <ul class="event_list">
			  
                  <?php foreach($events as $event) {  ?>
                <li>
                  <div class="event_panel">
                    <div class="event_date">
                      <div class="date"> <span><?php echo date('M', strtotime($event['Show']['show_dt']));  ?></span><span class="dt"><?php echo date('d', strtotime($event['Show']['show_dt']));  ?></span> </div>
                    </div>
                    <div class="event_desc">
                      <p>
					   <?php echo $this->Html->link($event['ShowsHome']['display_name'].'<span class="italic">'.date('m/d/y', strtotime($event['Show']['show_dt'])).'</span>', array('controller'=>'shows','action'=>'view',$event['Show']['id']),array('escape'=>false)); ?>
					  
<br />
                      <?php $theComponent = new commonComponent(new ComponentCollection());
							$location_city = $theComponent->getLocationInfo('location_city',$event['Show']['location_id']);
							$location_state = $theComponent->getLocationInfo('location_state',$event['Show']['location_id']);
							  ?>
                        <span><?php echo $event['Show']['show_name']; ?> - <?php echo $location_city.','.$location_state;  ?> <br />
                         <?php echo $event['ShowsHome']['special_message']; ?> </span></p>
                    </div>
                    <div class="event_outlook">
                    <?php echo $this->Html->link('Add to Outlook <br />or iCalendar', array('controller'=>'users','action'=>'icalender',date('Ymd', strtotime($event['Show']['show_dt'])),$event['ShowsHome']['display_name'],$event['Show']['show_name']),array('escape'=>false)); ?>
                    
                 </div>
                    <div class="clear"></div>
                  </div>
                </li>
               <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="box">
        <div class="special_head">Special Announcements</div>
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
                <?php  if(file_exists('img/team-message/150x80_'.$announce['image'])) 
					  echo $this->Html->image('team-message/150x80_'.$announce['image'], array("alt" => $announce['title'], 'url' => $announce['image_link'])); 
					  else
					  echo $this->Html->image('no_image_announc.jpg');
					   ?>
                  <div class="special_desc"><?php echo $announce['text']; ?> <a href="<?php echo $announce['image_link']; ?>">Click here to find out more!</a></div>
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
    <div class="rt_col">
    
    
      <?php if($this->Session->read('Auth.Client.User.id')==''){ ?>
      <div class="side_box">
        <div class="side_head">LOG IN</div>
        <div class="side_mid">
          <div class="side_bottom"> <?php echo $this->Form->create('User',array('controller'=>'users','action'=>'login')); ?>
          
          
            <ul class="login_panel">
            	<li style="color:#FF0000">
                	  <?php echo $this->Session->flash(); ?>
                </li>
              <li> <?php echo $this->Form->input('User.username',array('class'=>'login_txt','type'=>'text','value'=>'User Name:','onclick'=>"this.value='';",'onfocus'=>'this.select()','onblur'=>"this.value=!this.value?'User Name:':this.value;",'div'=>'','label'=>''));?> </li>
              <li>
                <?php  echo $this->Form->input('User.password',array('class'=>'login_txt','type'=>'password','value'=>'Password:','onclick'=>"this.value='';",'onfocus'=>'this.select()','onblur'=>"this.value=!this.value?'Password:':this.value;",'div'=>'','label'=>'')); ?>
              </li>
              <li>
                <?php 
                	 echo $this->Form->input('User.LOGIN',array('type'=>'hidden','value'=>'LOGIN'));
               		 echo $this->Form->submit('images/submit.jpg',array('style'=>'float:right'));
                 ?>
                <label>
                 <?php 
				 echo $this->Form->input('User.Login',array('type'=>'hidden','value'=>'LOGIN'));
				 
				 ?>
				 <a href="javascript:void(0);" onclick="showRegisterPopup()">Register Now</a>
				  / <?php echo $this->Html->link('Forgot Password',array('controller'=>'users','action'=>'forgotpassword'));?></label>
                <div class="clear"></div>
              </li>
            </ul>
            
              <?php echo  $this->Form->end(); ?></div>
        </div>
      </div>
      <?php } ?>
      <div class="side_box">
        <div class="side_head">Featured Employer:</div>
        <div class="side_mid">
          <div class="side_bottom">
            <div class="featured_logo">
			<?php if($featuredEmployer['Employer']['logo_file']!=''){?>
			<?php echo $this->Html->image('../upload/'.$featuredEmployer['Employer']['logo_file'],array('width'=>'321px','height'=>'76px','title'=>$featuredEmployer['Employer']['employer_name'])); ?>
			<?php }else{?>
			<?php echo $this->Html->image('no_logo_thumb.jpg',array('title'=>$featuredEmployer['Employer']['employer_name'])); ?> 
			<?php } ?>
			</div>
          </div>
        </div>
      </div>
      <div class="side_box">
        <div class="white_head"></div>
        <div class="white_mid1">
          <div class="white_bottom1">
            <div class="newsletter_header"> <?php echo $this->Html->image('images/email_icon.jpg'); ?>
              <h4>Join our mailing list</h4>
              <p>A quick way to sign up and be informed for upcoming </p>
              <div class="clear"></div>
              
              <?php echo $this->Form->create('User',array('controller'=>'users','action'=>'listSignup','name'=>'Login')); ?>
              <ul class="newsletter_panel">
                <li>
                  <input name="data[MASSEMAIL][list_email]" type="text" value="Enter your email address" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Enter your email address':this.value;" class="newsletter_txt" id='newLatter' />
                  
                  
                </li>
                <li> <?php echo $this->Form->submit('images/newsletter_button.jpg',array('style'=>'float:right','class'=>'newsletter_submit','onclick'=>'return checkvalidation()'));
				 echo $this->Form->input('MASSEMAIL.NEWSLETTER',array('type'=>'hidden','value'=>'NEWSLETTER'));
				?>
                
                 </li>
              </ul>
               <?php echo  $this->Form->end(); ?>
              <div class="clear"></div>
            </div>
            <div class="newsletter_header bordernone"> <?php echo $this->Html->image('images/emai2_icon.jpg'); ?>
              <h4 class="newsletter_subheading">Tell a friend's about us</h4>
              <div class="clear"></div>
              <ul class="newsletter_panel" style="float:right;margin-right:15px;">
                
                <li>
                 <?php echo $this->Html->link($this->Html->image("images/clickhere.gif",array('class'=>'newsletter_submit')), array('controller'=>'users','action'=>'tellaFriend'),array('class'=>'ajax','escape'=>false)); ?>
                </li>
              </ul>
              <div class="clear"></div>
            </div>
          </div>
        </div>
      </div>
       <?php echo $this->element('testimonials', array('cache' => true)); ?> 
       
       <div class="side_box">
        <div class="disc_head">Discussions</div>
        <div class="side_mid">
          <div class="side_bottom padding_1px">
            <div class="qunt_main">
              <div class="qunt_box">
                <ul id="menu2" class="menu1">
                  <li class="active"><a href="#jobseekers_d"><span>Job Seekers</span></a></li>
                  <li><a href="#employers_d"><span>Employers Topics</span></a></li>
                </ul>
                <div class="clear"></div>
                <div class="qunt_in_bx">
                  <div id="jobseekers_d" class="content_products">
                    <ul class="discussion_home_list">
                      <li>
                        <textarea name="" cols="" rows="">Join the conversation</textarea>
                      </li>
                      <li>
                        <input class="discuss_text" value="Type Message" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Type Message':this.value;" name="" type="text" />
                      </li>
                      <li class="last"> <?php echo $this->Html->image('images/send.jpg'); ?> </li>
                    </ul>
                    <div class="clear"></div>
                  </div>
                  <div class="clear"></div>
                  <div id="employers_d" class="content_products">
                    <ul class="discussion_home_list">
                      <li>
                        <textarea name="" cols="" rows="">Join the conversation</textarea>
                      </li>
                      <li>
                        <input class="discuss_text" value="Type Message" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Type Message':this.value;" name="" type="text" />
                      </li>
                      <li class="last"> <?php echo $this->Html->image('images/send.jpg'); ?> </li>
                    </ul>
                    <div class="clear"></div>
                  </div>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> 
  </div>
</div>

<a href="#?w=300" rel="registerpopup_name" class="poplight" style="display:none;"><input type="hidden" id="register"/></a>


<div id="registerpopup_name" class="popup_block"><?php echo $this->Html->image("images/close.png",array('onclick'=>'closePopup()','alt'=>'Close','title'=>'Close','class'=>'btn_close'));?>
   <div id="show_message" style="text-align:center">
   	 <?php echo $this->Html->link('Register as Jobseeker','/jobseeker_register', array('escape' => false));?><br/><br/>
	 <?php echo $this->Html->link('Register as Employer',array('controller'=>'employers','action'=>'profile'), array('escape' => false));?><br/><br/>
	 <?php echo $this->Html->link('Register as Exhibitor',array('controller'=>'employers','action'=>'profile'), array('escape' => false));?><br/><br/>
	</div>
</div>


<script type="text/javascript">
function showRegisterPopup(){
	 document.getElementById('register').click();
}
</script>