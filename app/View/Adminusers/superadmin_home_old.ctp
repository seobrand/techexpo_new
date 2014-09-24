<?php  $this->set('title_for_layout', 'Admin - Home'); //add a link to breadcrumb ?>
<div id="right2">
  <!-- table -->
  <div class="box1">
    <!-- box / title -->
    <div class="title-pad">
      <div class="title">
        <h5 style="width:97%;"><div style="float:left;">Dashboard</div><div style="float:right;font-weight:bold;">Visitor Count : 	
		<?php //echo $counter;?></div></h5>
        <div class="search">
          <div class="input"> </div>
          <div class="button"> </div>
        </div>
      </div>
    </div>
   
    <!-- end box / title -->
    <!-- display box / first -->
    <div class="display_row">
      <div class="display_left">
        <div class="table">
          <table>
            <thead>
              <tr>
                <th colspan="2" class="center">New Clients</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="left">Company Name</th>
                <th class="left">Date</th>
              </tr>
             <?php 
				  if(count($Client)>0) {  
				  	foreach($Client as $Client)	 { ?>
              <tr>
                <td class="small_title"><?php echo $Client['Client']['company_name'];?></td>
                <td class="big_date" style="text-align:left;"><?php	echo date(DATE_FORMAT,strtotime($Client['Client']['created'])); ?></td>
              </tr>
              <?php } }
					else {?>
              <tr>
                <td class="small_title"></td>
                <td class="big_date" style="text-align:left;"></td>
              </tr>
              
              <tr>
                <td class="small_title" colspan="2">No Client available.</td>
              </tr>
             <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="display_right">
        <div class="table">
          <table>
            <thead>
              <tr>
                <th colspan="4" class="center">Client Vacancy Submitted</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="left">Contact Name</th>
                <th class="left">Company Name</th>
                <th style="text-align:left;">Date</th>
                <th class="left">Job Vacancy</th>
              </tr>
          
              <tr>
                <td class="title" colspan="4">No Job available.</td>
              </tr>
              
            
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- display box / first end here -->
    <!-- display box / second -->
    <div class="display_row">
      <div class="display_left">
        <div class="table">
          <table>
            <thead>
              <tr>
                <th colspan="2" class="center yellow">New Candidates</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="left yellow">Name</th>
                <th class="yellow" style="text-align:left;">Date</th>
              </tr>
            
               <?php 
					if(count($candidate)) {
					foreach($candidate as $candidate) {?>
              <tr>
                <td class="small_title yellow1"><?php echo $candidate['User']['first_name'].' '.$candidate['User']['last_name'];?></td>
                <td class="big_date yellow1" style="text-align:left;"><?php	echo date(DATE_FORMAT,strtotime($candidate['User']['created'])); ?></td>
              </tr>
              <?php }} else { ?>
              <tr>
                <td class="small_title yellow" colspan="2">No Candidate available.</td>
              </tr>
              <?php }?>
            
            </tbody>
          </table>
        </div>
      </div>
      <div class="display_right">
        <div class="table">
          <?php /*?><table>
            <thead>
              <tr>
                <th colspan="5" class="center yellow">Candidate Timesheet Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="left yellow">Temp Name</th>
                <th class="left yellow">Client/Company Name</th>
                <th class="left yellow">W/E Date</th>
                <th class="yellow">Kings Status</th>
                <th class="yellow">Client Status</th>
              </tr>
			  <?php if(is_array($timesheets) && count($timesheets)) { 
			    foreach($timesheets as $timesheet) {
			   ?>
              <tr>
                <td class="title yellow"><?php echo $timesheet['Timesheet']['temp_name'];?></td>
                <td class="title yellow"><?php echo $timesheet['Timesheet']['company_name'];?></td>
                <td class="smallfield yellow"><?php echo ($timesheet['Timesheet']['weekend_time']) ? date(DATE_FORMAT,strtotime($timesheet['Timesheet']['weekend_time'])) : '';?></td>
				<?php $ks_css = (($timesheet['Timesheet']['kings_status'] == 'pending')) ? '#F60' : 'green'; ?>
				<?php $ks_css = (($timesheet['Timesheet']['kings_status'] == 'query')) ? '#FF0074' : $ks_css; ?>
                <td class="price yellow" style="color:<?php echo $ks_css;?>;"><?php echo ucfirst($timesheet['Timesheet']['kings_status']);?></span></td>
				<?php $cs_css = (($timesheet['Timesheet']['client_status'] == 'pending')) ? '#F60' : 'green'; ?>
				<?php $cs_css = (($timesheet['Timesheet']['client_status'] == 'query')) ? '#FF0074' : $cs_css; ?>
                <td class="price yellow " style="color:<?php echo $cs_css;?>;"><?php echo ucfirst($timesheet['Timesheet']['client_status']);?></span></td>
              </tr>
             <?php }
			 } ?>
            </tbody>
          </table><?php */?>
		  <?php //echo $this->element('scroller'); ?>
        </div>
      </div>
    </div>
	
    <!-- display box / second end here -->
  </div>
  <!-- end table -->
</div>