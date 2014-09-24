
<?php
echo $this->Html->css('demos');
echo $this->Html->css('jquery-ui');
 echo $this->Html->script('date/jquery.ui.core.js'); ?>
<?php  echo $this->Html->script('date/jquery.ui.datepicker.js'); ?>
<?php echo $this->Html->script('date/jquery.ui.widget.js'); ?>


<script> 
<?php  if($this->Session->check('popup')) { ?>			
popmsg (function() {
				popmsg ( "#datepicker" ).datepicker();
			});	
			<?php } ?>	
			
$(function() {
	$( "#datepicker" ).datepicker();
});
	
		</script> 
<div class="content">
  <!-- content / right -->
  <div id="right">
    <div class="box">
      <div class="breadcrumb"></div>
      <div id="right2">
        <!-- table -->
        <div class="box1">
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Send Online Resumes to BluePoint for CD inclusion</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
          <div class="display_row">
            <div class="table"> <?php echo $this->Form->create('Admincandidates',array('action'=>'', 'enctype' => 'multipart/form-data')); ?>
<table>
<tbody>
<tr>
<td valign="middle" align="left"> Send resumes to BluePoint for the following region (these are the online resumes that will be included on the CD-ROM: <br>
<br />
<?php 
echo $this->Form->input('Candidate.state_id',array('type'=>'select','options'=>$stateList,'empty'=>false,
                        'label'=>false,'class'=>'select1','div'=>'','class'=>'listbox','multiple'=>'multiple'));
?>
</td>
</tr>

<tr>
<td valign="middle" align="left"> Show date (used to create zip filename) -> NO SLASHES, eg: 03082005 <br>
<br />
<?php echo $this->Form->input('Resume.filename',array('div'=>false,'label'=>false,'maxlength'=>20,'size'=>10,'class'=>'inputbox1')); ?> 
</td>
</tr>


<tr>
<td valign="middle" align="left"> Send resumes that have been submitted since:<br>
<br />
<?php echo $this->Form->input('Resume.posteddt',array('div'=>false,'label'=>false,'maxlength'=>'10','size'=>'10','class'=>'inputbox1','id'=>'datepicker')); ?> <br />
<br>
(Enter as mm/dd/yyyy. e.g: 05/22/2001) <br></td>
</tr>
<tr>
<td valign="middle" align="left"><table>
<tr>
<td width="70px"><?php echo $this->Form->submit('Get Count',array('class'=>'cursorclass ui-state-default ui-corner-all','value'=>'get count','name'=>'count')); ?> </td>
<td><?php   echo $this->Form->input('Registration.SUBMIT',array('type'=>'hidden','div'=>false,'label'=>'false','value'=>'Submit'));
echo $this->Form->submit('Send !',array('class'=>'cursorclass ui-state-default ui-corner-all','value'=>'Send','name'=>'Send')); 
?></td>
</tr>
</table></td>
</tr>
<tr>
<td><?php
if($resumeTotalAll)
{?>
Total Resumes = 
<?php

 if(isset($resumeTotalAll) && is_numeric($resumeTotalAll) && isset($csv_file_name) && $csv_file_name!='' && file_exists(WWW_ROOT.'candidateXlsDocuments/'.$csv_file_name))
 { ?>
	<a href="<?php echo FULL_BASE_URL.router::url('/',false).'admincandidates/downloadFile/candidateXlsDocuments/'.$csv_file_name; ?>" title="click to download csv file"><?php echo $resumeTotalAll; ?></a>
<?php 
}else{  echo $resumeTotalAll; } 
 } 
 
 if(isset($resumeTotalAll) && $resumeTotalAll==0) echo "Total Resumes = No Records Found";
   ?>
</td>
</tr>
</tbody>
</table>
              <?php $this->end();?>
            </div>
          </div>
        </div>
      
      </div>
    </div>
  </div>
 
</div>