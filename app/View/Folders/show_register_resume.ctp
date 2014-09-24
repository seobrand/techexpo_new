      <?php 	$firstSting = $this->Session->read('search_reg_word');   ?>
                <style> 
				.highlight { background-color: yellow }
				</style> 
          <script type="text/javascript" >
		    $(document).ready(function() {
		   <?php
			$pos = strpos($this->Session->read('search_reg_url'),"type=Advanced");
 		    $pos2 = strpos($this->Session->read('search_reg_url'),"type=Any");
   		    $pos3 = strpos($this->Session->read('search_reg_url'),"type=All");
		    if ( ($pos !== false) || ($pos2 !== false) || ($pos3 !== false) ) { 
				$advancSrchKeyword = $this->Session->read('advancSrchKeywordSh');
				foreach($advancSrchKeyword as $adk)
				{ 
					?>
					$('.resume_highlight').highlight('<?php echo $adk; ?>');
					<?php 
				}
			}
			else 
			{
		  if(isset($firstSting)) { ?>
		$('.resume_highlight').highlight('<?php echo $firstSting; ?>');
		<?php } } ?>
		
			});
		
			jQuery.fn.highlight = function(pat) {
			
 function innerHighlight(node, pat) {
  var skip = 0;
  if (node.nodeType == 3) {
   var pos = node.data.toUpperCase().indexOf(pat);
   if (pos >= 0) {
    var spannode = document.createElement('span');
    spannode.className = 'highlight';
    var middlebit = node.splitText(pos);
    var endbit = middlebit.splitText(pat.length);
    var middleclone = middlebit.cloneNode(true);
    spannode.appendChild(middleclone);
    middlebit.parentNode.replaceChild(spannode, middlebit);
    skip = 1;
   }
  }
  else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
   for (var i = 0; i < node.childNodes.length; ++i) {
    i += innerHighlight(node.childNodes[i], pat);
   }
  }
  return skip;
 }
 return this.length && pat && pat.length ? this.each(function() {
  innerHighlight(this, pat.toUpperCase());
 }) : this;
};

jQuery.fn.removeHighlight = function() {
 return this.find("span.highlight").each(function() {
  this.parentNode.firstChild.nodeName;
  with (this.parentNode) {
   replaceChild(this.firstChild, this);
   normalize();
  }
 }).end();
};// JavaScript Document
		 </script>   
<?php //pr($candidateRec);?>
<div id="wrapper"> <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor"><?php if($candidateRec['Candidate']['candidate_privacy']=='Y')
				echo "Confidential";
				else
				echo $candidateRec['Candidate']['candidate_name'] ; ?>  
          <?php $viewdt = $common->resumeStatCheck($this->Session->read('Auth.Client.employerContact.employer_id'),$resume_id); 
		  if(isset($viewdt)){ 
		   ?>
          <span class="resume_satae">You have already viewed this resume <br/>
          Resume first viewed on: <?php echo date('m/d/Y',strtotime($viewdt)); ?>
            </span>
          <?php } ?>  
          </h1>
          <div class="content">
           <!-- <div class="jobseeker_info">
              <p><strong><?php echo $candidateRec['Candidate']['candidate_name']; ?>'s Resume Details</strong><br />
                <?php 
					$date = new DateTime("@".time());
					$date->setTimezone(new DateTimeZone('UTC'));   
					echo $date->format("l, d/m/Y - h:i A T");  // Pacific time</p>
				?></p>
            </div>-->
         	 <!--top section-->
            

				<!--***********************************section***************************************-->
		
            <div class="content" style="padding-left:2px!important;">
              

<div class="gray_full_top"></div>
<div class="gray_full_mid">

          <table  width="100%" border="0" cellspacing="0" cellpadding="0">
                
                <tr>
                <td class="whiteBg"></td>
                
                </tr>
                
                
                
                <tr>
                  <td class="table_row border_bottom alternate"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="last" style="text-align:left">
                     


<ul class="footer_btn">
<?php if(!empty($previousResumeId)){  ?>
<li class="paddingzero">
<?php echo $this->Html->link($this->Html->image("images/prev_resume.png"), array('controller'=>'folders','action'=>'showRegisterResume',$previousResumeId),array('escape'=>false)); ?>
</li>
<?php } ?>  
 
