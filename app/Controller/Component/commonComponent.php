<?php
/**************************************************************************
 Coder  : Pushkar
 Object : Component for common functions
**************************************************************************/ 
class commonComponent extends Component {
	var $components = array('Auth','Session');
	var $catArr 	= array();
	/** Function to get time stamp in unix timestamp format **/
	function getTimeStamp() {
		return mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
	}  
	/** Function to get time stamp after years
	 @param int - number of year default is 1
	 return timestamp after some year  ***/
	function getTimeStampAfterYear($years=1) {
		return mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y')+$years);
	} 
	/* Function to get time stamp after some time or days or month letter */
	function getTimeStampLaterDates($days=0,$months=0,$years=0) {
		return mktime(date('H'),date('i'),date('s'),date('m')+$months,date('d')+$days,date('Y')+$years);
	}   
	/*** Create a random string
	 * @param	int $length - length of the returned number
	 * @return	string - string ***/
	function randomString($length = 8)	{
		$pass = "";
		// possible password chars.
		$chars = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
			   "k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
			   "u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
		for($i=0 ; $i < $length ; $i++) {
			$pass .= $chars[mt_rand(0, count($chars) -1)];
		}
		return $pass;
	}
	/* Function to find time stamp according to date format */
	function timeStampByDate($date,$format= 'm-d-Y',$seprator='-') {
		$timeStamp  = '';
		$formatArr  =  preg_split("/[\s-:\/,]+/", strtolower($format)); 
		$formatArr  = array_flip($formatArr);
		$dArr 		= preg_split("/[\s-:\/,]+/", $date); 
		if(isset($dArr[0]) && isset($dArr[1]) && isset($dArr[2]) ) {
			$timeStamp = mktime(date('H'),date('i'),date('s'),$dArr[$formatArr['m']],$dArr[$formatArr['d']],$dArr[$formatArr['y']]);
		}
		return $timeStamp;
	}
	/*** Function to make a alias of any string
	 * @param	string  $data is string 
	 * @return	string - string ***/
	function makeAlias($data){
		$string_alias = trim($data);
		$string_alias = preg_replace('/\W/', ' ', $string_alias);
		// replace all white space sections with a dash
		$string_alias = preg_replace('/\ +/', '-', $string_alias);
		// trim dashes
		$string_alias = preg_replace('/\-$/', '', $string_alias);
		$string_alias = preg_replace('/^\-/', '', $string_alias);
		$string_alias = strtolower($string_alias);
		return $string_alias;
	}
	/*** function for uploading image 
	 * uploads files to the server
	 * @params:
	 *		$folder 	= the folder to upload the files e.g. 'img/files'
	 *		$formdata 	= the array containing the form files
	 *		$itemId 	= id of the item (optional) will create a new sub folder
	 * @return:	will return an array with the success of each file upload
	 */
	 
	 
	 
	function uploadFiles($folder, $formdata, $itemId = null) {
		// setup dir names absolute and relative
		$result = array();
		$folder_url = WWW_ROOT.$folder; 
		 $rel_url = $folder;
		// create the folder if it does not exist
		if(!is_dir($folder_url)) {
			mkdir($folder_url);
		}
		// if itemId is set create an item folder
		if($itemId) {
			// set new absolute folder
			$folder_url = WWW_ROOT.$folder.'/'.$itemId; 
			// set new relative folder
			$rel_url = $folder.'/'.$itemId;
			// create directory
			if(!is_dir($folder_url)) {
				mkdir($folder_url);
			}
		}
	// list of permitted file types, this is only images but documents can be added
	$permitted = array('image/gif','image/jpeg','image/jpg','image/pjpeg','image/png','image/x-png','image/tif','image/tiff');
	
	
	$file=$formdata;
	
	
	// loop through and deal with the files
	foreach($formdata as $file) {
	  
		// replace spaces with underscores
		
		$fileNaArr 		=  explode('.',$file['name']);
		
		$origFileName 	= $fileNaArr[0];
		$fileExt 		= end($fileNaArr);
		$filename 		= $this->makeAlias($origFileName).'.'.$fileExt; //str_replace(' ', '_', $file['name']);
		// assume filetype is false
		$typeOK = false;
		foreach($permitted as $type) {
			if($type == $file['type']) {
				$typeOK = true;
				break;
			}
		}

		// if file type ok upload the file
		if($typeOK) {
			// switch based on error code
			switch($file['error']) {
			  case 0:
					// create unique filename and upload file
					//ini_set('date.timezone', 'Europe/London');
					//$now      = $this->getTimeStamp();
					$now = microtime(true)*10000;
					//$filename = $this->makeAlias($filename);
					$full_url = $folder_url.'/'.$now.$filename;
					
					//$newfilepath = $now.'-'.$filename;
					$newfilepath = $filename;
					$url      = $rel_url.'/'.$newfilepath;
					$success  = move_uploaded_file($file['tmp_name'], $url);
				// if upload was successful
				if($success) {
					// save the url of the file
					$result['urls'][] = $newfilepath;
				} else {
					$result['errors'][] = "Error uploaded $filename. Please try again.";
				}
				break;
			case 3:
				// an error occured
				$result['errors'][] = "Error uploading $filename. Please try again.";
				break;
			default:
				// an error occured
				$result['errors'][] = "System error uploading $filename. Contact webmaster.";
				break;
			}
		} 
		else if($file['error'] == 4) {
			// no file was selected for upload
			$result['nofiles'][] = "No file Selected";
		} 
		else {
			// unacceptable file type
			$result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
		}
	}
		return $result;
	}
	/* Generate n random number */
	function generateRandNum($num=1,$prefix='',$postfix='') {
		for($i=0;$i<$num;$i++) {
			$mktime = $this->getTimeStamp();
			$rand   =  rand(1000,9999);
			$randArr[] = $prefix.$mktime.$rand.$postfix; 
		} 
		return $randArr;
	}
  /* Function to get shpping frequncy */
	function getShippingFrequency() {
		APP::import('Model','Shippingfrequency');
		$this->Shippingfrequency = new Shippingfrequency(); 
		return $this->Shippingfrequency->find('list',array('conditions'=>array('publish'=>'yes'),'fields'=>array('id','shippingfrequency_name')));
	}	
	/* Function to get Business size */
	function getBusinesssize() {
		APP::import('Model','Businesssize');
		$this->Businesssize = new Businesssize(); 
		return $this->Businesssize->find('list',array('conditions'=>array('publish'=>'yes'),'fields'=>array('id','businesssize_name')));
	}	
	
