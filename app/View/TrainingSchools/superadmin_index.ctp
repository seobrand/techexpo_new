<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'trainingschool')); ?>

  <div id="right2"> 
	<!-- table -->
	<div class="box1"> 
	<div class="title-pad">
		<div class="title">
		  <h5 style="width:97%;">
			<div style="float:left;">List of training schools in the system. Click on one to edit it.</div>
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
			  <td align="left" valign="middle" ><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Create a new training school profile" name="assign">',array('controller'=>'training_schools','action'=>'add'),array('escape'=>false)); ?></td>
			 <tr><td align="left" valign="middle">
			<br />
			  <?php if(is_array($ts) && count($ts)):?>
				<?php foreach ($ts as $t_s): ?>
					<ul class="bullet_list">         
						<li><?php echo $this->Html->link($t_s['TrainingSchool']['ts_name'],array('controller'=>'training_schools','action'=>'edit',$t_s['TrainingSchool']['id']),array('escape'=>false)); ?></li>
					</ul>
				<?php endforeach; ?>
			  <?php else:?>
				No Training School list is available.
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
<?php if(count($ts)):?>
<div style="clear:both; margin: 5px 60px;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;?>




