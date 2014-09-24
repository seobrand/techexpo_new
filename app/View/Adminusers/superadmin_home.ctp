<script type="text/javascript">


$(document).ready(function() {

	$('#per_show_id').change(function() {
	  // set the window's location property to the value of the option the user has selected
	  window.location = 'superadmin/shows/add/'+$(this).val();
	})
	
});
</script>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Dashboard</div>
      <!--<div style="float:right;font-weight:bold;">Visitor Count : 24372</div>-->
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<!-- end box / title -->
<!-- display box / first -->
<div class="display_row">
  
<div class="dashboard_upcomimg" > Upcoming Shows </div>
    <div class="table">
      <table width="100%">
       <!-- <thead >
          <tr>
            <th colspan="7" class="left" >Upcoming Shows</th>
          </tr>
        </thead>-->
        <tbody>
          <tr>
            <th class="left">Show Date</th>
            <th class="left">Display Name</th>
            <th class="left">Show Name</th>
            <th class="left">Entry Requirements</th>
            <th class="left">Published</th>
            <th class="left">Candidates</th>
            <th class="left">Exhibitors</th>
            <th class="left">Copy</th>
           </tr>
		  <?php if(count($showLists)==0){?>
          <tr>
            <td class="title" colspan="7">No Show available</td>
          </tr>
		 <?php }else{?>
		 	<?php foreach($showLists as $showList){?>
        <tr>
            <td ><?php echo date('Y-m-d',strtotime($showList['Show']['show_dt']));  ?></td>
            <td ><?php echo $this->Html->link($showList['ShowsHome']['display_name'],array('controller'=>'shows','action'=>'edit',$showList['Show']['id']),array('escape'=>false,'alt'=>'Edit'));?> </td>
            <td >
			<?php echo $this->Html->link($showList['Show']['show_name'],array('controller'=>'shows','action'=>'edit',$showList['Show']['id']),array('escape'=>false,'alt'=>'Edit'));?>
			</td>
            <td><?php  echo $showList['ShowsHome']['special_message']; ?></td>
            
            <td align="center"><?php  if($showList['Show']['published']==1)
						echo $this->Html->image('green_check.png',array('height'=>20,'width'=>20));
						else
						echo $this->Html->image('red_cross.png',array('height'=>20,'width'=>20));
			 ?>
            </td>
            <td ><?php echo $common->getShowCandidate($showList['Show']['id']); ?></td>
            <td><?php  echo $common->getShowEmployer($showList['Show']['id']); ?></td>
            <td align="center"> <?php echo $this->Html->link($this->Html->image('copy_new_icon.png',array('height'=>25,'width'=>25)),array('controller'=>'shows','action'=>'add',$showList['Show']['id']),array('escape'=>false,'alt'=>'Copy Now'));?> </td>
        </tr>
			<?php } //end foreach ?>
		 <?php } ?> 
        </tbody>
      </table>
    </div>
    
  		<div class="pager">
        <div class="paging"> 
        <?php echo $this->Paginator->prev('<< ' . __('Previous', true), array(), null, array('class'=>'disabled'));?>
        <?php echo $this->Paginator->numbers(array('separator'=>'&nbsp;|&nbsp;'));?>
        <?php echo $this->Paginator->next(__('Next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
        </div>

        <div class="clear"></div>
        
        </div>
    
    
    

</div>
 <div class="display_row">
 <?php echo $this->Form->input('per_show_id',array('label'=>'','options'=>$event_lists,'empty'=>'Select a show to duplicate','type'=>'select','error'=>false ,'class'=>'dashboard_dropdown'));?>

<?php echo $this->Html->link('New Show',array('controller'=>'shows','action'=>'add'),array('escape'=>false,'class'=>'cursorclass ui-state-default dashboard_new_button'));?>

 </div>
 
<!-- display box / first end here -->
<!-- display box / second -->
<div class="display_row">
  <div class="display_left">
    <div class="table"> </div>
  </div>
  <div class="display_right">
    <div class="table"> </div>
  </div>
</div>
