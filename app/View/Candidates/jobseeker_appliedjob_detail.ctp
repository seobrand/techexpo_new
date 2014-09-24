<div id="wrapper"> <?php echo $this->element('jobSeekerMenu', array('cache' => true)); ?>
  <div id="container"> <?php echo $this->element('jobSeekerSidebar', array('cache' => true)); ?>
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Job posting Details</h1>
          <div class="content">
            <div class="clear"></div>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <div class="clear"></div>
              <br />
              <h2 class="mana_subheading">Summary Information</h2>
              <ul class="form_list manage_resume_form">
                <li>
                  <label>Position Title:</label>
                  <div class="form_rt_col1">
                    <label><?php echo $jobPostingDetail['JobPosting']['job_title']; ?></label>
                  </div>
                </li>
                <li>
                  <label>Posted on:</label>
                  <div class="form_rt_col1">
                    <label>05/03/2012</label>
                  </div>
                </li>
                <li>
                  <label>Short Description:</label>
                  <div class="form_rt_col1">
                    <label><?php echo $jobPostingDetail['JobPosting']['short_descr']; ?></label>
                  </div>
                </li>
                <li>
                  <label>Location:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getWorkLocation($jobPostingDetail['JobPosting']['work_location_code']) ?> </label>
                  </div>
                </li>
                <li>
                  <label>Work type:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getWorkTypeCode($jobPostingDetail['JobPosting']['work_type_code']) ?> </label>
                  </div>
                </li>
                <li>
                  <label>Working Time:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getWorkTimeCode($jobPostingDetail['JobPosting']['work_time_code']) ?> </label>
                  </div>
                </li>
                <li>
                  <label>Position Type:</label>
                  <div class="form_rt_col1">
                    <label> Terms: Permanent   Location: On-Site Only    Hours: Full Time</label>
                  </div>
                </li>
                <li>
                  <label>Salary Type:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getSalaryType($jobPostingDetail['JobPosting']['salary_type_code']) ?> </label>
                  </div>
                <li>
                  <label>Start Date:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $jobPostingDetail['JobPosting']['start_dt']; ?> </label>
                  </div>
                </li>
                <li>
                  <label>Last Date:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $jobPostingDetail['JobPosting']['end_dt']; ?></label>
                  </div>
                </li>
                <li>
                  <label>Security clearance required: </label>
                  <div class="form_rt_col1">
                    <label>Top Secret w/ Full Scope Lifestyle Poly</label>
                    <br />
                  </div>
                </li>
              </ul>
              <div class="preview_panel">
                <h2 class="mana_subheading">Full Description</h2>
                <?php echo $jobPostingDetail['JobPosting']['full_descr']; ?> </div>
              <br />
              <div class="clear"></div>
            </div>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="clear"></div>
    <?php echo $this->element('partners', array('cache' => true)); ?> </div>
</div>
