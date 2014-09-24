<?php 
/******************************************************************************************
 Coder  : Apurav Gaur
 Object : Controller to handle Folder operations - view , add, edit and delete
******************************************************************************************/ 
class FoldersController extends AppController {
	var $name = 'Folders'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript','Text'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler','Captcha','Email');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'front'; //this is the layout for admin panel 
	var $uses = array('Candidate','User','Code','Resume','ResumeSkill','ApplyHistory','JobPosting','ShowCompanyProfile','Employer','TrainingSchool','JobPostingSkill','Code','FolderContent','Registration','Folder','ShowInterview','ResumeSet','EmployerSet','ClearanceKeyword','Show');
	//public $displayField = 'employer_name';
	

	
	/* function for create resume folder for employer  */
	function resumefolder($action = null )
	{	
		$this->set('meta_title','Employer Resume Folder');
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		$this->set('folderExistsError','');
		
		
		$errorsArr = "";
		// Folder Icon List   
		$this->loadModel('FolderIcon');
		$icon_list = $this->FolderIcon->find('list',array('fields'=>array("icon_id", 'icon_color_descr')));
		$this->set('icon_list',$icon_list);
		
		// Folder data   
		$this->loadModel('Folder');
		$folder_data = $this->Folder->find('all',array('conditions'=>array('employer_contact_id'=>$empContactID),'order'=>'folder_id desc'));
		$this->set('folder_data',$folder_data);
		
		
		
		if($this->request->is('post')){
		
			
			$this->Folder->set($this->request->data);
			if(!$this->Folder->validates()) 
			{
				$errorsArr = $this->Folder->validationErrors;	
			}
			
			
			if(!empty($this->request->data['Folder']['folder_descr']))
			{
				$folderExists=$this->Folder->find('count',array('conditions'=>'Folder.folder_descr="'.$this->request->data['Folder']['folder_descr'].'"
													 and Folder.employer_contact_id="'.$empContactID.'" '));
				if($folderExists)
				{
					$errorsArr['folder_descr']['0']='Folder name already exists';
					$this->set('folderExistsError','Folder name already exists');
				}
				
			}
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else{
				$this->request->data['Folder']['employer_contact_id'] = $empContactID;
				$this->request->data['Folder']['owner_type'] = 'e';
				//pr($this->request->data);die;
				$result = $this->Folder->save($this->request->data);
				$this->Session->write('popup','Folder successfully Created.');
				
				$this->redirect(array('controller'=>'folders','action' => "resumefolder"));
			}
			
		}
		
	}
	
	
		function resumefiletofolder($resume_id = null)
	{ 
			$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		/******** Insert Data inro employerStats for Emplyer Site usages History****/
		// Code for creating employer History for download resume page
		$prevpage = '';
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=''){
			$prevpage = end(explode("/",$_SERVER['HTTP_REFERER']));
			$referrar = $_SERVER['HTTP_REFERER'];
		}else{
			$referrar  = BASE_URL."".$_SERVER['REQUEST_URI'];
		}
		$remoteAddress  = $_SERVER['REMOTE_ADDR'];		
		// employer history for download resumes
		$this->common->saveEmployerPagesVisitHistory($employerID,"/resumefiletofolder",$remoteAddress,$referrar);
			
			if(isset($this->request->data['Folder']['copy_folder_id']))
		{ 
			if(empty($this->request->data['Folder']['copy_folder_id']))
			{
			$this->Session->write('popup','No folder for copy resume.');	
			}
			else{
			$this->request->data['FolderContent']['folder_id'] = $this->request->data['Folder']['copy_folder_id'];
			$this->request->data['FolderContent']['e_resume_id'] = $this->request->data['Folder']['resume_id'];
				
			$result = $this->FolderContent->save($this->request->data);
			$this->Session->write('popup','Resume Copied successfully.');
			$this->redirect(array('controller'=>'folders','action' => "showRegisterResume/".$resume_id));
			}
		}
		
	}
	
	
	function createresumefolder($action = null,$resume_id = null )
	{ 
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
			if($this->request->is('post')){
			$this->Folder->set($this->request->data);
			if(!$this->Folder->validates()) 
			{
				$errorsArr = $this->Folder->validationErrors;	
			}
			if($errorsArr) 
			{
			 	$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
				$this->redirect(array('controller'=>'folders','action' => $action."/".$resume_id));
			
			}
			else{ 
				$this->request->data['Folder']['employer_contact_id'] = $empContactID;
				$this->request->data['Folder']['owner_type'] = 'e';
				//pr($this->request->data);die;
				$result = $this->Folder->save($this->request->data);
				$this->Session->write('popup','Folder successfully Created.');
				
				$this->redirect(array('controller'=>'folders','action' => $action."/".$resume_id));
			}
			
		}	
		
	}
	
	function scheduleInteview($candidate_id = null,$sendmail = null)
	{
			$this->set("interviewset",'');
		if(isset($candidate_id)){
		$candidate_dt = $this->Candidate->find('first',array('conditions'=>array('Candidate.id'=>$candidate_id)));
	
		$this->set('candidate_dt',$candidate_dt);
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		$employerName = $this->Session->read('Auth.Client.employerContact.contact_name');
		
		$showIds = $this->Session->read('selected_showid');
		$showList = count($showIds);
		$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
		
		$conditions = " ShowInterview.candidate_id=".$candidate_id." AND ShowInterview.employer_id=".$employerID." AND Show.show_dt > ".$targetdate." ";
		
			$k=1;
			$PostinIdList='';
			
			foreach($showIds as $showID)
			{
				$PostinIdList.=$showID;
				
				if($k!=$showList)
				{
					$PostinIdList.=',';
				}
				$k=$k+1;
			}
			
			
			if($PostinIdList)
			{
				$conditions.='AND ShowInterview.Show_id in ('.$PostinIdList.') ';
			}
		
		$candidate_event = $this->ShowInterview->find('count',array('conditions'=>$conditions))	;
		
		// if $candidate_event > 0 that mean that candidate already Schedule for that 
		$this->set('already_schedule','');
		if($candidate_event > 0 )
		$this->set('already_schedule','Yes');
		
		
		
		if(!isset($already_schedule))
		{
			
			if($PostinIdList)
			{
				$conditions2=' Show.id in ('.$PostinIdList.') ';
			}
		$this->Show->recursive = -1;	
				
		$show_name = $this->Show->find('all',array('conditions'=>$conditions2,'fields'=>array('Show.show_name','Show.show_dt')));	
		$this->set('show_name',$show_name);
		
			if($this->request->is('post'))
		{
			// table entry
			

		
			foreach($showIds as $showId)
			{   
				$regEnrty['Registration']['candidate_id'] = $candidate_dt['Candidate']['id'];
				$regEnrty['Registration']['vip'] = 'y';
				$regEnrty['Registration']['show_id']= $showId;
				$this->Registration->save($regEnrty,false);
			}

			
			foreach($showIds as $showId)
			{   
				
			
				$shudInt['ShowInterview']['candidate_id'] = $candidate_dt['Candidate']['id'];
				$shudInt['ShowInterview']['employer_id'] = $employerID;
			 	$shudInt['ShowInterview']['show_id']= $showId;
				$shudInt['ShowInterview']['posting_id']= '0';
				$this->ShowInterview->save($shudInt,false);
			}
			
			
			
			$sendto = $candidate_dt['Candidate']['candidate_email'];
			$sendfrom = $this->request->data['Folder']['email'];
			$emailMessage = $this->request->data['Folder']['mailnotes'];
	
			$subject = $employerName." is requesting an interview with you at TECHEXPO";
			$bodyText = "<b>The following introduction will be included before your message:</b><br><br>
			Dear ".$candidate_dt['Candidate']['candidate_name'].",<br><br>

Thank you again for having registered for events<br><br>

Good News ! seobrand wishes to interview with you at the event. This upgrades your registration status to VIP. When you get to the show, DO NOT wait in line. Simply print this e-mail, bring it with you and present it directly at the event's registration desk. You will be escorted right in, without having to wait in line.<br><br>

You can view and print a list of all the companies who wish to interview with you at the event from the registration center at http://techexpo.seobranddev.com/jobseeker_register - Additionally, a list will be printed and waiting for you at the event's registration desk.<br><br>

**********************************************************************<br>
Following is a note from the employer...<br>
**********************************************************************<br>";
	if(isset($this->request->data['Folder']['email']))
	$bodyText.= $this->request->data['Folder']['mailnotes']; 
			
	
			$email = new CakeEmail();
			$email->from(array($sendfrom));
			//$email->to($sendto);
			$email->to("seobranddevelopers@gmail.com");
			$email->emailFormat('html');
			$email->subject(strip_tags($subject));
	
			$ok = $email->send($bodyText);
	
			if($ok){
			$this->set("interviewset",'yes');	
			$this->Session->write('popup','Interview scheduled successfully.');
			$this->redirect(array('controller'=>'folders','action' => "scheduleInteview/".$candidate_dt['Candidate']['id']));
			}
			
			}
		
			
		}
		



		}
	}
	function deletefolder($folder_id = null)
	{
		$this->loadModel('Folder');
		if(isset($folder_id))
		{
			$this->Folder->delete(array('Folder.folder_id' =>$folder_id));
			$this->Session->write('popup','Folder deleted successfully.');
			$this->redirect(array('controller'=>'folders','action' => "resumefolder"));
		}
	}

	function emptyfolder($folder_id = null)
	{
		$this->loadModel('FolderContent');
		if(isset($folder_id))
		{
			$this->FolderContent->deleteAll(array('FolderContent.folder_id' =>$folder_id));
			$this->Session->write('popup','Folder empty successfully.');
			$this->redirect(array('controller'=>'folders','action' => "resumefolder"));
		}
	}
	function iconname($id = null)
	{
		$this->loadModel('FolderIcon');

		if(isset($id))
		{
			$icon= $this->FolderIcon->find('first',array('conditions'=>array('icon_id'=>$id),'fields'=>array('icon_image_path')));
			return $icon['FolderIcon']['icon_image_path'];
		}
	}
	function editfolder($id = null)
	{
		// Folder Icon List
		$this->loadModel('FolderIcon');
		$this->loadModel('Folder');
		$icon_list = $this->FolderIcon->find('list',array('fields'=>array("icon_id", 'icon_color_descr')));
		$this->set('icon_list',$icon_list);

		if ($this->request->is('get')) {
			$this->request->data = $this->Folder->find('first',array('conditions'=>array('folder_id'=>$id)));
			$this->set('folderDt',$this->request->data['Folder']);
		}
		else{
			$empContactID = $this->Session->read('Auth.Client.employerContact.id');

			if(!$this->Folder->validates())
			{
				$errorsArr = $this->Folder->validationErrors;
			}
				
			if($errorsArr)
			{
				$this->set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			else{
				$this->request->data['Folder']['employer_contact_id'] = $empContactID;
				$this->request->data['Folder']['owner_type'] = 'e';
				$this->request->data['Folder']['folder_id'] = $id;
				$this->request->data['Folder']['icon_id'] = $this->request->data['Candidate']['icon_id'];
				$this->request->data['Folder']['folder_descr'] = $this->request->data['Candidate']['folder_descr'];
				//pr($this->request->data);die;
				$result = $this->Folder->save($this->request->data);
				$this->Session->write('popup','Folder successfully Updated.');
				$this->redirect(array('controller'=>'folders','action' => "resumefolder"));
					
			}


		}
	}

	function export($id = null ) {

		$this->loadModel('FolderContent');
		$this->loadModel('Resume');
		$this->loadModel('Candidate');


		$FolderRec = $this->FolderContent->find('all',array('conditions'=>array('folder_id'=>$id),'fields'=>array('FolderContent.e_resume_id','FolderContent.folder_id','FolderContent.notes','Resume.candidate_id')));
	 $i='0';
	 foreach($FolderRec as $dt){
	 	$FolderRec2 = $this->Candidate->find('first',array('conditions'=>array('Candidate.id'=>$dt['Resume']['candidate_id']),'fields'=>array('Candidate.candidate_name','Candidate.candidate_email','Candidate.candidate_phone')));
	 	$FolderRec[$i]['Candidate'] = $FolderRec2['Candidate'];
	 	$i++;
	 }
		//$candidate_dt



		//pr($FolderRec);die;
		ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large

		//create a file
		$filename = "export_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');

		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');


		// The column headings of your .csv file
		$header_row = array("candidate_name","candidate_email","candidate_phone","notes");
		fputcsv($csv_file,$header_row,',','"');

		// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
		foreach($FolderRec as $result)
		{
			// Array indexes correspond to the field names in your db table(s)
			$row = array(
						
					$result['Candidate']['candidate_name'],
					$result['Candidate']['candidate_email'],
					$result['Candidate']['candidate_phone'],
					$result['FolderContent']['notes']
						
			);

			fputcsv($csv_file,$row,',','"');
		}

		fclose($csv_file);die;


	}

	function folderContent($id = null,$action = null)
	{
		$this->set('meta_title','Employer Folder Content');
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');

		// all folder list related to current emplyer
		$this->loadModel('Folder');
		$folderList = $this->Folder->find('list',array('conditions'=>'Folder.employer_contact_id='.$empContactID.' and Folder.folder_id !='.$id,'fields'=>array('folder_id','folder_descr')));
		$this->set('folderList',$folderList);

		$foldername = $this->Folder->find('first',array('conditions'=>array('Folder.folder_id'=>$id),'fields'=>array('folder_descr')));
		$this->set('foldername',$foldername['Folder']['folder_descr']);

		//find all resume related to folder for employer
		$this->loadModel('FolderContent');
		$folderContent = $this->FolderContent->find('all',array('conditions'=>array('FolderContent.folder_id'=>$id),'fields'=>array('FolderContent.folder_id','FolderContent.e_resume_id','FolderContent.notes','FolderContent.fc_id','Resume.candidate_id','Resume.resume_title','Resume.posted_dt')));

		$i='0';
		$this->loadModel('Candidate');
		foreach($folderContent as $dt){
	 	$FolderRec2 = $this->Candidate->find('first',array('conditions'=>array('Candidate.id'=>$dt['Resume']['candidate_id']),'fields'=>array('Candidate.candidate_name,Candidate.candidate_email')));
	 	$folderContent[$i]['Candidate'] = $FolderRec2['Candidate'];
	 	$i++;
		}

		$this->set('folderContent',$folderContent);
		$this->set('folder_id',$id);

		if($action=='sendmail')
		{
				
			$employerEmail = $this->Session->read('Auth.Client.employerContact.contact_email');
			$this->Folder->set($this->request->data);
			$errorsArr=array();


			if(!$this->Folder->validEmailResume())
			{
				$errorsArr = $this->Folder->validationErrors;
					

			}

			if(!$errorsArr)
			{
				$resumeTotal=$this->FolderContent->find('all',array('fields'=>'FolderContent.e_resume_id,FolderContent.fc_id,Resume.resume_content,Resume.id','conditions'=>'FolderContent.folder_id ="'.$id.'"' ));
					
				// delete old files
					
				$handler = opendir(WWW_ROOT.'candidateDocument/resumeSend/');  // empty folder
				foreach(glob(WWW_ROOT.'candidateDocument/resumeSend/'.'*.*') as $v){
					unlink($v);
				}

				foreach($resumeTotal as $value)  // create rtf file
				{
					$rtf=strip_tags($value['Resume']['resume_content'],'<br>&nbsp;');  // creating rtf file
					file_put_contents('candidateDocument/resumeSend/resume_'.$value['Resume']['id'].'.rtf', $rtf);
				}

				// ===== create zip file all if resume more then 10
				/*
				 $results = array();
				$handler = opendir('candidateDocument/resumeSend/');
				while ($file = readdir($handler))
				{
				if ($file != "." && $file != "..")
				{
				$results[] = 'candidateDocument/resumeSend/'.$file;
				}
				}
					
				$ZIPNAME=DATE('D_m_Y',time());
				$result = $this->common->create_zip($results,'candidateDocument/resumeSend/'.$ZIPNAME.'.zip');
				*/
				// ===== create zip file all if resume more then 10 End
					
					
					
					
					
				$sendto = $this->request->data['Folder']['email'];
				$sendfrom = $employerEmail;
				$emailMessage = $this->request->data['Folder']['mailnotes'];

				$subject = "Resume forwarded-Poasted on techexpoUSA.com";
				$bodyText = "This Resume was forwarded to you by someone you know. It was posted on TechExpoUSA.com, the career center of choice for all technology professionals. To view the details of this Resume, go to<br/>techexpoUSA.com<br/><br/>*************************************************************************************<br/>".$emailMessage."<br/><br/> Thank You <br> Tech Expo Team ";

				// email attachment
				$email = new CakeEmail();
				foreach($resumeTotal as $value){
					//$this->Email->filePaths  = array('/candidateDocument/resumeSend/');
					//$this->Email->attachments =array('resume_'.$value['Resume']['id']);
					$attachfilePath = WWW_ROOT."candidateDocument/resumeSend/resume_".$value['Resume']['id'].".rtf";
					if(file_exists($attachfilePath)){
						$email->attachments(array($attachfilePath));
					}
						
				}
				$email->from(array($sendfrom));
				$email->to($sendto);
				$email->emailFormat('html');
				$email->subject(strip_tags($subject));
				$ok = $email->send($bodyText);

				if($ok){
					$this->Session->write('popup','Resume forwarded successfully.');
					$this->redirect(array('controller'=>'folders','action' => "folderContent/".$id));
				}
					
			}

		}
	}

	function removeResume($folder_id= null, $id= null)
	{

		$this->loadModel('FolderContent');
		if(isset($id))
		{
			$this->FolderContent->delete(array('FolderContent.fc_id' =>$id));
			$this->Session->write('popup','Resume removed successfully.');
			$this->redirect(array('controller'=>'folders','action' => "folderContent/".$folder_id));
		}
			
	}

	// show resume detail
	function showResume($resume_id = null)
	{
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		$folderList = $this->Folder->find('list',array('conditions'=>'Folder.employer_contact_id='.$empContactID ,'fields'=>array('folder_id','folder_descr')));
		$this->set('folderList',$folderList);

		

		// next and previous resume code start
			$CurrentPostKey= array_pop(array_keys($this->Session->read('search_db_event'),$resume_id));
			$nextResumeId=''; 
			$previousResumeId='';
			$SearchIdList=$this->Session->read('search_db_event');
			
			
			if(array_key_exists($CurrentPostKey+1,$SearchIdList))
			{
			$nextResumeId=$SearchIdList[$CurrentPostKey+1];
			}
			
			if(array_key_exists($CurrentPostKey-1,$SearchIdList))
			{
			$previousResumeId=$SearchIdList[$CurrentPostKey-1];
			}
			$this->set('nextResumeId',$nextResumeId);
			$this->set('previousResumeId',$previousResumeId);
		// next and previous resume code End


	
	
		$options['joins'] = array(
				array('table' => 'folders',
						'alias' => 'Folder',
						'type' => 'left',
						'conditions' => array(
								"Folder.folder_id	 = FolderContent.folder_id"
						)
				)
		);
		$options['conditions'] = array(
				"FolderContent.e_resume_id ='".$resume_id."'",
				"Folder.employer_contact_id ='".$empContactID."'"
		);
		$options['fields'] = array('DISTINCT FolderContent.folder_id,Folder.folder_descr');

		$currentfolderList = $this->FolderContent->find('all',$options);
		$this->set('currentfolderList',$currentfolderList);
		$this->loadModel('Resume');

		if(isset($this->request->data['Folder']['copy_folder_id']))
		{
			if(empty($this->request->data['Folder']['copy_folder_id']))
			{
			$this->Session->write('popup','No folder for copy resume.');	
			}
			else{
			$this->request->data['FolderContent']['folder_id'] = $this->request->data['Folder']['copy_folder_id'];
			$this->request->data['FolderContent']['e_resume_id'] = $this->request->data['Folder']['resume_id'];
				
			$result = $this->FolderContent->save($this->request->data);
			$this->Session->write('popup','Resume Copied successfully .');
			}
		}

		if(!empty($resume_id)):

		$candidateRec=$this->Resume->find('first',array('conditions'=>'Resume.id="'.$resume_id.'"'));
			
		endif;
		$this->set('candidateRec',$candidateRec);
		$this->set('resume_id',$resume_id);
		
		// use to show candidate video with resume
		$this->loadModel('CandidateVideo');
		$CandidateVd = $this->CandidateVideo->find('first',array('conditions'=>array('CandidateVideo.candidate_id'=>$candidateRec['Resume']['candidate_id'],'CandidateVideo.isApproved'=>'Y'),'order'=>'CandidateVideo.id DESC','fields'=>array('video_type','video','description','id')));
		$this->set('CandidateVd',$CandidateVd);
	}

	function showRegisterResume($resume_id = null)
	{
		// next and previous resume code start
		$CurrentPostKey= array_pop(array_keys($this->Session->read('search_reg_event'),$resume_id));
		$nextResumeId=''; 
		$previousResumeId='';
		$SearchIdList=$this->Session->read('search_reg_event');
		
		
		if(array_key_exists($CurrentPostKey+1,$SearchIdList))
		{
		$nextResumeId=$SearchIdList[$CurrentPostKey+1];
		}
		
		if(array_key_exists($CurrentPostKey-1,$SearchIdList))
		{
		$previousResumeId=$SearchIdList[$CurrentPostKey-1];
		}
		$this->set('nextResumeId',$nextResumeId);
		$this->set('previousResumeId',$previousResumeId);
		// next and previous resume code end

		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		$folderList = $this->Folder->find('list',array('conditions'=>'Folder.employer_contact_id='.$empContactID ,'fields'=>array('folder_id','folder_descr')));
		$this->set('folderList',$folderList);

		$options['joins'] = array(
				array('table' => 'folders',
						'alias' => 'Folder',
						'type' => 'left',
						'conditions' => array(
								"Folder.folder_id	 = FolderContent.folder_id"
						)
				)
		);
		$options['conditions'] = array(
				"FolderContent.e_resume_id ='".$resume_id."'",
				"Folder.employer_contact_id ='".$empContactID."'"
		);
		$options['fields'] = array('DISTINCT FolderContent.folder_id,Folder.folder_descr');

		$currentfolderList = $this->FolderContent->find('all',$options);
		$this->set('currentfolderList',$currentfolderList);
		$this->loadModel('Resume');

		if($this->request->data)
		{
			$this->request->data['FolderContent']['folder_id'] = $this->request->data['Folder']['copy_folder_id'];
			$this->request->data['FolderContent']['e_resume_id'] = $this->request->data['Folder']['resume_id'];
				
			$result = $this->FolderContent->save($this->request->data);
			$this->Session->write('popup','Resume Copied successfully .');


				
		}

		if(!empty($resume_id)):

		$candidateRec=$this->Resume->find('first',array('conditions'=>'Resume.id="'.$resume_id.'"'));
			
		endif;
		$this->set('candidateRec',$candidateRec);
		$this->set('resume_id',$resume_id);
		
		// use to show candidate video with resume
		$this->loadModel('CandidateVideo');
		$CandidateVd = $this->CandidateVideo->find('first',array('conditions'=>array('CandidateVideo.candidate_id'=>$candidateRec['Resume']['candidate_id'],'CandidateVideo.isApproved'=>'Y'),'order'=>'CandidateVideo.id DESC','fields'=>array('video_type','video','description','id')));
		$this->set('CandidateVd',$CandidateVd);
	}
	// create rtf resume file and download
	function exportResume($id = null ) {
		$this->autoRender = false;
		
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		/******** Insert Data inro employerStats for Emplyer Site usages History****/
		// Code for creating employer History for download resume page
		$prevpage = '';
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!=''){
			$prevpage = end(explode("/",$_SERVER['HTTP_REFERER']));
			$referrar = $_SERVER['HTTP_REFERER'];
		}else{
			$referrar  = BASE_URL."".$_SERVER['REQUEST_URI'];
		}
		$remoteAddress  = $_SERVER['REMOTE_ADDR'];		
		// employer history for download resumes
		$this->common->saveEmployerPagesVisitHistory($employerID,"/exportResume",$remoteAddress,$referrar);
		
		/** Download resume **/
		$this->loadModel('Resume');
		$resume = $this->Resume->find('first',array('conditions'=>array('Resume.id'=>$id),'fields'=>array('Resume.resume_content')));

		$rtf=strip_tags($resume['Resume']['resume_content'],'<br>&nbsp;');  // creating rtf file
		file_put_contents('candidateDocument/resume/downloadreume_'.$resume['Resume']['id'].'.rtf', $rtf);
		header("Content-type: application/rtf");
		echo file_get_contents('candidateDocument/resume/downloadreume_'.$resume['Resume']['id'].'.rtf');
		exit();
	}


	function updatenotes($id = null)
	{
		$foldername = $this->FolderContent->find('first',array('conditions'=>array('FolderContent.fc_id'=>$id),'fields'=>array('notes','fc_id','folder_id')));
		$this->set('fc',$foldername);
		if($this->request->isPost())
		{
			$this->loadModel('FolderContent');
			$this->request->data['FolderContent']['fc_id'] = $id;
			$this->request->data['FolderContent']['notes'] = $this->data['Folder']['notes'];
			$result = $this->FolderContent->save($this->request->data);
			$this->Session->write('popup','Notes successfully Updated.');
			$this->redirect(array('controller'=>'folders','action' => "folderContent/".$this->data['Folder']['folder_id']));
		}
	}
	function copyresume($id = null)
	{

		$this->loadModel('FolderContent');
		$current_folder = $this->FolderContent->findByFcId($this->data['Candidate']['fc_id']);

		$this->request->data['FolderContent']['folder_id'] = $this->data['Candidate']['copy_folder_id'];
		$this->request->data['FolderContent']['e_resume_id'] = $current_folder['FolderContent']['e_resume_id'];
		$this->request->data['FolderContent']['c_job_id'] = $current_folder['FolderContent']['c_job_id'];
		$this->request->data['FolderContent']['notes'] = $current_folder['FolderContent']['notes'];
		$this->request->data['FolderContent']['tracking_id'] = $current_folder['FolderContent']['tracking_id'];
		$this->request->data['FolderContent']['status'] = $current_folder['FolderContent']['status'];


		$result = $this->FolderContent->save($this->request->data);
		$this->Session->write('popup','Resume Copied successfully .');
		$this->redirect(array('controller'=>'folders','action' => "folderContent/".$id));

	}

	function moveresume()
	{

		$this->loadModel('FolderContent');
		$current_folder = $this->FolderContent->findByFcId($this->data['Candidate']['fc_id']);

		$this->request->data['FolderContent']['folder_id'] = $this->data['Candidate']['move_folder_id'];
		$this->request->data['FolderContent']['e_resume_id'] = $current_folder['FolderContent']['e_resume_id'];
		$this->request->data['FolderContent']['c_job_id'] = $current_folder['FolderContent']['c_job_id'];
		$this->request->data['FolderContent']['notes'] = $current_folder['FolderContent']['notes'];
		$this->request->data['FolderContent']['tracking_id'] = $current_folder['FolderContent']['tracking_id'];
		$this->request->data['FolderContent']['status'] = $current_folder['FolderContent']['status'];


		$result = $this->FolderContent->save($this->request->data);
		$this->FolderContent->delete(array('FolderContent.fc_id' =>$current_folder['FolderContent']['fc_id']));
		$this->Session->write('popup','Resume moved successfully .');
		$this->redirect(array('controller'=>'folders','action' => "resumefolder"));

	}

	public function mailsend($folder_id = null)
	{
		$employerEmail = $this->Session->read('Auth.Client.employerContact.contact_email');
		$this->Folder->set($this->request->data);
		$errorsArr=array();


		if(!$this->Folder->validEmailResume())
		{
			$errorsArr = $this->Folder->validationErrors;

		}

		if(!$errorsArr)
		{
			$resumeTotal=$this->FolderContent->find('all',array('fields'=>'FolderContent.e_resume_id,FolderContent.fc_id,Resume.resume_content,Resume.id','conditions'=>'FolderContent.folder_id ="'.$folder_id.'"' ));
				
			// delete old files
				
			$handler = opendir(WWW_ROOT.'candidateDocument/resumeSend/');  // empty folder
			foreach(glob(WWW_ROOT.'candidateDocument/resumeSend/'.'*.*') as $v){
				unlink($v);
			}

			foreach($resumeTotal as $value)  // create rtf file
			{
				$rtf=strip_tags($value['Resume']['resume_content'],'<br>&nbsp;');  // creating rtf file
				file_put_contents('candidateDocument/resumeSend/resume_'.$value['Resume']['id'].'.rtf', $rtf);
			}

			// ===== create zip file all if resume more then 10
			/*
			 $results = array();
			$handler = opendir('candidateDocument/resumeSend/');
			while ($file = readdir($handler))
			{
			if ($file != "." && $file != "..")
			{
			$results[] = 'candidateDocument/resumeSend/'.$file;
			}
			}
				
			$ZIPNAME=DATE('D_m_Y',time());
			$result = $this->common->create_zip($results,'candidateDocument/resumeSend/'.$ZIPNAME.'.zip');
			*/
			// ===== create zip file all if resume more then 10 End
				
				
				
				
				
			$sendto = $this->request->data['folders']['email'];
			$sendfrom = $employerEmail;
			$emailMessage = $this->request->data['folders']['mailnotes'];

			$subject = "Resume forwarded,oasted on  techexpoUSA.com";
			$bodyText = "This Resume was forwarded to you by someone you know. It was posted on TechExpoUSA.com, the career center of choice for all technology professionals. To view the details of this Resume, go to<br/>techexpoUSA.com<br/><br/>*************************************************************************************<br/>".$emailMessage."<br/><br/> Thank You <br> Tech Expo Team ";

			// email attachment

			foreach($resumeTotal as $value){
				$this->Email->filePaths  = array('/candidateDocument/resumeSend/');
				$this->Email->attachments =array('resume_'.$value['Resume']['id']);
			}

			$email = new CakeEmail();
			$email->from(array($sendfrom));
			$email->to($sendto);
			$email->emailFormat('html');
			$email->subject(strip_tags($subject));

			$ok = $email->send($bodyText);

			if($ok){
				$this->Session->write('popup','Resume forwarded successfully.');
				$this->redirect(array('controller'=>'folders','action' => "folderContent/".$folder_id));
			}
				
		}
	}

	public function mailResume($resume_id = null ,$action = null)
	{
		$employerEmail = $this->Session->read('Auth.Client.employerContact.contact_email');
		$this->set('resume_id',$resume_id);
		$this->Folder->set($this->request->data);

		$errorsArr=array();
		if(!$this->Folder->validEmailResume())
		{
			$errorsArr = $this->Folder->validationErrors;
				
		}


		if(!$errorsArr && $action=='sendresume')
		{
			$this->Resume->recursive = 0;
			$resume_detail=$this->Resume->find('first',array('fields'=>'Resume.resume_content,Resume.id','conditions'=>'Resume.id ="'.$resume_id.'"' ));

			// delete old files
				
			$handler = opendir(WWW_ROOT.'candidateDocument/resumeSend/');  // empty folder
			foreach(glob(WWW_ROOT.'candidateDocument/resumeSend/'.'*.*') as $v){
				unlink($v);
			}

			$rtf=strip_tags($resume_detail['Resume']['resume_content'],'<br>&nbsp;');  // creating rtf file
			file_put_contents('candidateDocument/resumeSend/resume_'.$resume_detail['Resume']['id'].'.rtf', $rtf);


				
			$sendto = $this->request->data['Folder']['email'];
			$sendfrom = $employerEmail;
			$emailMessage = $this->request->data['Folder']['mailnotes'];

			$subject = "Resume forwarded-Posted on  techexpoUSA.com";
			$bodyText = "This Resume was forwarded  by someone you know. It was posted on TechExpoUSA.com, the career center of choice for all technology professionals. To view the details of this Resume, go to<br/>techexpoUSA.com<br/><br/>*************************************************************************************<br/>".$emailMessage."<br/><br/> Thank You <br> Tech Expo Team ";

			//echo $bodyText;die;


			$email = new CakeEmail();
			$attachfilePath = WWW_ROOT."candidateDocument/resumeSend/resume_".$resume_detail['Resume']['id'].".rtf";
			if(file_exists($attachfilePath)){
				$email->attachments($attachfilePath);
			}
			$email->from(array($sendfrom));
			$email->to($sendto);
			$email->emailFormat('html');
			$email->subject(strip_tags($subject));

			$ok = $email->send($bodyText);

			if($ok){
				$this->Session->write('popup','Resume forwarded successfully.');
				$this->redirect(array('controller'=>'folders','action' => "mailResume/".$resume_id));
			}
				
		}
	}

	function searchRegCandidate()
	{
		$this->set('meta_title','Search Register Candidate');
			
		$this->loadModel('ShowEmployer');
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
			
		$condition  = "ShowEmployer.employer_id = ".$employerID."";
		$regEvents = $this->ShowEmployer->find('all',array('conditions'=>$condition,'order'=>array('Show.show_dt DESC')));
		$this->set('regEvents',$regEvents);
			
		$events = $this->ShowEmployer->find('all',array('conditions'=>$condition,'fields' => array('Show.show_name','Show.show_dt','Show.id'),'order'=>array('Show.show_dt DESC')));
		$event_list = Set::combine($events, '{n}.Show.id', array('{0} {1}', '{n}.Show.show_name', '{n}.Show.show_dt'));
		$this->set('event_list',$event_list);
		//pr($this->params->query);die;
	}

	function searchRegResult($action = null)
	{
		$this->set('keyword','');
		$this->set('meta_title','Search resume');
		$this->set('resumeLists',array());			
		//pr($this->params->query);
		$this->Session->write('search_reg_url',$_SERVER[ 'REQUEST_URI' ]);
	
			if($this->request->isGet())
			{
				$stringPostingIds='';
				$conditions='';
				$candidateString='';
				$show_id = '';
				$adv_sec = '';
				$candidate_state = '';

				if(count($this->params->query))			// if query string found
				{
					/* Initialize form variables if search was just POSTED */
					$search_words 			= trim($this->params->query['words']);
					$search_type  			= $this->params->query['type'];
					$citizen_status_code	= $this->params->query['citizen_status_code'];
					$experience_code		= $this->params->query['experience_code'];
					$date_search			= $this->params->query['date_search'];
					$time_units				= $this->params->query['time_units'];						
					$max_rows				= $this->params->query['max_rows'];
					
					if(isset($this->params->query['show_id'])){
						$show_id			= $this->params->query['show_id'];
					}
					if(isset($this->params->query['security_clearance_code2'])){
						$adv_sec				= $this->params->query['security_clearance_code2'];
					}
					if(isset($this->params->query['candidate_state'])){
						$candidate_state				= $this->params->query['candidate_state'];
					}
					
					$this->Session->write('selected_showid',$show_id); // apurav 12/19/2012
					
					if(isset($this->params->query['words'])){
						$words					=	$search_words;
						$type					=	$search_type;
						$candidate_state		=	$candidate_state;
						$citizen_status_code	=	$citizen_status_code;
						$experience_code		=	$experience_code;
						$show_id				=	$show_id;
					}
					
					if(isset($this->params->query['date_search'])){
						$date_search	=	$date_search;
						$time_units		=	$time_units;
						$today_date		=	date('Y-m-d');
						if(strlen($date_search)>0){
							$res_date_search	=	strtotime( '-'.$date_search.' '.$time_units.'' , strtotime ($today_date));
							$res_date_search	=	date("Y-m-d 00:00:00",$res_date_search);
						}
					}
					
					/*** Initialize security clearance from text field ****/
					/*** For form submits, clean up ' signs in security clearance text field -> replace with " ***/
					
					if(!empty($this->params->query['security_clearance_code'])){
						$security_clearance_code	=	str_replace("'", "\"", $this->params->query['security_clearance_code']);
					}else{
						$security_clearance_code	=	"";
					}
					
					/*** Initialize security clearance from pull-down ****/
					if(isset($this->params->query['security_clearance_code2'])){
						if(is_array($this->params->query['security_clearance_code2']) && count($this->params->query['security_clearance_code2'])>0){
							$security_clearance_code2	=	implode(",",$this->params->query['security_clearance_code2']);
						}else{
							$security_clearance_code2	=	"";
						}
					}
					
					/*** Clean up keywords search strings  ***/
					if($search_type!="Advanced"){
						$words	=	str_replace(",", " ", $words);
						$words	=	str_replace("'", " ", $words);
						$words	=	str_replace("(", " ", $words);
						$words	=	str_replace(")", " ", $words);
						$words	=	str_replace("\"", " ", $words);
						$words	=	str_replace(" and ", " ", $words);
						$words	=	str_replace(" or ", " ", $words);
						$words	=	str_replace(" not ", " ", $words);
					}
					
					$words2		=	str_replace(",", " ", $words);
					$words2		=	str_replace("'", " ", $words2);
					$words2		=	str_replace("(", " ", $words2);
					$words2		=	str_replace(")", " ", $words2);
					$words2		=	str_replace("\"", " ", $words2);
					$words2		=	str_ireplace(" and ", " ", $words2);
					$words2		=	str_ireplace(" or ", " ", $words2);
					$words2		=	str_ireplace(" not ", " ", $words2);
					
					$words3		=	str_replace(",", " ", $words);
					$words3		=	str_replace("'", " ", $words3);
					$words3		=	str_replace("(", " ", $words3);
					$words3		=	str_replace(")", " ", $words3);
					$words3		=	str_ireplace(" and ", " ", $words3);
					$words3		=	str_ireplace(" or ", " ", $words3);
					$words3		=	str_ireplace(" not ", " ", $words3);
					$words3		=	str_ireplace("   ", " ", $words3);
					$words3		=	str_ireplace("  ", " ", $words3);
					$words3		=	str_replace("\"", "", $words3);				
					
					/*** Conditional formatting ***/
					if(isset($this->params->query['security_clearance_code'])){
						$sec_clr_code	=	trim($this->params->query['security_clearance_code']);
						if(strlen($sec_clr_code)>0){
							if($adv_sec=='0'){
								$security_clearance_code	=	'"'.$sec_clr_code.'"';
								$adv_sec = 0;
							}else{
								$adv_sec=='1';
							}
						}
					}
					
					/*** Security Clearance artificial intelligence : for each value in
					 The security clearance pull-down, generate possible string matches ***/
					$security_clearance_code3	=	"";
					
					if(isset($this->params->query['security_clearance_code2'])){
						if(is_array($this->params->query['security_clearance_code2']) && count($this->params->query['security_clearance_code2'])>0){
							$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
							/*** get all security clearence values ***/
							$all_sec_clr	=	$this->ClearanceKeyword->find('all');
								
							$options_num	=	count($this->params->query['security_clearance_code2']);
							$cnt	=	1;
							$complex_search_string	=	"";
								
							foreach($all_sec_clr as $sec_clrs){
								if(in_array($sec_clrs['ClearanceKeyword']['clearance_code_id'],$this->params->query['security_clearance_code2']) && $baselist!='38'){
									if($sec_clrs['ClearanceKeyword']['clearance_code_id']==38){
										$complex_search_string	=	$complex_search_string.'("%a%"';
									}else{
										$complex_search_string	=	$complex_search_string.'("clearance"';
									}
										
									if($sec_clrs['ClearanceKeyword']['clearance_code_id']!="3922"){
						
										if(strlen($sec_clrs['ClearanceKeyword']['clearance_code_keywords1'])>0){
											$complex_search_string	=	$complex_search_string.' +(';
											$keywords1	=	explode(",",$sec_clrs['ClearanceKeyword']['clearance_code_keywords1']);
											$k1len	=	count($keywords1);
											$k1cnt	=	1;
												
											foreach($keywords1 as $keyword1){
												if($k1cnt==$k1len){
													$complex_search_string	=	$complex_search_string.' "'.$keyword1.'"';
												}else{
													$complex_search_string	=	$complex_search_string.' "'.$keyword1.'" ';
												}
												$k1cnt	=	$k1cnt	+	1;
											}
											$complex_search_string	=	$complex_search_string.')';
										}
						
										if(strlen($sec_clrs['ClearanceKeyword']['clearance_code_keywords2'])>0){
											$complex_search_string	=	$complex_search_string.' +(';
											$keywords2	=	explode(",",$sec_clrs['ClearanceKeyword']['clearance_code_keywords2']);
											$k2len	=	count($keywords2);
											$k2cnt	=	1;
						
											foreach($keywords2 as $keyword2){
												if($k2cnt==$k2len){
													$complex_search_string	=	$complex_search_string.' "'.$keyword2.'"';
												}else{
													$complex_search_string	=	$complex_search_string.' "'.$keyword2.'" ';
												}
												$k2cnt	=	$k2cnt	+	1;
											}
											$complex_search_string	=	$complex_search_string.')';
										}
						
									}else{
										if(strlen($security_clearance_code) > 0){
											if($adv_sec=='0'){
												$security_clearance_code	=	str_replace("\"", "", trim($security_clearance_code));
												//$complex_search_string		=	$complex_search_string." AND MATCH(Resume.resume_content) AGAINST('\"".$security_clearance_code."\"' IN BOOLEAN MODE))";
												$complex_search_string		=	$complex_search_string.' +"'.$security_clearance_code.'")';
											}else{
												// make string boolean of security clearence
												$pos = stripos(trim($security_clearance_code), " and ");
												//var_dump($pos);die;
												if($pos===false){
													$pos1 = stripos(trim($security_clearance_code), " or ");
													if($pos1===false){
														$pos2 = stripos(trim($security_clearance_code), " not ");
														if($pos2===false){
															$con_sec_clr = trim($security_clearance_code);
														}else{
															if(substr(end(explode(" not ",strtolower(trim($security_clearance_code)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($security_clearance_code)))), 0,1)=='('){
																$con_sec_clr	=	str_ireplace(" not ", " -", trim($security_clearance_code));
															}else{
																$con_sec_clr	=	str_ireplace(" not ", "\" -\"", trim($security_clearance_code));
															}
														}
													}else{
						
														if(substr(end(explode(" or ",strtolower(trim($security_clearance_code)))), 0,1)=='"' || substr(end(explode(" or ",strtolower(trim($security_clearance_code)))), 0,1)=='('){
															$con_sec_clr	=	str_ireplace(" or ", " ", trim($security_clearance_code));
														}else{
															$con_sec_clr	=	str_ireplace(" or ", "\" \"", trim($security_clearance_code));
														}
						
														if(substr(end(explode(" not ",strtolower(trim($con_sec_clr)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($con_sec_clr)))), 0,1)=='('){
															$con_sec_clr	=	str_ireplace(" not ", " -", trim($con_sec_clr));
														}else{
															$con_sec_clr	=	str_ireplace(" not ", "\" -\"", trim($con_sec_clr));
														}
													}
												}else{
													$sec_clr_pt = explode(" and ",strtolower(trim($security_clearance_code)));
													$cnt = 1;
													$len = count($sec_clr_pt);
													$con_sec_clr = "";
													foreach($sec_clr_pt as $key => $val){
														if(substr(trim($val), 0,1)!='"' && substr(trim($val), 0,1)!='('){
															$val = '"'.$val;
														}
														if(substr(trim($val), -1)!='"' && substr(trim($val), -1)!=')'){
															$val = $val.'"';
														}
						
														if($cnt==$len){
															//$con_sec_clr .= "+".$val;
															if(substr(trim($val), 0,1)=='(' && $key=='0'){
																$val   = str_replace("(", "", trim($val));
																$con_sec_clr .= "(+".$val;
															}elseif(substr(trim($val), 0,1)=='(' && $key!='0'){
																$val   = str_replace("(", "", trim($val));
																$con_sec_clr .= "+(".$val;
															}else{
																$con_sec_clr .= "+".$val;
															}
														}else{
															//$con_sec_clr .= "+".$val." ";
															if(substr(trim($val), 0,1)=='(' && $key=='0'){
																$val   = str_replace("(", "", trim($val));
																$con_sec_clr .= "+(".$val." ";
															}elseif(substr(trim($val), 0,1)=='(' && $key!='0'){
																$val   = str_replace("(", "", trim($val));
																$con_sec_clr .= "+(".$val." ";
															}else{
																$con_sec_clr .= "+".$val." ";
															}
														}
														$cnt++;
													}
														
													if(substr(end(explode(" or ",strtolower(trim($con_sec_clr)))), 0,1)=='"' || substr(end(explode(" or ",strtolower(trim($con_sec_clr)))), 0,1)=='('){
														$con_sec_clr	=	str_ireplace(" or ", " ", trim($con_sec_clr));
													}else{
														$con_sec_clr	=	str_ireplace(" or ", "\" \"", trim($con_sec_clr));
													}
														
													if(substr(end(explode(" not ",strtolower(trim($con_sec_clr)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($con_sec_clr)))), 0,1)=='('){
														$con_sec_clr	=	str_ireplace(" not ", " -", trim($con_sec_clr));
													}else{
														$con_sec_clr	=	str_ireplace(" not ", "\" -\"", trim($con_sec_clr));
													}
												}
												//echo $con_sec_clr;die;
												//$complex_search_string	=	$complex_search_string." AND MATCH(Resume.resume_content) AGAINST('".$con_sec_clr."' IN BOOLEAN MODE))";
												$complex_search_string	=	$complex_search_string." +(".$con_sec_clr."))";
											}
												
										}
									}
						
									if($cnt==$options_num OR $options_num==1){
										if($sec_clrs['ClearanceKeyword']['clearance_code_id']!="3922"){
											$complex_search_string	=	$complex_search_string.')';
										}
									}else{
										$complex_search_string	=	$complex_search_string.') ';
									}
						
									$cnt	=	$cnt+1;
								}
									
							} /** end of foreach($all_sec_clr as $sec_clrs) loop **/
								
							$security_clearance_code3	=	$complex_search_string;
						}
					}
					
					/**** Build query  -> NOT INDENTED SO SQL CODE IS EXACTLY THE SAME IN RESUME VIEW MODE ****/
					$conditions ="";
					$match_condition = "";
					/**** Serch result when Serach TYPE iS ANY *****/
					if($search_type=='Any'){
						$cnt	=	1;
						$match_condition .= '(';
							
						if(strlen($security_clearance_code3)>0){
							$match_condition .= $security_clearance_code3.")";
						}
							
						if(strlen($words)>0){
							$word_array	=	explode(" ",trim($words));
							$conditions .= " AND (";
							foreach($word_array as $word){
								if((trim($word)!="AND") && (trim($word)!="OR") && (trim($word)!="C")){
									if($cnt==1){
										$conditions .= "(Resume.resume_content like '%".$word."%')";
									}else{
										$conditions .= " OR (Resume.resume_content like '%".$word."%')";
									}
								}
								$cnt=$cnt+1;
							}
							$conditions .= ")";
						}
							
						$stlist = 1;
						if(is_array($this->params->query['candidate_state'])){
							if($this->params->query['candidate_state'][0]!="ALL"){
								$conditions .= " AND (";
								foreach($this->params->query['candidate_state'] as $states){
									if($stlist==1){
										$conditions .= "((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}else{
										$conditions .= " OR ((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}
									$stlist++;
								}
								$conditions .= ")";
							}
						}
					
						if(($this->params->query['citizen_status_code']!="") || ($this->params->query['citizen_status_code']!='0')){
							$conditions .= " AND ((Candidate.citizen_status_code='".$this->params->query['citizen_status_code']."') OR (Candidate.citizen_status_code is NULL) OR (Candidate.citizen_status_code =3226))";
						}
							
						if(is_array($this->params->query['security_clearance_code2'])){
							//pr($this->params->query['security_clearance_code2']);
							$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
							if(($baselist!='38') && (count($this->params->query['security_clearance_code2'])>0)){
								if(in_array("3650", $this->params->query['security_clearance_code2'])===FALSE){
									$conditions .= " AND ((Candidate.security_clearance_code!='3650') AND (Candidate.security_clearance_code not like '%,3650') AND (Candidate.security_clearance_code not like '3650,%') AND (Candidate.security_clearance_code not like '%,3650,%'))";
								}
								if(in_array("3922", $this->params->query['security_clearance_code2'])===FALSE){
									$conditions .= " AND ((Candidate.security_clearance_code!='3922') AND (Candidate.security_clearance_code not like '%,3922') AND (Candidate.security_clearance_code not like '3922,%') AND (Candidate.security_clearance_code not like '%,3922,%'))";
								}
							}elseif($baselist=='38'){
								$conditions .= " AND ((Candidate.security_clearance_code='38') OR (Candidate.security_clearance_code IS NULL) OR (LENGTH(Candidate.security_clearance_code)=0))";
							}
						}
							
						if($this->params->query['experience_code']!=""){
							$conditions .= " AND ((Candidate.experience_code>='".$this->params->query['experience_code']."') OR (Candidate.experience_code is NULL))";
						}
							
						if(strlen($date_search)>0){
							$conditions .= " AND Resume.posted_dt>='".$res_date_search."'";
						}

						if(is_array($show_id)){
							$showList = 1;
							$conditions .= " AND (";
							foreach($show_id as $showID){
								if($showList==1){
									$conditions .= "(Registration.show_id=".$showID.")";
								}else{
									$conditions .= " OR (Registration.show_id=".$showID.")";
								}
								$showList++;
							}
							$conditions .= ")";
						}
						
					}
					
					/**** Serch result when Serach TYPE iS ANY *****/
					if($search_type=='All'){
						$cnt	=	1;
						$match_condition .= '(';
							
						if(strlen($security_clearance_code3)>0){
							$match_condition .= $security_clearance_code3.")";
						}
							
						if(strlen($words)>0){
							$word_array	=	explode(" ",trim($words));
							$conditions .= " AND (";
							foreach($word_array as $word){
								if((trim($word)!="AND") && (trim($word)!="OR") && (trim($word)!="C")){
									if($cnt==1){
										$conditions .= "(Resume.resume_content like '%".$word."%')";
									}else{
										$conditions .= " AND (Resume.resume_content like '%".$word."%')";
									}
								}
								$cnt=$cnt+1;
							}
							$conditions .= ")";
						}
													
						$stlist = 1;
						if(is_array($this->params->query['candidate_state'])){
							if($this->params->query['candidate_state'][0]!="ALL"){
								$conditions .= " AND (";
								foreach($this->params->query['candidate_state'] as $states){
									if($stlist==1){
										$conditions .= "((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}else{
										$conditions .= " OR ((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}
									$stlist++;
								}
								$conditions .= ")";
							}
						}
					
						if(($this->params->query['citizen_status_code']!="") || ($this->params->query['citizen_status_code']!='0')){
							$conditions .= " AND ((Candidate.citizen_status_code='".$this->params->query['citizen_status_code']."') OR (Candidate.citizen_status_code is NULL) OR (Candidate.citizen_status_code =3226))";
						}
							
						if(isset($this->params->query['security_clearance_code2'])){
							if(is_array($this->params->query['security_clearance_code2'])){
								//pr($this->params->query['security_clearance_code2']);
								$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
								if(($baselist!='38') && (count($this->params->query['security_clearance_code2'])>0)){
									if(in_array("3650", $this->params->query['security_clearance_code2'])===FALSE){
										$conditions .= " AND ((Candidate.security_clearance_code!='3650') AND (Candidate.security_clearance_code not like '%,3650') AND (Candidate.security_clearance_code not like '3650,%') AND (Candidate.security_clearance_code not like '%,3650,%'))";
									}
									if(in_array("3922", $this->params->query['security_clearance_code2'])===FALSE){
										$conditions .= " AND ((Candidate.security_clearance_code!='3922') AND (Candidate.security_clearance_code not like '%,3922') AND (Candidate.security_clearance_code not like '3922,%') AND (Candidate.security_clearance_code not like '%,3922,%'))";
									}
								}elseif($baselist=='38'){
									$conditions .= " AND ((Candidate.security_clearance_code='38') OR (Candidate.security_clearance_code IS NULL) OR (LENGTH(Candidate.security_clearance_code)=0))";
								}
							}
						}
							
						if($this->params->query['experience_code']!=""){
							$conditions .= " AND ((Candidate.experience_code>='".$this->params->query['experience_code']."') OR (Candidate.experience_code is NULL))";
						}
							
						if(strlen($date_search)>0){
							$conditions .= " AND Resume.posted_dt>='".$res_date_search."'";
						}
							
						if(is_array($show_id)){
							$showList = 1;
							$conditions .= " AND (";
							foreach($show_id as $showID){
								if($showList==1){
									$conditions .= "(Registration.show_id=".$showID.")";
								}else{
									$conditions .= " OR (Registration.show_id=".$showID.")";
								}
								$showList++;
							}
							$conditions .= ")";
						}
							
					}
					
					/**** Serch result when Serach TYPE iS Exact Phrase *****/
					if($search_type=='Exact Phrase'){
						$cnt	=	1;
						$match_condition .= "(";
							
						if(strlen($security_clearance_code3)>0){
							$match_condition .= $security_clearance_code3.")";
						}							
						
						if(strlen($words)>0){
							$conditions .= " AND (Resume.resume_content LIKE '%".trim($words)."%')";						
						}
					
						$stlist = 1;
						if(isset($this->params->query['candidate_state'])){
							if($this->params->query['candidate_state'][0]!="ALL"){
								$conditions .= " AND (";
								foreach($this->params->query['candidate_state'] as $states){
									if($stlist==1){
										$conditions .= "((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}else{
										$conditions .= " OR ((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}
									$stlist++;
								}
								$conditions .= ")";
							}
						}
					
						if(($this->params->query['citizen_status_code']!="") || ($this->params->query['citizen_status_code']!='0')){
							$conditions .= " AND ((Candidate.citizen_status_code='".$this->params->query['citizen_status_code']."') OR (Candidate.citizen_status_code is NULL) OR (Candidate.citizen_status_code =3226))";
						}
							
						if(isset($this->params->query['security_clearance_code2'])){
							//pr($this->params->query['security_clearance_code2']);
							$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
							if(($baselist!='38') && (count($this->params->query['security_clearance_code2'])>0)){
								if(in_array("3650", $this->params->query['security_clearance_code2'])===FALSE){
									$conditions .= " AND ((Candidate.security_clearance_code!='3650') AND (Candidate.security_clearance_code not like '%,3650') AND (Candidate.security_clearance_code not like '3650,%') AND (Candidate.security_clearance_code not like '%,3650,%'))";
								}
								if(in_array("3922", $this->params->query['security_clearance_code2'])===FALSE){
									$conditions .= " AND ((Candidate.security_clearance_code!='3922') AND (Candidate.security_clearance_code not like '%,3922') AND (Candidate.security_clearance_code not like '3922,%') AND (Candidate.security_clearance_code not like '%,3922,%'))";
								}
							}elseif($baselist=='38'){
								$conditions .= " AND ((Candidate.security_clearance_code='38') OR (Candidate.security_clearance_code IS NULL) OR (LENGTH(Candidate.security_clearance_code)=0))";
							}
						}
							
						if($this->params->query['experience_code']!=""){
							$conditions .= " AND ((Candidate.experience_code>='".$this->params->query['experience_code']."') OR (Candidate.experience_code is NULL))";
						}
							
						if(strlen($date_search)>0){
							$conditions .= " AND Resume.posted_dt>='".$res_date_search."'";
						}
							
						if(is_array($show_id)){
							$showList = 1;
							$conditions .= " AND (";
							foreach($show_id as $showID){
								if($showList==1){
									$conditions .= "(Registration.show_id=".$showID.")";
								}else{
									$conditions .= " OR (Registration.show_id=".$showID.")";
								}
								$showList++;
							}
							$conditions .= ")";
						}
					
					}
					
					/**** Serch result when Serach TYPE iS Exact Phrase *****/
					if($search_type=='Advanced'){
						$cnt	=	1;
						$match_condition .= "(";
							
						if(strlen($security_clearance_code3)>0){
							$match_condition .= $security_clearance_code3.")";
						}
							
						if(strlen($words)>0 && strlen($security_clearance_code3)>0){
							$match_condition .= ' +(';
						}
							
						if(strlen($words)>0){
							// make string boolean of security clearence
							$pos = stripos(trim($words), " and ");
							//var_dump($pos);die;
							if($pos===false){
								$pos1 = stripos(trim($words), " or ");
								if($pos1===false){
									$pos2 = stripos(trim($words), " not ");
									if($pos2===false){
										$word = trim($words);
									}else{
										if(substr(end(explode(" not ",strtolower(trim($words)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($words)))), 0,1)=='('){
											$word	=	str_ireplace(" not ", " -", trim($words));
										}else{
											$word	=	str_ireplace(" not ", "\" -\"", trim($words));
										}
										//echo $word;die;
									}
								}else{
					
									if(substr(end(explode(" or ",strtolower(trim($words)))), 0,1)=='"' || substr(end(explode(" or ",strtolower(trim($words)))), 0,1)=='('){
										$word	=	str_ireplace(" or ", " ", trim($words));
									}else{
										$word	=	str_ireplace(" or ", "\" \"", trim($words));
									}
										
									if(substr(end(explode(" not ",strtolower(trim($word)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($word)))), 0,1)=='('){
										$word	=	str_ireplace(" not ", " -", trim($word));
									}else{
										$word	=	str_ireplace(" not ", "\" -\"", trim($word));
									}
									//echo $word;die;
								}
							}else{
								$word_pt = explode(" and ",strtolower(trim($words)));
								$cnt = 1;
								$len = count($word_pt);
								$word = "";
								foreach($word_pt as $key => $val){
									if(substr(trim($val), 0,1)!='"' && substr(trim($val), 0,1)!='('){
										$val = '"'.$val;
									}
									if(substr(trim($val), -1)!='"' && substr(trim($val), -1)!=')'){
										$val = $val.'"';
									}
									// add " or ( to starting of a string
									if($cnt==$len){
										if(substr(trim($val), 0,1)=='(' && $key=='0'){
											$val   = str_replace("(", "", trim($val));
											$word .= "(+".$val;
										}elseif(substr(trim($val), 0,1)=='(' && $key!='0'){
											$val   = str_replace("(", "", trim($val));
											$word .= "+(".$val;
										}else{
											$word .= "+".$val;
										}
									}else{
										if(substr(trim($val), 0,1)=='(' && $key=='0'){
											$val   = str_replace("(", "", trim($val));
											$word .= "+(".$val." ";
										}elseif(substr(trim($val), 0,1)=='(' && $key!='0'){
											$val   = str_replace("(", "", trim($val));
											$word .= "+(".$val." ";
										}else{
											$word .= "+".$val." ";
										}
									}
									$cnt++;
								}
									
								if(substr(end(explode(" or ",strtolower(trim($word)))), 0,1)=='"' || substr(end(explode(" or ",strtolower(trim($word)))), 0,1)=='('){
									$word	=	str_ireplace(" or ", " ", trim($word));
								}else{
									$word	=	str_ireplace(" or ", "\" \"", trim($word));
								}
					
								if(substr(end(explode(" not ",strtolower(trim($word)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($word)))), 0,1)=='('){
									$word	=	str_ireplace(" not ", " -", trim($word));
								}else{
									$word	=	str_ireplace(" not ", "\" -\"", trim($word));
								}
									
								//echo $word;die;
							}
					
							if(strlen($word)>0){
								$match_condition .=	$word;
								$match_condition .= ")";
							}
						}
					
						$stlist = 1;
						if(is_array($this->params->query['candidate_state'])){
							if($this->params->query['candidate_state'][0]!="ALL"){
								$conditions .= " AND (";
								foreach($this->params->query['candidate_state'] as $states){
									if($stlist==1){
										$conditions .= "((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}else{
										$conditions .= " OR ((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}
									$stlist++;
								}
								$conditions .= ")";
							}
						}
					
						if(($this->params->query['citizen_status_code']!="") || ($this->params->query['citizen_status_code']!='0')){
							$conditions .= " AND ((Candidate.citizen_status_code='".$this->params->query['citizen_status_code']."') OR (Candidate.citizen_status_code is NULL) OR (Candidate.citizen_status_code =3226))";
						}
							
						if(is_array($this->params->query['security_clearance_code2'])){
							//pr($this->params->query['security_clearance_code2']);
							$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
							if(($baselist!='38') && (count($this->params->query['security_clearance_code2'])>0)){
								if(in_array("3650", $this->params->query['security_clearance_code2'])===FALSE){
									$conditions .= " AND ((Candidate.security_clearance_code!='3650') AND (Candidate.security_clearance_code not like '%,3650') AND (Candidate.security_clearance_code not like '3650,%') AND (Candidate.security_clearance_code not like '%,3650,%'))";
								}
								if(in_array("3922", $this->params->query['security_clearance_code2'])===FALSE){
									$conditions .= " AND ((Candidate.security_clearance_code!='3922') AND (Candidate.security_clearance_code not like '%,3922') AND (Candidate.security_clearance_code not like '3922,%') AND (Candidate.security_clearance_code not like '%,3922,%'))";
								}
							}elseif($baselist=='38'){
								$conditions .= " AND ((Candidate.security_clearance_code='38') OR (Candidate.security_clearance_code IS NULL) OR (LENGTH(Candidate.security_clearance_code)=0))";
							}
						}
							
						if($this->params->query['experience_code']!=""){
							$conditions .= " AND ((Candidate.experience_code>='".$this->params->query['experience_code']."') OR (Candidate.experience_code is NULL))";
						}
							
						if(strlen($date_search)>0){
							$conditions .= " AND Resume.posted_dt>='".$res_date_search."'";
						}
							
						if(is_array($show_id)){
							$showList = 1;
							$conditions .= " AND (";
							foreach($show_id as $showID){
								if($showList==1){
									$conditions .= "(Registration.show_id=".$showID.")";
								}else{
									$conditions .= " OR (Registration.show_id=".$showID.")";
								}
								$showList++;
							}
							$conditions .= ")";
						}
					}
					
					$conditions .= " AND Resume.source_code >= 0";
					
					//echo $match_condition;
					if(strlen($match_condition)>1){
						$conditions = "(MATCH(Resume.resume_content) AGAINST('".$match_condition."' IN BOOLEAN MODE))".$conditions;
					}else{
						$conditions = "(1=1)".$conditions;
					}
					//echo $conditions;die;
					
					
					$this->Resume->unbindModel(array('belongsTo' => array('Candidate')));
					$options['joins'] = array(
							array('table' => 'candidates',
									'alias' => 'Candidate',
									'type' => 'inner',
									'conditions' => array(
											'Candidate.id = Resume.candidate_id'
									)
							),
							array('table' => 'codes',
									'alias' => 'Code',
									'type' => 'inner',
									'conditions' => array(
											'Candidate.experience_code = Code.code_id'
									)
							),
							array('table' => 'codes',
									'alias' => 'Codes',
									'type' => 'inner',
									'conditions' => array(
											'Candidate.citizen_status_code = Codes.code_id'
									)
							),
							array('table' => 'registrations',
									'alias' => 'Registration',
									'type' => 'inner',
									'conditions' => array(
											"Candidate.id = Registration.candidate_id"
									)
							)
					);
					
					$options['conditions'] = array($conditions);
					$options['fields'] = array("distinct(Resume.id)");
					if($max_rows!='All'){
						$options['limit'] = $max_rows;
					}		
					$options['order'] = array("Resume.posted_dt DESC");
					$this->Resume->recursive = -1;
					$resumes = $this->Resume->find('all', $options);
					$resume_result = count($resumes);
					//pr($books);
					
					$reslist="";
					$scrlist="";
					$loopcnt="1";
					
					foreach($resumes as $resume){
						$res	=	$resume['Resume']['id'];
						if($loopcnt!=1){
							$reslist	=	$reslist.",".$res;
						}else{
							$reslist	=	$reslist.$res;
						}
						$loopcnt	=	$loopcnt+1;
					}
					
					$this->Resume->recursive = 1;
					if($resume_result>0){
						$this->paginate = array(
								'fields' => array("distinct(Resume.id),Resume.resume_title,Resume.source_code,Resume.resume_summary,Resume.posted_dt,Resume.resume_content,Candidate.*"),
								'conditions' => array('(Resume.id IN ('.$reslist.'))'),
								'limit' => '10',
								'order' => array(
										'posted_dt' => 'desc'
								)
						);							
						$resumeLists= $this->paginate('Resume');	
					}else{
						$resumeLists = array();
					}
					$this->Session->write('search_reg_event',Set::extract('/Resume/id', $resumeLists));
					$this->set('resumeLists', $resumeLists);
					$this->set('countTotalRecords', $resume_result);
					
					if($resume_result < 1)
					{
						$this->Session->write('popup','Sorry, your search did not return any results.');
						$this->Session->setFlash('Sorry, your search did not return any results.');
						$this->redirect(array('controller'=>'folders','action'=>'searchRegCandidate'));
					}	
				}else{					
					$this->Session->write('popup','Please select at least one event.');
					$this->Session->setFlash('Please select at least one event.'); 
					$this->redirect(array('controller'=>'folders','action'=>'searchRegCandidate'));
				}
			}	
		
		
	}
	
	function resumeSearchResult($action = null)  // search resume result
	{ 
		ini_set("memory_limit","4000M");
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');	
		$this->set('keyword','');
		$this->set('selected','');
        $this->set('meta_title','Employer resume Search');
		$this->Session->write('search_db_url',$_SERVER[ 'REQUEST_URI' ]);
		$this->set('resumeLists',array());
		// Get the list of database which is assign to login employer
		$selected_db = $this->EmployerSet->find('all',array('fields'=>array('DISTINCT ResumeSetRule.set_id,ResumeSetRule.short_desc'),'order'=>'short_desc'));
		$newstates['All']='All Database';
		
		foreach($selected_db as $selected_db) 
		{
			$state = $selected_db['ResumeSetRule'];
			$newstates[$state['set_id']] = $state['short_desc'];
		}
		
		$newstates=array_filter($newstates);
		$this->set('selected_db',$newstates);
		
		
		/** Submit Form **/	
		if($this->request->isGet())
		{
			$stringPostingIds='';
			$conditions='';
			$candidateString='';

			if(count($this->params->query))			// if query string found
			{
				
				/* Initialize form variables if search was just POSTED */
				$search_words 			= trim($this->params->query['words']);
				$search_type  			= $this->params->query['type'];
				$candidate_state		= $this->params->query['candidate_state'];
				$citizen_status_code	= $this->params->query['citizen_status_code'];
				$experience_code		= $this->params->query['experience_code'];				
				$date_search			= $this->params->query['date_search'];
				$time_units				= $this->params->query['time_units'];
				$adv_sec				= 0;
				$max_rows				= $this->params->query['max_rows'];
				
				if(isset($this->params->query['set_id'])){
					$set_id				= $this->params->query['set_id'];
				}
				
				if(isset($this->params->query['words'])){
					$words					=	$search_words;
					$type					=	$search_type;
					$candidate_state		=	$candidate_state;
					$citizen_status_code	=	$citizen_status_code;
					$experience_code		=	$experience_code;
				}
				
				if(isset($this->params->query['date_search'])){
					$date_search	=	$date_search;
					$time_units		=	$time_units;
					$today_date		=	date('Y-m-d');
					if(strlen($date_search)>0){
						$res_date_search	=	strtotime( '-'.$date_search.' '.$time_units.'' , strtotime ($today_date));
						$res_date_search	=	date("Y-m-d 00:00:00",$res_date_search);
					}
				}
				
				/*** Initialize security clearance from text field ****/
				/*** For form submits, clean up ' signs in security clearance text field -> replace with " ***/
				
				if(!empty($this->params->query['security_clearance_code'])){
					$security_clearance_code	=	str_replace("'", "\"", $this->params->query['security_clearance_code']);
				}else{
					$security_clearance_code	=	"";
				}
				
				/*** Initialize security clearance from pull-down ****/
				if(isset($this->params->query['security_clearance_code2'])){
					if(is_array($this->params->query['security_clearance_code2']) && count($this->params->query['security_clearance_code2'])>0){
						$security_clearance_code2	=	implode(",",$this->params->query['security_clearance_code2']);
					}else{
						$security_clearance_code2	=	"";
					}
				}
				
				/*** Clean up keywords search strings  ***/
				if($search_type!="Advanced"){
					$words	=	str_replace(",", " ", $words);
					$words	=	str_replace("'", " ", $words);
					$words	=	str_replace("(", " ", $words);
					$words	=	str_replace(")", " ", $words);
					$words	=	str_replace("\"", " ", $words);
					$words	=	str_replace(" and ", " ", $words);
					$words	=	str_replace(" or ", " ", $words);
					$words	=	str_replace(" not ", " ", $words);
				}
				
				/*** Conditional formatting ***/
				if(isset($this->params->query['security_clearance_code'])){
					$sec_clr_code	=	trim($this->params->query['security_clearance_code']);
					if(strlen($sec_clr_code)>0){
						if($adv_sec=='0'){
							$security_clearance_code	=	'"'.$sec_clr_code.'"';
							$adv_sec = 0;
						}else{
							$adv_sec=='1';
						}
					}
				}
				
				/*** Security Clearance artificial intelligence : for each value in
				 The security clearance pull-down, generate possible string matches ***/
				$security_clearance_code3	=	"";
				if(isset($this->params->query['security_clearance_code2'])){
					if(is_array($this->params->query['security_clearance_code2']) && count($this->params->query['security_clearance_code2'])>0){
						$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
						/*** get all security clearence values ***/
						$all_sec_clr	=	$this->ClearanceKeyword->find('all');
							
						$options_num	=	count($this->params->query['security_clearance_code2']);
						$cnt	=	1;
						$complex_search_string	=	"";
							
						foreach($all_sec_clr as $sec_clrs){
							if(in_array($sec_clrs['ClearanceKeyword']['clearance_code_id'],$this->params->query['security_clearance_code2']) && $baselist!='38'){
								if($sec_clrs['ClearanceKeyword']['clearance_code_id']==38){
									$complex_search_string	=	$complex_search_string.'("%a%"';
								}else{
									$complex_search_string	=	$complex_search_string.'("clearance"';
								}
									
								if($sec_clrs['ClearanceKeyword']['clearance_code_id']!="3922"){
					
									if(strlen($sec_clrs['ClearanceKeyword']['clearance_code_keywords1'])>0){
										$complex_search_string	=	$complex_search_string.' +(';
										$keywords1	=	explode(",",$sec_clrs['ClearanceKeyword']['clearance_code_keywords1']);
										$k1len	=	count($keywords1);
										$k1cnt	=	1;
											
										foreach($keywords1 as $keyword1){
											if($k1cnt==$k1len){
												$complex_search_string	=	$complex_search_string.' "'.$keyword1.'"';
											}else{
												$complex_search_string	=	$complex_search_string.' "'.$keyword1.'" ';
											}
											$k1cnt	=	$k1cnt	+	1;
										}
										$complex_search_string	=	$complex_search_string.')';
									}
					
									if(strlen($sec_clrs['ClearanceKeyword']['clearance_code_keywords2'])>0){
										$complex_search_string	=	$complex_search_string.' +(';
										$keywords2	=	explode(",",$sec_clrs['ClearanceKeyword']['clearance_code_keywords2']);
										$k2len	=	count($keywords2);
										$k2cnt	=	1;
					
										foreach($keywords2 as $keyword2){
											if($k2cnt==$k2len){
												$complex_search_string	=	$complex_search_string.' "'.$keyword2.'"';
											}else{
												$complex_search_string	=	$complex_search_string.' "'.$keyword2.'" ';
											}
											$k2cnt	=	$k2cnt	+	1;
										}
										$complex_search_string	=	$complex_search_string.')';
									}
					
								}else{
									if(strlen($security_clearance_code) > 0){
										if($adv_sec=='0'){
											$security_clearance_code	=	str_replace("\"", "", trim($security_clearance_code));
											//$complex_search_string		=	$complex_search_string." AND MATCH(Resume.resume_content) AGAINST('\"".$security_clearance_code."\"' IN BOOLEAN MODE))";
											$complex_search_string		=	$complex_search_string.' +"'.$security_clearance_code.'")';
										}else{
											// make string boolean of security clearence
											$pos = stripos(trim($security_clearance_code), " and ");
											//var_dump($pos);die;
											if($pos===false){
												$pos1 = stripos(trim($security_clearance_code), " or ");
												if($pos1===false){
													$pos2 = stripos(trim($security_clearance_code), " not ");
													if($pos2===false){
														$con_sec_clr = trim($security_clearance_code);
													}else{
														if(substr(end(explode(" not ",strtolower(trim($security_clearance_code)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($security_clearance_code)))), 0,1)=='('){
															$con_sec_clr	=	str_ireplace(" not ", " -", trim($security_clearance_code));
														}else{
															$con_sec_clr	=	str_ireplace(" not ", "\" -\"", trim($security_clearance_code));
														}
													}
												}else{
					
													if(substr(end(explode(" or ",strtolower(trim($security_clearance_code)))), 0,1)=='"' || substr(end(explode(" or ",strtolower(trim($security_clearance_code)))), 0,1)=='('){
														$con_sec_clr	=	str_ireplace(" or ", " ", trim($security_clearance_code));
													}else{
														$con_sec_clr	=	str_ireplace(" or ", "\" \"", trim($security_clearance_code));
													}
					
													if(substr(end(explode(" not ",strtolower(trim($con_sec_clr)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($con_sec_clr)))), 0,1)=='('){
														$con_sec_clr	=	str_ireplace(" not ", " -", trim($con_sec_clr));
													}else{
														$con_sec_clr	=	str_ireplace(" not ", "\" -\"", trim($con_sec_clr));
													}
												}
											}else{
												$sec_clr_pt = explode(" and ",strtolower(trim($security_clearance_code)));
												$cnt = 1;
												$len = count($sec_clr_pt);
												$con_sec_clr = "";
												foreach($sec_clr_pt as $key => $val){
													if(substr(trim($val), 0,1)!='"' && substr(trim($val), 0,1)!='('){
														$val = '"'.$val;
													}
													if(substr(trim($val), -1)!='"' && substr(trim($val), -1)!=')'){
														$val = $val.'"';
													}
					
													if($cnt==$len){
														//$con_sec_clr .= "+".$val;
														if(substr(trim($val), 0,1)=='(' && $key=='0'){
															$val   = str_replace("(", "", trim($val));
															$con_sec_clr .= "(+".$val;
														}elseif(substr(trim($val), 0,1)=='(' && $key!='0'){
															$val   = str_replace("(", "", trim($val));
															$con_sec_clr .= "+(".$val;
														}else{
															$con_sec_clr .= "+".$val;
														}
													}else{
														//$con_sec_clr .= "+".$val." ";
														if(substr(trim($val), 0,1)=='(' && $key=='0'){
															$val   = str_replace("(", "", trim($val));
															$con_sec_clr .= "+(".$val." ";
														}elseif(substr(trim($val), 0,1)=='(' && $key!='0'){
															$val   = str_replace("(", "", trim($val));
															$con_sec_clr .= "+(".$val." ";
														}else{
															$con_sec_clr .= "+".$val." ";
														}
													}
													$cnt++;
												}
													
												if(substr(end(explode(" or ",strtolower(trim($con_sec_clr)))), 0,1)=='"' || substr(end(explode(" or ",strtolower(trim($con_sec_clr)))), 0,1)=='('){
													$con_sec_clr	=	str_ireplace(" or ", " ", trim($con_sec_clr));
												}else{
													$con_sec_clr	=	str_ireplace(" or ", "\" \"", trim($con_sec_clr));
												}
													
												if(substr(end(explode(" not ",strtolower(trim($con_sec_clr)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($con_sec_clr)))), 0,1)=='('){
													$con_sec_clr	=	str_ireplace(" not ", " -", trim($con_sec_clr));
												}else{
													$con_sec_clr	=	str_ireplace(" not ", "\" -\"", trim($con_sec_clr));
												}
											}
											//echo $con_sec_clr;die;
											//$complex_search_string	=	$complex_search_string." AND MATCH(Resume.resume_content) AGAINST('".$con_sec_clr."' IN BOOLEAN MODE))";
											$complex_search_string	=	$complex_search_string." +(".$con_sec_clr."))";
										}
											
									}
								}
					
								if($cnt==$options_num OR $options_num==1){
									if($sec_clrs['ClearanceKeyword']['clearance_code_id']!="3922"){
										$complex_search_string	=	$complex_search_string.')';
									}
								}else{
									$complex_search_string	=	$complex_search_string.') ';
								}
					
								$cnt	=	$cnt+1;
							}
								
						} /** end of foreach($all_sec_clr as $sec_clrs) loop **/
							
						$security_clearance_code3	=	$complex_search_string;
					}
				}
				
				/**** Build query  -> NOT INDENTED SO SQL CODE IS EXACTLY THE SAME IN RESUME VIEW MODE ****/
				$conditions ="";
				$match_condition = "";
				/**** Serch result when Serach TYPE iS ANY *****/
				if($search_type=='Any'){
					$cnt	=	1;
					$match_condition .= '(';
						
					if(strlen($security_clearance_code3)>0){
						$match_condition .= $security_clearance_code3.")";
					}
						
					if(strlen($words)>0){
						$word_array	=	explode(" ",trim($words));
						$conditions .= " AND (";
						foreach($word_array as $word){
							if((trim($word)!="AND") && (trim($word)!="OR") && (trim($word)!="C")){
								if($cnt==1){
									$conditions .= "(Resume.resume_content like '%".$word."%')";
								}else{
									$conditions .= " OR (Resume.resume_content like '%".$word."%')";
								}
							}
							$cnt=$cnt+1;
						}
						$conditions .= ")";
					}
						
					$stlist = 1;
					if(isset($this->params->query['candidate_state'])){
						if(is_array($this->params->query['candidate_state'])){
							if($this->params->query['candidate_state'][0]!="ALL"){
								$conditions .= " AND (";
								foreach($this->params->query['candidate_state'] as $states){
									if($stlist==1){
										$conditions .= "((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}else{
										$conditions .= " OR ((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
									}
									$stlist++;
								}
								$conditions .= ")";
							}
						}
					}
					
					if(($this->params->query['citizen_status_code']!="") || ($this->params->query['citizen_status_code']!='0')){
						$conditions .= " AND ((Candidate.citizen_status_code='".$this->params->query['citizen_status_code']."') OR (Candidate.citizen_status_code is NULL) OR (Candidate.citizen_status_code =3226))";
					}
						
					if(isset($this->params->query['security_clearance_code2'])){
						if(is_array($this->params->query['security_clearance_code2'])){
							//pr($this->params->query['security_clearance_code2']);
							$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
							if(($baselist!='38') && (count($this->params->query['security_clearance_code2'])>0)){
								if(in_array("3650", $this->params->query['security_clearance_code2'])===FALSE){
									$conditions .= " AND ((Candidate.security_clearance_code!='3650') AND (Candidate.security_clearance_code not like '%,3650') AND (Candidate.security_clearance_code not like '3650,%') AND (Candidate.security_clearance_code not like '%,3650,%'))";
								}
								if(in_array("3922", $this->params->query['security_clearance_code2'])===FALSE){
									$conditions .= " AND ((Candidate.security_clearance_code!='3922') AND (Candidate.security_clearance_code not like '%,3922') AND (Candidate.security_clearance_code not like '3922,%') AND (Candidate.security_clearance_code not like '%,3922,%'))";
								}
							}elseif($baselist=='38'){
								$conditions .= " AND ((Candidate.security_clearance_code='38') OR (Candidate.security_clearance_code IS NULL) OR (LENGTH(Candidate.security_clearance_code)=0))";
							}
						}
					}
						
					if($this->params->query['experience_code']!=""){
						$conditions .= " AND ((Candidate.experience_code>='".$this->params->query['experience_code']."') OR (Candidate.experience_code is NULL))";
					}
						
					if(strlen($date_search)>0){
						$conditions .= " AND Resume.posted_dt>='".$res_date_search."'";
					}

					if(is_array($set_id) && $set_id[0]!='all'){
						$resume_set_ids = implode(",", $set_id);
						$conditions .= " AND ResumeSet.set_id IN (".$resume_set_ids.")";
					}					
				
				}
				
				/**** Serch result when Serach TYPE iS ANY *****/
				if($search_type=='All'){
					$cnt	=	1;
					$match_condition .= '(';
						
					if(strlen($security_clearance_code3)>0){
						$match_condition .= $security_clearance_code3.")";
					}
						
					if(strlen($words)>0){
						$word_array	=	explode(" ",trim($words));
						$conditions .= " AND (";
						foreach($word_array as $word){
							if((trim($word)!="AND") && (trim($word)!="OR") && (trim($word)!="C")){
								if($cnt==1){
									$conditions .= "(Resume.resume_content like '%".$word."%')";
								}else{
									$conditions .= " AND (Resume.resume_content like '%".$word."%')";
								}
							}
							$cnt=$cnt+1;
						}
						$conditions .= ")";
					}
						
					$stlist = 1;
					if(is_array($this->params->query['candidate_state'])){
						if($this->params->query['candidate_state'][0]!="ALL"){
							$conditions .= " AND (";
							foreach($this->params->query['candidate_state'] as $states){
								if($stlist==1){
									$conditions .= "((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
								}else{
									$conditions .= " OR ((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
								}
								$stlist++;
							}
							$conditions .= ")";
						}
					}
				
					if(($this->params->query['citizen_status_code']!="") || ($this->params->query['citizen_status_code']!='0')){
						$conditions .= " AND ((Candidate.citizen_status_code='".$this->params->query['citizen_status_code']."') OR (Candidate.citizen_status_code is NULL) OR (Candidate.citizen_status_code =3226))";
					}
						
					if(isset($this->params->query['security_clearance_code2'])){
						//pr($this->params->query['security_clearance_code2']);
						$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
						if(($baselist!='38') && (count($this->params->query['security_clearance_code2'])>0)){
							if(in_array("3650", $this->params->query['security_clearance_code2'])===FALSE){
								$conditions .= " AND ((Candidate.security_clearance_code!='3650') AND (Candidate.security_clearance_code not like '%,3650') AND (Candidate.security_clearance_code not like '3650,%') AND (Candidate.security_clearance_code not like '%,3650,%'))";
							}
							if(in_array("3922", $this->params->query['security_clearance_code2'])===FALSE){
								$conditions .= " AND ((Candidate.security_clearance_code!='3922') AND (Candidate.security_clearance_code not like '%,3922') AND (Candidate.security_clearance_code not like '3922,%') AND (Candidate.security_clearance_code not like '%,3922,%'))";
							}
						}elseif($baselist=='38'){
							$conditions .= " AND ((Candidate.security_clearance_code='38') OR (Candidate.security_clearance_code IS NULL) OR (LENGTH(Candidate.security_clearance_code)=0))";
						}
					}
						
					if($this->params->query['experience_code']!=""){
						$conditions .= " AND ((Candidate.experience_code>='".$this->params->query['experience_code']."') OR (Candidate.experience_code is NULL))";
					}
						
					if(strlen($date_search)>0){
						$conditions .= " AND Resume.posted_dt>='".$res_date_search."'";
					}
						
					if(is_array($set_id) && $set_id[0]!='all'){
						$resume_set_ids = implode(",", $set_id);
						$conditions .= " AND ResumeSet.set_id IN (".$resume_set_ids.")";
					}
						
				}
				
				/**** Serch result when Serach TYPE iS Exact Phrase *****/
				if($search_type=='Exact Phrase'){
					$cnt	=	1;
					$match_condition .= "(";
						
					if(strlen($security_clearance_code3)>0){
						$match_condition .= $security_clearance_code3.")";
					}
						
					if(strlen($words)>0){
						$conditions .= " AND (Resume.resume_content LIKE '%".trim($words)."%')";						
					}
				
					$stlist = 1;
					if(is_array($this->params->query['candidate_state'])){
						if($this->params->query['candidate_state'][0]!="ALL"){
							$conditions .= " AND (";
							foreach($this->params->query['candidate_state'] as $states){
								if($stlist==1){
									$conditions .= "((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
								}else{
									$conditions .= " OR ((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
								}
								$stlist++;
							}
							$conditions .= ")";
						}
					}
				
					if(($this->params->query['citizen_status_code']!="") || ($this->params->query['citizen_status_code']!='0')){
						$conditions .= " AND ((Candidate.citizen_status_code='".$this->params->query['citizen_status_code']."') OR (Candidate.citizen_status_code is NULL) OR (Candidate.citizen_status_code =3226))";
					}
						
					if(isset($this->params->query['security_clearance_code2'])){
						//pr($this->params->query['security_clearance_code2']);
						$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
						if(($baselist!='38') && (count($this->params->query['security_clearance_code2'])>0)){
							if(in_array("3650", $this->params->query['security_clearance_code2'])===FALSE){
								$conditions .= " AND ((Candidate.security_clearance_code!='3650') AND (Candidate.security_clearance_code not like '%,3650') AND (Candidate.security_clearance_code not like '3650,%') AND (Candidate.security_clearance_code not like '%,3650,%'))";
							}
							if(in_array("3922", $this->params->query['security_clearance_code2'])===FALSE){
								$conditions .= " AND ((Candidate.security_clearance_code!='3922') AND (Candidate.security_clearance_code not like '%,3922') AND (Candidate.security_clearance_code not like '3922,%') AND (Candidate.security_clearance_code not like '%,3922,%'))";
							}
						}elseif($baselist=='38'){
							$conditions .= " AND ((Candidate.security_clearance_code='38') OR (Candidate.security_clearance_code IS NULL) OR (LENGTH(Candidate.security_clearance_code)=0))";
						}
					}
						
					if($this->params->query['experience_code']!=""){
						$conditions .= " AND ((Candidate.experience_code>='".$this->params->query['experience_code']."') OR (Candidate.experience_code is NULL))";
					}
						
					if(strlen($date_search)>0){
						$conditions .= " AND Resume.posted_dt>='".$res_date_search."'";
					}
						
					if(is_array($set_id) && $set_id[0]!='all'){
						$resume_set_ids = implode(",", $set_id);
						$conditions .= " AND ResumeSet.set_id IN (".$resume_set_ids.")";
					}
				
				}
				
				/**** Serch result when Serach TYPE iS Exact Phrase *****/
				if($search_type=='Advanced'){
					$cnt	=	1;
					$match_condition .= "(";
						
					if(strlen($security_clearance_code3)>0){
						$match_condition .= $security_clearance_code3.")";
					}
						
					if(strlen($words)>0 && strlen($security_clearance_code3)>0){
						$match_condition .= ' +(';
					}
						
					if(strlen($words)>0){
						// make string boolean of security clearence
						$pos = stripos(trim($words), " and ");
						//var_dump($pos);die;
						if($pos===false){
							$pos1 = stripos(trim($words), " or ");
							if($pos1===false){
								$pos2 = stripos(trim($words), " not ");
								if($pos2===false){
									$word = trim($words);
								}else{
									if(substr(end(explode(" not ",strtolower(trim($words)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($words)))), 0,1)=='('){
										$word	=	str_ireplace(" not ", " -", trim($words));
									}else{
										$word	=	str_ireplace(" not ", "\" -\"", trim($words));
									}
									//echo $word;die;
								}
							}else{
				
								if(substr(end(explode(" or ",strtolower(trim($words)))), 0,1)=='"' || substr(end(explode(" or ",strtolower(trim($words)))), 0,1)=='('){
									$word	=	str_ireplace(" or ", " ", trim($words));
								}else{
									$word	=	str_ireplace(" or ", "\" \"", trim($words));
								}
									
								if(substr(end(explode(" not ",strtolower(trim($word)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($word)))), 0,1)=='('){
									$word	=	str_ireplace(" not ", " -", trim($word));
								}else{
									$word	=	str_ireplace(" not ", "\" -\"", trim($word));
								}
								//echo $word;die;
							}
						}else{
							$word_pt = explode(" and ",strtolower(trim($words)));
							$cnt = 1;
							$len = count($word_pt);
							$word = "";
							foreach($word_pt as $key => $val){
								if(substr(trim($val), 0,1)!='"' && substr(trim($val), 0,1)!='('){
									$val = '"'.$val;
								}
								if(substr(trim($val), -1)!='"' && substr(trim($val), -1)!=')'){
									$val = $val.'"';
								}
								// add " or ( to starting of a string
								if($cnt==$len){
									if(substr(trim($val), 0,1)=='(' && $key=='0'){
										$val   = str_replace("(", "", trim($val));
										$word .= "(+".$val;
									}elseif(substr(trim($val), 0,1)=='(' && $key!='0'){
										$val   = str_replace("(", "", trim($val));
										$word .= "+(".$val;
									}else{
										$word .= "+".$val;
									}
								}else{
									if(substr(trim($val), 0,1)=='(' && $key=='0'){
										$val   = str_replace("(", "", trim($val));
										$word .= "+(".$val." ";
									}elseif(substr(trim($val), 0,1)=='(' && $key!='0'){
										$val   = str_replace("(", "", trim($val));
										$word .= "+(".$val." ";
									}else{
										$word .= "+".$val." ";
									}
								}
								$cnt++;
							}
								
							if(substr(end(explode(" or ",strtolower(trim($word)))), 0,1)=='"' || substr(end(explode(" or ",strtolower(trim($word)))), 0,1)=='('){
								$word	=	str_ireplace(" or ", " ", trim($word));
							}else{
								$word	=	str_ireplace(" or ", "\" \"", trim($word));
							}
				
							if(substr(end(explode(" not ",strtolower(trim($word)))), 0,1)=='"' || substr(end(explode(" not ",strtolower(trim($word)))), 0,1)=='('){
								$word	=	str_ireplace(" not ", " -", trim($word));
							}else{
								$word	=	str_ireplace(" not ", "\" -\"", trim($word));
							}
								
							//echo $word;die;
						}
				
						if(strlen($word)>0){
							$match_condition .=	$word;
							$match_condition .= ")";
						}
					}
				
					$stlist = 1;
					if(is_array($this->params->query['candidate_state'])){
						if($this->params->query['candidate_state'][0]!="ALL"){
							$conditions .= " AND (";
							foreach($this->params->query['candidate_state'] as $states){
								if($stlist==1){
									$conditions .= "((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
								}else{
									$conditions .= " OR ((Candidate.candidate_state like '".$states."') OR (Candidate.pref_locations like '".$states."'))";
								}
								$stlist++;
							}
							$conditions .= ")";
						}
					}
				
					if(($this->params->query['citizen_status_code']!="") || ($this->params->query['citizen_status_code']!='0')){
						$conditions .= " AND ((Candidate.citizen_status_code='".$this->params->query['citizen_status_code']."') OR (Candidate.citizen_status_code is NULL) OR (Candidate.citizen_status_code =3226))";
					}
						
					if(isset($this->params->query['security_clearance_code2'])){
						//pr($this->params->query['security_clearance_code2']);
						$baselist	=	implode(",",$this->params->query['security_clearance_code2']);
						if(($baselist!='38') && (count($this->params->query['security_clearance_code2'])>0)){
							if(in_array("3650", $this->params->query['security_clearance_code2'])===FALSE){
								$conditions .= " AND ((Candidate.security_clearance_code!='3650') AND (Candidate.security_clearance_code not like '%,3650') AND (Candidate.security_clearance_code not like '3650,%') AND (Candidate.security_clearance_code not like '%,3650,%'))";
							}
							if(in_array("3922", $this->params->query['security_clearance_code2'])===FALSE){
								$conditions .= " AND ((Candidate.security_clearance_code!='3922') AND (Candidate.security_clearance_code not like '%,3922') AND (Candidate.security_clearance_code not like '3922,%') AND (Candidate.security_clearance_code not like '%,3922,%'))";
							}
						}elseif($baselist=='38'){
							$conditions .= " AND ((Candidate.security_clearance_code='38') OR (Candidate.security_clearance_code IS NULL) OR (LENGTH(Candidate.security_clearance_code)=0))";
						}
					}
						
					if($this->params->query['experience_code']!=""){
						$conditions .= " AND ((Candidate.experience_code>='".$this->params->query['experience_code']."') OR (Candidate.experience_code is NULL))";
					}
						
					if(strlen($date_search)>0){
						$conditions .= " AND Resume.posted_dt>='".$res_date_search."'";
					}
						
					if(is_array($set_id) && $set_id[0]!='all'){
						$resume_set_ids = implode(",", $set_id);
						$conditions .= " AND ResumeSet.set_id IN (".$resume_set_ids.")";
					}
					
				}
				
				$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
				//$conditions .= " AND ResumeJoin.employer_id = ".$employerID." AND Resume.source_code >= 0";
				
				//echo $match_condition;
				if(strlen($match_condition)>1){
					$conditions = "(MATCH(Resume.resume_content) AGAINST('".$match_condition."' IN BOOLEAN MODE))".$conditions;
				}else{
					$conditions = "(1=1)".$conditions;
				}
				//echo $conditions;die;				
				
				$this->Resume->unbindModel(array('belongsTo' => array('Candidate')));
				$options['joins'] = array(
						array('table' => 'candidates',
								'alias' => 'Candidate',
								'type' => 'inner',
								'conditions' => array(
										'Candidate.id = Resume.candidate_id'
								)
						),
						array('table' => 'codes',
								'alias' => 'Code',
								'type' => 'inner',
								'conditions' => array(
										'Candidate.experience_code = Code.code_id'
								)
						),
						array('table' => 'codes',
								'alias' => 'Codes',
								'type' => 'inner',
								'conditions' => array(
										'Candidate.citizen_status_code = Codes.code_id'
								)
						),
						array('table' => 'resume_sets',
								'alias' => 'ResumeSet',
								'type' => 'inner',
								'conditions' => array(
										"Resume.id = ResumeSet.resume_id"
								)
						)
				);
				
				$options['conditions'] = array($conditions);
				$options['fields'] = array("distinct(Resume.id)");
				if($max_rows!='All'){
					$options['limit'] = $max_rows;
				}		
				$options['order'] = array("Resume.posted_dt DESC");
				$this->Resume->recursive = -1;
				$resumes = $this->Resume->find('all', $options);
				$resume_result = count($resumes);
				//pr($books);
				
				$reslist="";
				$scrlist="";
				$loopcnt="1";
				
				foreach($resumes as $resume){
					$res	=	$resume['Resume']['id'];
					if($loopcnt!=1){
						$reslist	=	$reslist.",".$res;
					}else{
						$reslist	=	$reslist.$res;
					}
					$loopcnt	=	$loopcnt+1;
				}
				
				$this->Resume->recursive = 1;
				if($resume_result>0){
					$this->paginate = array(
							'fields' => array("distinct(Resume.id),Resume.resume_title,Resume.source_code,Resume.resume_summary,Resume.posted_dt,Resume.resume_content,Candidate.*"),
							'conditions' => array('(Resume.id IN ('.$reslist.'))'),
							'limit' => '10',
							'order' => array(
									'posted_dt' => 'desc'
							)
					);						
					$resumeLists= $this->paginate('Resume');				
						
				}else{
					$resumeLists = array();
				}
				$this->Session->write('search_db_event',Set::extract('/Resume/id', $resumeLists));
				
				
				$this->set('resumeLists', $resumeLists);
				$this->set('countTotalRecords', $resume_result);
				
				if($resume_result < 1)
				{
					$this->Session->write('popup','Sorry, your search did not return any results.');
					$this->Session->setFlash('Sorry, your search did not return any results.');
					$this->redirect(array('controller'=>'employers','action'=>''));
				}	
			}else{					
				$this->Session->write('popup','Please select at least one database set.');
				$this->Session->setFlash('Please select at least one database set.'); 
				$this->redirect(array('controller'=>'employers','action'=>''));
			}
		}
	
			
	}
	
	function massEmail($folder_id = null)
	{
		$this->set('folder_id', $folder_id);
		
	}
	
	
	function sendEmailToCandidate($id = null)
	{
		$this->Candidate->id = $id;
		$candidate_email = $this->Candidate->field('candidate_email');
		$this->set('candidate_email',$candidate_email);
		
		//pr($this->request->data);die;
		if($this->request->data)
		{
			if($this->request->data['Resume']['SUBMIT']=='SUBMIT')
			{
				
				$this->set('candidateEmail',$this->request->data['folders']['candidate_email']);
			
				$errorsArr='';
					if(!$this->Folder->sendEmailToCandidate()):
					
						$errorsArr = $this->Folder->validationErrors;	
					else:
					
					endif;
				/*
				if(!$errorsArr){
					
						// Email configuration
						$sendto = $this->request->data['folders']['candidate_email'];
						$sendfrom = '';
						$emailMessage = $this->request->data['Candidate']['message'];
						
						$subject = "An employer mail to you";
						$bodyText = $emailMessage;
						
						//echo $bodyText;die;
						
						$email = new CakeEmail();
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
						
						if($ok){
							$this->Session->write('popup','Email has been sent successfully.');
							$this->redirect(array('controller'=>'folders','action' => "sendEmailToCandidate/".$id));
						}
				
				}
				*/
			}
		}else
		{
			$this->set('candidateEmail',$this->Session->read('Auth.Client.Candidate.candidate_email'));
			
		}
		
		
		
	}

	function createxhibitorprofile($showID=null,$employerID=null){
		$this->loadModel('ShowCompanyProfile');
		
		if($this->request->is('get')){
			$this->request->data = $this->ShowCompanyProfile->find("first",array('conditions'=>array('show_id'=>$showID,'employer_id'=>$employerID)));
		}else{
			if($this->request->data['ShowCompanyProfile']['num_lunch_tickets']>5){
				$this->request->data['ShowCompanyProfile']['num_lunch_tickets'] = 5;
			}
			if($this->request->data['ShowCompanyProfile']['booth']=='0'){
				$this->request->data['ShowCompanyProfile']['booth'] = 'n';
			}
			$this->request->data['ShowCompanyProfile']['show_id'] = $showID;
			$this->request->data['ShowCompanyProfile']['employer_id'] = $employerID;
			
			//pr($this->request->data);die;
			$this->ShowCompanyProfile->save($this->request->data);
			$this->Session->write('popup','Your exhibitor company profile has been saved successfully.');
			$this->redirect(array('controller'=>'employers','action' => "empeventprep"));
			
		}
	
	}
 
	function beforeFilter() 
	{ 
		parent::beforeFilter();
		
		if($this->Session->check('Auth.Client.User.id'))
		{
			$this->Auth->allow('*');
		}else
		{
			$this->Auth->allow('profile');
		}
   	}
	
	
	
}//end class
?>