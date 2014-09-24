<?php 
$firstyear="2004";
if(date("m")>=11)
	$thisyear = date("Y",mktime(0,0,0,date('m'),date('d'),date('Y')+1));
else
	$thisyear  = date("Y");
	
$cnt = 0;
?>
<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Assign resume databases to: <?php echo $common->getEmployerName($employerID) ?>
</div>
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
<?php if(!isset($showcontent)){?>
  <div class="table">
<input type="button" name="CheckAll" value="Check All" onClick="CheckAll()" class="cursorclass ui-state-default ui-corner-all">
<input type="button" name="UncheckAll" value="Uncheck All" onClick="UncheckAll()" class="cursorclass ui-state-default ui-corner-all"><br/><br/>
  	<?php echo $this->Form->create("ResumeSetRule",array('name'=>'resumeDB'));?>
    <table cellspacing="0" cellpadding="0" border="0" align="left">
      <tbody>
        <tr valign="top" align="left">
		<?php for($year=$thisyear; $year>=$firstyear; $year--){ $cnt++;?>
          <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Year <?php echo $year;?></b></font><br>
            <br>
            <br>
			<?php $resumesetList = $common->getResumeSet($year);?>
			<?php foreach($resumesetList as $key => $resumeSet){?>
					<?php if(in_array($resumeSet['ResumeSetRule']['set_id'], $employerSetID, true) !== false){?>
						<input type="checkbox" id="ResumeIsAssign" value="<?php echo $resumeSet['ResumeSetRule']['set_id'];?>" name="data[ResumeSetRule][isAssign][]" checked="checked">
						&nbsp; <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $resumeSet['ResumeSetRule']['set_descr'];?></font><br><br>
					<?php }else{ ?>
						<input type="checkbox" id="ResumeIsAssign" value="<?php echo $resumeSet['ResumeSetRule']['set_id'];?>" name="data[ResumeSetRule][isAssign][]">
						&nbsp; <font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $resumeSet['ResumeSetRule']['set_descr'];?></font><br><br>
					<?php } // endif?>
			<?php } // end foreach?>
            </td>
		<?php } // end for ?>
        </tr>
        <tr>
          <td colspan="<?php echo $cnt;?>">
            <?php echo $this->Form->submit('Assign',array('name'=>'Submit','class'=>'cursorclass ui-state-default ui-corner-all','div'=>false));?></td>
        </tr>
      </tbody>
    </table>
	<?php echo $this->Form->end();?>
  </div>
<?php }else{ ?>
<div class="table">
    <table cellspacing="0" cellpadding="0" border="0" align="left">
      <tbody>
        <tr valign="top" align="center">
			<td width="100%"></td><?php echo $showcontent;?></td>
        </tr>
      </tbody>
    </table>
  </div>
<?php } ?>
</div>
<script type="text/javascript">
function CheckAll()
{
	var c = new Array();
	  c = document.getElementsByTagName('input');
	  for (var i = 0; i < c.length; i++)
	  {
		if (c[i].type == 'checkbox')
		{
		  c[i].checked = true;
		}
	  }
	
}

function UncheckAll()
{
	var c = new Array();
	  c = document.getElementsByTagName('input');
	  for (var i = 0; i < c.length; i++)
	  {
		if (c[i].type == 'checkbox')
		{
		  c[i].checked = false;
		}
	  }
}
</script>