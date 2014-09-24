<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Candidate Mass Email Messages</div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<div class="display_row">
  <div class="table">
    <p>Please paste or type the text that will be included at the end of show mass e-mails sent to candidates: <br />
      <br />
    </p>
	<?php echo $this->Form->create("CandidateEmailMessage",array('type'=>'post'));?>
    <table width="100%">
      <tbody>
        <tr>
          <td valign="middle" align="right">1. Standard: <br></td>
          <td valign="middle" align="left"><textarea rows="20" cols="60" name="data[CandidateEmailMessage][msg1]"><?php echo nl2br($emailmessge1);?>
</textarea>
          </td>
        </tr>
		<tr>
          <td valign="middle" align="right">2. Open house:<br></td>
          <td valign="middle" align="left"><textarea rows="20" cols="60" name="data[CandidateEmailMessage][msg2]"><?php echo nl2br($emailmessge2);?>
</textarea>
          </td>
        </tr>
		<tr>
          <td valign="middle" align="right">3. Custom:<br></td>
          <td valign="middle" align="left"><textarea rows="20" cols="60" name="data[CandidateEmailMessage][msg3]"><?php echo nl2br($emailmessge3);?>
</textarea>
          </td>
        </tr>
        <tr>
          <td></td>
          <td>
		  <input type="hidden" name="data[CandidateEmailMessage][msg_id]" value="<?php echo $emailmessgeID ?>" />
		  <input type="submit" class="cursorclass ui-state-default ui-corner-all" name="operation" value="Update"></td>
        </tr>
      </tbody>
    </table>
    <?php echo $this->Form->end();?>
  </div>
</div>
