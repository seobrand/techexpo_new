<?php  	echo $this->Html->script('front_js/jquery-ui-1.7.2.custom.min.js');
echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
 ?>
 <script type="text/javascript">
$(function(){
	$(".ajax").colorbox();
	});
</script>

<div id="wrapper">
    <div class="inner_banner"><!--<?php echo $this->Html->image('images/about_banner.jpg');?>-->
    <?php ?>
    </div>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
           <div style="clear:both;height:50px"></div>
            <div class="content" style="margin-left:120px;">
           			<div class="side_box">
        <div class="side_head">LOG IN</div>
        <div class="side_mid">
          <div class="side_bottom"> <?php echo $this->Form->create('User',array('controller'=>'users','action'=>'login')); ?>
          
          
            <ul class="login_panel">
            	<li style="color:#FF0000">
                	  <?php echo $this->Session->flash(); ?>
                </li>
              <li> <?php echo $this->Form->input('User.username',array('class'=>'login_txt','type'=>'text','placeholder'=>'User Name','div'=>'','label'=>''));?> </li>
              <li>
                <?php  echo $this->Form->input('User.password',array('class'=>'login_txt','type'=>'password','placeholder'=>'Password','div'=>'','label'=>'')); ?>
              </li>
              <li>
                <?php 
                	 echo $this->Form->input('User.LOGIN',array('type'=>'hidden','value'=>'LOGIN'));
               		 echo $this->Form->submit('images/submit.jpg',array('style'=>'float:right;margin-right:10px;'));
                 ?>
                <label>
                 <?php 
				 echo $this->Form->input('User.Login',array('type'=>'hidden','value'=>'LOGIN'));
				  ?>
				  
                  <a href="javascript:void(0);" onclick="showRegisterPopup()">Register Now</a>/
				  <?php echo $this->Html->link('Forgot Password',array('controller'=>'users','action'=>'forgotpassword'));?></label>
                <div class="clear"></div>
              </li>
            </ul>
            
              <?php echo  $this->Form->end(); ?></div>
        </div>
      </div>
            </div>
            <div style="clear:both;height:100px"></div>
          </div>
        </div>
      </div>
      <div class="rt_col_inner">
         <?php echo $this->element('main_login_leftbar', array('cache' => true)); ?>
         <?php echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); ?>
      </div>
      <div class="clear"></div>
        <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>
  
  
