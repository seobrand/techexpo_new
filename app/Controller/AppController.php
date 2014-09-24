<?php

App::uses('Controller', 'Controller');


class AppController extends Controller {
    
	var $helpers = array('Form', 'Html', 'Session', 'Js','Number');
	 public $components = array('common');
	 
	 
	function admin_setCss($id) {
		$this->Cookie->delete('css_name');
		if($this->params['pass'][0]=='0'){
		   $this->Cookie->write('css_name','theme',false);
		   $this->redirect(array('action' => $this->params['pass'][1]));
		}else{
		   $this->Cookie->write('css_name','theme'.$this->params['pass'][0],false);
		   $this->redirect(array('action' => $this->params['pass'][1]));
		}
	}
	/* Function beforeFilter execute before controller logic work */
	function beforeFilter() {
		
	/*	$userType=$this->Session->read('Auth.Clients.user_type');
			if($userType=='C')
			{
				$this->redirect(array('controller'=>'users','action'=>'index','Jobseeker'=>false));
			}*/
	
		$this->set('currentURL',Router::url($this->here,true));
		$this->set('common',$this->common);
		
		$ipBlockValue =$this->common->CheckBlockIp();
		
		if($ipBlockValue==true)
		{
		echo "<h1>You are currently blocked on this site .Contact to site administrator</h2>";die;
		}
		
		
	}
	/* Function beforeFilter end */
	/* Function beforeRender execute before controller design view render */
	function beforeRender() {
		$this->_setErrorLayout();
		
	}
	
