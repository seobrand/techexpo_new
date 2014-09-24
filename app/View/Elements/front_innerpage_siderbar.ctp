<?php 	 if($this->Session->read('Auth.Client.Candidate.id')!='')
			{
				echo $this->element('jobSeekerSidebar', array('cache' => true)); 
				
			}elseif($this->Session->read('Auth.Client.employerContact.id')!='')
			{
				echo $this->element('employer_left_panel');
			}else
			{
				echo $this->element('main_upcoming_events_leftbar', array('cache' => true)); 
				echo $this->element('main_login_leftbar', array('cache' => true)); 
       			
			} ?>
