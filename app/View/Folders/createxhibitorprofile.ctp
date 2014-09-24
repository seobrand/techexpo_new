<?php //pr($this->request->data);?>
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
				  <?php echo $this->Form->input('ShowCompanyProfile.company_name',array('label'=>false,'div'=>false,'class'=>'smallTextB'));?>
                </li>
                <li>
                  <label>How many company badges will you need ?</label>
				  <?php echo $this->Form->input('ShowCompanyProfile.num_badges',array('label'=>false,'div'=>false,'class'=>'smallTextField','maxlength'=>'2'));?>
                </li>
                
                  
                 <li >
                  <label>How many representatives will be attending lunch?</label>
                  <div class="small_dropdown right_height" style="padding:0px 5px 6px 0px !important;">
                     <?php echo $this->Form->input('ShowCompanyProfile.num_lunch_tickets',array('label'=>false,'div'=>false,'class'=>'smallTextField','maxlength'=>'2'));?>
                    &nbsp;&nbsp;<br />
                    <br />
               Lunch is provided for up to 4 representatives for standard booths, and 8 representatives for platinum booths.<br />
                    </span></div>
                </li> 
                  
                  
                <li>
                  <label>Please indicate if you require electricity</label>
                  <div class="small_dropdown right_height" >
                    <?php echo $this->Form->input('ShowCompanyProfile.electricity',array('type'=>'select','options'=>array('y'=>'Yes','n'=>'No'),'label'=>false,'div'=>false));?>
                    &nbsp;&nbsp;<br />
                    <br />
                    Please note that there is an additional charge of $75 for electricity. The additional cost will be billed accordingly.<br />
                    </span></div>
                </li>
                <li>
                  <label>Please indicate if you require wifi.</label>
                  <div class="small_dropdown right_height">
                    <?php echo $this->Form->input('ShowCompanyProfile.phone',array('type'=>'select','options'=>array('y'=>'Yes','n'=>'No'),'label'=>false,'div'=>false));?>
                    &nbsp;&nbsp;<br />
                    <br />
                    Additional fees apply. Price varies with location, call us at 212.655.4505 ext. 225 for details.</span></div>
                </li>
                <li>
                  <label>Are you bringing a display booth?</label>
                  <div class="form_rt_col right_height">
                    <?php echo $this->Form->checkbox('ShowCompanyProfile.booth', array('value' => 'y')); ?>&nbsp;&nbsp;
                    check if you are bringing a booth</div>
                </li>
				<li>
                  <label>If you are bringing a booth, please enter its dimensions</label>
                  <div class="right_height" >
                    <?php echo $this->Form->input('ShowCompanyProfile.booth_size',array('label'=>false,'div'=>false,'class'=>'smallTextField'));?></div>
                </li>
				<li>
                  <label><!--Would you like a second booth at the show?--></label>
                  <div class="hint_content right_height"  >
                    <?php // echo $this->Form->input('ShowCompanyProfile.second_booth',array('type'=>'select','options'=>array('y'=>'Yes','n'=>'No'),'label'=>false,'div'=>false));?>
                   
                   If you would like a second table, contact Nancy Mathew at 212.655.4505 ext. 225 or email <a href="mailto:NMathew@TechExpoUSA.com"> NMathew@TechExpoUSA.com </a> <br />
                    </span></div>
                </li>
				<li>
                  <label><!--This is you company profile, which can be edited separately on your company profile page.--></label>
                  <div class="hint_content right_height" >
                  This is your main company profile and will be used for all events.
                    <!--This is your main company profile, which will be used for all show guides. If you wish to edit it, please visit your <?php // echo $this->Html->link("company profile page",array('controller'=>'employers','action'=>'editprofile'));?><br /><br />Remember to include contact information (fax, e-mail, web site address..etc) if you wish candidates to be able to contact you directly after the show (many candidates will take the show guide home with them and later apply for your positions if they didn't get to interview with you at the show).<br /><br />-->
					<?php // echo $this->request->data['Employer']['description'];?>
                    </span></div>
                </li>
              </ul>
            </div>
            <div class="man_resume_footer">
              <p>For special requests, please e-mail the <a href="">admin staff</a></p>
              <ul>
                <li>
				<?php echo $this->Form->input('ShowCompanyProfile.id',array('type'=>'hidden','value'=>$this->request->data['ShowCompanyProfile']['id']));?>
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
    <?php echo $this->element('partners');?>
  </div>
</div>
