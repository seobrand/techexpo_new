
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'chathistory')); ?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Current active user in chat groups</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
  <br/>
<!--  <?php echo $this->Form->postLink(
						'Delete All History',
						array('action' => 'deleteAllHistory','all'),
						array('confirm' => 'Are you sure to delete all history?','class'=>'a-state-default'));
					?><br/><br/><br/>-->
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <thead>
        <tr>
          <th width="5%" align="left" valign="middle"> Group Name  </th>


		  <th width="10%" align="center" valign="middle"> Action</th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($chatHistory as $chatHistory){?>
        <tr>
        
          <td align="left"><?php echo $common->getRoomName($chatHistory['ChatMessage']['room_id']) ;?></td>
	  <td align="center"><?php echo $this->Html->link('View History',array('controller' => 'chats', 'action' => 'viewHistory', $chatHistory['ChatMessage']['room_id'])); ?>
      &nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->Html->link('Delete Chat History',array('controller' => 'chats', 'action' => 'deleteHistory', $chatHistory['ChatMessage']['room_id'])); ?>
</td>
        </tr>
        <?php } ?>
		<?php if(count($chatHistory)==0){?>
		<tr>
         <td colspan="8" align="center">No history available Yet.</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
