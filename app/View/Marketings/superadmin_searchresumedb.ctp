<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Export Resumes for Mail and Mass E-mail Campaigns OR Export Resumes as TEXT FILES to send to clients </div>
      <div style="float:right;font-weight:bold;"></div>
    </h5>
    <div class="search">
      <div class="input"> </div>
      <div class="button"> </div>
    </div>
  </div>
</div>
<div class="display_row">
  <div class="table"> <br />
    <p><b><u><blink>VERY IMPORTANT:</blink></u> <a href="#" onclick="">CLICK HERE TO READ <i style="background-color: Yellow;">UPDATED</i> RESUME SEARCH INSTRUCTIONS AND TIPS</a></b></p>
    <br />
	<?php echo $this->Form->create('Folders',array('action'=>'searchRegResult','type'=>'GET'));?>
    <table cellpadding="0" cellspacing="0" border="0">
      <tbody>
        <tr valign="middle">
          <td align="right" valign="middle">Keywords:</td>
          <td align="left" colspan="2" valign="top" nowrap=""><?php echo $this->Form->input('keyword',array('class'=>'inputbox1','div'=>false,'label'=>false)); ?>
            &nbsp;
            <?php $option=array('All'=>'All Words','Exact'=>'Exact Phrase','Any'=>'Any Words');
                 echo $this->Form->input('keyword_matching',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'div'=>'','style'=>'font-size: x-small; font: x-small;')); ?></td>
        </tr>
        <tr valign="middle">
          <td align="right" valign="middle">State:</td>
          <td colspan="2" valign="top" align="left"><?php $state_list = $theComponent->getStateList();
							echo $this->Form->input('state_list', array(
							'type' => 'select', 
							'options' => $state_list, 
							'multiple' => 'checkbox',
							'div'=>false,
							'label'=>false,
							'style'=>'font-size: x-small; font: x-small'
							)
							)
						
					   ?>
            press Ctrl key for multiple states<br></td>
        </tr>
        <tr valign="middle">
          <td align="right" valign="middle">Citizenship 
            Status:</td>
          <td colspan="2" valign="top" align="left"><?php 
					$options=array('Y'=>'Yes','N'=>'No');
					$attributes=array('legend'=>false,'style'=>'font-size: x-small; font: x-small');
					echo $this->Form->radio('relocate',$options,$attributes);
					?>
            &nbsp;&nbsp; Min. years of Exp: &nbsp;&nbsp;
            <?php  $experience_code = $theComponent->getExperienceList();
			  echo $this->Form->input('experience_code',array('label'=>'','options'=>$experience_code,'type'=>'select','style'=>'font-size: x-small; font: x-small;','error'=>false,'div'=>false,'label'=>false,'style'=>'font-size: x-small; font: x-small'));
			   ?></td>
        </tr>
        <tr valign="top">
          <td align="right" valign="middle">Security clearance level desired (optional):<br></td>
          <td colspan="2" valign="top" align="left"><?php   $cleareance_list = $theComponent->getGovCleareanceList();
							
							echo $this->Form->input('cleareance_list', array(
							'type' => 'select', 
							'options' => $cleareance_list, 
							'multiple' => 'checkbox',
							'div'=>false,
							'label'=>false,
							'style'=>'font-size: 12 px;'
							)
							)
						
					   ?>
            <br>
            Hold down the control / command key to select several options<br>
            <font color="000066" size="1" face="verdana,arial,helvetica,sans-serif line-height:16px;">If you wish to see a security category added to the list, <a href="mailto:sberk@TechExpoUSA.com?subject=Please add a security category to your list"><strong>please click here</strong></a>. </font><br>
            <font face="Verdana, Arial, Helvetica, sans-serif" size="1" style="background-color: Yellow; line-height:16px;">If you selected "Other Active Clearance" in the above menu, you may enter security clearance search keywords here (click on instructions link above for detailed instructions)</font><br>
            <?php echo $this->Form->input('advanceSearch',array('class'=>'inputbox1','div'=>false,'label'=>false)); ?>
            <br>
            <?php echo $this->Form->checkbox('advance',array('div'=>false,'label'=>false)); ?>
            Check to perform an<b> ADVANCED BOOLEAN SEARCH</b> (read instructions).</td>
        </tr>
        <tr valign="middle">
          <td valign="middle" align="right"> Look for resumes in: </td>
          <td valign="top" align="left" colspan="2"><?php echo $this->Form->input('resumelast',array('class'=>'small_Texfield','div'=>false,'label'=>false)); ?></td>
        </tr>
        <tr valign="middle">
          <td valign="middle" align="right"> OPTIONAL: Look for resumes submitted in the last: </td>
          <td colspan="2" valign="top" align="left">
		  <?php 
			$option=array('days'=>'days','weeks'=>'weeks','months'=>'months','years'=>'years');
			 echo $this->Form->input('resumelast_matching',array('type'=>'select','options'=>$option,'empty'=>false,'label'=>false,'class'=>'work_location_code','div'=>'','style'=>'font-size: 12px;')); ?></td>
        </tr>
        <tr valign="middle">
          <td valign="middle" align="right">&nbsp;&nbsp; </td>
          <td valign="top" align="left" colspan="2"><a href="resume_search.html">
            <input type="submit" name="operation" value="Submit"  class="cursorclass ui-state-default ui-corner-all" align="absmiddle">
            </a></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
