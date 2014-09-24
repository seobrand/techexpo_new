
<div id="wrapper"> <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Resume Folder</h1>
          <div class="content">            
            <p><strong>How to file resumes to your folders:</strong></p>
            <ul class="list">
              <li>You can create folders right below.</li>
              <li>To populate folders with resumes, simply use the "file resume" function located at the top and bottom of each resume's detail page. </li>
              <li>You can access a resume's detail page after performing a <?php echo $this->Html->link('resume search', array('controller'=>'folders','action'=>'searchRegCandidate'),array('escape'=>false)); ?> or checking the results of your automatic job agents from your <?php echo $this->Html->link('JOB CENTER', array('controller'=>'employers','action'=>'joblists'),array('escape'=>false)); ?>. ("match" text links of each of your jobs)</li>
            </ul>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <thead>
                <tr class="tableHead">
                  <th  width="10%">Folder</th>
                  <th  width="40%">Folder title</th>
                  <th  width="15%">Delete folder</th>
                  <th  width="10%">Delete</th>
                  <th  width="10%">Edit</th>
                  <th  width="15%" class="last">Download</th>
            	</tr>
               </thead>
           <tbody>
            <?php $i=1; foreach($folder_data as $folder_data) { ?>
             <tr  class="<?php if($i%2=='0') {?>tablebody<?php }else { ?>tablebody2<?php } ?> border_bottom">
                    <td  width="77"><?php //echo $this->Html->image("images/folder.png",array('alt'=>''));
	 echo $this->Html->image($this->requestAction('/folders/iconname/'.$folder_data['Folder']['icon_id']),array('alt'=>''));    ?></td>
                    <td  width="87"><?php echo $this->Html->link($folder_data['Folder']['folder_descr'].'('.count($folder_data['FolderContent']).')', array('controller'=>'folders','action'=>'folderContent',$folder_data['Folder']['folder_id']),array('escape'=>false)); ?></td>
                    <td  width="77"><?php echo $this->Html->link($this->Html->image("images/folder_delete.png"), array('controller'=>'folders','action'=>'deletefolder',$folder_data['Folder']['folder_id']),array('escape'=>false,'confirm' => 'Are you sure to delete folder?','class'=>'a-state-default')); ?> </td>
                    <td  width="77"><?php echo $this->Html->link($this->Html->image("images/delete (1).png"), array('controller'=>'folders','action'=>'emptyfolder',$folder_data['Folder']['folder_id']),array('escape'=>false,'confirm' => 'Are you sure to empty folder?','class'=>'a-state-default')); ?> </td>
                    <td  width="67"><?php echo $this->Html->link($this->Html->image("images/pencil.png"), array('controller'=>'folders','action'=>'editfolder',$folder_data['Folder']['folder_id']),array('escape'=>false)); ?> </td>
                    <td  width="77" class="last"><?php echo $this->Html->link($this->Html->image("images/excel.png"), array('controller'=>'folders','action'=>'export',$folder_data['Folder']['folder_id']),array('escape'=>false)); ?> </td>
            </tr>
            <?php $i++; } ?>
            </tbody>
            </table>
            <br />
            <h2>Create a New Folder</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid"> <?php echo $this->Form->create('Folder',array('name'=>'resumeFolder','id'=>'resumeFolder'));?>
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Color:</label>
                  <div class="form_rt_col1">
                    <div class="dropdown even_reg_dropdown"> <?php echo $this->Form->input('icon_id',array('label'=>false,'options'=>$icon_list,'type'=>'select','div'=>false));?> </div>
                  </div>
                </li>
                <li>
                  <label>Title:</label>
                  <div class="form_rt_col1">
                    <div class="form_rt_col1"> <?php echo $this->Form->input('folder_descr',array('label'=>false,'class'=>'smallTextB','div'=>false,'onkeypress'=>"return allowNoAlpha(event);"));?>
                      <div style="color:#FF0000;clear:both" > <?php echo $folderExistsError; ?> </div>
                    </div>
                  </div>
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->submit('images/grey_submit.jpg',array('div'=>false,'name'=>'Submit'));?> </div>
                </li>
              </ul>
              <?php echo $this->Form->end();?> </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?> </div>
</div>
