<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Preview Resume</h1>
          <div class="content">
            <!--<div class="jobseeker_info">
              <p><strong><?php echo $candidateRec['Candidate']['candidate_name']; ?></strong><br />
                Thursday, 04/19/2012 - 08:06 AM EST</p>
            </div>-->
            <h2 class="mana_subheading">Candidate Summary and Core Skills</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <div class="preview_lf">
                <p><strong>Candidate Name:</strong><?php echo $candidateRec['Candidate']['candidate_name']; ?></p>
                <p><strong>Location:</strong>
                  <?php $locationArray=explode(',',$pref_locations=$candidateRec['Candidate']['pref_locations']); 
                	$totalRec=count($locationArray);
                    $i=1;
                    foreach($locationArray as $key =>$value)
                    {
                      echo  $common->getStateName($value);
                      if($i!=$totalRec):
                      	echo '&nbsp;,&nbsp;';
                      endif;
                      $i=$i+1;
                    }
              
			
			 
			    ?>
                </p>
                <p><strong>Current Title: <?php echo $candidateRec['Candidate']['candidate_title']; ?> </strong></p>
                <p><strong>Resume Title:</strong> <?php echo $candidateRec['Resume']['resume_title']; ?></p>
                <p><strong>Resume last updated on:</strong> <?php echo date('d-M-Y',strtotime($candidateRec['Resume']['modified']));  ?></p>
                <p><strong>Total years of Experience:</strong> <?php echo $common->getExperienceValue($candidateRec['Candidate']['experience_code']); ?> </p>
                <p><strong>Citizenship:</strong>
                  <?php
              	echo $common->getCitizenShipValue($candidateRec['Candidate']['citizen_status_code']);
               ?>
                </p>
                <p><strong>Security Clearance:</strong>
                  <?php 
                    	$clearanceArray=explode(',',$candidateRec['Candidate']['security_clearance_code']);
                    	
                        $totalRec=count($clearanceArray);
                        $i=1;
                        foreach($clearanceArray as $key =>$value)
                        {
                        
                        	 echo  $common->getSecurityClearanceValue($value);
                              if($i!=$totalRec):
                                echo '&nbsp;,&nbsp;';
                              endif;
                              $i=$i+1;
                              
                        }
                    ?>
                </p>
                <p><strong>E-mail:</strong> <a href="mailto:<?php echo $candidateRec['Candidate']['candidate_email']; ?>"><?php echo $candidateRec['Candidate']['candidate_email']; ?></a></p>
              </div>
              <div class="preview_rt_new">
                <p><strong>Candidate's Core Skills:</strong></p>
                <?php
             	            
               	for($i=0;$i<count($candidateRec['ResumeSkill']);$i++)
                {
                   
            ?>
                <p><span><strong>
                <?php echo $this->Html->link($common->getSkillName($candidateRec['ResumeSkill'][$i]['skill_id']),array('controller'=>'candidates','action'=>'jobsbyskill',$candidateRec['ResumeSkill'][$i]['skill_id']));?>
                 
                  </strong></span> <?php if($candidateRec['ResumeSkill'][$i]['experience_code']){ ?> ( <?php } ?>
				  <?php echo $common->getExperienceValue($candidateRec['ResumeSkill'][$i]['experience_code']);  ?>
                  <?php if($candidateRec['ResumeSkill'][$i]['experience_code']){ ?> ) <?php } ?>
                  </p>
                <?php 
                     
                }
             ?>
              </div>
              <div class="clear"></div>
              <div class="preview_panel">
                <h2 class="mana_subheading">Resume Preview</h2>
                <?php echo nl2br($candidateRec['Resume']['resume_content']); ?> </div>
                
                
                
			<?php if(!empty($CandidateVd['CandidateVideo']['id'])) {   ?>
            <div class="preview_panel">
            <h2 class="mana_subheading">Candidate Video</h2>
            <?php  //  echo $this->Html->link($this->Html->image("images/video.jpg",array('style'=>'width:295px;')), array('controller'=>'candidates','action'=>'showVideo/'.$CandidateVd['CandidateVideo']['id']),array('class'=>'ajax','escape'=>false));  ?>
            
            <a href="<?php echo $this->Html->url(FULL_BASE_URL.router::url('/',false).'Jobseeker/candidates/showVideo/'.$CandidateVd['CandidateVideo']['id'], false); ?>" class="ajax_empvideo" >
                <?php if($CandidateVd['CandidateVideo']['video_type']=='upload')
				{
				 echo $this->Html->image("images/video.jpg",array('style'=>'width:200px;'));
				}
				else {
					$youtubeId = end(explode('/',$CandidateVd['CandidateVideo']['video']));
				 ?>
                <img src="http://img.youtube.com/vi/<?php echo $youtubeId; ?>/0.jpg" style="width:200px;"  />
                <?php } ?>
                </a>
             </div>
            <?php } ?>
                
                
                
                
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>