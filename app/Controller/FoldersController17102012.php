<?php 
/******************************************************************************************
 Coder  : Apurav Gaur
 Object : Controller to handle Folder operations - view , add, edit and delete
******************************************************************************************/ 
class FoldersController extends AppController {
	var $name = 'Folders'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler','Captcha','Email');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'front'; //this is the layout for admin panel 
	var $uses = array('Candidate','User','Code','Resume','ResumeSkill','ApplyHistory','JobPosting','ShowCompanyProfile','Employer','TrainingSchool','JobPostingSkill','Code','FolderContent','Registration','Folder','ShowInterview','ResumeSet');
	//public $displayField = 'employer_name';
	

	
	/* function for create resume folder for employer  */
	function resumefolder($action = null )
	{	
		$this->set('meta_title','Employer Resume Folder');
		$empContactID = $this->Session->read('Auth.Client.employerContact.id');
		
		$errorsArr = "";
		// Folder Icon List   
		$this->loadModel('FolderIcon');
		$icon_list = $this->FolderIcon->find('list',array('fields'=>array("icon_id", 'icon_color_descr')));
		$this->set('icon_list',$icon_list);
		
		// Folder data   
		$this->loadModel('Folder');
		$folder_data = $this->Folder->find('all',array('conditions'=>array('employer_contact_id'=>$empContactID)));
		$this->set('folder_data',$folder_data);
		
		
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
	function scheduleInteview($candidate_id = null)
	{
		$candidate_dt = $this->Candidate->find('first',array('conditions'=>array('Candidate.id'=>$candidate_id)));
		$this->set('candidate_dt',$candidate_dt);
		
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		$candidate_event = $this->ShowInterview->find('first',array('conditions'=>array('ShowInterview.candidate_id'=>$candidate_id,'ShowInterview.employer_id'=>$employerID)));
		$this->set('candidate_event',$candidate_event);
		
		
						/*$sendto = $this->request->data['Folder']['email'];
						$sendfrom = $employerEmail;
						$emailMessage = $this->request->data['Folder']['mailnotes'];
						
						$subject = "Resume forwarded,oasted on  techexpoUSA.com";
						$bodyText = "This Resume was forwarded to you by someone you know. It was posted on TechExpoUSA.com, the career center of choice for all technology professionals. To view the details of this Resume, go to<br/>techexpoUSA.com<br/><br/>*************************************************************************************<br/>".$emailMessage."<br/><br/> Thank You <br> Tech Expo Team ";
						
						//echo $bodyText;die;
						
						$this->Email->filePaths  = array('/candidateDocument/resumeSend/');
				        $this->Email->attachments =array('resume_'.$resume_detail['Resume']['id']);
						
						$email = new CakeEmail();
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						
						$ok = $email->send($bodyText);
						
						if($ok){
							$this->Session->write('popup','Resume forwarded successfully.');
							$this->redirect(array('controller'=>'folders','action' => "mailResume/".$resume_id));
						}*/
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
	 	$FolderRec2 = $this->Candidate->find('first',array('conditions'=>array('Candidate.id'=>$dt['Resume']['candidate_id']),'fields'=>array('Candidate.candidate_name')));
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
						
						$subject = "Resume forwarded,oasted on  techexpoUSA.com";
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
	}
	
	function showRegisterResume($resume_id = null)
	{ 
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
	}
	// create rtf resume file and download
	function exportResume($id = null ) {
		$this->autoRender = false;
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
						
						$subject = "Resume forwarded,Posted on  techexpoUSA.com";
						$bodyText = "This Resume was forwarded to you by someone you know. It was posted on TechExpoUSA.com, the career center of choice for all technology professionals. To view the details of this Resume, go to<br/>techexpoUSA.com<br/><br/>*************************************************************************************<br/>".$emailMessage."<br/><br/> Thank You <br> Tech Expo Team ";
						
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
		
			// get only one month old events
			$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m")-1 , date("d"), date("Y")));
			$condition  = "ShowEmployer.employer_id = ".$employerID." AND ShowEmployer.payment_status = 'y' AND Show.show_dt > ".$targetdate." ";	
			$this->paginate = array('limit' =>20,'order' => array('show_id DESC'));
			$regEvents = $this->paginate('ShowEmployer', $condition);

			$this->set('regEvents',$regEvents);
			
			$events = $this->ShowEmployer->find('all',array('conditions'=>$condition,'fields' => array('Show.show_name','Show.show_dt','Show.id')));
			$event_list = Set::combine($events, '{n}.Show.id', array('{0} {1}', '{n}.Show.show_name', '{n}.Show.show_dt'));
			$this->set('event_list',$event_list);
			
			
			//pr($this->params->query);die;
				
		
	}
	
	function searchRegResult($action = null)
	{ 
			$stringPostingIds='';
			$conditions='';
			
		
			//pr($this->params->query['event_list']);die;
			if(count($this->params->query['event_list']) > 0 && !empty($this->params->query['event_list']))			{	
			
			// entry compulsory for employer and condidate in event table
			if($action == 'dashboardsearch')
			{
				//$candidateLists = $this->Registration->find('all',array('conditions'=>' Registration.show_id in (\''.$eventListing.'\') ','fields'=>array('candidate_id')));
			}
			else if(!empty($this->params->query['event_list'])) {
					$eventListing = implode(',',$this->params->query['event_list']);
					$eventListing = str_replace(',','\',\'',$eventListing);
					$candidateLists = $this->Registration->find('all',array('conditions'=>' Registration.show_id in (\''.$eventListing.'\') ','fields'=>array('candidate_id')));
					$candidateString ='';
								
					 $i=1;
					if(count($candidateLists) > 1){
					foreach ($candidateLists as $candidateList)
					{
						if($i < count($candidateLists))
						$candidateString.= '\''.$candidateList['Registration']['candidate_id'].'\',';
						else 
						$candidateString.= '\''.$candidateList['Registration']['candidate_id'].'\'';
						
						$i++;
					}
					}
					
			}
			
			// end condition
			if(isset($this->params->query['keyword_matching'])){
			$matchingType=$this->params->query['keyword_matching'];
			
			switch($matchingType)
			{
				case 'Any':
						if(!empty($this->params->query['keyword']))
							{	
							
							$keyword=str_replace(',',' ',trim($this->params->query['keyword']));
							$keyword=str_replace('(',' ',$keyword);
							$keyword=str_replace(' and ',' ',$keyword);
							$keyword=str_replace(' or ',' ',$keyword);
							$keyword=str_replace(' not ','',$keyword);
							$keyword=str_replace("'",' ',$keyword);
							$keyword=str_replace(")",' ',$keyword);
							$arrayKeyword=explode(' ',$keyword);
							
							foreach($arrayKeyword as $key19 =>$value19)
							{	
								if($value19)
								{
								$keyword=$this->params->query['keyword'];
								$codeIds=$this->Code->find('all',array('fields'=>array('code_id'),'order'=>array('code_id'),'conditions'=>array('code_name'=>'Skills','visible'=>'Y','code_descr like "%'.$value19.'%"'),'order'=>array("sort_order ASC")));
								
								
								$totalSkills=count($codeIds);
								$stringSkills='';
								$i=1;
								foreach($codeIds as $key=>$value)
								{
									$stringSkills.=$value['Code']['code_id'];
									
									if($i!=$totalSkills)
									{
										$stringSkills.=',';
									}
									$i=$i+1;
								}
								
								
								
								if($stringSkills)
								{
									$postingIds=$this->ResumeSkill->find('all',array('fields'=>'id','conditions'=>'ResumeSkill.skill_id in ('.$stringSkills.')'));
									$totalPostingIds=count($postingIds);
									$stringPostingIds='';
									$j=1;
									
								
									foreach($postingIds as $key=>$value)
									{
										$stringPostingIds.=$value['ResumeSkill']['id'];
										
										if($j!=$totalPostingIds)
										{
											$stringPostingIds.=',';
										}
										$j=$j+1;
									}
							
									
									/*if($stringPostingIds)
									{
										if(!empty($conditions))
										{
										$conditions.=' or ';
										}
										$conditions.=' ResumeSkill.id in ('.$stringPostingIds.') ';
									}*/
							 	}	
								
								
								if(!empty($conditions))
								{
									$conditions.=' or ';
								}
								$conditions.= 'Resume.resume_content like "%'.$value19.'%" ';
								}
							}
							
								
								$this->request->data['Candidates']['keyword']=$this->params->query['keyword'];
							
							}
						break;
						
				case 'All':
						if(!empty($this->params->query['keyword']))
							{		
							$keyword=str_replace(',',' ',trim($this->params->query['keyword']));
							$keyword=str_replace('(',' ',$keyword);
							$keyword=str_replace(' and ',' ',$keyword);
							$keyword=str_replace(' or ',' ',$keyword);
							$keyword=str_replace(' not ','',$keyword);
							$keyword=str_replace("'",' ',$keyword);
							$keyword=str_replace(")",' ',$keyword);
							
							$arrayKeyword=explode(' ',$keyword);
							
							foreach($arrayKeyword as $Key12 =>$value12)
							{
								if($value12)
								{
								//echo $value12;
							$codeIds=$this->Code->find('all',array('fields'=>array('code_id'),'order'=>array('code_id'),'conditions'=>array('code_name'=>'Skills','visible'=>'Y','code_descr like "%'.$value12.'%"'),'order'=>array("sort_order ASC")));
							
								$totalSkills=count($codeIds);
								$stringSkills='';
								$i=1;
								foreach($codeIds as $key=>$value)
								{
									$stringSkills.=$value['Code']['code_id'];
									
									if($i!=$totalSkills)
									{
										$stringSkills.=',';
									}
									$i=$i+1;
								}
								
								if($stringSkills)
								{
									$postingIds=$this->ResumeSkill->find('all',array('fields'=>'id','conditions'=>'ResumeSkill.skill_id in ('.$stringSkills.')'));
									$totalPostingIds=count($postingIds);
									$stringPostingIds='';
									$j=1;
									
								
									foreach($postingIds as $key=>$value)
									{
										$stringPostingIds.=$value['ResumeSkill']['id'];
										
										if($j!=$totalPostingIds)
										{
											$stringPostingIds.=',';
										}
										$j=$j+1;
									}
							
									
							 	}	
								}
								
								if(!empty($conditions))
								{
									$conditions.=' and ';
								}
								
								$conditions.= 'Resume.resume_content like "%'.$value12.'%" ';
								
							}
						
					
							
								
								$this->request->data['Candidates']['keyword']=$this->params->query['keyword'];
							}
						break;
				
				case 'Exact':
							if(!empty($this->params->query['keyword']))
							{ 		
								
							$keyword=$this->params->query['keyword'];
								$codeIds=$this->Code->find('all',array('fields'=>array('code_id'),'order'=>array('code_id'),'conditions'=>array('code_name'=>'Skills','visible'=>'Y','code_descr like "%'.$keyword.'%"'),'order'=>array("sort_order ASC")));
								$totalSkills=count($codeIds);
								$stringSkills='';
								$i=1;
								foreach($codeIds as $key=>$value)
								{
									$stringSkills.=$value['Code']['code_id'];
									
									if($i!=$totalSkills)
									{
										$stringSkills.=',';
									}
									$i=$i+1;
								}
								
								if($stringSkills)
								{
									$postingIds=$this->ResumeSkill->find('all',array('fields'=>'id','conditions'=>'ResumeSkill.skill_id in ('.$stringSkills.')'));
									$totalPostingIds=count($postingIds);
									$stringPostingIds='';
									$j=1;
									
								
									foreach($postingIds as $key=>$value)
									{
										$stringPostingIds.=$value['ResumeSkill']['id'];
										
										if($j!=$totalPostingIds)
										{
											$stringPostingIds.=',';
										}
										$j=$j+1;
									}
							
								
									
									/*if($stringPostingIds)
									{
										$conditions.=' ResumeSkill.id in ('.$stringPostingIds.') ';
									}*/
							 }
							 	
							
								if(!empty($conditions))
								{
									$conditions.=' and ';
								}
								
								
									
								
								$conditions.= 'Resume.resume_content like "%'.$this->params->query['keyword'].'%" '; 
								$this->request->data['Candidates']['keyword']=$this->params->query['keyword'];
							}
							
						break;
						
				case 'default':
						break;
			}
			
			
			}
	
				
				// check state list for resume
				
				if(!empty($this->params->query['state_list']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								$stringStateIds = implode(',',$this->params->query['state_list']);
							    $stringStateIds = str_replace(',','\',\'',$stringStateIds);
								$conditions.=' Candidate.candidate_state in (\''.$stringStateIds.'\') ';
							}
							 
	
							
				if(!empty($this->params->query['relocate']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								$conditions.='Candidate.relocate="'.$this->params->query['relocate'].'"';
							
							}
				
							
							
				if(!empty($this->params->query['citizen_status_code']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								$conditions.='Candidate.citizen_status_code="'.$this->params->query['citizen_status_code'].'"';
							
							}
						
					
			if(!empty($this->params->query['cleareance_list']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								
								$securityClearances=$this->params->query['cleareance_list'];
								count($securityClearances);
							//	echo explode(',',$this->params->query['security_clearance_code']);die;
								
								$totalSecurityClearance=count($securityClearances);
								$stringSecurityClearance='';
								$i=1;
								foreach($securityClearances as $key7=>$value7)
								{
									
									
									$conditions.= 'FIND_IN_SET("'.$value7.'",Candidate.security_clearance_code)';
									
									if($i!=$totalSecurityClearance)
									{
										$conditions.=" or ";
									}
									$i=$i+1;
								}
								 
								  $conditions;
						
							}
									
					if(!empty($this->params->query['experience_code']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
								}
								$conditions.='Candidate.experience_code="'.$this->params->query['experience_code'].'" ';
					}
						
					if(!empty($this->params->query['advance']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
								}
								$conditions.='Resume.resume_summary LIKE "%'.$this->params->query['advanceSearch'].'%" ';
					}
						
					if(!empty($this->params->query['resumelast_matching']) && !empty($this->params->query['resumelast']))
					{ 
								$date_set =$this->params->query['resumelast_matching'];
								if(!empty($conditions))
								{
									$conditions.=' and ';
								}
								
								switch($date_set)
								{ 
									case 'days':
									$last_dt = '-'.$this->params->query['resumelast'].' day';
									$last_dt2 =  date( "Y-m-d 00:00:00", strtotime($last_dt, mktime()));
									$conditions.='Resume.posted_dt >"'.$last_dt2.'"';
									break;
									
									case 'weeks':
									$last_dt = '-'.$this->params->query['resumelast'].' week';
									$last_dt2 =  date( "Y-m-d 00:00:00", strtotime($last_dt, mktime()));
									$conditions.='Resume.posted_dt >"'.$last_dt2.'"';
									break;
									
									case 'months':
									$last_dt = '-'.$this->params->query['resumelast'].' month';
									$last_dt2 =  date( "Y-m-d 00:00:00", strtotime($last_dt, mktime()));
									$conditions.='Resume.posted_dt >"'.$last_dt2.'"';
									break;
									
									case 'years':
									$last_dt = '-'.$this->params->query['resumelast'].' year';
									$last_dt2 =  date( "Y-m-d 00:00:00", strtotime($last_dt, mktime()));
									$conditions.='Resume.posted_dt >"'.$last_dt2.'"';
									break;
								}
								
					}
						
					
				
		//	pr($this->params->query);
		//	echo $conditions;die;
				if(!empty($conditions))
								{
									$conditions.=' and ';
								}		
				$conditions.=' Candidate.id in ('.$candidateString.') ';
			
				 $this->paginate = array(
					//'limit' => $this->params->query['max_rows'],
					'limit' => 3,
					'conditions'=>$conditions,
					'paramType' => 'querystring',
					'maxLimit' =>'100'
				);
				$resumeLists= $this->paginate('Resume');
			
				
				$this->set('resumeLists', $resumeLists);
				}else
				{ 
					$this->set('resumeList',array());
					$this->Session->write('popup','Please select at least one event.');
					$this->redirect(array('controller'=>'folders','action'=>'searchRegCandidate'));	
				}
				//pr($this->JobPosting->find('all',array('conditions'=>'JobPosting.security_clearance_code="3919"  and Employer.employer_name like "%Innovance%"')));die;
		
	}
	
	function resumeSearchResult($action = null)
	{ 
			$stringPostingIds='';
			$conditions='';
			$candidateString ='';
		
			if(count($this->params->query['selected_db']))			{	
			
			// entry compulsory for employer and condidate in event table
			if(!empty($this->params->query['selected_db'])) {
					$resumeLists = $this->ResumeSet->find('all',array('conditions'=>'ResumeSet.set_id = '.$this->params->query['selected_db'],'fields'=>array('resume_id','Resume.candidate_id')));
					
					if(empty($resumeLists))
					{
					$this->Session->write('popup','Please search again, no resume on this database.');
					$this->redirect(array('controller'=>'employers','action' => ""));
					}
					
					 $i=1;
					if(count($resumeLists) > 1){
					foreach ($resumeLists as $resumeList)
					{
						if($i < count($resumeLists))
						$candidateString.= '\''.$resumeList['Resume']['candidate_id'].'\',';
						else 
						$candidateString.= '\''.$resumeList['Resume']['candidate_id'].'\'';
						
						$i++;
					}
					}
			}else{
				
				$this->Session->write('popup','Please Select database for search.');
				$this->redirect(array('controller'=>'employers','action' => ""));
				
				}
			// end condition
			
			
				
				
				
				// check state list for resume
				
				if(!empty($this->params->query['state_list']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								$stringStateIds = implode(',',$this->params->query['state_list']);
							    $stringStateIds = str_replace(',','\',\'',$stringStateIds);
								$conditions.=' Candidate.candidate_state in (\''.$stringStateIds.'\') ';
							}
							 
	
							
				if(!empty($this->params->query['relocate']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								$conditions.='Candidate.relocate="'.$this->params->query['relocate'].'"';
							
							}
				
					if(!empty($this->params->query['keyword']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								$conditions.= ' Resume.resume_content like "%'.$this->params->query['keyword'].'%" or  Resume.resume_summary like "%'.$this->params->query['keyword'].'%" ';
							
					}		
							
				if(!empty($this->params->query['citizen_status_code']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								$conditions.='Candidate.citizen_status_code="'.$this->params->query['citizen_status_code'].'"';
							
							}
						
					
			if(!empty($this->params->query['cleareance_list']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
									
								}
								
								$securityClearances=$this->params->query['cleareance_list'];
								count($securityClearances);
							//	echo explode(',',$this->params->query['security_clearance_code']);die;
								
								$totalSecurityClearance=count($securityClearances);
								$stringSecurityClearance='';
								$i=1;
								foreach($securityClearances as $key7=>$value7)
								{
									
									
									$conditions.= 'FIND_IN_SET("'.$value7.'",Candidate.security_clearance_code) ';
									
									if($i!=$totalSecurityClearance)
									{
										$conditions.=" or ";
									}
									$i=$i+1;
								}
								 
								  $conditions;
						
							}
									
					if(!empty($this->params->query['experience_code']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
								}
								$conditions.='Candidate.experience_code="'.$this->params->query['experience_code'].'" ';
					}
						
					if(isset($this->params->query['advance']))
					{
								if(!empty($conditions))
								{
									$conditions.=' and ';
								}
								$conditions.='Resume.resume_summary LIKE "%'.$this->params->query['advanceSearch'].'%" ';
					}
						
					if(!empty($this->params->query['resumelast_matching']) && !empty($this->params->query['resumelast']))
					{ 
								$date_set =$this->params->query['resumelast_matching'];
								if(!empty($conditions))
								{
									$conditions.=' and ';
								}
								
								switch($date_set)
								{ 
									case 'days':
									$last_dt = '-'.$this->params->query['resumelast'].' day';
									$last_dt2 =  date( "Y-m-d 00:00:00", strtotime($last_dt, mktime()));
									$conditions.=' Resume.posted_dt >"'.$last_dt2.'" ';
									break;
									
									case 'weeks':
									$last_dt = '-'.$this->params->query['resumelast'].' week';
									$last_dt2 =  date( "Y-m-d 00:00:00", strtotime($last_dt, mktime()));
									$conditions.=' Resume.posted_dt >"'.$last_dt2.'" ';
									break;
									
									case 'months':
									$last_dt = '-'.$this->params->query['resumelast'].' month';
									$last_dt2 =  date( "Y-m-d 00:00:00", strtotime($last_dt, mktime()));
									$conditions.=' Resume.posted_dt >"'.$last_dt2.'" ';
									break;
									
									case 'years':
									$last_dt = '-'.$this->params->query['resumelast'].' year';
									$last_dt2 =  date( "Y-m-d 00:00:00", strtotime($last_dt, mktime()));
									$conditions.=' Resume.posted_dt >"'.$last_dt2.'" ';
									break;
								}
					}
						
				if(!empty($conditions))
								{
									$conditions.=' and ';
								}		
				$conditions.=' Candidate.id in ('.$candidateString.') ';
				
		
				 $this->paginate = array(
					//'limit' => $this->params->query['max_rows'],
					'limit' => 3,
					'conditions'=>$conditions,
					'paramType' => 'querystring'
				);
				$resumeLists= $this->paginate('Resume');
			
				//pr($resumeLists);die;
				
				$this->set('resumeLists', $resumeLists);
				}else
				{ 
					$this->set('resumeList',array());
					$this->Session->write('popup','Please select at least one databsae.');
					$this->redirect(array('controller'=>'employers','action'=>''));	
				}
				//pr($this->JobPosting->find('all',array('conditions'=>'JobPosting.security_clearance_code="3919"  and Employer.employer_name like "%Innovance%"')));die;
		
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