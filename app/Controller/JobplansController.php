<?php
App::uses('AppController', 'Controller');
/**
 * JobPlans Controller
 *
 * @property JobPlans $JobPlans
 */
class JobplansController extends AppController {
   	var $name = 'Jobplans'; //Model name attached with this controller 
	var $helpers = array('Html','Paginator','Ajax','Javascript','Text'); //add some other helpers to controller
	var $components = array('Auth','common','Session','Cookie','RequestHandler','Captcha','Email','Paypal','usaepay');  //add some other component to controller . this component file is exists in app/controllers/components
	var $layout = 'front'; //this is the layout for admin panel 
	public $uses = array("Employer","Jobplan","JobplanHistory");
/**
 * superadmin_index method
 *
 * @return void
 */
	public function index() {
        $this->set('meta_title','Job Plans');
		$errorsArr = '';
		$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
		
		$this->loadModel('SystemVariable');
		$systemVar = $this->SystemVariable->find('first',array('conditions'=>array('variable_name'=>'USAepay Source key'),'fields'=>array('variable_value')));
			
		if($this->request->is('get')){
			$condition = "Jobplan.is_active = 'y' AND (FIND_IN_SET('".$employerID."', Jobplan.available_for) OR Jobplan.available_for='all')";
			$jobplans = $this->Jobplan->find('all',array('conditions'=>$condition,'order'=>array('price ASC')));
			$this->set('jobplans',$jobplans);
		}elseif($this->request->is('post')){
		
		
			$planID = $this->request->data['JobPlan']['planID'];
			$planData = $this->Jobplan->find('first',array('conditions'=>array('id'=>$planID)));
			
			
			$this->set('plan_price',$planData['Jobplan']['price']);
			$this->set('planID',$planData['Jobplan']['id']);
			$this->set('plan_jobs',$planData['Jobplan']['jobs']);
			$this->set('getProfileInfo',true);
			
			if(isset($this->request->data['JobPlan']['card_number']) && $this->request->data['JobPlan']['card_number']!=''){
				
				$employerID = $this->Session->read('Auth.Client.employerContact.employer_id');
			
				if($this->request->data['JobPlan']['state']!=''){
					$state = $this->request->data['JobPlan']['state'];
				}else{
					$state = $this->request->data['JobPlan']['state_us'];
				}
				
				// Send request to sandbox server not production.  Make sure to comment or remove this line before
				//  putting your code into production
				//$tran->usesandbox=true;
				
				// Merchants Source key must be generated within the console
				$this->usaepay->key			=	$systemVar['SystemVariable']['variable_value'];//"Kd4fSB8Gfw3wnq372CF1F389Ds16h47z";
				$year 						= 	date("y",strtotime($this->request->data['JobPlan']['exp_year']['year']."-01-01"));
				$this->usaepay->card 		=	trim($this->request->data['JobPlan']['card_number']);
				$this->usaepay->exp			=	trim($this->request->data['JobPlan']['exp_month']['month']).$year;
				$this->usaepay->amount 		=	trim($planData['Jobplan']['price']);
				$this->usaepay->invoice		=	"1234";
				$this->usaepay->cardholder	=	trim($this->request->data['JobPlan']['first_name'])." ".trim($this->request->data['JobPlan']['last_name']);
				$this->usaepay->street		=	trim($this->request->data['JobPlan']['billing_address1']);
				$this->usaepay->zip			=	trim($this->request->data['JobPlan']['zip_code']);
				$this->usaepay->description	=	"Job Plan Purchasing for TechExpoUSA.com";
				$this->usaepay->cvv2		=	trim($this->request->data['JobPlan']['cvv_number']);
				
						
				// check for payment process
				if($this->usaepay->Process())
				{
					if($this->request->data['JobPlan']['planID']){
						if($this->Employer->updateAll(array('Employer.max_jobs' => 'Employer.max_jobs+'.$this->request->data['JobPlan']['jobs'].''), array('Employer.id' => $employerID))){
							// Insert data into jobplan history
							$jobplanData = array('JobplanHistory'=>array('employer_id'=>$employerID,'jobplan_title'=>$planData['Jobplan']['title'],'jobplan_price'=>$planData['Jobplan']['price'],'jobplan_jobs'=>$planData['Jobplan']['jobs'],'cc_firstname'=>$this->request->data['JobPlan']['first_name'],'cc_lastname'=>$this->request->data['JobPlan']['last_name'],'cc_type'=>$this->request->data['JobPlan']['cc_type'],'order_date'=>date("Y-m-d")));
							$this->JobplanHistory->save($jobplanData);
							$this->Session->write('popup','Your Payment has been done successfully. '.$this->request->data['JobPlan']['jobs'].' Jobs added in your account.');
						}
					}				
					$this->redirect(array('controller'=>'employers','action'=>'dashboard'));
										
				} else {
				
				
					$message = "<b>Card Declined</b> (" . $this->usaepay->result . ")<br>";
					$message .= "<b>Reason:</b> " . $this->usaepay->error . "<br>";
					if($this->usaepay->curlerror) $message .= "<b>Curl Error:</b> " . $this->usaepay->curlerror . "<br>";
					$this->Session->write('popup',$message);
					//$this->redirect($this->referer());
					
					$this->set('plan_price',$planData['Jobplan']['price']);
					$this->set('getProfileInfo',true);
				}
				
			}
			
		}		
		
	}
	
	
	function beforeFilter() 
	{ 
		parent::beforeFilter();
		
		$usertype=$this->Session->read('Auth.Clients.user_type');
		if($usertype=='E')
		{
			$this->Auth->allow('*');
		}else
		{
			$this->Auth->allow('profile','jobdetail','emailjob','eventregistrationform','recruitattechexpo');
		}
   	}

	
}