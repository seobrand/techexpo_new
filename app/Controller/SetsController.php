<?php 
/**************************************************************************
 Coder  : Keshav Sharma 
 Object : Controller to handle Area of interests add, edit and delete operation
**************************************************************************/ 
class SetsController extends AppController {
//	var $name = 'ResumeSetRule'; //Model name attached with this controller 
	var $helpers = array('Paginator'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'admin'; //this is the layout for admin panel 
	var $uses = array('Show','ResumeSetRule','Resume','User','Candidate','ResumeSet');
	/*********************************************************************
	This function call by default when a controller is called 
	Function will show list of all Area of interests
	********************************************************************/
	function superadmin_index() {
	
		$this->set('meta_title','Sets');
		/*
			select * from resume_set_rules
	where ((set_descr like '%#this_year#%') or (set_descr like '%#next_year#%'))
	order by set_descr
			*/
			
		// Resuem set rulus index listing
	 	$this_year = date('Y');
		$next_year = date('Y')+'1';
		$resumesetRecords  =	$this->ResumeSetRule->find('all',array('conditions'=>'ResumeSetRule.set_descr like "%'.$this_year.'%" or ResumeSetRule.set_descr like "%'.$next_year.'%" ','fields'=>array('ResumeSetRule.set_descr','ResumeSetRule.set_id'),'order'=>'set_descr'));	
		$this->set('resumesetRecords',$resumesetRecords);		
		
		
		}
	 /*********************************************************************
	 Function to save new set
	 **********************************************************************/
	
	 function superadmin_add() {
		$this->set('meta_title','Create New Set');	 
		$errors ='';
		
			
		// add and edit form Show List in current year 
		$this->Show->recursive = -1;	
		$showRecords  =	$this->Show->find('all',array('conditions'=>array('Show.show_dt >= '=>date('y').'-01-01'),'fields'=>array('Show.show_name','Show.show_dt','Show.id')));	
		$this->set('showRecords',$showRecords);	
		
		if(is_array($this->request->data) && $this->request->is('post'))  {	
			
		
			 $this->ResumeSetRule->set($this->request->data['Set']);
			
			if(!$this->ResumeSetRule->validates()){		
				$errors = $this->ResumeSetRule->validationErrors;                            
			}
			$start_dt = $this->request->data['Set']['start_dt'];
			$end_dt  =  $this->request->data['Set']['end_dt'];
			if($start_dt > $end_dt){
				$errors['start_dt'][0] = 'The start date cannot be greater than the end date';
			}
			if($errors) {			
			 	$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{ 
						if(isset($this->request->data['show']))
						{
						$showlist =	implode(',',$this->request->data['show']);	
						$this->request->data['ResumeSetRule']['source_code'] = $showlist;	
						}
					 
					   	$this->request->data['ResumeSetRule']['set_type'] = '1';		
						
				            if($this->ResumeSetRule->save($this->request->data,array('validate'=>false))) {
							
								// all data fatch condition for insert data in  resume set 
								
								$getLastInsertId = $this->ResumeSetRule->getLastInsertId();
							$this->ResumeSet->query("delete FROM resume_sets where set_id=".$getLastInsertId);
							//  union 1st condition
							$this->Candidate->unbindModel(array('hasOne' => array('User')));
							$this->Candidate->recursive = 0;
							//get record of current year
							$options['joins'] = array(
								array('table' => 'resumes',
									'alias' => 'Resume',
									'type' => 'inner',
									'conditions' => array(
										"Resume.candidate_id = Candidate.id"
									)
								)
							);
							$start_dt = $start_dt.' 00:00:00';
							$end_dt = $end_dt.' 00:00:00';
							$options['conditions'] = ' ( Resume.posted_dt BETWEEN \''.$start_dt.'\' and \''.$end_dt.'\' )   and	Resume.source_code=0 ';
						  
						  
						  // custom_clause match condition						  
							if(isset($this->request->data['Set']['custom_clause']))
							{
								$resume_content = $this->request->data['Set']['custom_clause'];
								$options['conditions'].= ' and Resume.resume_content like \'%'.$resume_content.'%\' ';	
							}
						  
							// pref_locations match condition						  
							if(isset($this->request->data['Set']['state_list']))
							{
								$stateLists1 =  str_replace(',','\',\'',$this->request->data['Set']['state_list']);
								$options['conditions'].= ' and (  Candidate.candidate_state in (\''.$stateLists1.'\')  ';
							
								$stateLists2 = explode( ',',$this->request->data['Set']['state_list']);
								foreach($stateLists2 as $stateList)
								{ 
								$options['conditions'].= ' or Candidate.pref_locations like "%'.$stateList.'%" ';	
								}
								
								$options['conditions'].= ' ) ';
								
							}
							$options['fields'] = array('Resume.id');
							$rec = $this->Candidate->find('all', $options);
							$results1 = Set::extract('/Resume/id', $rec);
						
							
							//  union 2nd condition
							if(isset($this->request->data['show']))
							{
							$showlist2 =  str_replace(',','\',\'',$showlist);
							$this->Resume->recursive = -1;
							$join2 = $this->Resume->find('all',array('conditions'=>"Resume.source_code in ('".$showlist2."') ",'fields'=>array('Resume.id')));
							}
							
							if(!empty($join2))
							{
						    $results2 = Set::extract('/Resume/id', $join2);
							}
							else
							{
							$results2 = array(); 	
							}
							
							$result_sets = array_merge($results1,$results2);
                            
							foreach($result_sets as $result_set)
							{
								$data['ResumeSet']['set_id'] = $getLastInsertId;
								$data['ResumeSet']['resume_id'] = $result_set;
								$this->ResumeSet->save($data,array('validate'=>false));
							}
							
							
							    $this->Session->write('popup','Set has been created successfully.');
                                $this->Session->setFlash('Set has been created successfully.');  
                                $this->redirect(array('controller'=>'sets','action' => "index/message:success"));
                            }else {
                                $this->Session->setFlash('Data save problem, Please try again.');  
                            }	
                        }//end if not error
                }// end if of check data array
				
			
	 } 
	 
	public function superadmin_edit($setId = null) {
		
		$this->set('meta_title','Edit Set');	 
		$errors ='';
		
		// add and edit form Show List in current year 
		$this->Show->recursive = -1;	
		$showRecords  =	$this->Show->find('all',array('conditions'=>array('Show.show_dt >= '=>date('y').'-01-01'),'fields'=>array('Show.show_name','Show.show_dt','Show.id')));	
		$this->set('showRecords',$showRecords);	
		
		if($this->request->is('get')){
		$this->set('SetData',$this->ResumeSetRule->find('first',array('conditions'=>array('ResumeSetRule.set_id'=>$setId))));
		}
		
		
			if(is_array($this->request->data) && $this->request->is('post'))  {	
			
		
			 $this->ResumeSetRule->set($this->request->data['Set']);
			
			if(!$this->ResumeSetRule->validates()){		
				$errors = $this->ResumeSetRule->validationErrors;                            
			}
			$start_dt = $this->request->data['Set']['start_dt'];
			$end_dt  =  $this->request->data['Set']['end_dt'];
			if($start_dt > $end_dt){
				$errors['start_dt'][0] = 'The start date cannot be greater than the end date';
			}
			if($errors) {			
			 	$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{ 
						if(isset($this->request->data['show']))
						{
						$showlist =	implode(',',$this->request->data['show']);	
						$this->request->data['ResumeSetRule']['source_code'] = $showlist;	
						}
					 
					   	$this->request->data['ResumeSetRule']['set_type'] = '1';		
						$this->request->data['ResumeSetRule']['set_id'] = $setId;
				            if($this->ResumeSetRule->save($this->request->data,array('validate'=>false))) {
							
								// all data fatch condition for insert data in  resume set 
								
							
							$this->ResumeSet->query("delete FROM resume_sets where set_id=".$setId);
							//  union 1st condition
							$this->Candidate->unbindModel(array('hasOne' => array('User')));
							$this->Candidate->recursive = 0;
							//get record of current year
							$options['joins'] = array(
								array('table' => 'resumes',
									'alias' => 'Resume',
									'type' => 'inner',
									'conditions' => array(
										"Resume.candidate_id = Candidate.id"
									)
								)
							);
							$start_dt = $start_dt.' 00:00:00';
							$end_dt = $end_dt.' 00:00:00';
							$options['conditions'] = ' ( Resume.posted_dt BETWEEN \''.$start_dt.'\' and \''.$end_dt.'\' )   and	Resume.source_code=0 ';
						  
						  
						  // custom_clause match condition						  
							if(isset($this->request->data['Set']['custom_clause']))
							{
								$resume_content = $this->request->data['Set']['custom_clause'];
								$options['conditions'].= ' and Resume.resume_content like \'%'.$resume_content.'%\' ';	
							}
						  
							// pref_locations match condition						  
							if(isset($this->request->data['Set']['state_list']))
							{
								$stateLists1 =  str_replace(',','\',\'',$this->request->data['Set']['state_list']);
								$options['conditions'].= ' and (  Candidate.candidate_state in (\''.$stateLists1.'\')  ';
							
								$stateLists2 = explode( ',',$this->request->data['Set']['state_list']);
								foreach($stateLists2 as $stateList)
								{ 
								$options['conditions'].= ' or Candidate.pref_locations like "%'.$stateList.'%" ';	
								}
								
								$options['conditions'].= ' ) ';
								
							}
							$options['fields'] = array('Resume.id');
							$rec = $this->Candidate->find('all', $options);
							$results1 = Set::extract('/Resume/id', $rec);
						
							
							//  union 2nd condition
							if(isset($this->request->data['show']))
							{
							$showlist2 =  str_replace(',','\',\'',$showlist);
							$this->Resume->recursive = -1;
							$join2 = $this->Resume->find('all',array('conditions'=>"Resume.source_code in ('".$showlist2."') ",'fields'=>array('Resume.id')));
							}
							if(!empty($join2))
							{
						    $results2 = Set::extract('/Resume/id', $join2);
							}
							else
							{
							$results2 = array();
							}
							
							$result_sets = array_merge($results1,$results2);
                            
							foreach($result_sets as $result_set)
							{
								$data['ResumeSet']['set_id'] = $setId;
								$data['ResumeSet']['resume_id'] = $result_set;
								$this->ResumeSet->save($data,array('validate'=>false));
							}
							
							
							    $this->Session->write('popup','Set has been updated successfully.');
                                $this->Session->setFlash('Set has been updated successfully.');  
                                $this->redirect(array('controller'=>'sets','action' => "index/message:success"));
                            }else {
                                $this->Session->setFlash('Data save problem, Please try again.');  
                            }	
                        }//end if not error
                }
		
		
		
		
		
	}
	
	public function superadmin_deleteset($setId = null) { 
	
		if($this->request->is('get'))
		{
		
		$this->ResumeSetRule->query("delete FROM resume_set_rules where set_id=".$setId);
		$this->ResumeSet->query("delete FROM resume_sets where set_id=".$setId);
		
		  $this->Session->write('popup','Set has been deleted successfully.');
			$this->Session->setFlash('Set has been deleted successfully.');  
			$this->redirect(array('controller'=>'sets','action' => "index/message:success"));
		
		}
	
	}
		 
	/* This function is used to call before  */
	function beforeFilter() { 
	
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		
		$this->Auth->allow('login');
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','admin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'Sets', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
		
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}//end class
?>