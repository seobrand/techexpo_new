<div id="wrapper">
    
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        
        
        
      <div class="whiteB_mid">
     <?php echo $this->Form->create('User',array('action'=>'', 'enctype' => 'multipart/form-data')); ?>
          <div class="whiteB_bottom">
          <br />
            <h2 class="bluecolor" style="padding:0px 18px 0px 20px">
Please fill out the fields below. Make sure to select which states are of interest to you so we can notify you of upcoming events taking place in them.</h2><br />
            <div class="content">
              
           
           
              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
                <ul class="form_list manage_resume_form">
                  
                  <li>
                    <label>Email:</label>
                    <div class="form_rt_col1">
                      <?php echo $this->Form->input('MASSEMAIL.list_email',array('class'=>'input_208','label'=>'',
					  																	'border'=>'none','div'=>'','class'=>'big237_textfield'));?>
                      </div>
                  </li>
                  
                  
                  <li>
                    <label>First Name:</label>
                    <div class="form_rt_col1">
                      <?php echo $this->Form->input('MASSEMAIL.list_first_name',array('class'=>'input_208','label'=>'',
					  																	'border'=>'none','div'=>'','class'=>'big237_textfield'));?>
                      
                      </div>
                  </li>
                   <li>
                    <label>Last Name:</label>
                    <div class="form_rt_col1">
                    <?php echo $this->Form->input('MASSEMAIL.list_last_name',array('class'=>'input_208','label'=>'',
					  																	'border'=>'none','div'=>'','class'=>'big237_textfield'));?>
                  
                   <br /> (10 digits max., no dashes, spaces or periods)</span></div>
                  </li>
                 
                  <li>
                    <label>Do you have active security clearance: </label>
                    <div class="form_rt_col1">
                     <?php 
						$option=array('1'=>'yes','0'=>'No'); 
					 echo $this->Form->input('MASSEMAIL.list_clearance', array('type' => 'select','class'=>'checkbox1','label' =>false,'options' => $option,'div'=>false,'style'=>'float:left;width:150px;'));
					 ?>
                      </div>
                  </li>
                  
                  
                  <li>
                    <label>
                    
                    States of interest  <br />
                (for TECHEXPO event notification)
                    </label>
                    <div class="form_rt_col1">
                    <?php echo $this->Form->input('MASSEMAIL.list_states', array('type' => 'select','class'=>'checkbox1','label' =>false,'multiple' => 'checkbox','options' => $statList,'div'=>false,'style'=>'float:left;width:150px;'));
					 ?>
                    
                  
                  <!-- <br /> (10 digits max., no dashes, spaces or periods)--></span></div>
                  </li>
                  <li>
                    <label>Employer messages:</label>
                    <div class="form_rt_col1">
                   
                      <?php echo $this->Form->checkbox('MASSEMAIL.list_employer', array('class'=>'checkbox1','div'=>false,'style'=>'float:left;width:30px;'));
					 ?><span style="float:left;width:350px;">Check to receive special messages and information from employers</span>
                      </div>
                  </li>
                  <li>
                    <label>Partner messages: </label>
                    <div class="form_rt_col1">
                      <?php echo $this->Form->checkbox('MASSEMAIL.list_adv', array('class'=>'checkbox1','label' =>'Check to receive special messages and information from employers','div'=>false,'style'=>'float:left;width:30px;'));
					 ?><span style="float:left;width:350px;">Check to receive special messages and promotional offers from our partners</span>
                      </div>
                  </li>
                 <li>
                    <label></label>
                    <div class="form_rt_col1">
                      <?php 
                      echo $this->Form->input('Candidate.REGIST',array('name'=>'candidate.REGISTER','value'=>'REGIST','type'=>'hidden'));
                      echo $this->Form->submit('images/submit.jpg');?>
                      
                      
                      </div>
                  </li>
                </ul>
              </div>
          
 
            </div>
          </div>
       <?php echo $this->end();?> 
        </div>
   </div>
      <div class="rt_col_inner">
         
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
      </div>
      <div class="clear"></div>
        <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>