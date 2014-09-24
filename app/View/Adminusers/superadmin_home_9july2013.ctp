<div class="title-pad">
  <div class="title">
    <h5 style="width:97%;">
      <div style="float:left;">Dashboard</div>
      <!--<div style="float:right;font-weight:bold;">Visitor Count : 24372</div>-->
    </h5>
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
            <th class="left" width="50%">Company Name</th>
            <th class="left">Date</th>
          </tr>
		  <?php foreach($employer as $key =>$client){?>
          <tr>
            <td class="small_title"><?php echo $this->Html->link($client['Employer']['employer_name'], array('controller'=>'clients','action'=>'clientdetail',$client['Employer']['id'],$client['EmployerContact']['id']),array('target' => '_blank')); ?></td>
            <td class="big_date" style="text-align:left;"><?php echo $client['EmployerContact']['created'];?></td>
          </tr>
		  <?php } ?>
		  <?php if(count($employer)>8){?>
		  <tr>
            <td colspan="2" align="right"><?php echo $this->Html->link("View More",array('controller'=>'clients','action'=>'allnewclient'));?></td>
          </tr>
		  <?php } ?>
		  <?php if(count($employer)==0){?>
		  <tr>
            <td colspan="2" align="center">No New Client Found.</td>
          </tr>
		  <?php } ?>
        </tbody>
      </table>
      <span style="text-align:right;float:left;width:100%;padding:5px 5px 0px 0px;"><?php echo $this->Html->link("Show All",array('controller'=>'clients','action'=>'allnewclients'));?></span>
    </div><br/> 
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
            <th class="yellow" style="text-align:left;">Email</th>
          </tr>
        
          <?php foreach($candidateRec as $value) {?>
          <tr>
            <td class="small_title yellow1">
            
            <?php echo $this->Html->link($value['Candidate']['candidate_name'], array('controller'=>'admincandidates','action'=>'candidateDetail',$value['Candidate']['id']),array('target' => '_blank')); ?>
            </td>
            <td class="big_date yellow1" style="text-align:left;"><?php echo $value['Candidate']['candidate_email'] ?></td>
          </tr>
           <?php } ?>
            <tr>
            <td colspan="2" align="right"><?php echo $this->Html->link("Show All",array('controller'=>'admincandidates','action'=>'candidateDetail'));?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div class="display_right">
    <div class="table">
      <table width="100%">
        <thead>
          <tr>
            <th colspan="4" class="center">Client Vacancy Submitted</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="left">Contact Name</th>
            <th class="left">Company Name</th>
            <th class="left" style="text-align:left;">Date</th>
            <th class="left">Job Vacancy</th>
          </tr>
		  <?php if(count($jobs)==0){?>
          <tr>
            <td class="title" colspan="4">No Job available.</td>
          </tr>
		 <?php }else{?>
		 	<?php foreach($jobs as $job){?>
				<tr>
					<td width="25%"><?php echo $common->getEmployerContactName($job['JobPosting']['employer_id']); ?></td>
					<td width="25%"><?php echo $job['Employer']['employer_name']; ?></td>
					<td width="15%"><?php echo $job['JobPosting']['start_dt']; ?></td>
					<td><?php echo $job['JobPosting']['job_title'];
					 ?></td>
				  </tr>
			<?php } //end foreach ?>
		 <?php } ?> 
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- display box / first end here -->
<!-- display box / second -->
<div class="display_row">
  <div class="display_left">
    <div class="table"> </div>
  </div>
  <div class="display_right">
    <div class="table"> </div>
  </div>
</div>
