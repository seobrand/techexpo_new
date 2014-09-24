<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Email to a Friend</h1>
          <div class="content"> <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <h2 class="mana_subheading">Short Description:</h2>
              <?php echo $this->Form->create('Candidate',array('controller'=>'candidates','action'=>'sendEmailToFriend?jobId='.$JobId)); ?>
              <ul class="form_list manage_resume_form">
                <li>
                  <label> Enter your e-mail:</label>
                  <div class="form_rt_col1">
                    <?php 
                    if(!empty($this->request->data['Candidate']['candidate_email']))
                    {
                    	$candidateEmail=$this->request->data['Candidate']['candidate_email'];
                    }else
                    {
                    	$candidateEmail=$candidateEmail;
                    }
                    echo $this->Form->input('candidate_email',array('div'=>false,'type'=>'text','label'=>false,'value'=>$candidateEmail,'class'=>'big237_textfield','style'=>'width:236px !important'));
                    ?>
                  </div>
                </li>
                <li>
                  <label>Enter your friend's<br />
                  e-mail:</label>
                  <div class="form_rt_col1">
                   
                    <?php echo $this->Form->input('candidate_friend_email',array('div'=>false,'label'=>false,'class'=>'big237_textfield','style'=>'width:233px !important')); ?>
                    <br />
                    <span class="instruction"> To send this job to several e-mail addresses at once, simply enter multiple addresses in this field, separated by commas (no space after comma). 255 character limit.</span> </div>
                </li>
                <li>
                  <label>Type a short message<br />
                  to send to your friend:</label>
                  <div class="form_rt_col1">
                   <?php echo $this->Form->input('message',array('type'=>'textarea','div'=>false,'label'=>false,'class'=>'big237_textfield','style'=>'width:233px !important'));
                    ?>
                  </div>
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1">
                    <?php
                   	echo $this->Form->input('Candidate.SUBMIT',array('value'=>'SUBMIT','type'=>'hidden','div'=>false,'label'=>false));
                    echo $this->Form->submit('images/submit_btn.jpg');
                   ?>
                  </div>
                </li>
              </ul>
              <?php echo $this->Form->end(); ?> </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>