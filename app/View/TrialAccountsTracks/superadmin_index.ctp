<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'trialAccounts')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
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
                 <?php                
                if(is_array($trialAccountTracks) && count($trialAccountTracks)>0){
                    foreach ($trialAccountTracks as $trialAccountTrack){ ?>
                 <tr>
                      <td valign="middle" align="left"><?php echo $trialAccountTrack['TrialAccountsTrack']['sales_rep']; ?></td>
                      <td valign="middle" align="left"><?php echo $trialAccountTrack['TrialAccountsTrack']['company'];?></td>
                      <td valign="middle" align="left"><?php echo $trialAccountTrack['TrialAccountsTrack']['contact'];?></td>
                      <td valign="middle" align="left"><?php echo $trialAccountTrack['TrialAccountsTrack']['trial_end_date'];?></td>
                  </tr>
                  <?php
                    }                
                } 
                ?>      
          </tbody>
        </table>
      </div>
    </div>
  </div>
        <!-- end table --> 
      </div>