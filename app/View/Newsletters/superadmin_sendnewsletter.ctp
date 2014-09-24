<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'sendnewsletter')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Add Email Template</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('Newsletter',array('type'=>'post','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
		  <?php if(isset($email_id)){?>
            <tr>
              <td width="20%" align="right" valign="middle">Send To: </td>
              <td width="80%"  align="left" valign="top"><?php echo $this->Form->input('sendemail',array('label'=>'','class'=>'inputbox1','error'=>false,'value'=>$email_id));?></td>
            </tr>
			<?php } ?>
			 <tr>
              <td width="20%" align="right" valign="middle">Subject: </td>
              <td width="80%"  align="left" valign="top"><?php echo $this->Form->input('subject',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
			
            <tr>
              <td width="20%" align="right" valign="middle">Template: </td>
              <td width="80%"  align="left" valign="top"><?php echo $this->Form->input('message',array('type'=>'textarea','rows'=>'20','cols'=>80));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->submit('Send Newsletter',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
              ?>
			  <?php echo $this->Form->end();?>
			  <?php if(isset($email_id)){?>
				<?php echo $this->Form->postLink(
						'Unsubscribe',
						array('action' => 'unsubscribe',$id),
						array('confirm' => 'Are you sure to unsubscribe this email?','class'=>'a-state-default'));
					?>
				<?php } ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
	
 </div>
        <!-- end table --> 
</div>