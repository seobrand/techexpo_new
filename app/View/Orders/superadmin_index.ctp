<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'orders')); ?>

  <div id="right2"> 
	<!-- table -->
	<div class="box1"> 
	<div class="title-pad">
		<div class="title">
		  <h5 style="width:97%;">
			<div style="float:left;">List of Job Plans</div>
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
		<table id="login" cellspacing="0" cellpadding="0" border="0" align="center">
		  <tbody>
			<tr>
			  <td align="left" valign="middle" ><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add New Plan" name="assign">',array('controller'=>'orders','action'=>'add'),array('escape'=>false)); ?></td>
			 <tr><td align="left" valign="middle">
			<br />
			  <?php if(is_array($jobplans) && count($jobplans)):?>
				<?php foreach ($jobplans as $jobplan): ?>
					<ul class="bullet_list">         
						<li><?php echo $this->Html->link($jobplan['Jobplan']['title'],array('controller'=>'orders','action'=>'edit',$jobplan['Jobplan']['id']),array('escape'=>false)); ?> (<?php if($jobplan['Jobplan']['is_active']=='y'){?> Active <?php }else{?> Deactive <?php } ?>)</li>
					</ul>
				<?php endforeach; ?>
			  <?php else:?>
				No Job Plan list is available.
			  <?php endif;?>
			 </td>
			</tr>      
		  </tbody>
		</table>
		</div>
		</div>
		</div>
	<!-- end table --> 
	</div>
	
    </div>
  </div>
  <!-- end content / right -->
</div>
<?php if(count($jobplans)):?>
<div style="clear:both; margin: 5px 60px;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;?>




