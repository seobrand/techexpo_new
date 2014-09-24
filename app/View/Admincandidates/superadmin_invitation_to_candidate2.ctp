<div class="content"> 
  <!-- content / right -->
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
                <div style="float:left;">Admin: Mass e-mail Invite to Candidates</div>
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
        <table>
          <tbody>
          	<tr>
            	<td valign="left" align="left">
                <?php
				
				 if(count($showDetail)>0) {?>
                You are about to send a mass e-mail to invite attendees to the following show:
                <strong><?php echo $showDetail['Show']['show_name']; ?> - <?php echo $showDetail['Show']['show_hours']; ?> - 
                <?php echo $showDetail['Show']['show_dt']; ?></strong>
                
                <?php } ?>
              
             
                
				</td>
			</tr>
          	<tr>
            	<td valign="middle" align="left">
             	<strong>Subject:	</strong>
                <?php   echo $this->Form->input('Registration.subject',array('type'=>'textbox','div'=>false,'width'=>"200",'size'=>"70",'label'=>false,'value'=>"You're invited to TECHEXPO"));  ?>
					<br />
                	
	<br><br><br>
	<b>The following verbiage will precede for techexpoUSA.com web site members:</b><br><br>
	
	<!-- 
	************************************************************************<br><br>
	
	To unsubscribe from all future communications with TechExpoUSA.com, please follow this link:<br>
	http://www.techexpoUSA.com/cand_email_prefs.cfm (your login will be required to unsubscribe) <br><br>
	
	************************************************************************<br><br> -->
	
	Dear #candidate_name#,<br><br>
	
	Many thanks for attending one of our past events or visiting TechexpoUSA's career center.<br><br>
                </td>
            </tr>
           
            <tr>
            	<td><br />
               <strong> This is the message you are about to send.
You can make changes within the text box area below before sending it out.</strong>
<br /><br />


                <?php 
				$showLocation=$common->getShowLocation($showDetail['Show']['location_id']);
				//pr($showDetail);
				//pr($showLocation);
				
				
				$valueMessage="You're invited to save time, travel and money by interviewing for hundreds of high-paying positions all in one day at TECHEXPO in ".$showLocation['Location']['location_state']." - ".$showLocation['Location']['location_city']." on ".$showDetail['Show']['show_dt']." ! Network & interview face to face with the I/T, Telecom, and New Media industries' cutting-edge companies at TECHEXPO!  Discover your worth in the job marketplace and significantly shorten your job search by meeting many companies in one day.<br><br>
	
	Date:- ".$showDetail['Show']['show_dt']." at ".$showDetail['Show']['show_hours']."
	".$showLocation['Location']['site_name']."<br>
	".$showLocation['Location']['site_address']." - ".$showLocation['Location']['location_city'].", ".$showLocation['Location']['location_state']." ".$showLocation['Location']['site_zip']."<br>
	For travel directions only please call ___.___.____ or visit our website at http://www.techexpoUSA.com<br>
	Free Admission
	
	*** REQUIREMENTS
	
	The big question these days is:  what companies are hiring ? Among the companies participating are: Lockheed Martin, Ajilon LLC, BEA Systems Inc., LOG-NET Inc., Parity-TelTech,  Rutgers - The State University, TIS Worldwide, Virtual Corporation, JobCircle.com, Visalign LLC, and many more...";
				
				
				
				  echo $this->Form->input('Registration.message',array('type'=>'textarea','class'=>'smallTextB mceNoEditor','style'=>'width:800px;height:300px','div'=>false,'label'=>false,'value'=>$valueMessage));  ?>
        		</td>
            </tr>
            
             
            
            
            
            <tr>
              <td valign="middle" align="left"> 

            <br />
            <br /><strong> The following verbiage will follow:</strong><br>

			<?php   echo $this->Form->input('Registration.message_footer',array('type'=>'textarea','class'=>'smallTextB mceNoEditor','style'=>'width:800px;height:300px','div'=>false,'label'=>false,'value'=>$FooterMsg));  ?>
			 </td>
            </tr>
            
            
            <tr>
              <td valign="middle" align="left"> 

<strong>send test message first: </strong>&nbsp;&nbsp;

	<?php   echo $this->Form->input('Registration.test_email',array('type'=>'checkbox','class'=>'smallTextB mceNoEditor','div'=>false,'label'=>false));  ?>
<br />
<br />
To: <input type ="text" value="nmathew@techexpousa.com" name="data[Registration][test_address]>

&nbsp;&nbsp;<b>IMPORTANT NOTE:</b> You must have ann account with this e-mail registered or this test feayure will not work</font><br><br>
                </td>
            </tr>
            <tr>
            
            
            <tr>
              <td valign="middle" align="left"> 

            <br />
            <br /><strong> Resume interrupted e-mail from: </strong><br><br />
            <input type ="text"  name="data[Registration][resume_email]>
&nbsp;&nbsp;<b>NOTE:</b> You may enter the first letter, first few letters or an entire e-mail address</font><br><br>
			
			 </td>
            </tr>
            
            <tr>
            	<td valign="middle" align="left">
             <br /><br />
             
             <select id="RegistrationExcludeDomian" class="listbox" size="10" multiple="multiple" domain_name="domain_name" fields="domain_id" name="data[Registration][exclude_domian][]">
           <?php
		      
		    foreach($doaminList as $key=>$value){ 
        ?>
             <option value="<?php echo $value['exclude_domains']['domain_name'];?>"><?php echo $value['exclude_domains']['domain_name']  ?></option>
             <?php } ?>
            </select>
           
         
             </td>
             </tr>
            
            
              <td valign="middle" align="left">
				   <?php
				   	echo $this->Form->input('Registration.show_id',array('type'=>'hidden','div'=>false,'label'=>false)); 
					echo $this->Form->input('Registration.showid',array('type'=>'hidden','div'=>false,'label'=>false)); 
					echo $this->Form->input('Registration.footer_type',array('type'=>'hidden','div'=>false,'label'=>false));
					
					echo $this->Form->input('Registration.security_clearance_code',array('type'=>'hidden','div'=>false,'label'=>false));
					echo $this->Form->input('Registration.state_id',array('type'=>'hidden','div'=>false,'label'=>false));
				   
				   
				   
				   
				   
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