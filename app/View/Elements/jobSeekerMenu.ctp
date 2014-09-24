<div class="topMenu">
  <ul>
    <li ><?php  echo $this->Html->link("Dashboard",array('controller'=>'candidates','action'=>'candidateprofile','Jobseeker'=>true)); ?></li>
    <li> <?php  echo $this->Html->link("Manage Resumes",array('controller'=>'resumes','action'=>'resumelist','Jobseeker'=>true)); ?></li>
    <li> <?php  echo $this->Html->link("Event Registration",array('controller'=>'shows','action'=>'eventList','Jobseeker'=>true)); ?> </li>
    <li> <?php  echo $this->Html->link("Search Jobs",array('controller'=>'candidates','action'=>'searchJob','Jobseeker'=>true)); ?> </li>
    <li> <?php  echo $this->Html->link("Track Applications",array('controller'=>'candidates','action'=>'trackApplication','Jobseeker'=>true)); ?> </li>
    <li> <?php  echo $this->Html->link("Research Companies",array('controller'=>'candidates','action'=>'searchCompanies','Jobseeker'=>true)); ?> </li>
   <!-- <li ><?php  echo $this->Html->link("Higher Education",array('controller'=>'candidates','action'=>'higherEducationPlan','Jobseeker'=>true)); ?></li>-->
    <li class="last"><?php  echo $this->Html->link("Videos",array('controller'=>'candidates','action'=>'videoList','Jobseeker'=>true)); ?></li>
    
  <?php /*?>  <li class="last"><?php  echo $this->Html->link("Interviews",array('controller'=>'candidates','action'=>'InterviewLists','Jobseeker'=>true)); ?></li><?php */?>
    
  </ul>
</div>