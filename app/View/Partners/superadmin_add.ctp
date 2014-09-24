<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addpartner')); ?>
<div id="right2">
  <!-- table -->
  <div class="box1">
    <!-- box / title -->
    <div class="title-pad">
      <div class="title">
        <h5 style="width:97%;">
          <div style="float:left;">Add Partner</div>
          <div style="float:right;font-weight:bold;"></div>
        </h5>
        <div class="search">
          <div class="input"> </div>
          <div class="button"> </div>
        </div>
      </div>
    </div>
   <?php echo $this->Form->create('Partner',array('action'=>'add','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
            <tr>
              <td width="25%" align="right" valign="middle">Partner Name: </td>
        		<td width="74%"  align="left" valign="top"><?php echo $this->Form->input('partner_name',array('class'=>'inputbox1','type'=>'text'));?></td>
            </tr>
            <tr>
              <td align="right" valign="middle"> Marketing Partner: </td>
              <td align="left" valign="top"><?php // echo $this->Form->input('employer_id',array('type'=>'select','options'=>$clientList,'empty'=>'-Select Partner-','lable'=>false,'div'=>'false')); ?>
              <?php echo $this->Form->input('marketing_exhibitor_id',array('type'=>'select','options'=>$clientList,'empty'=>'-Select Partner-','lable'=>false,'div'=>'false')); ?>
              
              </td>
            </tr>
            <tr>
              <td align="right" valign="middle"> Site URL: </td>
              <td align="left" valign="top">
			  <?php //echo $this->Form->input('employer_id',array('type'=>'select','options'=>$clientList,'empty'=>'-Select Partner-','lable'=>false,'div'=>'false')); ?>
              <?php echo $this->Form->input('site_url',array('class'=>'inputbox1','lable'=>false,'div'=>'false')); ?>
              </td>
            </tr> 
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top"><?php echo $this->Form->input('Add Partner',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all'));?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <?php echo $this->Form->end(); ?> </div>
  <!-- end table -->
</div>
