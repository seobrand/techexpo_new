<div id="wrapper">
   <div class="inner_banner">
      <div class="jobseeker_banner"> Create Account</div>
    </div>

    <div id="container">
    
 
        <?php echo $this->Form->create('Resume',array('action'=>'resume', 'enctype'=>'multipart/form-data')); ?>
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">Manage Resume</h1>
            <div class="content">
              <div class="tab_panel_4  tab_panel_41">
           
           <ul>
           <li class="firstTab"><?php echo $this->Html->link("Create New Account",array('controller'=>'candidates','action'=>'register')); ?></li>
            <li class="secondTab"><a href="frontend-manage-resume-update.html">Post <br />
Your Resume</a></li>
             <li class="thirdTab"><a href="user-event-registration.html">Register <br />
For an Event</a></li>
              <li class="fourthTab"><a href="thankyou.html">Thank You</a></li>
           </ul>
           <div class="clear"></div>
           
           </div><br />

         <a href="frontend-manage-resume.html"><?php echo $this->Form->Submit('update_resume.jpg'); ?> </a><br /><br />


               <h2 class="mana_subheading">1. Please enter a Title for your Resume &amp; Provide a Short Career summary (2-3 lines)</h2>
              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
                <ul class="form_list manage_resume_form">
                  <li>
                    <label>Resume Title:</label>
                    <div class="form_rt_col1">
                      
                      <?php echo $this->Form->input('Resume.resume_title',array('class'=>'big237_textfield','label'=>false,'div'=>''));?>
                       
                      <br />
                      <strong>Example:</strong><span class="instruction"> "Experienced Database Administrator. Oracle certified."</span></div>
                  </li>
                  <li>
                    <label>My professional profile can be summarized as:</label>
                    <div class="form_rt_col1">
                    <?php echo $this->Form->input('Resume.resume_content',array('class'=>'textarea_237','type'=>'textarea','label'=>false,'div'=>''));?>
            
                      <br />
                      <strong>Example: </strong><span class="instruction">"A database professional with over 10 years of strong design, administration &amp; optimization experience. Expert with SQL Server and Oracle systems."</span></div>
                  </li>
                </ul>
              </div>
              <br />
              <br />

              <h2 class="mana_subheading">2. Please provide keywords to attach to your resume. Keywords should represent your CORE or main skills.</h2>
              <p><strong>Please fill out your keyword information carefully.</strong></p>
              <ul class="listing_arrow">
                <li> This is very important for the job matching and automatic scoring process.</li>
                <li>You can enter 1-5 keywords.</li>
                <li>If you wish to see skills added to the list or have comments about this form, <a href="">click here</a>. </li>
              </ul>
              <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th width="258" style="text-align:left">Keyword</th>
                        <th width="153" style="text-align:center">Years of Exp.</th>
                        <th width="139" style="text-align:center">Last Used</th>
                        <th width="114" style="text-align:center">Level</th>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  width="223" style="text-align:left"><div class="dropdown_resume1">
                        <?php 
                        echo $this->Form->input('ResumeSkill.skill_id',array('type'=>'select','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                            
                          </div></td>
                        <td  width="153" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                             <?php 
                        echo $this->Form->input('ResumeSkill.experience_code',array('type'=>'select','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                            <?php 
                        echo $this->Form->input('ResumeSkill.last_used_code',array('type'=>'select','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                            <?php 
                        echo $this->Form->input('ResumeSkill.level_code',array('type'=>'select','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td class="table_row border_bottom alternate"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  width="223" style="text-align:left"><div class="dropdown_resume1">
                        <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                            
                          </div></td>
                        <td  width="153" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                             <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                            <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                            <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  width="223" style="text-align:left"><div class="dropdown_resume1">
                        <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                            
                          </div></td>
                        <td  width="153" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                             <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                            <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                            <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td class="table_row border_bottom alternate"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  width="223" style="text-align:left"><div class="dropdown_resume1">
                        <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                            
                          </div></td>
                        <td  width="153" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                             <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                            <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                            <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                      </tr>
                    </table></td>
                </tr>
                <tr>
                  <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td  width="223" style="text-align:left"><div class="dropdown_resume1">
                        <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$keywordArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                            
                          </div></td>
                        <td  width="153" class="normalfont" style="text-align:left"><div class="dropdown_resume2">
                             <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$experienceArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="139" class="normalfont" style="text-align:left"><div class="dropdown_resume3">
                            <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$lastUsedArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                        <td  width="114" class="last normalfont" style="text-align:left"><div class="dropdown_resume4">
                            <?php 
                        echo $this->Form->input('Candidate.availability_code',array('type'=>'select','options'=>$lastLevelArray,'label'=>false,'class'=>'select1','div'=>''));
                        ?>
                          </div></td>
                      </tr>
                    </table></td>
                </tr>
              </table>
              
                <br />
              <br />
              <h2 class="mana_subheading">3. Please paste your resume in the text area below.</h2>
                 <div class="gray_full_top"></div>
              <div class="gray_full_mid">
               <?php echo $this->Form->input('Resume.resume_summary',array('class'=>'big_textarea','type'=>'textarea','label'=>false,'div'=>''));?>
              
                
                
                <div class="man_resume_footer padding_right_none">
 <p>Please enter text as shown in image below:</p>
 <ul>

  <li class="last"> 
  <?php echo $this->Form->submit('delete_refresh.jpg',array('name'=>'Resume.Delete','value'=>'Delete')); ?>
  </li>

  <li> <?php                    
                   echo $this->Form->input('Resume.captcha',array('autocomplete'=>'off','value'=>'','label'=>false,'class'=>'security_txt','div'=>''));
                  ?></li>
   <li ><?php echo $this->Html->image($this->Html->url(array('controller'=>'candidates', 'action'=>'captcha'), true),array('style'=>'','vspace'=>2)); ?></li>
   
 </ul>
 <div class="clear"></div>
 <div class="align_right">
  <?php echo $this->Form->submit('update_resume.jpg',array('name'=>'Resume.Submit','value'=>'Update')); ?>
 </div>
 </div>
              </div>
              
 
            </div>
          </div>
        </div>
      </div>
      
     <?php echo $this->Form->end();?>
      
 <div class="rt_col_inner">
        
         <?php echo $this->element('main_login_leftbar', array('cache' => true)); ?>
         <?php echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); ?>
        
        
         
      </div>
      <div class="clear"></div>
        <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>