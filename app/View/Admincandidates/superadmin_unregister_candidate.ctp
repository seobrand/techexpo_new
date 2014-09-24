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
                    
                    	 <strong> Step 1:</strong> Upload the csv file with the names and e-mails of the candidates who DID NOT PRE-REGISTER,<br />
							and whether or not they wish to be in the National Database (must be indicated by y or n).<br />
                                <ul>
                                <li>This MUST BE a csv file with 3 columns in this order: name, email, national database preference.</li>
                                <li>DO NOT name the columns, just present the data as indicated above.</li>
                                <li>The national database preference column must contain only a 'y' or a 'n'.</li>
                                </ul>
                                <br />
                                <br />
                    </td>
                </tr>
                
                 <tr>
                    <td width="25%" valign="middle" align="right">
                    	Select the file from your hard drive:
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
							echo $this->Form->input('Candidate.File',array('type'=>'file','label'=>false,'div'=>false,'class'=>'uploadfile'))
						?>
                        <div style="clear:both" class="error-message">
                        	<?php echo $errorFile; ?>
                        </div>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right">
                    	Select which show these candidates came from:
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
                        echo $this->Form->input('Registration.show_id',array('type'=>'select','options'=>$showList,
																					'empty'=>'-Select Show-',
																					'label'=>false,'class'=>'select1','div'=>'','class'=>'listbox'));
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right"></td>
                    <td width="74%" valign="middle" align="left">
                   
                    <?php
                     echo $this->Form->input('Candidate.SUBMIT',array('type'=>'hidden','div'=>false,'label'=>'false','value'=>'uploadCSV'));
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