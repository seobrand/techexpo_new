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
                    
                    
			<font face="Verdana,Arial,Helvetica,sans-serif" size="5" color="Blue"><b>Upload Resumes - Step 1: upload CSV file.</b></font><br>
			
                    </td>
                </tr>
                
                 <tr>
                    <td width="25%" valign="middle" align="right">
                   1) Select the csv file containing the candidates info:<br><br>
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
							echo $this->Form->input('Candidate.File',array('type'=>'file','label'=>false,'div'=>false,'class'=>'uploadfile'))
						?>
                        <div style="clear:both" class="error-message">
                        	<?php  echo $errorFile; ?>
                        </div>
                        <br/>
                          
            <?php echo $this->Html->link('CSV Format',array('controller'=>'admincandidates','action'=>'downloadCSV')); ?>
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