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
                    
                    	 <font face="Verdana,Arial,Helvetica,sans-serif" size="5" color="Blue"><b>Upload Resumes - Step 2: upload ZIP files with resumes.</b></font><br>
                         <br />
                         <br />
                         <br />
                         <strong style="font-size:14px;">Total New Registration:</strong> <?php echo count($this->Session->read('csvFile')); ?>
                         &nbsp;&nbsp;&nbsp;&nbsp;Total Already  Exist Candidate:</strong> <?php echo count($this->Session->read('alreadyExistEmail')); ?>
                    </td>
                </tr>
                
                 <tr>
                    <td width="25%" valign="middle" align="right">
                   1) Select the ZIP file containing the candidate resumes:<br><br>
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
							echo $this->Form->input('Candidate.File',array('type'=>'file','label'=>false,'div'=>false,'class'=>'uploadfile'))
						?>
                        <div style="clear:both" class="error-message">
                        	<?php  echo $errorFile; ?>
                        </div>
                    </td>
                  </tr>
                  
                  <tr>
                    <td width="25%" valign="middle" align="right"></td>
                    <td width="74%" valign="middle" align="left">
                   
                    <?php
                     echo $this->Form->input('Candidate.SUBMIT',array('type'=>'hidden','div'=>false,'label'=>'false','value'=>'uploadZip'));
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