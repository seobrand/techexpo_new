<?php
App::uses('AppController', 'Controller'); 

class ShowsController extends AppController {

 	var $layout = 'admin'; //this is the layout for admin panel     
	var $helpers = array('Html','Paginator','Ajax','Javascript','Text','Number');
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
	public function superadmin_add($showId = null) {
		$errors ='';
		$this->set('meta_title','Add New Show');
		// load cleaerence keywords
		$this->set("ck",$this->common->getGovCleareanceList());  
		// Generate list
		$this->set('loc_list',$this->common->getLocationList());
		
		$this->set('resume_set',$this->common->getResumeList());
		
		// add and edit form Show List in current year 
		$this->Show->recursive = -1;	
		$showRecords  =	$this->Show->find('all',array('conditions'=>array('Show.show_dt >= '=>date('y').'-01-01'),'fields'=>array('Show.show_name','Show.show_dt','Show.id')));	
		$this->set('showRecords',$showRecords);	
		
		
		
	
		
		if($this->request->is('post')){	
		
	
		
		$resume_set_id = $this->request->data['Show']['resume_set_id']; 
		
		$this->Show->set($this->request->data);	
			
			
			if(empty($resume_set_id))
			{
				/*if(!$this->ResumeSetRule->validates()){		
					$errors = $this->ResumeSetRule->validationErrors;                            
				}*/
				$start_dt = $this->request->data['Show']['start_dt'];
				$end_dt  =  $this->request->data['Show']['end_dt'];
				/*if($start_dt > $end_dt){
					$errors['start_dt'][0] = 'The start date cannot be greater than the end date';
				}
				if($errors) {			
					$this->Set('errors',$errors);
					$this->set('data',$this->request->data);
				}*/
				
				if(empty($this->request->data['Show']['set_descr']))
   				$errors['set_descr'][0] = 'Please insert set description';
				if(empty($this->request->data['Show']['set_descr']))
   				$errors['start_dt'][0] = 'Please insert start Date';
				if(empty($this->request->data['Show']['set_descr']))
   				$errors['end_dt'][0] = 'Please insert end Date';
				if(empty($this->request->data['Show']['set_descr']))
   				$errors['state_list'][0] = 'Please insert state';
				if(empty($this->request->data['Show']['set_descr']))
   				$errors['short_desc'][0] = 'Please short description';
				
				
			}
			
			
			if(!$this->Show->validates()){		
				$errors = $this->Show->validationErrors;
			}
			
		//	$show_dt = $this->request->data['Show']['show_dt']['day']."-".$this->request->data['Show']['show_dt']['month']."-".$this->request->data['Show']['show_dt']['year'];
		//	$show_end_dt = $this->request->data['Show']['show_end_dt']['day']."-".$this->request->data['Show']['show_end_dt']['month']."-".$this->request->data['Show']['show_end_dt']['year'];
			
			$show_dt = $this->request->data['Show']['show_dt'];
			$show_end_dt = $this->request->data['Show']['show_end_dt'];
		
			
			if(strlen($show_end_dt)>2 && (strtotime($show_dt)>strtotime($show_end_dt))){
				$errors['show_dt'][0] = 'The show date cannot be greater than the show end date';
			}
			
			
			if($errors) {			
				$this->Set('errors',$errors);
				$this->set('data',$this->request->data);
			}else{
				
				//pr($this->request->data);die;	
				
				// creating set code start
				if(empty($resume_set_id))
				{
						if(isset($this->request->data['show']))
						{
						$showlist =	implode(',',$this->request->data['show']);	
						$resume_data['source_code'] = $showlist;	
						}
					 
					   	$resume_data['set_type'] = '1';	
						$resume_data['set_descr']	 = $this->request->data['Show']['set_descr'];	
						$resume_data['start_dt']	 = $this->request->data['Show']['start_dt'];	
						$resume_data['end_dt']		 = $this->request->data['Show']['end_dt'];	
						$resume_data['start_dt']	 = $this->request->data['Show']['start_dt'];	
						$resume_data['custom_clause']= $this->request->data['Show']['custom_clause'];	
						$resume_data['state_list']	 = $this->request->data['Show']['state_list'];	
						$resume_data['short_desc']	 = $this->request->data['Show']['short_desc'];	
			
			          if($this->ResumeSetRule->save($resume_data,array('validate'=>false))) {
							
								// all data fatch condition for insert data in  resume set 
								
								$getLastInsertId = $this->ResumeSetRule->getLastInsertId();
						//	$getLastInsertId = '481';
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
							if(isset($this->request->data['Show']['custom_clause']))
							{
								$resume_content = $this->request->data['Show']['custom_clause'];
								$options['conditions'].= ' and Resume.resume_content like \'%'.$resume_content.'%\' ';	
							}
						  
							// pref_locations match condition						  
							if(isset($this->request->data['Show']['state_list']))
							{
								$stateLists1 =  str_replace(',','\',\'',$this->request->data['Show']['state_list']);
								$options['conditions'].= ' and (  Candidate.candidate_state in (\''.$stateLists1.'\')  ';
							
								$stateLists2 = explode( ',',$this->request->data['Show']['state_list']);
								foreach($stateLists2 as $stateList)
								{ 
								$options['conditions'].= ' or Candidate.pref_locations like "%'.$stateList.'%" ';	
								}
								
								$options['conditions'].= ' ) ';
								
							}
						
							$options['fields'] = array('Resume.id');
							$rec = $this->Candidate->find('all', $options);
							$results1 = Set::extract('/Resume/id', $rec);
						
								
							//  union 2nd condition code commented 9 set 2013
							/*if(isset($this->request->data['show']))
							{
							$showlist2 =  str_replace(',','\',\'',$showlist);
							
							$this->Resume->recursive = -1;
							$join2 = $this->Resume->find('all',array('conditions'=>"Resume.source_code in ('".$showlist2."') ",'fields'=>array('Resume.id')));
							}
						    $results2 = Set::extract('/Resume/id', $join2);*/
							$results2 = array();
							
							$result_sets = array_merge($results1,$results2);
                            
							foreach($result_sets as $result_set)
							{
								$data['ResumeSet']['set_id'] = $getLastInsertId;
								$data['ResumeSet']['resume_id'] = $result_set;
								$this->ResumeSet->save($data,array('validate'=>false));
							}
				
				}
			}
				// creating set code end
				
			
				if(is_array($this->request->data['Show']['sec_clearance_list'])) // 31/10
				{
				$this->request->data['Show']['sec_clearance_list'] 	= implode(",",$this->request->data['Show']['sec_clearance_list']);
				}
				if(is_uploaded_file($this->request->data['Show']['show_confirm_file']['tmp_name'])) {
					$con_filename = time().'_'.$this->request->data['Show']['show_confirm_file']['name'];
					move_uploaded_file($this->request->data['Show']['show_confirm_file']['tmp_name'],WWW_ROOT.'ShowsDocument/showConfirmFile/'.$con_filename);
					$this->request->data['Show']['show_confirm_file'] 		= $con_filename;
				}else{
					$this->request->data['Show']['show_confirm_file'] 		= "";
				}
				
				if(is_uploaded_file($this->request->data['Show']['show_guide_file']['tmp_name'])) {
					$guide_filename = time().'_'.$this->request->data['Show']['show_guide_file']['name'];
					move_uploaded_file($this->request->data['Show']['show_guide_file']['tmp_name'],WWW_ROOT.'ShowsDocument/showGuide/'.$guide_filename);
					$this->request->data['Show']['show_guide_file'] 			= $guide_filename;
				}else{
					$this->request->data['Show']['show_guide_file'] 			= "";
				}
				
				if(is_uploaded_file($this->request->data['Show']['ics_file']['tmp_name'])) {
					$ics_filename = time().'_'.$this->request->data['Show']['ics_file']['name'];
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
					if(empty($resume_set_id))
					$this->request->data['Show']['resume_set_id'] = $getLastInsertId;
				//	$this->request->data['Show']['published'] = 0;
				if ($this->Show->save($this->request->data)) {
					
					$getLastInsertShowId = $this->Show->getLastInsertId();
					/* entry in show home table 06072013 */
					$this->loadModel('ShowsHome');
					$ShowData['ShowsHome']['show_id'] = $getLastInsertShowId;
					$ShowData['ShowsHome']['display_name'] = $this->request->data['ShowsHome']['display_name'];
					$ShowData['ShowsHome']['special_message'] = $this->request->data['ShowsHome']['special_message'];
					$this->ShowsHome->save($ShowData['ShowsHome'],false);
					
				//	$this->Session->write('popup','Show has been added successfully.');
				//	$this->Session->setFlash('Show has been added successfully.');  
				//	$this->redirect(array('controller'=>'shows','action' => "addstep2/".$getLastInsertShowId."/message:success"));
					$this->redirect(array('controller'=>'shows','action' => "addstep3/".$getLastInsertShowId));
				}else{
					$this->Session->setFlash('Data save problem, Please try again.');  
                }					
			}	
		}
		
		// code update 9 july 2013 comes to dashboard
		if(isset($showId))
		{
			$this->loadModel('ShowsHome');
			
			$showEntCheck = $this->ShowsHome->find('count',array('conditions'=>array('ShowsHome.show_id'=>$showId)));
			
			if($showEntCheck==1)
			{
			
				$this->request->data = $this->Show->find('first',array('joins' => array(
				array(
					'table' => 'shows_home',
					'alias' => 'ShowsHome',
					'type' => 'INNER',
					'conditions' => array(
						'ShowsHome.show_id = Show.id'
					)
				),array(
					'table' => 'resume_set_rules',
					'alias' => 'ResumeSetRule',
					'type' => 'INNER',
					'conditions' => array(
						'ResumeSetRule.set_id = Show.resume_set_id'
					)
				)
			),'fields' => array('Show.*','ShowsHome.display_name','ShowsHome.special_message','ResumeSetRule.*'),'conditions'=> array('Show.id'=>$showId)));
			
			}
			else
			{
			 $this->request->data = $this->Show->find('first',array('fields' => array('Show.*'),'conditions'=> array('Show.id'=>$showId)));
				
			}
			
			//unset resume set id for new set (Jitendra 29 july 2013 (#1311))
			$this->request->data['Show']['resume_set_id'] = "";
			$this->request->data['Show']['state_list'] = $this->request->data['ResumeSetRule']['state_list'];
			$this->request->data['Show']['set_descr'] = $this->request->data['ResumeSetRule']['set_descr'];
			$this->request->data['Show']['short_desc'] = $this->request->data['ResumeSetRule']['short_desc'];
			$this->request->data['Show']['custom_clause'] = $this->request->data['ResumeSetRule']['custom_clause'];
			
			// added 2 sep 2013
			if(!empty($this->request->data['Show']['show_special_html']))
				 {
				$this->request->data['Show']['show_special_html'] = str_replace('banners/',BASE_URL.'/uploaded/',$this->request->data['Show']['show_special_html']);
				 }
		}
		
	}
	
	public function superadmin_addstep2($showID) {
		
		  $this->loadModel('Show');
		$showDetail=$this->Show->find("first",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'INNER',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('Show.id'=>$showID)));
		
		
		App::import('Vendor', 'clsMsDocGenerator', array('file' => 'clsMsDocGenerator.php'));
	
		$doc = new clsMsDocGenerator();
		$doc->getHeader();
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		
		$doc->addParagraph('<strong>EVENT OVERVIEW</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		
		$doc->addParagraph('Event Date : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date('l,F d Y',strtotime($showDetail['Show']['show_dt'])),array('padding'=>'5px','margin-left'=>'100px','margin-top'=>'20px','font-size'=>'12px'));
		
		$doc->addParagraph('Event Location :  '.$showDetail['Location']['site_name'].'<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$showDetail['Location']['site_address'].'<br/>
															  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$showDetail['Location']['location_city'].", ".$showDetail['Location']['location_state']." ".$showDetail['Location']['site_zip'].'<br/>
															  ',array('padding'=>'5px','margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('Event Scope : &nbsp;&nbsp;&nbsp;'.$showDetail['ShowsHome']['special_message'],array('padding'=>'5px','margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>IMPORTANT CONTACT INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>Events Director : Nancy Mathew  212.655.4505 cxt. 225</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));

		/*if($showDetail['Show']['sec_clearance_req']=='y')
		$BoothSp = '2 6 foot skirted tables';
		else
		$BoothSp = '1 six foot skirted table';*/
	//	echo $showDetail['Show']['sec_clearance_list'];
		if(!empty($showDetail['Show']['sec_clearance_list']))
		{
		$secclearance_list = explode(',',$showDetail['Show']['sec_clearance_list']);
	//pr($secclearance_list);
		if(in_array(1,$secclearance_list) || in_array(3920,$secclearance_list))
		$BoothSp = '2 6 foot skirted tables';
		else
		$BoothSp = '1 six foot skirted table';
		}
		else
		$BoothSp = '1 six foot skirted table';
		
	//	echo $BoothSp;die;
		
		$doc->newPage(1);
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>BOOTH SPACE INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>Booth Specifications : '.$BoothSp.'</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>SHIPMENTS</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>All Shipments made to the TECHEXPO Top Secret Career Fair should be addressed</li> </ul>',array('padding'=>'5px','font-size'=>'12px'));
		$doc->addParagraph('TECHEXPO Top Secret <br/>
				'.$showDetail['Location']['site_name'].'<br/>
				'.$showDetail['Location']['site_address'].',<br/>
				'.$showDetail['Location']['location_city'].", ".$showDetail['Location']['location_state']." ".$showDetail['Location']['site_zip'].' ,
			<br/>HOLD FOR ARRIVAL -'.date('m/d/Y',strtotime($showDetail['Show']['show_dt'])),array('margin-left'=>'100px','font-weight'=>'bold','font-size'=>'13px'));	
		$doc->addParagraph('<ul><li><strong>SHIP NO EARLIER THAN 3 DAYS AND NO LATER THAN 1 DAY PRIOR TO THE EVENT. PLEASE REMEMBER TO BRING TRACKING #s WITH YOU TO THE EVENT</strong></li></ul>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>lf you need to ship materials after The event, please notify an EXPO representative.
Please do not leave your packages at your booth before speaking with a team member.</ul></li>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('**Job Expo International is not responsible for any lost or stolen items.**',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>ADDITIONAL EXHIBITOR INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>If you need <strong>Hotel Accommodations</strong>, please call '.$showDetail['Location']['site_name'].' at xxx.xxx.xxxx </li></ul>',array('padding'=>'5px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li><strong>Payment & Canccllation Policy:</strong></li></ul>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('Payment must be made in advance of the event date. All sales are final. Ilyou are unable to attend the actual event. we will issue you a credit to be used for any future event. Invoices 30 days past due are subject to a monthly 2% late fee. Resumes will be made available only upon receipt of payment. <br/>Cancellalion must be received in writing no less than two weeks prior to the event.',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<ul><li><strong>Advertising</strong></li></ul>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('Aside from the Marketing Campaign TECHEXPO participates in, to help draw additional aftention to your booth, please mention the event on your company web site. Many companies may choose to place their own recruitment ad in a regional newspaper. If you choose to do so you may want To include: <strong><i>Come interview with as in person at the TECHEXPO Top Secret Hiring Event at the '.$showDetail['Location']['site_name'].', '.date('l ,F d Y',strtotime($showDetail['Show']['show_dt'])).', '.$showDetail['Show']['show_hours'].'</i></strong>. <br/>A simple message with the delails of the event will draw additional candidates to yoor booth!',array('margin-left'=>'100px','font-size'=>'12px'));
		
		
		$doc->newPage(1);
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong><em>Please Complete this form ASAP and fax to 212.655.4501</em></strong>',array('text-align' => 'center','font-size'=>'13px'));
		
		$doc->addParagraph('<strong>COMPANY NAME:  ______________________</strong>',array('margin-left'=>'100px','font-size'=>'14px'));
		$doc->addParagraph('<strong>CONTACT PERSON:  ______________________</strong>',array('margin-left'=>'100px','font-size'=>'14px'));
		$doc->addParagraph('<strong>CONTACT #:  ____________________</strong>',array('margin-left'=>'100px','font-size'=>'14px'));
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,18).'&nbsp;&nbsp;&nbsp;Use these preferences for 7/16/13 ONLY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,18).'&nbsp;&nbsp;&nbsp;Use these preferences for ALL shows',array('margin-left'=>'20px','font-size'=>'12px'));
		


		$doc->addParagraph('');
		$doc->addParagraph('<strong>BOOTH LOCATION PREFERENCES</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px',));
		$doc->addParagraph('Our company prefers not to be located next to the following competitors:',array('padding'=>'10px','margin-top'=>'15px'));
		$doc->addParagraph('Competitor #1:  ____________________',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Competitor #2:  ____________________',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Competitor #3:  ____________________',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('TECHEXPO Top Secret will make every efforts to fulfill all requests, however we cannot guarantee booth placement.',array('padding'=>'10px','font-size'=>'12px'));
		
		$doc->addParagraph('');
		$doc->addParagraph('<strong>BOOTH SET UP</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('So we can best accommodate your needs, please provide as much information as you can regarding the type of booth you plan to bring:',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'15px'));
		$doc->addParagraph('Our company will have a tablecloth&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Our company will have a table-top display&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Our company will have a large display&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Other: __________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('');
		$doc->addParagraph('<strong>ADDITIONAL SHOW PREPARATION INFORMATION </strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		//$doc->addParagraph('Show date : '.date('l,F d Y',strtotime($showDetail['Show']['show_dt'])),array('padding'=>'10px'));
		$doc->addParagraph('Our company will have _____ staff members present at the event.',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'15px'));
		$doc->addParagraph('Our company would like electricity set up at our booth. (Additional '.$showDetail['Location']['site_electricity_cost'].')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('Our company would like to have an internet connection at our booth. (Additional '.$showDetail['Location']['internet_connectivity_cost'].' )&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('padding'=>'10px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>In order for TechExpo to customize its marketing to your needs, please list your top 8 positions:</strong>',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'15px'));
		$doc->addParagraph('<strong>1. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>2. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>3. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>4. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>5. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10._____________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		
		$doc->newPage(1);
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>CAREER FAIR EXHIBITOR GUIDE</strong>',array('text-align' => 'center','font-size'=>'15px'));
		
		$doc->addParagraph('<strong>WEBSITE INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<strong>Login Information:</strong>',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'20px'));
		$doc->addParagraph('<ul><li>You will receive an email from the TechExpouSA.com site giving you login infomation. It will mirror the informarion below:</li></ul>
		
				',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('<strong>Username: E-mail address<br/>
				Password: techexpo</strong>',array('margin-left'=>'160px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>Once you enter the site, you must change the password. if you are not sure which e-mail address we have on record for you, please contacl Nancy Mathew at 212.655.4505 x 225.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('<strong>Activating Your Account</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>Before an event, many candidates visit www.TechExpouSA.com to review job postings and to research employers in the job fair. It is in your companys best interest to set up your web site account by filling out your <i><b>company profile</b></i> as well as <i><b>posting jobs</b></i> ASAP, no later than 10 days prior to the job fair if possible.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>Manage Account / Company Profile </strong><br/>(Due 10 Days Before Event)',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li><strong>Update or edit your company profile and your contact information</strong>. This link will also list what resume databases you have access to. This company profile is what will be viewed publicly on our site on the event information page.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>Manage Jobs</strong>',array('padding'=>'5px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>You must post at least one job on the site. These jobs will also appear in the printed show guides given to attendees. In this show directory, you will be listed along with the first 8 job titles you post. This link allows you to post a new job, edit, refresh or delete your existing ones. Refreshing your jobs will change their posted date to today\'s date. <strong>Keywords</strong>: It is crucial that you select "keywords" from the pull down menus when posting your jobs. This will ensure that our resume matching agents will send you targeted resumes that match your criteria.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>Resume Access</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>14 Days before the event, exhibitors who have paid in full, may begin reviewing resumes early and reach out to schedule interviews with candidates that you want to be sure to meet at the TECHEXPO.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>Approximately one week after the event, resumes from the attendees will be added to the database for you to review. You will be notified via email when the show day resumes are uploaded onto the site.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		/*$doc->startTable(array('border'=>'0px'), 'tableWithoutGrid');
		$header = array('', '');
		$aligns = array('left', 'left');
		$valigns = array('middle', 'middle');
		$doc->addTableRow($header, $aligns, $valigns, array('font-weight' => 'bold', 'border'=>'opx'));
		
		
		$cols[0] = "column 1; row dfs".$doc->bufferImage('http://www.google.com.au/intl/en_au/images/logo.gif',138,55);
		$cols[1] = $doc->bufferImage('http://www.google.com.br/intl/pt-BR_br/images/logo.gif',138,55) . "column 2; row sdf";
		
		$doc->addTableRow($cols);
		
		$doc->endTable();*/
		
		$filename = time().'_'.$showID.'_Show_Packet.doc';
		
		$this->request->data['Show']['id']=$showID;
		$this->request->data['Show']['show_confirm_file']=$filename;
		$this->Show->save($this->request->data,false);
		
	//	$doc->output($filename);
		$doc->output($filename,WWW_ROOT.'ShowsDocument/showConfirmFile/');
	
		
		
		/*********** Create ICS File **************/
	
		$this->common->icalenderOrg($showID);
		
	
		
		$this->Session->write('popup','Show has been added successfully.');
		$this->Session->setFlash('Show has been added successfully.');  
	//	$this->redirect(array('controller'=>'shows','action' => "index/message:success")); apurav 06-11-2013
		$this->redirect(array('superadmin'=>true,'controller'=>'adminusers','action'=>'home/message:success'));
			
		
		
		
		
	}
	
	
	public function superadmin_addstep3($showID) {
		
		$this->set('showID',$showID);
		
		$this->loadModel('ShowsHome');
		$showEntCheck = $this->ShowsHome->find('count',array('conditions'=>array('ShowsHome.show_id'=>$showID)));
			
		
			
		$show=$this->Show->find("first",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'LEFT',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('Show.id'=>$showID)));
			
		
		
		require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php') ;
	
	//	$htmlData = file_get_contents(FULL_BASE_URL.router::url('/',false).'superadmin/shows/view_pdf/'.$showID);
		
		
		$htmlData ='<html>
<head>
<title>CAREER FAIR EXHIBITOR GUIDE</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {
	font-family: "Times New Roman", Times, serif;
	color: #000000;
}
.td1 {
	font-size: 15px; 
	text-align: right; 
	padding-top: 10px; 
	font-weight: normal;
}
.td2 {
	font-size: 15px; 
	text-align: left; 
	padding-left: 25px; 
	padding-top: 10px; 
	font-weight: normal;
}
.subhead1 {
	font-size: 15px; 
	text-align: left;
	border-bottom: solid 1px #000000;
}
.topright {
	font-size: 15px; 
	border-left: solid 1px #000000;
	padding-left: 20px; 
	font-weight: normal;
}

</style>
</head>
<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="right" width="50%" style="padding-right: 20px;padding-left:100px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/TECHEXPO_HIRINGEVENTS_PDF.png"  >
      
	</td>	
	<td class="topright" width="50%" align="left">
		276 5th Avenue, Suite 906<br />
		New York, New York 10001<br />
		(212) 655-4505 ext. 225<br />
	</td>
	</tr>
<tr><td style="font-size: 16px; text-align: center; padding-top: 15px;font-weight:bold;" colspan="3">CAREER FAIR EXHIBITOR GUIDE</td></tr>
</table>
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">EVENT OVERVIEW</td>
	</tr>
	<tr>
		<td width="25%" class="td1">Event Date:</td>
		<td width="75%" class="td2">'.date('l, F d Y',strtotime($show['Show']['show_dt'])).'</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr valign="top">
		<td width="25%" class="td1">Event Location:</td>
		<td width="75%" class="td2">'.$show['Show']['show_name'].' <br />
									'.$show['Location']['site_name'].' '.$show['Location']['site_address'].'<br />
									'.$show['Location']['location_city'].", ".$show['Location']['location_state']." ".$show['Location']['site_zip'].'<br />
									410.859.8300
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr valign="top">
		<td width="25%" class="td1">Event Scope:</td>
		<td width="75%" class="td2">'.$show['ShowsHome']['special_message'].'</td>
	</tr>
</table>	
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">EVENT SCHEDULE</td>
	</tr>
	<tr valign="top">
		<td width="25%" class="td1">'.$show['Show']['show_hours'].'</td>
		<td width="75%" class="td2">'.strip_tags($show['Show']['show_descr']).'</td>
	</tr>
</table>	
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;" >
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">IMPORTANT CONTACT INFORMATION</td>
	</tr>
	<tr valign="top">
		<td width="25%" class="td1">Events Director:</td>
		<td width="75%" class="td2">Nancy Mathew &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 212.655.4505 ext. 225</td>
	</tr>
</table>
<div style="page-break-after: always;"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" width="100%" style="padding-right: 20px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/TECHEXPO_HIRINGEVENTS_PDF.png"   >
    </td>
   </tr>
<tr><td style="font-size: 16px; text-align: center; padding-top: 15px;font-weight:bold;" >CAREER FAIR EXHIBITOR GUIDE</td></tr>
</table>

<br/><br/>';
if(!empty($show['Show']['sec_clearance_list']))
		{
		$secclearance_list = explode(',',$show['Show']['sec_clearance_list']);
	//pr($secclearance_list);
		if(in_array(1,$secclearance_list) || in_array(3920,$secclearance_list))
		$BoothSp = '2 6 foot skirted tables';
		else
		$BoothSp = '1 six foot skirted table';
		}
		else
		$BoothSp = '1 six foot skirted table';
$htmlData.='<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">BOOTH SPACE INFORMATION</td>
	</tr>
	<tr>
		<td width="25%" class="td1"  valign="top">Booth Specifications:</td>
		<td width="75%" class="td2" > 
					<li>'.$BoothSp.'</li>
					
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td width="25%" class="td1"  valign="top">Booth Amenities:</td>
		<td width="75%" class="td2" > 
					<li>Resume Folder</li>
					<li>Anti-Bacterial Hand Gel</li>
					
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">SHIPMENTS</td>
	</tr>
	<tr>
		<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
		
		<li>All Shipments made to the TECHEXPO Top Secret Career Fair should be addressed to:
		
		           	<div style="padding-left:100px;">
			         <br/>
					<strong>	TECHEXPO Top Secret <br/>
				'.$show['Location']['site_name'].'<br/>
				'.$show['Location']['site_address'].',<br/>
				'.$show['Location']['location_city'].', '.$show['Location']['location_state'].' '.$show['Location']['site_zip'].' ,
			<br/>HOLD FOR ARRIVAL -'.date('m/d/Y',strtotime($show['Show']['show_dt'])).'</strong></div><br/>
		
		</li>
		<li><strong>SHIP NO EARLIER THAN 3 DAYS AND NO LATER THAN 1 DAY PRIOR TO THE EVENT. PLEASE
REMEMBER TO BRING TRACKING #s WITH YOU TO THE EVENT.</strong> <br/><br/></li>
		<li>If you need to ship materials after the event, please notify an EXPO representative.
Please do not leave your packages at your booth before speaking with a team member.<br/></li>
		</td>
		
	</tr>
	<tr><td colspan="2" style="padding:5px 0 10px 100px;">**Job Expo International is not responsible for any lost or stolen items.**</td></tr>
	
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">ADDITIONAL EXHIBITOR INFORMATION</td>
	</tr>';
	if(!empty($show['Location']['site_name'])) { $sitephone = $show['Location']['site_name'];  }
	else {  $sitephone = 'XXX-XXX-XXXX'; }
	$htmlData.='<tr>
		<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top">
		
		<li>If you need <strong>Hotel Accommodations</strong>, please call '.$show['Location']['site_name'].' at '.$sitephone.'<br/><br/></li>
		<li><strong>Payment & Cancellation Policy</strong>:<br/> 
		<div style="padding-left:80px;">
		Payment must be made in advance of the event date. All sales are final. If you are unable to attend the
actual event, we will issue you a credit to be used for any future event. Invoices 30 days past due are
subject to a monthly 2% late fee. Resumes will be made available only upon receipt of payment.
		<br/><br/>

		Cancellation must be received in writing no less than two weeks prior to the event.
		</div>
		<br/>
		</li>
		<li><strong>Advertising</strong><br/>
		
		<div style="padding-left:80px;">
		Aside from the Marketing Campaign TECHEXPO participates in, to help draw additional attention to your booth,
please mention the event on your company\'s web site. Many companies may choose to place their own
recruitment ad in a regional newspaper; if you choose to do so you may want to include: "<strong><i>Come interview with us
in person at the '.$show['Location']['site_name'].', '.date('l ,F d Y',strtotime($show['Show']['show_dt'])).', '.$show['Show']['show_hours'].'</i></strong>" A simple message with the details of the event will draw additional candidates to your booth!
		
		</div>
		</li>
		</td>
	</tr>
</table>

<div style="page-break-after: always;"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" width="100%" style="padding-right: 20px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/TECHEXPO_HIRINGEVENTS_PDF.png"   >
    </td>
   </tr>
<tr><td style="font-size: 16px; text-align: center; padding-top: 15px;font-weight:bold;" >CAREER FAIR EXHIBITOR GUIDE</td></tr>
</table>

<br/>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
	<tr>
	<td  align="center" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">
	<span style="font-style:italic;" >Please Complete this form ASAP and fax to 212.655.4501</span>
	<div style="font-size:18px;font-weight:bold;text-align:left;padding-left:180px;">
	<br/>
				COMPANY NAME: ___________________<br/>
				CONTACT PERSON: _________________<br/>
				CONTACT #: ______________________<br/><br/>
	</div>
	</td>
	</tr>
	<tr align="center" style="font-size:15px;padding-top:10px;" >
	<td> <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15"> Use these preferences for 9/17/13 ONLY <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15"> Use these preferences for ALL shows </td>
	</tr>
	
	<tr>
	<td  class="subhead1" width="20%" style="padding:10px 0 5px 10px;font-weight:bold;">BOOTH LOCATION PREFERENCES</td>
	</tr>
	<tr>
	<td width="100%" style="padding-top:5px;">Our company prefers not to be located next to the following competitors:</td>
	</tr>	
	<tr>
	<td width="100%"  style="padding-left:80px;padding-top:8px;" >Competitor #1::_________________________</td>
	</tr>
	<tr>
	<td width="100%"  style="padding-left:80px;padding-top:8px;" >Competitor #2::_________________________</td>
	</tr>
	<tr>
	<td width="100%"  style="padding-left:80px;padding-top:8px;" >Competitor #3::_________________________</td>
	</tr>
	<tr>
	<td width="100%"  style="padding-left:80px;padding-top:8px;" >TECHEXPO Top Secret will make every effort to fulfill all requests, however we cannot guarantee booth placement. <br/><br/></td>
	</tr>
	
	<tr>
		<td  class="subhead1" width="20%" style="padding:10px 0 5px 10px;font-weight:bold;">BOOTH SET UP</td>
	</tr>
	<tr>
	<td width="100%" style="padding-top:5px;">So we can best accommodate your needs, please provide as much information as you can regarding the type of booth you plan to bring:</td>
	</tr>
	</table>
	
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
<tr>
	<td width="100%" style="padding:5px 0 0 100px;">
	Our company will have a tablecloth  
	</td>
	<td style="padding-right:120px;">
	 <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" > 
	</td>
	</tr>
	
	
	<tr>
	<td  width="100%" style="padding:5px 0 0 100px;">
	Our company will have a table-top display 
	</td>
	<td style="padding-right:120px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" >  </td>
	</tr>
	<tr>
	<td  width="100%" style="padding:5px 0 0 100px;">
	Our company will have a large Display  
	</td>
	<td style="padding-right:120px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" >  </td>
	</tr>
	<tr>
	<td  width="100%" style="padding:5px 0 0 100px;">
    Other:_____________________ 
	</td>
	<td style="padding-right:120px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" > </td>
	</tr>
	
	
	<tr>
		<td colspan="2"  class="subhead1" width="20%" style="padding:30px 0 5px 10px;font-weight:bold;">ADDITIONAL SHOW PREPARATION INFORMATION</td>
	</tr>
	
	<tr>
	<td colspan="2" width="100%" style="padding:5px 0 0 0;">
	<span style="width:200px;"><br/>Our company will have _____ staff members present at the event.  </td>
	</tr>
	<tr>
	<td  width="100%" style="padding:5px 0 0 0;">
	Our company would like electricity set up at our booth. (Additional $75)  
	</td>
	<td style="padding-right:120px;">
	 <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" >  </td>
	</tr>
	<tr>
	<td  width="100%" style="padding:5px 0 0 0;">
	Our company would like to have an internet connection at our booth. (Additional $15)  
	</td>
	<td style="padding-right:120px;">
	 <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" >  </td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
	<tr>
	<td width="100%" style="padding:5px 0 0 0;">
	<strong> <br/> In order for TechExpo to customize its marketing to your needs, please list your top 10 positions:</strong> </td>
	</tr>
	
	<tr>
	<td width="100%" style="padding:5px 0 0 0;">
	<strong>1._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>6._________________________________________</strong><br/>
	
	<strong>2._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>7._________________________________________</strong><br/>
	<strong>3._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>8._________________________________________</strong><br/>
	
	<strong>4._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>9._________________________________________</strong><br/>
	<strong>5._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>10._________________________________________</strong>
	

	
	</td>
	</tr>
	
	
</table>
<div style="page-break-after: always;"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" width="100%" style="padding-right: 20px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/TECHEXPO_HIRINGEVENTS_PDF.png"   >
    </td>
   </tr>
<tr><td style="font-size: 16px; text-align: center; padding-top: 15px;font-weight:bold;" >CAREER FAIR EXHIBITOR GUIDE</td></tr>
</table>

<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">WEBSITE INFORMATION</td>
	</tr>
	<tr>
		<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Login Information</strong></td>
	</tr>
	<tr>
		<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
		
		<li>You will receive an email from the TechExpoUSA.com site giving you login information. It will mirror
the information below:
		<div style="padding-left:30px;font-weight:bold;">
		Username: E-mail address<br/>
		Password: techexpo<br/><br/>
		</div>

		</li>
		<li>Once you enter the site, you must change the password. If you are not sure which e-mail address we
have on record for you, please contact Nancy Mathew at 212.655.4505 x 225.<br/><br/></li>
		
		</td>
	</tr>
	
	<tr>
	<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Activating Your Account</strong></td>
	</tr>
	<tr>
	<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
	
	<li>Before an event, many candidates visit www.TechExpoUSA.com to review job postings and to research
	employers in the job fair. It is in your company\'s best interest to set up your web site account by filling
	out your company profile as well as posting jobs ASAP, no later than 10 days prior to the job fair if
	possible.
	</li><br/><br/>
	</td>
	</tr>
	
	<tr>
	<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Manage Account / Company Profile</strong><br/>
	(Due 10 Days Before Event)
	</td>
	</tr>
	<tr>
	<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
	<li><strong>Update or edit your company profile and your contact information.</strong> This link will also list what
resume databases you have access to. This company profile is what will be viewed publicly on our site on
the event information page.
	</li><br/>
	</td>
	</tr>	
	
	<tr>
	<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Manage Jobs</strong>
	</td>
	</tr>
	<tr>
	<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
	<li>You must post at least one job on the site. These jobs will also appear in the printed show guides given
to attendees. In this show directory, you will be listed along with the first 8 job titles you post. This link
allows you to post a new job, edit, refresh or delete your existing ones. Refreshing your jobs will change
their posted date to today\'s date. <strong>Keywords</strong>: It is crucial that you select "keywords" from the pull down
menus when posting your jobs. This will ensure that our resume matching agents will send you targeted
resumes that match your criteria.
	</li><br/>
	</td>
	</tr>
	
<tr>
	<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Resume Access</strong>
	</td>
	</tr>
	<tr>
	<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
	<li>14 Days before the event, exhibitors who have paid in full, may begin reviewing resumes early and
reach out to schedule interviews with candidates that you want to be sure to meet at the TECHEXPO.<br/><br/>
	</li>
	<li>Approximately one week after the event, resumes from the attendees will be added to the database for
you to review. You will be notified via email when the show day resumes are uploaded onto the site.
	</li>
	
	</td>
	</tr>	
	
</table>


</body>
</html>'; 
		
		
		$dompdf = new DOMPDF();
		$dompdf->load_html(utf8_decode($htmlData), Configure::read('App.encoding'));
		$dompdf->render();
		$output = $dompdf->output();
		$file = time().'_'.$showID.'_Show_Packet.pdf';
		$filename = WWW_ROOT."ShowsDocument/showConfirmFile/".$file;
		file_put_contents($filename, $output);
		
	
		
		
		$this->request->data['Show']['id']=$showID;
		$this->request->data['Show']['show_confirm_file']=$file;
		$this->Show->save($this->request->data,false);

		/*********** Create ICS File **************/
	
		$this->common->icalenderOrg($showID);
		
		
		$this->Session->write('popup','Show has been added successfully.');
		$this->Session->setFlash('Show has been added successfully.');  
	//	$this->redirect(array('controller'=>'shows','action' => "index/message:success")); apurav 06-11-2013
		$this->redirect(array('superadmin'=>true,'controller'=>'adminusers','action'=>'home/message:success'));
			
		

		
		
	}
	

	public function _showpacket($showID) {
		
		  $this->loadModel('Show');

		
		$showDetail=$this->Show->find("first",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'INNER',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('Show.id'=>$showID)));
		
		
		
		App::import('Vendor', 'clsMsDocGenerator', array('file' => 'clsMsDocGenerator.php'));
	
		$doc = new clsMsDocGenerator();
		$doc->getHeader();
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		
		$doc->addParagraph('<strong>EVENT OVERVIEW</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		
		$doc->addParagraph('Event Date : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date('l,F d Y',strtotime($showDetail['Show']['show_dt'])),array('padding'=>'5px','margin-left'=>'100px','margin-top'=>'20px','font-size'=>'12px'));
		
		$doc->addParagraph('Event Location :  '.$showDetail['Location']['site_name'].'<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$showDetail['Location']['site_address'].'<br/>
															  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		                                                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$showDetail['Location']['location_city'].", ".$showDetail['Location']['location_state']." ".$showDetail['Location']['site_zip'].'<br/>
															  ',array('padding'=>'5px','margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('Event Scope : &nbsp;&nbsp;&nbsp;'.$showDetail['ShowsHome']['special_message'],array('padding'=>'5px','margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>IMPORTANT CONTACT INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>Events Director : Nancy Mathew  212.655.4505 cxt. 225</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));

		/*if($showDetail['Show']['sec_clearance_req']=='y')
		$BoothSp = '2 6 foot skirted tables';
		else
		$BoothSp = '1 six foot skirted table';*/
	//	echo $showDetail['Show']['sec_clearance_list'];
		if(!empty($showDetail['Show']['sec_clearance_list']))
		{
		$secclearance_list = explode(',',$showDetail['Show']['sec_clearance_list']);
	//pr($secclearance_list);
		if(in_array(1,$secclearance_list) || in_array(3920,$secclearance_list))
		$BoothSp = '2 6 foot skirted tables';
		else
		$BoothSp = '1 six foot skirted table';
		}
		else
		$BoothSp = '1 six foot skirted table';
		
	//	echo $BoothSp;die;
		
		$doc->newPage(1);
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>BOOTH SPACE INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>Booth Specifications : '.$BoothSp.'</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>SHIPMENTS</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>All Shipments made to the TECHEXPO Top Secret Career Fair should be addressed</li> </ul>',array('padding'=>'5px','font-size'=>'12px'));
		$doc->addParagraph('TECHEXPO Top Secret <br/>
				'.$showDetail['Location']['site_name'].'<br/>
				'.$showDetail['Location']['site_address'].',<br/>
				'.$showDetail['Location']['location_city'].", ".$showDetail['Location']['location_state']." ".$showDetail['Location']['site_zip'].' ,
			<br/>HOLD FOR ARRIVAL -'.date('m/d/Y',strtotime($showDetail['Show']['show_dt'])),array('margin-left'=>'100px','font-weight'=>'bold','font-size'=>'13px'));	
		$doc->addParagraph('<ul><li><strong>SHIP NO EARLIER THAN 3 DAYS AND NO LATER THAN 1 DAY PRIOR TO THE EVENT. PLEASE REMEMBER TO BRING TRACKING #s WITH YOU TO THE EVENT</strong></li></ul>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>lf you need to ship materials after The event, please notify an EXPO representative.
Please do not leave your packages at your booth before speaking with a team member.</ul></li>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('**Job Expo International is not responsible for any lost or stolen items.**',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>ADDITIONAL EXHIBITOR INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>If you need <strong>Hotel Accommodations</strong>, please call '.$showDetail['Location']['site_name'].' at xxx.xxx.xxxx </li></ul>',array('padding'=>'5px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li><strong>Payment & Canccllation Policy:</strong></li></ul>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('Payment must be made in advance of the event date. All sales are final. Ilyou are unable to attend the actual event. we will issue you a credit to be used for any future event. Invoices 30 days past due are subject to a monthly 2% late fee. Resumes will be made available only upon receipt of payment. <br/>Cancellalion must be received in writing no less than two weeks prior to the event.',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<ul><li><strong>Advertising</strong></li></ul>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('Aside from the Marketing Campaign TECHEXPO participates in, to help draw additional aftention to your booth, please mention the event on your company web site. Many companies may choose to place their own recruitment ad in a regional newspaper. If you choose to do so you may want To include: <strong><i>Come interview with as in person at the TECHEXPO Top Secret Hiring Event at the '.$showDetail['Location']['site_name'].', '.date('l ,F d Y',strtotime($showDetail['Show']['show_dt'])).', '.$showDetail['Show']['show_hours'].'</i></strong>. <br/>A simple message with the delails of the event will draw additional candidates to yoor booth!',array('margin-left'=>'100px','font-size'=>'12px'));
		
		
		$doc->newPage(1);
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong><em>Please Complete this form ASAP and fax to 212.655.4501</em></strong>',array('text-align' => 'center','font-size'=>'13px'));
		
		$doc->addParagraph('<strong>COMPANY NAME:  ______________________</strong>',array('margin-left'=>'100px','font-size'=>'14px'));
		$doc->addParagraph('<strong>CONTACT PERSON:  ______________________</strong>',array('margin-left'=>'100px','font-size'=>'14px'));
		$doc->addParagraph('<strong>CONTACT #:  ____________________</strong>',array('margin-left'=>'100px','font-size'=>'14px'));
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,18).'&nbsp;&nbsp;&nbsp;Use these preferences for 7/16/13 ONLY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,18).'&nbsp;&nbsp;&nbsp;Use these preferences for ALL shows',array('margin-left'=>'20px','font-size'=>'12px'));
		


		$doc->addParagraph('');
		$doc->addParagraph('<strong>BOOTH LOCATION PREFERENCES</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px',));
		$doc->addParagraph('Our company prefers not to be located next to the following competitors:',array('padding'=>'10px','margin-top'=>'15px'));
		$doc->addParagraph('Competitor #1:  ____________________',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Competitor #2:  ____________________',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Competitor #3:  ____________________',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('TECHEXPO Top Secret will make every efforts to fulfill all requests, however we cannot guarantee booth placement.',array('padding'=>'10px','font-size'=>'12px'));
		
		$doc->addParagraph('');
		$doc->addParagraph('<strong>BOOTH SET UP</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('So we can best accommodate your needs, please provide as much information as you can regarding the type of booth you plan to bring:',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'15px'));
		$doc->addParagraph('Our company will have a tablecloth&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Our company will have a table-top display&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Our company will have a large display&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Other: __________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('');
		$doc->addParagraph('<strong>ADDITIONAL SHOW PREPARATION INFORMATION </strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		//$doc->addParagraph('Show date : '.date('l,F d Y',strtotime($showDetail['Show']['show_dt'])),array('padding'=>'10px'));
		$doc->addParagraph('Our company will have _____ staff members present at the event.',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'15px'));
		$doc->addParagraph('Our company would like electricity set up at our booth. (Additional '.$showDetail['Location']['site_electricity_cost'].')&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('Our company would like to have an internet connection at our booth. (Additional '.$showDetail['Location']['internet_connectivity_cost'].' )&nbsp;&nbsp;&nbsp;&nbsp;'.$doc->bufferImage(BASE_URL.'/img/nxt-checkbox_n.png',15,15),array('padding'=>'10px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>In order for TechExpo to customize its marketing to your needs, please list your top 8 positions:</strong>',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'15px'));
		$doc->addParagraph('<strong>1. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>2. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;6.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>3. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;7.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>4. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;8.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>5. ______________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;10._____________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		
		$doc->newPage(1);
		$doc->addParagraph($doc->bufferImage(BASE_URL.'/img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>CAREER FAIR EXHIBITOR GUIDE</strong>',array('text-align' => 'center','font-size'=>'15px'));
		
		$doc->addParagraph('<strong>WEBSITE INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<strong>Login Information:</strong>',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'20px'));
		$doc->addParagraph('<ul><li>You will receive an email from the TechExpouSA.com site giving you login infomation. It will mirror the informarion below:</li></ul>
		
				',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('<strong>Username: E-mail address<br/>
				Password: techexpo</strong>',array('margin-left'=>'160px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>Once you enter the site, you must change the password. if you are not sure which e-mail address we have on record for you, please contacl Nancy Mathew at 212.655.4505 x 225.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('<strong>Activating Your Account</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>Before an event, many candidates visit www.TechExpouSA.com to review job postings and to research employers in the job fair. It is in your companys best interest to set up your web site account by filling out your <i><b>company profile</b></i> as well as <i><b>posting jobs</b></i> ASAP, no later than 10 days prior to the job fair if possible.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>Manage Account / Company Profile </strong><br/>(Due 10 Days Before Event)',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li><strong>Update or edit your company profile and your contact information</strong>. This link will also list what resume databases you have access to. This company profile is what will be viewed publicly on our site on the event information page.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>Manage Jobs</strong>',array('padding'=>'5px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>You must post at least one job on the site. These jobs will also appear in the printed show guides given to attendees. In this show directory, you will be listed along with the first 8 job titles you post. This link allows you to post a new job, edit, refresh or delete your existing ones. Refreshing your jobs will change their posted date to today\'s date. <strong>Keywords</strong>: It is crucial that you select "keywords" from the pull down menus when posting your jobs. This will ensure that our resume matching agents will send you targeted resumes that match your criteria.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>Resume Access</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>14 Days before the event, exhibitors who have paid in full, may begin reviewing resumes early and reach out to schedule interviews with candidates that you want to be sure to meet at the TECHEXPO.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>Approximately one week after the event, resumes from the attendees will be added to the database for you to review. You will be notified via email when the show day resumes are uploaded onto the site.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		/*$doc->startTable(array('border'=>'0px'), 'tableWithoutGrid');
		$header = array('', '');
		$aligns = array('left', 'left');
		$valigns = array('middle', 'middle');
		$doc->addTableRow($header, $aligns, $valigns, array('font-weight' => 'bold', 'border'=>'opx'));
		
		
		$cols[0] = "column 1; row dfs".$doc->bufferImage('http://www.google.com.au/intl/en_au/images/logo.gif',138,55);
		$cols[1] = $doc->bufferImage('http://www.google.com.br/intl/pt-BR_br/images/logo.gif',138,55) . "column 2; row sdf";
		
		$doc->addTableRow($cols);
		
		$doc->endTable();*/
		
		$filename = time().'_'.$showID.'_Show_Packet.doc';
		
		$this->request->data['Show']['id']=$showID;
		$this->request->data['Show']['show_confirm_file']=$filename;
		$this->Show->save($this->request->data,false);
		
	//	$doc->output($filename);
		$doc->output($filename,WWW_ROOT.'ShowsDocument/showConfirmFile/');
		
		

	}
	
	public function superadmin_downloadguidefile($filename)
	{
		 $this->downloadFile('ShowsDocument/showConfirmFile',$filename);
	}
	public function superadmin_downloadfile($filename,$type)
	{
		 if($type=='show_confirm_file')			
		 $this->downloadFile('ShowsDocument/showConfirmFile',$filename);
		 if($type=='show_guide_file')			
		 $this->downloadFile('ShowsDocument/showGuide',$filename);
		 if($type=='ics_file')			
		 $this->downloadFile('ShowsDocument/ics',$filename);
		 
		 
		 
	}
	
	public function superadmin_showpacket($showID) {
		
		$this->autoRender = false;
		
		$this->set('showID',$showID);
		
		$this->loadModel('ShowsHome');
		$showEntCheck = $this->ShowsHome->find('count',array('conditions'=>array('ShowsHome.show_id'=>$showID)));
			
		
			
		$show=$this->Show->find("first",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'LEFT',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('Show.id'=>$showID)));
			
		
		
		require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php') ;
	
	//	$htmlData = file_get_contents(FULL_BASE_URL.router::url('/',false).'superadmin/shows/view_pdf/'.$showID);
		
		
		$htmlData ='<html>
<head>
<title>CAREER FAIR EXHIBITOR GUIDE</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {
	font-family: "Times New Roman", Times, serif;
	color: #000000;
}
.td1 {
	font-size: 15px; 
	text-align: right; 
	padding-top: 10px; 
	font-weight: normal;
}
.td2 {
	font-size: 15px; 
	text-align: left; 
	padding-left: 25px; 
	padding-top: 10px; 
	font-weight: normal;
}
.subhead1 {
	font-size: 15px; 
	text-align: left;
	border-bottom: solid 1px #000000;
}
.topright {
	font-size: 15px; 
	border-left: solid 1px #000000;
	padding-left: 20px; 
	font-weight: normal;
}

</style>
</head>
<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br /><br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="right" width="50%" style="padding-right: 20px;padding-left:100px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/TECHEXPO_HIRINGEVENTS_PDF.png"  >
      
	</td>	
	<td class="topright" width="50%" align="left">
		276 5th Avenue, Suite 906<br />
		New York, New York 10001<br />
		(212) 655-4505 ext. 225<br />
	</td>
	</tr>
<tr><td style="font-size: 16px; text-align: center; padding-top: 15px;font-weight:bold;" colspan="3">CAREER FAIR EXHIBITOR GUIDE</td></tr>
</table>
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">EVENT OVERVIEW</td>
	</tr>
	<tr>
		<td width="25%" class="td1">Event Date:</td>
		<td width="75%" class="td2">'.date('l, F d Y',strtotime($show['Show']['show_dt'])).'</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr valign="top">
		<td width="25%" class="td1">Event Location:</td>
		<td width="75%" class="td2">'.$show['Show']['show_name'].' <br />
									'.$show['Location']['site_name'].' '.$show['Location']['site_address'].'<br />
									'.$show['Location']['location_city'].", ".$show['Location']['location_state']." ".$show['Location']['site_zip'].'<br />
									410.859.8300
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr valign="top">
		<td width="25%" class="td1">Event Scope:</td>
		<td width="75%" class="td2">'.$show['ShowsHome']['special_message'].'</td>
	</tr>
</table>	
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">EVENT SCHEDULE</td>
	</tr>
	<tr valign="top">
		<td width="25%" class="td1">'.$show['Show']['show_hours'].'</td>
		<td width="75%" class="td2">'.strip_tags($show['Show']['show_descr']).'</td>
	</tr>
</table>	
<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;" >
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">IMPORTANT CONTACT INFORMATION</td>
	</tr>
	<tr valign="top">
		<td width="25%" class="td1">Events Director:</td>
		<td width="75%" class="td2">Nancy Mathew &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 212.655.4505 ext. 225</td>
	</tr>
</table>
<div style="page-break-after: always;"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" width="100%" style="padding-right: 20px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/TECHEXPO_HIRINGEVENTS_PDF.png"   >
    </td>
   </tr>
<tr><td style="font-size: 16px; text-align: center; padding-top: 15px;font-weight:bold;" >CAREER FAIR EXHIBITOR GUIDE</td></tr>
</table>

<br/><br/>';
if(!empty($show['Show']['sec_clearance_list']))
		{
		$secclearance_list = explode(',',$show['Show']['sec_clearance_list']);
	//pr($secclearance_list);
		if(in_array(1,$secclearance_list) || in_array(3920,$secclearance_list))
		$BoothSp = '2 6 foot skirted tables';
		else
		$BoothSp = '1 six foot skirted table';
		}
		else
		$BoothSp = '1 six foot skirted table';
$htmlData.='<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">BOOTH SPACE INFORMATION</td>
	</tr>
	<tr>
		<td width="25%" class="td1"  valign="top">Booth Specifications:</td>
		<td width="75%" class="td2" > 
					<li>'.$BoothSp.'</li>
					
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td width="25%" class="td1"  valign="top">Booth Amenities:</td>
		<td width="75%" class="td2" > 
					<li>Resume Folder</li>
					<li>Anti-Bacterial Hand Gel</li>
					
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">SHIPMENTS</td>
	</tr>
	<tr>
		<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
		
		<li>All Shipments made to the TECHEXPO Top Secret Career Fair should be addressed to:
		
		           	<div style="padding-left:100px;">
			         <br/>
					<strong>	TECHEXPO Top Secret <br/>
				'.$show['Location']['site_name'].'<br/>
				'.$show['Location']['site_address'].',<br/>
				'.$show['Location']['location_city'].', '.$show['Location']['location_state'].' '.$show['Location']['site_zip'].' ,
			<br/>HOLD FOR ARRIVAL -'.date('m/d/Y',strtotime($show['Show']['show_dt'])).'</strong></div><br/>
		
		</li>
		<li><strong>SHIP NO EARLIER THAN 3 DAYS AND NO LATER THAN 1 DAY PRIOR TO THE EVENT. PLEASE
REMEMBER TO BRING TRACKING #s WITH YOU TO THE EVENT.</strong> <br/><br/></li>
		<li>If you need to ship materials after the event, please notify an EXPO representative.
Please do not leave your packages at your booth before speaking with a team member.<br/></li>
		</td>
		
	</tr>
	<tr><td colspan="2" style="padding:5px 0 10px 100px;">**Job Expo International is not responsible for any lost or stolen items.**</td></tr>
	
	
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">ADDITIONAL EXHIBITOR INFORMATION</td>
	</tr>';
	if(!empty($show['Location']['site_name'])) { $sitephone = $show['Location']['site_name'];  }
	else {  $sitephone = 'XXX-XXX-XXXX'; }
	$htmlData.='<tr>
		<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top">
		
		<li>If you need <strong>Hotel Accommodations</strong>, please call '.$show['Location']['site_name'].' at '.$sitephone.'<br/><br/></li>
		<li><strong>Payment & Cancellation Policy</strong>:<br/> 
		<div style="padding-left:80px;">
		Payment must be made in advance of the event date. All sales are final. If you are unable to attend the
actual event, we will issue you a credit to be used for any future event. Invoices 30 days past due are
subject to a monthly 2% late fee. Resumes will be made available only upon receipt of payment.
		<br/><br/>

		Cancellation must be received in writing no less than two weeks prior to the event.
		</div>
		<br/>
		</li>
		<li><strong>Advertising</strong><br/>
		
		<div style="padding-left:80px;">
		Aside from the Marketing Campaign TECHEXPO participates in, to help draw additional attention to your booth,
please mention the event on your company\'s web site. Many companies may choose to place their own
recruitment ad in a regional newspaper; if you choose to do so you may want to include: "<strong><i>Come interview with us
in person at the '.$show['Location']['site_name'].', '.date('l ,F d Y',strtotime($show['Show']['show_dt'])).', '.$show['Show']['show_hours'].'</i></strong>" A simple message with the details of the event will draw additional candidates to your booth!
		
		</div>
		</li>
		</td>
	</tr>
</table>

<div style="page-break-after: always;"></div>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" width="100%" style="padding-right: 20px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/TECHEXPO_HIRINGEVENTS_PDF.png"   >
    </td>
   </tr>
<tr><td style="font-size: 16px; text-align: center; padding-top: 15px;font-weight:bold;" >CAREER FAIR EXHIBITOR GUIDE</td></tr>
</table>

<br/>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
	<tr>
	<td  align="center" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">
	<span style="font-style:italic;" >Please Complete this form ASAP and fax to 212.655.4501</span>
	<div style="font-size:18px;font-weight:bold;text-align:left;padding-left:180px;">
	<br/>
				COMPANY NAME: ___________________<br/>
				CONTACT PERSON: _________________<br/>
				CONTACT #: ______________________<br/><br/>
	</div>
	</td>
	</tr>
	<tr align="center" style="font-size:15px;padding-top:10px;" >
	<td> <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15"> Use these preferences for 9/17/13 ONLY <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15"> Use these preferences for ALL shows </td>
	</tr>
	
	<tr>
	<td  class="subhead1" width="20%" style="padding:10px 0 5px 10px;font-weight:bold;">BOOTH LOCATION PREFERENCES</td>
	</tr>
	<tr>
	<td width="100%" style="padding-top:5px;">Our company prefers not to be located next to the following competitors:</td>
	</tr>	
	<tr>
	<td width="100%"  style="padding-left:80px;padding-top:8px;" >Competitor #1::_________________________</td>
	</tr>
	<tr>
	<td width="100%"  style="padding-left:80px;padding-top:8px;" >Competitor #2::_________________________</td>
	</tr>
	<tr>
	<td width="100%"  style="padding-left:80px;padding-top:8px;" >Competitor #3::_________________________</td>
	</tr>
	<tr>
	<td width="100%"  style="padding-left:80px;padding-top:8px;" >TECHEXPO Top Secret will make every effort to fulfill all requests, however we cannot guarantee booth placement. <br/><br/></td>
	</tr>
	
	<tr>
		<td  class="subhead1" width="20%" style="padding:10px 0 5px 10px;font-weight:bold;">BOOTH SET UP</td>
	</tr>
	<tr>
	<td width="100%" style="padding-top:5px;">So we can best accommodate your needs, please provide as much information as you can regarding the type of booth you plan to bring:</td>
	</tr>
	</table>
	
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
<tr>
	<td width="100%" style="padding:5px 0 0 100px;">
	Our company will have a tablecloth  
	</td>
	<td style="padding-right:120px;">
	 <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" > 
	</td>
	</tr>
	
	
	<tr>
	<td  width="100%" style="padding:5px 0 0 100px;">
	Our company will have a table-top display 
	</td>
	<td style="padding-right:120px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" >  </td>
	</tr>
	<tr>
	<td  width="100%" style="padding:5px 0 0 100px;">
	Our company will have a large Display  
	</td>
	<td style="padding-right:120px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" >  </td>
	</tr>
	<tr>
	<td  width="100%" style="padding:5px 0 0 100px;">
    Other:_____________________ 
	</td>
	<td style="padding-right:120px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" > </td>
	</tr>
	
	
	<tr>
		<td colspan="2"  class="subhead1" width="20%" style="padding:30px 0 5px 10px;font-weight:bold;">ADDITIONAL SHOW PREPARATION INFORMATION</td>
	</tr>
	
	<tr>
	<td colspan="2" width="100%" style="padding:5px 0 0 0;">
	<span style="width:200px;"><br/>Our company will have _____ staff members present at the event.  </td>
	</tr>
	<tr>
	<td  width="100%" style="padding:5px 0 0 0;">
	Our company would like electricity set up at our booth. (Additional $75)  
	</td>
	<td style="padding-right:120px;">
	 <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" >  </td>
	</tr>
	<tr>
	<td  width="100%" style="padding:5px 0 0 0;">
	Our company would like to have an internet connection at our booth. (Additional $15)  
	</td>
	<td style="padding-right:120px;">
	 <img src="'.FULL_BASE_URL.router::url("/",false).'img/nxt-checkbox_n.png"  width="15" height="15" >  </td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
	<tr>
	<td width="100%" style="padding:5px 0 0 0;">
	<strong> <br/> In order for TechExpo to customize its marketing to your needs, please list your top 10 positions:</strong> </td>
	</tr>
	
	<tr>
	<td width="100%" style="padding:5px 0 0 0;">
	<strong>1._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>6._________________________________________</strong><br/>
	
	<strong>2._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>7._________________________________________</strong><br/>
	<strong>3._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>8._________________________________________</strong><br/>
	
	<strong>4._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>9._________________________________________</strong><br/>
	<strong>5._________________________________________</strong> &nbsp;&nbsp;&nbsp; &nbsp;<strong>10._________________________________________</strong>
	

	
	</td>
	</tr>
	
	
</table>
<div style="page-break-after: always;"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td align="center" width="100%" style="padding-right: 20px;">
	<img src="'.FULL_BASE_URL.router::url("/",false).'img/TECHEXPO_HIRINGEVENTS_PDF.png"   >
    </td>
   </tr>
<tr><td style="font-size: 16px; text-align: center; padding-top: 15px;font-weight:bold;" >CAREER FAIR EXHIBITOR GUIDE</td></tr>
</table>

<br /><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:14px;">
	<tr>
		<td colspan="2" class="subhead1" width="20%" style="padding-bottom:5px;padding-left:10px;font-weight:bold;">WEBSITE INFORMATION</td>
	</tr>
	<tr>
		<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Login Information</strong></td>
	</tr>
	<tr>
		<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
		
		<li>You will receive an email from the TechExpoUSA.com site giving you login information. It will mirror
the information below:
		<div style="padding-left:30px;font-weight:bold;">
		Username: E-mail address<br/>
		Password: techexpo<br/><br/>
		</div>

		</li>
		<li>Once you enter the site, you must change the password. If you are not sure which e-mail address we
have on record for you, please contact Nancy Mathew at 212.655.4505 x 225.<br/><br/></li>
		
		</td>
	</tr>
	
	<tr>
	<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Activating Your Account</strong></td>
	</tr>
	<tr>
	<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
	
	<li>Before an event, many candidates visit www.TechExpoUSA.com to review job postings and to research
	employers in the job fair. It is in your company\'s best interest to set up your web site account by filling
	out your company profile as well as posting jobs ASAP, no later than 10 days prior to the job fair if
	possible.
	</li><br/><br/>
	</td>
	</tr>
	
	<tr>
	<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Manage Account / Company Profile</strong><br/>
	(Due 10 Days Before Event)
	</td>
	</tr>
	<tr>
	<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
	<li><strong>Update or edit your company profile and your contact information.</strong> This link will also list what
resume databases you have access to. This company profile is what will be viewed publicly on our site on
the event information page.
	</li><br/>
	</td>
	</tr>	
	
	<tr>
	<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Manage Jobs</strong>
	</td>
	</tr>
	<tr>
	<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
	<li>You must post at least one job on the site. These jobs will also appear in the printed show guides given
to attendees. In this show directory, you will be listed along with the first 8 job titles you post. This link
allows you to post a new job, edit, refresh or delete your existing ones. Refreshing your jobs will change
their posted date to today\'s date. <strong>Keywords</strong>: It is crucial that you select "keywords" from the pull down
menus when posting your jobs. This will ensure that our resume matching agents will send you targeted
resumes that match your criteria.
	</li><br/>
	</td>
	</tr>
	
<tr>
	<td width="100%" style="padding:10px 0 10px 10px;" colspan="2"  valign="top"><strong>Resume Access</strong>
	</td>
	</tr>
	<tr>
	<td width="100%" style="padding:10px 0 10px 100px;" colspan="2"  valign="top">
	<li>14 Days before the event, exhibitors who have paid in full, may begin reviewing resumes early and
reach out to schedule interviews with candidates that you want to be sure to meet at the TECHEXPO.<br/><br/>
	</li>
	<li>Approximately one week after the event, resumes from the attendees will be added to the database for
you to review. You will be notified via email when the show day resumes are uploaded onto the site.
	</li>
	
	</td>
	</tr>	
	
</table>


</body>
</html>'; 
		
		
		$dompdf = new DOMPDF();
		$dompdf->load_html(utf8_decode($htmlData), Configure::read('App.encoding'));
		$dompdf->render();
		$output = $dompdf->output();
		$file = time().'_'.$showID.'_Show_Packet.pdf';
		$dompdf->stream($file);
	//	$filename = WWW_ROOT."ShowsDocument/showConfirmFile/".$file;
	//	file_put_contents($filename, $output);
		
		
			

	}
	
	
	public function superadmin_wordfile($showID) {
		
		$this->autoRender = false;
		
		  $this->loadModel('Show');

		
		$showDetail=$this->Show->find("first",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'LEFT',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('Show.id'=>$showID)));
		
		
		App::import('Vendor', 'clsMsDocGenerator', array('file' => 'clsMsDocGenerator.php'));
	
		$doc = new clsMsDocGenerator();
		$doc->getHeader();
		$doc->addParagraph($doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		
		$doc->addParagraph('<strong>EVENT OVERVIEW</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		
		$doc->addParagraph('Event Date : '.date('l,F d Y',strtotime($showDetail['Show']['show_dt'])),array('padding'=>'5px','margin-left'=>'100px','margin-top'=>'20px','font-size'=>'12px'));
		
		$doc->addParagraph('Event Location :  '.$showDetail['Location']['site_name'].'<br/> '.$showDetail['Location']['site_address'].'<br/>
															  '.$showDetail['Location']['location_city'].", ".$showDetail['Location']['location_state']." ".$showDetail['Location']['site_zip'].'<br/>
															  ',array('padding'=>'5px','margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('Event Scope : '.$showDetail['ShowsHome']['special_message'],array('padding'=>'5px','margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>IMPORTANT CONTACT INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>Events Director : Nancy Mathew  212.655.4505 ext. 225</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));

		/*if($showDetail['Show']['sec_clearance_req']=='y')
		$BoothSp = '2 6 foot skirted tables';
		else
		$BoothSp = '1 six foot skirted table';*/
	//	echo $showDetail['Show']['sec_clearance_list'];
		if(!empty($showDetail['Show']['sec_clearance_list']))
		{
		$secclearance_list = explode(',',$showDetail['Show']['sec_clearance_list']);
	//pr($secclearance_list);
		if(in_array(1,$secclearance_list) || in_array(3920,$secclearance_list))
		$BoothSp = '2 6 foot skirted tables';
		else
		$BoothSp = '1 six foot skirted table';
		}
		else
		$BoothSp = '1 six foot skirted table';
		
	//	echo $BoothSp;die;
		
		$doc->newPage(1);
		$doc->addParagraph($doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>BOOTH SPACE INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>Booth Specifications : '.$BoothSp.'</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>SHIPMENTS</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>All Shipments made to the TECHEXPO Top Secret Career Fair should be addressed</li> </ul>',array('padding'=>'5px','font-size'=>'12px'));
		$doc->addParagraph('TECHEXPO Top Secret <br/>
				'.$showDetail['Location']['site_name'].'<br/>
				'.$showDetail['Location']['site_address'].',<br/>
				'.$showDetail['Location']['location_city'].", ".$showDetail['Location']['location_state']." ".$showDetail['Location']['site_zip'].' ,
			<br/>HOLD FOR ARRIVAL -'.date('m/d/Y',strtotime($showDetail['Show']['show_dt'])),array('margin-left'=>'100px','font-weight'=>'bold','font-size'=>'13px'));	
		$doc->addParagraph('<ul><li><strong>SHIP NO EARLIER THAN 3 DAYS AND NO LATER THAN 1 DAY PRIOR TO THE EVENT. PLEASE REMEMBER TO BRING TRACKING #s WITH YOU TO THE EVENT</strong></li></ul>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>lf you need to ship materials after The event, please notify an EXPO representative.
Please do not leave your packages at your booth before speaking with a team member.</ul></li>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('**Job Expo International is not responsible for any lost or stolen items.**',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>ADDITIONAL EXHIBITOR INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<ul><li>If you need <strong>Hotel Accommodations</strong>, please call '.$showDetail['Location']['site_name'].' at xxx.xxx.xxxx </li></ul>',array('padding'=>'5px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li><strong>Payment & Canccllation Policy:</strong></li></ul>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('Payment must be made in advance of the event date. All sales are final. Ilyou are unable to attend the actual event. we will issue you a credit to be used for any future event. Invoices 30 days past due are subject to a monthly 2% late fee. Resumes will be made available only upon receipt of payment. <br/>Cancellalion must be received in writing no less than two weeks prior to the event.',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('');
		$doc->addParagraph('<ul><li><strong>Advertising</strong></li></ul>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('Aside from the Marketing Campaign TECHEXPO participates in, to help draw additional aftention to your booth, please mention the event on your company web site. Many companies may choose to place their own recruitment ad in a regional newspaper. If you choose to do so you may want To include: <strong><i>Come interview with as in person at the TECHEXPO Top Secret Hiring Event at the '.$showDetail['Location']['site_name'].', '.date('l ,F d Y',strtotime($showDetail['Show']['show_dt'])).', '.$showDetail['Show']['show_hours'].'</i></strong>. <br/>A simple message with the delails of the event will draw additional candidates to yoor booth!',array('margin-left'=>'100px','font-size'=>'12px'));
		
		
		$doc->newPage(1);
		$doc->addParagraph($doc->bufferImage(FULL_BASE_URL.router::url('/',false).'/img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong><em>Please Complete this form ASAP and fax to 212.655.4501</em></strong>',array('text-align' => 'center','font-size'=>'13px'));
		
		$doc->addParagraph('<strong>COMPANY NAME:  ______________________</strong>',array('margin-left'=>'100px','font-size'=>'14px'));
		$doc->addParagraph('<strong>CONTACT PERSON:  ______________________</strong>',array('margin-left'=>'100px','font-size'=>'14px'));
		$doc->addParagraph('<strong>CONTACT #:  ____________________</strong>',array('margin-left'=>'100px','font-size'=>'14px'));
		$doc->addParagraph($doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/nxt-checkbox_n.png',15,18).'&#09; Use these preferences for 7/16/13 ONLY &#09;'.$doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/nxt-checkbox_n.png',15,18).'&#09; Use these preferences for ALL shows',array('margin-left'=>'20px','font-size'=>'12px'));
		


		$doc->addParagraph('');
		$doc->addParagraph('<strong>BOOTH LOCATION PREFERENCES</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px',));
		$doc->addParagraph('Our company prefers not to be located next to the following competitors:',array('padding'=>'10px','margin-top'=>'15px'));
		$doc->addParagraph('Competitor #1:  ____________________',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Competitor #2:  ____________________',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Competitor #3:  ____________________',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('TECHEXPO Top Secret will make every efforts to fulfill all requests, however we cannot guarantee booth placement.',array('padding'=>'10px','font-size'=>'12px'));
		
		$doc->addParagraph('');
		$doc->addParagraph('<strong>BOOTH SET UP</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('So we can best accommodate your needs, please provide as much information as you can regarding the type of booth you plan to bring:',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'15px'));
		$doc->addParagraph('Our company will have a tablecloth &#09;&#09;&#09;'.$doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Our company will have a table-top display &#09;&#09;&#09;'.$doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Our company will have a large display &#09;&#09;&#09;'.$doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('Other: __________________________________&#09;&#09;'.$doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/nxt-checkbox_n.png',15,15),array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('');
		$doc->addParagraph('<strong>ADDITIONAL SHOW PREPARATION INFORMATION </strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		//$doc->addParagraph('Show date : '.date('l,F d Y',strtotime($showDetail['Show']['show_dt'])),array('padding'=>'10px'));
		$doc->addParagraph('Our company will have _____ staff members present at the event.',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'15px'));
		$doc->addParagraph('Our company would like electricity set up at our booth. (Additional '.$showDetail['Location']['site_electricity_cost'].') &#09;&#09;'.$doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/nxt-checkbox_n.png',15,15),array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('Our company would like to have an internet connection at our booth. (Additional '.$showDetail['Location']['internet_connectivity_cost'].' )&#09;'.$doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/nxt-checkbox_n.png',15,15),array('padding'=>'10px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>In order for TechExpo to customize its marketing to your needs, please list your top 8 positions:</strong>',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'15px'));
		$doc->addParagraph('<strong>1. ______________________________&#09;5.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>2. ______________________________&#09;6.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>3. ______________________________&#09;7.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>4. ______________________________&#09;8.______________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<strong>5. ______________________________&#09;10._____________________________</strong>',array('padding'=>'10px','font-size'=>'12px'));
		
		$doc->newPage(1);
		$doc->addParagraph($doc->bufferImage(FULL_BASE_URL.router::url('/',false).'img/images/logo.jpg', 571, 70) , array('text-align' => 'center'));
		$doc->addParagraph('');
		$doc->addParagraph('<strong>CAREER FAIR EXHIBITOR GUIDE</strong>',array('text-align' => 'center','font-size'=>'15px'));
		
		$doc->addParagraph('<strong>WEBSITE INFORMATION</strong>',array('border-bottom'=>'2px solid #316293','padding'=>'5px','font-weight'=>'bold','font-size'=>'14px'));
		$doc->addParagraph('<strong>Login Information:</strong>',array('padding'=>'10px','font-size'=>'12px','margin-top'=>'20px'));
		$doc->addParagraph('<ul><li>You will receive an email from the TechExpouSA.com site giving you login infomation. It will mirror the informarion below:</li></ul>
		
				',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('<strong>Username: E-mail address<br/>
				Password: techexpo</strong>',array('margin-left'=>'160px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>Once you enter the site, you must change the password. if you are not sure which e-mail address we have on record for you, please contacl Nancy Mathew at 212.655.4505 x 225.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('<strong>Activating Your Account</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>Before an event, many candidates visit www.TechExpouSA.com to review job postings and to research employers in the job fair. It is in your companys best interest to set up your web site account by filling out your <i><b>company profile</b></i> as well as <i><b>posting jobs</b></i> ASAP, no later than 10 days prior to the job fair if possible.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>Manage Account / Company Profile </strong><br/>(Due 10 Days Before Event)',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li><strong>Update or edit your company profile and your contact information</strong>. This link will also list what resume databases you have access to. This company profile is what will be viewed publicly on our site on the event information page.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>Manage Jobs</strong>',array('padding'=>'5px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>You must post at least one job on the site. These jobs will also appear in the printed show guides given to attendees. In this show directory, you will be listed along with the first 8 job titles you post. This link allows you to post a new job, edit, refresh or delete your existing ones. Refreshing your jobs will change their posted date to today\'s date. <strong>Keywords</strong>: It is crucial that you select "keywords" from the pull down menus when posting your jobs. This will ensure that our resume matching agents will send you targeted resumes that match your criteria.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$doc->addParagraph('<strong>Resume Access</strong>',array('padding'=>'10px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>14 Days before the event, exhibitors who have paid in full, may begin reviewing resumes early and reach out to schedule interviews with candidates that you want to be sure to meet at the TECHEXPO.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		$doc->addParagraph('<ul><li>Approximately one week after the event, resumes from the attendees will be added to the database for you to review. You will be notified via email when the show day resumes are uploaded onto the site.</li></ul>',array('margin-left'=>'100px','font-size'=>'12px'));
		
		$filename= str_replace(',','',$showDetail['Show']['show_name']);
		$filename = str_replace('-','_',$filename);  
		$filename = str_replace(' ','_',$filename); 
		$doc->output($filename.'.doc');

		

	}
	
	
	public function superadmin_wordguidefile($showID) {
		
		$this->autoRender = false;
		
   	    $this->loadModel('ShowEmployer');
	
		$showDetail = $this->ShowEmployer->find('all',array('conditions'=>array('ShowEmployer.show_id'=>$showID),'contain'=>array('Employer.JobPosting'=>array('limit'=>10)),'order'=>'Employer.employer_name ASC'));
		
		
		
		
	//	header("Content-type: application/vnd.ms-word");
	//	header("Content-Disposition: attachment;Filename=document_name.doc");
		
			$html= "<style >
					html, body {
					  margin: 0;
					  padding: 0px;
					  border: 0px;
					}
					.nameclass{font-weight:bold;margin:10px 0 10px 0;}
					</style>";
					
			$html="";
			


	//	$html.= "<p style='text-align:center'><img src='".FULL_BASE_URL.router::url('/',false)."img/TECHEXPO_HIRINGEVENTS_PDF.png'  ></p><br/>";
		if(count($showDetail))
		{
		foreach($showDetail as $key=>$showDetail) 
		{
			if($key%4==0){
		
			}
			$html.= "<p><strong>".$showDetail['Employer']['employer_name']."</strong> </p>  <ul >";
			foreach($showDetail['Employer']['JobPosting'] as $jobdt) 
			{ 
				
			$html.= "<li style='margin:-5px 0 -5px -20px;'>";
			$html.= $jobdt['job_title'];
			$html.= "</li>";
			
			}
			$html.= "</ul>";
		
		
		}
		}
		else
		{
		$html="<h1>No Data Available</h1>";	
		}

		//echo $html;die;
		
		App::import('Vendor','phpdocx_trial/classes/CreateDocx');
        $docx = new CreateDocx();
		
		
		$customLayout = array(
                    'height' => '20160',
					'width'=>'12240',
                    'numberCols' => '4',
                    'orient' => 'portrait',  //A4
					 'marginTop' => '1000',
                    'marginRight' => '1000',
                    'marginBottom' => '1000',
                    'marginLeft' => '1000',
                    );
$docx->modifyPageLayout('custom', $customLayout);
		
				
		$headerImage = $docx->addImage(array('name' => WWW_ROOT.'/img/TECHEXPO_HIRINGEVENTS_PDF.png', 'dpi' => 70,'spacingLeft'=>70, 'rawWordML' => true, 'target' => 'defaultHeader','spacingBottom'=>'20'));
		$myImage = $docx->createWordMLFragment(array($headerImage));
		
		$docx->addHeader(array('default' => $myImage));

         
		//$docx->addHTML(array('html' => $html));
		$docx->embedHTML($html,array('strictWordStyles' => true));
			
	    //$docx->modifyPageLayout('A4-portrait', array('numberCols' => '4'));
		$docx->createDocxAndDownload( WWW_ROOT . 'ShowsDocument/showGuide/show_guide');


		

	}	

	
	public function superadmin_getTravelDt($id = null) {
		
		$this->autoRender = false;
		$locationID = $this->request->data['locationid'];
		$this->loadModel('Location');
		 $this->Location->id = $locationID;
		echo $this->Location->field('site_travel_direction');
		
		exit();
		
		
		
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
			$this->loadModel('ShowsHome');		

		if ($this->request->is('get')) {			
				
				$this->Show->unbindModel(array('hasMany' => array('Registration')));
				
				$this->request->data = $this->Show->find('first',array('conditions'=>array('Show.id'=>$id)));
				  $showHomeRD =   $this->ShowsHome->find('first',array('conditions'=>array('ShowsHome.show_id'=>$id)));
				 $this->request->data['Show']['display_name'] =  $showHomeRD['ShowsHome']['display_name']; 
				 $this->request->data['Show']['special_message'] =  $showHomeRD['ShowsHome']['special_message'];
				 
				 if(!empty($this->request->data['Show']['show_special_html']))
				 {
				$this->request->data['Show']['show_special_html'] = str_replace('banners/',BASE_URL.'/uploaded/',$this->request->data['Show']['show_special_html']);
				 }
				 
				
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
				
			/*	$show_dt = $this->request->data['Show']['show_dt']['day']."-".$this->request->data['Show']['show_dt']['month']."-".$this->request->data['Show']['show_dt']['year'];
				$show_end_dt = $this->request->data['Show']['show_end_dt']['day']."-".$this->request->data['Show']['show_end_dt']['month']."-".$this->request->data['Show']['show_end_dt']['year'];
			*/
			
				$show_dt = $this->request->data['Show']['show_dt'];
			$show_end_dt = $this->request->data['Show']['show_end_dt'];
			
				if(strlen($show_end_dt)>2 && (strtotime($show_dt)>strtotime($show_end_dt))){
					$errors['show_dt'][0] = 'The show date cannot be greater than the show end date';
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
								$con_filename = time().'_'.$this->request->data['Show']['show_confirm_file']['name'];
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
								$guide_filename = time().'_'.$this->request->data['Show']['show_guide_file']['name'];
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
							$ics_filename = time().'_'.$this->request->data['Show']['ics_file']['name'];
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
						
						/* entry in show home table 06072013 */
				
					$ShowData['ShowsHome']['show_id'] = $id;
					$ShowData['ShowsHome']['display_name'] = $this->request->data['Show']['display_name'];
					$ShowData['ShowsHome']['special_message'] = $this->request->data['Show']['special_message'];
					$this->ShowsHome->save($ShowData['ShowsHome'],false);
					
					
						$this->Session->write('popup','Show has been updated successfully.');
						$this->Session->setFlash('Show has been updated successfully.');  
						//	$this->redirect(array('controller'=>'shows','action' => "index/message:success")); apurav 06-11-2013
						$this->redirect(array('superadmin'=>true,'controller'=>'adminusers','action'=>'home/message:success'));
						
					} else {
						$this->Session->setFlash('Data save problem, Please try again.');  
						$this->redirect(array('controller'=>'shows','action' => "edit",$id));
					}
										
				}	
				
		}
		
		
	}
	
	
	public function superadmin_view_pdf($id = null) {
		
	$this->layout = 'ajax';
    $this->Show->id = $id;
	$this->Show->unbindModel(array('hasMany' => array('Registration')));
	$showDetail=$this->Show->find("first",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'INNER',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('Show.id'=>$id)));
	
	
	
    if (!$this->Show->exists()) {
        throw new NotFoundException(__('Invalid post'));
    }
    // increase memory limit in PHP 
    ini_set('memory_limit', '512M');
    $this->set('show',$showDetail);

	
	
	
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
			
			$this->loadModel('ShowsHome');
			$this->ShowsHome->query('delete from shows_home where show_id="'.$id.'" ');	
			
			if ($this->Show->delete($id)) {
				$this->Session->write('popup','Show has been deleted successfully.');
				$this->Session->setFlash('Show has been deleted successfully.');  
				//	$this->redirect(array('controller'=>'shows','action' => "index/message:success")); apurav 06-11-2013
				$this->redirect(array('superadmin'=>true,'controller'=>'adminusers','action'=>'home/message:success'));
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
			$candidate_info = $this->Candidate->find('first',array('conditions'=>array('Candidate.id'=>$this->Session->read('candidateId'))));
						
			if($this->request->data):
				if(!empty($this->request->data['Registration']['Submit'])):
				
					
					
					if(isset($this->request->data['ChkIsbsTxn']))
					{
					$this->redirect(array('controller'=>'candidates','action'=>'thankyou'));	
					}
					else
					{
						if(!is_array($this->request->data['Registration']['show_id']))
						$this->request->data['Registration']['show_id']='';
					}
					
					$this->Registration->set($this->request->data);
						
					if(!$this->Registration->eventValidate()):
						$errorsArr = $this->Registration->validationErrors;	
					else:
					
					
					
						//$this->request->data['Registration']['date_time']=date('Y-m-d',time());
						//	if($this->Registration->saveAll($this->request->data)):
						//
						
								if(!empty($this->request->data['Registration']['show_id']))
								{
									$showIds = $this->request->data['Registration']['show_id'] ;
								}	
							
								if(!empty($showIds))
								{
									foreach($showIds as $showId)
									{
										// ticket id 1407 (jitendra)
										$this->Show->recursive = 0;
										$showdetail = $this->Show->findById($showId);
										$show_home_detail = $this->common->get_show_homedetails($showId);
										if($show_home_detail['ShowsHome']['display_name']){
											$show_name	=	$show_home_detail['ShowsHome']['display_name'];
										}else{
											$show_name	=	$showdetail['Show']['show_name'];
										}
										$show_dt 	= $showdetail['Show']['show_dt'];
										$show_dt    =   strtotime($show_dt);
										//echo CURRENT_EST;die;
										$est_time   =   strtotime(CURRENT_EST);
										$seconds    = $show_dt - $est_time;
										//ticket # 1407 (jitendra)
										$showSecurityClearance = $showdetail['Show']['sec_clearance_list'];
										$candidateSecurityClearance = $this->common->getCandidateSecurityClearance($this->Session->read('candidateId'));
										if(!empty($showSecurityClearance)){
											$candidate_clearance_array = explode(',',$candidateSecurityClearance);
											$show_clearance_array = explode(',',$showSecurityClearance);
											$common_clearance  = array_intersect ($candidate_clearance_array, $show_clearance_array);
										}
											
										if(is_array($common_clearance) && count($common_clearance)==0){
									//		$this->Session->write('popup',"Sorry,your security clearance is not matching with event ".$showdetail['Show']['show_name']);
										$this->Session->write('popup',"Sorry, this event requires a security clearance that is not listed on your profile.");
											$this->redirect(array('controller'=>'shows','action'=>'eventregistration'));
											exit;
										}elseif($seconds>=3600){
											$this->request->data['Registration']['date_time']=date('Y-m-d',time());
											$this->request->data['Registration']['vip']='n';
											$this->request->data['Registration']['show_id'] = $showId;
											$this->Registration->saveAll($this->request->data);	

											// mail to candidate for event registration (ticket 4544 jitendra)
											$sendto = $candidate_info['Candidate']['candidate_email'];
											$sendfrom = 'amanda@TechExpoUSA.com';
											$subject = "TECHEXPO Registration Confirmation: ".$showdetail['Location']['location_city'].", ".date("F d",strtotime($showdetail['Show']['show_dt']));
											if($showdetail['Show']['email_type']=='s'){
												$bodyText = "Dear <strong>".$candidate_info['Candidate']['candidate_name']."</strong><br/><br/>Thank you for registering for the<br/><br/><strong>".$show_name."<br/>".date("l, F d, Y",strtotime($showdetail['Show']['show_dt']))."<br/>".$showdetail['Location']['site_name']."<br/>".$showdetail['Location']['site_address']."<br/>".$showdetail['Location']['location_city'].", ".$showdetail['Location']['location_state']."&nbsp;".$showdetail['Location']['site_zip']."</strong><br/><br/>A <strong>".$show_home_detail['ShowsHome']['special_message']."</strong> to attend.  Bring many copies of your resume with you, and share this invitation with your friends and colleagues that are also qualified to attend.<br/><br/>For details visit www.TechExpoUSA.com<br/><br/>Best Regards,<br/><br/>Amanda Alessio<br/>Marketing Director";
											}else{
												$bodyText = $showdetail['Show']['custom_email_message'];
											}
											$email = new CakeEmail('smtp');
											$email->from(array($sendfrom));
											$email->to($sendto);
											$email->emailFormat('html');
											$email->subject(strip_tags($subject));
											$ok = $email->send($bodyText);
											
											// entry in resume_set table  on show registration start Task id 2311
											$this->Show->id = $showId;
											$resume_set_idvalue = $this->Show->field('resume_set_id');
											
											$this->loadModel('Resume');
											$this->Resume->unbindModel(array('hasMany' => array('ResumeSkill')));
											$candidateResume = $this->Resume->find('first',array('conditions'=>array('Resume.candidate_id'=>$this->request->data['Registration']['candidate_id']),'fields'=>array('id'),'order'=>'modified DESC'));
											
											$resumeSetDt['ResumeSet']['set_id'] = $resume_set_idvalue;
											$resumeSetDt['ResumeSet']['resume_id'] = $candidateResume['Resume']['id']; 
											$this->loadModel('ResumeSet');
											$this->ResumeSet->save($resumeSetDt);
											// entry in resume_set table  on show registration end	
											
																					
										}else{
											$this->Session->write('popup',"Online pre-registration for an event ".$showdetail['Show']['show_name']." closes at 11 PM (EST) on the evening before the event.  However, you may still attend this event,  just come to the event and register in person.");
											$this->redirect(array('controller'=>'shows','action'=>'eventregistration'));
											exit;
										}										
										
									}
								}
							
								$this->Session->delete('candidateUserName');
								$this->Session->delete('candidateId');
								$this->redirect(array('controller'=>'candidates','action'=>'thankyou'));
					//		endif;
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
		// Set redirect url is set or not
		$this->set('referer_url',$this->referer());
		
		$this->layout = 'front';		
		$showListArray=$this->common->getShowList();  // experince array		
		$this->set('showListArray',$showListArray);		
		$this->request->data['Registration']['candidate_id']=$this->Session->read('Auth.Client.User.candidate_id');
		$candidate_info = $this->Candidate->find('first',array('conditions'=>array('Candidate.id'=>$this->Session->read('Auth.Client.User.candidate_id'))));
			
		if(!empty($this->request->data)):			
			
				if(!empty($this->request->data['Registration']['Submit'])):
				
					$this->Registration->set($this->request->data);
						
					if(!$this->Registration->eventValidate()):
						//$errorsArr = $this->Registration->validationErrors;	
					else:
					$this->Show->recursive = 0;	
					$showdetail = $this->Show->findById($this->request->data['Registration']['show_id']);
					$show_home_detail = $this->common->get_show_homedetails($this->request->data['Registration']['show_id']);
					if($show_home_detail['ShowsHome']['display_name']){
						$show_name	=	$show_home_detail['ShowsHome']['display_name'];
					}else{
						$show_name	=	$showdetail['Show']['show_name'];
					}
					$show_dt 	= $showdetail['Show']['show_dt'];
					$show_dt    =   strtotime($show_dt);					
					$est_time   =   strtotime(CURRENT_EST);
					$seconds    = $show_dt - $est_time;
					if($showdetail['Show']['sec_clearance_req']=='y')  // if added 13-11-2013 apurav
					{
						$showSecurityClearance = $showdetail['Show']['sec_clearance_list'];
						$candidateSecurityClearance = $this->common->getCandidateSecurityClearance($this->Session->read('Auth.Client.User.candidate_id'));
						if(!empty($showSecurityClearance)){
							$candidate_clearance_array = explode(',',$candidateSecurityClearance);
							$show_clearance_array = explode(',',$showSecurityClearance);
							$common_clearance  = array_intersect ($candidate_clearance_array, $show_clearance_array);						
						}
					}
					
					if(is_array($common_clearance) && count($common_clearance)==0){
						$this->Session->write('popup',"Sorry, this event requires a security clearance that is not listed on your profile.");
					}elseif($seconds>=3600){
						$this->request->data['Registration']['date_time']=date('Y-m-d',time());
						$this->request->data['Registration']['vip']='n';					
									
						if($this->Registration->saveAll($this->request->data)):
						
						// mail to candidate for event registration (ticket 4544 jitendra)
						$sendto = $candidate_info['Candidate']['candidate_email'];
						$sendfrom = 'amanda@TechExpoUSA.com';
						$subject = "TECHEXPO Registration Confirmation: ".$showdetail['Location']['location_city'].", ".date("F d",strtotime($showdetail['Show']['show_dt']));
						if($showdetail['Show']['email_type']=='s'){
							$bodyText = "Dear <strong>".$candidate_info['Candidate']['candidate_name']."</strong><br/><br/>Thank you for registering for the<br/><br/><strong>".$show_name."<br/>".date("l, F d, Y",strtotime($showdetail['Show']['show_dt']))."<br/>".$showdetail['Location']['site_name']."<br/>".$showdetail['Location']['site_address']."<br/>".$showdetail['Location']['location_city'].", ".$showdetail['Location']['location_state']."&nbsp;".$showdetail['Location']['site_zip']."</strong><br/><br/>A <strong>".$show_home_detail['ShowsHome']['special_message']."</strong> to attend.  Bring many copies of your resume with you, and share this invitation with your friends and colleagues that are also qualified to attend.<br/><br/>For details visit www.TechExpoUSA.com<br/><br/>Best Regards,<br/><br/>Amanda Alessio<br/>Marketing Director";
						}else{
							$bodyText = $showdetail['Show']['custom_email_message'];
						}						
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
							
						// entry in resume_set table  on show registration start Task id 2311
						$this->Show->id = $showdetail['Show']['id'];
						$resume_set_idvalue = $this->Show->field('resume_set_id');
						
						$this->loadModel('Resume');
						$this->Resume->unbindModel(array('hasMany' => array('ResumeSkill')));
						$candidateResume = $this->Resume->find('first',array('conditions'=>array('Resume.candidate_id'=>$this->request->data['Registration']['candidate_id']),'fields'=>array('id'),'order'=>'modified DESC'));
						
						$resumeSetDt['ResumeSet']['set_id'] = $resume_set_idvalue;
						$resumeSetDt['ResumeSet']['resume_id'] = $candidateResume['Resume']['id']; 
						$this->loadModel('ResumeSet');
						$this->ResumeSet->save($resumeSetDt);
						// entry in resume_set table  on show registration end	
						
							$this->Session->delete('candidateUserName');
							$this->Session->delete('candidateId');
							$this->Session->write('popup','Successfully Registered.');								
						endif;
					}else{
						$this->Session->write('popup',"Online pre-registration for an event closes at 11 PM (EST) on the evening before the event.  However, you may still attend this event,  just come to the event and register in person.");
					}	
					
					
					
					
					$this->redirect(array('controller'=>'shows','action' => "eventList/message:success",'Jobseeker'=>true)); //ticket id 1294
					
					
								
					//$this->redirect($this->request->data['Registration']['referer_url']);
					endif;
						
				endif;
		
			endif;
		
		//echo 'sadf';die;
	}
	public function superadmin_duplicateevent($eventId = null) 
	{
		if(isset($eventId)){
		
		$this->request->data = $this->Show->find('first',array('conditions'=>array('Show.id'=>$eventId)));
		$this->loadModel('ShowsHome');
		$showhomes = $this->ShowsHome->find('first',array('conditions'=>array('ShowsHome.show_id'=>$eventId)));
		
		
		$duplicate_entry['Show'] = $this->request->data['Show'];	
	//	$duplicate_entry['Show']['resume_set_id'] = ''; // code comment apurav 31-10-2013
		$duplicate_entry['Show']['published'] = 0;
		unset($duplicate_entry['Show']['id']);
		
	
		// copy new show document files start
		
		if(!empty($duplicate_entry['Show']['show_confirm_file']) && file_exists('ShowsDocument/showConfirmFile/'.$duplicate_entry['Show']['show_confirm_file']))
		{
			$file = 'ShowsDocument/showConfirmFile/'.$duplicate_entry['Show']['show_confirm_file'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$newConfirmFile = time().'_Show_Packet.'.$ext;
			$newfile = 'ShowsDocument/showConfirmFile/'.$newConfirmFile;
			copy($file, $newfile);	
			$duplicate_entry['Show']['show_confirm_file'] = $newConfirmFile;
			
		}
		
		if(!empty($duplicate_entry['Show']['show_guide_file']) && file_exists('ShowsDocument/showGuide/'.$duplicate_entry['Show']['show_guide_file']))
		{
			$file = 'ShowsDocument/showGuide/'.$duplicate_entry['Show']['show_guide_file'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$newConfirmFile = time().'_Show_Guide.'.$ext;
			$newfile = 'ShowsDocument/showGuide/'.$newConfirmFile;
			copy($file, $newfile);	
			$duplicate_entry['Show']['show_guide_file'] = $newConfirmFile;
			
		}
		
		if(!empty($duplicate_entry['Show']['ics_file']) && file_exists('ShowsDocument/ics/'.$duplicate_entry['Show']['ics_file']))
		{
			$file = 'ShowsDocument/ics/'.$duplicate_entry['Show']['ics_file'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$newConfirmFile = time().'_ics_file.'.$ext;
			$newfile = 'ShowsDocument/ics/'.$newConfirmFile;
			copy($file, $newfile);	
			$duplicate_entry['Show']['ics_file'] = $newConfirmFile;
			
		}
		if(!empty($duplicate_entry['Show']['boutique_banner_file']) && file_exists('ShowsDocument/boutiqueBanner/'.$duplicate_entry['Show']['boutique_banner_file']))
		{
			$file = 'ShowsDocument/boutiqueBanner/'.$duplicate_entry['Show']['boutique_banner_file'];
			$ext = pathinfo($file, PATHINFO_EXTENSION);
			$newConfirmFile = time().'_boutique_banner.'.$ext;
			$newfile = 'ShowsDocument/boutiqueBanner/'.$newConfirmFile;
			copy($file, $newfile);	
			$duplicate_entry['Show']['boutique_banner_file'] = $newConfirmFile;
			
		}
		
		// copy new show document files end
	
			
		$this->Show->save($duplicate_entry,false);
		
		$showhomes['ShowsHome']['show_id'] = $this->Show->getLastInsertId();
		$this->ShowsHome->save($showhomes,false);
		
		$this->Session->write('popup','Duplicate show created successfully.');
		$this->Session->setFlash('Duplicate show created successfully.');  
		$this->redirect(array('controller'=>'shows','action' => "index/message:success"));
		}



		
	}
	

	public function Jobseeker_eventList()  // function for event listing 
	{
		$this->isJobSeekerLogin();  // login check 
		$this->Session->read('Auth.Client.User.candidate_id');
		$this->layout = 'front';		
		$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
		$condition = "Show.show_dt>='".$targetdate."' and Show.published=1 ";
		/* $condition = "Registration.candidate_id='".$this->Session->read('Auth.Client.User.candidate_id')."' and show_dt>='".$targetdate."'"; */
		$this->Show->recursive =0;
		$this->paginate = array('limit' =>20,'order' => 'Show.show_dt ASC');
		$upcomingEvents = $this->paginate('Show', $condition);	
		//pr($upcomingEvents);die;
		
		$this->set('eventList',$upcomingEvents);
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
		
		/* if($this->Session->check('redirect_action_url')){
			$this->Session->delete('redirect_action_url');
		}else{ */			
			$this->Session->write('redirect_action_url','shows/view/'.$id);
		/* } */
		
		/*if($id)
		{
			$condition2  = "Show.id = ".$id." ";
			$eventDetail=$this->Show->find('first',array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'INNER',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=> $condition2));
			$this->set('shows',$eventDetail);	
			
		}*/
	
			
			$this->loadModel('ShowsHome');
			/*$showEntCheck = $this->ShowsHome->find('count',array('conditions'=>array('ShowsHome.show_id'=>$id)));
			if($showEntCheck==1)
			{*/
			$eventDetail = $this->Show->find("first",array('joins' => array(
			array(
						'table' => 'shows_home',
						'alias' => 'ShowsHome',
						'type' => 'LEFT',
						'conditions' => array(
							'ShowsHome.show_id = Show.id'
						)
					)
		
			),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('Show.id'=>$id)));
			
			$this->set('shows',$eventDetail);
		/*	}
			else
			{
			 $eventDetail =	$this->Show->find('first',array('fields' => array('Show.*'),'conditions'=> array('Show.id'=>$id)));
			 $this->set('shows',$eventDetail);				
			}*/
		
		// set meta title 
		  $this->set('meta_title_show','Job Fair Information : '.$eventDetail['Location']['location_city'].', '.$eventDetail['Location']['location_state']); 
		$this->set('meta_description_show','TECHEXPO Top Secret offers thousands of security clearance jobs in Virginia, Washington DC, Maryland, Colorado Springs and Alabama and produces job fairs targets to professionals with security clearance.');
		
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
						/*'ShowEmployer.payment_status' => 'y',*/ //task id 2309 
						'ShowEmployer.show_id = '.$id						
					)
				)
			);
			$options['order'] = array("Employer.employer_name ASC");
			$this->Employer->recursive = 1;
			$otherRegEmployer = $this->Employer->find('all', $options);
			$this->set('otherRegEmployer',$otherRegEmployer);
			// task id #3853
			$this->set('show_id',$id);
		}
		
	}
	
	public function index()
	{
		$this->layout = 'front';
		$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
		$this->Show->recursive = 0;
		$userType=$this->Session->read('Auth.Clients.user_type');
		if(isset($userType) && $userType=="E")
		{
		$shows=$this->Show->find('all',array('conditions'=>array('show_dt > "'.$targetdate.'" and Show.published=1  and Show.boutique="r" '),'limit'=>'20','order'=>'Show.show_dt ASC'));	
		}
		else
		{ 
		$shows=$this->Show->find('all',array('conditions'=>array('show_dt > "'.$targetdate.'" and Show.published=1'),'limit'=>'20','order'=>'Show.show_dt ASC'));
		}
		//pr($shows);
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