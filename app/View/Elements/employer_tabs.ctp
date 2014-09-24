<div class="topMenu employerMenu">
  <ul class="other_menu">
    <li><?php echo $this->Html->link('DASHBOARD',array('controller' => 'employers', 'action' => 'dashboard'));?></li>
    <li><?php echo $this->Html->link('MANAGE ACCOUNT',array('controller' => 'employers', 'action' => 'manageaccount'));?></li>
    <li><?php echo $this->Html->link('EVENTS',array('controller' => 'employers', 'action' => 'empevent'));?> </a></li>
    <li><?php echo $this->Html->link('EMPLOYER PREPARATION',array('controller' => 'employers', 'action' => 'empeventprep'));?></li>
    <li><?php echo $this->Html->link('PRE-REG RESUMES',array('controller' => 'folders', 'action' => 'searchRegCandidate'));?></li>
    <li><?php echo $this->Html->link('JOBS',array('controller' => 'employers', 'action' => 'joblists'));?></li>
    <li><?php echo $this->Html->link('RESUME FOLDER',array('controller' => 'folders', 'action' => 'resumefolder'));?></li>
    
    <li class="last"><?php echo $this->Html->link('VIDEOS',array('controller' => 'employers', 'action' => 'empJobseekerVideo'));?> </a>
       <ul class="sub_menu">
            <li><?php echo $this->Html->link('My Videos',array('controller' => 'employers', 'action' => 'empVideo'));?></li>
             <li><?php echo $this->Html->link('Job Seekers Videos',array('controller' => 'employers', 'action' => 'empJobseekerVideo'));?></li>
            </ul>
       </li>
  <?php /*?>  <li class="last"><?php echo $this->Html->link('INTERVIEWS',array('controller' => 'employers', 'action' => 'empinterview'));?></li><?php */?>
  </ul>
</div>
