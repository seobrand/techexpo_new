<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'orderhistory')); ?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">View Order History of Job Plans</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
  <br/>
  <?php echo $this->Form->postLink(
						'Delete All History',
						array('action' => 'deleteAllHistory','all'),
						array('confirm' => 'Are you sure to delete all history?','class'=>'a-state-default'));
					?><br/><br/><br/>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <thead>
        <tr>
          <th width="18%" align="left" valign="middle"> Employer Name </th>
          <th width="12%" align="left" valign="middle"> Job Plan </th>
          <th width="10%" align="left" valign="middle"> Job Plan Price </th>
          <th width="12%" align="left" valign="middle"> Jobs Purchased </th>
          <th width="15%" align="left" valign="middle"> Credit Card Payer </th>
		  <th width="12%" align="left" valign="middle"> Credit Card Type </th>
		  <th width="10%" align="left" valign="middle"> Order Date </th>
		  <th width="10%" align="center" valign="middle"> Action</th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($jobplanhistory as $history){?>
        <tr>
          <td align="left"><?php echo $history['Employer']['employer_name'];?></td>
          <td align="left"><?php echo $history['JobplanHistory']['jobplan_title'];?></td>
          <td align="center">$<?php echo $history['JobplanHistory']['jobplan_price'];?></td>
          <td align="center"><?php echo $history['JobplanHistory']['jobplan_jobs'];?> Jobs</td>
          <td align="left"><?php echo $history['JobplanHistory']['cc_firstname']." ".$history['JobplanHistory']['cc_lastname'];?></td>
		  <td align="center"><?php echo $history['JobplanHistory']['cc_type'];?></td>
		  <td align="left"><?php echo date("m/d/Y",strtotime($history['JobplanHistory']['order_date']));?></td>
		  <td align="center"><?php echo $this->Html->link('Delete',array('controller' => 'orders', 'action' => 'deletehistory', $history['JobplanHistory']['id']),array(),"Are you sure you wish to delete this history?");?>
</td>
        </tr>
        <?php } ?>
		<?php if(count($jobplanhistory)==0){?>
		<tr>
         <td colspan="8" align="center">No Histroy available Yet.</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
