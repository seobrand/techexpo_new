<div id="wrapper">
     <?php 
	// pr($employerDetail);
	 
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
            <h1 class="bluecolor">Company Profile </h1>
           
                 
            <table width="100%">
            	<tr>
                	<td width="4%"></td>
                	<td width="200px">
                    <div class="compnay_name" style="clear:both"><?php echo $employerDetail['Employer']['employer_name'];?></div><br /><br />
                  <div style="clear:both;padding-left:15px" >
                 <?php echo $employerDetail['Employer']['address'];?><br />  </div>
                  
                    
                    </td>
                    <td width="30%" align="right"> <?php if($employerDetail['Employer']['logo_file']!=""){?>
	              	<div class="compnay_profile_logo"><img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$employerDetail['Employer']['logo_file'];?>&maxw=200&maxh=80"  alt="<?php echo $employerDetail['Employer']['employer_name']; ?>"  title="<?php echo $employerDetail['Employer']['employer_name']; ?>"/>&nbsp;</div>
	          	 <?php }?></td>
                 <td width="5%"></td>
                </tr>
            
            </table>     
                 
                 
                 
            <div class="content">           	 
            <?php /*?>  <div class="border_bottom">
	             
              	<div class="compnay_name"><?php //echo $employerDetail['Employer']['employer_name'];?></div>
              </div><?php */?>
              
              
              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
              <br/>
                <ul class="form_list manage_resume_form">
                <?php if($employerDetail['Employer']['city']!=""){?>
                  <li>
                    <label>City:</label>
                    <div class="form_rt_col1">
                      <label>	<?php echo $employerDetail['Employer']['city']; ?></label>
                    </div>
                  </li>
                <?php }?>
                <?php if($employerDetail['Employer']['state']!=""){?>
                  <li>
                    <label>State:</label>
                    <div class="form_rt_col1">
                      <label><?php echo $employerDetail['Employer']['state']; ?></label>
                    </div>
                  </li>
                <?php }?>
                <?php if($employerDetail['Employer']['url']!=""){?>
                  <li>
                    <label>Company Website:</label>
                    <div class="form_rt_col1">
                      <label>	
<?php $url = parse_url($employerDetail['Employer']['url']);
$url = isset($url['scheme']) ? $employerDetail['Employer']['url'] : "http://".$employerDetail['Employer']['url'];
?>                       
<a href="<?php echo $url?>" target="_blank"><?php echo $employerDetail['Employer']['url']; ?></a>


</label>
                    </div>
                  </li>
                <?php }?>
                <?php if($employerDetail['Employer']['stock_symbol']!=""){?>
                  <li>
                    <label>Stock Symbol:</label>
                    <div class="form_rt_col1">
                      <label>  <?php echo $employerDetail['Employer']['stock_symbol']; ?></label>
                    </div>
                  </li>
                <?php }?>
                <?php if($employerDetail['Employer']['annual_revenue']!=""){?>
                  <li>
                    <label>Annual Revenue:</label>
                    <div class="form_rt_col1">
                      <label><?php echo $employerDetail['Employer']['annual_revenue']; ?></label>
                    </div>
                  </li>
                <?php }?>
                <?php if($employerDetail['Employer']['number_of_employees']!=""){?>
                  <li>
                    <label>Number of Employees:</label>
                    <div class="form_rt_col1">
                      <label><?php echo $employerDetail['Employer']['number_of_employees']; ?></label>
                    </div>
                  </li>
                <?php }?>
                <?php if($employerDetail['Employer']['visa_status']!=""){?>
                  <li>
                    <label>Answer to the question "Do you occasionally sponsor H1-B visas ?"</label>
                    <div class="form_rt_col1">
                     <label><?php echo $employerDetail['Employer']['visa_status']; ?></label>
                    </div>
                  </li>
                <?php }?>
                  <!--<li>
                    <label>Industry: </label>
                    <div class="form_rt_col1">
                      <label>	National Security Solutions</label>
                   
                    </div>
                  </li>-->
                    <li>
                    <label>Company Description: </label>
                    <div class="form_rt_col1">
                      <label><?php echo $employerDetail['Employer']['description']; ?></label>
                     
                    </div>
                  </li>
                </ul>
                
                <?php if(!empty($EmployerVd['EmployerVideo']['id'])) {   ?>
                <div class="preview_panel">
                <h2 class="border_botom">Company Video</h2>
             
                
                <a href="<?php echo $this->Html->url(FULL_BASE_URL.router::url('/',false).'employers/empshowVideo/'.$EmployerVd['EmployerVideo']['id'], false); ?>" class="ajax_empvideo" >
             <?php if($EmployerVd['EmployerVideo']['video_type']=='upload')
				{
				 echo $this->Html->image("images/video.jpg",array('style'=>'width:200px;'));
				}
				else {
					$youtubeId = end(explode('/',$EmployerVd['EmployerVideo']['video']));
				 ?>
                <img src="http://img.youtube.com/vi/<?php echo $youtubeId; ?>/0.jpg" style="width:200px;"  />
                <?php } ?>
                </a>
                
                </div>
                <?php } ?>
              
                
                <div class="preview_panel">
                
               
                  <h2 class="border_botom"><?php echo $employerDetail['Employer']['employer_name']; ?> Open Jobs </h2>
                  
                    <?php 
					if(count($employerDetail['JobPosting'])!= 0 ) {
					foreach($employerDetail['JobPosting'] as $key=>$value): 
						 if($value['active']){
					?>
                        <p><strong>
                        <?php echo $this->Html->link($value['job_title'],array('controller'=>'candidates','action'=>'jobDetail?jobId='.$value['posting_id']));?>
                            
                        </strong><br /><?php echo $value['short_descr']; ?></p>
                    <?php }  endforeach; 
					}
					else
					{
					echo 'This company presently has no open job listings';	
					}
					?>

                </div>
                <br />


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
				echo $this->element('main_login_leftbar', array('cache' => true)); 
       			echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); 
			}
	   ?>
      <div class="clear"></div>
      <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>