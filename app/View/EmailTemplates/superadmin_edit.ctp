<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'editemailtemplate'));?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Edit Email Template</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('EmailTemplate',array('type'=>'post','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
 			<tr>
              <td width="20%" align="right" valign="middle">Title* : </td>
              <td width="80%"  align="left" valign="top"><?php echo $this->Form->input('title',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
			<tr>
              <td width="20%" align="right" valign="middle">Subject*: </td>
              <td width="80%"  align="left" valign="top"><?php echo $this->Form->input('subject',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
			<tr>
              <td width="20%" align="right" valign="middle">Footer Message: </td>
              <td width="80%"  align="left" valign="top"><?php echo $this->Form->input('footer_message',array('type'=>'textarea'));?></td>
            </tr>
            <tr>
              <td width="20%" align="right" valign="middle">Message*: </td>
              <td width="80%"  align="left" valign="top"><?php echo $this->Form->input('message',array('type'=>'textarea','rows'=>'20','cols'=>80));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
     			<?php echo $this->Form->input('id', array('type' => 'hidden'));
				 echo $this->Form->submit('Update Template',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
                echo $this->Form->end();
              ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
 </div>
        <!-- end table --> 
</div>