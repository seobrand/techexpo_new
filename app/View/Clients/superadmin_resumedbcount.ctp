<?php 
$firstyear="1999";
$thisyear  = date("Y");
	
$cnt = 0;
$var = 0;
$var1 = 0;
$var2 = 0;

?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Resume Database Counts</div>
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
    <table border="0" cellpadding="0" cellspacing="0">
	<?php for($year=$thisyear; $year>=$firstyear; $year--){ $cnt++;?>
      <thead>
        <tr>
          <th align="left" colspan="3"> Year <?php echo $year; ?></th>
        </tr>
      </thead>
	  <?php $resumesetList = $common->getResumeSet($year);?>	  
	  <?php if(count($resumesetList)>0){?>
		  <?php foreach($resumesetList as $key => $resumeSet){?>
		  <?php $totalResume = $common->getResumeSetResumeCount($resumeSet['ResumeSetRule']['set_id']);?>
		  <?php // display show_name task id #3301 -Jitendra ?>
		  <?php $show_name = $common->getResumeSetShowName($resumeSet['ResumeSetRule']['set_id']);?>
			<tr>
			  <td align="left" width="35%"><?php echo $resumeSet['ResumeSetRule']['set_descr'];?><br></td>
			  <td width="35%"><?php echo $show_name;?></td>
			  <td align="left" width="20%"><?php if($totalResume>1) echo $totalResume."&nbsp resumes"; else echo $totalResume."&nbsp;resume"; ?>
			  <br></td>
			</tr>
		  <?php } // end foreach ?>
	  <?php } // end if ?>
	  <?php } // end for ?>
      <tr>
        <td align="left" colspan="3"><br>
          Number and percentage of resumes per state: (<?php echo date("Y");?> so far)<br>
          <br>
		  <?php foreach($rec as $key => $resumes){ $var = $var + $resumes[0]['cnt']; } ?>
		  <?php foreach($rec as $key => $resumes){?>
		  	<?php $percent = ($resumes[0]['cnt']/$var*100); ?>
				<?php if($resumes[0]['cnt'] > 10){?>
          			<?php echo strtoupper($resumes['Candidate']['candidate_state']);?>&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($resumes[0]['cnt']);?> (<?php echo number_format($percent,2,'.','');?>%)<br>
				<?php } ?>
         <?php } ?>
          <br>
          <br>
          Total: <?php echo $var;?> resumes  <br>
          <br>
          <br>
          Number and percentage of resumes per state: (<?php echo (date("Y")-1);?>)<br>
          <br>
         <?php foreach($rec1 as $key => $resumes1){ $var1 = $var1 + $resumes1[0]['cnt']; } ?>
		  <?php foreach($rec1 as $key => $resumes1){?>
		  	<?php $percent1 = ($resumes1[0]['cnt']/$var1*100); ?>
				<?php if($resumes1[0]['cnt'] > 10){?>
          			<?php echo strtoupper($resumes1['Candidate']['candidate_state']);?>&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($resumes1[0]['cnt']);?> (<?php echo number_format($percent1,2,'.','');?>%)<br>
				<?php } ?>
         <?php } ?>
          <br>
          <br>
          Total: <?php echo $var1;?>  resumes <br>
          <br>
          <br>
          Number and percentage of resumes per state: (<?php echo (date("Y")-2);?>)<br>
          <br>
          <?php foreach($rec2 as $key => $resumes2){ $var2 = $var2 + $resumes2[0]['cnt']; } ?>
		  <?php foreach($rec2 as $key => $resumes2){?>
		  	<?php $percent2 = ($resumes2[0]['cnt']/$var2*100); ?>
				<?php if($resumes2[0]['cnt'] > 10){?>
          			<?php echo strtoupper($resumes2['Candidate']['candidate_state']);?>&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($resumes2[0]['cnt']);?> (<?php echo number_format($percent2,2,'.','');?>%)<br>
				<?php } ?>
         <?php } ?>
          <br>
          <br>
          Total: <?php echo $var2;?> resumes <br>
          <br>
          Cumulative total: <?php echo ($var+$var1+$var2);?> resumes <br>
          <br>
          <br></td>
      </tr>
      </tbody>
      
    </table>
  </div>
</div>
