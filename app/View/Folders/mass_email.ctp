<div id="wrapper">
    
    
    <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
    <div id="container">
    

      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
            <h1 class="bluecolor">E-mail all the candidates whose resumes are filed in this folder</h1>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;Folder name: </p>
            <div class="content">
              
            
<br />

              <div class="gray_full_top"></div>
              <div class="gray_full_mid">
                
          
<?php echo $this->Form->create('Folder',array('name'=>'resumeFolder','id'=>'resumeFolder','action'=>'massEmail'));?>
                
                <ul class="form_list manage_resume_form">
                  <li>
                    <label>	
Subject line of your e-mail:</label>
                    <div class="form_rt_col1">
                
                       <?php echo $this->Form->input('subject',array('label'=>false,'class'=>'big237_textfield','div'=>false));?>
                      </div>
                  </li>
                  
                  <li>
                    <label>	

E-mail address you wish candidates to reply to:</label>
                    <div class="form_rt_col1">
                
                       <?php echo $this->Form->input('replyemail',array('label'=>false,'class'=>'big237_textfield','div'=>false));?>
                      </div>
                  </li>
                  
                  <li>
                    <label>Type a short message:</label>
                    <div class="form_rt_col1">
                                      <?php echo $this->Form->textarea('mailnotes',array('label'=>false,'class'=>'textarea_237 textarea_220','div'=>false));?>  
                      
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
      
  <?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>

