<?php 
/**************************************************************************
 Coder  : Pushkar Soni ,
 Object : Controller for login, logout and registration process of candidate
**************************************************************************/ 

App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController {
 	var $name = 'Users'; //Model name attached with this controller 
 	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some required helpers to this controller
 	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler','Captcha');  //add some required component to this controller .
	var $layout = 'front'; //this is the layout for front panel 
	var $currUser = 0;
	var $uses = array('User','HomepageDynamicContent','MASSEMAIL','ShowsHome','Testimonial','ShowEmployer','Employer','Banner','ChatUser','City','State','city','PageContent');
	/* This function call by default when a controller is called */
	
	function index()  // home page action
	{
		
		$this->set('meta_title','TECHEXPO Top Secret job fairs: Security Clearance Jobs and Career Fairs');
		$this->set('WorkTypeList',$this->common->getWorkTypeList());
		$this->set('WorkTimeList',$this->common->getWorkTimeList());
		$this->set('WorkLocationList',$this->common->getWorkLocationList());
		$this->set('GovCleareanceList',$this->common->getGovCleareanceList());
		
		$cityList=array('0'=>'please select city');
		$this->set('cityList',$cityList);	
	
		$this->set('specialAnnounces', $this->HomepageDynamicContent->find('all', array('conditions' => array('type' => 's', 'active' => 'y' ),
																						'limit'=>'6','order'=>'sort ASC')));    //special announcement list sort,title asc
		
		
																						
		$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
		//	$calEvents = $this->ShowsHome->find('all',array('order'=>'Show.show_dt ASC')); // 05/21/2013
		
		$this->loadModel('Show');
		$this->Show->unbindModel(array('hasMany' => array('Registration')));
		$calEvents = $this->Show->find("all",array('joins' => array(

				array(
					'table' => 'shows_home',
					'alias' => 'ShowsHome',
					'type' => 'INNER',
					'conditions' => array(
					'ShowsHome.show_id = Show.id'
					)
				)
			),'fields' => array('Show.location_id','Show.show_dt','Show.show_name','Show.show_hours','Show.id','Show.ics_file','Show.show_end_dt','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('ShowsHome.assign_homepage'=>1,'Show.published'=>1),'order'=>'Show.show_dt ASC'));
	// 'Show.show_dt >="'.$targetdate.'"',   condition removed task id 3111	
	
		/*
		$calEvents = $this->ShowsHome->find('all',array('conditions'=>array('show_dt >="'.$targetdate.'"','ShowsHome.assign_homepage'=>1,'Show.published'=>1),'order'=>'Show.show_dt ASC'));*/
		
		$this->set('events',$calEvents);  //events for home
		
		
		$this->set('testimonials_job', $this->Testimonial->find('all',array('conditions' => array('testimonial_by' => 'j','Testimonial.aprov'=>'1'),  // code for jobseeker testimonial
																						'limit'=>'3','order'=> 'id DESC')));
																						
		$this->set('testimonials_emp', $this->Testimonial->find('all',array('conditions' => array('testimonial_by' => 'e','Testimonial.aprov'=>'1'), // code for employer testimonial
																				'limit'=>'3','order'=> 'id DESC')));
																				
		//$this->set('featuredEmployer', $this->Employer->find('first',array('conditions' => array('is_featured' => 'y'))));
		
	}
	function banneronclick($bannerID =null){
		$this->autoRender = false;
		$banenrInfo = $this->Banner->find('first',array('conditions' => array('Banner.id'=>$bannerID)));
		$location = $_SERVER['HTTP_REFERER'];
		$this->common->addBannerPerformanceOnClick($bannerID, $location);
		$url = $banenrInfo['Banner']['href'];
		if(false === strpos($url, '://')) {
			$bannerurl = 'http://' . $url;
		}else{
			$bannerurl = $url;
		}
		
		
		if(isset($banenrInfo['Banner']['href']) && trim($url!=""))
		$this->redirect($bannerurl);
		/*echo "<script>window.location = '".$bannerurl."'</script>";*/
		else
		$this->redirect(array('controller'=>'users','action'=>'/'));
		
	}
	
	function aboutUs()  // about us page
	{
		$this->set('meta_title','About Us');
	}
	
	function contactUs()  // contact us page
	{
		$this->set('meta_title','Contact Us');
	}
	
	function recruitWithUs()   //  about us page page
	{
		$this->set('meta_title','Recruit With Us');
		$content = $this->PageContent->findById(5);
		$this->set('content',$content);
	}
	function jobposting()   //  about us page page
	{
		$this->set('meta_title','Job Posting');
		$content = $this->PageContent->findById(6);
		$this->set('content',$content);
	}
	function exihibitors()   //  about us page page
	{
		$this->set('meta_title','Exhibitors');
		$start_date="2002-01-01";

		$this->ShowEmployer->unbindModel(array('belongsTo' => array('Employer','Show')));
		$option['joins'] = array(
			array('table' => 'employers',
				'alias' => 'Employer',
				'type' => 'inner',
				'conditions' => array(
					"ShowEmployer.employer_id = Employer.id"
				)
			),
			array('table' => 'shows',
				'alias' => 'Show',
				'type' => 'inner',
				'conditions' => array(
					"Show.id = ShowEmployer.show_id",
					"Show.show_dt > '".$start_date."'"
				)
			)
		);
		$option['fields'] = array('DISTINCT(ShowEmployer.employer_id) as employerID','Employer.id','Employer.employer_name','Employer.logo_file');
		$option['order'] = array('Employer.employer_name');
		$exhibitor = $this->ShowEmployer->find('all', $option);
		$this->set('exhibitor',$exhibitor);
		//pr($exhibitor);
		
	}
	
	function whyAttend()  // why attend page
	{
		$this->set('meta_title','Why Attend?');	
		$content = $this->PageContent->findById('4');
		$this->set('content',$content);	
	}

	function privacypolicy()  // why attend page
	{
		$this->set('meta_title','Privacy Policy');
		$content = $this->PageContent->findById('1');
		$this->set('content',$content);
		
	}
	
	function termsofuse()  // why attend page
	{
		$this->set('meta_title','Terms Of Use');
		$content = $this->PageContent->findById('2');
		$this->set('content',$content);
	}
	
	function resumewriting()  // why attend page
	{
		$this->set('meta_title','Resume Writing');
		$content = $this->PageContent->findById('3');
		$this->set('content',$content);
		
	}
	
	function forgotpassword(){
		$this->set('meta_title','Forgot password');
		$errorsArr  = '';
		
		if($this->request->is('post')){
			$this->request->data['User']['contact_email'] = trim($this->request->data['User']['contact_email']);
			$userEmail = $this->request->data['User']['contact_email'];
			$userType = $this->request->data['User']['usertype'];
			
			
			$this->User->set($this->request->data);	
			if(!$this->User->forgotpassValidate())
			{
			$errorsArr = $this->User->validationErrors;
			}
		
			if($userType=='E')
			$condition = "User.user_type = '".$userType."' AND employerContact.contact_email like '".$userEmail."%' ";
			else
			$condition = "User.user_type = '".$userType."' AND Candidate.candidate_email like '".$userEmail."%' ";
			
			
			if(!$errorsArr){
				
				if($userType=='E')
				$userInfo = $this->User->find("first",array('fields'=>array('User.username','User.old_password','employerContact.contact_name'),'conditions'=>$condition));
				else
				$userInfo = $this->User->find("first",array('fields'=>array('User.username','User.old_password','Candidate.candidate_name'),'conditions'=>$condition));
			
				if($userInfo!==false){
					// email user
					$email = new CakeEmail('smtp');
					$email->from(array('Amanda@techexpousa.com'=>'TechExpoUSA'));
					//$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
					
					$subject = "Login Information for www.techexpoUSA.com";
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					
					if($userType=='E')
						$username = $userInfo['employerContact']['contact_name'];
					else
						$username = $userInfo['Candidate']['candidate_name'];
					
						$bodyText = 'Dear '.$username.',<br/><br/>Here is your TECHEXPO log in information :<br/><br/>Username:  '.$userInfo['User']['username'].'<br/>Password:  '.$userInfo['User']['old_password'].'<br/><br/>Thank you for your continued support and feel free to e-mail Amanda@techexpousa.com with any questions.<br/><br/>Best Regards,<br/><br/>The TECHEXPO Team.';
						
					if(Validation::email($userEmail)){
						$email->to($userEmail);
						$email->send($bodyText);
						$this->Session->write('popup','You will receive your username and password by email shortly.');
						unset($this->request->data);
					}
					
				}else{
					$this->Session->write('popup',"We're sorry, this email address is not recorded in our system.Try again.");
				}
				
			}
			
		}
		
	}
	
	function icalender($date = null,$subject = null,$desc = null)
	{ 



$startTime = '0000';
$endTime   = '0000';
$desc = str_replace("#", "\n", $desc);
$desc = str_replace("\\", "", $desc);
$desc = str_replace("\r", "=0D=0A", $desc);
$desc = str_replace("\n", "=0D=0A", $desc);
 
$ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . md5(uniqid(mt_rand(), true)) . "example.com
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:".$date."
DTEND:".$date."
SUMMARY:".$subject."
DESCRIPTION;ENCODING=QUOTED-PRINTABLE:".$desc."
END:VEVENT
END:VCALENDAR";
 
//set correct content-type-header
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename=calendar.ics');
echo $ical;
exit;
		
	}
	
// some updates by jitendra on 30 july 2013 by reference of ticket 1311	
function icalender2($startdate = null,$enddate = null,$subject = null,$desc = null,$location=null){
	
	
date_default_timezone_set('GMT');
$enddateyear =  date('Y',strtotime($enddate));
$startdate = date('Ymd\THis', strtotime($startdate));
$enddate =  date('Ymd\THis', strtotime($enddate)) ;

$desc = str_replace("#", "\\n ", $desc);



//echo $desc;die;
header("Content-Type: text/Calendar");
header("Content-Disposition: inline; filename=filename.ics");

echo "BEGIN:VCALENDAR\n";
echo "PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN\n";
echo "VERSION:2.0\n";
echo "METHOD:PUBLISH\n";
echo "X-MS-OLK-FORCEINSPECTOROPEN:TRUE\n";
echo "BEGIN:VEVENT\n";
echo "CLASS:PUBLIC\n";
echo "CREATED:20091109T101015Z\n";
echo "DESCRIPTION:$desc\n";
echo "DTEND:$enddate\n";
echo "DTSTAMP:20131007T093305Z\n";
echo "DTSTART:$startdate\n";
echo "LAST-MODIFIED:20131007T101015Z\n";
echo "LOCATION:$location\n";
echo "PRIORITY:5\n";
echo "SEQUENCE:0\n";
echo "SUMMARY;LANGUAGE=en-us:$subject\n";
echo "TRANSP:OPAQUE\n";
echo "UID:040000008200E00074C5B7101A82E008000000008062306C6261CA01000000000000000\n";
echo "X-MICROSOFT-CDO-BUSYSTATUS:BUSY\n";
echo "X-MICROSOFT-CDO-IMPORTANCE:1\n";
echo "X-MICROSOFT-DISALLOW-COUNTER:FALSE\n";
echo "X-MS-OLK-ALLOWEXTERNCHECK:TRUE\n";
echo "X-MS-OLK-AUTOFILLLOCATION:FALSE\n";
echo "X-MS-OLK-CONFTYPE:0\n";
echo "BEGIN:VALARM\n";
echo "TRIGGER:-PT1440M\n";
echo "ACTION:DISPLAY\n";
echo "DESCRIPTION:Reminder\n";
echo "END:VALARM\n";
echo "END:VEVENT\n";
echo "END:VCALENDAR\n";
//echo $ical;
exit;
		
	}	
	
	
function icalenderOrg($showId){
	
	$this->loadModel('Show');
		$this->Show->unbindModel(array('hasMany' => array('Registration')));
		$event = $this->Show->find("first",array('joins' => array(

				array(
					'table' => 'shows_home',
					'alias' => 'ShowsHome',
					'type' => 'LEFT',
					'conditions' => array(
					'ShowsHome.show_id = Show.id'
					)
				)
			),'fields' => array('Show.location_id','Show.show_dt','Show.show_name','Show.show_hours','Show.id','Show.ics_file','Show.show_end_dt','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=>array('Show.id'=>$showId)));
	
$show_display_name = (!empty($event['ShowsHome']['display_name'])) ? $event['ShowsHome']['display_name'] : $event['Show']['show_name'];

   $site_address =(!empty($event['Location']['site_address'])) ? '#'.$event['Location']['site_address'] : "";	
   $site_address .=(!empty($event['Location']['location_city'])) ? '#'.$event['Location']['location_city'].', ' : "";
   $site_address .=(!empty($event['Location']['location_state'])) ? $event['Location']['location_state'] : "";  
   $site_address .=(!empty($event['Location']['site_zip'])) ? " ".$event['Location']['site_zip'] : "";
   $show_location = "".$event['Location']['site_name'].' '.$site_address;

 //  $show_detail = $show_location."#Show Name: ".$event['Show']['show_name'];
    $show_detail = $show_location;
   $show_detail .= (!empty($event['Show']['show_hours'])) ? "#Show Time: ".$event['Show']['show_hours'] : ""; 
   $show_detail .= (!empty($event['ShowsHome']['display_name'])) ? "##".$event['ShowsHome']['display_name'] : "";
   $show_detail .= (!empty($event['ShowsHome']['special_message'])) ? ",  ".$event['ShowsHome']['special_message'] : "";
   
  	
			   
   $show_location2 = $event['Location']['site_name'];
   
   $Alldaytime =explode('-',$event['Show']['show_hours']);

   $starttime = date('Ymd H:i:s', strtotime($event['Show']['show_dt'].' '.$Alldaytime['0']));  
   if(!empty($event['Show']['show_end_dt']))
   $endtime = date('Ymd H:i:s', strtotime($event['Show']['show_end_dt'].' '.$Alldaytime['1'])); 
   else
   $endtime = date('Ymd H:i:s', strtotime($event['Show']['show_dt'].' '.$Alldaytime['1']));		
	

	
date_default_timezone_set('America/New_York');
$enddateyear =  date('Y',strtotime($endtime));
$startdate = date('Ymd\THis', strtotime($starttime));
$enddate =  date('Ymd\THis', strtotime($endtime)) ;

$desc = str_replace("#", "\\n ", $show_detail);


$fileName = str_replace(' ','_',$event['Show']['show_name']);
$fileName = str_replace(',','',$fileName);
$uid =md5(uniqid(mt_rand(), true));
//echo $desc;die;
header("Content-Type: text/x-vcard");
header("Content-Disposition: inline; filename=$fileName.ics");

echo "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Apple Inc.//Mac OS X 10.8.5//EN
CALSCALE:GREGORIAN
BEGIN:VTIMEZONE
TZID:America/New_York
BEGIN:DAYLIGHT
TZOFFSETFROM:-0500
RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=2SU
DTSTART:20070311T020000
TZNAME:EDT
TZOFFSETTO:-0400
END:DAYLIGHT
BEGIN:STANDARD
TZOFFSETFROM:-0400
RRULE:FREQ=YEARLY;BYMONTH=11;BYDAY=1SU
DTSTART:20071104T020000
TZNAME:EST
TZOFFSETTO:-0500
END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
TRANSP:OPAQUE
DTEND;TZID=America/New_York:$enddate
UID:$uid
DTSTAMP:20131115T190956Z
LOCATION:$show_location2
DESCRIPTION:$desc
URL;VALUE=URI:TechExpoUSA.com
SEQUENCE:20
SUMMARY:$show_display_name
DTSTART;TZID=America/New_York:$startdate
CREATED:20131016T153208Z
BEGIN:VALARM
X-WR-ALARMUID:$uid
UID:".md5($startdate)."
TRIGGER;VALUE=DATE-TIME:19760401T005545Z
X-APPLE-DEFAULT-ALARM:TRUE
X-APPLE-LOCAL-DEFAULT-ALARM:TRUE
ACTION:NONE
END:VALARM
END:VEVENT
END:VCALENDAR";

/*
echo "BEGIN:VCALENDAR\n";
echo "PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN\n";
echo "VERSION:2.0\n";
echo "METHOD:PUBLISH\n";
echo "X-MS-OLK-FORCEINSPECTOROPEN:TRUE\n";
echo "BEGIN:VEVENT\n";
echo "CLASS:PUBLIC\n";
echo "CREATED:20091109T101015Z\n";
echo "DESCRIPTION:$desc\n";
echo "DTEND:$enddate\n";
echo "DTSTAMP:20131007T093305Z\n";
echo "DTSTART:$startdate\n";
echo "LAST-MODIFIED:20131007T101015Z\n";
echo "LOCATION:$show_location2\n";
echo "PRIORITY:5\n";
echo "SEQUENCE:0\n";
echo "SUMMARY;LANGUAGE=en-us:$show_display_name\n";
echo "TRANSP:OPAQUE\n";
echo "UID:040000008200E00074C5B7101A82E008000000008062306C6261CA01000000000000000\n";
echo "X-MICROSOFT-CDO-BUSYSTATUS:BUSY\n";
echo "X-MICROSOFT-CDO-IMPORTANCE:1\n";
echo "X-MICROSOFT-DISALLOW-COUNTER:FALSE\n";
echo "X-MS-OLK-ALLOWEXTERNCHECK:TRUE\n";
echo "X-MS-OLK-AUTOFILLLOCATION:FALSE\n";
echo "X-MS-OLK-CONFTYPE:0\n";
echo "BEGIN:VALARM\n";
echo "TRIGGER:-PT1440M\n";
echo "ACTION:DISPLAY\n";
echo "DESCRIPTION:Reminder\n";
echo "END:VALARM\n";
echo "END:VEVENT\n";
echo "END:VCALENDAR\n";
*/
//echo $ical;
exit;
		
	}		
	
	
	
	
	function home()  // function to logout
	{
		
		$userChat = $this->ChatUser->find('first',array('conditions'=>array('ChatUser.login_user_id'=>$this->Session->read('Auth.Clients.id')))) ;
		
		if(isset($userChat['ChatUser']['id']))
		{
		$this->ChatUser->delete(array('ChatUser.login_user_id' =>$userChat['ChatUser']['id']));			
		}
		
		$this->Session->delete('Chat');
		$this->Session->delete('Auth.Client');
		$this->Session->delete('Auth.Clients');
		$this->Session->delete('Auth.redirect');
		$this->Session->delete('TrialAccountEmp');
		
		$this->redirect(array('controller'=>'users','action'=>'login'));
		die;
	}
	
	function Jobseeker_login()
	{
		 	$this->set('meta_title','Login');
			$this->Session->delete('Auth.Client');
			$this->Session->delete('Auth.Clients');
			$this->redirect(array('controller'=>'users','action'=>'login'));
	}

	
	function login(){  // to remove login error
	$this->set('meta_title','Login');
	if($this->Session->read('Auth.Client.User.id')!='')
	{ 
		$this->redirect(array('controller'=>'users','action'=>'index'));
	}else
	{
	
			if($this->request->data):   // CANDIDATE OR EMPLOYEER LOGIN CHECK
				if($this->request->data['User']['LOGIN']=='LOGIN'):
					$username = trim($this->request->data['User']['username']);
					$password = trim($this->request->data['User']['password']);
					$today_date = date("Y-m-d H:i:s");
					if($username=='User Name:'):
						$this->request->data['User']['username']='';
					endif;
					
					if($password=='Password:'):
						$this->request->data['User']['password']='';
					endif;
				
					$this->User->set($this->request->data);
					if(!$this->User->loginValidate()):
							
					else:
						// $condition = "User.username='".$username."' AND User.password='".md5($password)."' AND (User.created='0000-00-00 00:00:00' OR User.created='NULL' OR User.created< '".$today_date."') ";
						$condition = "User.username='".$username."' AND User.password='".md5($password)."'";
						$authenticate = $this->User->find('first',array('conditions'=>$condition));
						
						
						if($authenticate['User']['user_type']=='E' || $authenticate['User']['user_type']=='e')
						{
							
							$this->Employer->id=$authenticate['employerContact']['employer_id'];
							if($this->Employer->field('trial_client')=='Y' || $this->Employer->field('trial_client')=='y')
							{
								$condition = "User.username='".$username."' AND User.password='".md5($password)."' and User.created< '".$today_date."' ";
								$authenticate = $this->User->find('first',array('conditions'=>$condition));
							}
							$this->Employer->id='';
							
						}
						
				
						if(!empty($authenticate)) 
						{
							$this->Session->write('Auth.Clients',$authenticate['User']);
							// add after task id 2532 start
							$this->loadModel('TrialAccount');
							$trialdt = $this->TrialAccount->find('first',array('conditions'=>array('TrialAccount.employer_contact_id'=>$authenticate['User']['employer_contact_id'])));
							if(!empty($trialdt['TrialAccount']['employer_contact_id']) && isset($trialdt['TrialAccount']['employer_contact_id']))
							{
							$this->Session->write('TrialAccountEmp',1);	
							}
							// add after task id 2532 end
							
						}
						
						if($this->Session->check('Auth.Clients'))
						{
							$this->Session->write('Auth.Client',$authenticate);
							$redirect=$this->Session->read('Auth.redirect');
							
							if($this->Session->read('Auth.Redirects'))
								{
									$redirect=str_replace('&matching=','?matching=',$this->Session->read('Auth.Redirects'));
									$this->Session->delete('Auth.Redirects');
									
									$this->redirect($redirect);
								}else
								{
									$usertype=$this->Session->read('Auth.Clients.user_type');
									$referrar  = BASE_URL."".$_SERVER['REQUEST_URI'];
									$pagename  = "/".end(explode("/",$_SERVER['REQUEST_URI']));
									$remoteAddress  = $_SERVER['REMOTE_ADDR'];
									/**** insert into webstat ********/
									$this->common->saveDetailedTrafficHistory($pagename,$remoteAddress,$referrar);
								
									if($usertype=='E' || $usertype=='e'){
										
										// make entry in employer stat for login history
										$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
										$this->common->saveEmployerPagesVisitHistory($employerID,$pagename,$remoteAddress,$referrar);										
									}
									
									/*
									if($redirect=='' || $redirect=='/' || $redirect=='/pushkar/techexpo_new/Jobseeker/users/login')
									{*/
										if($usertype=='E' || $usertype=='e')
										{	
											
											$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										}else{
											
											if(strpos($this->Session->read('Auth.redirect'), 'Jobseeker/candidates/jobDetail')  != false)
											{
												
												$redirect_path1 = $this->Session->read('Auth.redirect');
												$redirect_path= end(explode('Jobseeker/',$redirect_path1));
												
												$this->redirect(FULL_BASE_URL.router::url('/',false).'Jobseeker/'.$redirect_path); 
											}else{											
												$this->redirect(array('controller' => 'candidates', 'action' => 'candidateprofile','Jobseeker'=>true));
											}
											
											
										}
									/*}
									else
									{
										$this->redirect($this->Auth->redirect());
									}*/
								}
						} else 
						{
							$this->Session->setFlash(__('Invalid username or password, try again.'));
						}
						
					endif;
				endif;
			endif;    ///=======END LOGIN CHECK 
		}
		
	}
		
	function listSignup($id=NULL)  // function to add news letter in 
	{	//pr($this->request->data);die;
		/****** sign up for newsletter by Jitendra ***/
		if($this->request->is('post')){
			
		if(!empty($_POST['newslatter_status']))
		{
			$this->redirect(array('controller'=>'users','action'=>'index'));
		}
			
		if($this->request->data['MASSEMAIL']['list_email']!='' && empty($_POST['newslatter_status'])){
			$this->loadModel('NewsletterSubscriber');
			$this->request->data['NewsletterSubscriber']['subscriber_email'] = $this->request->data['MASSEMAIL']['list_email'];
			$this->request->data['NewsletterSubscriber']['created_date'] = date('Y-m-d');
			if($this->NewsletterSubscriber->save($this->request->data))
			{
				// Email configuration
				$emailsendto = $this->request->data['NewsletterSubscriber']['subscriber_email'];
				$emailsendfrom = FROM_MAILING_ADDRESS;
				$emailsubject = "Thank you for signing up to the TECHEXPO mailing list.";				 
				$email_content ="Thank you for joining the TECHEXPO online community mailing list.<br/><br/>Each month you will receive invitations to our industry related shows and professional hiring events.<br/><br/>
				
				Best Regards,<br/>				
				The TECHEXPO Team.";				
				$email = new CakeEmail('smtp');
				$email->from(array($emailsendfrom));
				$email->to($emailsendto);
				$email->emailFormat('html');
			/*	$email->replyTo( 'webmaster@mailinglist.techexpomail.com');
				$email->returnPath( 'webmaster@mailinglist.techexpomail.com');*/
				$email->subject(strip_tags($emailsubject));
			//	$ok = $email->send($email_content);
				$this->Session->write('popup','Thank you for joining our mail list.');
				$this->redirect(array('controller'=>'users','action'=>'index'));
				die;
			}
		}
		}
		/******** old code start from here ***/
		
		$this->set('meta_title','Signup Newsletter');
		if(!empty($id))  //varifaction code
		{
				$this->request->data['MASSEMAIL']['list_id']=$id;
				$this->request->data['MASSEMAIL']['list_active']='1';
				$this->MASSEMAIL->set($this->request->data);
				
				if($this->MASSEMAIL->save($this->request->data))
				{
					$this->Session->write('popup','Thank you for signing up to the TECHEXPO Top Secret mailing list.');
					$this->redirect(array('controller'=>'users','action'=>'index'));
				}
		}
	
		$this->set('statList',$this->common->getStateList()); //    find statelist
		if($this->request->data)
		{
			if(!empty($this->request->data['candidate_REGISTER']))
			{
				
				$this->request->data['MASSEMAIL']['list_insert_date']=date('Y-m-d',time());
				$this->request->data['MASSEMAIL']['origin']='TECHEXPO_SITE';
				//$this->request->data['MASSEMAIL']['list_active	']='1';
				if(!empty($this->request->data['MASSEMAIL']['list_states']))
				{
					$this->request->data['MASSEMAIL']['list_states']=implode(',',$this->request->data['MASSEMAIL']['list_states']);
				}
				
				
				$this->MASSEMAIL->set($this->request->data);
				if(!$this->MASSEMAIL->newsLetterValidate())
				{
					if(!empty($this->request->data['MASSEMAIL']['list_states']))
					{
					$this->request->data['MASSEMAIL']['list_states']=explode(',',$this->request->data['MASSEMAIL']['list_states']);
					}
				}
				else
				{
					if($this->MASSEMAIL->save($this->request->data))
					{
					
						$lastInsertId=$this->MASSEMAIL->getLastInsertId();
						
						
						// Email configuration
						$sendto = $this->request->data['MASSEMAIL']['list_email'];
						$sendfrom = 'webmaster@mailinglist.techexpomail.com';
						//$emailMessage = $this->request->data['MASSEMAIL']['message'];
						
						$subject = "Thank you for signing up to the TECHEXPO Top Secret mailing list.";
						 						
						
						$bodyText ="Dear ".$this->request->data['MASSEMAIL']['list_first_name']."&nbsp;".$this->request->data['MASSEMAIL']['list_last_name'].",<br>

Welcome and thank you for joining the TECHEXPO Top Secret mailing list. 

To confirm the receipt of this e-mail and to activate your membership, you must first click on the link below:
<br><a href='".FULL_BASE_URL.router::url('/',false).'/users/listSignup/'.$lastInsertId."' target='_blank'>Click Here</a>
<br>

After you confirm your sign-up, you will soon start receiving invitations to our events and, if you have chosen to when signing up, special messages directly from employers as well as TECHEXPO partners and advertisers. All messages will always include a remove link. Please note that events labeled Top Secret require security clearance in order to attend unless otherwise indicated on the event page. The other TECHEXPO events and special employer shows do not. The event information pages of our site will indicate if clearance is required or not for a given show.
	
Best Regards,
	
The TECHEXPO Team.";

						//echo $bodyText;die;
						
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						//$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
						
						$this->Session->write('popup','please check your email address for activation');
						$this->redirect(array('controller'=>'users','action'=>'index'));
					}
				}
			
			}
		}
		
	}
	
	function tellaFriend()
	{	
		$this->set('meta_title','Tell a friend');
	
		extract($_POST);
		if(!empty($SUBMIT) && empty($friendabout))
		{  
						// Email configuration
						$sendto = $friendemail;
						$sendfrom = $email;
						//$emailMessage = $this->request->data['MASSEMAIL']['message'];
						$subject = " A friend is sending an e-mail from techexpoUSA.com";
						 						
						if($message){
							$message="Here is your friend's message:<br>
										".$message."";
							}
						
						$bodyText ="<table>
										<tr>
											<td>Hello,</td>
										</tr>
										<tr>
											<td>Your friend $fname $lname with e-mail address: $email thinks that you may benefit from our website, and used our online tool to tell you about it: ".FULL_BASE_URL.router::url('/',false)." 
											<br><br>
											Our site offers information on industry tradeshows, professional hiring events and thousands of technology, engineering & intelligence jobs.<br>
											<br>
											If you are an experienced professional, we invite you to join our community. <br><br>
											</td>
										</tr>
										<tr>
											<td>
												The TECHEXPO Team <br>
												Email: <a href='mailto:Amanda@TechExpoUSA.com'>Amanda@TechExpoUSA.com</a><br>
												Tel: 212.655.4505 ext. 224
												<br><br>
											</td>
										</tr>
									</table>";
					
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
						$this->Session->write('popup','Your message has been sent successfully');
						$this->redirect(array('controller'=>'users','action'=>'index'));
						
					
		}
		
	
	}
	
	function tellaFriendEvent()
	{	
		$this->set('meta_title','Tell a friend');
		
		extract($_POST);
		if(!empty($SUBMIT))
		{  
						// Email configuration
						$sendto = $friendemail;
						$sendfrom = $email;
						//$emailMessage = $this->request->data['MASSEMAIL']['message'];
						$subject = " A friend is sending an e-mail from techexpoUSA.com";
						 						
						if($message){
							$message="<br/>Here is your friend's message: 
										".$message." <br><br/>";
							}
						
						$bodyText ="<table>
										<tr>
											<td>Hello,</td>
										</tr>
										<tr>
											<td>
											
										".$message."
											
											<strong>$fname $lname</strong> would like to share information with you about an upcoming hiring event. TechExpoUSA.com provides IT, Engineering & Defense professionals with career opportunities with the Nation's leading employers. View job openings and register for upcoming hiring events on TechExpoUSA.com.<br><br>
											</td>
										</tr>
										<tr>
											<td>
												The TECHEXPO Team <br>
												Email: Amanda@TechExpoUSA.com<br>
												Tel: 212.655.4505 ext. 224
												<br><br>
											</td>
										</tr>
									</table>";
						
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText);
						$this->Session->write('popup','Your message has been sent successfully');
						$this->redirect($this->referer());
						
					
		}
		
	
	}
	function suggestion()
	{	
		$this->set('meta_title','Tell a friend');
		extract($_POST);
		
		if(!empty($_POST['SUBMIT']) && empty($_POST['checkuser']))
		{
			$systemEmail = $this->common->systemSetting();
						
						
			if(strpos($systemEmail['Email To'],',')){
				$sendto=explode(',',$systemEmail['Email To']);
				$sendto = array_filter(array_map('trim', $sendto));
				
			}else{
				$sendto=(array)$systemEmail['Email To'];
				$sendto = array_filter(array_map('trim', $sendto));
			}
			
			
			
			if(strpos($systemEmail['Email CC'],',')){
				$sendcc=explode(',',$systemEmail['Email CC']);
				$sendcc = array_filter(array_map('trim', $sendcc));
				
			}else{
				$sendcc=(array)$systemEmail['Email CC'];
				$sendcc = array_filter(array_map('trim', $sendcc));
			}
			
			
						
						$sendfrom = $senderemail;
						//$emailMessage = $this->request->data['MASSEMAIL']['message'];
						$subject = "Email to the CEO from TechExpo.com";
						$bodyText ="<table>
										<tr>
											<td style='align:right'>Message from $sendername</td>
											
										</tr>
										<tr>
										
											<td>$emailMessage</td>
										</tr>
									</table>";
						$email = new CakeEmail('smtp');
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->cc($sendcc);
						$email->emailFormat('html');
						//$email->replyTo( 'webmaster@mailinglist.techexpomail.com');
						//$email->returnPath( 'webmaster@mailinglist.techexpomail.com');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText); 
						$this->Session->write('popup','Thank you for your message');
						$this->redirect(array('controller'=>'users','action'=>'index'));
		}
		
	
	}
	
	function state($countryId=NULL)
	{
		$this->layout=false;
		$this->autoRender=false;
		$stateList=$this->common->getAjaxStateList($countryId);
		
	//	$option="<option value=''>Please select state</option>";
		$option="";
		foreach($stateList as $key=>$value)
		{
			
			
			$option.="<option value='".$key."'>$value</option>";
		}
		
		echo $option;
		//$this->set('statList',$stateList);
	}
	
	function city($state=NULL)
	{
		$this->layout=false;
		$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$state.'"','fields'=>'city,city','order by city ASC'));
		$this->set('cityList',$cityList);
	}
	
	function multiplecity($state=NULL)
	{
		$this->layout=false;
		$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$state.'"','fields'=>'city,city','order by city ASC'));
		$this->set('cityList',$cityList);
	}
	
	function multiplecity2($state=NULL)
	{
		$this->layout=false;
		$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$state.'"','fields'=>'city,city','order by city ASC'));
		$this->set('cityList',$cityList);
	}
	
	function multiplecity3($state=NULL)
	{
		$this->layout=false;
		$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$state.'"','fields'=>'city,city','order by city ASC'));
		$this->set('cityList',$cityList);
	}
	public function downloadfilehome($filename)
	{
		 $this->downloadFile('ShowsDocument/ics',$filename); 
	
	}
	
	function beforeFilter() 
	{ 
		parent::beforeFilter();
		$this->Auth->autoRedirect = true;
		$this->set('common',$this->common);

		$this->Auth->fields = array(
            'username' => 'username',
            'password' => 'password'
        );
		
		
		$usertype=$this->Session->read('Auth.Clients.user_type');
		if($usertype=='C')
		{
			$this->Auth->allow('*');
		}else
		{
			$this->Auth->allow('home','icalender','icalender2','listSignup','tellaFriend','aboutUs','login','whyAttend','contactUs','exihibitors','forgotpassword','index','city','City','multiplecity','multiplecity2','multiplecity3','privacypolicy','suggestion','privacypolicy','termsofuse','resumewriting','state','deleteimage','recruitWithUs','jobposting','icalenderOrg','downloadfilehome','tellaFriendEvent','banneronclick');
		}
		
				
		$this->Auth->authenticate = array(
				'Form' => array('userModel' => 'User')                                
		);
		if($usertype=='E')
		{
			$this->Auth->loginRedirect =array('controller'=>'employers','action'=>'dashboard');
		}
		if($usertype=='C')
		{
			$this->Auth->loginRedirect = array('controller' => 'candidates', 'action' => 'candidateprofile','Jobseeker'=>true);
		}
		
		
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login','Jobseeker'=>false);
		$this->Auth->loginError = "Login failed. Invalid Email or Password.";
	}
	
	function deleteimage() 
		{
			unlink($_GET['image']);
			echo '<input  type="hidden" value="" name="data[Candidate][candidate_image]" id="candidateimage"><img src="/img/images/new_account_pic.jpg" alt="">';
			die;
			
		}
		
	
		function beforeRender() 
		{
			
			$this->set('Session',$this->Session);
		}
	
}//end class
?>