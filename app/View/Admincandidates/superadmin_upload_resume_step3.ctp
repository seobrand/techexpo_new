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
                <div style="float:left;"></div>
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
            <div>
          
            </div>
            <?php echo $this->Form->create('Admincandidates',array('action'=>'', 'enctype' => 'multipart/form-data')); ?>
              	<table cellspacing="0" cellpadding="0" border="0">
                <tbody>
                <tr>
                	<td colspan="2">
                    
                    	 <font face="Verdana,Arial,Helvetica,sans-serif" size="5" color="Blue"><b>Upload Resumes - Step 3: select which show this upload applies to:</b></font><br><br>
                         <br />
                         <br />
                         <br />
                    </td>
                </tr>
                
                 <tr>
                    <td width="25%" valign="middle" align="right">
                   1) Select Show:<br>
                   <br>
                    </td>
                  <td width="74%" valign="middle" align="left">
                    	<?php 
                        echo $this->Form->input('Registration.show_id',array('type'=>'select','options'=>$showList,
																					'empty'=>'-Select Show-',
																					'label'=>false,'class'=>'select1 listbox','div'=>'','style'=>'max-width:464px !important;'));
                        ?>&nbsp;&nbsp;
                        <?php 
							echo $this->Form->input('Registration.overright',array('type'=>'text','label'=>false,'div'=>false,'class'=>'inputbox1'));
						?>
                        <div style="clear:both" class="error-message">
                        	<?php  echo $errorFile; ?>
                        </div>
                    </td>
                  </tr>
                  
                   <tr>
                    <td width="25%" valign="middle" align="right">
                   2) Type a title for the resumes:<br><br><br><br>
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
							echo $this->Form->input('Resume.resume_title',array('type'=>'text','label'=>false,'div'=>false,'class'=>'inputbox1'));
						?>
                        <div style="clear:both" class="error-message">
                        	<?php  echo $errorFile1; ?>
                        </div>
                    </td>
                  </tr>
                  
                  
                 
                  <tr>
                    <td width="25%" valign="middle" align="right"></td>
                    <td width="74%" valign="middle" align="left">
                   
                    <?php
                     echo $this->Form->input('Candidate.SUBMIT',array('type'=>'hidden','div'=>false,'label'=>'false','value'=>'Upload'));
                     echo $this->Form->submit('images/update.png',array('class'=>'delete_btn')); 
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