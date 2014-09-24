<?php
/**************************************************************************
 Coder  : Jitendra Pradhan  
 Object : Controller to registration process of client
**************************************************************************/ 

class BannerReportsController extends AppController {
	var $name = 'BannerReports'; /*Model name attached with this controller*/ 
	var $layout = 'admin'; /*this is the layout for front panel*/ 
	var $components = array('Auth','common','Session','Cookie','Email','RequestHandler');
	var $uses = array('Banner','BannerCategory');
	
	/******* Function for manage banners *********/
	public function superadmin_index($btid=null){
			$this->set('meta_title',' Banner Reports Management');
			
			$options['joins'] = array(
				array('table' => 'category',
					'alias' => 'BannerCategory',
					'type' => 'inner',
					'conditions' => array(
						"BannerCategory.id = Banner.category_link"
					)
				),
				array('table' => 'performance',
					'alias' => 'Performance',
					'type' => 'LEFT',
					'conditions' => array(
						"Banner.id = Performance.ad_id"
					)
				)
			);
			
 			if($btid!=NULL){
				$options['conditions'] = array("Banner.category_link = '".$btid."' and Banner.category_link !='4' ");
			}
			else
			$options['conditions'] = array(" Banner.category_link !='4' ");
			
			$options['fields'] = array('DISTINCT Banner.id, Banner.name, Banner.filename, Banner.href, Banner.alt, BannerCategory.id,BannerCategory.category_name, sum(Performance.loads) as totalloads, sum(Performance.clickthru) as totalclicks');
			$options['group'] = array('Banner.id, Banner.name, Banner.filename, Banner.href, Banner.alt, BannerCategory.id, BannerCategory.category_name');
			$options['order'] = array('Banner.name');
			$rec = $this->Banner->find('all', $options);
			$this->set('rec',$rec);
		
	}
	
		
	function beforeFilter() { 
		parent::beforeFilter();
        $this->Auth->fields = array(
            'username' => 'username', 
            'password' => 'password'
            );
			
        if($this->Session->check('Auth.User.Adminuser.id'))
		{
			$this->Auth->allow('*');
		}else
		{
			//$this->Auth->allow('superadmin_deletetrialaccount');
		}
        
		$this->Session->delete('Auth.redirect');
		$this->Auth->userModel = 'Adminuser';
		$this->Auth->loginAction = array('controller' => 'adminusers', 'action' => 'login','superadmin'=>true);
		$this->Auth->loginRedirect = array('controller' => 'trainingschools', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminclient.active' => 'yes');
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	}  
	

}