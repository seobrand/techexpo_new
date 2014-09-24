<div id="wrapper">
    
    
    <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
    <div id="container">
    

      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Email Resume</h1>
            <div class="content">
              
            
<br />

              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
                
          
<?php echo $this->Form->create('Folder',array('name'=>'resumeFolder','id'=>'resumeFolder','action'=>'mailResume/'.$resume_id.'/sendresume/'));?>
                
                <ul class="form_list manage_resume_form">
                  <li>
                    <label>	
Send this resume to the following e-mail address:</label>
                    <div class="form_rt_col1">
                
                       <?php echo $this->Form->input('email',array('label'=>false,'class'=>'big237_textfield','div'=>false));?>
                      </div>
                  </li>
                  
                
                  <li>
                    <label>Type a short message:</label>
                    <div class="form_rt_col1">
                                      <?php echo $this->Form->input('mailnotes',array('type'=>'textarea','label'=>false,'class'=>'textarea_237 textarea_220','div'=>false,'style'=>'width:226px;'));?>  
                      
                    </div>
                  </li>
                  <li>
                    <label></label>
                    <div class="form_rt_col1">
               
                         <?php echo $this->Form->submit('images/submit_btn.jpg',array('div'=>false,'name'=>'Submit'));?>
                    </div>
                  </li>
                </ul>
                 <?php echo $this->Form->end();?> 
               

              </div>
              
            </div>
          </div>
        </div>
      </div>
      
  <?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>
























<?php /*



<div id="wrapper"> <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Email to Candidate</h1>
          <div class="content"> <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <h2 class="mana_subheading">Short Decsription:</h2>
              <?php echo $this->Form->create('folders',array('controller'=>'folders','action'=>'sendEmailToCandidate')); ?>
              <ul class="form_list manage_resume_form">
                
                <li>
                  <label>Candidate's<br />
                  e-mail:</label>
                  <div class="form_rt_col1">
                    <?php 
                   
                    echo $this->Form->input('candidate_email',array('div'=>false,'label'=>false,'value'=> $candidate_email,'class'=>'big237_textfield'));
                    ?>
                  </div>
                </li>
                <li>
                  <label>Type a short message<br />
                  to send to your friend:</label>
                  <div class="form_rt_col1">
                   <?php echo $this->Form->input('message',array('type'=>'textarea','div'=>false,'label'=>false,'class'=>'textarea_237 textarea_220'));
                    ?>
                  </div>
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1">
                    <?php
                   	echo $this->Form->input('Resume.SUBMIT',array('value'=>'SUBMIT','type'=>'hidden','div'=>false,'label'=>false));
                    echo $this->Form->submit('images/submit_btn.jpg');
                   ?>
                  </div>
                </li>
              </ul>
              <?php echo $this->end(); ?> </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>


*/ ?>