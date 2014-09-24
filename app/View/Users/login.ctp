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
            <h1>Log In</h1>
            <div class="log_lf">
               <div class="gray_head"></div>
        <?php echo $this->Form->create('User',array('controller'=>'users','action'=>'login')); ?>
            <div class="gray_bottom" style="height:220px;">
            
<ul>
<li style="color:#FF0000;">
                	  <?php echo $this->Session->flash(); ?>
                </li>
<li>
<table>
	<tr>
    	<td><label >Username:</label></td>
        <td><?php echo $this->Form->input('User.username',array('class'=>'login_textfield','type'=>'text','placeholder'=>'User Name','div'=>'','label'=>'','style'=>'float:left'));?></td>
    </tr>
</table>


</li>
<li>
<table>
	<tr>
    	<td><label>Password:</label> </td>
        <td><?php  echo $this->Form->input('User.password',array('class'=>'login_textfield','type'=>'password','placeholder'=>'Password','div'=>'','label'=>'','style'=>'float:left')); ?></td>
    </tr>
</table>
</li>
<li><label>&nbsp;</label>


<?php 
                	 echo $this->Form->input('User.LOGIN',array('type'=>'hidden','value'=>'LOGIN'));
               		 echo $this->Form->submit('images/grey_submit.jpg',array('class'=>'login_btn'));
					  echo $this->Form->input('User.Login',array('type'=>'hidden','value'=>'LOGIN'));
                 ?>
</li>
<li>
<?php echo $this->Html->link('Forgot Password',array('controller'=>'users','action'=>'forgotpassword'),array('style'=>'margin-left:108px;'));?>
</li>
</ul>

            </div>
          
             <?php echo  $this->Form->end(); ?>
            </div>
            
            <div class="log_rt"><p class="blueheading">Don't have an account? </p>
            
             <a href="javascript:void(0);" onclick="showRegisterPopup()">
			 <?php   echo $this->Html->image('images/create_btn.jpg');
			?></a>
          
</div>
            
            
            <div class="clear"></div>
            
            </div>
          </div>
       
      </div>
    
    
    
      
      <div class="rt_col_inner">
         <?php echo $this->element('front_innerpage_siderbar', array('cache' => true));  ?>
      </div>
      <div class="clear"></div>
        <?php echo $this->element('partners', array('cache' => true)); ?> 
    </div>
  </div>
  
  
