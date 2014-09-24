
<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'users')); ?>
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
          <th width="5%" align="left" valign="middle"> id </th>
          <th width="12%" align="left" valign="middle"> Name </th>
          <th width="10%" align="left" valign="middle"> IP </th>
          <th width="12%" align="left" valign="middle"> Active </th>
          <th width="15%" align="left" valign="middle"> Room </th>
<!--		  <th width="12%" align="left" valign="middle"> Capacity </th>
		  <th width="23%" align="left" valign="middle">  	Capacity exclusive </th>-->
		  <th width="10%" align="center" valign="middle"> Action</th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($chatUsers as $chatUser){?>
        <tr>
          <td align="left"><?php echo $chatUser['ChatUser']['id'];?></td>
          <td align="left"><?php echo $chatUser['ChatUser']['user'];?></td>
          <td align="center"><?php echo $chatUser['ChatUser']['ip'];?></td>
          <td align="center"><?php if($chatUser['ChatUser']['active']=='1') echo "Active" ; else echo "Inactive";   ?> </td>
          <td align="left"><?php echo $common->getRoomName($chatUser['ChatUser']['room_id']) ;?></td>
<!--		  <td align="center"><?php echo $chatUser['ChatUser']['capacity'];?></td>
		  <td align="left"><?php echo date("m/d/Y",strtotime($chatUser['ChatUser']['order_date']));?></td>
-->		  <td align="center"><?php echo $this->Html->link('Delete',array('controller' => 'chats', 'action' => 'deleteChatUser', $chatUser['ChatUser']['id']),array(),"Are you sure you wish to delete this chatUser?");?>
</td>
        </tr>
        <?php } ?>
		<?php if(count($chatUsers)==0){?>
		<tr>
         <td colspan="8" align="center">No user available Yet.</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
