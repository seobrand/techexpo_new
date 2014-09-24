<?php  echo $this->element('admin-breadcrumbs',array('pageName'=>'lastVisit')); ?>
<div id="right2"> 
        <!-- table -->
        <div class="box1"> 
          <!-- box / title -->
          <div class="title-pad">
            <div class="title">
              <h5 style="width:97%;">
                <div style="float:left;">Site Wide Resumes</div>
                <div style="float:right;font-weight:bold;"></div>
              </h5>
              <div class="search">
                <div class="input"> </div>
                <div class="button"> </div>
              </div>
            </div>
          </div>
          <strong><p>Number of Candidates: <?php echo $cand_count; ?></p>
            <p>Number of Resumes:  <?php echo $resume_count; ?></p>
            <p> Number of Employers:  <?php echo $employer_count; ?></p>
           	<p> Number of Active Job Postings:  <?php echo $postings_count; ?></p>
            <p>Number of Employers with postings: <?php echo $employer_pcount;  ?></p>
            <p>Number of Applications Sent: <?php echo $application_count; ?></p></strong><br />
    <div class="display_row">
      <div class="table">
        <table border="0" cellpadding="0" cellspacing="0" >
         <thead>
            <tr>
              <th valign="middle" align="left">Employer</th>
              <th valign="middle" align="left">Contact</th>
              <th valign="middle" align="left">Postings</th>
              <th valign="middle" align="left">Applications</th>
            </tr>
            </thead>
             <tbody>
                 <?php     //pr($employerLastVisits);exit;           
                if(is_array($resume_dt) && count($resume_dt)>0){
                    foreach ($resume_dt as $resume_dt){ 
                      
                ?>
                 <tr>
                      <td valign="middle" align="left"><?php echo $resume_dt['Employer']['employer_name']; ?></td>
                      <td valign="middle" align="left"><?php if(isset($resume_dt['EmployerContact']['contact_name'])) echo $resume_dt['EmployerContact']['contact_name'];?></td>
                      <td valign="middle" align="left"><?php echo $resume_dt['0']['cnt_p']; ?></td>
                      <td valign="middle" align="left"> <?php echo $resume_dt['0']['cnt_c']; ?>
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
                <div style="float:left;">Resume with job</div>
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
              <th valign="middle" align="left">Title</th>
              <th valign="middle" align="left">Employer</th>
    		    <th valign="middle" align="left">Contact</th>
              <th valign="middle" align="left">Applications</th>
            </tr>
            </thead>
             <tbody>
                 <?php     //pr($employerLastVisits);exit;           
                if(is_array($jobresume_dt) && count($jobresume_dt)>0){
                    foreach ($jobresume_dt as $jobresume_dt){ 
             
                ?>
                 <tr>
                      <td valign="middle" align="left"><?php echo $jobresume_dt['JobPosting']['job_title']; ?></td>
                      <td valign="middle" align="left"><?php if(isset($jobresume_dt['Employer']['employer_name'])) echo $jobresume_dt['Employer']['employer_name'];?></td>
         		         <td valign="middle" align="left"><?php echo $jobresume_dt['EmployerContact']['contact_name']; ?></td>
                          <td valign="middle" align="left"><?php echo $jobresume_dt['0']['ascnt']; ?></td>  
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
      
      