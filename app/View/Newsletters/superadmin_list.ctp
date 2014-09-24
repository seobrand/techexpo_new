<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'newsletter-list')); ?>
<?php /*?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">NewsLetter List</div>      
      <div style="float:right;font-weight:bold;"></div>      
    </h5>
  </div>
  <?php //echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add New Set" name="assign">',array('controller'=>'sets','action'=>'add'),array('escape'=>false)); ?>
</div>
<?php */?>
<div class="display_row">
  <div class="table">
  <br/>
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <thead>
        <tr>
          <th width="80%" align="left" valign="middle"> NewLetter Title  </th>
		  <th width="20%" align="center" valign="middle"> Active </th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($newsletters as $newsletter){
			$tick_image = ($newsletter['Newsletter']['active']==1) ? '<img src="img/tick.png" alt="Active">' : "";
	  	
	  	?>
        <tr>
          	<td align="left"><?php echo $this->Html->link($newsletter['Newsletter']['newsletter_title'],array('controller' => 'newsletters', 'action' => 'manage', $newsletter['Newsletter']['id'])); ?></td>
	  		<td align="center">
	  		<?php if($newsletter['Newsletter']['active']==1){
	  			echo $this->Html->image("tick.png", array("alt" => "Active"));
	  		 }?>
	  		</td>
        </tr>
        <?php } ?>
		<?php if(count($newsletters)==0){?>
		<tr>
         <td colspan="2" align="center">No Newsletter exist.</td>
        </tr>
		<?php } ?>		
      </tbody>
    </table>
    <div style="margin-top: 10px;"><?php echo $this->Html->link('<input type="submit" class="cursorclass ui-state-default ui-corner-all" value="Add New Newsletter" name="add_newsletter">',array('controller'=>'newsletters','action'=>'manage'),array('escape'=>false)); ?></div>
  </div>
</div>
