<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Apply For a Job</h1>
          <div class="content"> <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
            <?php echo $this->Form->create('Candidates',array('controller'=>'candidates','action'=>'Jobseeker_jobApply?jobId='.$JobId)); ?>
              <ul class="form_list manage_resume_form">
               <li style="color:#FF0000">
               <?php echo $Error; ?>
               </li>
                <li>
                  <label>Select a Resume to send:</label>
                  <div class="form_rt_col1">
                    <div class="even_reg_dropdown">
                      <?php
                       echo $this->Form->input('ApplyHistory.resume_id',array('type'=>'select','options'=>$ResumeList,'empty'=>'-Select Resume-','label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                    </div>
                  </div>
                </li>
                <li>
                  <label>Type a message or
                  cover letter (optional):</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('ApplyHistory.notes',array('type'=>'textarea','div'=>false,'label'=>false,'class'=>'big_textarea'));
                    ?>
                  </div>
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1">
                  <?php
                   	echo $this->Form->input('ApplyHistory.SUBMIT',array('value'=>'SUBMIT','type'=>'hidden','div'=>false,'label'=>false));
                    echo $this->Form->submit('images/submit_btn.jpg');
                   ?> </div>
                </li>
              </ul>
            <?php echo $this->Form->end(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>