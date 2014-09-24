<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'news'));?>
<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<div class="title-pad">
  <div class="title">
    <h5>News</h5>
    <div class="search">
      <div class="button"> 
	  <?php echo $this->Form->create('News', array('action'=>'index'));?>
	  
	   <?php echo $this->Form->input('search',array('label'=>'','value'=>$search,'class'=>'inputbox','div'=>false));?>
        <?php $optionList =  array('no'=>'No','yes'=>'Yes');
	   echo $this->Form->select('active',$optionList,array('empty'=>'Active','class'=>'selectbox1'));
	   ?>	   
        <?php echo $this->Form->submit('Filter',array('class'=>'cursorclass ui-state-default ui-corner-all','id'=>'button41','div'=>false));?> <?php echo $this->Form->end();?> </div>
      <div class="input">
        <div class="button" style="margin-top:1px;"><?php echo $this->Form->create('News', array('controller'=>'news','action'=>'create'));?>
		 <?php echo $this->Html->link('<input type="submit" name="submit" value="Add News" class="cursorclass ui-state-default ui-corner-all"  />',array('controller'=>'news','action'=>'create'),array('escape'=>false)); ?>
		<?php echo $this->Form->end();?> 
		</div>			
      </div>
    </div>
  </div>
</div>
<!-- end box / title -->
<!-- display box / first -->
<div class="display_row">
  <div class="table">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
      <thead>
        <tr>
          <th width="4%" align="center"><?php echo $this->Paginator->sort('News.id','#'); ?></th>
          <th width="22%" align="center"><?php echo $this->Paginator->sort('News.title','Title'); ?></th>
          <th width="26%" align="center">Content</th>
          <th width="16%" align="center"><?php echo $this->Paginator->sort('News.publish','Publish'); ?></th>		  
          <th width="16%" align="center"><?php echo $this->Paginator->sort('News.expire','Expire'); ?></th>
          <th width="8%" align="center"><?php echo $this->Paginator->sort('News.active','Active'); ?></th>		  
          <th width="8%" align="center"><a href="#">Action</a></th>
        </tr>
      </thead>
      <tbody>
        <?php
			$i=0;
		if(is_array($data) && count($data)) {
			foreach ($data as $record) {;?>
        <tr>
          <td align="center"><?php echo $record['News']['id']; ?></td>
          <td align="left"><?php echo $record['News']['title']; ?></td>
		  <td align="left"><?php $content =strip_tags($record['News']['description']);		 
		  echo (strlen($content) > 20) ? substr($content,0,20).'...' : $content; ?></td>  	  
          <td align="center"><?php echo date(DATE_FORMAT,strtotime($record['News']['publish'])); ?></td>
          <td align="center"><?php echo date(DATE_FORMAT,strtotime($record['News']['expire'])); ?></td>	
          <td align="center"><?php echo ucfirst($record['News']['active']); ?></td>			  	  
          <td align="center">
		  <table width="100%" border="0">
		 <tr>
		 <td width="33%" style="padding:0px;border:none;" align="center">
		  <?php echo $this->Html->link($this->Html->image('zoom.png',array('alt'=>'View News','width'=>16,'height'=>16,'title'=>'View News')),array('action'=>'view', $record['News']['id']), array('escape' => false));?></td>
		  <td width="33%" style="padding:0px;border:none;" align="center">
		  <?php echo $this->Html->link($this->Html->image('application_edit.png',array('alt'=>'Edit News','width'=>16,'height'=>16,'title'=>'Edit News')),array('action'=>'update', $record['News']['id']), array('escape' => false));?></td>
		  <td width="34%" style="padding:0px;border:none;" align="center">
		  <?php 		echo $this->Html->link($this->Html->image('cancel.png',array('alt'=>'delete','width'=>16,'height'=>16,'title'=>'Delete News')),array('action'=>'delete', $record['News']['id']),array('escape' => false),'Are you sure you wish to Delete this News ?');?>
		  </td></tr></table>
		  
		  
		  </td>
		  
		  
		  
        </tr>
        <?php $i++;
			} ?>
			      </tbody>
    </table>
  </div>
</div>
<!-- display box / first end here -->
<div style="clear:both">
  <div class="title-pad"> <?php echo $this->element('admin-paging');?> </div>
</div>
			<?php
		}
		else  { ?>
        <tr>
          <td colspan="9" align="center">No records found.</td>
        </tr>			      </tbody>
    </table>
  </div>
</div>
<?php } ?>