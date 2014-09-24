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
            <?php echo $this->Form->create('Admincandidates',array('action'=>'registerCandidateMassEmail2', 'enctype' => 'multipart/form-data')); ?>
              	<table cellspacing="0" cellpadding="0" border="0">
                <tbody>
                 
                  <tr>
                    <td width="25%" valign="middle" align="right">
                    	
                    </td>
                    <td width="74%" valign="middle" align="left">
                    	<?php 
                        echo $this->Form->input('Registration.show_id',array('type'=>'select','options'=>$showList,
																					'empty'=>false,
																					'label'=>false,'class'=>'select1','div'=>'','class'=>'listbox'));
                        ?>
                    </td>
                  </tr>
                  <tr>
                    <td width="25%" valign="middle" align="right"></td>
                    <td width="74%" valign="middle" align="left">
                   
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