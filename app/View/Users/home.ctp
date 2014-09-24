<div id="wrapper">
    <div class="search_panel">
      <div class="search">
        <ul class="search_list">
          <li class="aligncenter">
            <h1>JOB SEEKERS</h1>
          
          <?php
			echo $this->Html->link($this->Html->image("images/submit_res.jpg"), array('controller'=>'candidates','action'=>'register'), array('escape' => false));
          ?> 
            <br />
            <h3><a href="search-results.html">Browse available jobs</a></h3>
          </li>
          <li class="aligncenter">
            <h1>EMPLOYERS</h1>
            <a href="employer-progress.html"> 
            <?php echo $this->Html->image('images/postjob.jpg'); ?>
            </a>
          </li>
          <li class="last aligncenter">
            <h1>RECRUIT WITH US</h1>
           <a href="employer-progress.html"><?php echo $this->Html->image('images/submit_exhi.jpg'); ?>  </a>
          </li>
        </ul>
        <div class="clear"></div>
      </div>
    </div>
    	
    <div id="container">
      <div class="lf_col">
        <div class="box">
          <div class="findjob_head"><?php echo $this->Html->image('images/findjob_txt.jpg'); ?></div>
          <div class="find_mid">
            <div class="find_bottom">
              <div class="search_padding">
                <div class="search_action">
                  <div class="search_col1">
                    <label>Keywords:</label>
                    <br />
                    <input name="" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'All Sectors':this.value;" value="All Sectors" type="text" />
                    <label>Job Sector:</label>
                    <br />
                    <div class="dropdown">
                      <select name="">
                        <option selected="selected">All Sectors</option>
                      </select>
                    </div>
                  </div>
                  <div class="search_col1">
                    <label>Location:</label>
                    <br />
                    <div class="dropdown">
                      <select name="">
                        <option selected="selected">All Locations</option>
                      </select>
                    </div>
                    <label>Job by Clearance Type:</label>
                    <br />
                    <div class="dropdown">
                      <select name="">
                        <option selected="selected">All Clearance Types</option>
                      </select>
                    </div>
                  </div>
                  <div class="search_btn">
                    <a href="search-results.html">
                   		 <?php echo $this->Html->image('images/search.jpg'); ?>
                     </a>
                  </div>
                  <div class="clear"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box">
          <div class="event_head">Calendar of Events</div>
          <div class="event_mid">
            <div class="event_bottom">
              <div class="event_padding">
                <ul class="event_list">
                  <li>
                    <div class="event_panel">
                      <div class="event_date">
                        <div class="date"> <span>jan</span><span class="dt">18</span> </div>
                      </div>
                      <div class="event_desc">
                        <p><a href="event-details.html"> TECHEXPO > Top Secret on <span class="italic">01/18/12</span></a><br />
                          <span>Tysons Corner Ritz Carlton - McLean, VA <br />
                          Security Clearance REQUIRED</span></p>
                      </div>
                      <div class="event_outlook"><a href="">Add to Outlook <br />
                        or iCalendar</a></div>
                      <div class="event_outlook_img"><?php echo $this->Html->image('images/outlook.jpg'); ?></div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                    <div class="event_panel">
                      <div class="event_date">
                        <div class="date"> <span>jan</span><span class="dt">18</span> </div>
                      </div>
                      <div class="event_desc">
                        <p><a href="event-details.html"> TECHEXPO > Top Secret on <span class="italic">01/18/12</span></a><br />
                          <span>Tysons Corner Ritz Carlton - McLean, VA <br />
                          Security Clearance REQUIRED</span></p>
                      </div>
                      <div class="event_outlook"><a href="">Add to Outlook <br />
                        or iCalendar</a></div>
                      <div class="event_outlook_img"> <?php echo $this->Html->image('images/outlook.jpg'); ?></div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                    <div class="event_panel">
                      <div class="event_date">
                        <div class="date"> <span>jan</span><span class="dt">18</span> </div>
                      </div>
                      <div class="event_desc">
                        <p> <a href="event-details.html">TECHEXPO > Top Secret on <span class="italic">01/18/12</span></a><br />
                          <span>Tysons Corner Ritz Carlton - McLean, VA <br />
                          Security Clearance REQUIRED</span></p>
                      </div>
                      <div class="event_outlook"><a href="">Add to Outlook <br />
                        or iCalendar</a></div>
                      <div class="event_outlook_img"> <?php echo $this->Html->image('images/outlook.jpg'); ?></div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                    <div class="event_panel">
                      <div class="event_date">
                        <div class="date"> <span>jan</span><span class="dt">18</span> </div>
                      </div>
                      <div class="event_desc">
                        <p> <a href="event-details.html">TECHEXPO > Top Secret on <span class="italic">01/18/12</span></a><br />
                          <span>Tysons Corner Ritz Carlton - McLean, VA <br />
                          Security Clearance REQUIRED</span></p>
                      </div>
                      <div class="event_outlook"><a href="">Add to Outlook <br />
                        or iCalendar</a></div>
                      <div class="event_outlook_img">
                      <?php echo $this->Html->image('images/outlook.jpg'); ?>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                    <div class="event_panel">
                      <div class="event_date">
                        <div class="date"> <span>jan</span><span class="dt">18</span> </div>
                      </div>
                      <div class="event_desc">
                        <p> <a href="event-details.html">TECHEXPO > Top Secret on <span class="italic">01/18/12</span></a><br />
                          <span>Tysons Corner Ritz Carlton - McLean, VA <br />
                          Security Clearance REQUIRED</span></p>
                      </div>
                      <div class="event_outlook"><a href="">Add to Outlook <br />
                        or iCalendar</a></div>
                      <div class="event_outlook_img"> <?php echo $this->Html->image('images/outlook.jpg'); ?></div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                    <div class="event_panel">
                      <div class="event_date">
                        <div class="date"> <span>jan</span><span class="dt">18</span> </div>
                      </div>
                      <div class="event_desc">
                        <p> <a href="event-details.html">TECHEXPO > Top Secret on <span class="italic">01/18/12</span></a><br />
                          <span>Tysons Corner Ritz Carlton - McLean, VA <br />
                          Security Clearance REQUIRED</span></p>
                      </div>
                      <div class="event_outlook"><a href="">Add to Outlook <br />
                        or iCalendar</a></div>
                      <div class="event_outlook_img"> <?php echo $this->Html->image('images/outlook.jpg'); ?></div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                    <div class="event_panel">
                      <div class="event_date">
                        <div class="date"> <span>jan</span><span class="dt">18</span> </div>
                      </div>
                      <div class="event_desc">
                        <p> <a href="event-details.html">TECHEXPO > Top Secret on <span class="italic">01/18/12</span></a><br />
                          <span>Tysons Corner Ritz Carlton - McLean, VA <br />
                          Security Clearance REQUIRED</span></p>
                      </div>
                      <div class="event_outlook"><a href="">Add to Outlook <br />
                        or iCalendar</a></div>
                      <div class="event_outlook_img"> <?php echo $this->Html->image('images/outlook.jpg'); ?></div>
                      <div class="clear"></div>
                    </div>
                  </li>
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
                  <li>  <?php echo $this->Html->image('images/img1.jpg'); ?>
                    <div class="special_desc">First time applicant, previously applied and or been referred to our AP2 program in the past? We enhanced our compensation package! <a href="">Click here to find out more!</a></div>
                    <div class="clear"></div>
                  </li>
                  <li> 
                  <?php echo $this->Html->image('images/img2.jpg'); ?>
                 
                    <div class="special_desc">Looking for a small, flexible and family-friendly company with excellent benefits? Learn about us, check out positions, benefits and more at <a href="">http://www.integrateit.net</a></div>
                    <div class="clear"></div>
                  </li>
                  <li> <?php echo $this->Html->image('images/img3.jpg'); ?>
                    <div class="special_desc">Send your career upwards! TransQuest is seeking top of the line cleared, professional talent. For more details and to apply to our jobs please <a href="">Click here</a></div>
                    <div class="clear"></div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="rt_col">
        <div class="side_box">
          <div class="side_head">Featured Employer:</div>
          <div class="side_mid">
            <div class="side_bottom">
              <div class="featured_logo"><?php echo $this->Html->image('images/featured_logo.jpg'); ?>  </div>
            </div>
          </div>
        </div>
        <?php if(!$this->Session->read('Auth.Client.id')): ?>
			<div class="side_box">
          <div class="white_head"></div>
          <div class="white_mid">
            <div class="white_bottom">
              <h3>LOG IN</h3>
              <?php echo $this->Form->create('User',array('controller'=>'users','action'=>'index')); ?>
              <ul class="login_panel">
                <li>
                 
                  <?php echo $this->Form->input('User.username',array('class'=>'login_txt','type'=>'text','value'=>'User Name:','onclick'=>"this.value='';",'onfocus'=>'this.select()','onblur'=>"this.value=!this.value?'User Name:':this.value;",'div'=>'','label'=>''));?>
                  
                </li>
                <li>
                 <?php  echo $this->Form->input('User.password',array('class'=>'login_txt','type'=>'password','value'=>'Password:','onclick'=>"this.value='';",'onfocus'=>'this.select()','onblur'=>"this.value=!this.value?'Password:':this.value;",'div'=>'','label'=>'')); ?>
                
                 
                </li>
                <li>
                
                <?php 
                	 echo $this->Form->input('User.LOGIN',array('type'=>'hidden','value'=>'LOGIN'));
               		 echo $this->Form->submit('images/submit.jpg',array('style'=>'float:right'));
                 ?>
                  
                  <label><a href="">Register Now</a> / <a href="">Forgot password</a></label>
                  <div class="clear"></div>
                </li>
              </ul>
              <?php echo $this->end(); ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
        <div class="side_box">
          <div class="white_head"></div>
          <div class="white_mid1">
            <div class="white_bottom1">
            <div class="newsletter_header">
             <?php echo $this->Html->image('images/email_icon.jpg'); ?>
    
              <h4>Join our mailing list</h4>
              <p>A quick way to sign up and be informed for upcoming </p>
              <div class="clear"></div>
              
              <ul class="newsletter_panel">
                <li>
                  <input name="" type="text" value="Enter your email address" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Enter your email address':this.value;" class="newsletter_txt" />
                </li>
                <li>
                  <?php echo $this->Form->submit('images/newsletter_button.jpg',array('style'=>'float:right','class'=>'newsletter_submit'));?>
                </li>
               
              </ul>
              <div class="clear"></div>
              </div>
              
              <div class="newsletter_header bordernone">
              <?php echo $this->Html->image('images/emai2_icon.jpg'); ?>
          
              <h4 class="newsletter_subheading">Tell a friend's about us</h4>

              <div class="clear"></div>
              
              <ul class="newsletter_panel">
                <li>
                  <input name="" type="text" value="Your friends email address" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Your friends email address':this.value;" class="newsletter_txt" />
                </li>
                <li>
					<?php echo $this->Form->submit('images/newsletter_button.jpg',array('style'=>'float:right','class'=>'newsletter_submit'));?>
                </li>
               
              </ul>
              <div class="clear"></div>
              </div>
              
              
              
            </div>
          </div>
        </div>
        
        <div class="side_box">
          <div class="news_head">Industry News </div>
          <div class="news_mid">
            <div class="news_bottom">
              <ul class="news_list">
                <li> <?php echo $this->Html->image('images/new1.jpg'); ?>
                  <div class="special_desc">First time applicant, previously applied and or been referred to our AP2 program in the past? We enhaced... <a href="emp-news.html">Click here to find out more!</a></div>
                  <div class="clear"></div>
                </li>
                <li> <?php echo $this->Html->image('images/new2.jpg'); ?>
                  <div class="special_desc">Looking for a small, flexible and family-friendly company with excellent benefits? Learn about us, check... <a href="emp-news.html">http://www.integrateit.net</a></div>
                  <div class="clear"></div>
                </li>
                <li> <?php echo $this->Html->image('images/new1.jpg'); ?>
                  <div class="special_desc">First time applicant, previously applied and or been referred to our AP2 program in the past? We enhaced... <a href="emp-news.html">Click here to find out more!</a></div>
                  <div class="clear"></div>
                </li>
                <li class="last"> <?php echo $this->Html->image('images/new2.jpg'); ?>
                  <div class="special_desc">Looking for a small, flexible and family-friendly company with excellent benefits? Learn about us, check... <a href="emp-news.html">http://www.integrateit.net</a></div>
                  <div class="clear"></div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
      
      <div class="scroller_panel">
<h5>Our Partners</h5>

<ul id="first-carousel" class="first-and-second-carousel jcarousel-skin-tango">
          <li><?php echo $this->Html->image('images/scroller1.jpg'); ?></li>
          <li><?php echo $this->Html->image('images/scroller2.jpg'); ?></li>
          <li><?php echo $this->Html->image('images/scroller3.jpg'); ?></li>
          <li><?php echo $this->Html->image('images/scroller4.jpg'); ?></li>
          <li><?php echo $this->Html->image('images/scroller5.jpg'); ?></li>
          <li><?php echo $this->Html->image('images/scroller1.jpg'); ?></li>
          <li><?php echo $this->Html->image('images/scroller2.jpg'); ?></li>
          <li><?php echo $this->Html->image('images/scroller3.jpg'); ?></li>
        </ul>
    <div class="clear"></div>  
      </div>
      
      
    </div>
  </div>
  

  