<div id="wrapper">
    <div class="inner_banner">
    </div>
    <div id="container">
      <div class="lf_col_inner">
        <div class="whiteB_head"></div>
        <div class="whiteB_mid">
          <div class="whiteB_bottom">
           <h1>Forgot Password? </h1>
         
            <div class="content" style="margin-left:120px;">
           			<div class="side_box">
        <div class="side_head">Email Password</div>
        <div class="side_mid">
          <div class="side_bottom"> 
		  <?php echo $this->Form->create('User'); ?>
            <ul class="login_panel">
            	<li style="color:#FF0000">
                	  <?php echo $this->Session->flash(); ?>
                </li>
              <li> Email : <br/> <?php echo $this->Form->input('User.contact_email',array('class'=>'login_txt','div'=>'','label'=>false,'style'=>"margin-top:5px;"));?> </li>
              <li>User Type : <br/>
                <?php echo $this->Form->input('User.usertype',array('type'=>'select','options'=>array('C'=>'Candidate','E'=>'Employer'),'class'=>'login_txt','div'=>'','label'=>false,'style'=>"width:100px;margin-top:5px;"));?>
              </li>
              <li>
                <?php echo $this->Html->link('Log In',array('controller'=>'users','action'=>'login'));?> / <a href="mailto:Amanda@techexpousa.com">E-mail the webmaster</a><br/><br/>		
			<?php echo $this->Form->submit('images/submit.jpg',array('style'=>'float:right;padding-right:10px;'));?>
                
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