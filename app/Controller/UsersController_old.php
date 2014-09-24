<?php 
/**************************************************************************
 Coder  : Pushkar Soni
 Object : Controller for login, logout and registration process of candidate
**************************************************************************/ 
class UsersController extends AppController {
 	var $name = 'Users'; //Model name attached with this controller 
 	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some required helpers to this controller
 	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler','Captcha');  //add some required component to this controller .
	var $layout = 'front'; //this is the layout for front panel 
	var $currUser = 0;
	var $uses = array('User','HomepageDynamicContent','MASSEMAIL','ShowsHome','Testimonial','ShowEmployer','Employer','Banner','ChatUser','City','State','city');
	/* This function call by default when a controller is called */
	
	function index()  // home page action
	{
		
		$this->set('meta_title','TECHEXPO Top Secret job fairs: Security Clearance Jobs and Career Fairs');
		$this->set('WorkTypeList',$this->common->getWorkTypeList());
		$this->set('WorkTimeList',$this->common->getWorkTimeList());
		$this->set('WorkLocationList',$this->common->getWorkLocationList());
		$this->set('GovCleareanceList',$this->common->getGovCleareanceList());
		
		$cityList=array('0'=>'please select state');
		$this->set('cityList',$cityList);	
	
		$this->set('specialAnnounces', $this->HomepageDynamicContent->find('all', array('conditions' => array('type' => 's', 'active' => 'y' ),
																						'limit'=>'6','order'=>'sort,title asc')));    //special announcement list
		
		
																						
		$targetdate = date("Y-m-d",mktime(0, 0, 0, date("m") , date("d"), date("Y")));
		$calEvents = $this->ShowsHome->find('all',array('conditions'=>array('show_dt >="'.$targetdate.'"'),'order'=>'Show.show_dt ASC'));
		$this->set('events',$calEvents);  //events for home
		
		
		$this->set('testimonials_job', $this->Testimonial->find('all',array('conditions' => array('testimonial_by' => 'j' ),  // code for jobseeker testimonial
																						'limit'=>'3','order'=> 'sort,name ASC')));
		$this->set('testimonials_emp', $this->Testimonial->find('all',array('conditions' => array('testimonial_by' => 'e' ), // code for employer testimonial
																				'limit'=>'3','order'=> 'sort,name ASC')));
																				
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
		echo "<script>window.location = '".$bannerurl."'</script>";
		else
		$this->redirect(array('controller'=>'users','action'=>'/'));
		
	}
	
	function aboutUs()  // about us page
	{
		$this->set('meta_title','Aboutus');
	}
	
	function contactUs()  // about us page
	{
		$this->set('meta_title','Contactus');
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
		$this->set('meta_title','Whyattend');
	}
	
	function privacypolicy()  // why attend page
	{
		$this->set('meta_title','Privacy Policy');
	}
	
	function forgotpassword(){
		$this->set('meta_title','Forgot password');
		$errorsArr  = '';
		
		if($this->request->is('post')){
			
			$userEmail = $this->request->data['User']['contact_email'];
			$userType = $this->request->data['User']['usertype'];
		
			if($this->request->data['User']['contact_email']==''){
				$this->User->validationErrors['contact_email'] = "Please provide email.";
				$errorsArr = $this->User->validationErrors;
			}
			
			$condition = "User.user_type = '".$userType."' AND employerContact.contact_email like '".$userEmail."%' ";
			
			if(!$errorsArr){
				$userInfo = $this->User->find("first",array('fields'=>array('User.username','User.old_password','employerContact.contact_name'),'conditions'=>$condition));

				if($userInfo!==false){
					// email user
					$email = new CakeEmail();
					$email->from(array(CANDIDATE_EMAIL_ID_LOGIN));
					$subject = "Login Information for www.techexpoUSA.com";
					$email->emailFormat('html');
					$email->subject(strip_tags($subject));
					
					$bodyText = 'Dear '.$userInfo['employerContact']['contact_name'].',<br/><br/>Here is your login information to gain access to www.TechExpoUSA.com:<br/><br/>Username:  '.$userInfo['User']['username'].'<br/>Password:  '.$userInfo['User']['old_password'].'<br/>Thank you for your continued support and feel free to e-mail webmaster@TechExpoUSA.com with any questions.<br/><br/>Best Regards,<br/><br/>The TECHEXPO Team.';
					
					if(Validation::email($userEmail)){
						$email->to($userEmail);
						$email->send($bodyText);
					}

					$this->Session->write('popup','You will receive your username and password by email shortly.');
					unset($this->request->data);
					
				}else{
					$this->Session->write('popup',"We're sorry, this email address is not recorded in our system.Try again.");
				}
				
			}
			
		}
		
	}
	
	function icalender($date = null,$subject = null,$desc = null)
	{ 



$startTime = '1300';
$endTime   = '1400';

 
$ical = "BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//hacksw/handcal//NONSGML v1.0//EN
BEGIN:VEVENT
UID:" . md5(uniqid(mt_rand(), true)) . "example.com
DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z
DTSTART:".$date."T".$startTime."00Z
DTEND:".$date."T".$endTime."00Z
SUMMARY:".$subject."
DESCRIPTION:".$desc."
END:VEVENT
END:VCALENDAR";
 
//set correct content-type-header
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: inline; filename=calendar.ics');
echo $ical;
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
						
						if(!empty($authenticate)) 
						{
							$this->Session->write('Auth.Clients',$authenticate['User']);
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
											$this->redirect(array('controller' => 'candidates', 'action' => 'candidateprofile','Jobseeker'=>true));
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
		if($this->request->data['MASSEMAIL']['list_email']!=''){
			$this->loadModel('NewsletterSubscriber');
			$this->request->data['NewsletterSubscriber']['subscriber_email'] = $this->request->data['MASSEMAIL']['list_email'];
			$this->request->data['NewsletterSubscriber']['created_date'] = date('Y-m-d');
			if($this->NewsletterSubscriber->save($this->request->data))
			{
				$this->Session->write('popup','Thank you for signing up for Newsletters.');
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
						
						$email = new CakeEmail();
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
		if(!empty($SUBMIT))
		{
						// Email configuration
						$sendto = $friendemail;
						$sendfrom = $email;
						//$emailMessage = $this->request->data['MASSEMAIL']['message'];
						$subject = " A friend is sending a e-mail from techexpoUSA.com";
						 						
						if($message){
							$message="Here is your friend's message:<br>
										".$message."";
							}
						
						$bodyText ="
						Hello,<br>your friend with e-mail address: ".$email." thinks that you may benefit from our site, and used our online tool to tell you about our web site: http://www.TechExpoUSA.com.
".$message."
<br>
Regards,

The TECHEXPO Team";
					
						/*$email = new CakeEmail();
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						$ok = $email->send($bodyText); */
						$this->Session->write('popup','mail has been sent successfully!');
						$this->redirect(array('controller'=>'users','action'=>'index'));
						
					
		}
		
	
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
	
	function beforeFilter() 
	{ 
		parent::beforeFilter();
		$this->Auth->autoRedirect = false;
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
			$this->Auth->allow('home','icalender','listSignup','tellaFriend','aboutUs','login','whyAttend','contactUs','exihibitors','forgotpassword','index','city','City','multiplecity','multiplecity2','multiplecity3','privacypolicy');
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
	
	
	
		function beforeRender() 
		{
			
			$this->set('Session',$this->Session);
		}
	
}//end class
?>