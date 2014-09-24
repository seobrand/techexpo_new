<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'lastVisit')); 
?>
   <div id="right2"> 
        <!-- table -->
        <div class="box1">
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Send E-mail </div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
          <!-- box / title -->
          
          <div class="display_row">
            <div class="table">
            <?php echo $this->Form->create('ExportResumes',array('id'=>'ExportResumes','action'=>'emailResume'));?>
              <table border="0" cellspacing="0" cellpadding="0">
                <tbody>
                  <tr>
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <td width="20%" valign="middle" align="right">Subject: </td>
                    <td width="79%" valign="middle" align="left">
                     <?php echo $this->Form->input('subject',array('label'=>false,'class'=>'inputbox1','div'=>false));?>
                      <br>
                      <br></td>
                  </tr>
                  <tr>
                    <td width="20%" valign="middle" align="right">Email To: </td>
                    <td width="79%" valign="middle" align="left">
                     <?php echo $this->Form->input('email',array('label'=>false,'class'=>'inputbox1','div'=>false));?></td>
                  </tr>
                    </tr>
                  
                  <tr>
                    <td width="20%" valign="middle" align="right"><br>
                      <br>
                      This is the message you are about to send.
                      You can make changes within the text box area below before sending it out.
                      <br></td>
                    <td width="79%" valign="middle" align="left">
                             <?php echo $this->Form->input('message',array('type'=>'textarea','label'=>false,'class'=>'smallTextB mceNoEditor','div'=>false));?>  
                
                     </td>
                  </tr>
                  <tr>
                    <td></td>
                      <td width="79%" valign="middle" align="left">
                      <?php echo $this->Form->submit('send',array('div'=>false,'name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all'));?>
                      </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- end table --> 
      </div>