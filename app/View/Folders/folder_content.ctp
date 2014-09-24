<?php   
// for facny box
	echo $this->Html->script('front_js/jquery.colorbox.js');
	echo $this->Html->css('front_css/colorbox.css');
?>
<script type="application/javascript">
$(document).ready(function() {
			$(".ajaxnew").colorbox({width:'350px', height:'310px'});
});

function validform()
{
  var email = $("#email").val();
   if(email=='')
   {
   alert("please enter email.");
   	return false;
   }
 
}
</script>

<div id="wrapper"> <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Folder Content</h1>
          <div class="content">
            <h2>Contents of folder titled: <?php echo $foldername;  ?> (<?php echo count($folderContent); ?> resumes)</h2>
            <h2>Please read carefully:</h2>
            <ul class="list">
              <li>Click on a column heading to sort by that column</li>
              <li>Click on the candidate's name to e-mail him / her</li>
              <li>Date Posted indicates the date on which the resume was posted</li>
              <li>Copy and Move will copy or move the resume AND attached notes to the selected folder</li>
              <li>You can only move or copy a resume to a folder OTHER than the current one<br />
                (hence, you need at least 2 folders to copy or move)</li>
              <li>Use the e-mail field below to send an e-mail with all the resumes in this folder<br />
                attached as text files, or send a mass e-mail to all the candidates within that folder (see message in red below)</li>
            </ul>
            <br />
            <h2>Email Resumes in Folder</h2>
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <p><strong>Email ALL the resumes filed in this folder</strong></p>
              <br />
              <h2>IMPORTANT NOTES:</h2>
              <ul class="list">
                <li>If your folder contains more than 10 resumes, they will be packed in a ZIP file before being e-mailed. PC users will need WinZip or equivalent. Macintosh users will need ZipIt or StuffIt.</li>
                <li>If your folder contains duplicate resumes, the total number you will receive by e-mail will be less than the current count for this folder, as resumes are de-duped before being e-mailed.</li>
              </ul>
              <?php echo $this->Form->create('Folder',array('name'=>'resumeMail','id'=>'resumeMail','action'=>'folderContent/'.$folder_id.'/sendmail'));?>
              <ul class="form_list manage_resume_form">
                <li>
                  <label> E-mail address to send resumes to:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('email',array('label'=>false,'class'=>'big237_textfield','div'=>false));?> </div>
                </li>
                <li>
                  <label>Message / Notes:</label>
                  <div class="form_rt_col1"> <?php echo $this->Form->input('mailnotes',array('type'=>'textarea','label'=>false,'class'=>'textarea_237 textarea_220','div'=>false,'style'=>"width:225px;"));?> </div>
                </li>
                <li>
                  <label></label>
                  <div class="form_rt_col1"> <?php echo $this->Form->submit('images/submit_btn.jpg',array('div'=>false,'name'=>'Submit'));?> </div>
                </li>
              </ul>
              <?php echo $this->Form->end();?> <span class="instruction">Alternatively, you can also send a MASS E-MAIL to all the candidates
              whose resumes are filed in this folder by <?php echo $this->Html->link('clicking here', array('controller'=>'folders','action'=>'massEmail',$folder_id),array('escape'=>false,'target'=>'blank')); ?></span> </span> </div>
            <br />
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_hd"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th width="98"><a href="">Candidate Name</a></th>
                      <th width="158"><a href="">Resume Title &amp; <br />
                        Primary Skills</a></th>
                      <th width="68"><a href="">Date <br />
                        Posted</a></th>
                      <th width="58"><a href="">My Notes</a></th>
                      <!--    <th width="58"><a href="">OFCCP <br />
