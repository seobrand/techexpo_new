<?php
	$this->set('title_for_layout', 'Login - Admin');
    echo $this->Form->create('Adminuser', array('action' => 'login'));
?>
<table class="nostyle_none" width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:-2px;">
        <tr>
          <td width="32%" style="background-color:#fff">&nbsp;</td>
          <td style="background-color:#fff"><table class="nostyle_none" width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td style="background-color:#fff;"><div id="simplemodal-container">
                    <h3 style="font-family: Verdana,Arial,Helvetica,sans-serif; margin:0px; padding:8px 10px; text-align:left;">Admin Login</h3>
                    <div id="basic-modal-content">
                      <div class="simplemodal-login-fields">
                          <div style="vertical-align: middle; padding: 5px;" id="UserInfoDiv">
                            <table class="nostyle_none" cellspacing="0" cellpadding="0" width="100%" border="0" style="font-family: Verdana,Arial,Helvetica,sans-serif; background-color:#A2B9D8;">
                              <tbody>
                                <tr>
                                  <td class="admin_login" colspan="2"><!--Your password will be sent to the email.-->Please enter your Username and Password <br />
                                    <br /></td>
									<td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td align="left" width="34%" class="admin_login_fields" valign="top">Username:</td>
                                  <td align="right" width="155px" valign="top"><?php echo $this->Form->input('username',array('class'=>'inputbox_login','id'=>'username','placeholder'=>'User Name', 'label'=>'','div'=>false));?></td>
								  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td class="admin_login_fields" align="left" width="34%" valign="top">Password:</td>
                                  <td align="right" valign="top">
								  <?php echo $this->Form->input('password',array('class'=>'inputbox_login','placeholder'=>'Password','label'=>'','div'=>false));?>
                                  </td>
								  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td align="right"><?php echo $this->Form->submit('login_bt.jpg',array('id'=>'','div'=>false,'style'=>'width:auto;height:auto;background:none;margin-left:136px;'));?></td>
								  <td>&nbsp;</td>
                                </tr>
                                
                                 <tr>
                                  <td class="admin_login_fields" align="left" width="34%" valign="top"></td>
                                  <td align="right" valign="top">
								             <?php echo $this->Html->link('Forgot Password', array('controller'=>'adminusers','action'=>'forgotpassword'),array('escape'=>false)); ?></td>
								  <td>&nbsp;</td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                      </div>
                    </div>
                  </div></td>
              </tr>
            </table></td>
          <td width="32%" style="background-color:#fff">&nbsp;</td>
        </tr>
      </table>
<?php echo $this->Form->end();?>
<script type="text/javascript">
	document.getElementById('username').focus();
</script>