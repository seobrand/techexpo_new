<?php
App::uses('AppController', 'Controller');
/**

 * HomepageMessages Controller
 *
 * @property HomepageMessage $HomepageMessage
 */
 
class ExportResumesController extends AppController {
	var $helpers = array('Html','Javascript','Text','Paginator','Ajax'); //add some required helpers to this controller
    public $components = array('Auth','Session','Email','common');
    public $layout = "admin";
	var $uses = array('EmployerLastVisit','User','EmployerContact','EmployerSet','Employer','CustomEmployerSet','CustomEmployerSet','EmployerStat','JobPosting','Resume','Candidate','Folder','FolderContent','ResumeAccessStat','OfccpTracking','ShowEmployer','ShowCompanyProfile','ShowInterview','ClearanceKeyword','ResumeSet','Code','ResumeSkill');

/**
 * superadmin_index method
 *
 * @return void
 */
	public function superadmin_index($action = null) 
	{
		$this->set('keyword','');
		$this->set('selected','');
        $this->set('meta_title','Employer export resume');
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
		
		foreach ($this->params->query as $key => $value){
			$this->request->data[$key] = $value;
		}
		
		if($this->request->isGet() && isset($this->params->query['searchResume']))
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
				$set_id					= $this->params->query['set_id'];
				$date_search			= $this->params->query['date_search'];
				$time_units				= $this->params->query['time_units'];
				$adv_sec				= 0;
				
				if(isset($this->params->query['words'])){
					$words					=	$search_words;
					$type					=	$search_type;
					$candidate_state		=	$candidate_state;
					$citizen_status_code	=	$citizen_status_code;
					$experience_code		=	$experience_code;
					$set_id					=	$set_id;
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
				if(is_array($this->params->query['security_clearance_code2']) && count($this->params->query['security_clearance_code2'])>0){
					$security_clearance_code2	=	implode(",",$this->params->query['security_clearance_code2']);
				}else{
					$security_clearance_code2	=	"";
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
				
				/*if($search_type=="Advanced"){
					$words  = 	trim($words);
					$words	=	str_replace(" and ", " ", $words);
					$words	=	str_replace(" or ", " ", $words);
					$words	=	str_replace(" not ", " ", $words);
				}*/
				
				/*** Conditional formatting ***/
				if(isset($this->params->query['security_clearance_code'])){
					$sec_clr_code	=	trim($this->params->query['security_clearance_code']);
					if(strlen($sec_clr_code)>1){
						if($adv_sec=='0'){
							$security_clearance_code	=	'"'.$sec_clr_code.'"';
							$adv_sec = 0;
						}else{
							$adv_sec=='1';
						}
					}
				}
				
				/*** Security Clearance artificial intelligence : for each value in The security clearance pull-down, generate possible string matches ***/
				$security_clearance_code3	=	"";
				
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
								
								if(strlen($sec_clrs['ClearanceKeyword']['clearance_code_keywords1'])>1){
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
								
								if(strlen($sec_clrs['ClearanceKeyword']['clearance_code_keywords2'])>1){
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
				
				
				/**** Build query  -> NOT INDENTED SO SQL CODE IS EXACTLY THE SAME IN RESUME VIEW MODE ****/
				$conditions ="";
				$match_condition = "";
				/**** Serch result when Serach TYPE iS ANY *****/
				if($search_type=='Any'){
					$cnt	=	1;
					$match_condition .= '(';
					
					if(strlen($security_clearance_code3)>1){
						$match_condition .= $security_clearance_code3.")";
					}
					
					if(strlen($words)>1 && strlen($security_clearance_code3)>1){
						$match_condition .= ' +(';
					}
					
					if(strlen($words)>1){
						$word_array	=	explode(" ",trim($words));
						$match_words ="";
						foreach($word_array as $word){
							if((trim($word)!="AND") && (trim($word)!="OR") && (trim($word)!="C")){
								$match_words .= trim($word);
								if($cnt!=count($word_array)){
									$match_words .= " ";
								}
							}
							$cnt=$cnt+1;
						}
						$match_condition .= $match_words.")";
					}
					
					/*if(strlen($match_condition)==0 && strlen($conditions)==0){
						$conditions .= "1=1";
					}*/
					
					$stlist = 1;
					if(is_array($this->params->query['candidate_state'])){
						if($this->params->query['candidate_state'][0]!="ALL"){
							$conditions .= " AND (";
							foreach($this->params->query['candidate_state'] as $states){
								if($stlist==1){
									$conditions .= "(Candidate.candidate_state like '".$states."')";
								}else{
									$conditions .= " OR (Candidate.candidate_state like '".$states."')";
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
						$conditions .= " AND posted_dt>='".$res_date_search."'";
					}
					
					/* if($set_id!='All'){
						$conditions .= " AND ResumeSet.set_id=".$set_id."";
					} */
					if(is_array($set_id) && $set_id[0]!='All'){
						$resume_set_ids = implode(",", $set_id);
						$conditions .= " AND ResumeSet.set_id IN (".$resume_set_ids.")";
					}
										
				}
				
				/**** Serch result when Serach TYPE iS ANY *****/
				if($search_type=='All'){
					$cnt	=	1;
					$match_condition .= '(';
					
					if(strlen($security_clearance_code3)>1){
						$match_condition .= $security_clearance_code3.")";
					}
					
					if(strlen($words)>1 && strlen($security_clearance_code3)>1){
						$match_condition .= ' +(';
					}
					
					if(strlen($words)>1){
						$word_array	=	explode(" ",trim($words));
						$match_words = "";
						foreach($word_array as $word){
							if((trim($word)!="AND") && (trim($word)!="OR") && (trim($word)!="C")){
								$match_words .= "+".trim($word);
								if($cnt!=count($word_array)){
									$match_words .= " ";
								}
							}
							$cnt=$cnt+1;
						}
						$match_condition .= $match_words.")";
					}
					
					/*if(strlen($match_condition)==0 && strlen($conditions)==0){
						$conditions .= "1=1";
					}*/
					
					$stlist = 1;
					if(is_array($this->params->query['candidate_state'])){
						if($this->params->query['candidate_state'][0]!="ALL"){
							$conditions .= " AND (";
							foreach($this->params->query['candidate_state'] as $states){
								if($stlist==1){
									$conditions .= "(Candidate.candidate_state like '".$states."')";
								}else{
									$conditions .= " OR (Candidate.candidate_state like '".$states."')";
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
						$conditions .= " AND posted_dt>='".$res_date_search."'";
					}
					
					/* if($set_id!='All'){
						$conditions .= " AND ResumeSet.set_id=".$set_id."";
					} */
					if(is_array($set_id) && $set_id[0]!='All'){
						$resume_set_ids = implode(",", $set_id);
						$conditions .= " AND ResumeSet.set_id IN (".$resume_set_ids.")";
					}
					
				}
				
				/**** Serch result when Serach TYPE iS Exact Phrase *****/
				if($search_type=='Exact Phrase'){
					$cnt	=	1;
					$match_condition .= "(";
					
					if(strlen($security_clearance_code3)>1){
						$match_condition .= $security_clearance_code3.")";
					}
					
					if(strlen($words)>1 && strlen($security_clearance_code3)>1){
						$match_condition .= ' +(';
					}
						
					if(strlen($words)>1){
						//$match_condition .= "Resume.resume_content LIKE '%".trim($words)."%')";
						$words = str_replace("\"", "", trim($words));
						$match_condition .= "\"".trim($words)."\")";
					}
						
					$stlist = 1;
					if(is_array($this->params->query['candidate_state'])){
						if($this->params->query['candidate_state'][0]!="ALL"){
							$conditions .= " AND (";
							foreach($this->params->query['candidate_state'] as $states){
								if($stlist==1){
									$conditions .= "(Candidate.candidate_state like '".$states."')";
								}else{
									$conditions .= " OR (Candidate.candidate_state like '".$states."')";
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
						$conditions .= " AND posted_dt>='".$res_date_search."'";
					}
					
					/* if($set_id!='All'){
						$conditions .= " AND ResumeSet.set_id=".$set_id."";
					} */
					if(is_array($set_id) && $set_id[0]!='All'){
						$resume_set_ids = implode(",", $set_id);
						$conditions .= " AND ResumeSet.set_id IN (".$resume_set_ids.")";
					}											
						
				}
				
				/**** Serch result when Serach TYPE iS Exact Phrase *****/
				if($search_type=='Advanced'){
					$cnt	=	1;
					$match_condition .= "(";
					
					if(strlen($security_clearance_code3)>1){
						$match_condition .= $security_clearance_code3.")";
					}
					
					if(strlen($words)>1 && strlen($security_clearance_code3)>1){
						$match_condition .= ' +(';
					}
					
					if(strlen($words)>1){
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
												
						if(strlen($word)>1){
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
									$conditions .= "(Candidate.candidate_state like '".$states."')";
								}else{
									$conditions .= " OR (Candidate.candidate_state like '".$states."')";
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
						$conditions .= " AND posted_dt>='".$res_date_search."'";
					}
					
					/* if($set_id!='All'){
						$conditions .= " AND ResumeSet.set_id=".$set_id."";
					} */
					if(is_array($set_id) && $set_id[0]!='All'){
						$resume_set_ids = implode(",", $set_id);
						$conditions .= " AND ResumeSet.set_id IN (".$resume_set_ids.")";
					}
				}			
				
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
					//pr($resumeLists);
					$countTotalRecords = $this->Resume->find('count',array('fields'=>'distinct(Resume.id)','conditions'=>array('(Resume.id IN ('.$reslist.'))')));
					
				}else{
					$countTotalRecords = $resume_result;
					$resumeLists = array();
				}
				
				$this->set('resumeLists', $resumeLists);
				$this->set('countTotalRecords', $countTotalRecords);
				
				if($countTotalRecords < 1)
				{
					$this->Session->write('popup','Sorry, your search did not return any results.');
					$this->Session->setFlash('Sorry, your search did not return any results.');
				}

			}
			else
			{				
				$this->Session->write('popup','Please select database for search.');
				$this->Session->setFlash('Please select database for search.');  
				//$this->redirect(array('controller'=>'ExportResumes','action' => ""));
			}			
			$this->set('keyword',$search_words);
		}
		
		
	}
	
	
	function superadmin_ViewResume($resume_id = null) {
		
		if(!empty($resume_id)):
		
			$candidateRec=$this->Resume->find('first',array('conditions'=>'Resume.id="'.$resume_id.'"'));
			
		endif;
		$this->set('candidateRec',$candidateRec);
		
		
		}
		
		
	function superadmin_exportResume($id = null ) {
		
	
		$this->autoRender = false;
        $this->loadModel('Resume');
		$resume = $this->Resume->find('first',array('conditions'=>array('Resume.id'=>$id),'fields'=>array('Resume.resume_content')));
		
		$rtf=strip_tags($resume['Resume']['resume_content'],'<br>&nbsp;');  // creating rtf file
		file_put_contents('candidateDocument/resume/downloadreume_'.$resume['Resume']['id'].'.rtf', $rtf);
		header("Content-type: application/rtf");
		echo file_get_contents('candidateDocument/resume/downloadreume_'.$resume['Resume']['id'].'.rtf');
		exit();
	//	$this->set('yourname',$resume['Resume']['resume_content']);

	}	
	

	
	function superadmin_resumeDetail($resume_id = null ) {
		
		$this->autoRender = false;
        $this->loadModel('Resume');$this->loadModel('Candidate');
		$resume = $this->Resume->find('first',array('conditions'=>array('Resume.id'=>$resume_id),'fields'=>array('Candidate.candidate_name,Candidate.candidate_address')));
		ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
		
		//create a file
		$filename = "export_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');


	// The column headings of your .csv file
		$header_row = array("candidate_name","candidate_address");
		fputcsv($csv_file,$header_row,',','"');
	
	// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
	foreach($resume as $result)
	{ // Array indexes correspond to the field names in your db table(s)
		$row = array(
			
			$result['candidate_name'],
			$result['candidate_address']
			
		);
		
		fputcsv($csv_file,$row,',','"');die;
	}
	
	fclose($csv_file);


	}
	
	
	function superadmin_resumeDetailAll() {
		
		$this->autoRender = false;
        $this->loadModel('Resume');$this->loadModel('Candidate');
		$conditions = $this->Session->read('search_condition');
		
		$resume = $this->Resume->find('all',array('conditions'=>$conditions,'fields'=>array('Candidate.candidate_name,Candidate.candidate_address')));
		ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large
		
		//create a file
		$filename = "export_".date("Y.m.d").".csv";
		$csv_file = fopen('php://output', 'w');
		
		header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'"');


	// The column headings of your .csv file
		$header_row = array("candidate_name","candidate_address");
		fputcsv($csv_file,$header_row,',','"');
	
	// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
	foreach($resume as $result)
	{ // Array indexes correspond to the field names in your db table(s)
		$row = array(
			
			$result['Candidate']['candidate_name'],
			$result['Candidate']['candidate_address']
			
		);
		
		fputcsv($csv_file,$row,',','"');
	}
	
	fclose($csv_file);die;


	}
	
	// Export All resume content in a file 
	function superadmin_resumeExportAll()
	{ 	
		$this->autoRender = false;
		$this->loadModel('Resume');$this->loadModel('Candidate');
		$conditions = $this->Session->read('search_condition');
		
		$resumes = $this->Resume->find('all',array('conditions'=>$conditions,'fields'=>array('Resume.resume_content')));
		$rtf='';	
		foreach($resumes as $resume){	
		$rtf.=strip_tags($resume['Resume']['resume_content'],'<br/>&nbsp;');  // creating rtf file
		}
		//pr($rtf);die;
		file_put_contents('candidateDocument/resume/downloadreume_'.$resume['Resume']['id'].'.rtf', $rtf);
		header("Content-type: application/rtf");
		echo file_get_contents('candidateDocument/resume/downloadreume_'.$resume['Resume']['id'].'.rtf');
		exit();
		
	}
        
	function superadmin_emailResume() {
			
			if($this->request->isPost())
			{	
						$handler = opendir(WWW_ROOT.'ShowsDocument/export/');  // empty folder 
						foreach(glob(WWW_ROOT.'ShowsDocument/export/'.'*.*') as $v){
							unlink($v);
						}
						
						
						// creating rtf file
						$this->loadModel('Resume');$this->loadModel('Candidate');
						$conditions = $this->Session->read('search_condition');
						
						$resumes = $this->Resume->find('all',array('conditions'=>$conditions,'fields'=>array('Resume.resume_content')));
						$rtf='';	
						foreach($resumes as $resume){	
						$rtf.=strip_tags($resume['Resume']['resume_content'],'<br/>&nbsp;');  // creating rtf file
						}
						file_put_contents('ShowsDocument/export/resume_export.rtf', $rtf);
									
			
						$sendto = $this->request->data['ExportResumes']['email'];
						$sendfrom = 'info@techexpo.com';
						$emailMessage = $this->request->data['ExportResumes']['message'];
						
						$subject = $this->request->data['ExportResumes']['subject'];
						$bodyText = "This Resume was forwarded to you by someone you know. It was posted on TechExpoUSA.com, the career center of choice for all technology professionals. To view the details of this Resume, go to<br/>techexpoUSA.com<br/><br/>*************************************************************************************<br/>".$emailMessage."<br/><br/> Thank You <br> Tech Expo Team ";
						
						// email attachment
						$email = new CakeEmail();
						$attachfilePath = WWW_ROOT."candidateDocument/resumeSend/resume_export.rtf";
						if(file_exists($attachfilePath)){
										$email->attachments(array($attachfilePath));
						}
						
						$email->from(array($sendfrom));
						$email->to($sendto);
						$email->emailFormat('html');
						$email->subject(strip_tags($subject));
						
						$ok = $email->send($bodyText);
						
						if($ok){
							$this->Session->write('popup','Mail has been sent successfully.');
							$this->Session->setFlash('Mail has been sent successfully.');  
							$this->redirect(array('controller'=>'ExportResumes','action' => "emailResume"));
						}		
			
			}
		
		
		}
		
	function superadmin_info() {
			
			$this->layout ='';
			
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
		$this->Auth->loginRedirect = array('controller' => 'ExportResumes', 'action' => '','superadmin'=>true);
		$this->Auth->userScope = array('Adminuser.active' => 'yes');		
   	}
	
	function beforeRender(){
	    parent::beforeRender();
		 //set css name and current admin array
		$this->set('currentAdmin', $this->Auth->user());
	} 
	
}