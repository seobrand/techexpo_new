<?php
App::uses('AppController', 'Controller'); 

class ShowsController extends AppController {

 	var $layout = 'admin'; //this is the layout for admin panel     
    var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array('Candidate','User','Code','Resume','Show','Registration','ShowEmployer','Employer','ResumeSetRule','ResumeSet');
	
	public function superadmin_index() { 	
		
		$this->set('meta_title','Event Shows');
		$this->Show->recursive = 0;

		$argArr = array();
		if(isset($this->params['pass'][0]) && isset($this->params['pass'][1]) && $this->params['pass'][1] == 'page_record') {
			$this->Session->write('per_page_record',$this->params['pass'][0]);
		}
		
		$this->set('argArr', $argArr);                
		$record = ($this->Session->read('per_page_record')) ? $this->Session->read('per_page_record') : ADMIN_PER_PAGE_RECORD;			
		
        $this->paginate = array('limit' =>$record,'order' => array('Show.show_dt' => 'DESC'));
        $data = $this->paginate('Show');
        //pr($data);
		$this->set('shows', $data);	
		
	}
	
	/**
 * superadmin_add method
 *
 * @return void
 */
	public function superadmin_add() {
		$errors ='';
		$this->set('meta_title','Add New Show');
		// load cleaerence keywords
		$this->set("ck",$this->common->getGovCleareanceList());  
		// Generate list
		$this->set('loc_list',$this->common->getLocationList());
		
		$this->set('resume_set',$this->common->getResumeList());
		
		if($this->request->is('post')){		
			
			$this->Show->set($this->request->data);	
			
			if(!$this->Show->validates()){		
				$errors = $this->Show->validationErrors;                            
			}	
			if($errors) {			
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				if(isset ($this->request->data['Show']['sec_clearance_list'])); // 31/10
				$this->request->data['Show']['sec_clearance_list'] 	= implode(",",$this->request->data['Show']['sec_clearance_list']);
				
				if(is_uploaded_file($this->request->data['Show']['show_confirm_file']['tmp_name'])) {
					$con_filename = $this->request->data['Show']['show_confirm_file']['name'];
					move_uploaded_file($this->request->data['Show']['show_confirm_file']['tmp_name'],WWW_ROOT.'ShowsDocument/showConfirmFile/'.$con_filename);
					$this->request->data['Show']['show_confirm_file'] 		= $con_filename;
				}else{
					$this->request->data['Show']['show_confirm_file'] 		= "";
				}
				
				if(is_uploaded_file($this->request->data['Show']['show_guide_file']['tmp_name'])) {
					$guide_filename = $this->request->data['Show']['show_guide_file']['name'];
					move_uploaded_file($this->request->data['Show']['show_guide_file']['tmp_name'],WWW_ROOT.'ShowsDocument/showGuide/'.$guide_filename);
					$this->request->data['Show']['show_guide_file'] 			= $guide_filename;
				}else{
					$this->request->data['Show']['show_guide_file'] 			= "";
				}
				
				if(is_uploaded_file($this->request->data['Show']['ics_file']['tmp_name'])) {
					$ics_filename = $this->request->data['Show']['ics_file']['name'];
					move_uploaded_file($this->request->data['Show']['ics_file']['tmp_name'],WWW_ROOT.'ShowsDocument/showGuide/'.$ics_filename);
					$this->request->data['Show']['ics_file'] 			= $ics_filename;
				}else{
					$this->request->data['Show']['ics_file'] 			= "";
				}
				
				if(is_uploaded_file($this->request->data['Show']['boutique_banner_file']['tmp_name'])) {
					$banner_filename = $this->request->data['Show']['boutique_banner_file']['name'];
					move_uploaded_file($this->request->data['Show']['boutique_banner_file']['tmp_name'],WWW_ROOT.'ShowsDocument/boutiqueBanner/'.$banner_filename);
					$this->request->data['Show']['boutique_banner_file'] 			= $banner_filename;
				}else{
					$this->request->data['Show']['boutique_banner_file'] 			= "";
				}
				
					//pr($this->request->data);die;

				if ($this->Show->save($this->request->data)) {
					$this->Session->write('popup','Show has been added successfully.');
					$this->Session->setFlash('Show has been added successfully.');  
					$this->redirect(array('controller'=>'shows','action' => "index/message:success"));
				}else{
					$this->Session->setFlash('Data save problem, Please try again.');  
                }					
			}	
		}
		
	}


