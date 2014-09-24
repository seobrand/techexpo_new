<?php //pr($employerDetail);?>
<div id="wrapper">
  <?php echo $this->element('employer_tabs');?>
  <div id="container">
    <div class="lf_col_inner">
      <div class="whiteB_head"></div>
      <div class="whiteB_mid">
        <div class="whiteB_bottom">
          <h1 class="bluecolor">Company Profile </h1>
          <div class="content">
            <h2 class="border_botom"><?php echo $employerDetail['Employer']['employer_name'];?></h2>
            <br />
            <div class="gray_full_top"></div>
            <div class="gray_full_mid">
              <ul class="form_list manage_resume_form">
                <li>
                  <label>City:</label>
                  <div class="form_rt_col1">
                    <label> <?php echo $employerDetail['Employer']['city'];?></label>
                  </div>
                </li>
                <li>
                  <label>State:</label>
                  <div class="form_rt_col1">
                    <label><?php echo $employerDetail['Employer']['state'];?></label>
                  </div>
                </li>
                <li>
                  <label>Web URL:</label>
                  <div class="form_rt_col1">
                    <label> <a href="<?php echo $employerDetail['Employer']['url'];?>" target="_blank"><?php echo $employerDetail['Employer']['url'];?></a></label>
                  </div>
                </li>
                <li>
                  <label>Stock Symbol:</label>
                  <div class="form_rt_col1">
                    <label><?php echo $employerDetail['Employer']['stock_symbol'];?></label>
                  </div>
                </li>
                <li>
                  <label>Annual Revenue:</label>
                  <div class="form_rt_col1">
                    <label> <?php if($employerDetail['Employer']['annual_revenue']!='') echo "$".$employerDetail['Employer']['annual_revenue'];?></label>
                  </div>
                </li>
                <li>
                  <label>Number of Employees:</label>
                  <div class="form_rt_col1">
                    <label><?php echo $employerDetail['Employer']['number_of_employees'];?></label>
                  </div>
                </li>
                <li>
                  <label>Answer to the question "Do you occasionally sponsor H1-B visas ?"</label>
                  <div class="form_rt_col1">
                    <label><?php echo ucfirst($employerDetail['Employer']['visa_status']);?></label>
                  </div>
                </li>
                <li>
                  <label>Industry: </label>
                  <div class="form_rt_col1">
                    <label> <?php echo $common->getIndustriesName($employerDetail['Employer']['employer_type_code']);?></label>
                  </div>
                </li>
                <li>
                  <label>Detailed Description: </label>
                  <div class="form_rt_col1">
                    <label><?php echo nl2br($employerDetail['Employer']['employer_name']);?></label>
                  </div>
                </li>
              </ul>
              <div class="preview_panel">
                <h2 class="border_botom"><?php echo $employerDetail['Employer']['employer_name'];?>'s Open Jobs </h2>
				<?php $employerOpenJobs = $employerDetail['JobPosting'];?>
				<?php if(count($employerOpenJobs)>0){ $i = 0; ?>
					<?php foreach($employerOpenJobs as $key => $empopenjobs){?>
							<?php if($empopenjobs['active']){?>
							<p><strong><?php echo $this->Html->link($empopenjobs['job_title'],array('controller'=>'employers','action'=>'jobdetail',$empopenjobs['posting_id']));?></strong><br />
						 <?php echo nl2br($empopenjobs['short_descr']);?></p>
							<?php $i++; } ?>
					 <?php } ?> 
				<?php } ?>
				<?php if(count($employerOpenJobs)==0 || $i==0){ ?>
					<p>There is no open jobs of this compnay..</p>
				<?php }?>  
              </div>
              <br />
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php echo $this->element('employer_left_panel');?>
    <div class="clear"></div>
    <?php echo $this->element('partners');?>
  </div>
</div>
