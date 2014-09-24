<div class="login_box">
  <div class="login_tstrip"></div>
  <div class="login_mid">  	
	<?php
		//variables declairation on remember me functioning.	
		$cookie_clientname 		= ($this->Session->read('remember.email')) ? $this->Session->read('remember.email') : '';
		//$cookie_password 		= ($this->Session->read('remember.password')) ? $this->Session->read('remember.password') : '';
		$cookie_remember_me 	= ($this->Session->read('remember.remember_me')) ? $this->Session->read('remember.remember_me') : '';
	?>
    <?php echo $form->create('Client', array('action'=>'login'));?>
    <h1>Client Login</h1>
    <div class="email_input"> Email<br>
      <?php echo $form->input('email',array('label'=>'','class'=>'input_03','width'=>'200px','div'=>false,'value'=>$cookie_clientname));?> </div>
    <div class="email_input"> Password<br>
      <?php echo $form->input('password',array('label'=>'','class'=>'input_03','width'=>'100px','div'=>false));?> </div>
    <div class="email_input">
      <div class="remember_me">
        <table cellspacing="" cellpadding="" width="" border="">
        <tr>
          <td><?php
	  if($cookie_remember_me == 1) {
	   		echo $form->input('remember_me',array('type'=>'checkbox','label'=>'','value'=>1,'class'=>'','div'=>false,'checked'=>'checked'));
		}
		else {
			echo $form->input('remember_me',array('type'=>'checkbox','label'=>'','value'=>1,'class'=>'','div'=>false));
		}	   
	   ?></td>
          <td valign="middle" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:10px;">&nbsp;Remember me</td>
        </tr>
        </table></div>
      <div class="f_right"><?php echo $form->submit('login_bt.jpg', array('id'=>'button1','div'=>false));?></div>
    </div>
    <div class="email_input">
      <div id='basic-modal'>
        <?php	echo $html->link('Request a password reminder','javascript:void(0);',array('class'=>'basic')); ?>
      </div>
    </div>
    <div class="condidte_registration_bt"><?php echo $html->link($html->image('client_registration_bt.jpg',array('alt'=>'Client Registration','title'=>'Client Registration')),array('controller'=>'clients','action'=>'clientEnquiry'),array('div'=>false,'escape'=>false)); ?></div>
    <?php echo $form->end();?>
  </div>
  <div class="login_bstrip"></div>
</div>
<div id="basic-modal-content" style="display:none">
  <h3 style="font-family:Verdana, Arial, Helvetica, sans-serif;">Request Password</h3>
  <div class="simplemodal-login-fields">
    <?php   echo  $ajax->form(array('type' => 'post',
    'options' => array(
  		 'model'=>'Client',
  		 'update'=>$this->Session->read('id'),
   	'url' => array(
   	'controller' => 'clients',
   	'action' => 'forgotpassword'
    	)
    	)
   ));
//echo $ajax->form('User',array('action'=>'forgotpassword')); ?>
    <div id="<?php echo $this->Session->read('id');?>" style="vertical-align:middle; padding:5px;"> <?php echo $this->element('forgotpassword');?> </div>
    <?php echo $form->end();?> </div>
  <div class="simplemodal-login-activity" style="display:none;"></div>
</div>
<?php 
echo $html->script('jquery');
echo $html->script('jquery.simplemodal');
echo $html->script('basic');
?>
<style  type="text/css">
#basic-modal-content {display:none; z-index:2000000;}
/* Overlay */
#simplemodal-overlay {background-color:#000; cursor:wait;}
/* Container */
#simplemodal-container { width:435px; color:#666666; background-color:#fff; padding:5px 5px 5px 5px; border:#000000 solid 1px; height:200px; }
#simplemodal-container-privacy { width:900px; color:#393939; background-color:#C9E7FF; border:8px solid #283D9A; padding:0px; overflow:scroll;}
#simplemodal-container .simplemodal-data {padding:0px; border:#e6e6e6 solid 1px;}
#simplemodal-container code {background:#141414; border-left:3px solid #65B43D; color:#bbb; display:block; font-size:12px; margin-bottom:12px; padding:4px 6px 6px;}
#simplemodal-container a {color:#ddd;}
#simplemodal-container a.modalCloseImg {background:url(<?php echo FULL_BASE_URL.Router::url('/',false);?>/img/x.png) no-repeat; width:30px; height:29px; display:inline; z-index:3200; position:absolute; top:10px; right:14px; cursor:pointer;}
#simplemodal-container h3 {color:#ffffff; font-size:24px; background:url(<?php echo FULL_BASE_URL.Router::url('/',false);?>img/head_rep.gif) repeat-x; padding:5px 10px 4px 10px; font-weight: normal; font-family:"Times New Roman", Times, serif; }
.simplemodal-login-fields p{margin-top:5px; margin-left:10px; margin-bottom:10px; width:160px; font-family:"Times New Roman", Times, serif; font-size:14px;}
.simplemodal-login-fields label{font-size:14px; font-weight:bold;}
.simplemodal-login-fields input{font-size:14px; color:#666666; padding:4px 10px; background:url(<?php echo FULL_BASE_URL.Router::url('/',false);?>/img/input.jpg) no-repeat center center; width:204; border:none;}
.simplemodal-login-fields  input.submit{ background:url(<?php echo FULL_BASE_URL.Router::url('/',false);?>/img/up_send.jpg) no-repeat center center #407adb; width:102px; font-family:Times New Roman, Times, serif; font-size:21px; text-align:center; color:#FFFFFF; float:right; margin:15px 2px 15px auto; cursor:pointer; height:37px;}
</style>