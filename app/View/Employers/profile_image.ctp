<div id="wrapper"> <?php echo $this->element('employer_tabs', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Add / Edit Your Company Logo</h1>
          <div class="content">
            <!-- <h2 class="mana_subheading">Please enter Short Description (2-3 lines) & Upload Profile Picture</h2> -->
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
            	 <?php echo $this->Form->create('Employer',array('action'=>'', 'enctype' => 'multipart/form-data'));?>
              <ul class="form_list manage_resume_form ">
             <li>
                  <label>Logo Title:</label>
                  <div class="form_rt_col1">
                   <?php echo $this->Form->input('Employer.logo_description',array('class'=>'textarea_237','type'=>'textarea','label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                <li>
                  <label>Upload Logo:</label>
                  <div class="form_rt_col1"> 
				  <?php echo $this->Form->input('Employer.logo_file',array('class'=>'textarea_237','type'=>'file','label'=>'','border'=>'none','div'=>''));?> <br />
                    <span class="instruction red">Maximum size 5MB</span> </div>
                </li>
                <li>
               <?php
			 
			   	$logoImage=$this->request->data['Employer']['old_logo'];
				 if($logoImage && file_exists('upload/150x80_'.$logoImage)){ ?>
             
                  
                  
                   <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$logoImage;?>&maxw=186&maxh=140" style="margin-left:230px;" "/>
                   
                
          
           		<?php }?>
                	
                </li>
                
                
                
                <li>
                  <label></label>
                  <div class="form_rt_col1">
                    <?php
					 echo $this->Form->input('Employer.old_logo',array('value'=>'UPLOAD','type'=>'hidden'));
					  echo $this->Form->input('Employer.UPLOAD',array('value'=>'UPLOAD','type'=>'hidden'));
                      echo $this->Form->submit('images/grey_submit.jpg');
					  ?>
                  </div>
                </li>
              </ul>
              <?php echo $this->end();?> </div>
            <br />
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>