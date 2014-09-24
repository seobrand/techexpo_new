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

  <div class="inner_banner">
 <!--  <img src="<?php echo $this->webroot;?>img/images/recurit.jpg" alt=""  />-->
   
          <?php $bannerDt = $common->getbannerImage('9');   ?>
 <div class="static_inner_banner">
   <div class="static_title_bar">
  <p><?php  echo $this->Text->truncate($bannerDt['OtherBanner']['name'], 40); ?></p>
  </div>
  <?php // echo $this->Html->image("images/banner_job.jpg");  ?>
  <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  />
  </div>
  
   
    </div>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">To Exhibit & Recruit call 212.655.4505 ext 224</h1>
          <div class="content">
            <div class="gray_full_top"></div>
            <div class="gray_full_mid event_padding1">
              <div class="content">
                <ul class="testimonial_list">
                  <li class="last">
                    <div class="lf_image full_image"><img src="<?php echo $this->webroot;?>img/images/recruit1.jpg" alt="Technical Recruiters" /></div>
                    <div class="testi_description rt_description full_image">
                      <h4 class="subtitle"><strong>An Invitation to all Technical Recruiters / HR Managers</strong></h4>
                      <p>All Job Fairs are not created equal. There's only one official brand: <strong>TECHEXPO Top Secret</strong> that the nation's leading companies have come to trust without hesitation. Since 1993, our organization has been considered among the best producers of professional hiring events in the United States, especially for the recruitment of cleared professionals in areas of technology, engineering, intelligence and beyond!</p>
                      <p><strong><?php echo $this->Html->link("CLICK HERE TO READ TESTIMONIALS",array('controller'=>'','action'=>'testimonials'));?></strong><span class="italic">&nbsp;FROM OUR REPEAT EXHIBITORS!</span> </p>
                  <p><strong><?php echo $this->Html->link("CLICK HERE FOR A LIST OF TECHEXPO Top Secret EXHIBITORS!",array('controller'=>'users','action'=>'exihibitors'));?></strong></p>
                  <p><strong><?php echo $this->Html->link("CLICK HERE to download our REGISTRATION FORMS",array('controller'=>'employers','action'=>'eventregistrationform'));?></strong></p>
                      <p><strong>AFCEA </strong>(Armed Forces Communications & Electronics Association) chose TECHEXPO Top Secret to produce a job fair within their TechNet Conference in June, 2002 in Washington, D.C. Nearly 100 companies exhibited including IBM, Microsoft, Lockheed Martin, L-3 Communications, The FAA, Honeywell, General Dynamics, The CIA, Booz Allen & Hamilton, Harris Corporation with over 4,000 candidates coming to interview with them. We were selected to produce AFCEA's hiring event within TechNet in May 2003 and again in May 2004, where we were awarded the opportunity to produce FOSE's official career fair. Our TECHEXPO Top Secret hiring events are produced throughout Maryland, Virginia, Washington, D.C., Massachusetts, Alabama, Colorado, and California. Since 1999, TECHEXPO has also been selected to produce specialized, custom-boutique open houses for some of the world's leading companies such as AT&T, Microsoft, Northrop Grumman, Lockheed Martin, Sun Microsystems & Boeing. If your company is looking for its own self-branded hiring event with all of the focus just on your critical recruitment needs, please call us for a proposal and we will produce it for you!</p>
                    </div>
                  </li>
                </ul>
                <h5 class="highlight_heading">When you exhibit with TECHEXPO Top Secret you receive the following:</h5>
                <ul class="testimonial_list">
                  <li>
                    <div class="lf_image full_image"><img src="<?php echo $this->webroot;?>img/images/security-clear.jpg" alt="Security-cleared professional" /></div>
                    <div class="testi_description rt_description full_image">
                      <h4 class="subtitle"><strong>Pre-Screened, Security-Cleared Professionals</strong></h4>
                      <p>TECHEXPO Top Secret grants immediate interviews with hundreds of highly qualified candidates. We personally invite hundreds of thousands of highly skilled professionals (with active clearance) to our events via first class, 4-color post cards direct mail, extensive advertising, PR campaigns, on-line advertising and link exchanges. Our advertising & marketing campaign will prove to be second to none.</p>
                    </div>
                  </li>
                  <li>
                    <div class="lf_image full_image"><img src="<?php echo $this->webroot;?>img/images/recruit3.jpg" alt="Your Company Name" /></div>
                    <div class="testi_description rt_description full_image">
                      <h4 class="subtitle"><strong>Your Company Name...</strong></h4>
                      <p>...Will appear in our major Advertising & Public Relations Campaigns including, but not limited to: The Washington Post, Baltimore Sun, San Diego Union-Tribe, Los Angeles Times, New York Times, Colorado Springs Gazette, Denver Post, Boston Globe, Huntsville Times, SIGNAL magazine, GI Jobs magazine, and many more industry-relevant publications.</p>
                    </div>
                  </li>
                  <li>
                    <div class="lf_image full_image"><img src="<?php echo $this->webroot;?>img/images/freeinternet.jpg" alt="Free Internet Advertising" /></div>
                    <div class="testi_description rt_description full_image">
                      <h4 class="subtitle"><strong>FREE Social Media Advertising</strong></h4>
                      <p>TECHEXPO Top Secret events are extensively advertised online as well for maximum exposure: Monster.com, LinkedIn.com, CareerBuilder.com, MilitaryHire.com, IntelligenceCareers.com, TAOnline.com, ClearedConnections.com, VetJobs.com, CareersinGovernment.com, DefenseJobs.com, EngineerJobs.com, SpaceJobs.com, ComputerJobs.com, JustTechJobs.com, User Group websites, & more! This exposes your company as well as your critical job openings to an innumerable volume candidates! We also utilize mass e-mail invitations targeted to the appropriate professionals.</p>
                      <p><strong>This advertising alone is worth thousands of dollars to your company!</strong></p>
                    </div>
                  </li>
                  <li>
                    <div class="lf_image full_image"><img src="<?php echo $this->webroot;?>img/images/company.jpg" alt="Your Company" /></div>
                    <div class="testi_description rt_description full_image">
                      <h4 class="subtitle"><strong>Everything Your Company Needs Is Included</strong></h4>
                      <p>We produce our shows with a first class touch! A catered breakfast & lunch are provided as well as a champagne toast at the end of each event. A company sign, table & chair for you and every candidate as well a personalized company name badge come standard with every show. </p>
                      <p><strong>There are NO hidden additional costs or fees.</strong></p>
                      <p><strong>FACT:</strong> TECHEXPO Top Secret is a low investment for a high return, far surpassing typical newspaper recruitment advertisements,online job postings, & costly placement agencies! It's a fun, time & cost effective way to recruit, network & do a month's worth of interviewing in 1 day! <strong>By hiring or placing just 1 candidate, the event pays for itself!</strong></p>
                    </div>
                  </li>
                  <li>
                    <div class="lf_image full_image"><img src="<?php echo $this->webroot;?>img/images/resumes_fol.jpg" alt="All Resumes are Included" /></div>
                    <div class="testi_description rt_description full_image">
                      <h4 class="subtitle"><strong>ALL OF THE RESUMES ARE INCLUDED</strong></h4>
                      <p>All the resumes collected at the event, as well as those submitted online by professionals that are available to you in the format you desire: online or CD, benefit from some of the amazing online features we can offer you.</p>
                      <p>
                        <srong>
                        TECHEXPO Top Secret prides itself on having one of the most advanced web site of any career fair company in the country. Here is why:</p>
                      <ul class="list padding_none">
                        <li>Unprecedented resume scoring and matching technology</li>
                        <li>The right presentation for search results: our years of experience and working with recruiters have allowed us to present resume search results in what our current clients call "a dream format"</li>
                        <li>Sophisticated resume folder management system, allowing you to e-mail / forward dozens of resumes in a folder in one click, or even send a mass e-mail to candidates.</li>
                        <li>The ability to search pre-registered candidates before the event and schedule show day interviews in advance... so you'll know that you will be interviewing the talent you need even before you get to the show !! </li>
                      </ul>
                    </div>
                  </li>
                  <li>
                    <div class="lf_image full_image"><img src="<?php echo $this->webroot;?>img/images/sponsership.jpg" alt="Sponsosrhip" /></div>
                    <div class="testi_description rt_description full_image">
                      <h4 class="subtitle"><strong>Sponsorship Opportunities Available !</strong></h4>
                      <p>Enhance your presence at our events. In addition to your booth, add a sponsorship to attract more candidates to your table at the event:</p>
                      <ul class="list padding_none">
                        <li><strong>Platinum $7,000</strong> <br />
                          2nd booth at the event; logo in all major print advertising; materials distribution at entrance; banner on TechExpoUSA.com's website. 50 job postions on TechExpoUSA with a corporate banner hung near the entrance to the exhibition hall. </li>
                        <li><strong>Gold $6,000</strong><br />
                          Your company logo printed on bags to be given to all candidates upon arrival. With items of your choice inserted into the bag. Premiere booth location.</li>
                        <li><strong>Silver $5,000</strong><br />
                          An item of your choice such as your company literature, handed out at the entrance to every candidate; premiere booth location</li>
                        <p>Just add any of the sponsorship amounts to the event price and you are all set!</p>
                      </ul>
                    </div>
                  </li>
                  <li>
                    <div class="lf_image full_image"><img src="<?php echo $this->webroot;?>img/images/recruit4.jpg" alt="" /></div>
                    <div class="testi_description rt_description full_image">
                      <h4 class="subtitle"><strong>An Incredible Value !</strong></h4>
                      <p>The TOTAL Price is only $2,995 PER SHOW Attend multiple events and benefit from our multi-show discounts.</p>
                    </div>
                  </li>
                  <li>
                    <div class="lf_image full_image"><img src="<?php echo $this->webroot;?>img/images/recruit2.jpg" alt="" /></div>
                    <div class="testi_description rt_description full_image">
                      <h4 class="subtitle"><strong>Virtual Job Fair / Resume Databases</strong></h4>
                      <p>Nothing beats exhibiting at TECHEXPO and meeting candidates face to face, but if you cannot make it, here is the next best thing: our Virtual Job Fair program, in which you have access to an event's database of resumes (online or CD) as well as the opportunity to post 25 jobs on TechExpoUSA.com. The database and virtual job fairs are only $1,995 per event. </p>
                      <p><strong>FOR MORE INFORMATION, CALL US AT (212) 655-4505 ext. 255 or e-mail to: <a href="mailto:BRand@TechExpoUSA.com">BRand@TechExpoUSA.com</a>.</strong></p>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
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
				 
       			echo $this->element('main_upcoming_events_leftbar', array('cache' => true));
				echo $this->element('main_login_leftbar', array('cache' => true));
			}
	   ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> 
  </div>
</div>
