<div id="wrapper">
    
    
    <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
    <div id="container">
    

      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Schedule interview</h1>
            <div class="content">
              
            
<br />

              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
          <?php  if($already_schedule=='Yes') {  ?>      
          You have already scheduled an interview with this candidate for this TECHEXPO event. Your company name will be in the personalized company / interview list we will give to this attendee at the event.<br><br>
<a href="#cgi.http_referer#">Please click here.</a> If you wish to send this person a reminder, you can <a href="mailto:<?php echo $candidate_dt['Candidate']['candidate_email'];   ?>">e-mail <?php echo $candidate_dt['Candidate']['candidate_email'];   ?></a><br>




       <?php } else {
		   
		
		    ?>
         
       <?php echo $this->Form->create('Folder',array('name'=>'Folder','id'=>'Folder','action'=>'scheduleInteview/'.$candidate_dt['Candidate']['id'].'/sendmail'));?>
                
           <table >
             <tbody>
	
	<tr valign="top" align="left"> 
	<td colspan="2">
	
	You are about to schedule an interview with <b><?php echo $candidate_dt['Candidate']['candidate_name'];   ?></b><br>for TECHEXPO 
    <b>
    <?php
	if(count($show_name > 0)) {
	 foreach($show_name as $show_name) { 
    echo $show_name['Show']['show_name'].' on '.date("m/d/Y",strtotime($show_name['Show']['show_dt'])).', ';
    
     }
	}
	 else
	 {
		echo "Event Not Set";
	 }
		 
	
	  ?></b>       
 
	<br><br>
	</td>
	</tr>
	
	<tr> 
	<td colspan="2"> <b>
	Your e-mail address:  <?php echo $this->Form->input('email',array('label'=>false,'class'=>'shud_textfield','value'=>$this->Session->read('Auth.Client.employerContact.contact_email'),'div'=>false));?> </b></td>
	</tr>
	
	<tr> 
	<td colspan="2"> 
	    <br><br><hr color="003399"><br>
	</td>
	</tr>
	
	
	<tr> 
	<td colspan="2">
	<b>The following introduction will be included before your message:</b><br><br>
	Dear <?php echo $candidate_dt['Candidate']['candidate_name'];   ?>,<br><br>

Thank you again for having registered for events.<br><br>

Good News! <?php  echo $Ename; ?> wishes to interview with you at the event. This upgrades your registration status to VIP. When you get to the show, DO NOT wait in line. Simply print this e-mail, bring it with you and present it directly at the event's registration desk. You will be escorted right in, without having to wait in line.<br><br>

You can view and print a list of all the companies who wish to interview with you at the event from the registration center at <?php echo BASE_URL?>/jobseeker_register - Additionally, a list will be printed and waiting for you at the event's registration desk.<br><br>

**********************************************************************<br>
Following is a note from the employer...<br>
**********************************************************************<br>
	<br/><hr color="003399"/><br/>
	
	</td>
	</tr>
	
	<tr>
    <td  valign="top" height="100" ><b>Your message:</b></td> 
	<td > 
	       <?php echo $this->Form->textarea('mailnotes',array('label'=>false,'class'=>'textarea_327','div'=>false));?>  
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2">
	

	<input type="hidden" value="298372" name="cid">
	<input type="hidden" value="465" name="show">
	
	<?php /*?><input type="submit" value="Send Email" name="operation" style="margin-left:130px;margin-top:10px;"><?php */?>
    <?php echo $this->Form->submit('images/send_email.jpg',array('div'=>false,'name'=>'Submit','style'=>'margin-left:130px;margin-top:10px;'));?>
	
	</td>
	</tr>
	
	</tbody>  
    		</table>
       <?php echo $this->Form->end();?> 
       <?php } ?>
       
              </div>
              
            </div>
          </div>
        </div>
      </div>
      
  <?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>


















