<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'Show')); ?>

  <div id="right2"> 
	<!-- table -->
	<div class="box1"> 
	<div class="title-pad">
		<div class="title">
		  <h5 style="width:97%;">
			<div style="float:left;">Show List</div>
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
			  <td align="left" valign="middle" ><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add New" name="assign">',array('controller'=>'shows','action'=>'add'),array('escape'=>false)); ?></td>
			 <tr><td align="left" valign="middle">
			<br />
			<?php if(is_array($shows) && count($shows)):?>
            <?php foreach ($shows as $show): ?>
            <?php $newdateformat = date("m-d-y",strtotime($show['Show']['show_dt']));?>
            
            <?php  	$theComponent = new commonComponent(new ComponentCollection());
            $location_state = $theComponent->getLocationInfo('location_state',$show['Show']['location_id']);
			if($show['Show']['published']==0) $publishClass= 'publish_class' ; else $publishClass='';
            ?>
            <ul class="bullet_list <?php echo $publishClass; ?>">         
            <li><?php echo $this->Html->link($newdateformat." - ".$show['Show']['show_name']." ".$location_state, array('controller'=>'shows','action'=>'edit',$show['Show']['id']),array('escape'=>false)); ?> &nbsp;&nbsp;&nbsp;
            <?php 
		if($show['Show']['published']==0)
		echo 'Please update this show';
		else
		echo $this->Html->link('Click here for duplicate event', array('controller' => 'shows','action' => 'duplicateevent',$show['Show']['id']));	
			 ?></li>
            </ul>
            <?php endforeach; ?>
            <?php else:?>
            No Shows list is available.
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
<?php if(count($shows)):?>
<div style="clear:both; margin: 5px 60px;"> 
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
<?php endif;?>




