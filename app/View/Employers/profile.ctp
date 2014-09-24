<?php 
	echo $this->element('numberformat', array('cache' => true));
	echo $this->element('ajax', array('cache' => true)); ?>
   
    <script src="<?php echo FULL_BASE_URL.router::url('/',false)?>/js/front_js/jquery.autotab-1.1b.js" type="text/javascript"></script>
    <script type="text/javascript">
	$(document).ready(function() {
	    $('#EmployerEmployerFname, #EmployerEmployerLname,#main_phone1,#main_phone2,#main_phone3,#main_phone4,#mobile_phone1,#mobile_phone2,#mobile_phone3').autotab_magic();
	});
	</script>
   <!-- .autotab_filter('numeric')-->
<div id="wrapper">
  <?php 
	
	if($this->Session->read('Auth.Client.employerContact.id')!='')
	{
		 echo $this->element('employer_tabs');
	}
 ?>
  <div class="inner_banner">
    <?php $bannerDt = $common->getbannerImage('4');   ?>
    <div class="static_inner_banner">
      <div class="static_title_bar">
        <p>
          <?php  echo $this->Text->truncate($bannerDt['OtherBanner']['name'], 40); ?>
        </p>
      </div>
      <?php // echo $this->Html->image("images/banner_job.jpg");  ?>
      <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'Banner/'.$bannerDt['OtherBanner']['filename'];?>&maxw=960&maxh=202"  /> </div>
  </div>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Employer Registration</h1>
         
          <div class="content">
           <h2 style="font-size:12px;">To exhibit at one of our hiring events or to post jobs, please create your account here.</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid" id="employerProfile"> <?php echo $this->Form->create(array('name'=>'empProfile','id'=>'empProfile'));?>
              <ul class="form_list manage_resume_form">
               <li>
                  <label>Company Name:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.employer_name',array('label'=>false,'div'=>false,'class'=>'big237_textfield')); ?> </div>
                </li>
                <li>
                  <label>First Name:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.employer_fname',array('label'=>false,'div'=>false,'class'=>'big237_textfield','onkeypress'=>"return allowNoAlpha(event);"));?> </div>
                </li>
                <li>
                  <label>Last Name:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.employer_lname',array('label'=>false,'div'=>false,'class'=>'big237_textfield','onkeypress'=>"return allowNoAlpha(event);"));?> </div>
                </li>
                
                 <li>
                  <label>Title / Position:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('EmployerContact.contact_title',array('label'=>false,'div'=>false,'class'=>'big237_textfield','onkeypress'=>"return allowNoAlpha(event);"));?> </div>
                </li>
                
                <li>
                  <label>Telephone:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1"> 
                   <!--
                    <span class="instruction"> (10 digits max., no dashes, spaces or periods)</span>-->
                    
                    <?php echo $this->Form->input('Employer.main_phone1',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'main_phone1','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> -
                    <?php echo $this->Form->input('Employer.main_phone2',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'main_phone2','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> -
                    <?php echo $this->Form->input('Employer.main_phone3',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>4,'id'=>'main_phone3','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> 
                    ext.<?php echo $this->Form->input('Employer.main_phone4',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>5,'id'=>'main_phone4','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?>
                    <?php echo $this->Form->input('Employer.main_phone',array('label'=>false,'div'=>false,'class'=>'big237_textfield','id'=>'phonenumber','style'=>'display:none','onkeypress'=>"return isNumericKey(event);"));?>                    </div>
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
                
                
                <li>
                  <label>Fax:</label>
                  <div class="form_rt_col1">
                  	<?php echo $this->Form->input('Employer.fax1',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'mobile_phone1','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> -
                    <?php echo $this->Form->input('Employer.fax2',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>3,'id'=>'mobile_phone2','style'=>"width:42px;height:23px;",'onkeypress'=>"return isNumericKey(event);"));?> -
                    <?php echo $this->Form->input('Employer.fax3',array('label'=>false,'div'=>false,'class'=>'inputType','maxlength'=>4,'id'=>'mobile_phone3','style'=>"width:42px;height:23px;"));?>&nbsp;(optional) 
                   <?php echo $this->Form->input('Employer.fax',array('label'=>false,'div'=>false,'id'=>'mobilenumber','class'=>'big237_textfield','style'=>'display:none;height:23px;','onkeypress'=>"return isNumericKey(event);"));?> <br/>
                    </div>
                </li>
                
                 <!--<li>
                  <label>Fax:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.fax',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>-->
                
                <li>
                  <label>Address:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.address',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>
                <li>
                  <label>City:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1" id="cityDiv"> 
				
 				 <?php  //echo $this->Form->input('Employer.city',array('type'=>'select','options'=>$cityList,'empty'=>'-Select City-','label'=>false,'class'=>'select1','div'=>'')); ?>
                 <?php   echo $this->Form->input('Employer.city',array('label'=>false,'div'=>false,'class'=>'big237_textfield','onkeypress'=>"return allowNoAlpha(event);"));?>
</div>
				  
                  
                  <!--</div>-->
                </li>
                
                <li>
                  <label>State:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1">
                    <div class="dropdown_237" style="margin:0 0 5px; 0">
                      <?php 
					    $statList= $common->getStateList();;
                    //	echo $this->Form->input('Employer.state',array('type'=>'select','options'=>$statList,'empty'=>'-Select State-','label'=>false,'class'=>'select1','div'=>'','onChange'=>'onChangeAjaxGet("'.FULL_BASE_URL.router::url('/',false).'employers/city/",this.value,"cityDiv")'));
					
					echo $this->Form->input('Employer.state',array('type'=>'select','options'=>$statList,'empty'=>'-Select State-','label'=>false,'class'=>'select1','div'=>'','style'=>'clear:both;margin-bottom:3px;'));
					 ?>
                    </div>
                  </div>
                </li>
                
                <li>
                  <label>Zip:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.zip',array('label'=>false,'div'=>false,'class'=>'big237_textfield','onkeypress'=>"return allowNoAlpha(event);",'onkeypress'=>"return isNumericKey(event);",'onkeypress'=>"return isNumericKey(event);"));?> </div>
                </li>
                <li>
                  <label>Contact Email:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('EmployerContact.contact_email',array('type'=>'text','label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>
                <li>
                  <label>Web Address:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.url',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>
                
                <li>
                  <label>LinkedIn / Corporate Profile:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.linkedin',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>
                
                  <li>
                  <label>My Personal LinkedIn Profile:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.myprofile',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>
                
                <li>
                  <label>Company Facebook:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.facebook',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>
               
                <li>
                  <label>Stock Symbol:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.stock_symbol',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>
                <li>
                  <label>Annual Revenue:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.annual_revenue',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                </li>
                <li>
                  <label>Number of Employees:</label>
                  <div class="form_rt_col1">
                 
                      <?php echo $this->Form->input('Employer.number_of_employees',array('label'=>false,'div'=>false,'class'=>'big237_textfield'));?>
                      <?php 
					  
					  
					/*  
					$employeeNUM=array('1 - 25'=>'1 - 25','25 - 100'=>'25 - 100','100 - 250'=>'100 - 250','250 - 500'=>'250 - 500','500 - 1000'=>'500 - 1000','1,000 - 5,000'=>'1,000 - 5,000','10,000 - 50,000'=>'10,000 - 50,000','50,000+'=>'50,000+');
					echo $this->Form->input('Employer.number_of_employees',array('type'=>'select','options'=>$employeeNUM,'label'=>false,'div'=>false,'class'=>'big237_textfield'));
					*/
					
					?>
                 
                  </div>
                </li>
                <li>
                  <label>Do you occasionally sponsor H1-B visas?</label>
                  <div class="form_rt_col1">
                    <div class="dropdown_237"> <?php echo $this->Form->input('Employer.visa_status',array('type'=>'select','options'=>array('yes'=>'Yes','no'=>'No'),'label'=>false,'div'=>false,'class'=>'big237_textfield'));?> </div>
                  </div>
                </li>
                <li>
                  <label>Industry:</label>
                  <div class="form_rt_col1">
                    <div class="checkbox_div checkbox_large_div"  style="height:100px">
                      <div class="checkbox_list" style="height:100px">
                        <?php 
							 echo $this->Form->input('Employer.employer_type_code',array('type'=>'select','multiple'=>'checkbox','options'=>$industryList,'label'=>false,'div'=>false,'hiddenField' => false,'class'=>'big237_textfield')); 
						   ?>
                      </div>
                    </div>
                  </div>
                  <span class="instruction" style="float:right;">To see an industry added  to the list, <a href="mailto:nmathew@techexpousa.com?Subject=Add%20industry%20in%20list">click here.</a></span> </li>
                <li>
                  <label>Enter Your Company Description:<span class="errors_message">*</span></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('Employer.description',array('type'=>'textarea','label'=>false,'div'=>false,'class'=>'textarea_327'));?> </div>
                </li>
                <li>
                	<label></label>
                	<div class="red_message">* Indicates a required field.</div>
                </li>               
                <li>
                  <label></label>
                  <div class="form_rt_col1">
                    <input type="text" value="" class="extrafields" name="checkuser"  />
          
                   <?php echo $this->Form->submit('images/submit.jpg',array('div'=>false,'name'=>'Submit'));?> </div>
                </li>
              </ul>
            <?php echo $this->Form->end();?> </div>
          </div>
        </div>
      </div>
    </div>
   
     <?php echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); ?>
      <?php echo $this->element('main_login_leftbar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
