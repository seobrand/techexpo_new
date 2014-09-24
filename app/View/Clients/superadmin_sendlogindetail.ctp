<?php //pr($this->request->data);?>

<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Company Profile</div>
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
    <table cellspacing="0" cellpadding="0" border="0">
      <tbody>
        <tr>
          <td align="left" valign="middle" colspan="2"><p>Login information was e-mailed to <strong><?php echo $this->request->data['EmployerContact']['contact_name'];?></strong>  at&nbsp;&nbsp;<strong><?php echo strip_tags($this->request->data['EmployerContact']['contact_email']);?></strong> <br>
    <br>
    You may close this window. </p></td>
        </tr>
      </tbody>
    </table>
    </div>
</div>
