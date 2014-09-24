<?php  
 echo $this->element('admin-breadcrumbs',array('pageName'=>'adminclient'));
 $this->set('title_for_layout', 'Clients List');
 
?>
<?php $this->Paginator->options(array('url'=>array_merge($argArr,$this->passedArgs)));?>
<div class="title-pad">
  <div class="title">
    <h5>Client List</h5>
    <div class="search">
      <div class="button">  
	   <?php echo $this->Form->create('Adminclient', array('action'=>'index'));?> 

	   				<?php echo $this->Form->input('search',array('label'=>'','value'=>$search,'class'=>'inputbox','div'=>false));?>
 
       				<?php $optionList =  array('company_name'=>'Company Name','email'=>'Email','name'=>'Name');
	  				 //echo $this->Form->select('act',$optionList,$act,array('empty'=>'Filter By','class'=>'selectbox1'));
                                         echo $this->Form->input('act',array('type'=>'select','options'=>$optionList,'empty'=>'Filter By','class'=>'selectbox1'))
                                         ?>	
                                         
     
	    <?php $optionList =  array('no'=>'No','yes'=>'Yes');
	   //echo $this->Form->select('active',$optionList,$active,array('empty'=>'Active','class'=>'selectbox1'));
           echo $this->Form->input('active',array('type'=>'select','options'=>$optionList,'empty'=>'Active','class'=>'selectbox1'))
           ?>
 
	   <?php /*$optionList =  array('temp'=>'Temp','perm'=>'Perm');
	   echo $this->Form->select('job_type',$optionList,$job_type,array('empty'=>'Job Type','class'=>'selectbox1'));*/?>   
       <?php echo $this->Form->submit('Filter',array('class'=>'cursorclass ui-state-default ui-corner-all','id'=>'button41','div'=>false));?><?php echo $this->Form->end();?>  
	   </div> 
	  <div class="input">
        <div class="button" style="margin-top:1px;">	
		<?php echo $this->Form->create('Adminclient', array('controller'=>'adminclients','action'=>'create'));?>
		 <?php echo $this->Html->link('<input type="submit" name="submit" value="Add New Client" class="cursorclass ui-state-default ui-corner-all"  />',array('controller'=>'adminclients','action'=>'create'),array('escape'=>false)); ?>		 
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
          <th width="6%" align="center"><?php echo $this->Paginator->sort('Adminclient.id','#'); ?></th>
          <th width="23%" align="center"><?php echo $this->Paginator->sort('Adminclient.full_name','Full Name'); ?></th>
          <th width="23%" align="center"><?php echo $this->Paginator->sort('Adminclient.company_name','Company Name'); ?></th>
          <th width="23%" align="center"><?php echo $this->Paginator->sort('Adminclient.email','Email ID'); ?></th>
          <th width="11%" align="center"><?php echo $this->Paginator->sort('Adminclient.created','Date Registered'); ?></th>
          <th width="5%" align="center"><?php echo $this->Paginator->sort('Adminclient.active','Active'); ?></th>
          <th width="9%" align="center"><a href="#">Action</a></th>
        </tr>
      </thead>
      <tbody>
        <?php 
			$i=0;
		if(is_array($data) && count($data)) {
			foreach ($data as $record) { ?>
        <tr>
          <td align="center"><?php echo $record['Adminclient']['id']; ?></td>
          <td align="left"><?php echo $record['Adminclient']['full_name']; ?></td>
          <td align="left"><?php echo $record['Adminclient']['company_name']; ?></td>
          <td align="left"><?php echo $record['Adminclient']['email']; ?></td>
	  <td align="center"><?php echo date(DATE_FORMAT,strtotime($record['Adminclient']['created'])); ?></td>
          <td align="center"><?php echo ucfirst($record['Adminclient']['active']); ?></td>          
          <td align="center">
		 <table width="100%" border="0">
		 <tr>
		 <td width="33%" style="padding:0px;border:none;" align="center">		  
		  <?php echo $this->Html->link($this->Html->image('zoom.png',array('alt'=>'View Client','width'=>16,'height'=>16,'title'=>'View Client')),array('action'=>'view', $record['Adminclient']['id']), array('escape' => false));?></td>
		  
		  <td width="33%" style="padding:0px;border:none;" align="center">
		  <?php echo $this->Html->link($this->Html->image('application_edit.png',array('alt'=>'Edit Client','width'=>16,'height'=>16,'title'=>'Edit Client')),array('action'=>'update', $record['Adminclient']['id']), array('escape' => false));?></td>
		  
		  <td width="34%" style="padding:0px;border:none;" align="center">
		  <?php 
		 
		  echo $this->Html->link($this->Html->image('cancel.png',array('alt'=>'delete','width'=>16,'height'=>16,'title'=>'Delete Client')),array('action'=>'delete', $record['Adminclient']['id']),array('escape' => false),'Are you sure you wish to Delete this Client ?');
		  ?>
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
          <td colspan="11" align="center">No records found.</td>
        </tr>			      </tbody>
    </table>
  </div>
</div>
<?php } ?>