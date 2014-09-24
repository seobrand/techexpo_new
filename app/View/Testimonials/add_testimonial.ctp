<?php echo $this->element('tinymce', array('cache' => true));

	
 ?>
<style>
ul.label_small li label
{
	width:132px!important;
}
</style>
<div id="wrapper">
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Add Testimonial</h1>
          <div class="content"> <?php echo $this->Form->create('Testimonial',array('action'=>'addTestimonial','type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false))); ?>
            <ul class="form_list manage_resume_form label_small">
              <li>
                <label><span class="red">*</span>Name:</label>
                <div class="form_rt_col1"> <?php echo $this->Form->input('Testimonial.name',array('class'=>'big537_textfield','label'=>false,'div'=>'','readonly'=>'readonly','style'=>'width:256px!important;'));?> </div>
              </li>
              <!--<li>
                <label><span class="red">*</span>Role:</label>
                <div class="form_rt_col1">
                  <div class="dropdown" style="clear:both">
                    <?php 
					   $option=array('j'=>'Job Seekers','e'=>'Employers');
                       echo $this->Form->input('Testimonial.testimonial_by',array('type'=>'select','options'=>$option,
					   															'empty'=>false,'label'=>false,'class'=>'select1','div'=>''));
                      ?>
                    <br />
                    <br />
                  </div>
                </div>
              </li>-->
              <li>
                <label><span class="red"></span>Text:</label>
                
                <?php echo $this->Form->input('Testimonial.text',array('class'=>'textarea_398','type'=>'textarea','label'=>false,'div'=>false,'style'=>'width:475px;overflow:hidden;','error'=>false));?>
               <div style="margin-left:148px;">
                <?php echo $this->Form->error('text',array('style'=>'margin-left:100px;','class'=>'')); ?></div>
                 </li>
            
          
              <?php /* commented by pushkar ticket id 1305?><li>
                <label><span class="red">*</span>Image:</label>
                <div class="form_rt_col1"> <?php echo $this->Form->input('logo_file',array('type'=>'file')); ?> </div>
              </li><?php */?>
              
              
              
              <li>
                <label></label>
                <div class="form_rt_col1">
                  <?php 
                      echo $this->Form->input('Testimonial.add',array('value'=>'add','type'=>'hidden'));
                      echo $this->Form->input('Testimonial.aprov',array('value'=>'0','type'=>'hidden'));
                      echo $this->Form->submit('images/submit.jpg');?>
                </div>
              </li>
            </ul>
            <?php echo $this->Form->end(); ?> </div>
        </div>
      </div>
    </div>
    <div class="rt_col_inner"> <?php // echo $this->element('main_login_leftbar', array('cache' => true)); ?> <?php echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); ?> </div>
   
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>