<?php if(!empty($nextResumeId)){   ?>  
<li class="paddingzero">
<?php echo $this->Html->link($this->Html->image("images/next_resume.jpg"), array('controller'=>'folders','action'=>'showRegisterResume',$nextResumeId),array('escape'=>false)); ?>
</li>
<?php } ?>                     
             <li class="paddingzero">        <?php // echo $this->Html->link($this->Html->image("images/back-search.jpg"), array(BASE_URL.$this->Session->read('search_url')),array('escape'=>false)); ?>
					<a href="<?php echo BASE_URL.$this->Session->read('search_reg_url'); ?>">
               	   <?php echo $this->Html->image("images/back-search.jpg",array('title'=>'Back To Search Result Page')); ?></a>
                  </li>
                  
                   <li class="paddingzero">
                    <?php echo $this->Html->link($this->Html->image("images/new_search.jpg"), array('controller'=>'folders','action'=>'searchRegCandidate'),array('escape'=>false)); ?>
                    
                  </li>
             
                </ul>

<div class="clear"></div>
<div class="search_resume_midpanel">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php if(count($folderList)>0){?>
    <td width="225"><label>File resume to folder:</label><?php echo $this->Form->create('Folder',array('name'=>'showResume','id'=>'showResume','action'=>'resumefiletofolder/'.$resume_id));?>
            <?php echo $this->Form->hidden('resume_id',array('value'=>$candidateRec['Resume']['id']));?>
   <?php echo $this->Form->input('copy_folder_id',array('label'=>false,'options'=>$folderList,'type'=>'select','div'=>false));?>
   
          <?php echo $this->Form->submit('File',array('div'=>false,'name'=>'Submit'));?>
      <?php echo $this->Form->end();?></td>
      <?php }?>
    <td <?php if(count($folderList)>0){?>width="225"<?php }else{?> colspan="2"<?php }?>><label>Create a new folder:</label>
       <?php echo $this->Form->create('Folder',array('name'=>'resumeFolder','id'=>'resumeFolder','action'=>'createresumefolder/showRegisterResume/'.$resume_id));
				   echo $this->Form->hidden('icon_id',array('value'=>'1'));
				   echo $this->Form->input('folder_descr',array('label'=>false,'class'=>'big237_textfield','div'=>false));
				   echo $this->Form->submit('Create',array('div'=>false,'name'=>'Submit'));
				   echo $this->Form->end();		
				
				?>
			
    </td>
    
    
 <td>            <?php echo $this->Html->link($this->Html->image("images/go-to-resume-folder.jpg"), array('controller'=>'folders','action'=>'resumefolder'),array('escape'=>false)); ?>
    </td>
  </tr>
</table>

</div>

<ul class="footer_btn">
                  <li class="paddingzero">
                   
               
                    
  <?php 
if(!empty($candidateRec['Resume']['filename']) && file_exists('candidateDocument/resume/'.$candidateRec['Resume']['filename']))
{
	$file_type =  substr($candidateRec['Resume']['filename'], -4);    	
    if($file_type==".pdf"){
		echo $this->Html->link($this->Html->image("images/download_resume.jpg"), array('controller'=>'folders','action'=>'downloadResume',$candidateRec['Resume']['filename'],'pdf'),array('escape'=>false));
	}else{
		echo $this->Html->link($this->Html->image("images/download_resume.jpg"), array('controller'=>'folders','action'=>'downloadResume',$candidateRec['Resume']['filename']),array('escape'=>false));
	}
  //echo $this->Html->link($this->Html->image("images/download_resume.jpg"), array('controller'=>'folders','action'=>'downloadResume',$candidateRec['Resume']['filename']),array('escape'=>false));
  
} 
else
{
echo $this->Html->link($this->Html->image("images/download_resume.jpg"), array('controller'=>'folders','action'=>'exportResume',$candidateRec['Resume']['id']),array('escape'=>false));
}
?>
                    
                  </li>
                  <li class="paddingzero">
             
                     <a href="mailto:<?php echo $candidateRec['Candidate']['candidate_email']; ?>" target="blank"> <?php echo $this->Html->image("images/email_frnd.jpg"); ?></a>
                  </li>
                  
                   <li class="paddingzero">
                    
                       <?php echo $this->Html->link($this->Html->image("images/forward-resume.jpg"), array('controller'=>'folders','action'=>'mailResume',$candidateRec['Resume']['id']),array('target'=>'blank','escape'=>false)); ?>
                  </li>
                  <li class="paddingzero">
                  
                     <?php echo $this->Html->link($this->Html->image("images/schdule-interview.jpg"), array('controller'=>'folders','action'=>'scheduleInteview',$candidateRec['Candidate']['id']),array('target'=>'blank','escape'=>false)); ?>
                  </li>
                </ul>
                        </td>
                       
                      </tr>
                    </table></td>
                </tr>
                  <tr>
                <td class="whiteBg"></td>
                
                </tr>
              </table>
           
