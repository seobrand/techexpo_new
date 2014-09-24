<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'lastVisit')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Show Stats &amp; Pre-Registrations</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>

    <div class="display_row">
      <div class="table">
      
      <table border="0" cellpadding="0" cellspacing="0">
      <tr>
      <td valign="middle" align="center">
      
        <?php  
		echo $this->Form->create('PreRegistrations',array('controller'=>'PreRegistrations','action'=>'index'));
        echo $this->Form->input('show_id',array('type'=>'select','options'=>$show_list,'empty'=>'-Select Show-','label'=>false,'div'=>false)); 
		echo $this->Form->submit('Show Stats',array('class'=>'cursorclass ui-state-default ui-corner-all','label'=>false,'div'=>false));
		echo  $this->end();			 
		 ?>
    
</td>
</tr>
</table><br />
<br />
		<?php if(isset($shows['Show']['id'])) { ?>
        <p><h4> Stats for : <?php  echo $shows['Show']['show_name'].','.date('M d,Y', strtotime($shows['Show']['show_dt']))   ?> </h4></p>

        <p>Number of regular pre-registrations (candidates without security clearance):<?php echo $reg_without_cl;  ?></p>
      
        <p>Number of Active Security Cleared pre-registrations: <?php echo $reg_with_cl;  ?></p>
        
        <p>Total Number of pre-registrations:<?php /* echo $total_canidate; commented task id 2074 */ echo $reg_without_cl+$reg_with_cl; ?>  </p>
        
       <p>
       <?php echo $this->Html->link('Click here to EXPORT THE CANDIDATE CONTACT INFO', array('controller'=>'PreRegistrations','action'=>'exportCandidate',$shows['Show']['id']),array('escape'=>false)); ?>
        </p>
        
<p>
  <?php echo $this->Html->link('Click here to EXPORT THE FULL CANDIDATE CONTACT INFO (for badges and such)', array('controller'=>'PreRegistrations','action'=>'exportFullCandidate',$shows['Show']['id']),array('escape'=>false)); ?> </p>
        
        
     <?php /*   
        <h2>STATS (for all registrations combined):</h2>
        
	<?php foreach($survey_dt as $survey_dt){ 
		$percentage =  (($survey_dt['0']['survey_cnt'] / $survey_total) * 100 );
		
		echo $survey_dt['c']['code_descr'].'&nbsp;&nbsp;'.ceil($percentage).'%&nbsp;&nbsp;'.$survey_dt['0']['survey_cnt'].'<br/>';
	  } ?>	
        
        
      <h2> POSTCARD TAGGING CODES BREAKDOWN</h2>

			<?php  if(count($postcard_dt) > 0 ){ foreach($postcard_dt as $postcard_dt) { 
			echo $postcard_dt['survey_results']['postcard_code'].'&nbsp;&nbsp;'.$postcard_dt['0']['pcnt'];
			 } } else {?>
           <p>       No results to display </p> 
            <?php  } */ ?> <?php  $SurveyResultCnt = $SurveyResultCnt[0][0]['totalcnt'] ; ?>
<h2>       "FREE-FORM" REGISTRATION STATS (<?php  echo $SurveyResultCnt; ?> REGISTRATIONS OF THIS TYPE)</h2>
        
        <table>
          <tbody>
          <?php if(count($SurveyResults) > 0) {
			  foreach($SurveyResults as $SurveyResult){
			   ?>
            <tr>
              <td valign="middle" align="left" width="30%"><?php echo $SurveyResult['SurveyResult']['survey_answer'];   ?></td>
              <?php  $perc2=round((($SurveyResult['0']['srvcnt'] / $SurveyResultCnt) * 100), 2);  ?>
              <td valign="middle" align="left" width="69%"><?php echo $perc2;   ?>% &nbsp;&nbsp;(<?php echo $SurveyResult['0']['srvcnt']; ?>)</td>
            </tr>
        <?php } } ?>
          </tbody>
        </table>
        
        
        <h2>SECURITY CLEARANCE BREAKDOWN</h2>
<p><strong>NOTE: </strong>breakdown may not add up to total number of candidates because candidates without security clearance were left out and certain candidates may have checked more than one security clearance option in their profile.</p>
        
        
        <table>
          <tbody>
          <?php foreach($security_clearance as $security_clearance) { ?>
            <tr>
              <td width="30%" valign="middle" align="left"><?php echo  $security_clearance['Code']['code_descr']; ?></td>
              <td width="69%" valign="middle" align="left"><?php  echo $common->candidateListClearance($security_clearance['Code']['code_id'],$shows['Show']['id']); ?></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
        
        
        <h2>REGULAR PRE-REGISTRATIONS:</h2>
        
        <table>
        <thead>
            <tr>
              <th  width="30%" valign="middle" align="left">Name </th>
              <th valign="middle" width="30%"  align="left">Candidate ID </th>
              <th valign="middle" width="40%"  align="left">Hear About The Event </th>
            </tr>
            </thead>
            <tbody>
          <?php /*		  
		   foreach( $reg_without_cl1 as $reg_without_cl ){
			   $interview_candidate =  $common->regularPreRegistration($reg_without_cl['Candidate']['id'],$shows['Show']['id']);
			 if($interview_candidate) {
			   ?>
            <tr>
              <td valign="middle" align="left"> <?php echo $reg_without_cl['Candidate']['candidate_name'] ; ?> </td>
              <td align="left"><?php echo $interview_candidate['ShowInterview']['candidate_id']; ?></td>
            </tr>
          <?php }    }  */ ?>
          <?php   if(count($reg_without_cl_candidate) > 0) {
		  foreach( $reg_without_cl_candidate as $reg ){
		     ?>
          <tr>
              <td valign="middle" align="left"> <?php echo $reg['Candidate']['candidate_name'] ; ?> </td>
              <td align="left"><?php echo $reg['Candidate']['id']; ?></td>
               <td align="left"><?php echo $reg['Registration']['hear_about']; ?></td>
            </tr>
          <?php }
		    } else  { ?>
			<tr>
              <td valign="middle" align="center" colspan="3"> No Candidate  without security clearance </td>
             
            </tr>  
		<?php  }  ?>
          
          
          </tbody>
        </table>
        
        
        <h2>ACTIVE SECURITY CLEARED PRE-REGISTRATIONS:</h2>
        
        <table>
        <thead>
            <tr>
              <th width="30%"  valign="middle" align="left">Name</th>
              <th valign="middle" width="30%"  align="left">Candidate ID</th>
               <th valign="middle" width="40%"  align="left">Hear About The Event</th>
            </tr>
            </thead>
              <tbody>
           <?php /*  foreach( $reg_with_cl_active as $reg_without_cl ){
			  $interview_candidate =  $common->regularPreRegistration($reg_without_cl['Candidate']['id'],$shows['Show']['id']);
			 if($interview_candidate) {
			   ?>
            <tr>
              <td valign="middle" align="left"> <?php echo $reg_without_cl['Candidate']['candidate_name'];  ?> </td>
              <td align="left"><?php echo $interview_candidate['ShowInterview']['candidate_id']; ?></td>
            </tr>
          <?php }    } */ ?>
           <?php if(count($reg_with_cl_candidate) > 0) {
		  foreach( $reg_with_cl_candidate as $reg ){
		     ?>
          <tr>
              <td valign="middle" align="left"> <?php echo $reg['Candidate']['candidate_name'] ; ?> </td>
              <td align="left"><?php echo $reg['Candidate']['id']; ?></td>
               <td align="left"><?php echo $reg['Registration']['hear_about']; ?></td>
            </tr>
          <?php }
		     } else  { ?>
			<tr>
              <td valign="middle" align="center" colspan="3"> No Candidate  with security clearance </td>
             
            </tr>  
		<?php  }  ?>
          </tbody>
        </table>
        
        <?php } ?>
      </div>
    </div>


 </div>
        <!-- end table --> 
      </div>