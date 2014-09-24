<div class="content"> 
  <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Pre-Registered Candidate Mass E-mail: select a show to send a message to the pre-registered candidates.</div>
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
            <?php echo $this->Form->create('Admincandidates',array('action'=>'', 'enctype' => 'multipart/form-data')); ?>
              	<table cellspacing="0" cellpadding="0" border="0">
                <tbody>
                 
                  <tr>
                    <td valign="middle" align="left" colspan="2">
                     You are about to send a mass e-mail to the following pre-registered show attendees: <?php echo $showDetail['Show']['show_name'];  ?>- <?php echo $showDetail['Show']['show_dt']; ?>
                        
                        
                    </td>
                    
                  </tr>
                  
                 <tr>
                 		<td width="20%" valign="middle" align="right">Subject</td>
                    
                    <td width="80%" valign="middle" align="left">
                    <?php   echo $this->Form->input('Registration.subject',array('type'=>'textbox','div'=>false,'width'=>"200",'size'=>"70",'label'=>false,'value'=>"Quick TECHEXPO Reminder"));  ?>
                    </td>
                 </tr>
                 
                  <tr>
                  	<td width="20%" valign="middle" align="right">
                    Message
                    </td>
                    <td width="80%" valign="middle" align="left">
                    	   <?php 
						   
						   $showLocation=$common->getShowLocation($showDetail['Show']['location_id']);
				$valueMessage="<table>
											<tr>
												<td>
												Thank you for pre-registering for our MD - ".$showDetail['Show']['show_name']."  - ".$showDetail['Show']['show_dt']." TECHEXPO, held at the BWI Marriott on 1743 West Nursery Road, from 10am - 3pm.<br><br>

Just a quick reminder that the show is coming up tomorrow. Make sure to bring plenty of resumes with you, remember an active security clearance (or one that has been used within the past 24 months) is required to enter.  Be prepared to interview for specific positions by consulting the jobs our exhibitors have posted: <a href='".FULL_BASE_URL.router::url('/',false)."shows/view/".$showDetail['Show']['id']." >Click Here</a><br><br>

Pass this message on to any other qualified professionals you may know.<br><br>

Thanks again and see you at the show.<br><br>

Sincerely,<br><br>

Nancy Mathew<br>
Director of Events and Marketing <br>
212.655.4505 ext. 225<br>

												
												</td>
											</tr>
											
											
											
											</table>";
				
				
				
				  echo $this->Form->input('Registration.message',array('type'=>'textarea','style'=>'width:800px;height:300px','div'=>false,'label'=>false,'value'=>$valueMessage));  ?>
                    </td>
                  </tr>
                  
                  <tr>
                  <td></td>
                  	<td>
                    <font face="Verdana,Arial,Helvetica,sans-serif" size="2" color="660066"><b>The following paragraph will automatically be appended to the verbiage in the text area box above:</b></font><br><br>

<font face="Verdana,Arial,Helvetica,sans-serif" size="2" color="Black">
You can access your account by logging in at <?php echo FULL_BASE_URL.router::url('/',false); ?> - if you forgot your login, you can have it e-mailed to you by going to <?php echo FULL_BASE_URL.router::url('/',false); ?>users/forgotpassword<br><br>

Sincerely,<br><br>

Nancy Mathew<br>
Events Coordinator<br>
212.655.4505 ext. 225<br>
276 Fifth Avenue, Suite 1103<br>
New York, NY 10001
                    </td>
                  </tr>
                  
                  <tr>
                    
                   	<td width="20%" valign="middle" align="right">
                  
                    </td>
                    <td width="80%" valign="middle" align="left">
                   
                    <?php
					
					    echo $this->Form->input('Registration.show_id',array('type'=>'hidden',
																					'label'=>false,'class'=>'select1','div'=>''));
                     echo $this->Form->input('Registration.SUBMIT',array('type'=>'hidden','div'=>false,'label'=>'false','value'=>'Email2'));
                     echo $this->Form->submit('Send !',array('class'=>'ui-state-default ui-corner-all','value'=>'Send !')); 
					?> 
                   </td>
                  </tr>
                  
                  
                  
                  
                </tbody>
              </table>
            <?php $this->end();?>
            </div>
          </div>
        </div>
        <!-- end table --> 
      </div>
    </div>
  </div>
  <!-- end content / right --> 
</div>