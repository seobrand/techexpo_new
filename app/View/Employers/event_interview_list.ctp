<?php //pr($interviewList);?>
<div id="wrapper">
  <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Scheduled Interview List</h1>
          <div class="content">
            <div class="jobseeker_info">
              <p><strong><?php echo $this->Session->read('Auth.Client.employerContact.contact_name');?>'s Account Management Center </strong><br />
                <?php //echo date("l, d/m/Y - h:i A T");?>
				<?php 
					$date = new DateTime("@".time());
					$date->setTimezone(new DateTimeZone('UTC'));   
					echo $date->format("l, d/m/Y - h:i A T");  // Pacific time</p>
				?></p>
            </div>
            <br />
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="115" style="text-align:left">Candidate name</th>
                      <th width="125" style="text-align:left">Years of experience</th>
                      <th width="115" style="text-align:left">E-mail candidate</th>
                      <th width="95" style="text-align:left">View Resume</th>
                      <th width="75" style="text-align:center">Download Resume</th>
                    </tr>
                  </table></td>
              </tr>
			  <?php if(count($interviewList)>0){?>
			  <?php foreach($interviewList as $key =>$interview){?>
              <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="115" style="text-align:left"><?php echo $interview['Candidate']['candidate_name'];?></td>
                      <td  width="125" class="normalfont" style="text-align:left" valign="middle"><?php echo $common->getExperienceValue($interview['Candidate']['experience_code']);?></td>
					  
                      <td  width="115" class="normalfont" style="text-align:left"><a href="mailto:<?php echo $interview['Candidate']['candidate_email'];?>"><?php echo $this->Html->image("images/email-candidate.gif",array('alt'=>"Email to candidate"));?></a> </td>
					  
                      <td  width="95" class="normalfont" style="text-align:left"><?php echo $this->Html->link($this->Html->image("images/view-resume-detail.gif",array('alt'=>"View Resume Detail")),array('controller'=>'folders','action'=>'showResume',$interview['Resume']['id']),array('escape'=>false)); ?></td>
                      <td  width="75" class="normalfont last" style="text-align:center"><a href="<?php echo $this->webroot;?>candidateDocument/resume/resume_<?php echo $interview['Resume']['id'];?>.rtf"><?php echo $this->Html->image("images/download-resume.gif",array('alt'=>"Download Resume"));?></a></td>
                    </tr>
                  </table></td>
              </tr>
			  <?php } ?>
			  <?php }else{?>
			  <tr>
                <td class="table_row border_bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td colspan="5">There is no cadidate assigned for interview..</td>
                    </tr>
                  </table></td>
              </tr>
			  <?php } ?>
            </table>
            <br />
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?> 
  </div>
</div>
