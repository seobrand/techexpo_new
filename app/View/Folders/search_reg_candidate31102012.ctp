   <div id="wrapper">
    <?php echo $this->element('employer_tabs');
	$theComponent = new commonComponent(new ComponentCollection());
	?>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Search Resumes</h1>
            <div class="content">
              <h2 class="mana_subheading"><strong>VERY IMPORTANT:</strong> CLICK HERE TO READ UPDATED RESUME SEARCH INSTRUCTIONS AND TIPS</h2>
              <h2 class="mana_subheading"> You are currently registered for the following TECHEXPO events:</h2>
              <ul class="list no_top">
              <?php  foreach ($regEvents as $regEvent){?>
                <li><a href="<?php echo $this->webroot; ?>employers/eventinfo/<?php echo $regEvent['Show']['id'] ?>"><?php echo $regEvent['Show']['show_name']; ?> - <?php echo date("m/d/Y",strtotime($regEvent['Show']['show_dt']));?></a></li>
                <?php } ?>
              </ul>
              <div class="gray_full_top"></div>
              <?php echo $this->Form->create('Folders',array('action'=>'searchRegResult','type'=>'GET'));?>
              <div class="gray_full_mid">
                <ul class="form_list manage_resume_form">
                  <li>
                    <label>Keywords:</label>
                    <div class="form_rt_col1">
                    <?php echo $this->Form->input('keyword',array('class'=>'small_Texfield','div'=>false,'label'=>false)); ?>
                      <div class="even_reg_dropdown float_left">
                      
                             <?php 
                        $option=array('All'=>'All Words','Exact'=>'Exact Phrase','Any'=>'Any Words');
                 echo $this->Form->input('keyword_matching',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                      </div>
                    </div>
                  </li>
                  <li>
                    <label>State:</label>
                    <div class="form_rt_col1">
                      <div class="checkbox_div ">
                        <ul class="checkbox_list">
                             <?php 
							   $state_list = $theComponent->getStateList();
							echo $this->Form->input('state_list', array(
							'type' => 'select', 
							'options' => $state_list, 
							'multiple' => 'checkbox',
							'div'=>false,
							'label'=>false
							)
							)
						
					   ?>
                          <!--<li>
                            <label>
                              <input name="" type="checkbox" value="DC" />
                              &nbsp;&nbsp;DC</label>
                          </li>-->
                        
                        </ul>
                      </div>
                    </div>
                  </li>
                  <li>
                    <label> Are you willing to relocate:</label>
                    <div class="form_rt_col1">
                    <?php 
					$options=array('Y'=>'Yes','N'=>'No');
					$attributes=array('legend'=>false,'div'=>false,'label'=>false,'style'=>'margin-top:13px;');
					echo $this->Form->radio('relocate',$options,$attributes);
					?>
                   
                    </div>
                  </li>
                  <li>
                    <label>Citizenship Status:</label>
                    <div class="form_rt_col1">
                      <div class="even_reg_dropdown f_left">
                      <?php  $citizen_list = $theComponent->getCitizenShipList();
					 echo $this->Form->input('citizen_status_code',array('label'=>'','options'=>$citizen_list,'type'=>'select','empty'=>'select','style'=>'font-size: x-small; font: x-small;','error'=>false,'div'=>false,'label'=>false));
					   ?>
                                             
                      </div>
                      <div class="second_label"> Min. years of Exp:</div>
                      <div class="small_dropdown margin_lf">
                         <?php  $experience_code = $theComponent->getExperienceList();
					  
					  echo $this->Form->input('experience_code',array('label'=>'','options'=>$experience_code,'empty'=>'select','type'=>'select','style'=>'font-size: x-small; font: x-small;','error'=>false,'div'=>false,'label'=>false));
					   ?>
                     
                      </div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                    <label>Security Clearance:<br />
<span>Please check all that apply.</span></label>
                    <div class="form_rt_col1">
                      <div class="checkbox_div checkbox_large_div">
                        <ul class="checkbox_list">
                          <?php   $cleareance_list = $theComponent->getGovCleareanceList();
							
							echo $this->Form->input('cleareance_list', array(
							'type' => 'select', 
							'options' => $cleareance_list, 
							'multiple' => 'checkbox',
							'div'=>false,
							'label'=>false
							)
							)
						
					   ?>
                      <!--   <li>
                            <label>
                              <input name="" type="checkbox" value="All" />
                              &nbsp;&nbsp;All</label>
                          </li>
                          <li>
                            <label>
                              <input name="" type="checkbox" value="SC" />
                              &nbsp;&nbsp;None</label>
                          </li>-->
                        </ul>
                      </div>
                      <div class="clear"></div>
                      <br />
                      <br />
                       <?php echo $this->Form->input('advanceSearch',array('class'=>'small_Texfield','div'=>false,'label'=>false)); ?>
                      <br />
                      <div class="clear"></div>
                      <br />
                       <?php echo $this->Form->checkbox('advance',array('class'=>'small_Texfield','div'=>false,'label'=>false)); ?>
                      &nbsp;&nbsp;Check to perform an ADVANCED BOOLEAN SEARCH (read instructions). </div>
                  </li>
                  <li>
                    <label>OPTIONAL: Look for resumes submitted in the last:</label>
                    <div class="form_rt_col1">
                     <?php echo $this->Form->input('resumelast',array('class'=>'small_Texfield','div'=>false,'label'=>false)); ?>
                      <div class="dropdown_resume4 float_left">
                     <?php 
                        $option=array('days'=>'days','weeks'=>'weeks','months'=>'months','years'=>'years');
                         echo $this->Form->input('resumelast_matching',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?>
                      </div>
                    </div>
                  </li>
                  <li>
                    <label> Max. number of results:</label>
                    <div class="form_rt_col1">
                      <div class="dropdown_resume4">
                        
                    <?php     $options=array('All'=>'View all','100'=>'100','200'=>'200','300'=>'300','500'=>'500','1000'=>'1000');
					echo $this->Form->input('max_rows',array('type'=>'select','options'=>$options,'empty'=>false,'label'=>false,'div'=>''));
					?>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </li>
                  <li>
                  <label>Search pre-registered candidates for the following event:</label>
                  <div class="form_rt_col1">
                    <div class="checkbox_div checkbox_large_div">
                      <ul class="checkbox_list">
                      
                         <?php 
						   echo $this->Form->input('event_list', array(
							'type' => 'select', 
							'options' => $event_list, 
							'multiple' => 'checkbox',
							'div'=>false,
							'label'=>false
							)
							);
						
					   ?>
                      
                  <!--      <li>
                          <label>
                            <input name="" type="checkbox" value="Colorado Springs, CO - 06/14/12" />
                            &nbsp;&nbsp;Colorado Springs, CO - 06/14/12</label>
                        </li>-->
                      
                       
                      </ul>
                    </div>
                  </div>
                  </li>
                  <li>
                    <label></label>
                    <div class="form_rt_col1">
                    <?php echo $this->Form->submit('images/grey_submit.jpg');?>
                    </div>
                  </li>
                </ul>
              </div>
               <?php echo $this->Form->end(); ?>
            </div>
          </div>
        </div>
      </div>
         <?php echo $this->element('employer_left_panel'); ?>
      <div class="clear"></div>
        <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>