<?php pr($this->request->data);die;?>
<div id="wrapper">
  <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Exibitors Profile</h1>
          <div class="content">
            <div class="jobseeker_info">
              <p>TECHEXPO Exhibitor Profile for Baltimore, MD on 09/20/2012</p>
            </div>
            <div class="gray_full_top"></div>
			<?php echo $this->Form->create(array('name'=>'exhibitorProfile','id'=>'exhibitorProfile'));?>
            <div class="gray_full_mid">
              <ul class="form_list">
                <li>
                  <label>Please enter your company name exactly as it should appear on your table sign</label>
				  <?php echo $this->Form->input('ShowCompnayProfile.company_name',array('label'=>false,'div'=>false,'class'=>'smallTextB'));?>
                </li>
                <li>
                  <label>How many company badges will you need ?</label>
				  <?php echo $this->Form->input('Employer.employer_name',array('label'=>false,'div'=>false,'class'=>'smallTextField'));?>
                </li>
                <li>
                  <label>How many representatives will be attending lunch?</label>
                  <?php echo $this->Form->input('Employer.employer_name',array('label'=>false,'div'=>false,'class'=>'smallTextField'));?>
                  <span style="font-size:11px; color:##3A3A3A;"> &nbsp;&nbsp;(Limit of 5 lunch tickets per <br />
                  &nbsp;&nbsp;exhibitor)</span></li>
                <li>
                  <label>Please indicate if you require electricity</label>
                  <div class="small_dropdown right_height" >
                    <?php echo $this->Form->input('Employer.visa_status',array('type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>false,'div'=>false));?>
                    &nbsp;&nbsp;<br />
                    <br />
                    Please note that there is an additional charge of $75 for electricity. The additional cost will be billed accordingly.<br />
                    </span></div>
                </li>
                <li>
                  <label>Please indicate if you require a phone / modem connection</label>
                  <div class="small_dropdown right_height">
                    <?php echo $this->Form->input('Employer.visa_status',array('type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>false,'div'=>false));?>
                    &nbsp;&nbsp;<br />
                    <br />
                    Please note that there is an additional charge of $150 (price varies with location, call us at 212.655.4505 ext. 225 for details). The additional cost will be billed accordingly.</span></div>
                </li>
                <li>
                  <label>Are you bringing a display booth?</label>
                  <div class="form_rt_col right_height">
                    <input name="" type="checkbox" value="" />
                    &nbsp;&nbsp;
                    check if you are bringing a booth</span></div>
                </li>
				<li>
                  <label>If you are bringing a booth, please enter its dimensions</label>
                  <div class="small_dropdown right_height" >
                    <?php echo $this->Form->input('Employer.visa_status',array('type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>false,'div'=>false));?>
                    &nbsp;&nbsp;<br />
                    <br />
                    Please note that there is an additional charge of $75 for electricity. The additional cost will be billed accordingly.<br />
                    </span></div>
                </li>
				<li>
                  <label>Would you like a second booth at the show?</label>
                  <div class="small_dropdown right_height" >
                    <?php echo $this->Form->input('Employer.visa_status',array('type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>false,'div'=>false));?>
                    &nbsp;&nbsp;<br />
                    <br />
                    Please note that there is an additional charge of $75 for electricity. The additional cost will be billed accordingly.<br />
                    </span></div>
                </li>
				<li>
                  <label>This is you company profile, which can be edited separately on your company profile page.</label>
                  <div class="small_dropdown right_height" >
                    <?php echo $this->Form->input('Employer.visa_status',array('type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>false,'div'=>false));?>
                    &nbsp;&nbsp;<br />
                    <br />
                    Please note that there is an additional charge of $75 for electricity. The additional cost will be billed accordingly.<br />
                    </span></div>
                </li>
              </ul>
            </div>
            <div class="man_resume_footer">
              <p>For special requests, please e-mail the <a href="">admin staff</a></p>
              <ul>
                <li>
				<?php echo $this->Form->submit('images/update.png',array('div'=>false,'name'=>'Submit'));?>
                </li>
              </ul>
              <div class="clear"></div>
            </div>
			<?php echo $this->Form->end();?>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('scroll_panel');?>
  </div>
</div>
