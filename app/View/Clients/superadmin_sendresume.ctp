<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Send Resumes To Clients</div>
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
    <p><strong>E-mail a resume database to a client</strong><br /></p>
	<?php if(isset($url) && $url!=''){?>
		<?php echo $this->Html->link('Download Zip File from Here', '/clientDocument/ResumeBluePrint/'.$url);?>
		<!--<a href="http://<?php echo $_SERVER['SERVER_NAME']."".$url;?>"><?php echo $_SERVER['SERVER_NAME']."".$url;?></a><br>-->
	<?php }elseif(isset($toemails) && $toemails!=''){?>
		<font face="Verdana,Geneva,Arial,Helvetica,sans-serif" size="1">E-mail sent to <?php echo $toemails;?><br></font>
	<?php }else{ // create Form from here ?>
	<?php echo $this->Form->create("SendResume",array('type'=>'post'));?>
    <table width="100%">
      <tbody>
        <tr>
          <td valign="middle" align="left"><strong>1. Select a database to e-mail:</strong> <br/><br />
            <?php echo $this->Form->input('resume_set_id',array('type'=>'select','options'=>$resume_sets,'div'=>false,'label'=>false));?>
			<br />
          </td>
        </tr>
        <tr>
          <td valign="middle" align="left"><strong>2. Choose whether you wantto e-mail this file to clients directly through the site or download it to your hard drive and e-mail it manually at your leisure (will save time if you need to e-mail it to other clients later on).</strong>
:<br/><br />
            <select id="SendResumeMethodId" name="data[SendResume][method]">
				<option value="email">E-mail directly through the site</OPTION>
				<option value="download">Download to hard drive</OPTION>
			</select>
			<br />
          </td>
        </tr>
        <tr>
          <td valign="middle" align="left"><strong>3.  If you are e-mailing the resumes directly, please fill out the fields below. If you are dowloading them, ignore the fields below.</strong><br/><br /><br/>
		  <strong>Subject</strong> : 
            <?php echo $this->Form->input('subject',array('div'=>false,'label'=>false,'class'=>'inputbox1'));?>
            <br/>
            <br/><br/><strong>List of recipent e-mails (separated by commas):</strong><br/><br/>
            <?php echo $this->Form->input('to',array('type'=>'textarea','div'=>false,'label'=>false,'class'=>'inputbox1'));?>
            <br/><br/><strong>Message</strong>:<br/><br/>
            <?php echo $this->Form->input('message',array('type'=>'textarea','div'=>false,'label'=>false,'class'=>'inputbox1'));?>
          </td>
        </tr>
        <tr>
          <td><?php echo $this->Form->submit('Go Ahed',array('div'=>false,'label'=>false,'class'=>'cursorclass ui-state-default ui-corner-all'));?></td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->end();?>
	<?php } ?>
  </div>
</div>
