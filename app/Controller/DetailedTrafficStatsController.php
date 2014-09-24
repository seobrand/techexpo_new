<?php
App::uses('AppController', 'Controller');
/**
 * DetailedTrafficStats Controller
 *
 * @property DetailedTrafficStats $DetailedTrafficStats
 */
class DetailedTrafficStatsController extends AppController {
    public $components = array('Auth','Session');
    public $layout = "admin";
	var $uses = array('WebStat','ApplyHistory','Registration','EmployerSet','Employer','CustomEmployerSet','CustomEmployerSet','EmployerStat','JobPosting','Resume','Candidate','Folder','FolderContent','ResumeAccessStat','OfccpTracking','ShowEmployer','ShowCompanyProfile','ShowInterview','TrialAccount');

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
        $this->set('meta_title','Detailed Traffic Stats');
		$errorsArr = '';

		if($this->request->is('post')){
			//pr($this->request->data);
			$today_dt = date('Y-m-d');
			$start_dt = $this->request->data['DetailedTraffic']['start_dt'];
			$period = $this->request->data['DetailedTraffic']['period'];
			$time_units = $this->request->data['DetailedTraffic']['time_units'];
			$end_dt = strtotime( '+'.$period.' '.$time_units.'' , strtotime ($start_dt));
			$end_dt = date ('Y-m-d' , $end_dt);
			$date1 = new DateTime($start_dt);
			$date2 = new DateTime($end_dt);
			$interval = $date1->diff($date2);
			$numdays = $interval->days;
			$numweeks = ceil($numdays/7);
			$nummonths = ceil($numdays/31);
			
			$summerize = $this->request->data['DetailedTraffic']['summarize'];
			$this->set('summerize',$summerize);
			$this->set('numdays',$numdays);
			$this->set('numweeks',$numweeks);
			$this->set('nummonths',$nummonths);
			
			// check dates validation
			if($start_dt==''){
				$errorsArr['start_dt'][0] = 'Plese select start date from you want statistics';
			}elseif($end_dt==''){
				$errorsArr['start_dt'][0] = 'Please enter time length to you want statistics';
			}elseif($start_dt > $today_dt){
				$errorsArr['start_dt'][0] = 'The start date for the statistics cannot be greater than today date';
			}elseif($summerize=='ww' && $time_units=='day' && $period<7){
				$errorsArr['start_dt'][0] = 'When entering the time period in days and summarizing the results by week, the number of days must be at least equal to 7 (1 week long).';
			}elseif($summerize=='m' && $time_units=='day' && $period<31){
				$errorsArr['start_dt'][0] = 'When entering the time period in days and summarizing the results by month, the number of days must be at least equal to 31 (1 month long).';
			}elseif($summerize=='m' && $time_units=='week' && $period<5){
				$errorsArr['start_dt'][0] = 'When entering the time period in weeks and summarizing the results by month, the number of weeks must be at least equal to 5 (1 month long, or 31 days).';
			}elseif($summerize=='m' && $time_units!='month'){
				$errorsArr['start_dt'][0] = 'When summarizing by months, you must also select the length of your time period in months.';
			}elseif($period<1){
				$errorsArr['start_dt'][0] = 'The time period, regardless of which units it is expressed in, must be at least equal to 1.';
			}
			
			if($errorsArr){
				$this->Set('errors',$errorsArr);
				$this->set('data',$this->request->data);
			}
			// dates validations end

			if(!$errorsArr){
				$this->set('showstat','showStatistics');
				$this->set('start_dt',$start_dt);
				$this->set('end_dt',$end_dt);
						
				// Get total Number of pages viewed:
				$condition1 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."'";
				$stats1 = $this->WebStat->find('all',array('fields'=>array('count(viewdate) as cnt','viewdate'),'conditions'=>$condition1,'group'=>array('viewdate'),'order'=>array('cnt DESC')));
				$this->set('get_page_views',$stats1);
				//pr($stats1);
				$total_pv = 0;
				foreach($stats1 as $statPV){
					$total_pv = $total_pv + $statPV[0]['cnt'];
				}	
				$this->set('total_pv',$total_pv);
				
				// Get total Number of Member Logins (employers and job seekers combined):
				$condition2 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."' AND (WebStat.pagename ='login.cfm' OR WebStat.pagename ='/login')";
				$stats2 = $this->WebStat->find('all',array('fields'=>array('count(viewdate) as cnt','viewdate'),'conditions'=>$condition2,'group'=>array('viewdate'),'order'=>array('cnt DESC')));
				$this->set('get_logins',$stats2);
				
				$total_lg = 0;
				foreach($stats2 as $statLG){
					$total_lg = $total_lg + $statLG[0]['cnt'];
				}	
				$this->set('total_lg',$total_lg);
				
				// Get total Number of resources exhibitor
				$condition3 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."' AND (WebStat.pagename ='emp_affiliates.cfm' OR WebStat.pagename ='/empexhibitor')";
				$stats3 = $this->WebStat->find('all',array('fields'=>array('count(viewdate) as cnt','viewdate'),'conditions'=>$condition3,'group'=>array('viewdate'),'order'=>array('viewdate')));
				$this->set('get_exh_res',$stats3);
				
				$total_er = 0;
				foreach($stats3 as $statER){
					$total_er = $total_er + $statER[0]['cnt'];
				}	
				$this->set('total_er',$total_er);
				
				// Get total Number of Resume Views:
				$condition4 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."' AND (WebStat.pagename like 'emp_display_resume%' OR WebStat.pagename = '/showResume' OR WebStat.pagename = '/showRegisterResume')";
				$stats4 = $this->WebStat->find('all',array('fields'=>array('count(viewdate) as cnt','viewdate'),'conditions'=>$condition4,'group'=>array('viewdate'),'order'=>array('cnt DESC')));
				$this->set('get_res_views',$stats4);

				$total_rv = 0;
				foreach($stats4 as $statRV){
					$total_rv = $total_rv + $statRV[0]['cnt'];
				}	
				$this->set('total_rv',$total_rv);
				
				// Get total Number of get_job_views
				$condition5 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."' AND (WebStat.pagename like 'show_display_posting%' OR WebStat.pagename = '/jobdetail' OR WebStat.pagename = '/Jobseeker_jobDetail')";
				$stats5 = $this->WebStat->find('all',array('fields'=>array('count(viewdate) as cnt','viewdate'),'conditions'=>$condition5,'group'=>array('viewdate'),'order'=>array('cnt DESC')));
				$this->set('get_job_views',$stats5);
				
				$total_jv = 0;
				foreach($stats5 as $statJV){
					$total_jv = $total_jv + $statJV[0]['cnt'];
				}	
				$this->set('total_jv',$total_jv);
				
				// Get total Number of Job applications
				$condition6 = "ApplyHistory.dt>='".$start_dt."' AND ApplyHistory.dt<='".$end_dt."'";
				$stats6 = $this->ApplyHistory->find('all',array('fields'=>array('count(dt) as cnt', 'dt'),'conditions'=>$condition6,'group'=>array('dt'),'order'=>array('cnt DESC')));
				$this->set('get_job_apps',$stats6);

				$total_ja = 0;
				foreach($stats6 as $statJA){
					$total_ja = $total_ja + $statJA[0]['cnt'];
				}	
				$this->set('total_ja',$total_ja);
				
				// Get total Number of Show registration
				$condition7 = "Registration.date_time>='".$start_dt."' AND Registration.date_time<='".$end_dt."'";
				$stats7 = $this->Registration->find('all',array('fields'=>array('count(date_time) as cnt', 'date_time'),'conditions'=>$condition7,'group'=>array('date_time'),'order'=>array('cnt DESC')));
				$this->set('get_show_regs',$stats7);

				$total_sr = 0;
				foreach($stats7 as $statSR){
					$total_sr = $total_sr + $statSR[0]['cnt'];
				}	
				$this->set('total_sr',$total_sr);
				
				// Get total Number of NEW candidate profiles submitted:
				$condition8 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."' AND (WebStat.pagename = 'cand_profile.cfm?new=1' OR WebStat.pagename ='/register')";
				$stats8 = $this->WebStat->find('all',array('fields'=>array('count(viewdate) as cnt','viewdate'),'conditions'=>$condition8,'group'=>array('viewdate'),'order'=>array('cnt DESC')));
				$this->set('get_new_cands',$stats8);
				
				$total_nc = 0;
				foreach($stats8 as $statNC){
					$total_nc = $total_nc + $statNC[0]['cnt'];
				}	
				$this->set('total_nc',$total_nc);
				
				// Get total Number of candidate profile updates:
				$condition9 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."' AND (WebStat.pagename='cand_profile.cfm' OR WebStat.pagename= '/Jobseeker_editprofile')";
				$stats9 = $this->WebStat->find('all',array('fields'=>array('count(viewdate) as cnt','viewdate'),'conditions'=>$condition9,'group'=>array('viewdate'),'order'=>array('cnt DESC')));
				$this->set('get_upd_cands',$stats9);

				$total_unc = 0;
				foreach($stats9 as $statUNC){
					$total_unc = $total_unc + $statUNC[0]['cnt'];
				}	
				$this->set('total_unc',$total_unc);
				
				// Get total Number of Member Logins (employers and job seekers combined):
				$condition11 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."'";
				$stats11 = $this->WebStat->find('all',array('fields'=>array('distinct(ip)'),'conditions'=>$condition11,'group'=>array('viewdate'),'order'=>array('viewdate')));
				$this->set('get_unique_visitors',$stats11);
				
				
				// Get total Number get_referrer_traffic
				/*$condition12 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."' AND WebStat.referrer not like '%techexpousa%'
AND WebStat.referrer not like '%tech-expo%' AND LENGTH(WebStat.referrer) > 10";*/
				$condition12 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."' AND WebStat.referrer not like '%techexpo%'
AND WebStat.referrer not like '%techexpo_new%' AND LENGTH(WebStat.referrer) > 10";
				$stats12 = $this->WebStat->find('all',array('fields'=>array('count(referrer) as cnt4','referrer'),'conditions'=>$condition12,'group'=>array('referrer'),'order'=>array('cnt4 DESC')));
				$this->set('get_referrer_traffic',$stats12);
				
				// Get total Number of Member Logins (employers and job seekers combined):
				$condition13 = "WebStat.viewdate>='".$start_dt."' AND WebStat.viewdate<='".$end_dt."' AND WebStat.pagename like 'index_%'
AND WebStat.pagename!='index.cfm'";
				$stats13 = $this->WebStat->find('all',array('fields'=>array('count(pagename) as cnt5','pagename'),'conditions'=>$condition13,'group'=>array('pagename'),'order'=>array('cnt5 DESC')));
				$this->set('get_referrer_traffic2',$stats13);

			}
			
					
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
		$this->Auth->loginRedirect = array('controller' => 'EmployerSiteUsages', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');		
   	}
	
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