</div>

            </div>
        
				<!--***********************************section***************************************-->


             
            <br />
            <h2 class="mana_subheading"><div class="mana_subheading_lf">Candidate Summary and Core Skills </div>  <span class="mana_subheading_rt">
            <?php  if(count($currentfolderList)) { ?> Resume filed to : <?php } foreach($currentfolderList as $cfolder){ echo $cfolder['Folder']['folder_descr'].',';   }  ?></span> </h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <div class="preview_lf">
                <p><strong>Candidate Name : </strong><?php 
				if($candidateRec['Candidate']['candidate_privacy']=='Y')
				echo "Confidential";
				else
				echo $candidateRec['Candidate']['candidate_name'] ;
				
				 ?></p>
                <?php /* comment by jitendra on 30-07-2013 by ref of ticket #1304 ?>
                <p><strong>Location :</strong>
                  <?php 
				  if($candidateRec['Candidate']['pref_locations']){
				  $locationArray=explode(',',$pref_locations=$candidateRec['Candidate']['pref_locations']); 
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
					}
					else
					echo "N/A";
					
                ?>
                </p>
                <?php */?>
                <p><strong>Current Title : </strong><?php if($candidateRec['Candidate']['candidate_title'])echo $candidateRec['Candidate']['candidate_title']; else echo "N/A"; ?> </p>
                <p><strong>Resume Title :</strong> <?php echo $candidateRec['Resume']['resume_title']; ?></p>
                <p><strong>Resume last updated on :</strong><?php echo date('m-d-Y',strtotime($candidateRec['Resume']['posted_dt'])); ?></p>
                <p><strong>Total years of Experience :</strong> <?php echo $common->getExperienceValue($candidateRec['Candidate']['experience_code']); ?> </p>
                <p><strong>Citizenship :</strong>
                  <?php
              	echo $common->getCitizenShipValue($candidateRec['Candidate']['citizen_status_code']);
               ?>
                </p>
                <p><strong>Security Clearance :</strong>
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
                <p><strong>E-mail :</strong> <a href="mailto:<?php echo $candidateRec['Candidate']['candidate_email']; ?>"><?php echo $candidateRec['Candidate']['candidate_email']; ?></a></p>
              </div>
              <div class="preview_rt">
              <?php if(!empty($candidateRec['Candidate']['candidate_image'])){?>
              <div class="candidate_profile_image"><img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$candidateRec['Candidate']['candidate_image'];?>&maxw=186&maxh=140" alt="<?php echo $candidateRec['Candidate']['candidate_name']; ?>"/></div>
              <?php }?>
                <p><strong>Candidate's Core Skills :</strong></p>
                <?php
             	            
               	for($i=0;$i<count($candidateRec['ResumeSkill']);$i++)
                {
                   
            ?>
                <p class="coreSkill"><span><strong>
                  <?php
                  	echo $common->getSkillName($candidateRec['ResumeSkill'][$i]['skill_id']); 
					$ResumeEXp =  $common->getExperienceValue($candidateRec['ResumeSkill'][$i]['experience_code']);
                  ?>
                  </strong></span>  <?php if(!empty($ResumeEXp)) echo '( '.$ResumeEXp.' )';  ?></p>
                <?php 
                     
                }
             ?>
              <p class="moreSkills" style="display:none;font-weight:bold;cursor:pointer;">View Additional Core Skills</p>
              </div>
              <div class="clear"></div>
              <div class="preview_panel resume_highlight">
              
              <?php if($candidateRec['Candidate']['linkedin']){ ?>
              	<a href="<?php echo $candidateRec['Candidate']['linkedin']; ?>" target="_blank"><img alt="" src="/pushkar/techexpo_new/img/images/link.jpg"></a>
             <?php } ?>
                <h2 class="mana_subheading">Resume Preview</h2>
                
                <?php  // echo  nl2br($candidateRec['Resume']['resume_content']); 
				 echo iconv("", "UTF-8//IGNORE", nl2br($candidateRec['Resume']['resume_content']));
				 ?>
                </div>
                
                
                <?php if(!empty($CandidateVd['CandidateVideo']['id'])) {   ?>
                <div class="preview_panel">
                <h2 class="mana_subheading">Candidate Video</h2>
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
    <?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
	<script type="text/javascript">
    $(document).ready(function() {
		// sue for hide skill on gt then 5 conditions
		
		if($('.coreSkill').length > 5){
		   $('.coreSkill:gt(5)').hide();
		   $('.moreSkills').show();
		}
		
		$( ".moreSkills" ).click(function() {
		  $('.coreSkill:gt(5)').show();
		  $('.moreSkills').hide();
		});
                
    });
    </script>  