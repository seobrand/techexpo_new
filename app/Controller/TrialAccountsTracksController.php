<?php
App::uses('AppController', 'Controller');
/**
 * HomepageMessages Controller
 *
 * @property HomepageMessage $HomepageMessage
 */
class TrialAccountsTracksController extends AppController {
    public $components = array('Auth');
    public $layout = "admin";

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index() {
            $this->set('meta_title','Trial Account Track');
		$this->TrialAccountsTrack->recursive = 0;
		$this->set('trialAccountTracks', $this->paginate());
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
		$this->Auth->loginRedirect = array('controller' => 'trialAccountsTracks', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');
		
   	}
	/* This function is setting all info about current SuperAdmins in  currentAdmin array so we can use it anywhere lie name id etc.*/
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
}
