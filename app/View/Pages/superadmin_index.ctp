<?php echo $this->element('admin-breadcrumbs',array('pageName'=>'page'));?>
<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<div class="title-pad">
  <div class="title">
    <h5>Pages</h5>
    <div class="search">
      <div class="button"> 
	  <?php echo $this->Form->create('Page', array('action'=>'index'));?>
	  
	   <?php echo $this->Form->input('search',array('label'=>'','value'=>$search,'class'=>'inputbox','div'=>false));?>
	   
       <?php $optionList =  array('content'=>'Content','doc_name'=>'Document','title'=>'Title');
	   echo $this->Form->select('act',$optionList,array('empty'=>'Filter By','class'=>'selectbox1'));
	   ?>
        <?php $optionList =  array('no'=>'No','yes'=>'Yes');
	   echo $this->Form->select('active',$optionList,array('empty'=>'Active','class'=>'selectbox1'));
	   ?>
        <?php $optionList =  array('content'=>'Content','document'=>'Document');
	   echo $this->Form->select('page_type',$optionList,array('empty'=>'Page Type','class'=>'selectbox1'));
	   ?>
        <?php echo $this->Form->submit('Filter',array('class'=>'cursorclass ui-state-default ui-corner-all','id'=>'button41','div'=>false));?> <?php echo $this->Form->end();?> </div>
      <div class="input">
        <div class="button" style="margin-top:1px;"><?php echo $this->Form->create('Page', array('controller'=>'pages','action'=>'create'));?>
		 <?php echo $this->Html->link('<input type="submit" name="submit" value="Add New Page" class="cursorclass ui-state-default ui-corner-all"  />',array('controller'=>'pages','action'=>'create'),array('escape'=>false)); ?>
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
          <th width="4%" align="center"><?php echo $this->Paginator->sort('Page.id','#'); ?></th>
          <th width="20%" align="center"><?php echo $this->Paginator->sort('Page.title','Title'); ?></th>
          <th width="19%" align="center"><?php echo $this->Paginator->sort('Page.alias','Alias'); ?></th>
          <th width="17%" align="center">Content</th>
          <th width="17%" align="center"><?php echo $this->Paginator->sort('Page.doc_name','Document'); ?></th>
          <th width="5%" align="center"><?php echo $this->Paginator->sort('Page.active','Active'); ?></th>
          <th width="10%" align="center"><?php echo $this->Paginator->sort('Page.created','Date Created'); ?></th>
          <th width="8%" align="center"><a href="#">Action</a></th>
        </tr>
      </thead>
      <tbody>
        <?php
			$i=0;
		if(is_array($data) && count($data)) {
			foreach ($data as $record) {;?>
        <tr>
          <td align="center"><?php echo $record['Page']['id']; ?></td>
          <td align="left"><?php echo $record['Page']['title']; ?></td>
          <td align="left"><?php echo $record['Page']['alias']; ?></td>
        <?php if((isset($this->params['named']['page_type']) && $this->params['named']['page_type'] == 'document') || ($record['Page']['page_type'] == 'document' && !$record['Page']['content'])) { ?>		 
		  <td align="left">
		  <?php  } else {?>
		  <td align="left"><?php }?>
		  <?php $content =strip_tags($record['Page']['content']);		 
		  echo (strlen($content) > 20) ? substr($content,0,20).'...' : $content; ?></td>		  
		  <?php if(((isset($this->params['named']['page_type']) && $this->params['named']['page_type'] == 'content')) || ($record['Page']['page_type'] == 'content' && !$record['Page']['doc_name'])) {?> 
          <td align="left">
		  <?php } else {?>
          <td align="left"><?php }?>	
		  <?php echo ($record['Page']['doc_name']) ? $this->Html->link($record['Page']['doc_name'],FULL_BASE_URL.Router::url('/', false).'documents/'.$record['Page']['doc_name'],array('target'=>'_blank')) : ''; ?></td>	  
          <td align="center"><?php echo ucfirst($record['Page']['active']); ?></td>
          <td align="center"><?php echo date('d M Y',strtotime($record['Page']['created'])); ?></td>
          <td align="center">
		 <table width="100%" border="0">
		 <tr>
		 <td width="33%" style="padding:0px;border:none;" align="center">		  
		  <?php echo $this->Html->link($this->Html->image('zoom.png',array('alt'=>'View Page','width'=>16,'height'=>16,'title'=>'View Page')),array('action'=>'view', $record['Page']['id']), array('escape' => false));?></td>
		  <td width="33%" style="padding:0px;border:none;" align="center">
		  <?php echo $this->Html->link($this->Html->image('application_edit.png',array('alt'=>'Edit Page','width'=>16,'height'=>16,'title'=>'Edit Page')),array('action'=>'update', $record['Page']['id']), array('escape' => false));?></td>
		  
		 <td width="34%" style="padding:0px;border:none;" align="center"> 
		  <?php 		echo $this->Html->link($this->Html->image('cancel.png',array('alt'=>'delete','width'=>16,'height'=>16,'title'=>'Delete Page')),array('action'=>'delete', $record['Page']['id']),array('escape' => false),'Are you sure you wish to Delete this Page ?');		  ?></td></tr></table>
		  
		  
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