Tracking</a></th>
     -->
                    </tr>
                  </table></td>
              </tr>
            </table>
            <?php if(count($folderContent) > 0){ foreach($folderContent as $fc) { ?>
            <table class="tableWhd" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="table_row"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td  width="98" style="text-align:left !important;"><?php echo $this->Html->link($fc['Candidate']['candidate_name'], array('controller'=>'folders','action'=>'showResume',$fc['FolderContent']['e_resume_id']),array('escape'=>false,'target'=>'blank')); ?><br />
     <?php 	echo $this->Html->image('envalop_new.png',array('style'=>'margin-top:10px;')); ?> 
                        <span style="position:absolute;margin:12px 0 0 15px">
      
                         <a href="mailto:<?php echo $fc['Candidate']['candidate_email']; ?>"> 
                             (Send e-mail)</a></span></td>
                      <td  width="158" style="text-align:left"> <?php echo $fc['Resume']['resume_title'];  ?>
                        <!--<strong>Status:</strong> <a href="">Update Status</a><br />

<span>
You have already viewed this resume<br />
Resume first viewed on: 05/18/2012</span><br />
<br />
                        Resume filed to : --><?php // echo $foldername;   ?> </td>
                      <td  width="68"><?php if(isset($fc['Resume']['posted_dt'])) echo  date(DATE_FORMAT,strtotime($fc['Resume']['posted_dt'])); else echo "N/A"  ;  ?></td>
                      <td  width="58"><?php echo $this->Html->link('Notes', array('controller'=>'folders','action'=>'updatenotes/'.$fc['FolderContent']['fc_id']),array('class'=>'ajaxnew','escape'=>false)); ?> </td>
                      <!--  <td  width="58" class="last"><a href="">See Info</a></td>-->
                    </tr>
                  </table></td>
              </tr>
            </table>
            <br />
            <ul class="footer_btn">
              <li style="padding:0px"> <?php  echo $this->Html->link('View Resume', array('controller'=>'folders','action'=>'showResume',$fc['FolderContent']['e_resume_id']),array('escape'=>false,'target'=>'blank','class'=>'front_button_new'));  ?> 
              </li>
              
              <li style="padding:0px"> <?php echo $this->Html->link('Download Resume', array('controller'=>'folders','action'=>'exportResume',$fc['FolderContent']['e_resume_id']),array('escape'=>false,'class'=>'front_button_new')); ?> </li>
              
               <li style="padding:0px"> <?php echo $this->Html->link('Remove from Folder', array('controller'=>'folders','action'=>'removeResume',$fc['FolderContent']['folder_id'],$fc['FolderContent']['fc_id']),array('escape'=>false,'confirm' => 'Are you sure to remove resume?','class'=>'front_button_new')); ?> </li>
               
              <li style="padding:0px" > <?php echo $this->Html->link('Forward by Email', array('controller'=>'folders','action'=>'mailResume',$fc['FolderContent']['e_resume_id']),array('target'=>'blank','escape'=>false,'class'=>'front_button_new')); ?> </li>
            </ul>
            <div class="clear"></div>
            <br />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>Copy to Folder:</td>
                <?php echo $this->Form->create(array('name'=>'resumeFolder','id'=>'resumeFolder','action'=>'copyresume/'.$fc['FolderContent']['folder_id']));?> <?php echo $this->Form->hidden('fc_id',array('value'=>$fc['FolderContent']['fc_id']));?>
                <td width="120"><?php echo $this->Form->input('copy_folder_id',array('label'=>false,'options'=>$folderList,'class'=>'resume_dropdown','type'=>'select','div'=>false));?></td>
                <td width="65"><?php echo $this->Form->submit('Copy',array('div'=>false,'name'=>'Submit','value'=>'Copy','class'=>'front_button_new' ));?></td>
                <?php echo $this->Form->end();?>
                <td width="20">&nbsp;</td>
                <td >Move to Folder:</td>
                <?php echo $this->Form->create(array('name'=>'resumeFolder','id'=>'resumeFolder','action'=>'moveresume/'));?> <?php echo $this->Form->hidden('fc_id',array('value'=>$fc['FolderContent']['fc_id']));?>
                <td width="120"><?php echo $this->Form->input('move_folder_id',array('label'=>false,'options'=>$folderList,'class'=>'resume_dropdown','type'=>'select','div'=>false));?></td>
                <td> <?php echo $this->Form->submit('Move',array('div'=>false,'name'=>'Submit','value'=>'Move','class'=>'front_button_new'));?></td>
                <?php echo $this->Form->end();?> </tr>
            </table>
            <br/>
            <br/>
            <br/>
            <?php } } else {  ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:10px;text-align:center;font-weight:bold;">
              <tr>
                <td>No resume in this folder</td>
              </tr>
            </table>
            <?php  } ?>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel'); ?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?> </div>
</div>
