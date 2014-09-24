<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'lastVisit')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Last EMPLOYER logins</div>
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
              <th valign="middle" align="left">Company</th>
              <th valign="middle" align="left">Name</th>
              <th valign="middle" align="left">Last Visited</th>
              <th valign="middle" align="left">Action</th>
            </tr>
            </thead>
             <tbody>
                 <?php     //pr($employerLastVisits);exit;           
                if(is_array($employerLastVisits) && count($employerLastVisits)>0){
                    foreach ($employerLastVisits as $employerLastVisit){ 
                        $days = floor((strtotime(date('Y-m-d')) - strtotime($employerLastVisit['EmployerLastVisit']['last_visit']))/(60*60*24));
                ?>
                 <tr>
                      <td valign="middle" align="left"><?php echo $employerLastVisit['Employer']['employer_name']; ?></td>
                      <td valign="middle" align="left"><?php if(isset($employerLastVisit['EmployerContact']['contact_name'])) echo $employerLastVisit['EmployerContact']['contact_name'];?></td>
                      <td valign="middle" align="left"><?php echo $employerLastVisit['EmployerLastVisit']['last_visit']." (".$days." days ago)";?></td>
                      <td valign="middle" align="left"> <?php echo $this->Html->link('Delete Account', array('controller'=>'employerLastVisits','action'=>'',$employerLastVisit['Employer']['id'],$employerLastVisit['EmployerContact']['id']),array('escape'=>false,'confirm' => 'You are about to delete this account. Are you sure you want to do this ?')); ?>
                      </td>
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
      
      <br /><br />
      <div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Employers without activity</div>
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
              <th valign="middle" align="left">Company</th>
              <th valign="middle" align="left">Name</th>
        
              <th valign="middle" align="left">Action</th>
            </tr>
            </thead>
             <tbody>
                 <?php     //pr($employerLastVisits);exit;           
                if(is_array($WithOutActive) && count($WithOutActive)>0){
                    foreach ($WithOutActive as $WithOutActive){ 
             
                ?>
                 <tr>
                      <td valign="middle" align="left"><?php echo $WithOutActive['Employer']['employer_name']; ?></td>
                      <td valign="middle" align="left"><?php if(isset($WithOutActive['EmployerContact']['contact_name'])) echo $WithOutActive['EmployerContact']['contact_name'];?></td>
                      <td valign="middle" align="left"> <?php echo $this->Html->link('Delete Account', array('controller'=>'employerLastVisits','action'=>'',$WithOutActive['Employer']['id'],$WithOutActive['EmployerContact']['id']),array('escape'=>false,'confirm' => 'You are about to delete this account. Are you sure you want to do this ?')); ?>
                      </td>
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
      
      