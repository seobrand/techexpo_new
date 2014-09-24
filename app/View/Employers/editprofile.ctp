<?php
echo $this->element('numberformat', array('cache' => true));
 echo $this->element('ajax', array('cache' => true)); ?>
  <script src="<?php echo FULL_BASE_URL.router::url('/',false)?>/js/front_js/jquery.autotab-1.1b.js" type="text/javascript"></script>
    <script type="text/javascript">
	$(document).ready(function() {
	    $('#EmployerEmployerName,#main_phone1,#main_phone2,#main_phone3,#main_phone4,#mobile_phone1,#mobile_phone2,#mobile_phone3').autotab_magic();
	});
	</script>
<div id="wrapper"> <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Company Profile</h1>
          <div class="content">
            <p><strong>Update <?php echo $this->Session->read('Auth.Client.employerContact.contact_name');?>'s company profile</strong></p>
            <br />
            <div class="gray_full_top"></div>
			<?php echo $this->Form->create(array('name'=>'empProfile','id'=>'empProfile'));?>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Company Name:</label>
                  <div class="form_rt_col1">
				  <?php echo $this->Form->input('Employer.employer_name',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Main Phone:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1">
                
                    <?php echo $this->Form->input('Employer.main_phone1',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'main_phone1','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> -
                    <?php echo $this->Form->input('Employer.main_phone2',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'main_phone2','style'=>"width:42px;;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> -
                    <?php echo $this->Form->input('Employer.main_phone3',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>4,'id'=>'main_phone3','style'=>"width:42px;;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> ext.
                    <?php echo $this->Form->input('Employer.main_phone4',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'main_phone4','style'=>"width:42px;;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?>
                    <?php echo $this->Form->input('Employer.main_phone',array('label'=>false,'div'=>false,'class'=>'big237_textfield','id'=>'phonenumber','style'=>'display:none;height:23px;','onkeypress'=>"return isNumericKey(event);"));?>
                    
                  </div>
                </li>
               
                  <li>
                  <label>Mobile Phone:</label>
                  <div class="form_rt_col1">
                  	<?php echo $this->Form->input('Employer.mobile_phone1',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'mobile_phone1','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> -
                    <?php echo $this->Form->input('Employer.mobile_phone2',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'mobile_phone2','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> -
                    <?php echo $this->Form->input('Employer.mobile_phone3',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>4,'id'=>'mobile_phone3','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?>&nbsp;(optional) 
                   
                   <?php echo $this->Form->input('Employer.mobile_phone',array('label'=>false,'div'=>false,'id'=>'mobilenumber','class'=>'big237_textfield','style'=>'display:none;height:23px;','onkeypress'=>"return isNumericKey(event);"));?> <br/>
                    </div>
                </li>
                
                <!--<li>
                  <label>Mobile Phone:</label>
                  <div class="form_rt_col1">
                  	<?php echo $this->Form->input('Employer.mobile_phone1',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'mobile_phone1','style'=>"width:68px;height:23px;"));?> -
                    <?php echo $this->Form->input('Employer.mobile_phone2',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'mobile_phone2','style'=>"width:68px;height:23px;"));?> -
                    <?php echo $this->Form->input('Employer.mobile_phone3',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>4,'id'=>'mobile_phone3','style'=>"width:68px;height:23px;"));?> 
                   
                   <?php echo $this->Form->input('Employer.mobile_phone',array('label'=>false,'div'=>false,'id'=>'mobilenumber','class'=>'big237_textfield','style'=>'display:none;height:25px;'));?> <br/>
                    </div>
                </li>-->
                
                <li>
                  <label>Fax:</label>
                  <div class="form_rt_col1">
                  	<?php echo $this->Form->input('Employer.fax1',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'mobile_phone1','style'=>"width:42px;height:23px;"));?> -
                    <?php echo $this->Form->input('Employer.fax2',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'mobile_phone2','style'=>"width:42px;height:23px;"));?> -
                    <?php echo $this->Form->input('Employer.fax3',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>4,'id'=>'mobile_phone3','style'=>"width:42px;height:23px;"));?>&nbsp;(optional) 
                   <?php echo $this->Form->input('Employer.fax',array('label'=>false,'div'=>false,'id'=>'mobilenumber','class'=>'big237_textfield','style'=>'display:none;height:23px;'));?> <br/>
                    </div>
                </li>
                
                <!--<li>
                  <label>Fax:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.fax',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>-->
                
                <li>
                  <label>Address:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.address',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
               <!-- <li>
                  <label>City:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.city',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>-->
                <li>
                  <label>City:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1" id="cityDiv"> 
				  
				  <div >
  <?php 
                       // class="dropdown_237" echo $this->Form->input('Employer.city',array('type'=>'select','options'=>$cityList,'empty'=>'-Select City-','label'=>false,'class'=>'select1','div'=>''));
                        ?>
</div>
				  <?php
				   
				  echo $this->Form->input('Employer.city',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  
                  </div>
                </li>
                
                <li>
                  <label>State:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1">
                    <?php //echo $this->Form->input('Employer.state',array('label'=>false,'div'=>false,'class'=>'big237_textfield','onChange'=>'onChangeAjaxGet("'.FULL_BASE_URL.router::url('/',false).'employers/city/",this.value,"cityDiv")'));?>
                    
                    <div class="dropdown_237" style="margin:0 0 3px 0;"> 
                      <?php 
					   $statList= $common->getStateList();;
                      //  echo $this->Form->input('Candidate.candidate_state',array('type'=>'select','options'=>$statList,'empty'=>'-Select State-','label'=>false,'class'=>'select1','div'=>''));
                     
					// echo $this->Form->input('Employer.state',array('type'=>'select','options'=>$statList,'empty'=>'-Select State-','label'=>false,'class'=>'select1','div'=>'','onChange'=>'onChangeAjaxGet("'.FULL_BASE_URL.router::url('/',false).'employers/city/",this.value,"cityDiv")'));
					
					 echo $this->Form->input('Employer.state',array('type'=>'select','options'=>$statList,'empty'=>'-Select State-','label'=>false,'class'=>'select1','div'=>'','style'=>'clear:both;margin-bottom:5px;'));
						
					    ?>
                    </div>
                    
                  </div>
                </li>
                
                
                <li>
                  <label>Zip:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.zip',array('label'=>false,'div'=>false,'class'=>'big237_textfield','onkeypress'=>"return isNumericKey(event);"));?>
                  </div>
                </li>
                <li>
                  <label>Company Website:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.url',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                
                <li>
                  <label>LinkedIn / Corporate Profile:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.linkedin',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                
                <li>
                  <label>My Personal LinkIn Profile:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.myprofile',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>
                
                <li>
                  <label>Company Facebook:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.facebook',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                
                
                
                <li>
                  <label>Stock Symbol:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.stock_symbol',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Annual Revenue:</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.annual_revenue',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Number of Employees:</label>
                  <div class="form_rt_col1">
                  
                       <?php echo $this->Form->input('Employer.number_of_employees',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                      <?php
					  /*  <div class="dropdown_resume1">
					 $employeeNUM=array('1 - 25'=>'1 - 25','25 - 100'=>'25 - 100','100 - 250'=>'100 - 250','250 - 500'=>'250 - 500','500 - 1000'=>'500 - 1000','1,000 - 5,000'=>'1,000 - 5,000','10,000 - 50,000'=>'10,000 - 50,000','50,000+'=>'50,000+');
					 
					   echo $this->Form->input('Employer.number_of_employees',array('type'=>'select','options'=>$employeeNUM,'label'=>false,'div'=>false,'class'=>'big237_textfield'));
				   </div>	   */
					   ?>
                      <br />
                 
                    <p> <span class="instruction">To see an industry added to the list, <a href="mailto:info@techExpoUSA.com">click here</a>.</span></p>
                  </div>
                  <!--<div class="form_rt_col1">
                    <?php //echo $this->Form->input('Employer.number_of_employees',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>-->
                </li>
                <li>
                  <label>Do you occasionally sponsor H1-B visas ?</label>
                  <div class="form_rt_col1">
                    <?php echo $this->Form->input('Employer.visa_status',array('type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                  </div>
                </li>
                <li>
                  <label>Industry:</label>
                  <div class="form_rt_col1">
                    
                    <div class="checkbox_div checkbox_large_div"  style="height:100px">
                      <div class="checkbox_list" style="height:100px">
                        <?php 
						 if(isset($this->request->data['Employer']['employer_type_code']))
		   $selected = explode(',',$this->request->data['Employer']['employer_type_code']);
		   else
		   $selected = '';
							 echo $this->Form->input('Employer.employer_type_code',array('type'=>'select','multiple'=>'checkbox','options'=>$industryList,'label'=>false,'div'=>false,'hiddenField' => false,'class'=>'big237_textfield', 'selected' => $selected)); 
						   ?>
                      </div>
                    </div>
                    <p> <span class="instruction">To see an industry added to the list, <a href="mailto:info@techExpoUSA.com">click here</a>.</span></p>
                  </div>
                </li>
                <li>
                  <label>Company Profile:</label>
                  <div class="form_rt_col1">
				  <?php echo $this->Form->input('Employer.description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'big_textarea','style'=>'height:160px !important;'));?>
                    <br />
                    <p> <strong>IMPORTANT NOTE: </strong><span class="instruction">This is your MAIN company profile, which is then automatically used as a template for all event profiles.</span></p>
                  </div>
                </li>
              </ul>
            </div>
            <div class="man_resume_footer padding_right_none">
             <!-- <p>Please enter text as shown in image below:</p>-->
              <ul>
                <li class="last">
				<?php echo $this->Form->submit('images/update-profile.jpg',array('div'=>false,'name'=>'Submit'));?>
                </li>
              <!--  <li><?php echo $this->Form->input('Employer.captcha',array('autocomplete'=>'off','value'=>'','label'=>false,'class'=>'security_txt','div'=>false)); ?>                 
                </li>
                <li ><?php echo $this->Html->image($this->Html->url(array('action'=>'captcha'), true),array('style'=>'','vspace'=>2)); ?></li>-->
              </ul>
              <div class="clear"></div>
            </div>
			<?php echo $this->Form->input('Employer.id',array('type'=>'hidden','value'=>$this->request->data['Employer']['id']));?>
			<?php echo $this->Form->end();?>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?> </div>
</div>
