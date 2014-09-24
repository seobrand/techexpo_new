<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'addjobplan')); ?>
<div id="right2">
  <!-- table -->
  <div class="box1">
    <div class="title-pad">
      <div class="title">
        <h5 style="width:97%;">
          <div style="float:left;">Add Job Plan</div>
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
        <?php  echo $this->Form->create('Jobplan',array('type' => 'post')); ?>
        <table cellspacing="0" cellpadding="0" border="0" align="left">
          <tbody>
            <tr>
              <td width="25%" valign="middle" align="right">Job Plan Title</td>
              <td valign="top" width="74%"  align="left"><?php echo $this->Form->input('title',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">Job Plan Price</td>
              <td valign="top" align="left"><?php echo $this->Form->input('price',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
			<tr>
              <td valign="middle" align="right">Jobs In This Plan</td>
              <td valign="top" align="left"><?php echo $this->Form->input('jobs',array('label'=>'','class'=>'inputbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">Available For</td>
              <td valign="top" align="left"><?php echo $this->Form->input('available_for',array('type'=>'select','options'=>$employer,'multiple'=>'multiple','default'=>'all','empty'=>array('all'=>'All Employer'),'size'=>'10','label'=>'','class'=>'selectbox1','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="middle" align="right">Active</td>
              <td valign="top" align="left"><?php echo $this->Form->input('is_active',array('type'=>'select','options'=>array('y'=>'Yes','n'=>'No'),'label'=>'','class'=>'','error'=>false));?></td>
            </tr>
            <tr>
              <td valign="top" align="left"></td>
              <td valign="top" align="left"><?php echo $this->Form->submit('Submit',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
            </tr>
          </tbody>
        </table>
        <?php echo $this->Form->end();?> </div>
    </div>
  </div>
  <!-- end table -->
</div>
</div>
</div>
<!-- end content / right -->
</div>
