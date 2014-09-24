<div id="wrapper">
  <?php if($this->Session->read('Auth.Client.User.user_type')=='E'):?>
  <?php echo $this->element('employer_tabs');?>
  <?php endif;?>
   <?php
	if($this->Session->read('Auth.Client.Candidate.id')!='')
	{
		echo $this->element('jobSeekerMenu', array('cache' => true));
	}
	 ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Email Job To A Friend</h1>
          <div class="content"> <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <h2 class="mana_subheading"><strong>Short Description</strong> : <?php echo $jobdetail['JobPosting']['short_descr'];?></h2><br/>
              <?php echo $this->Form->create();?>
			  <ul class="form_list manage_resume_form">
                <li>
                  <label> Enter your e-mail:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('JobPosting.yourEmail',array('label'=>false,'div'=>false,'class'=>'big237_textfield','style'=>'width:228px!important;'));?>
                  </div>
                </li>
                <li>
                  <label>Enter your friend's<br />
                  e-mail:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('JobPosting.friendEmail',array('maxlength'=>'255','label'=>false,'div'=>false,'class'=>'big237_textfield','style'=>'width:228px!important;'));?>
                    <br />
                    <span class="instruction"> To send this job to several e-mail addresses at once, simply enter multiple addresses in this field, separated by commas (no space after comma). 255 character limit.</span> </div>
                </li>
                <li>
                  <label>Type a short message<br />
                  to send to your friend:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('JobPosting.emailMessage',array('type'=>'textarea','label'=>false,'div'=>false,'style'=>'width:226px;','class'=>'textarea_237 textarea_220'));?>
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
    <?php 
		 if($this->Session->read('Auth.Client.Candidate.id')!='')
			{
				echo $this->element('jobSeekerSidebar', array('cache' => true)); 
				
			}elseif($this->Session->read('Auth.Client.employerContact.id')!='')
			{
				echo $this->element('employer_left_panel');
			}else
			{
				echo $this->element('main_login_leftbar', array('cache' => true)); 
       			echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); 
			}
	   ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?>
  </div>
</div>
