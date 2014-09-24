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
	
    <?php // echo $this->Html->image('images/why_attend.jpg');?>
           <?php $bannerDt = $common->getbannerImage('11');   ?>
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
            <h1 class="bluecolor">Contact Us</h1>
            <div class="content"><br />

<h2>TECHEXPO <p style="font-size:12px !important;color:#2D2D2D;">A Division of Job Expo International Inc.</p> </h2>


<p class="con_address"><strong>276 Fifth Avenue Suite 906<br />

New York, NY 10001</strong></p>



<p class="con_telephone"><strong>Tel: 212.655.4505 ext. <!--225-->224</strong><br /></p>

<p class="con_fax"><strong>Fax: 212.655.4501</strong></p>
<br />




            <div class="gray_full_top"></div>
            <div class="gray_full_mid event_padding1">
              
              <ul class="contactus_new">
<li>
<div class="contact_new_box">

<div class="contact_icon"><?php  echo $this->Html->image("images/nw_mail.png");  ?></div>
<div class="contact_new_rt"><h3>Job Seekers</h3>
<a href="mailto:Amanda@TechExpoUSA.com">Amanda@TechExpoUSA.com</a></div>

</div>

</li>

<li>
<div class="contact_new_box">
<div class="contact_icon"><?php  echo $this->Html->image("images/nw_mail.png");  ?></div>
<div class="contact_new_rt"><h3>Employers</h3>
<a href="mailto:NMathew@TechExpoUSA.com">NMathew@TechExpoUSA.com</a></div>

</div>

</li>

<?php /*?><li>
<div class="contact_new_box">
<div class="contact_icon"><?php  echo $this->Html->image("images/nw_mail.png");  ?></div>
<div class="contact_new_rt"><h3>Marketing</h3>
<a href="mailto:marketing@TechExpoUSA.com">marketing@TechExpoUSA.com</a></div>

</div>

</li>

<li>
<div class="contact_new_box">
<div class="contact_icon"><?php  echo $this->Html->image("images/nw_mail.png");  ?></div>
<div class="contact_new_rt"><h3>Tech Support</h3>
<a href="mailto:webmaster@TechExpoUSA.com">webmaster@TechExpoUSA.com</a></div>

</div>

</li><?php */?>

<li class="last">
<div class="contact_new_box">
 


<h3>Management inquiries:</h3>
<div class="management_div">
<p><strong>Bradford Rand, Founder &amp; CEO</strong><br/>
212.655.4505 ext. 223</p>
<a href="mailto:brand@techexpousa.com">brand@techexpousa.com</a>
</div>
</div>

</li>


</ul><br /><br />

              <div class="clear"></div>
            </div>
     
          
          
          



        
        <!--<table width="100%" cellspacing="0" cellpadding="0" border="0" class="tableWhd">
    
   
   <tbody>
   <tr>
   <td class="table_row">
   <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
     <td width="29%" align="left">Job Seekers:</td>
     <td width="69%" class="last" align="left"><a href="mailto:admin@TechExpoUSA.com">admin@TechExpoUSA.com</a></td>
    
      </tr>
      
    </tbody></table>
    </td>
   </tr>
 
<tr>
   <td class="table_row alternate">
   <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
     <td width="29%" align="left">Employers: </td>
     <td width="69%" class="last" align="left"><a href="mailto:jobs@TechExpoUSA.com">jobs@TechExpoUSA.com</a></td>
    
      </tr>
      
    </tbody></table>
    </td>
   </tr>
   
   <tr>
   <td class="table_row">
   <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
     <td width="29%" align="left">Marketing:  </td>
     <td width="69%" class="last" align="left"><a href="mailto:	marketing@TechExpoUSA.com">marketing@TechExpoUSA.com</a></td>
    
      </tr>
      
    </tbody></table>
    </td>
   </tr>
   
    <tr>
   <td class="table_row alternate">
   <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
     <td width="29%" align="left">
Tech Support:  </td>
     <td width="69%" class="last" align="left"><a href="mailto:webmaster@TechExpoUSA.com">	webmaster@TechExpoUSA.com</a></td>
    
      </tr>
      
    </tbody></table>
    </td>
   </tr>
   
      <tr>
   <td class="table_row">
   <table width="100%" cellspacing="0" cellpadding="0" border="0">
    <tbody><tr>
     <td width="29%" align="left">
Management inquiries:  </td>
     <td width="69%" class="last" align="left">Bradford Rand, Founder &amp; CEO<br />
212.655.4505 ext. 223<br />

<a href="mailto:brand@techexpousa.com">brand@techexpousa.com</a></td>
    
      </tr>
      
    </tbody></table>
    </td>
   </tr>
 </tbody></table>-->
 
    
 	
	
 <br />
<br />
<br />
<br />
<br />
<br />
<br />

 	

 

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