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
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Event Registration Forms</h1>
          <div class="content">
            <div class="jobseeker_info">
              <p><strong>To exhibit and recruit at our events, please call Nancy Mathew(212)655-4505 ext.225 or email NMathew@TechExpoUSA.com </strong> </p>
             
            </div><p>
TECHEXPO is the nation's leader in professional hiring events for the defense, technology & intelligence industry.
<br/><br/>
With over 20 years experience and production of over 1,000 events globally, our team is here to focus on creating turn-key effective solution strategies for your company's needs.
<br/><br/>
TECHEXPO produces hiring events for <strong>Security-Cleared Professionals, Cyber Security Professionals,IT Developers, Polygraph Tested Professionals and Cloud Computing Professionals</strong>.
<br/><br/>
<strong>If your company has recently been awarded a government contract and you are in need of hiring a specific targeted audience, TECHEXPO would be happy to assist you in creating a customized boutique hiring event to fulfill your company's recruitment needs.</strong>
</p><br/>
         <!--   <div class="gray_full_top"></div>-->
            <div class="">
           
              
              <ul class="form_list manage_resume_form event_newform02">
              
              <li>
                  <div class="gray_bxbg02"><label> 
                  
                   <?php  echo $this->Html->link($this->Html->image('images/shows_reg_2014_topsecret.jpg', array('alt' => '2014 TECHEXPO RECRUITMENT SCHEDULE','width'=>'606')), '/EventRegForm/TECHEXPO2014.pdf',array('target'=>'blank','escape'=>false)); 	?>
                  </label></div>
                  <div class="form_rt_col1">
                    <p>
                    This PDF document provides the <strong>2014 TECHEXPO Top Secret Event Plan</strong> including the exhibitor benefits of recruiting at one of our events. To exhibit, simply fax or scan back the last page of the presentation.
                    </p>
                    
                  </div><div class="clich_herediv">
                    <?php  echo $this->Html->link('Click here to download The Event Presentation & Participation Guide', '/EventRegForm/TECHEXPO2014.pdf',array('target'=>'_blank')); 	?>
                  </div>
               </li>
               
               
               <li>
                  <div class="gray_bxbg02"><label> 
                  <?php  echo $this->Html->link($this->Html->image('images/shows_reg_2014_polygraph.jpg', array('alt' => '2014 POLYGRAPH ONLY RECRUITMENT SCHEDULE','width'=>'606')), '/EventRegForm/TETS_Polygraph_2014.pdf',array('target'=>'_blank','escape'=>false)); 	?>
                  </label></div>
                  <div class="form_rt_col1">
                    <p>This PDF document provides the <strong>2014 TECHEXPO Top Secret POLYGRAPH-ONLY Event Plan</strong> including the exhibitor benefits of recruiting at one of our events. To exhibit, simply fax or scan back the last page of the presentation.</p>
                    
                  </div><div class="clich_herediv">
                  <?php  echo $this->Html->link('Click here to download The Event Presentation & Participation Guide', '/EventRegForm/TETS_Polygraph_2014.pdf',array('target'=>'_blank')); 	?>
                  </div>
               </li>
              
              
              <li>
                  <div class="gray_bxbg02"><label> 
                  
                   <?php  echo $this->Html->link($this->Html->image('images/shows_reg_2013_topsecret.jpg', array('alt' => '2013 TECHEXPO Top Secret events for all regions','width'=>'606')), '/EventRegForm/TETS2013.pdf',array('target'=>'_blank','escape'=>false)); 	?>
                  </label></div>
                  <div class="form_rt_col1">
                    <p>Provides information on our <strong>2013 TECHEXPO Top Secret events</strong>. If you were NOT able to exhibit & recruit at any of these events, here is your opportunity to gain access to the resume databases from any of our hiring events during 2013. To gain access, simply fax or scan back the last page of the presentation and check off "<strong>Virtual</strong>" for each of the events you would like resume access to. You may call us for any additional questions: 212.655.4505 ext. 225 </p>
                    
                  </div><div class="clich_herediv">
                   <?php  echo $this->Html->link('Click here to download The Event Presentation & Participation Guide', '/EventRegForm/TETS2013.pdf',array('target'=>'_blank')); 	?>
                  </div>
               </li>
               
               
               <li>
                  <div class="gray_bxbg02"><label>
                   <?php  echo $this->Html->link($this->Html->image('images/shows_reg_2013_polygraph.jpg', array('alt' => '2013 TECHEXPO Polygraph Only events for all regions','width'=>'606')), '/EventRegForm/TETSPolygraph2013.pdf',array('target'=>'blank','escape'=>false)); 	?>
                  </label></div>
                  <div class="form_rt_col1">
                    <p>Provides information on our <strong>2013 TECHEXPO Top Secret POLYGRAPH-ONLY Event Plan events</strong>.  If you were NOT able to exhibit & recruit at any of these exclusive events, here is your opportunity to gain access to the resume databases from any of our hiring events during 2013.  To gain access, simply fax or scan back the last page of the presentation and check off "<strong>Virtual</strong>" for each of the events you would like resume access to.  You may call us for any additional questions: 212.655.4505 ext. 225</p>
                    
                  </div><div class="clich_herediv">
                  <?php  echo $this->Html->link('Click here to download The Event Presentation & Participation Guide', '/EventRegForm/TETSPolygraph2013.pdf',array('target'=>'blank')); 	?>
                 </div>
               </li>
               
               
               
            <?php /*?>
              
              <li>
                  
                  <div class="gray_bxbg02"><label> <a href="<?php echo $this->webroot;?>EventRegForm/TETS_2012_Resumes.pdf" target="_blank"><img src="<?php echo $this->webroot;?>img/images/event_registration_banner_TECHEXPO2012.jpg" width="606" alt="2012 TECHEXPO Resume Databases" /> </a></label></div>
                  
                  <div class="form_rt_col1">
                    <p>Provides information on our <strong>2012 TECHEXPO Resume Databases</strong>, online or on CD-ROM and includes a faxable order form. Download, print, fill and fax back to (212) 655-4501.</p>
                  </div>
                  <div class="clich_herediv"><a href="<?php echo $this->webroot;?>EventRegForm/TETS_2012_Resumes.pdf" target="_blank">Click here to download The Event Presentation & Participation Guide</a></div>
                </li>
              <li>
                
                   <div class="gray_bxbg02"><label> <a href="<?php echo $this->webroot;?>EventRegForm/TETS_2011VJF.pdf" target="_blank"><img src="<?php echo $this->webroot;?>img/images/event_registration_banner_TECHEXPO2011.jpg" width="606" alt="2011 TECHEXPO Resume Databases" /> </a></label></div>
                  <div class="form_rt_col1">
                    <p>Provides information on our <strong>2011 TECHEXPO Resume Databases</strong>, online or on CD-ROM and includes a faxable order form. Download, print, fill and fax back to (212) 655-4501</p>
                  </div>
                    <div class="clich_herediv"><a href="<?php echo $this->webroot;?>EventRegForm/TETS_2011VJF.pdf" target="_blank">Click here to download The Event Presentation & Participation Guide</a></div>
                </li>
                <?php */?>
         
              </ul>
           
            </div>
          </div>
        </div>
      </div>
    </div>
   <div class="rt_col_inner">
    	<?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
    </div>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> 
  </div>
</div>
