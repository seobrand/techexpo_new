<script type="text/javascript">
function confirmfrmSubmit()
{
	var agree=confirm("Are you sure you wish to continue?");
	
	if (agree)
		return true ;
	else
		return false ;
}
</script>

<?php //  echo $this->element('admin-breadcrumbs',array('pageName'=>'chathistory')); ?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Job Email History</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
  <br/>
<br/>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <thead>
        <tr>
          <th width="5%" align="left" valign="middle"> From  </th>
          <th width="5%" align="left" valign="middle">To </th>


		  <th width="10%" align="center" valign="middle"> Action</th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($JobEmailHistory as $JobEmailHistory){?>
        <tr>
        
          <td align="left"><?php echo $JobEmailHistory['JobEmailHistory']['from_email'] ;?></td>
            <td align="left"><?php echo $JobEmailHistory['JobEmailHistory']['friend_email'] ;?></td>
		  <td align="center">
     	<?php echo $this->Html->link('View Job Detail',array('controller' => 'employers', 'action' => 'jobdetail', $JobEmailHistory['JobEmailHistory']['posting_id'],'superadmin'=>false)); ?>&nbsp;&nbsp;|&nbsp;&nbsp;
		<?php echo $this->Html->link('Delete',array('controller' => 'admincandidates', 'action' => 'emailhistory','delete',$JobEmailHistory['JobEmailHistory']['id']),array('onClick'=>'return confirmfrmSubmit()')); ?>


</td>
        </tr>
        
        
        <?php } ?>
        <tr>
        	<td colspan="4">
            	<div class="pager">
                <div class="paging"> <?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?> | <?php echo $this->Paginator->numbers(array('pages' => 2));?> | <?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?> </div>
                
                <div class="clear"></div>
              </div>
            </td>
        </tr>
		<?php if(count($JobEmailHistory)==0){?>
		<tr>
         <td colspan="8" align="center">No Block Ip available Yet.</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
