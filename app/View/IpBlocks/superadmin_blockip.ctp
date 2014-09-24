
<?php //  echo $this->element('admin-breadcrumbs',array('pageName'=>'chathistory')); ?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Block Ip Address</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
  </div>
</div>
<div class="display_row">
  <div class="table">
  <br/>
 <?php echo $this->Html->link(
						'Add Ip',
						array('action' => 'addip'),
						array('class'=>'a-state-default'));
					?><br/><br/><br/>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <thead>
        <tr>
          <th width="5%" align="left" valign="middle"> Block Ip  </th>


		  <th width="10%" align="center" valign="middle"> Action</th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($blockIps as $chatHistory){?>
        <tr>
        
          <td align="left"><?php echo $chatHistory['IpBlock']['ip'] ;?></td>
	  <td align="center"><?php // echo $this->Html->link('Edit',array('controller' => 'chats', 'action' => 'editIp', $chatHistory['IpBlock']['id'])); ?>
      &nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->Html->link('Delete',array('controller' => 'IpBlocks', 'action' => 'deleteip', $chatHistory['IpBlock']['id'])); ?>
</td>
        </tr>
        <?php } ?>
		<?php if(count($blockIps)==0){?>
		<tr>
         <td colspan="8" align="center">No Block Ip available Yet.</td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>
</div>