	/* Function to get entity type */
	function getEntitytype() {
		APP::import('Model','Entity');
		$this->Entity = new Entity(); 
		return $this->Entity->find('list',array('conditions'=>array('publish'=>'yes'),'fields'=>array('id','entity_name')));
	}	
	/* Function to get entity type */
	function getBussinesstype() {
		APP::import('Model','Businesstype');
		$this->Businesstype = new Businesstype(); 
		return $this->Businesstype->find('list',array('conditions'=>array('publish'=>'yes'),'fields'=>array('id','businesstype_name')));
	}
	/* Function to get fund for user */
	function getUserFund($userId,$checkAmount=0) {
	 APP::import('Model','Fund');
	 $this->Fund = new Fund();
	 $condition['Fund.user_id'] = $userId;
	 if($checkAmount) {
	 	$condition['Fund.amount  >='] = $checkAmount; 
	 }
	 return $this->Fund->find('first',array('conditions'=>$condition,'fields'=>array('Fund.id','Fund.amount')));
	
	}
	//deduct payent from user and accunt and return true on success
	function deductPayment($userId,$fundId,$deductAmount,$totalFund) {
		APP::import('Model','Fund');
		$this->Fund = new Fund();		
		$fundUpdateArr['Fund']['id'] 		= $fundId;
		$fundUpdateArr['Fund']['user_id'] 	= $userId;
		$fundUpdateArr['Fund']['amount'] 	= $totalFund-$deductAmount; 
		if($this->Fund->save($fundUpdateArr)) {
		   return true;
		}
		else {
		   return false;
		}
	}
	/* Function to return common seprated string */
	function arrayToCsvString($arr) {
	 	$csvStr = '';
		if(is_array($arr)) {
		  $arr = array_unique($arr);
		  foreach($arr as $val) {
			if($val) {
				$csvStr .= ($csvStr) ? ',' : '';
				$csvStr .= $val ;
			 }	
		  }
		}
	  else {
	  	$csvStr = $arr;
	  }	
	  return $csvStr;		
	}
	/* Function to get country list */
	function getCountryList() {
		APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'order'=>array('code_id'),
													'conditions'=>array('code_name'=>'Country','visible'=>'Y','code_descr!="Country"'),
													'order'=>'Code.sort_order asc'));
	}
	
	/* Function to get military services list */
	function getMilitaryList() {
		APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'order'=>array('code_id'),
													'conditions'=>array('code_name'=>'Military Service','visible'=>'Y','code_descr!="Military Service"'),
													'order'=>'Code.sort_order asc'));
	}	
	
	
	
	
	
	 
	/* Function to get region/state/provinces list */
	function getRegionList($country_id) {
		APP::import('Model','Region');
		$this->Region = new Region(); 
		return $this->Region->find('list',array('conditions'=>array('country_id'=>$country_id),'fields'=>array('id','name'),'order'=>array('name')));
	}
	/* Function to get city list */
	function getCityList($state_code) {
		APP::import('Model','City');
		$this->City = new City();
		
		return	$cityList=$this->City->find('list',array('conditions'=>'state_code="'.$state_code.'"','fields'=>'city,city','order by city ASC'));
				

	}
	/********* Function to get city name ************/
	function getCityName($city_id) {
		APP::import('Model','City');
		$this->City = new City();
		if($city_id) {
		  return $this->City->field('name',array('id'=>$city_id)); 
		}
	   return false;	
	}
	/********* Function to get Region/Provinces name ************/
	function getRegionName($region_id) {
		APP::import('Model','Region');
		$this->Region = new Region();
		if($region_id) {
		  return $this->Region->field('name',array('id'=>$region_id)); 
		}
	   return false;	
	}
	/********* Function to get Country name ************/
	function getCountryName($country_id) {
		APP::import('Model','Country');
		$this->Country = new Country();
		if($country_id) {
		  return $this->Country->field('name',array('id'=>$country_id)); 
		}
	   return false;	
	}
	//used
	function uploadDocuments($folder, $formdata, $itemId = null) {
		// setup dir names absolute and relative
		$folder_url = WWW_ROOT.$folder; 
		$rel_url = $folder;
		// create the folder if it does not exist
		if(!is_dir($folder_url)) {
			mkdir($folder_url);
		}
		// if itemId is set create an item folder
		if($itemId) {
			// set new absolute folder
			$folder_url = WWW_ROOT.$folder.'/'.$itemId; 
			// set new relative folder
			$rel_url = $folder.'/'.$itemId;
			// create directory
			if(!is_dir($folder_url)) {
				mkdir($folder_url);
			}
		}
	// list of permitted file types, this is only images but documents can be added
	$permitted = array('xls','xlsx','doc','docx','txt','rtf','pdf','odt');
	$permiteed_str = implode(', ', $permitted);
	// loop through and deal with the files
	//pr($formdata);
	foreach($formdata as $file) {
		// replace spaces with underscores
		$fileNaArr 		=  explode('.',$file['name']);
		$origFileName 	= $fileNaArr[0];
		$fileExt 		= end($fileNaArr);
		$filename 		= $this->makeAlias($origFileName).'.'.$fileExt; //str_replace(' ', '_', $file['name']);
		// assume filetype is false
		$typeOK = false;
		if(in_array(strtolower($fileExt),$permitted)) {
		  $typeOK = true;
		}
		/*foreach($permitted as $type) {
			if($type == $file['type']) {
				$typeOK = true;
				break;
			}
		}*/
		// if file type ok upload the file
		if($typeOK) {
			// switch based on error code
			switch($file['error']) {
			  case 0:
					// create unique filename and upload file
					//ini_set('date.timezone', 'Europe/London');
					//$now      = $this->getTimeStamp();
					$now = microtime(true)*10000;
					$filename 		= substr($this->makeAlias($origFileName),0,240).'.'.$fileExt;
					//$filename = $this->makeAlias($filename);
					$full_url = $folder_url.'/'.$filename;
					$newfilepath = $filename;
					$url      = $rel_url.'/'.$newfilepath;
					$success  = move_uploaded_file($file['tmp_name'], $url);
				// if upload was successful
				if($success) {
					// save the url of the file
					$result['urls'][] = $newfilepath;
				} else {
					$result['errors'][] = "Error uploaded $filename. Please try again.";
				}
				break;
			case 3:
				// an error occured
				$result['errors'][] = "Error uploading $filename. Please try again.";
				break;
			default:
				// an error occured
				$result['errors'][] = "System error uploading $filename. Contact webmaster.";
				break;
			}
		} 
		else if($file['error'] == 4) {
			// no file was selected for upload
			$result['nofiles'][] = "No file Selected";
		} 
		else {
			// unacceptable file type
			$result['errors'][] = "$filename cannot be uploaded. Acceptable file types: $permiteed_str.";
		}
	}
		return $result;
	}
	
	/****************** Function to get all parent category by pradeep Saxena******************/
	function getAllCategory(){
	 		App::import('model','Category');
		    $this->Category = new Category();
			$categoryList = $this->Category->find('all', array('fields' => array('id', 'category_name','alias'),'order' => 'Category.category_name ASC','recursive' => -1,'conditions' => array('Category.publish' => 'yes', 'Category.category_parent'=> '0'))); 
             //pr($categoryList);die;
			return $categoryList;
	      }	
	 /* Delete file */
	 function deleteImage($path = 'img/',$uploadFileName) {
	 	$filePath = WWW_ROOT.$path.$uploadFileName;
		if(file_exists($filePath)) {
			@unlink($filePath);
			return true;
		}
		else {
		  return false;
		}
	 }

	/****************** Function to get banners by category :- Pradeep Saxena******************/
	function getFrontBannerToDisplay($cacID = array()){
	 		App::import('model','Banner');
			$bannUserArr = array();
			$catIds = 0;
			if(is_array($cacID)) {
			  $bannUserArr = $cacID;
			}
			else if($bannUserArr) {
			   $bannUserArr[] = $cacID;
			}
			
			if(SHOW_AMDIN_BANNER) {
			   $bannUserArr[] = 0;
			}  
			if(is_array($bannUserArr)) {
			    $catString = implode(',',$bannUserArr);
				$this->Banner = new Banner(); 
				$bannerList = $this->Banner->find('all', array('fields' => array('Banner.id', 'Banner.line_one', 'Banner.graphic', 'Banner.hyperlink', 'Banner.active'),'order' => 'Banner.created ASC','conditions' => array('Banner.active' => 'yes', 'Banner.category_id IN ('.$catString .')'))); 
				 //pr($bannerList);//die;
				return $bannerList;
			}
			return ;
	      }	
		  
	/****************** Function to get banners by category :- Pradeep Saxena******************/
	function make_http_url($get_target_url){
	 		 
		     
				if ($get_target_url != '' && (substr($get_target_url, 0, 7) == 'http://' || substr($get_target_url, 0, 8) == 'https://'))
				 { 
					$target_url =  $get_target_url;
				}
				else
				{
					$target_url = 'http://'. $get_target_url;
				
				}
				return $target_url;
	      }	

		function limit_text( $text, $limit, $succeder='')
		 
		{
		 
		// figure out the total length of the string
		 
		if( strlen($text)>$limit )
		{
		$text = substr( $text,0,$limit );
		// lose any incomplete word at the end
		//$text = substr( $text,0,-(strlen(strrchr($text,' '))) );
		}
		
		// return the processed string
		
		return $text . $succeder;
		
		}

	/*************************** Functon to get all nested category list ***********************************/
	 function allSubcats($parent_id = 0,$publish=1,$returnField='category_name') {
		  static $co=0;
		  $whereCondition = array();
		  if($publish){
			 $whereCondition['Category.publish']= 'yes';
		  }
		  $whereCondition['category_parent']= $parent_id;
		  $orderBy = array('Category.category_order','Category.category_name');
		  $fields =  array('Category.id','Category.category_parent','Category.category_name');
		  $condition = array('conditions'=>$whereCondition,'order'=>$orderBy);
		  APP::import('Model','Category');
		  $this->Category  = new Category();
		  $count = $this->Category->find('count',$condition);
		  if($count) {
			$res = $this->Category->find('all',$condition);
			$space = '';
			for($k=0;$k<$co;$k++) {
			   $space .=" -- ";
			}
			foreach($res as $res1){
				 $result = $res1['Category'];
				 if($result['category_parent']==0) {
					 $co=0;
					 $space = "";
				 }
				$this->catArr[$result['id']] = $result[$returnField]; // Here is $returnField means what we want id or category name
				$co++;
				$this->allSubcats($result['id'],$publish,$returnField); //call recursive
			 }
		 }
		 else {
		   return ;
		 }   
   }
   /* Functioon to get all subcates ids */
     function allCateSubcatListIds($parent_id = 0,$publish=1) {
	    $this->allSubcats($parent_id ,$publish,$returnField='id');
		$arr = $this->catArr;
		$this->catArr = array();
		return $arr;
	 }
	/* Functioon to get all subcates category name with nesting */
     function allCateSubcatListNames($parent_id = 0,$publish=1) {
	    $this->allSubcats($parent_id ,$publish,$returnField='category_name');
		$arr = $this->catArr;
		$this->catArr = array();
		return $arr;
	 }
	 /* Function to get icons of file */
	 function getIconName($fileName) {
	   $extArr = explode('.',$fileName);
	   $ext = end($extArr);
	   switch(strtolower($ext)) {
	   	 case 'pdf' :
		    return 'pdf.jpg';
		 case 'xls' :
		 case 'xlsx' :
		    return 'excel.jpg';
		 case 'ppt' :
		 case 'pptx':
		     return 'power_point.jpg';	
		 case 'doc' :
		 case 'docx' :
		    return 'word.jpg';
		 case 'txt' :
		 case 'rtf' :
		    return 'txt.jpeg';
		 case 'gif' :
		 case 'jpeg' :
		 case 'jpg' :
		 case 'png' :
		    return 'thumb.jpg';
		 default :
		   return 'default.gif'; 
		    				
	   }
	 }
	 /************ Function to get low bid ***********/
	 function getLowShipmentBid($shipment_id) {
	 	APP::import('Model','Bid');
		$this->Bid = new Bid();
		return (float)$this->Bid->field('Min(bid_price)',array('Bid.shipment_id'=>$shipment_id));
	 }
	 /************ Function to get low bid  and counting***********/
	 function getLowBidNCounting($shipment_id) {
	 	APP::import('Model','Bid');
		$this->Bid = new Bid();
		$bidDet = $this->Bid->find('first',array('fields'=>array('COUNT(bid_price) as totalBid','MIN(bid_price) as min_bid_price'),'conditions'=>array('Bid.shipment_id'=>$shipment_id)));
		if(is_array($bidDet[0]) && count($bidDet[0])) {
		   return $bidDet[0];
		}
		else {
		  return array('totalBid'=>0,'min_bid_price'=>0);
		}
	 }
	 
	/* Function to save into inbox */
	function saveInboxMessage($to_user,$to_username,$subject,$body,$from_user=0,$from_username='admin',$project_id=0) {
	//Save mail to inbox 
		$mailToInbox['from_user'] = $from_user;
		$mailToInbox['to_user']	  = $to_user; 
		$mailToInbox['from_status'] = 1;
		$mailToInbox['to_status'] = 1;
		$mailToInbox['to_username'] = $to_username;
		$mailToInbox['from_username'] = $from_username;
		$mailToInbox['message_title'] = strip_tags($subject);
		$mailToInbox['message_contents'] = $body;
		$mailToInbox['message_read'] =1;
		$mailToInbox['project_id'] =$project_id;
		$mailToInbox['admin_id'] =1;
		APP::import('Model','Message');
		$this->Message = new Message();
		$this->Message->save($mailToInbox);
	}
	/*  Save payment order */
	function saveOrder($amount,$receiver_user_id,$sender_user_id,$description,$trns_id,$payment_status='complete') {
		$orderArr['amount'] 		  = $amount;
		$orderArr['receiver_user_id'] = $receiver_user_id;
		$orderArr['sender_user_id']   = $sender_user_id;
		$orderArr['description'] 	  = $description;
		$orderArr['payment_status']   = $payment_status;
		$orderArr['transaction_id']   = $trns_id;
		APP::import('Model','Order');
		$this->Order = new Order();
		$this->Order->save($orderArr);
	}
	/* Check feed back given or not */
    function checkFeedbackStatus($shipment_id,$to_user_id) {
		APP::import('Model','Review');
		$this->Review = new Review();
		$id = $this->Review->field('Review.id',array('Review.shipment_id'=>$shipment_id,'Review.to_user_id'=>$to_user_id));
		if((int)$id) {
			$count =  $this->Review->find('count',array('conditions'=>array('Review.from_user_id'=>$to_user_id,'Review.shipment_id'=>$shipment_id)));
			return !$count;
		}
		return (int)$id;
	}
	/************** Get avg rating of any user *************/
	function userRatingReview($userId) {
		APP::import('Model','Review');
		$this->Review = new Review();
		//$arr['avgRating'] 		= $this->Review->field('AVG(Review.rating)',array('Review.to_user_id'=>$userId));
		//$arr['countReview'] 	= $this->Review->field('COUNT(Review.review)',array('Review.to_user_id'=>$userId));
		$arr = $this->Review->find('first',array('fields'=>array('COUNT(Review.review) as countReview','AVG(Review.rating) as avgRating'),'conditions'=>array('Review.to_user_id'=>$userId)));
		if(isset($arr[0]) && count($arr[0])) {
			return $arr[0];
		}
		return array('avgRating'=>'0','countReview'=>0);
	}
	/*	Convert days into month */
	function daysToMonYearFormat($days) {
	  /*  $str = '';
		if($days > 360) {
		   $str .= ($days/30).' Month ';
		   if 
		}*/
	}
	/*Fucntion to save image from live url */
	function save_image($img,$fullpath){
		$ch = curl_init ($img);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
		$rawdata=curl_exec($ch);
		curl_close ($ch);
		if(!$rawdata) {
		   return false;
		}
		if(file_exists($fullpath)){
			unlink($fullpath);
		}
		$fp = fopen($fullpath,'x');
		fwrite($fp, $rawdata);
		fclose($fp);
		return true;
		
	}
	/* Function to calculate miles between two locations */
	
	  /* Get geocoordinates or latitude and logitude of any address */
	  function getLatLon($address='') {
	     $address = trim($address);
		 $resultArr = array();
	     if($address) {
			$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . GOOGLE_MAP_KEY;
			$request_url = $base_url . "&q=" . urlencode($address);
			$xml = simplexml_load_file($request_url);
			if(!$xml){
			 return $resultArr;
			 }
		
			$status = $xml->Response->Status->code;
			if (strcmp($status, "200") == 0) {
			  // Successful geocode
			  $coordinates = $xml->Response->Placemark->Point->coordinates;
			  $coordinatesSplit = split(",", $coordinates);
			  // Format: Longitude, Latitude, Altitude
			  $resultArr['lat'] = $coordinatesSplit[1];
			  $resultArr['lng'] = $coordinatesSplit[0];
			  return $resultArr;
			} 
  		}
		return $resultArr;
	  }
	  
	 /* Get miles between latitude and longitude address */
	 /* function getDistance($geocoordinates,) {
	    $miles = ( 3959 * acos( cos( radians(37) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(-122) ) + sin( radians(37) ) * sin( radians( lat ) ) ) );
	  }*/
	   function getDistance($lat1, $lng1, $lat2, $lng2, $miles = true) {
	  	 //echo M_PI;
		  $pi80 = M_PI / 180;
		  $lat1 *= $pi80;
		  $lng1 *= $pi80;
		  $lat2 *= $pi80;
		  $lng2 *= $pi80;
		  $r = 6371; // mean radius of Earth in km
		  $dlat = $lat2 - $lat1;
		  $dlng = $lng2 - $lng1;
		  $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
		  $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
		  $km = $r * $c;
		  return ($miles ? ($km * 0.621371192) : $km);
      }
	  //Filtering any string 
	  function remove_HTML($s , $keep = '<p>' , $expand = 'script|iframe|style|noframes|select|option'){
        /**///prep the string
        $s = ' ' . $s;
       
        /**///initialize keep tag logic
        if(strlen($keep) > 0){
            $k = explode('|',$keep);
            for($i=0;$i<count($k);$i++){
          //      $s = str_replace('<' . $k[$i],'[{(' . $k[$i],$s);
          //      $s = str_replace('</' . $k[$i],'[{(/' . $k[$i],$s);
            }
        }
       
        //begin removal
        /**///remove comment blocks
        while(stripos($s,'<!--') > 0){
            $pos[1] = stripos($s,'<!--');
            $pos[2] = stripos($s,'-->', $pos[1]);
            $len[1] = $pos[2] - $pos[1] + 3;
            $x = substr($s,$pos[1],$len[1]);
            $s = str_replace($x,'',$s);
        }
       
        /**///remove tags with content between them
        if(strlen($expand) > 0){
            $e = explode('|',$expand);
            for($i=0;$i<count($e);$i++){
                while(stripos($s,'<' . $e[$i]) > 0){
                    $len[1] = strlen('<' . $e[$i]);
                    $pos[1] = stripos($s,'<' . $e[$i]);
                    $pos[2] = stripos($s,$e[$i] . '>', $pos[1] + $len[1]);
                    $len[2] = $pos[2] - $pos[1] + $len[1];
                    $x = substr($s,$pos[1],$len[2]);
                    $s = str_replace($x,'',$s);
                }
            }
        }
       
        /**///remove remaining tags
        while(stripos($s,'<') > 0){
            $pos[1] = stripos($s,'<');
            $pos[2] = stripos($s,'>', $pos[1]);
            $len[1] = $pos[2] - $pos[1] + 1;
            $x = substr($s,$pos[1],$len[1]);
            $s = str_replace($x,'',$s);
        }
       
        /**///finalize keep tag
        for($i=0;$i<count($k);$i++){
         //   $s = str_replace('[{(' . $k[$i],'<' . $k[$i],$s);
         //   $s = str_replace('[{(/' . $k[$i],'</' . $k[$i],$s);
        }
        return trim($s);
    }	
	
	
	//function to remove <script> tags
	function ScriptRemover($arr) {
		$code = '/<script[^>]*?>.*?<\/script>/si';
   		$noscript = '';
		// $data array is passed using the form field name as the key
		// have to extract the value to make the function generic			 
		$key = array_keys($arr);
		foreach($key as $key){			 
			 
			 if(!is_array($arr[$key])) {		
					$arr[$key] = preg_replace($code, $noscript, $arr[$key]);
				}
				
			else
			{
			$key1 = array_keys($arr[$key]);
			foreach($key1 as $key1)
			{
			if(!is_array($arr[$key][$key1])) {		
					$arr[$key][$key1] = preg_replace($code, $noscript, $arr[$key][$key1]);
				}		
			}			
		}
	}
	return $arr;
	}	
        
        
        /* Function to get country list */
	
        
        
        function checkSortOrder($modelName,$sort){
            APP::import('Mode',$modelName);
            $this->$modelName = new $modelName;
            $countSort = $this->$modelName->find('first',array('conditions'=>array($modelName.'.sort_order'=>$sort)));
            if($countSort>0){
                return true;
            }else{
                return false;
            }
        }
        
        
        function getStatus($status){
            if($status == 1){
                return "Yes";
            }else{
                return "No";
            }
        }
        function getStatusRev($status){
            if($status == "Yes"){
                return 1;
            }else{
                return 0;
            }
        }
		
		
			/** Function to get show full  */
		function getShowLocation($locationId){
			APP::import('Model','Location');
			$this->Location = new Location();
			if($locationId) {
			  return $locationInfo=$this->Location->find('first',array('conditions'=>array('id="'.$locationId.'"')));
			}
		   	return false;			
		}
		
		
		/** Function to get state info by location id */
		function getLocationInfo($getinfo,$byinfo){
			APP::import('Model','Location');
			$this->Location = new Location();
			if($byinfo) {
			  return $this->Location->field($getinfo,array('id'=>$byinfo)); 
			}
		   	return false;			
		}
		
		
		//  ==================== Pushkar  =============
		function getStateList() 
		{
			APP::import('Model','State');
			$this->State = new State(); 
			$usaState1['USA']="=== USA === ";
			$usaState=$this->State->find('list',array('fields'=>array('state_abrev','state_name'),'conditions'=>'State.state_abrev!="00" and State.country="usa"','order'=>array('state_name')));
			$canadaState1['Canada']="=== Canada === ";
			$canadaState=$this->State->find('list',array('fields'=>array('state_abrev','state_name'),'conditions'=>'State.state_abrev!="00" and State.country="ca"','order'=>array('state_name')));
			
			return $statList=array_merge($usaState1,$usaState,$canadaState1,$canadaState);
			
		}
		
		function getAjaxStateList($countryId) 
		{
			APP::import('Model','State');
			$this->State = new State(); 
			$stateList1['']='Please select state';
			$stateList=$this->State->find('list',array('conditions'=>'State.country_id="'.$countryId.'"','fields'=>'state_abrev,state_name'));
			$stateList=array_merge($stateList1,$stateList);
			
			return $stateList;
		}
		
		function getStateName($state_id) 
		{
			APP::import('Model','State');
			$this->State = new State(); 
			if($state_id):
				$stateArray=$this->State->find('first',array('fields'=>array('state_name'),'conditions'=>array('state_abrev="'.$state_id.'"')));
				return $stateArray['State']['state_name'];
				
			endif;
				return false;
		}
		
    
		
		function getExperienceList() 
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'order'=>array('code_id'),
													'conditions'=>array('code_name'=>'Experience','visible'=>'Y','code_descr!="Experience"'),
													'order'=>'Code.sort_order asc'));
		}
		
		
		
		function getResumeSearchExperienceList()
		{
			APP::import('Model','Code');
			$this->Code = new Code();
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'order'=>array('code_id'),
													'conditions'=>array('code_name'=>'Experience','visible'=>'Y','code_descr !="Experience"','code_id !="3411"'),
													'order'=>array("sort_order ASC")));
		}
		
		function getExperienceValue($experienceCode)
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			if($experienceCode):
				$code_descr=$this->Code->find('first',array('fields'=>array('code_descr'),'conditions'=>array('code_name="Experience" and visible="Y"  and code_id="'.$experienceCode.'"')));
				return $code_descr['Code']['code_descr'];
			endif;
			
			return false;
			
		}
		
		
		function getCitizenShipList() 
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
	
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'order'=>array('code_id'),
											'conditions'=>array('code_name'=>'Citizen','visible'=>'Y','code_descr !="Citizen"'),
											'order'=>'code_descr ASC'));
		}
		
		function getCitizenShipValue($codeCitizenShip)
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			if($codeCitizenShip):
				$code_descr=$this->Code->find('first',array('fields'=>array('code_descr'),'conditions'=>array('code_name="Citizen" and code_id="'.$codeCitizenShip.'"')));
				return $code_descr['Code']['code_descr'];
			endif;
			
			return false;
			
		}
		#== Government security clearance 
		function getGovCleareanceList() 
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'order'=>array('code_id'),
																'conditions'=>array('code_name'=>'Security Clearance','visible'=>'Y','code_descr !="Security Clearance"'),
																'order'=>'sort_order DESC'));
		}
		
		function getSecurityClearanceValue($ClearanceCode)
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			if($ClearanceCode):
				$code_descr=$this->Code->find('first',array('fields'=>array('code_descr'),'conditions'=>array('code_name="Security Clearance" and  visible="Y" and code_id="'.$ClearanceCode.'"')));
				return $code_descr['Code']['code_descr'];
			endif;
			return false;
		}
		
		#==== Government security clearance 
		
		function getnoticeperiodList() 
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'order'=>array('code_id'),
													'conditions'=>array('code_name="Availability" and code_id!="89"')));
		}
		function getIndustriesList() 
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),
										'conditions'=>array('code_name'=>'Employer Type','visible'=>'Y','code_descr !="Employer Type"'),'order'=>array("code_descr ASC")));
		}
		/***** function for getting Industry name *****/
		function getIndustriesName($industryID) 
		{
		
			APP::import('Model','Code');
			$this->Code = new Code(); 
			if($industryID):
				$code_descr=$this->Code->find('first',array('fields'=>array('code_descr'),'conditions'=>array('code_name="Employer Type" and code_id="'.$industryID.'"')));
				
				return $code_descr['Code']['code_descr'];
			endif;
			
			return false;
		}
		#========================== work related code(Work Type , Work time) ======================
		function getWorkTypeCode($workCode)
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			if($workCode):
				$code_descr=$this->Code->find('first',array('fields'=>array('code_descr'),
															'conditions'=>array('code_name="Work Type" and  visible="Y" and code_id="'.$workCode.'" ')));
				return $code_descr['Code']['code_descr'];
			endif;
			
			return false;
		}
		// Get the list of /work type
		function getWorkTypeList()
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find("list",array('fields'=>array('code_id','code_descr'),'conditions'=>array('code_name'=>'Work Type',
																							'visible'=>'Y','code_descr !="Work Type" and  code_id!="3558"'),
																							'order'=>'code_descr ASC'));
		}
		
		
		
		// Get the value of work time code
		function getWorkTimeCode($workCode)
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			if($workCode):
				$code_descr=$this->Code->find('first',array('fields'=>array('code_descr'),
															'conditions'=>array('code_name="Work Time" and  visible="Y" and code_id="'.$workCode.'"')));
				
				return $code_descr['Code']['code_descr'];
			endif;
			
			return false;
		}
		// get list of work time
		function getWorkTimeList()
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find("list",array('fields'=>array('code_id','code_descr'),
													'conditions'=>array('code_name'=>'Work Time','visible'=>'Y','code_descr !="Work Time"'),
													'order'=>'code_descr ASC'));
		}
		// get the value of work locations
		function getWorkLocation($workCode)
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			if($workCode):
				$code_descr=$this->Code->find('first',array('fields'=>array('code_descr'),
														'conditions'=>array('code_name="Work Location" and  visible="Y" and code_id="'.$workCode.'"'),
														'order'=>'code_descr ASC'));
				
				return $code_descr['Code']['code_descr'];
			endif;
			
			return false;
		}
		// get the list of work locations
		function getWorkLocationList()
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find("list",array('fields'=>array('code_id','code_descr'),
													'conditions'=>array('code_name'=>'Work Location','visible'=>'Y','code_descr !="Work Location"'),'order'=>'code_descr ASC'));
		}
		// Get Salary Type 
		function getSalaryType($workCode)
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			if($workCode):
				$code_descr=$this->Code->find('first',array('fields'=>array('code_descr'),'conditions'=>array('code_name="Salary Type" and  visible="Y" and code_id="'.$workCode.'"')));
				
				return $code_descr['Code']['code_descr'];
			endif;
			
			return false;
		}
		// Get Salary Type List
		function getSalaryTypeList()
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find("list",array('fields'=>array('code_id','code_descr'),'conditions'=>array('code_name'=>'Salary Type','visible'=>'Y','code_descr !="Salary Type"'),'order'=>array("sort_order ASC")));
		}
		// Get importance value
		function getImportanceValue($importanceCode)
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			$code_descr = $this->Code->find('first',array('fields'=>array('code_descr'),'conditions'=>array('code_name="importance" and  visible="Y" and code_id="'.$importanceCode.'"')));
			return $code_descr['Code']['code_descr'];
		}
		// Get importance List
		function getImportanceList()
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find("list",array('fields'=>array('code_id','code_descr'),'conditions'=>array('code_name'=>'importance','visible'=>'Y','code_descr !="importance"'),'order'=>array("sort_order ASC")));
		}
		
		#==================  Get keyworkword/skills =========
		function getKeywordList() 
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			$skillsList=$this->Code->find('list',array('fields'=>array('code_id','Code.code_descr'),'order'=>'code_descr ASC','conditions'=>array('code_name'=>'Skills','visible'=>'Y','Code.code_descr!="Skills"')));
			
			return  array_filter($skillsList);
		
		}
		
		function getSkillName($skillcode)
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			if($skillcode):
				$code_descr=$this->Code->find('first',array('fields'=>array('code_descr'),'conditions'=>array('code_name="Skills" and  visible="Y" and code_id="'.$skillcode.'"')));
				return $code_descr['Code']['code_descr'];
			endif;
			
			return false;
		}
		
		
		#==================  end  =========
		
		
		function getLastUsedList() 
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'order'=>array('code_id'),'conditions'=>array('code_name'=>'Last Used','visible'=>'Y','code_descr !="Last Used"'),'order'=>array("sort_order ASC")));
		}
		
		
		function getlevelList() 
		{
			APP::import('Model','Code');
			$this->Code = new Code(); 
					
			return $this->Code->find('list',array('fields'=>array('code_id','code_descr'),'order'=>array('code_id'),'conditions'=>array('code_name'=>'skill level','visible'=>'Y','code_descr !="skill level"'),'order'=>array("sort_order ASC")));
		}
		
		function getShowList()  // get upcoming show list
		{
			APP::import('Model','Show');
			$this->Show = new Show(); 
			$this->Show->displayField = 'shownameLocationAdd';
			$this->Show->virtualFields['shownameLocationAdd'] = 'CONCAT(Show.show_dt," ",Show.show_name," - ",Location.location_city,", ",Location.location_state)';
		
			return $this->Show->find('list',array('joins' => array(
        array(
            'table' => 'locations',
            'alias' => 'Location',
            'type' => 'INNER',
            'conditions' => array(
                'Location.id = Show.location_id'
            )
        )
    ),'order'=>array('show_dt asc'),'conditions'=>array('show_dt >="'.date('Y-m-d',time()).'" and Show.published=1 ')));
		
		}
		// get show name
		function getShowName($showId = null)  // get upcoming show list
		{
			APP::import('Model','Show');
			$this->Show = new Show(); 
			$this->Show->id = $showId;		
			return $this->Show->field('show_name');
		}
		
		function getPreiousShowList()  // get previous show list
		{
			APP::import('Model','Show');
			$this->Show = new Show(); 
			return $this->Show->find('list',array('fields'=>array('id','show_name','show_name','show_dt'),'order'=>array('id'),
															'conditions'=>array('show_dt<="'.date('Y-m-d',time()).'"'),
															'order'=>'show_dt desc'
															));
		}
			
		
		
		function getLocationAddress($locationId) 
		{
			APP::import('Model','Location');
			$this->Location = new Location(); 
			$locationAddress=$this->Location->find('first',array('fields'=>array('site_address'),'conditions'=>array('id="'.$locationId.'"')));
			return $locationAddress['Location']['site_address'];
		}
		// Get the locations list from locations table
		function getLocationList() 
		{
			APP::import('Model','Location');
			$this->Location = new Location(); 
			return $this->Location->find("list", array("fields" => array("id", 'location_name'),"order"=> array('Location.location_state ASC')));
		}
		// Generate Resume set list
		function getResumeList() 
		{
			APP::import('Model','ResumeSetRule');
			$this->ResumeSetRule = new ResumeSetRule(); 
			return $this->ResumeSetRule->find("list", array("fields" => array("set_id", 'set_descr')));
		}
		//  =====================  End  ===============
		// function to get the total number of interview of an event for given employer
		function interviewCount($showID=null,$employerID=null) 
		{
			APP::import('Model','ShowInterview');
			$this->ShowInterview = new ShowInterview(); 
			return $this->ShowInterview->find("count", array("fields" => "DISTINCT candidate_id",'conditions'=>array('show_id'=>$showID,'employer_id'=>$employerID)));
		}
		
		function getprofileImage() 
		{
			APP::import('Model','Candidate');
			$this->Candidate = new Candidate(); 
			
			$this->Candidate->unBindModel(array('hasMany' => array('Resume')));
			return $candidateRec=$this->Candidate->find('first',array('fields'=>'Candidate.candidate_image,Candidate.profile_description',
																		'conditions'=>'Candidate.id="'.$this->Session->read('Auth.Client.User.candidate_id').'"'));
					
					
			// $candidateRec['Candidate']['candidate_image'];
		}
		
		function getemplogo() 
		{
			APP::import('Model','Employer');
			$this->Employer = new Employer(); 
			$this->Employer->id = $this->Session->read('Auth.Client.employerContact.employer_id');		
			return $this->Employer->field('logo_file');
		}
		
		function getemplogoDes() 
		{
			APP::import('Model','Employer');
			$this->Employer = new Employer(); 
			$this->Employer->id = $this->Session->read('Auth.Client.employerContact.employer_id');		
			return $this->Employer->field('logo_description');
		}
		
		function isTrylAccount($empId)
		{
			APP::import('Model','Employer');
			$this->Employer = new Employer();
			
		}
		
		
		function getJobSeekerMatchingJob() 
		{
				APP::import('Model','JobPosting');
				$this->JobPosting = new JobPosting();
				$candidateId=$this->Session->read('Auth.Client.User.candidate_id');
				$options['joins'] = array(
									array('table' => 'job_posting_skills',
											'alias' => 'JobPostingSkill',
											'type' => 'inner',
											'conditions' => array(
													'JobPosting.posting_id = JobPostingSkill.posting_id'
											)
									),
									array('table' => 'resume_skills',
											'alias' => 'ResumeSkill',
											'type' => 'inner',
											'conditions' => array(
													'JobPostingSkill.skill_id = ResumeSkill.skill_id'
											)
									),
									array('table' => 'resumes',
											'alias' => 'Resume',
											'type' => 'inner',
											'conditions' => array(
													'ResumeSkill.resume_id = Resume.id'
											)
									)
							);
							$skill_jobs_condition = "Resume.candidate_id=".$candidateId." AND JobPosting.start_dt > DATE(NOW() - INTERVAL 180 DAY) and JobPosting.active=1";
							
							$options['conditions'] = array($skill_jobs_condition);
							$options['limit']=10;
							$options['paramType']='querystring';
							$options['fields'] = array("distinct(JobPosting.posting_id),JobPosting.job_title,JobPosting.work_location_code,JobPosting.work_type_code,JobPosting.location_state,JobPosting.location_city,JobPosting.start_dt,Employer.employer_name,Employer.logo_file");
							//JobPosting.logo_file
							$options['order'] = array("JobPosting.start_dt DESC");
							$this->JobPosting->recursive = 0;
							
							return $jobLists=$this->JobPosting->find('all',$options);
							
													
		
		}
		// get candidate count according to security_clearance_code
		function candidateListClearance($clearanc_id = null,$show_id =null)
		{
			APP::import('Model','Registration');
			
			$this->Registration = new Registration(); 
			$conditions= 'FIND_IN_SET("'.$clearanc_id.'",Candidate.security_clearance_code) and Registration.show_id ='.$show_id;
			return $this->Registration->find("count", array('conditions'=>$conditions));
			
		}
			// get candidate count according to security_clearance_code
		function regularPreRegistration($candidate_id = null,$show_id =null)
		{
			APP::import('Model','ShowInterview');
			
			$this->ShowInterview = new ShowInterview(); 
			$conditions= 'ShowInterview.candidate_id='.$candidate_id.' and ShowInterview.show_id ='.$show_id;
			return $this->ShowInterview->find("first", array('conditions'=>$conditions,'fields'=>array('ShowInterview.candidate_id')));
			
			
		}
	// function to check whether employer is rgistered for an event or not
		function isEmployerRegisteredForEvent($showID=null, $employerID=null){
			APP::import('Model','ShowEmployer');
			$this->ShowEmployer = new ShowEmployer(); 
			 $condition  = "ShowEmployer.show_id = ".$showID." AND ShowEmployer.employer_id = ".$employerID." AND ShowEmployer.payment_status = 'y' ";
			return $this->ShowEmployer->find("count",array('conditions'=>array('ShowEmployer.show_id' =>$showID,'ShowEmployer.employer_id' =>$employerID,'ShowEmployer.payment_status' =>'y')));
		
		}
	
	//  for all upcoming event	
	function upcomingevent()
	{
			APP::import('Model','Show');
			$this->Show = new Show();		
			$targetdate = date('Y-m-d',mktime(0, 0, 0, date("m") , date("d"), date("Y")));
			// AND Show.boutique=r condition added 18 september 2013
			// boutique condition removed task id 3638
		//	$condition  = "Show.show_dt > '".$targetdate."' and Show.published=1 AND Show.boutique = 'r' ";
			$condition  = "Show.show_dt > '".$targetdate."' and Show.published=1  ";	
			$showList=$this->Show->find("all",array('joins' => array(
        array(
            'table' => 'shows_home',
            'alias' => 'ShowsHome',
            'type' => 'INNER',
			'conditions' => array(
                'ShowsHome.show_id = Show.id'
            )
        )
    ),'fields' => array('Show.*','Location.*','ShowsHome.display_name','ShowsHome.special_message'),'conditions'=> $condition,'limit' =>'6','order' => array('show_dt ASC')));
			return $showList;
	}
	
	
	function get_show_homedetails($id)
	{
			APP::import('Model','ShowsHome');
			$this->ShowsHome = new ShowsHome();		
			
			$showList=$this->ShowsHome->find('first',array('conditions'=>array('ShowsHome.show_id'=>$id)));
			
			
			return $showList;
	}
	
	
	
	
	
	
		
	// function to get username and password
		function usernamePassword($employerContactID=null){
			APP::import('Model','User');
			$this->User = new User(); 
			$this->User->recursive = -1;
			$userInfoArray = $this->User->find("first",array('fields'=>array('username','old_password'),'conditions'=>array('User.employer_contact_id' =>$employerContactID,'User.user_type' =>'E')));
			$userInfo[] = $userInfoArray['User']['username'];
			$userInfo[] = $userInfoArray['User']['old_password']; //converted here
			return $userInfo;		
		}
		
	// function to get Employer Name
		function getEmployerName($employerID=null){
			APP::import('Model','Employer');
			$this->Employer = new Employer(); 
			$employerInfo = $this->Employer->find("first",array('fields'=>array('employer_name'),'conditions'=>array('Employer.id' =>$employerID)));
			return $employerInfo['Employer']['employer_name'];		
		}
		
	// function to get Employer Contact name by employer id
		function getEmployerContactName($employerID=null){
			APP::import('Model','EmployerContact');
			$this->EmployerContact = new EmployerContact(); 
			$this->EmployerContact->recursive = -1;
			$employerInfo = $this->EmployerContact->find("first",array('fields'=>array('contact_name'),'conditions'=>array('EmployerContact.employer_id' =>$employerID)));
			return $employerInfo['EmployerContact']['contact_name'];		
		}
	
	// Get resume set count for an employer with respect to shows resume set
		function getResumeSetCount($resumeSetID=null,$employerID=null){
			APP::import('Model','EmployerSet');
			$this->EmployerSet = new EmployerSet(); 
			$employerInfo = $this->EmployerSet->find("count",array('conditions'=>array('EmployerSet.employer_id' =>$employerID,'EmployerSet.set_id'=>$resumeSetID)));
			return $employerInfo;	
		}
		
		function getSeekerAnnouncement(){  // get special announcement
			APP::import('Model','HomepageMessage');
			$this->HomepageMessage = new HomepageMessage(); 
			return $Rec = $this->HomepageMessage->find("first",array('conditions'=>array('type' =>'c')));
			 		
		}
	
	// function to get Resume set for assign to employer by year
		function getResumeSet($year=null){
			APP::import('Model','ResumeSetRule');
			$this->ResumeSetRule = new ResumeSetRule(); 
			$condition = "ResumeSetRule.set_descr like '".$year."%'";
			$resumesetList = $this->ResumeSetRule->find("all",array('fields'=>array('ResumeSetRule.set_id','ResumeSetRule.set_descr'),'conditions'=>$condition,'order'=>array('ResumeSetRule.set_descr')));
			return $resumesetList;		
		}
		
	// function to get Resume count for a resume setID 
		function getResumeSetResumeCount($setID=null){
			APP::import('Model','ResumeSet');
			$this->ResumeSet = new ResumeSet(); 
			$condition = "ResumeSet.set_id = ".$setID;
			$resumecount = $this->ResumeSet->find("count",array('conditions'=>$condition));
			return $resumecount;		
		}
	
	//function for get resume set descr value for set id
		function getResumeSetDescr($setID=null){
			APP::import('Model','ResumeSetRule');
			$this->ResumeSetRule = new ResumeSetRule(); 
			$condition = "ResumeSetRule.set_id = '".$setID."' ";
			$resumeset = $this->ResumeSetRule->find("first",array('fields'=>array('ResumeSetRule.set_descr'),'conditions'=>$condition));
			return $resumeset['ResumeSetRule']['set_descr'];		
		}
		
	// function for show name associate to resume set
		function getResumeSetShowName($setID=null){
			APP::import('Model','Show');
			$this->Show = new Show();			
			$condition = "Show.resume_set_id = '".$setID."'";
			$showList = $this->Show->find("list",array('fields'=>array('Show.id','Show.show_name'),'conditions'=>$condition,'order'=>array('Show.id DESC')));
			return $showList = implode("<br/>",$showList);
		}
		
	// function for get resume set for trail account
		function getResumeSetForTrailAccount(){
			APP::import('Model','ResumeSetRule');
			$this->ResumeSetRule = new ResumeSetRule(); 
			$currentyear = date("Y");
			$lastyear = $currentyear-1;			
			$condition = "ResumeSetRule.set_descr like '".$currentyear."%' OR ResumeSetRule.set_descr like '".$lastyear."%'";
			$resumesetList = $this->ResumeSetRule->find("list",array('fields'=>array('ResumeSetRule.set_id','ResumeSetRule.set_descr'),'conditions'=>$condition,'order'=>array('ResumeSetRule.set_descr')));
			return $resumesetList;		
		}
		
	// function for get annoucement of employer Dashboard
		function getEmployerAnnouncement(){
			APP::import('Model','HomepageMessage');
			$this->HomepageMessage = new HomepageMessage(); 
			$condition = "HomepageMessage.type = 'e'";
			$HomepageMessage = $this->HomepageMessage->find("first",array('conditions'=>$condition));
			return $HomepageMessage;		
		}
		
	// Function to check  number of posted job by an employer
		function GetPostedJobNumber($employerID=null){
			APP::import('Model','JobPosting');
			$this->JobPosting = new JobPosting(); 
			$condition = "JobPosting.employer_id	 = ".$employerID."";
			$count = $this->JobPosting->find("count",array('conditions'=>$condition));
			return $count;
		
		}
		
	// function to get job limit of an employer
		function GetEmployerJobLimit($employerID=null){
			APP::import('Model','Employer');
			$this->Employer = new Employer(); 
			$condition = "Employer.id	 = ".$employerID."";
			$joblimit = $this->Employer->find("first",array('fields'=>'Employer.max_jobs','conditions'=>$condition));
			if($joblimit['Employer']['max_jobs']!=''){
				return $joblimit['Employer']['max_jobs'];
			}else{
				return $joblimit = 0;
			}
		}
		
	// function to save employer last login history
		function saveEmployerLastVisit($employerID=null){
			APP::import('Model','EmployerLastVisit');
			$this->EmployerLastVisit = new EmployerLastVisit(); 
			$this->EmployerLastVisit->recursive = -1;
			$lastVisit = $this->EmployerLastVisit->find("first",array('fields'=>array('EmployerLastVisit.last_visit'),'conditions'=>array('EmployerLastVisit.employer_id'=>$employerID)));
			$lastvisitdate  = $lastVisit['EmployerLastVisit']['last_visit'];
			$newVisitDate = date("Y-m-d");

			if(isset($lastvisitdate) && ($lastvisitdate!=$newVisitDate)){
				// Update latest visit entry
				$EmployerLastVisitData = array('EmployerLastVisit'=>array('employer_id'=>$employerID,'last_visit'=>$newVisitDate));
				$this->EmployerLastVisit->save($EmployerLastVisitData, false, array('last_visit'));
			}elseif(!isset($lastvisitdate)){
				// insert visit info
				$EmployerLastVisitData = array('EmployerLastVisit'=>array('employer_id'=>$employerID,'last_visit'=>$newVisitDate));
				$this->EmployerLastVisit->save($EmployerLastVisitData);
			}	
		}
	
	// function for save employer site pages visit history 
		function saveEmployerPagesVisitHistory($employerID=null,$pagename=null,$remoteAddress=null,$referrar=null){
			APP::import('Model','EmployerStat');
			$this->EmployerStat = new EmployerStat(); 
			$stat_date = date("Y-m-d");
			$stat_time = date("Y-m-d H:i:s");
			
			// insert visit info
			$EmployerStatData = array('EmployerStat'=>array('employer_id'=>$employerID,'pagename'=>$pagename,'stat_date'=>$stat_date,'stat_time'=>$stat_time,'ip'=>$remoteAddress,'referrer'=>$referrar));
			$this->EmployerStat->save($EmployerStatData);
		}
		
	// function for showing employer site pages usage history 
		function showEmployerPagesVisitHistory($pagename=null,$start_dt=null,$end_dt=null){
			APP::import('Model','EmployerStat');
			$this->EmployerStat = new EmployerStat(); 
			$page_cond = '';
			if($pagename=='login'){
				$page_cond .= "AND pagename LIKE '/login%'";
			}elseif($pagename=='resumeSearchResult'){
				$page_cond .= "AND (pagename = '/resumeSearchResult' OR pagename = '/adv_resume_search.cfm')";
			}elseif($pagename=='searchRegResult'){
				$page_cond .= "AND (pagename = '/searchRegResult' OR pagename = '/emp_prereg_resume_search.cfm')";
			}elseif($pagename=='showResume'){
				$page_cond .= "AND (pagename = '/showResume' OR pagename = '/emp_display_resume2.cfm')";
			}elseif($pagename=='showRegisterResume'){
				$page_cond .= "AND (pagename = '/showRegisterResume' OR pagename = '/emp_display_resume_prereg.cfm')";
			}elseif($pagename=='exportResume'){
				$page_cond .= "AND (pagename = '/exportResume' OR pagename = '/emp_download.cfm')";
			}elseif($pagename=='mailResume'){
				$page_cond .= "AND (pagename = '/mailResume' OR pagename = '/emp_email_resume.cfm')";
			}elseif($pagename=='resumefiletofolder'){
				$page_cond .= "AND (pagename = '/resumefiletofolder' OR pagename = '/emp_res_quick_file_action.cfm')";
			}
			$condition = "EmployerStat.stat_date >= '".$start_dt."' AND EmployerStat.stat_date <= '".$end_dt."' ".$page_cond;

			// get employer history
			$options['joins'] = array(
				array('table' => 'employer_contacts',
					'alias' => 'EmployerContact',
					'type' => 'inner',
					'conditions' => array(
						"EmployerContact.employer_id = EmployerStat.employer_id"
					)
				)
			);
			
			$options['conditions'] = $condition;
			$options['fields'] = array('EmployerStat.employer_id, COUNT(EmployerStat.employer_id) as cnt, Employer.employer_name, EmployerContact.contact_name');
			$options['group'] = array('EmployerStat.employer_id, Employer.employer_name, EmployerContact.contact_name');
			$options['order'] = array('cnt DESC');
			$EmployerStatdata = $this->EmployerStat->find('all', $options);
			
			return $EmployerStatdata;
			
		}
		
		/****** Function to use save detailed traffic history ******/
		function saveDetailedTrafficHistory($pagename=null,$remoteAddress=null,$referrar=null){
			APP::import('Model','WebStat');
			$this->WebStat = new WebStat(); 
			$viewdate = date("Y-m-d");
			$viewtime = date("Y-m-d H:i:s");
			
			// insert visit info
			$WebStatData = array('WebStat'=>array('pagename'=>$pagename,'viewdate'=>$viewdate,'viewtime'=>$viewtime,'ip'=>$remoteAddress,'referrer'=>$referrar));
			$this->WebStat->save($WebStatData);
		}

		function checkJobSeekerEmail($emailId=null)
		{
			APP::import('Model','Candidate');
			$this->Candidate = new Candidate(); 
			$candidateRec = $this->Candidate->find("count",array('conditions'=>array('Candidate.candidate_email="'.$emailId.'"')));
			if(!$candidateRec)
			{
				return true;
			}
			return false;
		}
		
		function checkShowId($Id=null)
		{
		
			APP::import('Model','Show');
			$this->Show = new Show(); 
			$showRec = $this->Show->find("count",array('conditions'=>array('Show.id="'.$Id.'"')));
			if(!$showRec)
			{
				return true;
			}
			return false;
		}
		
		function checkPreRegisterUser($id=null)
		{
			APP::import('Model','User');
			$this->User = new User(); 
			
			$candidateRec = $this->User->find("count",array('conditions'=>array('User.candidate_id="'.$id.'" and User.status_code="PROFD"')));
			if($candidateRec)
			{
				return true;
			}
			return false;
		}
		
		function create_zip($files = array(),$destination ='',$overwrite = false) {
 
			  if(file_exists($destination) && !$overwrite) { return false; }
			
			  $valid_files = array();
			
			  if(is_array($files)) {
			  
				foreach($files as $file) {
			  
				  if(file_exists($file)) {
					$valid_files[] = $file;
				  }
				}
			  }
			 
			  if(count($valid_files)) {
			
				$zip = new ZipArchive();
				if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
				  return false;
				}
			
				foreach($valid_files as $file) {
				  $zip->addFile($file,$file);
				}
				
				$zip->close();
				
			  
				return file_exists($destination);
			  }
			  else
			  {
				return false;
			  }
			}
		
		/****** Function for show banner at frontend*******/	
		function showBanner(){
			APP::import('Model','Banner');
			$this->Banner = new Banner(); 
			
			$banenrs = $this->Banner->find('all',array('conditions'=>array('category_link NOT IN (4,5 )'),'order' => 'rand()'));
		
			return $banenrs;
		}
		
		/****** Function for add banner performance at frontend*******/	
		function addBannerPerformance($bannerID=null, $location=null){
			APP::import('Model','BannerPerformance');
			$this->BannerPerformance = new BannerPerformance(); 
			
			$banenrs = $this->BannerPerformance->find('first',array('conditions' => array('BannerPerformance.ad_id	'=>$bannerID,'BannerPerformance.ad_location'=>$location)));
			//pr($banenrs);
		
			if($banenrs['BannerPerformance']['id']==''){
				//insert data
				$data = array('BannerPerformance'=>array('ad_id'=>$bannerID,'loads'=>1,'clickthru'=>0,'ad_location'=>$location));
				$this->BannerPerformance->save($data);
			}else{
				//update data
				$this->BannerPerformance->updateAll(array('loads' => 'loads+1'), array('id' => $banenrs['BannerPerformance']['id']));
			}
			return false;
		}	
		
		/****** Function for add banner performance at frontend*******/	
		function adBanner($location=null){
			APP::import('Model','Banner');
			$this->Banner = new Banner();
			$banenrs = $this->Banner->find('first',array('conditions'=>array('Banner.category_link'=>'5','Banner.ad_position' => array('0',$location),'Banner.banner_status'=>'active'),'order' => 'rand()'));
			return $banenrs;
		}
		
		/****** Function for add banner performance at frontend*******/	
		function addBannerPerformanceOnClick($bannerID=null, $location=null){
			APP::import('Model','BannerPerformance');
			$this->BannerPerformance = new BannerPerformance(); 
			$banenrs = $this->BannerPerformance->find('first',array('conditions' => array('BannerPerformance.ad_id	'=>$bannerID,'BannerPerformance.ad_location'=>$location)));
			//update data
			$this->BannerPerformance->updateAll(array('clickthru' => 'clickthru+1'), array('id' => $banenrs['BannerPerformance']['id']));
			return false;
		}
		
		/****** Function for show banenr at home page *******/
		function getHomePageBanner(){
			APP::import('Model','Banner');
			$this->Banner = new Banner();
			$banenrs = $this->Banner->find('all',array('conditions' => array('Banner.category_link'=>'4','Banner.banner_status'=>'active')),array('order'=>'Banner.Order ASC'));
			return $banenrs;
		}
		
			/****** Function for Get Chat rooms*******/	
		function chatRoomList(){
			APP::import('Model','ChatRoom');
			$this->ChatRoom = new ChatRoom(); 
			
		$chatRoomLists = $this->ChatRoom->find('all',array('order' => 'room ASC','fields'=>array('ChatRoom.id','ChatRoom.room')));
			
			foreach($chatRoomLists as $chatRoomList) {
			$room_list[$chatRoomList['ChatRoom']['id']] = $chatRoomList['ChatRoom']['room'].'('.count($chatRoomList['ChatUser']).')';
		}
			
			return $room_list;
		}	
		
		/********* Function to get chat room name ************/
	function getRoomName($room_id) {
		APP::import('Model','ChatRoom');
			$this->ChatRoom = new ChatRoom(); 
		if($room_id) {
		  return $this->ChatRoom->field('room',array('id'=>$room_id)); 
		}
	   return false;	
	}
		
	function getbannerImage($bannerId) {
		APP::import('Model','OtherBanner');
			$this->OtherBanner = new OtherBanner(); 
		if($bannerId) {
		  return $this->OtherBanner->find('first',array('conditions' => array('OtherBanner.id'=>$bannerId))); 
		}
	   return false;	
	}	
	
	function isCandidateExits($idCandidate) 
	{
		APP::import('Model','Candidate');
		$this->Candidate = new Candidate(); 			
		$this->Candidate->unBindModel(array('hasMany' => array('Resume')));
		$candidateRec=$this->Candidate->find('count',array('conditions'=>'Candidate.id="'.$idCandidate.'"'));
		return $candidateRec;
	}
	
	function isCandidateRegForEvent($idCandidate,$showid) 
	{
		APP::import('Model','Registration');
		$this->Registration = new Registration();
		$candidateRec=$this->Registration->find('count',array('conditions'=>'Registration.candidate_id="'.$idCandidate.'" and Registration.show_id="'.$showid.'"'));
		return $candidateRec;
	}
		
	/****** function to check whether an employer is registered in an event or not *********/
	function checkRegisterEvent($eventID=null,$emplyerID=null){
		APP::import('Model','ShowEmployer');
		$this->ShowEmployer = new ShowEmployer();
		$registerEventCount = $this->ShowEmployer->find('count',array('conditions'=>'ShowEmployer.show_id="'.$eventID.'" and ShowEmployer.employer_id="'.$emplyerID.'"'));
		return $registerEventCount;
	}
	
	function totalJobWithSecurityClearances()
	{	
		APP::import('Model','JobPosting');
			$this->JobPosting = new JobPosting();
			$totalJobs=	$this->JobPosting->query("SELECT COUNT( posting_id ) AS jobcnt1
FROM job_postings
WHERE start_dt > DATE_SUB( CURRENT_DATE, INTERVAL 180
DAY ) 
AND active =1 and security_clearance_code !=''
		");
	  		$User = Set::flatten($totalJobs);
			return $User['0.0.jobcnt1'];
		
		
	}
	
	function candidateWithSecurityClearances()
	{	
			APP::import('Model','Candidate');
			$this->Candidate = new Candidate();
		
		
			$users_1=	$this->Candidate->query("select count(a.id) as candcnt2
				from candidates a, resumes b
				where a.security_clearance_code !='38'
				and a.security_clearance_code != '3683'
				and a.security_clearance_code != '3650'
				and a.security_clearance_code not like '%38%'
				and a.security_clearance_code not like '%3683%'
				and a.security_clearance_code not like '%3650%'
				and source_code=0
				and a.id=b.candidate_id");
	  		$users_1 = Set::flatten($users_1);
			
			
			$users_2=	$this->Candidate->query("select count(a.id) as candcnt3
				from candidates a, resumes b, shows c
				where c.sec_clearance_req ='y'
				and a.id=b.candidate_id
				and b.source_code=c.id");
	  		$users_2 = Set::flatten($users_2);
		
			
		
		return	$totalCandidate=	$users_1['0.0.candcnt2'] + $users_2['0.0.candcnt3'];			
	}
	
	function totalMembers()
	{	
			APP::import('Model','Candidate');
			$this->Candidate = new Candidate();
			$User=	$this->Candidate->query('SELECT COUNT( * )  as total_candidate
FROM  `candidates` 
WHERE 1');
	  		$User = Set::flatten($User);
			return $User['0.0.total_candidate'];		
	}
	function systemSetting()
	{	
			APP::import('Model','SystemVariable');
			$this->SystemVariable = new SystemVariable();
			return	$this->SystemVariable->find('list',array('fields'=>array('variable_name','variable_value')));		
	}
	// check block ip function
	function CheckBlockIp()
	{	
			APP::import('Model','IpBlock');
			$this->IpBlock = new IpBlock();
			
			$User=	$this->IpBlock->find('count',array('conditions'=>array('ip'=>CakeRequest::clientIp())));	
			
			if($User > 0)
			return true;
			else
			return false;		
			
	}
	
	//get list of photo categories
	function getAllPhotoCategory(){
		APP::import('Model','PhotoCategory');
		$this->PhotoCategory = new PhotoCategory();
		$categorylist = $this->PhotoCategory->find('list',array('fields'=>array('id','category_name'),'order'=>array('PhotoCategory.category_name ASC')));
		return $categorylist;
	}
	
	function getShowCandidate($show_id =null)
	{
		
		APP::import('Model','Registration');
		$this->Registration = new Registration(); 
		$records = $this->Registration->find("count", array('conditions'=>array('Registration.show_id'=>$show_id)));
		
		return $records;
		
	}
	function getShowEmployer($showID=null)
	{
			APP::import('Model','ShowEmployer');
			$this->ShowEmployer = new ShowEmployer(); 
			return $this->ShowEmployer->find("count",array('conditions'=>array('ShowEmployer.show_id' =>$showID)));
	}
	function countKeywords()
	{
		
		substr_count(strtoupper($haystack), strtoupper($needle));
	}
	
	
	function get_candidate_profileimage($user_id=null)
	{
			if($user_id){
			APP::import('Model','Candidate');
			$this->Candidate = new Candidate(); 
			
			
			APP::import('Model','User');
			$this->User = new User();
			
			$this->User->id=$user_id;
			$this->Candidate->id=$this->User->field('candidate_id');
			return $this->Candidate->field('candidate_image');
			
			}
	}
	
	function get_employeer_profileimage($user_id=null)
	{
		
		if($user_id){
			APP::import('Model','EmployerContact');
			$this->EmployerContact = new EmployerContact(); 
			
			
			APP::import('Model','User');
			$this->User = new User();
			
			$this->User->id=$user_id;
			$id=$this->User->field('employer_contact_id');
			
			
			$rec=$this->EmployerContact->findById($id);
			
			return $rec['Employer']['logo_file'];
			
			}
	}
	
	// jitendra on 06-08-2013 by reference of ticket #1407
	function getCandidateSecurityClearance($candidateId=null){
		APP::import('Model','Candidate');
		$this->Candidate = new Candidate();
		$this->Candidate->recursive = -1;
		$candidate = $this->Candidate->findById($candidateId);
		return $candidate['Candidate']['security_clearance_code'];
	}
function icalender($startdate = null,$enddate = null,$subject = null,$desc = null,$location=null,$ShowID){
//$startTime = '0000';
//$endTime   = '0000';
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
DTSTART:".$startdate."
DTEND:".$enddate."
SUMMARY:".$subject."
LOCATION:".$location."
DESCRIPTION;ENCODING=QUOTED-PRINTABLE:".$desc."
END:VEVENT
END:VCALENDAR";
 
//LOCATION:added by jitendra
//set correct content-type-header
header('Content-type: text/calendar; charset=utf-8');
//header('Content-Disposition: inline; filename=calendar.ics');
$file = time().'_'.$ShowID.'_calendar.ics';
$filename = WWW_ROOT."ShowsDocument/ics/".$file;

APP::import('Model','Show');
$this->Show = new Show();
$this->Show->id = $ShowID;
$this->Show->saveField('ics_file',$file);


file_put_contents($filename, $ical);
		
}

function icalenderOrg($showId)
	{
	
	
	APP::import('Model','Show');
		$this->Show = new Show();
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
	
	
	
date_default_timezone_set('GMT');
$enddateyear =  date('Y',strtotime($endtime));
$startdate = date('Ymd\THis', strtotime($starttime));
$enddate =  date('Ymd\THis', strtotime($endtime)) ;

$desc = str_replace("#", "\\n ", $show_detail);



//echo $desc;die;
header("Content-Type: text/x-vcard");
//header("Content-Disposition: inline; filename=filename.ics");
$ical = "BEGIN:VCALENDAR
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
UID:2E9AE1EF-E232-46A6-802C-EFD234007662
DTSTAMP:20131115T190956Z
LOCATION:$show_location2
DESCRIPTION:$desc
URL;VALUE=URI:TechExpoUSA.com
SEQUENCE:20
SUMMARY:$show_display_name
DTSTART;TZID=America/New_York:$startdate
CREATED:20131016T153208Z
BEGIN:VALARM
X-WR-ALARMUID:14C5F536-047B-481E-B01E-79C17154C8E4
UID:".md5($startdate)."
TRIGGER;VALUE=DATE-TIME:19760401T005545Z
X-APPLE-DEFAULT-ALARM:TRUE
X-APPLE-LOCAL-DEFAULT-ALARM:TRUE
ACTION:NONE
END:VALARM
END:VEVENT
END:VCALENDAR";


/*
$ical = "BEGIN:VCALENDAR\n
PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN\n
VERSION:2.0\n
METHOD:PUBLISH\n
X-MS-OLK-FORCEINSPECTOROPEN:TRUE\n
BEGIN:VEVENT\n
CLASS:PUBLIC\n
CREATED:20091109T101015Z\n
DESCRIPTION:$desc\n
DTEND:$enddate\n
DTSTAMP:20131007T093305Z\n
DTSTART:$startdate\n
LAST-MODIFIED:20131007T101015Z\n
LOCATION:$show_location2\n
PRIORITY:5\n
SEQUENCE:0\n
SUMMARY;LANGUAGE=en-us:$show_display_name\n
TRANSP:OPAQUE\n
UID:040000008200E00074C5B7101A82E008000000008062306C6261CA01000000000000000\n
X-MICROSOFT-CDO-BUSYSTATUS:BUSY\n
X-MICROSOFT-CDO-IMPORTANCE:1\n
X-MICROSOFT-DISALLOW-COUNTER:FALSE\n
X-MS-OLK-ALLOWEXTERNCHECK:TRUE\n
X-MS-OLK-AUTOFILLLOCATION:FALSE\n
X-MS-OLK-CONFTYPE:0\n
BEGIN:VALARM\n
TRIGGER:-PT1440M\n
ACTION:DISPLAY\n
DESCRIPTION:Reminder\n
END:VALARM\n
END:VEVENT\n
END:VCALENDAR\n";
*/
//echo $ical;

//header('Content-type: text/calendar; charset=utf-8');



$file = time().'_'.$showId.'_calendar.ics';
$filename = WWW_ROOT."ShowsDocument/ics/".$file;

APP::import('Model','Show');
$this->Show = new Show();
$this->Show->id = $showId;
$this->Show->saveField('ics_file',$file);


file_put_contents($filename, $ical); 


		return true;
	
	}
	function getShowHomeName($id)
	{
			APP::import('Model','ShowsHome');
			$this->ShowsHome = new ShowsHome();		
			$showList=$this->ShowsHome->find('first',array('conditions'=>array('ShowsHome.show_id'=>$id),'fields'=>array('display_name')));
			
			return $showList['ShowsHome']['display_name'];
	}
		
	function getFooterPartnar()
	{
			App::import('Model', 'Partner');
			$partner = new Partner();
			$partner->bindModel(array('belongsTo' => array('MarketingExhibitor')));
			return  $partner->find('all');
		
	}
	/*************************** Check and entry in resume_access_stat table  *************************/
	function resumeAccessStat($eid,$rid,$type = NULL)
	{
			App::import('Model', 'ResumeAccessStat');
			$ResumeAccessStat = new ResumeAccessStat();
			$ViewCnt= $ResumeAccessStat->find('count',array('conditions'=>array('ResumeAccessStat.employer_id'=>$eid,'ResumeAccessStat.resume_id'=>$rid)));	
			
			if($ViewCnt==0)
			{
				$data['ResumeAccessStat']['employer_id'] = $eid;	
				$data['ResumeAccessStat']['resume_id']   = $rid;
				$data['ResumeAccessStat']['dt']          = date('Y-m-d');	
				$data['ResumeAccessStat']['type']   	 = $type;
				$data['ResumeAccessStat']['ip'] 		 = $_SERVER['REMOTE_ADDR'] ;
				$ResumeAccessStat->save($data);
				
			}
	}
	/*************************** Check  resume_access_stat table  *************************/
	function resumeStatCheck($eid,$rid)
	{	
			App::import('Model', 'ResumeAccessStat');
			$ResumeAccessStat = new ResumeAccessStat();
			$ViewCnt= $ResumeAccessStat->find('first',array('conditions'=>array('ResumeAccessStat.employer_id'=>$eid,'ResumeAccessStat.resume_id'=>$rid),'fields'=>array('dt')));	
			return $ViewCnt['ResumeAccessStat']['dt'];
		
	}
	
	
	
		
}//Class end

?>