	/**
	 * superadmin_edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function superadmin_edit($id = null) {
		$this->set('id',$id);
		$this->set('meta_title','Edit Show');
				// load cleaerence keywords
				$this->set("ck",$this->common->getGovCleareanceList());  
				// Generate list
				$this->set('loc_list',$this->common->getLocationList());
				// Generate Resume set list
				$this->set('resume_set',$this->common->getResumeList());
				//pr($resume_set);
				

		if ($this->request->is('get')) {			
				
				$this->request->data = $this->Show->find('first',array('conditions'=>array('Show.id'=>$id)));
				
				$selectedCK = explode(',',$this->request->data['Show']['sec_clearance_list']);
				$this->set('selectedCK',$selectedCK);
								
		} else {
		
				$this->set('selectedCK',$this->request->data['Show']['sec_clearance_list']);
									
				$errors ='';				
				$this->Show->set($this->request->data);	
							
				if(!$this->Show->validates()){		
					$errors = $this->Show->validationErrors;                            
				}	
				if($this->request->data['Show']['show_confirm_file']['name']!=''){
					if(!$this->Show->uploadShowConfirmFile()) 
					{
						$errors = $this->Show->validationErrors;	
					}
				}
				if($this->request->data['Show']['ics_file']['name']!=''){
					if(!$this->Show->uploadShowIcsFile()) 
					{
						$errors = $this->Show->validationErrors;	
					}
				}
				if($this->request->data['Show']['boutique_banner_file']['name']!=''){
					if(!$this->Show->uploadShowBannerFile()) 
					{
						$errors = $this->Show->validationErrors;	
					}
				}
				
				if($errors) {		
					if(is_array($this->request->data['Show']['show_confirm_file'])){
						$this->request->data['Show']['show_confirm_file'] = $this->request->data['Show']['show_confirm_file']['name'];
					}
					if(is_array($this->request->data['Show']['show_guide_file'])){
						$this->request->data['Show']['show_guide_file'] = $this->request->data['Show']['show_guide_file']['name'];
					}
					if(is_array($this->request->data['Show']['ics_file'])){
						$this->request->data['Show']['ics_file'] = $this->request->data['Show']['ics_file']['name'];
					}
					if(is_array($this->request->data['Show']['boutique_banner_file'])){
						$this->request->data['Show']['boutique_banner_file'] = $this->request->data['Show']['boutique_banner_file']['name'];
					}	
					$this->Set('errors',$errors);
					$this->set('data',$this->request->data);
				}else{
					if(isset ($this->request->data['Show']['sec_clearance_list'])); // 31/10
					$this->request->data['Show']['sec_clearance_list'] 		= implode(",",$this->request->data['Show']['sec_clearance_list']);
					// call upload component
					
					if(!$this->request->data['Show']['keep_conf_same']) {
						if($this->request->data['Show']['old_conf_file'])
							unlink(WWW_ROOT.'ShowsDocument/showConfirmFile/'.$this->request->data['Show']['old_conf_file']);
							
						if($this->request->data['Show']['show_confirm_file']['error']==4){
							$this->request->data['Show']['show_confirm_file'] = '';
						}else{
								$con_filename = $this->request->data['Show']['show_confirm_file']['name'];
								move_uploaded_file($this->request->data['Show']['show_confirm_file']['tmp_name'],WWW_ROOT.'ShowsDocument/showConfirmFile/'.$con_filename);
								$this->request->data['Show']['show_confirm_file'] 			= $con_filename;
						}
					}else{
						$this->request->data['Show']['show_confirm_file'] 		= $this->request->data['Show']['old_conf_file'];
					}
					
					
					if(!$this->request->data['Show']['keep_guide_same']) {
						if($this->request->data['Show']['old_guide_file'])
							unlink(WWW_ROOT.'ShowsDocument/showGuide/'.$this->request->data['Show']['old_guide_file']);
							
						if($this->request->data['Show']['show_guide_file']['error']==4){
							$this->request->data['Show']['show_guide_file'] = '';
						}else{
								$guide_filename = $this->request->data['Show']['show_guide_file']['name'];
								move_uploaded_file($this->request->data['Show']['show_guide_file']['tmp_name'],WWW_ROOT.'ShowsDocument/showGuide/'.$guide_filename);
								$this->request->data['Show']['show_guide_file'] 			= $guide_filename;
						}
					}else{
						$this->request->data['Show']['show_guide_file'] 		= $this->request->data['Show']['old_guide_file'];
					}
					
					if(!$this->request->data['Show']['keep_ics_same']) {
						if($this->request->data['Show']['old_ics_file'])
							unlink(WWW_ROOT.'ShowsDocument/ics/'.$this->request->data['Show']['old_ics_file']);
							
						if($this->request->data['Show']['ics_file']['error']==4){
							$this->request->data['Show']['ics_file'] = '';
						}else{
							$ics_filename = $this->request->data['Show']['ics_file']['name'];
							move_uploaded_file($this->request->data['Show']['ics_file']['tmp_name'],WWW_ROOT.'ShowsDocument/ics/'.$ics_filename);
							$this->request->data['Show']['ics_file'] 	= $ics_filename;
						}
					}else{
						$this->request->data['Show']['ics_file'] 	= $this->request->data['Show']['old_ics_file'];
					}
					
					if(!$this->request->data['Show']['banner_not_upload']) {
						if($this->request->data['Show']['old_boutique_file'])
							unlink(WWW_ROOT.'ShowsDocument/boutiqueBanner/'.$this->request->data['Show']['old_boutique_file']);

						if($this->request->data['Show']['boutique_banner_file']['error']==4){
							$this->request->data['Show']['boutique_banner_file'] = '';
						}else{
								$buot_filename = $this->request->data['Show']['boutique_banner_file']['name'];
								move_uploaded_file($this->request->data['Show']['boutique_banner_file']['tmp_name'],WWW_ROOT.'ShowsDocument/boutiqueBanner/'.$buot_filename);
								$this->request->data['Show']['boutique_banner_file'] 	= $buot_filename;
						}
					}else{
						$this->request->data['Show']['boutique_banner_file'] 		= $this->request->data['Show']['old_boutique_file'];
					}
					//pr($this->request->data);die;
	
					if ($this->Show->save($this->request->data)) {
						$this->Session->write('popup','Show has been updated successfully.');
						$this->Session->setFlash('Show has been updated successfully.');  
						$this->redirect(array('controller'=>'shows','action' => "index/message:success"));
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'shows','action' => "edit",$id));
					}
										
				}	
				
		}
		
		
	}


/**
 * superadmin_delete method
 *
 * @param string $id
 * @return void
 */
	public function superadmin_delete($id = null) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}else{
			$this->request->data = $this->Show->find('first',array('conditions'=>array('Show.id'=>$id)));
			// call upload component
			if($this->request->data['Show']['show_confirm_file'])
				unlink(WWW_ROOT.'img/ShowsDocument/'.$this->request->data['Show']['show_confirm_file']);
				
			if($this->request->data['Show']['show_guide_file'])
				unlink(WWW_ROOT.'img/ShowsDocument/'.$this->request->data['Show']['show_guide_file']);
				
			if($this->request->data['Show']['ics_file'])
				unlink(WWW_ROOT.'img/ShowsDocument/'.$this->request->data['Show']['ics_file']);
				
			if($this->request->data['Show']['boutique_banner_file'])
				unlink(WWW_ROOT.'img/ShowsDocument/'.$this->request->data['Show']['boutique_banner_file']);
			
			if ($this->Show->delete($id)) {
				$this->Session->write('popup','Show has been deleted successfully.');
				$this->Session->setFlash('Show has been deleted successfully.');  
				$this->redirect(array('controller'=>'shows','action' => "index/message:success")); 
			} else {
				$this->Session->setFlash('Deletion problem, Please try again.');  
				$this->redirect(array('controller'=>'shows','action' => "index"));
			}
		}
	}
	public function superadmin_view($id = null) {
		$this->Show->id = $id;
		if (!$this->Show->exists()) {
			throw new NotFoundException(__('Invalid show'));
		}
		$this->set('show', $this->Show->read(null, $id));
	}
	
	public function eventregistration()
	{
	
		$this->layout = 'front';
		$showListArray=$this->common->getShowList();  // experince array
		$this->set('showListArray',$showListArray);
			
		
		if($this->Session->read('candidateUserName') && $this->Session->read('candidateId')):
			$this->request->data['Registration']['candidate_id']=$this->Session->read('candidateId');
						
			if($this->request->data):
				if(!empty($this->request->data['Registration']['Submit'])):
				
					
					$this->Registration->set($this->request->data);
						
					if(!$this->Registration->eventValidate()):
						//$errorsArr = $this->Registration->validationErrors;	
					else:
						$this->request->data['Registration']['date_time']=date('Y-m-d',time());
							if($this->Registration->saveAll($this->request->data)):
								$this->Session->delete('candidateUserName');
								$this->Session->delete('candidateId');
								$this->redirect(array('controller'=>'candidates','action'=>'thankyou'));
							endif;
					endif;
						
				endif;
		
			endif;
			
		else:
			if($this->Session->read('candidateUserName')):
				$this->Session->write('UserName',$this->Session->read('candidateUserName'));
				$this->Session->delete('candidateUserName');
				$this->redirect(array('controller'=>'resumes','action'=>'resume'));
			else:
				$this->redirect(array('controller'=>'candidates','action'=>'register'));
			endif;
		endif;
	}
	
	
	public function jobseeker_eventRegister($showID = null)  // register for an event
	{
		if($showID)
		{
			$this->request->data['Registration']['show_id']=$showID;
			$this->set('Show',$showID);
		}
		
		$this->layout = 'front';
		
		$showListArray=$this->common->getShowList();  // experince array
		
		$this->set('showListArray',$showListArray);
		
		$this->request->data['Registration']['candidate_id']=$this->Session->read('Auth.Client.User.candidate_id');
			
		if(!empty($this->request->data)):
			
			
				if(!empty($this->request->data['Registration']['Submit'])):
				
					$this->Registration->set($this->request->data);
						
					if(!$this->Registration->eventValidate()):
						//$errorsArr = $this->Registration->validationErrors;	
					else:
						$this->request->data['Registration']['date_time']=date('Y-m-d',time());
						$this->request->data['Registration']['vip']='n';
							if($this->Registration->saveAll($this->request->data)):
								$this->Session->delete('candidateUserName');
								$this->Session->delete('candidateId');
								$this->Session->write('popup','Successfully register for event.');
								$this->redirect(array('controller'=>'shows','action'=>'eventRegister'));
							endif;
					endif;
						
				endif;
		
			endif;
		
		//echo 'sadf';die;
	}

	public function Jobseeker_eventList()  // function for event listing 
	{
		
		$this->layout = 'front';
		
		$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
		//	$condition  = " ";	
		
		//and show.show_dt >= "'.$targetdate.'"
		$this->paginate = array(
					'conditions'=>'Registration.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'" ',
					'order'=>'Registration.id DESC',
					'paramType' => 'querystring',
					'limit'=>'10'
				);
		
		$eventList= $this->paginate('Registration');
		
		
				
		$this->set('eventList',$eventList);
	}
	
