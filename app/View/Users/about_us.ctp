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
    <div class="inner_banner">  <?php $bannerDt = $common->getbannerImage('1');   ?>
 <div class="static_inner_banner">
   <div class="static_title_bar">
  <p><?php  echo $this->Text->truncate($bannerDt['OtherBanner']['name'], 40); ?></p>
  </div>
 
  <?php // echo $this->Html->image("images/banner_job.jpg");  ?>
  <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  />
 
  
  </div>
    <?php ?>
    </div>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">About Us</h1>
            <div class="content">
              <p>
             <strong> TECHEXPO Top Secret</strong> is the Nation's premiere producer of professional job fairs for professionals with security clearance. TechExpoUSA.com serves as the country's leading online career center where the finest defense contractors, technology companies, consulting firms and numerous agencies of the US Government can recruit and hire experienced cleared professionals.
              </p>
              <br />
              <p>For nearly <strong>20 years</strong>, our company has consistently produced the nation's most successful hiring events for a multitude of industries with a major focus on Technology and Intelligence. With nearly 1,000 produced since the beginning, our team has helped thousands of companies recruit the best talent in the industry and has provided hundreds of thousands of professionals with a forum to advance their career.</p>
              <br />
              <p>TECHEXPO Top Secret career fairs target ALL professionals with a US government security clearance, especially those with skill sets in all areas of I/T, engineering, cyber-security, cloud computing, telecommunications, aerospace, intelligence & operations. Active, transitioning, recent veterans & retired military personnel are also encouraged to attend. These events typically provide face-to-face interviews for hundreds of jobs that require all levels of clearance. Some of our events, simply called TECHEXPO, do not require an active clearance and are open to all experienced technology & engineering professionals with at least 2 years in the industry.</p>
              <br />
              <p>Our Website: <strong>TechExpoUSA.com</strong> offers thousands of opportunities world-wide to qualified candidates that are unable to attend the events in person. Our site has a membership volume of over 160,000 experienced professionals.</p>
              <br />
              <p><strong>TECHEXPO </strong>has been featured on CNN, New York Times, Washington Post, Baltimore Sun, Wall Street Journal, Baltimore Business Journal and various other print and online media outlets. Our active client list exceeds 500 corporations.</p>
              <br />
              <p><strong>TECHEXPO </strong>has produced more "Customized or Boutique Open Houses" for major corporations than all other event and recruitment advertising agencies combined. These clients include many market leaders; IBM, Verizon, Microsoft, AT&T, Boeing, Northrop Grumman, L-3 Communications, General Dynamics and numerous others. TECHEXPO has one the most established, high-end corporate images amongst the entire recruitment industry.</p>
              <br />
              <p><strong>TECHEXPO </strong>values its strong relationships with numerous industry-related print and online media as well as professional associations & user groups such as; AFCEA, NYSIA, LISTA, Post Newsweek Tech Media, 1105 Media, WSTA, WebGrrrls, VetJobs, MilitaryHire, TAOnline, IDGA, AeroIndustryJobs, SpaceJobs, DefenseJobs, ComputerJobs, Security University, Gov Events, Defense Daily, Fierce Government IT, Military Exits and many others.</p>
              <br />
              <p>TECHEXPO has had numerous exclusive arrangements with large, established, industry trade shows such as: TechNet, West, GovSec, Transformation Warfare and FOSE where show attendees can interview on the spot at the TECHEXPO Job Fair Pavilions.</p>
              <br />
              <p>Our parent company, Job Expo International is recognized by Red Book as an official Recruitment Ad Agency. Thereby we are always able to arrange reduced advertising rates & superior ad placements for our clients and events. Our company handles all the media buying and creative 'in house' including services such as event production, logistical planning and recruitment marketing strategies. Our parent company has also produced job fairs such as Financial Career Expo, Fashion Career Expo, Diversity Expo and one of the nation's largest eco-friendly trade shows; Go Green Expo.</p>
              <br />
              <p>
              TECHEXPO began in <strong>1992</strong> with it's first ever event in New York City on February of 1993 to an attendance of 50 companies and 2,000 candidates. The business is privately held and lead by founder and CEO, <strong>Bradford Rand</strong>.
              </p>
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