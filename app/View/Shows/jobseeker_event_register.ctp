<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Event Registration Center</h1>
            <div class="content">
              <?php echo $this->element('jobseekerNameBar', array('cache' => true)); ?>
              <div class="gray_full_top"></div>
               <?php echo $this->Form->create('Show',array('action'=>'eventRegister', 'enctype' => 'multipart/form-data')); ?>
            	  <div class="gray_full_mid">
                <ul class="form_list manage_resume_form">
                  <li>
                    <label>Select which TECHEXPO event you
would like to pre-register for:</label>
                    <div class="form_rt_col1">
                      <div class="even_reg_dropdown15">
                                                
                         <?php 
                        echo $this->Form->input('Registration.show_id',array('type'=>'select','options'=>$showListArray,'empty'=>'- Select Event -','label'=>false,'div'=>'','style'=>'padding-bottom:5px;'));
                        ?>
                      </div>
                      <br />
                        <br />
                        
                      (<strong>Note:</strong> <span class="instruction">online pre-registration for an event closes at 11 PM (EST) on the evening before the event. If an event's registration is closed, you will be notified on the next screen, and you may just come to the event and register there in person.</span>)</div>
                  </li>
                  <li>
                    <label>How did you hear about this event? :</label>
                    <div class="form_rt_col1">
                      <div class="even_reg_dropdown15">
                                                
                         <?php 
                        echo $this->Form->input('Registration.hear_about',array('class'=>'smallTextB','label'=>false,'div'=>'','style'=>'padding-bottom:5px;'));
                        ?>
                      </div>
                      </div>
                  </li>
                  <li>
                    <label></label>
                    <div class="form_rt_col1">
                    <?php echo $this->Form->input('Registration.Submit',array('type'=>'hidden','div'=>false,'label'=>false,'value'=>'Register')); ?> 
                      <?php echo $this->Form->input('Registration.candidate_id',array('type'=>'hidden','div'=>false,'label'=>false)); ?> 
                      <?php echo $this->Form->submit('images/continue.png');?>

                    </div>
                  </li>
                </ul>
              </div>
              <?php echo $this->Form->input('Registration.referer_url',array('type'=>'hidden','value'=>$referer_url));?>
              <?php echo $this->Form->end();?>
            </div>
          </div>
        </div>
      </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>