/*	public function superadmin_createSet()
	{ 
		$this->layout = false;
		
		$errors ='';
		
			
		// add and edit form Show List in current year 
		$this->Show->recursive = -1;	
		$showRecords  =	$this->Show->find('all',array('conditions'=>array('Show.show_dt >= '=>date('y').'-01-01'),'fields'=>array('Show.show_name','Show.show_dt','Show.id')));	
		$this->set('showRecords',$showRecords);	
		
		if(is_array($this->request->data) && $this->request->is('post'))  {	
			
			
			 $this->ResumeSetRule->set($this->request->data['Show']);
			
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
						    $results2 = Set::extract('/Resume/id', $join2);
						
							$result_sets = array_merge($results1,$results2);
                            
							foreach($result_sets as $result_set)
							{
								$data['ResumeSet']['set_id'] = $getLastInsertId;
								$data['ResumeSet']['resume_id'] = $result_set;
								$this->ResumeSet->save($data,array('validate'=>false));
							}
							
							
							    $this->Session->write('Set','Set has been created successfully.');
                                $this->Session->setFlash('Set has been created successfully.');  
                                $this->redirect(array('controller'=>'sets','action' => "index/message:success"));
                            }else {
                                $this->Session->setFlash('Data save problem, Please try again.');  
                            }	
                        }//end if not error
                }// end if of check data array
		
		
		}
	*/
	
	public function eventDetail()
	{
		$this->layout = 'front';
		$eventList=$this->Registration->find('all',array('conditions'=>'Registration.candidate_id="'.$this->Session->read('Auth.Client.User.candidate_id').'"'));
		$this->set('eventList',$eventList);
		//pr($eventList);
	}
	
	public function view($id = null)
	{
		$this->layout = 'front';
		
		if($id)
		{
			$eventDetail=$this->Show->find('first',array('conditions'=>'Show.id="'.$id.'"'));
			$this->set('shows',$eventDetail);	
			
		}
		
		if($this->request->is('get')){
			// get only one month old events
			$condition  = "Show.id = ".$id." ";	
			$eventInfo = $this->Show->find("first",array('conditions'=>array($condition)));
			$this->set('regEventInfo',$eventInfo);
			// get the list of other employers who are also registered with this event
			$options['joins'] = array(
				array('table' => 'show_employers',
					'alias' => 'ShowEmployer',
					'type' => 'inner',
					'conditions' => array(
						'ShowEmployer.employer_id = Employer.id',
						'ShowEmployer.payment_status' => 'y',
						'ShowEmployer.show_id = '.$id						
					)
				)
			);
			$this->Employer->recursive = 1;
			$otherRegEmployer = $this->Employer->find('all', $options);
			
			$this->set('otherRegEmployer',$otherRegEmployer);
		}
		
	}
	
	public function index()
	{
	
		$this->layout = 'front';
		$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
		
		$shows=$this->Show->find('all',array('conditions'=>array('show_dt>="'.$targetdate.'"'),
												'limit'=>'20'));
		$this->set('shows',$shows);
		
	}
	function beforeFilter() 
	{ 
		parent::beforeFilter();
		
		 
		if($this->Session->read('Auth.Client.User.user_type')=='C')
		{
			$this->Auth->allow('eventregistration','Jobseeker_eventList','jobseeker_eventRegister','eventDetail');
		}
		
		$this->Auth->allow('eventregistration','index','view','createSet');
		
   	}



}


function beforeSave($created) {
    
    
}