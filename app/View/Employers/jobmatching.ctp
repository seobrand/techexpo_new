<div id="wrapper">
<?php echo $this->element('employer_tabs', array('cache' => true)); ?>
    <div id="container">
    
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Matching Resumes</h1>
            <div style="margin:0 0 0 17px;"><?php echo count($joblists); ?> Resumes Returned</div>
            <div class="content">
              
         <?php echo $this->Html->link($this->Html->image("images/new_search_btn.jpg"), array('controller'=>'folders','action'=>'searchRegCandidate'),array('escape'=>false)); ?><br /><br />
      <!-- 

              <div class="pager">0 recent jobs matching  &nbsp;&nbsp; - &nbsp;&nbsp;  <span>sorted by date posted</span>  &nbsp;&nbsp;&nbsp;&nbsp;viewing jobs 1- 0 of 0   (page 1 of 0)</div><br />--> <!-- 
<div class="pager_panel">
        
        <div class="pager">
   
      <ul><li class="prev"><a href="">« Previous</a></li>
            <li class="sel"><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href="">5</a></li>
            <li><a href="">6</a></li>
            <li><a href="">7</a></li>
            <li class="next last"><a href="">Next »</a></li>
        </ul>
        <div class="clear"></div>
        
        </div>

        
 </div>
        
        <br />-->

<p class="smalltext">Click on a column heading to sort</p>


          <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th width="125" style="text-align:left"><a href="">Candidate Name </a></th>
                     <!--   <th width="125" style="text-align:left"><a href="">Score</a></th>-->
                        <th width="125" style="text-align:left"><a href=""> Resume Title </a> </th>
                        <th width="125" style="text-align:left"><a href="">Location </a></th>
                        <th width="125" style="text-align:left"><a href="">Date Posted </a></th>
                     </tr>
                    </table></td>
                </tr>
                <tr>
                <td class="whiteBg"></td>
                
                </tr>
                <?php  if(count($joblists) > 0) { foreach($joblists as $joblist){ ?>
                <tr>
                  <td class="table_row border_bottom">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 
                      <tr>
                       <tr>
                        <td width="125" style="text-align:left"><?php echo $joblist['Candidatenew']['candidate_name']  ?></td>
                      
                       <!-- <td width="125" style="text-align:left">2134</td>-->
                        <td width="125" style="text-align:left"><a href=""><?php  echo $joblist['Resume']['resume_title'];  ?></a></td>
                         <td width="125" style="text-align:left"><?php  echo $joblist['Candidatenew']['candidate_state'];  ?><br />

<?php  echo $joblist['Candidatenew']['candidate_city'];  ?> </td>
                           <td width="125" style="text-align:left">        <?php echo date(DATE_FORMAT,strtotime($joblist['Resume']['posted_dt']));?></td>
                     
                      </tr>
                    </table></td>
                </tr>
                
                <tr>
                  <td class="table_row border_bottom alternate"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="5" class="last" style="text-align:left">
                        
<p><?php  echo $joblist['Resume']['resume_summary'];  ?></p>

<p><strong>Overall years of experience: </strong> <?php  echo $common->getExperienceValue($joblist['Candidatenew']['experience_code']);  ?> <strong> Citizenship: </strong><?php  echo $common->getCitizenShipValue($joblist['Candidatenew']['citizen_status_code']);  ?></p>

<p><strong>Security Clearance:</strong> <?php  echo $common->getSecurityClearanceValue($joblist['Candidatenew']['security_clearance_code']);  ?></p>
<!--<p><strong>Skills / Keywords:</strong> 66 hits on 'web'    </p>-->
<p>                <?php 
foreach($joblist['ResumeSkill'] as $value1)
{
	echo $common->getSkillName($value1['skill_id']).' - ';
}
?> </p>



<ul class="footer_btn">
                  <li style="padding:0 5px 0 5px">
                  
                       <?php echo $this->Html->link($this->Html->image("images/viewresume_details.jpg"), array('controller'=>'folders','action'=>'showResume',$joblist['Resume']['id']),array('target'=>'blank','escape'=>false)); ?>   
                  </li>
                  <li style="padding:0 5px 0 5px">
                    
                    <?php  echo  $this->Html->image("images/download.jpg",array('alt'=>''));  ?>
               </li>
                  <li>
             
             <a href="mailto:<?php echo $joblist['Candidatenew']['candidate_email']; ?>" target="blank"> <?php echo $this->Html->image("images/email-candidate.jpg"); ?></a>
                  </li>
                </ul>

            
                        
                        </td>
                       
                    </tr>
                    </table></td>
                    </tr>
                    
                    
                     <tr>
                    <td class="whiteBg"></td>
                    </tr> 
                <?php  }} else { ?>
               <tr><td>Job not matched with any other resume. </td></tr>
                <?php  } ?>
                    <tr>
                    <td class="whiteBg"></td>
                    </tr> 
                    
                    <tr>
                    <td class="whiteBg"></td>
                    </tr>     
          
             		 </table>

             	
        

 <!--            
<div class="pager_panel">
        
        <div class="pager">

        <ul><li class="prev"><a href="">« Previous</a></li>
            <li class="sel"><a href="">1</a></li>
            <li><a href="">2</a></li>
            <li><a href="">3</a></li>
            <li><a href="">4</a></li>
            <li><a href="">5</a></li>
            <li><a href="">6</a></li>
            <li><a href="">7</a></li>
            <li class="next last"><a href="">Next »</a></li>
        </ul>
        <div class="clear"></div>
        
        </div>

        
 </div><br />-->

              
     <!--   <div class="pager">0 recent jobs matching  &nbsp;&nbsp; - &nbsp;&nbsp;  <span>sorted by date posted</span>  &nbsp;&nbsp;&nbsp;&nbsp;viewing jobs 1- 0 of 0   (page 1 of 0)</div><br /> -->
      <?php echo $this->Html->link($this->Html->image("images/new_search_btn.jpg"), array('controller'=>'folders','action'=>'searchRegCandidate'),array('escape'=>false)); ?>
       <br />
            </div>
          </div>
        </div>
      </div>
      



 <?php echo $this->element('employer_left_panel'); ?>



      <div class="clear"></div>
      <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>