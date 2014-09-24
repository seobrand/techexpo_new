<?php echo $this->element('ajax', array('cache' => true)); ?>
<div id="wrapper"> <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Personal Contact Information</h1>
          <div class="content">
            <p><strong><?php echo $this->Session->read('Auth.Client.employerContact.contact_name');?>, update your personal contact information and profile</strong><br />
              (Your contact info and e-mail are confidential and will not be revealed to candidates)<br />
            </p>
            <br />
            <div class="gray_full_top"></div>
            <?php echo $this->Form->create(array('name'=>'empPersonalInfo','id'=>'empPersonalInfo'));?>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Name:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('EmployerContact.contact_name',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Title:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('EmployerContact.contact_title',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Phone:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('EmployerContact.contact_phone',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Fax:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('EmployerContact.contact_fax',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Email for critical TECHEXPO
                  messages & announcements <span class="instruction">(please enter your real e-mail, no general mailboxes or auto-responders</span>:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('EmployerContact.contact_email',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                    <br />
                    <p><span class="instruction">To have several recipients, simply enter several e-mail addresses, separated by commas.<br />
                      <strong>Example:</strong> joe@mycompany.com,tom@mycompany.com</span></p>
                  </div>
                </li>
                <li>
                  <label>Email for candidates <span class="instruction">(where resumes are to be sent). Please note that this e-mail address is never revealed to candidates</span>:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('EmployerContact.contact_email_job',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                    <br />
                    <p><span class="instruction">To have several recipients, simply enter several e-mail addresses, separated by commas.<br />
                      <strong> Example:</strong> joe@mycompany.com,tom@mycompany.com</span></p>
                  </div>
                </li>
                <li>
                  <label>Address:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('EmployerContact.contact_address',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>City:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('EmployerContact.contact_city',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  <!--  <div class="form_rt_col1" id="cityDiv"> 
				  
				  <div class="dropdown_237">
  <?php 
                        echo $this->Form->input('EmployerContact.contact_city',array('type'=>'select','options'=>$cityList,'empty'=>'-Select City-','label'=>false,'class'=>'select1','div'=>''));
                        ?>
</div>
				  </div>-->
                  </div>
                </li>
                
                <li>
                  <label>State:</label>
                  <div class="form_rt_col1">
                    <div class="dropdown_237">
                      <?php 
					    $statList= $common->getStateList();;
                    //	echo $this->Form->input('EmployerContact.contact_state',array('type'=>'select','options'=>$statList,'empty'=>'-Select State-','label'=>false,'class'=>'select1','div'=>'','onChange'=>'onChangeAjaxGet("'.FULL_BASE_URL.router::url('/',false).'employers/empcotactcity/",this.value,"cityDiv")'));
					
						echo $this->Form->input('EmployerContact.contact_state',array('type'=>'select','options'=>$statList,'empty'=>'-Select State-','label'=>false,'class'=>'select1','div'=>''));
					 ?>
                     
                    </div>
                 
                  </div>
                </li>
                
                
                <li>
                  <label>Zip:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('EmployerContact.contact_zip',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Username:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('User.username',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Password:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('User.password',array('type'=>'password','label'=>false,'value'=>'','div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Confirm Password:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('User.confirmpassword',array('type'=>'password','label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
				<li>
				<?php echo $this->Form->input('User.id',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$this->request->data['User']['id']));?>
                    <?php echo $this->Form->input('User.currentusername',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$this->request->data['User']['username']));?>
					<?php echo $this->Form->input('User.currentpassword',array('type'=>'hidden','label'=>false,'div'=>false,'value'=>$this->request->data['User']['password']));?>
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->submit('images/submit_btn.jpg',array('div'=>false,'name'=>'Submit'));?>
                  </div>
                </li>
              </ul>
            </div>
			<?php echo $this->Form->input('EmployerContact.id',array('type'=>'hidden','value'=>$this->request->data['EmployerContact']['id']));?>
            <?php echo $this->Form->end();?> </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?> </div>
</div>
