<script type="text/javascript">
$(function(){

//$(".pager").css({ 'word-wrap': 'break-word' });

});
</script>

<div id="wrapper"> <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Search Results</h1>
          <div class="content"> <?php echo $this->Html->link($this->Html->image("images/new_search_btn.jpg"), array('controller'=>'employers','action'=>''),array('escape'=>false)); ?><br />
            <br />
            
            <!--  <div class="pager">0 recent jobs matching  &nbsp;&nbsp; - &nbsp;&nbsp;  <span>sorted by date posted</span>  &nbsp;&nbsp;&nbsp;&nbsp;viewing jobs 1- 0 of 0   (page 1 of 0)</div><br />-->
            <div class="pager_panel">
              <div class="pager">
                <div class="paging">
                  <?php $page = $this->params['paging']['Resume']['page'];?>
                  <?php $pageLimit = $this->params['paging']['Resume']['limit'];?>
                  <?php $page_start = ($page*$pageLimit-$pageLimit)+1;?>
                  <?php  if(isset($countTotalRecords)) echo $countTotalRecords;  ?>
                  resumes matching your search <br/>
                  <br/>
                  <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?> <?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;&nbsp;'));?> <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?> </div>
                <div class="clear"></div>
              </div>
            </div>
            <br />
            <p class="smalltext">Click on a column heading to sort by that criterion</p>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="125" style="text-align:left"> <?php echo $this->Paginator->sort('Candidate.candidate_name','Candidate Name'); ?> </th>
                      <!--     <th width="125" style="text-align:left"><a href="">Score</a></th>-->
                      <th width="125" style="text-align:left"><?php echo $this->Paginator->sort('Resume.resume_title','Resume Title'); ?></th>
                      <th width="125" style="text-align:left"><?php echo $this->Paginator->sort('Resume.candidate_state','Location'); ?></th>
                      <th width="125" style="text-align:left"><?php echo $this->Paginator->sort('Resume.posted_dt','Date Posted'); ?></th>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="whiteBg"></td>
              </tr>
              <?php foreach($resumeLists as $resumeList){ ?>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                    <tr>
                      <td width="125" style="text-align:left"><?php echo $page_start.'.&nbsp;'; 
						if($resumeList['Candidate']['candidate_privacy']=='Y')
						echo "Confidential";
						else
						echo $resumeList['Candidate']['candidate_name'] ; ?></td>
                      
                      <!-- <td width="125" style="text-align:left">2134</td>-->
                      <td width="125" style="text-align:left"><?php echo $this->Html->link($resumeList['Resume']['resume_title'], array('controller'=>'folders','action'=>'showResume',$resumeList['Resume']['id']),array('target'=>'blank','escape'=>false)); ?></td>
                      <td width="125" style="text-align:left"><?php  echo $resumeList['Candidate']['candidate_state'];  ?>
                        <br />
                        <?php  echo $resumeList['Candidate']['candidate_city'];  ?></td>
                      <td width="125" style="text-align:left"><?php echo date("m/d/Y",strtotime($resumeList['Resume']['posted_dt']));?></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="table_row border_bottom alternate"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="5" class="last" style="text-align:left"><p>
                          <?php  echo $resumeList['Resume']['resume_summary'];  ?>
                        </p>
                        <p><strong>Overall years of experience : </strong>
                          <?php  echo $common->getExperienceValue($resumeList['Candidate']['experience_code']);  ?>
                          <strong> Citizenship : </strong>
                          <?php  echo $common->getCitizenShipValue($resumeList['Candidate']['citizen_status_code']);  ?>
                        </p>
                        <p><strong>Security Clearance :</strong>
                          <?php 
 //$securityCl =  $common->getSecurityClearanceValue($resumeList['Candidate']['security_clearance_code']);
  //echo str_ireplace('None','Viewable inside resume detail',$securityCl); ?>
                      <?php 
                          $clearanceArray=explode(',',$resumeList['Candidate']['security_clearance_code']);
                          
                          $totalRec=count($clearanceArray);
                          $i=1;
                          foreach($clearanceArray as $key =>$value)
                          {
                          
                               $securityCl =  $common->getSecurityClearanceValue($value);
							   echo str_ireplace('None','Viewable inside resume detail',$securityCl);
                                if($i!=$totalRec):
                                  echo '&nbsp;,&nbsp;';
                                endif;
                                $i=$i+1;
                                
                          }
                      ?>
                        </p>
                        <p><strong>Skills / Keywords:</strong>
                       <?php 
					   $pos = strpos($this->Session->read('search_db_url'),"type=Advanced");
					 	$pos2 = strpos($this->Session->read('search_db_url'),"type=Any");
						$pos3 = strpos($this->Session->read('search_db_url'),"type=All");
					    if ( ($pos !== false) || ($pos2 !== false) || ($pos3 !== false) ) { 
						   $advancSrchKeyword = $this->Session->read('advancSrchKeyword');
						   						
							foreach($advancSrchKeyword as $adk)
							{ 
								echo substr_count(strtoupper($resumeList['Resume']['resume_content']), strtoupper($adk))." hits on '".$adk."' &nbsp;&nbsp;";	
							}
							
						}
					   else
					   {
					    echo substr_count(strtoupper($resumeList['Resume']['resume_content']), strtoupper($this->Session->read('search_db_word')));  ?> hits on '
                          <?php  echo $this->Session->read('search_db_word'); ?>
                          '
                        <?php } ?>  
                          
                           </p>
                        <p>
                          <?php 
foreach($resumeList['ResumeSkill'] as $value1)
{
	echo $common->getSkillName($value1['skill_id']).' - ';
}
?>
                        </p>
                        <ul class="footer_btn">
                          <li style="padding:0 5px 0 5px"> <?php echo $this->Html->link($this->Html->image("images/viewresume_details.jpg"), array('controller'=>'folders','action'=>'showResume',$resumeList['Resume']['id']),array('target'=>'blank','escape'=>false)); ?> </li>
                          <li style="padding:0 5px 0 5px">
                            <?php
if(!empty($resumeList['Resume']['filename']) && file_exists('candidateDocument/resume/'.$resumeList['Resume']['filename']))
{
	$file_type =  substr($resumeList['Resume']['filename'], -4);    	
    if($file_type==".pdf"){
		$this->Html->link($this->Html->image("images/download.jpg"), array('controller'=>'folders','action'=>'downloadResume',$resumeList['Resume']['filename'],'pdf'),array('escape'=>false));
	}else{
		echo $this->Html->link($this->Html->image("images/download.jpg"), array('controller'=>'folders','action'=>'downloadResume',$resumeList['Resume']['filename']),array('escape'=>false));
	}
  //echo $this->Html->link($this->Html->image("images/download.jpg"), array('controller'=>'folders','action'=>'downloadResume',$resumeList['Resume']['filename']),array('escape'=>false));
  
} 
else
{
echo $this->Html->link($this->Html->image("images/download.jpg"), array('controller'=>'folders','action'=>'exportResume',$resumeList['Resume']['id']),array('escape'=>false));
}
?>
                          </li>
                          <li style="padding:0 5px 0 5px"> <a href="mailto:<?php echo $resumeList['Candidate']['candidate_email']; ?>" target="blank"> <?php echo $this->Html->image("images/email-candidate.jpg"); ?></a> </li>
                        </ul>
                        <?php
		  $viewdt = $common->resumeStatCheck($this->Session->read('Auth.Client.employerContact.employer_id'),$resumeList['Resume']['id']);
		 
		   if(isset($viewdt)){ 
		   ?>
                        <span class="result_state_viewed">You have already viewed this resume, 
                        Resume first viewed on: <?php echo date('m/d/Y',strtotime($viewdt)); ?> </span>
                        <?php } else { ?>
                        <span class="result_state_new">You have not yet viewed this resume </span>
                        <?php } ?></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td class="whiteBg"></td>
              </tr>
              <?php  $page_start++;  } ?>
              <tr>
                <td class="whiteBg"></td>
              </tr>
              <tr>
                <td class="whiteBg"></td>
              </tr>
            </table>
            <div class="pager_panel">
              <div class="pager">
                <div class="paging"> <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?> <?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;&nbsp;&nbsp;'));?> <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?> </div>
                <div class="clear"></div>
              </div>
            </div>
            <br />
            
            <!--  <div class="pager">0 recent jobs matching  &nbsp;&nbsp; - &nbsp;&nbsp;  <span>sorted by date posted</span>  &nbsp;&nbsp;&nbsp;&nbsp;viewing jobs 1- 0 of 0   (page 1 of 0)</div><br /> --> 
            <?php echo $this->Html->link($this->Html->image("images/new_search_btn.jpg"), array('controller'=>'employers','action'=>''),array('escape'=>false)); ?> <br />
            <?php /*?><div style="width:100%;"> <strong>Query  :</strong>
              <?php if($query1) { echo $query1."<br/>"; } ?>
            </div><?php */?>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
