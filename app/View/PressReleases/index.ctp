<div id="wrapper_outer1">
  <div id="wrapper">
    <div class="inner_banner">
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
       <?php $bannerDt = $common->getbannerImage('6');   ?>
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
            <h1 class="bluecolor">Press / Media Coverage</h1>
          
          <div class="content">
          <h2 class="mana_subheading">For Press & Media related question call:</h2>
          <p><strong>Bradford Rand,</strong> President / CEO<br />
Tel: 212.655.4505 ext 223<br />
Email: <a href="mailto:BRand@TechExpoUSA.com">BRand@TechExpoUSA.com</a></p><br />

<p><span class="instruction">Below are a list of media related announcements about TECHEXPO. Click to on the Title of the link to review each media article.</span></p><br />


             
<table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
    
   <?php foreach($pressreleases as $pressrelease){  ?>
   <tr>
   <td class="table_row border_bottom">
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
     <td  width="25%" style="text-align:left;font-weight:bold;">     
     <?php echo $this->Html->image("images/arrow.png",array('alt'=>''));?>
   &nbsp;&nbsp;<?php echo date(DATE_FORMAT, strtotime( $pressrelease['PressRelease']['pr_date']));  ?></td>
     <td  width="74%" class="last normalfont" style="text-align:left;font-weight:bold;">
     <?php if(file_exists(PRESS.$pressrelease['PressRelease']['pr_file'])) { ?>
     <a href="<?php   echo  'img/press/'.$pressrelease['PressRelease']['pr_file'];  ?>" class="blueHover" target="_blank">
	 <?php echo  $pressrelease['PressRelease']['pr_title'];  ?> </a>
     <?php }else{ ?>
   
	 <?php echo  $pressrelease['PressRelease']['pr_title'];  ?>
     <?php  } ?>
     </td>
    
      </tr>
    
      
    </table>
    </td>
   </tr>
   <?php  } ?>

 
 </table>
 
 
    
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