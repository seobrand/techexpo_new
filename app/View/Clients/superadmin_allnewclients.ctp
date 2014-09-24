<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'allnewclients')); ?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">All New Clients</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
  </div>
</div>
<div class="display_row">
  <div class="table">  
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <thead>
        <tr>
          <th width="28%" align="left" valign="middle"> Company Name </th>
          <th width="22%" align="left" valign="middle"> Company Phone </th>
          <th width="20%" align="left" valign="middle"> Company Address </th>
          <th width="15%" align="left" valign="middle"> Company Email	 </th>
          <th width="15%" align="left" valign="middle"> Created date </th>		 
        </tr>
      </thead>
      <tbody>
	  <?php foreach($employers as $employer){?>
        <tr>
          <td align="left"><?php echo $this->Html->link($employer['Employer']['employer_name'],array('controller'=>'clients','action'=>'clientdetail',$employer['Employer']['id'],$employer['EmployerContact']['id']));?></td>
          <td align="left"><?php echo $employer['Employer']['main_phone'];?></td>
          <td align="center"><?php echo $employer['Employer']['address']."<br/>".$employer['Employer']['city'].",".$employer['Employer']['state'].",".$employer['Employer']['zip'];?></td>
          <td align="center"><?php echo $employer['EmployerContact']['contact_email'];?></td>
          <td align="left"><?php echo date("m/d/Y",strtotime($employer['Employer']['created']));?></td>
        </tr>
        <?php } ?>
		<?php if(count($employers)==0){?>
		<tr>
         <td colspan="8" align="center">No New Clients Found.</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?php if(count($employers)):?>
<div style="clear:both; margin: 5px 0	px;"> 
  <div class="title-pad"> <?php echo $this->element('cms-paging');?> </div>
</div>
<?php endif;?>
