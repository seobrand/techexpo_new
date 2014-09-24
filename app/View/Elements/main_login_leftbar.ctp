<div class="side_box sidesearch_box">
          <div class="gray_side_head"></div>
          <div class="gray_side_mid">
            <div class="gray_side_bottom">
              <ul class="gray_action_list">
                <li class="aligncenter">
                  <h1>JOB SEEKERS</h1>
                  
                  <?php echo $this->Html->link($this->Html->image('images/side_submitresume.jpg'),array('controller'=>'candidates','action'=>'register'),array('escape'=>false));?>
                 
                   </li>
                <li class="aligncenter">
                  <h1>EMPLOYERS</h1>
                  <?php 
				  if($this->Session->read('Auth.Client.Candidate.id'))
				  { 
				   echo $this->Html->link($this->Html->image('images/side_post.jpg'),array('controller'=>'users','action'=>'index'),array('escape'=>false));
				  }
				  else if($this->Session->read('Auth.Client.employer.id'))
				  {
				   echo $this->Html->link($this->Html->image('images/side_post.jpg'),array('controller'=>'employers','action'=>'emppostjob'),array('escape'=>false));
				  }else
				  {
				  	echo $this->Html->link($this->Html->image('images/postjob.jpg'),array('controller'=>'users','action'=>'jobposting'),array('escape'=>false));
				  }
				   ?>
                  
                   </li>
                <li class="last aligncenter">
                  <h1>RECRUIT WITH US</h1>
                  
                   <?php 
				  if($this->Session->read('Auth.Client.Candidate.id'))
				  { 
				   echo $this->Html->link($this->Html->image('images/side_become_btn.jpg'),array('controller'=>'users','action'=>'index'),array('escape'=>false));
				  }
				  else if($this->Session->read('Auth.Client.employer.id'))
				  {
				   echo $this->Html->link($this->Html->image('images/side_become_btn.jpg'),array('controller'=>'employers','action'=>'emppostjob'),array('escape'=>false));
				  }else
				  {
				  	echo $this->Html->link($this->Html->image('images/side_become_btn.jpg'),array('controller'=>'users','action'=>'recruitWithUs'),array('escape'=>false));
				  }
				   ?>
              </li>
              </ul>
            </div>
          </div>
 </div>