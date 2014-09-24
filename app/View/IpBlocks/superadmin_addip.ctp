<?php
 //echo $this->element('admin-breadcrumbs',array('pageName'=>'addgroup'));
?>

<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Add Ip</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
<?php echo $this->Form->create('IpBlock',array('type'=>'post','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
    <div class="display_row">
      <div class="table">
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
            <tr>
              <td width="20%" align="right" valign="middle">Ip Address*: </td>
              <td width="80%"  align="left" valign="top"><?php echo $this->Form->input('ip',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
		
            <tr>
              <td align="right" valign="middle">&nbsp;</td>
              <td align="left" valign="top">
              <?php
                echo $this->Form->submit('Add Ip',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));
              ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
	<?php echo $this->Form->end();?>
 </div>
        <!-- end table --> 
</div>