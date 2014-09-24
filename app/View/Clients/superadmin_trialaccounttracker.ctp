<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">24 HOUR TRIAL ACCOUNT TRACKER</div>
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
    <table border="0" cellpadding="0" cellspacing="0" >
      <thead>
        <tr>
          <th valign="middle" align="left">Sales Rep</th>
          <th valign="middle" align="left">Company</th>
          <th valign="middle" align="left">Contact</th>
          <th valign="middle" align="left">End of Trial</th>
        </tr>
      </thead>
      <tbody>
	  <?php foreach($tracks as $key =>$track){?>
        <tr>
          <td valign="middle" align="left"><?php echo $track['TrialAccountTrack']['sales_rep'];?></td>
          <td valign="middle" align="left"><?php echo $track['TrialAccountTrack']['company'];?></td>
          <td valign="middle" align="left"><?php echo $track['TrialAccountTrack']['contact'];?></td>
          <td valign="middle" align="left"><?php echo date("m/d/Y h:i:s A",strtotime($track['TrialAccountTrack']['trial_end_date']));?></td>
        </tr>
       <?php } ?>
	   <?php if(count($tracks)==0){?>
	   <tr><td colspan="4" align="center">No trial account found</td></tr>
	   <?php } ?> 
      </tbody>
    </table>
  </div>
</div>
