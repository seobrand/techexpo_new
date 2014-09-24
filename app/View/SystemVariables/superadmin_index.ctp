<?php  //echo $this->element('admin-breadcrumbs',array('pageName'=>'ShowHome')); ?>
<div id="right2">
        <!-- table -->
        <div class="box1">
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">System Variables</div>
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
              <?php echo $this->Form->create('SystemVariable',array('action'=>'index','type'=>'file','inputDefaults'=>array('div'=>false,'error'=>false,'label'=>false))); ?>
              <table cellspacing="0" cellpadding="0" border="0" align="center">
                <thead>
                  <tr>
                    <th align="left"><b>Variable Name</b></font></th>
                    <th align="left"><b>Variable Value</b></font></th>                   
                  </tr>
                </thead>
                <tbody>                    
                  <?php $i=1; foreach($system_variable as $variables){ //pr($data);?>
                    <tr>
                       <td bgcolor="ccccff">
                       <font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="1"><?php echo $variables['SystemVariable']['variable_name']?></font>
                       </td>
                       <td bgcolor="ccccff"><?php echo $this->Form->input("SystemVariable.variables.{$variables['SystemVariable']['id']}",array('value'=>$variables['SystemVariable']['variable_value'],'class'=>'inputbox1'));?>&nbsp;
                       <?php  if($variables['SystemVariable']['id']==1  or $variables['SystemVariable']['id']==2) { ?>
                       (values can be comma-separated)
                       <?php  } ?>
                       </td>                            
                    </tr>                  
                  <?php $i++; } ?>
                  <tr>
                    <td colspan="9" align="left">                       
                        <?php
                            echo $this->Form->input('Update',array('type'=>'submit','class'=>'cursorclass ui-state-default ui-corner-all'));
                        ?>
                    </td>
                  </tr>
                </tbody>
              </table>
              <?php echo $this->Form->end(); ?>
            </div>
          </div>
        </div>
        <!-- end table -->
      </div>