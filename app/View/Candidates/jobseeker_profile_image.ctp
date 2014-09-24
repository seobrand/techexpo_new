<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Add / Edit Profile Picture</h1>
          <div class="content">
            <h2 class="mana_subheading">Please enter Short Description (2-3 lines) & Upload Profile Picture</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
            	 <?php echo $this->Form->create('Candidate',array('action'=>'', 'enctype' => 'multipart/form-data'));?>
              <ul class="form_list manage_resume_form ">
                <li>
                  <label>Profile Description:</label>
                  <div class="form_rt_col1">
                   <?php echo $this->Form->input('Candidate.profile_description',array('class'=>'textarea_237','type'=>'textarea','value'=> $description['Candidate']['profile_description'] ,'label'=>'','border'=>'none','div'=>''));?> </div>
                </li>
                <li>
                  <label>Upload Picture:</label>
                  <div class="form_rt_col1"> 
				  <?php echo $this->Form->input('Candidate.candidate_image',array('class'=>'textarea_237','type'=>'file','label'=>'','border'=>'none','div'=>'','size'=>'24px;'));?> <br />
                    <span class="instruction red">Maximum size 5MB</span><br/><br/>
                     <?php
					 $profileImage = $description['Candidate']['candidate_image'];
					  if($profileImage && file_exists('upload/150x80_'.$profileImage)){ ?>
              <div style="height:140px;">
            <!--  <img src="<?php echo $this->webroot.'upload/150x80_'.$profileImage;?>"  width="140px" height="80px" style="margin-left:16px;"/>
          -->   <img src="<?php echo $this->webroot; ?>thumbnail.php?file=<?php echo 'upload/'.$profileImage;?>&maxw=210&maxh=140" style="margin-left:16px;" />
              </div>
              <?php } ?>
                    
                     </div>
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1">
                    <?php
					  echo $this->Form->input('Candidate.UPLOAD',array('value'=>'UPLOAD','type'=>'hidden'));
                      echo $this->Form->submit('images/grey_submit.jpg');
					  ?>
                  </div>
                </li>
              </ul>
              <?php echo $this->Form->end();?> </div>
            <br />
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>