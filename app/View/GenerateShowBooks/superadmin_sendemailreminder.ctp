<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Send E-mail Reminder</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<!-- box / title -->
<div class="display_row">
  <div class="table">
  <?php echo $this->Form->create('',array('id'=>'sendemailreminder'));?>
    <table border="0" cellspacing="0" cellpadding="0">
      <tbody>
        <tr>
          <td colspan="2"></td>
        </tr>
        <tr>
          <td width="20%" valign="middle" align="right">Subject: </td>
          <td width="79%" valign="middle" align="left"><?php echo $this->Form->input('ShowCompanyProfile.subject',array('label'=>false,'div'=>false,'class'=>'inputbox1','value'=>'Important TECHEXPO reminder'));?>
            <br></td>
        </tr>
        <tr>
          <td width="20%" valign="middle" align="right"> To: </td>
          <td width="79%" valign="middle" align="left"><?php echo $this->Form->input('ShowCompanyProfile.sendto',array('label'=>false,'div'=>false,'class'=>'inputbox1','value'=>$employer['EmployerContact']['contact_email']));?></td>
        </tr>
        </tr>
        
        <tr>
          <td width="20%" valign="middle" align="right"><br>
            <br>
            This is the message you are about to send.
            You can make changes within the text box area below before sending it out. <br></td>
          <td width="79%" valign="middle" align="left"><textarea rows="20" cols="60" name="data[ShowCompanyProfile][message]">Dear <?php echo $employer['EmployerContact']['contact_name'] ?>,<br/><br/>Thank you for participating in our upcoming <?php echo $show['Location']['location_city'] ?> - <?php echo $show['Location']['location_state'] ?> event on <?php echo date("l F d, Y",strtotime($show['Show']['show_dt'])); ?>. <br/><br/>This is just a quick reminder that we still need you to complete your company profile so we can prepare adequately for the show and insure that you will get everything you need for the event (phone, electricity, your company description for the show guide...etc). This is where we pull your company's information for the show guide, which goes to print one week prior to the event.<br/><br/>You can do so by logging in to your account at http://www.TechExpoUSA.com and, when you get to your employer homepage, click on the "TECHEXPO event preparation center" graphic. This will take you to a screen that summarizes your participation in our different TECHEXPO events. <br/><br/>For each event, you will have a few options. One of them is to click on the event's corresponding small graphic labeled "create / edit show profile" (with a small, green plus sign). Click on it. This will then take you to the screen where you need to fill out your information. You may have filled some of it already but forgot certain fields. Make sure all the fields are filled out.<br/><br/>As a reminder, here is your login information:<br/><br/>username: <?php echo $employer['User']['username'] ?><br/>password: <?php echo $employer['User']['old_password'] ?><br/><br/>If you have any questions or need technical assistance, email nmathew@TechExpoUSA.com or call Nancy Mathew at 212.655.4505 ext. 225. <br/><br/>Sincerely, <br/><br/>Nancy Mathew<br/>Vice President, Events and Marketing<br/>212.655.4505 ext. 225</textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td width="79%" valign="middle" align="left"><?php echo $this->Form->submit('Send!',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?>
          </td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->end();?>
  </div>
</div>
