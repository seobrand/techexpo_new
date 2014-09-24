<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'ExportResumeView')); 
?>
      <?php $firstSting = $this->Session->read('search_db_word_admin');   ?>
                <style> 
				.highlight { background-color: yellow }
				</style> 
          <script type="text/javascript" >
		  
		  <?php if(isset($firstSting)) { ?>
		  $(document).ready(function() {
			 
		$('.resume_highlight').highlight('<?php echo $firstSting; ?>'); 
			});
			
		<?php } ?>	
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

<div id="right2"> 
        <!-- table -->
        <div class="box1">
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">View/Edit Recruiter Information</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
          <!-- box / title -->
          
          <div class="display_row">
            <div class="table">
            
             
              <br/>
              
              <?php if($previousJobId){ ?>
                
                   <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "export_resumes", "action" => "viewResume/".$previousJobId));?>">
             Previous Resume
              </a>&nbsp;&nbsp;
                <?php } ?>
              
              
             <?php if($nextJobId){ ?> 
              <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "export_resumes", "action" => "viewResume/".$nextJobId));?>">
              Next Resume
              </a>&nbsp;&nbsp;
               <?php } ?>
              
              <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "export_resumes", "action" => "?".$backtoSearchPage));?>">
              Back to Search
              </a>&nbsp;&nbsp;<a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "index"));?>">
              New Search
              </a>&nbsp;&nbsp;
              <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "resumeDetail/".$candidateRec['Resume']['id']));?>">
              Export Addresses / Email Candidates
              </a>&nbsp;&nbsp;<a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "exportResume/".$candidateRec['Resume']['id']));?>">
              Export Resumes as Text Files
              </a><br />
              <br />

              <table border="0" cellpadding="0" cellspacing="0">
                <tbody>
                  <tr>
                    <td>
                     
                     
<p><strong><?php echo $candidateRec['Candidate']['candidate_name']; ?></strong><br />

<?php if($candidateRec['Candidate']['candidate_title'])echo $candidateRec['Candidate']['candidate_title']; else echo "N/A"; ?><br />

<?php if($candidateRec['Candidate']['candidate_phone'])echo $candidateRec['Candidate']['candidate_phone']; else echo "N/A"; ?><br />
</p>

<h2>Summary of Expertise</h2>
<div class="resume_highlight">
 <?php //echo nl2br($candidateRec['Resume']['resume_content']);
 echo iconv("", "UTF-8//IGNORE", nl2br($candidateRec['Resume']['resume_content']));
  ?>
</div>
<div class="resume_detail_bot_row">
<h2>Candidate Summary and Core Skills</h2>

<div class="resume_detail_bot_col">


<p><strong>Candidate Name:</strong> <?php echo $candidateRec['Candidate']['candidate_name']; ?><br />

<strong>Location: </strong><?php 
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
					
                ?><br />

<strong>Current Title:</strong><?php if($candidateRec['Candidate']['candidate_title'])echo $candidateRec['Candidate']['candidate_title']; else echo "N/A"; ?> <br />

<strong>Resume Title:</strong><?php echo $candidateRec['Resume']['resume_title']; ?><br />

<strong>Resume last updated on:</strong><?php  echo date('m/d/Y', strtotime($candidateRec['Resume']['posted_dt']));  ?><br />

<strong>Total years of Experience:</strong>  <?php echo $common->getExperienceValue($candidateRec['Candidate']['experience_code']); ?><br />

<strong>Citizenship:</strong>  <?php
              	echo $common->getCitizenShipValue($candidateRec['Candidate']['citizen_status_code']);
               ?><br />

<strong>Security Clearance:</strong>  <?php 
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
                    ?><br />

<strong>E-mail:</strong> <a href="mailto:<?php echo $candidateRec['Candidate']['candidate_email']; ?>"><?php echo $candidateRec['Candidate']['candidate_email']; ?></a>
</p>
</div>

<div class="resume_detail_bot_col">

 <?php
  	for($i=0;$i<count($candidateRec['ResumeSkill']);$i++)
     {
     ?>
     <p style="margin:0 24px!important;"><span><strong>
     <?php
    echo $common->getSkillName($candidateRec['ResumeSkill'][$i]['skill_id']); 
	$ResumeEXp =  $common->getExperienceValue($candidateRec['ResumeSkill'][$i]['experience_code']);
     ?>
    </strong></span> <?php if(!empty($ResumeEXp)) echo '( '.$ResumeEXp.' )';  ?></p>
    <?php 
     }
             ?>
</div>


</div>
                     
                     </td>
                  </tr>
         
                </tbody>
              </table>
              <br />

              <?php if($previousJobId){ ?>
                
                   <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "export_resumes", "action" => "viewResume/".$previousJobId));?>">
             Previous Resume
              </a>&nbsp;&nbsp;
                <?php } ?>
              
              
             <?php if($nextJobId){ ?> 
              <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "export_resumes", "action" => "viewResume/".$nextJobId));?>">
              Next Resume
              </a>&nbsp;&nbsp;
               <?php } ?>
              
              <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "export_resumes", "action" => "?".$backtoSearchPage));?>">
              Back to Search
              </a>&nbsp;&nbsp;<a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "index"));?>">
              New Search
              </a>&nbsp;&nbsp;
              <a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "resumeDetail/".$candidateRec['Resume']['id']));?>">
              Export Addresses / Email Candidates
              </a>&nbsp;&nbsp;<a class="cursorclass ui-state-default ui-corner-all" href="<?php echo $this->Html->url(array("controller" => "ExportResumes", "action" => "exportResume/".$candidateRec['Resume']['id']));?>">
              Export Resumes as Text Files
              </a><br />
              <br />
            </div>
          </div>
        </div>
        <!-- end table --> 
      </div>