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
   <div class="inner_banner">
   <?php $bannerDt = $common->getbannerImage('5');   ?>
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
            <h1 class="bluecolor">Continuing Education</h1>
            <div class="content">
              <table class="border_table" style="width:500" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <?php foreach( $trainingschools as $ts ){ ?>
                  <tr valign="top" align="center">
                    <td align="center"><a target="_blank" href="<?php echo $ts['TrainingSchool']['ts_web']; ?>">
                
					<?php if(file_exists(TS.$ts['TrainingSchool']['ts_logo_path'])) 
					{
					// echo $this->Html->image('TrainingSchools/'.$ts['TrainingSchool']['ts_logo_path'],array('style'=>' max-width: 594px;'));
					?>
					 
					  <img src="thumbnail.php?file=<?php echo FULL_BASE_URL.router::url('/',false);?>img/TrainingSchools/<?php echo $ts['TrainingSchool']['ts_logo_path'];?>&maxw=594px&maxh=200px"  />
					  <?php }
					  else 
					  {
					  echo $this->Html->image('TrainingSchools/no_image.jpg');
					   }?>
              
                       </a><br>
                     <?php echo  $ts['TrainingSchool']['ts_profile'];  ?>
                     </td>
                  </tr>
                  <tr>
                  <td  class="noborder" height="15px">
                  </td>
                  </tr>
                 <?php } ?> 
                 
                </tbody>
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