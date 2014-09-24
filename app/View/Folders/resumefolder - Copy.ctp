
  <div id="wrapper">
<?php echo $this->element('employer_tabs');?>
    <div id="container">
    
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Resume Folder</h1>
            <div class="content">
              <div class="jobseeker_info">
                <p><strong><?php  echo $this->Session->read('Auth.Client.employerContact.contact_name');?>'s Resume Folders</strong>
                 </p>
              </div>
<p><strong>How to file resumes to your folders:</strong></p>

<ul class="list">
<li>You can create folders right below.</li>

<li>To populate folders with resumes, simply use the "file resume" function located at the top and bottom of each resume's detail page. </li>

<li>You can access a resume's detail page after performing a <a href="">resume search</a> or checking the results of your automatic job agents from your <a href="">JOB CENTER</a>. ("match" text links of each of your jobs)</li>

</ul>

<table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
    
   
   <tr>
   <td class="table_row table_heading">
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <th  width="77">Folder</th>
     <th  width="87">Resume title</th>
     <th  width="77">Delete folder</th>
     <th  width="77">Delete</th>
     <th  width="67">Edit</th>
     <th  width="77" class="last">Upload</th>
      </tr>
    </table>
    </td>
   </tr>
   
     <?php $i=1; foreach($folder_data as $folder_data) { ?>
   <tr>
   <td class="table_row <?php if($i%2=='0') echo "alternate";  ?>">
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td  width="77"><?php //echo $this->Html->image("images/folder.png",array('alt'=>''));
	 echo $this->Html->image($this->requestAction('/folders/iconname/'.$folder_data['Folder']['icon_id']),array('alt'=>''));    ?></td>
     <td  width="87"><?php echo $this->Html->link($folder_data['Folder']['folder_descr'].'('.count($folder_data['FolderContent']).')', array('controller'=>'folders','action'=>'folderContent',$folder_data['Folder']['folder_id']),array('escape'=>false)); ?></td>
     <td  width="77">
     <?php echo $this->Html->link($this->Html->image("images/folder_delete.png"), array('controller'=>'folders','action'=>'deletefolder',$folder_data['Folder']['folder_id']),array('escape'=>false,'confirm' => 'Are you sure to delete folder?','class'=>'a-state-default')); ?>
      
     </td>
     <td  width="77">
     <?php echo $this->Html->link($this->Html->image("images/delete (1).png"), array('controller'=>'folders','action'=>'emptyfolder',$folder_data['Folder']['folder_id']),array('escape'=>false,'confirm' => 'Are you sure to empty folder?','class'=>'a-state-default')); ?>
     </td>
     <td  width="67">
     <?php echo $this->Html->link($this->Html->image("images/pencil.png"), array('controller'=>'folders','action'=>'editfolder',$folder_data['Folder']['folder_id']),array('escape'=>false)); ?>
     </td>
     <td  width="77" class="last">
     <?php echo $this->Html->link($this->Html->image("images/excel.png"), array('controller'=>'folders','action'=>'export',$folder_data['Folder']['folder_id']),array('escape'=>false)); ?>
     </td>
      </tr>
      
    </table>
    </td>
   </tr>
	<?php $i++; } ?>   
   
    
   

 </table>
 
 <br />

 <h2>Create a New Folder</h2>
 
    <div class="gray_full_top"></div>
              <div class="gray_full_mid">
              <?php echo $this->Form->create('Folder',array('name'=>'resumeFolder','id'=>'resumeFolder'));?>
                <ul class="form_list manage_resume_form">
                  <li>
                    <label>Color:</label>
                    <div class="form_rt_col1">
                     <div class="even_reg_dropdown">
                        <?php echo $this->Form->input('icon_id',array('label'=>false,'options'=>$icon_list,'type'=>'select','div'=>false));?>
            
                      </div>
                     </div>
                  </li>
                  <li>
                    <label>Title:</label>
                    <div class="form_rt_col1">
                      <div class="form_rt_col1">
                   
                      <?php echo $this->Form->input('folder_descr',array('label'=>false,'class'=>'big237_textfield','div'=>false));?>
                     </div>
                     </div>
                  </li>
       
                  
                  <li>
                    <label></label>
                    <div class="form_rt_col1">
                    
                     <?php echo $this->Form->submit('images/grey_submit.jpg',array('div'=>false,'name'=>'Submit'));?>
                
                     </div>
                  </li>
                  
                </ul>
                <?php echo $this->Form->end();?>
                
              </div>
              
            </div>
          </div>
        </div>
      </div>
      
   <?php echo $this->element('employer_left_panel'); ?>
      <div class="clear"></div>
      <?php echo $this->element('scroll_panel');?>
    </div>
  </div>