	function _setErrorLayout()
	{
		if ($this->name == 'CakeError') 
		{
			if($this->params->prefix=='superadmin')
			{
				$this->layout = 'admin-eror';
			}else
			{
				$this->layout = 'error';
			}
		}
	}
	
	
	/* Download function path if folder any folder in img path */
	function downloadFile($folder,$fielname)	{
		
		
		$this->autoLayout = false;
		$newFileName = $fielname;
		$folder = str_replace('-','/',$folder);
		//Replace - to / to view subfolder
	    $path =  WWW_ROOT.$folder.'/'.$fielname;
		
		if(file_exists($path) && is_file($path)) {	
		
			$mimeContentType = 'application/octet-stream';
			$temMimeContentType = $this->_getMimeType($path); 
			if(isset($temMimeContentType)  && !empty($temMimeContentType))	{ 
							$mimeContentType = $temMimeContentType;
			}
	
			// START ANDR SILVA DOWNLOAD CODE
			// required for IE, otherwise Content-disposition is ignored
			if(ini_get('zlib.output_compression'))
			  	ini_set('zlib.output_compression', 'Off');
			header("Pragma: public"); // required
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private",false); // required for certain browsers 
			
			if($folder=="ShowsDocument/ics")
			{
				header("Content-Type: text/Calendar " );
			}
			else
			{
				header("Content-Type: " . $mimeContentType );
			}
			
	
			
			// change, added quotes to allow spaces in filenames, by Rajkumar Singh
			header("Content-Disposition: attachment; filename=\"".(is_null($newFileName)?basename($path):$newFileName)."\";" );
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($path));
			
			readfile($path);
			exit();
			// END ANDR SILVA DOWNLOAD CODE												
		 }
		 if(isset($_SERVER['HTTP_REFERER'])) {
		 	 $this->Session->setFlash('File not found.');
			 $this->redirect($_SERVER['HTTP_REFERER']);
		 }	 
 	}
	
	function _getMimeType($filepath) {
		ob_start();
		system("file -i -b {$filepath}");
		$output = ob_get_clean();
		$output = explode("; ",$output);
		if ( is_array($output) ) {
			$output = $output[0];
		}
		return $output;
	}
	/* Function to generate dynamic image */
	function generateImage($text)  {
	    $this->autoRender = false;
	    //$this->layout='ajax';
	    if(!isset($this->Createimage))   { //if Component was not loaded throug $components array()
	        App::import('Component','Createimage'); //load it
	        $this->Createimage = new CreateimageComponent(); //make instance
	        $this->Createimage->startup($this); //and do some manual calling
	    }
	    $width = isset($_GET['width']) ? $_GET['width'] : '230';
	    $height = isset($_GET['height']) ? $_GET['height'] : '16';
	    //$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
	    //$this->Captcha->create($width, $height, $characters); //options, default are 120, 40, 6.
	    $this->Createimage->create($width,$height,$text);
	}
  /* Check login both client or candidate or both */
  function checkLogin($usertype = 'either') {
  	 if($usertype =='either') {
	    if($this->Session->check('Auth.User.id')) {
		  return $this->Session->read('Auth.User.id');
		}
	    if($this->Session->check('Auth.Client.id')) {
		  return $this->Session->read('Auth.Client.id');
		}
	 }
	 if($usertype =='client') {
	 	return $this->Session->read('Auth.Client.id');
	 }
	 if($usertype =='candidate' || $usertype =='user') { //For candidate
	 	return $this->Session->read('Auth.User.id');
	 }
	 return false;
  }	
  /* Funcion to calculate week number on basis of financial year 01 April to 31 March 
   $param : $day : of the day ( like 5)
   $param : $month : Month of the day. ( like 4 )
   $param : $year : Year of the date (like 2011)
 
  */

 function calculate_weekno($startDate,$endDate,$holidays)
    
	{
    $days = (strtotime($endDate) - strtotime($startDate)) / 86400 + 1;
    $no_full_weeks = floor($days / 7);
    
    //$date = strtotime(date("Y-m-d", strtotime($date)) . " +1 day");
	
	
  $the_first_day_of_week = date("N",strtotime($startDate)); 
  
  
   if($the_first_day_of_week == 1) {  
   
		return $no_full_weeks+1;		
		}
		 else {
			$diff =  intval(7)-intval($the_first_day_of_week);
			
			$diff = $diff + 2;
			$startDate = strtotime(date("Y-m-d", strtotime($startDate)) . " +".$diff." day");
			
			//echo date('Y-m-d', $startDate).'<br />';
			$days = (strtotime($endDate) - $startDate) / 86400 + 1;
    		$no_full_weeks = floor($days / 7);
			return $no_full_weeks+2;	
		 }
    }	
	
	
	
	
	function showCaptchImage() {
		$width = isset($_GET['width']) ? $_GET['width'] : '120';
		$height = isset($_GET['height']) ? $_GET['height'] : '40';
		$characters = isset($_GET['characters']) && $_GET['characters'] > 1 ? $_GET['characters'] : '6';
		APP::import('Component','CaptchaSecurityImages');
		echo $captcha = new CaptchaSecurityImagesComponent($width,$height,$characters);
	}
	/* Function to generate captcha code */
	function captcha()  {
	    $this->autoRender = false;
	   
	    if(!isset($this->Captcha))   { //if Component was not loaded throug $components array()
	        App::import('Component','Captcha'); //load it
	        $this->Captcha = new CaptchaComponent(); //make instance
	        $this->Captcha->startup($this); //and do some manual calling
	    }
	    
	    $this->Captcha->create();
	}	
	
	
	function isJobSeekerLogin()  // login chek  for user
		{ 
			$userType=$this->Session->read('Auth.Clients.user_type');
			if($userType!='C')
			{
				$this->redirect(array('controller'=>'users','action'=>'index','Jobseeker'=>false));
			}
		}
	
	function isEmployerLogin()  // login chek  for user
		{ 
			$userType=$this->Session->read('Auth.Clients.user_type');
			if($userType!='E')
			{
				$allow=array('profile','jobdetail','emailjob','eventregistrationform','recruitattechexpo','empexhibitor','city','empshowVideo','showVideo','viewprofile','empcotactcity','partners');
				$currentAction=$this->params->action;
				if(in_array($currentAction,$allow))
				{
				}else
				{
					$this->redirect(array('controller'=>'users','action'=>'index','Jobseeker'=>false));
				}
			}
		}
	
	

	
}
