
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
                <p><strong>Michael's Resume Folders</strong>
                 </p>
              </div>
<p><strong>How to file resumes to your folders:</strong></p>

<ul class="list">
<li>You can create folders right below.</li>

<li>To populate folders with resumes, simply use the "file resume" function located at the top and bottom of each resume's detail page. </li>

<li>You can access a resume's detail page after performing a <a href="">resume search</a> or checking the results of your automatic job agents from your <a href="">JOB CENTER</a>. ("match" text links of each of your jobs)</li>

</ul>


 
 <br />

 <h2>Edit Folder</h2>
 
    <div class="gray_full_top"></div>
              <div class="gray_full_mid">
              <?php echo $this->Form->create(array('name'=>'resumeFolder','id'=>'resumeFolder'));?>
                <ul class="form_list manage_resume_form">
                  <li>
                    <label>Color:</label>
                    <div class="form_rt_col1">
                     <div class="even_reg_dropdown">
                        <?php echo $this->Form->input('icon_id',array('label'=>false,'options'=>$icon_list,'selected'=>$folderDt['icon_id'],'type'=>'select','div'=>false));?>
            
                      </div>
                     </div>
                  </li>
                  <li>
                    <label>Title:</label>
                    <div class="form_rt_col1">
                      <div class="form_rt_col1">
                   
                      <?php echo $this->Form->input('folder_descr',array('label'=>false,'class'=>'big237_textfield','div'=>false,'value'=>$folderDt['folder_descr']));?>
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
      <?php echo $this->element('partners');?>
    </div>
  </div>