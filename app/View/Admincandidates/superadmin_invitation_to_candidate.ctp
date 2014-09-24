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
      <?php echo $this->Form->create('Admincandidates',array('action'=>'invitationToCandidate2', 'enctype' => 'multipart/form-data')); ?>
        <table>
          <tbody>
          	<tr>
            	<td valign="middle" align="center">
                Invitation to Candidates by Mass E-mail: select a show to send a message to the members of our mailing list and web site (used to generate invitation message). IMPORTANT: use this only for show invitations. For partner and non-show related promotional announcements use THIS LINK<br /><br />
				</td>
			</tr>
          	<tr>
            	<td valign="middle" align="left">
             
1) Show for which you are sending invitations:<br /><br />
                	<?php 
                        echo $this->Form->input('Registration.show_id',array('type'=>'select','options'=>$showList,
																					'empty'=>false,
																					'label'=>false,'class'=>'select1','div'=>''));
                      ?>
                
                </td>
            </tr>
            <tr>
              <td valign="middle" align="left"> 
<b>2. Online candidates and mailing list members:</b>
select your states (used to select who will receive the e-mail, based on their state of residence or e-mail preferences.) Also, select whether or not you want candidates to have security clearance.
<br>
<br />
			<?php echo $this->Form->input('Registration.state_id',array('type'=>'select','options'=>$stateList,
																					'empty'=>false,
																					'label'=>false,'div'=>'','class'=>'listbox','multiple'=>'multiple','size'=>'10'));
             ?>
			 </td>
            </tr>
            <tr>
            	<td>
                	Security clearance:<br /><br />
                     <?php 
					 	$option=array('n'=>'I want BOTH candidates WITH and WITHOUT security clearance','y'=>'I ONLY want candidates WITH security clearance',);
                        echo $this->Form->input('Registration.security_clearance_code',array('type'=>'select','options'=>$option,
																					'empty'=>false,
																					'label'=>false,'class'=>'select1','div'=>''));
                      ?>
                
				</td>
            </tr>
            <tr>
              <td valign="middle" align="left"> 
<br />
             <strong> 3. "Show" candidates:</strong> in addition to online candidates, you can invite candidates that handed in their resume manually at various events. Please choose from the events below.
                <br /><br />
                <?php
					echo $this->Form->input('Registration.showid', array('type' => 'select','multiple' => 'checkbox','style'=>'width:100px;',
																	'options' => $previousShowList));
				?>
                </td>
            </tr>
            
            	<tr>
            	<td valign="middle" align="left">
             <br /><br />
4. Select message footer (text that will go at the end of the e-mail: <br /><br />
                	<?php 
					$footerOption=array('msg1'=>'msg1','msg2'=>'msg2','msg3'=>'msg3');
                        echo $this->Form->input('Registration.footer_type',array('type'=>'select','options'=>$footerOption,
																					'empty'=>false,
																					'label'=>false,'class'=>'select1','div'=>''));
                      ?>
                
                </td>
            </tr>
            
            <tr>
              <td valign="middle" align="left">
				   <?php
                     echo $this->Form->input('Registration.SUBMIT',array('type'=>'hidden','div'=>false,'label'=>'false','value'=>'Email'));
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